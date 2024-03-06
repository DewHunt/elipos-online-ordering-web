<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_Settings_Model extends Ex_Model
{
    protected $table_name = 'page_settings';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function get_by_name($name = '') {
        return $this->get_by(array('name'=>trim($name),),true);
    }

    public function isShow($pages, $name) {
        if (!empty($pages) && !empty($name)) {
            $pages_array = !empty($pages)?json_decode(json_encode($pages),true):array();
            $pages_as_name = array_column($pages_array,'is_show','name');
            return array_key_exists($name,$pages_as_name)?$pages_as_name[$name]:0;
        } else {
            return 0;
        }
    }
}