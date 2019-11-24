<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CH_Uploaded_File_Archiver {
   protected $ci;
   protected $upload_data;
   protected $upload_path;
   
   public function __construct() {
      $this->init_upload_lib();
   }
   
   protected function get_uploaded_file_path() {
      return $this->upload_path.'/'.$this->upload_data['file_name'];
   }
   
   public function delete_file() {
      $attachment_filepath = $this->get_uploaded_file_path();
      
      return unlink($attachment_filepath);
   }
 
   public function archive_file_to($dest_filepath) {
      $attachment_filepath = $this->get_uploaded_file_path();
      
      return rename($attachment_filepath, $dest_filepath);
   }
 
   public function get_file_extension() {
      return $this->upload_data['file_ext'];
   }
   
   public function get_original_filename() {
      return $this->upload_data['orig_name'];
   }
   
   public function upload_file($file_field) {
      $ci = $this->get_ci_instance();
      
      if ( ! $ci->upload->do_upload($file_field)) {
         return FALSE;
		}
		else {
         $this->upload_data = $ci->upload->data();
         return $this->upload_data !== FALSE;
      }
   }
   
   private function get_ci_instance() {
      if($this->ci == NULL) {
         $this->ci = &get_instance();
      }
      
      return $this->ci;
   }
   
   private function init_upload_lib() {
      $this->upload_path = sys_get_temp_dir();
      
      $config_uploader['upload_path'] = $this->upload_path;
      $config_uploader['allowed_types'] = '*';
      $config_uploader['encrypt_name'] = TRUE;

      $ci = $this->get_ci_instance();
      $ci->load->library('upload', $config_uploader);
      $ci->upload->initialize($config_uploader);
   }
}