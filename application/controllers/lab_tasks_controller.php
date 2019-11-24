<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lab_tasks_controller extends CH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_dictionary('ch_labs');
      $this->load_dictionary('ch_lab_tasks');
      $this->load_dictionary('ch_lab_instruments');
      
		$this->load->model(array('labs_model', 'lab_tasks_model'));
      
		$bb[] = array('label' => lang('labs_labs_label'), 'url' => base_url(CH_URL_LABS));
		$this->init_breadcrumb($bb);
      
      $this->add_script('ch_lab_tasks');
	}
   
   private function build_breadcrumb(Lab_DTO $lab, Project_gantt_task_DTO $lab_task) {
      $bb[] = array('label' => $lab->name, 'url' => base_url(CH_URL_LABS.'/edit_lab/'.$lab->id));
      $bb[] = array('label' => lang('labs_lab_tasks_label'), 'url' => base_url(CH_URL_LABS.'/edit_lab/'.$lab->id));
      
      $bb[] = array('label' => $lab_task->name, 'url' => base_url(CH_URL_LAB_TASKS.'/'.$lab_task->id));
      $this->set_breadcrumb($bb);
   }
   
   public function edit_task(/*$id_lab_url = FALSE,*/ $id_lab_task_url = FALSE) {
      $id_lab_task = ($id_lab_task_url === FALSE) ? $this->input->post('id') : $id_lab_task_url;
      $lab_task = $this->lab_tasks_model->get_lab_task($id_lab_task);

      $lab = $this->lab_tasks_model->get_assigned_lab($id_lab_task);
      
      if($lab === FALSE) {
         $this->send_user_message(lang('common_words_not_authorized_msg'), 'error');
         redirect(base_url(CH_URL_MAIN));
      }

      $this->build_breadcrumb($lab, $lab_task);
      
      $this->load->model(array('lab_instruments_model', 'gantt_model'));
      $lab_instruments_list = $this->lab_instruments_model->get_lab_instrument_by_lab($lab->id);
      
      $data = array(
         'lab' => $lab, 
         'back_action_url' => $this->get_back_action_url($lab_task, $lab),
         'lab_task' => $lab_task, 
         'task_is_started' => $lab_task->is_started(),
         'task_is_ended' => $lab_task->is_ended(),
         'enable_task_edit' => !$this->labs_model->open_lab_read_only($lab->id),
         'lab_instruments_list' => $lab_instruments_list
      );
      
      $this->load_page('lab_tasks/edit_lab_task_view', $data);
   }
   
   private function get_back_action_url($lab_task, $lab) {
      $this->load->library('controllers_tracker');
      $previous_controller = $this->controllers_tracker->get_previous_controller();
      if($previous_controller == CH_URL_LABS) {
         $url = base_url(CH_URL_LABS.'/edit_lab/'.$lab->id.'#lab_tasks');
      }
      else if($previous_controller == CH_URL_PROJECTS) {
         $this->load->model(array('lab_instruments_model', 'gantt_model'));
         $gantt = $this->gantt_model->get_by_id($lab_task->id_project_gantt);
         $url = base_url(CH_URL_PROJECTS.'/edit_project/'.$gantt->id_project.'#project_tasks');
      }
      return $url;
   }
   
   public function window_start_task($id_lab_task) {
      $data = array();
      $data['submit_url'] = base_url(CH_URL_LAB_TASKS.'/set_task_start_date/'.$id_lab_task);
      $data['title_dictionary_term'] = 'lab_tasks_start_task_btn_label';
      $data['message_dictionar_term'] = 'lab_tasks_start_task_message';
      
      $this->load->view('_common/select_date_window', $data);
   }

   public function set_task_start_date($id_lab_task) {
      $start_date = $this->input->post('selected_date');
      $result = $this->lab_tasks_model->set_start_date($id_lab_task, $start_date);
      
      $response = ($result === FALSE) ? CH_RESPONSE_FAILURE : CH_RESPONSE_SUCCESS;
      
      $extra = NULL;
      if($result === FALSE) { 
         $m = $this->lab_tasks_model->get_errors();
         $extra = array('message' => $m[0]);
      }
      
      json_response($response, $extra);
   }

   public function window_end_task($id_lab_task) {
      $data = array();
      $data['submit_url'] = base_url(CH_URL_LAB_TASKS.'/set_task_end_date/'.$id_lab_task);
      $data['title_dictionary_term'] = 'lab_tasks_end_task_btn_label';
      $data['message_dictionar_term'] = 'lab_tasks_end_task_message';
      
      $this->load->view('_common/select_date_window', $data);
   }

   public function set_task_end_date($id_lab_task) {
      $end_date = $this->input->post('selected_date');
      $result = $this->lab_tasks_model->set_end_date($id_lab_task, $end_date);
      
      $response = ($result === FALSE) ? CH_RESPONSE_FAILURE : CH_RESPONSE_SUCCESS;
      
      $extra = NULL;
      if($result === FALSE) { 
         $m = $this->lab_tasks_model->get_errors();
         $extra = array('message' => $m[0]);
      }
      
      json_response($response, $extra);
   }

   public function update_task_progress() {
      $id_lab_task = $this->input->post('id_lab_task');
      $progress = $this->input->post('progress');
      
      $response = CH_RESPONSE_FAILURE;
      $extra_data = array('message' => lang('common_words_bad_request_no_redirect_msg'));
      if(is_numeric($id_lab_task) && is_numeric($progress)) {
         if($this->lab_tasks_model->save_lab_task_progress($id_lab_task, $progress)) {
            $response = CH_RESPONSE_SUCCESS;
            $extra_data = NULL;
         }
         else {
            $response = CH_RESPONSE_FAILURE;
            $extra_data['message'] = lang('common_words_data_not_saved_msg');
         }
      }
      
      json_response($response);
   }
   
   public function get_task_instrument_timesheets_table_feed($id_lab_task, $id_lab_instrument = NULL) {
      $this->load->model('lab_instrument_timesheets_model');
      json_output($this->lab_instrument_timesheets_model->get_lab_task_instrument_timesheets_table_feed($id_lab_task, $id_lab_instrument));
   }
   
   public function window_export_timesheets() {
      $id_lab_task =  $this->input->get('id_lab_task');
      
      $data= array();
      $data['submit_url'] = base_url(CH_URL_LAB_TASKS.'/export_task_timesheet_csv/'.$id_lab_task);
      $data['title_dictionary_term'] = 'instruments_get_timesheet_csv_label';
      $this->load->view('_common/select_date_range_window', $data);
   }

   public function export_task_timesheet_csv($id_lab_task) {
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      
      $filters = array();
      
      $filters['id_lab_task'] = $id_lab_task;
      if($start_date) $filters['start_timestamp'] = $start_date;
      if($end_date) $filters['end_timestamp'] = $end_date;
      
      $this->load->model('lab_instrument_timesheets_model');
      $list = $this->lab_instrument_timesheets_model->get_lab_instrument_timesheets_csv_feed($filters);
      
      $full_filename = tempnam(sys_get_temp_dir(), 'csv');
      $fp = fopen($full_filename, 'w');
      foreach ($list as $fields) {
         fputcsv($fp, $fields);
      }

      fclose($fp);
      
      send_file_to_browser($full_filename, 'timesheet.csv');
      unlink($full_filename);
   }

   public function get_lab_task_attachments_table_feed($id_lab_task) {
      $this->load->model('lab_instrument_attachments_model');
      json_output($this->lab_instrument_attachments_model->get_lab_task_attachments_table_feed($id_lab_task));
   }
}
