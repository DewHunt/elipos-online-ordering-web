<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Food_type extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $parent_category_id = $this->session->userdata('parent_category_id_session');
        if ($parent_category_id) {
            $food_type_list = $this->Foodtype_Model->get_food_type_list_by_parent_category_id($parent_category_id);
        } else {
            $food_type_list = $this->Foodtype_Model->get();
        }
        $this->data['food_type_list'] = $food_type_list;

        $this->page_content_data['title'] = "Food Type";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content_data['food_type_table'] = $this->load->view('admin/menu/food_type/food_type_table',$this->data,true);
        $this->page_content = $this->load->view('admin/menu/food_type/food_type',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/food_type/food_type_js',$this->page_content_data,true);

        $this->data['title'] = "Food Type";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_food_type() {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Food Type";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content = $this->load->view('admin/menu/food_type/add_food_type',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/food_type/add_food_type_js',$this->page_content_data,true);

        $this->data['title'] = "Food Type | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_food_type($id = 0) {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Edit Food Type";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content_data['food_type'] = $this->Foodtype_Model->get($id);
        $this->page_content = $this->load->view('admin/menu/food_type/edit_food_type',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/food_type/edit_food_type_js',$this->page_content_data,true);

        $this->data['title'] = "Food Type | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $form_data = $this->Foodtype_Model->data_form_post(array('foodTypeName', 'parentCategoryId'));
        $parent_category_id = trim($this->input->post('parentCategoryId'));
        $food_type_name = trim($this->input->post('foodTypeName'));
        if (!empty($parent_category_id) && !empty($food_type_name)) {
            $food_type_name_exist = $this->Foodtype_Model->is_food_type_name_exist($food_type_name);
            if (!$food_type_name_exist) {
                $this->Foodtype_Model->save($form_data);
                $this->session->set_flashdata('save_message', 'Food Type Saved Successfully');
                redirect('admin/food_type');
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect('admin/food_type/add_food_type');
            }
        } else {
            $this->session->set_flashdata('error_message', 'Please Input Parent Category and food Type Name');
            redirect('admin/food_type/add_food_type');
        }
    }

    public function update() {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $form_data = $this->Foodtype_Model->data_form_post(array('foodTypeName', 'parentCategoryId'));
        $id = trim($this->input->post('foodTypeId'));
        $parent_category_id = trim($this->input->post('parentCategoryId'));
        $food_type_name = trim($this->input->post('foodTypeName'));
        if (!empty($parent_category_id) && !empty($food_type_name)) {
            $food_type_name_exist_for_update = $this->Foodtype_Model->is_food_type_name_exist_for_update($id, $food_type_name);
            if (!$food_type_name_exist_for_update) {
                $this->Foodtype_Model->where_column = 'foodTypeId';
                $result = $this->Foodtype_Model->save($form_data, $id);
                $this->session->set_flashdata('save_message', 'Food Type Updated Successfully');
                redirect('admin/food_type');
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect('admin/food_type/edit_food_type/'.$id);
            }
        } else {
            $this->session->set_flashdata('error_message', 'Please Input Parent Category and food Type Name');
            redirect('admin/food_type/edit_food_type/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Foodtype_Model->delete($id);
        redirect($this->admin.'/food_type');
    }

    public function get_food_type_by_parent_catregory_id () {
        if (is_user_permitted('admin/food_type') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $parent_category_id = trim($this->input->post('parent_category_id'));
            $status = trim($this->input->post('status'));
            $category_food_type_id = trim($this->input->post('category_food_type_id'));
            $food_type_list_by_parent_category_id = $this->Foodtype_Model->get_food_type_list_by_parent_category_id($parent_category_id);
            $this->data['status'] = $status;
            $this->data['food_type_list_by_parent_category_id'] = $food_type_list_by_parent_category_id;
            $this->data['category_food_type_id'] = $category_food_type_id;
            $options = $this->load->view('admin/menu/food_type/options',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        }
    }

    public function search_food_type() {
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $this->session->set_userdata('parent_category_id_session', $parent_category_id);
        $output = "";
        if ($parent_category_id) {
            $food_type_list = $this->Foodtype_Model->get_food_type_list_by_parent_category_id($parent_category_id);
        } else {
            $food_type_list = $this->Foodtype_Model->get();
        }

        if ($food_type_list) {
            $this->data['food_type_list'] = $food_type_list;
            $output = $this->load->view('admin/menu/food_type/food_type_table',$this->data,true);
        }
        // dd($food_type_list);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }
}
