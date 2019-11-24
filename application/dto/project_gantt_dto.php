<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_gantt_DTO extends DTO {

   const TABLE_NAME = 'project_gantts';
   const FIELD_ID_PROJECT_GANTT = 'id_project_gantt';
   const FIELD_ID_PROJECT = 'id_project';
   const FIELD_NAME = 'name';
   const FIELD_TYPE = 'type';
   
   const TYPE_MANAGER = 10;
   const TYPE_CLIENT = 20;
   
   public $id;
   public $id_project;
   public $name;
   public $type;
   
   public $selectedRow;
   public $canWrite = FALSE;
   public $canWriteOnParent = FALSE;
   public $deletedTaskIds;
   
   public $tasks;
   public $roles;
   public $resources;
   
   static public function parse_gantt_json($json) {
      $class_name = self::class_name();
      $dto = new $class_name();
      $gantt_data = is_string($json) ? json_decode($json, true): $json;
      
      $dto->deletedTaskIds = $gantt_data['deletedTaskIds'];
      foreach ($gantt_data['tasks'] as $idx => $task_array) {
         $task = Project_gantt_task_DTO::parse_gantt_json($task_array);
         $task->order = $idx;
         $dto->tasks[] = $task;
      }
      return $dto;
   }
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
         $this->selectedRow = 0;
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_PROJECT_GANTT, $data) ? $data[self::FIELD_ID_PROJECT_GANTT] : '';
         $this->id_project = array_key_exists(self::FIELD_ID_PROJECT, $data) ? $data[self::FIELD_ID_PROJECT] : '';
         $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
         $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_PROJECT_GANTT] = $this->id;
      if ($this->id_project !== '')
         $data[self::FIELD_ID_PROJECT] = $this->id_project;
      if ($this->name !== '')
         $data[self::FIELD_NAME] = $this->name;
      if ($this->type !== '')
         $data[self::FIELD_TYPE] = $this->type;
      return $data;
   }
}