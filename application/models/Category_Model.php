<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_Model extends Ex_Model {

    protected $table_name = 'category';
    protected $primary_key = 'categoryId';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_category() {
        $results = $this->db->query("SELECT * FROM `category` ORDER BY `SortOrder` ASC")->result();
        return $results;
    }

    public function get_all_category_ids() {
        $results = $this->db->query("SELECT `categoryId` FROM `category`")->result_array();
        if (is_array($results)) {
            $results = array_column($results, 'categoryId');
        }
        return $results;
    }

    function is_category_id_exist($id = 0) {
        $this->where_column = 'categoryId';
        return $this->get($id, true);
    }

    public function get_category_list_details($parent_category_id, $food_type_id) {
        if (($parent_category_id > 0) && ($food_type_id > 0)) {
            $query = $this->db->query("
                SELECT c.categoryId, c.parentCategoryId, c.foodTypeId, c.categoryTypeId, c.categoryName, c.tableView, c.takeawayView, c.barView, c.backgroundColor, c.ButtonHight, c.ButtonWidth, c.SortOrder, c.KitchenSectionId, c.FontSetting, c.Forecolor, c.PrintingSortOrder, c.active, c.orderable, c.isHighlight, c.highlight_color, c.category_description, pc.parentCategoryName, ft.foodTypeName
                FROM category c
                LEFT JOIN parentcategory pc ON c.parentCategoryId = pc.parentCategoryId
                LEFT JOIN foodtype ft ON c.foodTypeId = ft.foodTypeId
                WHERE c.parentCategoryId = '$parent_category_id' AND c.foodTypeId = '$food_type_id'
                ORDER BY c.SortOrder ASC
            ");
        } elseif (($parent_category_id > 0) && ($food_type_id <= 0)) {
            $query = $this->db->query("
                SELECT c.categoryId, c.parentCategoryId, c.foodTypeId, c.categoryTypeId, c.categoryName, c.tableView, c.takeawayView, c.barView, c.backgroundColor, c.ButtonHight, c.ButtonWidth, c.SortOrder, c.KitchenSectionId, c.FontSetting, c.Forecolor, c.PrintingSortOrder, c.active, c.orderable, c.isHighlight, c.highlight_color, c.category_description, pc.parentCategoryName, ft.foodTypeName
                FROM category c
                LEFT JOIN parentcategory pc ON c.parentCategoryId = pc.parentCategoryId
                LEFT JOIN foodtype ft ON c.foodTypeId = ft.foodTypeId
                WHERE c.parentCategoryId = '$parent_category_id'
                ORDER BY c.SortOrder ASC
            ");
        } else {
            $query = $this->db->query("
                SELECT c.categoryId, c.parentCategoryId, c.foodTypeId, c.categoryTypeId, c.categoryName, c.tableView, c.takeawayView, c.barView, c.backgroundColor, c.ButtonHight, c.ButtonWidth, c.SortOrder, c.KitchenSectionId, c.FontSetting, c.Forecolor, c.PrintingSortOrder, c.active, c.orderable, c.isHighlight, c.highlight_color, c.category_description, pc.parentCategoryName, ft.foodTypeName
                FROM category c
                LEFT JOIN parentcategory pc ON c.parentCategoryId = pc.parentCategoryId
                LEFT JOIN foodtype ft ON c.foodTypeId = ft.foodTypeId
                ORDER BY c.SortOrder ASC
            ");
        }
        return $query->result();
    }

    public function is_category_name_exist($name) {
        $this->search_column_name = 'categoryName';
        return !empty($this->get_numbers_of_rows($name)) ? TRUE : FALSE;
    }

    public function is_category_name_exist_for_update($id, $name) {
        $query = $this->db->query("SELECT * FROM category WHERE categoryId != $id AND categoryName = '$name'")->row();
        return !empty($query) ? TRUE : FALSE;
    }

    public function get_category_list_by_parent_category_id($id) {
        $query = $this->db->get_where($this->table_name, array('parentCategoryId' => $id));
        return $query->result();
    }

    public function get_category_list_by_food_type_id($id) {
        $query = $this->db->get_where($this->table_name, array('foodTypeId' => $id));
        return $query->result();
    }
    
    public function get_first_category_by_food_type_id($id) {
        $query = $this->db->get_where("SELECT * FROM category WHERE foodTypeId ='$id' ORDER BY foodTypeId ASC LIMIT 1");
        return $query->row();
    }

    public function get_offers_or_deals(){
        return $this->get_by(array('isDeals'=>1,'isPackage'=>0,));
    }

    public function get_offers_or_deals_and_package(){
        $this->db->where('isDeals',1);
        $this->db->or_where('isPackage',1);
        $result = $this->get();
        return $result;
    }

    public function get_all_normal(){
        // return $this->get_by(array('isDeals'=>0,));

        $this->db->where('isDeals',0);
        $this->db->or_where('isPackage',1);
        $result = $this->get();
        return $result;
    }

    public function get_packages(){
        $this->db->where('isPackage',1);
        $result=  $this->get();
        return $result;
    }

    public function get_category_by_id($categoryId) {
        $result = $this->db->query("SELECT * FROM `category` WHERE `categoryId` = $categoryId")->row();
        return $result;
    }

    public function update_active_status($categoryId,$status,$fieldName,$highlightColor = "") {
        $findResult = $this->db->query("SELECT * FROM category WHERE categoryId = $categoryId")->row();

        $setField = "";
        if ($highlightColor) {
            $setField = ", highlight_color = '$highlightColor'";
        }

        // dd($setField);

        $update = $this->db->query("UPDATE category SET $fieldName = $status $setField WHERE categoryId = $categoryId");

        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false; 
    }

    public function get_max_sort_order() {
        $result = $this->db->query("SELECT MAX(`SortOrder`) AS `SortOrder` FROM `category`")->row()->SortOrder;
        return $result;
    }
}