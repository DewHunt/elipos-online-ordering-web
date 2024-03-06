<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_design_model extends Ex_Model
{
    protected $table_name = 'page_design';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all($value='') {
    	$results = $this->db->query("SELECT * FROM `page_design` ORDER BY `name` ASC")->result();
    	return $results;
    }

    public function get_by_id($id) {
    	$result = $this->db->query("SELECT * FROM `page_design` WHERE `id` = $id")->row();
    	return $result;
    }

    public function get_by_name($name='') {
        return $this->get_by(array('name'=>trim($name)),true);
    }
}