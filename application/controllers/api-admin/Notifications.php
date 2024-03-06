<?php
class Notifications extends ApiAdmin_Controller {
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


    public function index(){
        if ($this->checkMethod('GET')) {
            $m_customer_notification=new Customer_Notification_Model();
            $sent_notifications=$m_customer_notification->get_sent_notification();
            $draft_notifications=$m_customer_notification->get_draft_notification();
            $deleted_notifications=$m_customer_notification->get_deleted_notification();
            $this->setResponseJsonOutput(array(
                'sentNotifications'=>$sent_notifications,
                'composedNotifications'=>$draft_notifications,
                'deletedNotifications'=>$deleted_notifications,
            ));
        }
    }





    public function save(){

        if ($this->checkMethod('POST')) {

            $title=$this->input->post('title');
            $message=$this->input->post('message');
            $expired_date=$this->input->post('expired_date');
            $is_inserted=false;
            if(!empty($title)){
                $m_customer_notification=new Customer_Notification_Model();
                $data=array(
                    'title'=>trim($title),
                    'message'=>trim($message),
                    'created_date'=>get_current_date_time(),
                    'expired_date'=>$expired_date
                );
                $is_inserted= $m_customer_notification->save($data);
                $this->setResponseJsonOutput(array(
                    'isSave'=>$is_inserted,
                    'responseMessage'=>($is_inserted)?'Save successfully':'Not saved',
                ));
            }

        }

    }


    public function update(){

        if ($this->checkMethod('POST')) {
            $id=$this->input->post('id');
            $title=$this->input->post('title');
            $message=$this->input->post('message');
            $expired_date=$this->input->post('expired_date');
            $is_updated=false;
            if(!empty($message) && !empty($id)){
                $m_customer_notification=new Customer_Notification_Model();
                $data=array(
                    'title'=>trim($title),
                    'message'=>trim($message),
                    'updated_date'=>get_current_date_time(),
                    'expired_date'=>$expired_date
                );

                $is_updated=$m_customer_notification->save($data,$id);
                $this->setResponseJsonOutput(array(
                    'isSave'=>$is_updated,
                    'responseMessage'=>($is_updated)?'Update successfully':'Not updated',
                ));
            }



        }
    }

    public function delete($id=0){
        if ($this->checkMethod('POST')) {
            $m_customer_notification=new Customer_Notification_Model();
            $id=intval($id);
            $is_deleted=false;
            if($id>0){
                $is_deleted=$m_customer_notification->save(array('is_deleted'=>true),$id);
            }
            $this->setResponseJsonOutput(array(
                'isDeleted'=>$is_deleted,
                'responseMessage'=>($is_deleted)?'Deleted successfully':'Not Deleted',
            ));
        }
    }
    public function sent_to_firebase($id=0)
    {
        if ($this->checkMethod('POST')) {
                $m_customer_notification = new Customer_Notification_Model();
                $lib_firebase = new Firebase();
                $id = intval($id);
                $is_sent = false;
                $notification = null;
                if ($id > 0) {
                    $m_device_registration = new Device_Registration_Model();
                    $m_customer_notification->db->where('is_deleted', false);
                    $notification = $m_customer_notification->get($id);

                    $total_sent = 0;
                    $total_failed = 0;
                    if (!empty($notification)) {
                        if(!$notification->is_sent){
                            $registration_ids = $m_device_registration->get_device_ids();
                            //$registration_ids=['1:111626657878:android:c985ce13c758ceac'];
                            if (!empty($registration_ids)) {
                                $registration_ids = array_column($registration_ids, 'registration_id');
                                $notification_data = array(
                                    'title' => $notification->title,
                                    'body' => $notification->message,
                                    'sound'=>"default",
                                    'click_action'=>"FCM_PLUGIN_ACTIVITY"
                                );

                                $data=array(
                                    'title'=>$notification->title,
                                    'message'=>$notification->message,
                                );
                                $result = $lib_firebase->post($registration_ids, $notification_data, $data);

                                if (!empty($result)) {

                                    $notification_id=$notification->id;
                                    $result_string=$result;
                                    $result = json_decode($result, true);
                                    if(!empty($result)){
                                        $total_sent = array_key_exists('success', $result) ? $result['success'] : 0;
                                        $total_failed = array_key_exists('failure', $result) ? $result['failure'] : 0;
                                        if($total_sent>0){
                                            $is_sent = true;
                                            $m_customer_notification->save(
                                                array(
                                                    'is_sent'=>1,
                                                    'sending_date'=>get_current_date_time('Y-m-d H:i:s'),
                                                    'fcm_response'=>$result_string,
                                                ),$notification_id);
                                        }else{
                                            $is_sent=false;
                                        }
                                    }else{
                                        $is_sent=false;
                                    }

                                }

                            }
                            $this->setResponseJsonOutput(array(
                                'isSent'=>$is_sent,
                                'responseMessage'=>($is_sent)?'Notification is sent successfully':'Notification is not sent',
                                'totalSent'=>$total_sent,
                                'totalFailed'=>$total_failed,
                            ));
                        }else{
                            $this->setResponseJsonOutput(array(
                                'isSent'=>false,
                                'responseMessage'=>'Already this notification is sent',
                                'totalSent'=>0,
                                'totalFailed'=>0,
                            ));
                        }

                    }else{
                        $this->setResponseJsonOutput(array(
                            'isSent'=>false,
                            'responseMessage'=>'Notification not exist on server',
                            'totalSent'=>0,
                            'totalFailed'=>0,
                        ));
                    }


                } else {
                    $this->setResponseJsonOutput(array(
                        'isSent'=>false,
                        'responseMessage'=>'Notification not exist on server',
                        'totalSent'=>0,
                        'totalFailed'=>0,
                    ));
                }
            }
    }



}