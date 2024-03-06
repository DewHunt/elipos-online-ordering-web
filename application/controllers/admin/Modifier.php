<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Category_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Modifier_Category_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->modifier_list_data['modifier_list'] = $this->Sidedishes_Model->get_modifier_by_modifier_category();
        $this->form_data['modifier_category_list'] = $this->Modifier_Category_Model->get_all();

        $this->page_content_data['modifier_form_div'] = $this->load->view('admin/menu/modifier/modifier_form_div',$this->form_data,true);
        $this->page_content_data['modifier_list_table'] = $this->load->view('admin/menu/modifier/modifier_list_table',$this->modifier_list_data,true);
        $this->page_content = $this->load->view('admin/menu/modifier/modifier',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/modifier/modifier_js','',true);

        $this->data['title'] = "Modifier";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function show_modifier_by_modifier_category() {
        $modifier_category_id = $this->input->post('modifier_category_id');
        $modifier_form_div = "";

        if (is_array($modifier_category_id) && in_array('-1', $modifier_category_id)) {
            $this->form_data['modifier_category_list'] = $this->Modifier_Category_Model->get_all();
            $this->form_data['selected_modifier_category_id'] = $modifier_category_id;
            $modifier_form_div = $this->load->view('admin/menu/modifier/modifier_form_div',$this->form_data,true);

            $modifier_category_id = $this->Modifier_Category_Model->get_ids();
            if ($modifier_category_id) {
                $modifier_category_id = array_column($modifier_category_id, 'ModifierCategoryId');
            }
        }

        if (is_array($modifier_category_id)) {
            $modifier_category_id = implode(',', $modifier_category_id);
        }


        $this->data['modifier_list'] = $this->Sidedishes_Model->get_modifier_by_modifier_category($modifier_category_id);
        $output = $this->load->view('admin/menu/modifier/modifier_list_table',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output,'modifier_form_div'=>$modifier_form_div)));
    }

    public function add_modifier() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_modifier_category = new Modifier_Category_Model();
        $modifier_categories = $m_modifier_category->get_all();

        $this->page_content_data['modifier_categories'] = $modifier_categories;
        $this->page_content = $this->load->view('admin/menu/modifier/add_modifier',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/modifier/modifier_js','',true);

        $this->data['title'] = "Add Modifier";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_modifier($id = 0) {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_modifier_category = new Modifier_Category_Model();
        $modifier_categories = $m_modifier_category->get_all();

        $this->page_content_data['modifier_categories'] = $modifier_categories;
        $this->page_content_data['modifier'] = $this->Sidedishes_Model->get($id);
        $this->page_content = $this->load->view('admin/menu/modifier/edit_modifier',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/modifier/modifier_js','',true);

        $this->data['title'] = "Edit Modifier";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_sort_order() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $modifier_category_id = trim($this->input->post('modifier_category_id'));
            $max_sort_order =  $this->Sidedishes_Model->get_sort_order_by_modifier_category_id($modifier_category_id);
            $sort_order = 1;
            if (!empty($max_sort_order) || $max_sort_order > 0) {
                $sort_order = $max_sort_order + 1;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($sort_order));
        }        
    }

    public function save() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $modifier_name = trim($this->input->post('modifier_name'));
        $menu_price = trim($this->input->post('menu_price'));
        $unit = trim($this->input->post('unit'));
        $ModifierCategoryId = trim($this->input->post('ModifierCategoryId'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $sort_order = trim($this->input->post('sort_order'));
        $form_data = array(
            //'SideDishesId' => $id,
            'ModifierCategoryId' => $ModifierCategoryId,
            'SideDishesName' => $modifier_name,
            'UnitPrice' => $menu_price,
            'VatRate' => $vat_rate,
            'Unit' => $unit,
            'SortOrder' => $sort_order,
            'OptionsColor' => '#FF0000',
            'ButtonHight' => 100,
            'ButtonWidth' => 100,
            'FontSetting' => 'Arial,Bold,12',
            'Forecolor' => '#008000',
        );
        $this->form_validation->set_rules('modifier_name', 'Modifier Name', 'required');
        $this->form_validation->set_rules('ModifierCategoryId', 'Modifier Category ', 'required');
        $this->form_validation->set_rules('menu_price', 'Price', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');

        if ($this->form_validation->run() === FALSE) {
            return redirect(base_url('admin/modifier/add_modifier'));
        } else {
            $is_exists_modifier_name = $this->Sidedishes_Model->is_exists_modifier_name($modifier_name,$ModifierCategoryId);
            if (!$is_exists_modifier_name) {
                $this->Sidedishes_Model->save($form_data);
                $this->session->set_flashdata('save_message', 'Information has been saved successfully');
                redirect(base_url('admin/modifier/add_modifier'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/modifier/add_modifier'));
            }
        }
    }

    public function update() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = trim($this->input->post('id'));
        $modifier_name = trim($this->input->post('modifier_name'));
        $menu_price = trim($this->input->post('menu_price'));
        $ModifierCategoryId = trim($this->input->post('ModifierCategoryId'));
        $unit = trim($this->input->post('unit'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $sort_order = trim($this->input->post('sort_order'));
        $form_data = array(
            'SideDishesId' => $id,
            'SideDishesName' => $modifier_name,
            'ModifierCategoryId' => $ModifierCategoryId,
            'UnitPrice' => $menu_price,
            'VatRate' => $vat_rate,
            'Unit' => $unit,
            'isEdited' => 1,
            'SortOrder' => $sort_order,
            'OptionsColor' => '#FF0000',
            'ButtonHight' => 100,
            'ButtonWidth' => 100,
            'FontSetting' => 'Arial,Bold,12',
            'Forecolor' => '#008000',
        );
        $this->form_validation->set_rules('modifier_name', 'Modifier Name', 'required');
        $this->form_validation->set_rules('ModifierCategoryId', 'Modifier Category ', 'required');
        $this->form_validation->set_rules('menu_price', 'Price', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        if ($this->form_validation->run() === FALSE) {
            return redirect(base_url('admin/modifier/add_modifier/$id'));
        } else {
            $is_modifier_name_exist_for_update = $this->Sidedishes_Model->is_modifier_name_exist_for_update($id, $modifier_name,$ModifierCategoryId);
            if (!$is_modifier_name_exist_for_update) {
                $this->Sidedishes_Model->where_column = 'SideDishesId';
                $result = $this->Sidedishes_Model->save($form_data, $id);
                redirect(base_url('admin/modifier'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/modifier/edit_modifier/').$id);
            }
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Sidedishes_Model->delete($id);
        redirect('admin/modifier');
    }

    public function assign_modifier() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['session_category_id'] = $this->session->userdata('category_id_for_modifier_session');
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['modifier_categories'] = $this->Modifier_Category_Model->get();
        $this->page_content_data['product_id'] = $this->session->userdata('product_id_for_modifier_session');
        $this->page_content_data['sub_product_id'] = $this->session->userdata('sub_product_id_for_modifier_session');

        $this->page_content = $this->load->view('admin/menu/modifier/assign_modifier',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/modifier/assign_modifier_js',$this->page_content_data,true);

        $this->data['title'] = "Assign Modifier";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function assign_modifier_save() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $category_id = trim($this->input->post('category_id'));
        $product_id = trim($this->input->post('product_id'));
        $sub_product_id = trim($this->input->post('sub_product_id'));
        $ModifierCategoryIds = $this->input->post('ModifierCategoryIds');

        $this->session->set_userdata('category_id_for_modifier_session', $category_id);
        $this->session->set_userdata('product_id_for_modifier_session', $product_id);
        $this->session->set_userdata('sub_product_id_for_modifier_session', $sub_product_id);

        /*
         * 1.if foodItemId and selectiveItemId is null then it is category wise modifier limit else,
         * 2.if foodItemId is not null and selectiveItemId is null then it is product wise modifier limit else ,
         * 3.if selectiveItemId is not null and foodItemId is null then it is sub product wise modifier limit else
         *
         * CategoryId is CategoryId if ProductLevel = 1
         * CategoryId is selectiveItemId if ProductLevel = 2
         * CategoryId is selectionItemId if ProductLevel = 3
        */

        $modifier_categories = $this->Modifier_Category_Model->get_ids();
        $modifier_categories_ids = array();
        if ($modifier_categories) {
            $modifier_categories_ids = array_column($modifier_categories,'ModifierCategoryId');
        } 

        $productLevelCategoryId = $this->Showsidedish_Model->get_productLevelCategoryId($category_id,$product_id,$sub_product_id);

        $categoryId = $productLevelCategoryId['categoryId'];
        $productLevel = $productLevelCategoryId['level'];

        $conditions = array('showsidedish.CategoryId'=>$categoryId,'showsidedish.productLevel'=>$productLevel);
        $modifier_categories_with_limit = $this->Showsidedish_Model->data_form_post($modifier_categories_ids);
        $this->Showsidedish_Model->delete_assigned_modifier($conditions);

        if (!empty($ModifierCategoryIds)) {
            foreach ($ModifierCategoryIds as $ModifierCategoryId) {
                $modifierLimit = array_key_exists($ModifierCategoryId,$modifier_categories_with_limit) ? $modifier_categories_with_limit[$ModifierCategoryId] : 0;
                $form_data = array(
                    'SideDishId' => $ModifierCategoryId,
                    'CategoryId' => $categoryId,
                    'ModifierLimit'=> $modifierLimit,
                    'ProductLevel'=>$productLevel ,
                );
                $this->Showsidedish_Model->save($form_data);
            }
        } else {
            $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
            //$this->session->set_flashdata('save_error_message', 'Please Select Modifier');
            redirect(base_url('admin/modifier/assign_modifier'));
        }
        $this->session->set_flashdata('save_message', 'Information has been Updated successfully');
        redirect(base_url('admin/modifier/assign_modifier'));
    }

    public function get_product_list_by_category_id() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $category_id = trim($this->input->post('category_id'));
            $product_list_by_parent_category_id = $this->Fooditem_Model->get_product_by_category_id($category_id);
            $this->data['product_lists'] = $product_list_by_parent_category_id;
            $this->data['session_product_id'] = $this->session->userdata('product_id_for_modifier_session');
            $options = $this->load->view('admin/menu/modifier/options_product',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        } else {
            redirect($this->admin);
        }
    }

    public function get_sub_product_list_by_product_id(){
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $product_id = trim($this->input->post('product_id'));
            $sub_product_list = $this->Selectionitems_Model->get_sub_product_by_product_id($product_id);
            $this->data['sub_product_list'] = $sub_product_list;
            $this->data['session_sub_product_id'] = $this->session->userdata('sub_product_id_for_modifier_session');
            $options = $this->load->view('admin/menu/modifier/options_sub_product',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        } else {
            redirect($this->admin);
        }
    }

    // public function delete_assigned_modifier_by_category_id($category_id) {
    //     if ($this->User_Model->loggedin() == true) {
    //         $m_showsidedish_Model = new Showsidedish_Model();
    //         $assigned_modifier_by_category_id = $m_showsidedish_Model->get_assigned_modifier_categories($category_id);
    //         if (!empty($assigned_modifier_by_category_id)) {
    //             foreach ($assigned_modifier_by_category_id as $assigned_modifier) {
    //                 $this->Showsidedish_Model->delete($assigned_modifier->Id);
    //             }
    //         }
    //     } else {
    //         redirect($this->admin);
    //     }
    // }

    public function get_assigned_modifiers() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            $product_id = trim($this->input->post('product_id'));
            $sub_product_id = trim($this->input->post('sub_product_id'));

            $m_showsidedish_Model = new Showsidedish_Model();
            $productLevelCategoryId = $m_showsidedish_Model->get_productLevelCategoryId($category_id,$product_id,$sub_product_id);
            $categoryId = $productLevelCategoryId['categoryId'];
            $level = $productLevelCategoryId['level'];
            $conditions = array('showsidedish.CategoryId'=>$categoryId,'showsidedish.productLevel'=>$level);
            $assigned_modifier_by_category_id = $m_showsidedish_Model->get_assigned_modifiers($conditions);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('modifiers' => $assigned_modifier_by_category_id)));
            // echo json_encode($assigned_modifier_by_category_id);
        }
    }

    public function get_food_type_by_parent_catregory_id_for_modifier() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $parent_category_id = trim($this->input->post('parent_category_id'));
        $status = trim($this->input->post('status'));
        $category_food_type_id = $this->session->userdata('food_type_id_for_modifier_session');
        $food_type_list_by_parent_category_id = $this->Foodtype_Model->get_food_type_list_by_parent_category_id($parent_category_id);
        if ((string) $status === 'list') {
            echo '<option value="', '', '">', 'All', '</option>';
        } elseif ((string) $status === 'add_or_update') {
            echo '<option value="', '', '">', 'Please Select', '</option>';
        } else {

        }
        // echo (int)$category_food_type_id == (int)$food_type->foodTypeId ? 'selected="selected"' : '';
        // if (!empty($category_food_type_id) && ((int) $category_food_type_id > 0)) {
        foreach ($food_type_list_by_parent_category_id as $food_type) {
            $result = '';
            if ((int) $category_food_type_id == (int) $food_type->foodTypeId) {
                $result = 'selected="selected"';
            }
            echo '<option ', $result, ' value="', $food_type->foodTypeId, '">', $food_type->foodTypeName, '</option>';
        }
        // } else {
        //    foreach ($food_type_list_by_parent_category_id as $food_type) {
        //        echo '<option value="', $food_type->foodTypeId, '">', $food_type->foodTypeName, '</option>';
        //    }
        // }

    }

    public function get_category_by_food_type_id_for_modifier() {
        if (is_user_permitted('admin/modifier') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $food_type_id = trim($this->input->post('food_type_id'));
        $status = trim($this->input->post('status'));
        $product_category_id = $this->session->userdata('category_id_for_modifier_session');
        $category_list_by_food_type_id = $this->Category_Model->get_category_list_by_food_type_id($food_type_id);
        if ((string) $status === 'list') {
            echo '<option value="', '', '">', 'All', '</option>';
        } elseif ((string) $status === 'add_or_update') {
            echo '<option value="', '', '">', 'Please Select', '</option>';
        }
        foreach ($category_list_by_food_type_id as $category) {
            $result = '';
            if ((int) $product_category_id == (int) $category->categoryId) {
                $result = 'selected="selected"';
            } else {
                $result = '';
            }
            echo '<option ', $result, ' value="', $category->categoryId, '">', $category->categoryName, '</option>';
        }
    }
}
