 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Ddt_DTO extends DTO {
   const TABLE_NAME = 'ddt';

   const FIELD_ID = 'id';
   const FIELD_ID_FORNITORE = 'id_fornitore';
   const FIELD_DATA_CREAZIONE = 'data_creazione';
   const FIELD_ID_SEDE = 'id_sede';
   const FIELD_DATA_DOCUMENTO = 'data_documento';
   const FIELD_NUMERO_DOCUMENTO = 'numero_documento';
   const FIELD_NUMERO_COLLI = 'numero_colli';
   const FIELD_PESO = 'peso';
   const FIELD_NOTE = 'note';
   const FIELD_VETTORE = 'vettore';
   const FIELD_STATO = 'stato';
   const STATO_APERTO = 1;
   const STATO_CHIUSO = 2;

   public $id;
   public $id_fornitore;
   public $data_creazione;
   public $id_sede;
   public $data_documento;
   public $numero_documento;
   public $numero_colli;
   public $peso;
   public $note;
   public $vettore;
   public $stato;
   public $fornitore;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_fornitore = array_key_exists(self::FIELD_ID_FORNITORE, $data) ? $data[self::FIELD_ID_FORNITORE] : '';
         $this->id_sede = array_key_exists(self::FIELD_ID_SEDE, $data) ? $data[self::FIELD_ID_SEDE] : '';
         $this->data_creazione = array_key_exists(self::FIELD_DATA_CREAZIONE, $data) ? $data[self::FIELD_DATA_CREAZIONE] : '';
         $this->data_documento = array_key_exists(self::FIELD_DATA_DOCUMENTO, $data) ? db_to_normal_date($data[self::FIELD_DATA_DOCUMENTO]) : '';
         $this->numero_documento = array_key_exists(self::FIELD_NUMERO_DOCUMENTO, $data) ? $data[self::FIELD_NUMERO_DOCUMENTO] : '';
         $this->numero_colli = array_key_exists(self::FIELD_NUMERO_COLLI, $data) ? $data[self::FIELD_NUMERO_COLLI] : '';
         $this->peso = array_key_exists(self::FIELD_PESO, $data) ? $data[self::FIELD_PESO] : '';
         $this->note = array_key_exists(self::FIELD_NOTE, $data) ? $data[self::FIELD_NOTE] : '';
         $this->vettore = array_key_exists(self::FIELD_VETTORE, $data) ? $data[self::FIELD_VETTORE] : '';
         $this->stato = array_key_exists(self::FIELD_STATO, $data) ? $data[self::FIELD_STATO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_fornitore !== '') $data[self::FIELD_ID_FORNITORE] = $this->id_fornitore;
      if($this->id_sede !== '') $data[self::FIELD_ID_SEDE] = $this->id_sede;
      if($this->data_creazione !== '') $data[self::FIELD_DATA_CREAZIONE] = $this->data_creazione;
      if($this->data_documento !== '') $data[self::FIELD_DATA_DOCUMENTO] = normal_to_db_date ($this->data_documento);
      if($this->numero_documento !== '') $data[self::FIELD_NUMERO_DOCUMENTO] = $this->numero_documento;
      if($this->numero_colli !== '') $data[self::FIELD_NUMERO_COLLI] = $this->numero_colli;
      if($this->peso !== '') $data[self::FIELD_PESO] = $this->peso;
      if($this->note !== '') $data[self::FIELD_NOTE] = $this->note;
      if($this->vettore !== '') $data[self::FIELD_VETTORE] = $this->vettore;
      if($this->stato !== '') $data[self::FIELD_STATO] = $this->stato;
      return $data;
   }
} 

class Ddt_dettaglio_DTO extends DTO {
   const TABLE_NAME = 'ddt_dettaglio';

   const FIELD_ID = 'id';
   const FIELD_ID_DDT = 'id_ddt';
   const FIELD_ID_BRAND = 'id_brand';
   const FIELD_CODICE_BRAND = 'codice_brand';
   const FIELD_CODICE_ARTICOLO = 'codice_articolo';
   const FIELD_QUANTITA = 'quantita';
   const FIELD_UNITA_MISURA = 'unita_misura';
   const FIELD_DESCRIZIONE = 'descrizione';

   public $id;
   public $id_ddt;
   public $id_brand;
   public $codice_brand;
   public $codice_articolo;
   public $quantita;
   public $unita_misura;
   public $descrizione;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_ddt = array_key_exists(self::FIELD_ID_DDT, $data) ? $data[self::FIELD_ID_DDT] : '';
         $this->id_brand = array_key_exists(self::FIELD_ID_BRAND, $data) ? $data[self::FIELD_ID_BRAND] : '';
         $this->codice_brand = array_key_exists(self::FIELD_CODICE_BRAND, $data) ? $data[self::FIELD_CODICE_BRAND] : '';
         $this->codice_articolo = array_key_exists(self::FIELD_CODICE_ARTICOLO, $data) ? $data[self::FIELD_CODICE_ARTICOLO] : '';
         $this->quantita = array_key_exists(self::FIELD_QUANTITA, $data) ? $data[self::FIELD_QUANTITA] : '';
         $this->unita_misura = array_key_exists(self::FIELD_UNITA_MISURA, $data) ? $data[self::FIELD_UNITA_MISURA] : '';
         $this->descrizione = array_key_exists(self::FIELD_DESCRIZIONE, $data) ? $data[self::FIELD_DESCRIZIONE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_ddt !== '') $data[self::FIELD_ID_DDT] = $this->id_ddt;
      if($this->id_brand !== '') $data[self::FIELD_ID_BRAND] = $this->id_brand;
      if($this->codice_brand !== '') $data[self::FIELD_CODICE_BRAND] = $this->codice_brand;
      if($this->codice_articolo !== '') $data[self::FIELD_CODICE_ARTICOLO] = $this->codice_articolo;
      if($this->quantita !== '') $data[self::FIELD_QUANTITA] = $this->quantita;
      if($this->unita_misura !== '') $data[self::FIELD_UNITA_MISURA] = $this->unita_misura;
      return $data;
   }
}
