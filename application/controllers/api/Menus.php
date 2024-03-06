<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'libraries/REST_Controller.php';
class Menus extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Deals_Item_Model');
        $this->load->model('Deals_Model');
        $this->load->model('Modifier_Category_Model');
        $this->load->model('FreeItem_Model');
        $this->load->model('Buy_and_get_model');
        $this->load->model('Sidedishes_Model');
        $this->load->library('product');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $product_object = new Product();

            $categories = $product_object->get_categories_menu_by_flags();
            $currentDayName = strtolower(date('l'));
            $categories_array = array();
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $category_id = $category->categoryId;
                    $category_array = array();
                    $category_array = (array) $category;
                    $availabilities = explode(',',$category->availability);
                    if (in_array($currentDayName,$availabilities)) {
                        $buy_get_for_category = $this->Buy_and_get_model->get_buy_get_for_all_menus($category_id);
                        $buy_get_for_category_array = array();
                        if ($buy_get_for_category) {
                            $buy_get_for_category_array = array(
                                'buy_get_id'=>$buy_get_for_category->id,
                                'buy_qty'=>$buy_get_for_category->buy_qty,
                                'get_qty'=>$buy_get_for_category->get_qty,
                                'buy_get_order_type'=>$buy_get_for_category->order_type,
                            );
                        }
                        $category_array['buy_and_get'] = $buy_get_for_category_array;

                        if ($category->isPackage) {
                            $category_array['packages'] = $this->Deals_Model->getDealsItemByCategory($category);
                            $category_array['products'] = null;
                        } else {
                            $products = $product_object->get_products_menu_by_flags($category_id);
                            $products_array = array();
                            if (!empty($products)) {
                                $product_array = array();
                                $i = 0;
                                foreach ($products as $product) {
                                    $availabilities = explode(',',$product->availability);
                                    if (in_array($currentDayName,$availabilities)) {
                                        $product_id = $product->foodItemId;
                                        $product_array = json_decode(json_encode($product),true);
                                        
                                        $buy_get_for_product = $this->Buy_and_get_model->get_buy_get_for_all_menus(0,$product_id);
                                        $buy_get_for_product_array = array();
                                        if ($buy_get_for_product) {
                                            $buy_get_for_product_array = array(
                                                'buy_get_id'=>$buy_get_for_product->id,
                                                'buy_qty'=>$buy_get_for_product->buy_qty,
                                                'get_qty'=>$buy_get_for_product->get_qty,
                                                'buy_get_order_type'=>$buy_get_for_product->order_type,
                                            );
                                        }
                                        $product_array['buy_and_get'] = $buy_get_for_product_array;

                                        $sub_products = $product_object->get_sub_product($product_id);
                                        $sub_products_array = array();
                                        if (!empty($sub_products)) {
                                            $sub_products_array = json_decode(json_encode($sub_products),true);
                                        }
                                        $product_array['has_sub_product'] = (!empty($sub_products_array)) ? 1 : 0;
                                        $product_array['sub_products'] = $sub_products_array;
                                        array_push($products_array,$product_array);
                                    }
                                }
                            }
                            // set all products
                            $category_array['products'] = $products_array;
                            $category_array['packages'] = null;
                        }
                        array_push($categories_array,$category_array);
                    }
                }
            }

            $dealsCategories = $product_object->get_deals_categories_menu_by_flags();
            $dealsCategoriesArray = array();
            if (!empty($dealsCategories)) {
                foreach ($dealsCategories as $dealsCategory) {
                    $availabilities = explode(',',$dealsCategory->availability);
                    if (in_array($currentDayName,$availabilities)) {
                        $dealsCategoryArray = array();
                        if ($dealsCategory->isDeals) {
                            $dealsArray = $this->Deals_Model->getDealsItemByCategory($dealsCategory);
                            $dealsCategoryArray = (array)$dealsCategory;
                            $dealsCategoryArray['deals'] = $dealsArray;
                        }
                        array_push($dealsCategoriesArray,$dealsCategoryArray);
                    }
                }
            }

            $allAssignedModifiersAsProductCategory = $this->Showsidedish_Model->get_all_assigned_modifiers_as_product_categories();
            $showSideDish = $this->Showsidedish_Model->get();
            $allSideDishesAsModifierCategory = $this->Sidedishes_Model->getAllAsModifierCategories();
            $modifiersCategories = $this->Modifier_Category_Model->get_all();
            $freeItemsDetails = $this->FreeItem_Model->getFreeItemDetailsForApi();
            $data = array(
                'categories'=>$categories_array,
                'dealsName'=>$product_object->get_offers_or_deals_name(),
                'dealsCategories'=>(!empty($dealsCategoriesArray)) ? $dealsCategoriesArray : null,
                'showSideDishes'=>$showSideDish,
                'modifiersCategories'=>$modifiersCategories,
                'allSideDishesAsModifierCategory'=>$allSideDishesAsModifierCategory,
                'freeItemsDetails' => $freeItemsDetails,
            );

            $response_data = array('status'=>200,'message'=>'Menu data is provided','data'=>$data,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));

        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}
