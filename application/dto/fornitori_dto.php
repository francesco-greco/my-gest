 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Fornitori_DTO extends DTO {
   const TABLE_NAME = 'fornitori';

   const FIELD_ID = 'id';
   const FIELD_RAGIONE_SOCIALE = 'ragione_sociale';
   const FIELD_INDIRIZZO = 'indirizzo';
   const FIELD_NUMERO_CIVICO = 'numero_civico';
   const FIELD_CAP = 'cap';
   const FIELD_TELEFONO_1 = 'telefono_1';
   const FIELD_TELEFONO_2 = 'telefono_2';
   const FIELD_FAX = 'fax';
   const FIELD_EMAIL_1 = 'email_1';
   const FIELD_EMAIL_2 = 'email_2';
   const FIELD_REFERENTE = 'referente';
   const FIELD_REFERENTE_RECAPITO = 'referente_recapito';
   const FIELD_P_IVA = 'p_iva';
   const FIELD_CODICE_FISCALE = 'codice_fiscale';
   const FIELD_WEB_SITE = 'web_site';
   const FIELD_CITTA = 'citta';
   const FIELD_PROVINCIA = 'provincia';
   const FIELD_NAZIONE = 'nazione';
   const FIELD_CONVENZIONATO = 'convenzionato';
   const FIELD_DATA_INSERIMENTO = 'data_inserimento';
   const FIELD_ENABLED = 'enabled';
   const FORNITORE_ABILITATO = 1;
   const FORNITORE_DISABILITATO = 2;
   const CONVENZIONATO_SI = 1;
   const CONVENZIONATO_NO = 2;

   public $id;
   public $ragione_sociale;
   public $indirizzo;
   public $numero_civico;
   public $cap;
   public $telefono_1;
   public $telefono_2;
   public $fax;
   public $email_1;
   public $email_2;
   public $referente;
   public $referente_recapito;
   public $p_iva;
   public $codice_fiscale;
   public $web_site;
   public $citta;
   public $provincia;
   public $nazione;
   public $convenzionato;
   public $data_inserimento;
   public $enabled;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->ragione_sociale = array_key_exists(self::FIELD_RAGIONE_SOCIALE, $data) ? $data[self::FIELD_RAGIONE_SOCIALE] : '';
         $this->indirizzo = array_key_exists(self::FIELD_INDIRIZZO, $data) ? $data[self::FIELD_INDIRIZZO] : '';
         $this->numero_civico = array_key_exists(self::FIELD_NUMERO_CIVICO, $data) ? $data[self::FIELD_NUMERO_CIVICO] : '';
         $this->cap = array_key_exists(self::FIELD_CAP, $data) ? $data[self::FIELD_CAP] : '';
         $this->telefono_1 = array_key_exists(self::FIELD_TELEFONO_1, $data) ? $data[self::FIELD_TELEFONO_1] : '';
         $this->telefono_2 = array_key_exists(self::FIELD_TELEFONO_2, $data) ? $data[self::FIELD_TELEFONO_2] : '';
         $this->fax = array_key_exists(self::FIELD_FAX, $data) ? $data[self::FIELD_FAX] : '';
         $this->email_1 = array_key_exists(self::FIELD_EMAIL_1, $data) ? $data[self::FIELD_EMAIL_1] : '';
         $this->email_2 = array_key_exists(self::FIELD_EMAIL_2, $data) ? $data[self::FIELD_EMAIL_2] : '';
         $this->referente = array_key_exists(self::FIELD_REFERENTE, $data) ? $data[self::FIELD_REFERENTE] : '';
         $this->referente_recapito = array_key_exists(self::FIELD_REFERENTE_RECAPITO, $data) ? $data[self::FIELD_REFERENTE_RECAPITO] : '';
         $this->p_iva = array_key_exists(self::FIELD_P_IVA, $data) ? $data[self::FIELD_P_IVA] : '';
         $this->codice_fiscale = array_key_exists(self::FIELD_CODICE_FISCALE, $data) ? $data[self::FIELD_CODICE_FISCALE] : '';
         $this->web_site = array_key_exists(self::FIELD_WEB_SITE, $data) ? $data[self::FIELD_WEB_SITE] : '';
         $this->citta = array_key_exists(self::FIELD_CITTA, $data) ? $data[self::FIELD_CITTA] : '';
         $this->provincia = array_key_exists(self::FIELD_PROVINCIA, $data) ? $data[self::FIELD_PROVINCIA] : '';
         $this->nazione = array_key_exists(self::FIELD_NAZIONE, $data) ? $data[self::FIELD_NAZIONE] : '';
         $this->convenzionato = array_key_exists(self::FIELD_CONVENZIONATO, $data) ? $data[self::FIELD_CONVENZIONATO] : '';
         $this->data_inserimento = array_key_exists(self::FIELD_DATA_INSERIMENTO, $data) ? $data[self::FIELD_DATA_INSERIMENTO] : '';
         $this->enabled = array_key_exists(self::FIELD_ENABLED, $data) ? $data[self::FIELD_ENABLED] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->ragione_sociale !== '') $data[self::FIELD_RAGIONE_SOCIALE] = $this->ragione_sociale;
      if($this->indirizzo !== '') $data[self::FIELD_INDIRIZZO] = $this->indirizzo;
      if($this->numero_civico !== '') $data[self::FIELD_NUMERO_CIVICO] = $this->numero_civico;
      if($this->cap !== '') $data[self::FIELD_CAP] = $this->cap;
      if($this->telefono_1 !== '') $data[self::FIELD_TELEFONO_1] = $this->telefono_1;
      if($this->telefono_2 !== '') $data[self::FIELD_TELEFONO_2] = $this->telefono_2;
      if($this->fax !== '') $data[self::FIELD_FAX] = $this->fax;
      if($this->email_1 !== '') $data[self::FIELD_EMAIL_1] = $this->email_1;
      if($this->email_2 !== '') $data[self::FIELD_EMAIL_2] = $this->email_2;
      if($this->referente !== '') $data[self::FIELD_REFERENTE] = $this->referente;
      if($this->referente_recapito !== '') $data[self::FIELD_REFERENTE_RECAPITO] = $this->referente_recapito;
      if($this->p_iva !== '') $data[self::FIELD_P_IVA] = $this->p_iva;
      if($this->codice_fiscale !== '') $data[self::FIELD_CODICE_FISCALE] = $this->codice_fiscale;
      if($this->web_site !== '') $data[self::FIELD_WEB_SITE] = $this->web_site;
      if($this->citta !== '') $data[self::FIELD_CITTA] = $this->citta;
      if($this->provincia !== '') $data[self::FIELD_PROVINCIA] = $this->provincia;
      if($this->nazione !== '') $data[self::FIELD_NAZIONE] = $this->nazione;
      if($this->convenzionato !== '') $data[self::FIELD_CONVENZIONATO] = $this->convenzionato;
      if($this->data_inserimento !== '') $data[self::FIELD_DATA_INSERIMENTO] = $this->data_inserimento;
      if($this->enabled !== '') $data[self::FIELD_ENABLED] = $this->enabled;
      return $data;
   }
} 