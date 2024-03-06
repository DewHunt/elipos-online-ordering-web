<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends Ex_Model {
    protected $table_name = 'menus';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_menu() {
    	$results = $this->db->query("
    		(SELECT `tab1`.*, `tab2`.`menu_name` AS `parent_name` 
    		FROM `menus` AS `tab1` 
    		INNER JOIN `menus` AS `tab2` ON `tab2`.`id` = `tab1`.`parent_menu`) 
    		UNION
            (SELECT `menus`.*, `parent_menu` AS `parent_name` FROM `menus` WHERE `menus`.`parent_menu` is NULL) 
    		ORDER BY `parent_name` ASC, `order_by` ASC
    	")->result();
    	return $results;
    }

    public function get_all_menu_info() {
    	$results = $this->db->query("SELECT * FROM `menus` WHERE `status` = 1 AND `menu_link` = '' ORDER BY `menu_name` ASC")->result();
    	return $results;
    }

    public function get_menu_by_id($menu_id) {
    	$result = $this->db->query("SELECT * FROM `menus` WHERE `id` = $menu_id")->row();
    	return $result;
    }

    public function get_menu_by_menu_link($menu_link = '') {
        $result = $this->db->query("SELECT * FROM `menus` WHERE `menu_link` = '$menu_link'")->row();
        return $result;
    }

    public function is_menu_exists($menu_link = '',$id = 0) {
    	$where_query = "";
    	if ($id > 0) {
    		$where_query = "AND `id` <> $id";
    	}

    	$result = $this->db->query("SELECT * FROM `menus` WHERE `menu_link` = '$menu_link' $where_query")->row();
    	return $result;
    }

    public function get_parent_menu_max_order() {
    	$result = $this->db->query("SELECT MAX(`order_by`) AS `max_order` FROM `menus` WHERE `parent_menu` IS NULL")->row();
    	return $result;
    }

    public function get_max_order($parent_menu_id) {
    	$result = $this->db->query("SELECT MAX(`order_by`) AS `max_order` FROM `menus` WHERE `parent_menu` = $parent_menu_id")->row();
    	return $result;
    }

    public function get_menu_by_ids($ids = '') {
        $results = $this->db->query("SELECT * FROM `menus` WHERE `id` IN ($ids)")->result();
        return $results;
    }

    public function get_menu_name_by_ids($ids = '') {
        $results = $this->db->query("SELECT `menu_name` FROM `menus` WHERE `id` IN ($ids)")->result();
        $menu_names = array();
        foreach ($results as $value) {
            array_push($menu_names, $value->menu_name);
        }
        $menu_names = implode(', ', $menu_names);
        return $menu_names;
    }
}
