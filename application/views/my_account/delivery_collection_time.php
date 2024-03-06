<div class="form-group">
    <?php
        $order_type = get_sess_order_type();
        $is_shop_closed = is_shop_closed();
        $is_pre_order = is_pre_order();
        $timeList = getShopOpeningAndClosingTimeList($is_shop_closed,$order_type);
    ?>

    <?php if ($order_type == 'delivery'): ?>
        <h4 class="color_green"><strong>DELIVERY TIME</strong></h4>
    <?php elseif ($order_type == 'collection'): ?>
        <h4 class="color_green"><strong>COLLECTION TIME</strong></h4> 
    <?php elseif ($order_type == 'dine_in'): ?>
        <?php $order_type = 'collection' ?>
        <h4 class="color_green"><strong>Dine-In TIME</strong></h4>        
    <?php endif ?>

    <?php if (!empty($timeList)): ?>
        <select class="input1" name="delivery_time" id="delivery_time">
            <option value="" selected readonly >Please select a time</option>
            <?php foreach ($timeList as $key => $value): ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php endforeach ?>
        </select>
    <?php else: ?>
        <div class="alert alert-info" role="alert">Time Is Not Available At This Moment <?= ucfirst($order_type) ?></div>
    <?php endif ?>
</div>