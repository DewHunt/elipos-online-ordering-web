<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_us extends Frontend_Controller {

    public $product;

    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->library('form_validation');
        $this->load->helper(array('form'));
        $this->load->library('email');
    }

    public function index() {
        $m_page_settings = new Page_Settings_Model();
        $page_details = $m_page_settings->get_by_name('contact_us');

        if (!empty($page_details)) {
            if ($page_details->is_show) {
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] = $page_details;
                $this->page_content = $this->load->view('contact_us/contact_us', $this->data, true);
                $this->footer = $this->load->view('footer', $this->data, true);
                $this->load->view('index', $this->data);
            } else {
                redirect('');
            }
        } else {
            redirect('');
        }
    }

    public function app() {
        $m_page_settings = new Page_Settings_Model();
        $page_details = $m_page_settings->get_by_name('contact_us');
        if (!empty($page_details)) {
            if ($page_details->is_show) {
                $this->data['title'] = $page_details->title;
                $this->data['page_details'] = $page_details;
                $this->load->view('header', $this->data);
                $this->load->view('contact_us/contact_us', $this->data);
            }
        }
?>
        <style type="text/css">
            .pace-progress{ display: none !important; }
            .contact_us_form_contact_form{ display: none !important; }
            .contact-us-form-block{ display: none !important; }
            .header-title{ display: none !important; }
            #content-wrap{ padding: 0px;; }
        </style>
<?php
    }

    public function send_message() {
        $resultMessage = '';
        if ($this->input->is_ajax_request()) {
            $message_rules = array(
                'email' => array(
                    'field' => 'email',
                    'label' => 'Email address',
                    'rules' => 'trim|required|valid_email',
                    'errors' => array(
                        'required' => 'You must provide a valid %s.',
                    ),
                ),
                'name' => array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Please provide your %s',
                    ),
                ),
                'mobile' => array(
                    'field' => 'mobile',
                    'label' => 'Mobile',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Please provide your %s',
                    ),
                ),
                'message' => array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Please write your %s',
                    ),
                ),
            );
            $this->form_validation->set_rules($message_rules);
            if ($this->form_validation->run() == true) {

                $name = trim($this->input->post('name'));
                $mobile = trim($this->input->post('mobile'));
                $email = trim($this->input->post('email'));
                $message = trim($this->input->post('message'));
                $is_send_message = $this->send_mail($name, $email, $message, $mobile);
                if ($is_send_message) {
                    $resultMessage = '<p style="color: white">Message is sent successfully,We will contact with you as soon as possible</p>';
                } else {
                    $resultMessage = '<p style="color: red">Message did not sent,Please try again</p>';
                }
            } else {
                $resultMessage = '<p style="color: red">Please check your all input fields.</p>';
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => $resultMessage)));
        } else {
            redirect(base_url());
        }
    }

    private function send_mail($name, $email, $message, $mobile) {
        $is_sent = false;
        try {
            $config = Array(
                'protocol' => 'smtp',
                'mailpath' => 'ssl://'.trim(get_smtp_host_url()),
                'smtp_host' => 'ssl://'.trim(get_smtp_host_url()),
                'smtp_port' => 465,
                'smtp_user' => trim(get_smtp_host_user()), // change it to yours
                'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
                'mailtype' => 'html',
            );
            $this->email->initialize($config);
            $this->email->reply_to($email, $name);
            $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
            $this->email->to(trim(get_company_contact_email()));
            $this->email->subject('From Contact Us');
            $this->data['message'] = $message;
            $this->data['email'] = $email;
            $this->data['name'] = $name;
            $this->data['mobile'] = $mobile;
            $body = $this->load->view('contact_us/email_template', $this->data, true);
            $this->email->message($body);
            $is_sent = $this->email->send();
            if ($is_sent) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

}
