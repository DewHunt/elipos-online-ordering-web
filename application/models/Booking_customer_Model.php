<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_customer_Model extends Ex_Model {

    protected $table_name = 'booking_customer';
    protected $primary_key = 'BookingId';
    public $where_column='BookingId';

    public function __construct() {
        parent::__construct();
    }

    public $reservation_rules = array(
        'name' => array(
            'field' => 'name',
            'label' => 'Full Name',
            'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'regex_match' => '%s contains letters, numbers and space only'
            ),
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required|max_length[11]|min_length[11]|regex_match[/^[0-9]+$/]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'min_length' => '%s must be at least 11 digit long',
                'max_length' => '%s must be 11 digit long',
                'regex_match' => '%s contains numbers only'
            ),
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'reservation_date' => array(
            'field' => 'reservation_date',
            'label' => 'Date',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'number_of_guest' => array(
            'field' => 'number_of_guest',
            'label' => 'No. Of People',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'booking_purpose' => array(
            'field' => 'booking_purpose',
            'label' => 'Notes',
            'rules' => 'trim|regex_match[/^[a-zA-Z0-9\s]+$/]',
            'errors' => array(
                'regex_match' => '%s contains letters, numbers and space only'
            ),
        )
    );

    public function get_booking_list_by_date($date) {
        $query = $this->db->get_where($this->table_name, array('DATE(BookingTime)' => $date));
        return $query->result();
    }

    public function get_recent_pending_booking_customer() {
        $current_date = date('Y-m-d');
        $result = $this->db->query("SELECT * FROM `booking_customer` WHERE DATE_FORMAT(`BookingTime`,'%Y-%m-%d') >= '$current_date' AND `booking_status`= 'pending'")->result();
        return $result;
    }

    public function get_booking($start_date,$end_date,$status) {
        $where_query = "";
        if ($start_date && $end_date) {
            $where_query .= "WHERE DATE_FORMAT(`BookingTime`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($status) {
            $where_query .= " AND `booking_status` = '$status'";
        }

        $result = $this->db->query("SELECT * FROM `booking_customer` $where_query")->result();
        return $result;
    }

    public function get_booking_by_id($booking_id = 0) {
        $result = $this->db->query("SELECT * FROM `booking_customer` WHERE `BookingId` = $booking_id")->row();
        return $result;
    }

    public function get_booking_list_by_date_and_table($date, $table_number) {
        $query = $this->db->query("SELECT * FROM booking_customer WHERE BookingTime = '$date' AND TableNumber = '$table_number'");
        return $query->result();
    }

    public function get_booking_list_by_date_and_table_for_update_check($booking_id, $date, $table_number) {
        $query = $this->db->query("SELECT * FROM booking_customer WHERE BookingTime = '$date' AND TableNumber = '$table_number' AND BookingId != '$booking_id'");
        return $query->result();
    }

    public function api_send_mail($email,$message) {
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

        $this->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $this->email->to($email);
        $this->email->cc(get_company_contact_email());
        $subject = 'Reservation Notification';
        $this->email->subject($subject);
        $this->email->message($message);
        $is_sent = false;
        try {
            //check if
            $is_sent = $this->email->send();
        } catch (Exception $e) {

        }
        return $is_sent;
    }
}
