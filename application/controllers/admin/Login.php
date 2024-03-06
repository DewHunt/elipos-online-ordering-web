<?php
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Login_log_details');
    }

    public function index() {
        if ($this->User_Model->loggedin() == true) {
            redirect('admin/dashboard');
        } else {
            $this->data['title'] = "Login";
            $this->load->view('admin/header');
            $this->load->view('admin/login_form');
            $this->load->view('admin/script_page');
        }
    }

    public function user_login() {
        $rules = $this->User_Model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == true) {
            $this->User_Model->login();
            if ($this->User_Model->loggedin() == true) {
                $user_info = $this->session->userdata();
                $this->Login_log_details->save_login_activity($user_info['user_id'],$user_info['user_name'],true,false);
                redirect('admin/dashboard');
                $this->session->set_flashdata('is_login', true);
            } else {
                $name_or_email = $this->input->post('name_or_email');
                $this->Login_log_details->save_login_activity(0,$name_or_email,false,true);
                $this->session->set_flashdata('login_error', 'Please Check User Name Or password');
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function user_logout() {
        if ($this->User_Model->loggedin()) {
            $user_info = $this->session->userdata();
            $this->Login_log_details->save_login_activity($user_info['user_id'],$user_info['user_name'],false,true);
            $this->User_Model->logout();
            $this->session->set_flashdata('is_login', false);
        }
        redirect('admin');
    }
}