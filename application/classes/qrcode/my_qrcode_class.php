<?php 
require_once APPPATH.'third_party/phpqrcode/phpqrcode.php';

class My_qrcode_class {
   
   public function __construct() {
      
   }


   
   public static function generateFile($filename, $text){
      $tmp_fold = sys_get_temp_dir();
      $full_filepath = $tmp_fold."/".$filename.".png";
      QRcode::png($text, $full_filepath, null, 2);
      return $full_filepath;
   }
   
   public static function destroyFile($path){
      unlink($path);
   }
   
}
