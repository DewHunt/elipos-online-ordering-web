<?php

class Admin_Controller extends Ex_Controller {
    public $data = array();
    public $admin = "admin";
    public $redirect_after_login = '';
    public function __construct() {
        parent::__construct();
        $this->load->model('Settings_Model');
        $this->load->helper('settings');
        $this->load->helper('product');
        $this->load->model('Product_Size_Model');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('cms');

        if (!$this->User_Model->loggedin()) {
            redirect('admin/Login');
        }
    }
}