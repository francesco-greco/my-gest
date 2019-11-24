<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_DTO extends DTO {

   const TABLE_NAME = 'labs';
   const FIELD_ID_LAB = 'id_lab';
   const FIELD_NAME = 'name';
   const FIELD_DESCRIPTION = 'description';
   const FIELD_ID_LAB_CHIEF = 'id_lab_chief';

   public $id;
   public $name;
   public $description;
   public $id_lab_chief;
   
   public $lab_chief;

   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_LAB, $data) ? $data[self::FIELD_ID_LAB] : '';
         $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
         $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
         $this->id_lab_chief = array_key_exists(self::FIELD_ID_LAB_CHIEF, $data) ? $data[self::FIELD_ID_LAB_CHIEF] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_LAB] = $this->id;
      if ($this->name !== '')
         $data[self::FIELD_NAME] = $this->name;
      if ($this->description !== '')
         $data[self::FIELD_DESCRIPTION] = $this->description;
      if ($this->id_lab_chief !== '')
         $data[self::FIELD_ID_LAB_CHIEF] = $this->id_lab_chief;
      return $data;
   }
}