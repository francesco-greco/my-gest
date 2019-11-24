<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Project_gantt_task_DTO as Task_DTO;
class Lab_tasks_model extends CH_Model {

   public function get_lab_task($id_lab_task) {
      $this->db->select('tsk.*, pgt.'.Project_gantt_DTO::FIELD_ID_PROJECT)
         ->from(Task_DTO::TABLE_NAME.' tsk')
         ->join(Project_gantt_DTO::TABLE_NAME.' pgt', 'pgt.'.Project_gantt_DTO::FIELD_ID_PROJECT_GANTT.' = tsk.'.Task_DTO::FIELD_ID_PROJECT_GANTT)
         ->where(Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_lab_task);
      
      $row = $this->_get(NULL, FALSE);
      if($row === FALSE) return FALSE;
      
      $task = new Task_DTO($row);
      
      $this->load->model('projects_model');
      $task->project = $this->projects_model->get_project($row[Project_gantt_DTO::FIELD_ID_PROJECT]);
      return $task;
   }
   
   public function save_lab_task_progress($id_lab_task, $progress) {
      $this->load->model('gantt_model');
      
      $lab_task = new Project_gantt_task_DTO();
      $lab_task->id = $id_lab_task;
      $lab_task->progress = $progress;
      
      return $this->gantt_model->save_task($lab_task);
   }
   
   public function get_lab_tasks($id_lab, $started= NULL, $ended=NULL) {
      $this->db->from(Task_DTO::TABLE_NAME.' t')
         ->join(Project_gantt_assignment_DTO::TABLE_NAME.' a', 'a.'.Project_gantt_assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK.' = t.'.Task_DTO::FIELD_ID_PROJECT_GANTT_TASK)
         ->where(array('a.'.Project_gantt_assignment_DTO::FIELD_ID_RESOURCE => $id_lab));
      if($started !== NULL) {
         if($started === FALSE) {
            $this->db->where('(t.'.Task_DTO::FIELD_ACTUAL_START_DATE." = '".NULL_DB_DATE.' '.NULL_DB_TIME."' OR t.".Task_DTO::FIELD_ACTUAL_START_DATE.' IS NULL)');
         }
         else {
            $this->db->where('(t.'.Task_DTO::FIELD_ACTUAL_START_DATE." <> '".NULL_DB_DATE.' '.NULL_DB_TIME."' AND t.".Task_DTO::FIELD_ACTUAL_START_DATE.' IS NOT NULL)');
         }
      }
      if($ended !== NULL) {
         if($ended === FALSE) {
            $this->db->where('(t.'.Task_DTO::FIELD_ACTUAL_END_DATE." = '".NULL_DB_DATE.' '.NULL_DB_TIME."' OR t.".Task_DTO::FIELD_ACTUAL_END_DATE.' IS NULL)');
         }
         else {
            $this->db->where('(t.'.Task_DTO::FIELD_ACTUAL_END_DATE." <> '".NULL_DB_DATE.' '.NULL_DB_TIME."' AND t.".Task_DTO::FIELD_ACTUAL_END_DATE.' IS NOT NULL)');
         }
      }
      return $this->_get_list(Task_DTO::class_name());
   }
   
   public function get_assigned_lab($id_lab_task) {
      $this->db->from(Task_DTO::TABLE_NAME.' t')
         ->join(Project_gantt_assignment_DTO::TABLE_NAME.' a', 'a.'.Project_gantt_assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK.' = t.'.Task_DTO::FIELD_ID_PROJECT_GANTT_TASK)
         ->where(array('t.'.Task_DTO::FIELD_ID_PROJECT_GANTT_TASK => $id_lab_task));
      
//      $assignment = new Project_gantt_assignment_DTO();
      $assignment = $this->_get(Project_gantt_assignment_DTO::class_name(), FALSE);

      if($assignment === FALSE) return FALSE;
      
      $this->load->model('labs_model');
      
      return $this->labs_model->get_lab($assignment->resourceId);
   }
   
   public function get_lab_tasks_table_feed($id_lab) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => 't.'.Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'dt' => 'id'),
         array('db' => 't.'.Task_DTO::FIELD_NAME, 'dt' => 'name'),
         array('db' => 'p.'.Project_DTO::FIELD_NAME.' project_name', 'dt' => 'project_name'),
         array('db' => Task_DTO::FIELD_START, 'dt' => 'start_date', 'formatter' => 'millis_to_date'),
         array('db' => Task_DTO::FIELD_END, 'dt' => 'end_date', 'formatter' => 'millis_to_date'),
         array('db' => Task_DTO::FIELD_PROGRESS, 'dt' => 'progress')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Task_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Project_gantt_assignment_DTO::TABLE_NAME.' a', 'a.'.Project_gantt_assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK.' = t.'.Task_DTO::FIELD_ID_PROJECT_GANTT_TASK)
         ->add_join_clauses(Project_gantt_DTO::TABLE_NAME.' g', 'g.'.Project_gantt_DTO::FIELD_ID_PROJECT_GANTT.' = t.'.Task_DTO::FIELD_ID_PROJECT_GANTT)
         ->add_join_clauses(Project_DTO::TABLE_NAME.' p', 'p.'.Project_DTO::FIELD_ID_PROJECT.' = g.'.Project_gantt_DTO::FIELD_ID_PROJECT)
         ->add_where_clauses('a.'.Project_gantt_assignment_DTO::FIELD_ID_RESOURCE, $id_lab);
         //se si è capo laboratori si possono vedere tutti le attività i cui progetti sono avviati e modificare solo quelli conclusi
         if($this->bitauth->has_role(CH_ROLE_LAB_AREA_CHIEF)) {
            $this->datatable_response_builder->add_where_clauses('(p.'.Project_DTO::FIELD_START_DATE.' IS NOT NULL OR p.'.Project_DTO::FIELD_START_DATE.' <> "'.NULL_DB_DATE.' '.NULL_DB_TIME.'")');
         }
         
         //Oppure gli operatori possono vedere quelle attività che sono stati avviati dal capo laboratorio e non ancora concluse
         if($this->bitauth->has_role(CH_ROLE_LAB_AREA_OPERATOR) && !$this->bitauth->has_role(CH_ROLE_LAB_AREA_CHIEF)) {
            $this->datatable_response_builder->add_where_clauses('(t.'.Task_DTO::FIELD_ACTUAL_START_DATE.' IS NOT NULL OR t.'.Task_DTO::FIELD_ACTUAL_START_DATE.' <> "'.NULL_DB_DATE.' '.NULL_DB_TIME.'")');
         };
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function set_start_date($id_lab_task, $start_date) {
      $lab_task = $this->get_lab_task($id_lab_task);
      if($lab_task === FALSE) {
         $this->set_error("L'attività richiesta non esiste.");
         return FALSE;
      }
      if($lab_task->is_started()) {
         $this->set_error("L'attività è già stata avviata.");
         return FALSE;
      }
      
      return $this->db->where(Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_lab_task)
         ->update(Task_DTO::TABLE_NAME, array(Task_DTO::FIELD_ACTUAL_START_DATE => normal_to_db_date($start_date)));
   }
   
   public function is_task_access_granted($id_lab_task) {
      //se è il capoprogetto, se è un operatore o responsabile del laboratorio assegnato, se è amministratore
      $grant = $this->bitauth->is_admin();
      
      return $grant;
   }
   
   public function set_end_date($id_lab_task, $end_date) {
      $lab_task = $this->get_lab_task($id_lab_task);
      if($lab_task === FALSE) {
         $this->set_error("L'attività richiesta non esiste.");
         return FALSE;
      }
      if($lab_task->is_ended()) {
         $this->set_error("L'attività è già stata conclusa.");
         return FALSE;
      }
      
      return $this->db->where(Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_lab_task)
         ->update(Task_DTO::TABLE_NAME, array(Task_DTO::FIELD_ACTUAL_END_DATE => normal_to_db_date($end_date)));
   }
}
