<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Client_data_DTO extends DTO {
    const TABLE_NAME = 'client_data';

    const FIELD_USERDATA_ID = 'userdata_id';
    const FIELD_USER_ID = 'user_id';
    const FIELD_FULLNAME = 'fullname';
    const FIELD_SURNAME = 'surname';
    const FIELD_NAME = 'name';
    const FIELD_PREFERRED_LANG = 'preferred_lang';
    const FIELD_EMAIL = 'email';
    const FIELD_PHONE_1 = 'phone_1';
    const FIELD_PHONE_2 = 'phone_2';
    const FIELD_ADDRESS = 'address';
    const FIELD_CAP = 'cap';
    const FIELD_CITY = 'city';
    const FIELD_PROV = 'provincia';
    const FIELD_CIVIC_NUMBER = 'civic_number';
    const FIELD_FISCAL_CODE = 'fiscal_code';

    public $id;
    public $user_id;
    public $fullname;
    public $name;
    public $surname;
    public $preferred_lang;
    public $email;
    public $phone_1;
    public $phone_2;
    public $address;
    public $cap;
    public $city;
    public $provincia;
    public $civic_number;
    public $fiscal_code;
    
    public function init($data) {
        if( ! is_array($data) && ! is_object($data)) {
            $this->pulisci();
        }
        else {
            $data = (array) $data;
            $this->id = array_key_exists(self::FIELD_USERDATA_ID, $data) ? $data[self::FIELD_USERDATA_ID] : '';
            $this->user_id = array_key_exists(self::FIELD_USER_ID, $data) ? $data[self::FIELD_USER_ID] : '';
            $this->fullname = array_key_exists(self::FIELD_FULLNAME, $data) ? $data[self::FIELD_FULLNAME] : '';
            $this->name = array_key_exists(self::FIELD_NAME, $data) ? $data[self::FIELD_NAME] : '';
            $this->surname = array_key_exists(self::FIELD_SURNAME, $data) ? $data[self::FIELD_SURNAME] : '';
            $this->preferred_lang = array_key_exists(self::FIELD_PREFERRED_LANG, $data) ? $data[self::FIELD_PREFERRED_LANG] : '';
            $this->email = array_key_exists(self::FIELD_EMAIL, $data) ? $data[self::FIELD_EMAIL] : '';
            $this->phone_1 = array_key_exists(self::FIELD_PHONE_1, $data) ? $data[self::FIELD_PHONE_1] : '';
            $this->phone_2 = array_key_exists(self::FIELD_PHONE_2, $data) ? $data[self::FIELD_PHONE_2] : '';
            $this->address = array_key_exists(self::FIELD_ADDRESS, $data) ? $data[self::FIELD_ADDRESS] : '';
            $this->cap = array_key_exists(self::FIELD_CAP, $data) ? $data[self::FIELD_CAP] : '';
            $this->city = array_key_exists(self::FIELD_CITY, $data) ? $data[self::FIELD_CITY] : '';
            $this->provincia = array_key_exists(self::FIELD_PROV, $data) ? $data[self::FIELD_PROV] : '';
            $this->civic_number = array_key_exists(self::FIELD_CIVIC_NUMBER, $data) ? $data[self::FIELD_CIVIC_NUMBER] : '';
            $this->fiscal_code = array_key_exists(self::FIELD_FISCAL_CODE, $data) ? $data[self::FIELD_FISCAL_CODE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_USERDATA_ID] = $this->id;
      if($this->user_id !== '') $data[self::FIELD_USER_ID] = $this->user_id;
      if($this->fullname !== '') $data[self::FIELD_FULLNAME] = $this->fullname;
      if($this->name !== '') $data[self::FIELD_NAME] = $this->name;
      if($this->surname !== '') $data[self::FIELD_SURNAME] = $this->surname;
      if($this->preferred_lang !== '') $data[self::FIELD_PREFERRED_LANG] = $this->preferred_lang;
      if($this->email !== '') $data[self::FIELD_EMAIL] = $this->email;
      if($this->phone_1 !== '') $data[self::FIELD_PHONE_1] = $this->phone_1;
      if($this->phone_2 !== '') $data[self::FIELD_PHONE_2] = $this->phone_2;
      if($this->address !== '') $data[self::FIELD_ADDRESS] = $this->address;
      if($this->cap !== '') $data[self::FIELD_CAP] = $this->cap;
      if($this->city !== '') $data[self::FIELD_CITY] = $this->city;
      if($this->provincia !== '') $data[self::FIELD_PROV] = $this->provincia;
      if($this->civic_number !== '') $data[self::FIELD_CIVIC_NUMBER] = $this->civic_number;
      if($this->fiscal_code !== '') $data[self::FIELD_FISCAL_CODE] = $this->fiscal_code;
      return $data;
   }
}