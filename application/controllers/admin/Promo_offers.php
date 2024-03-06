<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_offers extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Promo_offers_model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Apps Home Promo";
        $this->page_content_data['promo_offer_list'] = $this->Promo_offers_model->get_promo_offers_lists();
        $this->page_content = $this->load->view('admin/settings/promo_offers/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/promo_offers/index_js',$this->page_content_data,true);

        $this->data['title'] = "Promo Offers | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $max_sort_order = $this->Promo_offers_model->get_max_sort_order();
        $sort_order = 1;
        if (!empty($max_sort_order) || $max_sort_order > 0) {
            $sort_order = $max_sort_order + 1;
        }
        $this->page_content_data['title'] = "Add Promo Offers";
        $this->page_content_data['start_date'] = "";
        $this->page_content_data['end_date'] = "";
        $this->page_content_data['sort_order'] = $sort_order;
        $this->page_content_data['title'] = "Add Promo Offers";
        $this->page_content = $this->load->view('admin/settings/promo_offers/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/promo_offers/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Promo Offers | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());

        if ($_FILES["web_image"]) {
            $web_image_path = image_upload('web_image',$_FILES["web_image"],'assets/promo_offers/web_images/');
        }

        if ($_FILES["apps_image"]) {
            $apps_image_path = image_upload('apps_image',$_FILES["apps_image"],'assets/promo_offers/apps_images/');
        }

        $data = array(
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'web_image' => $web_image_path,
            'apps_image' => $apps_image_path,
            'sort_order' => $this->input->post('sort_order'),
        );

        $this->db->insert('promo_offers', $data);
        $this->session->set_flashdata('success_message', 'New Promo Offers Saved Successfully.');
        redirect(base_url('admin/promo_offers'));
    }

    public function edit($id) {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }        
        $this->page_content_data['title'] = "Edit Promo Offers";
        $promo_offers = $this->Promo_offers_model->get_promo_offers_by_id($id);
        $this->page_content_data['promo_offers'] = $promo_offers;
        $this->page_content_data['start_date'] = $promo_offers->start_date;
        $this->page_content_data['end_date'] = $promo_offers->end_date;
        $this->page_content = $this->load->view('admin/settings/promo_offers/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/settings/promo_offers/add_edit_js',$this->page_content_data,true);

        $this->data['title'] = "Promo Offers | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $promo_offers_id = $this->input->post('promo_offers_id');

        if ($_FILES["web_image"]["name"]) {
            $web_image_path = image_upload('web_image',$_FILES["web_image"],'assets/promo_offers/web_images/');
        } else {
            $web_image_path = $this->input->post('previous_web_image');
        }

        if ($_FILES["apps_image"]["name"]) {
            $apps_image_path = image_upload('apps_image',$_FILES["apps_image"],'assets/promo_offers/apps_images/');
        } else {
            $apps_image_path = $this->input->post('previous_apps_image');
        }

        $data = array(
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'web_image' => $web_image_path,
            'apps_image' => $apps_image_path,
            'sort_order' => $this->input->post('sort_order'),
        );

        $this->db->where('id',$promo_offers_id);
        $this->db->update('promo_offers', $data);
        $this->session->set_flashdata('success_message', 'Promo Offers Update Successfully.');
        redirect(base_url('admin/promo_offers'));
    }

    public function change_status() {
    	// dd($this->input->post());
    	$id = $this->input->post('id');
    	$status = $this->input->post('status');

    	if ($status == 1) {
    		$data['status'] = 0;
    	} else {
    		$data['status'] = 1;
    	}

        $this->db->where('id',$id);
        $this->db->update('promo_offers', $data);
        $promo_offers_info = $this->Promo_offers_model->get_promo_offers_by_id($id);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('promoOffersInfo' => $promo_offers_info)));

    }

    public function delete($id) {
        if (is_user_permitted('admin/promo_offers') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Promo_offers_model->delete($id);
        redirect('admin/promo_offers');
    }
}
