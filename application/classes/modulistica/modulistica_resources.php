<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulistica_Resources {
   var $resources = array();
   
   public function __construct($resources) {
      if(is_array($resources)) {
         $this->resources = $resources;
      }
      else {
         throw new Exception(get_class($this).": Resource used in costructor is not an array.");
      }
   }
   
   public function has_resource($resource_key) {
      return array_key_exists($resource_key, $this->resources);
   }
   
   public function get_resource($resource_key) {
      if(array_key_exists($resource_key, $this->resources)) {
         return $this->resources[$resource_key];
      }
      else {
         throw new Exception(get_class($this).": Resource $resource_key not found.");
      }
   }
}