<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_customer extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Allowed_postcodes_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Booking_customer_Model');
        $this->load->helper('shop');
        $this->load->helper('reservation');
    }

    public function index() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $current_date = date('Y-m-d');
        $this->page_content_data['allowed_postcodes_list'] = $this->Allowed_postcodes_Model->get();
        $this->page_content_data['booking_customer_list'] = $this->Booking_customer_Model->get();
        $this->page_content_data['booking_list_by_date'] = $this->Booking_customer_Model->get_booking($current_date,$current_date,'');

        $this->page_content = $this->load->view('admin/booking/daywise_booking_report',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/booking/daywise_booking_report_js','',true);

        $this->data['title'] = "Booking";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function add() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $this->page_content = $this->load->view('admin/booking/add_booking','',true);
        $this->custom_js = $this->load->view('admin/booking/add_booking_js','',true);

        $this->data['title'] = "Add Booking";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function save() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $title = trim($this->input->post('title'));
        $name = trim($this->input->post('name'));
        $name=(!empty($title))?$title.' '.$name:$name;
        $phone = trim($this->input->post('phone'));
        $mobile = trim($this->input->post('mobile'));
        $postcode = trim($this->input->post('postcode'));
        $email = trim($this->input->post('email'));
        $birth_month = trim($this->input->post('birth_month'));
        $birth_day = trim($this->input->post('birth_day'));
        $date_of_birth = (!empty($birth_month) ? $birth_month : '').' '.(!empty($birth_day < 10) ? '0'.$birth_day : $birth_day);
        $address = trim($this->input->post('address'));
        $booking_purpose = trim($this->input->post('booking_purpose'));
        $table_number = trim($this->input->post('table_number'));
        $reservation_date = trim($this->input->post('reservation_date'));

        $reservation_date = get_formatted_date($reservation_date,'Y-m-d');
        $start_time_hr = trim($this->input->post('start_time_hr'));
        $start_time_min = trim($this->input->post('start_time_min'));
        $start_time_am_pm = trim($this->input->post('start_time_am_pm'));
        $end_time_hr = trim($this->input->post('end_time_hr'));
        $end_time_min = trim($this->input->post('end_time_min'));
        $end_time_am_pm = trim($this->input->post('end_time_am_pm'));
        $number_of_guest = trim($this->input->post('number_of_guest'));
        $start_time = (((int) $start_time_hr < 10) ? '0' . $start_time_hr : $start_time_hr ) . ':' . $start_time_min . ':' . '00 ' . $start_time_am_pm;
        $end_time = (((int) $end_time_hr < 10) ? '0' . $end_time_hr : $end_time_hr ) . ':' . $end_time_min . ':' . '00 ' . $end_time_am_pm;
        $customer_id = 0;

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('reservation_date', 'Reservation Date', 'required');
        $this->form_validation->set_rules('number_of_guest', 'Number of Guest', 'required');
        $result = false;
        if ($this->form_validation->run() == true) {
            $data_for_customer = array(
                'title' => $title,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'mobile' => $mobile,
                'address' => $address,
                'date_of_birth' => $date_of_birth,
            );

            $m_customer = new Customer_Model();
            $customer_id = 0;
            if($m_customer->customer_is_loggedIn()) {
                $customer_id = $m_customer->get_logged_in_customer_id();
            }
            $form_data = array(
                'CustomerName' => $name,
                'CustomerPhone' => $mobile,
                'NumberOfGuest' => $number_of_guest,
                'email' => $email,
                'mobile' => $mobile,
                'address' => $address,
                'postcode' => $postcode,
                'birth_day' => $birth_day,
                'birth_month' => $birth_month,
                'TableNumber' => $table_number,
                'CustomerDetails' => $address,
                'BookingTime' => $reservation_date,
                'ExpireTime' => '',
                'StartTime' => $start_time,
                'EndTime' => $end_time,
                'CustomerId' => $customer_id,
                'BookingPurpose' => $booking_purpose,
                'TempOrderInformationId' => 0,
                'booking_status' => 'pending',
            );
            $result = $this->Booking_customer_Model->save($form_data);
            $reservation_id = $this->db->insert_id();

            if ($result) {
                $this->data['booking'] = $this->Booking_customer_Model->get($reservation_id,true);
                $message = $this->load->view('email_template/reservation',$this->data,true);
                $this->Booking_customer_Model->api_send_mail($email,$message);;
            }
        }

        if (!$result) {
            set_flash_form_data($this->input->post());
            set_flash_message(validation_errors());
        }
        ($result) ? set_flash_save_message('Booking is saved successfully') : set_flash_save_message('Booking is not save');
        redirect('admin/booking_customer/add_booking');
    }

    public function edit($id = 0) {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $booking = null;
        if (intval($id) > 0) {
            $booking = $this->Booking_customer_Model->get($id);
            if (!empty($booking)) {
                $this->data['customer'] = $this->Customer_Model->get($booking->CustomerId);
            }
        }
        $this->page_content_data['booking'] = $booking;
        $this->page_content = $this->load->view('admin/booking/update_booking',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/booking/update_booking_js','',true);
        $this->data['title'] = "Update Booking";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function update() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = trim($this->input->post('id'));
        $name = trim($this->input->post('name'));
        $phone = trim($this->input->post('phone'));
        $mobile = trim($this->input->post('mobile'));
        $postcode = trim($this->input->post('postcode'));
        $email = trim($this->input->post('email'));
        $birth_month = trim($this->input->post('birth_month'));
        $birth_day = trim($this->input->post('birth_day'));
        $date_of_birth = (!empty($birth_month) ? $birth_month : '') . ' ' . (!empty($birth_day < 10) ? '0' . $birth_day : $birth_day);
        $address = trim($this->input->post('address'));
        $booking_purpose = trim($this->input->post('booking_purpose'));
        $table_number = trim($this->input->post('table_number'));
        $reservation_date = trim($this->input->post('reservation_date'));

        $reservation_date = get_formatted_date($reservation_date,'Y-m-d');
        $start_time_hr = trim($this->input->post('start_time_hr'));
        $start_time_min = trim($this->input->post('start_time_min'));
        $start_time_am_pm = trim($this->input->post('start_time_am_pm'));
        $end_time_hr = trim($this->input->post('end_time_hr'));
        $end_time_min = trim($this->input->post('end_time_min'));
        $end_time_am_pm = trim($this->input->post('end_time_am_pm'));
        $number_of_guest = trim($this->input->post('number_of_guest'));

        $start_time = (((int) $start_time_hr < 10) ? '0'.$start_time_hr : $start_time_hr ).':'.$start_time_min.':'.'00 '.$start_time_am_pm;
        $end_time = (((int) $end_time_hr < 10) ? '0'.$end_time_hr : $end_time_hr ).':'.$end_time_min.':'.'00 '.$end_time_am_pm;
        $customer_id = 0;

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('reservation_date', 'Reservation Date', 'required');
        $this->form_validation->set_rules('number_of_guest', 'Number of Guest', 'required');

        if ($this->form_validation->run() == false) {
            redirect('admin/booking_customer/edit/'.$id);
        } else {
            $customer_id = $this->Customer_Model->get_logged_in_customer_id();

            $form_data = array(
                'CustomerName' => $name,
                'CustomerPhone' => $mobile,
                'NumberOfGuest' => $number_of_guest,
                'email' => $email,
                'mobile' => $mobile,
                'address' => $address,
                'postcode' => $postcode,
                'birth_day' => $birth_day,
                'birth_month' => $birth_month,
                'TableNumber' => $table_number,
                'CustomerDetails' => $address,
                'BookingTime' => $reservation_date,
                'ExpireTime' => '',
                'StartTime' => $start_time,
                'EndTime' => $end_time,
                'CustomerId' => $customer_id,
                'BookingPurpose' => $booking_purpose,
                'TempOrderInformationId' => 0,
                'booking_status' => 'pending',
            );

            $is_update = false;

            if (intval($id) > 0) {
                $is_update = $this->Booking_customer_Model->save($form_data,$id);
            }

            if ($is_update) {
                $this->session->set_flashdata('save_message','Booking is updated successfully');
                redirect('admin/booking_customer');
            } else {
                $this->session->set_flashdata('error_message','Booking is not updated');
                redirect('admin/booking_customer/edit/'.$id);
            }
        }
    }

    public function get_booking() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            // dd($this->input->post());
            $from = $this->input->post('from_date');
            $to = $this->input->post('to_date');
            $status = $this->input->post('status');
            $booking_list_by_date = $this->Booking_customer_Model->get_booking($from,$to,$status);
            $this->data['booking_list_by_date'] = $booking_list_by_date;
            $table_data = $this->load->view('admin/booking/table_data',$this->data,true);
            $this->output->set_content_type('application/json')->set_output(json_encode(array('table_data' => $table_data)));
        }
    }

    public function view() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $booking = $this->input->post('booking');
        $booking = json_decode($booking);
        $booking_id = $this->input->post('booking_id');
        $this->data['booking'] = $this->Booking_customer_Model->get_booking_by_id($booking_id);
        $content = $this->load->view('admin/booking/view',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content)));
    }

    public function delete() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if($this->input->is_ajax_request()){
            if ($this->User_Model->loggedin()) {
                $id = $this->input->post('id');
                $m_booking = new Booking_customer_Model();
                $is_deleted = $m_booking->delete($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(array('is_deleted' => $is_deleted)));
            }
        } else {
            redirect($this->admin);
        }
    }

    public function accept_booking() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $booking_id = $this->input->post('booking_id');

        $data = array('booking_status' => 'accept');
        $this->db->where('BookingId',$booking_id);
        $this->db->update('booking_customer', $data);

        $booking_info = $this->Booking_customer_Model->get_booking_by_id($booking_id);
        send_reservation_status_mail($booking_info);

        $this->data['booking'] = $booking_info;
        $content = $this->load->view('admin/booking/view',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content)));
    }

    public function reject_booking() {
        if (is_user_permitted('admin/booking_customer') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $booking_id = $this->input->post('booking_id');

        $data = array('booking_status' => 'reject');
        $this->db->where('BookingId',$booking_id);
        $this->db->update('booking_customer', $data);

        $booking_info = $this->Booking_customer_Model->get_booking_by_id($booking_id);
        send_reservation_status_mail($booking_info);

        $this->data['booking'] = $booking_info;
        $content = $this->load->view('admin/booking/view',$this->data,true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content)));
    }
}
