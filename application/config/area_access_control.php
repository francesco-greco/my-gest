<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['authorized'] = array(
	'Users_controller'   => array( 'role' => CH_ROLE_USER_AREA_ACCESS),
        'Vendita_controller' => array( 'role' => CH_ROLE_USER_VENDITA_ACCESS),
        'Tecnici_controller' => array( 'role' => CH_ROLE_USER_TECNICI_ACCESS)
);