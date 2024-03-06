<?php
function get_client_company_name($id=0){
    $CI=&get_instance();
    $CI->load->model('Client_Model');
    return $CI->Client_Model->get($id,true)->name;
}