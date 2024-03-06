<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . 'libraries/REST_Controller.php';

class Set_order extends Api_Controller {
    public $is_order_in_process = false;
    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Settings_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('Allowed_miles_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Voucher_Model');
        $this->load->model('Sagepay_transaction_model');
        $this->load->library('product');
        $this->load->helper('settings');
        $this->load->helper('security');
        $this->load->helper('shop');
        $this->load->helper('order');
        $this->load->helper('product');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $customer = $this->Customer_Model->getCustomerByApiAuth($data);
            $categories_array = array();
            $is_order_save = false;
            if (!empty($customer)) {
                $order_type = trim($data->order_type);
                $delivery_postcode = trim($data->delivery_postcode);
                $delivery_time = property_exists($data, 'delivery_time') ? $data->delivery_time : '0';
                if (empty($delivery_time) || $delivery_time == 0) {
                    $delivery_time = '0000-00-00 00:00:00';
                }

                $platform = $data->platform;
                $delivery_charge = $data->delivery_charge;
                $delivery_address_line_1 = $data->delivery_address_line_1;
                $mobile = $data->mobile;
                $payment_method = $data->payment_method;
                $cart_data = $data->cart_data;
                $cart_total = $data->cart_total;
                $is_pre_order = $data->is_pre_order;
                $surcharge = $data->surcharge;
                $discount = $data->discount;
                $order_note = xss_clean(trim($data->notes));

                $coupon_id = $data->couponId;
                $coupon_code = $data->couponCode;
                $coupon_discount = $data->couponDiscount;
                $total_buy_get_amount = $data->totalBuyGetAmount;
                $service_charge = $data->serviceCharge;
                $packaging_charge = $data->packagingCharge;
                $transaction_id = $data->transactionId;
                $table_number = $data->tableNumber;
                $tips_amount = $data->tipsAmount;
                $customer_id = $customer->id;
                $this->Customer_Model->save(array('delivery_address_line_1' => $delivery_address_line_1, 'mobile' => $mobile, 'delivery_postcode' => $delivery_postcode), $customer_id);

                if (!empty($cart_data)) {
                    // possess order if delivery post code is valid
                    // process order
                    if ($order_type == 'collection') {
                        $delivery_charge = 0;
                    }

                    if ($coupon_discount > $discount) {
                        $discount = $coupon_discount;
                        $this->Voucher_Model->updateCouponRemainingUsagesByCode($coupon_code);
                    }
                    
                    $save_data = array(
                        'platform' => $platform,
                        'order_type' => $order_type,
                        'delivery_time' => $delivery_time,
                        'notes' => $order_note,
                        'delivery_charge' => $delivery_charge,
                        'cart_data' => $cart_data,
                        'cart_total' => $cart_total,
                        'customer' => $customer,
                        'is_pre_order' => $is_pre_order,
                        'surcharge' => $surcharge,
                        'payment_method' => $payment_method,
                        'discount' => $discount,
                        'coupon_id' => $coupon_id,
                        'coupon_code' => $coupon_code,
                        'coupon_discount' => $coupon_discount,
                        'total_buy_get_amount' => $total_buy_get_amount,
                        'service_charge' => $service_charge,
                        'packaging_charge' => $packaging_charge,
                        'transaction_id' => $transaction_id,
                        'table_number' => $table_number,
                        'tips_amount' => $tips_amount,
                    );

                    $is_order_save = $this->Order_information_Model->api_order_insert($save_data);

                    $this->data['orderType'] = $order_type;
                    if ($is_order_save) {
                        if ($payment_method == 'sagepay') {
                            $this->db->delete('sagepay_transaction',array('customer_id'=>$customer_id));
                        } else if ($payment_method == 'cardstream') {
                            $this->db->delete('cardstream_transaction',array('customer_id'=>$customer_id));
                        }
                        $message = $this->load->view('api/template/order_success', $this->data, true);
                    } else {
                        $message = $this->load->view('api/template/order_error', $this->data, true);
                    }
                    $response_data = array('status' => 200,'message' => $message,'is_order_success' => $is_order_save,'data' => $cart_total,);
                    $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                } else {
                    $response_data = array('status' => 200,'message' => 'Order can not process because cart is empty','is_order_success' => $is_order_save,);
                    $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                }
            } else {
                $response_data = array('status' => 200,'message' => 'Order can not process because user is not granted ','is_order_success' => $is_order_save,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_delivery_charge() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $delivery_charge = 0;
            $is_post_code_valid = false;
            $message = '';
            $minimum_delivery_order = 0;
            $post_code = '';
            if (!empty($data)) {
                $post_code = property_exists($data, 'delivery_postcode') ? trim($data->delivery_postcode) : '';
                $allowed_miles = $this->Allowed_miles_Model->getDistanceDeliveryCharge($post_code);
                if (!empty($allowed_miles)) {
                    $delivery_charge = $allowed_miles->delivery_charge;
                    $minimum_delivery_order = $allowed_miles->min_order_for_delivery;
                    $is_post_code_valid = true;
                } else {
                    $delivery_post_code = $this->Allowed_postcodes_Model->get_delivery_charge_by_postcode($post_code);
                    if (!empty($delivery_post_code)) {
                        $is_post_code_valid = true;
                        if (!empty($delivery_post_code)) {
                            $delivery_charge = $delivery_post_code->delivery_charge;
                            $minimum_delivery_order = $delivery_post_code->min_order_for_delivery;
                        }
                    }
                }
            }

            if (!$is_post_code_valid) {
                $message = $this->Allowed_miles_Model->get_miles_error_message();
            }

            $response_data = array(
                'status' => 200,
                'message' => $message,
                'delivery_charge' => $delivery_charge,
                'delivery_postcode' => $post_code,
                'minimum_delivery_order' => $minimum_delivery_order,
                'is_valid_postcode' => $is_post_code_valid,
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_discount_details() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);

            $customer_id = get_property_value('customer_id', $data);
            $customer = $this->Customer_Model->get_by(array('id' => $customer_id), true);
            $message = 'Discount data is provided';
            $discount_details = get_discount_data();
            $loyalty_program_details = get_loyalty_program_data();

            $is_discount_available = false;
            $is_customer_first_order = $this->Order_information_Model->is_customer_first_order($customer_id);
            $discount_details['is_customer_first_order'] = $is_customer_first_order;
            $discount_details['discount_message'] = 'Congratulations! You have got totalDiscount from totalAmount';
            $customer_total_order = 0;
            if (!empty($customer_id)) {
                $customer_total_order = get_total_order($customer_id);
            }
            $loyalty_program_details['customer_total_order'] = $customer_total_order;
            $loyalty_program_details['discount_message'] = 'Congratulations! You have got totalDiscount discounts from totalAmount';

            $response_data = array(
                'status' => 200,
                'message' => $message,
                'is_customer_first_order' => $is_customer_first_order,
                'discount_details' => $discount_details,
                'loyalty_program_details' => $loyalty_program_details,
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    /*New discount form June 2017*/
    public function getDiscountAmount() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $discountAmount = 0;
            $discountMessage = '';
            $discount_details = get_discount_data();
            $response_data = array(
                'status' => 200,
                'discountAmount' => $discountAmount,
                'discountMessage' => $discountMessage,
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function reorder() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $orderId = property_exists($data, 'orderId') ? $data->orderId : 0;
            $customer = $this->Customer_Model->getCustomerByApiAuth($data);
            if (!empty($customer)) {
                $customerId = $customer->id;
                $order_information = $this->Order_information_Model->get_by(array('id' => $orderId,'customer_id' => $customerId), true);
                if (!empty($order_information)) {
                    $order_details = $this->Order_details_Model->getDetails(array('order_id' => $order_information->id,'order_deals_id' => 0,));
                    $count = 0;
                    $cartDataArray = array();
                    if (!empty($order_details)) {
                        foreach ($order_details as $detail) {
                            $side_dish = $this->Order_side_dish_Model->get_where('order_details_id', $detail->id);
                            $side_dish_description = '';
                            $side_dish_total_price = 0;
                            $side_dish_id_array = array();
                            foreach ($side_dish as $dish) {
                                $side_dish = $this->product->get_side_dish_by_id(trim($dish->side_dish_id));
                                if (!empty($side_dish)) {
                                    $side_dish_total_price += $side_dish->UnitPrice;
                                    array_push($side_dish_id_array, $side_dish->SideDishesId);
                                    $side_dish_description = $side_dish->SideDishesName . ' + ' . $side_dish_description;
                                }
                            }
                            if (!empty($side_dish)) {
                                $side_dish_description = substr($side_dish_description, 0, -3);
                                $side_dish_description = '( ' . $side_dish_description . ' )';
                            }
                            $price = $detail->unit_price;
                            $vat_rate = $detail->vat_total;
                            $name = $detail->product_name;
                            $product_id = $detail->product_id;
                            $sub_product_id = $detail->selection_item_id;

                            $id = '';
                            if ($sub_product_id > 0) {
                                $id = 'subproduct_' . $sub_product_id . $side_dish_description . $detail->item_comments;
                            } else {
                                $id = 'product_' . $product_id . $side_dish_description . $detail->item_comments;
                            }


                            $options = $this->Order_side_dish_Model->getSideDishOptions($detail->id);
                            $lib_product = new Product();

                            $product = $lib_product->get_product($product_id);

                            $itemData = array(
                                'product_id' => $product_id,
                                'sub_product_id' => $sub_product_id,
                                'name' => $name,
                                'price' => $price,
                                'optionsString' => $side_dish_description,
                                'comment' => $detail->item_comments,
                            );
                             if (!empty($product) && $price>0) {
                                $data = array(
                                    'id' => $id,
                                    'isDeals' => false,
                                    'item' => $itemData,
                                    'orderType' => $product->order_type,
                                    'quantity' => $detail->quantity,
                                    'options' => $options
                                );
                                if ($detail->order_deals_id == 0) {
                                    array_push($cartDataArray, $data);
                                }
                            }
                        }

                        $response_data = array(
                            'status' => 200,
                            'message' => 'Order details is given',
                            'data' => $cartDataArray,
                        );
                        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                    } else {
                        $response_data = array(
                            'status' => 200,
                            'message' => 'Order details is not found',
                            'data' => null,
                        );
                        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                    }
                } else {
                    $response_data = array('status' => 200,'message' => 'No Such order is found','data' => null,);
                    $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                }
            } else {
                $response_data = array('status' => 200,'message' => 'Authentication problem','data' => null,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function checkCartValidity() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $cart_details = $data->cart_data;
            $unAvailableProducts = array();
            $isCartIsValid = true;
            $indexNumber = 0;
            $product = null;
            foreach ($cart_details as $cart) {
                $isDeals = property_exists($cart, 'isDeals') ? $cart->isDeals : false;
                $id = property_exists($cart, 'id') ? $cart->id : 0;
                if ($isDeals) {
                } else {
                    $product_id = $cart->item->product_id;
                    $this->db->select('foodItemId');
                    $this->db->from('fooditem');
                    $this->db->where(array('foodItemId' => intval($product_id)));
                    $product = $this->db->get()->row();
                    if (empty($product)) {
                        $isCartIsValid = false;
                        array_push($unAvailableProducts, array('itemId' => $id,'productName' => $cart->item->name));
                    }
                }
                $indexNumber++;
            }

            $totalDiscount = 0;
            $discountMessage = '';
            $response_data = array(
                'isCartIsValid' => $isCartIsValid,
                'title' => '',
                'message' => 'Red highlighted item is not available at this moment.If you want to order without these item then remove them',
                'unAvailableProducts' => $unAvailableProducts
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}