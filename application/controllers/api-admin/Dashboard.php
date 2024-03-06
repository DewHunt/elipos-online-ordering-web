<?php
class Dashboard extends ApiAdmin_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Customer_Model');
        $this->load->helper('dashboard');
        $this->load->helper('product');
    }

    public function index()
    {

        if($this->checkMethod('GET')) {
            $data=array();
            $last_n_days_order=$this->load->view('admin/dashboard/last_n_days_order',$data,true);
            $data['last_n_days_order']=$last_n_days_order;
            $top_five_product =$this->load->view('admin/dashboard/top_five_product',$data,true) ;
            $data['top_five_product']=$top_five_product;
            $latest_order=$this->load->view('admin/dashboard/latest_order',$data,true);
            $data['latest_order']=$latest_order;
            $top_customer=$this->load->view('admin/dashboard/top_customer',$data,true);
            $data['top_customer']=$top_customer;
            $account_summary=$this->load->view('admin/dashboard/account_summary',$data,true);
            $data['account_summary']=$account_summary;
            $report=$this->load->view('admin/dashboard/api',$data,true);

                $this->setResponseJsonOutput(array(
                    'report'=>$report
                ));


        }

    }

    public function report()
    {

        if($this->checkMethod('GET')) {
            $data=array();
            $last_n_days_order=$this->load->view('admin/dashboard/last_15_days_order',$data,true);
            $data['last_n_days_order']=$last_n_days_order;
            $top_five_product =$this->load->view('admin/dashboard/top_five_product',$data,true) ;
            $data['top_five_product']=$top_five_product;
            $latest_order=$this->load->view('admin/dashboard/latest_order',$data,true);
            $data['latest_order']=$latest_order;
            $top_customer=$this->load->view('admin/dashboard/top_customer',$data,true);
            $data['top_customer']=$top_customer;
            $account_summary=$this->load->view('admin/dashboard/account_summary',$data,true);
            $data['account_summary']=$account_summary;
            $report=$this->load->view('admin/dashboard/api',$data,true);
            echo $report;


        }

    }
}