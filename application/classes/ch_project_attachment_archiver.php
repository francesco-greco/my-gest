<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CH_Project_Attachment_Archiver extends CH_Uploaded_File_Archiver {
   const ATTACHMENT_DIR = 'project_attachments';
   
   /**
    * Moves the just uploaded file to its repository
    * @return mixed The fullpath where the file was archived or FALSE is somthing went wrong
    */
   public function archive_file() {
      $repository = CH_FILE_REPOSITORY_BASE_PATH.'/'.self::ATTACHMENT_DIR;
      if(!file_exists($repository)) {
         mkdir($repository, 0755);
      }
      
      $filepath = $repository.'/'.$this->upload_data['file_name'];
      
      $response = FALSE;
      if($this->archive_file_to($filepath)) {
         $response = $filepath;
      }
      
      return $response;
   }
}
