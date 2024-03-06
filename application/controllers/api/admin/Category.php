<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Category_Model');
    }

    public function add_or_update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			
    		//	print_r($data); exit;
    			
    			
    			if ($data) {
	    			$form_data = json_decode($data);
		        	$categoryName = $form_data->categoryName;
	    			$categoryId = 0;
	    			if (isset($form_data->categoryId)) {
	    				$categoryId = $form_data->categoryId;
	    			}

                    $current_category=$this->Category_Model->get_category_by_id($categoryId);


	    			if (isset($current_category)) {
	    				$is_update = true;
		            	$category_name_exist = $this->Category_Model->is_category_name_exist_for_update($current_category->categoryId,$categoryName);
	    			} else {
	    				$is_update = false;
            			$category_name_exist = $this->Category_Model->is_category_name_exist($categoryName);
	    			}

	            	if ($category_name_exist) {
		            	$response_data = array('status'=>200,'message'=>'This category name already exists.');
	            	} else {
	            		if ($is_update) {
			                $this->db->where('categoryId',$categoryId);
			                $this->db->update('category',$form_data);
			                $message = "Category data updated successfully";
	            		} else {
                			$this->Category_Model->save($form_data);
			                $message = "Category data saved successfully";
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
	    			if (isset($form_data->categoryId)) {
	    				$categoryId = $form_data->categoryId;
		                $this->db->where('categoryId',$categoryId);
		                $this->db->update('category',$form_data);
		                $message = "Category data updated successfully";
		            	$response_data = array('status'=>200,'message'=>$message);
	    			} else {
	            		$response_data = array('status'=>200,'message'=>'Category id not provided');
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
