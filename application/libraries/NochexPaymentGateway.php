<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class NochexPaymentGateway
{

    public $currency='usd';
    public $merchant_id='eran@softsync.co.uk';
    public $order_id='';
    public $amount=0;
    public $success_url='';
    public $cancel_url='';
    public $declined_url='';
    public $callback_url='';


    public function __construct()
    {


    }




    public function post($order_data=array()){

        $url = 'https://secure.nochex.com';

        $data=array(
            "merchant_id"=>$this->merchant_id,
            "test_transaction"=>100,
            "order_id"=>$order_data['order_id'],
            "amount"=>$order_data['amount'],
            "description"=>get_company_name(),
            "callback_url"=>base_url('order/payment'),
        );
        $postvars = http_build_query($data);
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS,$postvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER,0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response =curl_exec( $ch );
        return $response;


    }





}