<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_Registration_Model extends Ex_Model
{
    protected $table_name = 'device_registration';
    protected $primary_key = 'id';
    public $where_column = 'registration_id';

    public function __construct() {
        parent::__construct();
    }

    public function register_device($data = array()) {
        return (!empty($data)) ? $this->save($data) : false;
    }

    public function get_device_ids($conditions = array()) {
        $this->db->select('registration_id');
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->get($this->table_name)->result_array();
    }

    public function get_by_registration_id($registration_id = null) {
        if (!empty($registration_id)) {
           return $this->get_by(array('registration_id'=>$registration_id),true);
        } else {
            return null;
        }
    }
}