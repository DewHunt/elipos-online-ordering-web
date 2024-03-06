<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Foodtype_Model extends Ex_Model {

    protected $table_name = 'foodtype';
    protected $primary_key = 'foodTypeId';

    public function __construct() {
        parent::__construct();
    }

    function is_foodTypeId_exist($id = 0) {
        $this->where_column = 'foodTypeId';
        return $this->get($id, true);
    }

    public function is_food_type_name_exist($name) {
        $this->search_column_name = 'foodTypeName';
        return !empty($this->get_numbers_of_rows($name)) ? TRUE : FALSE;
    }

    public function is_food_type_name_exist_for_update($id, $name) {
        $query = $this->db->query("SELECT * FROM foodtype WHERE foodTypeId != $id AND foodTypeName = '$name'")->row();
        return !empty($query) ? TRUE : FALSE;
    }

    public function get_food_type_list_by_parent_category_id($id) {
        $query = $this->db->get_where($this->table_name, array('parentCategoryId' => $id));
        return $query->result();
    }
    
    public function get_first_food_type_by_parent_category_id($id) {
        $query = $this->db->query("SELECT * FROM foodtype WHERE parentCategoryId ='$id' ORDER BY foodTypeId ASC LIMIT 1");
        return $query->row();
    }
}
