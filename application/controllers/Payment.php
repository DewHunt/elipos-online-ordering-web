<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public $product;
    public function __construct()
    {
        parent:: __construct();
        $this->product = new Product();
        $this->load->model('Customer_Model');
        $this->load->library('cart');
        $this->load->helper('nochex');
        $this->load->helper('settings');
        $this->load->helper('order');
        $this->load->helper('product');
        $this->load->helper('shop');
        $this->load->model('Settings_Model');
        $this->load->model('Card_Order_Model');
        $this->load->library('PayPalPaymentGateway');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');

    }

    public function nochex()
    {

// nochex post here as calback url . Then success url
        $post_data=$this->input->post();
        if(!empty($post_data)){

            $response = http_callback_post($post_data);
            $m_card_order_model=new Card_Order_Model();
            $nochex_order_id=$post_data['order_id'];
            $card_order_details= $m_card_order_model->get_by(array('nochex_order_id'=>$nochex_order_id),true);
            $card_order_id=(!empty($card_order_details))?$card_order_details->id:0;
            $is_authorized=0;
            $order_information_save_result=false;
            if (strstr($response, "AUTHORISED")){
                $is_authorized=1;
                // order place
                $paid_amount= $post_data['amount'];
                $transaction_status= $post_data['status'];
                $transaction_id= $post_data['transaction_id'];
                $update_data=array(
                    'nochex_callback_details'=>json_encode($post_data),
                    'paid_amount'=>$paid_amount,
                    'transaction_status'=>$transaction_status,
                    'transaction_id'=>$transaction_id,
                    'is_authorized'=>$is_authorized,
                );



                if($card_order_id>0){
                    $m_order_info=new Order_information_Model();
                    $m_card_order_model->save($update_data,$card_order_id);
                    $m_order_info->card_order_insert($card_order_id);
                    $orderDetails=get_property_value('order_info',$card_order_details);
                    $orderInfo=(!empty($orderDetails))?json_decode($orderDetails,true):array();
                    $order_type=get_array_key_value('order_type',$orderInfo);
                    $customer_id=get_property_value('customer_id',$card_order_details);
                    $this->Voucher_Model->saveAndSendCouponVoucher($paid_amount,$order_type,$customer_id);


                }
            }

        }











    }



    public function paypal()
    {
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            $paymentId = isset($_GET['paymentId'])?$_GET['paymentId']:'';
            $payerID = isset($_GET['PayerID'])?$_GET['PayerID']:'';
            if(empty($paymentId) || empty($payerID)){
                redirect('menu');
            }else{
                $order_details= $this->session->userdata('paypal_order_details');

                if(!empty($order_details)){
                    $order_type=$order_details['order_type'];
                    $delivery_time=$order_details['delivery_time'];
                    $notes=$order_details['order_note'];
                    $delivery_charge=$order_details['delivery_charge'];
                    $is_pre_order=$order_details['is_pre_order'];

                    $lib_paypal=new PayPalPaymentGateway();
                    $cart_contents=$order_details['cart_content'];
                    $cart_total=$order_details['cart_total'];
                    $discount=$order_details['discount'];


                    $surcharge=get_array_key_value('surcharge',$order_details);
                    $surcharge=(!empty($surcharge))?$surcharge:0;

                    $products=array();
                    $total=$cart_total+$delivery_charge-$discount+$surcharge;

                    foreach ($cart_contents as $cart) {
                        $product = array(
                            'name' => $cart['name'],
                            'price' => $cart['price'],
                            'quantity' => $cart['qty'],

                        );
                        array_push($products,$product);
                    }

                    if($surcharge>0){
                        $surchargeData= array(
                            'name' => 'Card Fee',
                            'price' =>$surcharge,
                            'quantity' => 1,

                        );
                        array_push($products,$surchargeData);

                    }

                    $sub_total=round($cart_total-$discount+$surcharge,2);
                    $result= $lib_paypal->execute_payment($paymentId,$payerID,$products,$delivery_charge,$sub_total,$total);

                    if(!empty($result)){

                        if($result->getState()=='approved'){
                            // order completed
                            $this->session->unset_userdata('paypal_order_details');
                            $order_information_save_result=false;
                            $m_order_information=new Order_information_Model();
                            $order_information_save_result= $m_order_information->insert_cart_order($order_type, $delivery_time, 'paypal', $notes, $delivery_charge,$cart_contents,$is_pre_order,0,$discount);
                            if($order_information_save_result){
                                $customer_id = $this->session->userdata('customer_id');
                                if($customer_id>0){
                                    $this->Voucher_Model->saveAndSendCouponVoucher($total,$order_type,$customer_id);
                                }

                                $message='your order has been placed successfully';
                            }else{
                                $message='of our server error, Please try again';
                            }

                            $order_submitted_details=array(
                                'payment_method'=>ucfirst('Paypal'),
                                'order_type'=>ucfirst($order_type),
                                'is_order_placed'=>$order_information_save_result,
                                'message'=>$message,
                            );

                            set_submitted_order_details($order_submitted_details);

                            set_order_placed($order_information_save_result);

                        }else{
                            $order_submitted_details=array(
                                'payment_method'=>ucfirst('Paypal'),
                                'order_type'=>ucfirst($order_type),
                                'is_order_placed'=>false,
                                'message'=>' you paypal payment is not approved',
                            );
                            set_submitted_order_details($order_submitted_details);

                            set_order_placed(false);
                            // redirect('order/order_unsuccessful');
                        }
                        redirect('order/message');
                    }else{
                        // redirect menu

                        redirect('menu');
                    }
                }else{
                    redirect('menu');
                }

            }

        }else{
            // redirect menu

            redirect('menu');
        }





    }







}
