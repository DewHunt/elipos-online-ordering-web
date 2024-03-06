<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'libraries/REST_Controller.php';

class Payment extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Settings_Model');
        $this->load->helper('settings');
    }
    
    public function index() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $payment_settings = get_payment_settings();
            $response_data = array('status'=>200,'message'=>'All settings ','data'=>$payment_settings,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function stripe() {
        $this->load->library('StripePaymentGateway');
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $stripe = new StripePaymentGateway();
            $total = property_exists($data,'amount') ? $data->amount : 0;
            $token = property_exists($data,'token') ? $data->token : '';
            log_message('error',$request_body);
            $customer_email = property_exists($data,'customer_email')?$data->customer_email:'';
            $data_array = array();
            $data_array['token'] = $token;
            $data_array['email'] = $customer_email;
            $data_array['description'] = get_company_name().' order payment';
            $data_array['amount'] = round($total,2);
            $order_information_save_result = false;
            $message = $stripe->chargeWithToken($data_array);
            $payment_message = '';
            //Order Information Insertion
            $payment_message = 'Payment Success';
            if($message == 'succeeded'){
                $payment_message = 'Payment Success';
                $response_data = array('status'=>200,'message'=>$message,'is_payed'=>true,);
            } else {
                $payment_message = 'Payment Unsuccessful';
                $response_data = array('status'=>200,'message'=>$message,'is_payed'=>false,);
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function paypal() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->load->library('PayPalPaymentGateway');
            $lib_paypal = new PayPalPaymentGateway();
            $lib_paypal->client_id;
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $stripe = new StripePaymentGateway();
            $stripe_details = $data->cardDetails;
            $total = $data->amount;
            $number = trim($stripe_details->number);
            $exp_month = trim($stripe_details->expMonth);
            $exp_year = trim($stripe_details->expYear);
            $cvc = trim($this->input->post($stripe_details->cvc));
            $data_array = array();
            $data_array['number'] = $number;
            $data_array['exp_month'] = $exp_month;
            $data_array['exp_year'] = $exp_year;
            $data_array['cvc'] = $cvc;
            $data_array['amount'] = $total;

            $order_information_save_result = false;
            $message = $stripe->charge($data_array);
            $payment_message = '';
            //Order Information Insertion
            $payment_message = 'Payment Success';
            if ($message == 'succeeded') {
                $payment_message = 'Payment Success';
                $response_data = array('status'=>200,'message'=>$message,'is_payed'=>true,'message'=>$payment_message,);
            } else {
                $payment_message = 'Payment Unsuccessful';
                $response_data = array('status'=>200,'message'=>$message,'is_payed'=>false,'message'=>$payment_message,);
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}