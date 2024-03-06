<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Size_Model extends Ex_Model
{
    protected $table_name = 'product_size';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_product_size() {
        $results = $this->db->query("SELECT * FROM `product_size` ORDER BY `size` ASC")->result();
        return $results;
    }

    public function get_pizza_size() {
        return $this->get_by(array('is_pizza' => 1));
    }
}

