<?php
class Customer_Notification_Model extends Ex_Model{

    protected $table_name = 'customer_notification';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_notification_by_id($id) {
        $result = $this->db->query("SELECT * FROM `customer_notification` WHERE `id` = $id")->row();
        return $result;
    }

    public function get_sent_notification() {
        $this->db->where('is_sent',1);
        $this->db->where('is_deleted',0);
        $this->db->order_by('sending_date','DESC');
       return $this->get();
    }

    public function get_draft_notification() {
        $this->db->where('is_sent',0);
        $this->db->where('is_deleted',0);
        $this->db->order_by('id','DESC');
        return $this->get();
    }

    public function get_deleted_notification() {
        $this->db->where('is_deleted',1);
        return $this->get();
    }

    public function get_customer_notification() {
        $this->db->where('is_sent',1);
        $this->db->where('is_deleted',0);
        $current_date = get_current_date_time('Y-m-d');
        $this->db->where('expired_date!=',null);
        $this->db->where('expired_date>=',$current_date);
        $this->db->order_by('sending_date','DESC');
        return $this->get();
    }

    public function get_api_customer_notification() {
        $current_date = get_current_date_time('Y-m-d');
        $results = $this->db->query("
            SELECT *
            FROM `customer_notification`
            WHERE `is_sent` = 1 AND `is_deleted` = 0
            ORDER BY `sending_date` DESC
        ")->result();
        return $results;
    }
}