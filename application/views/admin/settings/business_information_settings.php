<style>
    .progress[value] { color: green; width: 100%; }
</style>
<?php
    $details = '';
    if (!empty($company_details)) {
        $details = json_decode($company_details->value);
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
        <form class="form-horizontal form-label-left" id="business_information_settings_form" name="business_information_settings_form" method="post" action="<?= base_url('admin/settings/business_information_settings_save') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= !empty($company_details) ? $company_details->id : '' ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="company_details">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="company-name">Company Name</label>
                        <input type="text" name="company_name" class="form-control" id="company_name" value="<?= !empty($details) ? $details->company_name : '' ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="email-address">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= !empty($details) ? $details->email : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div for="cc-email-address">CC Email Address(separated by comma)</div>
                        <textarea rows="2" name="cc_email" class="form-control" id="cc_email"value="<?= !empty($details) ? get_property_value('cc_email',$details) : '' ?>"><?= !empty($details) ? get_property_value('cc_email',$details) : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="contact-number">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" id="contact_number" value="<?= !empty($details) ? $details->contact_number : '' ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" id="city" value="<?= get_property_value('city',$details)?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="company-address">Company Address</label>
                        <textarea type="text" rows="3" name="company_address" class="form-control" id="company_address"><?= !empty($details) ? $details->company_address : '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="food-type">Food Type</label>
                        <input type="text" name="food_type" class="form-control" id="food-type" value="<?= get_property_value('food_type',$details)?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="post-code">Post Code</label>
                        <input type="text" name="postcode" class="form-control" id="contact_number" value="<?= get_property_value('postcode',$details)?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label class="latitude">Latitude</label>
                        <input type="text" name="latitude" class="form-control" id="latitude" value="<?= get_property_value('latitude',$details)?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" class="form-control" id="longitude" value="<?= get_property_value('longitude',$details)?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="pickup-time">Pickup/Collection Time</label>
                        <input type="text" name="pickup_time" class="form-control" id="pickup_time" value="<?= get_property_value('pickup_time',$details)?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-time">Delivery Time</label>
                        <input type="text" name="delivery_time" class="form-control" id="delivery_time" value="<?= get_property_value('delivery_time',$details)?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="minimum-order-amount">Minimum Order Amount</label>
                        <input type="number" min="0" name="minimum_order_amount"  class="form-control" id="minimum_order_amount" value="<?=get_property_value('minimum_order_amount',$details)?>">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="per-slot-collection-order">Per Slot Collection Order</label>
                        <input  name="per_slot_collection_order"  class="form-control" id="per_slot_collection_order"  value="<?=get_property_value('per_slot_collection_order',$details)?>"/>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="per-slot-delivery-order">Per Slot Delivery Order</label>
                        <input  name="per_slot_delivery_order"  class="form-control" id="per_slot_delivery_order"  value="<?=get_property_value('per_slot_delivery_order',$details)?>" />
                    </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="minimum-order-amount-text">Minimum Order Amount Text</label>
                        <textarea  name="minimum_order_amount_text"  class="form-control" id="minimum_order_amount_text" ><?=get_property_value('minimum_order_amount_text',$details)?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label control-label">Company Logo</div>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" style="margin-top: 0px;">
                    <input type="file" class="form-control" name="file" id="file">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <button type="button" class="btn btn-primary btn-block image-upload">Upload Image</button>
                </div>
                <div class="logo-image-section col-xs-12 form-group row" style="margin-top: 10px;">
                    <label for="" class="col-sm-3 col-xs-12 col-form-label"></label>
                    <div class="col-sm-3 col-xs-12">
                        <div class="card" style="margin-bottom: 5px">
                            <img width="100px" height="100px" id="logoImage" class="image-preview" src="<?=(!empty(get_property_value('company_logo',$details))) ? base_url(get_property_value('company_logo',$details)):''?>">
                        </div>
                        <div class="progress" style="display: none">
                            <div class="progress-percentage text-align-center" style="color: #ffffff;background-color: green;"></div>
                            <progress style="width: 100%" class="progressbar progress progress-striped progress-animated progress-success" value="0" max="100" id="progress-bar"></progress>
                        </div>
                        <div class="image-message"></div>
                        <input type="hidden" class="input-value" name="company_logo" value="<?= get_property_value('company_logo',$details) ?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-2 col-md- 2 col-sm-3 col-xs-12 col-form-label control-label">Fav Icon</div>
                <div class="col-lg-8 col-md- 8 col-sm-3 col-xs-12">
                    <input type="file" class="form-control" name="file" id="file">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <button type="button" class="btn btn-primary btn-block image-upload">Upload Image</button>
                </div>
                <div class="logo-image-section col-xs-12 form-group row" style="margin-top: 10px;">
                    <label for="" class="col-sm-3 col-xs-12 col-form-label"></label>
                    <div class="col-sm-3 col-xs-12">
                        <div class="card" style="margin-bottom: 5px">
                            <img width="100px" height="100px" id="logoImage" class="image-preview" src="<?=(!empty(get_property_value('favicon',$details)))?base_url(get_property_value('favicon',$details)):''?>">
                        </div>

                        <div class="progress" style="display: none">
                            <div class="progress-percentage text-align-center" style="color: #ffffff;background-color: green;"></div>
                            <progress style="width: 100%" class="progressbar progress progress-striped progress-animated progress-success" value="0" max="100" id="progress-bar"></progress>
                        </div>

                        <div class="image-message"></div>
                        <input class="input-value" type="hidden" name="favicon" value="<?=get_property_value('favicon',$details)?>">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>