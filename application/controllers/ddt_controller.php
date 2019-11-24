<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ddt_controller extends CH_Controller {
   
   public function __construct() {
		parent::__construct();
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
//		$bb[] = array('label' => "DDT", 'url' => "");
		$this->init_breadcrumb($bb);
		$this->add_frontend_module('my_ddt');
//      $this->add_frontend_css('my_ddt');
      load_dto('ddt_dto');
      $this->load->model(array('ddt_model','brands_model'));
	}
   
   public function show_new_ddt_window(){
      $this->load->view('ddt/windows/new_ddt_window');
   }


   public function show_ddt_view($id_ddt){
      $bb[] = array('label' => "DDT caricati", 'url' => base_url(CH_URL_DDT."/ddt_list_page"));
      $bb[] = array('label' => "DDT", 'url' => "");
		$this->set_breadcrumb($bb);
      $brands = $this->brands_model->get_brands_list();
      $ddt = $this->ddt_model->get($id_ddt);
      $data = array(
          'brands' => $brands,
          'ddt' => $ddt,
          'ums' => $this->get_um()
      );
      $this->load_page('ddt/ddt_view', $data);
   }
   
   public function save_ddt(){
      $dto = Ddt_DTO::raccogli_dati_request('ddt');
      $dto->id_sede = $this->bitauth->id_sede;
      $result = $this->ddt_model->save($dto);
      $data = array();
      if($result != FALSE){
         $data['response'] = CH_RESPONSE_SUCCESS;
         $data['id_ddt'] = $result;
      } else {
         $data['response'] = CH_RESPONSE_FAILURE;
      }
      json_output($data);
   }
   
   public function get_datails($id_ddt){
      $details = $this->ddt_model->get_details($id_ddt);
      json_output($details);
   }
   
   public function save_ddt_detail(){
      $id_ddt = $this->input->post('id_ddt');
      $id_brand = $this->input->post('id_brand');
      $codice = $this->input->post('codice');
      $um = $this->input->post('um');
      $quantita = $this->input->post('quantita');
      $detail = new Ddt_dettaglio_DTO();
      $detail->codice_articolo = $codice;
      $detail->id_brand = $id_brand;
      $detail->id_ddt = $id_ddt;
      $detail->quantita = $quantita;
      $detail->unita_misura = $um;
      $result = $this->ddt_model->save_detail($detail);
      json_output($result);
   }
   
   public function ddt_list_page(){
      $bb[] = array('label' => "DDT caricati", 'url' => "");
		$this->set_breadcrumb($bb);
      $this->load_page('ddt/ddt_list_view');
   }
   
   public function get_ddt_table_feed(){
      $list = $this->ddt_model->get_ddt_table_feed();
      json_output($list);
   }
   
   public function get_ddt_old_table_feed(){
      $list = $this->ddt_model->get_ddt_old_table_feed();
      json_output($list);
   }
   
   public function delete_detail($id_detail){
      $result = $this->ddt_model->delete_detail($id_detail);
      json_output($result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function close_ddt($id_ddt){
      $result = $this->ddt_model->close_ddt($id_ddt);
      json_output($result);
   }
   
   public function get_list_details($id_brand = FALSE){
      if($id_brand == FALSE){
         $id_brand = $this->input->get('id_brand');
      }
      $filtro = $this->input->get('term');
      $return = $this->ddt_model->get_list($id_brand, $filtro);
      json_output($return);
   }
   
}