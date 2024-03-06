<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Api_Controller {
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
        $this->load->model('Fooditem_Model');
        $this->load->model('Category_Model');
        $this->load->library('product');
    }

    public function get_all_menu() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
	            $m_deals = new Deals_Model();
	            $m_show_side_dish = new Showsidedish_Model();
	            $product_object = new Product();

	            $request_body = file_get_contents('php://input');
	            $data = json_decode($request_body);

	            $categories = $this->Category_Model->get_all_category();
	            $categories_array = array();
	            if (!empty($categories)) {
	                foreach ($categories as $category) {
	                    $category_id = $category->categoryId;
	                    $category_array = array();
	                    $category_array = (array) $category;
                        if ($category->isPackage) {
                            $category_array['packages'] = $m_deals->getDealsItemByCategory($category);
                            $category_array['products'] = null;
                        } else {
                            $products = $this->Fooditem_Model->get_all_products_by_category_id($category_id);
                            $products_array = array();
                            if (!empty($products)) {
                                $product_array = array();
                                $i = 0;
                                foreach ($products as $product) {
                                    $product_id = $product->foodItemId;
                                    $product_array = json_decode(json_encode($product),true);

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
                            // set all products
                            $category_array['products'] = $products_array;
                            $category_array['packages'] = null;
                        }
                        array_push($categories_array,$category_array);
	                }
	            }

	            $allSideDishesAsModifierCategory = $this->Sidedishes_Model->getAllAsModifierCategories();
	            $modifiersCategories = $this->Modifier_Category_Model->get_all();
            	$showSideDish = $this->Showsidedish_Model->get();
	            $data = array(
	                'categories'=>$categories_array,
	                'modifiersCategories'=>$modifiersCategories,
	                'showSideDishes'=>$showSideDish,
	                'allSideDishesAsModifierCategory'=>$allSideDishesAsModifierCategory,
	            );

	            $response_data = array('status'=>200,'message'=>'Menu data is provided','data'=>$data,);
    		} else {
	            $response_data = array('status'=>401,'message'=>'Unauthorized Access');
    		}
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data,JSON_NUMERIC_CHECK));
    }
}
