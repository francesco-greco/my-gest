<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Project_gantt_DTO as Gantt_DTO;
use Project_gantt_task_DTO as Task_DTO;
use Project_gantt_assignment_DTO as Assignment_DTO;
use Project_gantt_role_DTO as Role_DTO;

class Gantt_model extends CH_Model {
   private function get($id_project, $type, $can_write = FALSE) {
      $this->db->trans_start();
      
      $this->db->from(Gantt_DTO::TABLE_NAME)
         ->where(array(
            Gantt_DTO::FIELD_TYPE => $type,
            Gantt_DTO::FIELD_ID_PROJECT => $id_project
         ));
      
      $gantt = $this->_get(Gantt_DTO::class_name());

      $gantt->canWrite = $can_write;
      $gantt->canWriteOnParent = $can_write;
      $gantt->tasks = $this->get_tasks($gantt->id, $can_write);
      $gantt->roles = $this->get_roles();
      $gantt->resources = $this->get_resources();
      
      return $gantt;
   }
   
   public function get_by_id($id_gantt) {
      $this->db->from(Gantt_DTO::TABLE_NAME)
         ->where(Gantt_DTO::FIELD_ID_PROJECT_GANTT, $id_gantt);
      
      return $this->_get(Gantt_DTO::class_name());
   }
   
   public function get_tasks($id_project_gantt, $can_write = FALSE) {
      $this->db->from(Task_DTO::TABLE_NAME)
         ->where(Task_DTO::FIELD_ID_PROJECT_GANTT, $id_project_gantt)
         ->order_by(Task_DTO::FIELD_ORDER);
      $tasks = $this->_get_list(Task_DTO::class_name());
      foreach($tasks as $idx => $t) {
         $tasks[$idx]->canWrite = $can_write;
         $tasks[$idx]->assigs = $this->get_task_assignments($t->id);
      }
      return $tasks;
   }
   
   public function get_task_assignments($id_task) {
      $this->db->from(Assignment_DTO::TABLE_NAME)
         ->where(Assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_task);
      return $this->_get_list(Assignment_DTO::class_name());
   }
   
   public function get_roles() {
      $this->db->from(Role_DTO::TABLE_NAME)
         ->where(Role_DTO::FIELD_ENABLED, 1)
         ->order_by(Role_DTO::FIELD_NAME);
      return $this->_get_list(Role_DTO::class_name());
   }
   
   public function get_resources() {
      $this->load->model('labs_model');
      return $this->labs_model->get_labs();
   }
   
   public function get_client_gantt($id_project, $can_write = FALSE) {
      return $this->get($id_project, Gantt_DTO::TYPE_CLIENT, $can_write);
   }
   
   public function get_manager_gantt($id_project, $can_write = FALSE) {
      return $this->get($id_project, Gantt_DTO::TYPE_MANAGER, $can_write);
   }
   
   public function save_gantt(Gantt_DTO $gantt) {
      $this->db->trans_start();
      $this->db->from(Gantt_DTO::TABLE_NAME)
         ->where(array(
            Gantt_DTO::FIELD_TYPE => $gantt->type,
            Gantt_DTO::FIELD_ID_PROJECT => $gantt->id_project
         ));
      
      $gantt_db = $this->_get(Gantt_DTO::class_name());
      
      $this->delete_tasks($gantt->deletedTaskIds);
      
      foreach($gantt->tasks as $task_dto) {
         $task_dto->id_project_gantt = $gantt_db->id;
         $this->save_task($task_dto);
      }
      $this->db->trans_complete();
      
      return $this->db->trans_status();
   }
   
   public function add_gantt($id_project, $type) {
      $gantt = new Project_gantt_DTO();
      $gantt->id_project = $id_project;
      $gantt->type = $type;
      
      return $this->_insert(Gantt_DTO::TABLE_NAME, $gantt->get_data_for_db());
   }
   
   public function save_task(Task_DTO $task_dto) {
      $response = FALSE;
      $this->db->trans_start();
      if($task_dto->id == '') {
         $response = $this->_insert(Task_DTO::TABLE_NAME, $task_dto->get_data_for_db());
         if($response !== FALSE) $task_dto->id = $response;
      }
      else {
         $response = $this->db->where(Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, $task_dto->id)
            ->update(Task_DTO::TABLE_NAME, $task_dto->get_data_for_db());
      }
      
      if(count($task_dto->assigs) == 0) {
         $response = $response && $this->delete_assignments ($task_dto->id);
      }
      else {
         $response = $response && $this->save_assignments($task_dto->id, $task_dto->assigs);
      }
      
      $this->db->trans_complete();
      
      return $this->db->trans_status() && $response;
   }
   
   public function delete_tasks($id_tasks) {
      $where_in = is_array($id_tasks) ? $id_tasks : array($id_tasks);
      if(count($where_in) == 0) return TRUE;
      
      $this->db->trans_start();
      
      $this->db->where_in(Assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK, $where_in)
         ->delete(Assignment_DTO::TABLE_NAME);
      
      $this->db->where_in(Task_DTO::FIELD_ID_PROJECT_GANTT_TASK, $where_in)
         ->delete(Task_DTO::TABLE_NAME);
      
      $this->db->trans_complete();
      return $this->db->trans_status();
   }
   
   public function delete_assignments($id_task) {
      return $this->db->where(Assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_task)
            ->delete(Assignment_DTO::TABLE_NAME);
   }
   
   public function save_assignments($id_task, $assignments) {
      if(empty($assignments)) return TRUE;
      
      $do_not_delete = array();
      foreach($assignments as $assignment) {
         if($assignment->id != '') {
            $do_not_delete[] = $assignment->id;
         }
      }
      
      //cancello tutte le assegnazioni non presenti tra quelle inviate dal client
      if(count($do_not_delete) > 0) {
         $this->db->where_not_in(Assignment_DTO::FIELD_ID_PROJECT_GANTT_ASSIGNMENT ,$do_not_delete)
            ->where(Assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK, $id_task)
            ->delete(Assignment_DTO::TABLE_NAME);
      }
      
      foreach($assignments as $assignment) {
         $assignment->id_project_gantt_task = $id_task;
         $this->save_assignment($assignment);
      }
   }
   
   public function save_assignment(Assignment_DTO $assignment_dto) {
      $response = FALSE;
      if(!is_numeric($assignment_dto->id)) {
         $assignment_dto->id = '';
         $response = $this->_insert(Assignment_DTO::TABLE_NAME, $assignment_dto->get_data_for_db());
      }
      else {
         $response = $this->db->where(Assignment_DTO::FIELD_ID_PROJECT_GANTT_ASSIGNMENT, $assignment_dto->id)
            ->update(Assignment_DTO::TABLE_NAME, $assignment_dto->get_data_for_db());
      }
      
      return $response !== FALSE;
   }
}
