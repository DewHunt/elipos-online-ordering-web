<?php
class Voucher_Model extends Ex_Model {
    protected $table_name = 'voucher';
    protected $primary_key = 'id';
    public $where_column = 'id';
    public $add_rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
        'min_order_amount' => array(
            'field' => 'min_order_amount',
            'label' => 'Minimum Order Amount',
            'rules' => 'trim|required|numeric',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
        'discount_type' => array(
            'field' => 'discount_type',
            'label' => 'Discount Type',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
        'discount_amount' => array(
            'field' => 'discount_amount',
            'label' => 'Discount Amount',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
        'max_time_usage' => array(
            'field' => 'max_time_usage',
            'label' => 'Maximum Usage Time',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
    );

    public function __construct() {
        parent::__construct();
    }

    public function getVoucherDaysText($validity_days) {
        if ($validity_days > 0) {
            if ($validity_days >= 30) {
                $months = intdiv($validity_days,30);
                $weeks = intdiv(($validity_days % 30),7);
                $days = ($validity_days % 30) % 7;
                $output = $months." Months ";
                if ($weeks > 0) {
                    $output .= $weeks." Weeks ".$days." Days";
                } elseif ($days > 0) {
                    $output .= $days." Days";
                }
                return $output;
            } elseif ($validity_days >= 7) {
                $weeks = intdiv($validity_days,7);
                $days = $validity_days % 7;
                $output = $weeks." Weeks ";                
                if ($days > 0) {
                    $output .= $days." Days";
                }
                return $output;
            }
        }
        return $validity_days." Days";
    }


    public function getVoucherDays() {
        return array(
            ['title' => 'Today', 'days' => 0],
            ['title' => 'Tomorrow', 'days' => 1],
            ['title' => 'After 2 Days', 'days' => 2],
            ['title' => 'After 3 Days', 'days' => 3],
            ['title' => '1 Week', 'days' => 7],
            ['title' => '2 Week', 'days' => 14],
            ['title' => '3 Week', 'days' => 21],
            ['title' => '1 Month', 'days' => 30],
            ['title' => '2 Month', 'days' => 60],
            ['title' => '3 Month', 'days' => 90],
            ['title' => '6 Month', 'days' => 180],
            ['title' => '1 Year', 'days' => 365],
        );
    }

    public function getVoucher($amount, $orderType = '') {
        $currentDate = date('Y-m-d');
        $this->db->where(array(
            'start_date<=' => $currentDate,
            'end_date>=' => $currentDate,
            'min_order_amount<=' => $amount,
            'status' => 1,
        ));
        $this->db->group_start()->where('order_type', $orderType)->or_where('order_type', 'any')->group_end();
        return $this->db->get($this->table_name)->row();
    }

    public function saveAndSendCouponVoucher($totalAmount = 0, $orderType = 0, $customerId = 0) {
        if (!$this->isCouponEnabled()) {
            if ($customerId != 29) {
                return false;
            }
        }

        $voucher = $this->getVoucher($totalAmount,$orderType);

        if (!empty($voucher)) {
            $plusDate = $voucher->validity_days;
            $startDate = $voucher->start_date;
            $expiredDate = $voucher->end_date;
            // $expiredDate = date('Y-m-d', strtotime("+ $plusDate days"));
            $permitted_chars = 'JKLMNOPQRSCDEGTUVWXYABCDEFHIZ';
            $codePrefix = substr(str_shuffle($permitted_chars), 0, 3);
            $timeText = time();
            $code = $customerId.$codePrefix.$timeText;
            $saveData = array(
                'code' => $code,
                'customer_id' => $customerId,
                'voucher_id' => $voucher->id,
                'title' => $voucher->title,
                'description' => $voucher->description,
                'min_order_amount' => $voucher->min_order_amount,
                'discount_type' => $voucher->discount_type,
                'discount_amount' => $voucher->discount_amount,
                'max_discount_amount' => $voucher->max_discount_amount,
                'order_type' => $voucher->order_type_to_use,
                'remaining_usages' => $voucher->max_time_usage,
                'start_date' => $startDate,
                'expired_date' => $expiredDate,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            );

            $isSave = $this->saveCoupon($saveData);

            if ($isSave && $customerId > 0) {
                $customer = $this->Customer_Model->get($customerId);
                $company = get_company_details();
                $companyName = get_property_value('company_name', $company);
                $subject = 'Gift Voucher form ' . $companyName;

                if (!empty($customer)) {
                    $discountText = ' ';
                    $discountAmount = $voucher->discount_amount;
                    if ($voucher->discount_type == 'amount') {
                        $discountText = get_price_text($discountAmount) . '';
                    } else {
                        if ($voucher->max_discount_amount > 0) {
                            $discountText = $discountAmount . '%  ';
                        } else {
                            $discountText = $discountAmount . '%';
                        }
                    }
                    $shop = get_company_details();
                    $companyName = get_property_value('company_name', $shop);

                    $discountText = sprintf("<p>This voucher entitles the holder to spend<br> <span  style='font-size: 30px;font-weight: bolder'>%s</span> at %s</p>", $discountText, $companyName);
                    $email = get_property_value('email', $customer);
                    $data = array(
                        'description' => $discountText,
                        'code' => $code,
                        'validityDate' => getFormatDateTime($expiredDate, 'd-m-Y'),
                        'background_image' => $voucher->image,
                    );

                    $body = $this->load->view('email_template/voucher_html', $data, true);
                    $pdfHtml = $this->load->view('email_template/voucher_pdf', $data, true);

                    $companyEmail = get_property_value('email', $company);
                    $attachment = $this->getVoucherAttachment($pdfHtml, $code);
                    $customerName = get_customer_full_name($customer);
                     
                    $this->load->library('PHPMailer_Lib');
         
                    $lib = new PHPMailer_Lib();
                    $isSend = $lib->sendMail($subject,$body,$email,$customerName, $attachment['path']);
                    unlink($attachment['path']);
                    // $isSend = $this->sendMail($subject,$body, $email, $attachment['path'], array($companyEmail));
                }
            }
        }
    }

    public function saveCoupon($data) {
        return $this->db->insert('coupons', $data);
    }

    public function getValidCoupon($code, $orderType, $totalAmount) {
        $this->db->where(array('code' => $code, 'status' => 1, 'min_order_amount<=' => $totalAmount, 'remaining_usages>' => 0, 'expired_date>=' => date('Y-m-d')));
        $this->db->group_start()->where('order_type', $orderType)->or_where('order_type', 'any')->group_end();
        return $this->db->get('coupons')->row();
    }

    public function getDiscountAmountFromValidCoupon($code, $orderType, $totalAmount) {
        if (!$this->isCouponEnabled()) {
            return 0;
        }
        $voucherCoupon = $this->getValidCoupon($code, $orderType, $totalAmount);
        // dd($voucherCoupon);
        if (!empty($voucherCoupon)) {
            // update coupon is used
            // $id = $voucherCoupon->id;
            // $remaining_usages = $voucherCoupon->remaining_usages;
            // $data = array('id' => $id,'remaining_usages' => $remaining_usages - 1,);
            // $this->db->update('coupons', $data, array('id' => $id));
            return $this->calculateCouponDiscount($voucherCoupon, $totalAmount);
        }
        return 0;
    }

    public function getByCode($code) {
        $this->db->where(array('code' => $code, 'status' => 1,));
        return $this->db->get('coupons')->row();
    }

    public function updateCouponRemainingUsagesByCode($code = '') {
        $coupon_info = $this->getByCode($code);
        if ($coupon_info) {
            $id = $coupon_info->id;
            $remaining_usages = $coupon_info->remaining_usages;
            $data = array('id' => $id,'remaining_usages' => $remaining_usages - 1,);
            $this->db->update('coupons', $data, array('id' => $id));
        }
    }

    public function getVoucherAttachment($pdfHtml, $code) {
        $this->load->library('Pdf_Generator');
        $pdf_g = new Pdf_Generator();
        $pdf = $pdf_g->get_pdf_object();
        $context = stream_context_create(['ssl' => ['verify_peer' => FALSE,'verify_peer_name' => FALSE,'allow_self_signed' => TRUE]]);

        //echo  $html;
        $customPaper = array(0, 0, 600, 289);
        $pdf->setPaper($customPaper);
        $pdf->setHttpContext($context);
        $pdf->loadHtml($pdfHtml);
        $pdf->render();

        //$pdf->stream('test.pdf',array('Attachment'=>0));
        //file_put_contents(base_url('assets/test.pdf'), $pdf->output());

        $output = $pdf->output();
        $file_name = 'assets/Voucher-' . $code . '.pdf';
        file_put_contents($file_name,$output);
        return array('path'=>$file_name,'output'=>$output);
    }


    public function sendMail($subject = '', $body = null, $to_email = null, $attachment = null, $cc_emails = array()) {
        // $this->load->library('parser');
        $configDetails = get_smtp_config_details();
        // $config = Array(
        //     'protocol' => 'smtp',
        //     'mailpath' => 'ssl://' . trim(get_property_value('host', $configDetails)),
        //     'smtp_host' => 'ssl://' . trim(get_property_value('host', $configDetails)),
        //     'smtp_port' => '587',
        //     'smtp_user' => trim(get_property_value('user', $configDetails)), // change it to yours
        //     'smtp_pass' => trim(get_property_value('password', $configDetails)), // change it to yours
        //     'mailtype' => 'html',
        // );

        $config = Array(
            'protocol' => 'smtp',
            'mailpath' => 'ssl://'.trim(get_smtp_host_url()),
            'smtp_host' => 'ssl://'.trim(get_smtp_host_url()),
            'smtp_port' => 465,
            'smtp_user' => trim(get_smtp_host_user()),  // change it to yours
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
            // $this->email->cc($cc_emails);
        }

        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->attach(base_url($attachment));

        $is_sent = false;
        try {
            //check if
            $is_sent = $this->email->send(false);
        } catch (Exception $e) {
            $is_sent = false;
        }
        unlink($attachment);
        return true;
    }

    public function calculateCouponDiscount($voucherCoupon = null, $totalAmount = 0) {
        if (!empty($voucherCoupon) && $totalAmount > 0) {
            $discount_type = $voucherCoupon->discount_type;
            $discount_amount = $voucherCoupon->discount_amount;
            if ($discount_type == 'percent') {
                $discount = ($totalAmount * $voucherCoupon->discount_amount) / 100;
                if ($discount > $voucherCoupon->max_discount_amount) {
                    return $voucherCoupon->max_discount_amount;
                }
                return $discount;
            }
            return $discount_amount;
        } else {
            return 0;
        }
    }

    public function isCouponEnabled() {
        $this->db->where('name', 'isCouponEnabled');
        $settingsData = $this->db->get('settings')->row();
        if (!empty($settingsData)) {
            $isEnabled = get_property_value('value', $settingsData);
            if (empty($isEnabled)) {
                return false;
            }
            return ($isEnabled == 'true') ? true : false;
        }
        return false;
    }
}