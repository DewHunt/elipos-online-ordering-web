<?php
require_once(APPPATH.'libraries/stripe-php/init.php');

class Stripe
{
	public $stripe = [];
    public function __construct() {
        $stripe_details = get_stripe_settings();
        $publishable_key = '';
        $secret_key = '';
        if (!empty($stripe_details)) {
            $publishable_key = property_exists($stripe_details,'publishable_key') ? $stripe_details->publishable_key : '';
            $secret_key = property_exists($stripe_details,'secret_key') ? $stripe_details->secret_key : '';
        }

        $this->stripe = ["secret_key" => $secret_key,"publishable_key" => $publishable_key];
        \Stripe\Stripe::setApiKey($this->stripe['secret_key']);
    }

    public function create_payment_intent($amount) {
        $client_secret = '';
        $token = '';
    	$amount = round($amount,2) * 100;
        $paymentIntent = \Stripe\PaymentIntent::create(['amount' => $amount,'currency' => 'GBP',]);

        if ($paymentIntent) {
            $client_secret = $paymentIntent->client_secret;
            $token = $paymentIntent->id;
        }
        return [$this->stripe['publishable_key'],$client_secret,$token];
    }
    
    public function retrive_payment_intent($client_secret) {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($client_secret);
        return $paymentIntent;
    }

    public function update_payment_intent($client_secret) {
        $paymentIntent = \Stripe\PaymentIntent::update($client_secret,['metadata' => ['order_id' => '6735']]);
        return $paymentIntent;
    }

    public function cancel_payment_intent($client_secret) {
        $payment_intent = \Stripe\PaymentIntent::retrieve($client_secret);
        $payment_intent->cancel();        
        return $payment_intent;
    }
}