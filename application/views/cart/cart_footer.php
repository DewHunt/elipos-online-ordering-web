<?php
    $order_type = $this->session->userdata('order_type_session');
    $m_customer = new Customer_Model();
    $cart_total = $this->cart->total();
    $cart_total_item = $this->cart->total_items();
    $discount = 0;
    $delivery_charge = 0;

    $payment_method = trim($this->session->userdata('order_payment_method'));
    if (empty($payment_method)) {
        $payment_method = 'cash';
    }
    $service_charge = $m_customer->get_service_charge($order_type,$payment_method);
    $packaging_charge = $m_customer->get_packaging_charge($order_type);

    $customer_id = 0;
    if ($m_customer->customer_is_loggedIn()) {
        $customer_id = $m_customer->get_logged_in_customer_id();
    }

    if ($this->cart->contents()) {
        $discount = $m_customer->get_discount_amount($this->cart->contents(),$order_type,$customer_id);
    }
    // echo $discount; exit();

    if (isset($couponDiscount) && $couponDiscount > $discount) {
        $discount = $couponDiscount;
    }
?>

<table class="table">
    <tr>
        <?php $subtotal = $cart_total - $total_buy_get_amount; ?>
        <td>Sub Total:</td>
        <td class="amount"><?php echo get_price_text($subtotal); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>

    <?php if ($discount > 0): ?>
        <tr>
            <td>Discount:</td>
            <td class="amount"><?=get_price_text($discount)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    <?php endif ?>

    <?php if ($service_charge > 0): ?>
        <tr>
            <td>Service Charge:</td>
            <td class="amount"><?=get_price_text($service_charge)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    <?php endif ?>

    <?php if ($packaging_charge > 0): ?>
        <tr>
            <td>Parcel Box:</td>
            <td class="amount"><?=get_price_text($packaging_charge)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    <?php endif ?>

    <?php if (!empty($order_type)): ?>
        <?php if ($order_type == 'collection'): ?>
            <?php $delivery_charge = 0; ?>
        <?php elseif ($order_type == 'delivery'): ?>
            <?php
                $delivery_charge = (!empty($this->session->userdata('delivery_charge'))) ? $this->session->userdata('delivery_charge') : 0;
                $minimum_order_amount = (!empty($this->session->userdata('minimum_order_amount'))) ? $this->session->userdata('minimum_order_amount') : 0;
                $min_amount_for_free_delivery_charge = (!empty($this->session->userdata('min_amount_for_free_delivery_charge'))) ? $this->session->userdata('min_amount_for_free_delivery_charge') : 0;
                if (!empty($min_amount_for_free_delivery_charge) && $min_amount_for_free_delivery_charge > 0 && $min_amount_for_free_delivery_charge < $subtotal) {
                    $delivery_charge = 0;
                }
            ?>

            <?php if ($delivery_charge > 0): ?>
                <tr>
                    <td>Delivery Charge :</td>
                    <td class="amount"> <?=get_price_text($delivery_charge)?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            <?php endif ?>
        <?php endif ?>
    <?php else: ?>
        <?php
            $delivery_charge = 0;
            $this->session->set_userdata('order_type_session','collection');
        ?>
    <?php endif ?>

    <?php
        $total_amount = ($cart_total + $delivery_charge + $service_charge + $packaging_charge) - ($discount + $total_buy_get_amount);
        $this->session->set_userdata('cart_total_session', $total_amount);
    ?>

    <tr>
        <td>Total:</td>
        <td class="amount"><?php echo get_price_text($total_amount); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>
