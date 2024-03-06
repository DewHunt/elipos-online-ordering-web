<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cardstream_transaction_model extends Ex_Model {

    protected $table_name = 'cardstream_transaction';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_customer_id($id) {
    	$result = $this->db->query("SELECT * FROM `cardstream_transaction` WHERE `customer_id` = $id")->row();
    	return $result;
    }
}
