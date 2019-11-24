 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Brands_DTO extends DTO {
   const TABLE_NAME = 'brands';

   const FIELD_ID = 'id';
   const FIELD_BRAND_NAME = 'brand_name';
   const FIELD_BRAND_CODE = 'brand_code';
   const BRAND_BRAUN = 'BR';
   const BRAND_CAFFITALY = 'CF';
   const BRAND_DDOLO = 'DD';
   const BRAND_DELONGHI = 'DL';
   const BRAND_ESSE85 = 'ES';
   const BRAND_FRIZZO = 'FR';
   const BRAND_GAGGIA = 'GA';
   const BRAND_IMETEC = 'IM';
   
   public $id;
   public $brand_name;
   public $brand_code;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->brand_name = array_key_exists(self::FIELD_BRAND_NAME, $data) ? $data[self::FIELD_BRAND_NAME] : '';
         $this->brand_code = array_key_exists(self::FIELD_BRAND_CODE, $data) ? $data[self::FIELD_BRAND_CODE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->brand_name !== '') $data[self::FIELD_BRAND_NAME] = $this->brand_name;
      if($this->brand_code !== '') $data[self::FIELD_BRAND_CODE] = $this->brand_code;
      return $data;
   }
} 

