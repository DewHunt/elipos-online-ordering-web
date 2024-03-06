<?php

function get_currency(){
    $CI =& get_instance();
    $currency = $CI->Settings_Model->get_by(array("name"=>'currency'),true);
    $details='';
    if (!empty($currency)) {
        $details = json_decode($currency->value);
    }
    return $details;
}

function get_placement(){
    return !empty(get_currency()) ? get_currency()->placement : '';
}

function get_currency_symbol(){
    return !empty(get_currency()) ? get_currency()->symbol : '';
}

function get_price_text($price) {
    $price = number_format($price,2);
    if (get_placement() == 'right') {
        return $price.get_currency_symbol();
    } else if(get_placement() == 'left') {
        return get_currency_symbol().$price;
    } else {
        return $price.get_currency_symbol();
    }
}