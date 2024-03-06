<?php
function get_footer_content_status($name = '') {
    $these = & get_instance();
    $is_show = false;
    $page_details = $these->Page_Settings_Model->get_by_name($name);
    if ($page_details && $page_details->is_show == 1) {
        $is_show = true;
    }

    return $is_show;
}

function get_todays_collection_delivery_time($order_type = '') {
    $collection_delivery_time = 0;
    if ($order_type) {
        $these = & get_instance();
        $current_day_id = date('w');
        $result = $these->db->query("SELECT * FROM `shop_timing` WHERE `order_type` = '$order_type' AND `day_id` = $current_day_id")->row();
        if ($result) {
            $collection_delivery_time = $result->collection_delivery_time;
        }
    }

    return $collection_delivery_time;
}

function get_todays_delivery_time() {
    $these = & get_instance();
    $current_day_id = date('w');
    $delivery_time = 0;
    $result = $these->db->query("SELECT * FROM `shop_timing` WHERE `order_type` = 'collection' AND `day_id` = $current_day_id")->row();
    if ($result) {
        $collection_time = $result->collection_delivery_time;
    }

    return $collection_time;
}

function get_settings_values($settings_name) {
    $these = & get_instance();
    $settings = $these->Settings_Model->get_by(array("name" => $settings_name), true);
    if (!empty($settings)) {
        $values = json_decode($settings->value);
    } else {
        $values = '';
    }
    return $values;
}

function get_settings_navigation_bar() {
    $CI = & get_instance();
    ?>
    <div class="settings">
        <ul class="nav nav-tabs">
            <li class="nav-item ">
                <?php
                if ($CI->uri->segment($CI->uri->total_segments()) == 'settings') {
                    $attributes = array(
                        'class' => 'nav-link active'
                    );
                } else {
                    $attributes = array(
                        'class' => 'nav-link'
                    );
                }
                echo anchor($CI->admin . '/settings', 'Company Details', $attributes);
                ?>
            </li>
            <li class="nav-item">
                <?php
                if ($CI->uri->segment($CI->uri->total_segments()) == 'about_us') {
                    $attributes = array(
                        'class' => 'nav-link active'
                    );
                } else {
                    $attributes = array(
                        'class' => 'nav-link'
                    );
                }
                echo anchor($CI->admin . '/settings/about_us', 'About Us', $attributes);
                ?>
            </li>

            <li class="nav-item">
                <?php
                if ($CI->uri->segment($CI->uri->total_segments()) == 'why_we_are') {
                    $attributes = array(
                        'class' => 'nav-link active'
                    );
                } else {
                    $attributes = array(
                        'class' => 'nav-link'
                    );
                }
                echo anchor($CI->admin . '/settings/why_we_are', 'Why We Are', $attributes);
                ?>
            </li>
            <li class="nav-item">
                <?php
                if ($CI->uri->segment($CI->uri->total_segments()) == 'present_offer') {
                    $attributes = array(
                        'class' => 'nav-link active'
                    );
                } else {
                    $attributes = array(
                        'class' => 'nav-link'
                    );
                }
                echo anchor($CI->admin . '/settings/present_offer', 'Present Offer', $attributes);
                ?>
            </li>

            <li class="nav-item">
                <?php
                if ($CI->uri->segment($CI->uri->total_segments()) == 'social_media') {
                    $attributes = array(
                        'class' => 'nav-link active'
                    );
                } else {
                    $attributes = array(
                        'class' => 'nav-link'
                    );
                }
                echo anchor($CI->admin . '/settings/social_media', 'Social Media', $attributes);
                ?>

            </li>

        </ul>

    </div>
    <?php
}

function get_company_name() {
    return !empty(get_company_details()) ? get_company_details()->company_name : '';}

function get_company_logo_url() {
    return !empty(get_company_details()) ? base_url().get_company_details()->company_logo : '';
}

function get_shop_logo() {
    return property_exists(get_company_details(), 'company_logo') ? get_company_details()->company_logo : '';
}

function get_about_us_logo() {
    return property_exists(get_company_about_us(), 'about_us_logo') ? get_company_about_us()->about_us_logo : '';
}

function get_company_address() {
    return !empty(get_company_details()) ? nl2br(get_company_details()->company_address) : '';
}

function get_company_contact_number() {
    return !empty(get_company_details()) ? get_company_details()->contact_number : '';
}

function get_company_contact_email() {
    return !empty(get_company_details()) ? get_company_details()->email : '';
}

function get_company_food_type() {
    return !empty(get_company_details()) ? get_company_details()->food_type : '';
}

function get_company_pickup_time() {
    return !empty(get_company_details()) ? get_company_details()->pickup_time : '';
}

//function get_postcode_list_by_limit() {
//    $postcode_list_by_limit = $this->Allowed_postcodes_Model->get_postcode_by_limit($limit = 20);
//    return !empty($postcode_list_by_limit) ? $postcode_list_by_limit : '';
//}

function get_company_details() {
    $CI = &get_instance();
    $company_details = $CI->Settings_Model->get_by(array("name" => 'company_details'), true);
    $details = '';
    if (!empty($company_details)) {
        $details = json_decode($company_details->value);
    }

    return $details;
}

function get_other_settings_details() {
    $these =& get_instance();
    $details = '';
    $other_settings_info = $these->Settings_Model->get_by(array('name'=>'other_settings'),true);
    if ($other_settings_info) {
        $details = json_decode($other_settings_info->value);
    }

    return $details;
}

function get_home_promo_settings_details() {
    $these = &get_instance();
    $details = '';
    $home_promo_info = $these->Settings_Model->get_by(array('name'=>'home_promo'),true);
    if ($home_promo_info) {
        $details = json_decode($home_promo_info->value);
    }

    return $details;
}

/* function get_company_about_us(){
  $CI =& get_instance();
  $about_us=$CI->Settings_Model->get_by(array("name"=>'about_us'),true);
  return $about_us->value;
  } */

function get_company_about_us() {
    $CI = & get_instance();
    $about_us = $CI->Settings_Model->get_by(array("name" => 'about_us'), true);
    if (!empty($about_us)) {
        $about_us = json_decode($about_us->value);
    } else {
        $about_us = '';
    }
    return $about_us;
}

function design_develop_by() {
    echo '<p>© ' . date('Y') . ' ' . get_company_name() . '. All rights reserved | Design by <a target="_blank" href="https://elipos.co.uk/">Elipos Systems</a></p>';
}

function get_social_media_details() {

    $CI = & get_instance();
    $social_media_details = $CI->Settings_Model->get_by(array("name" => 'social_media'), true);
    if (!empty($social_media_details)) {
        $details = json_decode($social_media_details->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_facebook_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->facebook) ? get_social_media_details()->facebook : '';
    }
    return '';
}

function get_youtube_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->youtube) ? get_social_media_details()->youtube : '';
    }
    return '';
}

function get_linkedIn_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->linkedIn) ? get_social_media_details()->linkedIn : '';
    }
    return '';
}

function get_googlePlus_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->googlePlus) ? get_social_media_details()->googlePlus : '';
    }
    return '';
}

function get_twitter_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->twitter) ? get_social_media_details()->twitter : '';
    }
    return '';
}

function get_skype_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->skype) ? get_social_media_details()->skype : '';
    }
    return '';
}

function get_instagram_url() {
    if (!empty(get_social_media_details())) {
        return !empty(get_social_media_details()->instagram) ? get_social_media_details()->instagram : '';
    }
    return '';
}

function the_social_medias() {
    ?>

    <div class="footer_social">
        <ul class="footbot_social">
            <?php if (!empty(get_facebook_url())) { ?>
                <li><a class="fb" href="<?= get_facebook_url() ?>" data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                <?php
            }

            if (!empty(get_twitter_url())) {
                ?>
                <li><a class="twtr" href="<?= get_twitter_url() ?>" data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                <?php
            }


            if (!empty(get_skype_url())) {
                ?>

                <li><a class="skype" href="<?= get_skype_url() ?>" data-placement="top" data-toggle="tooltip" title="Skype"><i class="fa fa-skype"></i></a></li>

                <?php
            }

            if (!empty(get_linkedIn_url())) {
                ?>

                <li><a class="linkedIn" href="<?= get_linkedIn_url() ?>" data-placement="top" data-toggle="tooltip" title="linkedIn"><i class="fa fa-linkedin-square"></i></a></li>

                <?php
            }
            ?>
        </ul>
    </div>

    <?php
}

function get_smtp_config_details() {
    $CI = & get_instance();
    $smtp_config = $CI->Settings_Model->get_by(array("name" => 'smtp_config'), true);
    if (!empty($smtp_config)) {
        $details = json_decode($smtp_config->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_smtp_host_url() {
    return !empty(get_smtp_config_details()) ? get_smtp_config_details()->host : '';
}

function get_smtp_host_user() {
    return !empty(get_smtp_config_details()) ? get_smtp_config_details()->user : '';
}

function get_smtp_host_user_password() {
    return !empty(get_smtp_config_details()) ? get_smtp_config_details()->password : '';
}

function get_smtp_mail_form_title() {
    return !empty(get_smtp_config_details()) ? get_smtp_config_details()->form : '';
}

/* Payment Settings */
function get_payment_settings() {
    $CI = & get_instance();
    $payment_settings = $CI->Settings_Model->get_by(array("name" => 'payment_settings'), true);
    if (!empty($payment_settings)) {
        $details = json_decode($payment_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_payment_settings_id() {
    $CI = & get_instance();
    $payment_settings = $CI->Settings_Model->get_by(array("name" => 'payment_settings'), true);
    if (!empty($payment_settings)) {
        return $payment_settings->id;
    } else {
        return '';
    }
}

function get_payment_gateways() {
    return property_exists(get_payment_settings(), 'payment_gateway') ? get_payment_settings()->payment_gateway : array();
}

function get_payment_mode() {
    return property_exists(get_payment_settings(), 'payment_mode') ? get_payment_settings()->payment_mode : '';
}

function get_delivery_options() {
    return property_exists(get_payment_settings(), 'delivery_options') ? get_payment_settings()->delivery_options : '';
}

function get_order_type() {
    $payment_settings = get_payment_settings();
    return property_exists($payment_settings, 'order_type') ? $payment_settings->order_type : '';
}

function get_payment_method() {
    return property_exists(get_payment_settings(), 'payment_method') ? get_payment_settings()->payment_method : '';
}

function get_dine_in() {
    return property_exists(get_payment_settings(), 'dine_in') ? get_payment_settings()->dine_in : '';
}

function get_reservation() {
    return property_exists(get_payment_settings(), 'reservation') ? get_payment_settings()->reservation : '';
}

function get_reservation_amount() {
    return property_exists(get_payment_settings(), 'reservation_amount') ? get_payment_settings()->reservation_amount : 0;
}

function get_tips_status($key) {
    return property_exists(get_payment_settings(), $key) ? get_payment_settings()->$key : '';
}

function get_tips_for_card() {
    return property_exists(get_payment_settings(), 'tips_for_card') ? get_payment_settings()->tips_for_card : '';
}

function get_tips_for_cash() {
    return property_exists(get_payment_settings(), 'tips_for_cash') ? get_payment_settings()->tips_for_cash : '';
}

function get_surcharge() {
    return property_exists(get_payment_settings(), 'surcharge') ? get_payment_settings()->surcharge : '';
}

function get_loyalty_point_status() {
    return property_exists(get_payment_settings(), 'lp_status') ? get_payment_settings()->lp_status : '';
}

function get_loyalty_point_earn_rate() {
    return property_exists(get_payment_settings(), 'lp_earn_rate') ? get_payment_settings()->lp_earn_rate : '';
}

#Region Booking Settings
    function get_booking_settings() {
        $CI = & get_instance();
        $booking_settings = $CI->Settings_Model->get_by(array("name" => 'booking_settings'), true);
        $details = null;
        if (!empty($booking_settings)) {
            $details = json_decode($booking_settings->value);
        }

        return $details;
    }

    function get_booking_accepted_message() {
        $booking_settings = get_booking_settings();
        $accepted_message =  property_exists($booking_settings, 'accepted_message') ? $booking_settings->accepted_message : '';
        return $accepted_message;
    }

    function get_booking_rejected_message() {
        $booking_settings = get_booking_settings();
        $rejected_message =  property_exists($booking_settings, 'rejected_message') ? $booking_settings->rejected_message : '';
        return $rejected_message;
    }
#End Region

#Region Stripe Settings 
    function get_stripe_settings() {
        $CI = & get_instance();
        $stripe_settings = $CI->Settings_Model->get_by(array("name" => 'stripe_settings'), true);
        $details = null;
        if (!empty($stripe_settings)) {
            $details = json_decode($stripe_settings->value);
        }

        return $details;
    }

    function get_stripe_settings_id() {
        $CI = & get_instance();
        $stripe_settings = $CI->Settings_Model->get_by(array("name" => 'stripe_settings'), true);
        if (!empty($stripe_settings)) {
            return $stripe_settings->id;
        }
        return null;
    }

    function get_stripe_display_name() {
        $stripe_settings = get_stripe_settings();
        $display_name =  property_exists($stripe_settings, 'display_name') ? $stripe_settings->display_name : '';
        if (empty($display_name)) {
            $display_name = 'Stripe';
        }
        return $display_name;
    }
#End Region

#Region Paypal Settings
    function get_paypal_settings() {
        $CI = & get_instance();
        $paypal_settings = $CI->Settings_Model->get_by(array("name" => 'paypal_settings'), true);
        if (!empty($paypal_settings)) {
            $details = json_decode($paypal_settings->value);
        } else {
            $details = '';
        }

        return $details;
    }

    function get_paypal_settings_id() {
        $CI = & get_instance();
        $paypal_settings = $CI->Settings_Model->get_by(array("name" => 'paypal_settings'), true);
        if (!empty($paypal_settings)) {
            return $paypal_settings->id;
        } else {
            return '';
        }
    }

    function get_paypal_display_name() {
        $paypal_settings = get_paypal_settings();
        $display_name =  property_exists($paypal_settings, 'display_name') ? $paypal_settings->display_name : '';
        if (empty($display_name)) {
            $display_name = 'Paypal';
        }
        return $display_name;
    }

    function get_paypal_api_signature() {
        return property_exists(get_paypal_settings(), 'paypal_api_signature') ? get_paypal_settings()->paypal_api_signature : '';
    }

    function get_paypal_api_password() {
        return property_exists(get_paypal_settings(), 'paypal_api_password') ? get_paypal_settings()->paypal_api_password : '';
    }

    function get_paypal_api_username() {
        return property_exists(get_paypal_settings(), 'paypal_api_username') ? get_paypal_settings()->paypal_api_username : '';
    }
#End Region

#Region Maintennace Mode
    function get_maintenance_settings() {
        $CI = & get_instance();
        $paypal_settings = $CI->Settings_Model->get_by(array("name" => 'get_maintenance_settings'), true);
        if (!empty($paypal_settings)) {
            $details = json_decode($paypal_settings->value);
        } else {
            $details = '';
        }

        return $details;
    }
#End Region

#Region nochecx Settings
    function get_nochecx_settings() {
        $CI = & get_instance();
        $nochecx_settings = $CI->Settings_Model->get_by(array("name" => 'nochecx_settings'), true);
        if (!empty($nochecx_settings)) {
            $details = json_decode($nochecx_settings->value);
        } else {
            $details = '';
        }

        return $details;
    }

    function get_nochecx_settings_id() {
        $CI = & get_instance();
        $nochecx_settings = $CI->Settings_Model->get_by(array("name" => 'nochecx_settings'), true);
        if (!empty($nochecx_settings)) {
            return $nochecx_settings->id;
        } else {
            return '';
        }
    }

    function get_nochecx_display_name() {
        $nochex_settings = get_nochecx_settings();
        $display_name =  property_exists($nochex_settings, 'display_name') ? $nochex_settings->display_name : '';
        if (empty($display_name)) {
            $display_name = 'Nochex';
        }
        return $display_name;
    }

    function get_nochecx_action_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_action_url') ? $nochex_settings->nochecx_action_url : '';
    }

    function get_nochecx_callback_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_callback_url') ? $nochex_settings->nochecx_callback_url : '';
    }

    function get_nochecx_merchant_email() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_merchant_email') ? $nochex_settings->nochecx_merchant_email : '';
    }

    function get_nochecx_description() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_description') ? $nochex_settings->nochecx_description : '';
    }

    function get_nochecx_success_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_success_url') ? $nochex_settings->nochecx_success_url : '';
    }

    function get_nochecx_failure_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_failure_url') ? $nochex_settings->nochecx_failure_url : '';
    }

    function get_nochecx_cancel_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_cancel_url') ? $nochex_settings->nochecx_cancel_url : '';
    }

    function get_nochecx_test_success_url() {
        $nochex_settings = get_nochecx_settings();
        return property_exists($nochex_settings, 'nochecx_test_success_url') ? $nochex_settings->nochecx_test_success_url : '';
    }
#End Region

#Region Pay360 Settings
    function get_pay360_settings() {
        $CI = & get_instance();
        $pay360_settings = $CI->Settings_Model->get_by(array("name" => 'pay360_settings'), true);
        if (!empty($pay360_settings)) {
            $details = json_decode($pay360_settings->value,true);
        } else {
            $details = '';
        }
        return $details;
    }

    function get_pay360_settings_id() {
        $CI = & get_instance();
        $pay360_settings = $CI->Settings_Model->get_by(array("name" => 'pay360_settings'), true);
        if (!empty($pay360_settings)) {
            return $pay360_settings->id;
        } else {
            return '';
        }
    }

    function get_pay360_value_info($value = '') {
        $pay360_settings = get_pay360_settings();
        return array_key_exists($value,$pay360_settings) ? $pay360_settings[$value] : '';
    }
#End Region

#Region Sagepay Settings
    function get_sagepay_settings() {
        $CI = & get_instance();
        $sagepay_settings = $CI->Settings_Model->get_by(array("name" => 'sagepay_settings'), true);
        $details = '';
        if (!empty($sagepay_settings)) {
            $details = json_decode($sagepay_settings->value);
        }

        return $details;
    }

    function get_sagepay_settings_id() {
        $CI = & get_instance();
        $sagepay_settings = $CI->Settings_Model->get_by(array("name" => 'sagepay_settings'), true);
        if ($sagepay_settings) {
            return $sagepay_settings->id;
        }
        return '';
    }

    function get_sagepay_display_name() {
        $sagepay_settings = get_sagepay_settings();
        $display_name =  property_exists($sagepay_settings, 'display_name') ? $sagepay_settings->display_name : '';
        if (empty($display_name)) {
            $display_name = 'Sagepay';
        }
        return $display_name;
    }

    function get_sagepay_environment() {
        return property_exists(get_sagepay_settings(), 'environment') ? get_sagepay_settings()->environment : '';
    }

    function get_sagepay_vendor_name() {
        return property_exists(get_sagepay_settings(), 'vendor_name') ? get_sagepay_settings()->vendor_name : '';
    }

    function get_sagepay_sandbox_integration_key() {
        return property_exists(get_sagepay_settings(), 'sandbox_integration_key') ? get_sagepay_settings()->sandbox_integration_key : '';
    }

    function get_sagepay_sandbox_integration_password() {
        return property_exists(get_sagepay_settings(), 'sandbox_integration_password') ? get_sagepay_settings()->sandbox_integration_password : '';
    }

    function get_sagepay_production_integration_key() {
        return property_exists(get_sagepay_settings(), 'production_integration_key') ? get_sagepay_settings()->production_integration_key : '';
    }

    function get_sagepay_production_integration_password() {
        return property_exists(get_sagepay_settings(), 'production_integration_password') ? get_sagepay_settings()->production_integration_password : '';
    }

    function get_sagepay_sandbox_server() {
        return property_exists(get_sagepay_settings(), 'sandbox_server') ? get_sagepay_settings()->sandbox_server : '';
    }

    function get_sagepay_production_server() {
        return property_exists(get_sagepay_settings(), 'production_server') ? get_sagepay_settings()->production_server : '';
    }

    function get_sagepay_description() {
        return property_exists(get_sagepay_settings(), 'description') ? get_sagepay_settings()->description : '';
    }

    function get_sagepay_active_server() {
        $environment = get_sagepay_environment();
        $sandbox_server = get_sagepay_sandbox_server();
        $production_server = get_sagepay_production_server();

        if (empty($sandbox_server)) {
            $sandbox_server = "https://pi-test.sagepay.com/api/v1/";
        }

        if (empty($production_server)) {
            $production_server = "https://pi-live.sagepay.com/api/v1/";
        }

        $server = $sandbox_server;
        if ($environment == 'live') {
            $server = $production_server;
        }
        return $server;
    }

    function get_sagepay_active_integration_key() {
        $environment = get_sagepay_environment();
        $sandbox_integration_key = get_sagepay_sandbox_integration_key();
        $production_integration_key = get_sagepay_production_integration_key();

        $integration_key = $sandbox_integration_key;
        if ($environment == 'live') {
            $integration_key = $production_integration_key;
        }

        return $integration_key;
    }

    function get_sagepay_active_integration_password() {
        $environment = get_sagepay_environment();
        $sandbox_integration_password = get_sagepay_sandbox_integration_password();
        $production_integration_password = get_sagepay_production_integration_password();

        $integration_password = $sandbox_integration_password;
        if ($environment == 'live') {
            $integration_password = $production_integration_password;
        }

        return $integration_password;
    }

    function get_sagepay_base64_encoded_integration_key_and_password() {
        $integration_key = get_sagepay_active_integration_key();
        $integration_password = get_sagepay_active_integration_password();
        $combined_string = $integration_key.":".$integration_password;
        $encoded_string = base64_encode($combined_string);
        return $encoded_string;
    }
#End Region

#Region Cardstream Settings
    function get_cardstream_settings() {
        $CI = & get_instance();
        $cardstream_settings = $CI->Settings_Model->get_by(array("name" => 'cardstream_settings'), true);
        $details = '';
        if (!empty($cardstream_settings)) {
            $details = json_decode($cardstream_settings->value);
        }

        return $details;
    }

    function get_cardstream_settings_id() {
        $CI = & get_instance();
        $cardstream_settings = $CI->Settings_Model->get_by(array("name" => 'cardstream_settings'), true);
        if (!empty($cardstream_settings)) {
            return $cardstream_settings->id;
        }
        return '';
    }

    function get_cardstream_display_name() {
        $cardstream_settings = get_cardstream_settings();
        $display_name =  property_exists($cardstream_settings, 'display_name') ? $cardstream_settings->display_name : '';
        if (empty($display_name)) {
            $display_name = 'Cardstream';
        }
        return $display_name;
    }

    function get_cardstream_marchant_account_id() {
        return property_exists(get_cardstream_settings(), 'marchant_account_id') ? get_cardstream_settings()->marchant_account_id : '';
    }

    function get_cardstream_signature_key() {
        return property_exists(get_cardstream_settings(), 'signature_key') ? get_cardstream_settings()->signature_key : '';
    }

    function get_cardstream_environment() {
        return property_exists(get_cardstream_settings(), 'environment') ? get_cardstream_settings()->environment : '';
    }

    function get_cardstream_url_mode() {
        return property_exists(get_cardstream_settings(), 'url_mode') ? get_cardstream_settings()->url_mode : '';
    }

    function get_cardstream_redirect_url() {
        return property_exists(get_cardstream_settings(),'redirect_url') ? get_cardstream_settings()->redirect_url : '';
    }

    function get_cardstream_test_hosted_url() {
        return property_exists(get_cardstream_settings(), 'test_hosted_url') ? get_cardstream_settings()->test_hosted_url : '';
    }

    function get_cardstream_live_hosted_url() {
        return property_exists(get_cardstream_settings(), 'live_hosted_url') ? get_cardstream_settings()->live_hosted_url : '';
    }

    function get_cardstream_test_direct_url() {
        return property_exists(get_cardstream_settings(), 'test_direct_url') ? get_cardstream_settings()->test_direct_url : '';
    }

    function get_cardstream_live_direct_url() {
        return property_exists(get_cardstream_settings(), 'live_direct_url') ? get_cardstream_settings()->live_direct_url : '';
    }

    function get_cardstream_description() {
        return property_exists(get_cardstream_settings(), 'description') ? get_cardstream_settings()->description : '';
    }

    function get_cardstream_active_url() {
        $environment = get_cardstream_environment();
        $url_mode = get_cardstream_url_mode();
        $test_hosted_url = get_cardstream_test_hosted_url();
        $live_hosted_url = get_cardstream_live_hosted_url();
        $test_direct_url = get_cardstream_test_direct_url();
        $live_direct_url = get_cardstream_live_direct_url();

        if (empty($test_hosted_url)) {
            $test_hosted_url = "https://gateway.cardstream.com/hosted/";
        }

        if (empty($live_hosted_url)) {
            $live_hosted_url = "https://gateway.cardstream.com/hosted/";
        }

        if (empty($test_direct_url)) {
            $test_direct_url = "https://gateway.cardstream.com/direct/";
        }

        if (empty($live_direct_url)) {
            $live_direct_url = "https://gateway.cardstream.com/direct/";
        }

        if ($url_mode == 'hosted_url') {
            $url = $test_hosted_url;
            if ($environment == 'live') {
                $url = $live_hosted_url;
            }
        } else {
            $url = $test_direct_url;
            if ($environment == 'live') {
                $url = $live_direct_url;
            }
        }
        
        return $url;
    }
#End Region

/* barclycard Settings */

function get_barclycard_settings() {
    $CI = & get_instance();
    $barclycard_settings = $CI->Settings_Model->get_by(array("name" => 'barclycard_settings'), true);
    if (!empty($barclycard_settings)) {
        $details = json_decode($barclycard_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_barclycard_settings_id() {
    $CI = & get_instance();
    $barclycard_settings = $CI->Settings_Model->get_by(array("name" => 'barclycard_settings'), true);
    if (!empty($barclycard_settings)) {
        return $barclycard_settings->id;
    } else {
        return '';
    }
}

function get_barclycard_pspid() {
    return property_exists(get_barclycard_settings(), 'barclycard_pspid') ? get_barclycard_settings()->barclycard_pspid : '';
}

function get_barclycard_sha_in_pass_phrase() {
    return property_exists(get_barclycard_settings(), 'barclycard_sha_in_pass_phrase') ? get_barclycard_settings()->barclycard_sha_in_pass_phrase : '';
}

function get_barclycard_sha_out_pass_phrase() {
    return property_exists(get_barclycard_settings(), 'barclycard_sha_out_pass_phrase') ? get_barclycard_settings()->barclycard_sha_out_pass_phrase : '';
}

function get_barclycard_decline_url() {
    return property_exists(get_barclycard_settings(), 'barclycard_decline_url') ? get_barclycard_settings()->barclycard_decline_url : '';
}

function get_barclycard_accept_url() {
    return property_exists(get_barclycard_settings(), 'barclycard_accept_url') ? get_barclycard_settings()->barclycard_accept_url : '';
}

/* Worldpay Settings */

function get_worldpay_settings() {
    $CI = & get_instance();
    $worldpay_settings = $CI->Settings_Model->get_by(array("name" => 'worldpay_settings'), true);

    if (!empty($worldpay_settings)) {
        $details = json_decode($worldpay_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_worldpay_settings_id() {
    $CI = & get_instance();
    $worldpay_settings = $CI->Settings_Model->get_by(array("name" => 'worldpay_settings'), true);
    if (!empty($worldpay_settings)) {
        return $worldpay_settings->id;
    } else {
        return '';
    }
}

function get_worldpay_status() {
    return property_exists(get_worldpay_settings(), 'worldpay_status') ? get_worldpay_settings()->worldpay_status : '';
}

function get_worldpay_application_id() {
    return property_exists(get_worldpay_settings(), 'worldpay_application_id') ? get_worldpay_settings()->worldpay_application_id : '';
}

function get_worldpay_currency() {
    return property_exists(get_worldpay_settings(), 'worldpay_currency') ? get_worldpay_settings()->worldpay_currency : '';
}

/* Home Meta */

function get_home_meta() {
    $CI = & get_instance();
    $home_meta = $CI->Settings_Model->get_by(array("name" => 'home_meta'), true);

    if (!empty($home_meta)) {
        $details = json_decode($home_meta->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_home_meta_id() {
    $CI = & get_instance();
    $home_meta = $CI->Settings_Model->get_by(array("name" => 'home_meta'), true);
    if (!empty($home_meta)) {
        return $home_meta->id;
    } else {
        return '';
    }
}

function get_home_meta_title() {
    return property_exists(get_home_meta(), 'meta_title') ? get_home_meta()->meta_title : '';
}

function get_home_meta_description() {
    return property_exists(get_home_meta(), 'meta_description') ? get_home_meta()->meta_description : '';
}

function get_home_meta_keywords() {
    return property_exists(get_home_meta(), 'meta_keywords') ? get_home_meta()->meta_keywords : '';
}

/* Checkout Settings */

function get_checkout_settings() {
    $CI = & get_instance();
    $checkout_settings = $CI->Settings_Model->get_by(array("name" => 'checkout_settings'), true);

    if (!empty($checkout_settings)) {
        $details = json_decode($checkout_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_checkout_settings_id() {
    $CI = & get_instance();
    $checkout_settings = $CI->Settings_Model->get_by(array("name" => 'checkout_settings'), true);
    if (!empty($checkout_settings)) {
        return $checkout_settings->id;
    } else {
        return '';
    }
}

function get_checkout_button_placement() {
    return property_exists(get_checkout_settings(), 'button_placement') ? get_checkout_settings()->button_placement : '';
}

function get_is_guest_checkout() {
    return property_exists(get_checkout_settings(), 'is_guest_checkout') ? get_checkout_settings()->is_guest_checkout : '';
}

/* maintenance mode settings */

function get_maintenance_mode_settings() {
    $CI = & get_instance();
    $maintenance_mode_settings = $CI->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);

    return $maintenance_mode_settings;
}

function get_desktop_data_settings() {
    $CI = & get_instance();
    $desktop_data_settings = $CI->Settings_Model->get_by(array("name" => 'desktop_data'), true);

    return $desktop_data_settings;
}

function get_maintenance_mode_settings_value() {
    $CI = & get_instance();
    $maintenance_mode_settings = $CI->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);

    return (!empty($maintenance_mode_settings)) ? json_decode($maintenance_mode_settings->value, true) : array();
}

function get_maintenance_mode_settings_id() {
    $CI = & get_instance();
    $maintenance_mode_settings = $CI->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);
    if (!empty($maintenance_mode_settings)) {
        return $maintenance_mode_settings->id;
    } else {
        return '';
    }
}

function get_is_maintenance_mode_on() {
    return property_exists(get_maintenance_mode_settings(), 'is_maintenance_mode_on') ? get_maintenance_mode_settings()->is_maintenance_mode_on : '';
}

function get_maintenance_message() {
    return property_exists(get_maintenance_mode_settings(), 'maintenance_message') ? get_maintenance_mode_settings()->maintenance_message : '';
}

/* google_analytics_verification_settings google_verification_code google_analytics_account_id  */

function get_google_analytics_verification_settings() {
    $CI = & get_instance();
    $google_analytics_verification_settings = $CI->Settings_Model->get_by(array("name" => 'google_analytics_verification_settings'), true);

    if (!empty($google_analytics_verification_settings)) {
        $details = json_decode($google_analytics_verification_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_google_analytics_verification_settings_id() {
    $CI = & get_instance();
    $google_analytics_verification_settings = $CI->Settings_Model->get_by(array("name" => 'google_analytics_verification_settings'), true);
    if (!empty($google_analytics_verification_settings)) {
        return $google_analytics_verification_settings->id;
    } else {
        return '';
    }
}

function get_google_verification_code() {
    return property_exists(get_google_analytics_verification_settings(), 'google_verification_code') ? get_google_analytics_verification_settings()->google_verification_code : '';
}

function get_google_analytics_account_id() {
    return property_exists(get_google_analytics_verification_settings(), 'google_analytics_account_id') ? get_google_analytics_verification_settings()->google_analytics_account_id : '';
}

/* Shop Timing settings */

function get_shop_timing_settings() {
    $CI = & get_instance();
    $shop_timing_settings = $CI->Settings_Model->get_by(array("name" => 'shop_timing'), true);

    if (!empty($shop_timing_settings)) {
        $details = json_decode($shop_timing_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function get_shop_timing_settings_id() {
    $CI = & get_instance();
    $shop_timing_settings = $CI->Settings_Model->get_by(array("name" => 'shop_timing'), true);

    if (!empty($shop_timing_settings)) {
        return $shop_timing_settings->id;
    } else {
        return '';
    }
}

function get_address_settings() {
    $CI = & get_instance();
    $address_settings = $CI->Settings_Model->get_by(array("name" => 'address_settings'), true);
    if (!empty($address_settingss)) {
        $details = json_decode($address_settings->value);
    } else {
        $details = '';
    }
    return $details;
}

function get_address_settings_id() {
    $CI = & get_instance();
    $address_settings = $CI->Settings_Model->get_by(array("name" => 'address_settings'), true);
    if (!empty($address_settings)) {
        return $address_settings->id;
    } else {
        return '';
    }
}

function get_address_line_1() {
    return property_exists(get_address_settings(), 'address_line_1') ? get_address_settings()->address_line_1 : '';
}

function get_address_line_2() {
    return property_exists(get_address_settings(), 'address_line_2') ? get_address_settings()->address_line_2 : '';
}

function get_address_line_3() {
    return property_exists(get_address_settings(), 'address_line_3') ? get_address_settings()->address_line_3 : '';
}

function get_city() {
    return property_exists(get_address_settings(), 'city') ? get_address_settings()->city : '';
}

function get_postcode() {
    return property_exists(get_address_settings(), 'postcode') ? get_address_settings()->postcode : '';
}

function get_latitude() {
    return property_exists(get_address_settings(), 'latitude') ? get_address_settings()->latitude : '';
}

function get_longitude() {
    return property_exists(get_address_settings(), 'longitude') ? get_address_settings()->longitude : '';
}

function get_phone() {
    return property_exists(get_address_settings(), 'phone') ? get_address_settings()->phone : '';
}

/* Site_font_settings */

function get_site_font_settings() {
    $CI = & get_instance();
    $site_font_settings = $CI->Settings_Model->get_by(array("name" => 'site_font_settings'), true);
    if (!empty($site_font_settings)) {
        $details = json_decode($site_font_settings->value);
    } else {
        $details = '';
    }
    return $details;
}

function get_site_font_settings_id() {
    $CI = & get_instance();
    $site_font_settings = $CI->Settings_Model->get_by(array("name" => 'site_font_settings'), true);
    if (!empty($site_font_settings)) {
        return $site_font_settings->id;
    } else {
        return '';
    }
}

/* Calling setting json value */

function get_site_color_by_name($valueObject, $property_name) {
    return property_exists($valueObject, $property_name) ? $valueObject->$property_name : '#ffffff';
}

function get_site_font_size_by_name($valueObject, $property_name) {
    return property_exists($valueObject, $property_name) ? $valueObject->$property_name : '10';
}

/* Food Allergy Settings */

function get_food_allergy_settings() {
    $CI = & get_instance();
    $food_allergy_settings = $CI->Settings_Model->get_by(array("name" => 'food_allergy_settings'), true);
    if (!empty($food_allergy_settings)) {
        $details = json_decode($food_allergy_settings->value);
    } else {
        $details = '';
    }
    return $details;
}

function get_food_allergy_settings_id() {
    $CI = & get_instance();
    $food_allergy_settings = $CI->Settings_Model->get_by(array("name" => 'food_allergy_settings'), true);
    if (!empty($food_allergy_settings)) {
        return $food_allergy_settings->id;
    } else {
        return '';
    }
}

function get_food_allergy_description() {
    return property_exists(get_food_allergy_settings(), 'food_allergy_description') ? get_food_allergy_settings()->food_allergy_description : '';
}

function get_food_allergy_image() {
    return property_exists(get_food_allergy_settings(), 'food_allergy_description') ? get_food_allergy_settings()->food_allergy_image : '';
}

/* Skin Settings */

/* Food Allergy Settings */

function get_skin_settings() {
    $CI = & get_instance();
    $food_allergy_settings = $CI->Settings_Model->get_by(array("name" => 'skin_settings'), true);
    if (!empty($food_allergy_settings)) {
        $details = json_decode($food_allergy_settings->value);
    } else {
        $details = '';
    }
    return $details;
}

function get_skin_settings_id() {
    $CI = & get_instance();
    $food_allergy_settings = $CI->Settings_Model->get_by(array("name" => 'skin_settings'), true);
    if (!empty($food_allergy_settings)) {
        return $food_allergy_settings->id;
    } else {
        return '';
    }
}

function get_site_background_color() {
    return property_exists(get_skin_settings(), 'site_background_color') ? get_skin_settings()->site_background_color : '#ffffff';
}

function get_site_theme() {
    return property_exists(get_skin_settings(), 'site_theme') ? get_skin_settings()->site_theme : '';
}

function get_background_image() {
    return property_exists(get_skin_settings(), 'background_image') ? get_skin_settings()->background_image : '';
}

function get_menu_file() {
    return property_exists(get_skin_settings(), 'menu_file') ? get_skin_settings()->menu_file : '';
}

// allowed postcode

function get_postcode_service_charge($postcode) {
    $CI = & get_instance();
    if (!empty($postcode)) {
        $result = $CI->Allowed_postcodes_Model->get_by(array('postcode' => $postcode), true);
        if (!empty($result)) {
            return $result->delivery_charge;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_currency_array() {
    return array(
        'ALL' => 'Albania Lek',
        'AFN' => 'Afghanistan Afghani',
        'ARS' => 'Argentina Peso',
        'AWG' => 'Aruba Guilder',
        'AUD' => 'Australia Dollar',
        'AZN' => 'Azerbaijan New Manat',
        'BSD' => 'Bahamas Dollar',
        'BBD' => 'Barbados Dollar',
        'BDT' => 'Bangladeshi taka',
        'BYR' => 'Belarus Ruble',
        'BZD' => 'Belize Dollar',
        'BMD' => 'Bermuda Dollar',
        'BOB' => 'Bolivia Boliviano',
        'BAM' => 'Bosnia and Herzegovina Convertible Marka',
        'BWP' => 'Botswana Pula',
        'BGN' => 'Bulgaria Lev',
        'BRL' => 'Brazil Real',
        'BND' => 'Brunei Darussalam Dollar',
        'KHR' => 'Cambodia Riel',
        'CAD' => 'Canada Dollar',
        'KYD' => 'Cayman Islands Dollar',
        'CLP' => 'Chile Peso',
        'CNY' => 'China Yuan Renminbi',
        'COP' => 'Colombia Peso',
        'CRC' => 'Costa Rica Colon',
        'HRK' => 'Croatia Kuna',
        'CUP' => 'Cuba Peso',
        'CZK' => 'Czech Republic Koruna',
        'DKK' => 'Denmark Krone',
        'DOP' => 'Dominican Republic Peso',
        'XCD' => 'East Caribbean Dollar',
        'EGP' => 'Egypt Pound',
        'SVC' => 'El Salvador Colon',
        'EEK' => 'Estonia Kroon',
        'EUR' => 'Euro Member Countries',
        'FKP' => 'Falkland Islands (Malvinas) Pound',
        'FJD' => 'Fiji Dollar',
        'GHC' => 'Ghana Cedis',
        'GIP' => 'Gibraltar Pound',
        'GTQ' => 'Guatemala Quetzal',
        'GGP' => 'Guernsey Pound',
        'GYD' => 'Guyana Dollar',
        'HNL' => 'Honduras Lempira',
        'HKD' => 'Hong Kong Dollar',
        'HUF' => 'Hungary Forint',
        'ISK' => 'Iceland Krona',
        'INR' => 'India Rupee',
        'IDR' => 'Indonesia Rupiah',
        'IRR' => 'Iran Rial',
        'IMP' => 'Isle of Man Pound',
        'ILS' => 'Israel Shekel',
        'JMD' => 'Jamaica Dollar',
        'JPY' => 'Japan Yen',
        'JEP' => 'Jersey Pound',
        'KZT' => 'Kazakhstan Tenge',
        'KPW' => 'Korea (North) Won',
        'KRW' => 'Korea (South) Won',
        'KGS' => 'Kyrgyzstan Som',
        'LAK' => 'Laos Kip',
        'LVL' => 'Latvia Lat',
        'LBP' => 'Lebanon Pound',
        'LRD' => 'Liberia Dollar',
        'LTL' => 'Lithuania Litas',
        'MKD' => 'Macedonia Denar',
        'MYR' => 'Malaysia Ringgit',
        'MUR' => 'Mauritius Rupee',
        'MXN' => 'Mexico Peso',
        'MNT' => 'Mongolia Tughrik',
        'MZN' => 'Mozambique Metical',
        'NAD' => 'Namibia Dollar',
        'NPR' => 'Nepal Rupee',
        'ANG' => 'Netherlands Antilles Guilder',
        'NZD' => 'New Zealand Dollar',
        'NIO' => 'Nicaragua Cordoba',
        'NGN' => 'Nigeria Naira',
        'NOK' => 'Norway Krone',
        'OMR' => 'Oman Rial',
        'PKR' => 'Pakistan Rupee',
        'PAB' => 'Panama Balboa',
        'PYG' => 'Paraguay Guarani',
        'PEN' => 'Peru Nuevo Sol',
        'PHP' => 'Philippines Peso',
        'PLN' => 'Poland Zloty',
        'QAR' => 'Qatar Riyal',
        'RON' => 'Romania New Leu',
        'RUB' => 'Russia Ruble',
        'SHP' => 'Saint Helena Pound',
        'SAR' => 'Saudi Arabia Riyal',
        'RSD' => 'Serbia Dinar',
        'SCR' => 'Seychelles Rupee',
        'SGD' => 'Singapore Dollar',
        'SBD' => 'Solomon Islands Dollar',
        'SOS' => 'Somalia Shilling',
        'ZAR' => 'South Africa Rand',
        'LKR' => 'Sri Lanka Rupee',
        'SEK' => 'Sweden Krona',
        'CHF' => 'Switzerland Franc',
        'SRD' => 'Suriname Dollar',
        'SYP' => 'Syria Pound',
        'TWD' => 'Taiwan New Dollar',
        'THB' => 'Thailand Baht',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TRY' => 'Turkey Lira',
        'TRL' => 'Turkey Lira',
        'TVD' => 'Tuvalu Dollar',
        'UAH' => 'Ukraine Hryvna',
        'GBP' => 'United Kingdom Pound',
        'USD' => 'United States Dollar',
        'UYU' => 'Uruguay Peso',
        'UZS' => 'Uzbekistan Som',
        'VEF' => 'Venezuela Bolivar',
        'VND' => 'Viet Nam Dong',
        'YER' => 'Yemen Rial',
        'ZWD' => 'Zimbabwe Dollar'
    );
}

function get_user_ip_address() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

function get_user_server_information() {
    return $_SERVER;
}

function get_captcha_image() {
    $these = & get_instance();
    $these->load->helper('captcha');
    $vals = array(
        // 'word' => 'Random word',
        'img_path' => './assets/images/captcha/',
        'img_url' => base_url('assets/images/captcha/'),
        'font_path' => BASEPATH.'/fonts/rubik-gemstones.ttf',
        'img_width' => 150,
        'img_height' => 40,
        'expiration' => 7200,
        'word_length' => 5,
        'font_size' => 18,
        'img_id' => 'Imageid',
        'pool' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        'colors' => array(
            'background' => array(255, 255, 255),
            'border' => array(255, 255, 255),
            'text' => array(0, 0, 0),
            'grid' => array(255, 200, 200)
        )
    );
    $cap = create_captcha($vals);
    return [$cap['image'],$cap['word']];
}