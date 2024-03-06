<?php
    $shop_details = get_company_details();

    $day_number = date('w');
    $today_shop_timing = get_today_shop_timing($day_number);
    $open_time = null;
    $close_time = null;
    $delivery_time_start = null;
    $collection_time_start = null;
    $delivery_time_end = null;
    $collection_time_end = null;
    $time_col_class = "col-xl-12 col-lg-12 col-md-12 col-sm-12";
    $payment_settings = get_payment_settings();
    $system_order_type = get_property_value('order_type', $payment_settings);
    if ($system_order_type == "delivery_and_collection") {
        $time_col_class = "col-xl-6 col-lg-6 col-md-6 col-sm-6";
    }

    $this->data['delivery_time_start'] = $delivery_time_start;
    $this->data['delivery_time_end'] = $delivery_time_end;

    if(!empty($today_shop_timing)){
        $open_time = get_formatted_time($today_shop_timing->open_time,'h:i A');
        $close_time = get_formatted_time($today_shop_timing->close_time,'h:i A');

        $delivery_time_start = date('h:i A', strtotime($today_shop_timing->open_time)+(3*3600));
        $delivery_time_end = date('h:i A', strtotime($today_shop_timing->open_time)-(1*3600));

        $collection_time_start = date('h:i A', strtotime($today_shop_timing->open_time)+(.2*3600));
        $collection_time_end = date('h:i A', strtotime($today_shop_timing->open_time)-(.2*3600));

        $this->data['delivery_time_start'] = $delivery_time_start;
        $this->data['delivery_time_end'] = $delivery_time_end;
    }
?>


<div class="info-top">
    <div class="row no-margin no-padding" style="border: 0px solid #000;">
        <?php
            $currentDayNumber = date('w');
            $discountData = get_discount_data();
            $specialOffer = $discountData ? $discountData[$currentDayNumber] : [];
        ?>

        <?php if ($specialOffer && (!empty($specialOffer['collection_discount_percent']) && $specialOffer['collection_discount_percent'] > 0) || (!empty($specialOffer['delivery_discount_percent']) && $specialOffer['delivery_discount_percent'] > 0)): ?>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 offer-and-time col-bottom-border col-bottom-pad">
                <h5>Special Offer</h5>
                <?php if ($specialOffer['collection_discount_percent'] > 0): ?>                    
                    <p><?= $specialOffer['collection_discount_percent'] ?>% off On Collection Orders Over £<?= $specialOffer['minimum_order_amount'] ?></p>
                <?php endif ?>

                <?php if ($specialOffer['delivery_discount_percent'] > 0): ?>                    
                    <p><?= $specialOffer['delivery_discount_percent'] ?>% off On Delivery Orders Over £<?= $specialOffer['minimum_order_amount'] ?></p>
                <?php endif ?>
            </div>
        <?php endif ?>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 col-top-pad col-bottom-pad">
            <div class="row">
                <?php if ($system_order_type == "collection" || $system_order_type == "delivery_and_collection"): ?> 
                    <div class="<?= $time_col_class ?> col text-center offer-and-time col-right-border">
                        <?php
                            $data['orderType'] = 'collection';
                            $data['displayOrderType'] = 'Collection Time';
                            $this->load->view('menu2/collection_delivery_time',$data);
                        ?>
                    </div>
                <?php endif ?>

                <?php if ($system_order_type == "delivery" || $system_order_type == "delivery_and_collection"): ?>
                    <div class="<?= $time_col_class ?> col text-center offer-and-time">
                        <?php
                            $data['orderType'] = 'delivery';
                            $data['displayOrderType'] = 'Delivery Time';
                            $this->load->view('menu2/collection_delivery_time',$data);
                        ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if ($specialOffer && (empty($specialOffer['collection_discount_percent']) && $specialOffer['collection_discount_percent'] <= 0) && (empty($specialOffer['delivery_discount_percent']) && $specialOffer['delivery_discount_percent'] <= 0)): ?>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 offer-and-time col-bottom-border col-bottom-pad"></div>
        <?php endif ?>

        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
            <div class="row">
                <?php if ($this->Customer_Model->customer_is_loggedIn() == true): ?>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-col-pad text-center">
                        <a href="<?= base_url('my_account/customer_order_list')?> " class="btn btn-sm btn-success btn-width"><i class="fa fa-sign-in" aria-hidden="true"></i> My Account</a>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-col-pad text-center">
                        <a href="<?= base_url('my_account/logout')?> " class="btn btn-sm btn-danger btn-width"><i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a>
                    </div>
                <?php else: ?>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-col-pad text-center">
                        <a href="<?= base_url('my_account')?> " class="btn btn-sm btn-success btn-width"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;Sign In</a>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 col-6 btn-col-pad text-center">
                        <a href="<?= base_url('my_account')?> " class="btn btn-sm btn-success btn-width"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Sign Up</a>
                    </div>
                <?php endif ?>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                    <?php if (!empty($today_shop_timing)): ?>
                        <p style="padding-top: 5px;">
                            <?php if (is_shop_weekend_off()): ?>
                                <span style="color: red; font-weight: bold;">WE ARE CLOSED</span> 
                            <?php else: ?>
                                Today's Opening Hours: <?= $open_time ?> - <?= $close_time ?>
                            <?php endif ?>
                        </p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>