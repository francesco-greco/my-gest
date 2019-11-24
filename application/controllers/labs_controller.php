<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Labs_controller extends CH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_dictionary('ch_labs');
      $this->load_dictionary('ch_lab_instruments');
      $this->load_dictionary('ch_lab_tasks');
		
		$bb[] = array('label' => lang('labs_labs_label'), 'url' => base_url(CH_URL_LABS));
		$this->init_breadcrumb($bb);
      
		$this->add_frontend_module('ch_labs');
      
      $this->load->model('labs_model');
	}
   
   public function index() {
      $this->load_page('labs/labs_view');
   }
   
   public function window_new_lab() {
      $this->load->model('users_model');
      
      $data = array();
      $data['chiefs'] = $this->users_model->get_lab_chiefs();
      
      $this->load->view('labs/new_lab_window', $data);
   }

   public function window_new_lab_staff() {
      $this->load->model('users_model');
      
      $data = array();
      $data['id_lab'] = $this->input->get('id_lab');
      $data['staff_members'] = $this->users_model->get_lab_staff_members($data['id_lab']);
      
      $this->load->view('labs/new_lab_staff_window', $data);
   }

   public function autocomplete_staff_roles_feed() {
      $filter = $this->input->get('term');
      $autocomplete_feed = flatten_for_autocomplete($this->labs_model->get_lab_staff_roles($filter), 'role');
      json_output($autocomplete_feed);
   }
   public function add_lab_staff_member() {
      $staff_member = Lab_staff_DTO::raccogli_dati_request('lab_staff_member');
      $response = $this->labs_model->add_lab_staff_member($staff_member->id_lab, $staff_member);
      json_response($response !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   function delete_lab_staff_member() {
      $id_lab_staff = $this->input->post('id_lab_staff');
      $result = $this->labs_model->delete_lab_staff_member($id_lab_staff);
      json_response($result !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function save_lab() {
      $lab = Lab_DTO::raccogli_dati_request('lab');
      
      $response = $this->labs_model->save($lab);
      
      json_response($response !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function edit_lab($id_lab =FALSE) {
      $this->add_script('ch_lab_instruments');
      $this->add_script('ch_lab_tasks');
      
      $selected_id_lab = $this->input->post('id');
      if($selected_id_lab === FALSE && $id_lab !== FALSE) {
         $selected_id_lab = $id_lab;
      }
      else if($selected_id_lab === FALSE && $id_lab === FALSE) {
         $this->send_user_message(lang('common_words_bad_request_msg'), 'error');
         redirect(CH_URL_LABS);
      }
      
      $can_manage_lab = !$this->labs_model->open_lab_read_only($selected_id_lab);
      $data = array(
         'lab' => $this->labs_model->get_lab($selected_id_lab),
         'chiefs' => $this->users_model->get_lab_chiefs(),
         'enable_lab_summary_edit' => $can_manage_lab,
         'enable_lab_staff_edit' => $can_manage_lab,
         'enable_lab_instrument_edit' => $can_manage_lab
      );
      
      $this->set_breadcrumb( array('label' => $data['lab']->name, 'url' => ''));
      $this->load_page('labs/edit_lab_view', $data);
   }

   public function get_lab_table_feed(){
      $output = $this->labs_model->get_lab_table_feed();
		json_output($output);
   }
   
   public function get_lab_tasks_table_feed($id_lab){
      $this->load->model('lab_tasks_model');
      $output = $this->lab_tasks_model->get_lab_tasks_table_feed($id_lab);
		json_output($output);
   }
   
   public function get_lab_staff_table_feed($id_lab){
      $output = $this->labs_model->get_lab_staff_table_feed($id_lab);
		json_output($output);
   }
}