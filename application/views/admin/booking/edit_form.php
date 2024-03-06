<form id="save_reservation_form" name="save_reservation_form" method="post" action="<?= base_url('reservation/save_reservation') ?>">
    <div class="error error-message">
        <?php echo validation_errors(); ?>
    </div>
    <?php if (!empty($this->session->flashdata('save_error_message'))) { ?>
        <div class="error-message text-align-center">
            <?php echo $this->session->flashdata('save_error_message'); ?>
        </div>
    <?php }

    $booking=null;
    ?>
    <div class="row">

    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12  form-group row ">

            <label for="name" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Full Name</label>
            <div class="col-md-9 ">
                <input class="form-control" type="text" value="" id="name" name="name" placeholder="Full Name">
            </div>

        </div>
        <div class="col-md-6 col-sm-12 form-group row ">
            <label for="email" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Email</label>
            <div class="col-md-9 ">
                <input class="form-control" type="email" value="<?=get_property_value('email',$booking);?>" id="email" name="email" placeholder="Email">
            </div>
        </div>





    </div>

    <div class="row">

        <div class="col-md-6 col-sm-12  form-group row ">
            <label  for="name" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Phone</label>
            <div class="col-md-9 ">
                <input class="form-control" type="text" value="<?=get_property_value('phone',$booking)?>" id="phone" name="phone" placeholder="Phone">
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
                <textarea class="form-control" id="address" rows="3" placeholder="Address" ><?=$address?></textarea>

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
                <input class="form-control" type="number" id="number_of_guest" name="number_of_guest" value="<?=get_property_value('number_of_guest',$booking)?>" placeholder="Number of guests" min="1">
            </div>
        </div>



        <div class="col-md-6 col-sm-12  form-group row ">
            <label for="reservation_date" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Reservation Date</label>
            <div class="col-md-9 ">
                <input class="form-control" id="reservation_date" name="reservation_date" type="text" value="<?=get_property_value('reservation_date',$booking)?>">
            </div>
        </div>
    </div>

    <div class="row">
        <?php



        $start_time=get_property_value('start_time',$booking);
        $start_time_hr='';
        $start_time_min='';
        $start_time_am_pm='';
        if(!empty($start_time)){
            $str = preg_replace('/:/', ' ', $end_time);
            $start_time_hr=$str[0];
            $start_time_min=$str[1];
            $start_time_am_pm=$str[2];
        }

        $end_time=get_property_value('end_time',$booking);
        $end_time_hr='';
        $end_time_min='';
        $end_time_am_pm='';
        if(!empty($end_time)){
            $str = preg_replace('/:/', ' ', $end_time);
            $end_time_hr=$str[0];
            $end_time_min=$str[1];
            $end_time_am_pm=$str[2];
        }


        ?>

        <div class="col-md-6 col-sm-12 form-group row">
            <label for="" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text">Start Time</label>
            <div class="col-md-9 form-inline">
                <div class="col-xs-4 ">
                    <select id="start_time_hr" name="start_time_hr" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option name="start_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="start_time_min" name="start_time_min" class="form-control">
                        <option name="start_time_min" value="00">00</option>
                        <option name="start_time_min" value="15">15</option>
                        <option name="start_time_min" value="30">30</option>
                        <option name="start_time_min" value="45">45</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="start_time_am_pm" name="start_time_am_pm" class="form-control">
                        <option name="start_time_am_pm" value="AM">AM</option>
                        <option name="start_time_am_pm" value="PM">PM</option>
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
                            <option name="end_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="end_time_min" name="end_time_min" class="form-control">
                        <option name="end_time_min" value="00">00</option>
                        <option name="end_time_min" value="15">15</option>
                        <option name="end_time_min" value="30">30</option>
                        <option name="end_time_min" value="45">45</option>
                    </select>
                </div>
                <div class="col-xs-4">
                    <select id="end_time_am_pm" name="end_time_am_pm" class="form-control">
                        <option name="end_time_am_pm" value="AM">AM</option>
                        <option name="end_time_am_pm" value="PM">PM</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-md-6 col-sm-12 form-group row">
        <label for="" class="col-sm-2 col-md-3 col-form-label checkout_login_form_area_left_text"></label>
        <div class="col-md-9">
            <button  id="send" type="submit" class="common-submit-button checkout_creat_account">SEND</button>
        </div>

    </div>


</form>
