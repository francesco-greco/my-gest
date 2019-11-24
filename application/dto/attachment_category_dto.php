<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Attachment_category_DTO extends DTO {

   const TABLE_NAME = 'attachment_category';
   const FIELD_ID_LAB_INSTRUMENT_ATTACHMENT_CATEGORY = 'id_attachment_category';
   const FIELD_CATEGORY = 'category';
   const FIELD_TYPES = 'types';
   const FIELD_LANGUAGE_LABEL = 'language_label';
   const FIELD_ORDER = 'order';

   const CATEGORY_INSTRUCTION = 'INSTRUCTION';
   const CATEGORY_RESULT = 'RESULT';
   const CATEGORY_OTHER = 'OTHER';
   
   public $id;
   public $category;
   public $types;
   public $language_label;
   public $order;

   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT_CATEGORY, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT_CATEGORY] : '';
         $this->category = array_key_exists(self::FIELD_CATEGORY, $data) ? $data[self::FIELD_CATEGORY] : '';
         $this->types = array_key_exists(self::FIELD_TYPES, $data) ? $data[self::FIELD_TYPES] : '';
         $this->language_label = array_key_exists(self::FIELD_LANGUAGE_LABEL, $data) ? $data[self::FIELD_LANGUAGE_LABEL] : '';
         $this->order = array_key_exists(self::FIELD_ORDER, $data) ? $data[self::FIELD_ORDER] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_LAB_INSTRUMENT_ATTACHMENT_TYPE] = $this->id;
      if ($this->category !== '')
         $data[self::FIELD_CATEGORY] = $this->category;
      if ($this->types !== '')
         $data[self::FIELD_TYPES] = $this->types;
      if ($this->language_label !== '')
         $data[self::FIELD_LANGUAGE_LABEL] = $this->language_label;
      if ($this->order !== '')
         $data[self::FIELD_ORDER] = $this->order;
      return $data;
   }

}
