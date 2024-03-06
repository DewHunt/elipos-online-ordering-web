<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Subscriber_Model');
        $this->load->helper('bootstrap4pagination');
    }

    public function index($offset = 0) {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $subscribers = $this->Subscriber_Model->get();

        $this->page_content_data['title'] = "Subscribers";
        $this->page_content_data['subscribers'] = $subscribers;
        $this->page_content = $this->load->view('admin/subscriber/index',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/subscriber/index_js',$this->page_content_data,true);

        $this->data['title'] = "Subscribers | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/subscriber/add') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Add Subscriber";
        $this->page_content = $this->load->view('admin/subscriber/add',$this->page_content_data,true);
        // $this->custom_js = $this->load->view('admin/menu/buy_and_get/add_js',$this->page_content_data,true);

        $this->data['title'] = "Subscriber | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $subscriber = $this->Subscriber_Model->get($id);
        if ($subscriber) {
            $this->page_content_data['title'] = "Edit Subscriber";
            $this->page_content_data['subscriber'] = $subscriber;
            $this->page_content = $this->load->view('admin/subscriber/edit',$this->page_content_data,true);
            // $this->custom_js = $this->load->view('admin/menu/buy_and_get/add_js',$this->page_content_data,true);

            $this->data['title'] = "Subscriber | Edit";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect('admin/subscriber');
        }
        //$this->load->view('admin/footer');
    }

    public function insert() {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_subscriber = new Subscriber_Model();
        $this->form_validation->set_rules($m_subscriber->subscriber_add_rules);
        $email = $this->input->post('email');

        if ($this->form_validation->run()) {
            $this->Subscriber_Model->save(array('email'=>$email));
            $this->session->set_flashdata('save_message', 'Subscriber is saved successfully.');
            redirect('admin/subscriber');
        } else {
            set_flash_form_data(array('email'=>$email));
            set_flash_message(validation_errors());
            redirect('admin/subscriber/add');
        }
    }

    public function get_subscribed () {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $m_subscriber = new Subscriber_Model();
            $this->form_validation->set_rules($m_subscriber->subscriber_add_rules);
            $email = $this->input->post('email');
            $message = '';
            if ($this->form_validation->run()) {
                $m_subscriber->save(array('email'=>$email));
                $message = "You are subscribed successfully";
            } else {
                $message = validation_errors();
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => '<p>'.$message.'</p>')));
        }
    }

    public function update() {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_subscriber = new Subscriber_Model();
        $this->form_validation->set_rules($m_subscriber->subscriber_edit_rules);
        $email = $this->input->post('email');
        $id = $this->input->post('id');

        if ($this->form_validation->run()) {
            $another_email = $m_subscriber->get_by(array('email'=>$email,'id!='=>$id),true);
            if (empty($another_email)) {
                $m_subscriber->where_column = 'id';
                $m_subscriber->save(array('email'=>$email),$id);
                $this->session->set_flashdata('save_message', 'Subscriber is updated successfully.');
                redirect($this->admin.'/subscriber');
            } else {
                $this->session->set_flashdata('error_message', 'Subscriber is not updated successfully.');
                redirect($this->admin.'/subscriber/edit/'.$id);
            }
        } else {
            set_flash_form_data(array('email'=>$email));
            redirect($this->admin.'/subscriber/edit/'.$id);
        }
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/subscriber') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $m_subscriber = new Subscriber_Model();
        $is_deleted = false;
        $is_deleted = $m_subscriber->delete($id);
        $message = ($is_deleted) ? 'Subscriber has been deleted successfully' : 'Subscriber did not deleted successfully';
        set_flash_message($message);
        redirect($this->admin.'/subscriber');
    }
}
