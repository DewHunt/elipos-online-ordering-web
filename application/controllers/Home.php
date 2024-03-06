<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

    public $product;

    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->library('form_validation');
        $this->load->helper('settings_helper');
        $this->load->helper('postcode_helper');
        $this->load->helper('shop_helper');
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Shop_timing_Model');
        $this->load->model('Subscriber_Model');        
    }

    public function index() {
        // dd(is_home_promo_active());
        $this->session->unset_userdata('is_today_is_holiday');
        isTodayIsHoliday();
        $companyDetails = get_company_details();
        // dd($companyDetails);
        $this->data['companyDetails'] = $companyDetails;
        $this->data['title'] = "Home | " . get_company_name();
        $this->banner_slider = $this->load->view('home/banner_slider', $this->data, true);
        $this->data['main_navigation'] = $this->load->view('main_navigation', $this->data, true); 
        $this->data['about_us'] = base_url('about_us/data');
        $this->footer = $this->load->view('footer', $this->data, true);
        $data = get_public_data();
        // dd($data);

        if (is_redirect_to_online_order()) {
            return redirect(base_url('menu'));
        }
        $this->load->view('home/index', $this->data);
    }

    public function promo() {
        $output = $this->load->view('home/promo','',true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }

    public function shop_opening_timing_list() {
        $rendered_html = $this->load->view('shop_opening_timing_iframe');
        return $rendered_html;
    }

    public function contact_us_page() {
        $rendered_html = $this->load->view('contact_us_page');
        return $rendered_html;
    }

    public function is_valid_postcode() {
        if ($this->input->is_ajax_request()) {
            $postcode = trim($this->input->post('postcode'));
            $order_type_from_search = trim($this->input->post('order_type_from_search'));
            $response_data = array();
            $response_data['order_type_from_search'] = $order_type_from_search;
            $delivery_charge = 0;
            $minimum_order_amount = 0;
            $delivery_post_code = $postcode;
            $this->session->set_userdata('order_type_session', $order_type_from_search);

            if ($order_type_from_search == 'delivery') {
                if (!empty($postcode)) {
                    $is_valid_post_code = $this->Allowed_postcodes_Model->is_valid_post_code($postcode);
                    if ($is_valid_post_code) {
                        $delivery_details = $this->Allowed_postcodes_Model->get_delivery_charge_by_postcode($postcode);
                        if (!empty($delivery_details)) {
                            $delivery_charge = $delivery_details->delivery_charge;
                            $minimum_order_amount = $delivery_details->min_order_for_delivery;
                            $min_amount_for_free_delivery_charge = $delivery_details->min_amount_for_free_delivery_charge;
                            $delivery_post_code = $delivery_details->postcode;
                        }
                        $response_data['is_post_code_exist'] = true;
                        $response_data['message'] = '';
                    } else {
                        $response_data['is_post_code_exist'] = false;
                        $response_data['message'] = 'Invalid postcode.';
                    }
                } else {
                    $response_data['is_post_code_exist'] = false;
                    $response_data['message'] = 'Enter delivery postcode.';
                }
            } else {
                $response_data['is_post_code_exist'] = '';
                $response_data['message'] = '';
            }

            $this->session->set_userdata('delivery_charge', $delivery_charge);
            $this->session->set_userdata('minimum_order_amount', $minimum_order_amount);
            $this->session->set_userdata('min_amount_for_free_delivery_charge', $min_amount_for_free_delivery_charge);
            $this->session->set_userdata('delivery_post_code', $delivery_post_code);

            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_subscribed() {
        if ($this->input->is_ajax_request()) {
            $m_subscriber = new Subscriber_Model();
            $this->form_validation->set_rules($m_subscriber->subscriber_add_rules);
            $email = trim($this->input->post('email'));
            $message = '';
            if ($this->form_validation->run()) {
                $m_subscriber->save(array('email' => $email));
                $message = "You are subscribed successfully";
            } else {
                $message = validation_errors();
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'message' => '<p>'.$message.'</p>'
            )));
        } else {
            redirect(base_url());
        }
    }
  
    public function download_menu() {
        if ($this->input->is_ajax_request()) {
            $this->load->helper('download');
            $file = "./assets/Streetly_Balti_Menu.pdf";
            // check file exists
            if (file_exists ( $file )) {
                // get file content
                //force download
                force_download ($file, null);
            }
        }
    }

}
