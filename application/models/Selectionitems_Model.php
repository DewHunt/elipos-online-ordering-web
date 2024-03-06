<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Selectionitems_Model extends Ex_Model {

    protected $table_name = 'selectionitems';
    protected $primary_key = 'selectiveItemId';
    public $where_column = 'selectiveItemId';
    public $selectionTextWithJoin = 'fooditem.categoryId,IFNUll(fooditem.foodItemName,fooditem.foodItemFullName) as foodItemName,selectionitems.selectiveItemId,IFNUll(selectionitems.selectiveItemName,selectionitems.selectiveItemFullName) as selectiveItemName,selectionitems.foodItemId,selectionitems.tablePrice,selectionitems.takeawayPrice,selectionitems.barPrice,selectionitems.product4_plu,selectionitems.status,selectionitems.selectiveItemStockQty,selectionitems.vatIncluded,selectionitems.vatRate,selectionitems.ButtonHight,selectionitems.ButtonWidth,selectionitems.SelectionItemColor,selectionitems.SortOrder,selectionitems.FontSetting,selectionitems.Forecolor,selectionitems.SelectionItemFilesId,selectionitems.productSizeId';

    public function __construct() {
        parent::__construct();
    }

    public function get_total_assigned_sub_product_files($product_id,$sub_product_files_ids) {
        $total = $this->db->query("
            SELECT COUNT(`selectiveItemId`) AS `total`
            FROM `selectionitems`
            WHERE `foodItemId` = $product_id AND `SelectionItemFilesId` IN ($sub_product_files_ids)
        ")->row()->total;
        return $total;
    }

    public function is_selectiveItemId_exist($id = 0) {
        $this->where_column = 'selectiveItemId';
        return $this->get($id, true);
    }

    public function is_sub_product_name_exist($name) {
        $this->db->where('selectiveItemName',$name);
        $result=$this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function is_sub_product_name_exist_with_another_product($name,$foodItemId=0) {
        $this->db->where('selectiveItemName',$name);
        $this->db->where('foodItemId',$foodItemId);
        $result = $this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function is_sub_product_name_exist_for_update($id, $name) {
        $this->db->where('selectiveItemName',$name);
        $this->db->where('selectiveItemId!=',$id);
        $result=$this->count();
        return (intval($result) > 0) ? true : false;
    }

    public function get_sub_product_list_details($product_id) {
        $query_result = $this->db->query("SELECT * FROM selectionitems WHERE foodItemId = '$product_id' ORDER BY SortOrder ASC ");
        return $query_result->result();
    }

    public function get_sub_product_category_id($sub_product_id) {
        $query_result = $this->db->query("
            SELECT `selectionitems`.`selectiveItemId`, `selectionitems`.`selectiveItemName`, `fooditem`.`categoryId`
            FROM `selectionitems`
            LEFT JOIN `fooditem` ON `selectionitems`.`foodItemId` = `fooditem`.`foodItemId`
            WHERE `selectionitems`.`selectiveItemId` = $sub_product_id
        ");
        return $query_result->row();
    }

    public function get_all_sub_products($conditions = array()){
        $this->db->select($this->selectionTextWithJoin);
        $this->db->from($this->table_name);
        $this->db->join('fooditem','fooditem.foodItemId=selectionitems.foodItemId');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->order_by('SortOrder','ASC');
        return $this->db->get()->result();
    }

    public function get_sub_product_by_id($selectiveItemId = 0) {
        $this->db->select($this->selectionTextWithJoin);
        $this->db->from($this->table_name);
        $this->db->join('fooditem','fooditem.foodItemId=selectionitems.foodItemId');
        $this->db->where('selectionitems.selectiveItemId',intval($selectiveItemId));
        return $this->db->get()->row();
    }

    public function get_sub_product_by_product_id ($foodItemId = 0) {
        if ($foodItemId) {
            $results = $this->db->query("
                SELECT `selectiveItemId`,IFNUll(`selectiveItemName`,`selectiveItemFullName`) as `selectiveItemName`,`foodItemId`,`tablePrice`,`takeawayPrice`,`barPrice`,`product4_plu`,`status`,`selectiveItemStockQty`,`vatIncluded`,`vatRate`,`ButtonHight`,`ButtonWidth`,`SelectionItemColor`,`SortOrder`,`FontSetting`,`Forecolor`,`SelectionItemFilesId`,`productSizeId`,`selection_item_description`,`selection_item_printed_description`
                FROM `selectionitems`
                WHERE `foodItemId` = $foodItemId
                ORDER BY `SortOrder` ASC
            ")->result();
            return $results;
        }
        return array();
    }

    public function get_sub_product_by_product_id_and_ids ($foodItemId = 0,$sub_product_ids = '') {
        $results = $this->db->query("
            SELECT `selectiveItemId`,IFNUll(`selectiveItemName`,`selectiveItemFullName`) as `selectiveItemName`,`foodItemId`,`tablePrice`,`takeawayPrice`,`barPrice`,`product4_plu`,`status`,`selectiveItemStockQty`,`vatIncluded`,`vatRate`,`ButtonHight`,`ButtonWidth`,`SelectionItemColor`,`SortOrder`,`FontSetting`,`Forecolor`,`SelectionItemFilesId`,`productSizeId`
            FROM `selectionitems`
            WHERE `foodItemId` = $foodItemId AND `selectiveItemId` IN ($sub_product_ids)
            ORDER BY `SortOrder` ASC
        ")->result();

        return $results;
    }

    public function get_sub_products_by_ids($selectiveItemIds = array()){
        if (!empty($selectiveItemIds) && is_array($selectiveItemIds)) {
            $this->db->select($this->selectionTextWithJoin);
            $this->db->from($this->table_name);
            $this->db->join('fooditem','fooditem.foodItemId=selectionitems.foodItemId');
            $this->db->where_in('selectionitems.selectiveItemId',$selectiveItemIds);
            $this->db->order_by('SortOrder','ASC');
            return $this->db->get()->result();
        } else {
            return null;
        }
    }

    public function get_sub_products_by_category_id_and_product_id($category_id = "", $product_id = "") {
        $where_condition = "";

        if ($category_id) {
            $where_condition .= "`category`.`categoryId` IN ($category_id)";
        }

        if ($product_id) {
            if ($where_condition != "") {
                $where_condition .= " AND ";
            }
            $where_condition .= "`selectionitems`.`foodItemId` IN ($product_id)";
        }

        if ($where_condition != "") {
            $where_condition = "WHERE ".$where_condition;
        }

        $results = $this->db->query("
            SELECT `selectionitems`.*,`category`.`categoryName`,`fooditem`.`foodItemName`
            FROM `selectionitems`
            INNER JOIN `fooditem` ON `fooditem`.`foodItemId` = `selectionitems`.`foodItemId`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            $where_condition
            ORDER BY `selectionitems`.`foodItemId` ASC
        ")->result();
        return $results;
    }

    public function get_sort_order_by_product_id($product_id) {
        $result = 0;
        if ($product_id) {
            $result = $this->db->query("SELECT MAX(`SortOrder`) AS `SortOrder` FROM `selectionitems` WHERE `foodItemId` = $product_id")->row()->SortOrder;
        }
        return $result;
    }
}