<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'third_party/stripe/init.php');
require_once(APPPATH.'third_party/stripe/lib/Stripe.php');

class StripePaymentGateway
{
    public $currency = 'GBP';

    public function __construct() {
        $stripe_details = get_stripe_settings();
        $publishable_key = '';
        $secret_key = '';
        if (!empty($stripe_details)) {
            $publishable_key = property_exists($stripe_details,'publishable_key') ? $stripe_details->publishable_key : '';
            $secret_key = property_exists($stripe_details,'secret_key') ? $stripe_details->secret_key : '';
        }

        $stripe = array("secret_key" => $secret_key,"publishable_key" => $publishable_key);
        \Stripe\Stripe::setApiKey($stripe['secret_key']);
    }


    public function charge($data = array()) {
        $card_details = array(
            'number' => $data['number'],
            'exp_month' => $data['exp_month'],
            'exp_year' => $data['exp_year'],
            'cvc' => $data['cvc'],
        );

        $message='';
        try {
            $charge = \Stripe\charge::create(array(
                'card'=>$card_details,
                'amount'=>$data['amount']*100,
                'currency'=>$this->currency,
            ));
            $message = $charge->status;
        } catch (Exception $ex) {
            $message = $ex->getMessage();
        }
        return $message;
    }

    public function chargeWithToken($data=array()){
        $message = '';
        try {
            $charge = null;
            if (!empty($data['email'])) {
                $customer = \Stripe\Customer::create(array(
                    'email' => $data['email'],
                    'source' => $data['token']
                ));
                $charge = \Stripe\charge::create(array(
                    'customer' => $customer->id,
                    'amount' => $data['amount']*100,
                    'currency' => $this->currency,
                    'description' => $data['description']
                ));
            } else {
                $charge = \Stripe\charge::create(array(
                    'source' => $data['token'],
                    'amount'=> $data['amount']*100,
                    'currency' => $this->currency,
                    'description' => $data['description']
                ));
            }

            $message = $charge->status;
        } catch(Exception $ex) {
            $message = $ex->getMessage();
        }
        return $message;
    }
}