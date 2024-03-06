<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Postcode_Model extends Ex_Model {

    protected $table_name = 'postcode';
    protected $primary_key = 'id';
    public $where_column = 'id';
    public $shopLatitude=0;
    public $shopLongitude=0;

    public function __construct() {
        parent::__construct();
    }

    public function get_postcode($start = 0,$limit = 0,$distance = '') {
        $settings = get_company_details();
        $shopLatitude = get_property_value('latitude',$settings);
        $shopLongitude = get_property_value('longitude',$settings);
        $have_query = "";
        $limit_query = "";

        if ($limit > 0) {
            $limit_query = "LIMIT $start, $limit";
        }

        if ($distance != '') {
            $have_query = "HAVING `distance` <= $distance";
        }

        $result = $this->db->query("
            SELECT *, ROUND(DEGREES(ACOS(LEAST(1.0,SIN(RADIANS($shopLatitude)) * SIN(RADIANS(`latitude`)) + COS(RADIANS($shopLatitude)) * COS(RADIANS(`latitude`)) * COS(RADIANS($shopLongitude - `longitude`))))) * 60 * 1.1515, 2) AS `distance`
            FROM `postcode` $have_query ORDER BY `distance` ASC $limit_query
        ")->result();
        return $result;
    }

    public function get_total_postcode() {
        $result = $this->db->query("SELECT * FROM `postcode`")->num_rows();
        return $result;
    }

    public function search_postcode($search_data = '') {
        $settings = get_company_details();
        $shopLatitude = get_property_value('latitude',$settings);
        $shopLongitude = get_property_value('longitude',$settings);
        $result =  '';
        
        if ($search_data != '') {
            $result = $this->db->query("
                SELECT *, ROUND(DEGREES(ACOS(LEAST(1.0,SIN(RADIANS($shopLatitude)) * SIN(RADIANS(`latitude`)) + COS(RADIANS($shopLatitude)) * COS(RADIANS(`latitude`)) * COS(RADIANS($shopLongitude - `longitude`))))) * 60 * 1.1515, 2) AS `distance`
                FROM `postcode` WHERE `postcode` LIKE '$search_data%' ORDER BY `distance` ASC
            ")->result();
        }
        return $result;
    }

    public function get_postcode_by_id($id = 0) {
        $result = '';
        if ($id > 0) {
            $result = $this->db->query("SELECT * FROM `postcode` WHERE `id` = $id")->row();
        }
        return $result;
    }

    public function is_postcode_exists($postcode = '', $id = 0) {
        $result = '';
        if ($id > 0) {
            $result = $this->db->query("SELECT  * FROM `postcode` WHERE `postcode` = '$postcode' AND `id` <> '$id'")->row();
        } else {
            $result = $this->db->query("SELECT  * FROM `postcode` WHERE `postcode` = '$postcode'")->row();
        }

        return $result;
    }

    public function get_distance($postcode = '') {
       $settings = get_company_details();
       $this->shopLongitude = get_property_value('longitude',$settings);
       $this->shopLatitude = get_property_value('latitude',$settings);

       if (!empty($postcode)) {
           $postcode = formatUKPostcode($postcode);
           $postcodeObj = $this->get_by(array('postcode' => trim($postcode)),true);

           if (!empty($postcodeObj)) {
               if (empty($postcodeObj->latitude) || empty($postcodeObj->longitude)){
                   return -1;
               } else {
                   return $this->distance_by_lat_long($this->shopLatitude,$this->shopLongitude,$postcodeObj->latitude,$postcodeObj->longitude);
               }
           } else {
               return -1;
           }
       } else {
           return -1;
       }
    }

    public  function distance_by_lat_long($lat1, $lon1, $lat2, $lon2, $unit='m') {
        if(!empty($lat1) && (!empty($lat2))){
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }else{
            return -1;
        }

    }

    public function save_postcode($data=array()){
        if(!empty($data)){
            $postcode=$data['postcode'];
            // check is exist
            $postcodeObj=$this->get_by(array(
                'postcode'=>$postcode
            ),true);
            if(!empty($postcodeObj)){
                // update if lat ,long exist
                return $this->save($data,$postcodeObj->id);
            }else{
                // insert
                return $this->save($data);

            }

        }
    }
}
