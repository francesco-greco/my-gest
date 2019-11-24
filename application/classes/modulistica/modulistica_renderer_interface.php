<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'modulistica_descriptor.php';

interface Modulistica_renderer_interface  {
   public function render(Modulistica_descriptor_iterator $descriptors);
}
