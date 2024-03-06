<style>
    .progress[value] { color: green; width: 100%; }
</style>
<?php
    $currency_value = '';
    if (!empty($currency)) {
        $currency_value = json_decode($currency->value);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?php echo validation_errors(); ?></div>
        <form class="form-horizontal form-label-left" id="currency_settings_form" name="currency_settings_form" method="post" action="<?= base_url('admin/settings/currency_settings_save') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= !empty($currency) ? $currency->id : '' ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="currency">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="currency-symbol">Currency Symbol</label>
                        <input class="form-control" type="text" value="<?= !empty($currency_value) ? $currency_value->symbol : '' ?>" id="symbol" name="symbol" placeholder="Currency Symbol">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group ">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label for="placement">Placement</label>
                            <?php
                                $currency_placement = !empty($currency_value) ? $currency_value->placement : '';
                                $placement_array = array('left'=>'Left','right'=>'Right');
                            ?>
                            <select name="placement" class="form-control" id="placement">
                                <option value="">Please Select</option>
                                <?php foreach ($placement_array as $key => $value): ?>
                                    <?php
                                        $select = '';
                                        if ($key == $currency_placement) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/settings/currency') ?>" class="btn btn-danger">Cancel</a>
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>