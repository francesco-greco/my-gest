<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lab_instruments_controller extends CH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_dictionary('ch_labs');
      $this->load_dictionary('ch_lab_instruments');
		
		$bb[] = array('label' => lang('labs_labs_label'), 'url' => base_url(CH_URL_LABS));
      $this->init_breadcrumb($bb);
      
      $this->add_script('ch_lab_instruments');      
		
      $this->load->model('lab_instruments_model');
	}
   
   private function build_breadcrumb(Lab_DTO $lab, Lab_instrument_DTO $lab_instrument) {
      $bb[] = array('label' => $lab->name, 'url' => base_url(CH_URL_LABS.'/edit_lab/'.$lab->id));
      $bb[] = array('label' => lang('instruments_instruments_label'), 'url' => '#');
      
      $bb[] = array('label' => $lab_instrument->name, 'url' => '#');
      $this->set_breadcrumb($bb);
   }
   
   public function edit_instrument() {
      $this->load->model('labs_model');
      
      $id_lab = $this->input->post('lab_id');
      $lab = $this->labs_model->get_lab($id_lab);
      
      $id_lab_instrument = $this->input->post('id');
      $lab_instrument = $this->lab_instruments_model->get_lab_instrument($id_lab_instrument);
      $lab_instrument_types = $this->lab_instruments_model->get_instruments_types();
      
      $this->build_breadcrumb($lab, $lab_instrument);
      
      $view_data = array();
      $view_data['lab'] = $lab;
      $view_data['lab_instrument'] = $lab_instrument;
      $view_data['lab_instrument_types'] = $lab_instrument_types;
      $view_data['enable_instrument_summary_edit'] = !$this->labs_model->open_lab_read_only($id_lab);
         
      $this->load_page('lab_instruments/edit_lab_instrument_view', $view_data);
   }
   
   public function save_instrument() {
      $lab_instrumemnt = Lab_instrument_DTO::raccogli_dati_request('lab_instrument');
      
      $response = $this->lab_instruments_model->save($lab_instrumemnt);
      
      json_response($response !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function window_new_lab_instrument() {
      $data = array();
      $data['id_lab'] = $this->input->get('id_lab');
      
      $this->load->view('lab_instruments/new_lab_instrument_window', $data);
   }

   public function autocomplete_lab_instrument_names_feed() {
      $filter = $this->input->get('term');
      $autocomplete_feed = flatten_for_autocomplete($this->lab_instruments_model->get_lab_instrument_names($filter), 'name');
      json_output($autocomplete_feed);
   }
   
   public function add_lab_instrument() {
      $staff_intrument = Lab_instrument_DTO::raccogli_dati_request('lab_instrument');
      $response = $this->lab_instruments_model->add_lab_instrument($staff_intrument->id_lab, $staff_intrument);
      json_response($response !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function get_lab_instruments_table_feed($id_lab){
      $output = $this->lab_instruments_model->get_lab_instruments_table_feed($id_lab);
		json_output($output);
   }
   
   /*****************************
    *****  START TIMESHEETS *****
    *****************************/
   public function get_lab_instrument_timesheets_table_feed($id_lab_instrument) {
      $this->load->model('lab_instrument_timesheets_model');
      json_output($this->lab_instrument_timesheets_model->get_lab_instrument_timesheets_table_feed($id_lab_instrument));
   }
   
   public function window_edit_lab_instrument_timesheet($id_timesheet = FALSE) {
      $this->load->model(array('labs_model', 'lab_tasks_model', 'lab_instrument_timesheets_model'));
      $id_lab_instrument = $this->input->get('id_lab_instrument');
      $lab_instrument = $this->lab_instruments_model->get_lab_instrument($id_lab_instrument);
      
      $data = array(
         'timesheet' => ($id_timesheet !== FALSE) ? $this->lab_instrument_timesheets_model->get_timesheet($id_timesheet) : new Lab_instrument_timesheets_DTO(),
         'lab_staff' => $this->labs_model->get_lab_staff($lab_instrument->id_lab),
         'lab_tasks' => $this->lab_tasks_model->get_lab_tasks($lab_instrument->id_lab, TRUE, FALSE),
         'timesheet_types' => $this->lab_instrument_timesheets_model->get_timesheet_types(),
         'id_lab_instrument' => $id_lab_instrument,
         'is_lab_chief' => $this->labs_model->is_lab_chief($lab_instrument->id_lab)
      );
      $this->load->view('lab_instruments/new_lab_instrument_timesheet_window', $data);
   }
   
   public function save_lab_instrument_timesheet() {
      $this->load->model('lab_instrument_timesheets_model');
      
      $timesheet = Lab_instrument_timesheets_DTO::raccogli_dati_request('timesheet');
      $res = $this->lab_instrument_timesheets_model->save($timesheet);
      
      json_response($res !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
   
   public function window_export_timesheets() {
      $id_lab_instrument =  $this->input->get('id_lab_instrument');
      
      $data= array();
      $data['submit_url'] = base_url(CH_URL_LAB_INSTRUMENTS.'/export_instrument_timesheet_csv/'.$id_lab_instrument);
      $data['title_dictionary_term'] = 'instruments_get_timesheet_csv_label';
      $this->load->view('_common/select_date_range_window', $data);
   }

   public function export_instrument_timesheet_csv($id_lab_instrument) {
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      
      $filters = array();
      
      $filters['id_lab_instrument'] = $id_lab_instrument;
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

   /*****************************
    *****  END TIMESHEETS *******
    *****************************/
   
   /*****************************
    *****  START ATTACHMENTS *****
    *****************************/
   public function get_lab_instrument_attachments_table_feed($id_lab_instrument) {
      $this->load->model('lab_instrument_attachments_model');
      json_output($this->lab_instrument_attachments_model->get_lab_instrument_attachments_table_feed($id_lab_instrument));
   }
   
   public function window_edit_lab_instrument_attachment($id_attachment = FALSE) {
      $this->load->model(array('labs_model', 'lab_tasks_model', 'lab_instrument_attachments_model'));
      $lab_instrument = $this->lab_instruments_model->get_lab_instrument($this->input->get('id_lab_instrument'));
      
      $data = array(
         'attachment' => ($id_attachment !== FALSE) ? $this->lab_instrument_attachments_model->get_attachment($id_attachment) : new Lab_instrument_attachments_DTO(),
         'lab_staff' => $this->labs_model->get_lab_staff($lab_instrument->id_lab),
         'lab_tasks' => $this->lab_tasks_model->get_lab_tasks($lab_instrument->id_lab, TRUE, FALSE),
         'attachment_categories' => $this->lab_instrument_attachments_model->get_attachment_categories(),
         'id_lab_instrument' => $this->input->get('id_lab_instrument')
      );
      $this->load->view('lab_instruments/new_lab_instrument_attachment_window', $data);
   }
   
   public function save_lab_instrument_attachment() {
      $this->load->model('lab_instrument_attachments_model');
      
      $attachment = Lab_instrument_attachments_DTO::raccogli_dati_request('attachment');
      $archiver = new CH_Instrument_Attachment_Archiver();
      if($archiver->upload_file('attachment_filename')) {
         $filename = $archiver->archive_file();
         if($filename !== FALSE) {
            $attachment->id_user = $this->bitauth->user_id;
            $attachment->filename = $filename;
            $attachment->original_filename = $archiver->get_original_filename();
            $res = $this->lab_instrument_attachments_model->save($attachment);
         }
         else {
            $res = FALSE;
         }

         json_response($res !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
      }
      else if(is_numeric($attachment->id)) {
         $res = $this->lab_instrument_attachments_model->save($attachment);
         
         json_response($res !== FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
      }
      else {
         json_response(CH_RESPONSE_FAILURE);
      }
   }
   
   /******************************
    *****  END ATTACHMENTS *******
    ******************************/
}