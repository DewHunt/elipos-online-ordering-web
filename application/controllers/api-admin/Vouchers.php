<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends ApiAdmin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Voucher_Model');
    }

    public function index() {

        if($this->checkMethod('GET')){
            $validityOptions = $this->Voucher_Model->getVoucherDays();
            $this->Voucher_Model->db->order_by('sort_order','ASC');
            $vouchers=$this->Voucher_Model->get();
            $this->setResponseJsonOutput(array(
                'vouchers'=>$vouchers,
                'validityOptions'=>$validityOptions,
                'responseMessage'=>'',
            ));
        }



    }



    public function save() {


        if($this->checkMethod('POST')){

            $isSave=false;
            $this->form_validation->set_rules($this->Voucher_Model->add_rules);
            if ($this->form_validation->run()) {
                $formData=$this->Voucher_Model->data_form_post(
                    array(
                        'title','min_order_amount','description','validity_days','discount_type','discount_amount','order_type',
                        'order_type_to_use','max_time_usage','status','sort_order','max_discount_amount'
                    )
                );
                $isAmountTitleExit=$this->Voucher_Model->get_by(
                    array(
                        'title'=>$formData['title'],
                        'min_order_amount'=>$formData['min_order_amount'],
                    ),true
                );
                $formData['created_at']=date('Y-m-d H:i:s');
                if(empty($isAmountTitleExit)){
                    $isSave=$this->Voucher_Model->save($formData);
                    $message='Saved successfully';
                }else{
                    $message='Title With amount is already exist';

                }
            }else{
                $message=validation_errors();
            }


            $this->setResponseJsonOutput(array(
                'isSave'=>$isSave,
                'responseMessage'=>$message,
            ));
        }




    }

    public function update() {

        if($this->checkMethod('POST')){
            $isSave=false;
            $message='';

            $this->form_validation->set_rules($this->Voucher_Model->add_rules);
            set_flash_form_data($_POST);
            $id=$this->input->post('id');
            $formData=$this->Voucher_Model->data_form_post(
                array(
                    'title','min_order_amount','description','validity_days','discount_type','discount_amount','order_type',
                    'order_type_to_use','max_time_usage','status','sort_order','max_discount_amount'
                )
            );
            if ($this->form_validation->run()) {

                $isAmountTitleExit=$this->Voucher_Model->get_by(
                    array(
                        'id!='=>$id,
                        'title'=>$formData['title'],
                        'min_order_amount'=>$formData['min_order_amount'],
                    ),true
                );
                $formData['updated_at']=date('Y-m-d H:i:s');
                if(empty($isAmountTitleExit)){
                    $formData['id']=$id;
                    $isSave=$this->Voucher_Model->save($formData,$id);
                    $message='Updated successfully';

                }else{
                    $message='Title With amount is already exist';

                }


            }else{
                $message=validation_errors();

            }
            $this->setResponseJsonOutput(array(
                'isSave'=>$isSave,
                'responseMessage'=>$message,
            ));
        }

    }

    public function delete($id = 0) {
        if ($this->checkMethod('POST')) {
            $isDeleted=$this->Voucher_Model->delete(intval($id));
            $this->setResponseJsonOutput(array(
                'isDeleted' => $isDeleted,
                'responseMessage' => ($isDeleted)?'Deleted successfully':'Did not deleted',
            ));

        }


    }


}