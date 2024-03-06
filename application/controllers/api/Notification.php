<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends Api_Controller {
    public function __construct() {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent:: __construct();
        $this->load->model('Customer_Notification_Model');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $request_header = getallheaders() ;
            // $request_body = file_get_contents('php://input');
            // $data = json_decode($request_body);
            $authorization = array_key_exists("Authorization",$request_header) ? $request_header['Authorization'] : '';
            $m_customer_notification = new Customer_Notification_Model();
            $notifications = $m_customer_notification->get_api_customer_notification();
            if (!empty($authorization)) {
                $value = "BombayJoesUk";
                $authorization = base64_decode($authorization);
                if ($authorization == $value) {
                    // get notification
                    $this->output->set_content_type('application/json')->set_output(json_encode(array('notifications'=>$notifications)));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(array('Authorization'=>'UnAuthorised','notifications'=>null)));
                }
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('notifications'=>$notifications)));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}