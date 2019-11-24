<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Counters_model extends CH_Model {

    const TABLE_NAME = 'counters';
    const FIELD_ANNO = 'year';
    const FIELD_MESE = 'month';
    const FIELD_CONTATORE = 'counter';
    const FIELD_TIPO = 'type';
    const GENERE_ANNUALE = 1;
    const GENERE_MENSILE = 2;
    const CONTATORE_TIPO_INTERVENTO = 10;
    const CONTATORE_TIPO_MOVIMENTI = 11;
    
    public function get_new_counter_intervention() {
        $counter_array = $this->nuovo_contatore_intervento();
        return substr($counter_array['year'], 2)."/". str_pad($counter_array['counter'], 5, "0", STR_PAD_LEFT);
    }
    
    public function get_new_counter_move() {
      $counter_array = $this->nuovo_contatore_movimento();
      return substr($counter_array['year'], 2) . "/" . str_pad($counter_array['counter'], 6, "0", STR_PAD_LEFT);
    }

   private function nuovo_contatore_intervento($rif_date = NULL) {
        return $this->nuovo_contatore(self::GENERE_ANNUALE, self::CONTATORE_TIPO_INTERVENTO, $rif_date);
    }
    
    private function nuovo_contatore_movimento($rif_date = NULL) {
        return $this->nuovo_contatore(self::GENERE_ANNUALE, self::CONTATORE_TIPO_MOVIMENTI, $rif_date);
    }

    private function nuovo_contatore($genere, $tipo, $rif_date = NULL) {
        $t = ($rif_date !== NULL) ? strtotime(normal_to_db_date($rif_date)) : time();
        $now = getdate($t);

        $contatore_params = array(
            self::FIELD_ANNO => $now['year'],
            self::FIELD_MESE => $genere === self::GENERE_ANNUALE ? 13 : $now['mon'],
            self::FIELD_TIPO => $tipo
        );

        $contatore_val = $this->prendi_ultimo_contatore($contatore_params);

        return $this->aggiorna_contatore($contatore_val, $contatore_params);
    }

    public function prendi_ultimo_num_contatore($tipo, $anno = FALSE, $mese = FALSE) {
        $this->db->select(self::FIELD_CONTATORE);
        $this->db->from(self::TABLE_NAME);
        $this->db->where('tipo', $tipo);
        if ($anno) {
            $this->db->where('year', $anno);
        } else {
            $this->db->where('year', date('Y'));
        }
        if ($mese) {
            $this->db->where('month', $mese);
        } else {
            $this->db->where('month', date('13'));
        }

        $result = $query['counter'] = $this->_get(NULL, FALSE);
        return $result;
    }

    private function prendi_ultimo_contatore($filtro_contatore) {
        //cerca anno e mese nella tabella contatore
        $this->db->select(self::FIELD_CONTATORE);
        $this->db->from(self::TABLE_NAME);
        $this->db->where($filtro_contatore);
        $query = $this->db->get();

        $contatore = NULL;
        if ($query->num_rows() > 0) {
            $t = $query->row_array();
            $contatore = $t[self::FIELD_CONTATORE];
        }

        return $contatore;
    }

    private function aggiorna_contatore($contatore_val, $contatore_params, $start_value = 1) {
        $res = FALSE;
        $new_contatore_val = $start_value;
        $updated = array(
            'year' => $contatore_params[self::FIELD_ANNO],
            'month' => $contatore_params[self::FIELD_MESE]
        );

        if ($contatore_val !== NULL && is_numeric($contatore_val)) {
            $new_contatore_val = intval($contatore_val) + 1;
            $this->db->where($contatore_params);
            $res = $this->db->update(self::TABLE_NAME, array(self:: FIELD_CONTATORE => $new_contatore_val));
        } else {
            $contatore_params[self::FIELD_CONTATORE] = $new_contatore_val;
            $res = $this->db->insert(self::TABLE_NAME, $contatore_params);
        }

        $updated['counter'] = $new_contatore_val;
        return $res ? $updated : FALSE;
    }

}
