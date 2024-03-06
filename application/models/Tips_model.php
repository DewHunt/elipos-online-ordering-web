<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tips_model extends Ex_Model {

    protected $table_name = 'tips';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_tips() {
    	$result = $this->db->query("SELECT * FROM `tips`")->result();
    	return $result;
    }

    public function get_all_tips_by_status() {
        $result = $this->db->query("SELECT * FROM `tips` WHERE `status` = 1")->result();
        return $result;
    }

    public function get_tips_by_id($id) {
    	$result = $this->db->query("SELECT * FROM `tips` WHERE `id` = $id")->row();
    	return $result;
    }
}