<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sell_items_report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Category_Model');
        $this->load->model('Product_model');
        $this->load->helper('product');
    }

    public function index() {
        if (is_user_permitted('admin/sell_items_report/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $from_date = "";
        $to_date = "";
        $category_id = "";
        $product_id = "";
        $products = "";

        $from_date = $this->input->post('from_date');
        if (empty($from_date)){
        	$from_date = date('Y-m-1');
        }
        $to_date = $this->input->post('to_date');
        if (empty($to_date)) {
        	$to_date = date("Y-m-t");
        }
        $category_id = $this->input->post('category_id');
        $product_id = $this->input->post('product_id');

        $this->session->set_userdata('from_date',$from_date);
        $this->session->set_userdata('to_date',$to_date);
        $this->session->set_userdata('category_id',$category_id);
        $this->session->set_userdata('product_id',$product_id);

        if (is_array($category_id) && in_array('all', $category_id)) {
        	$category_id = $this->Category_Model->get_all_category_ids();
        }

        if (is_array($category_id)) {
            $category_id = implode(',', $category_id);
        }

        if (is_array($product_id) && in_array('all', $product_id)) {
        	$product_id = $this->Product_model->get_all_product_ids_by_category_id($category_id);
        }

        if (is_array($product_id)) {
            $product_id = implode(',', $product_id);
        }

        $categories = $this->Category_Model->get_all_category();
        if ($category_id) {
        	$products = $this->Product_model->get_all_products_by_category_id($category_id);
        }

        $reports = $this->Order_details_Model->get_sell_item_report($from_date,$to_date,$category_id,$product_id);

        $this->page_content_data['title'] = "Sale Items Report";
        $this->page_content_data['from_date'] = $from_date;
        $this->page_content_data['to_date'] = $to_date;
        $this->page_content_data['categories'] = $categories;
        $this->page_content_data['products'] = $products;
        $this->page_content_data['reports'] = $reports;
        $this->page_content = $this->load->view('admin/sell_items_report/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/sell_items_report/index_js','',true);

        $this->data['title'] = "Sale Items Report";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_products_by_category_id() {
    	$category_id = $this->input->post('category_id');
        if (is_array($category_id) && in_array('all', $category_id)) {
            $category_id = $this->Category_Model->get_all_category_ids();
        }

        if (is_array($category_id)) {
            $category_id = implode(',', $category_id);
        }

    	$products = $this->Product_model->get_all_products_by_category_id($category_id);
    	$this->data['products'] = $products;
    	$output = $this->load->view('admin/sell_items_report/product_select_option',$this->data,true);

    	$this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }
}