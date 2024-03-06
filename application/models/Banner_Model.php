<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_Model extends Ex_Model
{

    protected $table_name = 'banner';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();

    }
}