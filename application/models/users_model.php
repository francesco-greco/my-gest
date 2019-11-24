<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CH_Model {
   /**
    * Return a list of users that can be designed as Lab chiefs
    * @return User_DTO array 
    */
   public function get_lab_chiefs() {
      $list = $this->bitauth->get_users();
      
      $operators = array();
      foreach ($list as $op) {
         if($this->bitauth->has_role(CH_ROLE_LAB_AREA_CHIEF, $op->roles) && !$this->bitauth->is_admin($op->roles)) {
            $operators[] = new User_DTO($op);
         }
      }
      return $operators;
   }
   
   public function get_lab_operators() {
      $list = $this->bitauth->get_users();
      
      $operators = array();
      foreach ($list as $op) {
         if($this->bitauth->has_role(CH_ROLE_LAB_AREA_OPERATOR, $op->roles) && !$this->bitauth->is_admin($op->roles)) {
            $operators[] = new User_DTO($op);
         }
      }
      return $operators;
   }
   
   /**
    * Return a list of users that can be designed as Lab staff member
    * @return User_DTO array 
    */
   public function get_lab_staff_members($id_lab) {
      $this->db->select('u.*')
         ->from(User_DTO::TABLE_NAME.' u')
         ->join(Lab_staff_DTO::TABLE_NAME. ' s', 's.'.Lab_staff_DTO::FIELD_ID_USER.' = u.'.User_DTO::FIELD_IDUSER.' AND s.'.Lab_staff_DTO::FIELD_ID_LAB." = $id_lab", 'left')
         ->where('u.'.User_DTO::FIELD_IDUSER.' <>', 1)
         ->where('s.'.Lab_staff_DTO::FIELD_ID_LAB_STAFF.' IS NULL');
      
      $list = $this->_get_list(User_DTO::class_name());
      
      $available_staff = array();
      foreach ($list as $leader) {
         $available_staff[] = new User_DTO($leader);
      }
      return $available_staff;
   }
   
   /**
    * Return a list of users that can be designed as Project Leader
    * @return User_DTO array 
    */
   public function get_project_leaders() {
      $list = $this->bitauth->get_users();
      
      $leaders = array();
      foreach ($list as $leader) {
         if($this->bitauth->has_role(CH_ROLE_PROJECT_AREA_MANAGE_PROJECT, $leader->roles) && !$this->bitauth->is_admin($leader->roles)) {
            $leaders[] = new User_DTO($leader);
         }
      }
      return $leaders;
   }
   
   public function get_user($id_user) {
      $user = $this->bitauth->get_user_by_id($id_user);
      
      return $this->bitauth->is_admin($user->roles) ? new User_DTO() : new User_DTO($user);
   }
}