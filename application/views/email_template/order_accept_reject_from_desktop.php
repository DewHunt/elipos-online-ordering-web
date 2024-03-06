<div class="basket-page  background-white">
    <div class="max-page order-success">
        <div class="card">
            <div class="card-header text-xs-center">

                <?php

                if($accept_reject_message=='accept'){
                    echo ' <h1 style="font-size: 150%">Order Accepted </h1>';

                }else if($accept_reject_message=='reject'){
                    echo ' <h1 style="font-size: 150%;color:red">Order Rejected </h1>';
                }
                ?>
            </div>
            <div class="card-block">
                <h2>Order ID : <?=$order_id?></h2>
                <p><?php

                    if($accept_reject_message=='accept'){
                        echo '<h1>Your order has been accepted .</h1>';

                        if(!empty($time)){
                            echo '<h1>' .ucfirst($order_type) .' time '.$time.'</h1>';
                        }

                        ?>
                    <?php
                    }else if($accept_reject_message=='reject'){
                        echo '<h1>Your order has been  rejected ';

                        $echo_message= (!empty($message))?' because '.$message:'';

                        echo $echo_message.'</h1>';

                    }

                    ?></p>
             <!--   <div class="back-to-menu-button text-xs-left">
                    <a  href="<?/*=base_url('products')*/?>" class="btn btn-primary">Back To Menu</a>
                </div>-->
            </div>
        </div>

    </div>

</div>