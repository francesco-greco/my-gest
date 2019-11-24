<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Labs_model extends CH_Model {
   public function save(Lab_DTO $lab) {
      $response = FALSE;
      if($lab->id == '') {
         $response = $this->_insert(Lab_DTO::TABLE_NAME, $lab->get_data_for_db());
      }
      else {
         $this->db->where(Lab_DTO::FIELD_ID_LAB, $lab->id);
         $response = $this->db->update(Lab_DTO::TABLE_NAME, $lab->get_data_for_db());
      }
      return $response;
   }

   public function get_lab($id_lab) {
      $this->load->model('users_model');
      
      $this->db->from(Lab_DTO::TABLE_NAME)
         ->where(Lab_DTO::FIELD_ID_LAB, $id_lab);
      $lab = $this->_get(Lab_DTO::class_name());
      
      $lab->lab_chief = $this->users_model->get_user($lab->id_lab_chief);
      
      return $lab;
   }
   
   public function get_labs() {
      $this->db->from(Lab_DTO::TABLE_NAME)
         ->order_by(Lab_DTO::FIELD_NAME);
      
      return $this->_get_list(Lab_DTO::class_name());
   }
   
   public function get_lab_table_feed() {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => 'l.'.Lab_DTO::FIELD_ID_LAB, 'dt' => 'id'),
         array('db' => Lab_DTO::FIELD_NAME, 'dt' => 'name'),
         array('db' => 'u.'.User_DTO::FIELD_FULLNAME.' lab_chief', 'dt' => 'lab_chief')
      );
      
      $this->datatable_response_builder->distinct()
         ->set_fields($fields)
         ->set_table(Lab_DTO::TABLE_NAME.' l')
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 'u.'.User_DTO::FIELD_IDUSER.' = l.'.  Lab_DTO::FIELD_ID_LAB_CHIEF, 'left')
         ->add_join_clauses(Lab_staff_DTO::TABLE_NAME.' ls', 'ls.'.Lab_staff_DTO::FIELD_ID_LAB.' = l.'.  Lab_DTO::FIELD_ID_LAB, 'left');
      
      //Un lab deve essere visibile al suo responsabile ed ai facenti parte dello staff
      if(!$this->bitauth->has_role(CH_ROLE_LAB_AREA_FULL_LABS_LIST) || !$this->bitauth->has_role(CH_ROLE_POWERUSER)) {
         $this->datatable_response_builder->add_where_clauses('(l.'.  Lab_DTO::FIELD_ID_LAB_CHIEF." = {$this->bitauth->user_id} OR ls.".Lab_staff_DTO::FIELD_ID_USER." = {$this->bitauth->user_id})");
      }
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_lab_staff($id_lab) {
      $this->db->from(Lab_staff_DTO::TABLE_NAME.' s')
         ->join(User_DTO::TABLE_NAME.' u', 'u.'.User_DTO::FIELD_IDUSER.' = s.'.Lab_staff_DTO::FIELD_ID_USER)
         ->where('s.'.Lab_staff_DTO::FIELD_ID_LAB, $id_lab)
         ->order_by('u.'.User_DTO::FIELD_FULLNAME);
      
      return $this->_get_list(Lab_staff_DTO::class_name());
   }
   
   public function get_lab_staff_table_feed($id_lab) {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => Lab_staff_DTO::FIELD_ID_LAB_STAFF, 'dt' => 'id'),
         array('db' => User_DTO::FIELD_FULLNAME, 'dt' => 'name'),
         array('db' => Lab_staff_DTO::FIELD_ROLE, 'dt' => 'role')
      );
      
      $this->datatable_response_builder->set_fields($fields)
         ->set_table(Lab_staff_DTO::TABLE_NAME.' s')
         ->add_join_clauses(User_DTO::TABLE_NAME.' u', 'u.'.User_DTO::FIELD_IDUSER.' = s.'.  Lab_staff_DTO::FIELD_ID_USER)
         ->add_where_clauses(array(Lab_staff_DTO::FIELD_ID_LAB => $id_lab));
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function add_lab_staff_member($id_lab, Lab_staff_DTO $member) {
      $member->id_lab = $id_lab;
      return $this->_insert(Lab_staff_DTO::TABLE_NAME, $member->get_data_for_db());
   }
   
   public function delete_lab_staff_member($id_lab_staff_member) {
      return $this->db->where(Lab_staff_DTO::FIELD_ID_LAB_STAFF, $id_lab_staff_member)
         ->delete(Lab_staff_DTO::TABLE_NAME);
   }
   
   public function get_lab_staff_roles($filter = FALSE) {
      $this->db->distinct()
         ->from(Lab_staff_DTO::TABLE_NAME)
         ->order_by(Lab_staff_DTO::FIELD_ROLE);
      
      if($filter !== FALSE) $this->db->like(Lab_staff_DTO::FIELD_ROLE, $filter, 'after');
      return $this->_get_list(Lab_staff_DTO::class_name());
   }
   
   public function is_lab_chief($id_lab, $id_user = FALSE) {
      $id_user_selected = ($id_user == FALSE) ? $this->bitauth->user_id : $id_user;
      
      $lab = $this->get_lab($id_lab);

      return $lab->id_lab_chief == $id_user_selected;
   }

   public function open_lab_read_only($id_lab) {
      if(!is_numeric($id_lab)) return TRUE;
      
      if($this->bitauth->has_role(CH_ROLE_POWERUSER)) return FALSE;
      //Se l'utente è il project manager o un power user può modificare il progetto
      if($this->bitauth->has_role(CH_ROLE_LAB_AREA_CHIEF) && $this->is_lab_chief($id_lab)) return FALSE;
      
      return TRUE;
   }
}