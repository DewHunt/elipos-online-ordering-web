<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_side_dish_Model extends Ex_Model
{
    protected $table_name = 'order_side_dish';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_order_details_id ($order_details_id = 0,$is_no = false) {
        $this->db->where('is_no',$is_no);
        $this->db->where('order_details_id',$order_details_id);
        return $this->get();
    }

    public function get_all_by_order_details_id($order_details_id = 0){
        $this->db->select("id,side_dish_id,order_id,order_details_id,is_no,quantity,vat,price,order_time, IF(is_no='1',concat(\"No \",side_dish_name),side_dish_name) AS side_dish_name");
        $this->db->where('order_details_id',$order_details_id);
        $this->db->order_by('id','ASC');
        return $this->get();
    }

    public function getSideDishOptions($order_details_id = 0){
        $m_side_dish = new Sidedishes_Model();
        $options_with_ids = $this->get_side_dish_ids($order_details_id,false);
        $options_without_ids = $this->get_side_dish_ids($order_details_id,true);
        $with = array();
        if (!empty($options_with_ids)) {
            $ids_with = array_column($options_with_ids,'id');
            $with = $m_side_dish->getAllByIds($ids_with);
        }

        $without = array();
        if (!empty($options_without_ids)) {
            $ids_without = array_column($options_with_ids,'id');
            $without = $m_side_dish->getAllByIds($ids_without);
        }

        return array('with'=>$with,'without'=>$without,);
    }

    public function get_side_dish_ids($order_details_id = 0,$is_no = false) {
        $this->db->select("side_dish_id as id");
        $this->db->where('is_no',$is_no);
        $this->db->where('order_details_id',$order_details_id);
        return $this->db->get($this->table_name)->result_array();
    }
}