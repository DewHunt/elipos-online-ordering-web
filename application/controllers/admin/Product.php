<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Category_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Fooditem_Strength_Model');
        $this->load->helper('user');
        // $this->load->helper('bootstrap4pagination'); 
    }

    public function index() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->session->unset_userdata('product_form_data');
        $session_category_id = 0;
        $product_category_food_type = $this->session->userdata('product_category_food_type');
        if ($product_category_food_type) {
            $session_category_id = $product_category_food_type['categoryId'];
        }

        $this->data['product_list_details'] = $this->Fooditem_Model->get_all_product();
        // dd($this->data['product_list_details']);

        $this->page_content_data['title'] = "Products";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['session_category_id'] = $session_category_id;
        $this->page_content_data['product_list_info'] = $this->load->view('admin/menu/product/table_data',$this->data,true);
        // dd($this->data['product_list_details']);
        $this->page_content = $this->load->view('admin/menu/product/product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/product/product_js',$this->page_content_data,true);

        $this->data['title'] = "Products | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function search() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            $product_list_details =  $this->Fooditem_Model->get_product_by_category_id($category_id);

            $this->data['product_list_details'] = $product_list_details;
            $table_data = $this->load->view('admin/menu/product/table_data', $this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('table_data' => $table_data)));
        }
    }

    public function get_sort_order() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            $max_sort_order =  $this->Fooditem_Model->get_sort_order_by_category_id($category_id);
            $sort_order = 1;
            if (!empty($max_sort_order) || $max_sort_order > 0) {
                $sort_order = $max_sort_order + 1;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($sort_order));
        }        
    }

    public function add_product() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // $this->session->unset_userdata('product_form_data');

        $this->page_content_data['title'] = "Add Product";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['fooditem_strength_list'] = $this->Fooditem_Strength_Model->get_all_fooditem_strengths();
        $this->page_content = $this->load->view('admin/menu/product/add_product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/product/add_product_js',$this->page_content_data,true);

        $this->data['title'] = "Products | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_product($id = 0) {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $product = $this->Fooditem_Model->get($id);

        $this->page_content_data['title'] = "Edit Product";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['fooditem_strength_list'] = $this->Fooditem_Strength_Model->get_all_fooditem_strengths();
        $this->page_content_data['product'] = $product;
        $this->page_content = $this->load->view('admin/menu/product/edit_product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/product/edit_product_js',$this->page_content_data,true);

        $this->data['title'] = "Products | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $parent_category_id = NULL;
        $food_type_id = NULL;
        $category_id = trim($this->input->post('category_id'));
        if ($category_id) {
            $category_info = $this->Category_Model->get_category_by_id($category_id);
            if ($category_info) {
                $parent_category_id = $category_info->parentCategoryId;
                $food_type_id = $category_info->foodTypeId;
            }
        }

        $parent_category_id = $parent_category_id;
        $food_type_id = $food_type_id;
        $product_name = trim($this->input->post('product_name'));
        $product_full_name = trim($this->input->post('product_full_name'));
        $productSizeId = trim($this->input->post('product_size_id'));
        $sort_order = trim($this->input->post('sort_order'));
        $table_price = trim($this->input->post('table_price'));
        $takeaway_price = trim($this->input->post('takeaway_price'));
        $bar_price = trim($this->input->post('bar_price'));
        $unit = trim($this->input->post('unit'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $vat_included = trim($this->input->post('vat_included'));
        $description = trim($this->input->post('description'));
        $printed_description = trim($this->input->post('printed_description'));
        if ((!empty($vat_included)) || $vat_included == 'on') {
            $vat_included = 1;
        } else {
            $vat_included = 0;
        }
        $isDiscount = trim($this->input->post('isDiscount'));
        $availability = null;
        if ($this->input->post('availability')) {
            $availability = implode(',',$this->input->post('availability'));
        }
        $item_strength = null;
        if ($this->input->post('product_strength')) {
            $item_strength = implode(',',$this->input->post('product_strength'));
        }
        $order_type = $this->input->post('order_type');

        $form_data = array(
            //'foodItemId' => $foodItemId,
            'parentCategoryId' => $parent_category_id,
            'foodTypeId' => $food_type_id,
            'categoryId' => $category_id,
            'foodItemName' => $product_name,
            'foodItemFullName' =>(!empty($product_full_name))?$product_full_name:null,
            'description' => $description,
            'food_item_printed_description' => $printed_description,
            'productSizeId' => $productSizeId,
            'tableView' => 1,
            'takeawayView' => 1,
            'barView' => 1,
            'itemStock' => 0,
            'qtyStatus' => 1,
            'tablePrice' => !empty($table_price) ? $table_price : 0,
            'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
            'barPrice' => !empty($bar_price) ? $bar_price : 0,
            'tableCost' => 0,
            'takeawayCost' => 0,
            'barCost' => 0,
            'vatRate' => $vat_rate,
            'vatStatus' => $vat_included,
            'itemUnit' => $unit,
            'product_plu' => '',
            'ButtonHight' => 75,
            'ButtonWidth' => 150,
            'ItemColor' => '#00FF00',
            'SortOrder' => $sort_order,
            'FontSetting' => 'Arial,Regular,14.25',
            'Forecolor' => '#8080C0',
            'availability' => $availability,
            'isDiscount' => $isDiscount,
            'item_strength' => $item_strength,
            'product_order_type' => $order_type,
        );
        $this->session->set_userdata('product_form_data',$form_data);
        $this->session->set_userdata('product_category_food_type',array(
            'categoryId' => $category_id,
            'itemUnit' => $unit,
            'SortOrder' => $sort_order,
        ));

        $this->form_validation->set_rules('category_id', 'Category Type', 'required');
        $this->form_validation->set_rules('product_name', 'Product Short Name', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->add_product();
        } else {
            $product_name_exist = $this->Fooditem_Model->is_product_name_exist($product_name);
            if (!$product_name_exist) {
               $is_inserted = $this->Fooditem_Model->save($form_data);
               if ($is_inserted) {
                   $this->session->set_flashdata('save_message', 'Information has been saved successfully');
               } else {
                   $this->session->set_flashdata('error_message', 'Information is not save successfully');
               }
               redirect(base_url('admin/product/add_product'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/product/add_product'));
            }
        }
    }

    public function update() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        
        $parent_category_id = NULL;
        $food_type_id = NULL;
        $category_id = trim($this->input->post('category_id'));
        if ($category_id) {
            $category_info = $this->Category_Model->get_category_by_id($category_id);
            if ($category_info) {
                $parent_category_id = $category_info->parentCategoryId;
                $food_type_id = $category_info->foodTypeId;
            }
        }

        //$form_data = $this->Parentcategory_Model->data_form_post(array('parentCategoryName'));
        $id = trim($this->input->post('id'));
        $parent_category_id = $parent_category_id;
        $food_type_id = $food_type_id;
        $category_id = trim($this->input->post('category_id'));
        $product_name = trim($this->input->post('product_name'));
        $product_full_name = trim($this->input->post('product_full_name'));
        $sort_order = trim($this->input->post('sort_order'));
        $table_price = trim($this->input->post('table_price'));
        $takeaway_price = trim($this->input->post('takeaway_price'));
        $productSizeId = trim($this->input->post('product_size_id'));
        $bar_price = trim($this->input->post('bar_price'));
        $unit = trim($this->input->post('unit'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $vat_included = trim($this->input->post('vat_included'));
        $description = trim($this->input->post('description'));
        $printed_description = trim($this->input->post('printed_description'));
        if ((!empty($vat_included)) || $vat_included == 'on') {
            $vat_included = 1;
        } else {
            $vat_included = 0;
        }
        $isDiscount = trim($this->input->post('isDiscount'));
        $availability = null;
        if ($this->input->post('availability')) {
            $availability = implode(',',$this->input->post('availability'));
        }
        $item_strength = null;
        if ($this->input->post('product_strength')) {
            $item_strength = implode(',',$this->input->post('product_strength'));
        }
        $order_type = $this->input->post('order_type');
        
        $form_data = array(
            'foodItemId' => $id,
            'parentCategoryId' => $parent_category_id,
            'foodTypeId' => $food_type_id,
            'categoryId' => $category_id,
            'foodItemName' => $product_name,
            'foodItemFullName' =>(!empty($product_full_name))?$product_full_name:null,
            'description' => $description,
            'food_item_printed_description' => $printed_description,
            'productSizeId' => $productSizeId,
            'tableView' => 1,
            'takeawayView' => 1,
            'barView' => 1,
            'itemStock' => 0,
            'qtyStatus' => 1,
            'tablePrice' => !empty($table_price) ? $table_price : 0,
            'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
            'barPrice' => !empty($bar_price) ? $bar_price : 0,
            'tableCost' => 0,
            'takeawayCost' => 0,
            'barCost' => 0,
            'vatRate' => $vat_rate,
            'vatStatus' => $vat_included,
            'itemUnit' => $unit,
            'product_plu' => '',
            'ButtonHight' => 75,
            'ButtonWidth' => 150,
            'ItemColor' => '#00FF00',
            'SortOrder' => $sort_order,
            'FontSetting' => 'Arial,Regular,14.25',
            'Forecolor' => '#8080C0',
            'availability' => $availability,
            'isEdited' => 1,
            'isDiscount' => $isDiscount,
            'item_strength' => $item_strength,
            'product_order_type' => $order_type,
        );

        $this->session->set_userdata('product_category_food_type',array(
            'parentCategoryId' => $parent_category_id,
            'foodTypeId' => $food_type_id,
            'categoryId' => $category_id,
            'itemUnit' => $unit,
            'SortOrder' => $sort_order,
            'fromUpdate' => true,
        ));

        $this->form_validation->set_rules('category_id', 'Category Type', 'required');
        $this->form_validation->set_rules('product_name', 'Product Short Name', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->edit_product($id);
        } else {
            $is_product_name_exist_for_update = $this->Fooditem_Model->is_product_name_exist_for_update($id, $product_name);
            if (!$is_product_name_exist_for_update) {
                $this->Fooditem_Model->where_column = 'foodItemId';
                $result = $this->Fooditem_Model->save($form_data, $id);
                $this->session->set_flashdata('save_message', 'Information has been updated successfully');
                redirect(base_url('admin/product'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/product/edit_product/').$id);
            }
        }
    }

    public function active_or_deactive_status() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());;
        $foodItemId = $this->input->post('foodItemId');
        $status = $this->input->post('status') == 1 ? 0 : 1;
        $fieldName = $this->input->post('fieldName');
        $highlightColor = $this->input->post('highlightColor');
        // echo $status; exit();

        if ($fieldName == 1) {
            $fieldName = 'active';
        } elseif ($fieldName == 2) {
            $fieldName = 'orderable';
        } elseif ($fieldName == 3) {
            $fieldName = 'isHighlight';
        }        

        $this->Fooditem_Model->update_active_status($foodItemId,$status,$fieldName,$highlightColor);
        $foodItemInfo = $this->Fooditem_Model->get_product_by_id($foodItemId);
        // echo "<pre>"; print_r($foodItemInfo); exit();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('foodItemInfo' => $foodItemInfo)));
    }

    public function delete() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id');
            $is_deleted = $this->Fooditem_Model->delete($id);
            if ($is_deleted) {
                $this->Selectionitems_Model->delete_where(array('foodItemId'=>$id),false);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_deleted' => $is_deleted)));
        }else{
            redirect('admin/product');
        }
    }
    
    public function changeOrderAbleStatus() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $orderable = $this->input->post('orderable');
            $this->Fooditem_Model->where_column = 'foodItemId';
            $is_updated = $this->Fooditem_Model->save(array('orderable'=>$orderable),$id);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_updated' => $is_updated)));
        } else {
            redirect('admin/product');
        }
    }

    public function get_product_list_by_category_id() {
        if (is_user_permitted('admin/product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $category_id = trim($this->input->post('category_id'));
            $product_id = trim($this->input->post('product_id'));
            $status = trim($this->input->post('status'));
            $product_list_by_parent_category_id = $this->Fooditem_Model->get_product_by_category_id($category_id);
            $this->data['status'] = $status;
            $this->data['product_id'] = $product_id;
            $this->data['sub_product_id'] = 0;
            $this->data['product_list_by_parent_category_id'] = $product_list_by_parent_category_id;
            $options = $this->load->view('admin/menu/product/options',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        }
    }
}