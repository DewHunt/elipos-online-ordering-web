<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier_category extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Modifier_Category_Model');
    }

    public function add_or_update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			if ($data) {
	    			$form_data = json_decode($data);
		        	$ModifierCategoryName = $form_data->ModifierCategoryName;
	    			$ModifierCategoryId = 0;
	    			
	    					$current_modifier_category= $this->Modifier_Category_Model->get_modifier_category_by_id($form_data->ModifierCategoryId);
	    			
	    	
	    			if (isset($form_data->ModifierCategoryId)) {
	    				$ModifierCategoryId = $form_data->ModifierCategoryId;
	    			}
	    			$modifier_category_name_exist = $this->Modifier_Category_Model->is_modifier_category_name_exists($ModifierCategoryName,$ModifierCategoryId);
	            	if ($modifier_category_name_exist) {
		            	$response_data = array('status'=>200,'message'=>'This modifier category name already exists.');
	            	} else {
		    			if (isset($current_modifier_category) && $current_modifier_category->ModifierCategoryId > 0) {
			                $this->db->where('ModifierCategoryId',$ModifierCategoryId);
			                $this->db->update('modifier_category',$form_data);
			                $message = "Modifier category data updated successfully";
		    			} else {
                			$this->Modifier_Category_Model->save($form_data);
			                $message = "Modifier category data saved successfully";
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