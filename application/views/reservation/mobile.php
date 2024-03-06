
<style>
    .row{
        margin: 0 0 15px 0px;

    }
    .error{
        color: red;
    }
    .custom-select{
        border-radius: 0;
    }
    ::-webkit-input-placeholder { /* Chrome */
        color: #ececec;;
        font-size:70%;
        opacity:0.5;
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: #ececec;
        font-size:70%;
        opacity:0.5;
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: #ececec;
        font-size:70%;
        opacity:0.5;

    }
    :-moz-placeholder { /* Firefox 4 - 18 */
        color: #ececec;
        font-size:70%;
        opacity:0.5;

    }
    .select-placeholder{
        color: #ececec;
        font-size:70%;
        opacity:0.5;
    }

    select option{
        width: auto;
    }
    .col-form-label{
        font-size:16px;
    }



</style>
<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content card" >
                <h1 class="text-color cart-title">Reservation</h1>
                <form id="save_reservation_form" name="save_reservation_form" method="post" action="<?= base_url('reservation/save_reservation') ?>" >
                    <div class="error error-message">
                        <?php echo validation_errors(); ?>
                    </div>

                    <?php if (!empty($this->session->flashdata('save_error_message'))) { ?>
                        <div class="error-message text-align-center">
                            <?php echo $this->session->flashdata('save_error_message'); ?>
                        </div>
                    <?php } ?>


                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label ">Title</label>
                        <div class="col-sm-9">
                            <?php
                            $title=get_property_value('title',$customer);

                            ?>
                            <select class="form-control " id="title" name="title">

                                <option value=''  >Please Select</option>
                                <option  value="Mr." <?=($title=='Mr.')?'selected':''?>>Mr.</option>
                                <option value="Mrs." <?=($title=='Mrs.')?'selected':''?>>Mrs.</option>
                                <option  value="Miss" <?=($title=='Miss')?'selected':''?>>Miss</option>
                            </select>
                        </div>

                    </div>
                    <div class=" form-group row">
                        <label for="name" class="col-sm-3 col-form-label ">Name</label>
                        <div class="col-sm-9 ">
                            <?php
                            $first_name=get_property_value('first_name',$customer);
                            $last_name= get_property_value('last_name',$customer);
                            ?>
                            <input class="form-control" type="text" value="<?=trim($first_name.' '.$last_name)?>" id="name" name="name" placeholder="Name">

                        </div>
                    </div>

                    <div class= "form-group row">
                        <label  for="name" class="col-sm-3 col-form-label ">Phone</label>
                        <div class="col-sm-9 ">
                            <input class="form-control" type="text" value="<?=get_property_value('phone',$customer)?>" id="phone" name="phone" placeholder="Phone">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3  col-form-label ">Mobile</label>
                        <div class="col-sm-9 ">
                            <input class="form-control" type="text" value="<?=get_property_value('mobile',$customer);?>" id="mobile" name="mobile" placeholder="Mobile">
                        </div>
                    </div>


                    <div class="form-group row ">
                        <label for="postcode" class="col-sm-3 co-md-2 col-form-label ">Postcode</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" value="<?=get_property_value('postcode',$customer);?>" id="postcode" name="postcode" placeholder="Postcode">

                        </div>
                    </div>

                    <div class=" form-group row  ">
                        <label for="email" class="col-sm-3 col-form-label ">Email</label>
                        <div class="col-sm-9 ">
                            <input class="form-control" type="email" value="<?=get_property_value('email',$customer);?>" id="email" name="email" placeholder="Email">                            </div>
                    </div>



                    <div class="form-group row">
                        <label for="birth_day" class="col-sm-3 col-form-label ">Date of Birth(Day)</label>
                        <div class="col-sm-9">
                            <select id="birth_day" name="birth_day" class="custom-select">
                                <option name="birth_day" value="">Select Day</option>
                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                    <option name="birth_day" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="row ">

                        <label for="birth_day" class="col-sm-3 col-form-label ">Date of Birth(Month)</label>
                        <div class="col-sm-9 ">
                            <select id="birth_day" name="birth_day" class="custom-select">
                                <option name="birth_day" value="">Select Month</option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option name="birth_day" value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>


                    </div>






                    <div class="form-group row">
                        <label for="address" class=" col-sm-3 col-form-label ">Address</label>
                        <div class="col-sm-9">
                            <?php

                            $billing_address_line_1=get_property_value('billing_address_line_1',$customer);
                            $delivery_address_line_1=get_property_value('delivery_address_line_1',$customer);


                            ?>
                            <textarea class="form-control" id="address" rows="3" placeholder="Address" ><?=(!empty($billing_address_line_1))?$billing_address_line_1:$delivery_address_line_1 ?></textarea>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="booking_purpose" class="col-sm-3 col-form-label ">Booking Purpose</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="booking_purpose" rows="3"  name="booking_purpose" placeholder="Booking Purpose"></textarea>
                        </div>
                    </div>



                    <div class=" form-group row">
                        <label for="reservation_date" class="col-sm-3 col-form-label ">Reservation Date</label>
                        <div class="col-sm-9 ">
                            <input class="form-control" id="reservation_date" name="reservation_date" type="text">
                        </div>
                    </div>




                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label ">Start Time</label>
                        <div class="col-sm-9 form-inline">
                            <div class="col-xs-4 ">
                                <select id="start_time_hr" name="start_time_hr" class="custom-select">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option name="start_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select id="start_time_min" name="start_time_min" class="custom-select">
                                    <option name="start_time_min" value="00">00</option>
                                    <option name="start_time_min" value="15">15</option>
                                    <option name="start_time_min" value="30">30</option>
                                    <option name="start_time_min" value="45">45</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select id="start_time_am_pm" name="start_time_am_pm" class="custom-select">
                                    <option name="start_time_am_pm" value="AM">AM</option>
                                    <option name="start_time_am_pm" value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="" class="col-sm-3 col-form-label ">End Time</label>
                        <div class="col-sm-9  form-inline ">
                            <div class="col-xs-4 ">
                                <select id="end_time_hr" name="end_time_hr" class="custom-select">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option name="end_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select id="end_time_min" name="end_time_min" class="custom-select">
                                    <option name="end_time_min" value="00">00</option>
                                    <option name="end_time_min" value="15">15</option>
                                    <option name="end_time_min" value="30">30</option>
                                    <option name="end_time_min" value="45">45</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select id="end_time_am_pm" name="end_time_am_pm" class="custom-select">
                                    <option name="end_time_am_pm" value="AM">AM</option>
                                    <option name="end_time_am_pm" value="PM">PM</option>
                                </select>
                            </div>
                        </div>                            </div>


                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label ">Number Of Guest</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="number" value="" id="number_of_guest" name="number_of_guest" placeholder="Number of guests" min="1">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button  id="send" type="submit" class="common-submit-button checkout_creat_account">SEND</button>
                        </div>

                    </div>


                </form>
            </div>
            <!--Scroll To Top-->
            <a href="#" class="typtipstotop"></a>
            <!--Scroll To Top-->



            <div id="background-on-popup"></div>

            <div>



            </div>

            <!-- End Login/Register Form -->
        </div>
    </div>
</div>
</div>
<script  type="text/javascript">
    $("form[name='save_reservation_form']").validate({
        rules: {
            title: "required",
            name: "required",
            mobile: "required",
            email: "required",
            reservation_date:{
                required: true,
            },
            number_of_guest: "required",
        },
        messages: {
            title: "Please select title",
            name: "Please enter name",
            mobile: "Please enter mobile",
            email: "Please enter email",
            reservation_date: {
                required: "Please select reservation date",
            },
            number_of_guest: "Please enter number of guest",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $( "#reservation_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
</script>

