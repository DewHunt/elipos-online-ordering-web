<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_product extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Selectionitems_Model');
    }

    public function add_or_update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			if ($data) {
	    			$form_data = json_decode($data);
	        		$selectiveItemName = $form_data->selectiveItemName;
	    			$selectiveItemId = 0;
	    			if ($form_data->selectiveItemId) {
	    				$selectiveItemId = $form_data->selectiveItemId;
	    			}
	    			
	    			
	    			$current_sub_product=$this->Selectionitems_Model->get_sub_product_by_id($selectiveItemId);
	    			
	    			if (isset($current_sub_product)) {
	    				$is_update = true;
	            		$sub_product_name_exist = $this->Selectionitems_Model->is_sub_product_name_exist_for_update($current_sub_product->selectiveItemId,$selectiveItemName);
	    			} else {
	    				$is_update = false;
            			$sub_product_name_exist = $this->Selectionitems_Model->is_sub_product_name_exist($selectiveItemName);
	    			}

	            	if ($sub_product_name_exist) {
		            	$response_data = array('status'=>200,'message'=>'This sub-product name already exists.');
	            	} else {
	            		if ($is_update) {
			                $this->db->where('selectiveItemId',$selectiveItemId);
			                $this->db->update('selectionitems',$form_data);
			                $message = "Sub-product data updated successfully";
	            		} else {
                			$this->Selectionitems_Model->save($form_data);
			                $message = "Sub-product data saved successfully";
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
}
