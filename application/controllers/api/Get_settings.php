<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_Settings extends Api_Controller
{
    public function __construct() {
        parent:: __construct();
        $this->load->model('Settings_Model');
        $this->load->model('Tips_model');
        $this->load->model('Shop_timing_Model');
        $this->load->model('App_Settings_Model');
        $this->load->model('Promo_offers_model');
        $this->load->helper('settings');
        $this->load->helper('shop');
    }

    public function shop_info() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $payPal = get_paypal_settings();
            $sagepay_details = get_sagepay_settings();
            $today_date_strtotime = strtotime(date('Y-m-d'));

            $payPal_data = array(
                'currency' => trim(get_property_value('currency', $payPal)),
                'production_client_id' => trim(get_property_value('production_client_id', $payPal)),
                'sandbox_client_id' => trim(get_property_value('sandbox_client_id', $payPal)),
                'environment' => trim(get_property_value('environment', $payPal))
            );

            $pay360_settings = $this->Settings_Model->get_by(array("name"=>'pay360_settings'),true);
            $pay360_data = '';
            if ($pay360_settings) {
                $pay360_value = json_decode($pay360_settings->value);
                $pay360_data = array(
                    'pay360_merchant_id' => get_property_value('pay360_merchant_id',$pay360_value),
                    'pay360_isv_id' => get_property_value('pay360_isv_id',$pay360_value),
                    'pay360_api_id' => get_property_value('pay360_api_id',$pay360_value),
                    'pay360_api_key' => get_property_value('pay360_api_key',$pay360_value),
                    'pay360_payment_api_key' => get_property_value('pay360_payment_api_key',$pay360_value),
                    'pay360_jwt' => get_property_value('pay360_jwt',$pay360_value),
                    'pay360_description' => get_property_value('pay360_description',$pay360_value),
                    'pay360_payment_mode' => get_property_value('pay360_payment_mode',$pay360_value),
                );
            }

            $discount_value = get_settings_values('discount');
            $daily_discount = "";
            $first_order_discount = "";
            $dailyDiscountAvailability = 0;
            $firstOrderAvailability = 0;
            $collectionOffers = "";
            $deliveryOffers = "";
            $isHasAnyOffers = false;
            if ($discount_value) {
                $current_day_number = date('w');
                $dailyDiscountAvailability = $discount_value[8]->dailyDiscountAvailability;
                $firstOrderAvailability = $discount_value[8]->firstOrderAvailability;
                for ($i = 0; $i < 7; $i++) { 
                    if ($current_day_number == $discount_value[$i]->day_ids) {
                        $daily_discount = array(
                            $discount_value[$i],
                        );
                    }
                }

                $specialOffer = $discount_value[$current_day_number];

                if ((!empty($specialOffer->collection_discount_percent) && $specialOffer->collection_discount_percent > 0) || (!empty($specialOffer->delivery_discount_percent) && $specialOffer->delivery_discount_percent > 0)) {
                    if ($specialOffer->collection_discount_percent > 0) {
                        $isHasAnyOffers = true;
                        $collectionOffers = $specialOffer->collection_discount_percent." % off On Collection Orders Over £".$specialOffer->minimum_order_amount;
                    }

                    if ($specialOffer->delivery_discount_percent > 0) {
                        $isHasAnyOffers = true;
                        $deliveryOffers = $specialOffer->delivery_discount_percent." % off On Delivery Orders Over £".$specialOffer->minimum_order_amount;
                    }
                }

                $first_order_discount = array(
                    $discount_value[7]
                );
            }

            $loyalty_programs_value = get_settings_values('loyalty_programs');
            $loyalty_programs_data = array();
            $loyaltyProgramAvailability = 0;
            if ($loyalty_programs_value) {
                $loyaltyProgramAvailability = $loyalty_programs_value[0]->loyaltyProgramAvailability;
                unset($loyalty_programs_value[0]);
                foreach ($loyalty_programs_value as $loyalty_programs) {
                    array_push($loyalty_programs_data, $loyalty_programs);
                }
            }

            $publishable_key = '';
            $stripe = get_stripe_settings();
            if (!empty($stripe)) {
                $publishable_key = property_exists($stripe, 'publishable_key') ? $stripe->publishable_key : '';
            }
            $stripe_data = array('publishable_key' => $publishable_key);

            $is_shop_closed = is_shop_closed();
            $collection_options = getShopOpeningAndClosingTimeList($is_shop_closed, 'collection');
            $collection_time_options = array();
            foreach ($collection_options as $key => $value) {
                array_push($collection_time_options, array('value' => $key,'label' => $value,));
            }

            $delivery_options = getShopOpeningAndClosingTimeList($is_shop_closed, 'delivery');
            $delivery_time_options = array();

            foreach ($delivery_options as $key => $value) {
                array_push($delivery_time_options, array('value' => $key,'label' => $value,));
            }

            $all_collection_time_by_day = $this->get_delivery_duration('collection');
            $all_delivery_time_by_day = $this->get_delivery_duration('delivery');

            $isOrderEnabled = true;
            $cartPageCheckoutButtonText = 'Process To Checkout';
            $cartPageCheckoutMessage = '';
            $checkoutPageButtonText = 'Submit Order';
            $maintenance_mode_settings = get_maintenance_mode_settings_value();
            $shop_maintenance_mode_message = null;
            $shop_maintenance_mode_image = null;
            $is_shop_maintenance_mode = 0;
            $app_environment_mode = 'live';
            $is_for_today = '';
            $is_for_tomorrow = '';

            if (!empty($maintenance_mode_settings)) {
                $is_shop_maintenance_mode = array_key_exists('is_app_maintenance', $maintenance_mode_settings) ? $maintenance_mode_settings['is_app_maintenance'] : 0;
                $app_environment_mode = array_key_exists('environment', $maintenance_mode_settings) ? $maintenance_mode_settings['environment'] : '';
                $shop_maintenance_mode_message = array_key_exists('message', $maintenance_mode_settings) ? $maintenance_mode_settings['message'] : null;
                $shop_maintenance_mode_image = array_key_exists('image', $maintenance_mode_settings) ? $maintenance_mode_settings['image'] : null;
                $is_for_today = array_key_exists('is_for_today', $maintenance_mode_settings) ? $maintenance_mode_settings['is_for_today'] : '';
                $is_for_tomorrow = array_key_exists('is_for_tomorrow', $maintenance_mode_settings) ? $maintenance_mode_settings['is_for_tomorrow'] : '';
            }

            $payment_settings = get_payment_settings();
            $orderType = get_property_value('order_type', $payment_settings);


            if ($is_shop_closed) {
                $isOrderEnabled = false;
                $cartPageCheckoutButtonText = 'Process To Preorder';
                $cartPageCheckoutMessage = 'Sorry!, We are closed at this moment. Please stay with us.';
            } else if ($is_for_today && $is_for_today['status'] == 1) {
                $is_for_today_date_strtotime = strtotime($is_for_today['date']);
                if ($today_date_strtotime == $is_for_today_date_strtotime) {
                    $is_shop_maintenance_mode = 1;
                    $shop_maintenance_mode_message = 'Sorry!, We are closed at this moment. Please stay with us.';
                    $isOrderEnabled = false;
                }
            } else if ($is_for_tomorrow && $is_for_tomorrow['status'] == 1) {
                $is_for_today_date_strtotime = strtotime($is_for_tomorrow['date']);
                if ($today_date_strtotime == $is_for_today_date_strtotime) {
                    $is_shop_maintenance_mode = 1;
                    $shop_maintenance_mode_message = 'Sorry!, We are closed at this moment. Please stay with us.';
                    $isOrderEnabled = false;
                }
            } else if ($orderType == 'delivery_and_collection') {
                if (empty($delivery_time_options) && empty($collection_time_options)) {
                    $is_shop_maintenance_mode = 1;
                    $cartPageCheckoutMessage = 'Sorry!, We are closed at this moment. Please stay with us.';
                    $isOrderEnabled = false;
                }
            } else if ($orderType == 'delivery') {
                if (empty($delivery_time_options)) {
                    $is_shop_maintenance_mode = 1;
                    $cartPageCheckoutMessage = 'Sorry!, We are closed at this moment. Please stay with us.';
                    $isOrderEnabled = false;
                }
            } else if ($orderType == 'collection') {
                if (empty($collection_time_options)) {
                    $is_shop_maintenance_mode = 1;
                    $cartPageCheckoutMessage = 'Sorry!, We are closed at this moment. Please stay with us.';
                    $isOrderEnabled = false;
                }
            }

            $booking_settings_value = get_settings_values('booking_settings');
            $booking_settings_data = '';
            if ($booking_settings_value) {
                $start_date = get_property_value('start_date',$booking_settings_value);
                $end_date = get_property_value('end_date',$booking_settings_value);
                $is_booking_closed = get_property_value('is_closed',$booking_settings_value);
                $start_date_strtotime = strtotime($start_date);
                $end_date_strtotime = strtotime($end_date);

                $booking_settings_data = array(
                    'reservation_status' => 0,
                    'reservation_status_messgae' => '',
                );

                if ($is_booking_closed == 1 && $start_date_strtotime <= $today_date_strtotime && $today_date_strtotime <= $end_date_strtotime) {
                    $booking_settings_data = array(
                        'reservation_status' => $is_booking_closed,
                        'reservation_status_messgae' => get_settings_values('message',$booking_settings_value),
                    );
                }
            }

            if ($is_shop_maintenance_mode == '1') {
                $isOrderEnabled = false;
                $cartPageCheckoutMessage = $shop_maintenance_mode_message;
            } else {
                if (($is_shop_closed && $is_shop_maintenance_mode == '0') && (empty($delivery_time_options) && empty($collection_time_options))) {
                    $is_shop_maintenance_mode = 1;
                    $shop_maintenance_mode_message = 'Sorry!, We are closed at this moment. Please stay with us.';
                    // $is_shop_closed = false;
                    $isOrderEnabled = false;
                }
            }

            $shop_weekend_off_message = '';
            $is_shop_weekend_off = is_shop_weekend_off();
            // dd($is_shop_weekend_off);

            if ($is_shop_weekend_off) {
                $isOrderEnabled = false;
                $shop_weekend_off_message = 'Sorry!, We are closed at this moment. Please stay with us.';
            }

            $all_tips = $this->Tips_model->get_all_tips();
            $tips_data['tips_for_card'] = $payment_settings->tips_for_card;
            $tips_data['tips_for_cash'] = $payment_settings->tips_for_cash;
            $tips_data['tips_data'] = $all_tips;
            
            $service_charge_value = get_settings_values('service_charge');
            $packaging_charge_value = get_settings_values('packaging_charge');
            $other_settings_value = get_settings_values('other_settings');

            $social_medias = get_social_media_details();
            $companyDetails = get_company_details();
            $current_date = date('Y-m-d');
            $promo_offers = $this->Promo_offers_model->get_promo_offers_for_apps($current_date);

            $data = array(
                'shop_name' => get_property_value('company_name', $companyDetails),
                'shop_address' => get_property_value('company_address', $companyDetails),
                'shop_contact' => get_property_value('contact_number', $companyDetails),
                'is_shop_closed' => $is_shop_closed,
                'is_shop_maintenance_mode' => $is_shop_maintenance_mode,
                'is_shop_weekend_off' => $is_shop_weekend_off,
                'app_environment_mode' => $app_environment_mode,
                'shop_maintenance_mode_message' => $shop_maintenance_mode_message,
                'cartPageCheckoutMessage' => $cartPageCheckoutMessage,
                'shop_weekend_off_message' => $shop_weekend_off_message,
                'isOrderEnabled' => $isOrderEnabled,
                'isCouponEnabled' => get_settings_values('isCouponEnabled'),
                'shop_maintenance_mode_image' => $shop_maintenance_mode_image,
                'tips' => $tips_data,
                'service_charge' => $service_charge_value,
                'packaging_charge' => $packaging_charge_value,
                'other_settings' => $other_settings_value,
                'discount' => array(
                    'dailyDiscountAvailability' => $dailyDiscountAvailability,
                    'firstOrderAvailability' => $firstOrderAvailability,
                    'loyaltyProgramAvailability' => $loyaltyProgramAvailability,
                    'daily_discount' => $daily_discount,
                    'first_order_discount' => $first_order_discount,
                    'loyalty_programs_discount' => $loyalty_programs_data
                ),
                'dailySpecialOffers' => array(
                    'isActiveBtn' => true,
                    'collectionOffers' => $collectionOffers,
                    'deliveryOffers' => $deliveryOffers,
                    'isHasAnyOffers' => $isHasAnyOffers
                ),
                'booking_settings' => $booking_settings_data,
                'order_settings' => $payment_settings,
                'delivery_time_options' => $delivery_time_options,
                'collection_time_options' => $collection_time_options,
                'cartPageCheckoutButtonText' => $cartPageCheckoutButtonText,
                'checkoutPageButtonText' => $checkoutPageButtonText,
                'payment_gateway' => array(
                    'paypal' => $payPal_data,
                    'stripe' => $stripe_data,
                    'pay360' => $pay360_data,
                ),
                'paymentSystemLabel' => array(
                    'cash' => 'Cash(Stricly cash please)',
                    'paypal' => get_property_value('display_name',$payPal),
                    'stripe' => get_property_value('display_name',$stripe),
                    'pay360' => 'Card',
                    'sagepay' => get_property_value('display_name',$sagepay_details)
                ),
                'customMessages' => array(
                    'cartValidity' => array(
                        'titleCollection' => 'Cart Invalid',
                        'titleDelivery' => 'Cart Invalid',
                        'messageCollection' => 'Your cart contain only for Collection Order item',
                        'messageDelivery' => 'Your cart contain only Delivery Order Item ',
                    ),
                    'productOrderType' => array(
                        'titleCollection' => 'This product only for Delivery ',
                        'titleDelivery' => 'This product only for Collection',
                        'messageCollectionProduct' => '',
                        'messageDeliveryProduct' => '',
                        'titleForSelect' => 'Please Select an Order Type',
                        'messageForSelect' => '',
                    ),
                ),
                'social_media_links' => $social_medias,
                'promoOffers' => $promo_offers
            );
            $response_data = array('status' => 200,'message' => 'Settings info','data' => $data,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_opening_closing_time_list() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $shop_timings = $this->Shop_timing_Model->get_all();
            foreach ($shop_timings as $s_timing) {
                $day_name = get_days_of_week()[$s_timing->day_id];
                $open_time = get_formatted_time($s_timing->open_time,'h:i A');
                $close_time = get_formatted_time($s_timing->close_time,'h:i A');
                $is_closed = is_shop_closed_status($s_timing->day_id);
                $s_timing->day_name = $day_name;
                $s_timing->open_time = $open_time;
                $s_timing->close_time = $close_time;
                $s_timing->is_closed = $is_closed;
            }
            $response_data = array('status' => 200,'message' => 'Shop opening closing time','data' => $shop_timings,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }        
    }

    public function get_opening_closing_time_data() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $weekend_off_details = "";
            $weekend_off = $this->Settings_Model->get_by(array("name" => 'weekend_off'), true);
            if ($weekend_off) {
                $weekend_off_details = json_decode($weekend_off->value);
            }
            $booking_settings_details = get_settings_values('booking_settings');
            $data = array(
                'shop_timing_details' => $this->Shop_timing_Model->get_shop_timing_list(),
                'weekend_off_details' => $weekend_off_details,
                'booking_settings_details' => $booking_settings_details,
            );
            $response_data = array('status' => 200,'message' => 'Settings info','data' => $data,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function home() {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $pages = $this->App_Settings_Model->get_decoded_value_by_name('app_menu');
            if ($pages) {
                foreach ($pages as $page) {
                    $page->isActive = (bool) $page->isActive;
                    $page->isShow = (bool) $page->isShow;
                    $page->showInHome = (bool) $page->showInHome;
                }
            }
            $home_settings = $this->App_Settings_Model->get_decoded_value_by_name('home_page');
            if ($home_settings) {
                foreach ($home_settings as $key => $value) {
                    if ($key != 'homeIconImageSide' && $key != 'backgroundColor') {
                        $home_settings->$key = (bool) $value;
                    }
                }
            }
            // dd($home_settings);
            $android_version_info = $this->App_Settings_Model->get_decoded_value_by_name('android_version');
            $ios_version_info = $this->App_Settings_Model->get_decoded_value_by_name('ios_version');
            $social_medias = get_social_media_details();
            $companyDetails = get_company_details();
            $day_number = date('w');
            $shop_timing = get_today_shop_timing($day_number);
            $openCloseTimeText = '';

            if (!empty($shop_timing)) {
                $open_time = $shop_timing->open_time;
                $close_time = $shop_timing->close_time;
                $openCloseTimeText = 'Open: '.getFormatDateTime($open_time, 'g:ia').' - '.getFormatDateTime($close_time, 'g:ia');
                $openCloseTimeText = $openCloseTimeText;
            }

            $data = array(
                'shop_name' => get_property_value('company_name', $companyDetails),
                'shop_address' => get_property_value('company_address', $companyDetails),
                'shop_contact' => get_property_value('contact_number', $companyDetails),
                'contactNumber' => get_property_value('contact_number', $companyDetails),
                'pages' => $pages,
                'homePageSettings' => $home_settings,
                'androidUpdateUrl' => $android_version_info ? $android_version_info->update_url : '',
                'androidVersionNumber' => $android_version_info ? $android_version_info->current_app_version : 0,
                'iosUpdateUrl' => $ios_version_info ? $ios_version_info->update_url : '',
                'iosVersionNumber' => $ios_version_info ? $ios_version_info->current_app_version : 0,
                'iosUpdateMessage' => 'Update your ios app to get free offer item on order amount.',
                'androidUpdateMessage' => 'Update your android app to get free offer item on order amount.',
                'social_media_links' => $social_medias,
                'openCloseTimeText' => $openCloseTimeText,
            );
            $response_data = array('status' => 200,'message' => 'Settings info','data' => $data,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_delivery_duration($order_type) {
        $weekendDayId = get_shop_weekend_day_ids();
        $allTime = $this->Shop_timing_Model->get_all($order_type);    
        $searchTime = "";
        $serachDayId = "";
        $printDayId = "";
        $start = false;
        $result = array();

        foreach ($allTime as $time) {
            if (!in_array($time->day_id,$weekendDayId)) {
                if ($time->collection_delivery_time != $searchTime) {
                    if ($start == true) {
                        if ($serachDayId != $printDayId) {
                            $output .= ' to '.date('D', strtotime("Sunday + $serachDayId Days"));
                        }
                        $start = false;
                        $output .= ' : '.$searchTime.' Min';
                        if ($output) {
                            array_push($result, $output);
                        }
                    }
                    if ($start == false) {
                        $output = '';
                        $output .= date('D', strtotime("Sunday + $time->day_id Days"));
                        $printDayId = $time->day_id;
                    }
                }
                $start = true;
                $searchTime = $time->collection_delivery_time;
                $serachDayId = $time->day_id;       
            }
        }

        if ($start == true) {
            if ($serachDayId != $printDayId) {
                $output .= ' to '.date('D', strtotime("Sunday + $serachDayId Days"));
            }
            $start = false;
            $output .= ' : '.$time->collection_delivery_time.' Min';
            array_push($result, $output);
        }
        return $result;
    }
}
