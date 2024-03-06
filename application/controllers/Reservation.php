<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/cardstream-sdk/gateway.php");
use \P3\SDK\Gateway;

class Reservation extends CI_Controller {
    public $product;

    public function __construct() {
        parent:: __construct();
        $this->product = new Product();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->library('Stripe');
        $this->load->library('Sagepay');
        $this->load->library('email');
        $this->load->helper('security');
        $this->load->helper('shop');
        $this->load->helper('reservation');
        $this->load->helper('settings_helper');
        $this->load->model('Settings_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Booking_customer_Model');
    }

    public function index() {
        $this->session->unset_userdata('reservation_form_data');
        $m_customer = new Customer_Model();
        $customer = null;
        if ($m_customer->customer_is_loggedIn()) {
            $customer_id = $m_customer->get_logged_in_customer_id();
            $customer = $m_customer->get($customer_id);
        }
        $booking_settings = get_settings_values('booking_settings');
        $is_closed = $booking_settings->is_closed;
        $closing_date = '';
        $message = '';
        if ($is_closed) {
            $closing_date = $booking_settings->closing_date;
            $closing_date = explode(',', $closing_date);
            $closing_date = json_encode($closing_date);
            $message = $booking_settings->message;
        }

        list($captcha_image,$captcha_text) = get_captcha_image();
        $this->session->set_userdata('reservation_captcha_text',$captcha_text);

        $this->data['title'] = "Reservation";
        $this->data['product_object'] = $this->product;
        $this->data['customer'] = $customer;
        $this->data['closing_date'] = $closing_date;
        $this->data['message'] = $message;
        $this->data['captcha_image'] = $captcha_image;

        $this->page_content = $this->load->view('reservation/reservation', $this->data, true);
        $this->footer = $this->load->view('footer', $this->data, true);
        $this->load->view('index', $this->data);
    }

    public function check_valid_date($reservation_date = '') {
        if ($this->input->is_ajax_request()) {
            $reservation_date = $this->input->post('date');
        }
        // dd($reservation_date);
        $day_id = date('w',strtotime($reservation_date));
        $status = true;
        $is_shop_closed_status = is_shop_closed_status($day_id);
        list($is_booking_closed_status,$message) = is_booking_closed($reservation_date);
        if ($is_shop_closed_status || $is_booking_closed_status) {
            $status = false;
        } else {
            $message = '';
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'message'=>$message)));
        } else {
            return [$status,$message];
        }
    }

    public function check_valid_time($reservation_time = '') {
        if ($this->input->is_ajax_request()) {
            $reservation_time = $this->input->post('time');
        }
        $message = '';
        $status = is_shop_closed($reservation_time);
        $booking_settings_value = get_settings_values('booking_settings');
        if ($booking_settings_value && $status) {
            $message = $booking_settings_value->message;
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => !$status,'message'=>$message)));
        } else {
            return [!$status,$message];
        }
    }

    public function refresh_captcha() {
        list($captcha_image,$captcha_text) = get_captcha_image();
        $this->session->set_userdata('reservation_captcha_text',$captcha_text);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('captcha_image'=>$captcha_image)));
    }

    public function check_captcha() {
        $is_reservation_payment_available = get_reservation();
        $is_matched = true;
        if ($is_reservation_payment_available == 'no') {
            $session_captcha_text = $this->session->userdata('reservation_captcha_text');
            $captcha_text = $this->input->post('captchaText');
            if ($session_captcha_text && $captcha_text) {
                if ($session_captcha_text != $captcha_text) {
                    $is_matched = false;
                }
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($is_matched));     
    }

    public function save_reservation() {
        // dd($this->input->post());
        $message = '';
        $reservation_id = 0;
        $is_reservation_payment_available = get_reservation();
        $name = trim($this->input->get_post('name'));
        $phone = trim($this->input->get_post('phone'));
        $email = trim($this->input->get_post('email'));
        $booking_purpose = trim($this->input->get_post('booking_purpose'));
        $booking_purpose = (!empty($booking_purpose)) ? xss_clean($booking_purpose) : '';
        $reservation_date = trim($this->input->get_post('reservation_date'));

        $reservation_date = get_formatted_date($reservation_date, 'Y-m-d');
        $start_time_hr = trim($this->input->get_post('start_time_hr'));
        $start_time_min = trim($this->input->get_post('start_time_min'));
        $start_time_am_pm = trim($this->input->get_post('start_time_am_pm'));
        $number_of_guest = trim($this->input->get_post('number_of_guest'));
        $payment_method = trim($this->input->get_post('payment_method'));
        $transaction_id = "";
        $amount = get_reservation_amount() + (int) get_property_value('surcharge', get_payment_settings());
        // dd($amount);

        if (empty($start_time_hr)) {
            $start_time_hr = '00';
        }

        if (empty($start_time_min)) {
            $start_time_min = '00';
        }

        $start_time = $start_time_hr.':'.$start_time_min.' '.$start_time_am_pm;
        // dd($this->check_valid_time($start_time));

        $customer_id = 0;
        $session_captcha_text = $this->session->userdata('reservation_captcha_text');
        $captcha_text = $this->input->post('captcha_text');
        $is_captcha_matched = false;
        if ($is_reservation_payment_available == 'yes') {
            $is_captcha_matched = true;
        } else if ($session_captcha_text == $captcha_text) {
            $is_captcha_matched = true;
        }

        $this->form_validation->set_rules($this->Booking_customer_Model->reservation_rules);
      
        $date_now = date("Y-m-d",strtotime("-1 days"));
        list($is_reservation_date_valid,$is_reservation_date_invalid_message) = $this->check_valid_date($reservation_date);
        list($is_reservation_time_valid,$is_reservation_time_invalid_message) = $this->check_valid_time($start_time);
      
        if (!$this->form_validation->run() || $number_of_guest <= 0 || $reservation_date <= $date_now || !$is_captcha_matched || !$is_reservation_date_valid || !$is_reservation_time_valid) {
            // $message = 'Please Check your input fields.';
            $message = validation_errors();
            if (!$is_reservation_date_valid) {
                $message = $is_reservation_date_invalid_message;
            } else if(!$is_reservation_time_valid) {
                $message = $is_reservation_time_invalid_message;
            } else if (!$is_captcha_matched) {
                $message = "Captcha not matched";
            }
            $this->session->set_userdata('booking_form_data',$this->input->post());
            $this->session->set_flashdata('error_msg', $message);
            redirect('reservation');
        } else {
            $is_saved = false;
            $is_card_payemnt = true;
            $m_customer = new Customer_Model();
            $customer_id = 0;

            if ($m_customer->customer_is_loggedIn()) {
                $customer_id = $m_customer->get_logged_in_customer_id();
            }

            $form_data = array(
                'transaction_id' => $transaction_id,
                'amount' => $amount,
                'CustomerName' => $name,
                'CustomerPhone' => $phone,
                'NumberOfGuest' => $number_of_guest,
                'email' => $email,
                'mobile' => $phone,
                'BookingTime' => $reservation_date,
                'ExpireTime' => '',
                'StartTime' => $start_time,
                'CustomerId' => $customer_id,
                'BookingPurpose' => $booking_purpose,
                'TempOrderInformationId' => 0,
                'booking_status' => 'pending',
            );

            if ($payment_method == 'stripe') {
                $display_name = get_stripe_display_name();
                $stripe_token = $this->input->get_post('stripe_token');
                if ($stripe_token) {
                    $retrive_payment = $this->stripe->retrive_payment_intent($stripe_token);
                    $form_data['transaction_id'] = $retrive_payment->id;
                    // dd($form_data);
                    $is_saved = $this->insert_reservation_data($form_data);
                    if ($is_saved == false) {
                        $cancel_payment = $this->stripe->cancel_payment_intent($stripe_token);
                    }
                } else {
                    $is_card_payemnt = false;
                    $display_name = get_stripe_display_name();
                    $stripe = $this->session->userdata('stripe_token');
                    if ($stripe) {
                        $this->stripe->cancel_payment_intent($stripe);
                    }
                }
                $this->session->unset_userdata('stripe_token');
            } else if ($payment_method == 'sagepay') {
                $sagepay_status = $this->input->get_post('sagepay_status');
                $transaction_id = $this->input->get_post('sagepay_transaction_id');
                $retrieve_status = false;
                if ($sagepay_status == "3DAuth") {
                    $cres = $this->input->get_post('cres');
                    if ($cres) {
                        $threed_challenge_res = $this->sagepay->sagepay_3d_secure_challenge_response($cres,$transaction_id);
                        if ($threed_challenge_res && isset($threed_challenge_res['status']) && $threed_challenge_res['status'] != "Ok") {
                            $is_card_payemnt = false;
                        }
                    } else {
                        $transaction_id = $this->input->get_post('MD');
                        $threeDResult = $this->sagepay->complete_3d_secure_sagepay_transaction($_POST);
                        if ($threeDResult && isset($threeDResult['status']) && $threeDResult['status'] != "Authenticated"  ) {
                            $is_card_payemnt = false;
                        }
                    }                    
                } else if ($sagepay_status != "Ok") {
                    $is_card_payemnt = false;
                }

                if ($is_card_payemnt == false) {
                    $display_name = get_sagepay_display_name();
                    $is_card_payemnt = false;
                } else {
                    $transaction_info = $this->sagepay->retrieve_sagepay_transaction($transaction_id);
                    if ($transaction_info['status'] == "Ok") {
                        $form_data['transaction_id'] = $transaction_info['transactionId'];
                        $is_saved = $this->insert_reservation_data($form_data);
                    }
                }
            } else if ($payment_method == 'cardstream') {
                $is_success = $this->input->post('cardstream_transaction_response_code');
                $this->session->unset_userdata('reservation_form_data');
                if ($is_success == 0) {
                    $form_data['transaction_id'] = $this->input->post('cardstream_transaction_id');
                    $is_saved = $this->insert_reservation_data($form_data);
                } else {
                    $display_name = get_cardstream_display_name();
                    $is_card_payemnt = false;
                }
            } else {
                $form_data['amount'] = 0;
                $is_saved = $this->insert_reservation_data($form_data);
            }

            if ($is_saved) {
                $message = 'Reservation Successful.';
                $this->session->set_flashdata('success_msg', $message);
            } else {
                $message = 'Reservation failed';
                if ($is_card_payemnt == false) {
                    $message .= ', because '.$display_name.' payment is not done.';
                }
                $this->session->set_flashdata('error_msg', $message);
            }
            $this->session->unset_userdata('booking_form_data');
            redirect('reservation');
        }
    }

    public function insert_reservation_data($form_data) {
        $result = $this->Booking_customer_Model->save($form_data);
        $reservation_id = $this->db->insert_id();

        if ($result) {
            $this->data['booking'] = $this->Booking_customer_Model->get($reservation_id, true);
            $message = $this->load->view('email_template/reservation', $this->data, true);
            $this->Booking_customer_Model->api_send_mail($form_data['email'], $message);;
        }

        return $result;
    }

    public function get_customer_insert_or_update($data_for_customer) {
        $customer = $this->Customer_Model->get_customer_by_phone_mobile_email($data_for_customer['phone'], $data_for_customer['mobile'], $data_for_customer['email']);
        $customer_id = !empty($customer) ? $customer->id : '';
        $customer_data = array(
            'id' => $customer_id,
            'title' => !empty($data_for_customer['title']) ? $data_for_customer['title'] : '',
            'first_name' => !empty($data_for_customer['name']) ? $data_for_customer['name'] : '',
            'email' => !empty($data_for_customer['email']) ? $data_for_customer['email'] : '',
            'telephone' => !empty($data_for_customer['phone']) ? $data_for_customer['phone'] : '',
            'mobile' => !empty($data_for_customer['mobile']) ? $data_for_customer['mobile'] : '',
            'billing_address_line_1' => !empty($data_for_customer['address']) ? $data_for_customer['address'] : '',
            'date_of_birth' => !empty($data_for_customer['date_of_birth']) ? $data_for_customer['date_of_birth'] : '',
        );

        if (!empty($customer_id) && ((int)$customer_id > 0)) {
           // $this->Customer_Model->where_column = 'id';
           // $result = $this->Customer_Model->save($customer_data, $customer_id);
        } else {
            $result = $this->Customer_Model->save($customer_data);
            $customer_id = $this->db->insert_id();
        }
        return $customer_id;
    }

#Region Stripe
    public function check_stripe_order_process() {  
        return true;
    }

    public function create_payment_intent() {
        // dd($this->input->post());
        if ($this->input->is_ajax_request()) {
            $output = '';
            $amount = get_reservation_amount() + (int) get_property_value('surcharge', get_payment_settings());
            $is_valid = $this->check_stripe_order_process();
            list($publishable_key,$client_secret,$token) = $this->stripe->create_payment_intent($amount);
            $this->session->set_userdata('stripe_token',$token);

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'publishableKey'=>$publishable_key,
                'clientSecret'=>$client_secret,
                'token'=>$token,
                'isValid' => $is_valid
            )));
        }
    }
#End Region

#Region Sagepay
    public function sagepay_transaction() {
        // dd($this->input->post());
        $post_data = $this->input->post('post_data');
        $form_data = $this->input->post('formData');
        $this->session->set_userdata('reservation_form_data',$form_data);

        $sagepay_card_number = $post_data['sagepay_card_number'];
        $sagepay_expiry_mm = $post_data['sagepay_expiry_mm'];
        $sagepay_expiry_yy = $post_data['sagepay_expiry_yy'];
        $sagepay_security_code = $post_data['sagepay_security_code'];
        $card_holder_name = $post_data['card_holder_name'];

        $result = "";
        $msg = "";
        $is_valid = true;
        $error_layer = 1;
        $ip_address = $this->input->ip_address();
        $ip_address = explode(':', $ip_address);
        if (empty($ip_address[0])) {
            $ip_address = "192.168.0.161";
        } else {
            $ip_address = $this->input->ip_address();
        }

        if ($sagepay_card_number == "") {
            $is_valid = false;
            $msg = "Please Enter Card Number";
        } else if ($sagepay_expiry_mm == "") {
            $is_valid = false;
            $msg = "Please Enter Expiry Month";
        } else if ($sagepay_expiry_yy == "") {
            $is_valid = false;
            $msg = "Please Enter Expiry Year";
        } else if ($sagepay_security_code == "") {
            $is_valid = false;
            $msg = "Please Enter CVC";
        } else {
            $error_layer = 2;
            $total_amount = get_reservation_amount();

            if ($total_amount > 0) {
                $error_layer = 3;
                $sagepay_expiry_date = $sagepay_expiry_mm."".$sagepay_expiry_yy;
                $card_data = '
                    {
                        "cardDetails": {
                            "cardholderName": "'.$card_holder_name.'",
                            "cardNumber": "'.$sagepay_card_number.'",
                            "expiryDate": "'.$sagepay_expiry_date.'",
                            "securityCode": "'.$sagepay_security_code.'"
                        }
                    }
                ';
                $notification_url = base_url('reservation/redirect_to_merchant');
                $transaction_result = $this->sagepay->sagepay_transaction($card_data,$total_amount,$notification_url);
                list($result,$is_valid,$msg) = $transaction_result;
            } else {
                $is_valid = false;
                $msg = "Card payment are incomplete, please contact to authority.";
            }
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['transaction_info'=>$result,'is_valid'=>$is_valid,'error_layer'=>$error_layer,'msg'=>$msg]));
        } else {
            return $result;
        }
    }

    public function redirect_to_merchant() {
        // dd($this->input->post());
        $cres = $this->input->post('cres');
        $transaction_id = $this->input->post('threeDSSessionData');
        $form_data = $this->session->userdata('reservation_form_data');
        parse_str($form_data,$form_data);
        $form_data['sagepay_status'] = "3DAuth";
        $form_data['sagepay_transaction_id'] = $transaction_id;
        $form_data['cres'] = $cres;
        $form_data = json_encode($form_data);
        $total_amount = get_reservation_amount();
        $this->data['form_data'] = $form_data;
        $this->data['total_amount'] = $total_amount;

        $this->load->view('reservation/payment_gateways/sagepay/reservation_form_for_sagepay_3d', $this->data);
    }
#End Region

#Region Cardstrem
    public function cardstream_transaction() {
        // Signature key entered on MMS. The demo account is fixed to this value,
        Gateway::$merchantSecret = get_cardstream_signature_key();
        
        // Gateway URL
        Gateway::$directUrl = get_cardstream_active_url();
        
        $pageUrl = base_url('reservation/cardstream_transaction');
        $pageUrl .= (strpos($pageUrl, '?') === false ? '?' : '&') . 'sid=' . urlencode(session_id());

        // If ACS response into the IFRAME then redirect back to parent window
        if (!empty($_GET['acs'])) {
            echo $this->silentPost($pageUrl, array('threeDSResponse' => $_POST), '_parent'); exit();
        }
        
        if (!isset($_POST['threeDSResponse'])) {
            $post_data = array();
            $session_post_data = $this->session->userdata('reservation_form_data');
            // dd($session_post_data);
            if ($session_post_data) {
                parse_str($session_post_data,$post_data);
                // dd($post_data);
            } else {
                $post_data = $_POST;
                $serialized_post_data = serialize_data($post_data);
                $this->session->set_userdata('reservation_form_data',$serialized_post_data);
            }
            // dd($post_data);
            $card_holder_name = $post_data['name'];
            $total_amount = get_reservation_amount();
            $total_amount = (int) round(($total_amount * 100), 0);
            // dd($total_amount);
            
            // Gather browser info - can be done at any time prior to the checkout
            if (!isset($_POST['browserInfo'])) {
                echo Gateway::collectBrowserInfo(); exit();
            }
            
            $cardstream_card_number = $post_data['cardstream_card_number'];
            $cardstream_expiry_date = $post_data['cardstream_expiry_date'];
            $cardstream_security_code = $post_data['cardstream_security_code'];
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
                'customerEmail' => $post_data['email'],
                'customerAddress' => '',
                'customerPostCode' => '',
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
                // Send request to the ACS server displaying response in an IFRAME
                // Render an IFRAME to show the ACS challenge (hidden for fingerprint method)
                /* $style = (isset($res['threeDSRequest']['threeDSMethodData']) ? 'display: none;' : ''); */
                
                /* echo "<iframe name=\"threeds_acs\" style=\"height:420px; width:420px; {$style}\"></iframe>\n"; */
                // echo "<div name=\"threeds_acs\" style=\"height:420px; width:420px; {$style}\"></div>\n";
                
                // Silently POST the 3DS request to the ACS in the IFRAME
                /* echo $this->silentPost($res['threeDSURL'], $res['threeDSRequest'], 'threeds_acs'); */
                
                // Remember the threeDSRef as need it when the ACS responds
                /* $_SESSION['threeDSRef'] = $res['threeDSRef']; */
                
                $this->data['res'] = $res;
                $this->data['silent_post'] = $this->silentPost($res['threeDSURL'], $res['threeDSRequest'], 'threeds_acs');;
                $this->page_content = $this->load->view('reservation/payment_gateways/cardstream/cardstream_transaction', $this->data, true);
                $this->load->view('index',$this->data);
                $this->load->view('footer',$this->data, true);
                $_SESSION['threeDSRef'] = $res['threeDSRef'];
            } else if ($res['responseCode'] === Gateway::RC_SUCCESS) {
                $message = "<p>Thank you for your payment.</p>";
                $is_redirect = true;
            } else {
                $message = "<p>Failed to take payment: " . htmlentities($res['responseMessage']) . "</p>";
                $is_redirect = true;
            }
            if ($is_redirect) {
                $form_data = $this->session->userdata('reservation_form_data');
                parse_str($form_data,$form_data);
                $form_data['cardstream_transaction_id'] = $res['transactionID'];
                $form_data['cardstream_transaction_response_code'] = $res['responseCode'];
                $form_data['cardstream_transaction_response_message'] = $message;
                $form_data = json_encode($form_data);
                $this->data['form_data'] = $form_data;
                $this->data['total_amount'] = $res['amount'];
                $this->load->view('reservation/payment_gateways/cardstream/reservation_form_for_cardstream', $this->data);
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
#End Region
}