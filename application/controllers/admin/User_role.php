<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_role extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_role_model');
        $this->load->model('Menu_model');
    }

    public function index() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $loggedin_user_role_id = $this->session->userdata('user_role');
        $user_role_lists = $this->User_role_model->get_all_user_role_list($loggedin_user_role_id);
        foreach ($user_role_lists as $user_role) {
            $menu_permission_names = '';
            if ($user_role->menu_permission) {
                $menu_permission_names = $this->Menu_model->get_menu_name_by_ids($user_role->menu_permission);
            }
            $user_role->menu_permission_names = $menu_permission_names;
        }
        // dd($user_role_lists);
        $this->data['user_role_lists'] = $user_role_lists;

        $this->page_content_data['title'] = "All User Role";
    	$this->page_content_data['user_role_table'] = $this->load->view('admin/user_role/user_role_table',$this->data,true);
        $this->page_content = $this->load->view('admin/user_role/index',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/user_role/index_js','',true);

        $this->data['title'] = "User Role | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Add User Role";
        $this->page_content = $this->load->view('admin/user_role/add',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/user_role/add_js','',true);

        $this->data['title'] = "User Role | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$role = $this->input->post('role');
    	$is_user_role_exists = $this->User_role_model->is_user_role_exists($role);

    	if ($is_user_role_exists) {
    		$this->session->set_flashdata('error_message', 'This User Role Already Saved With This Rold ID '.$role);
    		redirect(base_url('admin/user_role/add'));
    	} else {
            $data = array(
                'role' => $this->input->post('role'),
                'name' => $this->input->post('name'),
                'created_by' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('user_roles', $data);
    		$this->session->set_flashdata('save_message', 'User Role Saved Successfully.');
    		redirect(base_url('admin/user_role'));
    	}
    }

    public function edit($id) {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$user_role_info = $this->User_role_model->get_user_role_by_id($id);
        $this->page_content_data['title'] = "Edit User Role";
        $this->page_content_data['user_role_info'] = $user_role_info;
        $this->page_content = $this->load->view('admin/user_role/edit',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/user_role/edit_js','',true);

        $this->data['title'] = "User Role | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$id = $this->input->post('user_role_id');
    	$role = $this->input->post('role');
    	$is_user_role_exists = $this->User_role_model->is_user_role_exists($role,$id);

    	if ($is_user_role_exists) {
    		$this->session->set_flashdata('error_message', 'This User Role Already Saved With This Rold ID '.$role);
    		redirect(base_url('admin/user_role/edit/'.$id));
    	} else {
            $data = array(
                'role' => $role,
                'name' => $this->input->post('name'),
                'updated_by' => date('Y-m-d H:i:s'),
            );

            $this->db->where('id',$id);
            $this->db->update('user_roles', $data);
    		$this->session->set_flashdata('save_message', 'User Role Updated Successfully.');
    		redirect(base_url('admin/user_role'));
    	}
    }

    public function change_status() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$id = $this->input->post('id');
    	$status = $this->input->post('status');

    	if ($status == 1) {
    		$status = 0;
    	} else {
    		$status = 1;
    	}
    	$data['status'] = $status;

        $this->db->where('id',$id);
        $this->db->update('user_roles', $data);
        $msg = 'Status Changed Successfully';

        $loggedin_user_role_id = $this->session->userdata('user_role');
        $user_role_lists = $this->User_role_model->get_all_user_role_list($loggedin_user_role_id);
        foreach ($user_role_lists as $user_role) {
            $menu_permission_names = '';
            if ($user_role->menu_permission) {
                $menu_permission_names = $this->Menu_model->get_menu_name_by_ids($user_role->menu_permission);
            }
            $user_role->menu_permission_names = $menu_permission_names;
        }
        $this->data['user_role_lists'] = $user_role_lists;
        $user_role_table = $this->load->view('admin/user_role/user_role_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'user_role_table'=>$user_role_table)));
    }

    public function delete(){
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$id = $this->input->post('id');
        $this->db->delete('user_roles', array('id' => $id));
        $msg = 'User Role Delted Successfully';

        $loggedin_user_role_id = $this->session->userdata('user_role');
        $user_role_lists = $this->User_role_model->get_all_user_role_list($loggedin_user_role_id);
        foreach ($user_role_lists as $user_role) {
            $menu_permission_names = '';
            if ($user_role->menu_permission) {
                $menu_permission_names = $this->Menu_model->get_menu_name_by_ids($user_role->menu_permission);
            }
            $user_role->menu_permission_names = $menu_permission_names;
        }
        $this->data['user_role_lists'] = $user_role_lists;
        $user_role_table = $this->load->view('admin/user_role/user_role_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'user_role_table'=>$user_role_table)));
    }

    public function menu_permission($id) {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$user_role_info = $this->User_role_model->get_user_role_by_id($id);
    	// dd($user_role_info);
        $this->page_content_data['title'] = "Menu Permission (".$user_role_info->name.")";
        $this->page_content_data['user_role_info'] = $user_role_info;
        $this->page_content = $this->load->view('admin/user_role/menu_permission',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/user_role/menu_permission_js','',true);

        $this->data['title'] = "User Role | Menu Permission";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update_menu_permission() {
        if (is_user_permitted('admin/user_role') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $id = $this->input->post('user_role_id');
        $user_menus = NULL;

        if ($this->input->post('user_role_menu')) {
            $user_menus = implode(',',$this->input->post('user_role_menu'));
        }

        $data = array('menu_permission' => $user_menus,);

        $this->db->where('id',$id);
        $this->db->update('user_roles', $data);
        $this->session->set_flashdata('save_message', 'User Role Menu Permission Updated Successfully.');
        redirect(base_url('admin/user_role'));
    }
}
