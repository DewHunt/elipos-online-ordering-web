<style>
    .table-cart-details tr td{
        vertical-align: middle;
        padding: 5px 5px!important;


    }
    .table-cart-details tr td div{
        min-height: 60px !important;
        display: flex;
        align-items: center;
        justify-content: center

    }
    .table-cart-details tr td:first-child{
        width: 15%;

    }
    .table-cart-details tr td:last-child{

        width: 15%;

    }

    .table-cart-details tr td:first-child:hover{



    }
    .table-cart-details tr:hover{

    }
    .table-cart-details tr td:hover{
        cursor: pointer;

    }
    .table-order-summery{
        margin-bottom: 0px;
    }
    .table-order-summery tr td{
        margin-bottom: 0px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .item-description{
        font-size: 9px;
        color: #333;
        background: #fff;



    }
    .item-description .item-name{
        font-size: 12px;
    }
    .btn-checkout{
        background: #10636B;
        border: 1px solid #10636B;
        font-size: 18px;
        width: 100%;
        color: #ffffff;
    }
    .btn-checkout:hover{
        background: #222;
        border: 1px solid #222;
        color: #ffffff;
    }
    .checkout-button-wrapper{
        padding: 6px;
    }
    .table-order-summery tr td:last-child{
        padding-right: 10px;
        text-align: right;
    }
    .table-cart-details{
        margin-bottom: 0;
    }



    .table-cart-details .item-qty{
        white-space: nowrap
    }
    .item-quantity-handler{


        display: none;

    }
    .item-quantity-handler .increment{
        background: #10636B;
        color: #fff;
        border: 0;
        outline: none;
        width: 18px;
        height: 17px;
        float: left;
        padding: 0;
        border-radius: 0;
        font-size: 12px;
        text-align: center;
        clear: both;

    }
    .item-quantity-handler .decrement{
        width: 18px;
        height: 17px;
        float: left;
        padding: 0;
        border-radius: 0;
        font-size: 12px;
        text-align: center;
        clear: both;
        background: #10636B;
        color: #fff;
        border: 0;
        outline: none
    }
    .item-quantity-handler .decrement i{
        padding-top: 3px;
    }
    .item-quantity-handler .increment i{
        padding-top: 3px;

    }
    .item-quantity-handler .item-qty-middle{
        text-align: center;
        padding: 0;
        width: 18px;
        float: left;
        font-size: 10px;
        height: 19px;
        clear: both;
        border-radius: 0;
    }
    .item-remove i{

    }
    .table-cart-details .item-remove{
        display: block;
        color: #10636B;
        font-size: 22px;
        display: none;
        padding-bottom: 15px;
        height: 24px;
    }
    .table-cart-details .amount{
        font-size: 13px;
        width: 16% !important;
        color: #635c5c;
        background: #fff;

        text-align: right;
        padding-top: 10px;
        padding-bottom: 15px;
        height: 24px;
    }
    .card-empty-image img{
        width: 100px;
    }
    .card-empty-image p{
        margin-top: 10px;
        font-weight: 300;
        color: #8e969d;
    }
    .card-empty-image{
        text-align: center;
    }
    .custom-control-input:checked .custom-control-indicator {
        color: #fff;
        background-color: #10636B !important;

    }




</style>


<script type="text/javascript">

    itemHover();

    function itemHover() {

        $('.table-cart-details .item').hover(function () {
            $('.item-qty').css('display','block');
            $('.item-qty',this).css('display','none');
            $('.item-quantity-handler').hide();
            $('.item-quantity-handler',this).css('display','block');
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
                url: '<?=base_url('menu/remove_item_from_cart')?>',
                data: {'row_id': $(this).attr('row-id')},
                success: function (data) {
                    $('.product-cart-block').html(data['cart_content']);
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
                     //   dish.parents('.item').find('td.amount').find('.item-price').text(data['price']);


                        updateCartSummary(data);


                    }
                    // $('.product-cart-block').html(data['cart_content']);
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
                  //  $('.product-cart-block').html(data['cart_content']);

                    if(data['isUpdated']){
                        dish.siblings('.item-qty-middle').val(data['quantity']);
                        dish.parent().siblings('.item-qty').text(data['quantity']+'x');
                      //  dish.parents('.item').find('td.amount').find('.item-price').text(data['price']);

                        updateCartSummary(data)
                    }
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
        }

    });



</script>

<div class="card" style="border-radius: 0;" id="scolling-content-cart">
    <div class="card-header order-delivery-type form-inline" style="padding: 0.4rem 1.25rem;background: transparent" >
        <?php
        $order_type_value=get_sess_order_type();

        $order_type_value=(!empty($order_type_value))?$order_type_value:'collection';

        if ($this->order_type=='delivery_and_collection') {
            ?>

        <div class="custom-control custom-radio custom-control-inline">
            <input id="delivery" value="delivery" name="deliverytype" id="delivery" type="radio" class="order_type custom-control-input" <?=($order_type_value=='delivery')?'checked':''?>>

            <label class="custom-control-label" for="delivery">Delivery </label>
        </div>

        <div class="custom-control custom-radio custom-control-inline">
                <input id="collection" value="collection" name="deliverytype" type="radio" id="collection" class="order_type custom-control-input" <?=($order_type_value=='collection')?'checked':''?>>
            <label class="custom-control-label" for="collection">Collection </label>
        </div>

            <?php
        } else if ($this->order_type == 'delivery') {
            ?>

            <div class="custom-control custom-radio custom-control-inline">
                <input id="collection" value="collection" name="deliverytype" type="radio" id="collection" class="order_type custom-control-input" <?=($order_type_value=='collection')?'checked':''?>>
                <label class="custom-control-label" for="collection">Delivery </label>
            </div>


            <?php
        } else {
            ?>


            <div class="custom-control custom-radio custom-control-inline">
                <input id="delivery" value="delivery" name="deliverytype" id="delivery" type="radio" class="order_type  custom-control-input" <?=($order_type_value=='delivery')?'checked':''?>>
                <label class="custom-control-label" for="delivery">Delivery </label>
            </div>

            <?php
        }


        ?>
    </div>


    <div class="cart-title">My Order</div>


    <div class="card-body">

        <div class="product-cart-block">
            <?= $product_cart ?>
        </div>
    </div>

</div>



<div class="showcart_menuscroll">
    <a href="#scolling-content-cart">Cart</a>
</div>


<script type="text/javascript">
    cartScroll();
    $('.order_type').click(function () {  //click order type to set a session
        var order_type = $(this).val();
        var delivery_postcode = null;
        get_order_type_session(order_type,delivery_postcode);

    });


    function get_order_type_session(order_type,delivery_postcode) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("menu/get_order_type_session"); ?>',
            data: {'order_type': order_type,delivery_postcode:delivery_postcode},
            success: function (data) {
                $('.product-cart-block').html(data['cart_data']);
                if (data['order_type'] == 'delivery') {


                } else {

                }
                var isValidWithOrderType=data['isValidWithOrderType'];

                if(!isValidWithOrderType){

                }
            },
            error: function (error) {
                console.log("error occured");

            }
        });
    }



</script>