<?php

function get_total_number_of_orders() {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $orders = $ci->Order_information_Model->db->where('order_status','accept');
    $orders = $ci->Order_information_Model->get();
    $total_number_of_orders = 0;
    if (!empty($orders)) {
        $total_number_of_orders = count($orders);
    }
    return ($total_number_of_orders != NULL) ? $total_number_of_orders : 0;
}

function get_total_number_of_orders_of_last_week() {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $start_date = $start_date . ' 00:00:00';
    $end_date = date('Y-m-d');
    $end_date = $end_date . ' 23:59:59';
    $total_orders_by_date = $ci->Order_information_Model->get_total_orders_by_date($start_date, $end_date);
    $total_number_of_orders_of_last_week = 0;
    if (!empty($total_orders_by_date)) {
        $total_number_of_orders_of_last_week = count($total_orders_by_date);
    }
    return ($total_number_of_orders_of_last_week != NULL) ? $total_number_of_orders_of_last_week : 0;
}

function get_total_number_of_orders_by_order_type($order_type) {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $orders = $ci->Order_information_Model->get_orders_by_order_type($order_type);
    $total_number_of_orders = 0;
    if (!empty($orders)) {
        $total_number_of_orders = count($orders);
    }
    return ($total_number_of_orders != NULL) ? $total_number_of_orders : 0;
}

function get_total_number_of_orders_of_last_week_by_order_type($order_type) {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $start_date = $start_date . ' 00:00:00';
    $end_date = date('Y-m-d');
    $end_date = $end_date . ' 23:59:59';
    $total_orders_by_date = $ci->Order_information_Model->get_total_orders_by_date_nad_order_type($order_type, $start_date, $end_date);
    $total_number_of_orders_of_last_week_by_order_type = 0;
    if (!empty($total_orders_by_date)) {
        $total_number_of_orders_of_last_week_by_order_type = count($total_orders_by_date);
    }
    return ($total_number_of_orders_of_last_week_by_order_type != NULL) ? $total_number_of_orders_of_last_week_by_order_type : 0;
}

function get_total_orders_amount_by_order_type($order_type) {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $orders = $ci->Order_information_Model->get_total_orders_amount_by_order_type($order_type);
    $total_amount = 0;
    if (!empty($orders)) {
        $total_amount = $orders->order_total_sum;
    }
    return ($total_amount != NULL) ? $total_amount : 0;
}

function get_total_orders_amount_of_last_week_by_order_type($order_type) {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $start_date = $start_date . ' 00:00:00';
    $end_date = date('Y-m-d');
    $end_date = $end_date . ' 23:59:59';
    $total_orders_by_date = $ci->Order_information_Model->get_total_orders_amount_of_last_week_by_order_type($order_type, $start_date, $end_date);
    $total_amount_of_last_week_by_order_type = 0;
    if (!empty($total_orders_by_date)) {
        $total_amount_of_last_week_by_order_type = $total_orders_by_date->order_total_sum;
    }
    return ($total_amount_of_last_week_by_order_type != NULL) ? $total_amount_of_last_week_by_order_type : 0;
}

function get_total_order_amount() {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $orders = $ci->Order_information_Model->get_total_orders_amount();
    $order_total_amount_sum = 0;
    if (!empty($orders)) {
        $order_total_amount_sum = ($orders->order_total_sum);
    }
    return ($order_total_amount_sum != NULL) ? $order_total_amount_sum : 0;
}

function get_total_order_amount_of_last_week() {
    $ci = &get_instance();
    $ci->load->model("Order_information_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $start_date = $start_date . ' 00:00:00';
    $end_date = date('Y-m-d');
    $end_date = $end_date . ' 23:59:59';
    $total_orders_by_date = $ci->Order_information_Model->get_total_orders_amount_by_date($start_date, $end_date);
    $order_total_amount_sum = 0;
    if (!empty($total_orders_by_date)) {
        $order_total_amount_sum = ($total_orders_by_date->order_total_sum);
    }
    return ($order_total_amount_sum != NULL) ? $order_total_amount_sum : 0;
}

function get_top_five_product() {
    $ci = &get_instance();
    $ci->load->model("Order_details_Model");
    $ci->load->model("Fooditem_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $end_date = date('Y-m-d');
    $limit = 5;
    $product_list = $ci->Order_details_Model->get_top_five_product($start_date, $end_date, $limit);
    return $product_list;
}

function get_total_amount() {
    $ci = &get_instance();
    $ci->load->model("Order_details_Model");
    $start_date = date("Y-m-d", strtotime("-1 week"));
    $end_date = date('Y-m-d');
    $sum_of_amount = $ci->Order_details_Model->get_amount_total_by_date($start_date, $end_date);
    $total_amount = 0;
    if (!empty($total_amount)) {
        $total_amount = ($sum_of_amount->sum_of_amount);
    }
    return ($total_amount != NULL) ? $total_amount : 0;
}
