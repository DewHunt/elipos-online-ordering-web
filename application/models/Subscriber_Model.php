<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscriber_Model extends Ex_Model
{
    protected $table_name = 'subscriber';
    protected $primary_key = 'id';
    public $where_column = 'email';

    public function __construct()
    {
        parent::__construct();
    }


    public $subscriber_add_rules = array(

        'email' => array(
            'field' => 'email',
            'label' => 'email address',
            'rules' => 'trim|required|valid_email|is_unique[subscriber.email]',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'valid_email' => 'You  provided  %s is not valid .',
                'is_unique' => 'This %s is already subscribed .',
            ),
        ),
    );

    public $subscriber_edit_rules = array(

        'id' => array(
            'field' => 'id',
            'label' => 'id',
            'rules' => 'trim|required',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
            ),
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email',
            'errors' => array(
                'required' => 'You must provide a valid %s.',
                'valid_email' => 'You  provided  %s is not valid.',
            ),
        ),
    );
}