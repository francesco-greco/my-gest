<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('TAB_LISTA_UTENTI', 'tab-utenti-list');
define('TAB_LISTA_GRUPPI', 'tab-utenti-gruppi');

class Users_controller extends CH_Controller {
	const RECORD_PER_PAGE = 10;

	private $utente;
	private $gruppo;
	
	public function __construct() {
		parent::__construct();
		
		$this->load_dictionary('ch_users');
		
		$bb[] = array('label' => lang('user_users_label'), 'url' => base_url(CH_URL_USERS));
		$this->init_breadcrumb($bb);
      
      $this->add_frontend_module('my_users');
      
      if($this->session->userdata('utente') != NULL) {
			$this->utente = new User_DTO($this->session->userdata('utente')) ;
			$this->session->unset_userdata('utente');
		}
		
		if($this->session->userdata('gruppo') != NULL) {
			$this->gruppo = new Group_DTO($this->session->userdata('gruppo'));
			$this->session->unset_userdata('gruppo');
		}	
	}
	
	public function index() {
		$users_list = $this->bitauth->get_users(TRUE);
		$user_groups_list = $this->bitauth->get_groups();
		
		$gruppi_hashtable = array();
		foreach ($user_groups_list as $idx => $gruppo) {
			$gruppi_hashtable[$gruppo->group_id] = $gruppo->name;
			$user_groups_list[$idx]->roles = $this->bitauth->get_roles_by_mask($gruppo->roles);
		}
		
      $filtered_user_list = array();
		foreach ($users_list as $user) {
         
			$gruppi_utente = array();
			foreach ($user->groups as $value) {
				if($value != NULL) $gruppi_utente[] = $gruppi_hashtable[$value];
			}
			$user->groups = $gruppi_utente;
         
         $filtered_user_list[] = $user;
		}
		
		$data = array(
			//riordinare mettendo alla fine gli operatori inattivi
			'user_list' => $filtered_user_list,
			'user_groups_list' => $user_groups_list
		);
		
		$this->load_page('users/users_view', $data);
	}
	
	
	
	public function get_utenti_list_page($page) {
		$users_list = $this->bitauth->get_users(TRUE);
		$user_groups_list = $this->bitauth->get_groups();
		
		$gruppi_hashtable = array();
		foreach ($user_groups_list as $idx => $gruppo) {
			$gruppi_hashtable[$gruppo->group_id] = $gruppo->name;
		}
		
		$list = array();
		for($i = Utenti::RECORD_PER_PAGE * ($page - 1); $i < Utenti::RECORD_PER_PAGE * $page && $i<count($users_list); $i++) {
         if($this->bitauth->is_admin($users_list[$i]->roles)) continue;
			$utente = new User_DTO();
			$utente->user_id = $users_list[$i]->user_id;
			$utente->fullname = $users_list[$i]->fullname;
			$utente->enabled = $users_list[$i]->enabled;
			$utente->preferred_lang = $users_list[$i]->preferred_lang;
			
			$gruppi_utente = array();
			foreach ($users_list[$i]->groups as $value) {
				if($value != NULL) $gruppi_utente[] = $gruppi_hashtable[$value];
			}
			$utente->groups = $gruppi_utente;
			
			$list[] = $utente;
		}
		
		if(is_xmlhttprequest()) {
			echo json_encode($list);
		}
		else {
			return $list;
		}
	}
	
	public function nuovo_utente() {
      $ci = &get_instance();
      $ci->load->model('headquarters_model');
		$gruppi = $this->bitauth->get_groups();
		
		if($this->utente == NULL) $this->utente = new User_DTO();
		$data = array(
			'utente' => $this->utente,
			'gruppi' => $gruppi,
         'sedi' => $ci->headquarters_model->get_list()
		);
		$this->set_breadcrumb(array('label' => lang('user_new_user_label')));
		$this->load_page('users/edit_user_view', $data);
	}
	
	public function modifica_utente() {
		$utente_id = $this->input->post('utenti-id', TRUE);
      if($this->utente == NULL) $this->utente = new User_DTO();
		
      $user = $this->bitauth->get_user_by_id($utente_id);
		if(!$this->bitauth->is_admin($user->roles)) $this->utente = new User_DTO($user);
      
		$gruppi = $this->bitauth->get_groups();
		$data = array(
			'utente' => $this->utente,
			'gruppi' => $gruppi
		);
		$this->set_breadcrumb(array('label' => lang('user_edit_user_label')." '{$this->utente->fullname}'"));
		$this->load_page('users/edit_user_view', $data);
	}
	
	public function abilita_utente() {
		$utente_id = $this->input->post('utenti-id', TRUE);
      $user = $this->bitauth->get_user_by_id($utente_id);
		if($this->bitauth->is_admin($user->roles)) {
         $this->send_user_message(lang('common_words_not_authorized_msg'), 'info');
         redirect(base_url(CH_URL_MAIN));
		}
      
		$enabled = $this->input->post('utenti-abilitato') == '1' ? 0 : 1;
		$utente = array('enabled' => $enabled);
		if($this->bitauth->update_user($utente_id, $utente)) {
         $msg = ($enabled == 0 ? 'user_disabled_user_msg' : 'user_enabled_user_msg');
			$this->send_user_message(lang($msg), 'info');
		}
		else {
			$this->send_user_message(lang('user_enabled_user_error'), 'error');
		}
		redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_UTENTI));
	}


	public function salva_utente() {
		$utente_id = $this->input->post('utenti-id', TRUE);
		
		$gruppi = $this->input->post('utenti-gruppi', TRUE);
		if(is_string($gruppi)) {
			$gruppi = array($gruppi);
		}
		else if(is_bool($gruppi)) {
			$gruppi = array();
		}
		
      $utente = array(
			'username' => $this->input->post('utenti-username', TRUE),
			'fullname' => $this->input->post('utenti-nome'),
			'password' => $this->input->post('utenti-password'),
			'preferred_lang' => $this->input->post('utenti-preferred-lang', TRUE),
			'enabled' => $this->input->post('utenti-abilitato'),
			'groups' => $gruppi,
         'id_sede' => $this->input->post('utenti-id_sede')
		);
		
		//Il profilo utente è aggiornato, non aggiunto
		if($utente_id != NULL) {
         $user = $this->bitauth->get_user_by_id($utente_id);
         if($this->bitauth->is_admin($user->roles)) {
            $this->send_user_message(lang('common_words_not_authorized_msg'), 'info');
            redirect(base_url(CH_URL_MAIN));
         }
			if($this->bitauth->update_user($utente_id, $utente)) {
				$this->send_user_message(lang('user_updated_user_msg'), 'info');
				redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_UTENTI));
			}
			else {
				$this->send_user_message(lang("user_updated_user_error"), 'error');
				$this->session->set_userdata('utente', new User_DTO($utente));
				redirect(base_url(CH_URL_USERS.'/modifica_utente'));
			}
		}
		//Il profilo utente è aggiunto al database
		else {
			if($this->bitauth->add_user($utente)) {
				$this->send_user_message(lang('user_added_user_msg'), 'info');
				redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_UTENTI));
			}
			else {
				$this->send_user_message(lang('user_added_user_error'), 'error');
				$this->session->set_userdata('utente', new User_DTO($utente));
				redirect(base_url(CH_URL_USERS.'/nuovo_utente'));
			}
		}
	}
	
	public function nuovo_gruppo() {
		$r = $this->bitauth->get_roles();
		$roles = array();
		foreach ($r as $slug => $description) {
			$roles[] = (object) array('label' => $slug, 'description' => $description);
		}
		
		if($this->gruppo == NULL) $this->gruppo = new Group_DTO();
		
		$data = array(
			'gruppo' => $this->gruppo,
			'roles' => $roles
		);
		$this->set_breadcrumb(array('label' => lang('user_new_user_group_label')));
		$this->load_page('users/edit_group_view', $data);
	}
	
	public function modifica_gruppo() {
		$gruppi_id = $this->input->post('gruppi-id', TRUE);
		if($this->gruppo == NULL) $this->gruppo = new Group_DTO($this->bitauth->get_group_by_id($gruppi_id));
		$this->gruppo->roles = $this->bitauth->get_roles_by_mask($this->gruppo->roles, true);
		
		$r = $this->bitauth->get_roles();
		$roles = array();
		foreach ($r as $slug => $description) {
			$roles[] = (object) array('label' => $slug, 'description' => $description);
		}
		
		$data = array(
			'gruppo' => $this->gruppo,
			'roles' => $roles
		);
		$this->set_breadcrumb(array('label' => lang('user_edit_user_group_label')." '{$this->gruppo->name}'"));
		$this->load_page('users/edit_group_view', $data);
	}
	
	public function salva_gruppo() {
		$gruppi_id = $this->input->post('gruppi-id', TRUE);
		$roles = $this->input->post('gruppi-ruoli');
		$gruppo = array(
			'name' => $this->input->post('gruppi-nome', TRUE),
			'description' => $this->input->post('gruppi-descrizione', TRUE),
			'roles' => is_string($roles) ? array($roles) : $roles
		);
		
		if($gruppi_id != NULL) {
			if($this->bitauth->update_group($gruppi_id, $gruppo)) {
				$this->send_user_message(lang('user_updated_user_group_msg'), 'info');
				redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_GRUPPI));
			}
			else {
				$this->send_user_message(lang('user_updated_user_group_error'), 'error');
				$this->session->set_userdata('gruppo', new Group_DTO($gruppo));
				redirect(base_url(CH_URL_USERS.'/modifica_gruppo'));
			}
		}
		else {
			if($this->bitauth->add_group($gruppo)) {
				$this->send_user_message(lang('user_added_user_group_msg'), 'info');
				redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_GRUPPI));
			}
			else {
				$this->send_user_message(lang('user_added_user_group_error'), 'error');
				$this->session->set_userdata('gruppo',  new Group_DTO($gruppo));
				redirect(base_url(CH_URL_USERS.'/nuovo_gruppo'));
			}
		}
	}
	
	public function cancella_gruppo() {
		$gruppi_id = $this->input->post('gruppi-id');
		if(!$this->bitauth->delete_group($gruppi_id)) {
			$this->send_user_message(lang('user_deleted_user_error'), 'error');
		}
		redirect(base_url(CH_URL_USERS.'#'.TAB_LISTA_GRUPPI));
	}
}