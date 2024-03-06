<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_offers_model extends Ex_Model {

    protected $table_name = 'promo_offers';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_promo_offers_lists() {
    	$results = $this->db->query("SELECT * FROM `promo_offers` ORDER BY `sort_order` ASC")->result();
    	return $results;
    }

    public function get_promo_offers_by_status() {
        $results = $this->db->query("SELECT * FROM `promo_offers` WHERE `status` = 1 ORDER BY `sort_order` ASC")->result();
        return $results;
    }

    public function get_promo_offers_for_apps($date = '') {
        $results = $this->db->query("
            SELECT *
            FROM `promo_offers`
            WHERE DATE_FORMAT(`start_date`,'%Y-%m-%d') <= '$date' AND DATE_FORMAT(`end_date`,'%Y-%m-%d') >= '$date' AND `status` = 1
            ORDER BY `sort_order` ASC
        ")->result();
        return $results;
    }

    public function get_promo_offers_by_id($id) {
    	$result = $this->db->query("SELECT * FROM `promo_offers` WHERE `id` = $id")->row();
    	return $result;
    }

    public function get_max_sort_order() {
        $result = $this->db->query("SELECT MAX(`sort_order`) AS `sort_order` FROM `promo_offers`")->row()->sort_order;
        return $result;
    }
}
