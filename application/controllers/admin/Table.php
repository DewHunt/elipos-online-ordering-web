<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Table extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Table_model');
        $this->load->helper('user');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }

        $this->page_content_data['title'] = "Table List";
        $this->page_content_data['table_list'] = $this->Table_model->get_all_table();
        $this->page_content = $this->load->view('admin/menu/table/index',$this->page_content_data,true);

        $this->data['title'] = "Table | Index";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content_data['title'] = "Add Table";
        $this->page_content = $this->load->view('admin/menu/table/add',$this->page_content_data,true);

        $this->data['title'] = "Table | Add";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }

    	$number = $this->input->post('tablenNumber');
    	$is_table_exists = $this->Table_model->is_table_exists($number);

    	if ($is_table_exists) {
        	$this->session->set_flashdata('error_message', 'Table Alredy Exists.');
    		redirect(base_url('admin/table/add'));
    	}

        $data = array(
            'table_number' => $number,
            'table_capacity' => $this->input->post('tableCapacity'),
        );

        $this->db->insert('tables', $data);
        $this->session->set_flashdata('success_message', 'Table Saved Successfully.');
        redirect(base_url('admin/table'));
    }

    public function edit($id) {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }        
        $this->page_content_data['title'] = "Edit Table";
        $this->page_content_data['table_info'] = $this->Table_model->get_table_by_id($id);
        $this->page_content = $this->load->view('admin/menu/table/edit',$this->page_content_data,true);

        $this->data['title'] = "Table | Edit";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }
    	$number = $this->input->post('tablenNumber');
    	$table_id = $this->input->post('table_id');
    	$is_table_exists = $this->Table_model->is_table_exists($number,$table_id);

    	if ($is_table_exists) {
        	$this->session->set_flashdata('error_message', 'Table Alredy Exists.');
    		redirect(base_url('admin/table/edit'.$table_id));
    	}

        $data = array(
            'table_number' => $number,
            'table_capacity' => $this->input->post('tableCapacity'),
        );

        $this->db->where('id',$table_id);
        $this->db->update('tables', $data);
        $this->session->set_flashdata('success_message', 'Table Update Successfully.');
        redirect(base_url('admin/table'));
    }

    public function delete($id) {
        if (is_user_permitted('admin/table') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->Table_model->delete($id);
        redirect('admin/table');
    }
}
