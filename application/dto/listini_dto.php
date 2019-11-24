 <?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Listini_DTO extends DTO {
   const TABLE_NAME = 'listini';

   const FIELD_ID = 'id';
   const FIELD_BRAND_CODE = 'brand_code';
   const FIELD_CODICE = 'codice';
   const FIELD_MODELLO = 'modello';
   const FIELD_DESCRIZIONE = 'descrizione';
   const FIELD_PREZZO_PUBBLICO_1 = 'prezzo_pubblico_1';
   const FIELD_ACQUISTO_PREZZO_NETTO = 'acquisto_prezzo_netto';
   const FIELD_PREZZO_RIVENDITORE = 'prezzo_rivenditore';
   const FIELD_PREZZO_ACQUISTO = 'prezzo_acquisto';
   const FIELD_PREZZO_RIFATTURAZIONE = 'prezzo_rifatturazione';
   const FIELD_SCORTA_MINIMA = 'scorta_minima';
   const FIELD_ALIQUOTA_IVA = 'aliquota_iva';
   const FIELD_PRODOTTO_FINITO_RICAMBIO = 'prodotto_finito_ricambio';
   const FIELD_RIPARABILE_SOSTITUIBILE = 'riparabile_sostituibile';
   const FIELD_ORDINABILE = 'ordinabile';
   const FIELD_PRODOTTO_CRITICO = 'prodotto_critico';
   const FIELD_ABILITATO = 'abilitato';
   const ABILITATO_NO = 1;
   const ABILITATO_SI = 2;
   const PRODOTTO_FINITO = 'P';
   const PRODOTTO_RICAMBIO = 'R';
   const PRODOTTO_RIPARABILE = 'R';
   const PRODOTTO_SOLO_SOSTITUIBILE = 'S';
   const PRODOTTO_ORDINABILE_SI = 'S';
   const PRODOTTO_ORDINABILE_NO = 'N';
   const PRODOTTO_CRITICO_SI = 'S';
   const PRODOTTO_CRITICO_NO = 'N';
/*
 * nota sviluppo i listini sono sempre senza IVA
 */
   public $id;
   public $brand_code;
   public $codice;
   public $modello;
   public $descrizione;
   public $prezzo_pubblico_1;
   public $acquisto_prezzo_netto;
   public $prezzo_rivenditore;
   public $prezzo_acquisto;
   public $prezzo_rifatturazione;
   public $brand;
   public $articolo;
   public $scorta_minima;
   public $aliquota_iva;
   public $prodotto_finito_ricambio;
   public $riparabile_sostituibile;
   public $ordinabile;
   public $prodotto_critico;
   public $abilitato;


   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->brand_code = array_key_exists(self::FIELD_BRAND_CODE, $data) ? $data[self::FIELD_BRAND_CODE] : '';
         $this->codice = array_key_exists(self::FIELD_CODICE, $data) ? $data[self::FIELD_CODICE] : '';
         $this->modello = array_key_exists(self::FIELD_MODELLO, $data) ? $data[self::FIELD_MODELLO] : '';
         $this->prezzo_rivenditore = array_key_exists(self::FIELD_PREZZO_RIVENDITORE, $data) ? $data[self::FIELD_PREZZO_RIVENDITORE] : '';
         $this->descrizione = array_key_exists(self::FIELD_DESCRIZIONE, $data) ? $data[self::FIELD_DESCRIZIONE] : '';
         $this->prezzo_pubblico_1 = array_key_exists(self::FIELD_PREZZO_PUBBLICO_1, $data) ? $data[self::FIELD_PREZZO_PUBBLICO_1] : '';
         $this->acquisto_prezzo_netto = array_key_exists(self::FIELD_ACQUISTO_PREZZO_NETTO, $data) ? $data[self::FIELD_ACQUISTO_PREZZO_NETTO] : '';
         $this->prezzo_acquisto = array_key_exists(self::FIELD_PREZZO_ACQUISTO, $data) ? $data[self::FIELD_PREZZO_ACQUISTO] : '';
         $this->prezzo_rifatturazione = array_key_exists(self::FIELD_PREZZO_RIFATTURAZIONE, $data) ? $data[self::FIELD_PREZZO_RIFATTURAZIONE] : '';
         $this->scorta_minima = array_key_exists(self::FIELD_SCORTA_MINIMA, $data) ? $data[self::FIELD_SCORTA_MINIMA] : '';
         $this->aliquota_iva = array_key_exists(self::FIELD_ALIQUOTA_IVA, $data) ? $data[self::FIELD_ALIQUOTA_IVA] : '';
         $this->prodotto_finito_ricambio = array_key_exists(self::FIELD_PRODOTTO_FINITO_RICAMBIO, $data) ? $data[self::FIELD_PRODOTTO_FINITO_RICAMBIO] : '';
         $this->riparabile_sostituibile = array_key_exists(self::FIELD_RIPARABILE_SOSTITUIBILE, $data) ? $data[self::FIELD_RIPARABILE_SOSTITUIBILE] : '';
         $this->ordinabile = array_key_exists(self::FIELD_ORDINABILE, $data) ? $data[self::FIELD_ORDINABILE] : '';
         $this->prodotto_critico = array_key_exists(self::FIELD_PRODOTTO_CRITICO, $data) ? $data[self::FIELD_PRODOTTO_CRITICO] : '';
         $this->abilitato = array_key_exists(self::FIELD_ABILITATO, $data) ? $data[self::FIELD_ABILITATO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->brand_code !== '') $data[self::FIELD_BRAND_CODE] = $this->brand_code;
      if($this->codice !== '') $data[self::FIELD_CODICE] = $this->codice;
      if($this->modello !== '') $data[self::FIELD_MODELLO] = $this->modello;
      if($this->prezzo_rivenditore !== '') $data[self::FIELD_PREZZO_RIVENDITORE] = $this->prezzo_rivenditore;
      if($this->descrizione !== '') $data[self::FIELD_DESCRIZIONE] = $this->descrizione;
      if($this->prezzo_pubblico_1 !== '') $data[self::FIELD_PREZZO_PUBBLICO_1] = $this->prezzo_pubblico_1;
      if($this->acquisto_prezzo_netto !== '') $data[self::FIELD_ACQUISTO_PREZZO_NETTO] = $this->acquisto_prezzo_netto;
      if($this->prezzo_acquisto !== '') $data[self::FIELD_PREZZO_ACQUISTO] = $this->prezzo_acquisto;
      if($this->prezzo_rifatturazione !== '') $data[self::FIELD_PREZZO_RIFATTURAZIONE] = $this->prezzo_rifatturazione;
      if($this->scorta_minima !== '') $data[self::FIELD_SCORTA_MINIMA] = $this->scorta_minima;
      if($this->aliquota_iva !== '') $data[self::FIELD_ALIQUOTA_IVA] = $this->aliquota_iva;
      if($this->prodotto_finito_ricambio !== '') $data[self::FIELD_PRODOTTO_FINITO_RICAMBIO] = $this->prodotto_finito_ricambio;
      if($this->riparabile_sostituibile !== '') $data[self::FIELD_RIPARABILE_SOSTITUIBILE] = $this->riparabile_sostituibile;
      if($this->ordinabile !== '') $data[self::FIELD_ORDINABILE] = $this->ordinabile;
      if($this->prodotto_critico !== '') $data[self::FIELD_PRODOTTO_CRITICO] = $this->prodotto_critico;
      if($this->abilitato !== '') $data[self::FIELD_ABILITATO] = $this->abilitato;
      return $data;
   }
}

class Modello_gruppomerce_marchio_DTO extends DTO {
   const TABLE_NAME = 'modello_gruppomerce_marchio';

   const FIELD_ID = 'id';
   const FIELD_MODELLO = 'modello';
   const FIELD_GRUPPO_MERCE = 'gruppo_merce';
   const FIELD_MARCHIO = 'marchio';
   
   public $id;
   public $modello;
   public $gruppo_merce;
   public $marchio;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->modello = array_key_exists(self::FIELD_MODELLO, $data) ? $data[self::FIELD_MODELLO] : '';
         $this->gruppo_merce = array_key_exists(self::FIELD_GRUPPO_MERCE, $data) ? $data[self::FIELD_GRUPPO_MERCE] : '';
         $this->marchio = array_key_exists(self::FIELD_MARCHIO, $data) ? $data[self::FIELD_MARCHIO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->modello !== '') $data[self::FIELD_MODELLO] = $this->modello;
      if($this->gruppo_merce !== '') $data[self::FIELD_GRUPPO_MERCE] = $this->gruppo_merce;
      if($this->marchio !== '') $data[self::FIELD_MARCHIO] = $this->marchio;
      return $data;
   }
}

class Modello_tariffe_manodopera_DTO extends DTO {
   const TABLE_NAME = 'modello_tariffe_manodopera';
   
   const FIELD_ID = 'id';
   const FIELD_MODELLO = 'modello';
   const FIELD_DESCRIZIONE = 'descrizione';
   const FIELD_DESCRIZIONE_GRUPPO_MERCE = 'descrizione_gruppo_merce';
   const FIELD_CODICE_FITTIZIO = 'codice_fittizio';
   const FIELD_TARIFFA = 'tariffa';
   const FIELD_MARCHIO_CORTO = 'marchio_corto';
   const FIELD_ABBREVIAZIONE_MARCHIO = 'abbreviazione_marchio';

   public $id;
   public $modello;
   public $descrizione;
   public $descrizione_gruppo_merce;
   public $codice_fittizio;
   public $tariffa;
   public $marchio_corto;
   public $abbreviazione_marchio;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->modello = array_key_exists(self::FIELD_MODELLO, $data) ? $data[self::FIELD_MODELLO] : '';
         $this->descrizione = array_key_exists(self::FIELD_DESCRIZIONE, $data) ? $data[self::FIELD_DESCRIZIONE] : '';
         $this->descrizione_gruppo_merce = array_key_exists(self::FIELD_DESCRIZIONE_GRUPPO_MERCE, $data) ? $data[self::FIELD_DESCRIZIONE_GRUPPO_MERCE] : '';
         $this->codice_fittizio = array_key_exists(self::FIELD_CODICE_FITTIZIO, $data) ? $data[self::FIELD_CODICE_FITTIZIO] : '';
         $this->tariffa = array_key_exists(self::FIELD_TARIFFA, $data) ? $data[self::FIELD_TARIFFA] : '';
         $this->marchio_corto = array_key_exists(self::FIELD_MARCHIO_CORTO, $data) ? $data[self::FIELD_MARCHIO_CORTO] : '';
         $this->abbreviazione_marchio = array_key_exists(self::FIELD_ABBREVIAZIONE_MARCHIO, $data) ? $data[self::FIELD_ABBREVIAZIONE_MARCHIO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->modello !== '') $data[self::FIELD_MODELLO] = $this->modello;
      if($this->descrizione !== '') $data[self::FIELD_DESCRIZIONE] = $this->descrizione;
      if($this->descrizione_gruppo_merce !== '') $data[self::FIELD_DESCRIZIONE_GRUPPO_MERCE] = $this->descrizione_gruppo_merce;
      if($this->codice_fittizio !== '') $data[self::FIELD_CODICE_FITTIZIO] = $this->codice_fittizio;
      if($this->tariffa !== '') $data[self::FIELD_TARIFFA] = $this->tariffa;
      if($this->marchio_corto !== '') $data[self::FIELD_MARCHIO_CORTO] = $this->marchio_corto;
      if($this->abbreviazione_marchio !== '') $data[self::FIELD_ABBREVIAZIONE_MARCHIO] = $this->abbreviazione_marchio;
      return $data;
   }
}

class Gruppomerce_codice_difetto_DTO extends DTO {
   const TABLE_NAME = 'gruppomerce_codice_difetto';

   const FIELD_ID = 'id';
   const FIELD_GRUPPOMERCE = 'gruppomerce';
   const FIELD_CODICE_DIFETTO = 'codice_difetto';
   const FIELD_DESCRIZIONE_DIFETTO = 'descrizione_difetto';

   public $id;
   public $gruppomerce;
   public $codice_difetto;
   public $descrizione_difetto;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->gruppomerce = array_key_exists(self::FIELD_GRUPPOMERCE, $data) ? $data[self::FIELD_GRUPPOMERCE] : '';
         $this->codice_difetto = array_key_exists(self::FIELD_CODICE_DIFETTO, $data) ? $data[self::FIELD_CODICE_DIFETTO] : '';
         $this->descrizione_difetto = array_key_exists(self::FIELD_DESCRIZIONE_DIFETTO, $data) ? $data[self::FIELD_DESCRIZIONE_DIFETTO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->gruppomerce !== '') $data[self::FIELD_GRUPPOMERCE] = $this->gruppomerce;
      if($this->codice_difetto !== '') $data[self::FIELD_CODICE_DIFETTO] = $this->codice_difetto;
      if($this->descrizione_difetto !== '') $data[self::FIELD_DESCRIZIONE_DIFETTO] = $this->descrizione_difetto;
      return $data;
   }
}

class Listini_dati_extra_imetec_DTO extends DTO {
   const TABLE_NAME = 'listini_dati_extra_imetec';

   const FIELD_ID = 'id';
   const FIELD_ID_LISTINO = 'id_listino';
   const FIELD_CODICE_PRODOTTO_SOSTITUTIVO = 'codice_prodotto_sostitutivo';
   const FIELD_QUANTITA_CONFEZIONAMENTO = 'quantita_confezionamento';
   const FIELD_PREZZO_VENDITA_CONSIGLIATO = 'prezzo_vendita_consigliato';
   const FIELD_PREZZO_IMPOSTO_1 = 'prezzo_imposto_1';
   const FIELD_PREZZO_IMPOSTO_2 = 'prezzo_imposto_2';
   const FIELD_PREZZO_ACQUISTO_A_CATALOGO = 'prezzo_acquisto_a_catalogo';
   const FIELD_TARIFFA_ORARIA_MANODOPERA_GARANZIA = 'tariffa_oraria_manodopera_garanzia';
   const FIELD_DATA_VALIDITA = 'data_validita';
   const FIELD_DESCRIZIONE_AGGIUNTIVA = 'descrizione_aggiuntiva';
   const FIELD_DATA_PRODUZIONE_DI_RIFERIMENTO = 'data_produzione_di_riferimento';
   const FIELD_NOTE_PRODOTTI_CRITICI_1 = 'note_prodotti_critici_1';
   const FIELD_NOTE_PRODOTTI_CRITICI_2 = 'note_prodotti_critici_2';
   const FIELD_GRUPPO_MERCE = 'gruppo_merce';
   const FIELD_DATA_PREVISTA_ARRIVO = 'data_prevista_arrivo';
   const FIELD_CODICE_RAEE = 'codice_raee';

   public $id;
   public $id_listino;
   public $codice_prodotto_sostitutivo;
   public $quantita_confezionamento;
   public $prezzo_vendita_consigliato;
   public $prezzo_imposto_1;
   public $prezzo_imposto_2;
   public $prezzo_acquisto_a_catalogo;
   public $tariffa_oraria_manodopera_garanzia;
   public $data_validita;
   public $descrizione_aggiuntiva;
   public $data_produzione_di_riferimento;
   public $note_prodotti_critici_1;
   public $note_prodotti_critici_2;
   public $gruppo_merce;
   public $data_prevista_arrivo;
   public $codice_raee;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->id_listino = array_key_exists(self::FIELD_ID_LISTINO, $data) ? $data[self::FIELD_ID_LISTINO] : '';
         $this->codice_prodotto_sostitutivo = array_key_exists(self::FIELD_CODICE_PRODOTTO_SOSTITUTIVO, $data) ? $data[self::FIELD_CODICE_PRODOTTO_SOSTITUTIVO] : '';
         $this->quantita_confezionamento = array_key_exists(self::FIELD_QUANTITA_CONFEZIONAMENTO, $data) ? $data[self::FIELD_QUANTITA_CONFEZIONAMENTO] : '';
         $this->prezzo_vendita_consigliato = array_key_exists(self::FIELD_PREZZO_VENDITA_CONSIGLIATO, $data) ? $data[self::FIELD_PREZZO_VENDITA_CONSIGLIATO] : '';
         $this->prezzo_imposto_1 = array_key_exists(self::FIELD_PREZZO_IMPOSTO_1, $data) ? $data[self::FIELD_PREZZO_IMPOSTO_1] : '';
         $this->prezzo_imposto_2 = array_key_exists(self::FIELD_PREZZO_IMPOSTO_2, $data) ? $data[self::FIELD_PREZZO_IMPOSTO_2] : '';
         $this->prezzo_acquisto_a_catalogo = array_key_exists(self::FIELD_PREZZO_ACQUISTO_A_CATALOGO, $data) ? $data[self::FIELD_PREZZO_ACQUISTO_A_CATALOGO] : '';
         $this->tariffa_oraria_manodopera_garanzia = array_key_exists(self::FIELD_TARIFFA_ORARIA_MANODOPERA_GARANZIA, $data) ? $data[self::FIELD_TARIFFA_ORARIA_MANODOPERA_GARANZIA] : '';
         $this->data_validita = array_key_exists(self::FIELD_DATA_VALIDITA, $data) ? $data[self::FIELD_DATA_VALIDITA] : '';
         $this->descrizione_aggiuntiva = array_key_exists(self::FIELD_DESCRIZIONE_AGGIUNTIVA, $data) ? $data[self::FIELD_DESCRIZIONE_AGGIUNTIVA] : '';
         $this->data_produzione_di_riferimento = array_key_exists(self::FIELD_DATA_PRODUZIONE_DI_RIFERIMENTO, $data) ? $data[self::FIELD_DATA_PRODUZIONE_DI_RIFERIMENTO] : '';
         $this->note_prodotti_critici_1 = array_key_exists(self::FIELD_NOTE_PRODOTTI_CRITICI_1, $data) ? $data[self::FIELD_NOTE_PRODOTTI_CRITICI_1] : '';
         $this->note_prodotti_critici_2 = array_key_exists(self::FIELD_NOTE_PRODOTTI_CRITICI_2, $data) ? $data[self::FIELD_NOTE_PRODOTTI_CRITICI_2] : '';
         $this->gruppo_merce = array_key_exists(self::FIELD_GRUPPO_MERCE, $data) ? $data[self::FIELD_GRUPPO_MERCE] : '';
         $this->data_prevista_arrivo = array_key_exists(self::FIELD_DATA_PREVISTA_ARRIVO, $data) ? $data[self::FIELD_DATA_PREVISTA_ARRIVO] : '';
         $this->codice_raee = array_key_exists(self::FIELD_CODICE_RAEE, $data) ? $data[self::FIELD_CODICE_RAEE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->id_listino !== '') $data[self::FIELD_ID_LISTINO] = $this->id_listino;
      if($this->codice_prodotto_sostitutivo !== '') $data[self::FIELD_CODICE_PRODOTTO_SOSTITUTIVO] = $this->codice_prodotto_sostitutivo;
      if($this->quantita_confezionamento !== '') $data[self::FIELD_QUANTITA_CONFEZIONAMENTO] = $this->quantita_confezionamento;
      if($this->prezzo_vendita_consigliato !== '') $data[self::FIELD_PREZZO_VENDITA_CONSIGLIATO] = $this->prezzo_vendita_consigliato;
      if($this->prezzo_imposto_1 !== '') $data[self::FIELD_PREZZO_IMPOSTO_1] = $this->prezzo_imposto_1;
      if($this->prezzo_imposto_2 !== '') $data[self::FIELD_PREZZO_IMPOSTO_2] = $this->prezzo_imposto_2;
      if($this->prezzo_acquisto_a_catalogo !== '') $data[self::FIELD_PREZZO_ACQUISTO_A_CATALOGO] = $this->prezzo_acquisto_a_catalogo;
      if($this->tariffa_oraria_manodopera_garanzia !== '') $data[self::FIELD_TARIFFA_ORARIA_MANODOPERA_GARANZIA] = $this->tariffa_oraria_manodopera_garanzia;
      if($this->data_validita !== '') $data[self::FIELD_DATA_VALIDITA] = $this->data_validita;
      if($this->descrizione_aggiuntiva !== '') $data[self::FIELD_DESCRIZIONE_AGGIUNTIVA] = $this->descrizione_aggiuntiva;
      if($this->data_produzione_di_riferimento !== '') $data[self::FIELD_DATA_PRODUZIONE_DI_RIFERIMENTO] = $this->data_produzione_di_riferimento;
      if($this->note_prodotti_critici_1 !== '') $data[self::FIELD_NOTE_PRODOTTI_CRITICI_1] = $this->note_prodotti_critici_1;
      if($this->note_prodotti_critici_2 !== '') $data[self::FIELD_NOTE_PRODOTTI_CRITICI_2] = $this->note_prodotti_critici_2;
      if($this->gruppo_merce !== '') $data[self::FIELD_GRUPPO_MERCE] = $this->gruppo_merce;
      if($this->data_prevista_arrivo !== '') $data[self::FIELD_DATA_PREVISTA_ARRIVO] = $this->data_prevista_arrivo;
      if($this->codice_raee !== '') $data[self::FIELD_CODICE_RAEE] = $this->codice_raee;
      return $data;
   }
}

class Imetec_distinta_base_primo_livello_DTO extends DTO {
   const TABLE_NAME = 'imetec_distinta_base_primo_livello';

   const FIELD_ID = 'id';
   const FIELD_BRAND_CODE = 'brand_code';
   const FIELD_CODICE_PRODOTTO = 'codice_prodotto';
   const FIELD_CODICE_ARTICOLO_RICAMBIO = 'codice_articolo_ricambio';
   const FIELD_POSIZIONE_ESPLOSO = 'posizione_esploso';
   const FIELD_DATA_INIZIO_VALIDITA = 'data_inizio_validita';
   const FIELD_CODICE_ESPLOSO = 'codice_esploso';

   public $id;
   public $brand_code;
   public $codice_prodotto;
   public $codice_articolo_ricambio;
   public $posizione_esploso;
   public $data_inizio_validita;
   public $codice_esploso;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->brand_code = array_key_exists(self::FIELD_BRAND_CODE, $data) ? $data[self::FIELD_BRAND_CODE] : '';
         $this->codice_prodotto = array_key_exists(self::FIELD_CODICE_PRODOTTO, $data) ? $data[self::FIELD_CODICE_PRODOTTO] : '';
         $this->codice_articolo_ricambio = array_key_exists(self::FIELD_CODICE_ARTICOLO_RICAMBIO, $data) ? $data[self::FIELD_CODICE_ARTICOLO_RICAMBIO] : '';
         $this->posizione_esploso = array_key_exists(self::FIELD_POSIZIONE_ESPLOSO, $data) ? $data[self::FIELD_POSIZIONE_ESPLOSO] : '';
         $this->data_inizio_validita = array_key_exists(self::FIELD_DATA_INIZIO_VALIDITA, $data) ? $data[self::FIELD_DATA_INIZIO_VALIDITA] : '';
         $this->codice_esploso = array_key_exists(self::FIELD_CODICE_ESPLOSO, $data) ? $data[self::FIELD_CODICE_ESPLOSO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->brand_code !== '') $data[self::FIELD_BRAND_CODE] = $this->brand_code;
      if($this->codice_prodotto !== '') $data[self::FIELD_CODICE_PRODOTTO] = $this->codice_prodotto;
      if($this->codice_articolo_ricambio !== '') $data[self::FIELD_CODICE_ARTICOLO_RICAMBIO] = $this->codice_articolo_ricambio;
      if($this->posizione_esploso !== '') $data[self::FIELD_POSIZIONE_ESPLOSO] = $this->posizione_esploso;
      if($this->data_inizio_validita !== '') $data[self::FIELD_DATA_INIZIO_VALIDITA] = $this->data_inizio_validita;
      if($this->codice_esploso !== '') $data[self::FIELD_CODICE_ESPLOSO] = $this->codice_esploso;
      return $data;
   }
}

class Imetec_difetti_DTO extends DTO {
   const TABLE_NAME = 'imetec_difetti';

   const FIELD_ID = 'id';
   const FIELD_CODICE_DIFETTO = 'codice_difetto';
   const FIELD_DESCRIZIONE_DIFETTO = 'descrizione_difetto';
   const FIELD_GRUPPO_MERCE = 'gruppo_merce';
   const FIELD_ABILITAZIONE_RICAMBI = 'abilitazione_ricambi';
   const FIELD_TARIFFA_MANODOPERA_GARANZIA = 'tariffa_manodopera_garanzia';
   
   const ABILITATO_RICAMBI_SI = 'Y';
   const ABILITATO_RICAMBI_NO = 'N';

   public $id;
   public $codice_difetto;
   public $descrizione_difetto;
   public $gruppo_merce;
   public $abilitazione_ricambi;
   public $tariffa_manodopera_garanzia;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->codice_difetto = array_key_exists(self::FIELD_CODICE_DIFETTO, $data) ? $data[self::FIELD_CODICE_DIFETTO] : '';
         $this->descrizione_difetto = array_key_exists(self::FIELD_DESCRIZIONE_DIFETTO, $data) ? $data[self::FIELD_DESCRIZIONE_DIFETTO] : '';
         $this->gruppo_merce = array_key_exists(self::FIELD_GRUPPO_MERCE, $data) ? $data[self::FIELD_GRUPPO_MERCE] : '';
         $this->abilitazione_ricambi = array_key_exists(self::FIELD_ABILITAZIONE_RICAMBI, $data) ? $data[self::FIELD_ABILITAZIONE_RICAMBI] : '';
         $this->tariffa_manodopera_garanzia = array_key_exists(self::FIELD_TARIFFA_MANODOPERA_GARANZIA, $data) ? $data[self::FIELD_TARIFFA_MANODOPERA_GARANZIA] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->codice_difetto !== '') $data[self::FIELD_CODICE_DIFETTO] = $this->codice_difetto;
      if($this->descrizione_difetto !== '') $data[self::FIELD_DESCRIZIONE_DIFETTO] = $this->descrizione_difetto;
      if($this->gruppo_merce !== '') $data[self::FIELD_GRUPPO_MERCE] = $this->gruppo_merce;
      if($this->abilitazione_ricambi !== '') $data[self::FIELD_ABILITAZIONE_RICAMBI] = $this->abilitazione_ricambi;
      if($this->tariffa_manodopera_garanzia !== '') $data[self::FIELD_TARIFFA_MANODOPERA_GARANZIA] = $this->tariffa_manodopera_garanzia;
      return $data;
   }
}

class Imetec_codici_tipo_DTO extends DTO {
   const TABLE_NAME = 'imetec_codici_tipo';

   const FIELD_ID = 'id';
   const FIELD_CODICE_TIPO = 'codice_tipo';
   const FIELD_BRAND_CODE = 'brand_code';
   const FIELD_CODICE_PRODOTTO = 'codice_prodotto';
   const FIELD_DESCRIZIONE_TIPO = 'descrizione_tipo';

   public $id;
   public $codice_tipo;
   public $brand_code;
   public $codice_prodotto;
   public $descrizione_tipo;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->codice_tipo = array_key_exists(self::FIELD_CODICE_TIPO, $data) ? $data[self::FIELD_CODICE_TIPO] : '';
         $this->brand_code = array_key_exists(self::FIELD_BRAND_CODE, $data) ? $data[self::FIELD_BRAND_CODE] : '';
         $this->codice_prodotto = array_key_exists(self::FIELD_CODICE_PRODOTTO, $data) ? $data[self::FIELD_CODICE_PRODOTTO] : '';
         $this->descrizione_tipo = array_key_exists(self::FIELD_DESCRIZIONE_TIPO, $data) ? $data[self::FIELD_DESCRIZIONE_TIPO] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->codice_tipo !== '') $data[self::FIELD_CODICE_TIPO] = $this->codice_tipo;
      if($this->brand_code !== '') $data[self::FIELD_BRAND_CODE] = $this->brand_code;
      if($this->codice_prodotto !== '') $data[self::FIELD_CODICE_PRODOTTO] = $this->codice_prodotto;
      if($this->descrizione_tipo !== '') $data[self::FIELD_DESCRIZIONE_TIPO] = $this->descrizione_tipo;
      return $data;
   }
}

class Imetec_date_produzione_valide_DTO extends DTO {
   const TABLE_NAME = 'imetec_date_produzione_valide';

   const FIELD_ID = 'id';
   const FIELD_CODICE_PRODOTTO = 'codice_prodotto';
   const FIELD_DATA_PRODUZIONE = 'data_produzione';

   public $id;
   public $codice_prodotto;
   public $data_produzione;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->codice_prodotto = array_key_exists(self::FIELD_CODICE_PRODOTTO, $data) ? $data[self::FIELD_CODICE_PRODOTTO] : '';
         $this->data_produzione = array_key_exists(self::FIELD_DATA_PRODUZIONE, $data) ? $data[self::FIELD_DATA_PRODUZIONE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->codice_prodotto !== '') $data[self::FIELD_CODICE_PRODOTTO] = $this->codice_prodotto;
      if($this->data_produzione !== '') $data[self::FIELD_DATA_PRODUZIONE] = $this->data_produzione;
      return $data;
   }
}

class Imetec_imdtpr_load_file_temp_DTO extends DTO {
   const TABLE_NAME = 'imetec_imdtpr_load_file_temp';

   const FIELD_ID = 'id';
   const FIELD_CODICE_PRODOTTO = 'codice_prodotto';
   const FIELD_DATA_PRODUZIONE = 'data_produzione';

   public $id;
   public $codice_prodotto;
   public $data_produzione;
    
   public function init($data) {
      if( ! is_array($data) && ! is_object($data)) {
         $this->pulisci();
      }
      else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID, $data) ? $data[self::FIELD_ID] : '';
         $this->codice_prodotto = array_key_exists(self::FIELD_CODICE_PRODOTTO, $data) ? $data[self::FIELD_CODICE_PRODOTTO] : '';
         $this->data_produzione = array_key_exists(self::FIELD_DATA_PRODUZIONE, $data) ? $data[self::FIELD_DATA_PRODUZIONE] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if($this->id !== '') $data[self::FIELD_ID] = $this->id;
      if($this->codice_prodotto !== '') $data[self::FIELD_CODICE_PRODOTTO] = $this->codice_prodotto;
      if($this->data_produzione !== '') $data[self::FIELD_DATA_PRODUZIONE] = $this->data_produzione;
      return $data;
   }
}