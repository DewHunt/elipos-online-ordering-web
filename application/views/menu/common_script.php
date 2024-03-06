<script type="text/javascript">
    var orderType = '<?= get_sess_order_type() ?>';
    localStorage.setItem('orderType',orderType);

    $(document).on('click','.deals-modal-button',function() {
        console.log('get deals modal');
        var dealsId = $(this).attr('data-deal-id');
        var orderType = $(this).attr('data-order-type');
        var customerOrderType = localStorage.getItem('orderType');
        $(this).css('display','none');
        $(this).siblings('.adding-to-cart-button-loader').css('display','block');

        if ((customerOrderType == orderType) || (orderType =='both')) {
            $.ajax({
                type: "POST",
                url:'<?= base_url('menu/get_deal') ?>',
                data: {dealsId},
                success: function (data) {
                    if (data['status'] === true) {
                        $('.deals-modal-block').html(data['modal']);
                        if (data.is_half_and_half == 0) {
                            $('.deals-modal').modal('show');
                        } else {
                            $('.half-deals-modal').modal('show');
                        }
                    } else {
                        var message = "This Deals Or Offers available for <span style='text-transform: capitalize'>"+data['deal_order_type']+"</span> Order";
                        $('.orderTypeMissMatch .modal-body .message').html(message);
                        $('.orderTypeMissMatch').modal('show');
                    }
                },
                error: function (error) {
                    console.log("error");
                }
            });
        } else {
            var message = "This Deals Or Offers available for <span style='text-transform: capitalize'>"+orderType+"</span> Order";
            $('.orderTypeMissMatch .modal-body .message').html(message);
            $('.orderTypeMissMatch').modal('show');
        }
    });

    // $('.product .adding-to-cart-button').click(function() {
    //     var product_id = $(this).attr('data-product-id');
    //     var orderType = $(this).attr('data-order-type');
    //     console.log("Category Order Type = "+orderType);
    //     $(this).css('display','none');
    //     $(this).siblings('.adding-to-cart-button-loader').css('display','block');

    //     var customerOrderType = localStorage.getItem('orderType');
    //     console.log("Customer Order Type = "+customerOrderType);
    //     if ((customerOrderType == orderType) || (orderType =='both')) {
    //         $.ajax({
    //             type: "POST",
    //             url:'<?= base_url('menu/get_product') ?>',
    //             data: {'product_id': product_id,},
    //             success: function (data) {
    //                 $('.product-modal-block').empty();
    //                 $('.product-modal-block').html(data['modal']);
    //             },
    //             error: function (error) {
    //                 console.log("error");
    //             }
    //         });
    //     } else {
    //         showOrderTypeMissMatchMessage(orderType);
    //         $(this).css('display','block');
    //         $(this).siblings('.adding-to-cart-button-loader').css('display','none');
    //     }
    // });

    $(document).on('click','.sub-product .adding-to-cart-button',function() {
        var product_id = $(this).attr('data-product-id');
        var sub_product_id = $(this).attr('data-sub-product-id');
        var orderType = $(this).attr('data-order-type');
        $(this).css('display','none');
        $(this).siblings('.adding-to-cart-button-loader').css('display','block');

        var customerOrderType = localStorage.getItem('orderType');

        if ((customerOrderType == orderType) || (orderType =='both')) {
            $.ajax({
                type: "POST",
                url:'<?=base_url('menu/get_sub_product')?>',
                data: {'product_id': product_id,'sub_product_id':sub_product_id},
                success: function (data) {
                    $('.product-modal-block').html(data['modal']);
                },
                error: function (error) {
                    console.log("error");
                }
            });
        } else {
            showOrderTypeMissMatchMessage(orderType);
            $(this).css('display','block');
            $(this).siblings('.adding-to-cart-button-loader').css('display','none');
        }
    });

    function showOrderTypeMissMatchMessage(message) {
        $('.orderTypeMissMatch .modal-body .message').html('This Product only for  <span style="text-transform: capitalize">'+message+'</span> Order');
        $('.orderTypeMissMatch').modal('show');
    }
</script>

<div class="modal fade orderTypeMissMatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="message text-center"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn common-btn" data-dismiss="modal" >Ok</button>
            </div>
        </div>
    </div>
</div>
