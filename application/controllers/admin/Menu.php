<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Menu_model');
    }

    public function index() {
        if ($this->User_Model->loggedin() == true) {
            $menu_lists = $this->Menu_model->get_all_menu();
            $this->data['menu_lists'] = $menu_lists;

            $this->page_content_data['title'] = "Menu Lists";
            $this->page_content_data['menu_list_table'] = $this->load->view('admin/settings/menu/menu_list_table',$this->data,true);
            $this->page_content = $this->load->view('admin/settings/menu/index',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/settings/menu/index_js','',true);

            $this->data['title'] = "Menu | Index";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function add() {
        if ($this->User_Model->loggedin() == true) {
            $menu_lists = $this->Menu_model->get_all_menu_info();
            $parent_menu_max_order = $this->Menu_model->get_parent_menu_max_order();
            $order_by = 1;

            if ($parent_menu_max_order) {
                $order_by = $parent_menu_max_order->max_order + 1;
            }

            $this->page_content_data['title'] = "Add Menu";
            $this->page_content_data['menu_lists'] = $menu_lists;
            $this->page_content_data['order_by'] = $order_by;
            $this->page_content = $this->load->view('admin/settings/menu/add',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/settings/menu/add_js','',true);

            $this->data['title'] = "Menu | Add";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function save() {
        if ($this->User_Model->loggedin() == true) {
            // dd($this->input->post());
            $menu_link = $this->input->post('menu_link');
            $is_save = true;
            $is_exists = "";

            if ($menu_link) {
                $is_exists = $this->Menu_model->is_menu_exists($menu_link);
                $is_save = false;
            }       

            if ($is_exists && $is_save == false) {
                $this->session->set_flashdata('error', 'This Menu Link '.$menu_link.' Already Exists.');
                redirect(base_url('admin/menu/add'));
            } else {
                $parent_menu = NULL;
                if ($this->input->post('parent_menu')) {
                    $parent_menu = $this->input->post('parent_menu');
                }

                $data = array(
                    'parent_menu' => $parent_menu,
                    'menu_name' => trim($this->input->post('menu_name')),
                    'menu_link' => $menu_link,
                    'menu_icon' => trim($this->input->post('menu_icon')),
                    'order_by' => trim($this->input->post('order_by')),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $this->db->insert('menus', $data);
                $this->session->set_flashdata('message', 'Menu Save Successfully.');
                redirect(base_url('admin/menu'));
            }
        } else {
            redirect($this->admin);
        }
    }

    public function edit($id) {
        if ($this->User_Model->loggedin() == true) {
            $menu_lists = $this->Menu_model->get_all_menu_info();
            $menu_info = $this->Menu_model->get_menu_by_id($id);

            $this->page_content_data['title'] = "Edit Menu";
            $this->page_content_data['menu_lists'] = $menu_lists;
            $this->page_content_data['menu_info'] = $menu_info;
            $this->page_content = $this->load->view('admin/settings/menu/edit',$this->page_content_data,true);
            $this->custom_js = $this->load->view('admin/settings/menu/edit_js','',true);

            $this->data['title'] = "Menu | Edit";
            $this->load->view('admin/master/master_index',$this->data);
        } else {
            redirect($this->admin);
        }
    }

    public function update() {
        if ($this->User_Model->loggedin() == true) {
            // dd($this->input->post());
            $id = $this->input->post('menu_id');
            $menu_link = $this->input->post('menu_link');
            $is_save = true;
            $is_exists = "";

            if ($menu_link) {
                $is_exists = $this->Menu_model->is_menu_exists($menu_link,$id);
                $is_save = false;
            }       

            if ($is_exists && $is_save == false) {
                $this->session->set_flashdata('error', 'This Menu Link '.$menu_link.' Already Exists.');
                redirect(base_url('admin/menu/edit/'.$id));
            } else {
                $parent_menu = NULL;
                if ($this->input->post('parent_menu')) {
                    $parent_menu = $this->input->post('parent_menu');
                }

                $data = array(
                    'parent_menu' => $parent_menu,
                    'menu_name' => trim($this->input->post('menu_name')),
                    'menu_link' => $menu_link,
                    'menu_icon' => trim($this->input->post('menu_icon')),
                    'order_by' => trim($this->input->post('order_by')),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $this->db->where('id',$id);
                $this->db->update('menus', $data);
                $this->session->set_flashdata('message', 'Menu Updated Successfully.');
                redirect(base_url('admin/menu'));
            }
        } else {
            redirect($this->admin);
        }
    }

    public function max_order() {        
        $parent_menu_id = $this->input->post('parent_menu_id');
        $order_by = 1;

        if ($parent_menu_id) {
            $menu_max_order = $this->Menu_model->get_max_order($parent_menu_id);
        } else {
            $menu_max_order = $this->Menu_model->get_parent_menu_max_order();
        }

        if ($menu_max_order) {
            $order_by = $menu_max_order->max_order + 1;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('order_by' => $order_by,)));   
    }

    public function change_status(){
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if ($status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $data['status'] = $status;

        $this->db->where('id',$id);
        $this->db->update('menus', $data);
        $msg = 'Status Changed Successfully';

        $menu_lists = $this->Menu_model->get_all_menu();
        $this->data['menu_lists'] = $menu_lists;
        $menu_list_table = $this->load->view('admin/settings/menu/menu_list_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'menu_list_table'=>$menu_list_table)));
    }

    public function delete(){
        $id = $this->input->post('id');
        $this->db->delete('menus', array('id' => $id));
        $msg = 'Menu Deleted Successfully';

        $menu_lists = $this->Menu_model->get_all_menu();
        $this->data['menu_lists'] = $menu_lists;
        $menu_list_table = $this->load->view('admin/settings/menu/menu_list_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('msg'=>$msg,'menu_list_table'=>$menu_list_table)));
    }
}
