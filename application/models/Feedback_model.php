<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends Ex_Model {
    protected $table_name = 'feedbacks';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_feedbacks() {
        $results = $this->db->query("SELECT * FROM `feedbacks` ORDER BY `created_at` DESC")->result();
        return $results;
    }

    public function get_all_approved_feedbacks() {
        $results = $this->db->query("SELECT * FROM `feedbacks` WHERE `is_approved` = 1 ORDER BY `created_at` DESC")->result();
        return $results;
    }

    public function get_all_highest_to_lowest_feedbacks() {
        $results = $this->db->query("SELECT * FROM `feedbacks` WHERE `is_approved` = 1 ORDER BY `ratings` DESC")->result();
        return $results;
    }

    public function get_all_lowest_to_highest_feedbacks() {
        $results = $this->db->query("SELECT * FROM `feedbacks` WHERE `is_approved` = 1 ORDER BY `ratings` ASC")->result();
        return $results;
    }

    public function get_feedback_by_id($id) {
        $results = $this->db->query("SELECT * FROM `feedbacks` WHERE `id` = $id")->row();
        return $results;
    }

    public function get_average_ratings() {
        $result = $this->db->query("SELECT ROUND((SUM(`ratings`)/COUNT(*)),2) AS `average` FROM `feedbacks` WHERE `is_approved` = 1")->row()->average;
        return $result;
    }

    public function get_ratings_wise_total($rating) {
        $result = $this->db->query("SELECT COUNT(*) AS `total` FROM `feedbacks` WHERE `ratings` >= $rating AND `ratings` < ($rating + 1) AND `is_approved` = 1")->row()->total;
        return $result;
    }

    public function get_ratings_total() {
        $result = $this->db->query("SELECT COUNT(*) AS `total` FROM `feedbacks` WHERE `is_approved` = 1")->row()->total;
        return $result;
    }
}
