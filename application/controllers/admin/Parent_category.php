<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parent_category extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Parent Category";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content = $this->load->view('admin/menu/parent_category/parent_category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/parent_category/parent_category_js',$this->page_content_data,true);

        $this->data['title'] = "Parent Category";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_parent_category() {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Parent Category";
        $this->page_content = $this->load->view('admin/menu/parent_category/add_parent_category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/parent_category/add_parent_category_js',$this->page_content_data,true);

        $this->data['title'] = "Parent Category | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_parent_category($id = 0) {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Edit Parent Category";
        $this->page_content_data['parent_category'] = $this->Parentcategory_Model->get($id);
        $this->page_content = $this->load->view('admin/menu/parent_category/edit_parent_category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/parent_category/edit_parent_category_js',$this->page_content_data,true);

        $this->data['title'] = "Parent Category | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $form_data = $this->Parentcategory_Model->data_form_post(array('parentCategoryName'));
        $parent_category_name = trim($this->input->post('parentCategoryName'));
        if (!empty($parent_category_name)) {
            $parent_category_name_exist = $this->Parentcategory_Model->is_parent_category_name_exist($parent_category_name);
            if (!$parent_category_name_exist) {
                $this->Parentcategory_Model->save($form_data);
                $this->session->set_flashdata('save_message', 'Parent Category Saved Succesfully');
                redirect('admin/parent_category');
            } else {
                $this->session->set_flashdata('save_error_message', 'Name already exists');
                redirect('admin/parent_category/add_parent_category');
            }
        } else {
            $this->session->set_flashdata('save_error_message', 'Please Input Name');
            redirect('admin/parent_category/add_parent_category');
        }
    }

    public function update() {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $form_data = $this->Parentcategory_Model->data_form_post(array('parentCategoryName'));
        $id = trim($this->input->post('parentCategoryId'));
        $parent_category_name = trim($this->input->post('parentCategoryName'));
        if (!empty($parent_category_name)) {
            $parent_category_name_exist = $this->Parentcategory_Model->is_parent_category_name_exist_for_update($id, $parent_category_name);
            if (!$parent_category_name_exist) {
                $this->Parentcategory_Model->where_column = 'parentCategoryId';
                $result = $this->Parentcategory_Model->save($form_data, $id);
                $this->session->set_flashdata('save_message', 'Parent Category Update Succesfully');
                redirect('admin/parent_category');
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect('admin/parent_category/edit_parent_category/'.$id);
            }
        } else {
            $this->session->set_flashdata('error_message', 'Please Input Name');
            redirect('admin/parent_category/edit_parent_category/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/parent_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Parentcategory_Model->delete($id);
        redirect($this->admin.'/parent_category');
    }
}
