<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ex_Controller extends CI_Controller
{
    public $data = array();
    public function __construct() {
        parent::__construct();
        // date_default_timezone_set('ASIA/Dhaka');
        date_default_timezone_set('Europe/London');
        // Your own constructor code
    }
}