<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."third_party/PHPMailer/class.phpmailer.php";

class PHPMailer_lib {
   const DEBUG_EMAIL = 'francesco.greco@alice.it';
   
   private $mailer;
   private $debug = FALSE;
   
   public function PHPMailer_lib() {
      $this->mailer = new PHPMailer();
      $this->mailer->CharSet = 'UTF-8';
      $this->set_main_config();
      $this->debug = (ENVIRONMENT !== 'production');
   }
   
   public function set_main_config() {
      $this->mailer->IsSMTP(); 
      $this->mailer->SMTPAuth   = true;
//      $this->mailer->SMTPSecure = "tls";
      $this->mailer->Host       = "mail.fragreco.it";
      $this->mailer->Port       = 587;
      $this->mailer->Username   = "francesco.greco@alice.it";
      $this->mailer->Password   = "clorurodisodio79";
   }
   
   public function set_PEC_config() {
      $this->mailer->IsSMTP(); 
      $this->mailer->SMTPAuth   = true;
      $this->mailer->SMTPSecure = "ssl";
      $this->mailer->Host       = "smtp.gmail.com";
      $this->mailer->Port       = 465;
      $this->mailer->Username   = "myusername@gmail.com";
      $this->mailer->Password   = "password";
   }
   
   public function from($from_mail, $from_name = '') {
      $this->mailer->setFrom($from_mail, $from_name);
   }
   
   public function reply_to($reply_mail, $reply_name = '') {
      $this->mailer->addReplyTo($reply_mail, $reply_name);
   }
   
   public function to($to_mail, $to_name='') {
      if($this->debug) {
         $this->mailer->addAddress(self::DEBUG_EMAIL, $to_name);
      }
      else {
         if(is_array($to_mail)) {
            array_walk($to_mail, function($to_address, $k, $lib) {
               $lib->mailer->addAddress($to_address, '');
            }, $this);
         }
         else {
            $this->mailer->addAddress($to_mail, $to_name);
         }
      }
   }
   
   public function cc($cc_mail, $cc_name = '') {
      if(!$this->debug) {
         if(is_array($cc_mail)) {
            array_walk($cc_mail, function($cc_address, $k, $lib) {
               $lib->mailer->addCC($cc_address, '');
            }, $this);
         }
         else {
            $this->mailer->addCC($cc_mail, $cc_name);
         }
      }
   }
   
   public function bcc($bcc_mail, $bcc_name = '') {
      if(!$this->debug) {
         if(is_array($bcc_mail)) {
            array_walk($bcc_mail, function($bcc_address, $k, $lib) {
               $lib->mailer->addBCC($bcc_address, '');
            }, $this);
         }
         else {
            $this->mailer->addBCC($bcc_mail, $bcc_name);
         }
      }
   }
   
   public function subject($subject) {
      $this->mailer->Subject = ($this->debug ? 'EMAIL TEST - ' : '').$subject;
   }
   
   public function message($message) {
      $this->mailer->isHTML(FALSE);
      $this->mailer->Body = $message;
   }
   
   public function message_html($message, $basedir = '', $advanced = false) {
      $this->mailer->msgHTML($message, $basedir, $advanced);
   }
   
   public function alt_message($message) {
      $this->mailer->AltBody = $message;
   }
   
   public function attach($path, $name = '', $encoding = 'base64', $type = '', $disposition = 'attachment') {
      $this->mailer->addAttachment($path, $name, $encoding, $type, $disposition);
   }
   
   public function send() {
      return $this->mailer->send();
   }
   
   public function get_error() {
      return $this->mailer->ErrorInfo;
   }
   
   public function is_error() {
      return $this->mailer->isError();
   }
}