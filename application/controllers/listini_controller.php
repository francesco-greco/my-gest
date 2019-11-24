<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listini_controller extends CH_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->model(array('listini_model','brands_model'));
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
      $bb[] = array('label' => "listini", 'url' => base_url(CH_URL_LISTINI));
      $this->init_breadcrumb($bb);
      $this->add_frontend_module('my_listini');
      $this->add_frontend_css('my_listini');
      load_dto('listini_dto');
      load_dto('brands_dto');
      load_dto('magazzino_dto');
   }

   public function index(){
        $this->load_page('listini/listini_main_view');
    }
    
    public function show_new_listino_window(){
        $this->load->model(array('brands_model'));
        $brands_list = $this->brands_model->get_brands_list();
        $data = array(
            'brands' => $brands_list
        );
        $this->load->view('listini/windows/new_listino_window', $data);
    }
    
    public function save(){
        $listino = Listini_DTO::raccogli_dati_request('listino');
        $result = $this->listini_model->save($listino);
        json_output($result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
    }
    
    public function show_listini() {
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
      $bb[] = array('label' => "listini", 'url' => base_url(CH_URL_LISTINI));
      $bb[] = array('label' => "listini dettagli", 'url' => "");
      $brands = $this->brands_model->get_brands_list();
      $data = array('brands' => $brands);
      $this->init_breadcrumb($bb);
      $this->load_page('listini/details_listini_view', $data);
   }

   public function get_listini_table_feed(){
      $custom_filter = $this->input->get('brand_code');
        $output = $this->listini_model->get_listini_table_feed($custom_filter);
        json_output($output);
    }
    
    public function show_details_listino_window($id_listino){
        $listino = $this->listini_model->get_listino($id_listino);
        $data = array(
            'listino' => $listino['listino']
        );
        $this->load->view('listini/windows/listino_details_window', $data);
    }
    
    public function carica_articoli_view(){
       $this->load_page('carica_articoli_view');
    }
    
}
