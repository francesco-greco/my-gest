<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area_access_control {
	public $config;
	public $last_modified_config_file;
	public $bitauth;
	public $session;

	public function __construct() {
		$CI = & get_instance();
		$CI->load->library('bitauth');
		$CI->load->library('session');
		$this->bitauth = $CI->bitauth;
		$this->session = $CI->session;
		
		$CI->load->config('area_access_control', TRUE);
		$this->config = $CI->config->item('authorized', 'area_access_control');
		
	}
	
	public function check($classname) {
		//Controlla se a richiedere la pagina è un utente autorizzato
		if( ! $this->bitauth->logged_in()) {
         //Nel caso di richieste ajax si restiuisce un error code 401
         if(is_xmlhttprequest()) {
            header('HTTP/1.1 401 Unauthorized');
         }
         else {
            // Salvo l'url cosi da rimardarci l'utente dopo l'avvenuta autenticazione
            $this->session->set_userdata('redir', current_url());

            // Redirect to login form
            redirect(base_url(CH_URL_LOGIN));
         }
		}
		
		//Se la classe non è censita nell'array di configurazione allora è accessibile
		//da qualsiasi utente autorizzato
		$classlist = array_keys($this->config);
		if(in_array($classname, $classlist)) {
			$class_config = $this->config[$classname];
         $passed = FALSE;
         if(is_array($class_config['role'])) {
            foreach ($class_config['role'] as $role) {
               $passed |= $this->bitauth->has_role($role);
            }
         }
         else {
            $passed = $this->bitauth->has_role($class_config['role']);
         }
         
         if(!$passed) {
            $msg_obj = array('type' => 'info', 'message' => 'Accesso non consentito');
            $this->session->set_userdata('user_message', $msg_obj);
            $r = in_array('landing_page', $class_config) ? $class_config['landing_page'] : CH_URL_MAIN;
            redirect(base_url($r));
         }
		}
	}
}