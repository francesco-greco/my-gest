<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_instrument_timesheets_DTO extends DTO {
    const TABLE_NAME = 'lab_instrument_timesheets';

    const FIELD_ID_LAB_INSTRUMENT_TIMESHEET = 'id_lab_instrument_timesheet';
    const FIELD_ID_LAB_INSTRUMENT = 'id_lab_instrument';
    const FIELD_ID_LAB_TASK = 'id_lab_task';
    const FIELD_TYPE = 'type';
    const FIELD_START_TIMESTAMP = 'start_timestamp';
    const FIELD_END_TIMESTAMP = 'end_timestamp';
    const FIELD_DURATION = 'duration';
    const FIELD_ID_USER = 'id_user';

    public $id;
    public $id_lab_instrument;
    public $id_lab_task;
    public $type;
    public $start_timestamp;
    public $end_timestamp;
    public $duration;
    public $id_user;
    
    public function init($data) {
        if( ! is_array($data) && ! is_object($data)) {
            $this->pulisci();
        }
        else {
            $data = (array) $data;
            $this->id = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT_TIMESHEET, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT_TIMESHEET] : '';
            $this->id_lab_instrument = array_key_exists(self::FIELD_ID_LAB_INSTRUMENT, $data) ? $data[self::FIELD_ID_LAB_INSTRUMENT] : '';
            $this->id_lab_task = array_key_exists(self::FIELD_ID_LAB_TASK, $data) ? $data[self::FIELD_ID_LAB_TASK] : '';
            $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
            $this->start_timestamp = array_key_exists(self::FIELD_START_TIMESTAMP, $data) ? db_to_normal_timestamp($data[self::FIELD_START_TIMESTAMP]) : '';
            $this->end_timestamp = array_key_exists(self::FIELD_END_TIMESTAMP, $data) ? db_to_normal_timestamp($data[self::FIELD_END_TIMESTAMP]) : '';
            $this->duration = array_key_exists(self::FIELD_DURATION, $data) ? $data[self::FIELD_DURATION] : '';
            $this->id_user = array_key_exists(self::FIELD_ID_USER, $data) ? $data[self::FIELD_ID_USER] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID_LAB_INSTRUMENT_TIMESHEET] = $this->id;
      if($this->id_lab_instrument !== '') $data[self::FIELD_ID_LAB_INSTRUMENT] = $this->id_lab_instrument;
      if($this->id_lab_task !== '') $data[self::FIELD_ID_LAB_TASK] = $this->id_lab_task;
      if($this->type !== '') $data[self::FIELD_TYPE] = $this->type;
      if($this->start_timestamp !== '') $data[self::FIELD_START_TIMESTAMP] = normal_to_db_timestamp ($this->start_timestamp);
      if($this->end_timestamp !== '') $data[self::FIELD_END_TIMESTAMP] = normal_to_db_timestamp ($this->end_timestamp);
      
      if($this->duration !== '') {
         $data[self::FIELD_DURATION] = $this->duration;
      }
      else if($this->start_timestamp !== '' && $this->end_timestamp !== '') {
         $data[self::FIELD_DURATION] = strtotime($data[self::FIELD_END_TIMESTAMP]) - strtotime($data[self::FIELD_START_TIMESTAMP]);
      }
      
      if($this->id_user !== '') $data[self::FIELD_ID_USER] = $this->id_user;
      return $data;
   }
}
