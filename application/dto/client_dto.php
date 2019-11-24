<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Client_DTO extends DTO {
    const TABLE_NAME = 'clients';

    const FIELD_USER_ID = 'user_id';
    const FIELD_USERNAME = 'username';
    const FIELD_PASSWORD = 'password';
    const FIELD_PASSWORD_LAST_SET = 'password_last_set';
    const FIELD_PASSWORD_NEVER_EXPIRES = 'password_never_expires';
    const FIELD_REMEMBER_ME = 'remember_me';
    const FIELD_ACTIVATION_CODE = 'activation_code';
    const FIELD_ACTIVE = 'active';
    const FIELD_FORGOT_CODE = 'forgot_code';
    const FIELD_FORGOT_GENERATED = 'forgot_generated';
    const FIELD_ENABLED = 'enabled';
    const FIELD_LAST_LOGIN = 'last_login';
    const FIELD_LAST_LOGIN_IP = 'last_login_ip';

    public $id;
    public $username;
    public $password;
    public $password_last_set;
    public $password_never_expires;
    public $remember_me;
    public $activation_code;
    public $active;
    public $forgot_code;
    public $forgot_generated;
    public $enabled;
    public $last_login;
    public $last_login_ip;
    
    public function init($data) {
        if( ! is_array($data) && ! is_object($data)) {
            $this->pulisci();
        }
        else {
            $data = (array) $data;
            $this->id = array_key_exists(self::FIELD_USER_ID, $data) ? $data[self::FIELD_USER_ID] : '';
            $this->username = array_key_exists(self::FIELD_USERNAME, $data) ? $data[self::FIELD_USERNAME] : '';
            $this->password = array_key_exists(self::FIELD_PASSWORD, $data) ? $data[self::FIELD_PASSWORD] : '';
            $this->password_last_set = array_key_exists(self::FIELD_PASSWORD_LAST_SET, $data) ? $data[self::FIELD_PASSWORD_LAST_SET] : '';
            $this->password_never_expires = array_key_exists(self::FIELD_PASSWORD_NEVER_EXPIRES, $data) ? $data[self::FIELD_PASSWORD_NEVER_EXPIRES] : '';
            $this->remember_me = array_key_exists(self::FIELD_REMEMBER_ME, $data) ? $data[self::FIELD_REMEMBER_ME] : '';
            $this->activation_code = array_key_exists(self::FIELD_ACTIVATION_CODE, $data) ? $data[self::FIELD_ACTIVATION_CODE] : '';
            $this->active = array_key_exists(self::FIELD_ACTIVE, $data) ? $data[self::FIELD_ACTIVE] : '';
            $this->forgot_code = array_key_exists(self::FIELD_FORGOT_CODE, $data) ? $data[self::FIELD_FORGOT_CODE] : '';
            $this->forgot_generated = array_key_exists(self::FIELD_FORGOT_GENERATED, $data) ? $data[self::FIELD_FORGOT_GENERATED] : '';
            $this->enabled = array_key_exists(self::FIELD_ENABLED, $data) ? $data[self::FIELD_ENABLED] : '';
            $this->last_login = array_key_exists(self::FIELD_LAST_LOGIN, $data) ? $data[self::FIELD_LAST_LOGIN] : '';
            $this->last_login_ip = array_key_exists(self::FIELD_LAST_LOGIN_IP, $data) ? $data[self::FIELD_LAST_LOGIN_IP] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_USER_ID] = $this->id;
      if($this->username !== '') $data[self::FIELD_USERNAME] = $this->username;
      if($this->password !== '') $data[self::FIELD_PASSWORD] = $this->password;
      if($this->password_last_set !== '') $data[self::FIELD_PASSWORD_LAST_SET] = $this->password_last_set;
      if($this->password_never_expires !== '') $data[self::FIELD_PASSWORD_NEVER_EXPIRES] = $this->password_never_expires;
      if($this->remember_me !== '') $data[self::FIELD_REMEMBER_ME] = $this->remember_me;
      if($this->activation_code !== '') $data[self::FIELD_ACTIVATION_CODE] = $this->activation_code;
      if($this->active !== '') $data[self::FIELD_ACTIVE] = $this->active;
      if($this->forgot_code !== '') $data[self::FIELD_FORGOT_CODE] = $this->forgot_code;
      if($this->forgot_generated !== '') $data[self::FIELD_FORGOT_GENERATED] = $this->forgot_generated;
      if($this->enabled !== '') $data[self::FIELD_ENABLED] = $this->enabled;
      if($this->last_login !== '') $data[self::FIELD_LAST_LOGIN] = $this->last_login;
      if($this->last_login_ip !== '') $data[self::FIELD_LAST_LOGIN_IP] = $this->last_login_ip;
      return $data;
   }
}