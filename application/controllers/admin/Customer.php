<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends Admin_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('New_order_Model');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');
    }

    public function index() {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $customer_list = $this->Customer_Model->get();
        // dd($customer_list);
        $this->page_content_data['customer_list'] = $customer_list;
        $this->page_content = $this->load->view('admin/customer/customer_list',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/customer/customer_list_js','',true);

        $this->data['title'] = "Customer List";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function customer_create() {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        // $this->page_content_data['customer'] = $customer;
        $this->page_content = $this->load->view('admin/customer/customer_create','',true);
        $this->custom_js = $this->load->view('admin/customer/customer_create_js','',true);

        $this->data['title'] = "Add New Customer";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function orders($customer_id = 0) {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $grand_total = 0;
        $customer_id = intval($customer_id);
        $customer = $this->Customer_Model->get($customer_id);
        $m_order = new Order_information_Model();
        $this->Order_information_Model->db->order_by('id','DESC');
        $orders_information = $m_order->get_where('customer_id', $customer->id);
        if ($customer) {
            $grand_total = $m_order->get_customer_grand_total($customer->id);
        }

        $this->page_content_data['customer'] = $customer;
        $this->page_content_data['orders_information'] = $orders_information;
        $this->page_content_data['grand_total'] = $grand_total;
        $this->page_content = $this->load->view('admin/customer/order_list',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/customer/order_list_js','',true);

        $this->data['title'] = "View Order";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function insert() {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $form_data = $this->Customer_Model->data_form_post(array('title', 'first_name', 'last_name', 'email', 'telephone', 'mobile', 'billing_address_line_1', 'billing_address_line_2', 'billing_city', 'billing_postcode', 'delivery_address_line_1', 'delivery_address_line_2', 'delivery_city', 'delivery_postcode'));

        if (empty($form_data['first_name'])) {
            $this->session->set_flashdata('first_name_error_message', ' First Name is required');
            redirect('admin/customer/customer_create');
        }

        $telephone = trim($this->input->post('telephone'));
        $mobile = trim($this->input->post('mobile'));

        $mobile_telephone = $this->Customer_Model->data_form_post(array('telephone', 'mobile'));
        $is_mobile_telephone_exist = false;
        if ((empty($mobile_telephone['telephone']) && (!empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else if ((!empty($mobile_telephone['telephone']) && (empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else if ((!empty($mobile_telephone['telephone']) && (!empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else {
            $is_mobile_telephone_exist = false;
            $this->session->set_flashdata('common_number_error_message', ' Either Mobile number Or telephone Number is required');
        }

        if ($is_mobile_telephone_exist == false) {
            redirect('admin/customer/customer_create');
        }

        $is_telephone_or_mobile_exist_check = $this->Customer_Model->is_telephone_or_mobile_exist(!empty($telephone), !empty($mobile));
        if ($is_telephone_or_mobile_exist_check) {
            $this->Customer_Model->where_column = 'id';
            $result = $this->Customer_Model->save($form_data, $is_telephone_or_mobile_exist_check->id);
            redirect('admin/customer');
        } else {
            $result = $this->Customer_Model->save($form_data);
            redirect('admin/customer');
        }
    }

    public function customer_update($id = 0) {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $customer = $this->Customer_Model->get($id, true);
        if (empty($customer)) {
            redirect('admin/customer');
        }

        $this->page_content_data['customer'] = $customer;
        $this->page_content = $this->load->view('admin/customer/customer_update',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/customer/customer_update_js','',true);

        $this->data['title'] = "View Order";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $form_data = $this->Customer_Model->data_form_post(array('title', 'first_name', 'last_name', 'email', 'telephone', 'mobile', 'billing_address_line_1', 'billing_address_line_2', 'billing_city', 'billing_postcode', 'delivery_address_line_1', 'delivery_address_line_2', 'delivery_city', 'delivery_postcode'));

        if (empty($form_data['first_name'])) {
            $this->session->set_flashdata('first_name_error_message', ' First Name is required');
            redirect('admin/customer/customer_update/'.$id);
        }

        $id = trim($this->input->post('id'));
        $telephone = trim($this->input->post('telephone'));
        $mobile = trim($this->input->post('mobile'));

        $mobile_telephone = $this->Customer_Model->data_form_post(array('telephone', 'mobile'));
        $is_mobile_telephone_exist = false;
        if ((empty($mobile_telephone['telephone']) && (!empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else if ((!empty($mobile_telephone['telephone']) && (empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else if ((!empty($mobile_telephone['telephone']) && (!empty($mobile_telephone['mobile'])))) {
            $is_mobile_telephone_exist = true;
        } else {
            $is_mobile_telephone_exist = false;
            $this->session->set_flashdata('common_number_error_message', ' Either Mobile number Or telephone Number is required');
        }

        if ($is_mobile_telephone_exist == false) {
            redirect('admin/customer/customer_update/' . $id);
        }

        $is_telephone_exist_check_for_update = $this->Customer_Model->is_telephone_exist_check_for_update(!empty(trim($telephone)), $id);
        $is_mobile_exist_check_for_update = $this->Customer_Model->is_mobile_exist_check_for_update(!empty(trim($mobile)), $id);

        if ($is_mobile_exist_check_for_update) {
            $this->session->set_flashdata('mobile_error_message', ' Mobile Already Exists');
            redirect('admin/customer/customer_update/'.$id);
        }

        $this->Customer_Model->where_column = 'id';
        $result = $this->Customer_Model->save($form_data, $id);
        redirect('admin/customer');
    }

    public function delete($id) {
        if (is_user_permitted('admin/customer') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->Customer_Model->delete($id);
        redirect('admin/customer');
    }
}
