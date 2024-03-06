<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fooditem_Strength_Model extends Ex_Model {

    protected $table_name = 'fooditem_strength';
    protected $primary_key = 'id';

    public function get_all_fooditem_strengths()
    {
    	$result = $this->db->query("SELECT * FROM fooditem_strength ORDER BY name ASC")->result();
    	return $result;
    }

    public function get_fooditem_strength_by_id($id)
    {
    	$result = $this->db->query("SELECT * FROM fooditem_strength WHERE id = $id")->row();
    	return $result;
    }

    public function get_fooditem_strength_css_class_by_id($itemStrengthArray)
    {
        $result = $this->db->query("SELECT * FROM fooditem_strength WHERE FIND_IN_SET(id,$itemStrengthArray)")->result();
        return $result;
    }
}
