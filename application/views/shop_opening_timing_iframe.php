<?php
    $this->load->model('Shop_timing_Model');
    $m_shop_timing = new Shop_timing_Model();
    $shop_timings = $m_shop_timing->get_all();
    $shop_weekend_day_ids = get_shop_weekend_day_ids();
?>

<style>
	.table { width: 50%; }
    .table th, .table td{ padding: 0; }
    .table-bordered { border: none; }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td { border: 0x solid black; color: #136B84; }
    .table-hover tbody tr:hover { background-color: #fff; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #fff; }
    .card-header { padding: 0.75rem 1.25rem; margin-bottom: 0; background-color: #fff; border-bottom: none; }
    .back-color { background-color: #191919; }
    .font-color-t { font-size: 24px; font-weight: bold; }
    /* Portrait and Landscape */
    @media only screen 
    and (min-device-width: 375px) 
    and (max-device-width: 667px) 
    and (-webkit-min-device-pixel-ratio: 2) {
    	.table { width: 75%; }
        h3.tittle { font-size: 1em; }
        .font-color-t { font-size: 24px; font-weight: bold; }
    }
    /* Portrait and Landscape */
    @media only screen 
    and (min-device-width: 320px) 
    and (max-device-width: 568px)
    and (-webkit-min-device-pixel-ratio: 2) {
    	.table { width: 75%; }
        h3.tittle { font-size: 1em; }
        .font-color-t { font-size: 18px; font-weight: bold; }
    }
    .center-text { text-align: center; }
</style>

<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th colspan="3" class="center-text"><h3>Our Opening & Closing Hours</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shop_timings as $s_timing): ?>
            <?php
                $day_name = get_days_of_week()[$s_timing->day_id];
                $open_time = get_formatted_time($s_timing->open_time, 'h:i A');
                $close_time = get_formatted_time($s_timing->close_time, 'h:i A');
            ?>

            <?php if (!in_array($s_timing->day_id, $shop_weekend_day_ids)): ?>
                <tr>
                    <td class="center-text back-color font-color-t"><?= $day_name ?></td>
                    <td class="center-text font-color-t"><?= $open_time ?></td>
                    <td class="center-text font-color-t"><?= $close_time ?></td>
                </tr>                
            <?php else: ?>
                <tr>
                    <td class="center-text back-color font-color-t"><?= $day_name ?></td>
                    <td colspan="2" class="text-center font-color-t">Closed</td>
                </tr>                
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>
