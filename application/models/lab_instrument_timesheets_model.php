<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Lab_instrument_timesheets_DTO as Timesheet_DTO;
use Lab_instrument_timesheet_type_DTO as Timesheet_type_DTO;

class Lab_instrument_timesheets_model extends CH_Model {

   public function get_lab_instrument_timesheets_csv_feed($filters) {
      $this->db->select(array(
            'y.'.Timesheet_type_DTO::FIELD_LANGUAGE_LABEL,
            'i.'.Lab_instrument_DTO::FIELD_NAME.' instrument',
            'p.'.Project_gantt_task_DTO::FIELD_NAME.' task',
            't.'.Timesheet_DTO::FIELD_START_TIMESTAMP,
            't.'.Timesheet_DTO::FIELD_END_TIMESTAMP,
            't.'.Timesheet_DTO::FIELD_DURATION,
            'u.'.User_DTO::FIELD_FULLNAME
         ))
         ->from(Timesheet_DTO::TABLE_NAME.' t')
         ->join(Timesheet_type_DTO::TABLE_NAME.' y', 't.'.Timesheet_DTO::FIELD_TYPE. ' = y.'.Timesheet_type_DTO::FIELD_TYPE)
         ->join(User_DTO::TABLE_NAME.' u', 't.'.Timesheet_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->join(Lab_instrument_DTO::TABLE_NAME.' i', 't.'.Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT. ' = i.'.Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT)
         ->join(Lab_DTO::TABLE_NAME.' l', 'i.'.Lab_instrument_DTO::FIELD_ID_LAB. ' = l.'.Lab_DTO::FIELD_ID_LAB)
         ->join(Project_gantt_task_DTO::TABLE_NAME.' p', 't.'.Timesheet_DTO::FIELD_ID_LAB_TASK. ' = p.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'left');
      
      if(is_array($filters)) {
         if(array_key_exists('id_lab_instrument', $filters)) {
            $this->db->where('t.'.Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT, $filters['id_lab_instrument']);
         }
         
         if(array_key_exists('id_lab_task', $filters)) {
            $this->db->where('t.'.Timesheet_DTO::FIELD_ID_LAB_TASK, $filters['id_lab_task']);
         }
         
         if(array_key_exists('start_timestamp', $filters)) {
            $this->db->where('t.'.Timesheet_DTO::FIELD_START_TIMESTAMP.' >=', normal_to_db_timestamp($filters['start_timestamp']));
         }
         
         if(array_key_exists('end_timestamp', $filters)) {
            $this->db->where('t.'.Timesheet_DTO::FIELD_END_TIMESTAMP.' <=', normal_to_db_timestamp($filters['end_timestamp']));
         }
      }
      
      $query = $this->db->get();
      
      $list = array();
      foreach ($query->result_array() as $row) {
         $list[] = array(
            lang($row[Timesheet_type_DTO::FIELD_LANGUAGE_LABEL]),
            $row['instrument'],
            $row['task'],
            $row[Timesheet_DTO::FIELD_START_TIMESTAMP],
            $row[Timesheet_DTO::FIELD_END_TIMESTAMP],
            $row[Timesheet_DTO::FIELD_DURATION],
            $row[User_DTO::FIELD_FULLNAME]
         );
      }
      
      return  $list;
   }
   
   public function get_lab_instrument_timesheets_table_feed($id_lab_instrument) {
      $this->load->library('datatable_response_builder');
      $this->load->model(array('labs_model','lab_instruments_model'));
      
//      $instrument = new Lab_instrument_DTO();
      $instrument = $this->lab_instruments_model->get_lab_instrument($id_lab_instrument);
      $is_lab_chief = $this->labs_model->is_lab_chief($instrument->id_lab);
      
      $fields = array(
         array('db' => Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT_TIMESHEET, 'dt' => 'id'),
         array('db' => Timesheet_type_DTO::FIELD_LANGUAGE_LABEL, 'dt' => 'type'),
         array('db' => Project_gantt_task_DTO::FIELD_NAME, 'dt' => 'task_name'),
         array('db' => Timesheet_DTO::FIELD_START_TIMESTAMP, 'dt' => 'start'),
         array('db' => Timesheet_DTO::FIELD_END_TIMESTAMP, 'dt' => 'end'),
         array('db' => 't.'.Timesheet_DTO::FIELD_DURATION, 'dt' => 'duration'),
         array('db' => User_DTO::FIELD_FULLNAME, 'dt' => 'user_fullname')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Timesheet_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Timesheet_type_DTO::TABLE_NAME.' y', 't.'.Timesheet_DTO::FIELD_TYPE. ' = y.'.Timesheet_type_DTO::FIELD_TYPE)
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 't.'.Timesheet_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->add_join_clauses(Project_gantt_task_DTO::TABLE_NAME.' p', 't.'.Timesheet_DTO::FIELD_ID_LAB_TASK. ' = p.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'left')
         ->add_where_clauses(array(Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT => $id_lab_instrument));
      if(!$this->bitauth->has_role(CH_ROLE_POWERUSER) && !$is_lab_chief) {
         $this->datatable_response_builder->add_where_clauses(Timesheet_DTO::FIELD_ID_USER, $this->bitauth->user_id);
      }
         
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_lab_task_instrument_timesheets_table_feed($id_lab_task, $id_lab_instrument = NULL) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT_TIMESHEET, 'dt' => 'id'),
         array('db' => Lab_instrument_DTO::FIELD_NAME, 'dt' => 'instrument_name'),
         array('db' => Lab_DTO::FIELD_NAME, 'dt' => 'lab_name'),
         array('db' => Timesheet_DTO::FIELD_START_TIMESTAMP, 'dt' => 'start'),
         array('db' => Timesheet_DTO::FIELD_END_TIMESTAMP, 'dt' => 'end'),
         array('db' => 't.'.Timesheet_DTO::FIELD_DURATION, 'dt' => 'duration'),
         array('db' => User_DTO::FIELD_FULLNAME, 'dt' => 'user_fullname')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Timesheet_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Timesheet_type_DTO::TABLE_NAME.' y', 't.'.Timesheet_DTO::FIELD_TYPE. ' = y.'.Timesheet_type_DTO::FIELD_TYPE)
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 't.'.Timesheet_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->add_join_clauses(Lab_instrument_DTO::TABLE_NAME.' i', 't.'.Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT. ' = i.'.Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT)
         ->add_join_clauses(Lab_DTO::TABLE_NAME.' l', 'i.'.Lab_instrument_DTO::FIELD_ID_LAB. ' = l.'.Lab_DTO::FIELD_ID_LAB)
         ->add_where_clauses(array(Timesheet_DTO::FIELD_ID_LAB_TASK => $id_lab_task));
      
      if(is_numeric($id_lab_instrument)) $this->datatable_response_builder->add_where_clauses(array('t.'.Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT => $id_lab_instrument));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_timesheet_types() {
      $this->db->from(Timesheet_type_DTO::TABLE_NAME)
         ->order_by(Timesheet_type_DTO::FIELD_ORDER);
      
      return $this->_get_list(Timesheet_type_DTO::class_name());
   }
   
   public function get_timesheet($id_timesheet) {
      $this->db->from(Timesheet_DTO::TABLE_NAME)
         ->where(Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT_TIMESHEET, $id_timesheet);
      
      return $this->_get(Timesheet_DTO::class_name());
   }
   
   public function save(Timesheet_DTO $timesheet) {
      if(is_numeric($timesheet->id)) {
         return $this->db->update(Timesheet_DTO::TABLE_NAME, $timesheet->get_data_for_db(), array(Timesheet_DTO::FIELD_ID_LAB_INSTRUMENT_TIMESHEET => $timesheet->id));
      }
      else {
         return $this->_insert(Timesheet_DTO::TABLE_NAME, $timesheet->get_data_for_db());
      }
   }
}
