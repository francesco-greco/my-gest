<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Lab_instruments_model extends CH_Model {
   public function get_lab_instrument($id_lab_instrument) {
      $this->db->from(Lab_instrument_DTO::TABLE_NAME)
         ->where(Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT, $id_lab_instrument);
      
      return $this->_get(Lab_instrument_DTO::class_name(), FALSE);
   }
   
   public function save(Lab_instrument_DTO $lab_instrument) {
      $response = FALSE;
      if(!is_numeric($lab_instrument->id)) {
         $response = $this->_insert(Lab_instrument_DTO::TABLE_NAME, $lab_instrument->get_data_for_db());
      }
      else {
         $this->db->where(Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT, $lab_instrument->id);
         $response = $this->db->update(Lab_instrument_DTO::TABLE_NAME, $lab_instrument->get_data_for_db());
      }
      return $response;
   }
   
   public function add_lab_instrument($id_lab, Lab_instrument_DTO $lab_instrument) {
      $lab_instrument->id_lab = $id_lab;
      return $this->_insert(Lab_instrument_DTO::TABLE_NAME, $lab_instrument->get_data_for_db());
   }
   
   public function get_lab_instrument_names($filter = FALSE) {
      $this->db->distinct()
         ->from(Lab_instrument_DTO::TABLE_NAME)
         ->order_by(Lab_instrument_DTO::FIELD_NAME);
      
      if($filter !== FALSE) $this->db->like(Lab_instrument_DTO::FIELD_NAME, $filter, 'after');
      return $this->_get_list(Lab_instrument_DTO::class_name());
   }
   
   public function get_lab_instrument_by_lab($id_lab) {
      $this->db->from(Lab_instrument_DTO::TABLE_NAME)
         ->where(Lab_instrument_DTO::FIELD_ID_LAB, $id_lab)
         ->order_by(Lab_instrument_DTO::FIELD_NAME);
      
      return $this->_get_list(Lab_instrument_DTO::class_name());
   }
   
   public function get_lab_instruments_table_feed($id_lab) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT, 'dt' => 'id'),
         array('db' => Lab_instrument_DTO::FIELD_NAME, 'dt' => 'name'),
         array('db' => Lab_instrument_DTO::FIELD_DESCRIPTION, 'dt' => 'description')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Lab_instrument_DTO::TABLE_NAME)
         ->add_where_clauses(array(Lab_instrument_DTO::FIELD_ID_LAB => $id_lab));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_instruments_types() {
      $this->db->from(Lab_instrument_type_DTO::TABLE_NAME)
         ->order_by(Lab_instrument_type_DTO::FIELD_ORDER);
      
      return $this->_get_list(Lab_instrument_type_DTO::class_name());
   }
}
