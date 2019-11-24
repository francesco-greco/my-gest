<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_instrument_DTO extends DTO {
    const TABLE_NAME = 'lab_instruments';

    const FIELD_ID_LAB_INSTRUMENT = 'id_lab_instrument';
    const FIELD_NAME = 'instrument_name';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_TYPE = 'type';
    const FIELD_RENTABLE = 'rentable';
    const FIELD_ID_LAB = 'id_lab';

    const TYPE_NONE = 'NONE';
    
    public $id;
    public $name;
    public $description;
    public $type;
    public $rentable;
    public $id_lab;
    
    public function init($data) {
        if( ! is_array($data) && ! is_object($data)) {
            $this->pulisci();
        }
        else {
            $data = (array) $data;
            $this->id = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT] : '';
            $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
            $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
            $this->rentable = array_key_exists(self::FIELD_RENTABLE, $data) ? $data[self::FIELD_RENTABLE] : '';
            $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
            $this->id_lab = array_key_exists(self::FIELD_ID_LAB, $data) ? $data[self::FIELD_ID_LAB] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID_LAB_INSTRUMENT] = $this->id;
      if($this->name !== '') $data[self::FIELD_NAME] = $this->name;
      if($this->description !== '') $data[self::FIELD_DESCRIPTION] = $this->description;
      if($this->rentable !== '') $data[self::FIELD_RENTABLE] = $this->rentable;
      if($this->type !== '') $data[self::FIELD_TYPE] = $this->type;
      if($this->id_lab !== '') $data[self::FIELD_ID_LAB] = $this->id_lab;
      return $data;
   }   
}
