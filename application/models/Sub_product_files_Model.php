<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_product_files_Model extends Ex_Model {
    protected $table_name = 'selectionitemsfiles';
    protected $primary_key = 'selectiveItemId';

    public function __construct() {
        parent::__construct();
    }

    public function get_total_sub_product_files() {
        $total = $this->db->query("SELECT COUNT(`selectiveItemId`) AS `total` FROM `selectionitemsfiles`")->row()->total;
        return $total;
    }

    public function get_total_sub_product_files_ids() {
        $results = $this->db->query("SELECT * FROM `selectionitemsfiles`")->result();
        $ids = array();
        foreach ($results as $result) {
            array_push($ids, $result->selectiveItemId);
        }
        $ids = implode(',', $ids);
        return $ids;
    }

    public function is_selectiveItemId_exist($id = 0) {
        $this->where_column = 'selectiveItemId';
        return $this->get($id, true);
    }

    public function is_sub_product_item_file_name_exist($name) {
        $this->db->where('selectiveItemName',$name);
        $result = $this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function is_sub_product_item_file_name_exist_for_update($id, $name) {
        $this->db->where('selectiveItemName',$name);
        $this->db->where('selectiveItemId!=',$id);
        $result = $this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function get_sub_product_item_file_list_details($product_id) {
        $query_result = '';
        if (!empty($product_id)) {
            $query_result = $this->db->query("SELECT * FROM ".$this->table_name." WHERE foodItemId = '$product_id',ORDER BY SortOrder ASC");
        } else {
            $query_result = $this->db->query("SELECT * FROM ".$this->table_name);
        }
        return $query_result->result();
    }

    public function get_sub_product_item_file_category_id($sub_product_item_file_id) {
        $query_result = $this->db->query("SELECT si.selectiveItemId, si.selectiveItemName, fi.categoryId FROM ".$this.$this->table_name." si LEFT JOIN fooditem fi ON si.foodItemId=fi.foodItemId WHERE si.selectiveItemId ='$sub_product_item_file_id'");
        return $query_result->row();
    }
}