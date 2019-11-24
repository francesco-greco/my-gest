<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'modulistica_resources.php';
require_once 'modulistica_descriptor.php';

class Modulistica_Factory {
   const CLASS_NAME_TEMPLATE = "Modulistica_%s_class";

   public static function get_instance($type, Modulistica_Resources $resources) {
      $class_name = self::get_class_name($type);
      self::load_class($type);

      $class_instance = new $class_name($resources);
      if(!in_array('Modulistica_class', class_parents($class_instance))) {
         throw new Exception(get_class($class_instance).' do not extend Modulistica_class.');
      }
      return $class_instance;
   }

   private static function get_class_name($type) {
      $class_identifier = $type;
      if(strpos($type, '/') !== FALSE) {
         $path_segments = explode('/', $type);
         $class_identifier = array_pop($path_segments);
      }

      return sprintf(self::CLASS_NAME_TEMPLATE, $class_identifier);
   }

   private static function get_class_path($type) {
      $class_identifier = $type;
      $path_segments = array();
      if(strpos($type, '/') !== FALSE) {
         $path_segments = explode('/', $type);
         $class_identifier = array_pop($path_segments);
      }

      return strtolower(implode('/', $path_segments).'/'.sprintf(self::CLASS_NAME_TEMPLATE, $class_identifier).'.php');
   }

   private static function load_class($type) {
      $filename = self::get_class_path($type);
      $path = dirname(__FILE__) . '/repository/'.$filename;
      if (realpath($path)) {
         require_once $path;
      }
      else {
         throw new Exception(get_called_class().": $filename do not exists or is unreachable.");
      }
   }
}
