<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends Frontend_Controller {

     public $product;
    public function __construct()
    {
        parent:: __construct();
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
    }

    public function index()
    {


        $m_page_settings=new Page_Settings_Model();
        $page_details=$m_page_settings->get_by_name('help');

        if(!empty($page_details)){
            if($page_details->is_show){
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] =$page_details;
                $this->footer = $this->load->view('footer', $this->data,true);
                $this->page_content= $this->load->view('help/help', $this->data,true);

                $this->load->view('index', $this->data);



            }else{
                redirect('');
            }

        }else{
            redirect('');
        }
    }
    public function app()
    {

        ?>
        <style>
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
        $page_details=$m_page_settings->get_by_name('help');
        if(!empty($page_details)){
            if($page_details->is_show){
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] =$page_details;
                $this->load->view('header',$this->data);
                $this->load->view('help/help', $this->data);
            }else{

            }

        }else{

        }

    }



}
