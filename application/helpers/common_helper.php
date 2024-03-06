<?php

function dd($value = '') {
    echo "<pre>"; print_r($value); echo "</pre>"; exit();
}

function get_week_name_array() {
    $days = array(
        'sunday,monday,tuesday,wednesday,thursday,friday,saturday' => 'All Days',
        'sunday' => 'Sunday',
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
    );
    return $days;
}

function get_order_type_array() {
    $order_types = array(
        'delivery,collection,dine_in' => 'Delivery, Collection And Dine-In',
        'delivery,collection' => 'Delivery And Collection',
        'dine_in' => 'Dine-in'
    );
    return $order_types;
}

function is_user_permitted($menu_link = '') {
    $these = &get_instance();
    if ($these->User_Model->loggedin()) {
        $loggedin_user_role_id = $these->session->userdata('user_role');

        if ($loggedin_user_role_id == 1) {
            return true;
        }

        $user_role_info = $these->User_role_model->get_user_role_by_id($loggedin_user_role_id);

        if ($menu_link && $user_role_info) {
            if ($user_role_info->menu_permission) {
                $these->load->model('Menu_model');
                $menu_info = $these->Menu_model->get_menu_by_menu_link($menu_link);
                if ($menu_info) {
                    $menu_permission_array = explode(',', $user_role_info->menu_permission);
                    return in_array($menu_info->id, $menu_permission_array);
                }
                return false;
            }
            return false;
        }
        return false;
    }
    return false;
}

function image_upload($input_field_name,$files,$upload_path,$file_name = '') {
    $these = &get_instance();
    $path = '';
    if ($files && $upload_path) {
        $new_name = $files['name'];
        $config['file_name'] = time();
        if ($file_name) {
            $config['file_name'] = $file_name;
        }

        if (!file_exists($upload_path)) {
            mkdir($upload_path);
        }
        $config['upload_path'] = $upload_path;
        // $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
        $config['allowed_types'] = '*';
        $these->load->library('upload', $config);
        $these->upload->initialize($config);
        $is_upload = $these->upload->do_upload($input_field_name);
        $upload_info = array('upload_data' => $these->upload->data());

        if ($is_upload) {
            $path = $upload_path.$upload_info['upload_data']['file_name'];
        }
    }
    return $path;
}

function multiple_image_upload($input_field_name,$upload_path) {
    $paths_array = array();
    if (!empty($upload_path) && !empty($input_field_name)) {
        $these = &get_instance();
        $files = $_FILES;
        $total_image = count($files[$input_field_name]['name']);

        if (!file_exists($upload_path)) {
            mkdir($upload_path);
        }

        for ($i = 0; $i < $total_image; $i++) {
            $_FILES['single_image']['name'] = $files[$input_field_name]['name'][$i];
            $_FILES['single_image']['type'] = $files[$input_field_name]['type'][$i];
            $_FILES['single_image']['tmp_name'] = $files[$input_field_name]['tmp_name'][$i];
            $_FILES['single_image']['error'] = $files[$input_field_name]['error'][$i];
            $_FILES['single_image']['size'] = $files[$input_field_name]['size'][$i];
            // dd(mime_content_type($_FILES['single_image']['tmp_name']));

            if ($_FILES['single_image']) {
                $new_name = $_FILES['single_image']['name'];
                $config['file_name'] = $new_name;
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = '*';
                $these->load->library('upload', $config);
                $is_upload = $these->upload->do_upload('single_image');
                // dd($these->upload->display_errors());
                $upload_info = array('upload_data' => $these->upload->data());

                if ($is_upload) {
                    $path = $upload_path.$upload_info['upload_data']['file_name'];
                    array_push($paths_array, $path);
                }
            }
        }
    }
    return $paths_array;
}

function generate_random_string($length = 10, $dashed_number = 0, $string_type = 'all', $user_def_characters = '') {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';

    if ($string_type == 'num') { $characters = '0123456789'; }
    else if ($string_type == 'up') { $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
    else if ($string_type == 'low') { $characters = 'abcdefghijklmnopqrstuvwxyz'; }
    else if ($string_type == 'num-up') { $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
    else if ($string_type == 'num-low') { $characters = '0123456789abcdefghijklmnopqrstuvwxyz'; }
    else if ($string_type == 'up-low') { $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
    else if ($string_type == 'user-def') { $characters = $user_def_characters; }

    if ($dashed_number > 0) {
        for ($i = 0; $i < $dashed_number; $i++) {
            $random_string .= substr(str_shuffle(str_repeat($characters, ceil($length/strlen($characters)))),1,$length)."-";
        }
        $random_string .= substr(str_shuffle(str_repeat($characters, ceil($length/strlen($characters)))),1,$length);
    } else {
        $random_string = substr(str_shuffle(str_repeat($characters, ceil($length/strlen($characters)))),1,$length);
    }
    
    return $random_string;
}

function get_flash_message() {
    $CI =& get_instance();
    return $CI->session->flashdata('f_message');
}

function get_current_day_name($value='') {
    return date('l');
}

function set_flash_message($message = '') {
    $CI =& get_instance();
    $CI->session->set_flashdata('f_message', $message);
}

function set_flash_save_message($message = '') {
    $CI =& get_instance();
    $CI->session->set_flashdata('save_message', $message);
}
function get_flash_save_message() {
    $CI =& get_instance();
    return $CI->session->flashdata('save_message');
}

function set_flash_error_message($message = '') {
    $CI =& get_instance();
    $CI->session->set_flashdata('error_message', $message);
}
function get_flash_error_message() {
    $CI =& get_instance();
    return $CI->session->flashdata('error_message');
}

function set_flash_form_data($data = array()) {
    $CI =& get_instance();
    $CI->session->set_flashdata('form_data', $data);
}

function get_flash_form_data() {
    $CI =& get_instance();
    return $CI->session->flashdata('form_data');
}

function get_array_key_value($key = '',$data = array(),$default='') {
    if (!empty($key) && !empty($data)) {
        $value = array_key_exists($key, $data) ? $data[$key] : $default;
        return (empty($value)) ? $default : $value;
    } else {
        return $default;
    }
}

function get_property_value($key,$object,$default = '') {
    if (!empty($object)) {
        $value = property_exists($object, $key) ? $object->$key : $default;
        return (empty($value)) ? $default : $value;
    } else {
        return $default;
    }
}

function getDaysText($number_of_day) {
    if ($number_of_day > 0) {
        if ($number_of_day >= 30) {
            $months = intdiv($number_of_day,30);
            $weeks = intdiv(($number_of_day % 30),7);
            $days = ($number_of_day % 30) % 7;
            $output = $months." Months ";
            if ($weeks > 0) {
                $output .= $weeks." Weeks ".$days." Days";
            } elseif ($days > 0) {
                $output .= $days." Days";
            }
            return $output;
        } elseif ($number_of_day >= 7) {
            $weeks = intdiv($number_of_day,7);
            $days = $number_of_day % 7;
            $output = $weeks." Weeks ";            
            if ($days > 0) {
                $output .= $days." Days";
            }
            return $output;
        }
    }
    return $number_of_day." Days";
}

function get_redirect_string() {
    $CI =& get_instance();
    return $CI->session->userdata('redirect_string');}

function set_redirect_string($value = null) {
    $CI =& get_instance();
    if (!empty($value)) {
        $CI->session->set_userdata('redirect_string', $value);
    }
}

function unset_redirect_string() {
    $CI =& get_instance();
    $CI->session->unset_userdata('redirect_string');
}

function get_current_date_time($format = 'Y-m-d H:m:s') {
    return date($format);
}

function get_customer_full_name($customer = null) {
    if (!empty($customer)) {
        $title = $customer->title;
        $title = (!empty($title)) ? strpos($title, '.') ? $title : $title . '.' : '';
        $first_name = $customer->first_name;
        $last_name = $customer->last_name;
        return $name = (empty($title)) ? $first_name . ' ' . $last_name : $title . ' ' . $first_name . ' ' . $last_name;
    } else {
        return '';
    }
}

function get_customer_delivery_address_with_post_code($customer = null) {
    $delivery_address = "";
    if ($customer) {
        if ($customer->delivery_address_line_1) {
            $delivery_address = $customer->delivery_address_line_1.", ".$customer->delivery_postcode;
        } else if ($customer->delivery_address_line_2) {
            $delivery_address = $customer->delivery_address_line_2.", ".$customer->delivery_postcode;
        }
    }
    return $delivery_address;
}

function get_customer_full_delivery_address($customer = null) {
    if (!empty($customer)) {
        $address = $customer->delivery_address_line_1;
        return (!empty($address)) ? $address . '<br>' . $customer->delivery_address_line_2 : $customer->delivery_address_line_2;
    } else {
        return '';
    }
}

function print_array($data) {
    if (is_array($data)) {
        echo '<pre>'; print_r($data); echo '</pre>';
    } else {
        print_r((array)$data);
    }
}

function numberToRoman($num) {
    // Make sure that we only use the integer portion of the value
    $n = intval($num);
    $result = '';
    // Declare a lookup array that we will use to traverse the number:
    $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($n / $value);
        // Store that many characters
        $result .= str_repeat($roman, $matches);
        // Substract that from the number
        $n = $n % $value;
    }
    // The Roman numeral should be built, return it
    return $result;
}


function get_develop_by() {
    return '<a href="http://elipos.co.uk/" target="_blank">&copy; Developed By Elipos Systems</a>';
}


function set_userdata($key_name = '', $data = '') {
    $CI =& get_instance();
    $CI->session->set_userdata($key_name, $data);
}

function get_userdata($key_name = '') {
    $CI =& get_instance();
    return $CI->session->userdata($key_name);
}

function has_userdata($key_name = '') {
    $CI =& get_instance();
    return $CI->session->has_userdata($key_name);
}

function is_url_exist($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // dd($code);
    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function formatUKPostcode($postcode) {
    $postcode = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $postcode));
    if (!empty($postcode)) {
        if (strlen($postcode) == 5) {
            //$postcode = preg_replace('/\s+/', '', $postcode);
            $postcode = substr($postcode, 0, 2) . ' ' . substr($postcode, 2, 3);
        } elseif (strlen($postcode) == 6) {
            $postcode = substr($postcode, 0, 3) . ' ' . substr($postcode, 3, 3);
        } elseif (strlen($postcode) == 7) {
            $postcode = substr($postcode, 0, 4) . ' ' . substr($postcode, 4, 3);
        }
    }
    return $postcode;
}

function check_postcode_uk($original_postcode) {
    // Set callback's custom error message (CI specific)
    // $this->set_message('check_postcode_uk', 'Invalid UK postcode format.');

    // Permitted letters depend upon their position in the postcode.
    // Character 1
    $alpha1 = "[abcdefghijklmnoprstuwyz]";
    // Character 2
    $alpha2 = "[abcdefghklmnopqrstuvwxy]";
    // Character 3
    $alpha3 = "[abcdefghjkpmnrstuvwxy]";
    // Character 4
    $alpha4 = "[abehmnprvwxy]";
    // Character 5
    $alpha5 = "[abdefghjlnpqrstuwxyz]";

    // Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
    $pcexp[0] = '/^(' . $alpha1 . '{1}' . $alpha2 . '{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})$/';

    // Expression for postcodes: ANA NAA
    $pcexp[1] = '/^(' . $alpha1 . '{1}[0-9]{1}' . $alpha3 . '{1})([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})$/';

    // Expression for postcodes: AANA NAA
    $pcexp[2] = '/^(' . $alpha1 . '{1}' . $alpha2 . '{1}[0-9]{1}' . $alpha4 . ')([[:space:]]{0,})([0-9]{1}' . $alpha5 . '{2})$/';

    // Exception for the special postcode GIR 0AA
    $pcexp[3] = '/^(gir)([[:space:]]{0,})(0aa)$/';

    // Standard BFPO numbers
    $pcexp[4] = '/^(bfpo)([[:space:]]{0,})([0-9]{1,4})$/';

    // c/o BFPO numbers
    $pcexp[5] = '/^(bfpo)([[:space:]]{0,})(c\/o([[:space:]]{0,})[0-9]{1,3})$/';

    // Overseas Territories
    $pcexp[6] = '/^([a-z]{4})([[:space:]]{0,})(1zz)$/';

    // Anquilla
    $pcexp[7] = '/^ai-2640$/';

    // Load up the string to check, converting into lowercase
    $postcode = strtolower($original_postcode);

    // Assume we are not going to find a valid postcode
    $valid = FALSE;

    // Check the string against the six types of postcodes
    foreach ($pcexp as $regexp) {
        if (preg_match($regexp, $postcode, $matches)) {
            // Load new postcode back into the form element
            $postcode = strtoupper($matches[1] . ' ' . $matches [3]);

            // Take account of the special BFPO c/o format
            $postcode = preg_replace('/C\/O([[:space:]]{0,})/', 'c/o ', $postcode);

            // Take acount of special Anquilla postcode format (a pain, but that's the way it is)
            preg_match($pcexp[7], strtolower($original_postcode), $matches) AND $postcode = 'AI-2640';

            // Remember that we have found that the code is valid and break from loop
            $valid = TRUE;
            break;
        }
    }
    // Return with the reformatted valid postcode in uppercase if the postcode was
    return $valid ? true : FALSE;
}

function hideCharacterBy($string, $by = "X") {
    if (!empty($string)) {
        $length = strlen($string);
        $numberOfStar = $length - 3;
        $count = 0;
        $starString = '';
        while ($count < $numberOfStar) {
            $count++;
            $starString .= $by;
        }
        return substr_replace($string, $starString, 0, $numberOfStar);
    } else {
        return '';
    }
}


function getFormatDateTime($dateTime, $format) {
    $date = new DateTime($dateTime);
    return date_format($date, $format);
}

function setResponseJsonOutput($responseData = array(), $status = 200) {
    $CI =& get_instance();
    $CI->output
    ->set_status_header($status)
    ->set_content_type('application/json', 'utf-8')
    ->set_output(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
    ->_display();
    exit();
}

function show_save_message() {
    $CI =& get_instance();
    $message = $CI->session->flashdata('save_message');
    if(!empty($message)){
        echo sprintf('<div class="alert alert-info alert-dismissible" role="alert">%s<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',$message);
    }
}

function getAppVersion() {
    return 'Version:3.0.0';
}

function set_order_type_to_session($order_type = '') {
    $these = &get_instance();
    $session_order_type = $these->session->userdata('order_type_session');
    if ($these->order_type == 'collection') {
        $order_type = 'collection';
    } elseif ($these->order_type == 'delivery') {
        $order_type = 'delivery';
    } elseif ($these->order_type == 'dine_in') {
        $order_type = 'dine_in';
    } elseif (!empty($order_type)) {
        $order_type = $order_type;
    } elseif (!empty($session_order_type)) {
        $order_type = $session_order_type;
    } else {
        $order_type = 'collection';
    }
    $these->session->set_userdata('order_type_session', $order_type);
}

function serialize_data($data_array) {
    $result = "";
    if (is_array($data_array)) {
        $data_array_length = count($data_array);
        foreach ($data_array as $key => $value) {
            $data_array_length--;
            if (is_array($value)) {
                $value_array_length = count($value);
                foreach ($value as $val) {
                    $value_array_length--;
                    $result .= $key."%5B%5D=".$val;
                    if ($value_array_length >= 1) {
                        $result .= "&";
                    }
                }
            } else {
                $result .= $key."=".$value;
            }
            
            if ($data_array_length >= 1) {
                $result .= "&";
            }
        }
    }
    return $result;
}