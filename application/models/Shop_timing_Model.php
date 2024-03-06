<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_timing_Model extends Ex_Model
{
    protected $table_name = 'shop_timing';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all($order_type = 'collection') {
        $this->db->order_by('day_id','ASC');
        $this->db->where('order_type',$order_type);
        return $this->get();
    }

    public function get_shop_timing_list() {
        $results = $this->db->query("SELECT * FROM `shop_timing` ORDER BY `order_type` ASC, `day_id` ASC")->result();
        return $results;
    }

    public function count_row_for_collection_shop_timing() {
        $result = $this->db->query("SELECT count(`day_id`) AS `total_row` FROM `shop_timing` WHERE `order_type` = 'collection'")->row()->total_row;
        return $result;
    }

    public function count_row_for_delivery_shop_timing() {
        $result = $this->db->query("SELECT count(`day_id`) AS `total_row` FROM `shop_timing` WHERE `order_type` = 'delivery'")->row()->total_row;
        return $result;
    }
}