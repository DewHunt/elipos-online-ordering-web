<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fooditem_Model extends Ex_Model {
    protected $table_name = "fooditem";
    protected $primary_key = "foodItemId";
    public $selectionText = "foodItemId,parentCategoryId,foodtypeId,categoryId,availability,IFNUll(foodItemFullName,foodItemName) as foodItemName,tableView,barView,itemStock,qtyStatus,tablePrice,takeawayPrice,barPrice,tableCost,takeawayCost,barCost,vatRate,vatStatus,itemUnit,product_plu,ButtonHight,ButtonWidth,ItemColor,SortOrder,FontSetting,Forecolor,description,active,orderable,product_order_type,isHighlight,highlight_color,item_strength,isDiscount";

    public function __construct() {
        parent::__construct();
    }

    public function get_all_product() {
        $results = $this->db->query("
            SELECT `fooditem`.*, `category`.`categoryName`
            FROM `fooditem`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            ORDER BY `category`.`categoryName` ASC,`fooditem`.`SortOrder` ASC
        ")->result();
        return $results;
    }

    public function get_all_products_by_category_id($category_id = 0) {
        $results = $this->db->query("
            SELECT `fooditem`.*, `category`.`categoryName`
            FROM `fooditem`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            WHERE `fooditem`.`categoryId` = $category_id
            ORDER BY `fooditem`.`SortOrder` ASC
        ")->result();
        return $results;
    }

    public function get_all_product_ids_by_category_id($category_id = 0) {
        $results = $this->db->query("SELECT `foodItemId` FROM `fooditem` WHERE `categoryId` IN ($category_id)")->result_array();

        if (is_array($results)) {
            $results = array_column($results, 'foodItemId');
        }
        return $results;
    }

    public function is_foodItemId_exist($id = 0) {
        $this->where_column = 'foodItemId';
        return $this->get($id, true);
    }

    public function is_product_name_exist($name) {
        $this->db->where('foodItemName',$name);
        $result = $this->count();
        return (intval($result)>0)?true:false;
    }

    public function is_product_name_exist_for_update($id, $name) {
        $this->db->where('foodItemName',$name);
        $this->db->where('foodItemId!=',$id);
        $result = $this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function get_product_list_details($parent_category_id, $category_id) {
        $query_result = $this->db->query("SELECT * FROM fooditem WHERE parentCategoryId = '$parent_category_id' AND categoryId = '$category_id'");
        return $query_result->result();
    }

    public function get_product_list_by_parent_category_id($id) {
        $query = $this->db->get_where($this->table_name, array('parentCategoryId' => $id));
        return $query->result();
    }
    
    public function get_product_by_category_id($id) {
        $results = "";
        if ($id) {
            $results = $this->db->query("
                SELECT  `fooditem`.*, `category`.`categoryName`
                FROM `fooditem`
                INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
                WHERE `fooditem`.`categoryId` IN ($id)
                ORDER BY `fooditem`.`SortOrder` ASC"
            )->result();
        }
        return $results;
    }

    public function get_sort_order_by_category_id($category_id) {
        $result = 0;
        if ($category_id) {
            $result = $this->db->query("SELECT MAX(`SortOrder`) AS `SortOrder` FROM `fooditem` WHERE `categoryId` = $category_id")->row()->SortOrder;
        }
        return $result;
    }

    public function get_all_products($conditions = array()) {
        $this->db->select($this->selectionText);
        $this->db->from($this->table_name);
        if(!empty($conditions)){
            $this->db->where($conditions);
        }
        $this->db->order_by('SortOrder','ASC');
        return $this->db->get()->result();
    }

    public function get_product_by_id($foodItemId = 0){
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('foodItemId',intval($foodItemId));

       return $this->db->get()->row();
    }

    public function get_products_by_ids($foodItemIds = array()) {
        if (!empty($foodItemIds) && is_array($foodItemIds)) {
            $this->db->select($this->selectionText);
            $this->db->from($this->table_name);
            $this->db->where_in('foodItemId',$foodItemIds);
            return $this->db->get()->result();
        } else {
            return null;
        }
    }

    public function update_active_status($foodItemId,$status,$fieldName,$highlightColor) {
        $findResult = $this->db->query("SELECT * FROM fooditem WHERE foodItemId = $foodItemId")->row();
        $setField = "";
        if ($highlightColor) {
            $setField = ", highlight_color = '$highlightColor'";
        }
        // dd($findResult);

        $update = $this->db->query("UPDATE fooditem SET $fieldName = $status $setField WHERE foodItemId = $foodItemId");
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false; 
    }
}
