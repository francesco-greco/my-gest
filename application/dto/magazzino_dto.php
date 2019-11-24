 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Magazzino_zero_DTO extends DTO {
   const TABLE_NAME = 'magazzino_zero';

   const FIELD_ID = 'id';
   const FIELD_ID_LISTINO = 'id_listino';
   const FIELD_LISTINO_CODICE = 'listino_codice';
   const FIELD_QUANTITA = 'quantita';
   const FIELD_OPERATORE_ULTIMO_AGGIORNAMENTO = 'operatore_ultimo_aggiornamento';
//   const FIELD_SCORTA_MINIMA = 'scorta_minima';
   const FIELD_UBICAZIONE = 'ubicazione';
   const FIELD_DATA_ULTIMO_INGRESSO = 'data_ultimo_ingresso';
   const FIELD_NUMERO_PRENOTAZIONI = 'numero_prenotazioni';

   public $id;
   public $id_listino;
   public $listino_codice;
   public $quantita;
   public $operatore_ultimo_aggiornamento;
//   public $scorta_minima;
   public $ubicazione;
   public $numero_prenotazioni;
   public $data_ultimo_ingresso;


   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_listino = array_key_exists(self::FIELD_ID_LISTINO, $data) ? $data[self::FIELD_ID_LISTINO] : '';
         $this->listino_codice = array_key_exists(self::FIELD_LISTINO_CODICE, $data) ? $data[self::FIELD_LISTINO_CODICE] : '';
         $this->quantita = array_key_exists(self::FIELD_QUANTITA, $data) ? $data[self::FIELD_QUANTITA] : '';
         $this->operatore_ultimo_aggiornamento = array_key_exists(self::FIELD_OPERATORE_ULTIMO_AGGIORNAMENTO, $data) ? $data[self::FIELD_OPERATORE_ULTIMO_AGGIORNAMENTO] : '';
         $this->ubicazione = array_key_exists(self::FIELD_UBICAZIONE, $data) ? $data[self::FIELD_UBICAZIONE] : '';
         $this->numero_prenotazioni = array_key_exists(self::FIELD_NUMERO_PRENOTAZIONI, $data) ? $data[self::FIELD_NUMERO_PRENOTAZIONI] : '';
         $this->data_ultimo_ingresso = array_key_exists(self::FIELD_DATA_ULTIMO_INGRESSO, $data) ? $data[self::FIELD_DATA_ULTIMO_INGRESSO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_listino !== '') $data[self::FIELD_ID_LISTINO] = $this->id_listino;
      if($this->listino_codice !== '') $data[self::FIELD_LISTINO_CODICE] = $this->listino_codice;
      if($this->quantita !== '') $data[self::FIELD_QUANTITA] = $this->quantita;
      if($this->operatore_ultimo_aggiornamento !== '') $data[self::FIELD_OPERATORE_ULTIMO_AGGIORNAMENTO] = $this->operatore_ultimo_aggiornamento;
      if($this->ubicazione !== '') $data[self::FIELD_UBICAZIONE] = $this->ubicazione;
      if($this->numero_prenotazioni !== '') $data[self::FIELD_NUMERO_PRENOTAZIONI] = $this->numero_prenotazioni;
      if($this->data_ultimo_ingresso !== '') $data[self::FIELD_DATA_ULTIMO_INGRESSO] = $this->data_ultimo_ingresso;
      return $data;
   }
} 

class Magazzino_DTO extends DTO {
   const TABLE_NAME = 'magazzino';

   const FIELD_ID = 'id';
   const FIELD_ID_SEDE = 'id_sede';
   const FIELD_DATA_CREAZIONE = 'data_creazione';
   const FIELD_NOME = 'nome';
   const FIELD_RESPONSABILE = 'responsabile';
   const FIELD_ABILITATO = 'abilitato';
   const FIELD_CODICE = 'codice';
   const FIELD_CODICE_MAGAZZINO_CENTRALE = 'codice_magazzino_centrale';
   
   const MAGAZZINO_ZERO = 'ZERO';
   
   const ABILITATO_SI = 1;
   const ABILITATO_NO = 2;

   public $id;
   public $id_sede;
   public $data_creazione;
   public $nome;
   public $responsabile;
   public $abilitato;
   public $codice;
   public $codice_magazzino_centrale;
   public $ubicazioni;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_sede = array_key_exists(self::FIELD_ID_SEDE, $data) ? $data[self::FIELD_ID_SEDE] : '';
         $this->data_creazione = array_key_exists(self::FIELD_DATA_CREAZIONE, $data) ? $data[self::FIELD_DATA_CREAZIONE] : '';
         $this->nome = array_key_exists(self::FIELD_NOME, $data) ? $data[self::FIELD_NOME] : '';
         $this->responsabile = array_key_exists(self::FIELD_RESPONSABILE, $data) ? $data[self::FIELD_RESPONSABILE] : '';
         $this->abilitato = array_key_exists(self::FIELD_ABILITATO, $data) ? $data[self::FIELD_ABILITATO] : '';
         $this->codice = array_key_exists(self::FIELD_CODICE, $data) ? $data[self::FIELD_CODICE] : '';
         $this->codice_magazzino_centrale = array_key_exists(self::FIELD_CODICE_MAGAZZINO_CENTRALE, $data) ? $data[self::FIELD_CODICE_MAGAZZINO_CENTRALE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_sede !== '') $data[self::FIELD_ID_SEDE] = $this->id_sede;
      if($this->data_creazione !== '') $data[self::FIELD_DATA_CREAZIONE] = $this->data_creazione;
      if($this->nome !== '') $data[self::FIELD_NOME] = $this->nome;
      if($this->responsabile !== '') $data[self::FIELD_RESPONSABILE] = $this->responsabile;
      if($this->abilitato !== '') $data[self::FIELD_ABILITATO] = $this->abilitato;
      if($this->codice !== '') $data[self::FIELD_CODICE] = $this->codice;
      if($this->codice_magazzino_centrale !== '') $data[self::FIELD_CODICE_MAGAZZINO_CENTRALE] = $this->codice_magazzino_centrale;
      return $data;
   }
   
   public static function get_aree(){
      $return = array(
          'BANCO' => self::AREA_BANCO,
          'LABORATORIO' => self::AREA_LABORATORIO,
          'STOCCAGGIO' => self::AREA_STOCCAGGIO
      );
      return $return;
   }
}

class Magazzino_ubicazione_DTO extends DTO {
   const TABLE_NAME = 'magazzino_ubicazione';

   const FIELD_ID = 'id';
   const FIELD_ID_MAGAZZINO = 'id_magazzino';
   const FIELD_CODICE_UBICAZIONE = 'codice_ubicazione';
   const FIELD_DESCRIZIONE = 'descrizione';
   const FIELD_TIPOLOGIA = 'tipologia';
   const FIELD_DATA_CREAZIONE = 'data_creazione';
   const FIELD_ABILITATO = 'abilitato';
   
   const ABILITATO_SI = 1;
   const ABILITATO_NO = 2;

   public $id;
   public $id_magazzino;
   public $codice_ubicazione;
   public $descrizione;
   public $tipologia;
   public $data_creazione;
   public $abilitato;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_magazzino = array_key_exists(self::FIELD_ID_MAGAZZINO, $data) ? $data[self::FIELD_ID_MAGAZZINO] : '';
         $this->codice_ubicazione = array_key_exists(self::FIELD_CODICE_UBICAZIONE, $data) ? $data[self::FIELD_CODICE_UBICAZIONE] : '';
         $this->descrizione = array_key_exists(self::FIELD_DESCRIZIONE, $data) ? $data[self::FIELD_DESCRIZIONE] : '';
         $this->tipologia = array_key_exists(self::FIELD_TIPOLOGIA, $data) ? $data[self::FIELD_TIPOLOGIA] : '';
         $this->data_creazione = array_key_exists(self::FIELD_DATA_CREAZIONE, $data) ? $data[self::FIELD_DATA_CREAZIONE] : '';
         $this->abilitato = array_key_exists(self::FIELD_ABILITATO, $data) ? $data[self::FIELD_ABILITATO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_magazzino !== '') $data[self::FIELD_ID_MAGAZZINO] = $this->id_magazzino;
      if($this->codice_ubicazione !== '') $data[self::FIELD_CODICE_UBICAZIONE] = $this->codice_ubicazione;
      if($this->descrizione !== '') $data[self::FIELD_DESCRIZIONE] = $this->descrizione;
      if($this->tipologia !== '') $data[self::FIELD_TIPOLOGIA] = $this->tipologia;
      if($this->data_creazione !== '') $data[self::FIELD_DATA_CREAZIONE] = $this->data_creazione;
      if($this->abilitato !== '') $data[self::FIELD_ABILITATO] = $this->abilitato;
      return $data;
   }
}

class Magazzino_utente_DTO extends DTO {
   const TABLE_NAME = 'magazzino_utente';

   const FIELD_ID = 'id';
   const FIELD_ID_UTENTE = 'id_utente';
   const FIELD_ID_MAGAZZINO = 'id_magazzino';

   public $id;
   public $id_utente;
   public $id_magazzino;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_utente = array_key_exists(self::FIELD_ID_UTENTE, $data) ? $data[self::FIELD_ID_UTENTE] : '';
         $this->id_magazzino = array_key_exists(self::FIELD_ID_MAGAZZINO, $data) ? $data[self::FIELD_ID_MAGAZZINO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_utente !== '') $data[self::FIELD_ID_UTENTE] = $this->id_utente;
      if($this->id_magazzino !== '') $data[self::FIELD_ID_MAGAZZINO] = $this->id_magazzino;
      return $data;
   }
}

class Magazzino_ubicazione_articolo_DTO extends DTO {
   const TABLE_NAME = 'magazzino_ubicazione_articolo';

   const FIELD_ID = 'id';
   const FIELD_ID_MAGAZZINO = 'id_magazzino';
   const FIELD_ID_UBICAZIONE = 'id_ubicazione';
   const FIELD_ID_LISTINO = 'id_listino';
   const FIELD_QUANTITA = 'quantita';
   const FIELD_SCORTA_MINIMA = 'scorta_minima';

   public $id;
   public $id_magazzino;
   public $id_ubicazione;
   public $id_listino;
   public $quantita;
   public $scorta_minima;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_magazzino = array_key_exists(self::FIELD_ID_MAGAZZINO, $data) ? $data[self::FIELD_ID_MAGAZZINO] : '';
         $this->id_ubicazione = array_key_exists(self::FIELD_ID_UBICAZIONE, $data) ? $data[self::FIELD_ID_UBICAZIONE] : '';
         $this->id_listino = array_key_exists(self::FIELD_ID_LISTINO, $data) ? $data[self::FIELD_ID_LISTINO] : '';
         $this->quantita = array_key_exists(self::FIELD_QUANTITA, $data) ? $data[self::FIELD_QUANTITA] : '';
         $this->scorta_minima = array_key_exists(self::FIELD_SCORTA_MINIMA, $data) ? $data[self::FIELD_SCORTA_MINIMA] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_magazzino !== '') $data[self::FIELD_ID_MAGAZZINO] = $this->id_magazzino;
      if($this->id_ubicazione !== '') $data[self::FIELD_ID_UBICAZIONE] = $this->id_ubicazione;
      if($this->id_listino !== '') $data[self::FIELD_ID_LISTINO] = $this->id_listino;
      if($this->quantita !== '') $data[self::FIELD_QUANTITA] = $this->quantita;
      if($this->scorta_minima !== '') $data[self::FIELD_SCORTA_MINIMA] = $this->scorta_minima;
      return $data;
   }
}

class Movimenti_magazzino_DTO extends DTO {
   const TABLE_NAME = 'movimenti_magazzino';

   const FIELD_ID = 'id';
   const FIELD_ID_MAGAZZINO = 'id_magazzino';
   const FIELD_ID_OPERATORE = 'id_operatore';
   const FIELD_DATA_MOVIMENTO = 'data_movimento';
   const FIELD_TIPO_MOVIMENTO = 'tipo_movimento';
   const FIELD_STATO_MOVIMENTO = 'stato_movimento';
   const FIELD_CREATO_DDT = 'creato_ddt';
   const FIELD_MOVIMENTO_CODICE = 'movimento_codice';
   
   const TIPO_MOVIMENTO_DA_0_AD_ALTRO = 1;
   const TIPO_MOVIMENTO_CARICO_0 = 2;
   const TIPO_MOVIMENTO_SCARICO_VENDITA = 3;
   
   const STATO_BOZZA = 1;
   const STATO_CHIUSO = 2;
   const CREATO_DDT_NO = 1;
   const CREATO_DDT_SI = 2;

   public $id;
   public $id_magazzino;
   public $id_operatore;
   public $data_movimento;
   public $tipo_movimento;
   public $stato_movimento;
   public $creato_ddt;
   public $movimento_codice;
   public $dettagli;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_magazzino = array_key_exists(self::FIELD_ID_MAGAZZINO, $data) ? $data[self::FIELD_ID_MAGAZZINO] : '';
         $this->id_operatore = array_key_exists(self::FIELD_ID_OPERATORE, $data) ? $data[self::FIELD_ID_OPERATORE] : '';
         $this->data_movimento = array_key_exists(self::FIELD_DATA_MOVIMENTO, $data) ? $data[self::FIELD_DATA_MOVIMENTO] : '';
         $this->tipo_movimento = array_key_exists(self::FIELD_TIPO_MOVIMENTO, $data) ? $data[self::FIELD_TIPO_MOVIMENTO] : '';
         $this->stato_movimento = array_key_exists(self::FIELD_STATO_MOVIMENTO, $data) ? $data[self::FIELD_STATO_MOVIMENTO] : '';
         $this->creato_ddt = array_key_exists(self::FIELD_CREATO_DDT, $data) ? $data[self::FIELD_CREATO_DDT] : '';
         $this->movimento_codice = array_key_exists(self::FIELD_MOVIMENTO_CODICE, $data) ? $data[self::FIELD_MOVIMENTO_CODICE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_magazzino !== '') $data[self::FIELD_ID_MAGAZZINO] = $this->id_magazzino;
      if($this->id_operatore !== '') $data[self::FIELD_ID_OPERATORE] = $this->id_operatore;
      if($this->data_movimento !== '') $data[self::FIELD_DATA_MOVIMENTO] = $this->data_movimento;
      if($this->tipo_movimento !== '') $data[self::FIELD_TIPO_MOVIMENTO] = $this->tipo_movimento;
      if($this->stato_movimento !== '') $data[self::FIELD_STATO_MOVIMENTO] = $this->stato_movimento;
      if($this->creato_ddt !== '') $data[self::FIELD_CREATO_DDT] = $this->creato_ddt;
      if($this->movimento_codice !== '') $data[self::FIELD_MOVIMENTO_CODICE] = $this->movimento_codice;
      return $data;
   }
}

class Movimenti_magazzino_dettagli_DTO extends DTO {
   const TABLE_NAME = 'movimenti_magazzino_dettagli';

   const FIELD_ID = 'id';
   const FIELD_ID_MOVIMENTO = 'id_movimento';
   const FIELD_ID_ARTICOLO = 'id_articolo';
   const FIELD_QUANTITA = 'quantita';
   const FIELD_UNITA_MISURA = 'unita_misura';
   const FIELD_ID_UBICAZIONE = 'id_ubicazione';

   public $id;
   public $id_movimento;
   public $id_articolo;
   public $quantita;
   public $unita_misura;
   public $id_ubicazione;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_movimento = array_key_exists(self::FIELD_ID_MOVIMENTO, $data) ? $data[self::FIELD_ID_MOVIMENTO] : '';
         $this->id_articolo = array_key_exists(self::FIELD_ID_ARTICOLO, $data) ? $data[self::FIELD_ID_ARTICOLO] : '';
         $this->quantita = array_key_exists(self::FIELD_QUANTITA, $data) ? $data[self::FIELD_QUANTITA] : '';
         $this->unita_misura = array_key_exists(self::FIELD_UNITA_MISURA, $data) ? $data[self::FIELD_UNITA_MISURA] : '';
         $this->id_ubicazione = array_key_exists(self::FIELD_ID_UBICAZIONE, $data) ? $data[self::FIELD_ID_UBICAZIONE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_movimento !== '') $data[self::FIELD_ID_MOVIMENTO] = $this->id_movimento;
      if($this->id_articolo !== '') $data[self::FIELD_ID_ARTICOLO] = $this->id_articolo;
      if($this->quantita !== '') $data[self::FIELD_QUANTITA] = $this->quantita;
      if($this->unita_misura !== '') $data[self::FIELD_UNITA_MISURA] = $this->unita_misura;
      if($this->id_ubicazione !== '') $data[self::FIELD_ID_UBICAZIONE] = $this->id_ubicazione;
      return $data;
   }
}