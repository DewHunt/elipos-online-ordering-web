<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Card_Model');
        $this->load->helper('settings');
    }

    public function get_top_selling_product_lists() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $authorization = trim($this->input->get_request_header('Authorization'));
            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);

            if ($authKeyEncode == $authorization) {
                $pending_order = array();
                $pending_order_array = array();

                $request_body = file_get_contents('php://input');
                $data = (!empty($request_body)) ? json_decode($request_body) : null;
                $number_of_products = get_property_value('number_of_products',$data);
                $end_date = date("Y-m-d");
                $start_date = date("Y-m-d", strtotime("-30 days",strtotime($end_date)));
                // dd($end_date);

                $top_product_list = $this->Order_details_Model->get_top_sellings_product_info($number_of_products,$start_date,$end_date);

                if (!empty($top_product_list)) {
                    $message = count($top_product_list) .' product details is given';
                } else {
                    $message = 'Product Not Found';
                }
                
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'productLists' => $top_product_list,
                );
            } else {
                $response_data = array(
                    'status' => 401,
                    'message' => 'Unauthorized',
                    'productLists' => array(),
                );
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }
}