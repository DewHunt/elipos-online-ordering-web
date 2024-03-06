<?php

class Voucher extends Api_Controller
{
    public function __construct() {
        parent:: __construct();
        $this->load->model('Voucher_Model');
        $this->load->helper('product');
    }

    function discount() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $discount = 0;
            $message = '';
            $isValid = false;
            $coupon_code = $this->input->post('couponCode');
            $orderType = $this->input->post('orderType');
            $totalAmount = $this->input->post('totalAmount');

            if (!empty($coupon_code)) {
                $voucherCoupon = $this->Voucher_Model->getByCode($coupon_code);
                $message = 'Coupon code is invalid';
                if (!empty($voucherCoupon)) {
                    /*
                    * 1.check order type
                    * 2.Check expired date
                    * 3.Check remaining usages
                    */
                    // $totalCartAmount = $this->cart
                    $expiredDate = strtotime($voucherCoupon->expired_date);

                    if ($expiredDate < strtotime(date('Y-m-d'))) {
                        $message = 'Coupon code is expired';
                    } else {
                        $isValid = true;
                        $couponOrderType = $voucherCoupon->order_type;
                        if ($couponOrderType != 'any') {
                            if ($couponOrderType != $orderType) {
                                $isValid = false;
                                $message = 'Coupon code is only for ' . ucfirst($orderType) . ' order';
                            }
                        }
                        $remaining_usages = $voucherCoupon->remaining_usages;
                        if ($remaining_usages <= 0) {
                            $isValid = false;
                            $message = 'Coupon code is already used';
                        }
                        if ($isValid) {
                            $isValid = false;
                            $min_order_amount = $voucherCoupon->min_order_amount;
                            if ($min_order_amount <= $totalAmount) {
                                $isValid = true;
                            } else {
                                $message = 'Coupon code is applicable for minimum order amount of ' . get_price_text($min_order_amount, 0);
                            }
                        }
                    }
                    if ($isValid) {
                        // calculate discount and show message
                        $discount = $this->Voucher_Model->calculateCouponDiscount($voucherCoupon, $totalAmount);
                        $message = 'You have got discount amount of ' . get_price_text($discount, 2) . ' by this coupon';
                    }
                }
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array('isValid' => $isValid,'couponId'=>intval($voucherCoupon->id),'message' => $message,'discount' =>$discount)));
        } else {
            $response_data = array('status'=>400,'message'=>'Bad request',);
            $this->output->set_content_type('application/json')->set_output(json_encode($response_data));
        }
    }

    function setUsed() {
        $id = $this->input->post('id');
        $isUpdated = false;
        $voucherCoupon = $this->Voucher_Model->get_by(array('id'=>$id),true);
        if (!empty($voucherCoupon)) {
            // update coupon is used
            $id = $voucherCoupon->id;
            $remaining_usages = $voucherCoupon->remaining_usages;
            $data = array('id'=>$id,'remaining_usages'=>$remaining_usages-1,);
            $isUpdated = $this->db->update('coupons', $data, array('id' => $id));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('isUpdated' => $isUpdated,'message' => '',)));
    }
}