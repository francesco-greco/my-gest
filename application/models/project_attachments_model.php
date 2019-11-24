<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Project_attachment_DTO as Prj_Attachment_DTO;

class Project_attachments_model extends CH_Model {

   public function get_project_attachments_table_feed($id_project) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => 't.'.Attachment_DTO::FIELD_ID_ATTACHMENT, 'dt' => 'id'),
         array('db' => 'y.'.Attachment_category_DTO::FIELD_LANGUAGE_LABEL, 'dt' => 'type'),
         array('db' => 't.'.Attachment_DTO::FIELD_DESCRIPTION, 'dt' => 'description'),
         array('db' => 'k.'.Project_gantt_task_DTO::FIELD_NAME, 'dt' => 'task_name'),
         array('db' => 't.'.Attachment_DTO::FIELD_UPLOAD_DATE, 'dt' => 'date'),
         array('db' => Attachment_DTO::FIELD_SHARE, 'dt' => 'attachment_share'),
         array('db' => 'l.'.Lab_DTO::FIELD_NAME.' lab_name', 'dt' => 'lab'),
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Attachment_DTO::TABLE_NAME.' t')
         ->add_join_clauses(Attachment_category_DTO::TABLE_NAME.' y', 't.'.Attachment_DTO::FIELD_CATEGORY. ' = y.'.Attachment_category_DTO::FIELD_CATEGORY)
         ->add_join_clauses(Prj_Attachment_DTO::REL_TABLE_NAME.' r', 'r.'.Prj_Attachment_DTO::FIELD_ID_ATTACHMENT. ' = t.'.Attachment_DTO::FIELD_ID_ATTACHMENT, 'left')
         ->add_join_clauses(Lab_instrument_attachments_DTO::REL_TABLE_NAME.' r2', 'r2.'.Lab_instrument_attachments_DTO::FIELD_ID_ATTACHMENT. ' = t.'.Attachment_DTO::FIELD_ID_ATTACHMENT, 'left')
//         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 't.'.Attachment_DTO::FIELD_ID_USER. ' = u.'.User_DTO::FIELD_IDUSER)
         ->add_join_clauses(Project_gantt_task_DTO::TABLE_NAME.' k', 'r2.'.Lab_instrument_attachments_DTO::FIELD_ID_LAB_TASK. ' = k.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'left')
         ->add_join_clauses(Project_gantt_assignment_DTO::TABLE_NAME.' ass', 'ass.'.Project_gantt_assignment_DTO::FIELD_ID_PROJECT_GANTT_TASK. ' = k.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT_TASK, 'left')
         ->add_join_clauses(Lab_DTO::TABLE_NAME.' l', 'l.'.Lab_DTO::FIELD_ID_LAB. ' = ass.'.Project_gantt_assignment_DTO::FIELD_ID_RESOURCE, 'left')
         ->add_join_clauses(Project_gantt_DTO::TABLE_NAME.' p', 'k.'.Project_gantt_task_DTO::FIELD_ID_PROJECT_GANTT. ' = p.'.Project_gantt_DTO::FIELD_ID_PROJECT_GANTT, 'left')
         
         ->add_where_clauses('(r.'.Prj_Attachment_DTO::FIELD_ID_PROJECT ." = $id_project OR p.".Project_gantt_DTO::FIELD_ID_PROJECT . " = $id_project)")
         ->add_where_clauses(array(Attachment_DTO::FIELD_ID_CURRENT_ATTACHMENT_VERSION => NULL));
      
      $r = $this->datatable_response_builder->build_response();
//      echo $this->db->last_query();
      return $r;
   }
   
   public function get_attachment_categories() {
      $this->db->from(Attachment_category_DTO::TABLE_NAME)
         ->like(Attachment_category_DTO::FIELD_TYPES, Attachment_DTO::TYPE_PROJECT)
         ->order_by(Attachment_category_DTO::FIELD_ORDER);
      
      return $this->_get_list(Attachment_category_DTO::class_name());
   }
   
   public function get_attachment($id_attachment) {
      $this->db->from(Attachment_DTO::TABLE_NAME.' a')
         ->join(Prj_Attachment_DTO::REL_TABLE_NAME.' r', 'r.'.Prj_Attachment_DTO::FIELD_ID_ATTACHMENT.' = a.'.Attachment_DTO::FIELD_ID_ATTACHMENT)
         ->where('a.'.Attachment_DTO::FIELD_ID_ATTACHMENT, $id_attachment);
      
      return $this->_get(Prj_Attachment_DTO::class_name());
   }
   
   public function is_attachment_access_granted($id_attachment) {
      return TRUE;
   }
   
   public function save(Prj_Attachment_DTO $attachment) {
      $this->db->trans_start();

      $attachment_db_data = $attachment->get_data_for_db();
      $a = new Attachment_DTO($attachment_db_data);
      $a->type = Attachment_DTO::TYPE_PROJECT;
      if(is_numeric($attachment->id)) {
         if($this->db->update(Attachment_DTO::TABLE_NAME, $a->get_data_for_db(), array(Attachment_DTO::FIELD_ID_ATTACHMENT => $a->id))) {
            $this->db->update(Prj_Attachment_DTO::REL_TABLE_NAME, $attachment->get_rel_data_for_db(), array(Prj_Attachment_DTO::FIELD_ID_ATTACHMENT => $attachment->id));
         }
      }
      else {
         $id = $this->_insert(Attachment_DTO::TABLE_NAME, $a->get_data_for_db());
         if($id !== FALSE) {
            $attachment->id = $id;
            $this->_insert(Prj_Attachment_DTO::REL_TABLE_NAME, $attachment->get_rel_data_for_db());
         }
      }
      $this->db->trans_complete();
      
      return $this->db->trans_status();
   }
}
