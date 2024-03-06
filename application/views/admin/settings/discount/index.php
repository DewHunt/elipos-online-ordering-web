<?php
    $discount = $this->Settings_Model->get_by(array('name'=>'discount',),true);
    $discount_value = (!empty($discount)) ? $discount->value : null;
    $discount_data = (!empty($discount_value)) ? json_decode($discount_value,true) : array();
    $details = '';
    $days_array = array('0'=>'Sunday','1'=>'Monday','2'=>'Tuesday','3'=>'Wednesday','4'=>'Thrusday','5'=>'Friday','6'=>'Saturday');
    // dd(get_array_key_value('delivery_day_ids[]',$discount_data));

    $dailyDiscountAvailability = 0;
    $firstOrderAvailability = 0;
    if (isset($discount_data[8])) {
        $dailyDiscountAvailability = get_array_key_value('dailyDiscountAvailability',$discount_data[8]);
        $firstOrderAvailability = get_array_key_value('firstOrderAvailability',$discount_data[8]);
    }

    if (!empty($discount_data)) {
        $collections_details = get_array_key_value('collections_day_ids[]',$discount_data);
    } else {
        $collections_details = '';
    }

    $loyalty_program = $this->Settings_Model->get_by(array('name'=>'loyalty_programs',),true);
    $loyalty_program_value = (!empty($loyalty_program)) ? $loyalty_program->value : null;
    $loyalty_program_data = (!empty($loyalty_program_value)) ? json_decode($loyalty_program_value,true) : array();
?>

<style type="text/css">
    #discount-settings label{ padding: 5px 5px; font-size: 16px; }
    #discount-settings input{ width: 100px; }
    #discount-settings .form-group{ display: inline-flex !important; }
    .panel { margin-bottom: 6px; }
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="discount-settings-form" method="post" action="discount_save" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Discount Management</h2></div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="dailyDiscountAvailability" value="0">
                            <input type="hidden" name="firstOrderAvailability" value="0">

                            <label class="checkbox-inline">
                                <input type="checkbox" name="dailyDiscountAvailability" value="1" <?= $dailyDiscountAvailability == 1 ? 'checked' : '' ?>><b>Is Added Daily Discount Availability With Others</b>
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="firstOrderAvailability" value="1" <?= $firstOrderAvailability == 1 ? 'checked' : '' ?>><b>Is Added First Order Availability With Others</b>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Day</th>
                                <th class="text-center">Delivery Discount (%)</th>
                                <th class="text-center">Collection Discount (%)</th>
                                <th class="text-center">Minimum Amount</th>
                                <th class="text-center">Maximum Discount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($days_array as $key => $value): ?>
                                <tr>
                                    <th><?= $value ?> <input type="hidden" name="day_ids[]" value="<?= $key ?>"></th>
                                    <th>
                                        <?php
                                            $delivery_discount_percent = '';
                                            if (isset($discount_data[$key])) {
                                                $delivery_discount_percent = get_array_key_value('delivery_discount_percent',$discount_data[$key]);
                                            }
                                        ?>
                                        <input class="form-control" type="text" name="delivery_discount_percent[]" id="delivery_discount_percent_<?= $key ?>" value="<?= $delivery_discount_percent ?>">
                                    </th>
                                    <th>
                                        <?php
                                            $collection_discount_percent = '';
                                            if (isset($discount_data[$key])) {
                                                $collection_discount_percent = get_array_key_value('collection_discount_percent',$discount_data[$key]);
                                            }
                                        ?>
                                        <input class="form-control" type="text" name="collection_discount_percent[]" id="collection_discount_percent_<?= $key ?>" value="<?= $collection_discount_percent ?>">
                                    </th>
                                    <th>
                                        <?php
                                            $minimum_order_amount = '';
                                            if (isset($discount_data[$key])) {
                                                $minimum_order_amount = get_array_key_value('minimum_order_amount',$discount_data[$key]);
                                            }
                                        ?>
                                        <input class="form-control" type="text" name="minimum_order_amount[]" id="minimum_order_amount_<?= $key ?>" value="<?= $minimum_order_amount ?>">
                                    </th>
                                    <th>
                                        <?php
                                            $maximum_order_amount = '';
                                            if (isset($discount_data[$key])) {
                                                $maximum_order_amount = get_array_key_value('maximum_order_amount',$discount_data[$key]);
                                            }
                                        ?>
                                        <input class="form-control" type="text" name="maximum_order_amount[]" id="maximum_order_amount_<?= $key ?>" value="<?= $maximum_order_amount ?>">
                                    </th>
                                </tr>                                
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="discount_message" style="color: black;">
                                <h4>
                                    Discount Message Format : You have got (<b>discountPercent</b>%) <b>discountAmount</b> from <b>totalAmount</b> for <b>orderType</b>
                                </h4>
                                <p style="color: green;">Example:You have got (6%) $10 from $120</p>
                            </label>
                            <?php
                                $discount_message_format = '';
                                if (isset($discount_data[7])) {
                                    $discount_message_format = get_array_key_value('discount_message_format',$discount_data[7]);
                                }
                            ?>
                            <div class="form-group" >
                                <input type="text" name="discount_message_format"  class="form-control" id="discount_message_format" value="<?= $discount_message_format ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="delivery_discount_percent" class="form-control-label">First Order Discount</label>
                                    <?php
                                        $first_order_discount_percent = '';
                                        if (isset($discount_data[7])) {
                                            $first_order_discount_percent = get_array_key_value('first_order_discount_percent',$discount_data[7]);
                                        }
                                    ?>
                                    <div class="form-group">
                                        <input type="number" min="0" step="0.01" name="first_order_discount_percent"  class="form-control" id="first_order_discount_percent" value="<?= $first_order_discount_percent ?>">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="first_order_discount_percent" class="form-control-label">% For Minimum order amount</label>
                                    <?php
                                        $first_order_discount_minimum_order_amount = '';
                                        if (isset($discount_data[7])) {
                                            $first_order_discount_minimum_order_amount = get_array_key_value('first_order_discount_minimum_order_amount',$discount_data[7]);
                                        }
                                    ?>
                                    <div class="form-group">
                                        <input type="number" min="0" name="first_order_discount_minimum_order_amount"  class="form-control" id="first_order_discount_minimum_order_amount" value="<?= $first_order_discount_minimum_order_amount ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <label for="discount_message" class="form-control-label">Offer Information</label>
                            <?php
                                $offer_information = '';
                                if (isset($discount_data[7])) {
                                    $offer_information = get_array_key_value('offer_information',$discount_data[7]);
                                }
                            ?>
                            <div class="form-group" >
                                <textarea class="form-control" name="offer_information" rows="5">
                                    <?= $offer_information ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-footer text-right">
                    <button type="submit" id="contact-us-email-config-save-button" class="btn btn-md btn-primary">
                        <i class="fa fa-save"></i>&nbsp;Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="discount-settings-form" method="post" action="<?= base_url('admin/settings/loyalty_program_save') ?>" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <h2>Loyalty Program</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            <span class="btn btn-md btn-success" onclick="add_new_loyalty()">
                            Add New Loyalty
                        </span>
                        </div>
                    </div>          
                </div>

                <div class="panel-body">
                    <?php if (!empty($this->session->flashdata('loyalty_success_msg'))): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success!</strong> <?= $this->session->flashdata('loyalty_success_msg') ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($this->session->flashdata('loyalty_error_msg'))): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Danger!</strong> <?= $this->session->flashdata('loyalty_error_msg') ?>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <?php
                                    $loyaltyProgramAvailability = '';
                                    if (isset($discount_data[0]) && isset($loyalty_program_data[0])) {
                                        $loyaltyProgramAvailability = get_array_key_value('loyaltyProgramAvailability',$loyalty_program_data[0]);
                                    }
                                ?>
                                <input type="hidden" name="loyaltyProgramAvailability" value="0">

                                <label class="checkbox-inline">
                                    <input type="checkbox" name="loyaltyProgramAvailability" value="1" <?= $loyaltyProgramAvailability == 1 ? 'checked' : '' ?>><b>Is Added Loyalty Program Availability With Others</b>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered table-striped" id="loyalty_program">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th width="20px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $rowCount = 1; $arrayIndex = 0;?>
                                    <?php if ($loyalty_program_data): ?>
                                        <?php foreach ($loyalty_program_data as $loyalty_program): ?>
                                            <?php if ($arrayIndex > 0): ?>
                                                <tr id="rowId_<?= $rowCount ?>">
                                                    <td id="colData_<?= $rowCount ?>">
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Number Of Order</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="number" class="numberOfOrder" name="numberOfOrder[]" value="<?= get_array_key_value('number_Of_order',$loyalty_program) ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Minimum Order Amount</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="number" class="minimumOrderAmount" name="minimumOrderAmount[]" value="<?= get_array_key_value('minimum_order_amount',$loyalty_program) ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                <label>Maximum Discount Amount</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="number" class="maximumDiscountAmount" name="maximumDiscountAmount[]" value="<?= get_array_key_value('maximum_discount_amount',$loyalty_program) ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Offer Type</label>
                                                                <div class="form-group">
                                                                    <?php
                                                                        $offerTypeArray = array('fixed' => 'Fixed','percentage' => 'Percantage','others' => 'Others');
                                                                    ?>
                                                                    <select class="form-control select2 offerType" row-count="<?= $rowCount ?>" name="offerType[]">
                                                                        <option value="">Select Offer Type</option>
                                                                        <?php foreach ($offerTypeArray as $key => $value): ?>
                                                                            <?php
                                                                                if (get_array_key_value('offer_type',$loyalty_program) == $key) {
                                                                                    $select = "selected";
                                                                                } else {
                                                                                    $select = "";
                                                                                }                                                                
                                                                            ?>
                                                                            <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                                                <label>Discount Amount</label>
                                                                <div class="form-group">
                                                                    <input class="form-control" type="number" min="0" step="0.01" class="discountAmount" name="discountAmount[]" value="<?= get_array_key_value('discount_amount',$loyalty_program) ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <label>Description</label>
                                                                <div class="form-group">
                                                                    <textarea class="form-control" rows="2" class="description" id="description_<?= $rowCount ?>" name="description[]"  <?= get_array_key_value('offer_type',$loyalty_program) == 'others' ? 'required' : '' ?>><?= get_array_key_value('description',$loyalty_program) ?></textarea>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="statusId_<?= $rowCount ?>" name="status[]" value="add">
                                                            <input type="hidden" id="rowStatusId_<?= $rowCount ?>" name="rowStatus[]" value="old">
                                                        </div>
                                                    </td>
                                                    <td class="text-center" id="colBtn_<?= $rowCount ?>">
                                                        <span class="btn- btn-sm btn-danger" id="removeBtnId_<?= $rowCount ?>" onclick="remove_loyalty_program(<?= $rowCount ?>)">
                                                            <i class="fa fa-trash"></i>
                                                        </span>
                                                        <span class="btn- btn-sm btn-primary" id="restoreBtnId_<?= $rowCount ?>" onclick="restore_loyalty_program(<?= $rowCount ?>)" style="display: none;">
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php $rowCount++ ?> 
                                            <?php endif ?>
                                            <?php $arrayIndex++; ?>
                                        <?php endforeach ?>                                        
                                    <?php endif ?>
                                </tbody>
                            </table>
                            <input type="hidden" id="rowCount" name="rowCount" value="<?= $rowCount - 1 ?>">
                        </div>
                    </div>
                </div>

                <div class="panel-footer text-right">
                    <button type="submit" id="contact-us-email-config-save-button" class="btn btn-md btn-primary">
                        <i class="fa fa-save"></i>&nbsp;Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="padding-bottom: 100px;"></div>