<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_order_Model extends Ex_Model
{
    protected $table_name = 'new_order';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }
}