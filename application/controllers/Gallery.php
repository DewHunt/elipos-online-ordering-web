<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Frontend_Controller {

    public $product;
    public function __construct()
    {
        parent:: __construct();
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
    }

    public function index()
    {
        $this->data['title'] = "Gallery";
        $this->page_content=$this->load->view('gallery/gallery', $this->data,true);
        $this->load->view('index', $this->data);
    }
}
