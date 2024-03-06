<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postcode_Distance_Model extends Ex_Model
{
    protected $table_name = 'postcode_distance';
    protected $primary_key = 'id';
    public $where_column= 'id';

    public function __construct()
    {
        parent::__construct();

    }


    public function get_distance($from,$to){

        return $this->get_by(array('from'=>$from,'to'=>$to),true);

    }

    public function insert_new($data=array()){
        if(!empty($data)){
            $from=$data['from'];
            $to=$data['to'];
            $distance_miles=$this->get_by(array('from'=>$from,'to'=>$to),true);
            if(empty($distance_miles)){
                return $this->save($data);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}