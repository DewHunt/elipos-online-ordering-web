<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Ex_Model {

    protected $table_name = 'fooditem';
    protected $primary_key = 'foodItemId';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_products() {
    	$results = $this->db->query("SELECT * FROM `fooditem` ORDER BY `foodItemName` ASC")->result();
    	return $results;
    }

    public function get_all_products_by_category_id($category_id = 0) {
    	$results = $this->db->query("SELECT * FROM `fooditem` WHERE `categoryId` IN ($category_id) ORDER BY `foodItemName` ASC")->result();
    	return $results;
    }

    public function get_all_product_ids_by_category_id($category_id = 0) {
    	$results = $this->db->query("SELECT `foodItemId` FROM `fooditem` WHERE `categoryId` IN ($category_id)")->result_array();

        if (is_array($results)) {
            $results = array_column($results, 'foodItemId');
        }
    	return $results;
    }
}
