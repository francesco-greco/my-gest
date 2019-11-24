 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Intervention_notes_DTO extends DTO {
   const TABLE_NAME = 'intervention_notes';

   const FIELD_ID = 'id';
   const FIELD_ID_INTERVENTION = 'id_intervention';
   const FIELD_USER_ID = 'user_id';
   const FIELD_USER_FULLNAME = 'user_fullname';
   const FIELD_CREATION_DATE = 'creation_date';
   const FIELD_NOTE_TEXT = 'note_text';
   const FIELD_NOTE_CODE = 'note_code';
   
   //GENERIC
   const NOTE_CODE_GENERICA = 'G00';
   //TECNICAL
   const NOTE_CODE_START_TECNICO = 'T01';
   const NOTE_CODE_ESEGUITO = 'T03';
   const NOTE_CODE_DIAGNOSI = 'T02';
   const NOTE_CODE_ATTESA_RICAMBI = 'T04';
   const NOTE_CODE_CONTATTO_CLIENTE = 'T05';
   const NOTE_CODE_ATTESA_CLIENTE = 'T06';
   const NOTE_CODE_CHECK_RIPARAZIONE = 'T07';
   const NOTE_CODE_RITORNO_BANCO = 'T08';
   //BENCH
   const NOTE_CODE_ROTTAMAZIONE = 'B01';
   const NOTE_CODE_RICONSEGNA_CLIENTE = 'B02';
   //posthumous note
   const NOTE_CODE_POSTHUMOUS = 'PST';
   
   public $id;
   public $user_id;
   public $user_fullname;
   public $creation_date;
   public $note_text;
   public $id_intervention;
   public $note_code;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_intervention = array_key_exists(self::FIELD_ID_INTERVENTION, $data) ? $data[self::FIELD_ID_INTERVENTION] : '';
         $this->user_id = array_key_exists(self::FIELD_USER_ID, $data) ? $data[self::FIELD_USER_ID] : '';
         $this->user_fullname = array_key_exists(self::FIELD_USER_FULLNAME, $data) ? $data[self::FIELD_USER_FULLNAME] : '';
         $this->creation_date = array_key_exists(self::FIELD_CREATION_DATE, $data) ? $data[self::FIELD_CREATION_DATE] : '';
         $this->note_text = array_key_exists(self::FIELD_NOTE_TEXT, $data) ? $data[self::FIELD_NOTE_TEXT] : '';
         $this->note_code = array_key_exists(self::FIELD_NOTE_CODE, $data) ? $data[self::FIELD_NOTE_CODE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_intervention !== '') $data[self::FIELD_ID_INTERVENTION] = $this->id_intervention;
      if($this->user_id !== '') $data[self::FIELD_USER_ID] = $this->user_id;
      if($this->user_fullname !== '') $data[self::FIELD_USER_FULLNAME] = $this->user_fullname;
      if($this->creation_date !== '') $data[self::FIELD_CREATION_DATE] = $this->creation_date;
      if($this->note_text !== '') $data[self::FIELD_NOTE_TEXT] = $this->note_text;
      if($this->note_code !== '') $data[self::FIELD_NOTE_CODE] = $this->note_code;
      return $data;
   }
   
   public static function get_tecnical_notes() {
        $array = array(
            self::NOTE_CODE_START_TECNICO => "Prodotto in lavorazione",
//            self::NOTE_CODE_DIAGNOSI => "Diagnosi effettuata",
//            self::NOTE_CODE_ESEGUITO => "Riparazione eseguita",
            self::NOTE_CODE_ATTESA_RICAMBI => "Attesa ricambi",
            self::NOTE_CODE_CONTATTO_CLIENTE => "Contatto cliente",
//            self::NOTE_CODE_CHECK_RIPARAZIONE => "Check list riparazione",
            self::NOTE_CODE_RITORNO_BANCO => "Prodotto ritorno al banco"
        );
        return $array;
    }
    
    public static function get_banch_notes() {
        $array = array(
            self::NOTE_CODE_ROTTAMAZIONE => "Prodotto rottamato",
            self::NOTE_CODE_RICONSEGNA_CLIENTE => "Riconsegna cliente"
        );
        return $array;
    }
    
    public static function get_all_notes_code(){
        $note_tec = self::get_tecnical_notes();
        $note_banch = self::get_banch_notes();
        $merge = array_merge($note_banch, $note_tec);
        $merge[self::NOTE_CODE_GENERICA] = "Nota generica";
        return $merge;
    }
    
    public static function get_posthumous_notes_code() {
      $array = array(
          self::NOTE_CODE_POSTHUMOUS => "Nota postuma"
      );
      return $array;
   }

} 
