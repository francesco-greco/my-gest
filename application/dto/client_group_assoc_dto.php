<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');
class Client_group_assoc_DTO {
    const TABLE_NAME = 'client_group_assoc';

    const FIELD_ASSOC_ID = 'assoc_id';
    const FIELD_USER_ID = 'user_id';
    const FIELD_GROUP_ID = 'group_id';
    
    //ID del gruppo amminstratore
    const MAIN_GROUP_ID = 1;
}