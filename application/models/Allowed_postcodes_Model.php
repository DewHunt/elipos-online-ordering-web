<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Allowed_postcodes_Model extends Ex_Model {

    protected $table_name = 'allowed_postcodes';
    protected $primary_key = 'id';
    public $where_column = 'id';

    public function __construct() {
        parent::__construct();
    }

    public $rules = array(
        'postcode' => array(
            'field' => 'postcode',
            'label' => 'Postcode',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide %s.',
            ),
        ),
        'delivery_charge' => array(
            'field' => 'delivery_charge',
            'label' => 'Delivery Charge',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'Provide %s.',
            )
        ),
        'min_order_for_delivery' => array(
            'field' => 'min_order_for_delivery',
            'label' => 'Min Order For Delivery',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'Provide %s.',
            )
        )
    );

    public function get_area_coverage_by_postcode($postcode) {
        if (!empty($postcode)) {
            $query = $this->db->get_where($this->table_name, array('postcode' => $postcode));
        } else {
            $postcode_first_three = substr($postcode, 0, 3);
            $query = $this->db->get_where($this->table_name, array('postcode' => $postcode_first_three));
        }
        return $query->row();
    }

    public function is_valid_post_code($postcode){
        $postcode=formatUKPostcode($postcode);
        $postcode=preg_replace('/\s+/', '', $postcode);
        if(!empty($postcode)){
            $all_postcodes=$this->get();
            foreach ($all_postcodes as $postcode_obj){
                $comparePostcode=$postcode_obj->postcode;
                $comparePostcode=formatUKPostcode($comparePostcode);
                $comparePostcode=preg_replace('/\s+/', '', $comparePostcode);
                $db_post_code_length=strlen($comparePostcode);
                $first_n_code=substr($postcode, 0, $db_post_code_length);
                if(strcasecmp($first_n_code,$comparePostcode)==0){
                    return $postcode_obj;
                }
            }
            return null;
        }else{
            return null;
        }
    }

    public function get_delivery_charge_by_postcode($postcode){
        $postcode=formatUKPostcode($postcode);
        $postcode=preg_replace('/\s+/', '', $postcode);
        if(!empty($postcode)){
            $all_postcodes=$this->get();
            foreach ($all_postcodes as $postcode_obj){
                $comparePostcode=$postcode_obj->postcode;
                $comparePostcode=formatUKPostcode($comparePostcode);
                $comparePostcode=preg_replace('/\s+/', '', $comparePostcode);
                $db_post_code_length=strlen($comparePostcode);
                $first_n_code=substr($postcode, 0, $db_post_code_length);
                if(strcasecmp($first_n_code,$comparePostcode)==0){
                    return $postcode_obj;
                }
            }
            return null;
        }else{
            return null;
        }
    }

    public function get_postcode_by_limit($limit = 20) {
        $query = $this->db->query("SELECT * FROM `allowed_postcodes` LIMIT 0, $limit");
        return $query->result();
    }

    public function get_area_by_postcode($postcode) {
        if (!empty($postcode)) {
            $query = $this->db->get_where($this->table_name, array('postcode' => $postcode));
            return $query->row();
        }else{
            return null;
        }

    }

    public function is_postcode_exists($postcode) {
        $this->search_column_name = 'postcode';
        return !empty($this->get_numbers_of_rows($postcode)) ? TRUE : FALSE;
    }

    public function is_postcode_exists_for_update($id, $postcode) {
        $query = $this->db->query("SELECT * FROM allowed_postcodes WHERE id != $id AND postcode = '$postcode'")->row();
        return !empty($query) ? TRUE : FALSE;
    }

}
