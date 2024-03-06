<?php
Class Free_items extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('FreeItem_Model');
        $this->load->helper('shop');
        $this->load->model('Fooditem_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->library('form_validation');
    }

    public function index() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $enabled_free_item = $this->FreeItem_Model->is_enabled_free_item();
        $free_items = $this->FreeItem_Model->get();

        $this->page_content_data['title'] = "Free Items";
        $this->page_content_data['enabled_free_item'] = $enabled_free_item;
        $this->page_content_data['free_item_limit'] = $this->FreeItem_Model->get_free_item_limit();
        $this->page_content_data['free_items'] = $free_items;
        $this->page_content = $this->load->view('admin/free-items/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/free-items/index_js',$this->page_content_data,true);

        $this->data['title'] = "Free Items | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->data['product_ids'] = array();
        $this->data['sub_product_ids'] = array();
        $this->data['products'] = $this->Fooditem_Model->get_all_products();
        $this->data['subProducts'] = $this->Selectionitems_Model->get_all_sub_products();
        // dd($this->data);

        $this->page_content_data['title'] = "Add Free Items";
        $this->page_content_data['product_lists_data'] = $this->load->view('admin/free-items/products',$this->data,true);
        $this->page_content_data['sub_product_lists_data'] = $this->load->view('admin/free-items/sub_products',$this->data,true);
        $this->page_content = $this->load->view('admin/free-items/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/free-items/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Free Items | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->form_validation->set_rules($this->FreeItem_Model->add_rules);
        if ($this->form_validation->run()) {
            $description = $this->input->post('description');
            $status = $this->input->post('status');
            $amount = $this->input->post('amount');
            $product_ids = $this->input->post('product_ids');
            $sub_product_ids = $this->input->post('sub_product_ids');
            $this->FreeItem_Model->save(array(
                'amount'=>$amount,
                'description'=>$description,
                'status'=>$status,
                'product_ids'=>empty($product_ids) ? '' : json_encode($product_ids),
                'sub_products_ids'=>empty($sub_product_ids) ? '' : json_encode($sub_product_ids),
            ));

            redirect('admin/free_items');
        } else {
            $this->add();
        }
    }

    public function delete($id) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $free_item = $this->FreeItem_Model->get($id);
        if ($free_item) {
            $is_deleted = $this->FreeItem_Model->delete($id);
            if ($is_deleted) {
                set_flash_save_message('Deleted successfully');
            }
        }
        redirect('admin/free_items');
    }

    public function view($id) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $free_item = $this->FreeItem_Model->get($id,true);

        $this->page_content_data['title'] = "View Free Items";
        $this->page_content_data['free_item'] = $free_item;
        $this->page_content = $this->load->view('admin/free-items/view',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/free-items/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Free Items | View";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id) {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $free_item = $this->FreeItem_Model->get($id,true);
        if ($free_item) {
            $product_ids = get_property_value('product_ids',$free_item);
            $sub_product_ids = get_property_value('sub_products_ids',$free_item);
            if ($product_ids) {
                $product_ids = json_decode($product_ids);
            } else {
                $product_ids = array();
            }

            if ($sub_product_ids) {
                $sub_product_ids = json_decode($sub_product_ids);
            } else {
                $sub_product_ids = array();
            }
            $this->data['product_ids'] = $product_ids;
            $this->data['sub_product_ids'] = $sub_product_ids;
            $this->data['products'] = $this->Fooditem_Model->get_all_products();
            $this->data['subProducts'] = $this->Selectionitems_Model->get_all_sub_products();

            $this->page_content_data['title'] = "Edit Free Items";
            $this->page_content_data['free_item'] = $free_item;
            $this->page_content_data['product_lists_data'] = $this->load->view('admin/free-items/products',$this->data,true);
            $this->page_content_data['sub_product_lists_data'] = $this->load->view('admin/free-items/sub_products',$this->data,true);
            $this->page_content = $this->load->view('admin/free-items/edit',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/free-items/add_edit_js',$this->page_content_data,true);

            $this->data['title'] = "Free Items | Edit";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect('admin/free_items');
        }

    }

    public function update() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->FreeItem_Model->edit_rules);
        $id = $this->input->post('id');
        if($this->form_validation->run()){
            $description = $this->input->post('description');
            $status = $this->input->post('status');
            $amount = $this->input->post('amount');
            $product_ids = $this->input->post('product_ids');
            $sub_product_ids = $this->input->post('sub_product_ids');

            $free_item = $this->FreeItem_Model->get_by(array('amount'=>$amount,'id!='=>$id),true);
            if (empty($free_item)) {
                $this->FreeItem_Model->save(array(
                    'amount'=>$amount,
                    'description'=>$description,
                    'status'=>$status,
                    'product_ids'=>(!empty($product_ids))?json_encode($product_ids):'',
                    'sub_products_ids'=>(!empty($sub_product_ids))?json_encode($sub_product_ids):'',
                ),$id);
                set_flash_save_message('Update successfully');
                redirect('admin/free_items');
            } else {
                set_flash_save_message('Amount must be unique');
                $this->edit($id);
            }
        } else {
            $this->edit($id);
        }
    }

    public function save_settings() {
        if (is_user_permitted('admin/free_items') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $free_item_limit = $this->input->post('free_item_limit');
            $enabled_free_item = $this->input->post('enabled_free_item');
            $enabled_free_item_exist = $this->Settings_Model->get_by(array('name' =>'enabled_free_item',), true);
            $isSave = false;
            if (empty($enabled_free_item_exist)) {
                $isSave = $this->Settings_Model->save(array('name' =>'enabled_free_item','value'=>$enabled_free_item));
            } else {
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(array('value'=>$enabled_free_item),'enabled_free_item');
            }

            $enabled_free_item_exist = $this->Settings_Model->get_by(array('name' =>'free_item_limit',), true);
            $isSave=false;

            if (empty($enabled_free_item_exist)) {
                $isSave = $this->Settings_Model->save(array('name' =>'free_item_limit','value'=>$free_item_limit));
            } else {
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(array('value'=>$free_item_limit),'free_item_limit');
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('isSave' => $isSave)));
        }

    }
}