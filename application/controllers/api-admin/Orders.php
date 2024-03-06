<?php
/**
 * Created by IntelliJ IDEA.
 * User: Asus
 * Date: 09-Sep-19
 * Time: 3:55 PM
 */

class Orders  extends ApiAdmin_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('Sidedishes_Model');
        $this->load->model('Order_Deals_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Customer_Model');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index()
    {
        if($this->checkMethod('GET')){
            $order_status = $this->input->get('orderStatus');
            $from = $this->input->get('startDate');
            $to = $this->input->get('endDate');
            $m_order = new Order_information_Model();
            $m_order->db->order_by('id', 'DESC');
            $today = date("Y-m-d");
            $from_time = (!empty($from)) ? $from . ' 00:00:00' : $today . ' 00:00:00';
            $to_time = (!empty($to)) ? $to . ' 23:59:59' : $today . ' 23:59:59';
            $this->db->where('order_time>=', $from_time);
            $this->db->where('order_time<=', $to_time);
            if ($order_status != 'all') {
                $this->db->where('order_status=', $order_status);
            }

            $order_information_list = $this->Order_information_Model->get();
            $data_array = array();
            $m_order_deals = new Order_Deals_Model();
            if (!empty($order_information_list)) {
                foreach ($order_information_list as $order_info) {
                    $orderDeals = array();
                    if ($this->db->table_exists('order_deals')) {
                        $this->load->model('Order_Deals_Model');
                        $m_order_deals = new Order_Deals_Model();
                        $orderDeals = $m_order_deals->getDealsByOrderId($order_info->id);
                    }
                    $customer_id = (!empty($order_info)) ? $order_info->customer_id : 0;
                    $customer = $this->Customer_Model->get($customer_id, true);
                    $customer = (!empty($customer)) ? (array)$customer : array();
                    if (!empty($order_info)) {
                        if ($order_info->payment_method != 'cash') {
                            $order_info->payment_method = 'card';
                        }
                    }
                    $newOderInfo['order_id'] = $order_info->id;
                    $newOderInfo['order_information'] = (!empty($order_info)) ? (array)$order_info : array();
                    $newOderInfo['customer_information'] = $customer;
                    $newOderInfo['order_details'] = $this->get_details_by_order_id($order_info->id);
                    $newOderInfo['deals'] = $orderDeals;
                    array_push($data_array, $newOderInfo);
                }

            }

            $this->setResponseJsonOutput(array(
                'allOrders' => $data_array
            ), ApiAdmin_Controller::HTTP_OK);
        }
    }

    private function get_details_by_order_id($id = 0)
    {
        $count = 0;
        $side_dish_total_price = 0;
        $order_details_array = array();
        $order_information = $this->Order_information_Model->get($id, true);
        if (!empty($order_information)) {
            $order_details = $this->Order_details_Model->get_by(array(
                'order_id'=>$order_information->id,
                'order_deals_id'=>0,
            ));
            if (!empty($order_details)) {
                foreach ($order_details as $detail) {
                    $detail=(array)$detail;
                    $side_dish = $this->Order_side_dish_Model->get_all_by_order_details_id($detail['id']);
                    $detail['side_dish']=(!empty($side_dish))?json_decode(json_encode($side_dish),true):array();
                    array_push($order_details_array, $detail);
                }
            }
        }
        return $order_details_array;
    }

}