<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_controller extends CH_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model(array('products_model','listini_model','magazzino_model','headquarters_model'));
      $this->load->helper('ch_common');
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
      $bb[] = array('label' => "Gestione magazzini", 'url' => base_url(CH_URL_PRODUCTS));
      $this->init_breadcrumb($bb);
      $this->add_frontend_module('my_products');
      $this->add_frontend_css('my_products');
      load_dto('listini_dto');
      load_dto('brands_dto');
   }

   public function index() {
      $this->load_page('products/products_main_view');
   }
   
   public function show_articoli_view(){
      $this->load->model('brands_model');
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
//      $bb[] = array('label' => "articoli", 'url' => base_url(CH_URL_PRODUCTS));
      $bb[] = array('label' => "Visualizza articoli", 'url' => "");
      $this->init_breadcrumb($bb);
      $brands = $this->brands_model->get_brands_list();
      $data = array(
          'brands' => $brands
      );
      $this->load_page('products/show_articoli_view', $data);
   }
   
   public function show_details_article($id_listino){
      $dati = $this->listini_model->get_listino($id_listino);
      $this->load_page('products/article_details_view', $dati);
   }
   
   private function normalize_sede_list($lista){
      $return = array();
      foreach ($lista as $k => $sede){
         $return[$sede->stock_code] = $sede;
      }
      return $return;
   }
   
   public function stampa($id_listino){
      require_once APPPATH.'classes/modulistica/modulistica_factory.php';
      require_once APPPATH.'classes/modulistica/renderers/modulistica_pdf_renderer.php';
      $dati = $this->listini_model->get_listino($id_listino);
      $resources = array('dati' => $dati);
      $modulo = Modulistica_Factory::get_instance('riassunto_listino', new Modulistica_Resources($resources));
      $elenco_modulistica[] = $modulo->create_descriptor();
      $renderer = new Modulistica_pdf_renderer();
      $pdf_fullname = sys_get_temp_dir(). "/stampa_".time().".pdf";
      $renderer->render_to_browser(Modulistica_descriptor_iterator::merge($elenco_modulistica), $pdf_fullname, array( 'left_margin'=>'15', 'right_margin'=>'15', 'top_margin'=>'10', 'bottom_margin'=>'7','format' => 'A4-L' ));
   }
   
   public function nuovo_magazzino_show(){
      $lista_utenti = $this->bitauth->get_standard_users();
      $lista_sedi = $this->headquarters_model->get_list();
      $dati = array('lista_utenti' => $lista_utenti, 'lista_sedi' => $lista_sedi);
      $this->load->view('products/windows/nuovo_magazzino_window', $dati);
   }
   
   public function salva_magazzino(){
      $dto = Magazzino_DTO::raccogli_dati_request('magazzino');
      $result = $this->magazzino_model->save($dto);
      json_output($result !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function gestione_ubicazioni(){
      $bb[] = array('label' => "Gestione ubicazioni", 'url' => base_url(CH_URL_PRODUCTS));
      $this->set_breadcrumb($bb);
      $elenco_magazzini = $this->magazzino_model->get_list(TRUE);
      $tipi_ubicazioni = $this->magazzino_model->get_tipologia_ubicazione();
      $data = array('elenco_magazzini' => $elenco_magazzini, 'tipi_ubicazione' => $tipi_ubicazioni);
      $this->load_page('products/gestione_ubicazioni', $data);
   }
   
   public function get_lista_ubicazioni($id_magazzino){
      $lista = $this->magazzino_model->get_lista_ubicazioni($id_magazzino);
      json_output($lista);
   }
   
   public function salva_ubicazione(){
      $ub = Magazzino_ubicazione_DTO::raccogli_dati_request('ubicazione');
      $result = $this->magazzino_model->salva_ubicazione($ub);
      json_output($result !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function cancella_ubicazione($id_ubicazione){
      $result = $this->magazzino_model->cancella_ubicazione($id_ubicazione);
      json_output($result !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function load_gestione_magazzino_zero(){
      $bb[] = array('label' => "Gestione magazzino 0", 'url' => "");
      $this->set_breadcrumb($bb);
      $this->load_page("products/gestione_magazzino_zero");
   }
   
   public function gestione_magazzino(){
      $bb[] = array('label' => "Gestione magazzino 0", 'url' => base_url(CH_URL_PRODUCTS."/load_gestione_magazzino_zero"));
      $bb[] = array('label' => "Consulta magazzino", 'url' => "");
      $this->set_breadcrumb($bb);
      $this->load_page("products/azioni_magazzino");
   }
   
   public function get_prodotti_magazzino_zero_table_feed() {
      $output = $this->magazzino_model->get_prodotti_magazzino_zero_table_feed();
      json_output($output);
   }
   
   public function crea_nuovo_movimento_show(){
      $this->load->model('headquarters_model');
      $lista_sedi = $this->headquarters_model->get_list();
      $data = array("lista_sedi" => $lista_sedi);
      $this->load->view('products/windows/nuovo_movimento_window', $data);
   }
   
   public function get_lista_magazzini_by_sede_ajax($id_sede){
      json_output($this->get_lista_magazzini_by_sede($id_sede));
   }
   
   public function get_lista_magazzini_by_sede($id_sede){
      return $this->magazzino_model->get_list_magazzini_by_sede($id_sede);
   }
   
   public function crea_nuovo_movimento(){
      $this->load->model(array('counters_model'));
      $id_magazzino = $this->input->post('id_magazzino');
      $movimento = new Movimenti_magazzino_DTO();
      $movimento->id_magazzino = $id_magazzino;
      $movimento->id_operatore = $this->bitauth->user_id;
      $movimento->tipo_movimento = $this->input->post('tipo_movimento');
      $movimento->stato_movimento = Movimenti_magazzino_DTO::STATO_BOZZA;
      $movimento->movimento_codice = $this->counters_model->get_new_counter_move();
      $id_movimento = $this->magazzino_model->salva_movimento($movimento);
      $output = array();
      $output['response'] = $id_movimento != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE;
      $output['id_movimento'] = $id_movimento;
      json_output($output);
   }
   
   public function compila_dettagli_movimento($id_movimento){
      $bb[] = array('label' => "Lista movimenti", 'url' => base_url(CH_URL_PRODUCTS."/mostra_movimenti_list"));
      $bb[] = array('label' => "Dettaglio movimento", 'url' => "");
      $this->set_breadcrumb($bb);
      $movimento = $this->magazzino_model->get_movimento($id_movimento);
      $magazzino = $this->magazzino_model->get_info_magazzino($movimento->id_magazzino);
      $numero_movimento = $movimento->movimento_codice;
      $dati = array('id_movimento' => $id_movimento, 'numero_movimento' => $numero_movimento, 'magazzino' => $magazzino, 'stato_movimento' => $movimento->stato_movimento);
      $this->load_page('products/compila_dettagli_movimento_page', $dati);
   }
   
   public function autocomplete_articoli(){
      $filtro = $this->input->get('term');
      $return = $this->magazzino_model->autocomplete_articoli($filtro);
      json_output($return);
   }
   
   public function mostra_movimenti_list(){
      $bb[] = array('label' => "Lista movimenti", 'url' => "");
      $this->set_breadcrumb($bb);
      $this->load_page('products/movimenti_list');
   }
   
   public function get_movimenti_table_feed(){
      $output = $this->magazzino_model->get_movimenti_table_feed();
      json_output($output);
   }
   
   public function get_list_movements_details(){
      $id_movimento = $this->input->post('id_movimento');
      json_output($this->magazzino_model->get_list_movements_details($id_movimento));
   }
   
   public function save_movement_detail(){
      $movimento = Movimenti_magazzino_dettagli_DTO::raccogli_dati_request('dettaglio');
      $result = $this->magazzino_model->save_movement_detail($movimento);
      json_output($result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function importa_listino_da_gesat_show(){
      $this->load->helper('form_helper');
      $this->load->view('products/windows/import_from_gesat_window');
   }
   
   public function load_listino_from_gesat(){
      $path = sys_get_temp_dir();
      $config_uploader['upload_path'] = $path;
      $config_uploader['allowed_types'] = 'txt';
      $config_uploader['max_size'] = 102400;
      $config_uploader['encrypt_name'] = TRUE;
      $this->load->library('upload', $config_uploader);
      $this->upload->initialize($config_uploader);
      $res = TRUE;
      if ( ! $this->upload->do_upload('attachment')) {
         $res = array('result' => CH_RESPONSE_FAILURE, 'message' => $this->upload->display_errors());
		} else {
         $u_data = $this->upload->data();
         $realFileName = $u_data['file_name'];
         $working_file = $path."/$realFileName";
         $sanitaze_file = fopen($path."/sanitazed.txt", "w");
         $fh = fopen($working_file, 'r');
         while ($line = fgets($fh)) {
            if(
                    strpos($line, "&&&&&&&&&") === FALSE &&
                    strpos($line, "RUSSO FERDINANDO ASSISTENZA TE") === FALSE && 
                    strpos($line, "STAMPA LISTINO ARTICOLI") === FALSE && 
                    strpos($line, "=====================") === FALSE && 
                    strpos($line, "|Codice") === FALSE && 
                    str_replace (array("\r\n", "\n", "\r"), '', $line) !== "" 
                    && strpos($line, "--------------------------------") === FALSE
                    ){
               fwrite($sanitaze_file, $line);
            }
         }
         fclose($sanitaze_file);
         fclose($fh);
         $snt = fopen($path."/sanitazed.txt", 'r');
         while ($riga_prodotto = fgets($snt)){
            $listino = new Listini_DTO();
            $tmp = explode('|', $riga_prodotto);
            $b_c = explode(" ",$tmp[1]);
            $listino->brand_code = $b_c[0];
            $listino->codice = $b_c[1];
            $listino->modello = $tmp[2];
            $listino->descrizione = $tmp[3];
            $listino->prezzo_acquisto = $tmp[5];
            $listino->prezzo_rifatturazione = $tmp[6];
            $listino->prezzo_rivenditore = $tmp[8];
            $listino->prezzo_pubblico_1 = $tmp[9];
            $res &= $this->listini_model->save_by_code($listino);
         }
         fclose($snt);
      }
      json_output($res != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function chiudi_movimento_di_magazzino(){
      $id_movimento = $this->input->post('id_movimento');
      $result = $this->magazzino_model->chiudi_movimento_magazzino($id_movimento);
      $return = array('result' => CH_RESPONSE_SUCCESS, 'id_movimento' => $id_movimento);
      json_output($return);
   }
   
   public function allow_save_movement(){
      $id_movimento = $this->input->post('id_movimento');
      $id_articolo = $this->input->post('id_listino');
      $result = $this->magazzino_model->allow_save_movement($id_movimento, $id_articolo);
      json_output($result === FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }

}
