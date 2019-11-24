<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clients_model extends CH_Model {
   public function get_client_table_feed() {
      $this->load->library('datatable_response_builder');
      
      $fields = array(
         array('db' => Client_data_DTO::FIELD_USERDATA_ID, 'dt' => 'id'),
         array('db' => Client_data_DTO::FIELD_FULLNAME, 'dt' => 'fullname'),
         array('db' => Client_data_DTO::FIELD_FISCAL_CODE, 'dt' => 'fiscal_code'),
         array('db' => Client_data_DTO::FIELD_PHONE_1, 'dt' => 'phone_1'),
         array('db' => Client_data_DTO::FIELD_PHONE_2, 'dt' => 'phone_2') 
      );
      
      $this->datatable_response_builder->set_fields($fields);
      $this->datatable_response_builder->set_table(Client_data_DTO::TABLE_NAME);
      
      return $this->datatable_response_builder->build_response();
   }
   
   public function get_clients_list(){
       $this->db->from(Client_data_DTO::TABLE_NAME);
       return $this->_get_list(Client_data_DTO::class_name());
   }


   public function get_clients($enabled_only = TRUE) {
      $this->db->select(array('d.'.Client_data_DTO::FIELD_USER_ID, 'd.'.Client_data_DTO::FIELD_FULLNAME))
         ->from(Client_data_DTO::TABLE_NAME.' d')
         ->join(Client_DTO::TABLE_NAME.' c', 'c.'.Client_DTO::FIELD_USER_ID.' = d.'.Client_data_DTO::FIELD_USER_ID)
         ->order_by('d.'.Client_data_DTO::FIELD_FULLNAME);
      
      if($enabled_only) $this->db->where('c.'.Client_DTO::FIELD_ENABLED, 1);
      
      return $this->_get_list(Client_data_DTO::class_name());
   }
   
   public function get_client($id_client) {
      $this->db->from(Client_data_DTO::TABLE_NAME)
         ->where(Client_data_DTO::FIELD_USERDATA_ID, $id_client);
      
      return $this->_get(Client_data_DTO::class_name(), FALSE);
   }
   
   public function get_client_user_profile($id_client) {
      $this->db->from(Client_DTO::TABLE_NAME)
         ->where(Client_DTO::FIELD_USER_ID, $id_client);
      
      return $this->_get(Client_DTO::class_name(), FALSE);
   }
   
   public function save(Client_data_DTO $client) {
      $this->db->trans_start();
      
      $result = FALSE;
      if($client->id == '') {
         $result = $this->add_new_client($client);
      }
      else {
         $result = $this->update_client($client);
      }
      $this->db->trans_complete();
      
      return $this->db->trans_status() ? $result : FALSE;
   }
   
   public function create_activation_code_email($id_client) {
      $activation_code = $this->bitauth->generate_code();
      
      $client = $this->get_client($id_client);
      $user_profile = $this->get_client_user_profile($id_client);
      $user_profile->active = 0;
      $user_profile->activation_code = $activation_code;
      
      $this->db->trans_start();
      $this->db->where(Client_DTO::FIELD_USER_ID, $id_client)
         ->update(Client_DTO::TABLE_NAME, $user_profile->get_data_for_db());
      
      $email = array(
         'from' => CH_EMAIL_NOREPLY,
         'to' => $client->email,
         'subject' => lang('client_activation_email_subject'),
         'message' => lang('client_activation_email_body', CH_CLIENT_DASHBOARD_BASE_URL.'/login/activate/'.$activation_code)
      );
      $this->db->trans_complete();
      
      return $this->db->trans_status() ? $email : FALSE;
   }
   
   private function add_new_client(Client_data_DTO $client) {
      return $this->_insert(Client_data_DTO::TABLE_NAME, $client->get_data_for_db());
   }
   
   private function update_client(Client_data_DTO $client) {
         $result = $this->db->where(Client_data_DTO::FIELD_USERDATA_ID, $client->id)
         ->update(Client_data_DTO::TABLE_NAME, $client->get_data_for_db());
      return $result;
   }
}