<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brands_model extends CH_Model {
    
    public function get_brands_list(){
        $this->db->from(Brands_DTO::TABLE_NAME);
        return $this->_get_list(Brands_DTO::class_name());
    }
    
    public function get_brand($id_brand){
        $this->db->from(Brands_DTO::TABLE_NAME)
                ->where(Brands_DTO::FIELD_ID, $id_brand);
        return $this->_get(Brands_DTO::class_name(),FALSE);
    }
    
    public function get_brand_by_code($code){
        $this->db->from(Brands_DTO::TABLE_NAME)
                ->where(Brands_DTO::FIELD_BRAND_CODE, $code);
        return $this->_get(Brands_DTO::class_name(),FALSE);
    }
    
}