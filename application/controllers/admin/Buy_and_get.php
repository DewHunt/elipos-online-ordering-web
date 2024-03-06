<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_and_get extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Deals_Model');
        $this->load->model('Deals_Item_Model');
        $this->load->model('Category_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Buy_and_get_model');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');
    }

    public function index() {
        if (is_user_permitted('admin/buy_and_get') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Buy X Get Y";
        $this->page_content_data['buy_get_list'] = $this->Buy_and_get_model->get_all_buy_and_get();
        $this->page_content = $this->load->view('admin/menu/buy_and_get/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/menu/buy_and_get/index_js',$this->page_content_data,true);

        $this->data['title'] = "Buy X Get Y | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Buy X Get Y";
        $this->page_content_data['items_by_category'] = $this->Buy_and_get_model->get_items_by_category();
        $this->page_content = $this->load->view('admin/menu/buy_and_get/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/buy_and_get/add_js',$this->page_content_data,true);

        $this->data['title'] = "Buy X Get Y | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$category_item_list = $this->input->post('category_item_list');
    	$category_item_id_list = $this->get_category_and_item_id_list($category_item_list);

        $start_date = strtotime($this->input->post('start_date'));
        $end_date = strtotime($this->input->post('end_date'));
        $datediff = $end_date - $start_date;
        $totalDays =  round($datediff / (60 * 60 * 24)) + 1;
        $availability = $this->input->post('availability');
        if ($availability) {
            $availability = implode(',', $availability);
        }

        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'category_id' => $category_item_id_list['db_category_id_array'],
            'item_id' => $category_item_id_list['db_item_id_array'],
            'buy_qty' => $this->input->post('but_qty'),
            'get_qty' => $this->input->post('get_qty'),
            'order_type' => $this->input->post('order_type'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'validity_days' => $totalDays,
            'availability' => $availability,
            'status' => $this->input->post('status'),
        );

        $this->db->insert('buy_and_get',$data);
		$this->session->set_flashdata('message', 'Buy X Get Y Offer Saved Successfully.');
		redirect(base_url('admin/buy_and_get'));  	
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Edit Buy X Get Y";
    	$this->page_content_data['buy_get_info'] = $this->Buy_and_get_model->buy_get_info_by_id($id);
        $this->page_content_data['items_by_category'] = $this->Buy_and_get_model->get_items_by_category();
        $this->page_content = $this->load->view('admin/menu/buy_and_get/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/buy_and_get/edit_js',$this->page_content_data,true);

        $this->data['title'] = "Buy X Get Y | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	// echo "<pre>"; print_r($this->input->post()); exit();
    	$category_item_list = $this->input->post('category_item_list');
    	$category_item_id_list = $this->get_category_and_item_id_list($category_item_list);

        $start_date = strtotime($this->input->post('start_date'));
        $end_date = strtotime($this->input->post('end_date'));
        $datediff = $end_date - $start_date;
        $totalDays =  round($datediff / (60 * 60 * 24)) + 1;
        $availability = $this->input->post('availability');
        if ($availability) {
            $availability = implode(',', $availability);
        }

        $id = $this->input->post('buy_get_id');
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'category_id' => $category_item_id_list['db_category_id_array'],
            'item_id' => $category_item_id_list['db_item_id_array'],
            'buy_qty' => $this->input->post('but_qty'),
            'get_qty' => $this->input->post('get_qty'),
            'order_type' => $this->input->post('order_type'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'validity_days' => $totalDays,
            'availability' => $availability,
            'status' => $this->input->post('status'),
        );

        $this->db->where('id',$id);
        $this->db->update('buy_and_get',$data);
		$this->session->set_flashdata('save_message', 'Buy X Get Y Offer Updated Successfully.');
		redirect(base_url('admin/buy_and_get'));  	
    }

    public function get_category_and_item_id_list($category_item_list) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	sort($category_item_list);
    	$current_category_id = 0;
		$db_category_id_array = array();
		$db_item_id_array = array();
		$temp_item_array = array();

    	foreach ($category_item_list as $cat_item) {
    		$cat_item = explode(',',$cat_item);
    		$category_id = $cat_item[0];
    		$item_id = $cat_item[1];

    		if ($category_id != $current_category_id) {
    			$current_category_id = $category_id;
    			$total_item_id = $this->Buy_and_get_model->count_total_item_by_category($category_id);
    			$item_id_count = 1;
    			if ($db_item_id_array) {
    				$temp_item_array = $db_item_id_array;
    			}
    		} else {
    			$item_id_count++;
    		}

    		if ($total_item_id == $item_id_count) {
    			array_push($db_category_id_array,$category_id);
				$db_item_id_array = array();
    		} else {
    			if (empty($db_item_id_array)) {
    				$db_item_id_array = $temp_item_array;
    			}
    			array_push($db_item_id_array,$item_id);
    		}        		
    	}

		if ($temp_item_array) {
			if ($db_item_id_array) {
				$db_item_id_array = array_replace($db_item_id_array,$temp_item_array);
			}
			else {
				$db_item_id_array = $temp_item_array;
			}
		}

		$result_array = array(
			'db_category_id_array' => implode(',',$db_category_id_array),
			'db_item_id_array' => implode(',',$db_item_id_array),
		);

		return $result_array;
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$this->db->delete('buy_and_get', array('id' => $id));
        redirect( 'admin/buy_and_get');
    }
}
