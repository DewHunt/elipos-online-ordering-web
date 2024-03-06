<style>
    .progress[value] { color: green; width: 100%; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/settings/add_opening_and_closing_time') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?php echo validation_errors(); ?></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive">
                <thead class="thead-default">
                    <tr>
                        <th width="50px" class="text-center">Order Type</th>
                        <th width="50px">SN</th>
                        <th width="100px">Day</th>
                        <th width="100px">Open Time</th>
                        <th width="100px">Close Time</th>
                        <th width="120px">Colletion/Delivery Time</th>
                        <th width="60px">Sort Order</th>
                        <th width="70px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $count = 1;
                        $collection_text = 0;
                        $delivery_text = 0;
                    ?>
                    <?php if ($shop_timing_list): ?>
                        <?php foreach ($shop_timing_list as $shop_timing): ?>
                            <?php
                                $order_type = $shop_timing->order_type;
                            ?>
                            <tr>
                                <?php if ($collection_text == 0 && $order_type == 'collection'): ?>
                                    <?php $collection_text++ ?>
                                    <td rowspan="<?= $collection_row ?>" class="text-center" style="vertical-align: middle;"><?= ucfirst($order_type)?></td>
                                <?php endif ?>

                                <?php if ($delivery_text == 0 && $order_type == 'delivery'): ?>
                                    <?php $delivery_text++ ?>
                                    <td rowspan="<?= $delivery_row ?>" class="text-center" style="vertical-align: middle;"><?= ucfirst($order_type)?></td>
                                <?php endif ?>
                                <td><?= $count++; ?></td>
                                <td><?= get_days_of_week()[$shop_timing->day_id] ?></td>
                                <td><?= !empty($shop_timing->open_time) ? date('g:i a', strtotime($shop_timing->open_time)) : ''; ?></td>
                                <td><?= !empty($shop_timing->open_time) ? date('g:i a', strtotime($shop_timing->close_time)) : ''; ?></td>
                                <td><?= !empty($shop_timing->collection_delivery_time) ? $shop_timing->collection_delivery_time.' Min' : ''?></td>
                                <td><?= !empty($shop_timing->sort_order) ? ($shop_timing->sort_order) : ''; ?></td>
                                <td>
                                    <a href="<?= base_url("admin/settings/edit_opening_and_closing_time/$shop_timing->id") ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a onclick="return confirm('Are you sure?')" href="<?= base_url("admin/settings/shop_timing_delete/$shop_timing->id") ?>" class="btn btn-danger btn-sm"><i class=" fa fa-times" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>