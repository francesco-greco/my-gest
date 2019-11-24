<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'dto/intervention_dto.php';
require_once APPPATH.'dto/brands_dto.php';
require_once APPPATH.'dto/client_data_dto.php';
require_once APPPATH.'dto/processing_stage_dto.php';
require_once APPPATH.'dto/intervention_cost_dto.php';

class Interventions_model extends CH_Model {
    
    public function save_intervention(Intervention_DTO $intervention){
        if($intervention->id == null){
            return $this->_insert(Intervention_DTO::TABLE_NAME, $intervention->get_data_for_db());
        } else {
            $this->db->where(Intervention_DTO::FIELD_ID, $intervention->id);
            return $this->db->update(Intervention_DTO::TABLE_NAME, $intervention->get_data_for_db());
        }
    }
    
    public function get_interventions_by_client($id_client){
        $this->db->from(Intervention_DTO::TABLE_NAME)
                ->where(Intervention_DTO::FIELD_ID_CLIENT, $id_client);
        return $this->_get_list(Intervention_DTO::class_name());
    }
    
    public function get_historical_client($id_client){
        $this->db->from(Intervention_DTO::TABLE_NAME .' i')
                ->join(Processing_stage_DTO::TABLE_NAME.' p', 'p.'.Processing_stage_DTO::FIELD_ID. ' = i.'.Intervention_DTO::FIELD_ID_PROCESSING_STAGE)
                ->where(array('i.'.Intervention_DTO::FIELD_ID_CLIENT => $id_client, 'p.'.Processing_stage_DTO::FIELD_PROCESSING_STAGE => Processing_stage_DTO::STAGE_RICONSEGNA_CLIENTE));
        return $this->_get_list(Intervention_DTO::class_name());
    }
    
    public function get_processing_stage($processing_stage) {
        $this->db->from(Processing_stage_DTO::TABLE_NAME)
                ->where(Processing_stage_DTO::FIELD_PROCESSING_STAGE, $processing_stage);
        return $this->_get(Processing_stage_DTO::class_name(), FALSE);
    }
    
    public function get_processing_stage_by_id($id_processing_stage){
        $this->db->from(Processing_stage_DTO::TABLE_NAME)
                ->where(Processing_stage_DTO::FIELD_ID, $id_processing_stage);
        return $this->_get(Processing_stage_DTO::class_name(), FALSE);
    }
    
    public function get_interventions_table_feed() {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => "i.".Intervention_DTO::FIELD_ID, 'dt' => 'id_intervention'),
         array('db' => "i.".Intervention_DTO::FIELD_INTERVENTION_CODE, 'dt' => 'intervention_code'),
         array('db' => "i.".Intervention_DTO::FIELD_CREATION_DATE, 'dt' => 'creation_date'),
         array('db' => "i.".Intervention_DTO::FIELD_OBJECT_DESCRIPTION, 'dt' => 'object_description'),
         array('db' => "b.".Brands_DTO::FIELD_BRAND_NAME, 'dt' => 'brand_name'),
         array('db' => "c.".Client_data_DTO::FIELD_SURNAME, 'dt' => 'surname'),
         array('db' => "i.".Intervention_DTO::FIELD_SERIAL_NUMBER, 'dt' => 'serial_number'),
         array('db' => "i.".Intervention_DTO::FIELD_WARRANTY_YES, 'dt' => 'garanzia'),
         array('db' => "h.".Headquarters_DTO::FIELD_STOCK_DESCRIPTION, 'dt' => 'sede'), 
      );
      
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Intervention_DTO::TABLE_NAME." i");
      $this->datatable_response_builder->add_join_clauses(Client_data_DTO::TABLE_NAME." c", "c.".Client_data_DTO::FIELD_USERDATA_ID." = i.".Intervention_DTO::FIELD_ID_CLIENT, "left");
      $this->datatable_response_builder->add_join_clauses(Brands_DTO::TABLE_NAME." b", "b.".Brands_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_BRAND, "left");
      $this->datatable_response_builder->add_join_clauses(Processing_stage_DTO::TABLE_NAME." p", "p.". Processing_stage_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_PROCESSING_STAGE);
      $this->datatable_response_builder->add_join_clauses(Headquarters_DTO::TABLE_NAME." h", "h.". Headquarters_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_SEDE);
      $this->datatable_response_builder->add_where_clauses('i.'.Intervention_DTO::FIELD_STATUS . ' = '. Intervention_DTO::STATUS_OPENED);
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_old_interventions_table_feed() {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => "i.".Intervention_DTO::FIELD_ID, 'dt' => 'id_intervention'),
         array('db' => "i.".Intervention_DTO::FIELD_INTERVENTION_CODE, 'dt' => 'intervention_code'),
         array('db' => "i.".Intervention_DTO::FIELD_CREATION_DATE, 'dt' => 'creation_date'),
         array('db' => "i.".Intervention_DTO::FIELD_OBJECT_DESCRIPTION, 'dt' => 'object_description'),
         array('db' => "b.".Brands_DTO::FIELD_BRAND_NAME, 'dt' => 'brand_name'),
         array('db' => "c.".Client_data_DTO::FIELD_SURNAME, 'dt' => 'surname'),
         array('db' => "i.".Intervention_DTO::FIELD_SERIAL_NUMBER, 'dt' => 'serial_number'),
         array('db' => "i.".Intervention_DTO::FIELD_WARRANTY_YES, 'dt' => 'garanzia'),
         array('db' => "h.".Headquarters_DTO::FIELD_STOCK_DESCRIPTION, 'dt' => 'sede'),  
      );
      
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Intervention_DTO::TABLE_NAME." i");
      $this->datatable_response_builder->add_join_clauses(Client_data_DTO::TABLE_NAME." c", "c.".Client_data_DTO::FIELD_USERDATA_ID." = i.".Intervention_DTO::FIELD_ID_CLIENT, "left");
      $this->datatable_response_builder->add_join_clauses(Brands_DTO::TABLE_NAME." b", "b.".Brands_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_BRAND, "left");
      $this->datatable_response_builder->add_join_clauses(Processing_stage_DTO::TABLE_NAME." p", "p.". Processing_stage_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_PROCESSING_STAGE);
      $this->datatable_response_builder->add_join_clauses(Headquarters_DTO::TABLE_NAME." h", "h.". Headquarters_DTO::FIELD_ID." = i.".Intervention_DTO::FIELD_ID_SEDE);
      $this->datatable_response_builder->add_where_clauses('i.'.Intervention_DTO::FIELD_STATUS . ' = '. Intervention_DTO::STATUS_CLOSED);
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_intervention($id_intervention){
       $this->db->from(Intervention_DTO::TABLE_NAME)
               ->where(Intervention_DTO::FIELD_ID, $id_intervention);
       return $this->_get(Intervention_DTO::class_name(),FALSE);
   }
   
   public function get_count_entries($serial_number){
       $this->db->from(Intervention_DTO::TABLE_NAME)
               ->where(Intervention_DTO::FIELD_SERIAL_NUMBER, $serial_number);
       $this->db->where(Intervention_DTO::FIELD_STATUS, Intervention_DTO::STATUS_CLOSED);
       return $this->_get_list(Intervention_DTO::class_name());
   }
   
   public function get_intervention_full_data($id_intervention){
       $this->load->model(array('brands_model','clients_model'));
       $this->db->from(Intervention_DTO::TABLE_NAME)
               ->where(Intervention_DTO::FIELD_ID, $id_intervention);
       $intervention = $this->_get(Intervention_DTO::class_name(),FALSE);
       if($intervention != FALSE){
           $brand = $this->brands_model->get_brand($intervention->id_brand);
           $intervention->brand = $brand;
           $intervention->client = $this->clients_model->get_client($intervention->id_client);
           $intervention->processing_stage = $this->get_processing_stage_by_id($intervention->id_processing_stage);
           $intervention->category = $this->get_category($intervention->id_categoria);
           $intervention->extra_data = $this->get_extra_data_for_brand($intervention);
       }
       return $intervention;
   }
   
   public function get_cost($id_intervention){
      $this->db->from(Intervention_cost_DTO::TABLE_NAME)
              ->where(Intervention_cost_DTO::FIELD_ID_INTERVENTION, $id_intervention);
      $result = $this->_get(Intervention_cost_DTO::class_name(),FALSE);
      if($result != FALSE){
         $details = $this->get_cost_details($result->id);
         $result->details = $details;
      }
      return $result;
   }
   
   public function get_cost_details($id_cost, $type = FALSE){
      $this->db->from(Intervention_cost_details_DTO::TABLE_NAME)
              ->where(Intervention_cost_details_DTO::FIELD_ID_INTERVENTION_COST, $id_cost);
      if($type !== FALSE){
         $this->db->where(Intervention_cost_details_DTO::FIELD_TYPE, $type);
      }
      return $this->_get_list(Intervention_cost_details_DTO::class_name());
   }
   
   public function save_cost(Intervention_cost_DTO $dto){
      if($dto->id == ''){
         return $this->_insert(Intervention_cost_DTO::TABLE_NAME, $dto->get_data_for_db());
      } else {
         $this->db->where(Intervention_cost_DTO::FIELD_ID, $dto->id);
         return $this->db->update(Intervention_cost_DTO::TABLE_NAME, $dto->get_data_for_db());
      }
   }
   
   public function get_intervention_cost_details($id_intervention){
      $return = array();
      $return['manodopera_details'] = array();
      $return['materiali_details'] = array();
      $cost = $this->get_cost($id_intervention);
      if($cost !== FALSE){
         $id_cost = $cost->id;
         $return['manodopera_details'] = $this->get_cost_details($id_cost, Intervention_cost_details_DTO::TYPE_MANODOPERA);
         $return['materiali_details'] = $this->get_cost_details($id_cost, Intervention_cost_details_DTO::TYPE_MATERIALI);
      }
      return $return;
   }
   
   public function get_category_list(){
      $this->db->from(Interventi_categoria_DTO::TABLE_NAME);
      return $this->_get_list(Interventi_categoria_DTO::class_name());
   }
   
   public function get_category($id_category){
      $this->db->from(Interventi_categoria_DTO::TABLE_NAME)
              ->where(Interventi_categoria_DTO::FIELD_ID, $id_category);
      return $this->_get(Interventi_categoria_DTO::class_name(), FALSE);
   }
   
   public function save_category(Interventi_categoria_DTO $dati){
      if($dati->id == ''){
         return $this->_insert(Interventi_categoria_DTO::TABLE_NAME, $dati->get_data_for_db());
      } else {
         $this->db->from(Interventi_categoria_DTO::TABLE_NAME)
                 ->where(Interventi_categoria_DTO::FIELD_ID, $dati->id);
         return $this->db->update(Interventi_categoria_DTO::TABLE_NAME, $dati->get_data_for_db());
      }
   }
   
   
   public function get_extra_data_for_brand($intervention){
      if($intervention->brand->brand_code == Brands_DTO::BRAND_IMETEC){
         return $this->get_imetec_extra_data($intervention);
      }
   }
   
   private function get_imetec_extra_data($intervention){
      $this->load->model(array('listini_model'));
      $brand_id = $intervention->id_brand;
      $modello = $intervention->model;
      $this->db->trans_start();
      $listino = $this->listini_model->get_listino_by_brand_and_code($brand_id, $modello);
      $listino_extra = $this->listini_model->get_dati_extra_imetec_by_listino($listino->id);
      $type = $this->listini_model->get_imetec_codice_tipo($modello);
      $date_produzione = $this->listini_model->get_imetec_date_produzione_by_codice_prodotto($modello);
      $codici_difetto = $this->listini_model->get_codici_difetto($listino_extra->gruppo_merce);
      $distinta_base = $this->listini_model->get_imetec_distinta_base_by_codice_prodotto_finito($modello);
      if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
      $return = array(
          'listino' => $listino,
          'dati_extra_listino' => $listino_extra,
          'type' => $type,
          'date_produzione' => $date_produzione,
          'codici_difetto' => $codici_difetto,
          'distinta_base' => $distinta_base
      );
      return $return;
   }

}
