<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Device_registration extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Device_Registration_Model');
    }


    public function index() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $registration_id = property_exists($data,'registration_id') ? $data->registration_id : null;
            $customer_id = property_exists($data,'customer_id') ? $data->customer_id : null;
            $platform = property_exists($data,'platform') ? $data->platform : null;
            $version = property_exists($data,'version') ? $data->version : null;
            if (!empty($registration_id)) {
                $registered_device = $this->Device_Registration_Model->get_by_registration_id($registration_id);
                if (!empty($registered_device)) {
                    // update existing one device
                    $update_data = array('customer_id'=>$customer_id,'platform'=>$platform,'version'=>$version,);
                    $is_save = $this->Device_Registration_Model->save($update_data,$registered_device->id);
                    $response_data = array('status'=>200,'is_inserted'=>$is_save,);
                } else {
                    // insert new device
                    $save_data = array(
                        'registration_id'=>$registration_id,
                        'customer_id'=>$customer_id,
                        'platform'=>$platform,
                        'version'=>$version,
                        'intsallation_date'=>get_current_date_time()
                    );
                    $is_save = $this->Device_Registration_Model->register_device($save_data);
                    $response_data = array('status'=>200,'is_inserted'=>$is_save,);
                }
            } else {
                $response_data = array('status'=>200,'is_inserted'=>false,);
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $registration_id = $data->registration_id;
            $customer_id = property_exists($data,'customer_id') ? $data->customer_id : null;
            $is_updated = false;
            if (!empty($registration_id)) {
                $registered_device = $this->Device_Registration_Model->get_by_registration_id($registration_id);
                if (!empty($registered_device)) {
                    // update existing one device
                    if (!empty($customer_id)) {
                        $is_updated = $this->Device_Registration_Model->save(array('customer_id'=>$customer_id),$registered_device->registration_id);
                    }
                    $response_data = array('status'=>200,'is_updated'=>$is_updated,);
                } else {
                    // insert new device
                    $is_save = $this->Device_Registration_Model->register_device(array('registration_id'=>$registration_id,'customer_id'=>$customer_id));
                    $response_data = array('status'=>200,'is_updated'=>$is_save,);
                }
            } else {
                $response_data = array('status'=>200,'is_updated'=>$is_updated,);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}