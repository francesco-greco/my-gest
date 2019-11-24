<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_controller extends CH_Controller {
   public function __construct() {
      parent::__construct();
      $this->load_dictionary('ch_main');
      $bb[] = array('label' => "Home", 'url' => base_url(CH_URL_MAIN));
      $this->init_breadcrumb($bb);
      $this->add_frontend_modules(array('my_main','my_ddt'));
   }

   public function index() {
      $this->load_page('main_view');
   }
   
   public function wait() {
      $this->load->view('_templates/waiting_page');
   }
}