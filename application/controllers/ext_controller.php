<?php

class Ext_Controller extends CI_Controller {
   
   public function get_intervention_data($id_intervento){
      $this->load->model('interventions_model');
      $intervento = $this->interventions_model->get_intervention_full_data($id_intervento);
      $data = db_to_normal_date($intervento->expected_delivery_date);
      $string = "<!doctype html><html><head><meta charset='utf-8'><title>Info</title></head><body style='background: #7F604F; color: white; '><div style='padding: 5px 5px 5px 5px; font-size: 2em;'>";
      $string .= "<div style='text-align: center;'><img src='/my-gest/images/logo_moduli.png' style='width: 50%; margin-top: 30px;'></div><br>";
      $string .= "Gentile cliente <b>".$intervento->client->fullname."</b><br>La sua riparazione &eacute allo stato: <b>{$intervento->processing_stage->processing_stage_label}</b><br>";
      $string .= "Le ricordiamo che la data di consegna &eacute fissata per il giorno <b>{$data}</b>";
      $string .= "</div></body></html>";
      echo $string;
   }
   
}

