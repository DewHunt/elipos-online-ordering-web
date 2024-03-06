<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/phpmailer/load.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load() {
        // Include PHPMailer library files
    }


    public function sendMail($subject='',$body='',$email='',$toName='',$attachmentPath='',$ccEmail='') {
        $mail = new PHPMailer();
        $configDetails = get_smtp_config_details();
        $host = trim(get_property_value('host', $configDetails));
        $user = trim(get_property_value('user', $configDetails));
        $password = trim(get_property_value('password', $configDetails));
        $formTitle = trim(get_property_value('form', $configDetails));
        $contactMail = get_company_contact_email();
        try {
            // Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            $mail->isSMTP();    // Send using SMTP
            $mail->Host = $host;    // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $user;    // SMTP username
            $mail->Password = $password;    // SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587;  // TCP port to connect to
            $mail->setFrom($user, $formTitle);
            $mail->addReplyTo($user, $formTitle);
            $mail->addAddress($email, $toName);     // Add a recipient
            if(!empty($ccEmail)) {
                $mail->addCC($ccEmail);
            }

            // Attachments
            if (!empty($attachmentPath)) {
                $mail->addAttachment($attachmentPath);
            }
            // Add attachments
            // Content
            $mail->isHTML(true);    // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}