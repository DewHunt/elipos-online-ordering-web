<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Voucher_Model');
        $this->load->model('Coupon_Model');
    }

    public function index() {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $isCouponIsEnabled = $this->Voucher_Model->isCouponEnabled();
        $this->Coupon_Model->db->order_by('id','DESC');

        $this->page_content_data['title'] = "Coupons";
        $this->page_content_data['isCouponIsEnabled'] = $isCouponIsEnabled;
        $this->page_content_data['coupons'] = $this->Coupon_Model->get();
        $this->page_content = $this->load->view('admin/coupon/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/coupon/index_js',$this->page_content_data,true);

        $this->data['title'] = "Coupons | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Coupons";
        $this->page_content_data['discount_type_array'] = $this->get_discount_type_array();
        $this->page_content_data['order_type_array'] = $this->get_order_type_array();
        $this->page_content_data['order_type_to_use_array'] = $this->get_order_type_to_use_array();
        $this->page_content = $this->load->view('admin/coupon/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/coupon/add_js',$this->page_content_data,true);

        $this->data['title'] = "Coupons | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $coupon = $this->Coupon_Model->get(intval($id));
        // dd($coupon->discount_type);

        if (empty($coupon) || empty($id)) {
            set_flash_save_message('No such item is found');
            redirect('admin/coupons');
        }

        $this->page_content_data['title'] = "Edit Coupons";
        $this->page_content_data['coupon'] = $coupon;
        $this->page_content_data['discount_type_array'] = $this->get_discount_type_array();
        $this->page_content_data['order_type_array'] = $this->get_order_type_array();
        $this->page_content_data['order_type_to_use_array'] = $this->get_order_type_to_use_array();
        $this->page_content = $this->load->view('admin/coupon/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/coupon/edit_js',$this->page_content_data,true);

        $this->data['title'] = "Coupons | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->Coupon_Model->add_rules);
        set_flash_form_data($_POST);
        if ($this->form_validation->run()) {
            $formData = $this->Coupon_Model->data_form_post(array('title','code','min_order_amount','description','discount_type','start_date','expired_date','discount_amount','order_type','remaining_usages','status','max_discount_amount'));

            $formData['created_at'] = date('Y-m-d H:i:s');
            $this->Coupon_Model->save($formData);
            set_flash_save_message('Saved successfully');
            redirect('admin/coupons');
        } else {
            set_flash_save_message(validation_errors());
            redirect('admin/coupons/add');
        }
    }

    public function update() {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->form_validation->set_rules($this->Coupon_Model->edit_rules);
        set_flash_form_data($_POST);

        $id = $this->input->post('id');
        $formData = $this->Coupon_Model->data_form_post(array('title','code','min_order_amount','description','discount_type','start_date','expired_date','discount_amount','order_type','status','max_discount_amount','remaining_usages'));

        if ($this->form_validation->run() === true) {
            $plusDate = $this->input->post('validity_days');
            $expiredDate = date('Y-m-d',strtotime("+ $plusDate days"));
            $formData['updated_at'] = date('Y-m-d H:i:s');
            $formData['id'] = $id;

            $codeExit = $this->Coupon_Model->get_by(array('id!='=>$id,'code'=>$formData['code'],),true);
            if (empty($codeExit)) {
                $this->Coupon_Model->save($formData,$id);
                set_flash_save_message('Updated successfully');
                redirect('admin/coupons');
            } else {
                set_flash_save_message('Code &nbsp;'.$formData['code'].'&nbsp; is already exist');
                redirect('admin/coupons/edit/'.$id);
            }
        } else {
            set_flash_save_message(validation_errors());
            redirect('admin/coupons/edit/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $isDeleted = $this->Coupon_Model->delete(intval($id));
        if ($isDeleted) {
            set_flash_save_message('Deleted successfully');
        } else {
            set_flash_save_message('Deleted is Failed');
        }
        redirect('admin/coupons');
    }

    public function save_settings() {
        if (is_user_permitted('admin/coupons') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $isCouponEnabled = $this->input->post('isCouponEnabled');
            $enabled_free_item_exist = $this->Settings_Model->get_by(array('name' =>'isCouponEnabled',), true);
            $isSave = false;
            if (empty($enabled_free_item_exist)) {
                $isSave = $this->Settings_Model->save(array('name'=>'isCouponEnabled','value'=>$isCouponEnabled));
            } else {
                $this->Settings_Model->where_column = 'name';
                $isSave = $this->Settings_Model->save(array('value'=>$isCouponEnabled),'isCouponEnabled');
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('isSave' => $isSave)));
        }
    }

    public function coupon_reports() {
        if (is_user_permitted('admin/coupons/coupon_reports') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $start_date = $this->input->post('from_date');
        $end_date = $this->input->post('to_date');
        $coupon_id_array = $this->input->post('coupon_id');

        if ($start_date == "") {
            $start_date = date('Y-m-01');
        }

        if ($end_date == "") {
            $end_date = date('Y-m-t');
        }

        $coupon_ids = "";
        if (is_array($coupon_id_array)) {
            $coupon_ids = implode(',', $coupon_id_array);
        }

        $coupon_reports = $this->Coupon_Model->get_coupon_reports($start_date,$end_date,$coupon_ids);

        $this->page_content_data['title'] = "Coupon Reports";
        $this->page_content_data['coupons'] = $this->Coupon_Model->get();
        $this->page_content_data['coupon_reports'] = $coupon_reports;
        $this->page_content_data['start_date'] = $start_date;
        $this->page_content_data['end_date'] = $end_date;
        $this->page_content_data['coupon_id_array'] = $coupon_id_array;
        $this->page_content = $this->load->view('admin/coupon_reports/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/coupon_reports/index_js',$this->page_content_data,true);

        $this->data['title'] = "Coupons | Reports";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function view_reports_details() {
        $coupon_id = $this->input->post('coupon_id');
        $this->data['details_info'] = $this->Coupon_Model->get_coupon_reports_details_by_coupon_id($coupon_id);
        // dd($this->data['details_info']);

        $details_view_modal = $this->load->view('admin/coupon_reports/view_modal', $this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('details_view_modal' => $details_view_modal)));
    }

    public function get_order_type_array() {
        return array('any' => 'Any','collection' => 'Collection','delivery' => 'Delivery');
    }

    public function get_order_type_to_use_array() {
        return array('any' => 'Any','collection' => 'Collection','delivery' => 'Delivery','table' => 'Table','bar' => 'Bar');
    }

    public function get_discount_type_array() {
        return array('percent' => 'Percent','amount' => 'Amount');
    }
}