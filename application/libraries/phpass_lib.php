<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require_once APPPATH."/libraries/phpass.php"; 
 
class Phpass_lib extends Phpass { 
    public function __construct() { 
        parent::__construct(array('iteration_count_log2' => 8, 'portable_hashes' => FALSE)); 
    } 
}