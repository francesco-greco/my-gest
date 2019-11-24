 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Intervention_cost_DTO extends DTO {
   const TABLE_NAME = 'intervention_cost';

   const FIELD_ID = 'id';
   const FIELD_ID_INTERVENTION = 'id_intervention';
   const FIELD_CREATION_DATE = 'creation_date';
   const FIELD_TOTAL_COST = 'total_cost';
   const FIELD_USER_GENERATOR = 'user_generator';

   public $id;
   public $id_intervention;
   public $creation_date;
   public $total_cost;
   public $user_generator;
   public $details;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_intervention = array_key_exists(self::FIELD_ID_INTERVENTION, $data) ? $data[self::FIELD_ID_INTERVENTION] : '';
         $this->creation_date = array_key_exists(self::FIELD_CREATION_DATE, $data) ? $data[self::FIELD_CREATION_DATE] : '';
         $this->total_cost = array_key_exists(self::FIELD_TOTAL_COST, $data) ? $data[self::FIELD_TOTAL_COST] : '';
         $this->user_generator = array_key_exists(self::FIELD_USER_GENERATOR, $data) ? $data[self::FIELD_USER_GENERATOR] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_intervention !== '') $data[self::FIELD_ID_INTERVENTION] = $this->id_intervention;
      if($this->creation_date !== '') $data[self::FIELD_CREATION_DATE] = $this->creation_date;
      if($this->total_cost !== '') $data[self::FIELD_TOTAL_COST] = $this->total_cost;
      if($this->user_generator !== '') $data[self::FIELD_USER_GENERATOR] = $this->user_generator;
      return $data;
   }
}

class Intervention_cost_details_DTO extends DTO {
   const TABLE_NAME = 'intervention_cost_details';

   const FIELD_ID = 'id';
   const FIELD_ID_INTERVENTION_COST = 'id_intervention_cost';
   const FIELD_TYPE = 'type';
   const FIELD_CREATION_DATE = 'creation_date';
   const FIELD_QUANTITA = 'quantita';
   const FIELD_PREZZO_UNITARIO = 'prezzo_unitario';
   const FIELD_TOTALE = 'totale';
   const FIELD_DESCRIZIONE = 'descrizione';
   const FIELD_UNITA_MISURA = 'unita_misura';
   const FIELD_ID_BRAND = 'id_brand';
   const FIELD_CODICE_ARTICOLO = 'codice_articolo';
   
   const TYPE_MANODOPERA = 1;
   const TYPE_MATERIALI = 2;
   const TYPE_MATERIALI_FUORI_GARANZIA = 3;

   public $id;
   public $id_intervention_cost;
   public $type;
   public $creation_date;
   public $quantita;
   public $prezzo_unitario;
   public $totale;
   public $descrizione;
   public $unita_misura;
   public $id_brand;
   public $codice_articolo;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_intervention_cost = array_key_exists(self::FIELD_ID_INTERVENTION_COST, $data) ? $data[self::FIELD_ID_INTERVENTION_COST] : '';
         $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
         $this->creation_date = array_key_exists(self::FIELD_CREATION_DATE, $data) ? $data[self::FIELD_CREATION_DATE] : '';
         $this->quantita = array_key_exists(self::FIELD_QUANTITA, $data) ? $data[self::FIELD_QUANTITA] : '';
         $this->prezzo_unitario = array_key_exists(self::FIELD_PREZZO_UNITARIO, $data) ? $data[self::FIELD_PREZZO_UNITARIO] : '';
         $this->totale = array_key_exists(self::FIELD_TOTALE, $data) ? $data[self::FIELD_TOTALE] : '';
         $this->descrizione = array_key_exists(self::FIELD_DESCRIZIONE, $data) ? $data[self::FIELD_DESCRIZIONE] : '';
         $this->unita_misura = array_key_exists(self::FIELD_UNITA_MISURA, $data) ? $data[self::FIELD_UNITA_MISURA] : '';
         $this->id_brand = array_key_exists(self::FIELD_ID_BRAND, $data) ? $data[self::FIELD_ID_BRAND] : '';
         $this->codice_articolo = array_key_exists(self::FIELD_CODICE_ARTICOLO, $data) ? $data[self::FIELD_CODICE_ARTICOLO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_intervention_cost !== '') $data[self::FIELD_ID_INTERVENTION_COST] = $this->id_intervention_cost;
      if($this->type !== '') $data[self::FIELD_TYPE] = $this->type;
      if($this->creation_date !== '') $data[self::FIELD_CREATION_DATE] = $this->creation_date;
      if($this->quantita !== '') $data[self::FIELD_QUANTITA] = $this->quantita;
      if($this->prezzo_unitario !== '') $data[self::FIELD_PREZZO_UNITARIO] = $this->prezzo_unitario;
      if($this->totale !== '') $data[self::FIELD_TOTALE] = $this->totale;
      if($this->descrizione !== '') $data[self::FIELD_DESCRIZIONE] = $this->descrizione;
      if($this->unita_misura !== '') $data[self::FIELD_UNITA_MISURA] = $this->unita_misura;
      if($this->id_brand !== '') $data[self::FIELD_ID_BRAND] = $this->id_brand;
      if($this->codice_articolo !== '') $data[self::FIELD_CODICE_ARTICOLO] = $this->codice_articolo;
      return $data;
   }
}