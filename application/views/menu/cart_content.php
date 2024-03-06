<div class="content-cartspan" >
    <div id="scolling-content-cart" class="theiaStickySidebar">
        <div class="mycart">
            <div class="cartheading">
                <div class="cartheading_text">Your Order</div>
            </div>


            <?php







            if (strtolower($this->session->userdata('menu_page_session')) == strtolower(base_url('menu'))) {


                ?>

                <?php if (!empty($this->session->userdata('order_type_session'))) { ?>
                    <?php

                    $order_type_session = $this->session->userdata('order_type_session'); ?>


                    <div class="cartdelpick cart-delivery">
                        <ul>
                            <li>
                                <?php


                                if($this->order_type=='delivery_and_collection'){
                                    ?>
                                    <span class="delpick">
                                                    <input class="delivery_type" type='radio' name='deliverytype' value='delivery' id='delivery_type'<?= $order_type_session == 'delivery' ? 'checked' : '' ?>/>
                                                    Delivery


                                                    <input class="delivery_type" type='radio' name='deliverytype' value='collection' id='collection_type'<?= $order_type_session == 'collection' ? 'checked': '' ?>/>
                                                    Collection
                                                </span>
                                    <?php
                                }else if($this->order_type=='delivery'){
                                    ?>
                                    <span class="delpick">
                                                    <input class="delivery_type" type='radio' name='deliverytype' value='delivery' id='delivery_type' checked/>
                                                    Delivery

                                                </span>

                                    <?php
                                }else{
                                    ?>
                                    <span class="delpick">


                                                    <input class="delivery_type" type='radio' name='deliverytype' value='collection' id='collection_type' checked/>
                                                    Collection
                                                </span>

                                    <?php
                                }






                                ?>

                            </li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <div class="cartdelpick cart-delivery">
                        <ul>
                            <li>
                                <?php




                                if($this->order_type=='delivery_and_collection'){
                                    ?>

                                    <span class="delpick">
                                                    <input class="delivery_type" type='radio' name='deliverytype' value='delivery' id='delivery_type'/>
                                                    Delivery

                                                    <input class="delivery_type" type='radio' name='deliverytype' value='collection' id='collection_type' checked/>
                                                    Collection
                                                </span>
                                    <?php
                                }else if($this->order_type=='delivery'){
                                    ?>

                                    <span class="delpick">
                                                    <input class="delivery_type" type='radio' name='deliverytype' value='delivery' id='delivery_type' checked / >
                                                    Delivery

                                                </span>
                                    <?php
                                }else{
                                    ?>
                                    <span class="delpick">


                                        <input class="delivery_type" type='radio' name='deliverytype' value='collection' id='collection_type' checked/>
                                                    Collection
                                                </span>
                                    <?php
                                }








                                ?>
                            </li>
                        </ul>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="product-cart-block">
                <?= $product_cart ?>
            </div>

        </div>
    </div>
</div>

<div class="showcart_menuscroll">
    <a href="#scolling-content-cart">Cart</a>
</div>


<script type="text/javascript">
    $(".cart-delivery input[type='radio']").click(function (event) {

        if($(this).is(':checked')){
            var orderType = $(this).val();

            var orderTypeAlterValue=(orderType=='collection')?'delivery':'collection';

            $.ajax({
                type: "POST",
                url: '<?=base_url('menu/get_order_type_session')?>',
                data: {order_type:orderType},
                success: function (data) {
                    var cart=data['cart_data'];
                    var isValidWithOrderType=data['isValidWithOrderType'];
                    if(!isValidWithOrderType){

                        $("input[name=deliverytype][value="+orderTypeAlterValue+"]").prop('checked', true);
                        $('.cartOrderTypeNotChangeAbleModal .message').html(data['cartOrderTypeChangeMessage']);
                        $('.cartOrderTypeNotChangeAbleModal').modal('show');
                    }else{
                        localStorage.setItem('orderType',orderType);
                    }

                    $('.product-cart-block').html(cart);

                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }

    });
</script>

<?php

$this->load->view('menu/order_type_not_change_able_modal',$this->data);
?>



