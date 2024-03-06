<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends Api_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Card_Model');
        $this->load->helper('settings');
    }

    public function login() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $customer = $m_customer->getCustomerByApiAuth($data);
            if (empty($customer)) {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Email and password is not match',
                    'data' => null,
                    'is_logged_in' => false,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $auth_key = $this->Settings_Model->get_by(array("name" => 'auth_key'), true)->value;
                $password = $this->input->post('password');
                $customer->access_token = base64_encode($auth_key);
                $response_data = array(
                    'status' => 200,
                    'message' => 'Logged in successfully',
                    'data' => json_decode(json_encode($customer),true),
                    'is_logged_in' => true,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_all_customers() {       
        $response_data = array('status'=>400,'message'=>'Bad Request',);

        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $customer_lists = $this->Customer_Model->get_all_customers_for_api();
            if (!empty($customer_lists)) {
                $total_customer = count($customer_lists);
                $response_data = array(
                    'status'=>200,
                    'message'=>'Total '.$total_customer.' customer are given.',
                    'customer_lists'=>$customer_lists
                );
            } else {
                $response_data = array(
                    'status'=>200,
                    'message'=>'Customer Not Found.',
                    'customer_lists'=>$customer_lists
                );
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }
	
	public function is_email_exist() {		
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email= $data->email;        
            $password = (!empty($password)) ? sha1($password) : null;
            $customer = $m_customer->get_by(array('email'=>$email),true);
            if (!empty($customer)) {
                $response_data = array(
                    'status'=>200,
                    'message'=>'Email already registered',
                    'is_email_exist'=>true,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array('status'=>200,'message'=>'Email is not registered','is_email_exist'=>false,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
	}

    public function check_code() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = $data->email;
            $code = $data->code;
            $customer = (!empty($code)) ? $m_customer->get_by(array('email'=>$email,'temp_code'=>trim($code)),true):null;

            if(!empty($customer)){
                $response_data = array('status'=>200,'message'=>'Code matched','is_code_match'=>true,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array('status'=>200,'message'=>'Code is not matched','is_code_match'=>false,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
	}

    public function registration() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            // dd($data);
            $first_name = property_exists($data,'first_name') ? $data->first_name : '';
            $last_name = get_property_value('last_name',$data);
            $email = get_property_value('email',$data);
            $password = get_property_value('password',$data);
            $title = get_property_value('title',$data);
            $postcode = get_property_value('post_code',$data);
            $mobile = get_property_value('mobile',$data);
            $password_sha1 = (!empty($password)) ? sha1($password) : null;
            $is_registered = false;
            $message = '';

            if (!empty($email)) {
                $customer = $m_customer->get_by(array('email'=>$email),true);
                if (empty($customer)) {
                    $is_registered = $m_customer->save(array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'password' => $password_sha1,
                        'title' => $title,
                        'delivery_postcode' => $postcode,
                        'delivery_postcode' => $postcode,
                        'billing_postcode' => $postcode,
                        'mobile' => $mobile
                    ));
                    $message = (!$is_registered) ? 'User is not registered' : '';
                } else {
                    $is_registered = false;
                    $message = 'User email is already registered';
                }
            }

            if ($is_registered) {
                $customer_id = $m_customer->db->insert_id();
                $customer = $m_customer->get($customer_id);
                $this->send_registered_mail($customer);
                $response_data = array(
                    'status' => 200,
                    'is_registered' => $is_registered,
                    'message' => 'User has been registered successfully',
                    'data' => json_decode(json_encode($customer),true),
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $password = $this->input->post('password');
                $response_data = array(
                    'status' => 200,
                    'is_registered' => $is_registered,
                    'message' => $message,
                    'data' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function send_registered_mail($customer) {
        // dd($customer->email);
        $shop = get_company_details();
        $companyName = get_property_value('company_name', $shop);
        $customer_email = $customer->email;
        $customerName = get_customer_full_name($customer);
        $email = get_property_value('email', $customer);
        
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
        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to(trim($customer_email));
        $this->email->subject("Registration Confirmation Of ".$companyName);
        $this->data['customerInfo'] = $customer;
        $this->data['companyName'] = $companyName;
        $body = $this->load->view('email_template/customer_email', $this->data, true);
        $this->email->message($body);
        return $this->email->send();
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = $data->email;
            $password = $data->password;
            $update_data = $data->updateData;
            $password_sha1 = (!empty($password)) ? sha1($password) : null;
            $is_updated = false;
            $message = '';
            $customer = $m_customer->get_by(array('email' => $email, 'password' => $password_sha1), true);
            $update_data = json_decode(json_encode($update_data), true);
            if (!empty($customer)) {
                $customer_id = $customer->id;
                // update
                $is_updated = $m_customer->save($update_data, $customer_id);
                $message = (!$is_updated) ? 'Customer information did not updated' : 'Customer information successfully updated ';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_updated' => $is_updated,
                    'customer' => $customer,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $is_updated = false;
                $message = 'Customer information did not updated';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_updated' => $is_updated,
                    'customer' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function delete() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = $data->email;
            $password = $data->password;
            $customer_id = $data->customerId;
            $password_sha1 = (!empty($password)) ? sha1($password) : null;
            $message = '';
            $customer = $m_customer->get_by(array('email' => $email, 'password' => $password_sha1), true);
            if ($customer) {
                $customer_id = $customer->id;
                // delete
                $message = 'We have received your request, and after reviewing it we will get back to you. ';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_deleted' => true,
                    'customer' => $customer,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $message = 'Customer information not found';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_deleted' => false,
                    'customer' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function update_password() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = $data->email;
            $password = $data->password;
            $update_data = $data->updateData;
            $password_sha1 = $password ? sha1($password) : null;
            $is_updated = false;
            $message = '';
            $customer = $m_customer->get_by(array('email' => $email, 'password' => $password_sha1), true);
            if ($customer) {
                $customer_id = $customer->id;
                // update
                $new_password = trim($update_data->newPassword);
                if ($new_password) {
                    $new_password_sha1 = sha1($new_password);
                    $is_updated = $m_customer->save(array('password'=>$new_password_sha1), $customer_id);
                }

                $message = 'Password information did not updated';
                if ($is_updated) {
                    $message = 'Password information successfully updated';
                    $this->send_changed_password_mail($customer);
                }

                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_updated' => $is_updated,
                    'customer' => $customer,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $is_updated = false;
                $message = 'Customer information did not updated';
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_updated' => $is_updated,
                    'customer' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function send_changed_password_mail($customer_info) {
        if ($customer_info) {
            $ip = get_user_ip_address();
            $api_keys = "5d33e81130e343be882b84b782cd4e93";
            $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$api_keys."&ip=".$ip;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                )
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            
            if (empty($error)) {
                $customer_email = $customer_info->email;
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
                /// $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
                $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
                $this->email->to(trim($customer_email));
                $this->email->subject('Security Alert');
                $this->data['customer_info'] = $customer_info;
                $this->data['location'] = json_decode($response);
                $body = $this->load->view('email_template/changed_password', $this->data, true);
                $this->email->message($body);
                return $this->email->send();
            }
            return false;
        } else {
            return false;
        }
    }

    public function recover_password() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            // $email = $this->input->post('email');
            // $password = $this->input->post('password');
            $email = $data->email;
            $code = $data->code;
            $password = $data->newPassword;
            $password_sha1 = (!empty($password)) ? sha1($password) : null;
            $is_updated = false;
            $message = '';
            $customer = $m_customer->get_by(array('email' => $email, 'temp_code' => $code), true);
            $is_updated = false;
            if (!empty($customer) && !empty($password_sha1)) {
                $customer_id = $customer->id;
                // update
                if (!empty($password_sha1)) {
                    $is_updated = $m_customer->save(array('password'=>$password_sha1,'temp_code'=>null), $customer_id);
                }
            }

            $message = (!$is_updated) ? 'Password  did not recovered' : 'Password has been successfully recovered ';
            $response_data = array(
                'status' => 200,
                'message' => $message,
                'is_recovered' => $is_updated,
                'customer' => $customer,
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function send_recovery_code() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = $data->email;
            $customer = $this->Customer_Model->get_customer_by_email($email);
            if (!empty($customer)) {
                $code = null;
                for ($i = 0; $i < 6; $i++) {
                    $code .= mt_rand(1, 9);
                }
                $is_save = $this->Customer_Model->save(array('temp_code' => $code), $customer->id);
                $is_email_sent = false;
                if ($is_save) {
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
                    /// $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
                    $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
                    $this->email->to(trim($email));
                    $this->email->subject(get_company_name() . ' Account password recovery code');
                    $this->data['code'] = $code;
                    $body = $this->load->view('email_template/password_recovery', $this->data, true);
                    $this->email->message($body);
                    try {
                        $is_email_sent = $this->email->send();
                    } catch (Exception $ex) {
                    }
                }

                if ($is_email_sent) {
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Email has been sent',
                        'email' => $email,
                        'is_email_sent' =>true
                    );
                } else {
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Email did not sent',
                        'email' => $email,
                        'is_email_sent' => false
                    );
                }

                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Email not send because account not found',
                    'email' => $email,
                    'is_email_sent' => false
                );
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    private function send_mail($code) {
        $customer_email =$this->session->userdata('password_recovery_email');
        $this->session->unset_userdata('password_recovery_email');
        //$is_valid_email = valid_email($customer_email);
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
        /// $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to(trim($customer_email));
        $this->email->subject(get_company_name() . ' Account password recovery code');
        $this->data['code'] = $code;
        $body = $this->load->view('email_template/password_recovery', $this->data, true);
        $this->email->message($body);
        return $this->email->send();
    }

    public function get_account_details() {
        if ($this->input->server('REQUEST_METHOD') =='POST' || $this->input->server('REQUEST_METHOD') =='OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $is_registered = false;
            $message = '';
            $customer = $m_customer->getCustomerByApiAuth($data);
            $data = array();

            if (empty($customer)) {
                $response_data = array(
                    'status' => 200,
                    'message' => 'Account details not found because account is not exist',
                    'account_info' => null,
                    'orders' => null,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $m_order = new Order_information_Model();
                $m_details = new Order_details_Model();
                $side_dish = new Order_side_dish_Model();
                $m_order->db->order_by('id', 'DESC');
                $order_information_list = $m_order->get_where('customer_id', $customer->id);
                $data_array = array();
                $m_order_deals = new Order_Deals_Model();
                foreach ($order_information_list as $order) {
                    $order_id = $order->id;
                    $order_array = json_decode(json_encode($order), true);
                    $order_details = $m_details->get_by(array('order_id' => $order_id,'order_deals_id' => 0,));
                    $options_with = null;
                    $options_without = null;
                    $order_details_array = array();
                    $sub_total = 0;
                    foreach ($order_details as $order_detail) {
                        $order_detail = json_decode(json_encode($order_detail),true);
                        $sub_total += $order_detail['amount'] - $order_detail['buy_get_amount'];
                        $options = $side_dish->getSideDishOptions($order_detail['id']);
                        $order_detail['options'] = $options;
                        array_push($order_details_array,$order_detail);
                    }

                    $order_array['order_details'] = $order_details_array;
                    $dealDetails = $m_order_deals->get_by(array('order_id'=>$order_id));
                    foreach ($dealDetails as $deal) {
                        $sub_total += $deal->quantity * $deal->price;
                    }
                    $order_array['dealDetails'] = $dealDetails ;
                    $order_array['subTotal'] = $sub_total;
                    array_push($data_array, $order_array);
                }

                $response_data = array(
                    'status' => 200,
                    'message' => 'Account details is provided',
                    'account_info' => json_decode(json_encode($customer), true),
                    'orders' => $data_array,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function addCard() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $card_name = get_property_value('card_name',$data);
            $card_number = get_property_value('card_number',$data);
            $customer = '';
            $customer = $m_customer->getCustomerByApiAuth($data);
            $cards = null;
            $message = 'Authentication problem';
            if (!empty($customer)) {
                // Check Card Is number is available
                // Check total Card is less than 3
                $m_card = new Card_Model();
                $cards = $m_card->getAllCardsByCustomerId($customer->id);
                $totalCard = 0;
                if (!empty($cards)) {
                    $totalCard = count($cards);
                }
                $message = '';
                if ($totalCard < 3) {
                    $is_new_card_is_added = false;
                    // add new card
                    if (!empty($card_name) && !empty($card_number)) {
                        $card = $m_card->get_by(array('customer_id'=>$customer->id,'card_number'=>$card_number,),true);
                        if(empty($card)){
                            $is_new_card_is_added = $m_card->save(array(
                                'customer_id' => $customer->id,
                                'card_name' => $card_name,
                                'card_number' => $card_number,
                                'created_at' => get_current_date_time(),
                            ));

                            if ($is_new_card_is_added) {
                                $message = 'card is added successfully';
                            } else {
                                $message = 'card is not added successfully';
                            }
                        } else {
                            $message = 'Card Number is already added by you with name '.$card->card_name;
                        }
                    } else {
                        $message = 'Card Name and Card number can not be empty';
                    }
                } else {
                    $message = 'Already 3 cards is added';
                }
            } else {
                $message = 'Authentication problem';
            }

            $response_data = array('status'=>200,'message'=>$message,'cards'=>$cards);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function editCard() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $customer = $m_customer->getCustomerByApiAuth($data);
            $id = get_property_value('id',$data);
            $card_name = get_property_value('card_name',$data);
            $card_number = get_property_value('card_number',$data);
            $cards = null;
            $message = 'Authentication problem';
            if (!empty($customer)) {
                $m_card = new Card_Model();
                $cards = $m_card->getAllCardsByCustomerId($customer->id);
                $card = $m_card->get($id,true);
                $message = '';
                if (!empty($card)) {
                    $is_new_card_is_updated = false;
                    // update card
                    if (!empty($card_name) && !empty($card_number)) {
                        $card_2 = $m_card->get_by(array(
                            'id!=' => $id,
                            'customer_id' => $customer->id,
                            'card_number' => $card_number
                        ));
                        if (empty($card_2)) {
                            $is_new_card_is_updated = $m_card->save(array(
                                'card_name' => $card_name,
                                'card_number' => $card_number,
                                'updated_at' => get_current_date_time(),
                            ),$card->id);

                            if ($is_new_card_is_updated) {
                                $message = 'card is  updated successfully';
                            } else {
                                $message = 'card is not updated successfully';
                            }
                        } else {
                            $message = 'Card Number is already added by you with name '.$card_2->card_name;
                        }
                    } else {
                        $message = 'Card Name and Card number can not be empty';
                    }
                } else {
                    $message = 'No such card is found';
                }
            } else {
                $message = 'Authentication problem';
            }

            $response_data = array('status'=>200,'message'=>$message,'cards'=>$cards);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function deleteCard() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $customer = $m_customer->getCustomerByApiAuth($data);
            $id = get_property_value('id',$data);
            $cards = null;
            $message = '';
            if (!empty($customer)) {
                // Check Card Is number is available
                // Check total Card is less than 3
                $m_card = new Card_Model();
                $card = $m_card->get($id,true);
                $message = '';
                if (!empty($card)) {
                    $is_card_is_deleted = false;
                    $is_card_is_deleted = $m_card->delete($card->id);
                    if ($is_card_is_deleted) {
                        $message = 'card is  deleted successfully';
                    } else {
                        $message = 'card is not deleted successfully';
                    }
                } else {
                    $message = 'No such card is found';
                }
                $cards = $m_card->getAllCardsByCustomerId($customer->id);
            } else {
                $message = 'Authentication problem';
            }

            $response_data = array('status'=>200,'message'=>$message,'cards'=>$cards);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function getCards() {
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $customer = $m_customer->getCustomerByApiAuth($data);
            $cards = null;
            if (!empty($customer)) {
                // Check Card Is number is available
                // Check total Card is less than 3
                $m_card = new Card_Model();
                $cards = $m_card->getAllCardsByCustomerId($customer->id);
                $message = 'Cards Data is provided';
            } else {
                $message = 'Authentication problem';
            }

            $response_data = array('status'=>200,'message'=>$message,'cards'=>$cards,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function fbLogin() {
        if ($this->input->server('REQUEST_METHOD') =='POST' || $this->input->server('REQUEST_METHOD') =='OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = get_property_value('email',$data);;
            $accessToken = get_property_value('access_token',$data);
            $customer = $m_customer->get_by(array('email'=>$email),true);
            // check authorization with response accessToken with facebook Api
            if (empty($customer)) {
                // register as new
                $first_name = get_property_value('first_name',$data);;
                $last_name = get_property_value('last_name',$data);
                $auto_password = time().$email;
                $password_sha1 = sha1($auto_password);
                $title = '';
                $postcode = '';
                $mobile = '';
                $is_registered = $m_customer->save(array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $password_sha1,
                    'title' => $title,
                    'delivery_postcode' => $postcode,
                    'delivery_postcode' => $postcode,
                    'billing_postcode' => $postcode,
                    'mobile' => $mobile,
                    'access_token' => $accessToken,
                ));
                if ($is_registered) {
                    $customer = $m_customer->get_by(array('email'=>$email,'access_token'=>$accessToken),true);
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Logged in successfully',
                        'data' => json_decode(json_encode($customer),true),
                        'is_logged_in' => true,
                    );
                } else {
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Login  is not successful',
                        'data' => '',
                        'is_logged_in' => false,
                    );
                }
            } else {
                $is_registered = $m_customer->save(array('access_token'=>$accessToken,),$customer->id);
                // just login and return user details
                $customer = $m_customer->get_by(array('email'=>$email,'access_token'=>$accessToken),true);
                $response_data = array(
                    'status' => 200,
                    'message' => 'Logged in successfully',
                    'data' => json_decode(json_encode($customer),true),
                    'is_logged_in' => true,
                );
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    public function gmailLogin(){
        if ($this->input->server('REQUEST_METHOD') == 'POST' || $this->input->server('REQUEST_METHOD') == 'OPTIONS'){
            $m_customer = new Customer_Model();
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            $email = get_property_value('email',$data);
            $accessToken = get_property_value('accessToken',$data);
            // check authorization with response accessToken from goggle Api
            $customer = $m_customer->get_by(array('email'=>$email),true);
            if (empty($customer)) {
                // register as new
                $name = get_property_value('displayName',$data);
                $name_array = explode(' ',$name);
                $first_name = '';
                $last_name = '';
                if (!empty($name_array)) {
                    if (count($name_array) == 3) {
                        $first_name = $name_array[1];
                        $last_name = $name_array[2];
                    } else {
                        $first_name = $name_array[0];
                        $last_name = $name_array[1];
                    }
                }
                $auto_password = time().$email;
                $password_sha1 = sha1($auto_password);
                $title = '';
                $postcode = '';
                $mobile = '';
                $is_registered = $m_customer->save(array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $password_sha1,
                    'title' => $title,
                    'delivery_postcode' => $postcode,
                    'delivery_postcode' => $postcode,
                    'billing_postcode' => $postcode,
                    'mobile' => $mobile,
                    'access_token' => $accessToken
                ));
                if ($is_registered) {
                    $customer = $m_customer->get_by(array('email'=>$email),true);
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Logged in successfully',
                        'data' => json_decode(json_encode($customer),true),
                        'is_logged_in' => true,
                    );
                } else {
                    $response_data = array(
                        'status' => 200,
                        'message' => 'Login  is not successful',
                        'data' => '',
                        'is_logged_in' => false,
                    );
                }
            } else {
                $is_registered = $m_customer->save(array('access_token'=>$accessToken),$customer->id);
                $customer = $m_customer->get_by(array('email'=>$email,'access_token'=>$accessToken),true);
                // just login and return user details
                $response_data = array(
                    'status' => 200,
                    'message'=>'Logged in successfully',
                    'data' => json_decode(json_encode($customer),true),
                    'is_logged_in' => true,
                );
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    public function get_top_customer_lists() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $authorization = trim($this->input->get_request_header('Authorization'));
            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);

            if ($authKeyEncode == $authorization) {
                $pending_order = array();
                $pending_order_array = array();

                $request_body = file_get_contents('php://input');
                $data = (!empty($request_body)) ? json_decode($request_body) : null;
                $number_of_customers = get_property_value('number_of_customers',$data);
                $end_date = date("Y-m-d");
                $start_date = date("Y-m-d", strtotime("-30 days",strtotime($end_date)));
                // dd($end_date);

                $top_customer_list = $this->Order_information_Model->get_top_customer_info($number_of_customers,$start_date,$end_date);

                if (!empty($top_customer_list)) {
                    $message = count($top_customer_list) .' customer details is given';
                } else {
                    $message = 'Customer Not Found';
                }
                
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'customerLists' => $top_customer_list,
                );
            } else {
                $response_data = array(
                    'status' => 401,
                    'message' => 'Unauthorized',
                    'customerLists' => array(),
                );
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }
}