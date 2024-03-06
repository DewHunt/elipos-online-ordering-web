<?php
    $this->load->model('Shop_timing_Model');
    $m_shop_timing = new Shop_timing_Model();
    $shop_timings = $m_shop_timing->get_all();
    $shop_weekend_day_ids = get_shop_weekend_day_ids();
    // dd($shop_timings);
?>
<style>
    .table th, .table td{ padding: 0; }
</style>

<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">Day</th>
            <th class="text-center">Opening Time</th>
            <th class="text-center">Closing Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shop_timings as $s_timing): ?>
            <?php
                $day_name = get_days_of_week()[$s_timing->day_id];
                $open_time = get_formatted_time($s_timing->open_time,'h:i A');
                $close_time = get_formatted_time($s_timing->close_time,'h:i A');
                $is_closed = is_shop_closed_status($s_timing->day_id);
            ?>

            <tr>
                <td class="text-center"><?= $day_name ?></td>
                <?php if ($is_closed): ?>
                    <td colspan="2" class="text-center">Closed</td>
                <?php else: ?>
                    <td class="text-center"><?= $open_time ?></td>
                    <td class="text-center"><?= $close_time ?></td>
                <?php endif ?>
            </tr>        
        <?php endforeach ?>
    </tbody>
</table>