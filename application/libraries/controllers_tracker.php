<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controllers_tracker {
	var $session;
   var $tracker;

	public function __construct() {
		$CI = & get_instance();
		$CI->load->library('session');
		$this->session = $CI->session;
	}
	
   private function get_tracker() {
      return unserialize($this->session->userdata('controller_tracker'));
   }
   
   private function update_tracker() {
      $this->session->set_userdata('controller_tracker', serialize($this->tracker));
   }
   
   public function get_previous_controller() {
      $this->tracker = $this->get_tracker();
      return count($this->tracker) >= 2 ? $this->tracker[0] : FALSE;
   }
   
	public function track($controller) {
		$this->tracker = $this->get_tracker();
      $controller_trimmmed = strtolower(str_replace('_controller', '', $controller));
      
      if(empty($this->tracker)) {
         $this->tracker = array($controller_trimmmed);
      }
      else if(count($this->tracker) == 1 && $this->tracker[0] != $controller_trimmmed) {
         $this->tracker[] = $controller_trimmmed;
      }
      else if(count($this->tracker) > 1 && $this->tracker[1] != $controller_trimmmed) {
         $this->tracker[] = $controller_trimmmed;
         array_shift($this->tracker);
      }
      
      $this->update_tracker();
	}
}