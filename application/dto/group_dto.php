<?php if (!defined('BASEPATH'))	exit('No direct script access allowed');

class Group_DTO extends DTO {
	public $group_id;
	public $name;
	public $description;
	public $roles;
	
	public function init($data) {
		if( ! is_array($data) && ! is_object($data)) {
			$this->pulisci();
         $this->roles = array();
		}
		else {
			$data = (array) $data;
			$this->group_id = array_key_exists('group_id', $data) ? $data['group_id'] : '';
			$this->name = array_key_exists('name', $data) ? $data['name'] : '';
			$this->description = array_key_exists('description', $data) ? $data['description'] : '';
			$this->roles = array_key_exists('roles', $data) ? $data['roles'] : array();
		}
	}

   public function get_data_for_db() {
      
   }
}