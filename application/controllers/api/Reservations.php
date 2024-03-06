<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations extends Api_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->helper('settings');
        $this->load->library('user_agent');
        $this->load->model('Settings_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Booking_customer_Model');
        $this->load->library('email');
        $this->load->helper('shop');
        $this->load->helper('security');
        $this->load->library('user_agent');
        // $this->load->helper('reservation');
    }

    public function index() {
    }

    public function get_reservations($isRecent = false) {
        if ($isRecent) {
            $reservation = $this->Booking_customer_Model->get_recent_pending_booking_customer();
        } else {
            $reservation = $this->Booking_customer_Model->get_where('booking_status','pending');
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($reservation));
    }

    public function set_reservation_status() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $m_booking = new Booking_customer_Model();
            $request_body = file_get_contents('php://input');
            if (!empty($request_body)) {
                $result = json_decode($request_body);
                $booking_id = $result->bookingId; //accept or reject
                $booking_status = $result->bookingStatus;
                $message = $result->message;
                $save = array('booking_status' => $booking_status,'comments' => $message);
                if (!empty($booking_id)) {
                    $email = null;
                    if(intval($booking_id) > 0){
                        $reservation = $m_booking->get($booking_id);
                        $email = (!empty($reservation)) ? $reservation->email : null;
                    }
                    $is_save = false;
                    if (!empty($reservation)) {
                        $is_save = $m_booking->save($save,$booking_id);
                    }

                    if ($is_save) {
                        $this->output->set_content_type('application/json')->set_output( 'Booking status updated successfully' );
                        send_reservation_mail($email,$message);
                    } else {
                        $this->output->set_content_type('application/json')->set_output( 'Booking status updated failed' );
                    }
                } else {
                    $this->output->set_content_type('application/json')->set_output('Booking id missing' );
                }
            } else {
                $this->output->set_content_type('application/json')->set_output( 'Post data empty' );
            }
        }
    }

    public function check_valid_date($reservation_date = '') {
        // dd($reservation_date);
        $day_id = date('w',strtotime($reservation_date));
        $status = true;
        $is_shop_closed_status = is_shop_closed_status($day_id);
        list($is_booking_closed_status,$message) = is_booking_closed($reservation_date);
        if ($is_shop_closed_status || $is_booking_closed_status) {
            $status = false;
        } else {
            $message = '';
        }

        return [$status,$message];
    }

    public function check_valid_time($reservation_time = '') {
        $message = '';
        $status = is_shop_closed($reservation_time);
        $booking_settings_value = get_settings_values('booking_settings');
        if ($booking_settings_value && $status) {
            $message = $booking_settings_value->message;
        }
        return [!$status,$message];
    }

    public function set() {
        $is_mobile_req = $this->agent->is_mobile();
        if ($this->input->server('REQUEST_METHOD') == 'POST' && $is_mobile_req == true) {
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body);
            if (!empty($data)) {
                $reservation_date = get_property_value('reservation_date',$data);
                $start_time = get_property_value('start_time',$data);
                $start_time_string = get_formatted_time($start_time,'h:i:s A');
                list($is_reservation_date_valid,$is_reservation_date_invalid_message) = $this->check_valid_date($reservation_date);
                list($is_reservation_time_valid,$is_reservation_time_invalid_message) = $this->check_valid_time($start_time);
                if (!$is_reservation_date_valid || !$is_reservation_time_valid) {
                    if (!$is_reservation_date_valid) {
                        $message = $is_reservation_date_invalid_message;
                    } else if(!$is_reservation_time_valid) {
                        $message = $is_reservation_time_invalid_message;
                    }
                    $response_data = array('status'=>200,'is_reservation_success'=>false,'message'=>$message);
                    $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                } else {
                    $title = get_property_value('title',$data);
                    $name = get_property_value('name',$data);
                    $phone = get_property_value('phone',$data);
                    $mobile = get_property_value('mobile',$data);
                    $postcode = get_property_value('postcode',$data);
                    $email = get_property_value('email',$data);
                    $transaction_id = get_property_value('transactionId',$data);
                    $amount = get_property_value('amount',$data);

                    $address = get_property_value('address',$data);
                    $booking_purpose = get_property_value('booking_purpose',$data);
                    $table_number = get_property_value('table_number',$data);
                    $number_of_guest = get_property_value('number_of_guest',$data);

                    $payment_method = get_property_value('payment_method',$data);

                    $data_for_customer = array(
                        'title' => $title,
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'mobile' => $mobile,
                        'address' => $address,
                        'billing_postcode' => $postcode,
                    );
                    $customer = $this->Customer_Model->get_customer_by_phone_mobile_email($data_for_customer['phone'], $data_for_customer['mobile'], $data_for_customer['email']);
                    $customer_id = !empty($customer) ? $customer->id : 0;
                    $name = (!empty($title)) ? $title.'. '.$name : $name;
                    $form_data = array(
                        'transaction_id' => $transaction_id,
                        'amount' => $amount,
                        'CustomerName' => $name,
                        'email' => $email,
                        'mobile' => $mobile,
                        'CustomerPhone' => $phone,
                        'address'=>$address,
                        'postcode'=>$postcode,
                        'NumberOfGuest' => $number_of_guest,
                        'TableNumber' => $table_number,
                        'CustomerDetails' => $address,
                        'BookingTime' => $reservation_date,
                        'ExpireTime' => '',
                        'StartTime' =>$start_time_string,
                        'EndTime' => '',
                        'CustomerId' => $customer_id,
                        'BookingPurpose' => $booking_purpose,
                        'TempOrderInformationId' => 0,
                        'booking_status' => 'pending',
                    );
                    $result = $this->Booking_customer_Model->save($form_data);
                    $reservation_id = $this->Booking_customer_Model->db->insert_id();
                    if ($reservation_id > 0 && $payment_method != '' && $transaction_id != '') {
                        if ($payment_method == 'sagepay') {
                            $this->db->delete('sagepay_transaction',array('transaction_id'=>$transaction_id));
                        } else if ($payment_method == 'cardstream') {
                            $this->db->delete('cardstream_transaction',array('transaction_id'=>$transaction_id));
                        }                    
                    }
                    $shopName = get_company_name();
                    $response_data = array(
                        'status'=>200,
                        'is_reservation_success'=>$result,
                        'message'=>$this->load->view('api/template/reservation', array('shopName'=>$shopName),true)
                    );

                    if ($result) {
                        $booking = $this->Booking_customer_Model->get($reservation_id);
                        $this->data['booking'] = $booking;
                        $message = $this->load->view('email_template/reservation',$this->data,true);
                        $this->Booking_customer_Model->api_send_mail($email,$message);
                    }
                    $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
                }
            } else {
                $response_data = array('status'=>200,'is_reservation_success'=>false,'message'=>'',);
                $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
            }
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }
}