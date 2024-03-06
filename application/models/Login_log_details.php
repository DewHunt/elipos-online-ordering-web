<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_log_details extends Ex_Model {

    protected $table_name = 'login_log_details';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_login_activity() {
    	$results = $this->db->query("SELECT * FROM `login_log_details` ORDER BY `id` DESC")->result();
    	return $results;
    }

    public function get_last_ten_login_activity() {
    	$results = $this->db->query("SELECT * FROM `login_log_details` ORDER BY `id` DESC LIMIT 10")->result();
    	return $results;
    }

    public function save_login_activity($user_id = 0,$user_name = '',$login = true,$logout = false) {
        $data = array(
            'user_id' => $user_id,
            'user_name_or_email' => $user_name,
            'ip_address' => get_user_ip_address(),
        );
        if ($login) {
        	$data['login_time'] = date('Y-m-d H:i:s');
        }
        if ($logout) {
        	$data['logout_time'] = date('Y-m-d H:i:s');
        }
        $this->save($data);
    }

    public function save_logout_activity($user) {
        if ($user) {
            $data = array(
                'user_id' => $user['user_id'],
                'user_name_or_email' => $user['user_name'],
                'ip_address' => get_user_ip_address(),
                'logout_time' => date('Y-m-d H:i:s'),
            );
            $this->save($data);
        }
    }
}
