<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sagepay_gateway extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('Sagepay');
        $this->load->helper('settings');
        $this->load->model('Customer_Model');
        $this->load->model('Sagepay_transaction_model');
    }

    public function payment() {
        $this->data['customer_id'] = $_GET['ci'];
        $this->data['total_amount'] = $_GET['tc'];
        $this->data['card_holder_name'] = '';
        if (isset($_GET['chn'])) {
            $this->data['card_holder_name'] = $_GET['chn'];
        }
        $this->page_content = $this->load->view('sagepay_gateway/payment/payment', $this->data, true);
        $this->script_content = $this->load->view('sagepay_gateway/payment/payment_script', $this->data, true);
        $this->css_content = $this->load->view('sagepay_gateway/payment/payment_css', $this->data, true);
        $this->load->view('sagepay_gateway/master', $this->data);
    }

    public function redirect_to_merchant($customer_id) {
        // dd($this->input->post());
        $retrieve_status = false;
        $cres = $this->input->post('cres');
        $transaction_id = $this->input->post('threeDSSessionData');
        $threed_challenge_res = $this->sagepay->sagepay_3d_secure_challenge_response($cres,$transaction_id);

        if (!empty($threed_challenge_res) && !empty($threed_challenge_res['status']) && $threed_challenge_res['status'] == "Ok"  ) {
            $retrieve_status = true;
            $data = array(
                'customer_id' => $customer_id,
                'transaction_id' => $transaction_id,
                'cres' => $cres,
            );
            $this->save_sagepay_tansaction($data);
        }

        $this->data['retrieve_status'] = $retrieve_status;
        $this->page_content = $this->load->view('sagepay_gateway/complete/complete', $this->data, true);
        $this->css_content = $this->load->view('sagepay_gateway/complete/complete_css', $this->data, true);
        $this->load->view('sagepay_gateway/master', $this->data);
    }

    public function close() {
        // this function created for close in-app-browser on apps only. dont delete this function.
        echo "this function created for close in-app-browser on apps only. dont delete this function.";
    }

    public function save_sagepay_tansaction($data) {
        if ($data) {
            $this->db->insert('sagepay_transaction',$data);
        }
    }

    public function sagepay_transaction() {
        // dd($this->input->post());
        $post_data = $this->input->post('postData');
        $customer_id = $post_data['customerId'];
        $card_holder_name = $post_data['cardHolderName'];
        $total_amount = $post_data['totalAmount'];
        $card_number = $post_data['number'];
        $expiry_month = $post_data['expiryMonth'];
        $expiry_year = $post_data['expiryYear'];
        $cvc_code = $post_data['cvc'];
        $result = "";
        $msg = "";
        $is_valid = true;
        $ip_address = $this->input->ip_address();
        $ip_address = explode(':', $ip_address);
        if (empty($ip_address[0])) {
            $ip_address = "192.168.0.161";
        } else {
            $ip_address = $this->input->ip_address();
        }

        if ($card_number == "") {
            $is_valid = false;
            $msg = "Card number not provided or valid";
        } else if ($expiry_month == "") {
            $is_valid = false;
            $msg = "Expiry month not provided or valid";
        } else if ($expiry_year == "") {
            $is_valid = false;
            $msg = "Expiry year not provided or valid";
        } else if ($cvc_code == "") {
            $is_valid = false;
            $msg = "CVC not provided or valid";
        } else {
            $total_amount = (int)round(($total_amount * 100), 0);
            if ($total_amount > 0) {
                $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
                if ($customer_info) {
                    $first_name = $customer_info->first_name;
                    $last_name = $customer_info->last_name;
                    $card_holder_name = $first_name . " " . $last_name;
                }
                $expiry_date = $expiry_month."".$expiry_year;
                $card_data = '
                    {
                        "cardDetails": {
                            "cardholderName": "'.$card_holder_name.'",
                            "cardNumber": "'.$card_number.'",
                            "expiryDate": "'.$expiry_date.'",
                            "securityCode": "'.$cvc_code.'"
                        }
                    }
                ';
                $notification_url = base_url('sagepay_gateway/redirect_to_merchant/'.$customer_id);
                $transaction_result = $this->sagepay->sagepay_transaction($card_data,$total_amount,$notification_url);
                list($result,$is_valid,$msg) = $transaction_result;
            } else {
                $is_valid = false;
                $msg = "";
            }
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode(['transactionInfo'=>$result,'isValid'=>$is_valid,'msg'=>$msg]));
    }
}