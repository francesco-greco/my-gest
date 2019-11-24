 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Headquarters_DTO extends DTO {
   const TABLE_NAME = 'headquarters';

   const FIELD_ID = 'id';
   const FIELD_ADDRESS = 'address';
   const FIELD_CIVIC_NUMBER = 'civic_number';
   const FIELD_BUSINESS_NAME = 'business_name';
   const FIELD_CITY = 'city';
   const FIELD_PROVINCIA = 'provincia';
   const FIELD_CAP = 'cap';
   const FIELD_P_IVA = 'p_iva';
   const FIELD_PHONE_1 = 'phone_1';
   const FIELD_PHONE_2 = 'phone_2';
   const FIELD_FAX = 'fax';
   const FIELD_EMAIL = 'email';
   const FIELD_RESPONSIBLE = 'responsible';
   const FIELD_UNIQUE_CODE = 'unique_code';
   const FIELD_WWW_SITE = 'www_site';
   const FIELD_IDENTIFICATION_CODE = 'identification_code';
   const FIELD_STOCK_CODE = 'stock_code';
   const FIELD_STOCK_DESCRIPTION = 'stock_description';

   public $id;
   public $address;
   public $civic_number;
   public $business_name;
   public $city;
   public $provincia;
   public $cap;
   public $p_iva;
   public $phone_1;
   public $phone_2;
   public $fax;
   public $email;
   public $responsible;
   public $unique_code;
   public $www_site;
   public $identification_code;
   public $stock_code;
   public $stock_description;

   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->address = array_key_exists(self::FIELD_ADDRESS, $data) ? $data[self::FIELD_ADDRESS] : '';
         $this->civic_number = array_key_exists(self::FIELD_CIVIC_NUMBER, $data) ? $data[self::FIELD_CIVIC_NUMBER] : '';
         $this->business_name = array_key_exists(self::FIELD_BUSINESS_NAME, $data) ? $data[self::FIELD_BUSINESS_NAME] : '';
         $this->city = array_key_exists(self::FIELD_CITY, $data) ? $data[self::FIELD_CITY] : '';
         $this->provincia = array_key_exists(self::FIELD_PROVINCIA, $data) ? $data[self::FIELD_PROVINCIA] : '';
         $this->cap = array_key_exists(self::FIELD_CAP, $data) ? $data[self::FIELD_CAP] : '';
         $this->p_iva = array_key_exists(self::FIELD_P_IVA, $data) ? $data[self::FIELD_P_IVA] : '';
         $this->phone_1 = array_key_exists(self::FIELD_PHONE_1, $data) ? $data[self::FIELD_PHONE_1] : '';
         $this->phone_2 = array_key_exists(self::FIELD_PHONE_2, $data) ? $data[self::FIELD_PHONE_2] : '';
         $this->fax = array_key_exists(self::FIELD_FAX, $data) ? $data[self::FIELD_FAX] : '';
         $this->email = array_key_exists(self::FIELD_EMAIL, $data) ? $data[self::FIELD_EMAIL] : '';
         $this->responsible = array_key_exists(self::FIELD_RESPONSIBLE, $data) ? $data[self::FIELD_RESPONSIBLE] : '';
         $this->unique_code = array_key_exists(self::FIELD_UNIQUE_CODE, $data) ? $data[self::FIELD_UNIQUE_CODE] : '';
         $this->www_site = array_key_exists(self::FIELD_WWW_SITE, $data) ? $data[self::FIELD_WWW_SITE] : '';
         $this->identification_code = array_key_exists(self::FIELD_IDENTIFICATION_CODE, $data) ? $data[self::FIELD_IDENTIFICATION_CODE] : '';
         $this->stock_code = array_key_exists(self::FIELD_STOCK_CODE, $data) ? $data[self::FIELD_STOCK_CODE] : '';
         $this->stock_description = array_key_exists(self::FIELD_STOCK_DESCRIPTION, $data) ? $data[self::FIELD_STOCK_DESCRIPTION] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->address !== '') $data[self::FIELD_ADDRESS] = $this->address;
      if($this->civic_number !== '') $data[self::FIELD_CIVIC_NUMBER] = $this->civic_number;
      if($this->business_name !== '') $data[self::FIELD_BUSINESS_NAME] = $this->business_name;
      if($this->city !== '') $data[self::FIELD_CITY] = $this->city;
      if($this->provincia !== '') $data[self::FIELD_PROVINCIA] = $this->provincia;
      if($this->cap !== '') $data[self::FIELD_CAP] = $this->cap;
      if($this->p_iva !== '') $data[self::FIELD_P_IVA] = $this->p_iva;
      if($this->phone_1 !== '') $data[self::FIELD_PHONE_1] = $this->phone_1;
      if($this->phone_2 !== '') $data[self::FIELD_PHONE_2] = $this->phone_2;
      if($this->fax !== '') $data[self::FIELD_FAX] = $this->fax;
      if($this->email !== '') $data[self::FIELD_EMAIL] = $this->email;
      if($this->responsible !== '') $data[self::FIELD_RESPONSIBLE] = $this->responsible;
      if($this->unique_code !== '') $data[self::FIELD_UNIQUE_CODE] = $this->unique_code;
      if($this->www_site !== '') $data[self::FIELD_WWW_SITE] = $this->www_site;
      if($this->identification_code !== '') $data[self::FIELD_IDENTIFICATION_CODE] = $this->identification_code;
      if($this->stock_code !== '') $data[self::FIELD_STOCK_CODE] = $this->stock_code;
      if($this->stock_description !== '') $data[self::FIELD_STOCK_DESCRIPTION] = $this->stock_description;
      return $data;
   }
} 