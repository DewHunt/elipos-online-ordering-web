<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Postcode_distance extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        if ($this->User_Model->loggedin()) {
            $this->data['title'] = "Postcode distance";
            $this->Postcode_Distance_Model->db->order_by('meters','ASC');
           $this->data['postcode_distances']=$this->Postcode_Distance_Model->get();

           $this->data['page_content']=$this->load->view('admin/postcode_distance/index',$this->data,true);
            $this->load->view('admin/admin_template',$this->data);

        } else {
            redirect($this->admin);
        }
    }



    public function add() {
        if ($this->User_Model->loggedin()) {

        }else{
            redirect($this->admin);
        }

    }

    public function edit($id = 0) {
        if ($this->User_Model->loggedin()) {


        } else {
            redirect($this->admin);
        }


    }


    public function insert() {
        if ($this->User_Model->loggedin()) {



        } else {
            redirect($this->admin);
        }
    }

    public function update() {
        if ($this->User_Model->loggedin()) {

            $id = trim($this->input->post('id'));
        } else {
            redirect($this->admin);
        }
    }



    public function delete() {
        if ($this->User_Model->loggedin() == true) {
            if($this->input->is_ajax_request()){
                $id=$this->input->post('id');
                $is_deleted=$this->Postcode_Distance_Model->delete($id);
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('is_deleted' => $is_deleted)));
            }else{
                redirect('admin/postcode_distance');
            }


        }else {
            redirect($this->admin);
        }


    }


}
