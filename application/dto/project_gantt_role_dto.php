<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_gantt_role_DTO extends DTO {

   const TABLE_NAME = 'project_gantt_roles';
   const FIELD_ID_PROJECT_GANTT_ROLE = 'id_project_gantt_role';
   const FIELD_NAME = 'name';
   const FIELD_ENABLED = 'enabled';

   public $id;
   public $name;
   public $enabled;

   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_PROJECT_GANTT_ROLE, $data) ? $data[self::FIELD_ID_PROJECT_GANTT_ROLE] : '';
         $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
         $this->enabled = array_key_exists(self::FIELD_ENABLED, $data) ? $data[self::FIELD_ENABLED] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_PROJECT_GANTT_ROLE] = $this->id;
      if ($this->name !== '')
         $data[self::FIELD_NAME] = $this->name;
      if ($this->enabled !== '')
         $data[self::FIELD_ENABLED] = $this->enabled;
      return $data;
   }
}