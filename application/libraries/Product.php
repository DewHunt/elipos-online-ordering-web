<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product {

    public $product_data = array();
    public $ins;
    public $selectProductFiledWithJoin = 'fooditem.foodItemId,fooditem.parentCategoryId,fooditem.foodtypeId,fooditem.categoryId, fooditem.foodItemName,fooditem.foodItemFullName,fooditem.productSizeId,fooditem.isDiscount';

    public function __construct() {
        $this->ins = &get_instance();
        $this->ins->load->Model('Category_Model');
        $this->ins->load->model('Parentcategory_Model');
        $this->ins->load->model('Fooditem_Model');
        $this->ins->load->model('Foodtype_Model');
        $this->ins->load->model('Selectionitems_Model');
        $this->ins->load->model('Sidedishes_Model');
        $this->ins->load->model('Product_Size_Model');
    }

    public function get_fooditem_strength_css_class_by_id($itemStrength)
    {
        $allFoodItemStrenghts = $this->ins->db->query("SELECT css_class, icon FROM fooditem_strength WHERE FIND_IN_SET(id,'$itemStrength')")->result();

        // $cssClassArray = array();
        // foreach ($allFoodItemStrenghts as $foodItemStrenght) {
        //     array_push($cssClassArray,$foodItemStrenght->css_class);
        // }
        // $cssClass = implode(' ',$cssClassArray);
        // return $cssClass;

        return $allFoodItemStrenghts;
    }

    public function get_categories() {
        $this->ins->Category_Model->db->order_by('SortOrder', 'ASC');
        return $this->ins->Category_Model->get_all_normal();
    }

    public function get_categories_menu_by_flags() {
        $result = $this->ins->db->query("SELECT * FROM `category` WHERE `active` = 1 AND `orderable` = 1 AND `isDeals` = 0 AND `isPackage` = 0 ORDER BY `SortOrder` ASC")->result();
        return $result;
    }

    public function get_deals_categories() {
        $this->ins->Category_Model->db->order_by('SortOrder', 'ASC');
        return $this->ins->Category_Model->get_offers_or_deals();
    }

    public function get_deals_categories_menu_by_flags() {
        $result = $this->ins->db->query("SELECT * FROM `category` WHERE `active` = 1 AND `orderable` = 1 AND `isDeals` = 1 AND `isPackage` = 0 ORDER BY `SortOrder` ASC")->result();
        return $result;
    }

    public function get_package_categories() {
        $this->ins->Category_Model->db->order_by('SortOrder', 'ASC');
        return $this->ins->Category_Model->get_packages();
    }

    public function get_product_by_category_id($category_id = 0) {
        // $where = array('categoryId' => $category_id,'orderable'=>1);
        $where = array('categoryId' => $category_id);
        return $this->ins->Fooditem_Model->get_all_products($where);
    }

    public function get_products() {
        $results = $this->ins->db->query("
            SELECT `fooditem`.*, `category`.`categoryName`
            FROM `fooditem`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            WHERE `fooditem`.`active` = 1 AND `fooditem`.`orderable` = 1
            ORDER BY `category`.`SortOrder` ASC,`fooditem`.`SortOrder` ASC            
        ")->result();
        return $results;
    }

    public function get_products_menu_by_flags($category_id = 0) {
        $where_query = "";
        if ($category_id > 0) {
            $where_query = "AND `fooditem`.`categoryId` = $category_id";
        }
        $result = $this->ins->db->query("
            SELECT `fooditem`.*, `category`.`categoryName`
            FROM `fooditem`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            WHERE `fooditem`.`active` = 1 AND `fooditem`.`orderable` = 1 $where_query
            ORDER BY `fooditem`.`SortOrder` ASC
        ")->result();

        return $result;
    }

    public function get_product_price_by_order_type($id,$order_type,$sub_product_id = 0,$get_sub_product_price = false)
    {
        $product_info = $this->ins->db->query("SELECT * FROM `fooditem` WHERE `foodItemId` = $id")->row();
        $sub_product_info = $this->ins->db->query("SELECT * FROM `selectionitems` WHERE `selectiveItemId` = $sub_product_id")->row();
        $product_order_type = explode(',',$product_info->product_order_type);
        // dd($sub_product_info);
        if ($order_type == 'dine_in' && in_array($order_type,$product_order_type)) {
            if ($get_sub_product_price === true) {
                return $sub_product_info->tablePrice;
            }
            return $product_info->tablePrice;
        }

        if ($get_sub_product_price === true) {
            return $sub_product_info->takeawayPrice;
        }
        return $product_info->takeawayPrice;
    }

    public function get_product_availability_by_order_type($id,$order_type)
    {
        $product_info = $this->ins->db->query("SELECT * FROM `fooditem` WHERE `foodItemId` = $id")->row();
        $product_order_type = explode(',',$product_info->product_order_type);
        $return_order_type = '';
        $status = true;

        if ($order_type == 'dine_in' && in_array($order_type,$product_order_type) === false) {
            $return_order_type = 'delivery And Collection';
            $status = false;
        } else if (($order_type == 'collection' || $order_type == 'delivery') && in_array($order_type,$product_order_type) === false){
            $return_order_type = 'dine_in';
            $status = false;
        }
        return array('product_order_type' => $return_order_type,'status' => $status);
    }

    public function get_deals_or_offer_availability_by_order_type($id,$order_type)
    {
        $deal_info = $this->ins->db->query("SELECT * FROM `deals` WHERE `id` = $id")->row();
        $deal_order_type = explode(',',$deal_info->deal_order_type);
        $return_order_type = '';
        $status = true;

        if ($order_type == 'dine_in' && in_array($order_type,$deal_order_type) === false) {
            $return_order_type = 'delivery And Collection';
            $status = false;
        } else if (($order_type == 'collection' || $order_type == 'delivery') && in_array($order_type,$deal_order_type) === false){
            $return_order_type = 'dine_in';
            $status = false;
        }
        return array('deal_order_type' => $return_order_type,'status' => $status);
    }

    public function get_products_by_ids($ids = array()) {
        $this->ins->db->select('*');
        $this->ins->db->from('fooditem');
        $this->ins->db->where_in('fooditem.fooditemId', $ids);
        $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        return $this->ins->db->get()->result();
    }

    public function get_sub_product($product_id = 0) {
        $this->ins->db->select('selectionitems.*,category.*,' . $this->selectProductFiledWithJoin);
        $this->ins->db->from('selectionitems');
        $this->ins->db->where('selectionitems.fooditemId', $product_id);
        $this->ins->db->join('fooditem', 'fooditem.fooditemId=selectionitems.fooditemId');
        $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        return $this->ins->db->get()->result();
    }

    public function get_product($id = 0) {
        $this->ins->db->select('fooditem.*,category.order_type as order_type,category.isDiscount as categoryIsDiscount');
        $this->ins->db->from('fooditem');
        $this->ins->db->where('fooditem.fooditemId',$id);
        $this->ins->db->join('category','category.categoryId = fooditem.categoryId');
        return $this->ins->db->get()->row();
    }

    public function get_sub_product_by_id($sub_product_id = 0) {
        $this->ins->db->select('selectionitems.*,category.order_type as order_type,category.isDiscount as categoryIsDiscount,fooditem.*');
        $this->ins->db->from('selectionitems');
        $this->ins->db->where('selectiveItemId', $sub_product_id);
        $this->ins->db->join('fooditem', 'fooditem.fooditemId=selectionitems.fooditemId');
        $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        return $this->ins->db->get()->row();
    }

    public function _get_sub_product_by_id($sub_product_id = 0) {
        $this->ins->db->select('selectionitems.*,category.*,' . $this->selectProductFiledWithJoin);
        $this->ins->db->from('selectionitems');
        $this->ins->db->where('selectiveItemId', $sub_product_id);
        $this->ins->db->join('fooditem', 'fooditem.fooditemId=selectionitems.fooditemId');
        $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        return $this->ins->db->get()->row();
    }

    public function get_all_sub_products() {
        $results = $this->ins->db->query("
            SELECT `selectionitems`.*,`category`.*,`fooditem`.`foodItemId`,`fooditem`.`parentCategoryId`,`fooditem`.`foodtypeId`,`fooditem`.`categoryId`,`fooditem`.`foodItemName`,`fooditem`.`foodItemFullName`,`fooditem`.`productSizeId`,`fooditem`.`isDiscount`
            FROM `selectionitems`
            INNER JOIN `fooditem` ON `fooditem`.`foodItemId` = `selectionitems`.`foodItemId`
            INNER JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            ORDER BY `fooditem`.`foodItemId` ASC,`selectionitems`.`SortOrder` ASC
        ")->result();
        return $results;
        // $this->ins->db->select('selectionitems.*,category.*,' . $this->selectProductFiledWithJoin);
        // $this->ins->db->from('selectionitems');
        // $this->ins->db->join('fooditem', 'fooditem.fooditemId=selectionitems.fooditemId');
        // $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        // return $this->ins->db->get()->result();
    }

    public function get_sub_products_by_ids($ids = array()) {
        return $this->ins->Selectionitems_Model->get_sub_products_by_ids($ids);
    }

    public function get_side_dish() {
        return $this->ins->Sidedishes_Model->get();
    }

    public function get_side_dish_by_id($id = 0) {
        return $this->ins->Sidedishes_Model->get($id, true);
    }

    public function get_side_dishes_by_ids($ids = array()) {
        if (!empty($ids)) {
            $this->ins->Sidedishes_Model->db->select('sidedishes.*');
            $this->ins->Sidedishes_Model->db->where_in('sidedishes.SideDishesId', $ids);
            $this->ins->Sidedishes_Model->db->join('modifier_category', 'modifier_category.ModifierCategoryId=sidedishes.ModifierCategoryId');
            $this->ins->Sidedishes_Model->db->order_by('modifier_category.SortOrder', 'ASC');
            return $this->ins->Sidedishes_Model->db->get('sidedishes')->result();
        } else {
            return array();
        }
    }

    public function get_offers_or_deals_name() {
        return 'SPECIAL OFFERS';
    }

    public function getProductsAsCategory($products = array(), $categoryId = 0) {
        if (!empty($products) && $categoryId > 0) {
            return array_filter($products, function ($element) use ($categoryId) {
                return ($element->categoryId == $categoryId);
            });
        } else {
            return null;
        }
    }

    public function getSubProductsByProductId($subProducts = array(), $foodItemId = 0) {
        if (!empty($subProducts) && $foodItemId > 0) {
            return array_filter($subProducts, function ($element) use ($foodItemId) {
                return ($element->foodItemId == $foodItemId);
            });
        } else {
            return null;
        }
    }

    public function get_products_by_sort_order($limit) {
        $this->ins->db->select('*');
        $this->ins->db->from('fooditem');
        $this->ins->db->join('category', 'category.categoryId=fooditem.categoryId');
        $this->ins->db->order_by("fooditem.SortOrder", "asc");
        $this->ins->db->limit(intval($limit));
        return $this->ins->db->get()->result();
    }
}