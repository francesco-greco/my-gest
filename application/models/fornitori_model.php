<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fornitori_model extends CH_Model {
   
   public function get_fornitori_table_feed() {
      $this->load->library('datatable_response_builder');
      $fields = array(
          array('db' => "f." . Fornitori_DTO::FIELD_ID, 'dt' => 'id_fornitore'),
          array('db' => "f." . Fornitori_DTO::FIELD_RAGIONE_SOCIALE, 'dt' => 'ragione_sociale'),
          array('db' => "f." . Fornitori_DTO::FIELD_TELEFONO_1, 'dt' => 'telefono_1'),
          array('db' => "f." . Fornitori_DTO::FIELD_TELEFONO_2, 'dt' => 'telefono_2'),
          array('db' => "f." . Fornitori_DTO::FIELD_REFERENTE, 'dt' => 'referente'),
          array('db' => "f." . Fornitori_DTO::FIELD_REFERENTE_RECAPITO, 'dt' => 'referente_recapito'),
          array('db' => "f." . Fornitori_DTO::FIELD_EMAIL_1, 'dt' => 'email')
      );
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Fornitori_DTO::TABLE_NAME . " f");
      $this->datatable_response_builder->add_order_by_clauses(Fornitori_DTO::FIELD_RAGIONE_SOCIALE, 'asc');
      return $this->datatable_response_builder->build_response();
   }
   
   public function save(Fornitori_DTO $dto){
      if($dto->id != ''){
         $this->db->where(Fornitori_DTO::FIELD_ID, $dto->id);
         return $this->db->update(Fornitori_DTO::TABLE_NAME, $dto->get_data_for_db());
      } else {
         return $this->_insert(Fornitori_DTO::TABLE_NAME, $dto->get_data_for_db());
      }
   }
   
   public function get($id_supplier){
      $this->db->from(Fornitori_DTO::TABLE_NAME)
              ->where(Fornitori_DTO::FIELD_ID, $id_supplier);
      return $this->_get(Fornitori_DTO::class_name(),FALSE);
   }
   
   public function get_list($filter = FALSE){
      $this->db->from(Fornitori_DTO::TABLE_NAME);
      if($filter != FALSE){
         $this->db->or_like(array(Fornitori_DTO::FIELD_RAGIONE_SOCIALE => $filter, Fornitori_DTO::FIELD_P_IVA => $filter, Fornitori_DTO::FIELD_CODICE_FISCALE => $filter));
      }
      $query = $this->db->get();
      $list = array();
      foreach ($query->result_array() as $row) {
			$fornitore = new Fornitori_DTO($row);
			$list[] = $fornitore;
		}
      return $list;
   }

}