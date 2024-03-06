<?php

class Order_send_to_desktop extends Frontend_Controller
{
    public $product;

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Customer_Model');
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('Booking_customer_Model');
        $this->product = new Product();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->helper(array('form'));
        $this->load->helper(array('reservation'));
    }

    public function index() {
        // do smoething
    }

    public function get_new_order() {
        $m_order_deals = new Order_Deals_Model();
        $new_order_information_list = $this->db->query("SELECT * FROM `new_order`;")->result();
        $all_new_order = array();
        $all_new_order_array = array();
        if (!empty($new_order_information_list)) {
            foreach ($new_order_information_list as $new_order) {
                $all_new_order['order_id'] = $new_order->order_id;
                $order_info = $this->Order_information_Model->get($new_order->order_id, true);
                $orderDeals = $m_order_deals->getDealsByOrderId($new_order->order_id);
                $customer_id = (!empty($order_info)) ? $order_info->customer_id : 0;
                $customer = $this->Customer_Model->get($customer_id, true);
                $customer = (!empty($customer)) ? (array)$customer : array();
                if(!empty($order_info)){
                    if($order_info->payment_method != 'cash'){
                        $order_info->payment_method = 'card';
                    }
                }

                $all_new_order['order_information'] = (!empty($order_info)) ? (array)$order_info : array();
                $all_new_order['customer_information'] = $customer;
                $all_new_order['order_details'] = $this->get_details_by_order_id($new_order->order_id);
                $all_new_order['deals'] = $orderDeals;

                array_push($all_new_order_array, $all_new_order);
            }
        }

        $data = json_encode($all_new_order_array);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function delete_saved_order() {
        $message = $this->input->post('message');
        if (!empty($message)) {
            $data = json_decode($message);
            $save_message = $data->message; //saved successfully
            $order_id = $data->id;  //online order id
            if (!empty($order_id)) {
                $this->delete_new_order($order_id);
                $this->output->set_content_type('application/json')->set_output('deleted id '. $order_id);
            }
        }
    }

    private function delete_new_order($order_id) {
        $this->db->query("DELETE FROM new_order WHERE order_id = $order_id");
    }

    public function accept_reject_message() {  
        // dd($this->input->post('data'));    
        if (!empty($this->input->post('data'))) {
            $data = $this->input->post('data');
            $result = json_decode($data);
            $accept_reject_message = $result->data; //accept or reject
            $online_order_id = $result->id;
            $time = $result->time;
            $message = $result->message;
            $m_customer = new Customer_Model();
            $save = array('order_status' => $accept_reject_message,);

            if (!empty($online_order_id)) {
                $order = $this->Order_information_Model->get($online_order_id,true);
                if (!empty($order)) {
                    $a_r_message = '';
                    $today_date = date("Y-m-d");
                    $delivery_time = $order->delivery_time;
                    $delivery_time = strtotime($delivery_time);
                    $new_delivery_time = '0000-00-00 00:00:00';
                    if (!empty($time)) {
                        if ($delivery_time > 0) {
                            $delivery_date = get_formatted_time($order->delivery_time,'Y-m-d');
                            $new_delivery_time = get_formatted_time($delivery_date.' '.$time,'Y-m-d H:i:s');
                        } else {
                            $new_delivery_time = get_formatted_time($today_date.' '.$time,'Y-m-d H:i:s');
                        }
                    } else {
                        $new_delivery_time = $order->delivery_time;
                    }

                    if ($accept_reject_message == 'accept') {
                        $save['delivery_time'] = $new_delivery_time;
                        $a_r_message = 'accepted';
                    } else {
                        $a_r_message = 'rejected';
                    }

                    $time = (empty(strtotime($new_delivery_time))) ? get_formatted_time($new_delivery_time,'Y-m-d h:i:s a') : 'ASAP';

                    $save['order_comments'] = $message;
                    $save['order_time'] = $order->order_time;
                    $res = $this->Order_information_Model->save($save, $online_order_id);
                    if ($res) {
                        $this->delete_new_order($online_order_id);
                        $customer = $m_customer->get($order->customer_id,true);
                        if (!empty($customer)) {
                            $customer_email = $customer->email;
                            $customer_name = get_customer_full_name($customer);
                            $order_type = $order->order_type;
                            if ($accept_reject_message == 'accept') {
                                $this->send_mail($a_r_message,$online_order_id,$order_type,$time,$customer_email,$message);
                            } else {
                                $this->reject_mail($customer_name,$customer_email,$message);
                            }
                        }
                        $this->output->set_content_type('application/json')->set_output($a_r_message);
                    } else {
                        $this->output->set_content_type('application/json')->set_output($a_r_message);
                    }
                } else {
                    $this->output->set_content_type('application/json')->set_output('No such order exist');
                }
            } else {
                $this->output->set_content_type('application/json')->set_output('Online order id missing');
            }
        } else {
            $this->output->set_content_type('application/json')->set_output('Post data empty');
        }
    }

    private function reject_mail($customer_name='',$customer_email='',$reject_cause='') {
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

    private function get_details_by_order_id($id = 0) {
        $count = 0;
        $side_dish_total_price = 0;
        $order_details_array = array();
        $order_information = $this->Order_information_Model->get($id, true);
        if (!empty($order_information)) {
            $order_details = $this->Order_details_Model->getForDesktop(array('order_id'=>$order_information->id,'order_deals_id'=>0,),false);

            if (!empty($order_details)) {
                foreach ($order_details as $detail) {
                    $side_dish = $this->Order_side_dish_Model->get_all_by_order_details_id($detail['id']);
                    $detail['side_dish'] = (!empty($side_dish)) ? json_decode(json_encode($side_dish),true) : array();
                    array_push($order_details_array, $detail);

                }
            }
        }
        return $order_details_array;
    }

    function get_order_status(){
        $message = $this->data->post('message');
        $this->output->set_content_type('application/json')->set_output($message);
    }

    function get_online_order_status() {
        $online_order_status_json = array();
        $result = $this->input->post('online_order_status_json');
        $online_order_status_json = json_decode(result, true);
        $order_info_update = array(
            'order_id' => $online_order_status_json->order_id,
            'order_status' => $online_order_status_json->order_status
        );
        $this->Order_information_Model->where_column = $online_order_status_json->order_id;
        $this->Order_information_Model->save($order_info_update, $online_order_status_json->order_id);
    }

    public function update_reservation_status() {
        // dd($this->input->post());
        $request_body = $this->input->post('data');
        if ($request_body) {
            $result = json_decode($request_body);
            $booking_id = $result->bookingId;
            $booking_status = $result->bookingStatus; //accept or reject
            $message = $result->message;

            if (!empty($booking_id) && intval($booking_id) > 0) {
                $email = null;
                $is_save = false;

                $reservation = $this->Booking_customer_Model->get_booking_by_id($booking_id);

                if ($reservation) {
                    $email = $reservation->email;
                    $data = array('booking_status' => $booking_status,'comments' => $message);
                    $is_save = $this->Booking_customer_Model->save($data,$booking_id);
                }

                if ($is_save) {
                    // $this->send_reservation_mail1($email, $booking_status);
                    $booking_info = $this->Booking_customer_Model->get_booking_by_id($booking_id);
                    send_reservation_status_mail($booking_info);
                    $this->output->set_content_type('application/json')->set_output($booking_status);
                } else {
                    $this->output->set_content_type('application/json')->set_output('Booking status updated failed');
                }
            } else {
                $this->output->set_content_type('application/json')->set_output('Booking id missing');
            }
        } else {
            $this->output->set_content_type('application/json')->set_output('Post data empty');
        }
    }

    function send_reservation_mail1($customer_email = '', $status = '') {
        $config = Array(
            'protocol' => 'smtp',
            'mailpath' => 'ssl://'.trim(get_smtp_host_url()),
            'smtp_host' => 'ssl://'.trim(get_smtp_host_url()),
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

        if ($status == 'accept') {
            $status = 'accepted';
        } else if ($status == 'reject') {
            $status = 'rejected';
        }

        $this->email->subject('Booking has been '.$status.' by '.get_company_name());
        // $body = $this->load->view('email_template/order_rejected',array('customer_name'=>$customer_name,'reject_cause'=>$reject_cause,),true);

        $body = 'hi, </br></br>' . '<p>Your Booking has been '.$status.' by ' . get_company_name().
        '.</p></br></br><p>If you have any questions about your booking, call us on '. get_company_contact_number(). '.</p></br></br>Many Thanks.';
        
        $this->email->message($body);
        $this->email->send();
    }
}