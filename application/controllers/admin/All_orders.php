<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class All_orders extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Order_information_Model');
        $this->load->model('Order_details_Model');
        $this->load->model('Order_side_dish_Model');
        $this->load->model('New_order_Model');
        $this->load->model('Customer_Model');
        $this->load->helper('user');
        $this->load->helper('shop');
        $this->load->helper('product');
        /* $this->load->helper('bootstrap4pagination'); */
    }

    public function index() {
        // dd($this->session->userdata());
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        // $orders_information = $this->Order_information_Model->get();
        $orders_information = $this->get_all_order_information();
        // dd($orders_information);
        $orders_information = $orders_information['orders_information'];
        $total_information = $this->get_total_info_for_orders_info($orders_information);

        $customer = $this->Customer_Model->get();
        $this->data['customers'] = $customer;
        $this->data['orders_information'] = $orders_information;
        $this->data['total_information'] = $total_information;
        $this->page_content_data['order_table'] = $this->load->view('admin/all_orders/all_orders_table', $this->data, true);
        $this->page_content = $this->load->view('admin/all_orders/all_orders',$this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/all_orders/all_orders_js','',true);

        $this->data['title'] = "All Orders";
        $this->load->view('admin/master/master_index',$this->data);
    }

    public function get_orders() {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $from = $this->input->post('from_date');
            $to = $this->input->post('to_date');
            $order_status = $this->input->post('order_status');
            $platform = $this->input->post('platform');
            $search_result = $this->get_all_order_information($from,$to,$order_status,$platform);
            $orders_information = $search_result['orders_information'];
            $total_information = $this->get_total_info_for_orders_info($orders_information);

            $this->data['orders_information'] = $orders_information;
            $this->data['total_information'] = $total_information;
            $this->load->view('admin/all_orders/all_orders_table', $this->data);
        } else {
            redirect($this->admin . '/all_orders');
        }
    }

    public function get_orders_after_update() {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            $from = $this->input->post('from_date');
            $to = $this->input->post('to_date');
            $order_status = $this->input->post('order_status');
            $order_information_id = $this->input->post('order_information_id');
            $search_result = $this->get_all_order_information($from, $to, $order_status);
            $orders_information = $search_result['orders_information'];
            $total_information = $this->get_total_info_for_orders_info($orders_information);

            $this->data['orders_information'] = $orders_information;
            $this->data['total_information'] = $total_information;
            $all_orders_table = $this->load->view('admin/all_orders/all_orders_table', $this->data,true);

            $this->output->set_content_type('application/json')->set_output(json_encode(array('all_orders_table' => $all_orders_table)));
        } else {
            redirect($this->admin.'/all_orders');
        }
    }

    private function get_all_order_information($from = '',$to = '',$order_status = 'all',$platform = 'all') {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $today = date("Y-m-d");
        $from_time = (!empty($from)) ? $from . ' 00:00:00' : $today . ' 00:00:00';
        $to_time = (!empty($to)) ? $to . ' 23:59:59' : $today . ' 23:59:59';
        $this->db->where('order_time>=', $from_time);
        $this->db->where('order_time<=', $to_time);
        if ($order_status != 'all') {
            $this->db->where('order_status=', $order_status);
        }
        if ($platform != 'all') {
            $this->db->where('platform=', $platform);
        }
        $this->db->order_by('id', 'DESC');
        $order_information = $this->Order_information_Model->get();
        return array('orders_information' => $order_information);
    }

    public function order_information_show_in_modal() {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin() == true) {
                // dd($this->input->post());
                $product_obj = new Product();
                $id = trim($this->input->post('id'));
                $is_show_btn = trim($this->input->post('is_show_btn'));
                $order_information = $this->Order_information_Model->get($id, true);

                if (!empty($order_information)) {
                    $customer_id = $order_information->customer_id;
                    $customer = $this->Customer_Model->get($customer_id, true);

                    $orders_details = $this->Order_details_Model->get_where('order_id', $id);

                    $new_order = $this->New_order_Model->get_by(array('order_id'=>$id),true);
                    $is_order_in_new_order = empty($new_order);

                    $this->data['customer'] = $customer;
                    $this->data['order_information'] = $order_information;
                    $this->data['order_details'] = $orders_details;
                    $this->data['is_order_in_new_order'] = $is_order_in_new_order;
                    $this->data['product_obj'] = $product_obj;
                    $this->data['is_show_btn'] = $is_show_btn;

                    $this->load->view('admin/all_orders/all_orders_modal', $this->data);
                }
            } else {
                redirect($this->admin);
            }
        }
    }

    public function delete() {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin() == true) {
                $order_id = trim($this->input->post('id'));
               $is_deleted=$this->Order_information_Model->delete($order_id);
               if($is_deleted){
                   $this->Order_details_Model->delete_where(array('order_id'=>$order_id),false);
                   $this->Order_side_dish_Model->delete_where(array('order_id'=>$order_id),false);
                   $this->New_order_Model->delete_where(array('order_id'=>$order_id),false);
               }
            } else {
                redirect($this->admin);
            }
        }
    }

    public function sent_to_new_order() {
        if (is_user_permitted('admin/all_orders') == false) {
            redirect(base_url('admin/dashboard'));
        }
        if ($this->input->is_ajax_request()) {
            if ($this->User_Model->loggedin() == true) {
                $order_id = trim($this->input->post('id'));

                $order_information = $this->Order_information_Model->get($order_id, true);
                $new_order = null;
                if (!empty($order_information)) {
                    $new_order = $this->New_order_Model->get_by(array('order_id'=>$order_id),true);

                    $is_update = false;
                    if (empty($new_order) && ($order_information->order_status == 'pending')) {
                        $is_update = $this->New_order_Model->save(array(
                            'order_id'=>$order_id
                        ));
                    }
                }
                $this->output->set_content_type('application/json')->set_output(json_encode(array('isUpdate' => $is_update)));
            } else {
                redirect($this->admin);
            }
        }
    }

    public function get_total_info_for_orders_info($orders_information) {
        $total_collection = 0;
        $total_delivery = 0;
        $total_cash = 0;
        $total_card = 0;
        $total_rejected = 0;
        $total_sale = 0;
        $total_web = 0;
        $total_android = 0;
        $total_ios = 0;

        if ($orders_information) {
            foreach ($orders_information as $order) {
                $total_sale += (double) $order->order_total;

                if ($order->platform == 'web') {
                    $total_web += (double) $order->order_total;
                }

                if ($order->platform == 'android') {
                    $total_android += (double) $order->order_total;
                }

                if ($order->platform == 'ios') {
                    $total_ios += (double) $order->order_total;
                }

                if ($order->order_type == 'collection' && $order->order_status != 'reject') {
                    $total_collection += $order->cash_amount + $order->card_amount;
                } else if ($order->order_type == 'delivery' && $order->order_status != 'reject') {
                    $total_delivery += $order->cash_amount + $order->card_amount;
                }

                if ($order->payment_method == 'cash' && $order->order_status != 'reject') {
                    $total_cash += $order->cash_amount;
                } else if ($order->payment_method != 'cash' && $order->order_status != 'reject') {
                    $total_card += $order->card_amount;
                }

                if ($order->order_status == 'reject') {
                    $total_rejected += $order->cash_amount + $order->card_amount;
                }
            }
        }

        return [$total_collection,$total_delivery,$total_cash,$total_card,$total_rejected,$total_web,$total_android,$total_ios,$total_sale];
    }
}