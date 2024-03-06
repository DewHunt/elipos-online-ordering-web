<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Why_us extends Frontend_Controller {

    public $product;

    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
    }

    public function index() {

        $m_page_settings=new Page_Settings_Model();
        $page_details=$m_page_settings->get_by_name('why_us');

        if(!empty($page_details)){
            if($page_details->is_show){
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] =$page_details;
                $this->page_content=$this->load->view('why_us/why_us', $this->data,true);
                $this->footer = $this->load->view('footer', $this->data,true);
                $this->load->view('index', $this->data);


            }else{
                redirect('');
            }

        }else{
            redirect('');
        }
    }
    public function app() {

        ?>
        <style type="text/css">
            #content-wrap{
                padding: 0;
            }
            .pace-progress{
                display: none !important;
            }
            .header-title{
                display: none !important;
            }
        </style>
        <?php
        $m_page_settings=new Page_Settings_Model();
        $page_details=$m_page_settings->get_by_name('why_us');

        if(!empty($page_details)){
            if($page_details->is_show){
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] =$page_details;
                $this->load->view('header',$this->data);
                $this->load->view('why_us/why_us', $this->data);
            }else{

            }
        }else{

        }


    }

}
