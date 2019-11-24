<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Projects_model extends CH_Model {
   public function is_unique_project_code($code) {
      $this->db->from(Project_DTO::TABLE_NAME)
         ->where(Project_DTO::FIELD_CODE, $code);
      
      $results = $this->_get_list();
      return count($results) == 0;
   }
   
   public function save(Project_DTO $project) {
      $this->load->model('gantt_model');
      $response = FALSE;
      $this->db->trans_start();
      if($project->id == '') {
         $response = $this->_insert(Project_DTO::TABLE_NAME, $project->get_data_for_db());
         if($response !== FALSE) {
            $this->gantt_model->add_gantt($response, Project_gantt_DTO::TYPE_MANAGER);
            $this->gantt_model->add_gantt($response, Project_gantt_DTO::TYPE_CLIENT);
         }
      }
      else {
         $this->db->where(Project_DTO::FIELD_ID_PROJECT, $project->id);
         $response = $this->db->update(Project_DTO::TABLE_NAME, $project->get_data_for_db());
      }
      $this->db->trans_complete();
      
      return $response;
   }

   public function create_new_project_email($id_project) {
      $prj = $this->get_project($id_project);
      $email = array(
         'from' => CH_EMAIL_NOREPLY,
         'to' => $prj->project_leader->email,
         'subject' => lang('projects_new_project_email_subject', $prj->name."({$prj->code})"),
         'message' => lang('projects_new_project_email_body', $prj->name."({$prj->code})")
      );
      return $email;
   }
   
   public function get_project($id_project) {
      $this->load->model(array('clients_model', 'users_model'));
      
      $this->db->from(Project_DTO::TABLE_NAME)
         ->where(Project_DTO::FIELD_ID_PROJECT, $id_project);
      $project = $this->_get(Project_DTO::class_name(), FALSE);
      
      if($project !== FALSE) {
         $project->client = $this->clients_model->get_client($project->id_client);
         $project->project_leader = $this->users_model->get_user($project->id_project_leader);
      }
      
      return $project;
   }
   
   public function get_project_table_feed() {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => Project_DTO::FIELD_ID_PROJECT, 'dt' => 'id'),
         array('db' => Project_DTO::FIELD_NAME, 'dt' => 'name'),
         array('db' => Project_DTO::FIELD_CODE, 'dt' => 'code'),
         array('db' => 'u.'.User_DTO::FIELD_FULLNAME.' project_leader', 'dt' => 'project_leader'),
         array('db' => 'c.'.Client_data_DTO::FIELD_FULLNAME.' client_name', 'dt' => 'client')
      );
      
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Project_DTO::TABLE_NAME.' p');
      $this->datatable_response_builder->add_join_clauses(Client_data_DTO::TABLE_NAME.' c', 'c.'.Client_data_DTO::FIELD_USER_ID.' = p.'.Project_DTO::FIELD_ID_CLIENT);
      $this->datatable_response_builder->add_join_clauses(User_DTO::TABLE_NAME.' u', 'u.'.User_DTO::FIELD_IDUSER.' = p.'.Project_DTO::FIELD_ID_PROJECT_LEADER);
      if(!$this->bitauth->has_role(CH_ROLE_PROJECT_AREA_FULL_PROJECTS_LIST))
         $this->datatable_response_builder->add_where_clauses(array('p.'.Project_DTO::FIELD_ID_PROJECT_LEADER => $this->bitauth->user_id));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_task_with_assignments_table_feed($id_project) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'dt' => 'id'),
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_NAME, 'dt' => 'name'),
         array('db' => 'l.'.Lab_DTO::FIELD_NAME.' lab_name', 'dt' => 'lab'),
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_START, 'dt' => 'start', 'formatter' => 'millis_to_date'),
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_END, 'dt' => 'end', 'formatter' => 'millis_to_date'),
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_ACTUAL_START_DATE, 'dt' => 'actual_start'),
         array('db' => 't.'.Project_gantt_task_DTO::FIELD_ACTUAL_END_DATE, 'dt' => 'actual_end')
      );
      
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Project_gantt_task_DTO::TABLE_NAME.' t');
      $this->datatable_response_builder->add_join_clauses(Project_gantt_DTO::TABLE_NAME.' p', 'p.'.Project_gantt_DTO::FIELD_ID_PROJECT_GANTT.' = t.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT);
      $this->datatable_response_builder->add_join_clauses(Project_gantt_assignment_DTO::TABLE_NAME.' a', 'a.'.Project_gantt_assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK.' = t.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK);
      $this->datatable_response_builder->add_join_clauses(Lab_DTO::TABLE_NAME.' l', 'l.'.Lab_DTO::FIELD_ID_LAB.' = a.'.Project_gantt_assignment_DTO::FIELD_ID_RESOURCE);
      $this->datatable_response_builder->add_where_clauses(array('p.'.Project_gantt_DTO::FIELD_ID_PROJECT => $id_project));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function is_project_leader($id_project, $id_project_leader = FALSE) {
      $id_pl = ($id_project_leader === FALSE) ? $this->bitauth->user_id : $id_project_leader;
      
      $this->db->from(Project_DTO::TABLE_NAME)
         ->where(Project_DTO::FIELD_ID_PROJECT, $id_project)
         ->where(Project_DTO::FIELD_ID_PROJECT_LEADER,$id_pl);
      $res = $this->_get(NULL, FALSE);
      
      return $res !== FALSE;
   }
   
   public function set_start_date($id_project, $start_date) {
      $project = $this->get_project($id_project);
      if($project === FALSE) {
         $this->set_error('Il progetto richiesto non esiste.');
         return FALSE;
      }
      if($project->is_started()) {
         $this->set_error('Il progetto è già stato avviato.');
         return FALSE;
      }
      
      return $this->db->where(Project_DTO::FIELD_ID_PROJECT, $id_project)
         ->update(Project_DTO::TABLE_NAME, array(Project_DTO::FIELD_START_DATE => normal_to_db_date($start_date)));
   }
   
   public function set_end_date($id_project, $end_date) {
      $project = $this->get_project($id_project);
      if($project === FALSE) {
         $this->set_error('Il progetto richiesto non esiste.');
         return FALSE;
      }
      if($project->is_ended()) {
         $this->set_error('Il progetto è già stato avviato.');
         return FALSE;
      }
      
      return $this->db->where(Project_DTO::FIELD_ID_PROJECT, $id_project)
         ->update(Project_DTO::TABLE_NAME, array(Project_DTO::FIELD_END_DATE => normal_to_db_date($end_date)));
   }
   
   /**
    * Sulla base dello stato del progetto e dell'utente connesso abilita la modifica dei dati di un progetto
    * @param mixed $id_project id di un progetto oppure un oggetto di tipo Project_DTO
    * @return boolean TRUE indica che il progetto può essere modificato dall'utente indicato.
    */
   public function open_project_read_only($id_project) {
      if(!is_numeric($id_project)) return TRUE;
      
      if($this->bitauth->has_role(CH_ROLE_POWERUSER)) return FALSE;
      //Se l'utente è il project manager o un power user può modificare il progetto
      if($this->bitauth->has_role(CH_ROLE_PROJECT_AREA_MANAGE_PROJECT) && $this->is_project_leader($id_project)) return FALSE;
      
      return TRUE;
   }
}