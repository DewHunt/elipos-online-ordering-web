<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_product_files extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Parentcategory_Model');
        $this->load->model('Foodtype_Model');
        $this->load->model('Category_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Sub_product_files_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $sub_product_list_details = $this->Sub_product_files_Model->get();
        $this->page_content_data['title'] = "Sub Product Files Item";
        $this->page_content_data['sub_product_list_details'] = $sub_product_list_details;
        $this->page_content = $this->load->view('admin/menu/sub_product_files/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product_files/index_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Files Item | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add_item() {
        if (is_user_permitted('admin/sub_product_files/assign') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Sub Product Files Item";
        $this->page_content = $this->load->view('admin/menu/sub_product_files/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product_files/add_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Files Item | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit_item($id = 0) {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $sub_product = $this->Sub_product_files_Model->get($id);
        $product = $this->Fooditem_Model->get($sub_product->foodItemId);

        $this->page_content_data['title'] = "Sub Product Files Item";
        $this->page_content_data['product'] = $product;
        $this->page_content_data['sub_product'] = $sub_product;
        $this->page_content = $this->load->view('admin/menu/sub_product_files/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product_files/edit_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Files Item | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
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
        $form_data = array(
            //'selectiveItemId' => $id,
            'selectiveItemName' => $sub_product_name,
            'selectiveItemFullName' => (!empty($sub_product_full_name))?$sub_product_full_name:null,
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
        );

        $this->form_validation->set_rules('sub_product_name', 'Sub Product', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->add_item();
        } else {
            $sub_product_name_exist = $this->Sub_product_files_Model->is_sub_product_item_file_name_exist($sub_product_name);
            if (!$sub_product_name_exist) {
                $this->Sub_product_files_Model->save($form_data);
                $this->session->set_flashdata('save_message', 'Information has been saved successfully');
                redirect(base_url($this->admin.'/sub_product_files/add_item'));
            } else {
                $this->session->set_flashdata('error_message', 'Name already exists');
                redirect(base_url($this->admin.'/sub_product_files/add_item'));
            }
        }
    }

    public function update() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = trim($this->input->post('id'));
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
        $form_data = array(
            'selectiveItemId' => $id,
            'selectiveItemName' => $sub_product_name,
            'selectiveItemFullName' => (!empty($sub_product_full_name))?$sub_product_full_name:null,
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
        );

        $this->form_validation->set_rules('sub_product_name', 'Sub Product File', 'required');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'required');
        $this->form_validation->set_rules('table_price', 'Table Price', 'required');
        $this->form_validation->set_rules('takeaway_price', 'Takeaway Price', 'required');
        $this->form_validation->set_rules('bar_price', 'Bar Price', 'required');
        $this->form_validation->set_rules('vat_rate', 'Vat Rate', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->edit_item($id);
        } else {
            $is_sub_product_name_exist_for_update = $this->Sub_product_files_Model->is_sub_product_item_file_name_exist_for_update($id, $sub_product_name);
            if (!$is_sub_product_name_exist_for_update) {
                $this->Sub_product_files_Model->where_column = 'selectiveItemId';
                $result = $this->Sub_product_files_Model->save($form_data, $id);
                redirect(base_url($this->admin.'/sub_product_files'));
            } else {
                $this->session->set_flashdata('save_error_message', 'Name already exists');
                redirect(base_url($this->admin.'/sub_product_files/edit_item/') . $id);
            }
        }
    }

    public function remove() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $sub_product_item_id=$this->input->post('sub_product_item_id');
            $m_sub_product=new Selectionitems_Model();
            $m_sub_product->db->where('SelectionItemFilesId',$sub_product_item_id);
            $m_sub_product->db->limit(1);
            $this->db->delete($m_sub_product->get_table_name());
        }
    }

    public function delete_item($id = 0) {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Sub_product_files_Model->delete($id);
        redirect($this->admin.'/sub_product_files');
    }

    public function assign() {
        if (is_user_permitted('admin/sub_product_files/assign') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Sub Product Files Item Assign/Remove";
        $this->page_content_data['category_list'] = $this->Category_Model->get_all_category();
        $this->page_content_data['sub_product_list_details'] = null;
        $this->page_content = $this->load->view('admin/menu/sub_product_files/assign',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/menu/sub_product_files/assign_js',$this->page_content_data,true);

        $this->data['title'] = "Sub Product Files Item | Assign";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_sub_product_files() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $product_id = $this->input->post('product_id');
            $total_sub_product_files = $this->Sub_product_files_Model->get_total_sub_product_files();
            $all_sub_product_files_ids = $this->Sub_product_files_Model->get_total_sub_product_files_ids();
            $total_assigned_sub_product_files = $this->Selectionitems_Model->get_total_assigned_sub_product_files($product_id,$all_sub_product_files_ids);
            $all_check = '';
            if ($total_sub_product_files == $total_assigned_sub_product_files) {
                $all_check = 'checked';
            }
            $this->data['foodItemId'] = $product_id;
            $this->data['sub_product_list_details'] = $this->Sub_product_files_Model->get();
            $this->data['all_check'] = $all_check;
            $table_data = $this->load->view('admin/menu/sub_product_files/assign_table_data', $this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('table_data' => $table_data)));
        }
    }

    public function do_assign() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $assign_ids = $this->input->post('assign_ids');
            $delete_ids = $this->input->post('delete_ids');
            $foodItemId = $this->input->post('foodItemId');

            if (!empty($assign_ids)) {
                // Assign And Updated
                foreach ($assign_ids as $id) {
                    $sub_product_file = $this->Sub_product_files_Model->get_by(array('selectiveItemId'=>$id),true);
                    if (!empty($sub_product_file)) {
                        $sub_product = $this->Selectionitems_Model->get_by(array('SelectionItemFilesId'=>$id,' foodItemId'=>$foodItemId),true);

                        $sub_product_file_array = !empty($sub_product_file) ? json_decode(json_encode($sub_product_file),true): null;
                        $food_item = $this->Fooditem_Model->get($foodItemId);
                        $food_item_name = $food_item->foodItemName;

                        if (empty($sub_product)) {
                            if (!empty($sub_product_file_array)) {
                                unset($sub_product_file_array['selectiveItemId']);
                                $sub_product_file_array['selectiveItemName'] = $sub_product_file->selectiveItemName.' '.$food_item_name;
                                $sub_product_file_array['SelectionItemFilesId'] = $id;
                                $sub_product_file_array['foodItemId'] = $foodItemId;
                                $this->Selectionitems_Model->save($sub_product_file_array);;
                            }
                        } else {
                            // Updated
                            if (!empty($sub_product_file_array)) {
                                $updated_data = array();
                                $updated_data['selectiveItemName'] = $sub_product_file->selectiveItemName.' '.$food_item_name;
                                $updated_data['tablePrice'] = $sub_product_file->tablePrice;
                                $updated_data['takeawayPrice'] = $sub_product_file->takeawayPrice;
                                $updated_data['barPrice'] = $sub_product_file->barPrice;
                                $SelectionItemFilesId = $sub_product->selectiveItemId;
                                $this->Selectionitems_Model->save($updated_data,$SelectionItemFilesId);
                            }
                        }
                    }
                }
            }

            // Delete
            if (!empty($delete_ids)) {
                foreach ($delete_ids as $id) {
                    $this->Selectionitems_Model->db->where('SelectionItemFilesId',$id);
                    $this->Selectionitems_Model->db->where('foodItemId',$foodItemId);
                    $this->Selectionitems_Model->db->limit(1);
                    $this->db->delete('selectionitems');
                }
            }
        }
    }

    public function get_product_list_by_category_id() {
        if (is_user_permitted('admin/sub_product_files') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            $category_id = trim($this->input->post('category_id'));
            $product_list_by_parent_category_id = $this->Fooditem_Model->get_product_by_category_id($category_id);
            $this->data['product_lists'] = $product_list_by_parent_category_id;
            $options = $this->load->view('admin/menu/sub_product_files/options_product',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('options' => $options)));
        }
    }
}