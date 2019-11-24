<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'dto/magazzino_dto.php';

class Magazzino_model extends CH_Model {
   
   public function save(Magazzino_DTO $dati) {
      if ($dati->id == '') {
         return $this->_insert(Magazzino_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Magazzino_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Magazzino_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }

   public function get($id_magazzino) {
      $this->db->from(Magazzino_DTO::TABLE_NAME)
              ->where(array(
                  Magazzino_DTO::FIELD_ID => $id_magazzino,
                  Magazzino_DTO::FIELD_ABILITATO => Magazzino_DTO::ABILITATO_SI
      ));
      return $this->_get(Magazzino_DTO::class_name(), FALSE);
   }
   
   public function get_list($all = FALSE) {
      $this->db->from(Magazzino_DTO::TABLE_NAME);
      if ($all === FALSE) {
         $this->db->where(
                 array(
                     Magazzino_DTO::FIELD_ID_SEDE => $this->bitauth->id_sede,
                     Magazzino_DTO::FIELD_ABILITATO => Magazzino_DTO::ABILITATO_SI
                 )
         );
      }
      return $this->_get_list(Magazzino_DTO::class_name());
   }
   
   public function get_tipologia_ubicazione(){
      $return = array(
          'SC' => 'Scaffale',
          'CS' => 'Cassetto',
          'PD' => 'Pedana',
          'MS' => 'Mensola'
      );
      return $return;
   }
   
   public function get_lista_ubicazioni($id_magazzino){
      $this->db->from(Magazzino_ubicazione_DTO::TABLE_NAME)
              ->where(Magazzino_ubicazione_DTO::FIELD_ID_MAGAZZINO, $id_magazzino);
      return $this->_get_list(Magazzino_ubicazione_DTO::class_name());
   }
   
   public function salva_ubicazione(Magazzino_ubicazione_DTO $dati){
       if ($dati->id == '') {
         return $this->_insert(Magazzino_ubicazione_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Magazzino_ubicazione_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Magazzino_ubicazione_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function cancella_ubicazione($id_ubicazione){
      $this->db->where(Magazzino_ubicazione_DTO::FIELD_ID, $id_ubicazione);
      return $this->db->delete(Magazzino_ubicazione_DTO::TABLE_NAME);
   }
   
   public function get_prodotti_magazzino_zero_table_feed(){
      $this->load->library('datatable_response_builder');
        $fields = array(
            array('db' => "art." . Magazzino_zero_DTO::FIELD_ID_LISTINO, 'dt' => 'id_listino'),
            array('db' => "b." . Brands_DTO::FIELD_BRAND_NAME, 'dt' => 'brand'),
            array('db' => "b." . Brands_DTO::FIELD_BRAND_CODE, 'dt' => 'brand_code'),
            array('db' => "art." . Magazzino_zero_DTO::FIELD_LISTINO_CODICE, 'dt' => 'codice'),
            array('db' => "l." . Listini_DTO::FIELD_DESCRIZIONE, 'dt' => 'descrizione'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_ACQUISTO, 'dt' => 'acquisto'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_PUBBLICO_1, 'dt' => 'vendita_1'),
            array('db' => "l." . Listini_DTO::FIELD_ACQUISTO_PREZZO_NETTO, 'dt' => 'acquisto_prezzo_netto'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_RIFATTURAZIONE, 'dt' => 'rifatturazione'),
            array('db' => "art." . Magazzino_zero_DTO::FIELD_QUANTITA, 'dt' => 'quantita'),
            array('db' => "art." . Magazzino_zero_DTO::FIELD_DATA_ULTIMO_INGRESSO, 'dt' => 'last_date'),
        );
        $this->datatable_response_builder->set_fields($fields);
        $this->datatable_response_builder->set_table(Magazzino_zero_DTO::TABLE_NAME." art");
        $this->datatable_response_builder->add_join_clauses(Listini_DTO::TABLE_NAME . " l", "l." . Listini_DTO::FIELD_ID . " = art." . Magazzino_zero_DTO::FIELD_ID_LISTINO);
        $this->datatable_response_builder->add_join_clauses(Brands_DTO::TABLE_NAME . " b", "b." . Brands_DTO::FIELD_BRAND_CODE . " = l." . Listini_DTO::FIELD_BRAND_CODE);
        $this->datatable_response_builder->add_order_by_clauses(Brands_DTO::FIELD_BRAND_NAME,'asc');
        return $this->datatable_response_builder->build_response();
   }
   
   public function get_list_magazzini_by_sede($id_sede){
      $this->db->from(Magazzino_DTO::TABLE_NAME)
              ->where(Magazzino_DTO::FIELD_ID_SEDE, $id_sede);
      return $this->_get_list(Magazzino_DTO::class_name());
   }
   
   public function salva_movimento(Movimenti_magazzino_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Movimenti_magazzino_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Movimenti_magazzino_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Movimenti_magazzino_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function get_info_magazzino($id_magazzino){
      $magazzino = $this->get($id_magazzino);
      if($magazzino != FALSE){
         $magazzino->ubicazioni = $this->get_lista_ubicazioni($id_magazzino);
      }
      return $magazzino;
   }
   
   public function get_movimento($id_movimento){
      $this->db->from(Movimenti_magazzino_DTO::TABLE_NAME)
              ->where(Movimenti_magazzino_DTO::FIELD_ID, $id_movimento);
      return $this->_get(Movimenti_magazzino_DTO::class_name(), FALSE);
   }
   
   public function autocomplete_articoli($filtro){
      $this->db->distinct();
      $this->db->select(array(
          'm0.'.Magazzino_zero_DTO::FIELD_ID_LISTINO,
          'm0.'.Magazzino_zero_DTO::FIELD_LISTINO_CODICE,
          'l.'.Listini_DTO::FIELD_DESCRIZIONE,
          'l.'.Listini_DTO::FIELD_BRAND_CODE,
          'm0.'.Magazzino_zero_DTO::FIELD_QUANTITA." quantita_da_0"
      ));
      $this->db->from(Magazzino_zero_DTO::TABLE_NAME.' m0')
              ->join(Listini_DTO::TABLE_NAME.' l','l.'.Listini_DTO::FIELD_ID.' = '.'m0.'.Magazzino_zero_DTO::FIELD_ID_LISTINO);
      $this->db->join(Brands_DTO::TABLE_NAME.' b', 'b.'.Brands_DTO::FIELD_BRAND_CODE.' = '.'l.'.Listini_DTO::FIELD_BRAND_CODE);
      if($filtro != FALSE){
         $this->db->where('(l.'.Listini_DTO::FIELD_CODICE . " LIKE '%" . $filtro ."%' OR " . 'l.'.Listini_DTO::FIELD_DESCRIZIONE . " LIKE '%" . $filtro ."%' OR "."l.".Listini_DTO::FIELD_BRAND_CODE. " LIKE '%" . $filtro . "%' OR b.".Brands_DTO::FIELD_BRAND_NAME." LIKE '%$filtro%')");
      }
      $this->db->where('l.'.Listini_DTO::FIELD_ABILITATO, Listini_DTO::ABILITATO_SI);
      return $this->_get_list();
   }
   
   public function get_movimenti_table_feed(){
      $this->load->library('datatable_response_builder');
        $fields = array(
            array('db' => "m." . Movimenti_magazzino_DTO::FIELD_ID, 'dt' => 'id_movimento'),
            array('db' => "m." . Movimenti_magazzino_DTO::FIELD_DATA_MOVIMENTO, 'dt' => 'data_movimento'),
            array('db' => "m." . Movimenti_magazzino_DTO::FIELD_MOVIMENTO_CODICE, 'dt' => 'movimento_codice'),
            array('db' => "mag." . Magazzino_DTO::FIELD_NOME, 'dt' => 'magazzino'),
            array('db' => "m." . Movimenti_magazzino_DTO::FIELD_TIPO_MOVIMENTO, 'dt' => 'tipo_movimento'),
            array('db' => "m." . Movimenti_magazzino_DTO::FIELD_STATO_MOVIMENTO, 'dt' => 'stato')
        );
        $this->datatable_response_builder->set_fields($fields);
        $this->datatable_response_builder->set_table(Movimenti_magazzino_DTO::TABLE_NAME." m");
        $this->datatable_response_builder->add_join_clauses(Magazzino_DTO::TABLE_NAME . " mag", "mag." . Magazzino_DTO::FIELD_ID . " = m." . Movimenti_magazzino_DTO::FIELD_ID_MAGAZZINO);
        $this->datatable_response_builder->add_order_by_clauses(Movimenti_magazzino_DTO::FIELD_STATO_MOVIMENTO,'asc');
        $this->datatable_response_builder->add_order_by_clauses(Movimenti_magazzino_DTO::FIELD_DATA_MOVIMENTO,'asc');
        return $this->datatable_response_builder->build_response();
   }
   
   public function get_list_movements_details($id_movimento){
      $fileds = array(
          'l.'.Listini_DTO::FIELD_BRAND_CODE,
          'l.'.Listini_DTO::FIELD_CODICE,
          'l.'. Listini_DTO::FIELD_DESCRIZIONE,
          'md.'. Movimenti_magazzino_dettagli_DTO::FIELD_QUANTITA,
          'mu.'.Magazzino_ubicazione_DTO::FIELD_CODICE_UBICAZIONE
      );
      $this->db->select($fileds);
      $this->db->from(Movimenti_magazzino_dettagli_DTO::TABLE_NAME.' md')
              ->join(Listini_DTO::TABLE_NAME.' l', 'l.'.Listini_DTO::FIELD_ID.' = '.'md.'.Movimenti_magazzino_dettagli_DTO::FIELD_ID_ARTICOLO)
              ->join(Magazzino_ubicazione_DTO::TABLE_NAME.' mu','mu.'.Magazzino_ubicazione_DTO::FIELD_ID.' = '.'md.'.Movimenti_magazzino_dettagli_DTO::FIELD_ID_UBICAZIONE, ' LEFT');
      $this->db->where('md.'.Movimenti_magazzino_dettagli_DTO::FIELD_ID_MOVIMENTO, $id_movimento);
      return $this->_get_list();
   }
   
   public function save_movement_detail(Movimenti_magazzino_dettagli_DTO $dati){
      return $this->_insert(Movimenti_magazzino_dettagli_DTO::TABLE_NAME, $dati->get_data_for_db());
   }
   
   public function get_movimento_dettagli($id_movimento){
      $this->db->from(Movimenti_magazzino_dettagli_DTO::TABLE_NAME)
              ->where(Movimenti_magazzino_dettagli_DTO::FIELD_ID_MOVIMENTO, $id_movimento);
      return $this->_get_list(Movimenti_magazzino_dettagli_DTO::class_name());
   }


   public function get_movimento_magazzino_full($id_movimento){
      $movimento = $this->get_movimento($id_movimento);
      if($movimento != FALSE){
         $movimento->dettagli = $this->get_movimento_dettagli($id_movimento);
      }
      return $movimento;
   }
   
   public function get_articolo_esistente_in_magazzino($id_magazzino, $id_articolo, $id_ubicazione) {
      $this->db->from(Magazzino_ubicazione_articolo_DTO::TABLE_NAME)
              ->where(array(
                  Magazzino_ubicazione_articolo_DTO::FIELD_ID_MAGAZZINO => $id_magazzino,
                  Magazzino_ubicazione_articolo_DTO::FIELD_ID_LISTINO => $id_articolo
      ));
      if ($id_ubicazione != null) {
         $this->db->where(Magazzino_ubicazione_articolo_DTO::FIELD_ID_UBICAZIONE, $id_ubicazione);
      }
      return $this->_get(Magazzino_ubicazione_articolo_DTO::class_name(), FALSE);
   }
   
   public function salva_articolo_in_magazzino(Magazzino_ubicazione_articolo_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Magazzino_ubicazione_articolo_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Magazzino_ubicazione_articolo_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Magazzino_ubicazione_articolo_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function chiudi_movimento($id_movimento){
      $dto = new Movimenti_magazzino_DTO();
      $dto->id = $id_movimento;
      $dto->stato_movimento = Movimenti_magazzino_DTO::STATO_CHIUSO;
      return $this->salva_movimento($dto);
   }
   
   public function salva_articolo_magazzino_zero(Magazzino_zero_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Magazzino_zero_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Magazzino_zero_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Magazzino_zero_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }


   public function get_articolo_magazzino_zero($id_articolo){
      $this->db->from(Magazzino_zero_DTO::TABLE_NAME)
              ->where(Magazzino_zero_DTO::FIELD_ID_LISTINO, $id_articolo);
      return $this->_get(Magazzino_zero_DTO::class_name(), FALSE);
   }


   public function aggiorna_articolo_magazzino_zero($id_articolo, $quantita){
      $art = $this->get_articolo_magazzino_zero($id_articolo);
      if($art == FALSE) return FALSE;
      $art->quantita -= $quantita;
      return $this->salva_articolo_magazzino_zero($art);
   }

   public function chiudi_movimento_magazzino($id_movimento) {
      $this->db->trans_start();
      $movimento = $this->get_movimento_magazzino_full($id_movimento);
      $dettagli = $movimento->dettagli;
      $id_magazzino = $movimento->id_magazzino;
      foreach ($dettagli as $k => $dettaglio) {
         $id_articolo = $dettaglio->id_articolo;
         $id_ubicazione = $dettaglio->id_ubicazione;
         $articolo_esistente = $this->get_articolo_esistente_in_magazzino($id_magazzino, $id_articolo, $id_ubicazione);
         if ($articolo_esistente == FALSE) {
            $new_entry = new Magazzino_ubicazione_articolo_DTO();
            $new_entry->id_magazzino = $id_magazzino;
            $new_entry->id_ubicazione = $dettaglio->id_ubicazione;
            $new_entry->id_listino = $dettaglio->id_articolo;
            $new_entry->quantita = $dettaglio->quantita;
            $this->salva_articolo_in_magazzino($new_entry);
         } else {
            $articolo_esistente->quantita += $dettaglio->quantita;
            $this->salva_articolo_in_magazzino($articolo_esistente);
         }
         $this->aggiorna_articolo_magazzino_zero($dettaglio->id_articolo, $dettaglio->quantita);
      }
      $this->chiudi_movimento($id_movimento);
      if ($this->db->trans_status() === FALSE) {
         $this->db->trans_rollback();
         return FALSE;
      } else {
         $this->db->trans_commit();
         return TRUE;
      }
   }
   
   public function allow_save_movement($id_movimento, $id_articolo){
      $this->db->from(Movimenti_magazzino_dettagli_DTO::TABLE_NAME)
              ->where(array(Movimenti_magazzino_dettagli_DTO::FIELD_ID_MOVIMENTO => $id_movimento, Movimenti_magazzino_dettagli_DTO::FIELD_ID_ARTICOLO => $id_articolo));
      return $this->_get(Movimenti_magazzino_dettagli_DTO::class_name(), FALSE);
   }

}

