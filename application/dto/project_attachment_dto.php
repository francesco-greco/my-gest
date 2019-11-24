<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_attachment_DTO extends Attachment_DTO {
   const REL_TABLE_NAME = 'project_attachments_rel';
   
   const FIELD_ID_PROJECT_ATTACHMENT = 'id_project_attachment';
   const FIELD_ID_PROJECT = 'id_project';
   
   public $id_project_attachment;
   public $id_project;
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         parent::init($data);
         
         $this->id_project_attachment = array_key_exists(self::FIELD_ID_PROJECT_ATTACHMENT, $data) ? $data[self::FIELD_ID_PROJECT_ATTACHMENT] : '';
         $this->id_project = array_key_exists(self::FIELD_ID_PROJECT, $data) ? $data[self::FIELD_ID_PROJECT] : '';
      }
   }

   public function get_data_for_db() {
      $data = parent::get_data_for_db();
      
      if ($this->id_project_attachment !== '')
         $data[self::FIELD_ID_PROJECT_ATTACHMENT] = $this->id_project_attachment;
      if ($this->id_project !== '')
         $data[self::FIELD_ID_PROJECT] = $this->id_project;

      return $data;
   }
   
   public function get_rel_data_for_db() {
      $data = array();
      
      if ($this->id !== '')
         $data[self::FIELD_ID_ATTACHMENT] = $this->id;
      if ($this->id_project !== '')
         $data[self::FIELD_ID_PROJECT] = $this->id_project;

      return $data;
   }

}
