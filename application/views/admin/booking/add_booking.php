<style type="text/css">
    .flex-container { display: flex; }
    .flex-child { flex: 1; }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Add Booking Information</h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-lg" href="<?= base_url('admin/booking_customer') ?>"><i class="fa fa-reply" aria-hidden="true"></i></i> All Booking</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php if (get_flash_message()): ?>
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Opps!</strong> <?= get_flash_message() ?>
            </div>
        <?php endif ?>

        <?php if (get_flash_save_message()): ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> <?= get_flash_save_message() ?>
            </div>
        <?php endif ?>

        <form id="save_reservation_form" name="save_reservation_form" method="post" action="<?= base_url('admin/booking_customer/save') ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="from-group">
                        <label for="full-name">Full Name</label>
                        <input class="form-control" type="text"  id="name" name="name" value="" placeholder="Full Name">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" value="" id="email" name="email" placeholder="Email">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control" type="text" value="" id="phone" name="phone" placeholder="Phone">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="Mobile">Mobile</label>
                        <input class="form-control" type="text" value="" id="mobile" name="mobile" placeholder="Mobile">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input class="form-control" type="text" value="" id="postcode" name="postcode" placeholder="Postcode">
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="birth_day">Date of Birth (Day)</label>
                        <select id="birth_day" name="birth_day" class="form-control">
                            <option name="birth_day" value="" class="select-placeholder">Select Day</option>
                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                <option name="birth_day" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="birth_day">Date of Birth (Month)</label>
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
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" rows="3" name="address" placeholder="Address" ></textarea>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="booking_purpose">Booking Purpose</label>
                        <textarea class="form-control" id="booking_purpose" rows="3" name="booking_purpose" placeholder="Booking Purpose"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="number-of-guest">Number Of Guest</label>
                        <input class="form-control" type="number" id="number_of_guest" name="number_of_guest" value="" placeholder="Number of guests" min="1">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="reservation_date">Reservation Date</label>
                        <input class="form-control" id="reservation_date" name="reservation_date" type="text" value="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="from-group">
                        <label for="start-time">Start Time</label>
                        <div class="flex-container">
                            <div class="flex-child">
                                <label>Hour</label>
                                <select id="start_time_hr" name="start_time_hr" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option name="start_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="flex-child">
                                <label>Minute</label>
                                <select id="start_time_min" name="start_time_min" class="form-control">
                                    <option name="start_time_min" value="00">00</option>
                                    <option name="start_time_min" value="15">15</option>
                                    <option name="start_time_min" value="30">30</option>
                                    <option name="start_time_min" value="45">45</option>
                                </select>
                            </div>
                            <div class="flex-child">
                                <label>AM/PM</label>
                                <select id="start_time_am_pm" name="start_time_am_pm" class="form-control">
                                    <option name="start_time_am_pm" value="AM">AM</option>
                                    <option name="start_time_am_pm" value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="end-time">End Time</label>
                        <div class="flex-container">
                            <div class="flex-child">
                                <label>Hour</label>
                                <select id="end_time_hr" name="end_time_hr" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option name="end_time_hr" value="<?= ((int) $i < 0) ? '0' . $i : $i ?>"><?= ((int) $i < 10) ? '0' . $i : $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="flex-child">
                                <label>Minute</label>
                                <select id="end_time_min" name="end_time_min" class="form-control">
                                    <option name="end_time_min" value="00">00</option>
                                    <option name="end_time_min" value="15">15</option>
                                    <option name="end_time_min" value="30">30</option>
                                    <option name="end_time_min" value="45">45</option>
                                </select>
                            </div>
                            <div class="flex-child">
                                <label>AM/PM</label>
                                <select id="end_time_am_pm" name="end_time_am_pm" class="form-control">
                                    <option name="end_time_am_pm" value="AM">AM</option>
                                    <option name="end_time_am_pm" value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>