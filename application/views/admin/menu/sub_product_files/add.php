<?php
    $sub_product_form_data= $this->session->userdata('sub_product_from_data');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Sub Product Files Items</a>
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files/assign') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Assign/Remove Sub Product Files Item</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="sub_product_save_form" name="sub_product_save_form" method="post" action="<?= base_url('admin/sub_product_files/save') ?>">
            <div class="error error-message"><?= validation_errors(); ?></div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-short-name">Sub Product Short Name</label>
                        <input class="form-control" type="text" id="sub_product_name" name="sub_product_name" placeholder="Sub Product Short Name" value="<?= get_array_key_value('selectiveItemName',$sub_product_form_data) ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sub-product-full-name">Sub Product Full Name</label>
                        <input class="form-control" type="text" id="sub_product_full_name" name="sub_product_full_name" placeholder="Sub Product Full Name" value="<?= get_array_key_value('selectiveItemFullName',$sub_product_form_data) ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="table-price">Table Price</label>
                        <input class="form-control" type="text" id="table_price" name="table_price" placeholder=" Table Price" value="0">
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="takeaway-price">Takeaway Price</label>
                        <input class="form-control" type="text" id="takeaway_price" name="takeaway_price" placeholder="Takeaway Price" value="0">
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="bar-price">Bar Price</label>
                        <input class="form-control" type="text" id="bar_price" name="bar_price" placeholder="Bar Price" value="0">
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="vat-rate">Vat Rate</label>
                        <input type="text" class="form-control" id="vat_rate" name="vat_rate" placeholder="Vat Rate" value="0">
                        <input type="checkbox" class="form-check-input" id="vat_included" name="vat_included"><span> Vat Included</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" placeholder="Sort Order" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/sub_product_files') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>