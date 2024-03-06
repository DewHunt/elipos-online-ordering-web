<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ex_Model extends CI_Model {

    protected $table_name = '';
    protected $primary_key = 'id';
    protected $primary_filter = 'intval';
    public $order_by = '';
    public $order = '';
    public $rules = array();
    public $limit = 0;
    public $offset = 0;
    public $where_column;

    public function __construct() {
        parent::__construct();
    }

    public function data_form_post($dataFields) {
        $dataArray = array();
        foreach ($dataFields as $field) {
            $dataArray[$field] = $this->input->get_post($field);
        }
        return $dataArray;
    }

    public function get($id = null, $single = false) {
        if ($id != null) {
            $filter = $this->primary_filter;
            $id = $filter($id);
            if (!$id) {
                return false;
            }
            $this->db->where($this->primary_key, $id);
            $method = 'row';
            return $this->db->get($this->table_name)->$method();
        } else if ($single == true) {
            $method = 'row';
            return $this->db->get($this->table_name)->$method();
        } else {
            $method = 'result';
            return $this->db->limit($this->limit, $this->offset)->get($this->table_name)->$method();
        }
    }

    public function get_by($wheres = array(), $single = false) {
        foreach ($wheres as $key => $value) {
            $this->db->where(trim($key), trim($value));
        }
        return $this->get(null, $single);
    }

    public function get_order_by() {
        $this->db->order_by($this->order_by, $this->order);
        return $this->get();
    }

    public function save($data, $id = null) {
        if ($id == null) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->set($data);
            $this->db->where($this->where_column, $id);
            return $this->db->update($this->table_name);
        }
    }

    public function delete($id) {
        $filter = $this->primary_filter;
        $id = $filter($id);
        if (!$id) {
            return false;
        }
        $this->db->where($this->primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

    public function delete_where($wheres = array(), $single = true) {

        if (!empty($wheres)) {
            $this->db->where($wheres);
            if ($single) {
                $this->db->limit(1);
            }
            return $this->db->delete($this->table_name);
        } else {
            return false;
        }
    }

    public $search_column_name;

    public function get_numbers_of_rows($value = null) {
        if (empty($this->search_column_name) || $this->search_column_name == null) {
            $this->search_column_name = $this->primary_key;
        }
        return $value != null ? $this->db->where(trim($this->search_column_name), trim($value))->count_all_results($this->table_name) : $this->db->count_all($this->table_name);
    }

    public function queryString($sqlString) {
        return $this->db->query($sqlString)->row();
    }

    public function get_where($column, $value) {
        return $this->db->get_where($this->table_name, array($column => $value), $this->limit, $this->offset)->result();
    }

    public function get_table_name() {
        return $this->table_name;
    }

    public function get_total_rows() {
        return $this->db->get($this->table_name)->num_rows();
    }

    public function count() {
        return $this->db->count_all_results($this->table_name);
    }

    public function insert_batch($data = array()) {
        if (!empty($data)) {
            return $this->db->insert_batch($this->table_name, $data);
        } else {
            return false;
        }
    }

    public function clean_table() {
        $this->db->truncate($this->table_name);
    }

}
