<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_Model extends Ex_Model {

    protected $table_name = 'customer';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public $customer_registration_admin_rules = array(
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide %s.',),
        ),
        'telephone' => array(
            'field' => 'telephone',
            'label' => 'Telephone',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide %s.',)
        ),
        'mobile' => array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide %s.',)
        )
    );

    public $customer_registration_rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Please select your %s',),
        ),
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9\s.]+$/]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'regex_match' => '%s contains letters, numbers and space only'
            ),
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
            'label' => 'Email Address',
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
        'billing_postcode' => array(
            'field' => 'billing_postcode',
            'label' => 'Postcode',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'regex_match' => '%s contains letters, numbers and space only'
            ),
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
        'confirm_password' => array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
        'terms_conditions' => array(
            'field' => 'terms_conditions',
            'label' => 'Terms And Conditions',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must agree to our %s.',),
        )
    );

    public $customer_login_rules = array(
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
    );

    public $email_rules = array(
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
    );

    public $code_rules = array(
        'code' => array(
            'field' => 'code',
            'label' => 'code',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
    );

    public $recovery_password_reset_rules = array(
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
        'confirm_password' => array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
    );

    public $password_reset_rules = array(
        'current_password' => array(
            'field' => 'current_password',
            'label' => 'Current Password',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
        'confirm_password' => array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]',
            'errors' => array('required' => 'Provide a  %s.',),
        ),
    );

    public $customer_profile_update_rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Please Provide your Title',),
        ),
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Please Provide your First Name',),
        ),
        'last_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Please Provide your Last Name',),
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'mobile' => array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'billing_address_line_1' => array(
            'field' => 'billing_address_line_1',
            'label' => 'Address',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'billing_postcode' => array(
            'field' => 'billing_postcode',
            'label' => 'Postcode',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'billing_city' => array(
            'field' => 'billing_city',
            'label' => 'City',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        )
    );

    public function get_all_customers_for_api() {
        $results = $this->db->query("SELECT * FROM `customer` ORDER BY `first_name` ASC")->result();
        return $results;
    }

    public function get_customer_info_by_id($id = 0) {
        $result = $this->db->query("
            SELECT `id`,`title`,`first_name`,`last_name`,`email`,`telephone`,`mobile`,`billing_address_line_1`,`billing_address_line_2`,`billing_city`,`billing_postcode`,`delivery_address_line_1`,`delivery_address_line_2`,`delivery_city`,`delivery_postcode`,`date_of_birth`
            FROM `customer`
            WHERE `id` = $id
        ")->row();
        return $result;
    }

    public function login($email,$password) {
        $customer = $this->get_by((array('email' => $email, 'password' => $password)), true);
        if (count($customer)) {
            $customer_data = array(
                'customer_name' => $customer->first_name . ' ' . $customer->last_name,
                'customer_email' => $customer->email,
                'customer_id' => $customer->id,
                'login_type' => $customer->login_type,
                'is_loggedIn' => true,
            );
            $this->session->set_userdata($customer_data);
        }
    }

    public function logout_guest_customer() {
        $login_type = $this->session->userdata('login_type');
        $is_loggedIn = $this->session->userdata('is_loggedIn');
        
        if ($is_loggedIn == true && $login_type == 'guest') {
            redirect('my_account/logout');
        }
    }

    public function logout() {
        $this->session->set_userdata('is_loggedIn', false);
    }

    public function customer_is_loggedIn() {
        return (bool) $this->session->userdata('is_loggedIn');
    }

    public function new_customer() {
        $data = $this->data_form_post(array('name', 'email', 'password'));
        $this->save($data);
    }

    public function update_customer() {
        $data = $this->data_form_post(array('id', 'name', 'email', 'password'));
        $this->save($data, $data['id']);
    }

    public function is_email_registered() {
        $email = $this->input->post('email');
        $this->search_column_name = 'email';
        return !empty($this->get_numbers_of_rows($email)) ? true : false;
    }

    public function is_telephone_or_mobile_exist($telephone, $mobile) {
        $result = $this->db->query("SELECT * FROM customer WHERE telephone = '$telephone' OR mobile = '$mobile'")->row();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_telephone_exist_check_for_update($telephone, $id) {
        $result = $this->db->query("SELECT * FROM customer WHERE telephone = '$telephone' AND id != $id")->row();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_mobile_exist_check_for_update($mobile, $id) {
        $result = $this->db->query("SELECT * FROM customer WHERE mobile = '$mobile' AND id != $id")->row();
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_customer_by_email($email) {
        if (!empty($email)) {
            $this->db->where('email=', $email);
            return $this->get(null, true);
        } else {
            return array();
        }
    }

    public function get_customer_by_id($id) {
        if (!empty($id)) {
            $result = $this->db->query("SELECT * FROM customer WHERE id = $id")->row();
            return $result;
        } else {
            return array();
        }
    }

    public function is_code_exist_with_email($customer_id, $code, $email) {
        if (!empty($code) && !empty($customer_id) && !empty($email)) {
            $this->db->where('id', $customer_id);
            $this->db->where('temp_code', $code);
            $this->db->where('email=', $email);
            return (!empty($this->get(null, true))) ? true : false;
        } else {
            return false;
        }
    }

    public function update_password_recovery($customer_id, $password) {

        if (!empty($customer_id)) {
            $data['password'] = $password;
            //$data['temp_code']='';
            return $this->save($data, $customer_id);
        } else {
            return false;
        }
    }

    public function is_password_match_with_id($customer_id, $password) {
        if ((!empty($customer_id)) && (!empty($password))) {
            $this->db->where('id', $customer_id);
            $this->db->where('password', $password);
            return(!empty($this->get(null, true))) ? true : false;
        } else {
            return false;
        }
    }

    public function get_logged_in_customer_id() {
        if ($this->customer_is_loggedIn()) {
            return $this->session->userdata('customer_id');
        }
        return 0;
    }

    public function get_logged_in_customer_email() {
        return $this->session->userdata('customer_email');
    }

    public function get_login_customer_email_update_duplicate_check($customer_id, $email) {
        $query = $this->db->query("SELECT * FROM customer WHERE id != '$customer_id' AND  email = '$email'");
        return $query->row();
    }

    public function get_customer_by_phone_mobile_email($phone = '', $mobile = '', $email = '') {
        $sr = '';
        if (!empty($phone)) {
            $sr .= "telephone = '$phone' OR ";
        }
        if (!empty($mobile)) {
            $sr .= "mobile = '$mobile' OR ";
        }
        if (!empty($email)) {
            $sr .= "email = '$email'";
        }
        $query = $this->db->query("SELECT * FROM customer WHERE $sr");
        return $query->row();
    }

    public function get_customers($limit = 0,$offset = 0) {
        $this->db->limit($limit,$offset);
        return $this->db->get($this->table_name)->result();

    }

    public function get_lowest_price($min_price,$price) {
        if ($min_price < $price) {
            return $min_price;
        } else {
            return $price;
        }
    }

    public function get_discountable_amount($cart_content) {
        $discountAmount = 0;
        if (is_array($cart_content)) {
            foreach ($cart_content as $item) {
                if (((isset($item['is_category_discount']) && $item['is_category_discount'] == 0) && (isset($item['is_item_discount']) && $item['is_item_discount'] == 0)) && (isset($item['is_deals_discount']) && $item['is_deals_discount'] == 0)) {
                    $discountAmount += $item['subtotal'] - $item['buy_get_amount'];
                }
            }
        }
        return $discountAmount;
    }

    public function buy_get_discount_amount($cart_content) {
        $buy_get_discount = 0;
        $min_price = 999999;
        $total_qty = 0;
        $buy_qty = 0;
        $get_qty = 0;
        
        foreach ($cart_content as $item) {
            if ($item['isDeal'] === false) {
                if ($item['is_buy_get_discount'] === true) {
                    $total_qty += $item['qty'];
                    $buy_qty = $item['buy_qty'];
                    $get_qty = $item['get_qty'];
                    if ($min_price < $item['price']) {
                        $min_price = $min_price;
                    } else {
                        $min_price = $item['price'];
                    }
                }
                $multiplier = $buy_qty + 1;
                if ($total_qty % $multiplier == 0) {
                    $offerQty = intval($total_qty / $multiplier);
                    $buy_get_discount = ($offerQty * $get_qty * $min_price);
                }
            }
        }

        return $buy_get_discount;
    }

    public function get_service_charge($order_type = '',$payment_method = 'cash') {
        $service_charge_data = get_service_charge_data();
        $service_charge = 0;

        if ($service_charge_data && $this->cart->contents()) {
            if (isset($service_charge_data['is_service_charge_applicable']) && $service_charge_data['is_service_charge_applicable'] == 1) {
                if ($order_type && $order_type == 'collection' && isset($service_charge_data['for_collection']) && $service_charge_data['for_collection'] == 1) {
                    if ($payment_method && $payment_method == 'cash' && isset($service_charge_data['is_active_collection_cash']) && $service_charge_data['is_active_collection_cash'] == 1) {
                        if (isset($service_charge_data['collection_cash_charge'])) {
                            $service_charge = $service_charge_data['collection_cash_charge'];
                        }
                    }

                    if ($payment_method && $payment_method != 'cash' && isset($service_charge_data['is_active_collection_card']) && $service_charge_data['is_active_collection_card'] == 1) {
                        if (isset($service_charge_data['collection_card_charge'])) {
                            $service_charge = $service_charge_data['collection_card_charge'];
                        }
                    }
                }

                if ($order_type && $order_type == 'delivery' && isset($service_charge_data['for_delivery']) && $service_charge_data['for_delivery'] == 1) {
                    if ($payment_method && $payment_method == 'cash' && isset($service_charge_data['is_active_delivery_cash']) && $service_charge_data['is_active_delivery_cash'] == 1) {
                        if (isset($service_charge_data['delivery_cash_charge'])) {
                            $service_charge = $service_charge_data['delivery_cash_charge'];
                        }
                    }

                    if ($payment_method && $payment_method != 'cash' && isset($service_charge_data['is_active_delivery_card']) && $service_charge_data['is_active_delivery_card'] == 1) {
                        if (isset($service_charge_data['delivery_card_charge'])) {
                            $service_charge = $service_charge_data['delivery_card_charge'];
                        }
                    }
                }
            }
        }
        
        return $service_charge;
    }

    public function get_packaging_charge($order_type = '') {
        $packaging_charge_data = get_packaging_charge_data();
        $packaging_charge = 0;

        if ($packaging_charge_data && $this->cart->contents()) {
            if (isset($packaging_charge_data['is_packaging_charge_applicable']) && $packaging_charge_data['is_packaging_charge_applicable'] == 1) {
                if ($order_type && $order_type == 'collection' && isset($packaging_charge_data['is_for_collection']) && $packaging_charge_data['is_for_collection'] == 1) {
                    if (isset($packaging_charge_data['collection_packaging_charge'])) {
                        $packaging_charge = $packaging_charge_data['collection_packaging_charge'];
                    }
                }

                if ($order_type && $order_type == 'delivery' && isset($packaging_charge_data['is_for_delivery']) && $packaging_charge_data['is_for_delivery'] == 1) {
                    if (isset($packaging_charge_data['delivery_packaging_charge'])) {
                        $packaging_charge = $packaging_charge_data['delivery_packaging_charge'];
                    }
                }
            }
        }
        
        return $packaging_charge;
    }

    public function get_discount_amount($cart_content,$order_type = null,$customer_id = 0) {
        $discountAmount = 0;
        $discount_data = get_discount_data();
        $loyalty_program_data = get_loyalty_program_data();
        $loyalty_program_discount = 0;

        $total_amount = $this->get_discountable_amount($cart_content);

        $currentDayNumber = date('w');
        $discount_on_order_type = 0;
        $discount_first_order = 0;

        if (!empty($discount_data)) {
            if (isset($discount_data[7])) {
                $discount_first_order = $this->get_first_order_discount($discount_data[7],$customer_id,$total_amount);
            }
            if (!empty($order_type)) {
                if (isset($discount_data[$currentDayNumber])) {
                    $discount_on_order_type = $this->get_discount_on_order_type($discount_data[$currentDayNumber],$order_type,$total_amount);
                }
            }
        }

        if (!empty($loyalty_program_data)) {
            $loyalty_program_discount = $this->get_loyalty_program_discount($loyalty_program_data,$customer_id,$order_type,$total_amount);
        }
        // dd($loyalty_program_discount);

        $discountAmount = $this->get_total_discount_amount($discount_data,$loyalty_program_data,$discount_first_order,$discount_on_order_type,$loyalty_program_discount);
        // dd($cart_content);

        return $discountAmount;
    }

    public function get_total_discount_amount($discount_data,$loyalty_program_data,$discount_first_order,$discount_on_order_type,$loyalty_program_discount) {
        $discountAmount = 0;
        $dailyDiscountAvailability = 0;
        $firstOrderAvailability = 0;
        $loyaltyProgramAvailability = 0;

        if (isset($discount_data[8])) {
            $dailyDiscountAvailability = get_array_key_value('dailyDiscountAvailability',$discount_data[8],0);
            $firstOrderAvailability = get_array_key_value('firstOrderAvailability',$discount_data[8],0);
        }

        if (isset($loyalty_program_data[0])) {
            $loyaltyProgramAvailability = get_array_key_value('loyaltyProgramAvailability',$loyalty_program_data[0],0);
        }

        if ($dailyDiscountAvailability == 0 && $firstOrderAvailability == 0 &&  $loyaltyProgramAvailability == 0) {
            $discountAmount = 0;
        } else {
            $discountAmount = $discount_on_order_type;
            $is_max = 1;
            
            if ($discount_first_order > $discountAmount) {
                $discountAmount = $discount_first_order;
                $is_max = 2;
            } elseif ($loyalty_program_discount > $discountAmount) {
                $discountAmount = $loyalty_program_discount;
                $is_max = 3;
            }

            if ($dailyDiscountAvailability == 1 && $is_max != 1) {
                $discountAmount += $discount_on_order_type;
            }

            if ($firstOrderAvailability == 1 && $is_max != 2) {
                $discountAmount += $discount_first_order;
            }

            if ($loyaltyProgramAvailability == 1 && $is_max != 3) {
                $discountAmount += $loyalty_program_discount;
            }
        }

        return $discountAmount;
    }

    public function get_loyalty_program_discount($loyalty_program_data = null,$customer_id = 0,$order_type,$total_amount = 0) {
        if ($customer_id > 0) {
            if(!empty($loyalty_program_data)) {
                $total_order = get_total_order($customer_id);

                foreach ($loyalty_program_data as $loyalty) {
                    $number_Of_order = get_array_key_value('number_Of_order',$loyalty);
                    $minimum_order_amount = get_array_key_value('minimum_order_amount',$loyalty);

                    if (!empty($minimum_order_amount) && $minimum_order_amount >= 0 && $total_order == $number_Of_order && $total_amount >= $minimum_order_amount) {
                        $discount_amount = get_array_key_value('discount_amount',$loyalty);
                        $maximum_discount_amount = get_array_key_value('maximum_discount_amount',$loyalty);
                        $offer_type = get_array_key_value('offer_type',$loyalty);

                        if ($offer_type == 'fixed') {
                            $discountAmount =  $discount_amount ;
                        } elseif ($offer_type == 'percentage') {
                            $discountAmount = ($total_amount * $discount_amount) / 100;
                        } elseif ($offer_type == 'others') {
                            $data = array(
                                'id' => rand(),
                                'is_loyalty_program_discount' => 1,
                                'product_id' => 0,
                                'sub_product_id' => 0,
                                'name' => get_array_key_value('description',$loyalty),
                                'qty' => 1,
                                'price' => 0,
                                'vat' => 0,
                                'side_dish' => null,
                                'cat_level' => 3,
                                'order_type' => $order_type,
                            );
                            // $this->cart->remove('186affa0329ac42f9c4f8f5dfb66aac0');
                            if (isHasFreeProductInCart() == 0) {
                                $this->cart->insert($data);
                            }
                            // dd($this->cart->contents());
                            return 0;
                        }

                        if ($discountAmount > $maximum_discount_amount) {
                            return $maximum_discount_amount;
                        } else {
                            return $discountAmount;
                        }                   
                    }
                }
                return 0;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function get_first_order_discount($discount_data = null,$customer_id = 0,$total_amount = 0) {
        if ($customer_id > 0) {
            $m_order_information = new Order_information_Model();
            $is_customer_first_order = $m_order_information->is_customer_first_order($customer_id);
            $first_order_discount_percent = 0;
            $first_order_discount_minimum_order_amount = 0;

            if ($is_customer_first_order) {
                $first_order_discount_minimum_order_amount = get_array_key_value('first_order_discount_minimum_order_amount',$discount_data);
                $first_order_discount_percent = get_array_key_value('first_order_discount_percent',$discount_data);
            }

            if (!empty($first_order_discount_minimum_order_amount) && $first_order_discount_minimum_order_amount >= 0 && $first_order_discount_minimum_order_amount <= $total_amount) {
                if ($first_order_discount_percent) {
                    return  ($total_amount * $first_order_discount_percent) / 100;
                }
                return 0;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function get_discount_on_order_type($discount_data = null,$order_type = '',$total_amount = 0) {
        if (!empty($discount_data)) {
            if ($order_type == 'delivery'  && !is_discount_off('delivery' )) {
                $discount_percent_key = 'delivery_discount_percent';
            } else if ($order_type == 'collection' && !is_discount_off('collection' )) {
                $discount_percent_key = 'collection_discount_percent';
            }

            if (!empty($discount_percent_key)){
                $discount_percent = get_array_key_value($discount_percent_key,$discount_data);
                if (!empty($discount_percent)) {
                    $minimum_order_amount = get_array_key_value('minimum_order_amount',$discount_data);

                    if (!empty($minimum_order_amount) && $minimum_order_amount >= 0 && $total_amount >= $minimum_order_amount) {
                        $maximum_order_amount = get_array_key_value('maximum_order_amount',$discount_data);
                        $discount_amount = ($total_amount * $discount_percent) / 100;

                        if (!empty($maximum_order_amount) && $maximum_order_amount > 0 && $discount_amount > $maximum_order_amount) {
                            $discount_amount = $maximum_order_amount;
                        }

                        return $discount_amount;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    public function get_api_discount($total_amount=0,$order_type='',$customer_id=0){
        $discount_data = get_discount_data();
        $discount_on_order_type = 0;
        $discount_first_order = 0;
        if(!empty($discount_data)){
            $discount_first_order = $this->get_first_order_discount($discount_data,$customer_id,$total_amount);
            $discount_on_order_type = $this->get_discount_on_order_type($discount_data,$order_type,$total_amount);
        }
        
        if ($discount_on_order_type > $discount_first_order) {            
            return $discount_on_order_type;
        }
        
        return $discount_first_order;
    }

    public function getCustomerByApiAuth($data = null) {
        if (!empty($data)) {
            $email = get_property_value('email',$data);
            $password = get_property_value('password',$data);
            $customer = null;
            $authorization = get_property_value('token',$data);
            if (!empty($authorization)) {
                $customer = $this->get_by(array('email'=>$email,'access_token'=>$authorization),true);
                if (!empty($password) && (empty($customer))) {
                    $password_sha1 = sha1($password);
                    $customer = $this->get_by(array('email'=>$email,'password'=>$password_sha1),true);
                }
            } else {
                if (!empty($password)) {
                    $password_sha1 = sha1($password);
                    $customer = $this->get_by(array('email'=>$email,'password'=>$password_sha1),true);
                }
            }
            return $customer;
        } else {
            return null;
        }
    }
}