<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CH_Model extends CI_Model {
   var $error = FALSE;
   var $error_msg  = array();

   public function set_error($error_msg) {
      $this->error = TRUE;
      $this->error_msg[] = $error_msg;
   }
   
   public function has_errors() {
      return $this->error;
   }

   public function clear_errors() {
      $this->error = FALSE;
      $this->error_msg = array();
   }

   public function get_errors() {
      return $this->error_msg;
   }

   public function _get_list($dto_class_name = NULL) {
      if($dto_class_name === NULL || class_exists($dto_class_name)) {
         $query = $this->db->get();
         $list = array();
         foreach ($query->result_array() as $row) {
            $obj = $dto_class_name !== NULL ? new $dto_class_name($row) : $row;
            $list[] = $obj;
         }
         return $list;
      }
   }
   
   //funzione utilizzata come feed per i campi con autocompletamento
   public function autocomplete_data($field, $table, $filter) {
      $this->db->distinct();
      $this->db->select($field);
      if($filter !== FALSE) $this->db->like($field, $filter);
      $this->db->from($table);
      $this->db->order_by($field);
      
      $query = $this->db->get();
      $list = array();
      foreach ($query->result_array() as $row) {
         $list[] = $row[$field];
      }
      return $list;
   }

   public function _get($dto_class_name = NULL, $default=NULL) {
      $query = $this->db->get();
		
		$num = $query->num_rows();
		$obj = $dto_class_name !== NULL ? new $dto_class_name: new stdClass;
		if($num > 0) {
			$row = $query->row_array();
			if($dto_class_name !== NULL) {
            $obj->init($row);
         }
         else {
            $obj = $row;
         }
		}
      elseif($default !== NULL) {
         $obj = $default;
      }

		return $obj;
   }
   
   public function _insert($tabella, $dati) {
      $res = $this->db->insert($tabella, $dati);
      return $res !== FALSE ? $this->db->insert_id() : FALSE;
   }
}