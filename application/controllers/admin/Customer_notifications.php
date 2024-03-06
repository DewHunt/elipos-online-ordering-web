<?php
class Customer_notifications extends Admin_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('Firebase');
        $this->load->model('Settings_Model');
        $this->load->helper('shop');
        $this->load->model('Customer_Model');
        $this->load->model('Customer_Notification_Model');
        $this->load->model('Device_Registration_Model');
    }

    public function index() {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $lib_firebase = new Firebase();
        $notification_data = array(
            'title' => 'topics title',
            'body' => 'offers topics',
            'sound'=>"default",
            'click_action'=>"FCM_PLUGIN_ACTIVITY"
        );

        $sent_notifications = $this->Customer_Notification_Model->get_sent_notification();
        $this->data['notifications'] = $sent_notifications;
        $sent_notification_table = $this->load->view('admin/notification/sent_table',$this->data,true);

        $draft_notifications = $this->Customer_Notification_Model->get_draft_notification();
        $this->data['notifications'] = $draft_notifications;
        $draft_notification_table = $this->load->view('admin/notification/table_data',$this->data,true);

        $deleted_notifications = $this->Customer_Notification_Model->get_deleted_notification();
        $this->data['notifications'] = $deleted_notifications;
        $deleted_notification_table = $this->load->view('admin/notification/trash_table',$this->data,true);

        $this->page_content_data['title'] = "Notifications";
        $this->page_content_data['sent_notification_table'] = $sent_notification_table;
        $this->page_content_data['draft_notification_table'] = $draft_notification_table;
        $this->page_content_data['deleted_notification_table'] = $deleted_notification_table;
        $this->page_content = $this->load->view('admin/notification/index', $this->page_content_data,true);
        $this->custom_js = $this->load->view('admin/notification/index_js', $this->page_content_data,true);

        $this->data['title'] = "Notifications | Index";
        $this->load->view('admin/master/master_index', $this->data);
    }

    public function add() {
        $output = $this->load->view('admin/notification/add','',true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }

    public function edit() {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('notification_id');
        $output = 'Data Not Found';
        if (intval($id) > 0) {
            $this->Customer_Notification_Model->db->where('is_deleted',0);
            $this->Customer_Notification_Model->db->where('is_sent',0);
            $notification = $this->Customer_Notification_Model->get_notification_by_id($id);
            $this->data['notification'] = $notification;
            $output = $this->load->view('admin/notification/edit',$this->data,true);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }

    public function insert() {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $expired_date = $this->input->post('expired_date');
        $is_inserted = false;

        if (!empty($title)) {
            $data = array(
              'title'=>trim($title),
              'message'=>trim($message),
              'created_date'=>get_current_date_time(),
              'expired_date'=>$expired_date
            );
            $is_inserted = $this->Customer_Notification_Model->save($data);
        }
        $this->session->set_flashdata('save_message', 'Notification is saved successfully.');
        redirect($this->admin.'/customer_notifications');
    }

    public function update() {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $expired_date = $this->input->post('expired_date');
        $is_updated = false;

        if (!empty($message) && !empty($id)) {
            $data = array(
                'title'=>trim($title),
                'message'=>trim($message),
                'updated_date'=>get_current_date_time(),
                'expired_date'=>$expired_date
            );
            $is_updated = $this->Customer_Notification_Model->save($data,$id);
        }

        if ($is_updated) {
            $this->session->set_flashdata('save_message', 'Notification is updated successfully.');
        } else {
            $this->session->set_flashdata('save_message', 'Notification is not updated successfully.');
        }
        redirect($this->admin.'/customer_notifications');
    }

    public function delete($id = 0) {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = intval($id);
        $is_deleted = false;
        $deleted_notification_table = "";
        if ($id > 0) {
            $is_deleted = $this->Customer_Notification_Model->save(array('is_deleted'=>true),$id);
            if ($is_deleted) {
                $deleted_notifications = $this->Customer_Notification_Model->get_deleted_notification();
                $this->data['notifications'] = $deleted_notifications;
                $deleted_notification_table = $this->load->view('admin/notification/trash_table',$this->data,true);
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_deleted'=>$is_deleted,'deleted_notification_table'=>$deleted_notification_table)));
    }

    public function recover($id = 0) {
        if (is_user_permitted('admin/customer_notifications') == false) {
            redirect(base_url('admin/dashboard'));
        }
        $id = intval($id);
        $is_recover = false;
        $deleted_notification_table = "";
        if ($id > 0) {
            $is_recover = $this->Customer_Notification_Model->save(array('is_deleted'=>false),$id);
            if ($is_recover) {
                $sent_notifications = $this->Customer_Notification_Model->get_sent_notification();
                $this->data['notifications'] = $sent_notifications;
                $sent_notification_table = $this->load->view('admin/notification/sent_table',$this->data,true);

                $draft_notifications = $this->Customer_Notification_Model->get_draft_notification();
                $this->data['notifications'] = $draft_notifications;
                $draft_notification_table = $this->load->view('admin/notification/table_data',$this->data,true);
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('is_recover'=>$is_recover,'draft_notification_table'=>$draft_notification_table,'sent_notification_table'=>$sent_notification_table)));
    }

    public function sent_to_firebase() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            if (is_user_permitted('admin/customer_notifications') == true) {
                $m_customer_notification = new Customer_Notification_Model();
                $id = $this->input->post('id');
                $lib_firebase = new Firebase();
                $id = intval($id);
                $is_sent = false;
                $notification = null;

                if ($id > 0) {
                    $notification = $this->Customer_Notification_Model->get_notification_by_id($id);
                    $total_sent = 0;
                    $total_failed = 0;
                    if (!empty($notification)) {
                        $all_registration_ids = $this->Device_Registration_Model->get_device_ids();
                        // $registration_ids = ['1:111626657878:android:c985ce13c758ceac'];
                        if (!empty($all_registration_ids)) {
                            $start_index = 0;
                            $end_index = 999;
                            while (!empty($registration_ids = array_slice($all_registration_ids, $start_index, $end_index))) {
                                $registration_ids = array_column($registration_ids, 'registration_id');
                                // dd($registration_ids);
                                $start_index = $start_index + $end_index;

                                $notification_data = array(
                                    'title' => $notification->title,
                                    'body' => $notification->message,
                                    'sound' => "default",
                                    'click_action' => "FCM_PLUGIN_ACTIVITY"
                                );

                                $data = array('title'=>$notification->title,'message'=>$notification->message,);
                                $result = $lib_firebase->post($registration_ids, $notification_data, $data);

                                if (!empty($result)) {
                                    $notification_id = $notification->id;
                                    $result_string = $result;
                                    $result = json_decode($result, true);
                                    if (!empty($result)) {
                                        $total_sent = array_key_exists('success', $result) ? $result['success'] : 0;
                                        $total_failed = array_key_exists('failure', $result) ? $result['failure'] : 0;
                                        if ($total_sent > 0) {
                                            $is_sent = true;
                                            $this->Customer_Notification_Model->save(array('is_sent'=>1,'sending_date'=>get_current_date_time('Y-m-d H:i:s'),'fcm_response'=>$result_string,),$notification_id);
                                        } else {
                                            $is_sent = false;
                                        }
                                    } else {
                                        $is_sent = false;
                                    }
                                }
                            }
                        }
                    }
                    $sent_notifications = $this->Customer_Notification_Model->get_sent_notification();
                    $this->data['notifications'] = $sent_notifications;
                    $sent_notification_table = $this->load->view('admin/notification/sent_table',$this->data,true);

                    $draft_notifications = $this->Customer_Notification_Model->get_draft_notification();
                    $this->data['notifications'] = $draft_notifications;
                    $draft_notification_table = $this->load->view('admin/notification/table_data',$this->data,true);

                    $this->output->set_content_type('application/json')->set_output(json_encode(array('is_sent'=>$is_sent,'total_sent'=>$total_sent,'total_failed'=>$total_failed,'draft_notification_table'=>$draft_notification_table,'sent_notification_table'=>$sent_notification_table)));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(array('is_sent' => $is_sent,'total_sent' => 0,'total_failed' => 0,)));
                }
            } else {
                $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => '200','message' => 'Unauthorized',)));
            }
        } else {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>'200','message'=>'Bad request')));
        }
    }
}