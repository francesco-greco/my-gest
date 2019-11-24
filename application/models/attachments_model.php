<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachments_model extends CH_Model {

   public function get_attachment_categories($type) {
      $this->db->from(Attachment_category_DTO::TABLE_NAME)
         ->like(Attachment_category_DTO::FIELD_TYPES, $type)
         ->order_by(Attachment_category_DTO::FIELD_ORDER);
      
      return $this->_get_list(Attachment_category_DTO::class_name());
   }
   
   public function get_attachment($id_attachment) {
      $this->db->from(Attachment_DTO::TABLE_NAME.' a')
         ->where('a.'.Attachment_DTO::FIELD_ID_ATTACHMENT, $id_attachment);
      
      return $this->_get(Attachment_DTO::class_name());
   }
   
   public function save(Attachment_DTO $attachment) {
      if(is_numeric($attachment->id)) {
         return $this->db->update(Attachment_DTO::TABLE_NAME, $attachment->get_data_for_db(), array(Attachment_DTO::FIELD_ID_ATTACHMENT => $attachment->id));
      }
      else {
         return $this->_insert(Attachment_DTO::TABLE_NAME, $attachment->get_data_for_db());
      }
   }
}
