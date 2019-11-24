<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lab_staff_DTO extends DTO {

   const TABLE_NAME = 'lab_staff';
   const FIELD_ID_LAB_STAFF = 'id_lab_staff';
   const FIELD_ID_LAB = 'id_lab';
   const FIELD_ID_USER = 'id_user';
   const FIELD_ROLE = 'role';

   public $id;
   public $id_lab;
   public $id_user;
   public $role;

   public $user;
   
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_LAB_STAFF, $data) ? $data[self::FIELD_ID_LAB_STAFF] : '';
         $this->id_lab = array_key_exists(self::FIELD_ID_LAB, $data) ? $data[self::FIELD_ID_LAB] : '';
         $this->id_user = array_key_exists(self::FIELD_ID_USER, $data) ? $data[self::FIELD_ID_USER] : '';
         $this->role = array_key_exists(self::FIELD_ROLE, $data) ? $data[self::FIELD_ROLE] : '';
         
         if(array_key_exists(User_DTO::FIELD_FULLNAME, $data)) $this->user = new User_DTO($data);
      }
   }

   public function get_data_for_db() {
      $data = array();
      
      if ($this->id !== '') $data[self::FIELD_ID_LAB_STAFF] = $this->id;
      if ($this->id_lab !== '') $data[self::FIELD_ID_LAB] = $this->id_lab;
      if ($this->id_user !== '') $data[self::FIELD_ID_USER] = $this->id_user;
      if ($this->role !== '') $data[self::FIELD_ROLE] = $this->role;
      
      return $data;
   }
}