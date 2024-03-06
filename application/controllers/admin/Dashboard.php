<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function __construct() {
        parent:: __construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Selectionitems_Model');
        $this->load->model('Fooditem_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Login_log_details');
        $this->load->helper('dashboard');
        $this->load->helper('settings_helper');
    }

    public function index() {
        // dd($this->Login_log_details->get_all_login_activity());
        // dd($this->session->userdata());
        // dd($this->input->post());

        if ($this->User_Model->loggedin() == true) {
            $last_n_days_order = $this->load->view('admin/dashboard/last_n_days_order',$this->data,true);
            $top_five_product = $this->load->view('admin/dashboard/top_five_product',$this->data,true) ;
            $latest_order = $this->load->view('admin/dashboard/latest_order',$this->data,true);
            $account_summary = $this->load->view('admin/dashboard/account_summary',$this->data,true);
            $top_customer = $this->load->view('admin/dashboard/top_customer',$this->data,true);

            $this->info_data['login_activities'] = $this->Login_log_details->get_last_ten_login_activity();
            $this->info_data['is_panel_view'] = true;
            $login_activity = $this->load->view('admin/dashboard/login_activities',$this->info_data,true);

            $this->info_data['login_activities'] = $this->Login_log_details->get_all_login_activity();
            $this->info_data['is_panel_view'] = false;
            $all_login_activity = $this->load->view('admin/dashboard/login_activities',$this->info_data,true);

            $this->data['last_n_days_order'] = $last_n_days_order;
            $this->data['top_five_product'] = $top_five_product;
            $this->data['latest_order'] = $latest_order;
            $this->data['top_customer'] = $top_customer;
            $this->data['account_summary'] = $account_summary;
            $this->data['login_activity'] = $login_activity;
            $this->data['all_login_activity'] = $all_login_activity;

            $this->data['title'] = "Dashboard";
            $this->load->view('admin/header');
            $this->load->view('admin/dashboard/index',$this->data);
            $this->load->view('admin/script_page');
        } else {
            redirect($this->admin.'/login');
        }
    }

    public function get_by_date() {
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin()) {
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                // dd($this->Order_details_Model->get_top_sellings_product(5,$from_date,$to_date));
                $this->data['from_date'] = $from_date;
                $this->data['to_date'] = $to_date;
                $last_n_days_order = $this->load->view('admin/dashboard/last_n_days_order',$this->data,true);
                $top_five_product = $this->load->view('admin/dashboard/top_five_product',$this->data,true) ;
                $latest_order = $this->load->view('admin/dashboard/latest_order',$this->data,true);
                $top_customer = $this->load->view('admin/dashboard/top_customer',$this->data,true);
                $account_summary = $this->load->view('admin/dashboard/account_summary',$this->data,true);

                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'last_n_days_order' => $last_n_days_order,
                    'top_five_product' => $top_five_product,
                    'latest_order' => $latest_order,
                    'top_customer' => $top_customer,
                    'account_summary' => $account_summary,
                )));
            }
        } else {
            redirect($this->admin.'/dashboard');
        }
    }
}
