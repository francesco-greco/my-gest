<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project_gantt_task_DTO extends DTO {

   const TABLE_NAME = 'project_gantt_tasks';
   const FIELD_ID_PROJECT_GANTT_TASK = 'id_project_gantt_task';
   const FIELD_ID_PROJECT_GANTT = 'id_project_gantt';
   const FIELD_NAME = 'name';
   const FIELD_CODE = 'code';
   const FIELD_DESCRIPTION = 'description';
   const FIELD_PROGRESS = 'progress';
   const FIELD_LEVEL = 'level';
   const FIELD_STATUS = 'status';
   const FIELD_START = 'start';
   const FIELD_DURATION = 'duration';
   const FIELD_END = 'end';
   const FIELD_ACTUAL_START_DATE = 'actual_start_date';
   const FIELD_ACTUAL_END_DATE = 'actual_end_date';
   const FIELD_STARTISMILESTONE = 'startIsMilestone';
   const FIELD_ENDISMILESTONE = 'endIsMilestone';
   const FIELD_HASCHILD = 'hasChild';
   const FIELD_DEPENDS = 'depends';
   const FIELD_COLLAPSED = 'collapsed';
   const FIELD_DELETED = 'deleted';
   const FIELD_ORDER = 'order';
   
   public $id;
   public $id_project_gantt;
   public $name;
   public $code;
   public $description;
   public $progress;
   public $level;
   public $status;
   public $start;
   public $duration;
   public $end;
   public $actual_start_date;
   public $actual_end_date;
   public $startIsMilestone;
   public $endIsMilestone;
   public $hasChild;
   public $depends;
   public $collapsed;
   public $deleted;
   public $order;
   
   public $assigs = array();
   public $project;
   
   public $canWrite = FALSE;
   
   static public function parse_gantt_json($json) {
      $class_name = self::class_name();
      $tasks_data = is_string($json) ? json_decode($json, true): $json;
      
      $dto = new $class_name();
      $dto->id = is_numeric($tasks_data['id']) ? $tasks_data['id'] : '';
      $dto->name = $tasks_data['name'];
      $dto->code = $tasks_data['code'];
      $dto->level = $tasks_data['level'];
      $dto->status = $tasks_data['status'];
      $dto->start = $tasks_data['start'];
      $dto->duration = $tasks_data['duration'];
      $dto->end = $tasks_data['end'];
      $dto->startIsMilestone = $tasks_data['startIsMilestone'];
      $dto->endIsMilestone = $tasks_data['endIsMilestone'];
      if(array_key_exists('collapsed', $tasks_data)) $dto->collapsed = $tasks_data['collapsed'];
      $dto->hasChild = $tasks_data['hasChild'];
      $dto->description = $tasks_data['description'];
      $dto->progress = $tasks_data['progress'];
      $dto->depends = $tasks_data['depends'];
      $dto->assigs = array();
      foreach ($tasks_data['assigs'] as $assigment_data) {
         $dto->assigs[] = Project_gantt_assignment_DTO::parse_gantt_json($assigment_data);
      }
      return $dto;
   }
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
         $this->startIsMilestone = FALSE;
         $this->endIsMilestone = FALSE;
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_PROJECT_GANTT_TASK, $data) ? $data[self::FIELD_ID_PROJECT_GANTT_TASK] : '';
         $this->id_project_gantt = array_key_exists(self::FIELD_ID_PROJECT_GANTT, $data) ? $data[self::FIELD_ID_PROJECT_GANTT] : '';
         $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
         $this->code = array_key_exists(self::FIELD_CODE, $data) ? $data[self::FIELD_CODE] : '';
         $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
         $this->progress = array_key_exists(self::FIELD_PROGRESS, $data) ? $data[self::FIELD_PROGRESS] : '';
         $this->level = array_key_exists(self::FIELD_LEVEL, $data) ? $data[self::FIELD_LEVEL] : '';
         $this->status = array_key_exists(self::FIELD_STATUS, $data) ? $data[self::FIELD_STATUS] : '';
         $this->start = array_key_exists(self::FIELD_START, $data) ? $data[self::FIELD_START] : '';
         $this->duration = array_key_exists(self::FIELD_DURATION, $data) ? $data[self::FIELD_DURATION] : '';
         $this->end = array_key_exists(self::FIELD_END, $data) ? $data[self::FIELD_END] : '';
         $this->actual_start_date = array_key_exists(self::FIELD_ACTUAL_START_DATE, $data) ? db_to_normal_date($data[self::FIELD_ACTUAL_START_DATE]) : '';
         $this->actual_end_date = array_key_exists(self::FIELD_ACTUAL_END_DATE, $data) ? db_to_normal_date($data[self::FIELD_ACTUAL_END_DATE]) : '';
         $this->startIsMilestone = array_key_exists(self::FIELD_STARTISMILESTONE, $data) ? (boolean) $data[self::FIELD_STARTISMILESTONE] : FALSE;
         $this->endIsMilestone = array_key_exists(self::FIELD_ENDISMILESTONE, $data) ? (boolean) $data[self::FIELD_ENDISMILESTONE] : FALSE;
         $this->hasChild = array_key_exists(self::FIELD_HASCHILD, $data) ? (boolean) $data[self::FIELD_HASCHILD] : FALSE;
         $this->depends = array_key_exists(self::FIELD_DEPENDS, $data) ? $data[self::FIELD_DEPENDS] : '';
         $this->collapsed = array_key_exists(self::FIELD_COLLAPSED, $data) ? (boolean) $data[self::FIELD_COLLAPSED] : FALSE;
         $this->deleted = array_key_exists(self::FIELD_DELETED, $data) ? $data[self::FIELD_DELETED] : '';
         $this->order = array_key_exists(self::FIELD_ORDER, $data) ? $data[self::FIELD_ORDER] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_PROJECT_GANTT_TASK] = $this->id;
      if ($this->id_project_gantt !== '')
         $data[self::FIELD_ID_PROJECT_GANTT] = $this->id_project_gantt;
      if ($this->name !== '')
         $data[self::FIELD_NAME] = $this->name;
      if ($this->code !== '')
         $data[self::FIELD_CODE] = $this->code;
      if ($this->description !== '')
         $data[self::FIELD_DESCRIPTION] = $this->description;
      if ($this->progress !== '')
         $data[self::FIELD_PROGRESS] = $this->progress;
      if ($this->level !== '')
         $data[self::FIELD_LEVEL] = $this->level;
      if ($this->status !== '')
         $data[self::FIELD_STATUS] = $this->status;
      if ($this->start !== '')
         $data[self::FIELD_START] = $this->start;
      if ($this->duration !== '')
         $data[self::FIELD_DURATION] = $this->duration;
      if ($this->end !== '')
         $data[self::FIELD_END] = $this->end;
      if ($this->actual_start_date !== '')
         $data[self::FIELD_ACTUAL_START_DATE] = normal_to_db_date ($this->actual_start_date);
      if ($this->actual_end_date !== '')
         $data[self::FIELD_ACTUAL_END_DATE] = normal_to_db_date ($this->actual_end_date);
      if ($this->startIsMilestone !== '')
         $data[self::FIELD_STARTISMILESTONE] = $this->startIsMilestone;
      if ($this->endIsMilestone !== '')
         $data[self::FIELD_ENDISMILESTONE] = $this->endIsMilestone;
      if ($this->hasChild !== '')
         $data[self::FIELD_HASCHILD] = $this->hasChild;
      if ($this->depends !== '')
         $data[self::FIELD_DEPENDS] = $this->depends;
      if ($this->collapsed !== '')
         $data[self::FIELD_COLLAPSED] = $this->collapsed;
      if ($this->deleted !== '')
         $data[self::FIELD_DELETED] = $this->deleted;
      if ($this->order !== '')
         $data[self::FIELD_ORDER] = $this->order;
      return $data;
   }
   
   public function is_started() {
      return $this->actual_start_date && $this->actual_start_date != NULL_DB_DATE.' '.NULL_DB_TIME;
   }

   public function is_ended() {
      return $this->actual_end_date && $this->actual_end_date != NULL_DB_DATE.' '.NULL_DB_TIME;
   }

   
}