<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/vouchers') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Vouchers</a>
            </div>
        </div>
    </div>
    <?php
        $formData = get_flash_form_data();
        $voucher = empty($formData) ? null : (object)$formData;
    ?>

    <div class="panel-body">
        <form id="voucher-form" method="post" action="save" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <label>Title</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" value="<?=get_property_value('title', $voucher);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="status">Status</label>
                    <div class=" form-group">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?=get_property_value('status', $voucher,1)==1?'checked':''?>>
                            Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?=(get_property_value('status', $voucher,1)==0)?'checked':''?>>
                            In Acive
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Minimum Order Amount</label>
                    <div class="form-group">
                        <input type="number" class="form-control" id="min-order-amount" name="min_order_amount" value="<?=get_property_value('min_order_amount', $voucher,1);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Validity</label>
                    <div class="form-group">
                        <div id="reportrange-new" class="pull-right" style="cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="from_date" type="hidden" name="start_date" value="">
                                <input id="to_date" type="hidden" name="end_date" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Discount Type</label>
                    <div class="form-group">
                        <select class="form-control" name="discount_type" id="discount-type" value="<?=get_property_value('discount_type', $voucher);?>">
                            <option value="percent"> Percent</option>
                            <option value="amount"> Amount</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Discount Amount</label>
                    <div class="form-group">
                        <input type="number" class="form-control" name="discount_amount" id="discount-amount" value="<?=get_property_value('discount_amount', $voucher,0);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Amount Up To</label>
                    <div class="form-group">
                        <input type="number" class="form-control" name="max_discount_amount" id="discount-amount-up-to" value="<?=get_property_value('max_discount_amount', $voucher,0);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Order Type</label>
                    <div class="form-group">
                        <?php $orderType=get_property_value('order_type', $voucher); ?>
                        <select class="form-control" name="order_type" id="order-type">
                            <option value="any" <?=($orderType=='any')?'selected':''?>> Any</option>
                            <option value="collection" <?=($orderType=='collection')?'selected':''?>> Collection</option>
                            <option value="delivery" <?=($orderType=='delivery')?'selected':''?>>Delivery</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="max_time_usage">Maximum Time Usage</label>
                    <div class=" form-group">
                        <input type="number" min="1" class="form-control" name="max_time_usage" id="max_time_usage" value="<?=get_property_value('max_time_usage', $voucher,1);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="sort-order">Sort Order</label>
                    <div class=" form-group">
                        <input type="number" min="1" class="form-control" name="sort_order" id="sort-order" value="<?=get_property_value('sort_order', $voucher,1);?>">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label for="order_type_to_use">Order Type To Use</label>
                    <div class=" form-group">
                        <?php $orderTypeToUse = get_property_value('order_type_to_use', $voucher); ?>
                        <select class="form-control" name="order_type_to_use" id="order_type_to_use" value="<?=get_property_value('order_type_to_use', $voucher);?>">
                            <option value="any" <?=($orderTypeToUse == 'any') ? 'selected' : '' ?>> Any</option>
                            <option value="collection" <?=($orderTypeToUse == 'collection') ? 'selected' : '' ?>> Collection</option>
                            <option value="delivery" <?=($orderTypeToUse == 'delivery') ? 'selected' : '' ?>>Delivery</option>
                            <option value="table" <?=($orderTypeToUse == 'table') ? 'selected' : '' ?>>Table</option>
                            <option value="bar" <?=($orderTypeToUse == 'bar') ? 'selected' : '' ?>>Bar</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Description</label>
                    <div class="form-group">
                        <textarea class="form-control" value="" id="message" name="description" placeholder="Description" rows="4"><?=get_property_value('description', $voucher);?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="voucher-image">Voucher Background Image</label>
                    <div class=" form-group">
                        <input type="file" class="form-control" name="voucher_image" id="voucher_image" value="">
                    </div>  
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button  id="send" type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>