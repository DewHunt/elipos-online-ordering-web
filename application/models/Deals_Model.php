<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deals_Model extends Ex_Model
{
    protected $table_name = 'deals';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $result = $this->db->query("
            SELECT `deals`.*,`category`.`categoryName` AS `categoryName` 
            FROM `deals`
            JOIN `category` ON `category`.`categoryId` = `deals`.`categoryId`
            ORDER BY `category`.`categoryName` ASC,`deals`.`sort_order` ASC
        ")->result();
        return $result;
    }

    public function get_deal_by_id($id) {
        $result = $this->db->query("SELECT * FROM `deals` WHERE `id` = $id")->row();
        return $result;
    }

    public function get_by_id($id = 0) {
        $this->db->select('deals.*,category.*');
        $this->db->from('deals');
        $this->db->join('category','deals.categoryId = category.categoryId');
        $this->db->where('id',intval($id));
        return $this->db->get()->row();
    }

    public function get_by_category_id($categoryId = 0) {
        $result = $this->db->query("
            SELECT `deals`.*,`category`.`categoryName` AS `categoryName` 
            FROM `deals`
            INNER JOIN `category` ON `category`.`categoryId` = `deals`.`categoryId`
            WHERE `deals`.`categoryId` = $categoryId
            ORDER BY `deals`.`sort_order` ASC
        ")->result();
        return $result;
    }

    public function get_deal_by_category_id_and_flags($categoryId = 0) {
        $result = $this->db->query("
            SELECT `deals`.*,`category`.`categoryName` AS `categoryName` 
            FROM `deals`
            JOIN `category` ON `category`.`categoryId` = `deals`.`categoryId`
            WHERE `deals`.`categoryId` = $categoryId AND `deals`.`orderable` = 1 AND `deals`.`active` = 1
            ORDER BY `deals`.`sort_order` ASC
        ")->result();
        return $result;
    }
    
    public function getDealsItem($dealDetails = array(),$id = 0) {
        foreach ($dealDetails as $detail) {
            if($detail['id'] == $id){
                return array_key_exists('elements',$detail) ? $detail['elements'] : null;
            }
        }
        return null;
    }

    public function getDealsItemAsCategories($dealsCategories) {
        $dealsCategoriesArray = array();
        if (!empty($dealsCategories)) {
            foreach ($dealsCategories as $dealsCategory){
                $dealsCategoryArray = array();
                if ($dealsCategory->isDeals) {
                    $dealsArray = $this->getDealsItemByCategory($dealsCategory);
                    $dealsCategoryArray['deals'] = $dealsArray;
                }
                array_push($dealsCategoriesArray,$dealsCategoryArray);
            }
        }
        return $dealsCategoriesArray;
    }

    public function getDealsItemByCategory($category) {
        $deals = $this->get_deal_by_category_id_and_flags($category->categoryId);
        $currentDayName = strtolower(date('l'));
        if (empty($deals)) {
           return array();
        } else {
            $dealsCategoryArray = (array)$category;
            $dealsArray = array();
            $product_object = new Product();
            foreach ($deals as $deal){
                $dealsAvailabilities = explode(',',$deal->availability);
                if (in_array($currentDayName,$dealsAvailabilities)) {
                    $mDealsItem = new Deals_Item_Model();
                    $deals_items = $mDealsItem->get_by_deals_id($deal->id);
                    $deal = (array)$deal;
                    $newDealsItem = array();
                    foreach ($deals_items as $deals_item) {
                        $itemProductIds = $deals_item['productIds'];
                        $itemProductIds = (!empty($itemProductIds)) ? json_decode($itemProductIds,true) : null;
                        $itemSubProductIds = $deals_item['subProductIds'];
                        $itemSubProductIds = (!empty($itemSubProductIds)) ? json_decode($itemSubProductIds,true) : null;
                        $itemSubProducts = null;
                        if (!empty($itemSubProductIds)) {
                            $itemSubProducts = $product_object->get_sub_products_by_ids($itemSubProductIds);
                        }
                        $itemProducts = null;
                        if (!empty($itemProductIds)) {
                            $itemProducts = $product_object->get_products_by_ids($itemProductIds);
                        }
                        $deals_item['products'] = $itemProducts;
                        $deals_item['subProducts'] = $itemSubProducts;
                        array_push($newDealsItem,$deals_item);
                    }
                    $deal['deals_items'] = $newDealsItem;
                    array_push($dealsArray,$deal);
                }
            }
            return $dealsArray;
        }
    }

    public function update_active_status($dealId,$status,$fieldName) {
        // echo $fieldName;
        $findResult = $this->db->query("SELECT * FROM deals WHERE id = $dealId")->row();

        // dd($findResult);
        $update = $this->db->query("UPDATE deals SET $fieldName = $status WHERE id = $dealId");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false; 
    }

    public function get_sort_order_by_category_id($category_id) {
        $result = 0;
        if ($category_id) {
            $result = $this->db->query("SELECT MAX(`sort_order`) AS `sort_order` FROM `deals` WHERE `categoryId` = $category_id")->row()->sort_order;
        }
        return $result;
    }
}