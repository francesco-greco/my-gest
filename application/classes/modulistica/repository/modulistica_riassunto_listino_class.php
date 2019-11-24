<?php 

require_once APPPATH.'classes/modulistica/modulistica_class.php';
require_once APPPATH.'classes/modulistica/modulistica_descriptor.php';

class Modulistica_riassunto_listino_class extends Modulistica_class {
   var $needed_resource = array('dati');
   var $dati;
   var $listino;
   var $dettagli;

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
      $this->dati = $this->resources->get_resource('dati');
      $this->listino = $this->dati['listino']; 
      $this->dettagli = $this->dati['dettagli'];
   }

   private function set_descriptor_default_vars(Modulistica_descriptor $descriptor) {
      $descriptor->set_value('brand_name', $this->listino->brand->brand_name);
      $descriptor->set_value('codice', $this->listino->codice);
      $descriptor->set_value('dettagli', $this->dettagli);
      $descriptor->set_value('listino', $this->listino);
   }

   public function create_descriptor(array $descriptor_mods = array()) {
      $this->load_data();
      $descriptor = new Modulistica_descriptor();
      $descriptor->set_template_path('moduli_pdf/pdf_riassunto_listino');

      $this->set_descriptor_default_vars($descriptor);

      $descriptor->update_vars_list($descriptor_mods);

      return new Modulistica_descriptor_iterator(array($descriptor));
   }
}