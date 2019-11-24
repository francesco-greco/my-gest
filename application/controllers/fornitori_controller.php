<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fornitori_controller extends CH_Controller {
   
	public function __construct() {
		parent::__construct();
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
		$bb[] = array('label' => "fornitori", 'url' => base_url(CH_URL_FORNITORI));
		$this->init_breadcrumb($bb);
		$this->add_frontend_module('my_fornitori');
      $this->add_frontend_css('my_fornitori');
      load_dto('fornitori_dto');
      $this->load->model(array('fornitori_model'));
	}
   
   public function index(){
      $this->load_page('fornitori/fornitori_main');
   }
   
   public function get_fornitori_table_feed(){
      $list = $this->fornitori_model->get_fornitori_table_feed();
      json_output($list);
   }
   
   public function show_new_supplier_window(){
      $this->load->view('fornitori/windows/new_supplier_window');
   }
   
   public function create_supplier(){
      $supplier = Fornitori_DTO::raccogli_dati_request('fornitore');
      $result = $this->fornitori_model->save($supplier);
      json_output($result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function show_supplier($id_supplier){
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
		$bb[] = array('label' => "fornitori", 'url' => base_url(CH_URL_FORNITORI));
      $bb[] = array('label' => "anagrafica fornitore", 'url' => "");
		$this->init_breadcrumb($bb);
      $fornitore = $this->fornitori_model->get($id_supplier);
      $data = array(
          'fornitore' => $fornitore
      );
      $this->load_page('fornitori/supplier_page', $data);
   }
   
   public function get_list(){
      $filtro = $this->input->get('term');
      $return = $this->fornitori_model->get_list($filtro);
      json_output($return);
   }
   
}

