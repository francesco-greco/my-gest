<?php

/**
 * This line is required, it must contain the label for your unique username field (what users login with)
 */
$lang['bitauth_username']			= 'Username';

/**
 * Password Complexity Labels
 */
$lang['bitauth_pwd_uppercase']		= 'Caratteri maiuscoli';
$lang['bitauth_pwd_number']			= 'Numeri';
$lang['bitauth_pwd_special']		= 'Caratteri speciali';
$lang['bitauth_pwd_spaces']			= 'Spazi';

/**
 * Login Error Messages
 */
$lang['bitauth_login_failed']		= '%s o password non valida.';
$lang['bitauth_user_inactive']		= 'Devi attivare questo profilo utente prima di poter accedere.';
$lang['bitauth_user_disabled']		= 'Questo profilo utente è stato disabilitato.';
$lang['bitauth_user_locked_out']	= 'Sono stati riscontrati parecchi tentativi di accesso falliti. Per questo il login verrà disabilitato per %d minuti. Per favore ritentare più tardi.';
$lang['bitauth_pwd_expired']		= 'La tua password è scaduta.';

/**
 * User Validation Error Messages
 */
$lang['bitauth_unique_username']	= 'Il campo %s deve essere unico.';
$lang['bitauth_password_is_valid']	= '%s non soddisfa i criteri di complessità: ';
$lang['bitauth_username_required']	= 'Il campo %s è obbligatorio.';
$lang['bitauth_password_required']	= 'Il campo %s è obbligatorio.';
$lang['bitauth_passwd_complexity']	= 'La password non soddisfa i criteri di complessità: %s';
$lang['bitauth_passwd_min_length']	= 'La password deve essere di almeno %d caratteri.';
$lang['bitauth_passwd_max_length']	= 'La password non più superare i %d caratteri.';

/**
 * Group Validation Error Messages
 */
$lang['bitauth_unique_group']		= 'Il campo %s deve essere unico.';
$lang['bitauth_groupname_required']	= 'Il nome del gruppo è obbligatorio.';

/**
 * General Error Messages
 */
$lang['bitauth_instance_na']		= "BitAuth was unable to get the CodeIgniter instance.";
$lang['bitauth_data_error']			= 'You can\'t overwrite default BitAuth properties with custom userdata. Please change the name of the field: %s';
$lang['bitauth_enable_gmp']			= 'You must enable php_gmp to use Bitauth.';
$lang['bitauth_user_not_found']		= 'User not found: %d';
$lang['bitauth_activate_failed']	= 'Unable to activate user with this activation code.';
$lang['bitauth_expired_datatype']	= '$user must be an array or an object in Bitauth::password_is_expired()';
$lang['bitauth_expiring_datatype']	= '$user must be an array or an object in Bitauth::password_almost_expired()';
$lang['bitauth_add_user_datatype']	= '$data must be an array or an object in Bitauth::add_user()';
$lang['bitauth_add_user_failed']	= 'Adding user failed, please notify an administrator.';
$lang['bitauth_code_not_found']		= 'Activation Code Not Found.';
$lang['bitauth_edit_user_datatype']	= '$data must be an array or an object in Bitauth::update_user()';
$lang['bitauth_edit_user_failed']	= 'Updating user failed, please notify an administrator.';
$lang['bitauth_del_user_failed']	= 'Deleting user failed, please notify an administrator.';
$lang['bitauth_set_pw_failed']		= 'Unable to set user\'s password, please notify an administrator.';
$lang['bitauth_no_default_group']	= 'Default group was either not specified or not found, please notify an administrator.';
$lang['bitauth_add_group_datatype']	= '$data must be an array or an object in Bitauth::add_group()';
$lang['bitauth_add_group_failed']	= 'Adding group failed, please notify an administrator.';
$lang['bitauth_edit_group_datatype']= '$data must be an array or an object in Bitauth::update_group()';
$lang['bitauth_edit_group_failed']	= 'Updating group failed, please notify an administrator.';
$lang['bitauth_del_group_failed']	= 'Deleting group failed, please notify an administrator.';
$lang['bitauth_lang_not_found']		= '(No language entry for "%s" found!)';
