<?php
    $weekendDayId = get_shop_weekend_day_ids();
    $allTime = $this->Shop_timing_Model->get_all($orderType);    
    $searchTime = "";
    $serachDayId = "";
    $printDayId = "";
    $start = false;
?>

<?php if (isset($displayOrderType)): ?>
    <h5><?= ucfirst($displayOrderType) ?></h5>
<?php endif ?>

<?php foreach ($allTime as $time): ?>
    <?php if (!in_array($time->day_id,$weekendDayId)): ?>
        <?php if ($time->collection_delivery_time != $searchTime): ?>
            <?php if ($start == true): ?>
                <?php if ($serachDayId != $printDayId): ?>
                    to <?= date('D', strtotime("Sunday + $serachDayId Days")) ?>
                <?php endif ?>
                <?php $start = false; ?>
                : <?= $searchTime; ?> Min</p>
            <?php endif ?>

            <?php if ($start == false): ?>
                <p><?= date('D', strtotime("Sunday + $time->day_id Days")) ?> 
                <?php $printDayId = $time->day_id; ?>
            <?php endif ?>                            
        <?php endif ?>

        <?php
            $start = true;
            $searchTime = $time->collection_delivery_time;
            $serachDayId = $time->day_id;
        ?>        
    <?php endif ?>
<?php endforeach ?>

<?php if ($start == true): ?>
    <?php if ($serachDayId != $printDayId): ?>
        to <?= date('D', strtotime("Sunday + $serachDayId Days")) ?>
    <?php endif ?>
    <?php $start = false; ?>
    : <?= $time->collection_delivery_time; ?> Min</p>
<?php endif ?>