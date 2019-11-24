 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Processing_stage_DTO extends DTO {
   const TABLE_NAME = 'processing_stage';

   const FIELD_ID = 'id';
   const FIELD_PROCESSING_STAGE_LABEL = 'processing_stage_label';
   const FIELD_PROCESSING_STAGE = 'processing_stage';
   const FIELD_ENABLE = 'enable';
   
   const STAGE_AVVIO = 'AVVIO';
   const STAGE_PRODOTTO_DAL_TECNICO = 'PRODOTTO_DAL_TECNICO';
   const STAGE_DIAGNOSI_ESEGUITA = 'DIAGNOSI_ESEGUITA';
   const STAGE_ATTESA_RICAMBI_LAVORAZIONE = 'ATTESA_RICAMBI_LAVORAZIONE';
   const STAGE_ATTESA_CLIENTE = 'ATTESA_CLIENTE';
   const STAGE_ESECUZIONE_RIPARAZIONE = 'ESECUZIONE_RIPARAZIONE';
   const STAGE_RIPARAZIONE_NON_ESEGUITA = 'RIPARAZIONE_NON_ESEGUITA';
   const STAGE_TEST = 'TEST';
   const STAGE_RIPARAZIONE_ESEGUITA = 'RIPARAZIONE_ESEGUITA';
   const STAGE_RICONSEGNA_CLIENTE = 'RICONSEGNA_CLIENTE';
   const STAGE_CHECK_RIPARAZIONE = 'CHECK_RIPARAZIONE';
   const STAGE_PRODOTTO_RITORNO_BANCO = 'PRODOTTO_RITORNO_BANCO';

   public $id;
   public $processing_stage_label;
   public $processing_stage;
   public $enable;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->processing_stage_label = array_key_exists(self::FIELD_PROCESSING_STAGE_LABEL, $data) ? $data[self::FIELD_PROCESSING_STAGE_LABEL] : '';
         $this->processing_stage = array_key_exists(self::FIELD_PROCESSING_STAGE, $data) ? $data[self::FIELD_PROCESSING_STAGE] : '';
         $this->enable = array_key_exists(self::FIELD_ENABLE, $data) ? $data[self::FIELD_ENABLE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->processing_stage_label !== '') $data[self::FIELD_PROCESSING_STAGE_LABEL] = $this->processing_stage_label;
      if($this->processing_stage !== '') $data[self::FIELD_PROCESSING_STAGE] = $this->processing_stage;
      if($this->enable !== '') $data[self::FIELD_ENABLE] = $this->enable;
      return $data;
   }
   
} 

