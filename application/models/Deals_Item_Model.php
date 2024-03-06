<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deals_Item_Model extends Ex_Model
{
    protected $table_name = 'deals_items';
    protected $primary_key = 'id';

    public function __construct(){
        parent::__construct();
    }

    public function get_items_from_session(){
       return $this->session->userdata('deals_items');
    }

    public function get_total_items_from_session(){
       return count($this->session->userdata('deals_items'));
    }

    public function set_item_to_session($item = array()) {
        $items = $this->get_items_from_session();
        if (!empty($items)) {
            array_push($items,$item);
        } else {
            $items = array();
            array_push($items,$item);
        }
        $this->session->set_userdata('deals_items',$items);
    }

    public function update_deals_items_to_session($items=array()){
        $this->session->set_userdata('deals_items',$items);
    }

    public function unset_item_to_session(){
        $this->session->unset_userdata('deals_items');
    }

    public function get_by_deals_id ($dealsId = 0) {
        $this->db->where('dealsId',$dealsId);
        return $this->db->get($this->table_name)->result_array();
    }

    public function get_deal_item_by_id($id = 0) {
        $result = $this->db->query("SELECT * FROM `deals_items` WHERE `id` = $id")->row();
        return $result;
    }

    public function get_total_limit_by_deals_id ($dealsId = '') {
        $result = $this->db->query("SELECT SUM(`limit`) AS `limit` FROM `deals_items` WHERE `dealsId` = $dealsId")->row();
        return $result;
    }
}