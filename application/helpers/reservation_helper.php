<?php

function send_reservation_mail($email=null,$message=null) {
    $CI = &get_instance();
    $config = Array(
        'protocol' => 'smtp',
        'mailpath' => 'ssl://' . trim(get_smtp_host_url()),
        'smtp_host' => 'ssl://' . trim(get_smtp_host_url()),
        'smtp_port' => 465,
        'smtp_user' => trim(get_smtp_host_user()), // change it to yours
        'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
        'mailtype' => 'html',
    );
    $CI->load->library('email');
    $CI->email->initialize($config);
    $from_email = get_company_contact_email(); //"test@gmail.com";
    $subject = 'Reservation Notification Email';
    if (!empty($email) || !empty($message)) {
        //Load email library
        $CI->email->from($from_email, get_company_name());
        $CI->email->to($email);
        $CI->email->subject($subject);
        $CI->email->message($message);
        //Send mail
        if ($CI->email->send()) {
            //echo 'success';
            //$CI->session->set_flashdata("email_sent", "Email sent successfully.");
        } else {
            //echo 'fail';
        }
     }
}

function send_reservation_status_mail($booking_info) {
    $these = &get_instance();
    if ($booking_info) {
        $customer_email = $booking_info->email;
        $status = $booking_info->booking_status;
        $message_body = '';
        if ($status == 'accept') {
            $status = 'accepted';
            $message_body = get_booking_accepted_message();
            if ($message_body) {
                $message_body = str_replace('(businessName)', get_company_name(), $message_body);
                $message_body = str_replace('(amountOfPeople)', $booking_info->NumberOfGuest, $message_body);
            }
        } else if ($status == 'reject') {
            $status = 'rejected';
            $message_body = get_booking_rejected_message();
            if ($message_body) {
                $message_body = str_replace('(contactNumber)', get_company_contact_number(), $message_body);
            }
        }

        if ($message_body) {
            $day_name = date('l',strtotime($booking_info->BookingTime));
            $date = date('jS F Y',strtotime($booking_info->BookingTime));
            $message_body = str_replace('(dayName)', $day_name, $message_body);
            $message_body = str_replace('(date)', $date, $message_body);
            $message_body = str_replace('(time)', $booking_info->StartTime, $message_body);
        } else {
            $message_body = 'hi, </br></br><p>Your Booking has been '.$status.' by '.get_company_name().'.</p></br></br><p>If you have any questions about your booking, call us on '.get_company_contact_number().'.</p></br></br>Many Thanks.';
        }

        $config = Array(
            'protocol' => 'smtp',
            'mailpath' => 'ssl://'.trim(get_smtp_host_url()),
            'smtp_host' => 'ssl://'.trim(get_smtp_host_url()),
            'smtp_port' => 465,
            'smtp_user' => trim(get_smtp_host_user()), // change it to yours
            'smtp_pass' => trim(get_smtp_host_user_password()), // change it to yours
            'mailtype' => 'html',
        );
        $these->load->library('email');
        $these->email->initialize($config);
        $these->email->from(trim(get_smtp_host_user()), get_smtp_mail_form_title());
        $these->email->to($customer_email);
        $these->email->bcc(get_company_contact_email());

        $these->email->subject('Booking has been '.$status.' by '.get_company_name());
        
        $these->email->message($message_body);
        $these->email->send();
    }
}