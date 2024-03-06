<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_public_data extends Api_Controller {

    public $product;
    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('postcode_helper');
        $this->load->helper('shop_helper');
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Shop_timing_Model');
        $this->load->model('Subscriber_Model');
        $this->load->model('Page_Settings_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Shop_timing_Model');
    }

    public function get_data() {
    	if ($this->input->SERVER('REQUEST_METHOD') == 'GET') {
    		return get_public_data();
    	}
    }
}