<?php load_sg_class('modulistica/modulistica_renderer_interface');

class Modulistica_html_renderer implements Modulistica_renderer_interface {
   var $render_form_field;
   var $field_prefix;
   
   public function __construct() { }

   public function render(Modulistica_descriptor_iterator $descriptors) {
      $this->render_form_field = FALSE;
      return $this->create_html($descriptors);
   }
   
   public function render_form(Modulistica_descriptor_iterator $descriptors, $field_prefix) {
      $this->render_form_field = TRUE;
      $this->field_prefix = $field_prefix;
      return $this->create_html($descriptors);
   }
   
   public function render_to_browser(Modulistica_descriptor_iterator $descriptors) {
      echo $this->render($descriptors);
   }
   
   public function render_form_to_browser(Modulistica_descriptor_iterator $descriptors, $field_prefix) {
      echo $this->render_form($descriptors, $field_prefix);
   }
   
   private function get_form_field_name(Modulistica_descriptor_var $var) {
      return $this->field_prefix.'_'.$var->name;
   }
   
   private function render_input_none(Modulistica_descriptor_var $var) {
      return $var->value;
   }
   
   private function render_input_text(Modulistica_descriptor_var $var) {
      $TEMPLATE = '<input data-customforms="disabled" type="text" class="%s" name="%s" value="%s">';

      if($this->render_form_field) {
         $field_name = $this->get_form_field_name($var);
         return sprintf($TEMPLATE, $field_name, $field_name, $var->value);
      }
      else {
         return $var->value;
      }
   }
   
   private function render_input_checkbox(Modulistica_descriptor_var $var) {
      $TEMPLATE = '<input data-customforms="disabled" type="checkbox" %s class="%s" name="%s" value="1">';

      $field_name = $this->get_form_field_name($var);
      $checked = ($var->value != NULL && $var->value != FALSE && $var->value != '') ? 'checked' : '';
      return sprintf($TEMPLATE, $checked, $field_name, $field_name);
   }
   
   private function render_textarea(Modulistica_descriptor_var $var) {
      $TEMPLATE = '<textarea data-customforms="disabled" class="%s" name="%s">%s</textarea>';

      if($this->render_form_field) {
         $field_name = $this->get_form_field_name($var);
         return sprintf($TEMPLATE, $field_name, $field_name, $var->value);
      }
      else {
         return $var->value;
      }
   }
   
   private function render_combobox(Modulistica_descriptor_var $var) {
      $TEMPLATE_SELECT = '<select data-customforms="disabled" class="%s" name="%s">%s</select>';
      $TEMPLATE_OPTION = '<option $s value="%s">%s</option>';

      if($this->render_form_field) {
         $rendered = '';
         foreach ($var->extra as $option) {
            $selected = $var->value == $option['value'] ? 'selected' : '';
            $rendered .= sprintf($TEMPLATE_OPTION, $selected, $option['value'], $option['label']);
         }
         
         $field_name = $this->get_form_field_name($var);
         return sprintf($TEMPLATE_SELECT, $field_name, $field_name, $rendered);
      }
      else {
         $v = array_filter($var->extra, function($v) use ($var) { return $var->value == $v['value']; });
         return $v[0]['label'];
      }
   }
   
   private function render_var(Modulistica_descriptor_var $var) {
     $rendered = '';
     switch ($var->type) {
         case Modulistica_descriptor_var::TEXT: $rendered = $this->render_input_text($var); break;
         case Modulistica_descriptor_var::TEXTAREA: $rendered = $this->render_textarea($var); break;
         case Modulistica_descriptor_var::COMBOBOX: $rendered = $this->render_combobox($var); break;
         case Modulistica_descriptor_var::CHECKBOX: $rendered = $this->render_input_checkbox($var); break;
         case Modulistica_descriptor_var::NONE: $rendered = $this->render_input_none($var); break;
         default : throw new Exception(__CLASS__.': Unknown var renderer.');
      }
      
      return $rendered;
   }


   private function create_html(Modulistica_descriptor_iterator $descriptors) {
      $CI = &get_instance();
      $vars = array( 'base_url' => $CI->config->item('base_url'));
      
		$html = '';
      $page = new Modulistica_descriptor();
      foreach($descriptors as $page) {
         $page_name = strpos($page->get_template_path(), '/') === 0 ? $page->get_template_path() : '_pdf/'.$page->get_template_path();
         $rendered_vars = array();
         foreach ($page->get_vars_list() as $var) {
            $rendered_vars[$var->name] = $this->render_var($var);
         }
         $html .= $CI->load->view($page_name, array_merge($vars, $rendered_vars), TRUE);
      }
		
      return $html;
	}
}