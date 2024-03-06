<div class="menucontentarea" id="">
    <?php
    $company_details=get_company_details();



    ?>

    <div class="info_area">
        <div class="info_data_area">
            <h1>Restaurant Overview :</h1>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="payment-table">

                <tr class="even">
                    <td width="25%" class="bdr-bottom bdr-right">Address :</td>
                    <td width="75%" class="bdr-bottom">
                        <?= get_company_address() ?>

                    </td>
                </tr>

                <tr class="odd">
                    <td width="25%" class="bdr-bottom bdr-right">Cuisines :</td>
                    <td width="75%" class="bdr-bottom"><?=get_property_value('food_type',$company_details)?>
                    </td>
                </tr>

                <tr class="odd">
                    <td width="25%" class="bdr-bottom bdr-right">Pickup Time : </td>
                    <td width="75%" class="bdr-bottom"><?=get_property_value('pickup_time',$company_details)?><br>
                    </td>
                </tr>

                <tr class="odd">
                    <td width="25%" class="bdr-bottom bdr-right">Payment Method :</td>
                    <td width="75%" class="bdr-bottom">

                        <?php
                        $payment_gateways= get_payment_gateways();
                        //var_dump($payment_gateways);
                        if($this->payment_method=='both'){
                            echo 'Cash ';
                            foreach ($payment_gateways as $payment){
                               echo  ', '.ucfirst($payment);
                            }


                        }else if($this->payment_method=='cash'){
                            echo 'Cash ';
                        }else{

                            $i=0;
                            foreach ($payment_gateways as $payment){
                               echo  ($i++==0)?'':',';
                                echo  ucfirst($payment);
                            }
                        }

                        ?>
                    </td>
                </tr>

            </table>
        </div>

        <div class="info_data_area">

            <?php

            $today_shop_timing=get_today_shop_timing();

            if(!empty($today_shop_timing)){
                $open_time=get_formatted_time($today_shop_timing->open_time,'h:i A');
                $close_time=get_formatted_time($today_shop_timing->close_time,'h:i A');

                ?>
            <h1>Opening Hour :<?=$open_time?> - <?=$close_time?></h1>

                <?php
            }
            ?>



        </div>


</div>
</div>