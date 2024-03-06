<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/cardstream-sdk/gateway.php");
use \P3\SDK\Gateway;

class Cardstream_gateway extends Frontend_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->helper('settings');
        $this->load->model('Customer_Model');
        $this->load->model('Cardstream_transaction_model');
    }

    public function payment() {
        $this->session->unset_userdata('form_data');
        $this->data['customer_id'] = $_GET['ci'];
        $this->data['total_amount'] = $_GET['tc'];
        $this->data['card_holder_name'] = '';
        if (isset($_GET['chn'])) {
            $this->data['card_holder_name'] = $_GET['chn'];
        }
        $this->page_content = $this->load->view('cardstream_gateway/payment/payment', $this->data, true);
        $this->script_content = $this->load->view('cardstream_gateway/payment/payment_script', $this->data, true);
        $this->css_content = $this->load->view('cardstream_gateway/payment/payment_css', $this->data, true);
        $this->load->view('sagepay_gateway/master', $this->data);
    }

    public function redirect_to_merchant($customer_id) {
        $retrieve_status = false;
        $transaction_info = $this->session->userdata('cardstream_transaction_info');
        if ($transaction_info['response_code'] == 0) {
            $retrieve_status = true;
            $data = array(
                'customer_id' => $customer_id,
                'transaction_id' => $transaction_info['transaction_id'],
            );
            $this->save_cardstream_tansaction($data);
        }

        $this->session->unset_userdata('cardstream_transaction_info');
        $this->data['retrieve_status'] = $retrieve_status;
        $this->page_content = $this->load->view('sagepay_gateway/complete/complete', $this->data, true);
        $this->css_content = $this->load->view('sagepay_gateway/complete/complete_css', $this->data, true);
        $this->load->view('sagepay_gateway/master', $this->data);
    }

    public function close() {
        // this function created for close in-app-browser on apps only. dont delete this function.
        echo "this function created for close in-app-browser on apps only. dont delete this function.";
    }

    public function save_cardstream_tansaction($data) {
        if ($data) {
            $this->db->insert('cardstream_transaction',$data);
        }
    }

    public function cardstream_transaction() {
        // Signature key entered on MMS. The demo account is fixed to this value,
        Gateway::$merchantSecret = get_cardstream_signature_key();
        
        // Gateway URL
        Gateway::$directUrl = get_cardstream_active_url();
        
        $pageUrl = base_url('cardstream_gateway/cardstream_transaction');
        $pageUrl .= (strpos($pageUrl, '?') === false ? '?' : '&') . 'sid=' . urlencode(session_id());

        // If ACS response into the IFRAME then redirect back to parent window
        if (!empty($_GET['acs'])) {
            echo $this->silentPost($pageUrl, array('threeDSResponse' => $_POST), '_parent'); exit();
        }
        
        if (!isset($_POST['threeDSResponse'])) {
            // dd($_POST);
            $post_data = array();
            $session_post_data = $this->session->userdata('form_data');
            // dd($session_post_data);
            if ($session_post_data) {
                parse_str($session_post_data,$post_data);
                // dd($post_data);
            } else {
                $post_data = $_POST;
                $serialized_post_data = serialize_data($post_data);
                $this->session->set_userdata('form_data',$serialized_post_data);
            }
            $card_holder_name = $post_data['card_holder_name'];
            $customer_email = '';
            $customer_delivery_address = '';
            $customer_delivery_postcode = '';
            $customer_id = $post_data['customer_id'];
            $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
            if ($customer_info) {
                $first_name = $customer_info->first_name;
                $last_name = $customer_info->last_name;
                $card_holder_name = $first_name . " " . $last_name;
                $customer_email = $customer_info->email;
                $customer_delivery_address = $customer_info->delivery_address_line_1;
                // $customer_delivery_postcode = $customer_info->delivery_postcode;
                $customer_delivery_postcode = "";
            }
            $total_amount = $post_data['total_amount'];
            $total_amount = (int)round(($total_amount * 100), 0);
            // dd($total_amount);
            
            // Gather browser info - can be done at any time prior to the checkout
            if (!isset($_POST['browserInfo'])) {
                echo Gateway::collectBrowserInfo(); exit();
            }
            
            $cardstream_card_number = $post_data['card_number'];
            $cardstream_expiry_date = $post_data['expiry_date'];
            $cardstream_security_code = $post_data['security_code'];
            $cardstream_expiry_month = $cardstream_expiry_date[0];
            $cardstream_expiry_year = $cardstream_expiry_date[1];

            $req = array(
                'merchantID' => get_cardstream_marchant_account_id(),
                'action' => 'SALE',
                'type' => 1,
                'currencyCode' => 826,
                'countryCode' => 826,
                'amount' => $total_amount,
                'cardNumber' => $cardstream_card_number,
                'cardExpiryMonth' => $cardstream_expiry_month,
                'cardExpiryYear' => $cardstream_expiry_year,
                'cardCVV' => $cardstream_security_code,
                'customerName' => $card_holder_name,
                'customerEmail' => $customer_email,
                'customerAddress' => $customer_delivery_address,
                'customerPostCode' => $customer_delivery_postcode,
                'orderRef' => 'Test purchase',
                // The following fields are mandatory for 3DS
                'remoteAddress' => $_SERVER['REMOTE_ADDR'],
                'threeDSRedirectURL' => $pageUrl . '&acs=1',
                // The following field allows options to be passed for 3DS
                // and the values here are for demonstration purposes only
                'threeDSOptions' => array(
                    'paymentAccountAge' => '20190601',
                    'paymentAccountAgeIndicator' => '05',
                ),
                'duplicateDelay' => 0,
            );
            // Append the fields contained in browserInfo to the request as some are
            // mandatory for 3DS as detailed in section 5.5.5 of the Integration Guide.
            $req += $_POST['browserInfo'];
            // dd($req);
        } else {
            // 3DS continuation request
            $req = array(
                // The following field are only required for tbe benefit of the SDK
                'merchantID' => get_cardstream_marchant_account_id(),
                'action' => 'SALE',
                // The following field must be passed to continue the 3DS request
                'threeDSRef' => $_SESSION['threeDSRef'],
                'threeDSResponse' => $_POST['threeDSResponse'],
            );
        }

        try {
            $is_redirect = false;
            $res = Gateway::directRequest($req);
            
            // Check the response code
            if ($res['responseCode'] === Gateway::RC_3DS_AUTHENTICATION_REQUIRED) {
                $this->data['res'] = $res;
                $this->data['silent_post'] = $this->silentPost($res['threeDSURL'], $res['threeDSRequest'], 'threeds_acs');
                $this->page_content = $this->load->view('cardstream_gateway/transactions/transaction', $this->data, true);
                $this->script_content = $this->load->view('cardstream_gateway/transactions/transaction_script', $this->data, true);
                $this->css_content = $this->load->view('cardstream_gateway/transactions/transaction_css', $this->data, true);
                $this->load->view('sagepay_gateway/master', $this->data);
                $_SESSION['threeDSRef'] = $res['threeDSRef'];
            } else if ($res['responseCode'] === Gateway::RC_SUCCESS) {
                $message = "<p>Thank you for your payment.</p>";
                $is_redirect = true;
            } else {
                $message = "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>";
                $is_redirect = true;
            }
            if ($is_redirect) {
                $post_data = array();
                $session_post_data = $this->session->userdata('form_data');
                parse_str($session_post_data,$post_data);
                $customer_id = $post_data['customer_id'];
                $transaction_info = array('transaction_id'=>$res['transactionID'],'response_code'=>$res['responseCode']);

                $this->session->set_userdata('cardstream_transaction_info',$transaction_info);
                redirect(base_url("cardstream_gateway/redirect_to_merchant/$customer_id"));
            }
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    // Render HTML to silently POST data to URL in target brower window
    public function silentPost($url = '?', array $post = null, $target = '_self') {
        $url = htmlentities($url);
        $target = htmlentities($target);
        $fields = '';
        if ($post) {
            foreach ($post as $name => $value) {
                $fields .= Gateway::fieldToHtml($name, $value);
            }
        }
        $ret = "
            <form id=\"silentPost\" action=\"{$url}\" method=\"post\" target=\"{$target}\">
                {$fields}
                <noscript><input type=\"submit\" value=\"Continue\"></noscript>
            </form>
            <script>window.setTimeout('document.forms.silentPost.submit()', 0);</script>
        ";
        return $ret;
    }
}