<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Lab_instrument_attachments_DTO as Inst_Attachment_DTO;

class Lab_instrument_attachments_model extends CH_Model {

   public function get_lab_instrument_attachments_table_feed($id_lab_instrument) {
      $this->load->library('datatable_response_builder');
      
      $this->load->model(array('labs_model','lab_instruments_model'));
      
      $instrument = $this->lab_instruments_model->get_lab_instrument($id_lab_instrument);
      $is_lab_chief = $this->labs_model->is_lab_chief($instrument->id_lab);
      
      $fields = array(
         array('db' => 't.'.Attachment_DTO::FIELD_ID_ATTACHMENT, 'dt' => 'id'),
         array('db' => Attachment_category_DTO::FIELD_LANGUAGE_LABEL, 'dt' => 'type'),
         array('db' => 't.'.Attachment_DTO::FIELD_DESCRIPTION, 'dt' => 'description'),
         array('db' => Project_gantt_task_DTO::FIELD_NAME, 'dt' => 'task_name'),
         array('db' => 't.'.Attachment_DTO::FIELD_UPLOAD_DATE, 'dt' => 'date', 'formatter' => 'db_to_normal_date'),
         array('db' => User_DTO::FIELD_FULLNAME, 'dt' => 'user_fullname')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Attachment_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Attachment_category_DTO::TABLE_NAME.' y', 't.'.Attachment_DTO::FIELD_CATEGORY. ' = y.'.Attachment_category_DTO::FIELD_CATEGORY)
         ->add_join_clauses(Inst_Attachment_DTO::REL_TABLE_NAME.' r', 'r.'.Inst_Attachment_DTO::FIELD_ID_ATTACHMENT. ' = t.'.Attachment_DTO::FIELD_ID_ATTACHMENT)
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 't.'.Attachment_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->add_join_clauses(Project_gantt_task_DTO::TABLE_NAME.' p', 'r.'.Inst_Attachment_DTO::FIELD_ID_LAB_TASK. ' = p.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'left')
         ->add_where_clauses(array(Inst_Attachment_DTO::FIELD_ID_LAB_INSTRUMENT => $id_lab_instrument, Attachment_DTO::FIELD_ID_CURRENT_ATTACHMENT_VERSION => NULL));
      
      if(!$this->bitauth->has_role(CH_ROLE_POWERUSER) && !$is_lab_chief) {
         $this->datatable_response_builder->add_where_clauses(Inst_Attachment_DTO::FIELD_ID_USER, $this->bitauth->user_id);
      }
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_lab_task_attachments_table_feed($id_lab_task) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => 't.'.Attachment_DTO::FIELD_ID_ATTACHMENT, 'dt' => 'id'),
         array('db' => 't.'.Attachment_DTO::FIELD_DESCRIPTION, 'dt' => 'description'),
         array('db' => 'i.'.Lab_instrument_DTO::FIELD_NAME, 'dt' => 'instrument_name'),
         array('db' => 't.'.Attachment_DTO::FIELD_UPLOAD_DATE, 'dt' => 'date'),
         array('db' => User_DTO::FIELD_FULLNAME, 'dt' => 'user_fullname')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Attachment_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Attachment_category_DTO::TABLE_NAME.' y', 't.'.Attachment_DTO::FIELD_CATEGORY. ' = y.'.Attachment_category_DTO::FIELD_CATEGORY)
         ->add_join_clauses(Inst_Attachment_DTO::REL_TABLE_NAME.' r', 'r.'.Inst_Attachment_DTO::FIELD_ID_ATTACHMENT. ' = t.'.Attachment_DTO::FIELD_ID_ATTACHMENT)
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 't.'.Attachment_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->add_join_clauses(Lab_instrument_DTO::TABLE_NAME.' i', 'r.'.Inst_Attachment_DTO::FIELD_ID_LAB_INSTRUMENT. ' = i.'.Lab_instrument_DTO::FIELD_ID_LAB_INSTRUMENT, 'left')
         ->add_where_clauses(array(Inst_Attachment_DTO::FIELD_ID_LAB_TASK => $id_lab_task, Attachment_DTO::FIELD_ID_CURRENT_ATTACHMENT_VERSION => NULL));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_attachment_categories() {
      $this->db->from(Attachment_category_DTO::TABLE_NAME)
         ->like(Attachment_category_DTO::FIELD_TYPES, Attachment_DTO::TYPE_INSTRUMENT)
         ->order_by(Attachment_category_DTO::FIELD_ORDER);
      
      return $this->_get_list(Attachment_category_DTO::class_name());
   }
   
   public function get_attachment($id_attachment) {
      $this->db->from(Attachment_DTO::TABLE_NAME.' a')
         ->join(Inst_Attachment_DTO::REL_TABLE_NAME.' r', 'r.'.Inst_Attachment_DTO::FIELD_ID_ATTACHMENT.' = a.'.Attachment_DTO::FIELD_ID_ATTACHMENT)
         ->where('a.'.Attachment_DTO::FIELD_ID_ATTACHMENT, $id_attachment);
      
      return $this->_get(Inst_Attachment_DTO::class_name());
   }
   
   //TODO: implementare un sistema di policy per l'accesso ai file di di tipo strumentazione
   public function is_attachment_access_granted($id_attachment) {
      return TRUE;
   }
   
   public function save(Inst_Attachment_DTO $attachment) {
      $this->db->trans_start();
      $attachment->type = Attachment_DTO::TYPE_INSTRUMENT;
      $attachment_db_data = $attachment->get_data_for_db();
      $a = new Attachment_DTO($attachment_db_data);
      if(is_numeric($attachment->id)) {
         if($this->db->update(Attachment_DTO::TABLE_NAME, $a->get_data_for_db(), array(Attachment_DTO::FIELD_ID_ATTACHMENT => $a->id))) {
            $this->db->update(Inst_Attachment_DTO::REL_TABLE_NAME, 
               array(Inst_Attachment_DTO::FIELD_ID_LAB_INSTRUMENT => $attachment->id_lab_instrument, Inst_Attachment_DTO::FIELD_ID_LAB_TASK => $attachment->id_lab_task),
               array(Inst_Attachment_DTO::FIELD_ID_ATTACHMENT => $attachment->id));
         }
      }
      else {
         $id = $this->_insert(Attachment_DTO::TABLE_NAME, $a->get_data_for_db());
         if($id !== FALSE) {
            $attachment->id = $id;
            $this->_insert(Inst_Attachment_DTO::REL_TABLE_NAME, $attachment->get_rel_data_for_db());
         }
      }
      $this->db->trans_complete();
      
      return $this->db->trans_status();
   }
}
