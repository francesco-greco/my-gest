<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CH_autoloader {
   public static function dto() {
      $loaders = array();
      $loaders[] = array(get_class(), '_DTO_loader');
      $loaders[] = array(get_class(), '_CH_classes_loader');
      
      foreach ($loaders as $loader) {
         if(!self::is_yet_loaded($loader)) {
            spl_autoload_register($loader);
         }
      }
   }
   
   static private function is_yet_loaded($loader) {
      return spl_autoload_functions() && in_array($loader, spl_autoload_functions());
   }
   
   private static function _CH_classes_loader($class) {
      $filename = strtolower($class) . '.php';
      $file = APPPATH.'classes/' . $filename;
      if (!file_exists($file)) {
         return false;
      }
      include_once $file;
   }
   
   private static function _DTO_loader($class) {
      $filename = strtolower($class) . '.php';
      $file = APPPATH.'dto/' . $filename;
      if (!file_exists($file)) {
         return false;
      }
      include_once $file;
   }
}
