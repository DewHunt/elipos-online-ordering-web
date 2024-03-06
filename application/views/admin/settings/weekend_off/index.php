<?php
    $details = '';
    $all_days = get_days_of_week();
    if (!empty($weekend_off)) {
        $details = json_decode($weekend_off->value);
    }
    $weekend_day_ids = get_property_value('day_ids',$details);
    $weekend_day_ids = (!empty($weekend_day_ids)) ? $weekend_day_ids : array();
    $is_off_all_holidays = get_property_value('is_off_all_holidays',$details);
    $is_closed_for_today = get_property_value('is_closed_for_today',$details);
    $is_closed_for_tomorrow = get_property_value('is_closed_for_tomorrow',$details);
    $is_closed_for_this_weeks = get_property_value('is_closed_for_this_weeks',$details);
    $is_closed_for_this_weeks = (!empty($is_closed_for_this_weeks)) ? $is_closed_for_this_weeks : array();
    $is_closed_for_this_weeks_day_ids = get_property_value('day_ids',$is_closed_for_this_weeks);
    $is_closed_for_this_weeks_day_ids = (!empty($is_closed_for_this_weeks_day_ids)) ? $is_closed_for_this_weeks_day_ids : array();
    // dd($is_closed_for_this_weeks_day_ids);
?>

<style type="text/css">
    .x_content { font-size: 18px; }
    input[type = checkbox], input[type = radio] { margin: 7px 0 0; }
</style>

<style>
    .progress[value] { color: green; width: 100%; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?php echo validation_errors(); ?></div>
        <form class="form-label-left" id="" name="business_information_settings_form" method="post" action="<?= base_url('admin/settings/weekend_off_save') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_property_value('id',$weekend_off)?>">

            <div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Check Weekend Day Off</div></div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left: 20px;">
                    <div class="form-group">
                        <?php foreach ($all_days as $dayId => $dayName): ?>
                            <?php
                                $check = '';
                                $for_this_week_check = '';
                                if (in_array($dayId,$weekend_day_ids)) {
                                    $check = 'checked';
                                }

                                if (in_array($dayId,$is_closed_for_this_weeks_day_ids)) {
                                    $for_this_week_check = 'checked';
                                }
                            ?>
                            <div>
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="is_closed_for_this_weeks" name="is_closed_for_this_weeks[]" value="<?= $dayId ?>" <?= $for_this_week_check ?>>Is For This Week
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="day_id_<?= $dayId ?>" name="day_ids[]" value="<?= $dayId ?>" <?= $check ?>><?=$dayName?>
                                </label>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left: 40px;">
                    <div class="form-group">
                        <label class="checkbox">
                            <input name="is_off_all_holidays" type="checkbox" value="1" <?= $is_off_all_holidays ? 'checked' : ''?>>Is Closed In All Holidays
                        </label>
                        <label class="checkbox">
                            <?php
                                $check = '';
                                if ($is_closed_for_today && $is_closed_for_today->status == 1) {
                                    $check = 'checked';
                                }
                            ?>
                            <input name="is_closed_for_today" type="checkbox" value="1" <?= $check ?>>Is Closed For Today
                        </label>
                        <label class="checkbox">
                            <?php
                                $check = '';
                                if ($is_closed_for_tomorrow && $is_closed_for_tomorrow->status == 1) {
                                    $check = 'checked';
                                }
                            ?>
                            <input name="is_closed_for_tomorrow" type="checkbox" value="1" <?= $check ?>>Is Closed For Tomorrow
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.is_closed_for_this_weeks').click(function(event){
            var day_id = $(this).val();
            if (this.checked) {
                $('.day_id_'+day_id).each(function() { this.checked = true; });
            } else {
                $('.day_id_'+day_id).each(function() { this.checked = false; });
            }
        });
    });
</script> -->






 