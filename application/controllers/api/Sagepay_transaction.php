<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sagepay_transaction extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('curl');
        $this->load->helper('settings');
        $this->load->model('Customer_Model');
        $this->load->model('Sagepay_transaction_model');
    }

    public function get_transaction_info() {
        $response_data = array('status'=>400,'message'=>'Bad request');
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $post_data = json_decode($request_body);
            $customer_id = $post_data->customerId;
            $result = $this->Sagepay_transaction_model->get_by_customer_id($customer_id);
            $response_data = array('status'=>200,'transactionInfo'=>$result);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));        
    }
}