<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_information_Model extends Ex_Model
{
   protected $table_name = 'order_information';
   protected $primary_key = 'id';
   public $where_column = 'id';

   public function __construct() {
      parent::__construct();
   }

   public $order_submit_rules = array(
      'first_name' => array(
         'field' => 'first_name',
         'label' => 'First Name',
         'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9\s.]+$/]',
         'errors' => array('required' => 'Please select your %s',),
      ),
      'last_name' => array(
         'field' => 'last_name',
         'label' => 'Last Name',
         'rules' => 'trim|regex_match[/^[a-zA-Z0-9\s.]+$/]',
         'errors' => array(
            'required' => 'You must provide a valid %s.',
            'regex_match' => '%s contains letters, numbers and space only'
         ),
      ),
      'email' => array(
         'field' => 'email',
         'label' => 'Email',
         'rules' => 'trim|required|valid_email',
         'errors' => array('required' => 'You must provide a valid %s.',),
      ),
      'mobile' => array(
         'field' => 'mobile',
         'label' => 'Mobile',
         'rules' => 'trim|required|max_length[11]|min_length[11]|regex_match[/^[0-9]+$/]',
         'errors' => array(
            'required' => 'You must provide a valid %s.',
            'min_length' => '%s must be at least 11 digit long',
            'max_length' => '%s must be 11 digit long',
            'regex_match' => '%s contains numbers only'
         ),
      ),
      'delivery_postcode' => array(
         'field' => 'delivery_postcode',
         'label' => 'Post Code(Delivery)',
         'rules' => 'trim|regex_match[/^[a-zA-Z0-9\s]+$/]',
         'errors' => array(
            'required' => 'You must provide a valid %s.',
            'regex_match' => '%s contains letters, numbers and space only'
         ),
      ),
      'delivery_address_line_1' => array(
         'field' => 'delivery_address_line_1',
         'label' => 'Delivery Details',
         'rules' => 'trim|regex_match[/^[a-zA-Z0-9\s.]+$/]',
         'errors' => array(
            'required' => 'You must provide a valid %s.',
            'regex_match' => '%s contains letters, numbers and space only'
         ),
      ),
      'notes' => array(
         'field' => 'notes',
         'label' => 'Comments',
         'rules' => 'trim|regex_match[/^[a-zA-Z0-9\s]+$/]',
         'errors' => array(
            'required' => 'You must provide a valid %s.',
            'regex_match' => '%s contains letters, numbers and space only'
         ),
      ),
      'terms_conditions' => array(
         'field' => 'terms_conditions',
         'label' => 'Terms And Conditions',
         'rules' => 'trim|required',
         'errors' => array('required' => 'You must agree to our %s.',),
      )
   );

   public $card_verification_rules = array(
      'credit_card_number' => array(
         'field' => 'credit_card_number',
         'label' => 'Credit Card Number',
         'rules' => 'trim|required',
         'errors' => array('required' => 'You must provide a valid %s.',),
      ),
      'exp_month' => array(
         'field' => 'exp_month',
         'label' => 'Card Expired Month',
         'rules' => 'trim|required',
         'errors' => array('required' => 'Select a %s.',)
      ),
      'exp_year' => array(
         'field' => 'exp_year',
         'label' => 'Card Expired Year',
         'rules' => 'trim|required',
         'errors' => array('required' => 'Select a %s.',)
      ),
      'cvc_code' => array(
         'field' => 'cvc_code',
         'label' => 'CVV ',
         'rules' => 'trim|required',
         'errors' => array('required' => 'Provide  %s.',)
      ),
   );

   public $customer_details = array(
      'email' => array(
         'field' => 'email',
         'label' => 'Email',
         'rules' => 'trim|required',
         'errors' => array('required' => 'You must provide a valid %s.',),
      ),
      'first_name' => array(
         'field' => 'first_name',
         'label' => 'First Name',
         'rules' => 'trim|required',
         'errors' => array('required' => 'You must provide  %s.',)
      ),
      'mobile' => array(
         'field' => 'mobile',
         'label' => 'Mobile Number',
         'rules' => 'trim|required',
         'errors' => array('required' => 'You must provide  %s.',)
      ),

      // 'cvc_code' => array(
      //    'field' => 'cvc_code',
      //    'label' => 'CVV ',
      //    'rules' => 'trim|required',
      //    'errors' => array('required' => 'Provide  %s.',)
      // ),
   );

   public function get_orders_info_by_date_and_order_status($order_status = '',$order_time = '',$start_date = '',$end_date = '') {
      $condition = '';

      if ($order_status == 'all') {
         $condition = "WHERE DATE_FORMAT(`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      } else {
         if ($order_status) {
            $condition .= "WHERE `order_status` = '$order_status'";
         }

         if ($order_time) {
            if ($condition == '') {
               $condition .= "WHERE ";
            } else {
               $condition .= " AND ";
            }
            $condition .= "`order_time` > '$order_time'";
         }
      }

      $results = $this->db->query("
         SELECT `id`,`customer_id`,`order_time`,`order_status`,`order_type`,`order_comments`,`assign_driver`,`show_notification`,`delivery_time`,`delivery_charge`,`notes`,`traking_number`,`payment_method`,`cash_amount`,`card_amount`,`discount`,`service_charge`,`packaging_charge`,`tips`,`order_total`,`is_pre_order`,`surcharge`,`is_refunded`
         FROM `order_information`
         $condition
         ORDER BY `order_time` DESC
      ")->result();
      // dd($this->db->last_query());
      return $results;
   }

   public function get_top_customer_info($limit = 5,$start_date = null,$end_date = null) {
      $where_query = "";
      if ($start_date && $end_date) {
         $where_query .= "WHERE DATE_FORMAT(`order_information`.`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      }
      // WHERE `order_information`.`order_status` = 'pending' $where_query
      $result = $this->db->query("
         SELECT `customer`.`first_name`,`customer`.`last_name`,`customer`.`email`,`customer`.`telephone`,`customer`.`mobile`,`customer`.`delivery_postcode`, ROUND(SUM(`order_information`.`order_total`),2) as `total_amount`
         FROM `order_information`
         LEFT JOIN `customer` ON `customer`.`id` = `order_information`.`customer_id`
         $where_query
         GROUP BY `order_information`.`customer_id`
         ORDER BY `total_amount` DESC
         LIMIT $limit
      ")->result();
      // dd($this->db->last_query());
      return $result;
   }

   public function get_customer_grand_total($customer_id = 0) {
      $grand_total = 0;
      if ($customer_id) {
         $result = $this->db->query("SELECT SUM(`order_total`) as `grand_total` FROM `order_information` WHERE `customer_id`=$customer_id")->row();
         if ($result) {
            $grand_total = $result->grand_total;
         }
      }
      return $grand_total;
   }

   public function get_order_info_by_id($id = 0) {
      $result = $this->db->query("SELECT * FROM order_information WHERE id = $id")->row();
      return $result;
   }

   public function get_total_orders_by_date($start_date, $end_date) {
      $query = $this->db->query("SELECT * FROM order_information WHERE order_time >= '$start_date' AND order_time <= '$end_date' AND order_status='accept'");
      return $query->result();
   }

   public function get_total_orders_by_date_nad_order_type($order_type, $start_date, $end_date) {
      $query = $this->db->query("SELECT * FROM order_information WHERE order_type = '$order_type' AND order_time >= '$start_date' AND order_time <= '$end_date' AND order_status='accept'");
      return $query->result();
   }

   public function get_orders_by_order_type($order_type) {
      $query = $this->db->get_where($this->table_name, array('order_type' => $order_type,'order_status'=>'accept'));
      return $query->result();
   }

   public function get_total_orders_amount_by_order_type($order_type) {
      $query = $this->db->query("SELECT SUM(order_total) AS order_total_sum FROM order_information WHERE order_type = '$order_type' AND order_status='accept'");
      return $query->row();
   }

   public function get_total_orders_amount_of_last_week_by_order_type($order_type, $start_date, $end_date) {
      $query = $this->db->query("SELECT SUM(order_total) AS order_total_sum FROM order_information WHERE order_type = '$order_type' AND order_time >= '$start_date' AND order_time <= '$end_date' AND order_status='accept'");
      return $query->row();
   }

   public function get_total_orders_amount() {
      $query = $this->db->query("SELECT SUM(order_total) AS order_total_sum FROM order_information WHERE order_status='accept'");
      return $query->row();
   }

   public function get_total_orders_amount_by_date($start_date, $end_date) {
      $query = $this->db->query("SELECT SUM(order_total) AS order_total_sum FROM order_information WHERE order_time >= '$start_date' AND order_time <= '$end_date' AND order_status='accept'");
      return $query->row();
   }

   public function get_latest_orders($limit = 5,$start_date = null,$end_date = null) {
      $where_query = "";
      if ($start_date && $end_date) {
         $where_query .= "AND DATE_FORMAT(`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      }

      $result = $this->db->query("
         SELECT *
         FROM `order_information`
         WHERE `order_status` = 'accept' $where_query
         ORDER BY `order_time` DESC
         LIMIT $limit
      ")->result();
      return $result;

      // $this->db->where('order_status','accept');
      // $this->db->order_by('order_time','DESC');
      // $this->limit = $limit;
      // return $this->get();
   }

   public function get_top_customer_by_order_totals($limit = 5,$start_date = null,$end_date = null) {
      $where_query = "";
      if ($start_date && $end_date) {
         $where_query .= "AND DATE_FORMAT(`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      }
      $result = $this->db->query("
         SELECT *, SUM(`order_total`) as `total_amount`
         FROM `order_information`
         WHERE `order_status` = 'pending' $where_query
         GROUP BY `customer_id`
         ORDER BY `total_amount` DESC
         LIMIT $limit
      ")->result();
      // dd($this->db->last_query());
      return $result;
   }

   public function get_total_order_amount($start_date = null,$end_date = null) {
      $where_query = "";
      if ($start_date && $end_date) {
         $where_query .= "AND DATE_FORMAT(`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      }

      $result = $this->db->query("
         SELECT sum(`order_total`) as `total_amount`
         FROM `order_information`
         WHERE `order_status` = 'accept' $where_query
      ")->row();
      return $result;
   }

   public function get_last_30_days_orders() {
      $today = date("Y-m-d");
      $to = $today.' 23:59:59';
      $from = date('Y-m-d', strtotime('-30 days')).' 00:00:00';
      $results = $this->db->query("
         SELECT DATE(order_time) AS order_date , SUM(order_total) AS total_amount
         FROM `order_information`
         WHERE order_status = 'accept' AND order_time >= '$from' AND order_time <= '$to'
         GROUP BY order_date
      ")->result();
      return $results;
   }

   public function get_order_by_date($date) {
      $result = $this->db->query("
         SELECT DATE(order_time) AS order_date , SUM(order_total) AS total_amount
         FROM `order_information`
         WHERE order_status = 'accept' AND DATE(order_time) = '$date'
         GROUP BY order_date
      ")->row();
      return $result;
   }

   public function api_order_insert($save_data) {
      $currently_inserted_id = 0;
      $cart_data = $save_data['cart_data'];
      $customer = $save_data['customer'];
      // dd($cart_data);
      if (!empty($cart_data)) {
         $customer_email = $customer ? $customer->email : '';
         $cart_details = $cart_data;
         $order_time = date("Y-m-d H:i:s");
         $platform = $save_data['platform'];
         $cart_total = $save_data['cart_total'];
         $delivery_charge = $save_data['delivery_charge'];
         $discount = $save_data['discount'];
         $payment_method = $save_data['payment_method'];
         $order_type = $save_data['order_type'];
         $surcharge = $save_data['surcharge'];
         $delivery_time = $save_data['delivery_time'];
         $notes = $save_data['notes'];
         $is_pre_order = $save_data['is_pre_order'];

         $coupon_id = $save_data['coupon_id'];
         $coupon_code = $save_data['coupon_code'];
         $coupon_discount = $save_data['coupon_discount'];
         $total_buy_get_amount = $save_data['total_buy_get_amount'];
         $service_charge = $save_data['service_charge'];
         $packaging_charge = $save_data['packaging_charge'];
         $transaction_id = $save_data['transaction_id'];
         $table_number = $save_data['table_number'];
         $tips_amount = $save_data['tips_amount'];

         $total = ($cart_total + $delivery_charge + $service_charge + $packaging_charge + $tips_amount + $surcharge) - ($discount + $total_buy_get_amount);
         $cash = 0;
         $card = 0;
         if ($payment_method == 'cash') {
            $cash = $total;
         } else {
            $card = $total;
         }

         $order_info_for_save = array(
            'platform' => $platform,
            'customer_id' => $customer->id,
            'transaction_id' => $transaction_id,
            'order_time' => $order_time,
            'order_status' => 'pending',
            'order_type' => $order_type,
            'table_number' => $table_number,
            'delivery_time' => $delivery_time,
            'delivery_charge' => $delivery_charge,
            'payment_method' => $payment_method,
            'cash_amount' => $cash,
            'card_amount' => $card,
            'coupon_id' => $coupon_id,
            'discount' => $discount,
            'service_charge' => $service_charge,
            'packaging_charge' => $packaging_charge,
            'tips' => $tips_amount,
            'order_total' => $total,
            'notes' => $notes,
            'is_pre_order' => $is_pre_order,
            'surcharge' => $surcharge
         );

         $order_information_save_result = $this->Order_information_Model->save($order_info_for_save);
         if ($order_information_save_result) {
            $currently_inserted_id = $this->db->insert_id();
            // order id save for new order
            $new_order_save = array('order_id' => $currently_inserted_id,);
            $this->New_order_Model->save($new_order_save);
            //order_details_insert()
            $item_order_time = get_current_date_time('Y-m-d');
            foreach ($cart_details as $cart) {
               $isDeals = property_exists($cart,'isDeals') ? $cart->isDeals : false;
               if ($isDeals) {
                  $m_order_deals = new Order_Deals_Model();
                  $deal = $cart->deal;
                  $productText = $cart->productText;
                  $dealItems = $cart->itemDetails;
                  $deal_name = $deal->title;
                  if (isset($deal->deal_printed_description) && !empty($deal->deal_printed_description)) {
                     $deal_name .= $deal->deal_printed_description;
                  }
                  $is_deals_save = $m_order_deals->save(array(
                     'order_id'=> $currently_inserted_id,
                     'title'=> $deal_name,
                     'price'=> $cart->price,
                     'quantity'=> $cart->quantity,
                     'productText'=> $productText,
                     'dealsDetails'=> json_encode($deal),
                     'itemsDetails'=> json_encode($dealItems),
                  ));

                  if ($is_deals_save) {
                     $order_deals_id = $m_order_deals->db->insert_id();
                     $this->insertDealsProduct($dealItems,$currently_inserted_id,$order_deals_id);
                  }
               } else {
                  $quantity = $cart->quantity;
                  $buy_get_amount = 0;
                  if (isset($cart->buy_get_amount)) {
                     $buy_get_amount = $cart->buy_get_amount;
                  }

                  $options = $cart->options;
                  $optionsWith = [];
                  $optionWithout = [];
                  if ($options) {
                     $optionsWith = $options->with;
                     $optionWithout = $options->without;
                  }

                  $item = $cart->item;
                  $regular_price = 0;
                  if (isset($item->regular_price)) {
                     $regular_price = $item->regular_price;
                  }
                  $price = $item->price;
                  $product_id = $item->product_id;
                  $product_name = $item->name;
                  if (isset($item->printedDescription) && !empty($item->printedDescription)) {
                     $product_name .= $item->printedDescription;
                  }
                  $sub_product_id = $item->sub_product_id;
                  $item_comments = $item->comment;

                  // option with as price with add
                  $cat_level = $this->getProductCatLevel($product_id,$sub_product_id);
                  $is_free = $cart->isFree;

                  $order_details_for_save = array(
                     'order_id' => $currently_inserted_id,
                     'product_id' => $product_id,
                     'is_free' => $is_free,
                     'selection_item_id' => (!empty($sub_product_id)) ? $sub_product_id : 0,
                     'product_name' => $product_name,
                     'regular_price' => $regular_price,
                     'unit_price' => $price,
                     'buy_get_amount' => $buy_get_amount,
                     'quantity' => $quantity,
                     'amount' => $price * $quantity,
                     'cat_level' => $cat_level,
                     'item_order_time'=> $item_order_time,
                     'item_comments'=> $item_comments
                  );

                  $order_details_save_result = $this->Order_details_Model->save($order_details_for_save);
                  $currently_inserted_order_details_id = $this->db->insert_id();

                  if (!empty($optionsWith)) {
                     foreach ($optionsWith as $side_dish) {
                        $order_side_dish_for_save = array(
                           'side_dish_id' => $side_dish->SideDishesId,
                           'order_id' => $currently_inserted_id, // currently_inserted_order_id
                           'order_details_id' => $currently_inserted_order_details_id,
                           'side_dish_name' => $side_dish->SideDishesName,
                           'price' => $side_dish->UnitPrice,
                           'vat' => $side_dish->VatRate,
                           'quantity' => 1,
                           'order_time' => $order_time
                        );
                        $order_side_dish_save_result = $this->Order_side_dish_Model->save($order_side_dish_for_save);
                     }
                  }
                  if (!empty($optionWithout)) {
                     foreach ($optionWithout as $side_dish) {
                        $order_side_dish_for_save = array(
                           'side_dish_id' => $side_dish->SideDishesId,
                           'order_id' => $currently_inserted_id, // currently_inserted_order_id
                           'order_details_id' => $currently_inserted_order_details_id,
                           'side_dish_name' => $side_dish->SideDishesName,
                           'is_no' => 1,
                           'price' => 0,
                           'vat' => $side_dish->VatRate,
                           'quantity' => 1,
                           'order_time' => $order_time
                        );
                        $order_side_dish_save_result = $this->Order_side_dish_Model->save($order_side_dish_for_save);
                     }
                  }
               }
            }
            $order_email_template = $this->get_order_email_template($currently_inserted_id);
            $subject = 'Order has been placed to '.get_company_name();
            try {
               $this->send_mail($order_email_template,$customer_email,$subject);
            } catch (Exception $e) {
               // 
            }
         }
         return $order_information_save_result;
      }
   }

   public function getProductCatLevel($product_id,$sub_product_id) {
      if (!empty($product_id) && !empty($sub_product_id)) {
         return 4;
      } else if (empty($product_id) && !empty($sub_product_id)) {
         return 3;
      } else {
         return 0;
      }
   }

   public function insertDealsProduct($dealsItems,$orderId, $dealsId) {
      $m_order_details = new Order_details_Model();
      $order_time = get_current_date_time();
      foreach ($dealsItems as $dealsItem) {
         if (!is_array($dealsItem)) {
            $dealsItem = (array)$dealsItem;
         }
         $itemProducts = $dealsItem['itemProducts'];
         if (!empty($itemProducts)) {
            foreach ($itemProducts as $itemProduct) {
               if (!is_array($itemProduct)) {
                  $itemProduct = (array)$itemProduct;
               }
               $subProduct = $itemProduct['subProduct'];
               $product = $itemProduct['product'];
               $modifiers = $itemProduct['modifiers'];
               $item_order_time = get_current_date_time('Y-m-d');
               if (!empty($subProduct)) {
                  if (!is_array($subProduct)) {
                     $subProduct = (array)$subProduct;
                  }

                  $order_details_for_save = array(
                     'order_id' => $orderId,
                     'order_deals_id' => $dealsId,
                     'product_id' => $subProduct['foodItemId'],
                     'selection_item_id' => $subProduct['selectiveItemId'],
                     'product_name' => $subProduct['selectiveItemName'],
                     'unit_price' => $subProduct['takeawayPrice'],
                     'quantity' => 1,
                     'amount' => $subProduct['takeawayPrice'],
                     'cat_level' => 4,
                     'item_order_time' => $item_order_time
                  );
               } else {
                  if (!empty($product)) {
                     if (!is_array($product)) {
                        $product = (array)$product;
                     }
                     $order_details_for_save = array(
                        'order_id'=>$orderId,
                        'order_deals_id'=>$dealsId,
                        'product_id'=>$product['foodItemId'],
                        'selection_item_id'=>0,
                        'product_name'=>$product['foodItemName'],
                        'unit_price'=>$product['takeawayPrice'],
                        'quantity'=>1,
                        'amount'=>$product['takeawayPrice'],
                        'cat_level'=>3,
                        'item_order_time'=>$item_order_time
                     );
                  }
               }
               if (!empty($order_details_for_save)) {
                  $is_save = $m_order_details->save($order_details_for_save);
                  if ($is_save) {
                     $order_details_id = $m_order_details->db->insert_id();
                     $this->insertDealsSideDishes($modifiers,$orderId,$order_details_id,$order_time);
                  }
               }
            }
         }
      }
   }

   public function insertDealsSideDishes($side_dishes,$order_id,$order_details_id,$order_time) {
      if (!empty($side_dishes)) {
         foreach ($side_dishes as $side_dish) {
            if (!is_array($side_dish)) {
               $side_dish = (array)$side_dish;
            }
            $order_side_dish_for_save = array(
               'side_dish_id'=>$side_dish['SideDishesId'],
               'order_id'=>$order_id, // currently_inserted_order_id
               'order_details_id'=>$order_details_id,
               'side_dish_name'=>$side_dish['SideDishesName'],
               'price'=>$side_dish['UnitPrice'],
               'quantity'=>$side_dish['quantity'],
               'order_time'=>$order_time
            );
            $this->Order_side_dish_Model->save($order_side_dish_for_save);
         }
      }
   }

   public function insert_cart_order($order_type,$delivery_time,$payment_method = 'cash',$notes = null,$delivery_charge = 0,$cart_contents = array(),$is_pre_order = false,$card_order_id = 0,$discount = 0,$coupon_id = 0,$tips_amount = 0,$service_charge = 0,$packaging_charge = 0,$transaction_id = null) {
      $currently_inserted_id = 0;
      if (!empty($cart_contents)) {
         if (is_null($tips_amount)) {
            $tips_amount = 0;
         }
         $tips_amount = (double) $tips_amount;
         $customer_id = $this->session->userdata('customer_id');
         $customer = $this->Customer_Model->get($customer_id,true);
         $current_date_time = date("Y-m-d H:i:s");
         $order_time = $current_date_time;
         //$order_time = date("Y-m-d H:i:s");
         $payment_settings = get_payment_settings();
         $surcharge = 0;
         if ($payment_method != 'cash') {
            $surcharge = (int)get_property_value('surcharge',$payment_settings);
         }
         $cart_total = $this->cart->total();
         $total_buy_get_amount = get_total_from_cart('buy_get_amount');
         $total = ($cart_total + $delivery_charge + $service_charge + $packaging_charge + $tips_amount + $surcharge) - ($discount + $total_buy_get_amount);
         $card = 0;
         $cash = 0;
         if ($payment_method == 'cash') {
            $cash = $total;
         } else {
            $card = $total;
         }
         $table_number = null;
         if ($order_type == 'dine_in') {
            $table_number = $this->session->userdata('dine_in_table_number_id');
         }
         $order_info_for_save = array(
            'platform' => 'web',
            'customer_id' => $customer_id,
            'transaction_id' => $transaction_id,
            'order_time' => $order_time,
            'order_status' => 'pending',
            'order_type' => $order_type,
            'table_number' => $table_number,
            'delivery_time' => $delivery_time,
            'delivery_charge' => $delivery_charge,
            'payment_method' => $payment_method,
            'cash_amount' => $cash,
            'card_amount' => $card,
            'coupon_id' => $coupon_id,
            'discount' => $discount,
            'service_charge' => $service_charge,
            'packaging_charge' => $packaging_charge,
            'tips' => $tips_amount,
            'order_total' => $total,
            'notes' => $notes,
            'is_pre_order' => $is_pre_order,
            'surcharge' => $surcharge
         );
         // dd($order_info_for_save);
         $m_new_order = new New_order_Model();
         $m_side_dish = new Order_side_dish_Model();
         $m_details = new Order_details_Model();
         $m_order_deals = new Order_Deals_Model();
         $lib_product = new Product();
         $order_information_save_result = $this->save($order_info_for_save);
         if ($order_information_save_result) {
            set_order_placed();
            $currently_inserted_id = $this->db->insert_id();
            $this->session->set_flashdata('currently_inserted_order_id', $currently_inserted_id);
            // order id save for new order
            $new_order_save = array('order_id' => $currently_inserted_id,);
            if ($card_order_id > 0) {
               // updated order id in card order table
               $m_card_order = new Card_Order_Model();
               $m_card_order->save($new_order_save,$card_order_id);
            }
            $m_new_order->save($new_order_save);
            // order_details_insert()
            foreach ($cart_contents as $cart) {
               $isDeals = array_key_exists('deals',$cart);
               if ($isDeals) {
                  $deal = $cart['deals'];
                  $productText = $cart['dealsText'];
                  $dealItems = $deal['dealItems'];
                  $is_deals_save = $m_order_deals->save(array(
                     'order_id' => $currently_inserted_id,
                     'title' => $cart['name'],
                     'price' => $cart['price'],
                     'quantity' => $cart['qty'],
                     'productText' => $productText,
                     'dealsDetails' => json_encode($deal['deal']),
                     'itemsDetails' => json_encode($dealItems),
                  ));
                  if ($is_deals_save) {
                     $order_deals_id = $m_order_deals->db->insert_id();
                     $this->insertDealsProduct($dealItems,$currently_inserted_id,$order_deals_id);
                  }
               } else {
                  $is_free = false;
                  if (isset($cart['isFree']) && !empty($cart['isFree'])) {
                     $is_free = $cart['isFree'];
                  }
                  if (isset($cart['is_loyalty_program_discount']) && !empty($cart['is_loyalty_program_discount'])) {
                     $is_free = $cart['is_loyalty_program_discount'];
                  }

                  $order_details_for_save = array(
                     'order_id' => $currently_inserted_id,
                     'product_id' => get_array_key_value('product_id',$cart),
                     'is_free' => $is_free,
                     'selection_item_id' => get_array_key_value('sub_product_id',$cart),
                     'product_name' => $cart['name'],
                     'regular_price' => isset($cart['regular_price']) ? $cart['regular_price'] : 0,
                     'unit_price' => $cart['price'],
                     'buy_get_amount' => isset($cart['buy_get_amount']) ? $cart['buy_get_amount'] : 0,
                     'quantity' => $cart['qty'],
                     'amount' => $cart['price'] * $cart['qty'],
                     'side_dish_price' => empty($cart['side_dish_price']) ? 0 : $cart['side_dish_price'],
                     'side_dish_vat' => empty($cart['side_dish_vat']) ? 0 : $cart['side_dish_vat'],
                     'cat_level' => $cart['cat_level'],
                     'item_order_time' => $order_time,
                     'item_comments' => get_array_key_value('comments',$cart)
                  );

                  $order_details_save_result = $m_details->save($order_details_for_save);
                  $currently_inserted_order_details_id = $m_details->db->insert_id();
                  $this->session->set_flashdata('currently_inserted_order_details_id', $currently_inserted_order_details_id);
                  //order_side_dish_insert()
                  if ((!empty($cart['side_dish_ids']))) {
                     foreach ($cart['side_dish_ids'] as $side_dish_id) {
                        $side_dish = $lib_product->get_side_dish_by_id(trim($side_dish_id));
                        $order_side_dish_for_save = array(
                           'side_dish_id' => $side_dish_id,
                           'order_id' => $currently_inserted_id, // currently_inserted_order_id
                           'order_details_id' => $currently_inserted_order_details_id,
                           'side_dish_name' => $side_dish->SideDishesName,
                           'vat' => $cart['vat'],
                           'price' => $cart['price'],
                           'quantity' => 1,
                           'order_time' => $order_time
                        );
                        $order_side_dish_save_result = $m_side_dish->save($order_side_dish_for_save);
                     }
                  }
               }
            }
            $this->cart->destroy();
            $this->get_session_clear();
            $order_email_template = $this->get_order_email_template($currently_inserted_id);
            $subject = 'Order has been placed to '.get_company_name();
            $customer_email = $customer->email;
            $this->send_mail($order_email_template,$customer_email,$subject);
         }
         return $order_information_save_result;
      }
   }

   public function card_order_insert($card_order_id = 0) {
      $current_date_time = date("Y-m-d H:i:s");
      $current_date = date("Y-m-d");
      $m_card_order_model = new Card_Order_Model();
      $card_order_details = null;
      if (intval($card_order_id) > 0) {
         $card_order_details = $m_card_order_model->get($card_order_id,true);
      }

      if (!empty($card_order_details)) {
         if ($card_order_details->order_id == 0) {
            $customer_id = $card_order_details->customer_id;
            $card_order_info = $card_order_details->order_info;
            $card_order_info = (!empty($card_order_info)) ? json_decode($card_order_info,true) : array();
            $delivery_time = get_array_key_value('delivery_time',$card_order_info);
            $order_type = get_array_key_value('order_type',$card_order_info);
            $delivery_charge = get_array_key_value('delivery_charge',$card_order_info);
            $payment_method = get_array_key_value('payment_method',$card_order_info);
            $order_note = get_array_key_value('order_note',$card_order_info);
            $discount = get_array_key_value('discount',$card_order_info);
            $is_pre_order = get_array_key_value('is_pre_order',$card_order_info);
            $payment_settings = get_payment_settings();
            $surcharge = 0;
            if ($payment_method != 'cash') {
               $surcharge = get_property_value('surcharge',$payment_settings);
            }
            $cart_contents = $card_order_details->cart_contents;
            $cart_contents = !empty($cart_contents) ? json_decode($cart_contents,true) : array();

            $order_info_for_save = array(
               'customer_id' => $customer_id,
               'order_time' =>$current_date_time,
               'order_status' => 'pending',
               'order_type' => $order_type,
               'delivery_time' => $delivery_time,
               'delivery_charge' => $delivery_charge,
               'payment_method' => $payment_method,
               'cash_amount' => 0,
               'card_amount' => $card_order_details->paid_amount,
               'discount' =>$discount,
               'order_total' => $card_order_details->payable_amount,
               'notes' => $order_note,
               'is_pre_order' => $is_pre_order,
               'surcharge' => $surcharge
            );

            $m_new_order = new New_order_Model();
            $m_side_dish = new Order_side_dish_Model();
            $m_details = new Order_details_Model();
            $lib_product = new Product();
            $order_information_save_result = $this->save($order_info_for_save);
            if ($order_information_save_result) {
               set_order_placed();
               $currently_inserted_id = $this->db->insert_id();
               // order id save for new order
               $new_order_save = array('order_id' => $currently_inserted_id,);
               if ($card_order_id > 0) {
                  // updated order id in card order table
                  $m_card_order=new Card_Order_Model();
                  $m_card_order->save($new_order_save,$card_order_id);
               }
               $m_new_order->save($new_order_save);
               //order_details_insert()
               foreach ($cart_contents as $cart) {
                  $isDeals = array_key_exists('deals',$cart);
                  if ($isDeals) {
                     $m_order_deals = new Order_Deals_Model();
                     $deal = $cart['deals'];
                     $productText = $cart['dealsText'];
                     $dealItems = $deal['dealItems'];
                     $is_deals_save = $m_order_deals->save(array(
                        'order_id'=>$currently_inserted_id,
                        'title'=>$cart['name'],
                        'price'=>$cart['price'],
                        'quantity'=>$cart['qty'],
                        'productText'=>$productText,
                        'dealsDetails'=>json_encode($deal['deal']),
                        'itemsDetails'=>json_encode($dealItems),
                     ));
                     if ($is_deals_save) {
                        $order_deals_id = $m_order_deals->db->insert_id();
                        $this->insertDealsProduct($dealItems,$currently_inserted_id,$order_deals_id);
                     }
                  } else {
                     $order_details_for_save = array(
                        'order_id' => $currently_inserted_id,
                        'product_id' =>get_array_key_value('product_id',$cart),
                        'selection_item_id' => get_array_key_value('sub_product_id',$cart),
                        'product_name' => $cart['name'],
                        'unit_price' => $cart['price'],
                        'quantity' => $cart['qty'],
                        'amount' => $cart['price'] * $cart['qty'],
                        'cat_level' => $cart['cat_level'],
                        'item_order_time' => $current_date,
                        'item_comments' =>get_array_key_value('comments',$cart)
                     );
                     $order_details_save_result = $m_details->save($order_details_for_save);
                     $currently_inserted_order_details_id = $m_details->db->insert_id();
                     //order_side_dish_insert()
                     if ((!empty($cart['side_dish_ids']))) {
                        foreach ($cart['side_dish_ids'] as $side_dish_id) {
                           $side_dish = $lib_product->get_side_dish_by_id(trim($side_dish_id));
                           $order_side_dish_for_save = array(
                              'side_dish_id' => $side_dish_id,
                              'order_id' => $currently_inserted_id, // currently_inserted_order_id
                              'order_details_id' => $currently_inserted_order_details_id,
                              'side_dish_name' => $side_dish->SideDishesName,
                              'vat' => $cart['vat'],
                              'price' => $cart['price'],
                              'quantity' =>1,
                              'order_time' => $current_date_time
                           );
                           $order_side_dish_save_result = $m_side_dish->save($order_side_dish_for_save);
                        }
                     }
                  }
               }
               $order_email_template = $this->get_order_email_template($currently_inserted_id);
               $subject = 'Order has been placed to '.get_company_name();
               $m_customer = new Customer_Model();
               $customer = $m_customer->get($customer_id);
               $customer_email = $customer->email;
               $this->send_mail($order_email_template,$customer_email,$subject);
            }
            return $order_information_save_result;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }

   public function get_order_email_template($order_id = 0,$delivery_time = null) {
      $order_information = (intval($order_id) > 0) ? $this->get($order_id,true) : null;
      if (!empty($order_information)) {
         $customer_id = $order_information->customer_id;
         $customer = $this->Customer_Model->get($customer_id, true);
         $order_details = $this->Order_details_Model->get_where('order_id',$order_id);
         $table_info = null;
         if ($order_information->table_number) {
            $table_info = $this->db->query("SELECT * FROM tables WHERE id = $order_information->table_number")->row();
         }
         $data = array(
            'order_information' => $order_information,
            'table_info' => $table_info,
            'order_details' => $order_details,
            'customer' => $customer,
            'delivery_time' => $delivery_time,
         );
         return $this->load->view('email_template/order_details',$data ,true);
      } else {
         return '<h2>Order is not completed</h2>';
      }
   }

   private function get_session_clear() {
      $this->session->unset_userdata('order_type_session');  // delivery/collection
      $this->session->unset_userdata('notes_session'); //special notes
      $this->session->unset_userdata('delivery_charge_info_session');
      $this->session->unset_userdata('delivery_charge_session');
      $this->session->unset_userdata('coupon_code');
      $this->session->unset_userdata('coupon_id');
   }

   public function send_mail($order_email_template=null,$customer_email='',$subject='') {
      $config = Array(
         'protocol' => 'smtp',
         'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
         'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
         'smtp_port' => 465,
         'smtp_user' => trim(get_smtp_host_user()), // change it to yours
         'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
         'mailtype' => 'html',
      );

      $this->load->library('email');
      $this->email->initialize($config);
      $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
      $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
      $this->email->to($customer_email);
      $this->email->bcc(trim(get_company_contact_email()));
      $this->email->subject($subject);
      $this->email->message($order_email_template);
      $is_sent = false;
      try {
         //check if
         return $this->email->send();
      } catch (Exception $e) {
         return false;
      }
   }

   public function is_customer_first_order($customer_id = 0) {
      if (intval($customer_id) > 0) {
         $result = $this->get_by(array('customer_id'=>$customer_id),true);
         return empty($result) ? true : false;
      } else {
         return false;
      }
   }

   public function get_order_account_details($order_status = 'all',$start_date = null,$end_date = null) {
      $where_query = "";
      if ($order_status != 'all') {
         $where_query .= "WHERE `order_status` = '$order_status'";
      }

      if ($start_date && $end_date) {
         if ($where_query == "") {
            $where_query .= "WHERE";
         } else {
            $where_query .= " AND";
         }
         $where_query .= " DATE_FORMAT(`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
      }
      $result = $this->db->query("
         SELECT SUM(`order_total`) AS `order_total`, SUM(`discount`) AS `discount`, SUM(`card_amount`) AS `card_amount`, SUM(`cash_amount`) AS `cash_amount`, SUM(`surcharge`) AS `surcharge`
         FROM `order_information` $where_query
      ")->row();
      return $result;
   }

   public function getLastOrder($customerId = 0) {
      //$this->db->select('order_time');
      $this->db->where('customer_id',$customerId);
      $this->db->order_by('id','DESC');
      return $this->db->get($this->table_name)->row();
   }

   public function isOrderProcessFormCustomer($customerId = 0) {
      $customer_last_order = $this->getLastOrder($customerId);
      if (!empty($customer_last_order)) {
         $order_time = $customer_last_order->order_time;
         $current_time = date("Y-m-d H:i");
         $order_time = strtotime($order_time);
         $current_time = strtotime($current_time);
         $time_difference = ($current_time - $order_time);
         /*Customer order process less than one minute return false*/
         return $time_difference > 60;
      } else {
         return true;
      }
   }

   public function send_multiple_mail($subject='',$body=null,$to_email=null,$cc_emails=array()) {
      $config = Array(
         'protocol' => 'smtp',
         'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
         'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
         'smtp_port' => 465,
         'smtp_user' => trim(get_smtp_host_user()), // change it to yours
         'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
         'mailtype' => 'html',
      );
      $this->load->library('email');
      $this->email->initialize($config);
      $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
      $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
      if (!empty($to_email)) {
         $this->email->to($to_email);
      }
      if (!empty($cc_emails)) {
         $this->email->cc($cc_emails);
      }
      $this->email->subject($subject);
      $this->email->message($body);
      $is_sent = false;
      try {
         //check if
         return $this->email->send();
      } catch (Exception $e) {
         return false;
      }
   }
}