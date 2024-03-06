<?php

function get_days_of_week() {
    $days = array(
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    );
    return $days;
}

function get_holidays_type() {
    return array(
        array('id'=>1,'name'=>'Bank Holiday',),
        array('id'=>2,'name'=>'Government Holiday',),
    );
}

function get_formatted_date($date, $format="h:i:s a") {
    return date($format, strtotime($date));
}

function get_formatted_time($time, $format = "h:i:s a") {
    return date($format, strtotime($time));
}


function is_discount_off($order_type) {
    $CI = & get_instance();
    $discount = $CI->Settings_Model->get_by(array('name' => 'discount',), true);

    if (!empty($discount)) {
        $discount_value = (!empty($discount)) ? $discount->value : null;
        $discount_data = (!empty($discount_value)) ? json_decode($discount_value, true) : array();

        if ($order_type == 'delivery') {
            $delivery_details = get_array_key_value('delivery_day_ids[]', $discount_data);
        } else if ($order_type == 'collection') {
            $delivery_details = get_array_key_value('collections_day_ids[]', $discount_data);
        }
        $day_number = date('w');
        
        $delivery_details = (!empty($delivery_details)) ? $delivery_details : array();
        return (in_array($day_number, $delivery_details));
    }

    return false;
}

function get_today_shop_timing($day_number = -1,$order_type = 'collection'){
    // dd($order_type);
    $ci = &get_instance();
    $ci->load->model("Shop_timing_Model");
    return $ci->Shop_timing_Model->get_by(array('day_id'=>$day_number,'order_type'=>$order_type),true);
}

function is_home_promo_active() {
    $home_promo_details = get_home_promo_settings_details();

    if ($home_promo_details) {
        $is_show = get_property_value('is_show',$home_promo_details);
        if ($is_show) {
            $date_of_permanence = get_property_value('date_of_permanence',$home_promo_details);
            if ($date_of_permanence) {
                $status = get_property_value('status',$date_of_permanence);
                if ($status == 1) {
                    $date = get_property_value('date',$date_of_permanence);
                    $date_strtotime = strtotime($date);
                    $current_date = date('Y-m-d');
                    $current_date_strtotime = strtotime($current_date);
                    if ($current_date_strtotime <= $date_strtotime) {
                        return true;
                    }
                    return false;
                }
                return true;
            }
            return true;
        }
        return false;
    }
    return false;
}

function is_home_promo_active_for_menu() {
    $home_promo_details = get_home_promo_settings_details();

    if ($home_promo_details) {
        $is_show_in_menu = get_property_value('is_show_in_menu',$home_promo_details);
        if ($is_show_in_menu) {
            return true;
        }
        return false;
    }
    return false;
}

function is_shop_closed($time = '') {
    // $time = date('h:i:s A',strtotime('20:30'));
    // $time = date('G:i:s',strtotime($time));
    if ($time) {
        $time = date('G:i:s',strtotime($time));
    } else {
        $time = date('G:i:s');
    }
    // dd($time);

    // $time = '09:00:00';
    $time = strtotime($time);
    // $time=strtotime($time);
    $day_number = date('w');
    $shop_timing = get_today_shop_timing($day_number);
    $is_closed = TRUE;
    $prev_day_number = -1;
    if ($day_number == 0){
        $prev_day_number = 6;
    } else if($day_number > 0){
        $prev_day_number = $day_number - 1;
    }
    $shop_timing_prev_day = get_today_shop_timing($prev_day_number);
    if (!empty($shop_timing)) {
        $open_time = strtotime($shop_timing->open_time);
        $close_time = strtotime($shop_timing->close_time);
        if ($open_time > $close_time) {
            if ($open_time <= $time){
                $is_closed = FALSE;
            } else {
                $is_closed = TRUE;
            }
        } else {
            if ($time >= $open_time && $time <= $close_time) {
                $is_closed = FALSE;
            } else {
                $is_closed = TRUE;
            }
        }

        if (!empty($shop_timing_prev_day)) {
            $prev_day_closing_time = $shop_timing_prev_day->close_time;
            $prev_day_closing_time = strtotime($prev_day_closing_time);
            if (!($time >= strtotime('12:00:00')) && $prev_day_closing_time <= strtotime('12:00:00')) {
                if ($prev_day_closing_time >= $time && (!($open_time <= $time))) {
                    $is_closed = FALSE;
                }
            }
        }
    }
    return $is_closed;
}

function is_pre_order() {
    $CI = &get_instance();
    if (is_shop_closed()) {
        return (!empty($CI->session->userdata('is_pre_order'))) ? $CI->session->userdata('is_pre_order') : false;
    } else {
        $CI->session->set_userdata('is_pre_order',false);
        return false;
    }
}

function is_shop_maintenance_mode() {
    $CI = &get_instance();
    $maintenance_mode = get_maintenance_mode_settings_value();
    $today_date_strtotime = strtotime(date('Y-m-d'));

    if (!empty($maintenance_mode)) {
        if (array_key_exists('is_maintenance',$maintenance_mode) && $maintenance_mode['is_maintenance'] == 1) {
            return true;
        }

        if (array_key_exists('is_for_today',$maintenance_mode) && $maintenance_mode['is_for_today']['status'] == 1) {
            $is_for_today_date_strtotime = strtotime($maintenance_mode['is_for_today']['date']);
            if ($today_date_strtotime == $is_for_today_date_strtotime) {
                return true;
            }
        }

        if (array_key_exists('is_for_tomorrow', $maintenance_mode) && $maintenance_mode['is_for_tomorrow']['status'] == 1) {
            $is_for_tomorrow_date_strtotime = strtotime($maintenance_mode['is_for_tomorrow']['date']);
            if ($today_date_strtotime == $is_for_tomorrow_date_strtotime) {
                return true;
            }
        }
    } else {
        return false;
    }
}

function is_shop_weekend_off() {
    $CI = &get_instance();
    $weekend_off = $CI->Settings_Model->get_by(array("name" => 'weekend_off'), true);
    if (!empty($weekend_off)) {
        $details = json_decode($weekend_off->value);
        $day_number = date('w');
        $weekend_day_ids = get_property_value('day_ids',$details);
        $is_off_all_holidays = get_property_value('is_off_all_holidays',$details);
        $is_closed_for_this_weeks = get_property_value('is_closed_for_this_weeks',$details);
        $is_closed_for_today = get_property_value('is_closed_for_today',$details);
        $is_closed_for_tomorrow = get_property_value('is_closed_for_tomorrow',$details);
        $today_date_strtotime = strtotime(date('Y-m-d'));

        if (!empty($is_closed_for_today)) {
            if ($is_closed_for_today->status == 1 && $is_closed_for_today->date != '') {
                $is_closed_for_today_date_strtotime = strtotime($is_closed_for_today->date);
                if ($today_date_strtotime == $is_closed_for_today_date_strtotime) {
                    return true;
                }
            }
        }

        if (!empty($is_closed_for_tomorrow)) {
            if ($is_closed_for_tomorrow->status == 1 && $is_closed_for_tomorrow->date != '') {
                $is_closed_for_tomorrow_date_strtotime = strtotime($is_closed_for_tomorrow->date);
                if ($today_date_strtotime == $is_closed_for_tomorrow_date_strtotime) {
                    return true;
                }
            }
        }

        if (!empty($is_closed_for_this_weeks)) {
            if ($is_closed_for_this_weeks->status == 1 && $is_closed_for_this_weeks->start_date != '' && $is_closed_for_this_weeks->end_date != '') {
                $start_date_strtotime = strtotime($is_closed_for_this_weeks->start_date);
                $end_date_strtotime = strtotime($is_closed_for_this_weeks->end_date);

                if ($today_date_strtotime >= $start_date_strtotime && $today_date_strtotime <= $end_date_strtotime) {
                    return (in_array($day_number,$is_closed_for_this_weeks->day_ids));
                }
            }
        }
        $is_today_is_holiday = false;
        $is_today_is_holiday = get_userdata('is_today_is_holiday');
        $is_today_is_holiday = (!empty($is_today_is_holiday)) ? $is_today_is_holiday : false;

        if ($is_today_is_holiday) {
            return $is_off_all_holidays;
        } else {
            $weekend_day_ids = (!empty($weekend_day_ids)) ? $weekend_day_ids : array();
            return (in_array($day_number,$weekend_day_ids));
        }
    } else {
        return false;
    }
}

function get_shop_weekend_day_ids() {
    $CI = &get_instance();
    $weekend_off = $CI->Settings_Model->get_by(array("name" => 'weekend_off'), true);
    if (!empty($weekend_off)) {
        $details = json_decode($weekend_off->value);
        $weekend_day_ids = get_property_value('day_ids',$details);
        $weekend_day_ids = (!empty($weekend_day_ids)) ? $weekend_day_ids : array();
        return $weekend_day_ids;
    } else {
        return array();
    }
}

function is_shop_closed_status($day_id) {
    $CI = &get_instance();
    $weekend_off = $CI->Settings_Model->get_by(array("name" => 'weekend_off'), true);
    if ($weekend_off) {
        $details = json_decode($weekend_off->value);
        $weekend_day_ids = get_property_value('day_ids',$details);
        $weekend_day_ids = $weekend_day_ids ? $weekend_day_ids : array();
        $is_closed_for_today = get_property_value('is_closed_for_today',$details);
        $is_closed_for_tomorrow = get_property_value('is_closed_for_tomorrow',$details);
        $is_closed_for_this_weeks = get_property_value('is_closed_for_this_weeks',$details);
        $today_date_strtotime = strtotime(date('Y-m-d'));

        if (in_array($day_id,$weekend_day_ids)) {
            return true;
        }

        if ($is_closed_for_today && $is_closed_for_today->status == 1 && $is_closed_for_today->date != '' && $day_id == $is_closed_for_today->day_id) {
            $is_closed_for_today_date_strtotime = strtotime($is_closed_for_today->date);
            if ($today_date_strtotime == $is_closed_for_today_date_strtotime) {
                return true;
            }
        }

        if ($is_closed_for_tomorrow && $is_closed_for_tomorrow->status == 1 && $is_closed_for_tomorrow->date != '' && $day_id == $is_closed_for_tomorrow->day_id) {
            $is_closed_for_tomorrow_date_strtotime = strtotime($is_closed_for_tomorrow->date);
            if ($today_date_strtotime <= $is_closed_for_tomorrow_date_strtotime) {
                return true;
            }
        }

        if ($is_closed_for_this_weeks && $is_closed_for_this_weeks->status == 1 && $is_closed_for_this_weeks->start_date != '' && $is_closed_for_this_weeks->end_date != '' && in_array($day_id, $is_closed_for_this_weeks->day_ids)) {
            $start_date_strtotime = strtotime($is_closed_for_this_weeks->start_date);
            $end_date_strtotime = strtotime($is_closed_for_this_weeks->end_date);
            if ($today_date_strtotime >= $start_date_strtotime && $today_date_strtotime <= $end_date_strtotime) {
                return true;
            }
        }
        return false;
    }
    return false;
}

function is_booking_closed($date = '') {
    if ($date == '') {
        $date = date('Y-m-d');
    }
    $is_closed = false;
    $message = '';
    $booking_settings_value = get_settings_values('booking_settings');
    if ($booking_settings_value) {
        $message = $booking_settings_value->message;
        if ($booking_settings_value->is_closed == 1) {
            $all_closing_dates = $booking_settings_value->closing_date;
            if ($all_closing_dates) {
                $all_closing_dates = explode(',', $all_closing_dates);
                if (in_array($date, $all_closing_dates)) {
                    $is_closed = true;
                }
            }
        }
    }
    return [$is_closed,$message];
}

function isTodayIsHoliday(){
    if(!has_userdata('is_today_is_holiday')){
        $url = 'https://console.elipos.co.uk/api/holiday/get';
        $data = array('date'=>get_current_date_time('Y-m-d'),'country_code'=>'GB');
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS,(json_encode($data)));
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER,0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );
        if (!empty($response)) {
            $is_today_is_holiday = get_property_value('is_holiday',json_decode($response));
            set_userdata('is_today_is_holiday',$is_today_is_holiday);
        }
    }
}

function get_order_times($start_time,$end_time,$current_time,$is_pre_order,$order_date){
    $timesArray = array();
    $isValidTime = false;
    $opening_time = $start_time;
    $is_first_time = true;
    $temp_end_time = $end_time;

    // Night 12:00:00 AM
    $check_midnight_time = '00:00:00';

    $check_midnight_timestamp = strtotime($check_midnight_time);
    // Morning 6 AM
    if ($current_time > $check_midnight_timestamp) {
        $end_time = strtotime('23:59:59');
        while ($start_time <= $end_time) {
            if ($start_time >= $current_time || $is_pre_order ) {
                if ($is_first_time) {
                    $start_time += 2700;
                    $is_first_time = false;
                    $isValidTime = true;
                }

                if ($opening_time <= $current_time && !$is_pre_order) {
                    // $timesArray['0000-00-00 00:00:00']='ASAP';
                }

                if ($current_time < $start_time){
                    $endTime = date("H:i", $start_time);
                    $endTimeShow = date("h:i A", $start_time);
                    $timesArray[$order_date.' '.$endTime.':00']=$endTimeShow;
                }
            }
            $start_time += 900;
        }
    }

    $check_till_morning_time = '06:00:00';
    $check_till_morning_timestamp = strtotime($check_till_morning_time);
    if($temp_end_time >= $check_midnight_timestamp && $temp_end_time <= $check_till_morning_timestamp){
        $order_date = date('Y-m-d', strtotime( $order_date .' +1 day'));
        $start_time = $check_midnight_timestamp;
        while($start_time <= $temp_end_time){
            if($current_time > $start_time){
                $endTime = date("H:i", $start_time);
                $endTimeShow = date("h:i A", $start_time);
                $timesArray[$order_date.' '.$endTime.':00'] = $endTimeShow;
                $isValidTime = true;
            }
            $start_time+=900;
        }
    }

    return array('time_options'=>$timesArray,'is_valid_time'=>$isValidTime);
}

function get_shop_postcode() {
    $details = get_company_details();
    $shopPostCode = get_property_value('postcode',$details);
    return trim($shopPostCode);
}

function get_previous_day_number($day_number = 0) {
    if ($day_number == 0) {
        return  $prev_day_number = 6;
    } else if($day_number > 0) {
        return $prev_day_number = $day_number-1;
    } else {
        return $prev_day_number = -1;
    }
}

function convert_min_to_hour($min = 0) {
    if ($min > 60) {
        $hour = intdiv($min,60);
        $min = $min % 60;
        return $hour." Hour ".$min." Min";
    }
    return $min." Min";
}

function getShopOpeningAndClosingTimeList($is_pre_order = false,$order_type = 'collection') {
    $day_number = date('w');
    $prev_day_shop_timings = array();
    $today_day_shop_timings = array();
    $prev_day_number = get_previous_day_number($day_number);
    $shop_timing = get_today_shop_timing($day_number, $order_type);
    $prev_day_shop_timing = get_today_shop_timing($prev_day_number, $order_type);
    $current_time_with_am_pm = date('h:i:a', time());
    $orderTimesArray = array();
    $todayDate = date('Y-m-d');

    if (strstr($current_time_with_am_pm,'am')) {
        /*
        * Check prev day end time is on am.
        * If it contain on am then check today start
        */

        if ($prev_day_shop_timing) {
            $prev_open_time = $prev_day_shop_timing->open_time;
            $prev_close_time = $prev_day_shop_timing->close_time;
            $close_time_with_am_pm = date('h:i:a',strtotime($prev_close_time));
            if (strstr($close_time_with_am_pm,'am')) {
                /*
                * Now Check current time with prev day end time
                * If Prev day end time is greater than
                */
                $prev_open_time = '00:00:00';
                $prev_open_time = strtotime($prev_open_time);
                $prev_close_time = strtotime($prev_close_time);
                $previousDayDate = date('Y-m-d', strtotime(date('Y-m-d').' -1 day'));
                $prev_day_shop_timings = getTimingArray($prev_open_time,$prev_close_time,$todayDate,false,$is_pre_order,$order_type);
                // dd($prev_day_shop_timings);

                if(!empty($prev_day_shop_timings)){
                    $orderTimesArray = array_merge($orderTimesArray,$prev_day_shop_timings);
                    // array_push($orderTimesArray, $prev_day_shop_timings);
                }
            }
        }
    }

    if ($shop_timing && empty($prev_day_shop_timings)) {
        $open_time = strtotime($shop_timing->open_time);
        $close_time = strtotime($shop_timing->close_time);
        $close_time_with_am_pm = date('h:i:a',$close_time);
        
        if (strstr($close_time_with_am_pm,'am')) {
            $newOpenTime = '00:00:00';
            $newOpenTime = strtotime($newOpenTime);
            $newCloseTime = '23:59:59';
            $newCloseTime = strtotime($newCloseTime);

            /* Day timing */
            $today_day_shop_timings = getTimingArray($open_time,$newCloseTime,$todayDate,true,$is_pre_order,$order_type);

            if ($today_day_shop_timings) {
                $orderTimesArray = array_merge($orderTimesArray,$today_day_shop_timings);
                // array_push($orderTimesArray, $today_day_shop_timings);
            }

            /*After midnight timing*/
            $order_date = date('Y-m-d', strtotime(date('Y-m-d').' +1 day'));
            $tomorrow_shop_timings = getTimingArray($newOpenTime,$close_time,$order_date,false,$is_pre_order,$order_type);

            if ($tomorrow_shop_timings) {
                $orderTimesArray = array_merge($orderTimesArray,$tomorrow_shop_timings);
                // array_push($orderTimesArray, $tomorrow_shop_timings);
            }
        } else {
            $is_first_time = true;
            if ($is_pre_order) {
                $is_first_time = false;
            }
            $today_day_shop_timings = getTimingArray($open_time,$close_time,$todayDate,$is_first_time,$is_pre_order,$order_type);
            if ($today_day_shop_timings) {
                $orderTimesArray = array_merge($orderTimesArray,$today_day_shop_timings);
            }
        }
    }
    return $orderTimesArray;
}

function getTimingArray($start_time,$end_time,$date,$is_first_time = false,$is_pre_order = false,$order_type = '') {
    $timesArray = array();
    $current_time = strtotime(date('H:i'),time());
    $todayDate = strtotime(date('Y-m-d'));

    $date_time = new DateTime();
    $day_number = date('w');
    $shop_timing = get_today_shop_timing($day_number, $order_type);
    $first_time_increment = $shop_timing->collection_delivery_time * 60;
    $increment = 900;
    // dd($is_pre_order);

    if ($start_time <= $current_time && $todayDate == strtotime($date)) {
        $start_time = strtotime($date_time->format('H:i:s'));
        $differResult = ($date_time->format('i') % 5);

        if ($differResult > 0) {
            $addMinute = 5 - $differResult;
            $start_time += $addMinute * 60;
        }
        if ($shop_timing) {
            $timesArray['0000-00-00 00:00:00'] = 'ASAP/ '.convert_min_to_hour($shop_timing->collection_delivery_time);
        }
    }

    while ($start_time <= $end_time) {
        if ($current_time <= $start_time || $todayDate < strtotime($date)) {
            if ($is_first_time) {
                $start_time += $first_time_increment;
                $is_first_time = false;
                $isValidTime = true;
            }

            if ($is_pre_order) {
                $start_time += $first_time_increment;
                $is_pre_order = false;
            }
            $endTime = date("H:i", $start_time);
            $endTimeShow = date("h:i A", $start_time);
            $timesArray[$date.' '.$endTime.':00'] = $endTimeShow;
        }

        $start_time += $increment;
    }
    return $timesArray;
}

function getDeliveryTimeText($delivery_time='',$order_type='collection') {
    $delivery_time = strtotime($delivery_time);
    $deliveryText = 'ASAP/1 hour';
    $collectionText = 'ASAP/30 mins';
    if ($order_type == 'collection') {
        return ($delivery_time > 0) ? date("d-m-Y h:i:s A",$delivery_time) : $collectionText;
    } else {
        return ($delivery_time > 0) ? date("d-m-Y h:i:s A",$delivery_time) : $deliveryText;
    }
}

function update_weekend_off() {
    $these = &get_instance();
    $weekend_off = $these->Settings_Model->get_by(array("name" => 'weekend_off'), true);
    $today_date_strtotime = strtotime(date('Y-m-d'));
    if ($weekend_off) {
        $id = $weekend_off->id;
        $data['name'] = 'weekend_off';
        $details = json_decode($weekend_off->value);
        $is_closed_for_today = get_property_value('is_closed_for_today',$details);
        $is_closed_for_tomorrow = get_property_value('is_closed_for_tomorrow',$details);
        $is_closed_for_this_weeks = get_property_value('is_closed_for_this_weeks',$details);

        if ($is_closed_for_today && $is_closed_for_today->status == 1 && $is_closed_for_today->date != '') {
            $is_closed_for_today_date_strtotime = strtotime($is_closed_for_today->date);
            if ($today_date_strtotime > $is_closed_for_today_date_strtotime) {
                $details->is_closed_for_today->status = null;
                $details->is_closed_for_today->date = null;
                $details->is_closed_for_today->day_id = null;
            }
        }

        if ($is_closed_for_tomorrow && $is_closed_for_tomorrow->status == 1 && $is_closed_for_tomorrow->date != '') {
            $is_closed_for_tomorrow_date_strtotime = strtotime($is_closed_for_tomorrow->date);
            if ($today_date_strtotime > $is_closed_for_tomorrow_date_strtotime) {
                $details->is_closed_for_tomorrow->status = null;
                $details->is_closed_for_tomorrow->date = null;
                $details->is_closed_for_tomorrow->day_id = null;
            }
        }

        if ($is_closed_for_this_weeks && $is_closed_for_this_weeks->status == 1 && $is_closed_for_this_weeks->start_date != '' && $is_closed_for_this_weeks->end_date != '') {
            $start_date_strtotime = strtotime($is_closed_for_this_weeks->start_date);
            $end_date_strtotime = strtotime($is_closed_for_this_weeks->end_date);

            if ($today_date_strtotime > $start_date_strtotime && $today_date_strtotime > $end_date_strtotime) {
                $details->is_closed_for_this_weeks->status = null;
                $details->is_closed_for_this_weeks->start_date = null;
                $details->is_closed_for_this_weeks->end_date = null;
                $details->is_closed_for_this_weeks->day_ids = null;
            }
        }

        $json_value = json_encode($details);
        $data['value'] = $json_value;
        $these->Settings_Model->where_column = 'id';
        $these->Settings_Model->save($data, $id);
    }
}

function update_maintenance_mode() {
    $these =& get_instance();
    $maintenance_mode = $these->Settings_Model->get_by(array("name" => 'maintenance_mode_settings'), true);
    $today_date_strtotime = strtotime(date('Y-m-d'));
    if ($maintenance_mode) {
        $id = $maintenance_mode->id;
        $data['name'] = 'maintenance_mode_settings';
        $details = json_decode($maintenance_mode->value);
        $is_for_today = get_property_value('is_for_today',$details);
        $is_for_tomorrow = get_property_value('is_for_tomorrow',$details);

        if ($is_for_today && $is_for_today->status == 1 && $is_for_today->date != '') {
            $is_for_today_date_strtotime = strtotime($is_for_today->date);
            if ($today_date_strtotime > $is_for_today_date_strtotime) {
                $details->is_for_today->status = null;
                $details->is_for_today->date = null;
                $details->is_for_today->day_id = null;
            }
        }

        if ($is_for_tomorrow && $is_for_tomorrow->status == 1 && $is_for_tomorrow->date != '') {
            $is_for_tomorrow_date_strtotime = strtotime($is_for_tomorrow->date);
            if ($today_date_strtotime > $is_for_tomorrow_date_strtotime) {
                $details->is_for_tomorrow->status = null;
                $details->is_for_tomorrow->date = null;
                $details->is_for_tomorrow->day_id = null;
            }
        }

        $json_value = json_encode($details);
        $data['value'] = $json_value;
        $these->Settings_Model->where_column = 'id';
        $these->Settings_Model->save($data, $id);
    }
}

function is_active_reservation() {
    $these =& get_instance();
    $other_settings = get_other_settings_details();

    if ($other_settings) {
        if ($other_settings->active_reservation == 1) {
            return true;
        }
        return false;    
    }
    return true;
}

function is_redirect_to_online_order() {
    $these =& get_instance();
    $other_settings = get_other_settings_details();

    if ($other_settings) {
        if ($other_settings->redirect_to_online_order == 1) {
            return true;
        }
        return false;    
    }
    return true;
}