<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_Settings_Model extends Ex_Model
{
    protected $table_name = 'app_settings';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_by_name($name = '') {
        return $this->get_by(array('name'=>trim($name),),true);
    }

    public function get_value_by_name($name = '') {
        $data = $this->get_by(array('name'=>trim($name),),true);
        return (!empty($data)) ? $data->value : '';
    }

    public function get_decoded_value_by_name($name = '') {
        $data = $this->get_by(array('name'=>trim($name),),true);
        $data = $data ? $data->value : null;
        $data = $data ? json_decode($data) : '';
        return $data;
    }

    public function save_by_name($name = '',$value = '') {
        $existName = $this->get_by_name($name);
        if (empty($existName)) {
            // insert new
            return $this->save(array('name'=>$name,'value'=>$value));
        } else {
            // update
            $id = $existName->id;
            return $this->save(array('name'=>$name,'value'=>$value),$id);
        }
    }
}