<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_DTO extends DTO {

   const TABLE_NAME = 'projects';
   const FIELD_ID_PROJECT = 'id_project';
   const FIELD_NAME = 'name';
   const FIELD_CODE = 'code';
   const FIELD_DESCRIPTION = 'description';
   const FIELD_START_DATE = 'start_date';
   const FIELD_END_DATE = 'end_date';
   const FIELD_ID_CLIENT = 'id_client';
   const FIELD_ID_PROJECT_LEADER = 'id_project_leader';

   public $id;
   public $name;
   public $code;
   public $description;
   public $start_date;
   public $end_date;
   public $id_client;
   public $id_project_leader;
   
   public $client;
   public $project_leader;

   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_PROJECT, $data) ? $data[self::FIELD_ID_PROJECT] : '';
         $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
         $this->code = array_key_exists(self::FIELD_CODE, $data) ? $data[self::FIELD_CODE] : '';
         $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
         $this->start_date = array_key_exists(self::FIELD_START_DATE, $data) ? db_to_normal_date($data[self::FIELD_START_DATE]) : '';
         $this->end_date = array_key_exists(self::FIELD_END_DATE, $data) ? db_to_normal_date($data[self::FIELD_END_DATE]) : '';
         $this->id_client = array_key_exists(self::FIELD_ID_CLIENT, $data) ? $data[self::FIELD_ID_CLIENT] : '';
         $this->id_project_leader = array_key_exists(self::FIELD_ID_PROJECT_LEADER, $data) ? $data[self::FIELD_ID_PROJECT_LEADER] : '';
      }
   }

   public function is_started() {
      return $this->start_date && $this->start_date != NULL_DB_DATE.' '.NULL_DB_TIME;
   }

   public function is_ended() {
      return $this->end_date && $this->end_date != NULL_DB_DATE.' '.NULL_DB_TIME;
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_PROJECT] = $this->id;
      if ($this->name !== '')
         $data[self::FIELD_NAME] = $this->name;
      if ($this->code !== '')
         $data[self::FIELD_CODE] = $this->code;
      if ($this->description !== '')
         $data[self::FIELD_DESCRIPTION] = $this->description;
      if ($this->start_date !== '')
         $data[self::FIELD_START_DATE] = normal_to_db_date ($this->start_date);
      if ($this->end_date !== '')
         $data[self::FIELD_END_DATE] = normal_to_db_date ($this->end_date);
      if ($this->id_client !== '')
         $data[self::FIELD_ID_CLIENT] = $this->id_client;
      if ($this->id_project_leader !== '')
         $data[self::FIELD_ID_PROJECT_LEADER] = $this->id_project_leader;
      return $data;
   }

}
