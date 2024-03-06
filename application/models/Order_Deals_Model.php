<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_Deals_Model extends Ex_Model
{
    protected $table_name = 'order_deals';
    protected $primary_key = 'id';
    public $where_column= 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getDealsByOrderId($order_id) {
        $m_orderDetails = new Order_details_Model();
        $m_order_side_dish = new Order_side_dish_Model();
        $dealsArray = array();
        $deals = $this->get_by(array('order_id' => $order_id));

        if (!empty($deals)) {
            foreach ($deals as $deal) {
                $itemsArray = array();
                $id = $deal->id;
                $dealsItems = $deal->itemsDetails;
                $dealsItems = (!empty($dealsItems)) ? json_decode($dealsItems,true) : null;

                foreach ($dealsItems as $dealsItem) {
                    $itemProducts = $dealsItem['itemProducts'];
                    $productsArray = array();
                    if (!empty($itemProducts)) {
                        foreach ($itemProducts as $itemProduct) {
                            $subProduct = $itemProduct['subProduct'];
                            $product = $itemProduct['product'];
                            // $modifiers = $itemProduct['modifiers'];
                            $product_id = 0;
                            $selection_item_id = 0;
                            $cat_level = 0;
                            if (!empty($subProduct)) {
                                if (!is_array($subProduct)) {
                                    $subProduct = (array)$subProduct;
                                }
                                $selection_item_id = $subProduct['selectiveItemId'];
                                $product_id = $subProduct['foodItemId'];
                                $cat_level = 4;
                            } else {
                                if (!empty($product)) {
                                    if (!is_array($product)) {
                                        $product = (array)$product;
                                    }
                                    $selection_item_id = 0;
                                    $product_id = $product['foodItemId'];
                                    $cat_level = 3;
                                }
                            }

                            $orderDetails = $m_orderDetails->getForDesktop(array(
                                'order_id'=>$order_id,
                                'order_deals_id'=>$id,
                                'product_id'=>$product_id,
                                'selection_item_id'=>$selection_item_id,
                                'cat_level'=>$cat_level,
                            ),true);

                            $side_dish = array();
                            if (!empty($orderDetails)) {
                                $order_details_id = $orderDetails['id'];
                                $side_dish = $m_order_side_dish->get_by(array('order_id'=>$order_id,'order_details_id'=>$order_details_id,));
                            }

                            $orderDetailsArray = $orderDetails;
                            $orderDetailsArray['side_dish'] = $side_dish;
                            array_push($productsArray,$orderDetailsArray);
                        }
                    }

                    $dealsItem = (array) $dealsItem;
                    if ((array_key_exists('itemProducts',$dealsItem))) {
                        unset($dealsItem['itemProducts']);
                    }
                    $dealsItem['products'] = $productsArray;
                    array_push($itemsArray,(array)$dealsItem);
                }

                $deal = (array)$deal;

                if ((array_key_exists('itemsDetails',$deal))) {
                    unset($deal['itemsDetails']);
                }

                if ((array_key_exists('productText',$deal))) {
                    unset($deal['productText']);
                }

                if ((array_key_exists('dealsDetails',$deal))) {
                    unset($deal['dealsDetails']);
                }

                $deal['items'] = $itemsArray;
                array_push($dealsArray,$deal);
            }
            return $dealsArray;
        }
        return array();
    }
}