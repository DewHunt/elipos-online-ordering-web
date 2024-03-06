<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Table_model extends Ex_Model {

    protected $table_name = 'tables';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_table()
    {
    	$result = $this->db->query("SELECT * FROM tables ORDER BY table_number ASC")->result();

    	return $result;
    }

    public function get_table_by_id($id = 0) {
    	$result = $this->db->query("SELECT * FROM tables WHERE id = $id")->row();
    	return $result;
    }

    public function is_table_exists($number,$table_id = 0)
    {
    	$query = "";
    	if ($table_id > 0) {
    		$query .= "AND id <> $table_id";
    	}
    	$result = $this->db->query("SELECT * FROM tables WHERE table_number = '$number' $query")->row();
    	return $result;
    }
}
