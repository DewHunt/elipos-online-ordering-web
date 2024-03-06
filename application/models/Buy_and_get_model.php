<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_and_get_model extends Ex_Model
{
    protected $table_name = 'buy_and_get';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_buy_and_get() {
    	$all_buy_get = $this->db->query("SELECT * FROM buy_and_get")->result();

    	foreach ($all_buy_get as $buy_get) {
    		$category_id = $buy_get->category_id;
    		$item_id = $buy_get->item_id;

            $categories = array();
            $categoryArray = array();

            $items = array();
            $itemArray = array();

            if ($category_id) {
                $categories = $this->db->query("SELECT * FROM category WHERE categoryId IN ($category_id)")->result();
            }

            if ($item_id) {
                $items = $this->db->query("SELECT * FROM fooditem WHERE foodItemId IN ($item_id)")->result();
            }
        
            foreach ($categories as $category) {
                array_push($categoryArray,$category->categoryName);
            }
        
            foreach ($items as $item) {
                array_push($itemArray,$item->foodItemName);
            }

            $categoryName = implode(', ',$categoryArray);
            $itemName = implode(', ',$itemArray);
            $buy_get->category_id = $categoryName;
            $buy_get->item_id = $itemName;
    	}

    	return $all_buy_get;
    }

    public function buy_get_info_by_id($id) {
    	$result = $this->db->query("SELECT * FROM buy_and_get WHERE id = $id")->row();
    	return $result;
    }

    public function get_items_by_category() {
    	$Category_Model = new Category_Model();
    	$Fooditem_Model = new Fooditem_Model();

    	$items_by_category = $this->db->query("SELECT * FROM category ORDER BY categoryName ASC")->result();

    	foreach ($items_by_category as $category) {
    		$itemList = $this->db->query("SELECT * FROM fooditem WHERE categoryId = $category->categoryId ORDER BY foodItemName ASC")->result();
    		$category->itemList = $itemList;
    	}
    	return $items_by_category;

    	// echo "<pre>"; print_r($items_by_category); exit();
    }

    public function count_total_item_by_category($category_id) {
    	$result = $this->db->query("SELECT COUNT(`foodItemId`) AS countItem FROM `fooditem` WHERE `categoryId` = $category_id")->row()->countItem;
    	return $result;
    }

    public function get_buy_get_for_all_menus($category_id = 0,$item_id = 0) {
        $current_date = date('Y-m-d');
        $currentDayName = strtolower(date('l'));

        $where_condition = "";
        if ($category_id > 0) {
            $where_condition .= "AND FIND_IN_SET($category_id,`category_id`)";
        }

        if ($item_id > 0) {
            $where_condition .= " AND FIND_IN_SET($item_id,`item_id`)";
        }

        $result = $this->db->query("
            SELECT * FROM `buy_and_get` WHERE '$current_date' BETWEEN `start_date` AND `end_date` AND FIND_IN_SET('$currentDayName',`availability`) $where_condition AND status = 1
        ")->row();
        return $result;
    }
}

