<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachments_controller extends CH_Controller {
   public function __construct() {
      parent::__construct();
      
      $this->load->model('attachments_model');
   }
   
   function download_attachment($id_attachment) {
      $attachment = $this->attachments_model->get_attachment($id_attachment);
      
      $model_name = FALSE;
      switch($attachment->type) {
         case Attachment_DTO::TYPE_INSTRUMENT: $model_name = 'lab_instrument_attachments_model'; break;
         case Attachment_DTO::TYPE_PROJECT: $model_name = 'project_attachments_model'; break;
      }
      
      if($model_name === FALSE) {
         $this->send_user_message("La richiesta inviata è malformata.", 'error');
         redirect(CH_URL_MAIN);
      }
      
      $this->load->model($model_name);
      if($this->$model_name->is_attachment_access_granted($id_attachment)) {
         send_file_to_browser($attachment->filename, $attachment->original_filename);
      }
      else {
         $this->send_user_message("Non si hanno sufficienti diritti per accedere all'allegato.", 'error');
         redirect(CH_URL_MAIN);
      }
   }
}
