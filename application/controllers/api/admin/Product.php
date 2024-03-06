<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Fooditem_Model');
    }

    public function add_or_update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
				$data = $this->input->post('data');

				if ($data) {
					$form_data = json_decode($data);
		        	$foodItemName = $form_data->foodItemName;
	    			$foodItemId = 0;
	    			if (isset($form_data->foodItemId)) {
	    				$foodItemId = $form_data->foodItemId;
	    			}
	    			
	    			$current_product= $this->Fooditem_Model->get_product_by_id($foodItemId);
	    			
	    			if (isset($current_product)) {
	    				$is_update = true;
		            	$product_name_exist = $this->Fooditem_Model->is_product_name_exist_for_update($current_product->foodItemId,$foodItemName);
	    			} else {
	    				$is_update = false;
            			$product_name_exist = $this->Fooditem_Model->is_product_name_exist($foodItemName);
	    			}
	    			
	            	if ($product_name_exist) {
		            	$response_data = array('status'=>200,'message'=>'This product name already exists.');
	            	} else {
		                // dd($form_data);
		                if ($is_update) {
			                $this->db->where('foodItemId',$foodItemId);
			                $this->db->update('fooditem',$form_data);
			            	$message = "Product data updated successfully";
		                } else {
		                	$this->Fooditem_Model->save($form_data);
			            	$message = "Product data saved successfully";
		                }
		                
		            	$response_data = array('status'=>200,'message'=>$message);
	            	}            	
				} else {
	            	$response_data = array('status'=>200,'message'=>'Data not provided');
				}				
    		} else {
	            $response_data = array('status'=>401,'message'=>'Unauthorized Access');
    		}
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    public function active_or_deactive_status() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			if ($data) {
	    			$form_data = json_decode($data);
	    			if (isset($form_data->foodItemId)) {
	    				$foodItemId = $form_data->foodItemId;
		                $this->db->where('foodItemId',$foodItemId);
		                $this->db->update('fooditem',$form_data);
		                $message = "Product data updated successfully";
		            	$response_data = array('status'=>200,'message'=>$message);
	    			} else {
	            		$response_data = array('status'=>200,'message'=>'Product id not provided');
	    			}
    			} else {
	            	$response_data = array('status'=>200,'message'=>'Data not provided');
    			}    			
    		} else {
	            $response_data = array('status'=>401,'message'=>'Unauthorized Access');
    		}
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }
}
