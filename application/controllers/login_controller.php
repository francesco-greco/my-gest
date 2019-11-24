<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_controller extends CI_Controller {
   public function __construct() {
      parent::__construct();
      
      require_once APPPATH.'classes/CH_autoloader.php';
      CH_autoloader::dto();
      
      $lang = substr($this->input->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
      
      $dictionary_lang = ($lang != 'it') ? 'english': 'italian';
      $this->lang->load('ch_common_words', $dictionary_lang);
      $this->lang->load('ch_login', $dictionary_lang);
      
      $this->load->library('bitauth');
      $this->load->helper('recaptcha');
   }

   public function hash($pwd=NULL) {
		if($pwd === NULL) {
			redirect(base_url(CH_URL_LOGIN));
		}
		else {
			$this->load->library('phpass_lib');
			echo $this->phpass_lib->HashPassword($pwd);
		}
	}
	
   public function wip() {
      $data = array('base_url' => $this->config->item('base_url'), "no_breadcrumb" => true);
      
      $this->load->view('header', $data);
		$this->load->view('wip_view');
		$this->load->view('footer');
   }
   
	public function index() {
		$data = array('base_url' => $this->config->item('base_url'));
      
      $js_scripts = array(
         'my_modules/my_login.js'
      );
		
      if($this->session->userdata('user_message')) {
			$data['user_message'] = $this->session->userdata('user_message');
			$this->session->unset_userdata('user_message');
		}
		
		$this->load->view('header', $data);
		$this->load->view('login_view', array('modules' => $js_scripts));
		$this->load->view('footer');
	}
	
	public function autenticate() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember_me = $this->input->post('remember_me');

//      $resp = recaptcha_check_answer (RECAPTCHA_LOCALHOST_PRIVATE_KEY,
//            $this->input->server("REMOTE_ADDR"),
//            $this->input->post('recaptcha_challenge_field'),
//            $this->input->post('recaptcha_response_field'));

//      if($resp->is_valid) {
         if($this->bitauth->login($username, $password, $remember_me)) {
            json_response(CH_RESPONSE_SUCCESS);
         }
         else {
            json_response(CH_RESPONSE_FAILURE, array('message' => $this->bitauth->get_error()));
         }	
//		}
//      else {
//			json_response(CH_RESPONSE_FAILURE, array('message' => lang('login_recapcha_error')));
//      }
	}
	
	public function logout() {
		$this->bitauth->logout();
		redirect(base_url(CH_URL_LOGIN));
	}
}