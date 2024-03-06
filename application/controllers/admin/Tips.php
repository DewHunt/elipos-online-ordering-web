<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tips extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Tips_model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = 'Tips Lists';
        $this->page_content_data['tips_lists'] = $this->Tips_model->get_all_tips();
        $this->page_content = $this->load->view('admin/tips/index',$this->page_content_data,true);

        $this->data['title'] = "Tips | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = 'Add Tips';
        $this->page_content = $this->load->view('admin/tips/add_tips',$this->page_content_data,true);

        $this->data['title'] = "Tips | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());

        $data = array(
            'name' => $this->input->post('name'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status'),
        );

        $this->db->insert('tips', $data);
        $this->session->set_flashdata('save_message', 'Tips Saved Successfully.');
        redirect(base_url('admin/tips'));
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = 'Edit Tips';
        $this->page_content_data['tips'] = $this->Tips_model->get_tips_by_id($id);
        $this->page_content = $this->load->view('admin/tips/edit_tips',$this->page_content_data,true);

        $this->data['title'] = "Tips | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // dd($this->input->post());
        $id = $this->input->post('tips_id');

        $data = array(
            'name' => $this->input->post('name'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status'),
        );

        $this->db->where('id',$id);
        $this->db->update('tips', $data);
        $this->session->set_flashdata('save_message', 'Tips Updated Successfully.');
        redirect(base_url('admin/tips'));
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/tips/index') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->db->delete('tips', array('id' => $id));
        redirect(base_url('admin/tips'));
    }
}
