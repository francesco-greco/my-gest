 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Intervention_DTO extends DTO {
   const TABLE_NAME = 'intervention';

   const FIELD_ID = 'id';
   const FIELD_INTERVENTION_CODE = 'intervention_code';
   const FIELD_ID_SEDE = 'id_sede';
   const FIELD_ID_CLIENT = 'id_client';
   const FIELD_ID_PROCESSING_STAGE = 'id_processing_stage';
   const FIELD_ID_CATEGORIA = 'id_categoria';
   const FIELD_CREATION_DATE = 'creation_date';
   const FIELD_USER_ID_CREATION = 'user_id_creation';
   const FIELD_ID_BRAND = 'id_brand';
   const FIELD_MODEL = 'model';
   const FIELD_SERIAL_NUMBER = 'serial_number';
   const FIELD_OBJECT_DESCRIPTION = 'object_description';
   const FIELD_PURCHASE_DATE = 'purchase_date';
   const FIELD_WARRANTY_YES = 'warranty_yes';
   const FIELD_RECEIPT_PRESENT = 'receipt_present';
   const FIELD_PREVIOUS_FAILURES = 'previous_failures';
   const FIELD_PRICE_QUOTATION = 'price_quotation';
   const FIELD_SPENDING_LIMIT = 'spending_limit';
   const FIELD_SPENDING_LIMIT_AMOUNT = 'spending_limit_amount';
   const FIELD_DESCRIPTION = 'description';
   const FIELD_PRODUCT_ENTRY_NOTES = 'product_entry_notes';
   const FIELD_EXPECTED_DELIVERY_DATE = 'expected_delivery_date';
   const FIELD_DEPOSIT = 'deposit';
   const FIELD_STATUS = 'status';
   
   const SELECTED_YES = 1;
   const SELECTED_NO = 2;
   const STATUS_OPENED = 1;
   const STATUS_CLOSED = 2;
   const WARRENTY_YES = 1;
   const WARRENTY_NO = 2;

   public $id;
   public $intervention_code;
   public $id_sede;
   public $id_client;
   public $client;
   public $id_processing_stage;
   public $id_categoria;
   public $processing_stage;
   public $creation_date;
   public $user_id_creation;
   public $id_brand;
   public $brand;
   public $model;
   public $categoria;
   public $serial_number;
   public $object_description;
   public $purchase_date;
   public $warranty_yes;
   public $receipt_present;
   public $previous_failures;
   public $price_quotation;
   public $spending_limit;
   public $spending_limit_amount;
   public $description;
   public $product_entry_notes;
   public $expected_delivery_date;
   public $deposit;
   public $status;
   public $extra_data;


   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_client = array_key_exists(self::FIELD_ID_BRAND, $data) ? $data[self::FIELD_ID_CLIENT] : '';
         $this->id_sede = array_key_exists(self::FIELD_ID_SEDE, $data) ? $data[self::FIELD_ID_SEDE] : '';
         $this->id_categoria = array_key_exists(self::FIELD_ID_CATEGORIA, $data) ? $data[self::FIELD_ID_CATEGORIA] : '';
         $this->intervention_code = array_key_exists(self::FIELD_INTERVENTION_CODE, $data) ? $data[self::FIELD_INTERVENTION_CODE] : '';
         $this->id_processing_stage = array_key_exists(self::FIELD_ID_PROCESSING_STAGE, $data) ? $data[self::FIELD_ID_PROCESSING_STAGE] : '';
         $this->creation_date = array_key_exists(self::FIELD_CREATION_DATE, $data) ? $data[self::FIELD_CREATION_DATE] : '';
         $this->user_id_creation = array_key_exists(self::FIELD_USER_ID_CREATION, $data) ? $data[self::FIELD_USER_ID_CREATION] : '';
         $this->id_brand = array_key_exists(self::FIELD_ID_BRAND, $data) ? $data[self::FIELD_ID_BRAND] : '';
         $this->model = array_key_exists(self::FIELD_MODEL, $data) ? $data[self::FIELD_MODEL] : '';
         $this->serial_number = array_key_exists(self::FIELD_SERIAL_NUMBER, $data) ? $data[self::FIELD_SERIAL_NUMBER] : '';
         $this->object_description = array_key_exists(self::FIELD_OBJECT_DESCRIPTION, $data) ? $data[self::FIELD_OBJECT_DESCRIPTION] : '';
         $this->purchase_date = array_key_exists(self::FIELD_PURCHASE_DATE, $data) ? $data[self::FIELD_PURCHASE_DATE] : '';
         $this->warranty_yes = array_key_exists(self::FIELD_WARRANTY_YES, $data) ? $data[self::FIELD_WARRANTY_YES] : '';
         $this->receipt_present = array_key_exists(self::FIELD_RECEIPT_PRESENT, $data) ? $data[self::FIELD_RECEIPT_PRESENT] : '';
         $this->previous_failures = array_key_exists(self::FIELD_PREVIOUS_FAILURES, $data) ? $data[self::FIELD_PREVIOUS_FAILURES] : '';
         $this->price_quotation = array_key_exists(self::FIELD_PRICE_QUOTATION, $data) ? $data[self::FIELD_PRICE_QUOTATION] : '';
         $this->spending_limit = array_key_exists(self::FIELD_SPENDING_LIMIT, $data) ? $data[self::FIELD_SPENDING_LIMIT] : '';
         $this->spending_limit_amount = array_key_exists(self::FIELD_SPENDING_LIMIT_AMOUNT, $data) ? $data[self::FIELD_SPENDING_LIMIT_AMOUNT] : '';
         $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
         $this->product_entry_notes = array_key_exists(self::FIELD_PRODUCT_ENTRY_NOTES, $data) ? $data[self::FIELD_PRODUCT_ENTRY_NOTES] : '';
         $this->expected_delivery_date = array_key_exists(self::FIELD_EXPECTED_DELIVERY_DATE, $data) ? $data[self::FIELD_EXPECTED_DELIVERY_DATE] : '';
         $this->deposit = array_key_exists(self::FIELD_DEPOSIT, $data) ? $data[self::FIELD_DEPOSIT] : '';
         $this->status = array_key_exists(self::FIELD_STATUS, $data) ? $data[self::FIELD_STATUS] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_sede !== '') $data[self::FIELD_ID_SEDE] = $this->id_sede;
      if($this->id_categoria !== '') $data[self::FIELD_ID_CATEGORIA] = $this->id_categoria;
      if($this->id_client !== '') $data[self::FIELD_ID_CLIENT] = $this->id_client;
      if($this->intervention_code !== '') $data[self::FIELD_INTERVENTION_CODE] = $this->intervention_code;
      if($this->id_processing_stage !== '') $data[self::FIELD_ID_PROCESSING_STAGE] = $this->id_processing_stage;
      if($this->creation_date !== '') $data[self::FIELD_CREATION_DATE] = $this->creation_date;
      if($this->user_id_creation !== '') $data[self::FIELD_USER_ID_CREATION] = $this->user_id_creation;
      if($this->id_brand !== '') $data[self::FIELD_ID_BRAND] = $this->id_brand;
      if($this->model !== '') $data[self::FIELD_MODEL] = $this->model;
      if($this->serial_number !== '') $data[self::FIELD_SERIAL_NUMBER] = $this->serial_number;
      if($this->object_description !== '') $data[self::FIELD_OBJECT_DESCRIPTION] = $this->object_description;
      if($this->purchase_date !== '') $data[self::FIELD_PURCHASE_DATE] = normal_to_db_date ($this->purchase_date);
      if($this->warranty_yes !== '') $data[self::FIELD_WARRANTY_YES] = $this->warranty_yes;
      if($this->receipt_present !== '') $data[self::FIELD_RECEIPT_PRESENT] = $this->receipt_present;
      if($this->previous_failures !== '') $data[self::FIELD_PREVIOUS_FAILURES] = $this->previous_failures;
      if($this->price_quotation !== '') $data[self::FIELD_PRICE_QUOTATION] = $this->price_quotation;
      if($this->spending_limit !== '') $data[self::FIELD_SPENDING_LIMIT] = $this->spending_limit;
      if($this->spending_limit_amount !== '') $data[self::FIELD_SPENDING_LIMIT_AMOUNT] = $this->spending_limit_amount;
      if($this->description !== '') $data[self::FIELD_DESCRIPTION] = $this->description;
      if($this->product_entry_notes !== '') $data[self::FIELD_PRODUCT_ENTRY_NOTES] = $this->product_entry_notes;
      if($this->expected_delivery_date !== '') $data[self::FIELD_EXPECTED_DELIVERY_DATE] = normal_to_db_date ($this->expected_delivery_date);
      if($this->deposit !== '') $data[self::FIELD_DEPOSIT] = $this->deposit;
      if($this->status !== '') $data[self::FIELD_STATUS] = $this->status;
      return $data;
   }
   
   public function is_warrenty(){
      return $this->warranty_yes == self::WARRENTY_YES ? TRUE : FALSE;
   }
}

class Interventi_categoria_DTO extends DTO {
   const TABLE_NAME = 'interventi_categoria';

   const FIELD_ID = 'id';
   const FIELD_CATEGORIA = 'categoria';
   const FIELD_MASSIMO_RIPARAZIONI_GIORNALIERE = 'massimo_riparazioni_giornaliere';
   const FIELD_ABILITATO = 'abilitato';

   public $id;
   public $categoria;
   public $massimo_riparazioni_giornaliere;
   public $abilitato;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->categoria = array_key_exists(self::FIELD_CATEGORIA, $data) ? $data[self::FIELD_CATEGORIA] : '';
         $this->massimo_riparazioni_giornaliere = array_key_exists(self::FIELD_MASSIMO_RIPARAZIONI_GIORNALIERE, $data) ? $data[self::FIELD_MASSIMO_RIPARAZIONI_GIORNALIERE] : '';
         $this->abilitato = array_key_exists(self::FIELD_ABILITATO, $data) ? $data[self::FIELD_ABILITATO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->categoria !== '') $data[self::FIELD_CATEGORIA] = $this->categoria;
      if($this->massimo_riparazioni_giornaliere !== '') $data[self::FIELD_MASSIMO_RIPARAZIONI_GIORNALIERE] = $this->massimo_riparazioni_giornaliere;
      if($this->abilitato !== '') $data[self::FIELD_ABILITATO] = $this->abilitato;
      return $data;
   }
}
