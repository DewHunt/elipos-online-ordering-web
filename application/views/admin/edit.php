<div class="page-title">
    <div class="title_left">
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Vouchers </h2>

                <?php echo anchor(base_url('admin/vouchers'), '<i class="fa fa-backward" aria-hidden="true"></i> All', 'class="btn btn-info btn-lg right-side-view"') ?>

                <div class="clearfix"></div>
            </div>
            <?php

            $save_message=get_flash_save_message();
            if($save_message){
                echo sprintf('<div class=" alert alert-info text-center">%s</div>',$save_message);
            }

            $formData=(!empty($voucher))?(array)$voucher:get_flash_form_data();
            $voucher=(!empty($formData))?(object)$formData:null;
            ?>
            <div class="x_content">
                <div class="col-lg-12"></div>


                <form id="voucher-form" method="post" action="<?=base_url('admin/vouchers/update')?>">
                    <input type="hidden" name="id" value="<?=get_property_value('id', $voucher);?>">
                    <div class=" form-group">
                        <label for="title"> Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?=get_property_value('title', $voucher);?>">
                    </div>
                    <div class=" form-group">
                        <label for="message">Description</label>
                        <textarea class="form-control" value=""
                                  id="message"
                                  name="description" placeholder="Description" rows="5"><?=get_property_value('description', $voucher);?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="min-order-amount"> Min Order Amount</label>
                        <input type="number" class="form-control" id="min-order-amount" name="min_order_amount" value="<?=get_property_value('min_order_amount', $voucher,1);?>">
                    </div>

                    <?php $validityOptions = $this->Voucher_Model->getVoucherDays();
                    $selectedOption=get_property_value('min_order_amount', $voucher);


                    ?>
                    <div class=" form-group">
                        <label for="validity-days">Validity</label>

                        <select class="form-control" name="validity_days" id="validity-days">
                            <?php
                            foreach ($validityOptions as $option) {
                                echo sprintf('<option value="%d">%s</option>', $option['days'], $option['title']);
                            }
                            ?>
                        </select>
                    </div>


                    <div class=" form-group">
                        <label for="discount-type">Discount Type</label>
                        <select class="form-control" name="discount_type" id="discount-type" value="<?=get_property_value('discount_type', $voucher);?>">
                            <option value="percent"> Percent</option>
                            <option value="amount"> Amount</option>
                        </select>
                    </div>
                    <div class=" form-group">
                        <label for="discount-amount">Discount Amount</label>
                        <input type="number" class="form-control" name="discount_amount" id="discount-amount" value="<?=get_property_value('discount_amount', $voucher,0);?>">
                    </div>
                    <div class=" form-group">
                        <label for="discount-amount-up-to">Amount Up to </label>
                        <input type="number" class="form-control" name="max_discount_amount" id="discount-amount-up-to" value="<?=get_property_value('max_discount_amount', $voucher,0);?>">
                    </div>
                    <?php
                    $orderType=get_property_value('order_type', $voucher);

                    ?>
                    <div class=" form-group">
                        <label for="order_type">Order Type</label>
                        <select class="form-control" name="order_type" id="order-type">
                            <option value="any" <?=($orderType=='any')?'selected':''?>> Any</option>
                            <option value="collection" <?=($orderType=='collection')?'selected':''?>> Collection</option>
                            <option value="delivery" <?=($orderType=='delivery')?'selected':''?>>Delivery</option>
                        </select>
                    </div>
                    <?php
                    $orderTypeToUse=get_property_value('order_type_to_use', $voucher);

                    ?>
                    <div class=" form-group">
                        <label for="order_type_to_use">Order Type To Use</label>
                        <select class="form-control" name="order_type_to_use" id="order_type_to_use" value="<?=get_property_value('order_type_to_use', $voucher);?>">
                            <option value="any" <?=($orderTypeToUse=='any')?'selected':''?>> Any</option>
                            <option value="collection" <?=($orderTypeToUse=='collection')?'selected':''?>> Collection</option>
                            <option value="delivery" <?=($orderTypeToUse=='delivery')?'selected':''?>>Delivery</option>
                            <option value="table" <?=($orderTypeToUse=='table')?'selected':''?>>Table</option>
                            <option value="bar" <?=($orderTypeToUse=='bar')?'selected':''?>>Bar</option>
                        </select>
                    </div>
                    <div class=" form-group">
                        <label for="max_time_usage">Maximum Time Usage</label>
                        <input type="number" min="1" class="form-control" name="max_time_usage" id="max_time_usage" value="<?=get_property_value('max_time_usage', $voucher,1);?>">
                    </div>


                    <div class=" form-group">
                        <label for="status">Status</label>
                        <label class="checkbox-inline">
                            <input type="radio" name="status" value="1" <?=get_property_value('status', $voucher)==1?'checked':''?>>
                            Active
                        </label>
                        <label class="checkbox-inline">
                            <input type="radio" name="status" value="0" <?=(get_property_value('status', $voucher)==0)?'checked':''?>>
                            In Acive
                        </label>
                    </div>
                    <div class=" form-group">
                        <label for="sort-order">Sort Order</label>
                        <input type="number" min="1" class="form-control" name="sort_order" id="sort-order" value="<?=get_property_value('sort_order', $voucher,1);?>">
                    </div>

                    <div class="row">
                        <button  id="send" type="submit" class="btn btn-primary" style="float: right">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>