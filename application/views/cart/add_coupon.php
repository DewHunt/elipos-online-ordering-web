<?php if($this->Voucher_Model->isCouponEnabled()): ?>
    <?php
        $coupon_id = $this->session->userdata('coupon_id');
        $coupon_code = $this->session->userdata('coupon_code');
    ?>
    <div class="clearfix"></div>
    <div  style="margin-top: 10px;background: #ffffff;padding: 2px;pointer-events:all">
        <div class="form-group" style="margin-bottom: 0">
            &nbsp;<input type="text" class="form-control input1" style="width: 190px;height: 35px;" id="coupon-code" name="coupon_code"   placeholder="Enter Coupon Code" value="<?= $coupon_code ?>">
            <button type="button" id="check-coupon-code" class="btn btn-secondary" style="background: green;color: #ffffff;cursor: pointer">Add </button>
        </div>
        <div id="coupon-message"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            console.log('Coupon Section');
            let code = "<?= $coupon_code ?>";
            if (code) {
                var isValid = /^([A-Z0-9]{6,})$/.test(code);
                addCouponCode(code,isValid);
            }
        });

        $('#check-coupon-code').unbind('click').bind('click',function () {
            var code = $('#coupon-code').val().toUpperCase();
            var isValid = /^([A-Z0-9]{6,})$/.test(code);
            addCouponCode(code,isValid);
        });

        function addCouponCode(code,isValid) {
            console.log("Add Coupon Code Function");
            if (code && !isValid) {
                console.log("invalid");
                $('#coupon-message').html('<p class="error">Coupon Code Is Invalid</p>');
            }

            if (code && isValid) {
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('/order/check_coupon') ?>',
                    data: {coupon_code: code},
                    success: function (data) {
                        if(data.isValid){
                            var html='<p class="info">'+data.message+'</p><button type="button" id="remove-coupon-code" class="btn btn-secondary" style="background: red;color: #ffffff;cursor: pointer;width: 100%">Remove Coupon </button>';
                            $('#coupon-message').html(html);
                            $('#order_process_form #c-ip').html('<input id="coupon-code" type="hidden" value="'+code+'" name="coupon_code">');
                            removeCouponCode();
                        } else {
                            $('#coupon-message').html('<p class="error">'+data.message+'</p>');
                        }
                        $('.cart-footer').html(data.cart_footer);
                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
            }
        }

        function removeCouponCode() {
            $('#remove-coupon-code').unbind('click').bind('click',function () {
                $('#order_process_form #c-ip').empty();
                $('#coupon-code').val('');
                $('#coupon-message').empty();
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('/order/check_coupon') ?>',
                    data: {coupon_code: ''},
                    success: function (data) {
                        if(data.isValid){
                            var html='<p class="info">'+data.message+'</p><button type="button" id="remove-coupon-code" class="btn btn-secondary" style="background: red;color: #ffffff;cursor: pointer;width: 100%">Remove Coupon </button>';
                            $('#coupon-message').html(html);
                            $('#order_process_form #c-ip').html('<input id="coupon-code" type="hidden" value="'+code+'" name="coupon_code">')

                            removeCouponCode();
                        }else{
                            $('#coupon-message').html('<p class="error">'+data.message+'</p>');
                        }
                        $('.cart-footer').html(data.cart_footer);

                    },
                    error: function (error) {
                        console.log("error occured");
                    }
                });
                addCouponCode();
            });
        }
    </script>    
<?php endif ?>