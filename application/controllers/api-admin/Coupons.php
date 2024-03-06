<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends ApiAdmin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Voucher_Model');
        $this->load->model('Coupon_Model');

    }

    public function index()
    {

        if ($this->checkMethod('GET')) {
            $isCouponIsEnabled = $this->Voucher_Model->isCouponEnabled();
            $this->Coupon_Model->db->order_by('id', 'DESC');
            $coupons = $this->Coupon_Model->get();
            $validityOptions = $this->Voucher_Model->getVoucherDays();
            $this->setResponseJsonOutput(array(
                'coupons' => $coupons,
                'validityOptions' => $validityOptions,
                'isCouponIsEnabled' => $isCouponIsEnabled,
                'responseMessage' => '',
            ));
        }
    }


    public function save()
    {

        if ($this->checkMethod('POST')) {
            $message = '';
            $isSave = false;
            $this->form_validation->set_rules($this->Coupon_Model->add_rules);
            if ($this->form_validation->run()) {

                $plusDate = intval($this->input->post('validity_days'));
                if(!empty($plusDate)){
                    $expiredDate = date('Y-m-d', strtotime("+ $plusDate days"));
                    $formData['expired_date'] = $expiredDate;
                }

                $formData = $this->Coupon_Model->data_form_post(
                    array(
                        'title', 'code', 'min_order_amount', 'description', 'discount_type', 'discount_amount', 'order_type',
                        'remaining_usages', 'status', 'max_discount_amount'
                    )
                );
                $formData['created_at'] = date('Y-m-d H:i:s');

                $isSave = $this->Coupon_Model->save($formData);
                $message = 'Saved successfully';
            } else {
                $message = validation_errors();
            }
            $this->setResponseJsonOutput(array(
                'isSave' => $isSave,
                'responseMessage' => $message,
            ));
        }

    }

    public function update()
    {

        if ($this->checkMethod('POST')) {
            $this->form_validation->set_rules($this->Coupon_Model->edit_rules);
            $id = $this->input->post('id');
            $formData = $this->Coupon_Model->data_form_post(
                array(
                    'title', 'code', 'min_order_amount', 'description', 'discount_type', 'discount_amount', 'order_type',
                    'status', 'max_discount_amount', 'remaining_usages','expired_date'
                )
            );

            $message = '';
            $isSave = false;

            if ($this->form_validation->run()) {
                $formData['updated_at'] = date('Y-m-d H:i:s');
                $formData['id'] = $id;
                $codeExit = $this->Coupon_Model->get_by(
                    array(
                        'id!=' => $id,
                        'code' => $formData['code'],
                    ), true
                );
                if (empty($codeExit)) {
                    $isSave = $this->Coupon_Model->save($formData, $id);
                    $message = 'Updated successfully';
                } else {
                    $message = 'Code &nbsp;' . $formData['code'] . '&nbsp; is already exist';
                }


            } else {
                $message = validation_errors();
            }
            $this->setResponseJsonOutput(array(
                'isSave' => $isSave,
                'responseMessage' => $message,
            ));
        }

    }

    public function delete($id = 0)
    {
        if ($this->checkMethod('POST')) {
            $isDeleted = $this->Coupon_Model->delete(intval($id));
            $this->setResponseJsonOutput(array(
                'isDeleted' => $isDeleted,
                'responseMessage' => ($isDeleted)?'Deleted successfully':'Did not deleted',
            ));
        }

    }

    public function save_settings()
    {
        if ($this->checkMethod('POST')) {
            $isCouponEnabled = $this->input->post('isCouponEnabled');
            $enabled_free_item_exist = $this->Settings_Model->get_by(array(
                'name' =>'isCouponEnabled',
            ), true);
            $isSave=false;
            if(empty($enabled_free_item_exist)){
                $isSave=$this->Settings_Model->save(
                    array('name' =>'isCouponEnabled','value'=>$isCouponEnabled)
                );

            }else{
                $this->Settings_Model->where_column='name';
                $isSave=$this->Settings_Model->save(array('value'=>$isCouponEnabled),'isCouponEnabled');
            }

            $this->setResponseJsonOutput(array(
                'isSave' => $isSave,
                'responseMessage' =>($isSave)?'Saved successfully':'Did not updated'
            ));
        }

    }



}