<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_instrument_attachments_DTO extends Attachment_DTO {
   const REL_TABLE_NAME = 'lab_instrument_attachments_rel';
   
   const FIELD_ID_LAB_INSTRUMENT_ATTACHMENT = 'id_lab_instrument_attachment';
   const FIELD_ID_LAB_TASK = 'id_lab_task';
   const FIELD_ID_LAB_INSTRUMENT = 'id_lab_instrument';
   
   public $id_lab_instrument_attachment;
   public $id_lab_task;
   public $id_lab_instrument;
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         parent::init($data);
         
         $this->id_lab_instrument_attachment = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT] : '';
         $this->id_lab_task = array_key_exists(self::FIELD_ID_LAB_TASK, $data) ? $data[self::FIELD_ID_LAB_TASK] : '';
         $this->id_lab_instrument = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT] : '';
      }
   }

   public function get_data_for_db() {
      $data = parent::get_data_for_db();
      
      if ($this->id_lab_task !== '')
         $data[self::FIELD_ID_LAB_TASK] = $this->id_lab_task;
      if ($this->id_lab_instrument_attachment !== '')
         $data[self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT] = $this->id_lab_instrument_attachment;
      if ($this->id_lab_instrument !== '')
         $data[self::FIELD_ID_LAB_INSTRUMENT] = $this->id_lab_instrument;

      return $data;
   }
   
   public function get_rel_data_for_db() {
      $data = array();
      
      if ($this->id !== '')
         $data[self::FIELD_ID_ATTACHMENT] = $this->id;
      if ($this->id_lab_task !== '')
         $data[self::FIELD_ID_LAB_TASK] = $this->id_lab_task;
      if ($this->id_lab_instrument !== '')
         $data[self::FIELD_ID_LAB_INSTRUMENT] = $this->id_lab_instrument;

      return $data;
   }

}
