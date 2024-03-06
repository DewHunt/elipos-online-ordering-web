<?php

class Frontend_Controller extends Ex_Controller
{
    public $data = array();
    public $order_type='collection';
    public $payment_method='cash';
    public $banner_slider='';
    public $footer='';
    public $page_content='';
    public $page_title="Impressive Selection <span>for any Occasion</span>";
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Europe/London');
        $this->load->model('Settings_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->helper('security');
        $this->load->helper('settings');
        $this->load->helper('product');
        $this->load->helper('shop');
        $this->load->helper('order');
        $this->session->set_userdata('last_page', current_url());
        $this->order_type=get_order_type();
        $this->payment_method=get_payment_method();

    }
}