<form id="save_reservation_form" name="save_reservation_form" method="post" action="<?= base_url('admin/booking_customer/update') ?>">

    <?php

    if(!empty(get_flash_message() )){
        ?>
        <div class=" alert alert-error">
            <?php echo get_flash_message() ?>
        </div>
        <?php
    }

    $save_message=get_flash_save_message();

    if($save_message){
        echo sprintf('<div class=" alert alert-info text-center">%s</div>',$save_message);
    }

    $formData=get_flash_form_data();
    $booking=(!empty($formData))?(object)$formData:$booking;

    ?>

    <input class="" type="hidden"  id="id" name="id" value="<?=get_property_value('BookingId',$booking);?>"  >


    <div class="row">
        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="name" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Full Name</label>
            <div class="col-md-9 ">
                <input class="form-control" type="text"  id="name" name="name" value="<?=get_property_value('CustomerName',$booking);?>"  placeholder="Full Name">
            </div>
        </div>
        <div class="col-md-6 col-sm-12 form-group row ">
            <label for="email" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Email</label>
            <div class="col-md-9 ">
                <input class="form-control" type="email" value="<?=get_property_value('email',$booking);?>"  id="email" name="email" placeholder="Email">
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 col-sm-12  form-group row ">
            <label  for="name" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Phone</label>
            <div class="col-md-9 ">
                <input class="form-control" type="text" value="<?=get_property_value('CustomerPhone',$booking)?>" id="phone" name="phone" placeholder="Phone">
            </div>
        </div>
        <div class="col-md-6 col-sm-12  form-group row ">
            <label  for="Mobile" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Mobile</label>
            <div class="col-md-9 ">
                <input class="form-control" type="text" value="<?=get_property_value('mobile',$booking);?>" id="mobile" name="mobile" placeholder="Mobile">
            </div>
        </div>


    </div>



    <div class="row">
        <div class="col-md-6 col-sm-12 form-group row">
            <label for="postcode" class="col-sm-2 col-md-3 co-md-2 col-form-label checkout_login_form_area_left_text">Postcode</label>
            <div class="col-md-9">
                <input class="form-control" type="text" value="<?=get_property_value('postcode',$booking);?>" id="postcode" name="postcode" placeholder="Postcode">

            </div>
        </div>

        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="birth_day" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Date of Birth(Day)</label>
            <div class="col-md-9">
                <select id="birth_day" name="birth_day" class="form-control">
                    <option name="birth_day" value="" class="select-placeholder">Select Day</option>
                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                        <option name="birth_day" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12  form-group row ">
        </div>

        <div class="col-md-6 col-sm-12  form-group row ">

            <label for="birth_day" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Date of Birth(Month)</label>
            <div class="col-md-9 ">
                <select id="birth_day" name="birth_day" class="form-control">
                    <option name="birth_day" value="" class="select-placeholder">Select Month</option>
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option name="birth_day" value="<?=$i?>"><?=$i?></option>
                    <?php } ?>
                </select>
            </div>


        </div>
    </div>



    <div class="row">

        <div class="col-md-6 col-sm-12 form-group row">
            <label for="address" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Address</label>
            <div class="col-md-9">
                <?php
                $address=get_property_value('address',$booking);
                ?>
                <textarea class="form-control" id="address" rows="3" name="address" placeholder="Address" ><?=$address?></textarea>

            </div>
        </div>
        <?php
        $BookingPurpose=get_property_value('BookingPurpose',$booking);
        ?>

        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="booking_purpose" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Booking Purpose</label>
            <div class="col-md-9 ">
                <textarea class="form-control" id="booking_purpose" rows="3"  name="booking_purpose" placeholder="Booking Purpose"><?=$BookingPurpose?></textarea>
            </div>
        </div>
    </div>

    <div class="row">

        <div class=" col-md-6 col-sm-12 form-group row">
            <label for="" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Number Of Guest</label>
            <div class="col-md-9">
                <input class="form-control" type="number" id="number_of_guest" name="number_of_guest" value="<?=get_property_value('NumberOfGuest',$booking)?>" placeholder="Number of guests" min="1">
            </div>
        </div>



        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="reservation_date" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Reservation Date</label>
            <div class="col-md-9 ">
                <input class="form-control" id="reservation_date" name="reservation_date" type="text" value="<?=get_formatted_time(get_property_value('BookingTime',$booking),'d-m-Y')?>">
            </div>
        </div>
    </div>

    <div class="row">
        <?php



        $start_time=get_property_value('StartTime',$booking);
        $start_time_hr='';
        $start_time_min='';
        $start_time_am_pm='';
        if(!empty($start_time)){
            $str = preg_replace('/:/', ' ', $start_time);

            $str=explode(' ',$str);

            $start_time_hr=$str[0];
            $start_time_min=$str[1];
            $start_time_am_pm=$str[3];
        }

        $end_time=get_property_value('EndTime',$booking);
        $end_time_hr='';
        $end_time_min='';
        $end_time_am_pm='';
        if(!empty($end_time)){
            $str = preg_replace('/:/', ' ', $end_time);
            $str=explode(' ',$str);
            $end_time_hr=$str[0];
            $end_time_min=$str[1];
            $end_time_am_pm=$str[3];
        }
        ?>

        <div class="col-md-6 col-sm-12 form-group row">
            <label for="" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Start Time</label>
            <div class="col-md-9 form-inline">
                <div class="col-xs-4 ">
                    <select id="start_time_hr" name="start_time_hr" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option name="start_time_hr" <?=($start_time_hr==$i)?'selected':''?> value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="start_time_min" name="start_time_min" class="form-control">
                        <option name="start_time_min" value="00" <?=($start_time_min=='00')?'selected':''?>>00</option>
                        <option name="start_time_min" value="15" <?=($start_time_min=='15')?'selected':''?>>15</option>
                        <option name="start_time_min" value="30" <?=($start_time_min=='30')?'selected':''?>>30</option>
                        <option name="start_time_min" value="45" <?=($start_time_min=='45')?'selected':''?>>45</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="start_time_am_pm" name="start_time_am_pm" class="form-control">
                        <option name="start_time_am_pm" value="AM" <?=($start_time_am_pm=='AM')?'selected':''?>>AM</option>
                        <option name="start_time_am_pm" value="PM" <?=($start_time_am_pm=='PM')?'selected':''?>>PM</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">End Time</label>
            <div class="col-md-9  form-inline ">
                <div class="col-xs-4 ">
                    <select id="end_time_hr" name="end_time_hr" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option name="end_time_hr" <?=($end_time_hr==$i)?'selected':''?> value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="end_time_min" name="end_time_min" class="form-control">
                        <option name="end_time_min" value="00"  <?=($end_time_hr=='00')?'selected':''?>>00</option>
                        <option name="end_time_min" value="15" <?=($end_time_hr=='15')?'selected':''?>>15</option>
                        <option name="end_time_min" value="30" <?=($end_time_hr=='30')?'selected':''?>>30</option>
                        <option name="end_time_min" value="45" <?=($end_time_hr=='45')?'selected':''?>>45</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="end_time_am_pm" name="end_time_am_pm" class="form-control">
                        <option name="end_time_am_pm" value="AM" <?=($end_time_am_pm=='AM')?'selected':''?>>AM</option>
                        <option name="end_time_am_pm" value="PM" <?=($end_time_am_pm=='PM')?'selected':''?>>PM</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class=" form-group">
        <div class="col-md-12" >
            <div class="col-xs-12">
                <button  id="send" type="submit" class="btn btn-primary" style="float: right">Save</button>

            </div>
        </div>

    </div>


</form>
