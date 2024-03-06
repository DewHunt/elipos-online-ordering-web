<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {
    public $users = array();
    public $single_user = array();

    //public $paginationArray=array();

    public function __construct() {
        parent::__construct();
        $this->load->helper('user');
        $this->load->model('User_Model');
        $this->load->model('User_role_model');
    }

    public function index() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $loggedin_user_role_id = $this->session->userdata('user_role');
        $users = $this->User_Model->get_all_users($loggedin_user_role_id);
        
        $this->page_content_data['title'] = "User Lists";
        $this->page_content_data['users'] = $users;
        $this->page_content = $this->load->view('admin/user/user_list',$this->page_content_data,true);

        $this->data['title'] = "User | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function user_create() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $loggedin_user_role_id = $this->session->userdata('user_role');
        $user_role_lists = $this->User_role_model->get_all_user_role_list_by_status($loggedin_user_role_id);
        $this->page_content_data['title'] = "Add User";
        $this->page_content_data['user_role_lists'] = $user_role_lists;
        $this->page_content = $this->load->view('admin/user/user_create',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/user/user_create_js',$this->page_content_data,true);

        $this->data['title'] = "User | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function user_update($id = 0) {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $user = $this->User_Model->get($id, true);
        if (empty($user)) {
            redirect($this->admin.'/user');
        } else {
            $loggedin_user_role_id = $this->session->userdata('user_role');
            $user_role_lists = $this->User_role_model->get_all_user_role_list_by_status($loggedin_user_role_id);
            $this->page_content_data['title'] = "Edit User";
            $this->page_content_data['user'] = $user;
            $this->page_content_data['user_role_lists'] = $user_role_lists;
            $this->page_content = $this->load->view('admin/user/user_update',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/user/user_update_js',$this->page_content_data,true);

            $this->data['title'] = "User | Edit";
            $this->load->view('admin/master/master_index',$this->data);
        }
    }

    public function user_profile_update($id = 0) {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $user = $this->User_Model->get($id, true);
        if (empty($user)) {
            redirect($this->admin.'/user');
        } else {
            $this->page_content_data['title'] = "Update User Information";
            $this->page_content_data['user'] = $user;
            $this->page_content = $this->load->view('admin/user/user_profile_update',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/user/user_profile_update_js',$this->page_content_data,true);

            $this->data['title'] = "User | Edit";
            $this->load->view('admin/master/master_index',$this->data);

            // $this->data['title'] = "user Update";
            // $this->load->view('admin/header');
            // $this->data['user'] = $user;
            // $this->load->view('admin/user/user_profile_update', $this->data);
            // $this->load->view('admin/script_page');
        }
    }

    public function user_profile_edit() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $this->User_Model->where_column = 'id';
        $this->User_Model->update_user();
        $this->session->set_flashdata('save_message', 'Information has been updated successfully.');
        redirect($this->admin . '/user/user_profile_update/' . $id);
    }

    public function edit() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // if ($this->input->is_ajax_request()) {
        $this->User_Model->where_column = 'id';
        $this->User_Model->update_user();
        redirect($this->admin . '/user');
        //get_users_table_rows($this->users_data());
        /* } else {
          redirect($this->admin . '/user');
          } */
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // if ($this->input->is_ajax_request()) {
        $loggedId = $this->session->userdata('user_id');
        if ($loggedId == $id) {
            set_flash_save_message( "Delete Forbidden for Logged in User " . $this->session->userdata('user_name'));
        } else {
            if (!empty($id > 0)) {
                $this->User_Model->delete($id);
                set_flash_save_message( "User has been deleted successfully");
            }
        }
        redirect($this->admin . '/user');
    }

    public function save() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->session->set_flashdata('is_post', true);
        //if ($this->input->is_ajax_request()) {
        $result = $this->User_Model->new_user();
        if ($result == 'Saved successfully') {
            redirect($this->admin.'/user');
           set_flash_save_message('User is Saved Successfully');
        } else {
            set_flash_save_message($result);
            set_flash_form_data($_POST);
            redirect($this->admin.'/user/user_create');
        }
    }

    public function view() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $single_user = json_decode(json_encode($this->User_Model->get($id, true)), True);
            view_user($single_user);
        } else {
            redirect($this->admin . '/user');
        }
    }

    public function single_user() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $this->data['user'] = $this->User_Model->get($id, true);
        $this->load->view('admin/user/user_edit_modal', $this->data);
    }

    protected function users_data() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->User_Model->order_by = 'id';
        $this->User_Model->order = 'DESC';
        return $this->User_Model->get_order_by();
    }

    public function is_user_name_exist() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->is_user_name_exist()) {
                echo "<p class='message-user-exist' style='color: red'>User Name Already Exist try another</p>";
            } else {
                
            }
        } else {
            redirect($this->admin . '/user');
        }
    }

    public function is_email_exist() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->is_email_registered()) {
                echo "<p class='message-email-exist' style='color: red'>Email Already registered by another user try another</p>";
            } else {
                
            }
        } else {
            redirect($this->admin . '/user');
        }
    }

    public function is_email_exist_without_this_id() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $email = $this->input->post('email');
            $sql = "SELECT * FROM user WHERE not id='$id'and email='$email'";

            if (!empty($this->User_Model->queryString($sql))) {
                echo "<p class='message-email-exist' style='color: red'>Email Already registered by another user. Try another</p>";
            } else {
                
            }
        } else {
            redirect($this->admin . '/user');
        }
    }

    public function user_profile() {
        if (is_user_permitted('admin/user') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->session->userdata('user_id');
        $this->data['title'] = "Users";
        $this->load->view('admin/header', $this->data);
        $user = $this->User_Model->get($id, true);
        $this->data['user'] = $user;
        $this->load->view('admin/user/user_profile', $this->data);
        $this->load->view('admin/script_page');
    }

}
