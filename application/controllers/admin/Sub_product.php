<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_product extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Category_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Product_Size_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->session->userdata());
        $session_category_id = 0;
        $session_food_item_id = 0;
        $product_list = '';
        $session_category_id = $this->session->userdata('session_category_id');
        $session_food_item_id = $this->session->userdata('session_food_item_id');

        if ($session_category_id) {
            $product_list = $this->Fooditem_Model->get_product_by_category_id($session_category_id);
        } else {
            $product_list = $this->Fooditem_Model->get_all_product();
        }

        $sub_product_list_details = $this->Selectionitems_Model->get_sub_products_by_category_id_and_product_id();
        $this->sub_product_data['sub_product_list_details'] = $sub_product_list_details;
        $table_data = $this->load->view('admin/menu/sub_product/table_data', $this->sub_product_data,true);

        $this->page_content_data['title'] = "Sub Product Item";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['product_list'] = $product_list;
        $this->page_content_data['session_category_id'] = $session_category_id;
        $this->page_content_data['session_food_item_id'] = $session_food_item_id;
        $this->page_content_data['table_data'] = $table_data;

        $this->page_content = $this->load->view('admin/menu/sub_product/sub_product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product/sub_product_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Item";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function search() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            $product_id = trim($this->input->post('product_id'));

            if ($category_id <= 0) {
                $category_id = $this->Category_Model->get_all_category_ids();
                if (is_array($category_id)) {
                    $category_id = implode(',', $category_id);
                }
            }

            if ($product_id <= 0) {
                $product_id = $this->Fooditem_Model->get_all_product_ids_by_category_id($category_id);
                if (is_array($product_id)) {
                    $product_id = implode(',', $product_id);
                }
            }

            $sub_product_list_details = $this->Selectionitems_Model->get_sub_products_by_category_id_and_product_id($category_id, $product_id);
            $this->data['sub_product_list_details'] = $sub_product_list_details;
            $table_data = $this->load->view('admin/menu/sub_product/table_data', $this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('table_data' => $table_data)));
        }
    }

    public function get_sort_order() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $product_id = trim($this->input->post('product_id'));
            $max_sort_order = $this->Selectionitems_Model->get_sort_order_by_product_id($product_id);
            $sort_order = 1;
            if (!empty($max_sort_order) || $max_sort_order > 0) {
                $sort_order = $max_sort_order + 1;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($sort_order));
        }
    }

    public function add_sub_product() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($form_data);
        $session_category_id = 0;
        $session_food_item_id = 0;
        $session_product_size_id = 0;
        $product_list = '';

        $form_data = $this->session->userdata('sub_product_from_data');
        if ($form_data) {
            $session_category_id = $this->session->userdata('session_category_id');
            $session_food_item_id = $this->session->userdata('session_food_item_id');
            $session_product_size_id = $this->session->userdata('session_product_size_id');

            if ($session_category_id) {
                $product_list = $this->Fooditem_Model->get_product_by_category_id($session_category_id);
            }
        }

        $this->page_content_data['title'] = "Add Sub Product Item";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['product_list'] = $product_list;
        $this->page_content_data['product_sizes'] = $this->Product_Size_Model->get_all_product_size();
        $this->page_content_data['session_category_id'] = $session_category_id;
        $this->page_content_data['session_food_item_id'] = $session_food_item_id;
        $this->page_content_data['session_product_size_id'] = $session_product_size_id;
        $this->page_content_data['form_data'] = $form_data;
        $this->page_content = $this->load->view('admin/menu/sub_product/add_sub_product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product/add_sub_product_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Item";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_sub_product($id = 0) {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $sub_product = $this->Selectionitems_Model->get($id);
        $product = $this->Fooditem_Model->get($sub_product->foodItemId);

        $this->page_content_data['title'] = "Edit Sub Product Item";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['product_list'] = $this->Fooditem_Model->get();
        $this->page_content_data['product_sizes'] = $this->Product_Size_Model->get_all_product_size();

        $this->page_content_data['category'] = $this->Category_Model->get($product->categoryId);
        $this->page_content_data['product'] = $product;
        $this->page_content_data['sub_product'] = $sub_product;

        $this->page_content = $this->load->view('admin/menu/sub_product/edit_sub_product',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product/edit_sub_product_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Item | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $category_id = trim($this->input->post('category_id'));
        $product_id = trim($this->input->post('product_id'));
        $product_size_id = trim($this->input->post('product_size_id'));

        $sub_product_name = trim($this->input->post('sub_product_name'));
        $sub_product_full_name = trim($this->input->post('sub_product_full_name'));
        $sort_order = trim($this->input->post('sort_order'));
        $table_price = trim($this->input->post('table_price'));
        $takeaway_price = trim($this->input->post('takeaway_price'));
        $bar_price = trim($this->input->post('bar_price'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $vat_included = trim($this->input->post('vat_included'));
        if ((!empty($vat_included)) || $vat_included == 'on') {
            $vat_included = 1;
        } else {
            $vat_included = 0;
        }
        $description = trim($this->input->post('description'));
        $printed_description = trim($this->input->post('printed_description'));

        $this->session->set_userdata('session_category_id',$category_id);
        $this->session->set_userdata('session_food_item_id',$product_id);
        $this->session->set_userdata('session_product_size_id',$product_size_id);
        $this->session->set_userdata('session_sort_id',$sort_order);

        $this->form_validation->set_rules('category_id', 'Category Type', 'required');
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('sub_product_name', 'Sub Product', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->set_form_data_to_session($sub_product_name,$sub_product_full_name,$product_id,$table_price,$takeaway_price,$bar_price,$vat_included,$vat_rate,$sort_order);
            redirect(base_url('admin/sub_product/add_sub_product'));
        } else {
            $sub_product_name_exist = $this->Selectionitems_Model->is_sub_product_name_exist($sub_product_name);
            if (!$sub_product_name_exist) {
                $data = array(
                    //'selectiveItemId' => $id,
                    'foodItemId' => $product_id,
                    'selectiveItemName' => $sub_product_name,
                    'selectiveItemFullName' => $sub_product_full_name,
                    'tablePrice' => !empty($table_price) ? $table_price : 0,
                    'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
                    'barPrice' => !empty($bar_price) ? $bar_price : 0,
                    'product4_plu' => '',
                    'status' => 1,
                    'selectiveItemStockQty' => 0,
                    'vatIncluded' => $vat_included,
                    'vatRate' => $vat_rate,
                    'ButtonHight' => 100,
                    'ButtonWidth' => 100,
                    'SelectionItemColor' => '#0080FF',
                    'SortOrder' => $sort_order,
                    'FontSetting' => 'Arial,Bold,12',
                    'Forecolor' => '#FFFFFF',
                    'productSizeId' => $product_size_id,
                    'selection_item_description' => $description,
                    'selection_item_printed_description' => $printed_description,
                );
                // dd($data);
                $this->session->set_userdata('sub_product_from_data',$data);
                $is_save = $this->Selectionitems_Model->save($data);
                if ($is_save) {
                    $this->session->set_flashdata('save_message', 'Sub Product Saved Successfully');
                    // $this->session->unset_userdata('sub_product_from_data');
                } else {
                    $this->session->set_flashdata('error_message', 'Information is not save');
                }
                redirect(base_url('admin/sub_product/add_sub_product'));
            } else {
                $this->set_form_data_to_session($sub_product_name,$sub_product_full_name,$product_id,$table_price,$takeaway_price,$bar_price,$vat_included,$vat_rate,$sort_order);
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/sub_product/add_sub_product'));
            }
        }
    }

    public function update() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = trim($this->input->post('id'));
        $category_id = trim($this->input->post('category_id'));
        $product_id = trim($this->input->post('product_id'));
        $product_size_id = trim($this->input->post('product_size_id'));

        $sub_product_name = trim($this->input->post('sub_product_name'));
        $sub_product_full_name = trim($this->input->post('sub_product_full_name'));
        $sort_order = trim($this->input->post('sort_order'));
        $table_price = trim($this->input->post('table_price'));
        $takeaway_price = trim($this->input->post('takeaway_price'));
        $bar_price = trim($this->input->post('bar_price'));
        $vat_rate = trim($this->input->post('vat_rate'));
        $vat_included = trim($this->input->post('vat_included'));
        if ((!empty($vat_included)) || $vat_included == 'on') {
            $vat_included = 1;
        } else {
            $vat_included = 0;
        }
        $description = trim($this->input->post('description'));
        $printed_description = trim($this->input->post('printed_description'));

        $this->session->set_userdata('session_category_id',$category_id);
        $this->session->set_userdata('session_food_item_id',$product_id);
        $this->session->set_userdata('session_product_size_id',$product_size_id);
        $this->session->set_userdata('session_sort_id',$sort_order);

        $this->form_validation->set_rules('category_id', 'Category Type', 'required');
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('sub_product_name', 'Sub Product', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');

        if ($this->form_validation->run() === FALSE) {
            redirect(base_url('admin/sub_product/edit_sub_product/').$id);
        } else {
            $is_sub_product_name_exist_for_update = $this->Selectionitems_Model->is_sub_product_name_exist_for_update($id, $sub_product_name);
            if (!$is_sub_product_name_exist_for_update) {
                $form_data = array(
                    'selectiveItemId' => $id,
                    'selectiveItemName' => $sub_product_name,
                    'selectiveItemFullName' => $sub_product_full_name,
                    'foodItemId' => $product_id,
                    'tablePrice' => !empty($table_price) ? $table_price : 0,
                    'takeawayPrice' => !empty($takeaway_price) ? $takeaway_price : 0,
                    'barPrice' => !empty($bar_price) ? $bar_price : 0,
                    'selectiveItemStockQty' => 0,
                    'isEdited' => 1,
                    'status' => 1,
                    'product4_plu' => '',
                    'vatIncluded' => $vat_included,
                    'vatRate' => $vat_rate,
                    'ButtonHight' => 100,
                    'ButtonWidth' => 100,
                    'SelectionItemColor' => '#0080FF',
                    'SortOrder' => $sort_order,
                    'FontSetting' => 'Arial,Bold,12',
                    'Forecolor' => '#FFFFFF',
                    'productSizeId' => $product_size_id,
                    'selection_item_description' => $description,
                    'selection_item_printed_description' => $printed_description,
                );
                $this->Selectionitems_Model->where_column = 'selectiveItemId';
                $result = $this->Selectionitems_Model->save($form_data, $id);
                $this->session->set_flashdata('save_message', 'Sub Product Updated Successfully');
                redirect(base_url('admin/sub_product'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url('admin/sub_product/edit_sub_product/').$id);
            }
        }
    }

    public function set_form_data_to_session($sub_product_name,$sub_product_full_name,$product_id,$table_price,$takeaway_price,$bar_price,$vat_included,$vat_rate,$sort_order) {
        $form_data = array(
            //'selectiveItemId' => $id,
            'sub_product_name' => $sub_product_name,
            'sub_product_full_name' => (!empty($sub_product_full_name))?$sub_product_full_name:null,
            'foodItemId' => $product_id,
            'table_price' => !empty($table_price) ? $table_price : 0,
            'takeaway_price' => !empty($takeaway_price) ? $takeaway_price : 0,
            'bar_price' => !empty($bar_price) ? $bar_price : 0,
            'vatIncluded' => $vat_included,
            'vatRate' => $vat_rate,
            'SortOrder' => $sort_order,
        );
        $this->session->set_userdata('sub_product_from_data',$form_data);
    }

    public function delete() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $id = $this->input->post('id');
            $is_deleted = $this->Selectionitems_Model->delete($id);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('is_deleted' => $is_deleted)));
        } else {
            redirect('admin/product');
        }
    }

    public function get_product_list_by_category_id() {
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $category_id = trim($this->input->post('category_id'));
            if ($category_id <= 0) {
                $category_id = $this->Category_Model->get_all_category_ids();
            }
            if (is_array($category_id)) {
                $category_id = implode(',', $category_id);
            }
            $product_lists = $this->Fooditem_Model->get_product_by_category_id($category_id);
            $this->data['product_lists'] = $product_lists;
            $options = $this->load->view('admin/menu/sub_product/options_product',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        }
    }

    public function get_sub_product_list_by_product_id(){
        if (is_user_permitted('admin/sub_product') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            if ($this->User_Model->loggedin() == true) {
                $product_id = trim($this->input->post('product_id'));
                $sub_product_id = trim($this->input->post('sub_product_id'));
                $m_sub_product = new Selectionitems_Model();
                $sub_product_list_by_product_id = $m_sub_product->get_sub_product_by_product_id($product_id);

                $this->data['sub_product_id'] = $sub_product_id;
                $this->data['sub_product_list_by_product_id'] = $sub_product_list_by_product_id;
                $options = $this->load->view('admin/menu/sub_product/options',$this->data,true);
                $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
            }
        } else {
            redirect($this->admin);
        }
    }
}
