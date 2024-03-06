<?php
class Customer_Action_Model extends Ex_Model
{

    protected $table_name = 'customer_action';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }



    public function save_action($action_name='',$customer_id=0,$data=null){
        if($customer_id>0){
            $save_data=array(
              'customer_id'=>$customer_id,
              'action' =>$action_name,
              'data'=>$data,
              'time'=>get_current_date_time(),
              'ip'=>$this->get_user_IP()


            );
           return $this->save($save_data);
        }else{
            return false;
        }

    }
  public  function get_user_IP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

}