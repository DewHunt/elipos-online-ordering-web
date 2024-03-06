<?php
    $title_array = array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Miss'=>'Miss');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4>Edit Customer Information</h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info btn-lg right-side-view" href="<?= base_url('admin/customer') ?>"><i class="fa fa-reply" aria-hidden="true"></i>&nbsp;All Customer</a>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->userdata('mobile_error_message')): ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Opps!</strong> <?= $this->session->flashdata('mobile_error_message'); ?>
    </div>                
<?php endif ?>

<form class="form-horizontal form-label-left" id="customer_update_form" name="customer_update_form" method="post" action="<?= base_url('admin/customer/update') ?>">
    <input class="form-control" type="hidden" value="<?= $customer->id ?>" name="id">

    <div class="panel panel-default" style="margin-top: -15px;">
        <div class="panel-heading"><h4>Details</h4></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <select id="title" name="title" class="form-control">
                            <option id="title" name="title" value="">Please Select</option>
                            <?php foreach ($title_array as $key => $value): ?>
                                <?php
                                    $select = '';
                                    if ($key == $customer->title) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option id="title" name="title" value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" value="<?= $customer->email ?>" id="email" name="email" oninvalid="setCustomValidity('Please enter a valid email Address')" placeholder="Email">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input class="form-control" type="text" value="<?= $customer->first_name ?>" id="first-name" name="first_name" placeholder="First Name">
                        <div class="error-message">
                            <?= $this->session->flashdata('first_name_error_message') ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input class="form-control" type="text" value="<?= $customer->last_name ?>" id="last_name" name="last_name" placeholder="Last Name">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input class="form-control" type="text" value="<?= $customer->telephone ?>" id="telephone" name="telephone" placeholder="Telephone">
                        <div class="error-message">
                            <?php echo form_error('telephone', '<div class="error-message">', '</div>'); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input class="form-control" type="text" value="<?= $customer->mobile ?>" id="mobile" name="mobile" placeholder="Mobile">
                        <div class="error-message">
                            <?= $this->session->flashdata('common_number_error_message') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="margin-top: -15px;">
        <div class="panel-heading"><h4>Billing Address</h4></div>
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="billing-address-line-1">Billing Address Line 1</label>
                        <textarea class="form-control" rows="3" id="billing_address_line_1" name="billing_address_line_1" placeholder="Billing Address Line 1"><?= $customer->billing_address_line_1 ?></textarea>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="billing-address-line-2">Billing Address Line 2</label>
                        <textarea class="form-control" rows="3" id="billing_address_line_2" name="billing_address_line_2" placeholder="Billing Address Line 2"><?= $customer->billing_address_line_2 ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="billing-city">Billing City</label>
                        <input class="form-control" type="text" value="<?= $customer->billing_city ?>" id="billing_city" name="billing_city" placeholder="Billing City">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="billing-postcode">Billing Postcode</label>
                        <input class="form-control" type="text" value="<?= $customer->billing_postcode ?>" id="billing_postcode" name="billing_postcode" placeholder="Billing Postcode">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="margin-top: -15px;">
        <div class="panel-heading">
            <h4 class="card-title card-title-border">Delivery Address 
                <label class="form-check-label" style="font-weight: 500;">
                    <input class="form-check-input" type="checkbox" value="" id="same_as_address_checkbox" name="same_as_address_checkbox" style="margin-left: 30px;">&nbsp;Same as billing address</label>
                </h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-address-line-1">Delivery Address Line 1</label>
                        <textarea class="form-control" type="text" rows="3" id="delivery_address_line_1" name="delivery_address_line_1" placeholder="Delivery Address Line 1"><?= $customer->delivery_address_line_1 ?></textarea>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-address-line-2">Delivery Address Line 2</label>
                        <textarea class="form-control" type="text" rows="3" id="delivery_address_line_2" name="delivery_address_line_2" placeholder="Delivery Address Line 2"><?= $customer->delivery_address_line_2 ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-city">Delivery City</label>
                        <input class="form-control" type="text" value="<?= $customer->delivery_city ?>" id="delivery_city" name="delivery_city" placeholder="Delivery City">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="delivery-postcode">Delivery Postcode</label>
                        <input class="form-control" type="text" value="<?= $customer->delivery_postcode ?>" id="delivery_postcode" name="delivery_postcode" placeholder="Delivery Postcode">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="margin-top: -15px;">
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a type="button" href="<?= base_url('admin/customer') ?>"
                       class="btn btn-danger">Cancel</a>
                    <button class="btn btn-warning rest-button" type="button">Reset</button>
                    <button id="send" type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>