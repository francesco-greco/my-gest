<?php if (!defined('BASEPATH'))	exit('No direct script access allowed');

class User_DTO extends DTO {
	const TABLE_NAME = 'user_data';
	
	const FIELD_IDUSER = 'user_id';
	const FIELD_FULLNAME = 'fullname';
   const FIELD_EMAIL = 'email';
	const FIELD_PREFERRED_LANG = 'preferred_lang';
        const FIELD_HEADQUARTERS = 'headquarters';
	
	public $user_id;
	public $username;
	public $fullname;
   public $email;
	public $preferred_lang;
	public $enabled;
	public $groups;
        public $headquarters;
   
   public $field_prefix;
	
	public function init($data) {
		if( ! is_array($data) && ! is_object($data)) {
			$this->pulisci();
         $this->groups = array();
		}
		else {
			$data = (array) $data;
			$this->user_id = array_key_exists($this->field_prefix.self::FIELD_IDUSER, $data) ? $data[$this->field_prefix.self::FIELD_IDUSER] : '';
			$this->username = array_key_exists('username', $data) ? $data['username'] : '';
			$this->fullname = array_key_exists($this->field_prefix.self::FIELD_FULLNAME, $data) ? $data[$this->field_prefix.self::FIELD_FULLNAME] : '';
         $this->email = array_key_exists($this->field_prefix.self::FIELD_EMAIL, $data) ? $data[$this->field_prefix.self::FIELD_EMAIL] : '';
			$this->preferred_lang = array_key_exists($this->field_prefix.self::FIELD_PREFERRED_LANG, $data) ? $data[$this->field_prefix.self::FIELD_PREFERRED_LANG] : '';
			$this->enabled = array_key_exists('enabled', $data) ? $data['enabled'] : 0;
			$this->groups = array_key_exists('groups', $data) ? $data['groups'] : array();
                        $this->headquarters = array_key_exists('headquarters', $data) ? $data['headquarters'] : array();
		}
	}

   public function get_data_for_db() {
      
   }

}