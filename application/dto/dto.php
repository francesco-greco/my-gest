<?php if (!defined('BASEPATH'))	exit('No direct script access allowed');

abstract class DTO {
   const EMPTY_FIELD_VALUE = FALSE;

   abstract public function init($data);
	abstract public function get_data_for_db();
   
   static public function class_name() {
      return get_called_class();
   }

   public function __construct($data = NULL) {
		$this->init($data);
	}
	
	public function comprimi() {
		$tmp = (array) $this;
		$compresso = array();
		foreach ($tmp as $key => $value) {
         if($value != '' && $value != NULL) {
            if($value instanceof DTO) {
               $compresso[$key] = $value->comprimi();
            }
            else {
               $compresso[$key] = $value;
            }
         }
      }
		return (object) $compresso;
	}
	
	static public function raccogli_dati_request($prefisso, $tipo_request = 'POST') {
      $dto_class_name = get_called_class();
      
      $dto = new $dto_class_name();
		$CI = &get_instance();
		$chiavi = array_keys((array) $dto);
		if($tipo_request === 'POST') {
			foreach ($chiavi as $k) {
				if($CI->input->post($prefisso.'_'.$k) !== FALSE)
					$dto->$k = $CI->input->post($prefisso.'_'.$k);
			}
		}
		else if($tipo_request === 'GET') {
			foreach ($chiavi as $k) {
				if($CI->input->get($prefisso.'_'.$k) !== FALSE)
					$dto->$k = $CI->input->get($prefisso.'_'.$k);
			}
		}
      else if($tipo_request === 'REQUEST') {
			foreach ($chiavi as $k) {
				if($CI->input->get($prefisso.'_'.$k) !== FALSE)
					$dto->$k = $CI->input->get_post($prefisso.'_'.$k);
			}
		}
      return $dto;
	}
   
   public function pulisci($default = '') {
      $tmp = (array) $this;
		foreach ($tmp as $key => $value) {
         $this->$key = $default;
      }
   }
   
  public function clona() {
      $classname = get_class($this);
      $d = $this->get_data_for_db();
      return new $classname($d);
   }
}