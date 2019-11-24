<?php 

require_once APPPATH.'classes/qrcode/my_qrcode_class.php';
require_once APPPATH.'classes/modulistica/modulistica_class.php';
require_once APPPATH.'classes/modulistica/modulistica_descriptor.php';
      
class Modulistica_ricevuta_ingresso_class extends Modulistica_class {
   var $needed_resource = array('id_intervention');
   var $id_intervention;
   var $intervention;
   var $client;

   protected function check_resources(Modulistica_resources $resources) {
      foreach($this->needed_resource as $r) {
         if(!$resources->has_resource($r)) return FALSE;
      }
      return TRUE;
   }

   protected function get_missing_resources(Modulistica_resources $resources) {
      $missing = array();
      foreach($this->needed_resource as $r) {
         if(!$resources->has_resource($r)) $missing[] = $r;
      }
      return implode(' ', $missing);
   }

   private function load_data() {
      $this->CI->load->model(array('interventions_model'));
      $this->id_intervention = $this->resources->get_resource('id_intervention');
      $this->intervento = $this->CI->interventions_model->get_intervention_full_data($this->id_intervention);
   }

   private function set_descriptor_default_vars(Modulistica_descriptor $descriptor) {
      $descriptor->set_value('marca', $this->intervento->brand->brand_name);
      $descriptor->set_value('modello', $this->intervento->model);
      $descriptor->set_value('matricola', $this->intervento->serial_number);
      $descriptor->set_value('data', db_datetime_to_normal_date($this->intervento->creation_date));
      $descriptor->set_value('number', $this->intervento->intervention_code);
      $descriptor->set_value('cliente', $this->intervento->client->fullname);
      $descriptor->set_value('indirizzo', $this->intervento->client->address.", ".$this->intervento->client->civic_number);
      $descriptor->set_value('citta', $this->intervento->client->city.", ".$this->intervento->client->provincia);
      $descriptor->set_value('cap', $this->intervento->client->cap);
      $descriptor->set_value('garanzia', $this->intervento->warranty_yes == 1 ? "SI" : "NO");
      $descriptor->set_value('guasto', $this->intervento->description);
      $descriptor->set_value('note', $this->intervento->product_entry_notes);
      $descriptor->set_value('consegna', db_to_normal_date($this->intervento->expected_delivery_date));
      $descriptor->set_value('macchinario', $this->intervento->object_description);
      $descriptor->set_value('preventivo', $this->intervento->price_quotation == 1 ? "SI" : "NO");
      $descriptor->set_value('limite_spesa', $this->intervento->spending_limit == 1 ? "SI" : "NO");
      $descriptor->set_value('limite_spesa_costo', $this->intervento->spending_limit_amount);
      $descriptor->set_value('telefono_1', $this->intervento->client->phone_1);
      $descriptor->set_value('telefono_2', $this->intervento->client->phone_2);
      $descriptor->set_value('email', $this->intervento->client->email);
      $descriptor->set_value('extra_info_string', $this->intervento->brand->brand_code == Brands_DTO::BRAND_IMETEC && $this->intervento->extra_data['listino']->prodotto_critico == Listini_DTO::PRODOTTO_CRITICO_SI ? "Prodotto Critico" : null);
      $gen = new My_qrcode_class();
      $path = $gen::generateFile($this->intervento->client->fullname, "http://francescogreco.ddns.net/my-gest/ext/get_intervention_data/".$this->intervento->id);
      $descriptor->set_value('path', $path);
   }

   public function create_descriptor(array $descriptor_mods = array()) {
      $this->load_data();
      $descriptor = new Modulistica_descriptor();
      $descriptor->set_template_path('moduli_pdf/pdf_ricevuta_ingresso_cliente');

      $this->set_descriptor_default_vars($descriptor);

      $descriptor->update_vars_list($descriptor_mods);

      return new Modulistica_descriptor_iterator(array($descriptor));
   }
}