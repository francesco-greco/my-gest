<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients_controller extends CH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_dictionary('ch_clients');
		
		$bb[] = array('label' => lang('client_clients_label'), 'url' => base_url(CH_URL_CLIENTS));
		$this->init_breadcrumb($bb);
      
		$this->add_frontend_module('my_clients');

      $this->load->model(array('clients_model','interventions_model'));
	}
	
	public function index() {
		$this->load_page('clients/clients_view');
	}
   
   public function new_client() {
      $client = new Client_data_DTO();
      $user_profile = new Client_DTO();
      $this->load_page('clients/edit_client_view', array('client' => $client, 'user_profile' => $user_profile));
   }
   
   public function edit_client($id_client = FALSE) {
      $id_client_selected = ($id_client !== FALSE) ? $id_client : $this->input->post('id');
      $client = $this->clients_model->get_client($id_client_selected);
      $old_interventions = $this->interventions_model->get_historical_client($id_client_selected);
      $this->load_page('clients/edit_client_view', array('client' => $client, 'storico' => $old_interventions));
   }
   
   public function save_client() {
      $client = Client_data_DTO::raccogli_dati_request('client');
      $client->fullname = $client->surname." ".$client->name;
      $client->preferred_lang = 'it';
      $client_user_id = $this->clients_model->save($client);
      if($client_user_id !== FALSE) {
         json_response(CH_RESPONSE_SUCCESS, array('id' => $client_user_id));
      }
      else {
         json_response(CH_RESPONSE_FAILURE, array('id' => $client_user_id));
      }
   }
   
   public function get_client_table_feed() {
       $start = $this->input->get('start');
       $lenght = $this->input->get('length');
		$output = $this->clients_model->get_client_table_feed();
		json_output($output);
   }
   
   public function window_send_activation_code($id_client) {
      $client = $this->clients_model->get_client($id_client);
      if($client->email != '') {
         $this->load->view('clients/send_activation_code_window', array('client' => $client));
      }
      else {
         echo "<span>Nessun indirizzo email è associato a <strong>{$client->fullname}</strong></span>";
      }
   }
   
   public function send_activation_code() {
      $id_client = $this->input->post('id_client');
      
      $email = $this->clients_model->create_activation_code_email($id_client);
      $response = ch_send_email($email);
      
      json_output($response);
   }
}