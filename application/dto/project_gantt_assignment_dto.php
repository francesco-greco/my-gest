<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_gantt_assignment_DTO extends DTO {

   const TABLE_NAME = 'project_gantt_assignments';
   const FIELD_ID_PROJECT_GANTT_ASSIGNMENT = 'id_project_gantt_assignment';
   const FIELD_ID_PROJECT_GANTT_TASK = 'id_project_gantt_task';
   const FIELD_ID_RESOURCE = 'id_resource';
   const FIELD_ID_PROJECT_GANTT_ROLE = 'id_project_gantt_role';
   const FIELD_EFFORT = 'effort';

   public $id;
   public $id_project_gantt_task;
   public $resourceId;
   public $roleId;
   public $effort;
   
   static public function parse_gantt_json($json) {
      $class_name = self::class_name();
      $assignment_data = is_string($json) ? json_decode($json, true): $json;
      
      $dto = new $class_name();
      $dto->id = is_numeric($assignment_data['id']) ? $assignment_data['id'] : '';
      $dto->resourceId = $assignment_data['resourceId'];
      $dto->roleId = $assignment_data['roleId'];
      $dto->effort = $assignment_data['effort'];
      
      return $dto;
   }
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_PROJECT_GANTT_ASSIGNMENT, $data) ? $data[self::FIELD_ID_PROJECT_GANTT_ASSIGNMENT] : '';
         $this->id_project_gantt_task = array_key_exists(self::FIELD_ID_PROJECT_GANTT_TASK, $data) ? $data[self::FIELD_ID_PROJECT_GANTT_TASK] : '';
         $this->resourceId = array_key_exists(self::FIELD_ID_RESOURCE, $data) ? $data[self::FIELD_ID_RESOURCE] : '';
         $this->roleId = array_key_exists(self::FIELD_ID_PROJECT_GANTT_ROLE, $data) ? $data[self::FIELD_ID_PROJECT_GANTT_ROLE] : '';
         $this->effort = array_key_exists(self::FIELD_EFFORT, $data) ? $data[self::FIELD_EFFORT] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_PROJECT_GANTT_ASSIGNMENT] = $this->id;
      if ($this->id_project_gantt_task !== '')
         $data[self::FIELD_ID_PROJECT_GANTT_TASK] = $this->id_project_gantt_task;
      if ($this->resourceId !== '')
         $data[self::FIELD_ID_RESOURCE] = $this->resourceId;
      if ($this->roleId !== '')
         $data[self::FIELD_ID_PROJECT_GANTT_ROLE] = $this->roleId;
      if ($this->effort !== '')
         $data[self::FIELD_EFFORT] = $this->effort;
      return $data;
   }
}