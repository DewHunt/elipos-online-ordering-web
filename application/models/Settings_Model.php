<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Model extends Ex_Model
{
    protected $table_name = 'settings';
    protected $primary_key = 'id';
    public $where_column= 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_name($name='') {
        return $this->get_by(array('name'=>trim($name)),true);
    }
    
    public function get_current_date_and_time() {
        date_default_timezone_set("Europe/London");
        return $current_date_time = date('Y-m-d H:i:s');
    }
}