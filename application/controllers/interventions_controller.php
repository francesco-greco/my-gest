<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'dto/brands_dto.php';

class Interventions_controller extends CH_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('interventions_model','counters_model','intervention_note_model'));
        $this->add_frontend_module('my_interventions');
        $this->add_frontend_css('my_interventions');
        load_dto('intervention_notes_dto');
    }
    
    public function index() {
        $bb = array('label' => "interventi", 'url' => base_url(CH_URL_INTERVENTIONS));
        $this->init_breadcrumb($bb);
        $this->load_page('interventions/interventions_main_view');
    }

    public function new_intervention_window_show($id_client){
        $this->load->model(array('brands_model'));
        $brands_list = $this->brands_model->get_brands_list();
        $start_stage = $this->interventions_model->get_processing_stage(Processing_stage_DTO::STAGE_AVVIO);
        $categorie = $this->interventions_model->get_category_list();
        $data = array(
            'id_client' => $id_client,
            'brands_list' => $brands_list,
            'start_stage' => $start_stage,
            'categorie' => $categorie
        );
        $this->load->view('interventions/windows/new_intervention_window', $data);
    }
    
    public function create_intervention(){
        $intervention = Intervention_DTO::raccogli_dati_request('intervento');
        $intervention->user_id_creation = $this->bitauth->user_id;
        $intervention->id_sede = $this->bitauth->id_sede;
        $counter = $this->counters_model->get_new_counter_intervention();
        $intervention->intervention_code = $counter;
        $result = $this->interventions_model->save_intervention($intervention);
        $data = array(
            'response' => is_numeric($result) ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE,
            'id_intervention' => is_numeric($result) ? $result : ""
        );
        json_output($data);
    }
    
    public function get_interventions_by_client($id_client){
        return $this->interventions_model->get_interventions_by_client($id_client);
    }
    
    public function get_interventions_table_feed() {
        $start = $this->input->get('start');
        $lenght = $this->input->get('length');
        $output = $this->interventions_model->get_interventions_table_feed();
        json_output($output);
    }
    
    public function get_old_interventions_table_feed(){
        $start = $this->input->get('start');
        $lenght = $this->input->get('length');
        $output = $this->interventions_model->get_old_interventions_table_feed();
        json_output($output);
    }
    
    public function show_intervention($id_intervention){
        $intervention = $this->interventions_model->get_intervention_full_data($id_intervention);
        $bb[] = array('label' => "interventi", 'url' => base_url(CH_URL_INTERVENTIONS));
        $bb[] = array('label' => "intervento N. {$intervention->intervention_code}", 'url' => "");
        $this->init_breadcrumb($bb);
        $this->load->model('clients_model');
        $serial_count = count($this->interventions_model->get_count_entries($intervention->serial_number));
        $data = array(
            'intervention' => $intervention,
            'serial_count' => $serial_count
        );
        $this->load_page('interventions/intervention_page', $data);
    }
    
    public function show_new_note_window($id_intervention) {
      $intervento = $this->interventions_model->get_intervention($id_intervention);
      $notes = array();
      $post_string = "";
      if ($intervento != FALSE && $intervento->status == Intervention_DTO::STATUS_OPENED) {
         $notes = Intervention_notes_DTO::get_all_notes_code();
      } else {
         $notes = Intervention_notes_DTO::get_posthumous_notes_code();
         $post_string .= " <u>Postuma</u>";
      }
      $data = array(
          'id_intervention' => $id_intervention,
          'notes' => $notes,
          'post_string' => $post_string
      );
      $this->load->view('interventions/windows/new_note', $data);
   }

   public function save_note(){
        $note = Intervention_notes_DTO::raccogli_dati_request('note');
        $result = $this->intervention_note_model->save_note($note);
        $response = $result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE;
        json_output(array( 'response' => $response, 'id_intervention' => $note->id_intervention));
    }
    
    public function get_notes_intervention($id_intervention){
        $result = $this->intervention_note_model->get_notes_intervention($id_intervention);
        json_output($result);
    }
    
    public function get_current_processing_stage($id_intervention){
        $response = array();
        $intervention = $this->interventions_model->get_intervention_full_data($id_intervention);
        if($intervention != FALSE){
            $response['response'] = CH_RESPONSE_SUCCESS;
            $response['processing_stage'] = $intervention->processing_stage->processing_stage_label;
            $response['status'] = $intervention->status;
        } else {
            $response['response'] = CH_RESPONSE_FAILURE;
        }
        json_output($response);
    }
    
    public function stampa_ricevuta($id_intervernion) {
      require_once APPPATH . 'classes/modulistica/modulistica_factory.php';
      require_once APPPATH . 'classes/modulistica/renderers/modulistica_pdf_renderer.php';
      $resources = array('id_intervention' => $id_intervernion);
      $modulo = Modulistica_Factory::get_instance('ricevuta_ingresso', new Modulistica_Resources($resources));
      $elenco_modulistica[] = $modulo->create_descriptor();
      $renderer = new Modulistica_pdf_renderer();
      $pdf_fullname = sys_get_temp_dir(). "/ricevuta_".time().".pdf";
      $renderer->render_to_browser(Modulistica_descriptor_iterator::merge($elenco_modulistica), $pdf_fullname, array( 'left_margin'=>'15', 'right_margin'=>'15', 'top_margin'=>'10', 'bottom_margin'=>'7','format' => 'A4' ));
   }
   
   public function intervention_costs_window_show($id_intervention){
      $intervention = $this->interventions_model->get_intervention_full_data($id_intervention);
      $is_warrenty = $intervention->is_warrenty();
      $actual_cost = $this->interventions_model->get_cost($id_intervention);
      if($actual_cost === FALSE){
         $cost_dto = new Intervention_cost_DTO();
         $cost_dto->id_intervention = $id_intervention;
         $cost_dto->user_generator = $this->bitauth->user_id;
         $this->interventions_model->save_cost($cost_dto);
         $actual_cost = $this->interventions_model->get_cost($id_intervention);
      }
      $data = array(
          'intervention' => $intervention,
          'is_warrenty' => $is_warrenty,
          'actual_cost' => $actual_cost,
          'um' => $this->get_um()
      );
      $this->load->view('interventions/windows/intervention_costs_window', $data);
   }
   
   public function get_intervention_cost_details($id_intervention){
      json_output($this->interventions_model->get_intervention_cost_details($id_intervention));
   }
   
   public function change_intervention_warranty_mode(){
      $intervento = Intervention_DTO::raccogli_dati_request('intervento');
      $result = $this->interventions_model->save_intervention($intervento);
      json_output($result != FALSE ? CH_RESPONSE_SUCCESS : CH_RESPONSE_FAILURE);
   }
}
