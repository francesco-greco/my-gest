<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CH_Model {
    
    public function get_articolo_by_listino($id_listino){
       $this->load->model('headquarters_model');
       $result = array();
       $lista_sedi = $this->headquarters_model->get_list();
       $result['MAG0'] = $this->get_articolo_dettagli($id_listino);
       return $result;
    }
    
    public function get_articolo_dettagli($id_listino) {
      $this->db->from(Magazzino_zero_DTO::TABLE_NAME)
              ->where(Magazzino_zero_DTO::FIELD_ID_LISTINO, $id_listino);
      return $this->_get(Magazzino_zero_DTO::class_name(), FALSE);
    }
   
   public function carica_articolo_in_magazzino(Ddt_dettaglio_DTO $dati, Listini_DTO $listino){
      $dettagli_articolo = $this->get_articolo_dettagli($listino->id, $this->bitauth->id_sede);
      if($dettagli_articolo == FALSE){
         $dettaglio = new Magazzino_zero_DTO();
         $dettaglio->id_listino = $listino->id;
//         $dettaglio->id_sede = $this->bitauth->id_sede;
         $dettaglio->listino_codice = $dati->codice_articolo;
         $dettaglio->operatore_ultimo_aggiornamento = $this->bitauth->fullname;
         $dettaglio->quantita = $dati->quantita;
         return $this->_insert(Magazzino_zero_DTO::TABLE_NAME, $dettaglio->get_data_for_db());
      } else {
         $dettaglio = new Magazzino_zero_DTO();
         $dettaglio->quantita = $dati->quantita + $dettagli_articolo->quantita;
         $dettaglio->id = $dettagli_articolo->id;
         return $this->update_quantita($dettaglio);
      }
   }
   
   public function update_quantita(Magazzino_zero_DTO $dati){
      $this->db->where(Magazzino_zero_DTO::FIELD_ID, $dati->id);
      return $this->db->update(Magazzino_zero_DTO::TABLE_NAME, $dati->get_data_for_db());
   }

}