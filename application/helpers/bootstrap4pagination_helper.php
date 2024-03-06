<?php
function get_pagination($dataArray=array()){
    // base_url('admin/user/user_curd')
    $CI =& get_instance();
    $CI->load->library('pagination');
    $config = [
        'base_url' =>$dataArray['base_url'],
        'per_page' => $dataArray['per_page'],
        'total_rows' =>$dataArray['total_rows'] ,// set where as primary key then pass the value
        'full_tag_open' => '<nav><ul class="pagination">',
        'full_tag_close' => '</ul></nav>',
        'first_tag_open' => '<li class="page-item">',
        'first_tag_close' => '</li>',
        'prev_tag_open' => '<li class="page-item">',
        'prev_tag_close' => '</li>',
        'next_tag_open' => '<li class="page-item">',
        'next_tag_close' => '</li>',
        'last_tag_open' => '<li class="page-item"> ',
        'last_tag_close' => '</li>',
        'num_tag_open' => '<li class="page-item">',
        'num_tag_close' => '</li>',
        'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
        'cur_tag_close' => '</a></li>',
        'attributes' => array('class' => 'page-link'),
        'rel' => false,
        'num_links' => 15,
        'first_link' => false,
        'last_link' => false,
        'next_link' => 'Next',
        'prev_link' => 'Previous',

    ];

    $CI->pagination->initialize($config);

    return  $CI->pagination->create_links();


}