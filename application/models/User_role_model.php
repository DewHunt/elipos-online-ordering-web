<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_role_model extends Ex_Model {

    protected $table_name = 'user_roles';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_user_role_list($role = 0) {
        $where_query = "";
        if ($role != 1 || $role > 0) {
            if ($role == 2) {
                $where_query = "WHERE `role` >= $role";
            } else if ($role == 3) {
                $where_query = "WHERE `role` = $role";
            }
        }
    	$results = $this->db->query("
            SELECT * FROM `user_roles` $where_query ORDER BY `role` ASC
        ")->result();
    	return $results;
    }

    public function get_all_user_role_list_by_status($role = 0) {
        $where_query = "";
        if ($role != 1 || $role > 0) {
            if ($role == 2) {
                $where_query = "AND `role` >= $role";
            } else if ($role == 3) {
                $where_query = "AND `role` = $role";
            }
        }
        $results = $this->db->query("SELECT * FROM `user_roles` WHERE `status` = 1 $where_query ORDER BY `role` ASC")->result();
        return $results;
    }

    public function get_user_role_by_id($id) {
    	$result = $this->db->query("SELECT * FROM `user_roles` WHERE `id` = $id")->row();
    	return $result;
    }

    public function is_user_role_exists($role = '',$id = 0) {
    	$where_query = "";
    	if ($id > 0) {
    		$where_query = "AND `id` <> $id";
    	}

    	$result = $this->db->query("SELECT * FROM `user_roles` WHERE `role` = '$role' $where_query")->row();
    	return $result;
    }
}
