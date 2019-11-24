<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'dto/listini_dto.php';

class Listini_model extends CH_Model {
    
    public function save(Listini_DTO $listino){
        if($listino->id != ''){
            $this->db->where(Listini_DTO::FIELD_ID, $listino->id);
            return $this->db->update(Listini_DTO::TABLE_NAME, $listino->get_data_for_db());
        } else {
            return $this->_insert(Listini_DTO::TABLE_NAME, $listino->get_data_for_db());
        }
    }
    
    public function get_listini_table_feed($custom_filter) {
        $this->load->library('datatable_response_builder');
        $fields = array(
            array('db' => "l." . Listini_DTO::FIELD_ID, 'dt' => 'id_listino'),
            array('db' => "b." . Brands_DTO::FIELD_BRAND_NAME, 'dt' => 'brand'),
            array('db' => "b." . Brands_DTO::FIELD_BRAND_CODE, 'dt' => 'brand_code'),
            array('db' => "l." . Listini_DTO::FIELD_CODICE, 'dt' => 'codice'),
            array('db' => "l." . Listini_DTO::FIELD_DESCRIZIONE, 'dt' => 'descrizione'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_ACQUISTO, 'dt' => 'acquisto'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_PUBBLICO_1, 'dt' => 'vendita_1'),
            array('db' => "l." . Listini_DTO::FIELD_ACQUISTO_PREZZO_NETTO, 'dt' => 'acquisto_prezzo_netto'),
            array('db' => "l." . Listini_DTO::FIELD_PREZZO_RIFATTURAZIONE, 'dt' => 'rifatturazione')
        );
        $this->datatable_response_builder->set_fields($fields);
        $this->datatable_response_builder->set_table(Listini_DTO::TABLE_NAME . " l");
        $this->datatable_response_builder->add_join_clauses(Brands_DTO::TABLE_NAME . " b", "b." . Brands_DTO::FIELD_BRAND_CODE . " = l." . Listini_DTO::FIELD_BRAND_CODE);
        $this->datatable_response_builder->add_order_by_clauses(Brands_DTO::FIELD_BRAND_NAME,'desc');
        $this->datatable_response_builder->add_where_clauses('l.'. Listini_DTO::FIELD_ABILITATO . ' = '. Listini_DTO::ABILITATO_SI);
        if($custom_filter != '' && $custom_filter != FALSE){
           $this->datatable_response_builder->add_where_clauses('l.'. Listini_DTO::FIELD_BRAND_CODE . ' = "'.$custom_filter.'"');
        }
        return $this->datatable_response_builder->build_response();
    }
    
    public function get_listino($id_listino){
        $this->load->model(array('brands_model','products_model'));
        $this->db->from(Listini_DTO::TABLE_NAME)
                ->where(Listini_DTO::FIELD_ID, $id_listino);
        $listino = $this->_get(Listini_DTO::class_name(),FALSE);
        if($listino == FALSE){ 
            return FALSE;
        } else {
           $listino->brand = $this->brands_model->get_brand_by_code($listino->brand_code);
           $dettagli = $this->get_full_data_listino_magazzini($id_listino);
           return array('listino' => $listino, 'dettagli' => $dettagli);
//            $listino->articolo = $this->products_model->get_articolo_by_listino($listino->id);
//            return $listino;
        }
    }
    
    public function get_full_data_listino_magazzini($id_listino) {
       $sql = "SELECT 
               h.id id_sede, 
		         h.stock_description sede, 
		         m.nome nome_magazzino, 
		         m.codice codice_magazzino, IFNULL((
               SELECT SUM(mua.quantita)
               FROM magazzino_ubicazione_articolo mua
               WHERE mua.id_magazzino = m.id AND mua.id_listino = $id_listino),0) quantita, IFNULL((
               SELECT GROUP_CONCAT(mu.codice_ubicazione)
               FROM magazzino_ubicazione mu
               JOIN magazzino_ubicazione_articolo muaa
               WHERE muaa.id_magazzino = m.id AND muaa.id_listino = $id_listino AND mu.id = muaa.id_ubicazione),'--') ubicazioni
               FROM magazzino m
               JOIN headquarters h ON h.id = m.id_sede UNION
               SELECT '' id_sede,'Stoccaggio' sede,'Magazzino 0' nome_magazzino,'STG' codice_magazzino,quantita,'--' ubicazioni
               FROM magazzino_zero
               WHERE id_listino = $id_listino
               ORDER BY id_sede";
      $query = $this->db->query($sql);
      $result = $query->result();
      foreach ($result as $row) {
         $ret[] = (object) $row;
      }
      return $ret;
   }

   public function get_listino_by_brand_and_code($id_brand, $code) {
      $this->load->model(array('brands_model', 'products_model'));
      $brand = $this->brands_model->get_brand($id_brand);
      if ($brand == FALSE)
         return FALSE;
      $this->db->from(Listini_DTO::TABLE_NAME)
              ->where(array(
                  Listini_DTO::FIELD_BRAND_CODE => $brand->brand_code,
                  Listini_DTO::FIELD_CODICE => $code
      ));
      return $this->_get(Listini_DTO::class_name(),FALSE);
   }
   
   public function save_by_code(Listini_DTO $listino, $return_id = FALSE){
        $listino_db = $this->get_listino_by_brand_code_and_code($listino->brand_code, $listino->codice);
        if($listino_db === FALSE){
           return $this->_insert(Listini_DTO::TABLE_NAME, $listino->get_data_for_db());
        } else {
           $this->db->where(array(
               Listini_DTO::FIELD_BRAND_CODE => $listino->brand_code,
               Listini_DTO::FIELD_CODICE => $listino->codice
           ));
           $return = $this->db->update(Listini_DTO::TABLE_NAME, $listino->get_data_for_db());
           if($return_id === FALSE){
              return $return;
           } else {
              return $listino_db->id;
           }       
        }
    }
    
    public function get_listino_by_brand_code_and_code($brand_code, $product_code) {
      $this->db->from(Listini_DTO::TABLE_NAME)
              ->where(array(
                  Listini_DTO::FIELD_BRAND_CODE => $brand_code,
                  Listini_DTO::FIELD_CODICE => $product_code
      ));
      return $this->_get(Listini_DTO::class_name(), FALSE);
   }
   
   public function get_modello_gruppo_merce_marchio_by_modello_gruppo_merce(Modello_gruppomerce_marchio_DTO $dati){
      $this->db->from(Modello_gruppomerce_marchio_DTO::TABLE_NAME)
              ->where(array(
              Modello_gruppomerce_marchio_DTO::FIELD_MODELLO => $dati->modello,
              Modello_gruppomerce_marchio_DTO::FIELD_GRUPPO_MERCE => $dati->gruppo_merce
              ));
      return $this->_get(Modello_gruppomerce_marchio_DTO::class_name(),FALSE);
   }


   public function save_modello_gruppo_marchio(Modello_gruppomerce_marchio_DTO $dati){
      $row_db = $this->get_modello_gruppo_merce_marchio_by_modello_gruppo_merce($dati);
      if($row_db === FALSE){
         return $this->_insert(Modello_gruppomerce_marchio_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(
                 array(
                 Modello_gruppomerce_marchio_DTO::FIELD_MODELLO => $dati->modello,
                 Modello_gruppomerce_marchio_DTO::FIELD_GRUPPO_MERCE => $dati->gruppo_merce
                 ));
         return $this->db->update(Modello_gruppomerce_marchio_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function save_data_extra_imetec_from_file(Listini_dati_extra_imetec_DTO $dati){
      $exists = $this->get_dati_extra_imetec_by_listino($dati->id_listino);
      if($exists === FALSE){
         return $this->save_listino_imetec_extra_data($dati);
      } else {
         $this->db->where(Listini_dati_extra_imetec_DTO::FIELD_ID_LISTINO, $dati->id_listino);
         return $this->db->update(Listini_dati_extra_imetec_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }


   public function get_dati_extra_imetec_by_listino($id_listino){
      $this->db->from(Listini_dati_extra_imetec_DTO::TABLE_NAME)
              ->where(Listini_dati_extra_imetec_DTO::FIELD_ID_LISTINO, $id_listino);
      return $this->_get(Listini_dati_extra_imetec_DTO::class_name(), FALSE);
   }


   public function save_listino_imetec_extra_data(Listini_dati_extra_imetec_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Listini_dati_extra_imetec_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Listini_dati_extra_imetec_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Listini_dati_extra_imetec_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }


   public function save_modello_tariffe_manodopera(Modello_tariffe_manodopera_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Modello_tariffe_manodopera_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Modello_tariffe_manodopera_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Modello_tariffe_manodopera_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function save_gruppomerce(Gruppomerce_codice_difetto_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Gruppomerce_codice_difetto_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Gruppomerce_codice_difetto_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Gruppomerce_codice_difetto_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function save_imetec_distinta_base_primo_livello(Imetec_distinta_base_primo_livello_DTO $dati) {
      if ($dati->id == '') {
         return $this->_insert(Imetec_distinta_base_primo_livello_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Imetec_distinta_base_primo_livello_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Imetec_distinta_base_primo_livello_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function get_imetec_distinta_base_by_codice_prodotto_finito($codice_prodotto){
      $this->db->from(Imetec_distinta_base_primo_livello_DTO::TABLE_NAME)
              ->where(Imetec_distinta_base_primo_livello_DTO::FIELD_CODICE_PRODOTTO, $codice_prodotto);
      return $this->_get_list(Imetec_distinta_base_primo_livello_DTO::class_name());
   }
   
   public function get_imetec_distinta_base_by_codice_prodotto_ricambio($codice_prodotto){
      $this->db->from(Imetec_distinta_base_primo_livello_DTO::TABLE_NAME)
              ->where(Imetec_distinta_base_primo_livello_DTO::FIELD_CODICE_ARTICOLO_RICAMBIO, $codice_prodotto);
      return $this->_get_list(Imetec_distinta_base_primo_livello_DTO::class_name());
   }
   
   public function save_imetec_difetto(Imetec_difetti_DTO $dati){
      if ($dati->id == '') {
         return $this->_insert(Imetec_difetti_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Imetec_difetti_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Imetec_difetti_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function save_imetec_codice_tipo(Imetec_codici_tipo_DTO $dati){
      if ($dati->id == '') {
         return $this->_insert(Imetec_codici_tipo_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Imetec_codici_tipo_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Imetec_codici_tipo_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function get_imetec_codice_tipo($codice_prodotto){
      $this->db->from(Imetec_codici_tipo_DTO::TABLE_NAME)
              ->where(Imetec_codici_tipo_DTO::FIELD_CODICE_PRODOTTO, $codice_prodotto);
      return $this->_get(Imetec_codici_tipo_DTO::class_name(),FALSE);
   }
   
   public function save_imetec_date_produzione(Imetec_date_produzione_valide_DTO $dati){
      if ($dati->id == '') {
         return $this->_insert(Imetec_date_produzione_valide_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->where(Imetec_date_produzione_valide_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Imetec_date_produzione_valide_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   public function save_imetec_date_produzione_by_codice_e_data(Imetec_date_produzione_valide_DTO $dati){
      $this->db->from(Imetec_date_produzione_valide_DTO::TABLE_NAME)
              ->where(array(
                  Imetec_date_produzione_valide_DTO::FIELD_CODICE_PRODOTTO => $dati->codice_prodotto,
                  Imetec_date_produzione_valide_DTO::FIELD_DATA_PRODUZIONE => $dati->data_produzione
      ));
      $exists = $this->_get(Imetec_date_produzione_valide_DTO::class_name(), false);
      if($exists == FALSE){
         return $this->save_imetec_date_produzione($dati);
      } else {
         return null;
      }
   }
   
   public function get_list_imdtpr_temp(){
      $this->db->from(Imetec_imdtpr_load_file_temp_DTO::TABLE_NAME);
      return $this->_get_list(Imetec_imdtpr_load_file_temp_DTO::class_name());
   }


   public function save_imetec_imdtpr_temp(Imetec_imdtpr_load_file_temp_DTO $dati){
      return $this->_insert(Imetec_imdtpr_load_file_temp_DTO::TABLE_NAME, $dati->get_data_for_db());
   }
   
   public function truncate_imetec_imdtpr_temp(){
      return $this->db->truncate(Imetec_imdtpr_load_file_temp_DTO::TABLE_NAME);
   }

   public function get_imetec_date_produzione_by_codice_prodotto($codice) {
      $this->db->from(Imetec_date_produzione_valide_DTO::TABLE_NAME)
              ->where(Imetec_date_produzione_valide_DTO::FIELD_CODICE_PRODOTTO, $codice);
      return $this->_get_list(Imetec_date_produzione_valide_DTO::class_name());
   }

   public function get_codici_difetto($gruppo_merce){
      $this->db->from(Imetec_difetti_DTO::TABLE_NAME)
              ->where(Imetec_difetti_DTO::FIELD_GRUPPO_MERCE, $gruppo_merce);
      return $this->_get_list(Imetec_difetti_DTO::class_name());
   }

}
