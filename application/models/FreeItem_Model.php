<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FreeItem_Model extends Ex_Model
{
    protected $table_name = 'free_items';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }
    public $add_rules = array(
        'amount' => array(
            'field' => 'amount',
            'label' => 'Amount',
            'rules' => 'trim|required|numeric|is_unique[free_items.amount]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'numeric' => '%s must be a number.',
                'is_unique' => '%s must be unique number.',
            ),
        ),
    );
    public $edit_rules = array(
        'amount' => array(
            'field' => 'amount',
            'label' => 'Amount',
            'rules' => 'trim|required|numeric',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'numeric' => '%s must be a number.',
            ),
        ),
    );

    public function is_enabled_free_item() {
        $is_enabled_free_item = false;
        $enabled_free_item = $this->Settings_Model->get_by(array('name' => 'enabled_free_item',), true);
        if (!empty($enabled_free_item)) {
            if ($enabled_free_item->value == 'true') {
                return true;
            }
        }
        return $is_enabled_free_item;
    }

    public function get_free_item_limit(){
        $free_item_limit = 0;
        $free_item_limit = $this->Settings_Model->get_by(array('name' => 'free_item_limit',), true);
        if (!empty($free_item_limit)) {
            return intval($free_item_limit->value);
        }
        return $free_item_limit;
    }

    public function getOfferAsAmount($amount = 0) {
        if ($this->is_enabled_free_item()) {
            $this->db->order_by('amount', 'DESC');
            $result = $this->get_by(array('amount<=' => $amount,'status' => 1), true);
            return $result;
        } else {
            return null;
        }
    }

    public function addFreeItem() {
        $free_offers = $this->getFreeItemOffer();
        // dd($free_offers);
        $freeProduct = null;
        $freeSubProduct = null;
        $isShowFreeItemModal = false;        
        if (!empty($free_offers)) {
            $lib_product = new Product();
            $product_ids = (!empty($free_offers->product_ids)) ? json_decode($free_offers->product_ids) : array();
            $sub_product_ids = (!empty($free_offers->sub_products_ids)) ? json_decode($free_offers->sub_products_ids) : array();
            if (!empty($product_ids) && empty($sub_product_ids)){
                $freeProduct = $lib_product->get_product($product_ids[0]);
            }
            if (!empty($sub_product_ids)) {
                $freeSubProduct= $lib_product->get_sub_product_by_id($sub_product_ids[0]);
            }
        }

        if (!empty($freeProduct)) {
            $name = 'Free '.$freeProduct->foodItemName;
            $product_id = $freeProduct->foodItemId;
            $category_id = $freeProduct->categoryId;
            $data = array(
                'id' => time(),
                'isDeal' => false,
                'isFree' => true,
                'product_id' => $product_id,
                'category_id' => $category_id,
                'sub_product_id' => 0,
                'name' => $name,
                'qty' => 1,
                'price' => 0,
                'regular_price' => 0,
                'vat' => 0,
                'side_dish' => '',
                'cat_level' => 3,
                'side_dish_ids' => array(),
                'side_dish_name' => '',
                'side_dish_price' => 0,
                'side_dish_vat' => 0,
                'order_type' => 'both',
                'is_category_discount' => $freeProduct->categoryIsDiscount,
                'is_item_discount' => $freeProduct->isDiscount,
                'is_deals_discount' => 0,
            );
        } else if(!empty($freeSubProduct)) {
            $name = 'Free '.$freeSubProduct->selectiveItemName;
            $food_item_id = $freeSubProduct->foodItemId;
            $category_id = $freeSubProduct->categoryId;
            $data = array(
                'id' =>time(),
                'isDeal' => false,
                'isFree' => true,
                'product_id' => $food_item_id,
                'category_id' => $category_id,
                'sub_product_id' => $freeSubProduct->selectiveItemId,
                'name' => $name,
                'qty' => 1,
                'price' => 0,
                'regular_price' => 0,
                'vat' => 0,
                'side_dish' => '',
                'cat_level' => 3,
                'side_dish_ids' => array(),
                'side_dish_name' => '',
                'side_dish_price' => 0,
                'side_dish_vat' => 0,
                'order_type' => 'both',
                'is_category_discount' => $freeSubProduct->categoryIsDiscount,
                'is_item_discount' => $freeSubProduct->isDiscount,
                'is_deals_discount' => 0,
            );
        }

        $data['is_buy_get_discount'] = false;
        $data['buy_get_id'] = 0;
        $data['buy_qty'] = false;
        $data['get_qty'] = false;
        $data['free_item_qty'] = 0;
        $data['buy_get_amount'] = 0;
        $data['comments'] = "";
        // echo "<pre>"; print_r($data); exit();

        if (!empty($data)) {
            $this->cart->insert($data);
        }
    }

    public function isOfferItemIsAdded( $offerId = 0) {
        $items = $this->cart->contents();
        foreach ($items as $item) {
            if (array_key_exists('isFree', $item)) {
                $freeDetails = $item['freeDetails'];
                if ($offerId == $freeDetails['offerId']) {
                    return $item['rowid'];
                }
            }
        }
        return null;
    }

    public function getFreeOfferRowId() {
        $items = $this->cart->contents();
        foreach ($items as $item) {
            if (array_key_exists('isFree', $item)) {
                return $item['rowid'];
            }
        }
        return null;
    }

    public function getFreeItemOffer() {
        $enabled_free_item = $this->is_enabled_free_item();
        if ($enabled_free_item) {
            $cart_total = $this->cart->total();
            $free_offers = $this->getOfferAsAmount($cart_total);
            return $free_offers;
        }
        return null;
    }

    public function removeFreeItem() {
        $items = $this->cart->contents();
        $amount = $this->cart->total();
        foreach ($items as $item) {
            if (array_key_exists('isFree', $item)) {
                $freeDetails = $item['freeDetails'];
                if ($amount < $freeDetails['amount']) {
                    $this->cart->remove($item['rowid']);
                }
            }
        }
        return null;
    }

    public function removeAllFreeItem() {
        $items = $this->cart->contents();
        foreach ($items as $item) {
            if (array_key_exists('isFree', $item)) {
                $isFree = $item['isFree'];
                if ($isFree) {
                    $this->cart->remove($item['rowid']);
                }
            }
        }
    }


    public function getFreeItemForApi() {
        $enabled_free_item = $this->is_enabled_free_item();
        if ($enabled_free_item) {
            $result = $this->get_by(array('status' => 1));
            return $result;
        } else {
            return array();
        }
    }

    public function getAllFreeItemIsAddedToCart() {
        $items = $this->cart->contents();
        return array_filter($items,function ($item){
            return array_key_exists('isFree',$item);
        });
    }

    public function getFreeItemDetailsForApi() {
        $product_object = new Product();
        $freeItems = $this->getFreeItemForApi();
        $freeItemLimit = $this->get_free_item_limit();
        $freeItemsArray = array();
        $isFreeItemEnabled = false;
        if (!empty($freeItems)) {
            $isFreeItemEnabled = true;
            foreach ($freeItems as $freeItem) {
                $product_ids = (!empty($freeItem->product_ids)) ? json_decode($freeItem->product_ids) : array();
                $products = array();
                $sub_products = array();
                if (!empty($product_ids)){
                    $products = $product_object->get_products_by_ids($product_ids);
                }
                $sub_product_ids = (!empty($freeItem->sub_products_ids)) ? json_decode($freeItem->sub_products_ids) : array();
                if (!empty($sub_product_ids)) {
                    $sub_products = $product_object->get_sub_products_by_ids($sub_product_ids);
                }
                $_freeItem = (array)$freeItem;
                $_freeItem['products'] = $products;
                $_freeItem['subProducts'] = $sub_products;
                array_push($freeItemsArray,$_freeItem);
            }
        }
        return  array(
            'freeItems'=>$freeItemsArray,
            'itemLimit'=>$freeItemLimit,
            'message'=>'Remove one item from top to add a item from bottom',
            'isFreeItemEnabled'=>$isFreeItemEnabled,
        );
    }
}