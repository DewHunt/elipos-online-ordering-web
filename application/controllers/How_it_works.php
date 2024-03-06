<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class How_it_works extends Frontend_Controller {

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
        $page_details=$m_page_settings->get_by_name('how_it_works');
        if(!empty($page_details)){
            if($page_details->is_show){
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] =$page_details;
                $this->footer = $this->load->view('footer', $this->data,true);
                $this->page_content= $this->load->view('how_it_works/how_it_works', $this->data,true);
                $this->load->view('index', $this->data);

            }else{
                redirect('');
            }

        }else{
            redirect('');
        }
    }
}
