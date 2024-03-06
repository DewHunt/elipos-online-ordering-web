<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Category_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $parent_category_id = $this->session->userdata('parent_category_id_for_category_session');
        $food_type_id = $this->session->userdata('food_type_id_for_category_session');

        if ($parent_category_id && $food_type_id) {
            $category_list_details = $this->Category_Model->get_category_list_details($parent_category_id, $food_type_id);
        } else {
            $category_list_details = $this->Category_Model->get_category_list_details(0,0);
        }

        $this->page_content_data['title'] = "Category";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content_data['food_type_list'] = $this->Foodtype_Model->get();
        $this->page_content_data['category_list'] = $this->Category_Model->get();
        $this->page_content_data['food_type'] = $this->Foodtype_Model->get_food_type_list_by_parent_category_id($parent_category_id);
        $this->page_content_data['category_list_details'] = $category_list_details;
        $this->page_content_data['food_type_id'] = $food_type_id;
        $this->page_content = $this->load->view('admin/menu/category/category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/category/category_js',$this->page_content_data,true);

        $this->data['title'] = "Category";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_category() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $max_sort_order = $this->Category_Model->get_max_sort_order();
        $sort_order = 1;
        if (!empty($max_sort_order) || $max_sort_order > 0) {
            $sort_order = $max_sort_order + 1;
        }
        $this->page_content_data['title'] = "Add Category";
        $this->page_content_data['sort_order'] = $sort_order;
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content_data['food_type_list'] = $this->Foodtype_Model->get();
        $this->page_content = $this->load->view('admin/menu/category/add_category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/category/add_category_js',$this->page_content_data,true);

        $this->data['title'] = "Category | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_category($id = 0) {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $category = $this->Category_Model->get($id);

        $this->page_content_data['title'] = "Edit Category";
        $this->page_content_data['parent_category_list'] = $this->Parentcategory_Model->get();
        $this->page_content_data['food_type_list'] = $this->Foodtype_Model->get();
        $this->page_content_data['category'] = $category;
        $this->page_content_data['food_type'] = $this->Foodtype_Model->get($category->foodTypeId);
        $this->page_content = $this->load->view('admin/menu/category/edit_category',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/category/edit_category_js',$this->page_content_data,true);

        $this->data['title'] = "Category | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $food_type_id = trim($this->input->post('food_type_id'));
        $category_type_id = trim($this->input->post('category_type_id'));
        $category_name = trim($this->input->post('category_name'));
        $isOffersOrDeals = trim($this->input->post('is_offers_or_deals'));
        $isPackage = trim($this->input->post('isPackage'));
        $sort_order = trim($this->input->post('sort_order'));
        $orderType = trim($this->input->post('order_type'));
        $isDiscount = trim($this->input->post('isDiscount'));
        $availability = implode(',',$this->input->post('availability'));
        $description = trim($this->input->post('description'));

        $form_data = array(
            // 'categoryId' => $categoryId,
            'parentCategoryId' => $parent_category_id,
            'foodTypeId' => $food_type_id,
            'categoryTypeId' => $category_type_id,
            'categoryName' => $category_name,
            'isDeals' => $isOffersOrDeals,
            'isPackage' => $isPackage,
            'order_type' => (!empty($orderType))?$orderType:'both',
            'tableView' => 1,
            'takeawayView' => 1,
            'barView' => 1,
            'backgroundColor' => '#408080',
            'ButtonHight' => 53,
            'ButtonWidth' => 128,
            'SortOrder' => $sort_order,
            'KitchenSectionId' => 11,
            'FontSetting' => 'Arial,Bold,12',
            'Forecolor' => '#FFFFFF',
            'PrintingSortOrder' => 2,
            'availability' => $availability,
            'isDiscount' => $isDiscount,
            'category_description' => $description,
        );

        $this->form_validation->set_rules('parent_category_id', 'Parent Category', 'required');
        $this->form_validation->set_rules('food_type_id', 'Food Type', 'required');
        $this->form_validation->set_rules('category_type_id', 'Category Type', 'required');
        $this->form_validation->set_rules('category_name', 'Category ', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order ', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->data['title'] = "Add Food Type";
            $this->data['parent_category_list'] = $this->Parentcategory_Model->get();
            $this->data['food_type_list'] = $this->Foodtype_Model->get();
            $this->load->view('admin/header');
            // $this->load->view('admin/navigation');
            $this->load->view('admin/menu/category/add_category', $this->data);
            $this->load->view('admin/script_page');
        } else {
            $category_name_exist = $this->Category_Model->is_category_name_exist($category_name);
            if (!$category_name_exist) {
                $this->Category_Model->save($form_data);
                $this->session->set_flashdata('save_message', 'Category Saved Successfully');
                redirect('admin/category');
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect('admin/category/add_category');
            }
        }
    }

    public function update() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        //$form_data = $this->Parentcategory_Model->data_form_post(array('parentCategoryName'));
        $id = trim($this->input->post('id'));
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $food_type_id = trim($this->input->post('food_type_id'));
        $category_type_id = trim($this->input->post('category_type_id'));
        $category_name = trim($this->input->post('category_name'));
        $sort_order = trim($this->input->post('sort_order'));
        $isOffersOrDeals= trim($this->input->post('is_offers_or_deals'));
        $isPackage= trim($this->input->post('isPackage'));
        $orderType= trim($this->input->post('order_type'));
        $isDiscount= trim($this->input->post('isDiscount'));
        if ($this->input->post('availability')) {
            $availability = implode(',',$this->input->post('availability'));
        } else {
            $availability = null;
        }
        $description = trim($this->input->post('description'));
        
        $form_data = array(
            'categoryId' => $id,
            'parentCategoryId' => $parent_category_id,
            'foodTypeId' => $food_type_id,
            'categoryTypeId' => $category_type_id,
            'categoryName' => $category_name,
            'isEdited'=>1,
            'isDeals' => $isOffersOrDeals,
            'isPackage' => $isPackage,
            'order_type' => (!empty($orderType)) ? $orderType : 'both',
            'tableView' => 1,
            'takeawayView' => 1,
            'barView' => 1,
            'backgroundColor' => '#408080',
            'ButtonHight' => 53,
            'ButtonWidth' => 128,
            'SortOrder' => $sort_order,
            'KitchenSectionId' => 11,
            'FontSetting' => 'Arial,Bold,12',
            'Forecolor' => '#FFFFFF',
            'PrintingSortOrder' => 2,
            'availability' => $availability,
            'isDiscount' => $isDiscount,
            'category_description' => $description,
        );
        $this->form_validation->set_rules('parent_category_id', 'Parent Category', 'required');
        $this->form_validation->set_rules('food_type_id', 'Food Type', 'required');
        $this->form_validation->set_rules('category_type_id', 'Category Type', 'required');
        $this->form_validation->set_rules('category_name', 'Category ', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order ', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->data['title'] = "Add Food Type";
            $this->data['parent_category_list'] = $this->Parentcategory_Model->get();
            $this->data['food_type_list'] = $this->Foodtype_Model->get();
            $this->load->view('admin/header');
            //$this->load->view('admin/navigation');
            $this->load->view('admin/menu/category/edit_category', $this->data);
            $this->load->view('admin/script_page');
        } else {
            $category_name_exist_for_update = $this->Category_Model->is_category_name_exist_for_update($id, $category_name);
            if (!$category_name_exist_for_update) {
                $this->Category_Model->where_column = 'CategoryId';
                $result = $this->Category_Model->save($form_data, $id);
                $this->session->set_flashdata('save_message', 'Category Updated Successfully');
                redirect('admin/category');
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect('admin/category/edit_category/' . $id);
            }
        }
    }

    public function active_or_deactive_status() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // echo "<pre>"; print_r($this->input->post()); exit();
        $categoryId = $this->input->post('categoryId');
        $status = $this->input->post('status') == 1 ? 0 : 1;
        $fieldName = $this->input->post('fieldName');
        $highlightColor = $this->input->post('highlightColor');

        if ($fieldName == 1) {
            $fieldName = 'active';
        } elseif ($fieldName == 2) {
            $fieldName = 'orderable';
        } elseif ($fieldName == 3) {
            $fieldName = 'isHighlight';
        }

        $this->Category_Model->update_active_status($categoryId,$status,$fieldName,$highlightColor);
        $categoryInfo = $this->Category_Model->get_category_by_id($categoryId);
        // echo "<pre>"; print_r($categoryInfo); exit();

        $this->output->set_content_type('application/json')->set_output(json_encode(array('categoryInfo' => $categoryInfo)));
    }
    
    public function changeOrderAbleStatus() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()) {
            $categoryId = $this->input->post('categoryId');
            $orderable = $this->input->post('orderable');
            $this->Category_Model->where_column ='categoryId';
            $is_updated = $this->Category_Model->save(array('orderable'=>$orderable),$categoryId);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_updated' => $is_updated)));
        } else {
            redirect('admin/product');
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Category_Model->delete($id);
        redirect('admin/category');
    }

    public function get_category_by_parent_category_id() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $status = trim($this->input->post('status'));
        $category_list_by_parent_category_id = $this->Category_Model->get_category_list_by_parent_category_id($parent_category_id);
        if ((string) $status === 'list') {
            echo '<option value="', '', '">', 'All', '</option>';
        } elseif ((string) $status === 'add_or_update') {
            echo '<option value="', '', '">', 'Please Select', '</option>';
        } else {

        }
        foreach ($category_list_by_parent_category_id as $category) {
            echo '<option value="', $category->categoryId, '">', $category->categoryName, '</option>';
        }
    }

    public function get_category_by_food_type_id() {
        if (is_user_permitted('admin/category') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $food_type_id = trim($this->input->post('food_type_id'));
            $status = trim($this->input->post('status'));
            $product_category_id = trim($this->input->post('product_category_id'));
            $category_list_by_food_type_id = $this->Category_Model->get_category_list_by_food_type_id($food_type_id);
            $this->data['status'] = $status;
            $this->data['product_category_id'] = $product_category_id;
            $this->data['category_list_by_food_type_id'] = $category_list_by_food_type_id;
            $options = $this->load->view('admin/menu/category/options',$this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        } else {
            redirect(base_url('admin/category'));
        }
    }

    public function search_category() {
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $food_type_id = trim($this->input->post('food_type_id'));
        $this->session->set_userdata('parent_category_id_for_category_session', $parent_category_id);
        $this->session->set_userdata('food_type_id_for_category_session', $food_type_id);
        if (empty($parent_category_id) && empty($food_type_id)) {
            $category_list_details = $this->Category_Model->get_category_list_details(0,0);
        } else {
            $category_list_details = $this->Category_Model->get_category_list_details($parent_category_id, $food_type_id);
        }

        if ($category_list_details) {
            $this->data['category_list_details'] = $category_list_details;
            $output = $this->load->view('admin/menu/category/category_table',$this->data,true);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }
}
