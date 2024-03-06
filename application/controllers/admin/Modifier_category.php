<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier_category extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Modifier_Category_Model');
        $this->load->helper('user');
    }

    public function index() {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Modifier Category";
        $this->page_content_data['modifier_categories'] = $this->Modifier_Category_Model->get_all();
        $this->page_content = $this->load->view('admin/modifier-category/index',$this->page_content_data,true);

        $this->data['title'] = "Modifier Category | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $max_sort_order = $this->Modifier_Category_Model->get_max_sort_order();
        $sort_order = 1;
        if (!empty($max_sort_order) || $max_sort_order > 0) {
            $sort_order = $max_sort_order + 1;
        }
        $this->page_content_data['title'] = "Add Modifier Category";
        $this->page_content_data['sort_order'] = $sort_order;
        $this->page_content = $this->load->view('admin/modifier-category/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/modifier-category/add_js',$this->page_content_data,true);

        $this->data['title'] = "Modifier Category | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $modifier_category = $this->Modifier_Category_Model->get($id);

        $this->page_content_data['title'] = "Modifier Category";
        $this->page_content_data['modifier_category'] = $modifier_category;
        $this->page_content = $this->load->view('admin/modifier-category/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/modifier-category/edit_js',$this->page_content_data,true);

        $this->data['title'] = "Modifier Category | Edit";
        $this->load->view('admin/master/master_index',$this->data);

        // $this->load->view('admin/header');
        // $this->load->view('admin/modifier-category/edit', $this->data);
        // $this->load->view('admin/script_page');
    }

    public function save() {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->Modifier_Category_Model->add_rules);
        $data = $this->Modifier_Category_Model->data_form_post(array('ModifierCategoryName','ModifierLimit','SortOrder'));
        $this->session->set_flashdata('form_data',$data);
        if ($this->form_validation->run()) {
            $is_save = $this->Modifier_Category_Model->save($data);
            if ($is_save) {
                $this->session->set_flashdata('save_message','Modifer Category saved successfully');
                redirect('admin/modifier_category');
            } else {
                $this->session->set_flashdata('error_message','Modifer Category not saved successfully');
                redirect('admin/modifier_category/add');
            }
        } else {
            $this->session->set_flashdata('error_message',validation_errors());
            redirect('admin/modifier_category/add');
        }
    }

    public function update() {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_modifier_category = new Modifier_Category_Model();
        $data = $this->Modifier_Category_Model->data_form_post(array('ModifierCategoryId','ModifierCategoryName','ModifierLimit','SortOrder'));
        $name = $data['ModifierCategoryName'];
        $id = $data['ModifierCategoryId'];

        $this->form_validation->set_rules($this->Modifier_Category_Model->edit_rules);
        if ($this->form_validation->run()) {
            $modifier_category = $this->Modifier_Category_Model->get_by(array('ModifierCategoryId!='=>$id,'ModifierCategoryName'=>$name), true);
            if (empty($modifier_category)) {
                $data['isEdited'] = 1;
                $is_update = $this->Modifier_Category_Model->save($data,$id);
                if ($is_update) {
                    $this->session->set_flashdata('save_message','Modifer Category updated successfully');
                    redirect('admin/modifier_category');
                } else {
                    $this->session->set_flashdata('save_message','Modifer Category not updated successfully');
                    redirect('admin/modifier_category/edit/'.$id);
                }
            } else {
                $this->session->set_flashdata('save_message','Modifer Category not updated successfully');
                redirect('admin/modifier_category/edit/'.$id);
            }
        } else {
            $this->session->set_flashdata('form_error',validation_errors());
            redirect('admin/modifier_category/edit/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/modifier_category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_modifier_category=new Modifier_Category_Model();
        $m_modifier_category->delete($id);
        redirect('admin/modifier_category');
    }
}
