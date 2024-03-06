<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('Sidedishes_Model');
    }

    public function insert() {
    	// $data = {"SideDishesId":45,"ModifierCategoryId":41,"SideDishesName":"api test modifier","UnitPrice":3,"VatRate":2,"Unit":"Pics","SortOrder":1,"OptionsColor":"#FF0000","ButtonHight":100,"ButtonWidth":100,"FontSetting":"Arial,Bold,12","Forecolor":"#008000"}
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			$form_data = json_decode($data);
        		$ModifierCategoryId = $form_data->ModifierCategoryId;
        		$SideDishesName = $form_data->SideDishesName;

            	$modifier_name_exist = $this->Sidedishes_Model->is_exists_modifier_name($SideDishesName,$ModifierCategoryId);
            	if ($modifier_name_exist) {
	            	$response_data = array('status'=>200,'message'=>'This modifier name already exists.');
            	} else {
                	$this->Sidedishes_Model->save($form_data);
	            	$response_data = array('status'=>200,'message'=>'Modifier data saved successfully');
            	}            	
    		} else {
	            $response_data = array('status'=>401,'message'=>'Unauthorized Access');
    		}
        } else {
            $response_data = array('status'=>400,'message'=>'Bad Request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    public function add_or_update() {
        if ($this->input->server('REQUEST_METHOD') =='POST') {
    		$authorized_key = trim($this->input->get_request_header('Authorization'));
    		if (is_auth_key_valid($authorized_key)) {
    			$data = $this->input->post('data');
    			if ($data) {
	    			$form_data = json_decode($data);
	        		$SideDishesName = $form_data->SideDishesName;
	        		$ModifierCategoryId = $form_data->ModifierCategoryId;
	        		$SideDishesId = 0;
	        		if (isset($form_data->SideDishesId)) {
	        			$SideDishesId = $form_data->SideDishesId;
	        		}



                   $current_side_dish=$this->Sidedishes_Model->get_modifier_by_id($SideDishesId);

	    			if (isset($current_side_dish)) {
	    				$is_update = true;
	            		$modifier_name_exist = $this->Sidedishes_Model->is_modifier_name_exist_for_update($SideDishesId,$SideDishesName,$ModifierCategoryId);
	    			} else {
	    				$is_update = false;
	    				$modifier_name_exist = $this->Sidedishes_Model->is_exists_modifier_name($SideDishesName,$ModifierCategoryId);
	    			}
	            	if ($modifier_name_exist) {
		            	$response_data = array('status'=>200,'message'=>'This modifier name already exists.');
	            	} else {
		                // dd($form_data);
		                if ($is_update) {
			                $this->db->where('SideDishesId',$SideDishesId);
			                $this->db->update('sidedishes',$form_data);
			                $message = "Modifier data updated successfully";
		                } else {
                			$this->Sidedishes_Model->save($form_data);
			                $message = "Modifier data saved successfully";
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