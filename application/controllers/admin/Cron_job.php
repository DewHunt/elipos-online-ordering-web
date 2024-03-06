<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Settings_Model');
        $this->load->helper('settings');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');

    }

    public function pending_order_notification(){
        if(!(is_shop_closed())){
            $current_time=date('Y-m-d H:i:s', strtotime('-5 minutes'));
            $total_data=date('Y-m-d');
            $m_order_information=new Order_information_Model();
            $pending_order=$m_order_information->db->where(
                array(
                    'order_status'=>'pending',
                    'order_time >='=>$total_data.' 00:00:00',
                    'order_time<='=>$current_time,
                )
            )
                ->order_by('order_time','DESC')
                ->get($m_order_information->get_table_name())->result();
            $email_body='';
            foreach ($pending_order as $order_information){
                $customer_id=$order_information->customer_id;
                $customer = $this->Customer_Model->get($customer_id, true);
                $order_details= $this->Order_details_Model->get_where('order_id',$order_information->id);
                $data=array(
                    'order_information'=>$order_information,
                    'order_details'=>$order_details,
                    'customer'=>$customer,
                    'delivery_time'=>$order_information->delivery_time,
                );
                $email_body.=$this->load->view('email_template/order_details',$data ,true);
            }


            $total_pending_order=count($pending_order);
            $subject='Total '.$total_pending_order.' orders are pending ';


            if($total_pending_order>0){
                $company_details= get_company_details();
                $cc_email=get_property_value('cc_email',$company_details);
                $to_email=get_property_value('email',$company_details);
                $cc_email_array=array_map('trim',explode(',',$cc_email));
                $m_order_information->send_multiple_mail($subject,$email_body,$to_email,$cc_email_array);

            }

        }

    }



}
