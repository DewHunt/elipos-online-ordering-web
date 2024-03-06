<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public $product;

    public function __construct()
    {
        parent:: __construct();
        $this->load->library('product');
        $this->load->library('cart');
        $this->load->helper('form');
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->data['is_valid_postcode'] = false;
    }

    public function index()
    {
        $this->data['price'] = 0;
        $this->data['quantity'] = 0;
        $this->data['product_object'] = $this->product;
        //$this->data['product_cart'] = $this->load->view('cart/index', $this->data, true);
        $this->data['title'] = "";
        $this->load->view('header',$this->data);
        $this->load->view('navigation_1');
        $this->load->view('customer', $this->data);
        $this->load->view('footer');
    }
    

}
