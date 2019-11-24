<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'dto/brands_dto.php';
require_once APPPATH.'dto/listini_dto.php';

class File_import_controller extends CH_Controller {
   
   public function __construct() {
      parent::__construct();
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
      $bb[] = array('label' => "Import File", 'url' => "");
      $this->init_breadcrumb($bb);
      $this->add_frontend_module('my_file_import');
      $this->load->model(array('brands_model','listini_model'));
   }


   public function main_import_file(){
      $this->load_page('file_import/main_file_import');
   }
   
   public function show_widget_file_import($brand_code, $filename){
      $this->load->helper('form_helper');
      $brand = $this->brands_model->get_brand_by_code($brand_code);
      $data = array('brand' => $brand,'filename' => $filename);
      $this->load->view('file_import/windows/widget_file_import', $data);
   }
   
   public function load_file() {
      $file_type = $this->input->post('file_type');
      $brand_code = $this->input->post('brand_code');
      $filename_upload = $this->get_filename_upload($file_type, $brand_code);
      if ($filename_upload === FALSE) {
         $data = array('response' => CH_RESPONSE_FAILURE, 'message' => 'Nessuna funzione è stata implementata per il caricamento di questo file!');
         json_output($data);
         return;
      }
      $path = sys_get_temp_dir();
      $config_uploader['upload_path'] = $path;
      $config_uploader['allowed_types'] = 'txt';
      $config_uploader['max_size'] = 10240;
      $config_uploader['encrypt_name'] = TRUE;
      $this->load->library('upload', $config_uploader);
      $this->upload->initialize($config_uploader);
      if (!$this->upload->do_upload('attachment')) {
         json_output(array('result' => CH_RESPONSE_FAILURE, 'message' => $this->upload->display_errors()));
         return;
      } else {
         $u_data = $this->upload->data();
         if ($u_data['orig_name'] != $filename_upload) {
            $data = array('response' => CH_RESPONSE_FAILURE, 'message' => 'Attenzione si sta tentando di caricare il file con nome errato!');
            json_output($data);
            return;
         }
         $realFileName = $u_data['file_name'];
         $working_file = $path . "/$realFileName";
         $fh = fopen($working_file, 'r');
         if ($file_type === 'fl4') {
            $res = $this->charge_file_4($fh);
         } elseif($file_type === 'fl7'){
            $res = $this->charge_file_7($fh);
         } elseif($file_type === 'fl10'){
            $res = $this->charge_file_10($fh);
         } elseif($file_type === 'impro'){
            $res = $this->charge_file_impro($fh);
         } elseif($file_type === 'imdif'){
            $res = $this->charge_file_imdif($fh);
         } elseif($file_type === 'imric'){
            $res = $this->charge_file_imric($fh);
         } elseif($file_type === 'imtype'){
            $res = $this->charge_file_imtype($fh);
         } elseif($file_type === 'imdtpr'){
            $res = $this->charge_file_imdpr($fh);
         } elseif($file_type === 'fl6'){
            $res = $this->charge_file_6($fh);
         } 
      }
      fclose($fh);
      unlink($working_file);
      if ($res != FALSE) {
         $response = array(
             'response' => CH_RESPONSE_SUCCESS,
             'message' => "Importazione avvenuta correttamente"
         );
      } else {
         $response = array(
             'response' => CH_RESPONSE_FAILURE,
             'message' => "Errore di importazione, il file che si sta tentando di importare potrebbe essere corrotto!"
         );
      }
      json_output($response);
   }

   private function charge_file_4($file) {
      $res = TRUE;
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $modello = trim(substr($line, 0, 22));
            $gruppo_merce = trim(substr($line, 22, 8));
            $marchio = trim(substr($line, 31, 24));
            $dto = new Modello_gruppomerce_marchio_DTO();
            $dto->modello = trim($modello);
            $dto->gruppo_merce = trim($gruppo_merce);
            $dto->marchio = trim($marchio);
            $res &= is_numeric($this->listini_model->save_modello_gruppo_marchio($dto));
         }
      }
      return $res;
   }
   
   private function charge_file_7($file){
      $res = TRUE;
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Modello_tariffe_manodopera_DTO();
            $dto->modello = trim(substr($line, 0, 20));
            $dto->descrizione = trim(substr($line, 20, 40));
            $dto->descrizione_gruppo_merce = trim(substr($line, 60, 30));
            $dto->codice_fittizio = trim(substr($line, 90, 20));
            $dto->tariffa = trim(substr(str_replace(',','.',$line), 110, 10));
            $dto->marchio_corto = trim(substr($line, 120, 5));
            $dto->abbreviazione_marchio = trim(substr($line, 125, 2));
            $res &= is_numeric($this->listini_model->save_modello_tariffe_manodopera($dto));
         }
      }
      return $res;
   }
   
   private function charge_file_10($file){
      $res = TRUE;
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Gruppomerce_codice_difetto_DTO();
            $dto->gruppomerce = trim(substr($line, 0, 9));
            $dto->codice_difetto = trim(substr($line, 9, 5));
            $dto->descrizione_difetto = trim(substr($line, 14, 50));
            $res &= is_numeric($this->listini_model->save_gruppomerce($dto));
         }
      }
      return $res;
   }
   
   private function charge_file_impro($file){
      $res = TRUE;
      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Listini_DTO();
            $dto->brand_code = trim(substr($line, 0, 2));
            $dto->codice = trim(substr($line, 2, 13));
            $dto->modello = $dto->codice;
            $dto->descrizione = trim(substr($line, 15, 45));
            $prezzo_pubblico_tmp = trim(substr($line, 66, 7));
            $dto->prezzo_pubblico_1 = $this->get_price($prezzo_pubblico_tmp);
            $prezzo_rivenditore_tmp = trim(substr($line, 73, 7));
            $dto->prezzo_rivenditore = $this->get_price($prezzo_rivenditore_tmp);
            $dto->prezzo_rifatturazione = $this->get_price(trim(substr($line, 101, 7)));
            $dto->aliquota_iva = trim(substr($line, 126, 2));
            $dto->prodotto_finito_ricambio = trim(substr($line, 128, 1));
            $dto->riparabile_sostituibile = trim(substr($line, 129, 1));
            $dto->ordinabile = trim(substr($line, 130, 1));
            $dto->prodotto_critico = trim(substr($line, 161, 1));
            $result = $this->listini_model->save_by_code($dto, TRUE);
            $res &= (is_numeric($result) || $result != FALSE);
            $dto_extra = new Listini_dati_extra_imetec_DTO();
            $dto_extra->id_listino = $result;
            $dto_extra->codice_prodotto_sostitutivo = trim(substr($line, 47, 13));
            $dto_extra->quantita_confezionamento = trim(substr($line, 60, 3));
            $dto_extra->prezzo_vendita_consigliato = $this->get_price(trim(substr($line, 66, 7)));
            $dto_extra->prezzo_acquisto_a_catalogo = $this->get_price(trim(substr($line, 94, 7)));
            $dto_extra->prezzo_imposto_1 = $this->get_price(trim(substr($line, 80, 7)));
            $dto_extra->prezzo_imposto_2 = $this->get_price(trim(substr($line, 87, 7)));
            $dto_extra->tariffa_oraria_manodopera_garanzia = $this->get_price(trim(substr($line, 108, 7)));
            $dto_extra->data_validita = normal_to_db_date(trim(substr($line, 118, 8)));
            $dto_extra->descrizione_aggiuntiva = trim(substr($line, 131, 30));
            $dto_extra->data_produzione_di_riferimento = trim(substr($line, 162, 4));
            $dto_extra->note_prodotti_critici_1 = trim(substr($line, 166, 60));
            $dto_extra->note_prodotti_critici_2 = trim(substr($line, 247, 60));
            $dto_extra->gruppo_merce = trim(substr($line, 226, 6));
            $dto_extra->codice_raee = trim(substr($line, 240, 7));
            $dto_extra->data_prevista_arrivo = db_to_normal_date(trim(substr($line, 232, 8)));
            $this->listini_model->save_data_extra_imetec_from_file($dto_extra);
         }
      }
      $this->db->trans_complete();
      return $this->db->trans_status();
   }
   
   private function charge_file_imric($file) {
      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $distinta = new Imetec_distinta_base_primo_livello_DTO();
            $distinta->brand_code = trim(substr($line, 0, 2));
            $distinta->codice_articolo_ricambio = trim(substr($line, 17, 13));
            $distinta->codice_esploso = trim(substr($line, 42, 20));
            $distinta->codice_prodotto = trim(substr($line, 2, 13));
            $distinta->data_inizio_validita = normal_to_db_date(trim(substr($line, 34, 8)));
            $distinta->posizione_esploso = trim(substr($line, 30, 4));
            $this->listini_model->save_imetec_distinta_base_primo_livello($distinta);
         }
      }
      $this->db->trans_complete();
      return $this->db->trans_status();
   }

   private function charge_file_imdif($file) {
      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Imetec_difetti_DTO();
            $dto->codice_difetto = trim(substr($line, 0, 3));
            $dto->descrizione_difetto = trim(substr($line, 3, 60));
            $dto->gruppo_merce = trim(substr($line, 63, 6));
            $dto->abilitazione_ricambi = trim(substr($line, 69, 1));
            $dto->tariffa_manodopera_garanzia = $this->get_price(trim(substr($line, 70, 7)));
            $this->listini_model->save_imetec_difetto($dto);
         }
      }
      $this->db->trans_complete();
      return $this->db->trans_status();
   }
   
   private function charge_file_imtype($file){
      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Imetec_codici_tipo_DTO();
            $dto->codice_tipo = trim(substr($line, 0, 20));
            $dto->brand_code = trim(substr($line, 20, 2));
            $dto->codice_prodotto = trim(substr($line, 22, 20));
            $dto->descrizione_tipo = trim(substr($line, 42, 60));
            $exists = $this->listini_model->get_imetec_codice_tipo($dto->codice_prodotto);
            if($exists === FALSE){
               $this->listini_model->save_imetec_codice_tipo($dto);
            }
         }
      }
      $this->db->trans_complete();
      return $this->db->trans_status();
   }
   
   private function charge_file_imdpr($file){
      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $dto = new Imetec_imdtpr_load_file_temp_DTO();
            $dto->codice_prodotto = trim(substr($line, 0, 13));
            $dto->data_produzione = trim(substr($line, 13, 4));
            $this->listini_model->save_imetec_imdtpr_temp($dto);
         }
      }
      $list = $this->listini_model->get_list_imdtpr_temp();
      foreach ($list as $k => $row){
         $row->id = null;
         $dto = new Imetec_date_produzione_valide_DTO($row);
         $this->listini_model->save_imetec_date_produzione_by_codice_e_data($dto);
      }
      $this->listini_model->truncate_imetec_imdtpr_temp();
      $this->db->trans_complete();
      return $this->db->trans_status();
   }

   private function charge_file_6($file){
//      $c = 1;
//      $this->db->trans_start();
      while ($line = fgets($file)) {
         if ($line != '' && $line != null) {
            $tmp = explode(";", $line);
            $dto = new Listini_DTO();
            $dto->codice = trim($tmp[0]);
            $dto->modello = trim($tmp[0]);
            $dto->descrizione = trim($tmp[2]);
            $dto->prezzo_acquisto = trim($tmp[3]);
            $dto->brand_code = Brands_DTO::BRAND_DELONGHI;
            $dto->prodotto_finito_ricambio = Listini_DTO::PRODOTTO_RICAMBIO;
            $this->listini_model->save_by_code($dto);
//            $c++;
         }
      }
      
//      if($this->db->trans_status() == FALSE)
//			{
//				$this->db->trans_rollback();
//				return FALSE;
//			}
//
//			$this->db->trans_commit();
			return TRUE;
   }

   private function get_filename_upload($file_type, $brand_code){
      if($file_type === 'fl4'){
         return "file4.txt";
      } elseif($file_type === 'fl7'){
         return "file7.txt";
      } elseif($file_type === 'fl10'){
         return "file10.txt"; 
      } elseif($file_type === 'impro'){
         return "impro.txt";
      } elseif($file_type === 'imdif'){
         return "IMDIF.TXT";
      } elseif($file_type === 'imric'){
         return "IMRIC.TXT";
      } elseif($file_type === 'imtype'){
         return "IMTYPE.TXT";
      } elseif($file_type === 'imdtpr'){
         return "imdtpr.txt";
      } elseif($file_type === 'fl6'){
         return "File_6.TXT";
      } else {
         return FALSE;
      }
   }
   
   private function get_int_part_price($price, $start = 0, $stop = 5){
      $return = trim(substr($price, $start, $stop));
      return $return;
   }
   
   private function get_decimal_part($price){
      $return = trim(substr($price, -2));
      return $return;
   }
   
   private function get_price($price, $start = 0, $stop = 5){
      if($price != null && $price != ''){
         $int = $this->get_int_part_price($price, $start, $stop);
         $dec = $this->get_decimal_part($price);
         return $int.".".$dec;
      } else {
         return 0;
      }
   }

}