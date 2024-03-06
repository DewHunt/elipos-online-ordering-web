<style>
    .typtipstotop { bottom: 50px; }
    .mobile-cart{ position: fixed; bottom:0; z-index: 100; background: #ccc; width: 100%; display: none; text-align: center; left: 0; right: 0; }
    .mobile-cart:hover { cursor:pointer; }
    .cart-item { border-right: 1px solid #ccc; color: #970e12; display: inline-block; float: left; font-size: 14px; height: auto; line-height: 26px; margin: 0; padding-top: 5px; text-align: center; width: 33.33%; }
    .cart-total { border-right: 1px solid #ccc; color: #970e12; display: inline-block; float: left; font-size: 14px; height: auto; line-height: 26px; margin: 0; padding-top: 5px; text-align: center; width: 33.33%; }
    .cart-checkout { background: #970e12 none repeat scroll 0 0; border: medium none; color: #fff; display: inline-block; float: left; height: 100%; padding: 0; position: absolute; right: 0; width: 33.33%; }
    .btn-mobile-checkout { border: medium none; color: #fff; height: 100%; padding: 0; line-height:30px; }
    @media only screen and (max-width: 767px){
        .mobile-cart{ display: inline-flex; }
        .showcart_menuscroll { display: none; }
    }
    .btn-primary { background: #10636B none repeat scroll 0 0; border-radius: 0px; border-color: #10636B; padding-left: 4px; font-size: 13px; width: 33.33%; height: 100%; }
</style>

<?php
    $total_item = $this->cart->total_items();
    $order_type = $this->session->userdata('order_type_session');
    if (!empty($order_type)) {
        if ($order_type == 'collection' || $order_type == 'dine_in') {
            $delivery_charge = 0;
        } else if ($order_type == 'delivery') {
            $delivery_charge = (!empty( $this->session->userdata('delivery_charge'))) ? $this->session->userdata('delivery_charge') : 0;
        }
    } else {
        $delivery_charge = 0;
        $this->session->set_userdata('order_type_session','collection');
    }
    $customer_id = 0;
    $m_customer = new Customer_Model();
    $cart_total = $this->cart->total();
    $cart_contents = $this->cart->contents();
    $discount = 0;

    if ($m_customer->customer_is_loggedIn()) {
        $customer_id = $m_customer->get_logged_in_customer_id();
    }
    $order_type = trim($this->session->userdata('order_type_session'));
    if ($cart_contents) {
        $discount = $m_customer->get_discount_amount($cart_contents,$order_type,$customer_id);
    }

    $payment_method = trim($this->session->userdata('order_payment_method'));
    if (empty($payment_method)) {
        $payment_method = 'cash';
    }
    $service_charge = $m_customer->get_service_charge($order_type,$payment_method);
    $packaging_charge = $m_customer->get_packaging_charge($order_type);
    $total_buy_get_amount = get_total_from_cart('buy_get_amount');
    $total_amount = ($cart_total + $delivery_charge + $service_charge + $packaging_charge) - ($discount + $total_buy_get_amount);
    $this->session->set_userdata('cart_total_session', $total_amount);
?>

<?php if ($total_amount > 0): ?> 
    <div class="mobile-cart">
        <?php $order_type_value = get_sess_order_type(); ?>
        <?php if (($order_type_value != 'dine_in' && $this->session->userdata('is_loggedIn') == false) ||  $this->session->userdata('is_loggedIn') == true): ?>
            <div class="cart-item"><i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;<?=$total_item?></div>               
        <?php endif ?>
        <div class="cart-total">              
            <p>Total:&nbsp;<i class="fa fa-gbp" aria-hidden="true"></i> <?= get_price_text($total_amount);?></p> 
        </div>
        <?php if ($order_type_value == 'dine_in' && $this->session->userdata('is_loggedIn') == false): ?>
            <a id="mob_guest_checkout_button" class="btn btn-primary checkout_button" checkout-type="guest" href="<?= base_url('order') ?>">Guest Checkout</a>
        <?php endif ?>
        <div class="cart-checkout">
            <a id="mob_checkout_button" class="btn-mobile-checkout checkout_button" checkout-type="user" href="<?= base_url('order') ?>">Checkout</a>
        </div>
    </div>   
<?php endif ?>

<script type="text/javascript">
    $('.mobile-cart .cart-item, .mobile-cart .cart-total').click(function(){
        $('#scolling-content-cart')[0].scrollIntoView();
    });
</script>
