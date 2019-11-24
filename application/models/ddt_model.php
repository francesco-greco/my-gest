<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ddt_model extends CH_Model {
   
   public function save(Ddt_DTO $dati){
      if($dati->id != ''){
         $this->db->where(Ddt_DTO::FIELD_ID, $dati->id);
         $result = $this->db->update(Ddt_DTO::TABLE_NAME, $dati->get_data_for_db());
         return $dati->id;
      } else {
         return $this->_insert(Ddt_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function get($id_ddt){
      $this->db->from(Ddt_DTO::TABLE_NAME)
              ->where(Ddt_DTO::FIELD_ID, $id_ddt);
      $result = $this->_get(Ddt_DTO::class_name(), FALSE);
      if($result == FALSE){
         return $result;
      } else {
         $this->load->model('fornitori_model');
         $result->fornitore = $this->fornitori_model->get($result->id_fornitore);
         return $result;
      }
   }
   
   public function get_details($id_ddt){
      require_once APPPATH.'dto/listini_dto.php';
      $this->db->select(Ddt_dettaglio_DTO::TABLE_NAME.'.*, l.'.Listini_DTO::FIELD_DESCRIZIONE.' descrizione');
      $this->db->from(Ddt_dettaglio_DTO::TABLE_NAME)
              ->join(Listini_DTO::TABLE_NAME.' l', Listini_DTO::FIELD_BRAND_CODE . ' = ' .Ddt_dettaglio_DTO::FIELD_CODICE_BRAND.' AND '.Ddt_dettaglio_DTO::FIELD_CODICE_ARTICOLO . ' = ' .Listini_DTO::FIELD_CODICE)
              ->where(Ddt_dettaglio_DTO::FIELD_ID_DDT, $id_ddt);
      $result = $this->_get_list(Ddt_dettaglio_DTO::class_name());
      return $result;
   }
   
   public function save_detail(Ddt_dettaglio_DTO $dati){
      $this->load->model('listini_model');
      $data = array();
      $listino = $this->listini_model->get_listino_by_brand_and_code($dati->id_brand, $dati->codice_articolo);
      if($listino != FALSE){
         $dati->codice_brand = $listino->brand_code;
         $res_first = $this->_insert(Ddt_dettaglio_DTO::TABLE_NAME, $dati->get_data_for_db());
         if($res_first != FALSE){
            $data['error'] = FALSE;
         } else {
            $data['error'] = TRUE;
            $data['message'] = "Attenzione qualcosa è andato storto, riprovare o contattare personale IT!";
         }
      } else {
         $data['error'] = TRUE;
         $data['message'] = "Attenzione prodotto non associato a nessun listino, impossibile inserire in magazzino!";
      }
      return $data;
   }
   
   public function get_ddt_table_feed(){
      $this->load->library('datatable_response_builder');
      $fields = array(
          array('db' => "d." . Ddt_DTO::FIELD_ID, 'dt' => 'id_ddt'),
          array('db' => "h." . Headquarters_DTO::FIELD_STOCK_DESCRIPTION, 'dt' => 'sede'),
          array('db' => "f." . Fornitori_DTO::FIELD_RAGIONE_SOCIALE, 'dt' => 'fornitore'),
          array('db' => "d." . Ddt_DTO::FIELD_DATA_DOCUMENTO, 'dt' => 'data_documento'),
          array('db' => "d." . Ddt_DTO::FIELD_NUMERO_DOCUMENTO, 'dt' => 'numero_documento')
      );
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Ddt_DTO::TABLE_NAME . " d");
      $this->datatable_response_builder->add_join_clauses(Headquarters_DTO::TABLE_NAME." h", "h.". Headquarters_DTO::FIELD_ID." = d.". Ddt_DTO::FIELD_ID_SEDE);
      $this->datatable_response_builder->add_join_clauses(Fornitori_DTO::TABLE_NAME." f", "f.". Fornitori_DTO::FIELD_ID." = d.". Ddt_DTO::FIELD_ID_FORNITORE);
      $this->datatable_response_builder->add_order_by_clauses(Ddt_DTO::FIELD_DATA_DOCUMENTO, 'desc');
      $this->datatable_response_builder->add_where_clauses('d.'. Ddt_DTO::FIELD_STATO . ' = '. Ddt_DTO::STATO_APERTO);
      $this->datatable_response_builder->add_where_clauses('d.'. Ddt_DTO::FIELD_ID_SEDE . ' = '. $this->bitauth->id_sede);
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_ddt_old_table_feed(){
      $this->load->library('datatable_response_builder');
      $fields = array(
          array('db' => "d." . Ddt_DTO::FIELD_ID, 'dt' => 'id_ddt'),
          array('db' => "h." . Headquarters_DTO::FIELD_STOCK_DESCRIPTION, 'dt' => 'sede'),
          array('db' => "f." . Fornitori_DTO::FIELD_RAGIONE_SOCIALE, 'dt' => 'fornitore'),
          array('db' => "d." . Ddt_DTO::FIELD_DATA_DOCUMENTO, 'dt' => 'data_documento'),
          array('db' => "d." . Ddt_DTO::FIELD_NUMERO_DOCUMENTO, 'dt' => 'numero_documento')
      );
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Ddt_DTO::TABLE_NAME . " d");
      $this->datatable_response_builder->add_join_clauses(Headquarters_DTO::TABLE_NAME." h", "h.". Headquarters_DTO::FIELD_ID." = d.". Ddt_DTO::FIELD_ID_SEDE);
      $this->datatable_response_builder->add_join_clauses(Fornitori_DTO::TABLE_NAME." f", "f.". Fornitori_DTO::FIELD_ID." = d.". Ddt_DTO::FIELD_ID_FORNITORE);
      $this->datatable_response_builder->add_order_by_clauses(Ddt_DTO::FIELD_DATA_DOCUMENTO, 'desc');
      $this->datatable_response_builder->add_where_clauses('d.'. Ddt_DTO::FIELD_STATO . ' = '. Ddt_DTO::STATO_CHIUSO);     
      return $this->datatable_response_builder->build_response();
   }
   
   public function delete_detail($id_detail){
      return $this->db->where(Ddt_dettaglio_DTO::FIELD_ID, $id_detail)->delete(Ddt_dettaglio_DTO::TABLE_NAME);
   }
   
   public function close_ddt($id_ddt) {
      $result = array();
      $this->db->trans_start();
      $details = $this->get_details($id_ddt);
      if (count($details) === 0) {
         $result['response'] = CH_RESPONSE_SUCCESS;
         $result['action'] = FALSE;
         $result['message'] = "Il documento non contiene alcun dettaglio, impossibile chiudere documento!";
      } else {
         $this->load->model('listini_model');
         foreach ($details as $k => $detail) {
            $listino = $this->listini_model->get_listino_by_brand_and_code($detail->id_brand, $detail->codice_articolo);
            $this->products_model->carica_articolo_in_magazzino($detail, $listino);
         }
         $this->set_close($id_ddt);
         if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result['response'] = CH_RESPONSE_FAILURE;
         } else {
            $this->db->trans_commit();
            $result['response'] = CH_RESPONSE_SUCCESS;
            $result['action'] = TRUE;
            $result['message'] = "Documento chiuso correttamente e articoli caricati in magazzino";
         }
      }
      return $result;
   }
   
   private function set_close($id_ddt){
      $ddt_dto = new Ddt_DTO();
      $ddt_dto->stato = Ddt_DTO::STATO_CHIUSO;
      $ddt_dto->id = $id_ddt;
      return $this->save($ddt_dto);
   }
   
   public function get_list($id_brand, $filtro = FALSE){
      require_once APPPATH.'dto/listini_dto.php';
      $this->db->select(array(
          'l.'.Listini_DTO::FIELD_CODICE,
          'l.'.Listini_DTO::FIELD_DESCRIZIONE
      ));
      $this->db->from(Listini_DTO::TABLE_NAME.' l')
              ->join(Brands_DTO::TABLE_NAME.' b', 'b.'.Brands_DTO::FIELD_BRAND_CODE.' = '.'l.'.Listini_DTO::FIELD_BRAND_CODE)
              ->where('b.'.Brands_DTO::FIELD_ID, $id_brand);
      if($filtro != FALSE){
         $this->db->where('(l.'.Listini_DTO::FIELD_CODICE . " LIKE '%" . $filtro ."%' OR " . 'l.'.Listini_DTO::FIELD_DESCRIZIONE . " LIKE '%" . $filtro ."%')");
      }
      $query = $this->db->get();
      $list = array();
      foreach ($query->result_array() as $row) {
			$list[] = (object)$row;
		}
      return $list;
   }

}

