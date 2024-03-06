<?php
    $this->load->model('Shop_timing_Model');
    $m_shop_timing = new Shop_timing_Model();
    $shop_timings = $m_shop_timing->get_all();
    $shop_weekend_day_ids = get_shop_weekend_day_ids();
?>

<style>
    .table th, .table td{ padding: 0; }
    .table-bordered { border: none; color: #136B84; }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td { border: none; }
    .table-hover tbody tr:hover { background-color: #fff; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #fff; }
    .card-header { padding: 0.75rem 1.25rem; margin-bottom: 0; background-color: #fff; border-bottom: none; }
    .back-color { background-color: #191919; }
    .font-color-t { font-size: 40px; font-weight: bold; }
    /* Portrait and Landscape */
    @media only screen 
    and (min-device-width: 375px) 
    and (max-device-width: 667px) 
    and (-webkit-min-device-pixel-ratio: 2) { 
        h3.tittle { font-size: 1em; }
        .font-color-t { font-size: 24px; font-weight: bold; }
    }
    /* Portrait and Landscape */
    @media only screen 
    and (min-device-width: 320px) 
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2) {
        h3.tittle { font-size: 1em; }
        .font-color-t { font-size: 18px; font-weight: bold; }
    }
</style>

<table class="table table-striped table-hover table-bordered">
    <!-- <thead>
        <tr>
            <th class="text-center">Day</th>
            <th class="text-center">Opening Time</th>
            <th class="text-center">Closing Time</th>
        </tr>
    </thead> -->
    <tbody>
        <?php foreach ($shop_timings as $s_timing): ?>
            <?php
                $day_name = get_days_of_week()[$s_timing->day_id];
                $open_time = get_formatted_time($s_timing->open_time, 'h:i A');
                $close_time = get_formatted_time($s_timing->close_time, 'h:i A');
            ?>

            <?php if (!in_array($s_timing->day_id, $shop_weekend_day_ids)): ?>
                <tr>
                    <td style="width: 10%;"></td>
                    <td class="text-center back-color font-color-t" style="width: 20%;"><?= $day_name ?></td>
                    <td class="text-center font-color-t" style="width: 20%;"><?= $open_time ?></td>
                    <td class="text-center font-color-t" style="width: 20%;"><?= $close_time ?></td>
                    <td style="width: 10%;"></td>
                </tr>                
            <?php else: ?>
                <tr>
                    <td style="width: 10%;"></td>
                    <td class="text-center back-color font-color-t" style="width: 20%;"><?= $day_name ?></td>
                    <td colspan="2" class="text-center font-color-t">Closed</td>
                </tr>                
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>
