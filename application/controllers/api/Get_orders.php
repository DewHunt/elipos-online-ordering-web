<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Get_orders extends Api_Controller {
    public function __construct() {
        parent:: __construct();

        $this->load->model('Customer_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Showsidedish_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->library('product');
        $this->load->helper('settings');
        $this->load->helper('security');
        $this->load->helper('shop');
        $this->load->helper('order');
        $this->load->helper('product');
    }

    public function index() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $authorization = trim($this->input->get_request_header('Authorization'));
            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);

            if ($authKeyEncode == $authorization) {
                $pending_order = array();
                $pending_order_array = array();
                $m_new_order = new New_order_Model();
                $all_new_orders = $m_new_order->get();
                $m_order_information = new Order_information_Model();
                $m_order_information->db->order_by('order_time','DESC');

                $request_body = file_get_contents('php://input');
                $data = (!empty($request_body)) ? json_decode($request_body) : null;
                $order_time_back = intval(get_property_value('order_time_back',$data));
                $conditions = array();
                if ($order_time_back > 0) {
                    $order_time_back = $order_time_back*-1;
                    $now = date("Y-m-d H:i:s");
                    $order_time = date("Y-m-d H:i:s", strtotime("$order_time_back hours", strtotime($now)));
                    $conditions = array('order_status'=>'pending','order_time>'=>$order_time,);
                } else {
                    $conditions = array('order_status'=>'pending');
                }

                $pending_order_information_list = $m_order_information->get_by($conditions);

                if (!empty($pending_order_information_list)) {
                    $message = count($pending_order_information_list) .' pending order details is given';
                    foreach ($pending_order_information_list as $new_order) {
                        $pending_order['order_id'] = $new_order->id;
                        $order_info = $this->Order_information_Model->get($new_order->id, true);
                        $orderDeals = array();
                        if ($this->db->table_exists('order_deals')) {
                            $this->load->model('Order_Deals_Model');
                            $m_order_deals = new Order_Deals_Model();
                            $orderDeals = $m_order_deals->getDealsByOrderId($new_order->id);
                        }

                        $customer_id = (!empty($order_info)) ? $order_info->customer_id : 0;
                        $customer = $this->Customer_Model->get($customer_id, true);
                        $customer = (!empty($customer)) ? (array)$customer : array();
                        if (!empty($order_info)) {
                            if ($order_info->payment_method != 'cash') {
                                $order_info->payment_method = 'card';
                            }
                        }

                        $pending_order['order_information'] = (!empty($order_info)) ? (array)$order_info : array();
                        $pending_order['customer_information'] = $customer;
                        $pending_order['order_details'] = $this->get_details_by_order_id($new_order->id);
                        $pending_order['deals'] = $orderDeals;
                        array_push($pending_order_array, $pending_order);
                    }
                } else {
                    $message = 'No pending order is found';
                }
                
                $response_data = array(
                    'status'=>200,
                    'message'=>$message,
                    'orders'=>$pending_order_array,
                    'newOrders'=>$all_new_orders,
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data=array(
                    'status'=>401,
                    'message'=>'Unauthorized',
                    'orders'=>array(),
                    'newOrders'=>array(),
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function get_all_orders_by_order_status() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $authorization = trim($this->input->get_request_header('Authorization'));
            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);

            if ($authKeyEncode == $authorization) {
                $pending_order = array();
                $pending_order_array = array();
                $all_new_orders = $this->New_order_Model->get();

                $request_body = file_get_contents('php://input');
                $data = (!empty($request_body)) ? json_decode($request_body) : null;
                $order_time_back = intval(get_property_value('order_time_back',$data));
                $order_status = get_property_value('order_status',$data);
                // dd($order_status);
                $order_time = '';
                $start_date = '';
                $end_date = '';

                if ($order_status == 'all') {
                    $end_date = date("Y-m-d");
                    $start_date = date("Y-m-d", strtotime("-30 days", strtotime($end_date)));
                } else {
                    if ($order_time_back > 0) {
                        $order_time_back = $order_time_back * -1;
                        $now = date("Y-m-d H:i:s");
                        $order_time = date("Y-m-d H:i:s", strtotime("$order_time_back hours", strtotime($now)));
                    }
                }

                $pending_order_information_list = $this->Order_information_Model->get_orders_info_by_date_and_order_status($order_status,$order_time,$start_date,$end_date);

                if (!empty($pending_order_information_list)) {
                    $message = count($pending_order_information_list) .' order details is given';
                    foreach ($pending_order_information_list as $order_info) {
                        $pending_order['order_id'] = $order_info->id;
                        // $order_info = $this->Order_information_Model->get($new_order->id, true);
                        $orderDeals = array();
                        if ($this->db->table_exists('order_deals')) {
                            $orderDeals = $this->Order_Deals_Model->getDealsByOrderId($order_info->id);
                        }

                        $customer_id = (!empty($order_info)) ? $order_info->customer_id : 0;
                        $customer = $this->Customer_Model->get_customer_info_by_id($customer_id);
                        $customer = (!empty($customer)) ? (array)$customer : array();
                        if (!empty($order_info)) {
                            if ($order_info->payment_method != 'cash') {
                                $order_info->payment_method = 'card';
                            }
                        }

                        $pending_order['order_information'] = (!empty($order_info)) ? (array)$order_info : array();
                        $pending_order['customer_information'] = $customer;
                        $pending_order['order_details'] = $this->get_details_by_order_id($order_info->id);
                        $pending_order['deals'] = $orderDeals;
                        array_push($pending_order_array, $pending_order);
                    }
                } else {
                    $message = 'No pending order is found';
                }
                
                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'orders' => $pending_order_array,
                    'newOrders' => $all_new_orders,
                );
            } else {
                $response_data=array(
                    'status' => 401,
                    'message' => 'Unauthorized',
                    'orders' => array(),
                    'newOrders' => array(),
                );
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
    }

    private function get_details_by_order_id($id = 0) {
        $count = 0;
        $side_dish_total_price = 0;
        $order_details_array = array();
        $order_information = $this->Order_information_Model->get($id, true);
        if (!empty($order_information)) {
            $order_details = $this->Order_details_Model->get_by(array(
                'order_id' => $order_information->id,
                'order_deals_id' => 0,
            ));
            if (!empty($order_details)) {
                foreach ($order_details as $detail) {
                    $detail = (array)$detail;
                    $side_dish = $this->Order_side_dish_Model->get_all_by_order_details_id($detail['id']);
                    $detail['side_dish'] = (!empty($side_dish)) ? json_decode(json_encode($side_dish),true) : array();
                    array_push($order_details_array, $detail);
                }
            }
        }
        return $order_details_array;
    }

    public function set_as_new_order() {
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $authorization = $this->input->get_request_header('Authorization');

            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);
            if ($authKeyEncode == $authorization) {
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body);
                $orderId = get_property_value('order_id',$data);
                $order_information = $this->Order_information_Model->get_by(array('id'=>intval($orderId)),true);
                $new_order = null;
                $is_update = false;
                $message = 'Order is not updated as new order';
                if (!empty($order_information)) {
                    if ($order_information->order_status == 'pending') {
                        $new_order = $this->New_order_Model->get_by(array('order_id'=>intval($orderId)),true);
                        if (empty($new_order)) {
                            $is_update = $this->New_order_Model->save(array('order_id'=>$orderId));
                            if ($is_update) {
                                $message = 'Order is  updated as new order';
                            } else {
                                $message = 'Order is not updated as new order';
                            }
                        } else {
                            $message = 'Order already in new order';
                        }
                    } else {
                        $message = 'Only pending order can set as new order';
                    }
                } else {
                    $message = 'Order information is not found';
                }

                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_update' => $is_update,
                    'order' => $order_information,
                    'orderId' => $orderId,
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array('status' => 401,'message' => 'Unauthorized','is_update' => false,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request','is_update' => false,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    public function set_order_status() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $authorization = $this->input->get_request_header('Authorization');
            $auth_key_settings = $this->Settings_Model->get_by(array("name" => 'auth_key'), true);
            $auth_key = (!empty($auth_key_settings)) ? trim($auth_key_settings->value) : '';
            $authKeyEncode = base64_encode($auth_key);
            if ($authKeyEncode == $authorization) {
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body);
                $orderId = get_property_value('order_id',$data);
                $order_message = get_property_value('message',$data);
                $order_status = get_property_value('status',$data);
                $time = get_property_value('time',$data);
                $isSendMail = intval(get_property_value('isSendMail',$data));
                $order_information = $this->Order_information_Model->get_by(array('id'=>intval($orderId)),true);
                $new_order = null;
                $is_update = false;
                $message = 'Order status is not updated';

                if (!empty($order_information)) {
                    if ($order_information->order_status == 'pending') {
                        if ($order_status == 'accept' || $order_status == 'reject') {
                            $today_date = date("Y-m-d");
                            $delivery_time = $order_information->delivery_time;
                            $delivery_time = strtotime($delivery_time);
                            $new_delivery_time = '0000-00-00 00:00:00';
                            $update_data = array();
                            if (!empty($time)) {
                                if ($delivery_time > 0) {
                                    $delivery_date = get_formatted_time($order_information->delivery_time,'Y-m-d');
                                    $new_delivery_time = get_formatted_time($delivery_date.' '.$time,'Y-m-d H:i:s');
                                } else {
                                    $new_delivery_time = get_formatted_time($today_date.' '.$time,'Y-m-d H:i:s');
                                }
                            } else {
                                $new_delivery_time = $order_information->delivery_time;
                            }

                            if($order_status == 'accept') {
                                $update_data['delivery_time'] = $new_delivery_time;
                            }

                            $update_data['order_status'] = $order_status;
                            $time = (empty(strtotime($new_delivery_time))) ? get_formatted_time($new_delivery_time,'Y-m-d h:i:s a') : 'ASAP';
                            $update_data['order_comments'] = $order_message;
                            $update_data['order_time'] = $order_information->order_time;
                            // update order status
                            $is_update = $this->Order_information_Model->save($update_data,$orderId);
                        } else {
                            $message = 'Unknown order status '.$order_status;
                        }

                        if ($is_update) {
                            $message = 'Order status is updated to '.$order_status;
                            $m_customer = new Customer_Model();
                            $customer = $m_customer->get($order_information->customer_id,true);
                            if (!empty($customer)) {
                                $customer_email = $customer->email;
                                $customer_name = get_customer_full_name($customer);
                                $order_type = $order_information->order_type;
                                $online_order_id = $order_information->id;
                                if (intval($isSendMail) > 0) {
                                    if ($order_status == 'accept') {
                                        $this->send_mail('Accepted',$online_order_id,$order_type,$time,$customer_email,$order_message);
                                    } else {
                                        $this->reject_mail($customer_name,$customer_email,$order_message);
                                    }
                                }
                            }

                            $new_order = $this->New_order_Model->get_by(array('order_id'=>intval($orderId)),true);

                            if (!empty($new_order)) {
                                // delete new order
                                $this->New_order_Model->delete($new_order->id);
                            }
                        }
                    } else {
                        $message = 'Only pending order status is changeable';
                    }
                } else {
                    $message = 'Order information is not found';
                }

                $response_data = array(
                    'status' => 200,
                    'message' => $message,
                    'is_update' => $is_update,
                    'order' => $order_information,
                    'orderId' => $orderId,
                    'isSendMail' => $isSendMail
                );

                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            } else {
                $response_data = array('status'=>401,'message'=>'Unauthorized','is_update'=>false,);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status' => 400,'message' => 'Bad request','is_update' => false,);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    private function reject_mail($customer_name='',$customer_email='',$reject_cause='') {
        $config = array(
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
        // $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to($customer_email);
        $this->email->bcc(get_company_contact_email());
        $this->email->subject('Order has been rejected by '.get_company_name());
        $body = $this->load->view('email_template/order_rejected',array(
            'customer_name'=>$customer_name,
            'reject_cause'=>$reject_cause,
        ),true);
        $this->email->message($body);
        return $this->email->send();
    }

    private function send_mail($accept_reject_message='',$order_id=0,$order_type='',$time='',$customer_email='',$message='') {
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
        // $this->email->reply_to(trim(get_company_contact_email()), get_smtp_mail_form_title());
        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to($customer_email);
        $this->email->bcc(get_company_contact_email());
        $this->email->subject('Order has been '.$accept_reject_message.' by '.get_company_name());
        $body = $this->Order_information_Model->get_order_email_template($order_id,$time);
        $this->email->message($body);
        return $this->email->send();
    }
}