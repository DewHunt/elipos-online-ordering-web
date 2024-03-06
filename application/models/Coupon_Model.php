<?php
class Coupon_Model extends Ex_Model
{
    protected $table_name = 'coupons';
    protected $primary_key = 'id';
    public $where_column = 'id';


    public $add_rules = array(
        'code' => array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => 'trim|required|is_unique[coupons.code]',
            'errors' => array('required' => 'You must provide  %s.','is_unique' => 'code must be unique  %s.'),
        ),
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'min_order_amount' => array(
            'field' => 'min_order_amount',
            'label' => 'Minimum Order Amount',
            'rules' => 'trim|required|numeric',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'discount_type' => array(
            'field' => 'discount_type',
            'label' => 'Discount Type',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'discount_amount' => array(
            'field' => 'discount_amount',
            'label' => 'Discount Amount',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'remaining_usages' => array(
            'field' => 'remaining_usages',
            'label' => 'Maximum Usage Time',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
    );
    public $edit_rules = array(
        'code' => array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'title' => array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'min_order_amount' => array(
            'field' => 'min_order_amount',
            'label' => 'Minimum Order Amount',
            'rules' => 'trim|required|numeric',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'start_date' => array(
            'field' => 'start_date',
            'label' => 'Validity',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'discount_type' => array(
            'field' => 'discount_type',
            'label' => 'Discount Type',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'discount_amount' => array(
            'field' => 'discount_amount',
            'label' => 'Discount Amount',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
        'remaining_usages' => array(
            'field' => 'remaining_usages',
            'label' => 'Maximum Usage Time',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.'),
        ),
    );

    public function __construct() {
        parent::__construct();
    }

    public function get_coupon_reports($start_date,$end_date,$coupon_ids) {
        $where_condition = "";

        if ($start_date && $end_date) {
            $where_condition .= "WHERE DATE_FORMAT(`order_information`.`order_time`,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }

        if ($coupon_ids) {
            if ($where_condition == "") {
                $where_condition .= "WHERE ";
            } else {
                $where_condition .= " AND ";
            }

            $where_condition .= "`order_information`.`coupon_id` IN ($coupon_ids)";
        }

        $results = $this->db->query("
            SELECT `coupons`.*,COUNT(`order_information`.`coupon_id`) AS `total_coupon_usages`
            FROM `coupons`
            INNER JOIN `order_information` ON `order_information`.`coupon_id` = `coupons`.`id`
            $where_condition
            GROUP BY `order_information`.`coupon_id`
        ")->result();

        return $results;
    }

    public function get_coupon_reports_details_by_coupon_id($coupon_id) {
        $results = $this->db->query("
            SELECT `order_information`.`customer_id`,CONCAT(`customer`.`title`,' ',`customer`.`first_name`,' ',`customer`.`last_name`) AS `customer_name`,`customer`.`email`,`customer`.`mobile`,COUNT(`order_information`.`coupon_id`) As `total_coupon_usages`
            FROM `order_information`
            LEFT JOIN `customer` ON `customer`.`id` = `order_information`.`customer_id`
            WHERE `order_information`.`coupon_id` = $coupon_id
            GROUP BY `order_information`.`customer_id`
        ")->result();

        return $results;
    }
}