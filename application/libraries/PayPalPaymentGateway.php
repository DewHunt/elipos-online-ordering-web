<?php
require_once(APPPATH.'third_party/PayPal/init.php');

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;



class PayPalPaymentGateway
{

    public $currency='GBP';
    public $client_id='';
    public $client_secret='';
    public $environmentMode='live';


    public function __construct()
    {
        $this->config();

    }
    private function config(){
        $payPal_details=get_paypal_settings();
      
        $this->environmentMode=get_property_value('environment',$payPal_details);
        $this->currency=get_property_value('currency',$payPal_details);
        if($this->environmentMode=='live'){
            $this->client_id=get_property_value('production_client_id',$payPal_details);
            $this->client_secret=get_property_value('production_client_secret',$payPal_details);
        }else{
            $this->client_id=get_property_value('sandbox_client_id',$payPal_details);
            $this->client_secret=get_property_value('sandbox_client_secret',$payPal_details);
        }
      
    
      
  
    }



    public function get_paypal_link_for_sale($products=array(),$delivery_charge=0,$sub_total=0,$total=0,$discount=0){

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $all_items=array();
        foreach ($products as $product){

            $item1 = new Item();
            $item1->setName($product['name'])
                ->setCurrency($this->currency)
                ->setQuantity($product['quantity'])
                ->setPrice(round($product['price'],2));

            array_push($all_items,$item1);

        }

        if($discount>0){
            $item1 = new Item();
            $discount=round($discount,2);
            $item1->setName('Discount')
                ->setCurrency($this->currency)
                ->setQuantity(1)
                ->setPrice('-'.$discount);
            array_push($all_items,$item1);

        }

        $itemList = new ItemList();
        $itemList->setItems($all_items);




// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
        $details = new Details();
        $details->setShipping(round($delivery_charge,2))
            ->setSubtotal(round($sub_total,2));
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal(round($total,2))
            ->setDetails($details);





        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Order from '.get_company_name())
            ->setInvoiceNumber(uniqid());
        $baseUrl = base_url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl.'payment/paypal?success=true')
            ->setCancelUrl($baseUrl."order");

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        try{
            $payment->create($this->getApiContext());
        }catch(Exception $ex){

    

            return null;
        }
        return $payment->getApprovalLink();
    }

    public function getApiContext()
    {
        // #### SDK configuration
        // Register the sdk_config.ini file in current directory
        // as the configuration source.
        /*
        if(!defined("PP_CONFIG_PATH")) {
            define("PP_CONFIG_PATH", __DIR__);
        }
        */
        // ### Api context
        // Use an ApiContext object to authenticate
        // API calls. The clientId and clientSecret for the
        // OAuthTokenCredential class can be retrieved from
        // developer.paypal.com
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->client_id,
                $this->client_secret
            )
        );
        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration
        $apiContext->setConfig(
            array(
                'mode' =>$this->environmentMode,
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
            )
        );
        // Partner Attribution Id
        // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
        // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
        // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');
        return $apiContext;
    }

    public function execute_payment($paymentId,$payerId,$products=array(),$delivery_charge=0,$sub_total=0,$total=0){

        // Get the payment Object by passing paymentId
        // payment id was previously stored in session in
        // CreatePaymentUsingPayPal.php
        $payment_obj=new Payment();
        $payment = $payment_obj->get($paymentId, $this->getApiContext());
        // ### Payment Execute
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        // ### Optional Changes to Amount
        // If you wish to update the amount that you wish to charge the customer,
        // based on the shipping address or any other reason, you could
        // do that by passing the transaction object with just `amount` field in it.
        // Here is the example on how we changed the shipping to $1 more than before.

        $amount = new Amount();


        $item1 = new Item();
        $all_items=array();
        foreach ($products as $product){
            $item1 = new Item();
            $item1->setName($product['name'])
                ->setCurrency($this->currency)
                ->setQuantity($product['quantity'])
                ->setPrice($product['price']);

            array_push($all_items,$item1);

        }

        $itemList = new ItemList();
        $itemList->setItems($all_items);





        $details = new Details();
        $details->setShipping($delivery_charge)
            ->setSubtotal($sub_total);
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        // Add the above transaction object inside our Execution object.
        $execution->addTransaction($transaction);
        $result=null;
        try {

            $result = $payment->execute($execution, $this->getApiContext());

            try {
                $payment = Payment::get($paymentId, $this->getApiContext());

            } catch (Exception $ex) {



            }
        } catch (Exception $ex) {

        }





        return $result;


    }




    public function capture_payment($paymentId,$payerId,$products=array(),$delivery_charge=0,$sub_total=0,$total=0){


        // Get the payment Object by passing paymentId
        // payment id was previously stored in session in
        // CreatePaymentUsingPayPal.php
        $payment_obj=new Payment();

        $payment = $payment_obj->get($paymentId, $this->getApiContext());
        // ### Payment Execute
        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        // ### Optional Changes to Amount
        // If you wish to update the amount that you wish to charge the customer,
        // based on the shipping address or any other reason, you could
        // do that by passing the transaction object with just `amount` field in it.
        // Here is the example on how we changed the shipping to $1 more than before.

        $amount = new Amount();


        $item1 = new Item();
        $all_items=array();
        foreach ($products as $product){
            $item1 = new Item();
            $item1->setName($product['name'])
                ->setCurrency($this->currency)
                ->setQuantity($product['quantity'])
                ->setPrice($product['price']);

            array_push($all_items,$item1);

        }

        $itemList = new ItemList();
        $itemList->setItems($all_items);





        $details = new Details();
        $details->setShipping($delivery_charge)
            ->setSubtotal($sub_total);
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        // Add the above transaction object inside our Execution object.
        $execution->addTransaction($transaction);



        $transactions = $payment->getTransactions();
        $transaction = $transactions[0];
        $relatedResources = $transaction->getRelatedResources();

        $relatedResource = $relatedResources[0];
        $order = $relatedResource->getOrder();




        $capture = new Capture();
        $capture->setIsFinalCapture(true);
        $capture->setAmount($amount);
        $result=null;
        try {
            $result = $order->capture($capture, $this->getApiContext());

        } catch (Exception $ex) {

        }



        return $result;


    }

}