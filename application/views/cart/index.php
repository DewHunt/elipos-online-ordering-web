<?php
    $i = 1;
    $m_customer = new Customer_Model();
    $order_type = $this->session->userdata('order_type_session');
    $cart_total = $this->cart->total();
    $cart_total_item = $this->cart->total_items();
    $customer_id = 0;
    $discount = 0;
    $delivery_charge = 0;
    $total_buy_get_amount = get_total_from_cart('buy_get_amount');

    if ($m_customer->customer_is_loggedIn()) {
        $customer_id = $m_customer->get_logged_in_customer_id();
    }

    if ($this->cart->contents()) {
        $discount = $m_customer->get_discount_amount($this->cart->contents(),$order_type,$customer_id);
    }
    // dd($discount);

    $subtotal = $cart_total - $total_buy_get_amount;
    if (!empty($order_type) && $order_type == 'delivery') {
        $minimum_order_amount = 0;
        $min_amount_for_free_delivery_charge = 0;
        
        if ($this->session->userdata('delivery_charge')) {
            $delivery_charge = $this->session->userdata('delivery_charge');
        }

        if ($this->session->userdata('minimum_order_amount')) {
            $minimum_order_amount = $this->session->userdata('minimum_order_amount');
        }

        if ($this->session->userdata('min_amount_for_free_delivery_charge')) {
            $min_amount_for_free_delivery_charge = $this->session->userdata('min_amount_for_free_delivery_charge');
        }
        // dd($min_amount_for_free_delivery_charge);
        
        if (!empty($min_amount_for_free_delivery_charge) && $min_amount_for_free_delivery_charge > 0 && $min_amount_for_free_delivery_charge < $subtotal) {
            $delivery_charge = 0;
        }
    }

    $payment_method = trim($this->session->userdata('order_payment_method'));
    if (empty($payment_method)) {
        $payment_method = 'cash';
    }
    $service_charge = $m_customer->get_service_charge($order_type,$payment_method);
    $packaging_charge = $m_customer->get_packaging_charge($order_type);

    $total_amount = ($cart_total + $delivery_charge + $service_charge + $packaging_charge) - ($discount + $total_buy_get_amount);
    $this->session->set_userdata('cart_total_session', $total_amount);
?>

<div class="">
    <form id="cart_information_form" name="cart_information_form" method="post" action="<?= base_url('menu/update_cart') ?>">
        <div class="cartscroll" style="max-height: 230px; overflow-y: auto">
            <table class="table  table-cart-details">
                <?php if (empty($this->cart->contents())): ?>
                    <tr>
                        <td colspan="3" style="padding:0">
                            <div class="card-empty-image"><img  src="<?= base_url('assets/images/cart_bag_shopping.png') ?>"></div>
                            <p>Add menu items into your basket</p>
                        </td>
                    </tr>                    
                <?php else: ?>
                    <?php foreach ($this->cart->contents() as $items): ?>
                        <?php
                            echo form_hidden($i.'[rowid]',$items['rowid']);
                        ?>
                        <tr class="item" row-id="<?= $items['rowid'] ?>" qty="<?= $items['qty'] ?>" plus_minus="plus" id="<?= $items['id'] ?>">
                            <td class="qty-col">
                                <span class="item-quantity-handler" >
                                    <span class="increment" row-id="<?= $items['rowid'] ?>" id="<?= $items['id'] ?>">
                                        <i class="fa fa-plus"></i>
                                    </span>
                                    <input readonly class=" form-control item-qty-middle" value="<?php echo $items['qty']; ?>">
                                    <span class="decrement" row-id="<?= $items['rowid'] ?>" id="<?= $items['id'] ?>">
                                        <i class="fa fa-minus"></i>
                                    </span>
                                </span>
                                <span class="item-qty"><?php echo $items['qty']; ?> x</span>
                            </td>
                            <td>
                                <?php echo $items['name']; ?>
                                <?php if (isset($items['side_dish']) && $items['side_dish']): ?>
                                    <br><?= $items['side_dish']; ?>
                                <?php endif ?>
                                <?php if (isset($items['free_item_qty']) && $items['free_item_qty'] > 0): ?>
                                    <br>You Have Got <?= $items['free_item_qty']; ?> Items Free
                                <?php endif ?>
                                <?php if (isset($items['comments']) && $items['comments']): ?>
                                    <br><?= $items['comments'] ?>
                                <?php endif ?>
                            </td>
                            <td class="amount">
                                <?php
                                    $item_total_amount = 0;
                                    $item_subtotal = 0;
                                    $item_buy_get_amount = 0;

                                    if (isset($items['subtotal'])) {
                                        $item_subtotal = $items['subtotal'];
                                    }

                                    if (isset($items['buy_get_amount'])) {
                                        $item_buy_get_amount = $items['buy_get_amount'];
                                    }

                                    $item_total_amount = $item_subtotal - $item_buy_get_amount;
                                ?>
                                <span class="item-remove" row-id="<?= $items['rowid'] ?>" qty="<?= $items['qty'] ?>" id="<?= $items['id'] ?>"><i class="fa fa-times-circle-o"></i></span>
                                <span class="item-price"><?= number_format($item_total_amount, 2) ?></span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </table>
        </div>

        <?php if (!empty($this->cart->contents())): ?>
            <table class="table table-order-summery">
                <tr>
                    <td>Sub Total</td>
                    <td class="sub-total"><?php echo get_price_text($subtotal); ?></td>
                </tr>

                <?php if ($discount > 0): ?>
                    <tr>
                        <td>Discount</td>
                        <td class="discount"><?= get_price_text($discount) ?></td>
                    </tr>
                <?php endif ?>

                <?php if ($service_charge > 0): ?>
                    <tr>
                        <td>Service Charge</td>
                        <td class="service-charge"><?= get_price_text($service_charge) ?></td>
                    </tr>
                <?php endif ?>

                <?php if ($packaging_charge > 0): ?>
                    <tr>
                        <td>Parcel Box</td>
                        <td class="service-charge"><?= get_price_text($packaging_charge) ?></td>
                    </tr>
                <?php endif ?>

                <?php if ($order_type == 'delivery' && $delivery_charge > 0): ?>
                    <tr>
                        <td>Delivery Charge</td>
                        <td class="delivery-charge"><?= get_price_text(!empty($delivery_charge) ? $delivery_charge : 0 ) ?></td>
                    </tr>
                <?php endif ?>

                <tr>
                    <td>Total</td>
                    <td class="total"><?php echo get_price_text($total_amount); ?></td>
                </tr>
            </table>
        <?php endif ?>
    </form>

    <?php if (strtolower($this->session->userdata('menu_page_session')) == strtolower(base_url('menu'))): ?>
        <div class="checkout-button-wrapper">
            <?php if (!empty($this->cart->contents())): ?>
                <?php
                    $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    $this->session->set_userdata('menu_url_session', $current_url);
                    $order_type_value = get_sess_order_type();
                    $col_class = 'col-lg-12';

                    if ($order_type_value == 'dine_in' && $this->session->userdata('is_loggedIn') == false) {
                        $col_class = 'col-lg-6';
                    }
                ?>
                <div class="row">
                    <div class="<?= $col_class ?>">
                        <a id="checkout_button" class="btn btn-checkout checkout_button" checkout-type="user" href="<?= base_url('order') ?>">Checkout</a>
                    </div>

                    <?php if ($order_type_value == 'dine_in' && $this->session->userdata('is_loggedIn') == false): ?>
                        <div class="col-lg-6">
                            <a id="guest_checkout_button" class="btn btn-checkout checkout_button" checkout-type="guest" href="<?= base_url('order') ?>">Guest Checkout</a>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>

<div class="clearfix" style="margin-top: 5px;background: #EDEDED"></div>

<?php if ($order_type == 'delivery'): ?>
    <?php $minimum_order_amount = $this->session->userdata('minimum_order_amount'); ?>

    <?php if (!empty($minimum_order_amount)): ?>
        <table class="table table-order-summery" >
            <tr>
                <td>
                    <span class="minimum-order-amount" >Minimum Order Amount  <?= get_price_text($minimum_order_amount) ?></span>
                </td>
            </tr>
        </table>
    <?php endif ?>
<?php endif ?>

<script type="text/javascript">
    $('.item-quantity-handler').unbind('mouseenter').unbind('mouseleave');
    removeItem();
    incrementQty();
    decrementQty();
    itemHover();
</script>