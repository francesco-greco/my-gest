<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_instrument_type_DTO extends DTO {
    const TABLE_NAME = 'lab_instrument_type';

    const FIELD_ID_LAB_INSTRUMENT_TYPE = 'id_lab_instrument_type';
    const FIELD_TYPE = 'type';
    const FIELD_LANGUAGE_LABEL = 'language_label';
    const FIELD_ORDER = 'order';

    public $id;
    public $type;
    public $language_label;
    public $order;
    
    public function init($data) {
        if( ! is_array($data) && ! is_object($data)) {
            $this->pulisci();
        }
        else {
            $data = (array) $data;
            $this->id = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT_TYPE, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT_TYPE] : '';
            $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
            $this->language_label = array_key_exists(self::FIELD_LANGUAGE_LABEL, $data) ? $data[self::FIELD_LANGUAGE_LABEL] : '';
            $this->order = array_key_exists(self::FIELD_ORDER, $data) ? $data[self::FIELD_ORDER] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID_LAB_INSTRUMENT_TYPE] = $this->id;
      if($this->type !== '') $data[self::FIELD_TYPE] = $this->type;
      if($this->language_label !== '') $data[self::FIELD_LANGUAGE_LABEL] = $this->language_label;
      if($this->order !== '') $data[self::FIELD_ORDER] = $this->order;
      return $data;
   }
}
