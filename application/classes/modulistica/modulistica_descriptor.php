<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modulistica_descriptor {

   var $template_path;
   var $vars_list;

   static public function wrap_old_modulistica_params($config) {
      $descriptor = new Modulistica_descriptor();
      $descriptor->set_template_path($config['page']);
      $descriptor->set_value_list($config['vars']);

      return new Modulistica_descriptor_iterator(array($descriptor));
   }

   public function __construct($template_path = NULL, $vars_list = array()) {
      $this->set_template_path($template_path);
      $this->set_vars_list($vars_list);
   }

   public function get_template_path() {
      return $this->template_path;
   }

   public function set_template_path($template_path) {
      $this->template_path = $template_path;
   }

   public function get_vars_list() {
      return $this->vars_list;
   }

   public function set_vars_list(array $vars_list) {
      $this->vars_list = $vars_list;
   }

   public function update_vars_list(array $vars_list) {
      foreach ($vars_list as $var) {
         $this->update_var($var);
      }
   }

   public function set_var(Modulistica_descriptor_var $var) {
      $this->vars_list[$var->name] = $var;
   }

   public function update_var(Modulistica_descriptor_var $var) {
      if (array_key_exists($var->name, $this->vars_list))
         $this->vars_list[$var->name] = $var;
   }

   public function get_var($name) {
      return $this->vars_list[$name];
   }

   public function update_value_list(array $list) {
      foreach ($list as $name => $value) {
         $this->update_value ($name, $value);
      }
   }

   public function set_value_list(array $list) {
      foreach ($list as $name => $value) {
         $this->set_value($name, $value);
      }
   }

   public function get_value_list() {
      $values = array();
      foreach ($this->vars_list as $name => $var) {
         $values[$name] = $var->value;
      }
      return $values;
   }

   public function set_value($name, $value) {
      if (array_key_exists($name, $this->vars_list)) {
         $this->vars_list[$name]->value = $value;
      }
      else {
         $this->vars_list[$name] = new Modulistica_descriptor_var($name, $value);
      }
   }

   public function update_value($name, $value) {
      if (array_key_exists($name, $this->vars_list))
         $this->vars_list[$name]->value = $value;
   }

   public function get_value($name) {
      return $this->vars_list[$name]->value;
   }
}

class Modulistica_descriptor_var {
   const TEXT = 'text';
   const CHECKBOX = 'checkbox';
   const TEXTAREA = 'textarea';
   const COMBOBOX = 'combobox';
   const NONE = 'none';

   var $name;
   var $value;
   var $type;
   var $extra;

   public function __construct($name, $value = NULL, $type = self::TEXT, $extra = FALSE) {
      $this->name = $name;
      $this->type = $type;
      $this->value = $value;
      $this->extra = $extra;
   }
}

class Modulistica_descriptor_var_none extends Modulistica_descriptor_var {
   public function __construct($name, $value = NULL, $extra = FALSE) {
      parent::__construct($name, $value, Modulistica_descriptor_var::NONE, $extra);
   }
}

class Modulistica_descriptor_iterator implements Iterator {

   private $position = 0;
   private $descriptors = array();

   public function __construct(array $descriptors) {
      foreach ($descriptors as $descriptor) {
         if (!($descriptor instanceof Modulistica_descriptor)) {
            throw new Exception(get_class($this) . ': All elements of the array passed to constructor must be instance of Modulistica_descriptor class.');
         }
      }
      $this->descriptors = $descriptors;
   }

   function rewind() {
      $this->position = 0;
   }

   function current() {
      return $this->descriptors[$this->position];
   }

   function key() {
      return $this->position;
   }

   function next() {
      ++$this->position;
   }

   function has_next() {
      return isset($this->descriptors[$this->position + 1]);
   }

   function valid() {
      return isset($this->descriptors[$this->position]);
   }

   static public function merge() {
      $args = func_get_args();
      $it_array = array();
      $descriptors = is_array($args[0]) ? $args[0] : $args;

      foreach ($descriptors as $idx => $arg) {
         if ($arg instanceof Modulistica_descriptor_iterator) {
            foreach ($arg as $d) {
               $it_array[] = $d;
            }
         }
         else {
            throw new Exception('Modulistica_descriptor_iterator merge: Argument n° '.$idx.' is not instance of Modulistica_descriptor_iterator.');
         }
      }

      return new Modulistica_descriptor_iterator($it_array);
   }

}