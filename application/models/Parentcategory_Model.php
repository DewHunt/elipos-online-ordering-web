<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parentcategory_Model extends Ex_Model {

    protected $table_name = 'parentcategory';
    protected $primary_key = 'parentCategoryId';

    public function __construct() {
        parent::__construct();
    }

    function is_parentCategoryId_exist($id = 0) {
        $this->where_column = 'parentCategoryId';
        return $this->get($id, TRUE);
    }

    public function is_parent_category_name_exist($name) {
        $this->search_column_name = 'parentCategoryName';
        return !empty($this->get_numbers_of_rows($name)) ? TRUE : FALSE;
    }

    public function is_parent_category_name_exist_for_update($id, $name) {
        $query = $this->db->query("SELECT * FROM parentcategory WHERE parentCategoryId != $id AND parentCategoryName = '$name'")->row();
        return !empty($query) ? TRUE : FALSE;
    }
    
    public function get_first_parent_category() {
        $query = $this->db->query("SELECT * FROM `parentcategory` ORDER BY `parentCategoryId` ASC LIMIT 1");
        return $query->row();
    }

}
