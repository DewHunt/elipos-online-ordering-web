<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'libraries/REST_Controller.php';
class Modifiers extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        // $this->load->model('Customer_Model');
        // $this->load->model('Selectionitems_Model');
        // $this->load->model('Deals_Item_Model');
        // $this->load->model('Deals_Model');
        // $this->load->model('Modifier_Category_Model');
        // $this->load->model('FreeItem_Model');
        // $this->load->model('Buy_and_get_model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->library('product');
    }

    public function get_modifiers() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $category_id = $data->categoryId;
            $product_id = $data->productId;
            $sub_product_id = $data->subProductId;
	        $first_condition = array('showsidedish.CategoryId'=>$category_id,'showsidedish.ProductLevel'=>1,);
	        $second_condition = array('showsidedish.CategoryId'=>$product_id,'showsidedish.ProductLevel'=>2,);
	        $third_condition = array('showsidedish.CategoryId'=>$sub_product_id,'showsidedish.ProductLevel'=>3,);

	        $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($third_condition);
	        if (empty($show_side_dishes)) {
	        	$show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($second_condition);
	        	if (empty($show_side_dishes)) {
	        		$show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($first_condition);
	        	}
	        }
	        $modifiers_array = array();
	        foreach ($show_side_dishes as $side_dish) {
	        	$side_dishes = $this->Sidedishes_Model->get_by_modifier_category_id($side_dish->ModifierCategoryId);
	        	$side_dish->limit = $side_dish->ModifierLimit;
	        	$side_dish->freeLimit = 0;
	        	$side_dish->SideDishes = $side_dishes;
	        }
            // dd($show_side_dishes);

            $response_data = array('status'=>200,'message'=>'Side Dishes is provided','data'=>$show_side_dishes,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_show_side_dishes() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $category_id = $data->categoryId;
            $product_id = $data->productId;
            $sub_product_id = $data->subProductId;
            $first_condition = array('showsidedish.CategoryId'=>$category_id,'showsidedish.ProductLevel'=>1,);
            $second_condition = array('showsidedish.CategoryId'=>$product_id,'showsidedish.ProductLevel'=>2,);
            $third_condition = array('showsidedish.CategoryId'=>$sub_product_id,'showsidedish.ProductLevel'=>3,);

            $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($third_condition);
            if (empty($show_side_dishes)) {
                $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($second_condition);
                if (empty($show_side_dishes)) {
                    $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($first_condition);
                }
            }
            // dd($show_side_dishes);

            $response_data = array('status'=>200,'message'=>'Side Dishes is provided','data'=>$show_side_dishes,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_assigned_show_side_dish() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $category_id = $data->categoryId;
            $product_id = $data->productId;
            $sub_product_id = $data->subProductId;
            $modifier_category_id = $data->modifierCategoryId;
            $first_condition = array(
                'showsidedish.CategoryId'=>$category_id,
                'showsidedish.ProductLevel'=>1,
                'showsidedish.SideDishId'=>$modifier_category_id
            );
            $second_condition = array(
                'showsidedish.CategoryId'=>$product_id,
                'showsidedish.ProductLevel'=>2,
                'showsidedish.SideDishId'=>$modifier_category_id
            );
            $third_condition = array(
                'showsidedish.CategoryId'=>$sub_product_id,
                'showsidedish.ProductLevel'=>3,
                'showsidedish.SideDishId'=>$modifier_category_id
            );

            $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($third_condition);
            if (empty($show_side_dishes)) {
                $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($second_condition);
                if (empty($show_side_dishes)) {
                    $show_side_dishes = $this->Showsidedish_Model->get_assigned_modifiers($first_condition);
                }
            }
            // dd($show_side_dishes);

            $response_data = array('status'=>200,'message'=>'Side Dishes is provided','data'=>$show_side_dishes,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}
