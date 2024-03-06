<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Order_Model extends Ex_Model
{

    protected $table_name = 'card_order';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct()
    {
        parent::__construct();

    }
}