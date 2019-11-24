<?php 
require_once APPPATH.'classes/modulistica/modulistica_renderer_interface.php';

class Modulistica_pdf_renderer implements Modulistica_renderer_interface {
   public function __construct() {
      require_once(APPPATH."third_party/MPDF56/mpdf.php");
   }

   public function render(Modulistica_descriptor_iterator $descriptors) {
      return $this->render_to_output($descriptors, 'S');
   }

   public function render_to_file(Modulistica_descriptor_iterator $descriptors, $pdf_filename, $page_options = array()) {
      $this->render_to_output($descriptors, 'F', $pdf_filename, $page_options);
   }

   public function render_to_browser(Modulistica_descriptor_iterator $descriptors, $pdf_filename=FALSE, $page_options = array()) {
      $filename = ($pdf_filename === FALSE) ? 'pdf_'.uniqid().'.pdf' : $pdf_filename;
		ob_clean();
		$this->render_to_output($descriptors, 'I', $filename, $page_options);
   }

   private function render_to_output(Modulistica_descriptor_iterator $descriptors, $output, $pdf_filename = '', $page_options = array()) {
      $html = $this->create_html($descriptors);

      $mpdf = $this->create_mpdf_instance($page_options);
      $mpdf->WriteHTML($html);
		ob_clean();

      if ($output != 'S') {
			$mpdf->output($pdf_filename, $output);
		} else {
			return $mpdf->output($pdf_filename, $output);
		}
   }

   private function create_mpdf_instance($options = array()) {
      $defaults = array(
         'format' => 'A4', 'font_size' => '', 'font_type' => '',
         'left_margin'=>'10', 'right_margin'=>'10', 'top_margin'=>'10', 'bottom_margin'=>'7',
         'header_margin' => '9', 'footer_margin' => '9',
         'orientation'  => 'P'
      );
      $final_options = array_merge($defaults, $options);
      $mpdf = new mPDF('utf-8', $final_options['format'], $final_options['font_size'],
              $final_options['font_type'], $final_options['left_margin'], $final_options['right_margin'],
              $final_options['top_margin'], $final_options['bottom_margin'], $final_options['header_margin'],
              $final_options['footer_margin'], $final_options['orientation']
      );
      $mpdf->debug = FALSE;
//      $mpdf->shrink_tables_to_fit = 0;
      return $mpdf;
	}

   private function render_var(Modulistica_descriptor_var $var) {
      $rendered = '';
      switch ($var->type) {
         case Modulistica_descriptor_var::CHECKBOX: $rendered = $this->render_input_checkbox($var); break;
         case Modulistica_descriptor_var::TEXTAREA: $rendered = $this->render_input_textarea($var); break;
         case Modulistica_descriptor_var::COMBOBOX:
         case Modulistica_descriptor_var::TEXT:
         case Modulistica_descriptor_var::NONE: $rendered = $this->render_input_none($var); break;
         default : throw new Exception(__CLASS__.': Unknown var renderer.');
      }

      return $rendered;
   }

   private function render_input_none(Modulistica_descriptor_var $var) {
      return $var->value;
   }

   private function render_input_textarea(Modulistica_descriptor_var $var) {
      return nl2br($var->value);
   }

   private function render_input_checkbox(Modulistica_descriptor_var $var) {
      $TEMPLATE = '<input data-customforms="disabled" type="checkbox" %s class="%s" name="%s" value="1">';

      $field_name = $var->name;
      $checked = ($var->value != NULL && $var->value != FALSE && $var->value != '') ? 'checked="checked"' : '';
      return sprintf($TEMPLATE, $checked, $field_name, $field_name);
   }

   private function create_html(Modulistica_descriptor_iterator $descriptors) {
      $CI = &get_instance();
      $vars = array( 'base_url' => $CI->config->item('base_url'));

		$html = $CI->load->view('pdf_template/pdf_header', $vars, TRUE);
      $page = new Modulistica_descriptor();
      foreach($descriptors as $page) {
         $page_name = strpos($page->get_template_path(), '/') === 0 ? $page->get_template_path() : $page->get_template_path();
         $page_vars = array();
         //nel caso in cui sono presenti dei newline li sostituisce con dei br per mantenere la formattazione
         foreach($page->get_vars_list() as $var) {
            $page_vars[$var->name] = $this->render_var($var);
         }

         $html .= $CI->load->view($page_name, array_merge($vars, $page_vars), TRUE);
         if($descriptors->has_next()) $html .= "<pagebreak />";
      }

      $html .= $CI->load->view('pdf_template/pdf_footer', $vars, TRUE);

      return $html;
	}
}
