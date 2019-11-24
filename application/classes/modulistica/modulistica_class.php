<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'modulistica_resources.php';

abstract class Modulistica_class {
   protected $CI;
   protected $resources;
   
   abstract public function create_descriptor(array $descriptor_mods);
//   abstract public function get_descriptor();
   abstract protected function check_resources(Modulistica_resources $resources);
   abstract protected function get_missing_resources(Modulistica_resources $resources);
   
   /**
    * 
    * @param Modulistica_resources $resources
    */
   public function __construct(Modulistica_resources $resources) {
      $this->CI = &get_instance();
      $this->embed_resources($resources);
   }
   
   public function embed_resources(Modulistica_resources $resources) {
      if($this->check_resources($resources)) {
         $this->resources = $resources;
      }
      else {
         throw new Exception(get_class($this)." - The following resources are missing:  {$this->get_missing_resources($resources)}.");
      }
   }
}
