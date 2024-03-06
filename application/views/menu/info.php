<div class="restaurant-container" style="">

    <div class="restaurantfull">

        <ul>

            <li>

                            <span class="reslogo">

                                <img alt="Elipos"
                                     src="<?= base_url(get_shop_logo()) ?>" width="94"
                                     height="104"/>

                            </span>

                <span class="resdetails">

                                <span class="column80">

                                    <div class="resnamefull">A Simple way to Order Food!</div>

                                    <div class="resaddressfull">
                                     <?= get_company_address()?>
                                    </div>

                                </span>

                                <span class="column20">

                                    <div class="ratingimg">
                                        <div class="stars stars-example-css">

                                            <div class="br-wrapper br-theme-css-stars">


                                            </div>


                                        </div>
                                    </div>

                                    <div class="ratingpointfull">
                                       <!-- (0) Reviews-->
                                    </div>
                                </span>
                    <?php
                    $shop_details=get_company_details();

                    $day_number =date('w');
                    $today_shop_timing=get_today_shop_timing($day_number);
                    $open_time=null;
                    $close_time=null;
                    $delivery_time_start=null;
                    $collection_time_start=null;
                    $delivery_time_end=null;
                    $collection_time_end=null;

                    $this->data['delivery_time_start']=$delivery_time_start;
                    $this->data['delivery_time_end']=$delivery_time_end;

                    if(!empty($today_shop_timing)){
                        $open_time=get_formatted_time($today_shop_timing->open_time,'h:i A');
                        $close_time=get_formatted_time($today_shop_timing->close_time,'h:i A');

                        $delivery_time_start= date('h:i A', strtotime($today_shop_timing->open_time)+(3*3600));
                        $delivery_time_end=date('h:i A', strtotime($today_shop_timing->open_time)-(1*3600));

                        $collection_time_start= date('h:i A', strtotime($today_shop_timing->open_time)+(.2*3600));
                        $collection_time_end=date('h:i A', strtotime($today_shop_timing->open_time)-(.2*3600));


                        $this->data['delivery_time_start']=$delivery_time_start;
                        $this->data['delivery_time_end']=$delivery_time_end;
                        ?>

                        <?php
                    }
                    ?>


                                <span class="column100">

                                    <span class="column20">

                                        <div  class="resdetailsfullfont1">
                                            Delivery Time :  <?=get_property_value('delivery_time',$shop_details) ?>
                                            <br>
                                            Collection Time : <?=get_property_value('pickup_time',$shop_details) ?>
                                        </div>

                                    </span>

                                    <span class="column20">

                                        <?php


                                        if(!empty($today_shop_timing)){

                                            ?>
                                            <div class="resdetailsfullfont1">Our Opening hours <br> <?=$open_time?> - <?=$close_time?></div>

                                            <?php
                                        }
                                        ?>


                                    </span>

                                    <span class="column20">
                                        <div class="resdetailsfullfont1"> <span
                                                    id="orderMinAmount"><?php echo nl2br(get_property_value('minimum_order_amount_text',$shop_details))?></span>
                                        </div>

                                    </span>

                                    <span class="column40">


                                        <div class="resdetailsfullfont1">
                                               <?php
                                               $discount_percent=0;
                                               $minimum_order_amount=0;
                                               $minimum_delivery_order_amount=0;
                                               $discount_data=get_discount_data();
                                               $discount_on_collection=0;
                                               $discount_on_delivery=0;
                                               $discount_percent_on_collection=0;
                                               $discount_percent_on_delivery=0;

                                               $minimum_order_amount_for_discount_on_collection=0;
                                               $minimum_order_amount_for_discount_on_delivery=0;


                                               $discount_percent_on_first_order=0;
                                               $minimum_order_amount_for_discount_on_first_order=0;
                                               $offer_information_text='';

                                               if(!empty($discount_data)){
                                                   $offer_information_text=  get_array_key_value('offer_information',$discount_data);
                                                   $discount_percent_key='';
                                                   $minimum_order_amount_key='';
                                                   /*    if($order_type=='delivery'){
                                                           $discount_percent_key='delivery_discount_percent';
                                                           $minimum_order_amount_key='delivery_discount_minimum_order_amount';
                                                       }else if($order_type=='collection'){
                                                           $discount_percent_key='collection_discount_percent';
                                                           $minimum_order_amount_key='collection_discount_minimum_order_amount';
                                                       }*/

                                                   $discount_percent=get_array_key_value($discount_percent_key,$discount_data);
                                                   $minimum_order_amount=get_array_key_value($minimum_order_amount_key,$discount_data);


                                                   /*Collection Discount*/
                                                   $discount_percent_on_collection=get_array_key_value('collection_discount_percent',$discount_data);
                                                   $minimum_order_amount_for_discount_on_collection=get_array_key_value('collection_discount_minimum_order_amount',$discount_data);




                                                   /*Delivery Discount*/
                                                   $discount_percent_on_delivery=get_array_key_value('delivery_discount_percent',$discount_data);
                                                   $minimum_order_amount_for_discount_on_delivery=get_array_key_value('delivery_discount_minimum_order_amount',$discount_data);

                                                   $minimum_order_amount_for_discount_on_first_order=get_array_key_value('first_order_discount_minimum_order_amount',$discount_data);
                                                   $discount_percent_on_first_order=get_array_key_value('first_order_discount_percent',$discount_data);
                                               }
                                               $minimum_delivery_order_amount=get_array_key_value('minimum_delivery_order_amount',$discount_data);
                                               ?>
                                                   <span style=""> <?php echo  nl2br($offer_information_text)?></span>


                                        </div>
                                    </span>
                                </span>
                            </span>
            </li>
        </ul>
    </div>

</div>