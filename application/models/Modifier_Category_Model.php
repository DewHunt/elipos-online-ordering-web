<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modifier_Category_Model extends Ex_Model {
    protected $table_name = 'modifier_category';
    protected $primary_key = 'ModifierCategoryId';
    public  $where_column = 'ModifierCategoryId';
    public function __construct() {
        parent::__construct();
    }

    public $add_rules = array(
        'ModifierCategoryName' => array(
            'field' => 'ModifierCategoryName',
            'label' => 'Name',
            'rules' => 'trim|required|is_unique[modifier_category.ModifierCategoryName]',
            'errors' => array('required' => 'You must provide a valid %s.','is_unique'     => 'This %s already exists.'),
        ),
        'ModifierLimit' => array(
            'field' => 'ModifierLimit',
            'label' => 'Limit',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
    );
    public $edit_rules = array(
        'ModifierCategoryId' => array(
            'field' => 'ModifierCategoryId',
            'label' => 'Id',
            'rules' => 'trim|required',
            'errors' =>array('required' => 'You must provide a valid %s.',),
        ),
        'ModifierCategoryName' => array(
            'field' => 'ModifierCategoryName',
            'label' => 'Name',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide a valid %s.',),
        ),
        'ModifierLimit' => array(
            'field' => 'ModifierLimit',
            'label' => 'Limit',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide  %s.',),
        ),
    );

    public function get_all(){
        $this->db->order_by('ModifierCategoryName','ASC');
        return $this->get();
    }

    public function get_ids(){
        $this->db->select('ModifierCategoryId');
        $this->db->from($this->table_name);
        return $this->db->get()->result_array();
    }

    public function is_category_id_exist($id = 0) {
        $this->where_column = 'ModifierCategoryId';
        return $this->get($id, true);
    }
    
    
       public function get_modifier_category_by_id($id) {
      
        $result = $this->db->query("SELECT * FROM `modifier_category` WHERE `ModifierCategoryId` = '$id' ")->row();
        return $result;
    }

    public function is_modifier_category_name_exists($name = '',$id = 0) {
        $where_condition = "";
        if ($id > 0) {
            $where_condition = "AND `ModifierCategoryId` <> $id";
        }
        $result = $this->db->query("SELECT * FROM `modifier_category` WHERE `ModifierCategoryName` = '$name' $where_condition")->row();
        return $result;
    }

    public function get_max_sort_order() {
        $result = $this->db->query("SELECT MAX(`SortOrder`) AS `SortOrder` FROM `modifier_category`")->row()->SortOrder;
        return $result;
    }
}