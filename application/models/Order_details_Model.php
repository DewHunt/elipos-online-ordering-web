<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_details_Model extends Ex_Model
{
    protected $table_name = 'order_details';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_orders_id($order_id){
        $this->db->where('order_id',$order_id);
        return $this->get();
    }

    public function get_total_quantity_by_order_id($order_id){
        $this->db->select_sum('quantity');
        $this->db->where('order_id',$order_id);
        return $this->db->get($this->table_name)->row()->quantity;
    }

    public function get_top_sellings_product($limit = 5,$from_date = '',$to_date = '') {
        $where_query = "";
        if ($from_date && $to_date) {
            $where_query .= " WHERE DATE_FORMAT(`item_order_time`,'%Y-%m-%d') BETWEEN '$from_date' AND '$to_date' ";
        }
        $result = $this->db->query("
            SELECT *,sum(`quantity`) AS `qty` ,sum(`amount`) AS `amt`
            FROM `order_details`
            $where_query
            GROUP BY `product_id`
            ORDER BY `amt` DESC
            LIMIT $limit"
        )->result();
        // dd($this->db->last_query());
        return $result;
    }

    public function get_top_sellings_product_info($limit = 0,$from_date = '',$to_date = '') {
        $where_query = "";
        $limit_query = "";
        if ($from_date && $to_date) {
            $where_query .= " WHERE DATE_FORMAT(`order_details`.`item_order_time`,'%Y-%m-%d') BETWEEN '$from_date' AND '$to_date' ";
        }

        if ($limit > 0) {
            $limit_query .= "LIMIT $limit";
        }

        $results = $this->db->query("
            SELECT `fooditem`.`foodItemName`,`category`.`categoryName`,`fooditem`.`description`,SUM(`order_details`.`quantity`) AS `quantity` ,SUM(`order_details`.`amount`) AS `amount`
            FROM `order_details`
            LEFT JOIN `fooditem` ON `fooditem`.`foodItemId` = `order_details`.`product_id`
            LEFT JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            $where_query
            GROUP BY `order_details`.`product_id`
            ORDER BY `amount` DESC
            $limit_query
        ")->result();
        // dd($this->db->last_query());
        return $results;
    }

    public function getForDesktop($conditions=array(),$single=false){
        $this->db->select('order_details.id as id,order_details.product_id as product_id,order_details.selection_item_id as selection_item_id,order_details.order_id as order_id, order_details.product_name as name,order_details.quantity as qty,order_details.unit_price as price,order_details.buy_get_amount as buy_get_amount,(order_details.amount - order_details.buy_get_amount) as amount,order_details.cat_level as cat_level,order_details.item_comments,category.SortOrder as category_sort_order,category.categoryName,fooditem.SortOrder as product_sort_order ');
        $this->db->join('fooditem','order_details.product_id=fooditem.foodItemId');
        $this->db->join('category','category.categoryId=fooditem.categoryId','inner');
        $this->db->order_by('fooditem.SortOrder','ASC');
        $this->db->where($conditions);
        if($single){
            return  $this->db->get($this->table_name)->row_array();

        }else{
            return $this->db->get($this->table_name)->result_array();
        }
    }

    public function getDetails($conditions=array(),$single=false){
        $this->db->select('*');
        $this->db->where($conditions);
        if ($single) {
            return  $this->db->get($this->table_name)->row();

        } else {
            return $this->db->get($this->table_name)->result();
        }
    }

    public function get_sell_item_report($from_date,$to_date,$category_id,$product_id) {
        $where_condition = "";

        if ($from_date && $to_date) {
            $where_condition .= "DATE_FORMAT(`item_order_time`,'%Y-%m-%d') BETWEEN '$from_date' AND '$to_date'";
        }

        if ($category_id) {
            if ($where_condition != "") {
                $where_condition .= " AND ";
            }
            $where_condition .= "`category`.`categoryId` IN ($category_id)";
        }


        if ($product_id) {
            if ($where_condition != "") {
                $where_condition .= " AND ";
            }
            $where_condition .= "`order_details`.`product_id` IN ($product_id)";
        }

        if ($where_condition != "") {
            $where_condition = "WHERE ".$where_condition;
        }

        $results = $this->db->query("
            SELECT `order_details`.`order_id`,`category`.`categoryId`,`category`.`categoryName`,`order_details`.`product_id`,`order_details`.`product_name`,MAX(`order_details`.`regular_price`) AS `price`,SUM(`order_details`.`quantity`) AS `quantity`,ROUND((MAX(`order_details`.`regular_price`)*SUM(`order_details`.`quantity`)),2) AS `total_amount`
            FROM `order_details`
            LEFT JOIN `fooditem` ON `fooditem`.`foodItemId` = `order_details`.`product_id`
            LEFT JOIN `category` ON `category`.`categoryId` = `fooditem`.`categoryId`
            $where_condition
            GROUP BY `order_details`.`product_id`
            ORDER BY `category`.`categoryId` ASC
        ")->result();

        return $results;
    }
}