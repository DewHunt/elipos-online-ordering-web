<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class House_information_model extends Ex_model {

    protected $table_name = 'allowed_postcodes';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }

    public function getHouseInformationByPostcode($postcode)
    {
        $postCodeDB = $this->load->database('postcode',true);
        $postcode = strtoupper(preg_replace('/\s+/', '', $postcode));
        $postcodeResult = $postCodeDB->query("SELECT OrganisationName, SubBuilding, BuildingName, BuildingNumber, ThoroughfareAndDescriptor, DependantThoroughfareAndDescriptor FROM HouseInformation WHERE UPPER(REPLACE(Postcode,' ','')) = '$postcode' LIMIT 10")->result();
        return $postcodeResult;
    }

    public function getPostcodeByString($postcode)
    {
        $postCodeDB = $this->load->database('postcode',true);
        $postcode = strtoupper(preg_replace('/\s+/', '', $postcode));
        // echo $postcode; exit();
        $postcodeResult = $postCodeDB->query("SELECT UPPER(REPLACE(Postcode,' ','')) AS Postcode FROM Postcode WHERE UPPER(REPLACE(Postcode,' ','')) LIKE '%$postcode%' LIMIT 20")->result();
        return $postcodeResult;
    }
}