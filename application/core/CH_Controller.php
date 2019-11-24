<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'config/CH_constants.php';
require_once APPPATH.'classes/CH_autoloader.php';

class CH_Controller extends CI_Controller {
	private $base_breadcrumb;
	private $breadcrumb;
	private $user_message;
   private $frontend_modules;
   private $frontend_plugins;
   private $frontend_css;
   private $frontend_dictionary = array();
   
	
	public function __construct() {
		parent::__construct();
      CH_autoloader::dto();
      
		$this->frontend_css = $this->frontend_modules = $this->frontend_plugins = array();
      //Nel caso di una richiesta ajax ed il server è in manutenzione restituisce un errore 503
      if(ENVIRONMENT === 'maintenance' && is_xmlhttprequest()) {
         header('HTTP/1.1 503 Service Temporarily Unavailable');
         header('Status: 503 Service Temporarily Unavailable');
         header('Retry-After: 300');//300 seconds
         exit();
      }
      
		//Gestore per il controllo dell'accesso alle pagine su base dei profili utente
		$this->load->library(array('area_access_control', 'controllers_tracker'));
      $controller = get_class($this);
      
      $this->area_access_control->check($controller);
      
		//Se sono presenti dei messaggi utenti nella sessione, li memorizza 
		//e poi li cancella
		if(!is_xmlhttprequest()) {
         $this->controllers_tracker->track($controller);
         
			if($this->session->userdata('user_message') != NULL) {
				$this->user_message = $this->session->userdata('user_message');
				$this->session->unset_userdata('user_message');
			}
		}
      $this->load_dictionary('ch_common_words');
	}
	
   public function load_dictionary($dictionary_file) {
      $t = $this->input->server('HTTP_ACCEPT_LANGUAGE');
      $lang = substr($t, 0, 2);
      if($this->bitauth->logged_in()) {
         $lang = $this->bitauth->preferred_lang;
      }
      
      $dictionary_lang = ($lang != 'it') ? 'english': 'italian';
      
      $d = $this->lang->load($dictionary_file, $dictionary_lang, TRUE);
      //this call is needed to load language in a variable to be translated in a js array inside header
      $this->frontend_dictionary = array_merge($this->frontend_dictionary, $d);
      
      //this call is needed to load language application-wide
      $this->lang->load($dictionary_file, $dictionary_lang);
   }
   
   public function get_loaded_dictionary() {
      return $this->frontend_dictionary;
   }
   
   //da inglobare nella relativa libreria
   public function send_email($email) {
      $this->load->library('phpmailer_lib');
      
      $this->phpmailer_lib->from($email['from']);
      $this->phpmailer_lib->to($email['to']);
      if(array_key_exists('cc', $email)) $this->phpmailer_lib->cc($email['cc']);
      if(array_key_exists('bcc', $email)) $this->phpmailer_lib->bcc($email['bcc']);
      $this->phpmailer_lib->subject($email['subject']);
      $this->phpmailer_lib->message($email['message']);
      if(array_key_exists('attach', $email)) $this->phpmailer_lib->attach($email['attach']);
      
      $response = array();
      if($this->phpmailer_lib->send()) {
         $response['result'] = CH_RESPONSE_SUCCESS;
      }
      else {
         $response['result'] = CH_RESPONSE_FAILURE;
         $response['message'] = lang('common_words_email_not_sent_msg');
         if($this->phpmailer_lib->is_error()) {
            $response['message'] .= ' '.$this->phpmailer_lib->get_error();
         }
      }
            
      return $response;
   }

   public function init_breadcrumb($bb) {
		$bblist = isset($bb['label']) ? array($bb) : $bb;
		$this->base_breadcrumb = $bblist;
		$this->breadcrumb = $bblist;
	}
	
	public function get_breadcrumb($crumbs=NULL) {
		if($crumbs == NULL ) return $this->base_breadcrumb;
		
		$to_merge = isset($crumbs["label"]) ? array($crumbs) : $crumbs;
		$this->breadcrumb = array_merge($this->base_breadcrumb, $to_merge);
		return $this->breadcrumb;
	}
	
	public function set_breadcrumb($crumbs=NULL) {
		if($crumbs == NULL ) return $this->base_breadcrumb;
		
		$to_merge = isset($crumbs["label"]) ? array($crumbs) : $crumbs;
		$this->breadcrumb = array_merge($this->base_breadcrumb, $to_merge);
	}
	
   public function add_frontend_modules($module) {
      if(is_array($module)) {
         foreach ($module as $s) {
            $this->add_frontend_module($s);
         }
      }
      else if(is_string($module)) {
         $this->add_frontend_module($module);
      }
	}
	
	public function add_frontend_module($module) {
      $this->add_script($module);
      $this->_add_frontend_css('my_modules/'.$module);
	}
	
	public function add_frontend_plugins($plugins) {
      if(is_array($plugins)) {
         foreach ($plugins as $s) {
            $this->add_frontend_plugin($s);
         }
      }
      else if(is_string($plugins)) {
         $this->add_frontend_plugin($plugins);
      }
	}
	
	public function add_frontend_plugin($plugin) {
      $t = $plugin.'.js';
      if(array_search($t, $this->frontend_plugins) === FALSE) {
         $this->frontend_plugins[] = 'plugin/'.$t;
      }
	}
	
   public function add_frontend_css($css) {
      if(is_array($css)) {
         foreach ($css as $s) {
            $this->_add_frontend_css($s);
         }
      }
      else if(is_string($css)) {
         $this->_add_frontend_css($css);
      }
	}
   
	private function _add_frontend_css($css_script) {
      $t = $css_script.'.css';
      if(array_search($t, $this->frontend_css) === FALSE) {
         $this->frontend_css[] = $t;
      }
	}
	
	public function add_script($script) {
      $md = $script.'.js';
      if(array_search($md, $this->frontend_modules) === FALSE) {
         $this->frontend_modules[] = 'my_modules/'.$md;
      }
   }
	
	public function send_user_message($msg, $type) {
		$msg_obj = array('type' => $type, 'message' => $msg);
		$this->user_message = $msg_obj;
		$this->session->set_userdata('user_message', $msg_obj);
	}
	
	function load_page($pages, $template_vars=NULL) {
		$vars = array(
			'base_url' => $this->config->item('base_url'),
			'bb' => $this->breadcrumb,
			'modules' => $this->frontend_modules,
         'plugins' => $this->frontend_plugins,
         'dictionary' => $this->frontend_dictionary,
			'css_script' => $this->frontend_css,
			'user_message' => $this->user_message,
			'user_fullname' => 'MANCANTE'
		);
		$full_template_vars = $template_vars !== NULL ? array_merge($vars, $template_vars) : $vars;
		$this->load->view('header', $full_template_vars);
		if(is_array($pages)) {
			foreach($pages as $page) {
				$page_name = $page['page'];
				$page_vars = array_merge($vars, $pages['vars']);
				$this->load->view($page_name, $page_vars);
			}
		}
		else {
			$this->load->view($pages, $full_template_vars);
		}
		$this->load->view('footer', $full_template_vars);
	}
	
   function create_csv($dati, $intestazione = NULL) {
      $this->load->helper('string');
      $csv = '';
      
      if($intestazione !== NULL) {
         if(is_array($intestazione)) {
            $csv .= '"'.implode('";"', array_map('strip_quotes', $intestazione))."\"\r\n";
         }
         elseif (is_string($intestazione)) {
            $csv .= $intestazione;
         }
      }
   
      foreach ($dati as $row) {
         $v = array_values($row);
         $csv .= '"'.implode('";"', array_map('strip_quotes', $v))."\"\r\n";
      }
      return utf8_decode($csv);
   }
   
	function create_send_csv($dati, $filename, $intestazione = NULL) {
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="' . $filename . '"');
      header('Cache-Control: max-age=0');
      
      echo $this->create_csv($dati, $intestazione);
   }
   
   function get_um(){
      $um = array(
          'pezzo' => 'Pz.',
          'sacchetto' => 'Sac.',
          'scatolo' => 'Scat.',
          'metro' => 'Mt.',
          'litro' => 'Lt.'
      );
      return $um;
   }
}