<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_Model extends Ex_Model
{

    protected $table_name = 'cards';
    protected $primary_key = 'id';
  
  public $where_column='id';

    public function __construct()
    {
        parent::__construct();
    }


  public function getAllCardsByCustomerId($customerId=0){
        return $this->get_by(array(
           'customer_id'=> $customerId
        ));

    }

    public function getAllCardsForAutoComplete($customerId=0){

        $this->db->select('card_name as label, card_number as value');
        $this->db->where('customer_id',$customerId);
       $cards_as_name= $this->db->get($this->table_name)->result();
        $this->db->select('card_number as label, card_number as value');
        $this->db->where('customer_id',$customerId);
        $cards_as_number= $this->db->get($this->table_name)->result();

        $cards=array_merge($cards_as_name,$cards_as_number);
        return $cards;

    }


}