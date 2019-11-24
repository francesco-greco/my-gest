<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'dto/headquarters_dto.php';

class Headquarters_model extends CH_Model{
   
   public function get_list(){
      $this->db->from(Headquarters_DTO::TABLE_NAME);
      return $this->_get_list(Headquarters_DTO::class_name());
   }
   
   public function get($id_sede){
      $this->db->from(Headquarters_DTO::TABLE_NAME)
              ->where(Headquarters_DTO::FIELD_ID, $id_sede);
      return $this->_get(Headquarters_DTO::class_name(),FALSE);
   }
   
}
