<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
require_once APPPATH.'dto/dto.php';

class Attachment_DTO extends DTO {
   const TABLE_NAME = 'attachments';

   const FIELD_ID_ATTACHMENT = 'id_attachment';
   const FIELD_TYPE = 'type';
   const FIELD_CATEGORY = 'category';
   const FIELD_UPLOAD_DATE = 'upload_date';
   const FIELD_DESCRIPTION = 'description';
   const FIELD_FILENAME = 'filename';
   const FIELD_ORIGINAL_FILENAME = 'original_filename';
   const FIELD_SHARE = 'share';
   const FIELD_ID_CURRENT_ATTACHMENT_VERSION = 'id_current_attachment_version';
   const FIELD_ID_USER = 'id_user';

   const TYPE_INSTRUMENT = 'INSTRUMENT';
   const TYPE_PROJECT = 'PROJECT';
    
   public $id;
   public $type;
   public $category;
   public $upload_date;
   public $description;
   public $filename;
   public $original_filename;
   public $share;
   public $id_current_attachment_version;
   public $id_user;
    
   public function init($data) {
      if (!is_array($data) && !is_object($data)) {
         $this->pulisci();
      } else {
         $data = (array) $data;
         $this->id = array_key_exists(self::FIELD_ID_ATTACHMENT, $data) ? $data[self::FIELD_ID_ATTACHMENT] : '';
         $this->type = array_key_exists(self::FIELD_TYPE, $data) ? $data[self::FIELD_TYPE] : '';
         $this->category = array_key_exists(self::FIELD_CATEGORY, $data) ? $data[self::FIELD_CATEGORY] : '';
         $this->upload_date = array_key_exists(self::FIELD_UPLOAD_DATE, $data) ? db_to_normal_date($data[self::FIELD_UPLOAD_DATE]) : '';
         $this->description = array_key_exists(self::FIELD_DESCRIPTION, $data) ? $data[self::FIELD_DESCRIPTION] : '';
         $this->filename = array_key_exists(self::FIELD_FILENAME, $data) ? $data[self::FIELD_FILENAME] : '';
         $this->original_filename = array_key_exists(self::FIELD_ORIGINAL_FILENAME, $data) ? $data[self::FIELD_ORIGINAL_FILENAME] : '';
         $this->share = array_key_exists(self::FIELD_SHARE, $data) ? $data[self::FIELD_SHARE] : '';
         $this->id_current_attachment_version = array_key_exists(self::FIELD_ID_CURRENT_ATTACHMENT_VERSION, $data) ? $data[self::FIELD_ID_CURRENT_ATTACHMENT_VERSION] : '';
         $this->id_user = array_key_exists(self::FIELD_ID_USER, $data) ? $data[self::FIELD_ID_USER] : '';
      }
   }

   public function get_data_for_db() {
      $data = array();
      if ($this->id !== '')
         $data[self::FIELD_ID_ATTACHMENT] = $this->id;
      if ($this->type !== '')
         $data[self::FIELD_TYPE] = $this->type;
      if ($this->category !== '')
         $data[self::FIELD_CATEGORY] = $this->category;
      if ($this->upload_date !== '')
         $data[self::FIELD_UPLOAD_DATE] = normal_to_db_date($this->upload_date);
      if ($this->description !== '')
         $data[self::FIELD_DESCRIPTION] = $this->description;
      if ($this->filename !== '')
         $data[self::FIELD_FILENAME] = $this->filename;
      if ($this->original_filename !== '')
         $data[self::FIELD_ORIGINAL_FILENAME] = $this->original_filename;
      if ($this->share !== '')
         $data[self::FIELD_SHARE] = $this->share;
      if ($this->id_current_attachment_version !== '')
         $data[self::FIELD_ID_CURRENT_ATTACHMENT_VERSION] = $this->id_current_attachment_version;
      if ($this->id_user !== '')
         $data[self::FIELD_ID_USER] = $this->id_user;
      return $data;
   }

}