<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Voucher_Model');

    }

    public function index() {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Voucher_Model->db->order_by('sort_order','ASC');

        $this->page_content_data['title'] = "Vouchers";
        $this->page_content_data['vouchers'] = $this->Voucher_Model->get();
        $this->page_content = $this->load->view('admin/voucher/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/menu/buy_and_get/index_js',$this->page_content_data,true);

        $this->data['title'] = "Vouchers | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Voucher";
        $this->page_content = $this->load->view('admin/voucher/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/voucher/add_js',$this->page_content_data,true);

        $this->data['title'] = "Vouchers | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->data['title'] = 'Edit Voucher';
        $voucher = $this->Voucher_Model->get(intval($id));

        if (empty($voucher) || empty($id)) {
            set_flash_save_message('No such item is found');
            redirect('admin/vouchers');
        }

        $this->page_content_data['title'] = "Edit Voucher";
        $this->page_content_data['voucher'] = $voucher;
        $this->page_content = $this->load->view('admin/voucher/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/voucher/edit_js',$this->page_content_data,true);

        $this->data['title'] = "Vouchers | Edit";
        $this->load->view('admin/master/master_index',$this->data);

        // $this->data['page_content'] = $this->load->view('admin/voucher/edit',$this->data,true);
        // $this->load->view('admin/index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->Voucher_Model->add_rules);
        set_flash_form_data($_POST);
        if ($this->form_validation->run()) {
            $formData = $this->Voucher_Model->data_form_post(array('title','min_order_amount','description','start_date','end_date','discount_type','discount_amount','order_type','order_type_to_use','max_time_usage','status','sort_order','max_discount_amount'));

            $formData['image'] = '';
            if ($_FILES["voucher_image"]) {
                $formData['image'] = image_upload('voucher_image',$_FILES["voucher_image"],'assets/voucher/');
            }
            $start_date = strtotime($this->input->post('start_date'));
            $end_date = strtotime($this->input->post('end_date'));
            $datediff = $end_date - $start_date;
            $totalDays = round($datediff / (60 * 60 * 24)) + 1;
            $formData['created_at'] = date('Y-m-d H:i:s');
            $formData['validity_days'] = $totalDays;
            // echo "<pre>"; print_r($formData); exit();

            $isAmountTitleExit = $this->Voucher_Model->get_by(array('title'=>$formData['title'],'min_order_amount'=>$formData['min_order_amount'],),true);

            if (empty($isAmountTitleExit)) {
                $this->Voucher_Model->save($formData);
                set_flash_save_message('Saved successfully');
                redirect('admin/vouchers');
            } else {
                set_flash_save_message('Title With amount is already exist');
                redirect('admin/vouchers/add');
            }
        } else {
            set_flash_save_message(validation_errors());
            redirect('admin/vouchers/add');
        }
    }

    public function update() {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->Voucher_Model->add_rules);
        set_flash_form_data($_POST);
        $id = $this->input->post('id');
        $formData = $this->Voucher_Model->data_form_post(array('title','min_order_amount','description','start_date','end_date','discount_type','discount_amount','order_type','order_type_to_use','max_time_usage','status','sort_order','max_discount_amount'));

        if ($_FILES["voucher_image"]["name"]) {
            $formData['image'] = image_upload('voucher_image',$_FILES["voucher_image"],'assets/voucher/');
        } else {
            $formData['image'] = $this->input->post('previous_voucher_image');
        }

        $start_date = strtotime($this->input->post('start_date'));
        $end_date = strtotime($this->input->post('end_date'));
        $datediff = $end_date - $start_date;
        $totalDays =  round($datediff / (60 * 60 * 24)) + 1;
        $formData['created_at'] = date('Y-m-d H:i:s');
        $formData['validity_days'] = $totalDays;
        
        if ($this->form_validation->run()) {
            $isAmountTitleExit = $this->Voucher_Model->get_by(array('id!='=>$id,'title'=>$formData['title'],'min_order_amount'=>$formData['min_order_amount'],),true);
            $formData['updated_at'] = date('Y-m-d H:i:s');
            if (empty($isAmountTitleExit)) {
                $formData['id'] = $id;
                $this->Voucher_Model->save($formData,$id);
                set_flash_save_message('Updated successfully');

                redirect('admin/vouchers');
            } else {
                set_flash_save_message('Title With amount is already exist');
                redirect('admin/vouchers/edit/'.$id);
            }
            redirect('admin/vouchers/edit/'.$id);
        } else {
            set_flash_save_message(validation_errors());
            redirect('admin/vouchers/edit/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/vouchers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $isDeleted = $this->Voucher_Model->delete(intval($id));
        if ($isDeleted) {
            set_flash_save_message('Deleted successfully');
        }else{
            set_flash_save_message('Deleted is Failed');
        }
        redirect('admin/vouchers');
    }
}