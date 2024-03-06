<script type="text/javascript">
    itemHover();
    function itemHover() {
        $('.table-cart-details .item').hover(function () {
            $('.item-qty').css('display','block');
            $('.item-qty',this).css('display','none');
            $('.item-quantity-handler').hide();
            $('.item-quantity-handler',this).css('display','inline-flex');
            // $('.item-quantity-handler',this).css('display','block');
            $('.item-remove').css('display','none');
            $('.item-remove',this).css('display','block');
            $('.item-price').css('display','block');
            $('.item-price',this).css('display','none');
        });
        return false;
    }
    removeItem();
    incrementQty();
    decrementQty();
    function removeItem() {
        $('.item-remove').unbind('click');

        $('.item-remove').on('click', function (event) {
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/remove_item_from_cart') ?>',
                data: {'row_id': $(this).attr('row-id')},
                success: function (data) {
                    $('.product-cart-block').html(data['cart_content']);
                    $('.mobile-cart-block').html(data['mobile_cart']);
                    cartScroll();
                    removeItem();
                    incrementQty();
                    decrementQty();
                    //  itemHover();
                },
                error: function (error) {
                    console.log("error occured");
                    removeItem();
                    incrementQty();
                    decrementQty();
                    // itemHover();
                }
            });
            event.preventDefault();
        });
        return false;
    }

    function incrementQty() {
        $('.item-quantity-handler .increment').unbind('click');
        $('.item-quantity-handler .increment').on('click', function (event) {
            var dish=$(this);
            $.ajax({
                type: "POST",
                url:'<?=base_url('menu/update_cart') ?>',
                data: {'row_id': $(this).attr('row-id'), 'plus_minus': 'plus', 'id': $(this).attr('id')},
                success: function (data) {
                    if(data['isUpdated']){
                        dish.siblings('.item-qty-middle').val(data['quantity']);
                        dish.parent().siblings('.item-qty').text(data['quantity']+'x');
                        // dish.parents('.item').find('td.amount').find('.item-price').text(data['price']);
                        updateCartSummary(data);
                    }
                    $('.product-cart-block').html(data['cart_content']);
                    $('.mobile-cart-block').html(data['mobile_cart']);
                    removeItem();
                    incrementQty();
                    decrementQty();
                    //  itemHover();
                },
                error: function (error) {
                    console.log("error occured");
                    removeItem();
                    incrementQty();
                    decrementQty();
                    //  itemHover();
                }
            });
            event.preventDefault();
        });
    }

    function decrementQty() {
        $('.item-quantity-handler .decrement').unbind('click');
        $('.item-quantity-handler .decrement').on('click', function (event) {
            var dish=$(this);
            $.ajax({
                type: "POST",
                url: '<?=base_url('menu/update_cart') ?>',
                data: {'row_id': $(this).attr('row-id'), 'plus_minus': 'minus', 'id': $(this).attr('id')},
                success: function (data) {
                    if(data['isUpdated']){
                        dish.siblings('.item-qty-middle').val(data['quantity']);
                        dish.parent().siblings('.item-qty').text(data['quantity']+'x');
                      //  dish.parents('.item').find('td.amount').find('.item-price').text(data['price']);
                        updateCartSummary(data)
                    }
                    $('.product-cart-block').html(data['cart_content']);
                    $('.mobile-cart-block').html(data['mobile_cart']);
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                },
                error: function (error) {
                    console.log("error occured");
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                }
            });
            event.preventDefault();
        });
    }

    function updateCartSummary(data) {
        $('.table-order-summery .delivery-charge').text(data['deliveryCharge']);
        $('.table-order-summery .discount').text(data['discount']);
        $('.table-order-summery .sub-total').text(data['subTotal']);
        $('.table-order-summery .total').text(data['total']);
    }

    $(".order-delivery-type input[type='radio']").click(function (event) {
        if ($(this).is(':checked')) {
            var orderType = $(this).val();
            $.ajax({
                type: "POST",
                url: '<?=base_url('menu/get_order_type_session')?>',
                data: {order_type: orderType},
                success: function (data) {
                    var cart = data['cart_content'];
                    $('.product-cart-block').html(cart);
                    cartScroll();
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                },
                error: function (error) {
                    console.log("error occured");
                    cartScroll();
                    removeItem();
                    incrementQty();
                    decrementQty();
                    itemHover();
                }
            });
        }
    });
</script>

<div id="scolling-content-cart">
    <div class="card" style="border-radius: 0;">
        <div class="card-header order-delivery-type form-inline" style="padding: 0.4rem 1.25rem;background: transparent" >
            <?php
                $order_type_value = get_sess_order_type();
                $table_number_msg = null;
                if ($this->session->userdata('dine_in_table_number_id')) {
                    $table_number_msg = "(".$this->session->userdata('dine_in_table_number').")";
                }
            ?>

            <?php if ($this->order_type == 'delivery_collection_and_dinein'): ?>
                <?php if ($order_type_status_based_on_url === true): ?>
                    <label class="radio-inline">
                        <input id="delivery" value="delivery" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'delivery' ? 'checked' : '' ?>>&nbsp;Delivery
                    </label>
                    &nbsp;&nbsp;

                    <label class="radio-inline">
                        <input id="collection" value="collection" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'collection' ? 'checked' : '' ?>>&nbsp;Collection
                    </label>
                    &nbsp;&nbsp;
                <?php endif ?>

                <label class="radio-inline">
                    <input id="dine_in" value="dine_in" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'dine_in' ? 'checked' : '' ?>>&nbsp;Dine-In&nbsp;<span id="table_number_msg"><?= $table_number_msg ?></span>
                </label>
            <?php elseif ($this->order_type == 'delivery_and_collection'): ?>
                <?php if ($order_type_status_based_on_url === true): ?>
                    <label class="radio-inline">
                        <input id="delivery" value="delivery" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'delivery' ? 'checked' : '' ?>>&nbsp;Delivery
                    </label>
                    &nbsp;&nbsp;

                    <label class="radio-inline">
                        <input id="collection" value="collection" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'collection' ? 'checked' : '' ?>>&nbsp;Collection
                    </label>
                    &nbsp;&nbsp;
                <?php endif ?>
            <?php elseif ($this->order_type == 'dinein_and_collection'): ?>
                <label class="radio-inline">
                    <input id="collection" value="collection" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'collection' ? 'checked' : '' ?>>&nbsp;Collection
                </label>
                &nbsp;&nbsp;

                <label class="radio-inline">
                    <input id="dine_in" value="dine_in" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'dine_in' ? 'checked' : '' ?>>&nbsp;Dine-In&nbsp;<span id="table_number_msg"><?= $table_number_msg ?></span>
                </label>
            <?php elseif ($this->order_type == 'delivery'): ?>
                <label class="radio-inline">
                    <input id="delivery" value="delivery" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'delivery' ? 'checked' : '' ?>>&nbsp;Delivery
                </label>          
            <?php elseif ($this->order_type == 'collection'): ?>
                <?php //$order_type_value; exit(); ?>
                <label class="radio-inline">
                    <input id="collection" value="collection" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'collection' ? 'checked' : '' ?>>&nbsp;Collection
                </label>          
            <?php else: ?>
                <label class="radio-inline">
                    <input id="dine_in" value="dine_in" name="deliverytype" type="radio" class="order_type" <?= $order_type_value == 'dine_in' ? 'checked' : '' ?>>&nbsp;Dine-In&nbsp;<span id="table_number_msg"><?= $table_number_msg ?></span>
                </label>
            <?php endif ?>
        </div>

        <!-- <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-del-time">
                    <?php $data['orderType'] = 'collection'; ?>
                    <?php $this->load->view('menu2/collection_delivery_time',$data); ?>
                </div>

                <div class="col-lg-6 col-del-time">
                    <?php $data['orderType'] = 'delivery'; ?>
                    <?php $this->load->view('menu2/collection_delivery_time',$data); ?>
                </div>
            </div>
        </div> -->
    </div>

    <!-- <div class="card">
        <div class="card-header">
            <div class="cart-title">Specia Offer</div>
        </div>

        <div class="card-body">
            <?php
                $currentDayNumber = date('w');
                $discountData = get_discount_data();
                $specialOffer = $discountData[$currentDayNumber];
                // echo "<pre>"; print_r($specialOffer); exit();
            ?>
            <p class="special-offer"><?= $specialOffer['collection_discount_percent'] ?>% off On Collection Orders Over £<?= $specialOffer['minimum_order_amount'] ?></p>
            <p class="special-offer"><?= $specialOffer['delivery_discount_percent'] ?>% off On Delivery Orders Over £<?= $specialOffer['minimum_order_amount'] ?></p>
        </div>
    </div> -->

    <div class="card">
        <div class="card-header">
            <div class="cart-title">My Order</div>
        </div>

        <div class="card-body cart-body">
            <div class="product-cart-block"><?= $product_cart ?></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="dineInTableModal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Dine-In Tables</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="showcart_menuscroll"><a href="#scolling-content-cart">Cart</a></div>

<script type="text/javascript">
    $(document).ready(function(){
        var order_type_status_based_on_url = '<?php echo $order_type_status_based_on_url ?>';
        var payment_settings_order_type = '<?php echo $this->order_type ?>';
        var order_type_value = '<?php echo $order_type_value ?>';
        var delivery_postcode = null;

        if ((payment_settings_order_type == 'delivery_collection_and_dinein' || payment_settings_order_type == 'dinein_and_collection' ||  payment_settings_order_type == 'dine_in') && order_type_status_based_on_url == '') {
            get_all_tables();
        } else {
            get_order_type_session(order_type_value,delivery_postcode);
        }
    });
    cartScroll();

    $('.order_type').click(function () {
        //click order type to set a session
        var order_type = $(this).val();
        var delivery_postcode = null;
        get_order_type_session(order_type,delivery_postcode);

        if (order_type == 'dine_in') {
            get_all_tables();
        }
    });

    function get_order_type_session(order_type,delivery_postcode) {
        // alert(order_type);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("menu/get_order_type_session"); ?>',
            data: {order_type:order_type,delivery_postcode:delivery_postcode},
            success: function (data) {
                $('.product-cart-block').html(data['cart_data']);
                $('.mobile-cart-block').html(data['mobile_cart_data']);
                if (data['order_type'] == 'delivery') {} else {}
                var isValidWithOrderType = data['isValidWithOrderType'];
                if (data['current_total_cart_item'] < data['previous_total_cart_item']) {
                    showProductAddedMessage('Some Product Remove From Cart');
                }
                set_table_number_message(data['session_dine_in_table_number_id'],data['session_dine_in_table_number']);

                if(!isValidWithOrderType){}
            },
            error: function (error) { console.log("error occured"); }
        });
    }

    function get_all_tables() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("menu/get_all_tables"); ?>',
            data: {},
            success: function (data) {
                $('#dineInTableModal .modal-body').empty();
                $('#dineInTableModal .modal-body').html(data['modal_data']);
                $('#dineInTableModal').modal('show');
                set_dinein_table_in_session();
            },
            error: function (error) { console.log("error occured"); }
        });
    }
    
    function set_dinein_table_in_session() {
        $('#dine_in_table_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $('#dineInTableModal').modal('hide');
                    set_table_number_message(data['session_dine_in_table_number_id'],data['session_dine_in_table_number']);
                    showProductAddedMessage('Your Selected Table Is : '+data['session_dine_in_table_number']);
                    if (data['session_dine_in_table_number_id']) {
                        $('#table_number_error_msg').empty();
                        $('#checkout_button').removeClass('disabled');
                        $('.product-cart-block').html(data['cart_data']);
                    }
                },
                error: function (error) {
                }
            });
        });
    }

    function set_table_number_message(session_dine_in_table_number_id,session_dine_in_table_number) {
        var table_number_msg = null;
        if (session_dine_in_table_number_id) {
            table_number_msg = "("+session_dine_in_table_number+")";
        }
        $('#table_number_msg').html(table_number_msg);
    }
</script>