<?php
function get_minimum_order_amount(){
    $CI = &get_instance();
    $minimum_order_amount = $CI->session->userdata('minimum_order_amount');
    return !empty($minimum_order_amount) ? $minimum_order_amount : 0;
}

function set_order_placed($is_placed=false){
    $CI = &get_instance();
    $CI->session->set_userdata('is_order_placed',$is_placed);
}

function is_order_placed(){
    $CI = &get_instance();
    $is_order_placed = $CI->session->userdata('is_order_placed');
    return (!empty($is_order_placed)) ? $is_order_placed : false;
}

function unset_order_placed(){
    $CI = &get_instance();
    $CI->session->unset_userdata('is_order_placed');
}

function unset_stripe_placed(){
    $CI = &get_instance();
    $CI->session->unset_userdata('stripe_token');
}

function set_order_submitted(){
    $CI = &get_instance();
    $CI->session->set_userdata('is_order_submitted',true);
}

function is_order_submitted(){
    $CI = &get_instance();
    $is_order_submitted = $CI->session->userdata('is_order_submitted');
    return (!empty($is_order_submitted)) ? $is_order_submitted : false;
}

function unset_order_submitted(){
    $CI = &get_instance();
    $CI->session->unset_userdata('is_order_submitted');
}

function set_submitted_order_details($details=array()){
    $CI = &get_instance();
    $CI->session->set_userdata('submitted_order_details',$details);
}

function get_submitted_order_details(){
    $CI = &get_instance();
    return $CI->session->userdata('submitted_order_details');
}

function unset_submitted_order_details(){
    $CI = &get_instance();
    $CI->session->unset_userdata('submitted_order_details');
}

function get_sess_order_type(){
    $CI = &get_instance();
    return $CI->session->userdata('order_type_session');
}

function set_sess_order_type($orderType=''){
    $CI = &get_instance();
    $CI->session->set_userdata('order_type_session',$orderType);
}

function get_discount_data(){
    $CI = &get_instance();
    $discount = $CI->Settings_Model->get_by(array('name'=>'discount'),true);
    $discount_value = (!empty($discount)) ? $discount->value : null;
    $discount_data = (!empty($discount_value)) ? json_decode($discount_value,true) : array();
    // echo "<pre>"; print_r($discount_data); exit();
    return $discount_data;
}

function get_service_charge_data() {
    $CI = &get_instance();
    $service_charge_info = $CI->Settings_Model->get_by(array('name'=>'service_charge'),true);
    $service_charge_value = (!empty($service_charge_info)) ? $service_charge_info->value : null;
    $service_charge_data = (!empty($service_charge_value)) ? json_decode($service_charge_value,true) : array();
    return $service_charge_data;
}

function get_packaging_charge_data() {
    $CI = &get_instance();
    $packaging_charge_info = $CI->Settings_Model->get_by(array('name'=>'packaging_charge'),true);
    $packaging_charge_value = (!empty($packaging_charge_info)) ? $packaging_charge_info->value : null;
    $packaging_charge_data = (!empty($packaging_charge_value)) ? json_decode($packaging_charge_value,true) : array();
    return $packaging_charge_data;
}

function get_total_order($customer_id) {
    $CI = &get_instance();
    $result = $CI->db->query("SELECT COUNT(customer_id) AS totalOrder FROM order_information WHERE customer_id = $customer_id")->row();
    return $result->totalOrder;
}

function isHasFreeProductInCart() {
    $CI = &get_instance();
    $count = 0;
    if ($CI->cart->contents()) {
        foreach ($CI->cart->contents() as $cartProduct) {
            if ($cartProduct['product_id'] == 0) {
                $count++;
            }
        }
    }
    return $count;
}

function get_total_from_cart($index_name = '') {
    $ci = &get_instance();
    $cart_contents = $ci->cart->contents();
    $total = 0;
    if ($cart_contents) {
        foreach ($cart_contents as $item) {
            if (isset($item[$index_name])) {
                $total += $item[$index_name];
            }
        }
    }
    return $total;
}

function is_buy_get_valid($category_id = 0,$item_id = 0) {
    $CI = &get_instance();
    $current_date = date('Y-m-d');
    $current_date_name = strtolower(date('l'));
    $order_type = $CI->session->userdata('order_type_session');
    if (empty($order_type)) {
        $order_type = 'collection';
    }
    $where_condition = "";

    if ($category_id > 0) {
        $where_condition .= "AND FIND_IN_SET($category_id,`category_id`)";
    }

    if ($item_id > 0) {
        $where_condition .= " AND FIND_IN_SET($item_id,`item_id`)";
    }

    $result = $CI->db->query("
        SELECT * FROM `buy_and_get` WHERE '$current_date' BETWEEN `start_date` AND `end_date` AND FIND_IN_SET('$current_date_name',`availability`) AND FIND_IN_SET('$order_type',`order_type`) $where_condition AND status = 1
    ")->row();
    // echo "<pre>"; print_r($CI->db->last_query()); exit();
    return $result;
}

function get_loyalty_program_data(){
    $CI = &get_instance();
    $loyalty_program = $CI->Settings_Model->get_by(array('name'=>'loyalty_programs'),true);
    $loyalty_program_value = (!empty($loyalty_program)) ? $loyalty_program->value : null;
    $loyalty_program_data = (!empty($loyalty_program_value)) ? json_decode($loyalty_program_value,true) : array();
    // dd($discount_data);
    return $loyalty_program_data;
}

function isFoodOrderTypeMatchWithCustomer($order_type='both'){
    $CI = &get_instance();
    $customer_order_type = $CI->session->userdata('order_type_session');
    return ($order_type == $customer_order_type);
}

function isCartValidWithOrderType($orderType = 'both',$cartsData = array()) {
    if(!empty($cartsData)){
        return true;
        foreach ($cartsData as $item){
            $itemOrderType = array_key_exists('order_type',$item) ? $item['order_type'] : 'both';
            if ((!empty($itemOrderType) && $itemOrderType != 'both') && ($itemOrderType != $orderType)){
                return false;
            }
        }
    } else {
        return true;
    }
}

function isItemAddAbleToCart($itemOrderType = 'both'){
    if(!empty($itemOrderType) && ($itemOrderType != 'both')){
        return true;
        $orderType = get_sess_order_type();
        return ($orderType == $itemOrderType);
    } else {
        return true;
    }
}

function is_order_processable($data = array()) {
    $these = &get_instance();
    // dd($data);
    if ($these->Customer_Model->customer_is_loggedIn() == true) {
        if (is_shop_closed() && !is_pre_order() && is_shop_maintenance_mode() || is_shop_weekend_off()) {
            return false;
        }

        $terms_conditions = trim($these->input->post('terms_conditions'));
        if (array_key_exists('terms_conditions', $data)) {
            $terms_conditions = trim($data['terms_conditions']);
        }
        
        if (empty($terms_conditions)) {
            set_flash_message('You must agree to our Terms and Conditions');
            return false;
        }

        $delivery_time = trim($these->input->post('delivery_time'));
        if (array_key_exists('delivery_time',$data)) {
            $delivery_time = trim($data['delivery_time']);
        }       

        if (empty($delivery_time)) {
            set_flash_message('Please Select Delivery/Collection Time');
            return false;
        }

        $order_type = $these->session->userdata('order_type_session');
        if (empty($order_type)) {
            set_flash_message('Please Select Order Type');
            redirect('order');
        }

        $isValidOrderType = isCartValidWithOrderType(trim($order_type), $these->cart->contents());
        if (!$isValidOrderType) {
            $cartHasItemOf = ($order_type == 'collection') ? 'Delivery' : 'Collection';
            $cartOrderTypeChangeMessage = 'Your cart has only for ' . $cartHasItemOf . ' Item';
            set_flash_message($cartOrderTypeChangeMessage);
            return false;
        }

        $cart_content = $these->cart->contents();
        $cart_total = $these->cart->total();
        $total_buy_get_amount = get_total_from_cart('buy_get_amount');
        $cart_sub_total = $cart_total - $total_buy_get_amount;

        $shop_details = get_company_details();
        $minimum_order_amount = get_property_value('minimum_order_amount', $shop_details);

        if ($cart_total <= 0) {
            set_flash_message('Please add some item in the cart');
            return false;
        }

        if (array_key_exists('delivery_postcode', $data)) {
            $delivery_postcode = trim($data['delivery_postcode']);
        } else {
            $delivery_postcode = trim($these->input->post('delivery_postcode'));
        }
        
        if (array_key_exists('delivery_address_line_1', $data)) {
            $delivery_address_line_1 = trim($data['delivery_address_line_1']);
        } else {
            $delivery_address_line_1 = trim($these->input->post('delivery_address_line_1'));
        }        

        if (!empty($order_type) && $order_type == 'delivery') {
            if (empty($delivery_address_line_1)) {
                set_flash_message('Delivery address is missing ');
                return false;
            }

            if (empty($delivery_postcode)) {
                set_flash_message('Delivery postcode is missing');
                return false;
            }

            $m_allowed_miles = new Allowed_miles_Model();
            $allowed_miles = $m_allowed_miles->getDistanceDeliveryCharge($delivery_postcode);
            $delivery_charge = $these->session->userdata('delivery_charge');
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
                return false;
            }

            if ($cart_total < $minimum_order_amount) {
                set_flash_message('Minimum order amount for delivery is ' . get_price_text($minimum_order_amount));
                return false;
            }
        } else {
            if ($cart_total < $minimum_order_amount) {
                set_flash_message('Minimum order amount for collection is ' . get_price_text($minimum_order_amount));
                return false;
            }
        }
        return true;
    }
    return false;
}

function get_order_total_amount($payment_method = 'cash') {
    $these = &get_instance();
    $order_type = $these->session->userdata('order_type_session');
    $delivery_charge = 0;

    $cart_content = $these->cart->contents();
    $cart_total = $these->cart->total();
    $total_buy_get_amount = get_total_from_cart('buy_get_amount');
    $cart_sub_total = $cart_total - $total_buy_get_amount;

    $shop_details = get_company_details();
    $minimum_order_amount = get_property_value('minimum_order_amount', $shop_details);
            
    if (!empty($order_type) && $order_type == 'delivery') {
        $delivery_postcode = $these->session->userdata('delivery_post_code');

        $m_allowed_miles = new Allowed_miles_Model();
        $allowed_miles = $m_allowed_miles->getDistanceDeliveryCharge($delivery_postcode);
        $delivery_charge = $these->session->userdata('delivery_charge');
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
            return 0;
        }

        if ($cart_sub_total < $minimum_order_amount) {
            return 0;
        }
    } else {
        if ($cart_sub_total < $minimum_order_amount) {
            return 0;
        }
    }

    if (isset($min_amount_for_free_delivery_charge) && !empty($min_amount_for_free_delivery_charge) && $min_amount_for_free_delivery_charge > 0 && $min_amount_for_free_delivery_charge < $cart_sub_total) {
        $delivery_charge = 0;
    }

    $coupon_code = $these->session->userdata('coupon_code');
    $payment_settings = get_payment_settings();
    $service_charge = 0;
    $packaging_charge = 0;
    $couponDiscount = 0;
    $tips_amount = 0;
    $surcharge = 0;
    $discount = 0;

    $customer_id = $these->Customer_Model->get_logged_in_customer_id();

    if ($cart_content) {
        $discount = $these->Customer_Model->get_discount_amount($cart_content,$order_type,$customer_id);
    }

    if (!empty($coupon_code)) {
        $couponDiscount = $these->Voucher_Model->getDiscountAmountFromValidCoupon($coupon_code,$order_type,$cart_total);
    }

    if ($couponDiscount > $discount) {
        $discount = $couponDiscount;
    }

    if ($payment_method != 'cash') {
        $surcharge = (int) get_property_value('surcharge', $payment_settings);
    }

    if (!empty($these->session->userdata('tips_amount'))) {
        $tips_amount = $these->session->userdata('tips_amount');
    }

    $service_charge = $these->Customer_Model->get_service_charge($order_type,$payment_method);
    $packaging_charge = $these->Customer_Model->get_packaging_charge($order_type);
    $total_buy_get_amount = get_total_from_cart('buy_get_amount');

    $total = ($cart_total + $delivery_charge + $service_charge + $packaging_charge + $tips_amount + $surcharge) - ($discount + $total_buy_get_amount);

    return $total;
}