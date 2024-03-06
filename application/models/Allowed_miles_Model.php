<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allowed_miles_Model extends Ex_Model {

    protected $table_name = 'allowed_miles';
    protected $primary_key = 'id';
    public $where_column = 'id';
    public $postcodeMessage='Out of range';
    public $shopLatitude=0;
    public $shopLongitude=0;

    public function __construct() {
        parent::__construct();
    }

    public $rules = array(
        'delivery_radius_miles' => array(
            'field' => 'delivery_radius_miles',
            'label' => 'Delivery Radius Miles',
            'rules' => 'trim|required',
            'errors' => array('required' => 'You must provide %s.',),
        ),
        'delivery_charge' => array(
            'field' => 'delivery_charge',
            'label' => 'Delivery Charge',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide %s.',)
        ),
        'min_order_for_delivery' => array(
            'field' => 'min_order_for_delivery',
            'label' => 'Min Order For Delivery',
            'rules' => 'trim|required',
            'errors' => array('required' => 'Provide %s.',)
        )
    );

    public function is_allowed_miles_exists($delivery_radius_miles) {
        $this->search_column_name = 'delivery_radius_miles';
        return !empty($this->get_numbers_of_rows($delivery_radius_miles)) ? TRUE : FALSE;
    }
    
    public function is_allowed_miles_exists_for_update($id, $delivery_radius_miles) {
        $query = $this->db->query("SELECT * FROM allowed_miles WHERE id != $id AND delivery_radius_miles = '$delivery_radius_miles'")->row();
        return !empty($query) ? TRUE : FALSE;
    }


    public function getDistanceFromShop($deliverPostCode='') {
        $shopPostCode = get_shop_postcode();
        $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($shopPostCode).'&destinations='.urlencode($deliverPostCode).'&sensor=false';
        $distance = -1;
        $response = json_decode(file_get_contents($url));
        if (!empty($response)) {
            if (trim($response->status) == 'OK') {
                if(!empty($response->rows[0])){
                    $elements = $response->rows[0]->elements[0];
                    $distance = property_exists($elements,'distance')?$elements->distance->value:-1;
                    if ($distance > 0){
                        $miles = $distance*0.00062137;
                        $kilometers = $distance*0.001;
                        $meters = $distance;
                        $insert_data = array(
                            'from'=>$shopPostCode,
                            'to'=>trim($deliverPostCode),
                            'miles'=>number_format($miles,2),
                            'meters'=>$meters,
                            'kilometers'=>number_format($kilometers,2),
                        );
                        $this->Postcode_Distance_Model->insert_new($insert_data);
                    }
                } else {
                    $distance = -1;
                }
            } else {
                $distance = -1;
            }
        } else {
            $distance = -1;
        }

        if ($distance > 0) {
            $distance = $distance * 0.00062137;// meter to miles
        }
        return $distance;
    }


    public function getPostcodeDetailsFromEliposConsole($deliverPostCode = ''){
        $libGiantsCurl = new GiantsCurl();
        $url = 'http://localhost/order_monitoring/api/postcode/details';
        $libGiantsCurl->setPost(json_encode(array('postcode'=>$deliverPostCode,)));
        $response = $libGiantsCurl->createCurl($url.'/api/get_orders/set_order_status',null);

        return $response;
    }

    public function getLatLongFromGoogle($deliverPostCode = '') {
        $isValid = check_postcode_uk($deliverPostCode);
        if($isValid){
            $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($deliverPostCode);
            $response = json_decode(file_get_contents($url));
            if (!empty($response)) {
                if (trim($response->status) == 'OK') {
                    $result = $response->results[0];
                    if (!empty($result)) {
                        $geometry = $result->geometry;
                        // $address_components=$result->address_components;
                        if (!empty($geometry)) {
                            $location = $geometry->location;
                            $dataToSave = array(
                                'postcode'=>$deliverPostCode,
                                'latitude'=>$location->lat,
                                'longitude'=>$location->lng,
                                'country'=>'',
                                'county'=>'',
                                'district'=>'',
                                'postal_town'=>'',
                            );
                            $this->Postcode_Model->save_postcode($dataToSave);
                            return $location;
                        }
                    }
                    return null;
                } else {
                    // insert post code with latitude and longitude zero
                    $dataToSave=array(
                        'postcode'=>$deliverPostCode,
                        'latitude'=>0,
                        'longitude'=>0,
                        'country'=>'',
                        'county'=>'',
                        'district'=>'',
                        'postal_town'=>'',
                    );
                    $this->Postcode_Model->save_postcode($dataToSave);
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public  function getDistanceDeliveryCharge($postCode=''){
        $shopPostcode = get_shop_postcode();
        $postCode = formatUKPostcode($postCode);
        // get from list
        $existPostCode = $this->Postcode_Distance_Model->get_distance($shopPostcode,$postCode);
        if (!empty($existPostCode)) {
            return $this->get_allowed_miles($existPostCode->miles);
        } else{
            $distance= $this->Postcode_Model->get_distance($postCode);     
            if ($distance < 0) {
                $this->postcodeMessage="We can't detect your postcode";
                return null;
            } else {
                return $this->get_allowed_miles($distance);
            }
        }
    }


  /*  public  function getDistanceDeliveryCharge($postCode=''){
        $postCode=formatUKPostcode($postCode);
        $settings= get_company_details();
        $this->shopLongitude=get_property_value('longitude',$settings);$this->shopLatitude=get_property_value('latitude',$settings);
        $postcodeDetails=  $this->getPostcodeDetailsFromEliposConsole($postCode);
        $distance=-1;
      if(!empty($postcodeDetails)){
          $postcodeDetails=json_decode($postcodeDetails);
         $postcodeObj=(!empty($postcodeDetails))?$postcodeDetails->postcode:null;
         if(!empty($postcodeObj)){
             $distance=$this->distance_by_lat_long($this->shopLatitude,$this->shopLongitude,$postcodeObj->latitude,$postcodeObj->longitude);
         }else{
             $this->postcodeMessage="We can't detect your postcode";
         }
      }else{
          $this->postcodeMessage="We can't detect your postcode";
      }
        if($distance<0){
            $this->postcodeMessage="We can't detect your postcode";
         return null;
        }else{
            return $this->get_allowed_miles($distance);
        }

    }*/

    public function get_allowed_miles($miles=0){
        $this->db->where('delivery_radius_miles>='.$miles);
        $this->db->order_by('delivery_radius_miles','ASC');
        return  $this->db->get($this->table_name)->row();
    }

    public function get_miles_error_message(){
        return $this->postcodeMessage.', Please contact restaurant '.get_company_contact_number();
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
        } else {
            return -1;
        }

    }
}