<?php


function get_settings() {
    $CI = & get_instance();
    $payment_settings = $CI->Settings_Model->get_by(array("name" =>'payment_settings'), true);
    if (!empty($payment_settings)) {
        $details = json_decode($payment_settings->value);
    } else {
        $details = '';
    }

    return $details;
}

function is_stripe_payment_on(){


}


function is_paypal_payment_on(){

}

function is_nochex_payment_on(){

}