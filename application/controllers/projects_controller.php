<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects_controller extends CH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_dictionary('ch_projects');
      $this->load_dictionary('ch_lab_instruments');
		
		$bb[] = array('label' => lang('projects_projects_label'), 'url' => base_url(CH_URL_PROJECTS));
		$this->init_breadcrumb($bb);
      
		$this->add_frontend_module('ch_projects');

      $this->load->model('projects_model');
	}
   
   public function index() {
      $data = array();
      $data['enable_create_prj_btn'] = $this->bitauth->has_role(CH_ROLE_PROJECT_AREA_CREATE_PROJECT);
      $data['enable_manage_prj_btn'] = $this->bitauth->has_role(CH_ROLE_PROJECT_AREA_MANAGE_PROJECT);
      $this->load_page('projects/projects_view', $data);
   }
   
   public function window_new_project() {
      $this->load->model(array('clients_model', 'users_model'));
      
      $data = array();
      $data['clients'] = $this->clients_model->get_clients();
      $data['leaders'] = $this->users_model->get_project_leaders();
      
      $this->load->view('projects/new_project_window', $data);
   }

   public function check_project_code() {
      $code = $this->input->get('project_code');

      json_output($this->projects_model->is_unique_project_code($code));
   }

   public function save_project() {
      $project = Project_DTO::raccogli_dati_request('project');
      
      $response = $this->projects_model->save($project);
      
      $extra_data = NULL;
      if($response !== FALSE) {
         $extra_data = array('id' => $response);
         $email = $this->projects_model->create_new_project_email($response);
         if(!$this->send_email($email)) $extra_data['error'] = lang ('common_words_email_not_sent_msg');
      }
      
      json_response($response !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE, $extra_data);
   }
   
   public function window_start_project($id_project) {

      $data = array();
      $data['id_project'] = $id_project;
      $data['submit_url'] = base_url(CH_URL_PROJECTS.'/set_project_start_date/'.$id_project);
      $data['title_dictionary_term'] = 'projects_start_project_btn_label';
      $data['message_dictionar_term'] = 'projects_start_project_message';
      
      $this->load->view('_common/select_date_window', $data);
   }

   public function set_project_start_date($id_project) {
      if($this->projects_model->open_project_read_only($id_project)) {
         json_response(CH_RESPONSE_FAILURE, array('message' => 'Non hai i diritti di modifica del progetto'));
         return;
      }
      
      $start_date = $this->input->post('selected_date');
      $result = $this->projects_model->set_start_date($id_project, $start_date);
      
      $response = ($result === FALSE) ? CH_RESPONSE_FAILURE : CH_RESPONSE_SUCCESS;
      
      $extra = NULL;
      if($result === FALSE) { 
         $m = $this->projects_model->get_errors();
         $extra = array('message' => $m[0]);
      }
      
      json_response($response, $extra);
   }

   public function window_end_project($id_project) {

      $data = array();
      $data['id_project'] = $id_project;
      $data['submit_url'] = base_url(CH_URL_PROJECTS.'/set_project_end_date/'.$id_project);
      $data['title_dictionary_term'] = 'projects_end_project_btn_label';
      $data['message_dictionar_term'] = 'projects_end_project_message';
      
      $this->load->view('_common/select_date_window', $data);
   }

   public function set_project_end_date($id_project) {
      if($this->projects_model->open_project_read_only($id_project)) {
         json_response(CH_RESPONSE_FAILURE, array('message' => 'Non hai i diritti di modifica del progetto'));
         return;
      }
      
      $end_date = $this->input->post('selected_date');
      $result = $this->projects_model->set_end_date($id_project, $end_date);
      
      $response = ($result === FALSE) ? CH_RESPONSE_FAILURE : CH_RESPONSE_SUCCESS;
      
      $extra = NULL;
      if($result === FALSE) { 
         $m = $this->projects_model->get_errors();
         $extra = array('message' => $m[0]);
      }
      
      json_response($response, $extra);
   }

   public function edit_project($id_project_url = FALSE) {
      $id_project = ($id_project_url === FALSE) ? $this->input->post('id') : $id_project_url;
      
      $project = $this->projects_model->get_project($id_project);
      $data = array(
         'project' => $project,
         'project_is_started' => $project->is_started(),
         'project_is_ended' => $project->is_ended(),
         'open_read_only' => $this->projects_model->open_project_read_only($id_project)
      );
      
      $this->set_breadcrumb( array('label' => $data['project']->name, 'url' => ''));
      $this->load_page('projects/edit_project_view', $data);
   }

   public function get_project_table_feed(){
      $output = $this->projects_model->get_project_table_feed();
		json_output($output);
   }
   
   public function get_project_tasks_with_assignments_table_feed($id_project) {
      $output = $this->projects_model->get_task_with_assignments_table_feed($id_project);
		json_output($output);
   }
   
   public function get_project_attachments_table_feed($id_project) {
      $this->load->model('project_attachments_model');
      $output = $this->project_attachments_model->get_project_attachments_table_feed($id_project);
		json_output($output);
   }
   
   public function window_edit_project_attachment($id_attachment = FALSE) {
//      $project = $this->projects_model->get_project($this->input->get('id_project'));
      
      $this->load->model('project_attachments_model');
      
      $data = array(
         'attachment' => ($id_attachment !== FALSE) ? $this->project_attachments_model->get_attachment($id_attachment) : new Project_attachment_DTO(),
         'attachment_categories' => $this->project_attachments_model->get_attachment_categories(),
         'id_project' => $this->input->get('id_project')
      );
      $this->load->view('projects/new_project_attachment_window', $data);
   }
   
   public function save_project_attachment() {
      $this->load->model('project_attachments_model');
      
      $attachment = Project_attachment_DTO::raccogli_dati_request('attachment');
      $archiver = new CH_Project_Attachment_Archiver();
      if($archiver->upload_file('attachment_filename')) {
         $filename = $archiver->archive_file();
         if($filename !== FALSE) {
            $attachment->id_user = $this->bitauth->user_id;
            $attachment->filename = $filename;
            $attachment->original_filename = $archiver->get_original_filename();
            $res = $this->project_attachments_model->save($attachment);
         }
         else {
            $res = FALSE;
         }

         json_response($res !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
      }
      else {
         json_response(CH_RESPONSE_FAILURE);
      }
   }
   
   public function share_project_attachment() {
      $this->load->model('attachments_model');
      
      $id_attachment = $this->input->post('id_attachment');
      $attachment = $this->attachments_model->get_attachment($id_attachment);
      
      $model_name = FALSE;
      switch($attachment->type) {
         case Attachment_DTO::TYPE_INSTRUMENT: $model_name = 'lab_instrument_attachments_model'; break;
         case Attachment_DTO::TYPE_PROJECT: $model_name = 'project_attachments_model'; break;
      }
      
      $this->load->model($model_name);
      if($this->$model_name->is_attachment_access_granted($id_attachment)) {
         $attachment->share = $attachment->share == 1 ? 0 : 1;
         $this->attachments_model->save($attachment);
         
         json_response(CH_RESPONSE_SUCCESS);
      }
      else {
         json_response(CH_RESPONSE_FAILURE, array('message' => "Non si hanno sufficienti diritti per accedere all'allegato."));
      }
   }
   
   /**********************
    * START GANTT ACTION *
    **********************/

   
   public function project_gantt($id_project) {
      $this->load_dictionary('ch_gantt');
      $this->load->model('labs_model');
      
      $data = array();
      $data['base_url'] = $this->config->item('base_url');
      $data['project'] = $this->projects_model->get_project($id_project);
      $data['dictionary'] = $this->get_loaded_dictionary();

      $this->load->view('projects/gantt', $data);
   }
   
   public function ajax_load_manager_gantt($id_project) {
      $this->load->model('gantt_model');
      $can_write = !$this->projects_model->open_project_read_only($id_project);
      $gantt = $this->gantt_model->get_manager_gantt($id_project, $can_write);
      $gantt->selectedRow = 0;
      json_output(array('ok' => TRUE, 'project' => $gantt));
   }
   
   public function ajax_save_manager_gantt($id_project) {
      $this->load->model('gantt_model');
      $json = $this->input->post('prj');
      
      $gantt_dto = Project_gantt_DTO::parse_gantt_json($json);
      $gantt_dto->id_project = $id_project;
      $gantt_dto->type = Project_gantt_DTO::TYPE_MANAGER;
      
      $this->gantt_model->save_gantt($gantt_dto);
      $can_write = $this->bitauth->is_admin() || $this->projects_model->is_project_leader($id_project);
      json_output(array('ok' => TRUE, 'project' => $this->gantt_model->get_manager_gantt($id_project, $can_write)));
   }
   /**********************
    * START GANTT ACTION *
    **********************/
}