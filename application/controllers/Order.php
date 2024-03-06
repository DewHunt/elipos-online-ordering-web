<?php
require_once(APPPATH."libraries/cardstream-sdk/gateway.php");
use \P3\SDK\Gateway;

class Order extends Frontend_Controller
{
    public $product;
    public $discount = 0;
    public $publishable_key = '';
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('PayPalPaymentGateway');
        $this->load->library('curl');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->library('Sagepay');
        $this->load->library('Stripe');
        $this->load->helper('cookie');
        $this->load->helper(array('form'));
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Settings_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Card_Order_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('Voucher_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Tips_model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('FreeItem_Model');
        $this->product = new Product();
        isTodayIsHoliday();

        $stripe_details = get_stripe_settings();
    }

    public function index() {
        if (is_shop_closed() && !is_pre_order() && is_shop_maintenance_mode() || is_shop_weekend_off()) {
            redirect('menu');
        }

        $this->data['title'] = 'Order';
        $this->data['payment_method'] = '';
        $order_type_value = get_sess_order_type();
        $session_dine_in_table_number_id = $this->session->userdata('dine_in_table_number_id');
        $session_dine_in_table_number = $this->session->userdata('dine_in_table_number');

        if ($order_type_value == 'dine_in' && empty($session_dine_in_table_number_id)) {
            $this->session->set_flashdata('order_type_error_message',' Please Select Your Desired Table.');
            redirect('menu');
        }

        if (!empty($this->cart->contents())) {
            $this->FreeItem_Model->removeAllFreeItem();
            $this->FreeItem_Model->addFreeItem();
            if ($this->Customer_Model->customer_is_loggedIn() == true) {
                $this->session->set_userdata('menu_page_session', ''); //checkout button don't work for this page
                if (!empty($this->session->userdata('order_type_session'))) {
                    $order_type_session = $this->session->userdata('order_type_session');
                } else {
                    $order_type = 'collection';
                    $this->session->set_userdata('order_type_session', $order_type);
                    $order_type_session = $this->session->userdata('order_type_session');
                }

                //$order_type_session = $this->session->userdata('delivery_charge_info_session');
                $customer_id = $this->session->userdata('customer_id');
                $customer_name = $this->session->userdata('customer_name');
                $customer = $this->Customer_Model->get($customer_id, true);
                $tips_lists = $this->Tips_model->get_all_tips_by_status();
                $this->data['customer_latest_information'] = $customer;
                $this->data['product_object'] = $this->product;
                $this->data['product_cart'] = $this->load->view('cart/summary', $this->data, true);
                $this->tips['tips_lists'] = $tips_lists;
                $this->data['tips_options'] = $this->load->view('my_account/tips_lists_table',$this->tips,true);
                $this->data['tips_modal_status'] = 'no';
                if ($tips_lists) {
                    $this->data['tips_modal_status'] = 'yes';
                }

                if (!empty($order_type_session)) {
                    $this->data['customer'] = $customer;
                    $_SESSION["customer_session"] = $customer;
                    $this->data['order_type'] = $order_type_session;

                    $this->page_content = $this->load->view('my_account/billing_information_new', $this->data, true);
                    $this->load->view('index',$this->data);
                    $this->load->view('footer',$this->data, true);
                } else {
                    $this->session->set_flashdata('order_type_error_message',' Please Select an order Type');
                    redirect('menu');
                }
            } else {
                redirect('my_account');
            }
        } else if (empty($this->session->userdata('delivery_charge_info_session'))) {
            $this->session->set_flashdata('order_type_error_message',' Please Select an order Type');
            redirect('menu');
        } else {
            $this->session->set_flashdata('order_type_error_message',' Please Select an order Type');
            redirect('menu');
        }
    }

    public function get_service_charges() {
        $order_type = $this->input->post('order_type');
        $payment_mode = $this->input->post('payment_mode');
        $this->session->set_userdata('order_payment_method',$payment_mode);
        $service_charge = $this->Customer_Model->get_service_charge($order_type,$payment_mode);
        $product_cart = $this->load->view('cart/summary', $this->data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('product_cart'=>$product_cart)));
    }

    public function set_tips($tips_id = 0) {
        $this->session->unset_userdata('tips_amount');
        $tips_amount = 0;
        if ($tips_id > 0) {
            $tips_info = $this->Tips_model->get_tips_by_id($tips_id);
            if ($tips_info) {
                $tips_amount = $tips_info->amount;
            }
        }
        $this->session->set_userdata('tips_amount',$tips_amount);
    }

    public function order_process() {
        // dd($this->input->post());
        if (is_shop_closed() && !is_pre_order() && is_shop_maintenance_mode() || is_shop_weekend_off()) {
            redirect('menu');
        }

        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $this->form_validation->set_rules($this->Order_information_Model->order_submit_rules);
            // echo $this->form_validation->run();
            // echo validation_errors();
            // dd($this->input->post());
            if ($this->form_validation->run() == false) {
                set_flash_message(validation_errors());
                redirect('order');
            } else {
                $terms_conditions = trim($this->input->get_post('terms_conditions'));
                $delivery_time = trim($this->input->get_post('delivery_time'));
                $order_type = trim($this->input->get_post('order_type'));
                $tips_id = $this->input->get_post('tips_id');
                $this->set_tips($tips_id);

                if (empty($terms_conditions)) {
                    set_flash_message('You must agree to our Terms and Conditions');
                    redirect('order');
                }

                if (empty($delivery_time) || empty($order_type)) {
                    redirect('order');
                }
                
                $cart_content = $this->cart->contents();
                $cart_total = $this->cart->total();
                $total_buy_get_amount = get_total_from_cart('buy_get_amount');
                $cart_sub_total = $cart_total - $total_buy_get_amount;

                $isValidOrderType = isCartValidWithOrderType(trim($order_type), $cart_content);
                if (!$isValidOrderType) {
                    $cartHasItemOf = ($order_type == 'collection') ? 'Delivery' : 'Collection';
                    $cartOrderTypeChangeMessage = 'Your cart has only for '.$cartHasItemOf.' Item';
                    set_flash_message($cartOrderTypeChangeMessage);
                    redirect('order');
                }

                $shop_details = get_company_details();
                $minimum_order_amount = get_property_value('minimum_order_amount', $shop_details);
                $delivery_charge = 0;
                
                if (!empty($order_type) && $order_type == 'delivery') {
                    $delivery_postcode = trim($this->input->get_post('delivery_postcode'));
                    $delivery_address_line_1 = trim($this->input->get_post('delivery_address_line_1'));

                    if (empty($delivery_postcode)) {
                        set_flash_message('Delivery postcode is missing');                    
                        redirect('order');
                    }

                    if (empty($delivery_address_line_1)) {
                        set_flash_message('Delivery address is missing ');                    
                        redirect('order');
                    }

                    $m_allowed_miles = new Allowed_miles_Model();
                    $allowed_miles = $m_allowed_miles->getDistanceDeliveryCharge($delivery_postcode);
                    $delivery_charge = $this->session->userdata('delivery_charge');
                    $is_valid = false;

                    if (!empty($allowed_miles)) {
                        $delivery_charge = $allowed_miles->delivery_charge;
                        $minimum_order_amount = $allowed_miles->min_order_for_delivery;
                        $min_amount_for_free_delivery_charge = $allowed_miles->min_amount_for_free_delivery_charge;
                        $is_valid = true;
                    } else {
                        $m_allowed_post_code_model = new Allowed_postcodes_Model();
                        $delivery_details = $m_allowed_post_code_model->get_delivery_charge_by_postcode($delivery_postcode);
                        if (!empty($delivery_details)) {
                            $is_valid = true;
                            $delivery_charge = $delivery_details->delivery_charge;
                            $minimum_order_amount = $delivery_details->min_order_for_delivery;
                            $min_amount_for_free_delivery_charge = $delivery_details->min_amount_for_free_delivery_charge;
                        }
                    }

                    if (!$is_valid) {
                        set_flash_message($m_allowed_miles->get_miles_error_message());                  
                        redirect('order');
                    }

                    if ($cart_sub_total < $minimum_order_amount) {
                        set_flash_message('Minimum order amount for delivery is '.get_price_text($minimum_order_amount));
                        redirect('order');
                    }
                } else {
                    if ($cart_sub_total < $minimum_order_amount) {
                        set_flash_message('Minimum order amount for collection is '.get_price_text($minimum_order_amount));
                        redirect('order');
                    }
                }

                if (isset($min_amount_for_free_delivery_charge) && !empty($min_amount_for_free_delivery_charge) && $min_amount_for_free_delivery_charge > 0 && $min_amount_for_free_delivery_charge < $cart_sub_total) {
                    $delivery_charge = 0;
                }

                $form_data = $this->Customer_Model->data_form_post(array('id','first_name','last_name','email','mobile','delivery_address_line_1','delivery_postcode'));
                //Update Customer Information
                $this->customer_update($form_data);

                $payment_method = trim($this->input->get_post('payment_method'));
                $coupon_code = $this->input->get_post('coupon_code');
                $coupon_id = 0;
                $notes = trim($this->input->get_post('notes'));
                $order_type_session = $this->session->userdata('order_type_session');
                $payment_settings = get_payment_settings();
                $service_charge = 0;
                $packaging_charge = 0;
                $couponDiscount = 0;
                $tips_amount = 0;
                $surcharge = 0;
                $discount = 0;

                $customer_id = $this->Customer_Model->get_logged_in_customer_id();

                if ($cart_content) {
                    $discount = $this->Customer_Model->get_discount_amount($cart_content,$order_type,$customer_id);
                }

                if (!empty($coupon_code)) {
                    $couponDiscount = $this->Voucher_Model->getDiscountAmountFromValidCoupon($coupon_code,$order_type,$cart_sub_total);
                }

                if ($couponDiscount > $discount) {
                    $coupon_id = $this->session->userdata('coupon_id');
                    $discount = $couponDiscount;
                    $this->Voucher_Model->updateCouponRemainingUsagesByCode($coupon_code);
                }

                if ($payment_method != 'cash') {
                    $surcharge = (int) get_property_value('surcharge', $payment_settings);
                }

                if (!empty($this->session->userdata('tips_amount'))) {
                    $tips_amount = $this->session->userdata('tips_amount');
                }

                $service_charge = $this->Customer_Model->get_service_charge($order_type,$payment_method);
                $packaging_charge = $this->Customer_Model->get_packaging_charge($order_type);
                $total_buy_get_amount = get_total_from_cart('buy_get_amount');

                $total = ($cart_total + $delivery_charge + $service_charge + $packaging_charge + $tips_amount + $surcharge) - ($discount + $total_buy_get_amount);

                if ($total <= 0) {
                    // minimum order
                    redirect('order');
                }

                $is_pre_order = is_pre_order();
                $order_details = array(
                    'order_type' => $order_type,
                    'delivery_time' => $delivery_time,
                    'payment_method' => $payment_method,
                    'order_note' => $notes,
                    'delivery_charge' => $delivery_charge,
                    'is_pre_order' => $is_pre_order,
                    'discount' => $discount,
                    'service_charge' =>$service_charge,
                    'packaging_charge' =>$packaging_charge,
                    'tips' => $tips_amount,
                    'surcharge' => $surcharge,
                );

                set_order_submitted();

                $this->data['payment_method'] = $payment_method;
                $this->data['order_type'] = $order_type;
                
                if ($payment_method == 'cash') {
                    //Order Information Insertion
                    $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,$payment_method,$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$coupon_id,$tips_amount,$service_charge,$packaging_charge);
                    $message = '';
                    if ($order_information_save_result) {
                        $message = 'Your order has been placed successfully';
                    } else {
                        $message = 'because of our server error, Please try again';
                    }

                    $order_submitted_details = array(
                        'payment_method' => ucfirst($payment_method),
                        'order_type' => ucfirst($order_type),
                        'is_order_placed' => $order_information_save_result,
                        'message' => $message,
                    );

                    set_submitted_order_details($order_submitted_details);
                    set_order_placed($order_information_save_result);
                    if ($order_information_save_result) {
                        $this->Voucher_Model->saveAndSendCouponVoucher($total, $order_type, $customer_id);
                    }
                    redirect('order/message');
                } else if ($payment_method == 'nochex') {
                    $this->load->model('Card_Order_Model');
                    $m_card_order_model = new Card_Order_Model();
                    $cart_contents = $this->cart->contents();
                    $cart_contents_json = (!empty($cart_contents)) ? json_encode($cart_contents) : null;
                    $m_card_order_model->save(array('cart_contents' => $cart_contents_json, 'customer_id' => $customer_id, 'payable_amount' => $total,));
                    $card_order_id = $m_card_order_model->db->insert_id();
                    $nochex_order_id = $card_order_id . '-' . $customer_id . '-' . time();
                    $order_details['nochex_order_id'] = $nochex_order_id;
                    $order_details['card_order_id'] = $card_order_id;
                    $m_card_order_model->save(array('nochex_order_id' => $nochex_order_id, 'order_info' => json_encode($order_details)), $card_order_id);
                    $this->session->set_userdata('nochex_order_details', json_encode($order_details));
                    $nochex_settings = get_nochecx_settings();

                    $merchant_id = property_exists($nochex_settings, 'nochecx_merchant_email') ? $nochex_settings->nochecx_merchant_email : '';
                    $description = property_exists($nochex_settings, 'nochecx_description') ? $nochex_settings->nochecx_description : '';
                    $description = property_exists($nochex_settings, 'nochecx_description') ? $nochex_settings->nochecx_description : '';
                    $callback_url = property_exists($nochex_settings, 'nochecx_callback_url') ? $nochex_settings->nochecx_callback_url : '';
                    $success_url = property_exists($nochex_settings, 'nochecx_success_url') ? $nochex_settings->nochecx_success_url : '';
                    $cancel_url = property_exists($nochex_settings, 'nochecx_cancel_url') ? $nochex_settings->nochecx_cancel_url : '';

                    $this->data['merchant_id'] = $merchant_id;
                    $this->data['description'] = $description;
                    $this->data['callback_url'] = $callback_url;
                    $this->data['success_url'] = $success_url;
                    $this->data['cancel_url'] = $cancel_url;
                    $this->data['nochex_order_id'] = $nochex_order_id;
                    $this->data['total'] = $total;
                    $this->load->view('my_account/nochex_wait', $this->data);
                } else if ( $payment_method == 'cardstream') {
                    $order_information_save_result = false;
                    $display_name = get_sagepay_display_name();
                    $is_success = $this->input->post('cardstream_transaction_response_code');
                    if ($is_success == 0) {
                        $cardstream_transaction_id = $this->input->post('cardstream_transaction_id');
                        $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,'cardstream',$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$coupon_id,$tips_amount,$service_charge,$packaging_charge,$cardstream_transaction_id);

                        if ($order_information_save_result) {
                            $message = 'Your order has been placed successfully';
                        } else {
                            $message = 'because of our server error, Please try again';
                        }
                    } else {
                        // $message = 'because '.$display_name.' payment is not done';
                        $message = 'because '.$display_name.' '.$this->input->post('cardstream_transaction_response_message');
                        set_flash_message($message);
                        $this->session->unset_userdata('order_process_form_data');
                        redirect('order');
                    }

                    $order_submitted_details = array(
                        'payment_method' => ucfirst($payment_method),
                        'order_type' => ucfirst($order_type),
                        'is_order_placed' => $order_information_save_result,
                        'message' => $message,
                    );

                    set_submitted_order_details($order_submitted_details);

                    set_order_placed($order_information_save_result);
                    if ($order_information_save_result) {
                        $this->Voucher_Model->saveAndSendCouponVoucher($total, $order_type, $customer_id);
                    }
                    $this->session->unset_userdata('order_process_form_data');
                    redirect(base_url('order/message'));
                } else if ($payment_method == 'stripe') {
                    $stripe_token = trim($this->input->get_post('stripe_token'));
                    if ($stripe_token) {
                        $payment_intent = $this->stripe->retrive_payment_intent($stripe_token);
                        $order_information_save_result = false;
                        if ($payment_intent->status == 'succeeded') {
                            $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,'stripe',$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$coupon_id,$tips_amount,$service_charge,$packaging_charge);
                            if ($order_information_save_result) {
                                $message = 'Your order has been placed successfully';
                            } else {
                                $payment_intent = $this->stripe->cancel_payment_intent($stripe_token);
                                $message = 'because of our server error, Please try again';
                            }
                        } else {
                            $message = 'because stripe payment is not done';
                        }

                        $order_submitted_details = array(
                            'payment_method' => ucfirst($payment_method),
                            'order_type' => ucfirst($order_type),
                            'is_order_placed' => $order_information_save_result,
                            'message' => $message,
                        );

                        set_submitted_order_details($order_submitted_details);

                        set_order_placed($order_information_save_result);
                        if ($order_information_save_result) {
                            $this->Voucher_Model->saveAndSendCouponVoucher($total, $order_type, $customer_id);
                        }
                        redirect(base_url('order/message'));
                    } else {
                        set_flash_message('Card details are invalid.');
                        $stripe = $this->session->userdata('stripe_token');
                        if ($stripe) {
                            $this->stripe->cancel_payment_intent($stripe);
                            set_flash_message('Card payment are incomplete, please try again.');
                        }
                        redirect('order');
                    }
                    $this->session->unset_userdata('stripe_token');
                } else if ($payment_method == 'sagepay') {
                    $display_name = get_sagepay_display_name();
                    $sagepay_status = $this->input->get_post('sagepay_status');
                    $transaction_id = $this->input->get_post('sagepay_transaction_id');
                    $retrieve_status = false;
                    if ($sagepay_status == "3DAuth") {
                        $cres = $this->input->get_post('cres');
                        if ($cres) {
                            $threed_challenge_res = $this->sagepay->sagepay_3d_secure_challenge_response($cres,$transaction_id);
                            if (!empty($threed_challenge_res) && !empty($threed_challenge_res['status']) && $threed_challenge_res['status'] == "Ok"  ) {
                                $retrieve_status = true;
                            }
                        } else {
                            $transaction_id = $this->input->get_post('MD');
                            $threeDResult = $this->sagepay->complete_3d_secure_sagepay_transaction($_POST);
                            if (!empty($threeDResult) && !empty($threeDResult['status']) && $threeDResult['status'] == "Authenticated"  ) {
                                $retrieve_status = true;
                            }
                        }                    
                    } else if ($sagepay_status == "Ok") {
                        $retrieve_status = true;
                    }

                    if ($retrieve_status == false) {
                        set_flash_message('Card payment are incomplete, please try again.');
                        redirect('order');
                    }

                    $transaction_info = $this->sagepay->retrieve_sagepay_transaction($transaction_id);
                    $order_information_save_result = false;

                    if ($transaction_info['status'] == "Ok") {
                        $transaction_id = $transaction_info['transactionId'];
                        $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,'sagepay',$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$coupon_id,$tips_amount,$service_charge,$packaging_charge,$transaction_id);
                        if ($order_information_save_result) {
                            $message = 'Your order has been placed successfully';
                        } else {
                            $message = 'because of our server error, Please try again';
                        }
                    } else {
                        $message = 'because '.$display_name.' payment is not done';
                    }

                    $order_submitted_details = array(
                        'payment_method' => ucfirst($payment_method),
                        'order_type' => ucfirst($order_type),
                        'is_order_placed' => $order_information_save_result,
                        'message' => $message,
                    );

                    set_submitted_order_details($order_submitted_details);

                    set_order_placed($order_information_save_result);
                    if ($order_information_save_result) {
                        $this->Voucher_Model->saveAndSendCouponVoucher($total, $order_type, $customer_id);
                    }
                    redirect(base_url('order/message'));
                } else if ($payment_method == 'pay360') {
                    $transaction_id = $this->session->userdata('pay360_transaction_id');
                    $pay360_transaction_info = $this->get_pay360_payment_status($transaction_id);

                    if ($pay360_transaction_info->payment_status === true) {
                        $order_information_save_result = false;

                        $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,'pay360',$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$coupon_id,$tips_amount,$service_charge,$packaging_charge,$transaction_id);

                        if ($order_information_save_result) {
                            $message = 'Your order has been placed successfully';
                            $this->session->unset_userdata('pay360_transaction_id');
                        } else {
                            $payment_cancel_info = $this->cancel_pay360_payment($pay360_transaction_info);
                            if ($payment_cancel_info->cancel_status === false) {
                                $message = 'cancel payment unsuccessful. because of our server error, Please try again';
                            } else {
                                $message = 'because of our server error, Please try again';
                            }
                        }

                        $order_submitted_details = array(
                            'payment_method' => ucfirst($payment_method),
                            'order_type' => ucfirst($order_type),
                            'is_order_placed' => $order_information_save_result,
                            'message' => $message,
                        );

                        set_submitted_order_details($order_submitted_details);

                        set_order_placed($order_information_save_result);
                        if ($order_information_save_result) {
                            $this->Voucher_Model->saveAndSendCouponVoucher($total,$order_type,$customer_id);
                        }
                        redirect(base_url('order/message'));
                    } else {
                        set_flash_message('Card payment are incomplete, please try again or contact to restaurant authority.');
                        redirect('order');
                    }
                } else if ($payment_method == 'worldpay') {
                    dd('Dew');
                    $this->initiate_payment($customer_id);
                    // $this->redirect_to_3ds_page();

                    // $transaction_id = $this->session->userdata('pay360_transaction_id');
                    // $pay360_transaction_info = $this->get_pay360_payment_status($transaction_id);

                    // if ($pay360_transaction_info->payment_status === true) {
                    //     $order_information_save_result = false;

                    //     $order_information_save_result = $this->Order_information_Model->insert_cart_order($order_type,$delivery_time,'pay360',$notes,$delivery_charge,$this->cart->contents(),$is_pre_order,0,$discount,$tips_amount,$transaction_id);

                    //     if ($order_information_save_result) {
                    //         $message = 'Your order has been placed successfully';
                    //         $this->session->unset_userdata('pay360_transaction_id');
                    //     } else {
                    //         $payment_cancel_info = $this->cancel_pay360_payment($pay360_transaction_info);
                    //         if ($payment_cancel_info->cancel_status === false) {
                    //             $message = 'cancel payment unsuccessful. because of our server error, Please try again';
                    //         } else {
                    //             $message = 'because of our server error, Please try again';
                    //         }
                    //     }

                    //     $order_submitted_details = array(
                    //         'payment_method' => ucfirst($payment_method),
                    //         'order_type' => ucfirst($order_type),
                    //         'is_order_placed' => $order_information_save_result,
                    //         'message' => $message,
                    //     );

                    //     set_submitted_order_details($order_submitted_details);

                    //     set_order_placed($order_information_save_result);
                    //     if ($order_information_save_result) {
                    //         $this->Voucher_Model->saveAndSendCouponVoucher($total,$order_type,$customer_id);
                    //     }
                    //     redirect(base_url('order/message'));
                    // } else {
                    //     set_flash_message('Card payment are incomplete, please try again or contact to restaurant authority.');
                    //     redirect('order');
                    // }
                } else if ($payment_method == 'paypal') {
                    $this->load->view('my_account/paypal_waiting', $this->data);
                    $cart_contents = $this->cart->contents();
                    $products = array();

                    $cart_total = $this->cart->total();
                    $total = $cart_total + $delivery_charge - $discount;
                    foreach ($cart_contents as $cart) {
                        $product = array(
                            'name' => $cart['name'],
                            'price' => $cart['price'],
                            'quantity' => $cart['qty'],

                        );
                        array_push($products, $product);
                    }

                    $lib_paypal = new PayPalPaymentGateway();

                    $cart_total = round($cart_total, 2);
                    if ($discount > 0) {
                        $discount = round($discount, 2);
                    }

                    $sub_total = $cart_total - $discount + $surcharge;
                    $sub_total = round($sub_total, 2);

                    if ($delivery_charge > 0) {
                        $delivery_charge = round($delivery_charge, 2);
                    }
                    $total = $cart_total + $delivery_charge - $discount + $surcharge;
                    $total = round($total, 2);

                    if ($surcharge > 0) {
                        $surchargeData = array(
                            'name' => 'Card Fee',
                            'price' => $surcharge,
                            'quantity' => 1,
                        );
                        array_push($products, $surchargeData);
                    }

                    $pay_pal_link = $lib_paypal->get_paypal_link_for_sale($products, $delivery_charge, $sub_total, $total, $discount);
                    $order_details = array(
                        'order_type' => $order_type,
                        'delivery_time' => $delivery_time,
                        'payment_method' => $payment_method,
                        'order_note' => $notes,
                        'delivery_charge' => $delivery_charge,
                        'is_pre_order' => $is_pre_order,
                        'cart_content' => $cart_contents,
                        'cart_total' => $cart_total,
                        'discount' => $discount,
                        'surcharge' => $surcharge,
                    );

                    if (!empty($pay_pal_link)) {
                        $this->session->set_userdata('paypal_order_details', $order_details);
                        redirect($pay_pal_link);
                    } else {
                        redirect('order');
                    }
                }
            }
        }
    }

#Region Cardstrem
    public function cardstream_transaction() {
        // Signature key entered on MMS. The demo account is fixed to this value,
        Gateway::$merchantSecret = get_cardstream_signature_key();
        
        // Gateway URL
        Gateway::$directUrl = get_cardstream_active_url();
        
        $pageUrl = get_cardstream_redirect_url();
        $pageUrl .= (strpos($pageUrl, '?') === false ? '?' : '&') . 'sid=' . urlencode(session_id());

        // If ACS response into the IFRAME then redirect back to parent window
        if (!empty($_GET['acs'])) {
            echo $this->silentPost($pageUrl, array('threeDSResponse' => $_POST), '_parent'); exit();
        }
        
        if (!isset($_POST['threeDSResponse'])) {
            $post_data = array();
            $session_post_data = $this->session->userdata('order_process_form_data');
            // dd($session_post_data);
            if ($session_post_data) {
                parse_str($session_post_data,$post_data);
                // dd($post_data);
            } else {
                $post_data = $_POST;
                $serialized_post_data = serialize_data($post_data);
                $this->session->set_userdata('order_process_form_data',$serialized_post_data);
            }
            // dd($post_data);
            $customer_id = $post_data['id'];
            $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
            $first_name = $customer_info->first_name;
            $last_name = $customer_info->last_name;
            $card_holder_name = $first_name . " " . $last_name;
            if ($last_name == "") {
                $last_name = "N/A";
            }
            $total_amount = get_order_total_amount('cardstream');
            $total_amount = (int)round(($total_amount * 100), 0);
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
                'customerEmail' => $customer_info->email,
                'customerAddress' => $customer_info->delivery_address_line_1,
                'customerPostCode' => $customer_info->delivery_postcode,
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
                $this->page_content = $this->load->view('my_account/cardstream_transaction', $this->data, true);
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
                $form_data = $this->session->userdata('order_process_form_data');
                parse_str($form_data,$form_data);
                $form_data['cardstream_transaction_id'] = $res['transactionID'];
                $form_data['cardstream_transaction_response_code'] = $res['responseCode'];
                $form_data['cardstream_transaction_response_message'] = $message;
                $form_data = json_encode($form_data);
                $this->data['form_data'] = $form_data;
                $this->data['total_amount'] = $res['amount'];
                $this->load->view('my_account/order_process_form_for_cardstream', $this->data);
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

#Region Sagepay
    public function sagepay_transaction() {
        dd($this->input->post());
        $post_data = $this->input->post('post_data');
        $form_data = $this->input->post('formData');
        $this->session->set_userdata('order_process_form_data',$form_data);
        $customer_id = $post_data['customer_id'];
        $terms_conditions = $post_data['terms_conditions'];
        $delivery_time = $post_data['delivery_time'];
        $delivery_postcode = '';
        if (isset($post_data['delivery_postcode'])) {
            $delivery_postcode = $post_data['delivery_postcode'];
        }
        $delivery_address_line_1 = '';
        if (isset($post_data['delivery_address_line_1'])) {
            $delivery_address_line_1 = $post_data['delivery_address_line_1'];
        }
        $sagepay_card_number = $post_data['sagepay_card_number'];
        $sagepay_expiry_mm = $post_data['sagepay_expiry_mm'];
        $sagepay_expiry_yy = $post_data['sagepay_expiry_yy'];
        $sagepay_security_code = $post_data['sagepay_security_code'];
        $tips_id = 0;
        if (isset($post_data['tips_id'])) {
            $tips_id = $post_data['tips_id'];
        }
        $result = "";
        $msg = "";
        $is_valid = true;
        $error_layer = 1;
        $this->set_tips($tips_id);
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
            $is_order_processable = is_order_processable($post_data);
            $total_amount = get_order_total_amount('sagepay');

            if ($is_order_processable && $total_amount > 0) {
                $error_layer = 3;
                $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
                $first_name = $customer_info->first_name;
                $last_name = $customer_info->last_name;
                $card_holder_name = $first_name . " " . $last_name;
                if ($last_name == "") {
                    $last_name = "N/A";
                }
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
                $notification_url = base_url('order/redirect_to_merchant');
                $transaction_result = $this->sagepay->sagepay_transaction($card_data,$total_amount,$notification_url);
                list($result,$is_valid,$msg) = $transaction_result;
            } else {
                $is_valid = false;
                $msg = "";
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
        $form_data = $this->session->userdata('order_process_form_data');
        parse_str($form_data,$form_data);
        $form_data['sagepay_status'] = "3DAuth";
        $form_data['sagepay_transaction_id'] = $transaction_id;
        $form_data['cres'] = $cres;
        $form_data = json_encode($form_data);
        $total_amount = get_order_total_amount('sagepay');
        $this->data['form_data'] = $form_data;
        $this->data['total_amount'] = $total_amount;

        $this->load->view('my_account/order_process_form_for_sagepay_3d', $this->data);
    }

    public function sagepay_refund_transaction() {
        $transaction_id = $this->input->post('transaction_id');
        $order_information_id = $this->input->post('order_information_id');
        $total_amount = $this->input->post('total_amount');
        $status = $this->sagepay->sagepay_refund_transaction($transaction_id,$order_information_id,$total_amount);

        if ($status) {
            $data = array('order_status' => 'refund', 'is_refunded' => 1);
            $this->db->where('id', $order_information_id);
            $this->db->update('order_information', $data);
            $msg = "This order refund successfully";
        } else {
            $msg = "Something wrong here, please try again.";
        }

        $response_array = array('status' => $status, 'message' => $msg);
        $this->output->set_content_type('application/json')->set_output(json_encode($response_array));
    }
#End Region

#Region Stripe
    public function check_stripe_order_process() {       
        $is_pre_order = is_pre_order();
        if (is_shop_closed() && !is_pre_order() && is_shop_maintenance_mode() || is_shop_weekend_off()) {
            return false;
           // redirect('menu');
        }

        if (is_shop_weekend_off()) {
            return false;
        }

        $terms_conditions = trim($this->input->post('terms_conditions'));
        // echo  $terms_conditions;

        if (empty($terms_conditions)) {
            set_flash_message('You must agree to our Terms and Conditions');
            return false;
        }

        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            $form_data = $this->Customer_Model->data_form_post(array('id', 'first_name', 'last_name', 'email', 'mobile', 'delivery_address_line_1', 'delivery_postcode'));
            $delivery_time = trim($this->input->post('delivery_time'));

            if (empty($delivery_time)) {
               return false;
            }

            $payment_method = trim($this->input->post('payment_method'));
            $order_type = trim($this->input->post('order_type'));
            $notes = trim($this->input->post('notes'));

            $delivery_charge = ($order_type == 'delivery') ? $this->session->userdata('delivery_charge') : 0;

            if (empty($order_type)) {
                redirect('order');
            }

            // check order is valid as collection or delivery ony product

            $isValidOrderType = isCartValidWithOrderType(trim($order_type), $this->cart->contents());
            if (!$isValidOrderType) {
                $cartHasItemOf = ($order_type == 'collection') ? 'Delivery' : 'Collection';
                $cartOrderTypeChangeMessage = 'Your cart has only for ' . $cartHasItemOf . ' Item';
                set_flash_message($cartOrderTypeChangeMessage);
                // redirect('order');
                return false;
            }


            $order_type_session = $this->session->userdata('order_type_session');
            //Update Customer Information
            $this->customer_update($form_data);

            $this->data['order_type'] = $order_type;
            $cart_total = $this->cart->total();

            $shop_details = get_company_details();
            $minimum_order_amount = get_property_value('minimum_order_amount', $shop_details);

            $customer_id = $this->Customer_Model->get_logged_in_customer_id();
            $discount = $this->Customer_Model->get_discount_amount($this->cart->contents(), $order_type, $customer_id);

            $delivery_postcode = trim($this->input->post('delivery_postcode'));
            $delivery_address_line_1 = $form_data['delivery_address_line_1'];         
            
            if (!empty($order_type) && $order_type == 'delivery') {
                if (empty($delivery_address_line_1)) {
                    set_flash_message('Delivery address is missing ');
                    return false;                    
                }

                if (empty($delivery_postcode)) {
                    set_flash_message('Delivery postcode is missing');
                    return false;
                }

                $is_valid = false;
                $m_allowed_miles = new Allowed_miles_Model();
                $allowed_miles = $m_allowed_miles->getDistanceDeliveryCharge($delivery_postcode);
                if (!empty($allowed_miles)) {
                    $delivery_charge = $allowed_miles->delivery_charge;
                    $minimum_order_amount = $allowed_miles->min_order_for_delivery;
                    $is_valid = true;
                } else {
                    $m_allowed_post_code_model = new Allowed_postcodes_Model();
                    $delivery_details = $m_allowed_post_code_model->get_delivery_charge_by_postcode($delivery_postcode);
                    if (!empty($delivery_details)) {
                        $is_valid = true;
                        $delivery_charge = $delivery_details->delivery_charge;
                        $minimum_order_amount = $delivery_details->min_order_for_delivery;
                    }
                }

                if (!$is_valid) {
                    set_flash_message($m_allowed_miles->get_miles_error_message());
                    // $payment_intent = $this->cancel_intent($stripe_token);
                    // redirect('order');
                    return false;
                }

                if ($cart_total < $minimum_order_amount) {
                    set_flash_message('Minimum order amount for delivery is ' . get_price_text($minimum_order_amount));
                    // $payment_intent = $this->cancel_intent($stripe_token);
                    // redirect('order');
                    return false;
                }
                $delivery_address_line_1 = $form_data['delivery_address_line_1'];
            } else {
                if ($minimum_order_amount > $cart_total) {
                    set_flash_message('Minimum order amount for collection is ' . get_price_text($minimum_order_amount));
                    // $payment_intent = $this->cancel_intent($stripe_token);
                    // redirect('order');
                    return false;
                }
            }

            $delivery_charge = !empty($delivery_charge) ? $delivery_charge : 0;
            $coupon_code = $this->input->post('coupon_code');

            // check coupon code add set discount;
            if (!empty($coupon_code)) {
                // calculate discount.
                $couponDiscount = $this->Voucher_Model->getDiscountAmountFromValidCoupon($coupon_code, $order_type, $cart_total);
                if ($couponDiscount > 0 && $discount > 0 && $couponDiscount > $discount) {
                    $discount = $couponDiscount;
                }
            }

            $total = $cart_total + $delivery_charge - $discount;
            if ($total <= 0) {
                return false;
            }
            return true;
        }        
        return false;
    }

    public function create_payment_intent() {
        // dd($this->input->post());
        if ($this->input->is_ajax_request()) {
            $output = '';
            $amount = get_order_total_amount('stripe');
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

#Region Pay360 
    public function worldpay_test() {
        $this->data['title'] = 'Worldpay Test';

        $this->page_content = $this->load->view('my_account/worldpay_test', $this->data, true);
        $this->load->view('index', $this->data);
        $this->load->view('footer', $this->data, true);
    }

    public function initiate_payment($customer_id = 0) {
        // require_once('application/libraries/worldpay-php/lib/worldpay.php');
        require_once(APPPATH.'libraries\worldpay-php\init.php');
        // \Worldpay\Worldpay()::setApiKey($this->secret_key);

        $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
        $customer_name = $customer_info->first_name." ".$customer_info->last_name;
        $return_url = base_url()."?return=true";

        $worldpay_settings = $this->Settings_Model->get_by(array("name"=>'worldpay_settings'),true);
        $worldpay_value = json_decode($worldpay_settings->value);

        $payment_settings = $this->Settings_Model->get_by(array("name"=>'payment_settings'),true);
        $payment_settings_value = json_decode($payment_settings->value);

        $total_amount = $this->Customer_Model->get_cart_grand_total() * 100;
        // $transaction_date_time = date('Y-m-d')."T".date('h:i:s')."Z";

        // \Worldpay\Worldpay::setServiceKey('T_S_4763be2b-bc06-41s0-8338-7014f08575da');
        $worldpay = new Worldpay('T_S_4763be2b-bc06-41s0-8338-7014f08575da');

        $billing_address = array(
            "address1" => $customer_info->billing_address_line_1,
            "address2" => $customer_info->billing_address_line_2,
            "address3" => '',
            "postalCode" => $customer_info->billing_postcode,
            "city" => $customer_info->billing_city,
            "state" => '',
            "countryCode" => 'GB',
        );
        try {
            $response = $worldpay->createOrder(array(
                'token' => 'your-order-token',
                'amount' => 500,
                'currencyCode' => 'GBP',
                'name' => '3D',
                'billingAddress' => $billing_address,
                'orderDescription' => 'Order description',
                'customerOrderCode' => 'Order code',
                'is3DSOrder' => true
            ));
            $_SESSION['orderCode'] = $response['orderCode'];
            $oneTime3DsToken = $response['oneTime3DsToken'];
            $redirectURL = $response['redirectURL'];
        } catch (WorldpayException $e) {
            echo 'Error code: ' .$e->getCustomCode() .'
            HTTP status code:' . $e->getHttpStatusCode() . '
            Error description: ' . $e->getDescription()  . '
            Error message: ' . $e->getMessage();
        }
    }

    public function cancel_pay360_payment($pay360_transaction_info) {
        $transaction_id = $pay360_transaction_info->transaction->transactionId;
        $request_id = $pay360_transaction_info->processing->requestId;
        $return_url = base_url()."?requestId=".$request_id;

        $payment_settings = $this->Settings_Model->get_by(array("name"=>'payment_settings'),true);
        $payment_settings_value = json_decode($payment_settings->value);

        $pay360_settings = $this->Settings_Model->get_by(array("name"=>'pay360_settings'),true);
        $pay360_value = json_decode($pay360_settings->value);
        $merchant_id = $pay360_value->pay360_merchant_id;
        $jwt = $pay360_value->pay360_jwt;

        $this->data['title'] = 'Cancel Pay360 Payment Request';

        $request_data = '
            {
                "description": "CANCELLATION_REASON",
                "processing": {
                    "account": "string",
                    "requestId": "'.$request_id.'",
                    "responseCallback": {
                        "attempts": 0,
                        "headers": {
                            "property1": "string",
                            "property2": "string"
                        },
                        "key": "string",
                        "name": "string",
                        "url": "'.$return_url.'",
                        "when": "ALWAYS"
                    },
                    "timeout": "2min"
                },
                "reasonCode": "UNKNOWN"
            }
        ';
        $data = $request_data;
        // gg($request_data);

        /* API URL */
        if ($payment_settings_value->payment_mode == 1) {
            $url = 'https://secure.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/cancel';
        } else {
            $url = 'https://secure.test.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/cancel';
        }
   
        /* Init cURL resource */
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'jwt:'.$jwt,
                'Content-Type: application/json',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));            
        /* execute request */
        $response = curl_exec($ch);
        
        if ($response === FALSE) {
            $response = "Curl failed: ".curL_error($ch);
            $cancel_status = false;
        }

        if (is_string($response) && is_array(json_decode($response, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            $response = json_decode($response);
            $error_msg = null;
            $cancel_status = true;
            if (isset($response->status)) {
                $error_msg = $response->detail.' Please contact to restaurant authority.';
                $cancel_status = false;
            }
        }

        $pay360_transaction_id = 0;
        if (isset($response->transaction->transactionId)) {
            $pay360_transaction_id = $response->transaction->transactionId;
        }
        $response->error_msg = $error_msg;
        $response->cancel_status = $cancel_status;
        $this->session->set_userdata('pay360_transaction_id',$pay360_transaction_id);

        /* close cURL resource */
        curl_close($ch);

        $this->data['response'] = $response;

        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

        // $this->page_content = $this->load->view('my_account/pay360_test', $this->data, true);
        // $this->load->view('index', $this->data);
        // $this->load->view('footer', $this->data, true);
    }

    public function refund_pay360_payment($transaction_id = 0,$customer_id = 0) {
        $pay360_transaction_info = $this->get_pay360_payment_status($transaction_id);
        $request_id = $pay360_transaction_info->processing->requestId;
        $return_url = base_url()."?requestId=".$request_id;
        $bank_account_id = $pay360_transaction_info->remittance->bankAccountId;
        $payment_account_id = $pay360_transaction_info->remittance->paymentAccountId;
        $remittance_group = $pay360_transaction_info->remittance->remittanceGroup;

        $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
        $customer_name = $customer_info->first_name." ".$customer_info->last_name;
        $return_url = base_url()."?return=true";

        $pay360_settings = $this->Settings_Model->get_by(array("name"=>'pay360_settings'),true);
        $pay360_value = json_decode($pay360_settings->value);
        $merchant_id = $pay360_value->pay360_merchant_id;
        $jwt = $pay360_value->pay360_jwt;

        $payment_settings = $this->Settings_Model->get_by(array("name"=>'payment_settings'),true);
        $payment_settings_value = json_decode($payment_settings->value);

        $total_amount = $this->Customer_Model->get_cart_grand_total();
        $transaction_date_time = date('Y-m-d')."T".date('h:i:s')."Z";
        $unique_merchant_reference = $pay360_value->pay360_merchant_id."-".date('ymdhis');

        $this->data['title'] = 'Create Pay360 Payment Request';

        $request_data = '
            {
                "amount": 5.99,
                "description": "REFUND_REASON",
                "items": [
                    {
                        "additionalReference": "PAYER_ADDITIONAL_REFERENCE",
                        "notificationEmail": "'.$customer_info->email.'",
                        "quantity": 0,
                        "reference": "PAYER_REFERENCE",
                        "remittance": {
                            "bankAccountId": "'.$bank_account_id.'",
                            "merchantId": 11001531,
                            "paymentAccountId": "'.$payment_account_id.'",
                            "remittanceGroup": "'.$remittance_group.'"
                        },
                        "shippingAddress": {
                            "city": "'.$customer_info->billing_city.'",
                            "countryCode": "GBR",
                            "postcode": "'.$customer_info->billing_postcode.'",
                        },
                        "shippingAmount": 0,
                        "skuCode": "0",
                        "taxAmount": 0,
                        "taxRate": 0,
                        "totalAmount": 99
                    }
                ],
                "processing": {
                    "account": "string",
                    "profile": "string",
                    "requestId": "'.$request_id.'",
                    "responseCallback": {
                        "attempts": 0,
                        "headers": {
                            "property1": "string",
                            "property2": "string"
                        },
                        "key": "string",
                        "name": "string",
                        "url": "'.$return_url.'",
                        "when": "ALWAYS"
                    },
                    "timeout": "2min"
                },
                "refundReason": "GOODS_RETURNED"
            }
        ';
        $data = $request_data;
        dd($request_data);

        /* API URL */
        if ($payment_settings_value->payment_mode == 1) {
            $url = 'https://secure.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/refund';
        } else {
            $url = 'https://secure.test.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/refund';
        }
   
        /* Init cURL resource */
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'jwt:'.$jwt,
                'Content-Type: application/json',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));            
        /* execute request */
        $response = curl_exec($ch);
        
        if ($response === FALSE) {
            $response = "Curl failed: ".curL_error($ch);
            $payment_status = false;
        }

        if (is_string($response) && is_array(json_decode($response, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            $response = json_decode($response);
            $error_msg = null;
            $payment_status = true;
            if (isset($response->status)) {
                $error_msg = $response->detail.' Please contact to restaurant authority.';
                $payment_status = false;
            }
        }

        $pay360_transaction_id = 0;
        if (isset($response->transaction->transactionId)) {
            $pay360_transaction_id = $response->transaction->transactionId;
        }
        $response->error_msg = $error_msg;
        $response->payment_status = $payment_status;
        $this->session->set_userdata('pay360_transaction_id',$pay360_transaction_id);

        /* close cURL resource */
        curl_close($ch);

        $this->data['response'] = $response;

        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

        // $this->page_content = $this->load->view('my_account/pay360_test', $this->data, true);
        // $this->load->view('index', $this->data);
        // $this->load->view('footer', $this->data, true);
    }

    public function create_pay360_payment_request() {
        // echo "<pre>"; print_r($this->input->post());
        $card_holder_name = $this->input->post('first_name')." ".$this->input->post('last_name');
        $customer_id = $this->input->post('id');
        $customer_info = $this->Customer_Model->get_customer_by_id($customer_id);
        $customer_name = $customer_info->first_name." ".$customer_info->last_name;
        $return_url = base_url()."?return=true";

        $pay360_settings = $this->Settings_Model->get_by(array("name"=>'pay360_settings'),true);
        $pay360_value = json_decode($pay360_settings->value);
        $merchant_id = $pay360_value->pay360_merchant_id;
        $jwt = $pay360_value->pay360_jwt;

        $payment_settings = $this->Settings_Model->get_by(array("name"=>'payment_settings'),true);
        $payment_settings_value = json_decode($payment_settings->value);

        $total_amount = $this->Customer_Model->get_cart_grand_total();
        $transaction_date_time = date('Y-m-d')."T".date('h:i:s')."Z";
        $unique_merchant_reference = $merchant_id."-".date('ymdhis');

        $this->data['title'] = 'Create Pay360 Payment Request';

        $request_data = '
            {
                "customer": {
                    "address": {
                        "city": "'.$customer_info->billing_city.'",
                        "line1": "'.$customer_info->billing_address_line_1.'",
                        "line2": "'.$customer_info->billing_address_line_2.'",
                        "postcode": "'.$customer_info->billing_postcode.'",
                        "region": ""
                    },
                    "customerId": "'.$customer_info->id.'",
                    "emailAddress": "'.$customer_info->email.'",
                    "name": "'.$customer_name.'",
                    "telephone": "'.$customer_info->telephone.'",
                    "mobile": "'.$customer_info->mobile.'"
                },
                "emailNotifications": [{"address": "'.$this->input->post('email').'","type": "RECEIPT"}],
                "paymentMethod": {
                    "billingAddress": {
                        "city": "'.$customer_info->billing_city.'",
                        "line1": "'.$customer_info->billing_address_line_1.'",
                        "line2": "'.$customer_info->billing_address_line_2.'",
                        "postcode": "'.$customer_info->billing_postcode.'",
                        "region": ""
                    },
                    "billingEmail": "'.$this->input->post('email').'",
                    "card": {
                        "cardHolderName": "'.$card_holder_name.'",
                        "commerceType": "ECOMM",
                        "cv2": '.$this->input->post('cv2_number').',
                        "do3DSecure": true,
                        "entryType": "ECOMM",
                        "expiryMonth": "'.$this->input->post('expiry_month').'",
                        "expiryYear": '.$this->input->post('expiry_year').',
                        "issueNumber": 1,
                        "merchantCategoryCode": 8299,
                        "paRes": "3DS_PA_RESPONSE",
                        "pan": '.$this->input->post('pan').',
                        "token": "UNIQUE_STORED_CARD_TOKEN"
                    },
                    "gateway": {
                        "acceptMethods": ["card","paypal","pbba","visacheckout"],
                        "returnUrl": "'.$return_url.'"
                    },
                    "methodId": "GATEWAY",
                    "provider": "SBS",
                    "saveMethod": "NO",
                    "test": {
                      "async": true,
                      "asyncDelay": 0,
                      "authCode": 0,
                      "error": true,
                      "name": "string",
                      "test3ds": true,
                      "threeDSData": "string"
                    }
                }, 
                "remittance": {
                    "merchantId": '.$pay360_value->pay360_merchant_id.',
                    "remittanceGroup": "Field trip"
                },
                "transaction": {
                    "amount": '.get_price_text($total_amount).',
                    "capture": true,
                    "channel": "WEB",
                    "currency": "GBP",
                    "description": "Payment for purchase",
                    "fraudChecks": "NONE",
                    "merchantReference": "'.$pay360_value->pay360_merchant_id.'",
                    "recurring": "NONE",
                    "recurringType": "CONTINUOUS",
                    "sequenceId": 543,
                    "submit": true,
                    "transactionDateTime": "'.$transaction_date_time.'",
                    "uniqueMerchantReference": "'.$unique_merchant_reference.'"
                }
            }
        ';
        $data = $request_data;

        /* API URL */
        // $url = 'https://api.test.pay360evolve.com/demo/pf-api-gateway/apiGateway/user-account/user-account/userAccounts?invitation=true';
        if ($payment_settings_value->payment_mode == 1) {
            $url = 'https://secure.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments';
        } else {
            $url = 'https://secure.test.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments';
        }
   
        /* Init cURL resource */
        $ch = curl_init();
        curl_setopt_array($ch,array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'jwt:'.$jwt,
                'Content-Type: application/json',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));            
        /* execute request */
        $response = curl_exec($ch);
        
        if ($response === FALSE) {
            $response = "Curl failed: ".curL_error($ch);
            $payment_status = false;
        }

        if (is_string($response) && is_array(json_decode($response, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            $response = json_decode($response);
            $error_msg = null;
            $payment_status = true;
            if (isset($response->status)) {
                $error_msg = $response->detail.' Please contact to restaurant authority.';
                $payment_status = false;
            }
        }

        $pay360_transaction_id = 0;
        if (isset($response->transaction->transactionId)) {
            $pay360_transaction_id = $response->transaction->transactionId;
        }
        $response->error_msg = $error_msg;
        $response->payment_status = $payment_status;
        $this->session->set_userdata('pay360_transaction_id',$pay360_transaction_id);

        /* close cURL resource */
        curl_close($ch);

        $this->data['response'] = $response;

        $this->output->set_content_type('application/json')->set_output(json_encode($this->data));

        // $this->page_content = $this->load->view('my_account/pay360_test', $this->data, true);
        // $this->load->view('index', $this->data);
        // $this->load->view('footer', $this->data, true);
    }

    public function get_pay360_payment_status($transaction_id = 0) {
        $payment_settings = $this->Settings_Model->get_by(array("name"=>'payment_settings'),true);
        $payment_settings_value = json_decode($payment_settings->value);

        $pay360_settings = $this->Settings_Model->get_by(array("name"=>'pay360_settings'),true);
        $pay360_value = json_decode($pay360_settings->value);
        $merchant_id = $pay360_value->pay360_merchant_id;
        $jwt = $pay360_value->pay360_jwt;

        $this->data['title'] = 'Pay360 Payment Status';
        /* API URL */
        if ($payment_settings_value->payment_mode == 1) {
            $url = 'https://secure.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/status';
        } else {
            $url = 'https://secure.test.pay360evolve.com/api/v1/merchants/'.$merchant_id.'/transactions/payments/'.$transaction_id.'/status';
        }
        // $url = 'https://secure.test.pay360evolve.com/api/v1/merchants/11001637/transactions/payments/44751/status';
   
        /* Init cURL resource */
        $curl = curl_init($url);

        curl_setopt_array($curl,array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'jwt:'.$jwt
            ),
        ));
        /* execute request */
        $response = curl_exec($curl);
        
        if ($response === FALSE) {
            $response = "Curl failed: " . curL_error($curl);
            $payment_status = false;
        }

        if (is_string($response) && is_array(json_decode($response, true)) && (json_last_error() == JSON_ERROR_NONE)) {
            $response = json_decode($response);
            $error_msg = '';
            $payment_status = true;
            if (isset($response->status) && $response->status == 'INTERNAL_SERVER_ERROR') {
                $error_msg = $response->detail.'. Please contact to restaurant authority.';
                $payment_status = false;
            }
        }

        $response->error_msg = $error_msg;
        $response->payment_status = $payment_status;
             
        /* close cURL resource */
        curl_close($curl);
        return $response;

        // $this->data['response'] = $response;

        // $this->page_content = $this->load->view('my_account/pay360_test', $this->data, true);
        // $this->load->view('index', $this->data);
        // $this->load->view('footer', $this->data, true);
    }
#End Region

    public function message() {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if (is_order_submitted()) {
                $submitted_order_details = get_submitted_order_details();
                unset_submitted_order_details();
                unset_stripe_placed();
                $this->data['submitted_order_details'] = $submitted_order_details;
                if (is_order_placed()) {
                    $this->data['title'] = "Order placed success";
                    $this->page_content = $this->load->view('order/order_success', $this->data, true);
                    $this->load->view('index', $this->data);
                } else {
                    $this->data['title'] = "Order placed failed";
                    $this->page_content = $this->load->view('order/order_error', $this->data, true);
                    $this->load->view('index', $this->data);
                }
                unset_order_placed();
            } else {
                redirect('menu');
            }
            unset_order_submitted();
        } else {
            redirect('menu');
        }
    }

    public function customer_update($form_data) {
        if ($this->Customer_Model->customer_is_loggedIn() == true) {
            if (!empty($form_data)) {
                $id = $form_data['id'];
                if (empty($form_data['email'])) {
                    $this->session->set_flashdata('email_error_meaage', 'Email is required');
                    redirect(base_url('order'));
                }

                if (empty($form_data['first_name'])) {
                    $this->session->set_flashdata('first_name_error_message', ' First Name is required');
                    redirect(base_url('order'));
                }

                if (empty($form_data['mobile'])) {
                    $this->session->set_flashdata('mobile_error_meaage', 'Mobile is required');
                    redirect(base_url('order'));
                } else {
                    $this->Customer_Model->where_column = 'id';
                    $result = $this->Customer_Model->save($form_data, $id);
                }
            }
        }
    }

    public function payment_checking() {
        if ($this->Customer_Model->customer_is_loggedIn()) {
            $order_information_save_result = false;
            $nochex_order_details = $this->session->userdata('nochex_order_details');
            $nochex_order_details = (!empty($nochex_order_details)) ? json_decode($nochex_order_details, true) : array();
            if (!empty($nochex_order_details)) {
                $card_order_id = $nochex_order_details['card_order_id'];
                $nochex_order_id = $nochex_order_details['nochex_order_id'];
                $order_type = $nochex_order_details['order_type'];
                $payment_method = $nochex_order_details['payment_method'];
                $this->load->model('Card_Order_Model');
                $m_card_order_model = new Card_Order_Model();
                $this->session->unset_userdata('nochex_order_details');
                $card_order = $m_card_order_model->get(intval($card_order_id), true);
                $message = '';
                if (!empty($card_order)) {
                    $this->data['card_order'] = $card_order;
                    $is_authorized = $card_order->is_authorized;
                    if ($is_authorized == 1) {
                        //payment authorized so submit order
                        // order submitted successful
                        $order_information_save_result = true;
                        $message = 'order has been placed successfully';
                        $this->cart->destroy();
                    } else {
                        // Payment unauthorized card so order did not submit
                        $message = 'because unauthorized nochex card payment, Please try again';
                    }
                } else {
                    $message = 'because unauthorized nochex card payment, Please try again';
                }

                $order_submitted_details = array(
                    'payment_method' => ucfirst($payment_method),
                    'order_type' => ucfirst($order_type),
                    'is_order_placed' => $order_information_save_result,
                    'message' => $message,
                );
                set_submitted_order_details($order_submitted_details);
                set_order_placed($order_information_save_result);
                redirect('order/message');
            } else {
                redirect('menu');
            }
        } else {
            redirect('menu');
        }
    }
    
    public function check_coupon() {
        //get input from delivery postcode textbox
        if ($this->input->is_ajax_request()) {
            $isValid = false;
            if ($this->Customer_Model->customer_is_loggedIn()) {
                $total_buy_get_amount = get_total_from_cart('buy_get_amount');
                $coupon_code = $this->input->post('coupon_code', true);
                $this->session->set_userdata('coupon_code',$coupon_code);
                $couponDiscount = 0;
                $message = '';
                if (!empty($coupon_code)) {
                    $voucherCoupon = $this->Voucher_Model->getByCode($coupon_code);
                    $message = 'Coupon Code Is Invalid';
                    $cartTotal = $this->cart->total();
                    $order_type = $this->session->userdata('order_type_session');

                    if (!empty($voucherCoupon)) {
                        /* 
                        * $totalCartAmount=$this->cart
                        * 1.check order type
                        * 2.Check expired date
                        * 3.Check remaining usages
                        */
                        $this->session->set_userdata('coupon_id',$voucherCoupon->id);
                        $this->session->set_userdata('coupon_code',$voucherCoupon->code);
                        $expiredDate = strtotime($voucherCoupon->expired_date);
                        $startDate = strtotime($voucherCoupon->start_date);
                        if ($startDate > strtotime(date('Y-m-d'))) {
                            $message = 'Coupon Has Not Start Yet.';
                        } elseif ($expiredDate < strtotime(date('Y-m-d'))) {
                            $message = 'Coupon Code Is Expired';
                        } else {
                            $isValid = true;
                            $order_type = $this->session->userdata('order_type_session');
                            $couponOrderType = $voucherCoupon->order_type;
                            if ($couponOrderType != 'any') {
                                if ($couponOrderType != $order_type) {
                                    $isValid = false;
                                    $message = 'Coupon Code Is Only For '.ucfirst($couponOrderType) . ' order';
                                }
                            }

                            $remaining_usages = $voucherCoupon->remaining_usages;
                            if ($remaining_usages <= 0) {
                                $isValid = false;
                                $message = 'Coupon Code Is Already Used';
                            }

                            if ($isValid) {
                                $isValid = false;
                                $min_order_amount = $voucherCoupon->min_order_amount;
                                $cartTotal = $this->cart->total() - $total_buy_get_amount;
                                if ($min_order_amount <= $cartTotal) {
                                    $isValid = true;
                                } else {
                                    $message = 'Coupon Code Is Applicable For Minimum Order Amount Of ' . get_price_text($min_order_amount, 0);
                                }
                            }
                        }

                        if ($isValid) {
                            // calculate discount and show message
                            $discount = $this->Voucher_Model->calculateCouponDiscount($voucherCoupon,$cartTotal);
                            $couponDiscount = $discount;
                            $message = 'You Have Got Discount Amount Of '.get_price_text($discount, 2).' By This Coupon';
                        }
                    }
                }

                $this->data['couponDiscount'] = $couponDiscount;
                $this->data['total_buy_get_amount'] = $total_buy_get_amount;
                $cart_footer = $this->load->view('cart/cart_footer', $this->data, true);
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'isValid' => $isValid,
                    'message' => $message,
                    'cart_footer' => $cart_footer
                )));
            }
        }
    }

    public function get_order_total() {
        $order_type = $this->session->userdata('order_type_session');
        $m_customer = new Customer_Model();
        $cart_total = $this->cart->total();
        $customer_id = $this->Customer_Model->get_logged_in_customer_id();
        $discount = $m_customer->get_discount_amount($this->cart->contents(), $order_type, $customer_id);
        $coupon_code = $this->input->post('coupon_code');
        $tips_amount = 0;
        if (!empty($this->session->userdata('tips_amount'))) {
            $tips_amount = $this->session->userdata('tips_amount');
        }
        // check coupon code add set discount;
        if (!empty($coupon_code)) {
            // calculate discount.
            $couponDiscount = $this->Voucher_Model->getDiscountAmountFromValidCoupon($coupon_code, $order_type, $cart_total);
            if ($couponDiscount > 0 && $discount > 0 && $couponDiscount > $discount) {
                $discount = $couponDiscount;
            }
        }        

        $delivery_charge = 0;
        if (!empty($order_type)) {
            if ($order_type == 'collection') {
                $delivery_charge = 0;
            } else if ($order_type == 'delivery') {
                $delivery_charge = (!empty($this->session->userdata('delivery_charge'))) ? $this->session->userdata('delivery_charge') : 0;
            }
        }

        $total_amount = ($cart_total + $delivery_charge + $tips_amount) - $discount;

        return $total_amount;
    }
}