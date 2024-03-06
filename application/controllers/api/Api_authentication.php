<?php
class Api_authentication extends ApiAdmin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('shop_helper');
        $this->load->helper('settings');
        $this->load->helper('jwt_helper');
        $this->load->model('Settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('Shop_timing_Model');
        // $this->Settings_Model->where_column = 'name';
    }

    public function index() {
    	// dd($this->get_jwt_token());
    	dd($this->get_decoded_jwt_token('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmdWxsX25hbWUiOiJFbGlwb3MiLCJ1c2VyX25hbWUiOiJlbGlwb3MiLCJ1c2VyX2VtYWlsIjoiZWxpcG9zQGdtYWlsLmNvbSIsInVzZXJfaWQiOiIxOSIsInVzZXJfcm9sZSI6IjEiLCJ1c2VyX2xvZ2dlZGluIjp0cnVlfQ.zkXPOWyCQ-12MfWovNBZcRhe_eD9UlQ0CNdK8r6Bn5U'));
    	dd($this->get_decoded_jwt_token('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiNDIwIiwiZW1haWwiOiJkZXZlbG9wZXJAZ21haWwuY29tIiwidXNlcl90eXBlIjoiYWRtaW4ifQ.Xd3Hp0903vXhd41MeoDviqC6hLytR9HMgNczeVwlrI'));
    }

    public function get_jwt_token($data = '') {
    	$jwt = new JWT();
    	$jwt_secrect_key = "VitalInformationResourcesUnderSeize";
    	$token = '';
    	if ($data) {
    		$token = $jwt->encode($data,$jwt_secrect_key,'HS256');
    	}
    	return $token;
    }

    public function get_decoded_jwt_token($token = '') {
    	$jwt = new JWT();
    	$jwt_secrect_key = "VitalInformationResourcesUnderSeize";
    	// $decode_data = $jwt->decode($token,$jwt_secrect_key,'HS256');
    	$decode_data = $jwt->decode($token,$jwt_secrect_key);
    	return $decode_data;
    }

    public function login() {
    	if ($this->checkMethod('POST')) {
    		$data = $this->input->post('data');
    		if ($data) {
    			$data = json_decode($data);
    			$name_or_email = $data->name_or_email;
    			$password = sha1($data->password);
    			if ($name_or_email && $password) {
    				if (filter_var($name_or_email, FILTER_VALIDATE_EMAIL)) {
    					$this->db->where('email',$name_or_email);
					} else {
						$this->db->where('user_name',$name_or_email);
					}
					$this->db->select('*');
					$this->db->from('user');
					$this->db->where('password',$password);

					$query = $this->db->get();
					if ($query->num_rows() > 0) {
						$user_info = $query->row();
						$start_time = strtotime(date("Y-m-d H:i:s"));
						$end_time = $start_time + 60 * 60 * 24 * 30;
			            $login_data = array(
			                'full_name' => $user_info->name,
			                'user_name' => $user_info->user_name,
			                'user_email' => $user_info->email,
			                'user_id' => $user_info->id,
			                'user_role' => $user_info->role,
			                'user_loggedin' => true,
			                'start_time' => $start_time,
			                'end_time' => $end_time,
			            );
			            $token = $this->get_jwt_token($login_data);
						// dd($token);
                		$responseData = array('token'=>$token,'login_info'=>$login_data);
					} else {
                		$responseData = array('status'=>404,'message'=>'User Not Found');
					}					
    			} else {
                	$responseData = array('status'=>400,'message'=>'Bad Request');
    			}    			
    		} else {
                $responseData = array('status'=>400,'message'=>'Bad Request');
    		}
    		$this->output->set_content_type('application/json')->set_output(json_encode($responseData,JSON_NUMERIC_CHECK));
    	}
    }
}