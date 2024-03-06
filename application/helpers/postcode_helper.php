<?php

function postcode_by_limit() {
    $ci = &get_instance();
    $ci->load->model("Allowed_postcodes_Model");
    $postcode_by_limit = $ci->Allowed_postcodes_Model->get_postcode_by_limit();
    return $postcode_by_limit;
}
