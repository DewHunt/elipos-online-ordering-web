<?php // dd($this->cart->contents()); ?>
<style>
    .table-cart-summary tr td { padding: 5px; font-size: 14px; }
    .table .amount { text-align: right; }
    .table tr td,th { font-size: 12px; padding: 5px; }
    .item-comment { font-size: 9px; color: #333; background: #fff; }
    .item-sidedish { font-size: 9px; color: #333; background: #fff; }
</style>

<div class="cartscroll" style="max-height: 300px; overflow-y: scroll">
    <table class="table table-cart-summary">
        <?php
            $i = 1;
            $total_buy_get_amount = get_total_from_cart('buy_get_amount');
        ?>

        <?php if (empty($this->cart->contents())): ?>
            <tr>
                <td colspan="3" style="padding:0">
                    <div class="card-empty-image">
                        <img  src="<?=base_url('assets/images/cart_bag_shopping.png')?>">
                        <p >Your basket is empty</p>
                    </div>

                </td>
            </tr>            
        <?php else: ?>
            <?php foreach ($this->cart->contents() as $items): ?>
                <tr class="item">
                    <td ><span class="item-qty"><?php echo $items['qty']; ?>&nbsp;x</span></td>
                    <td>
                        <?= $items['name']; ?>
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
                        <span class="item-price"><?=number_format($item_total_amount,2)?></span>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </table>
</div>

<div class="cart-footer">
    <?php
        $this->data['total_buy_get_amount'] = $total_buy_get_amount;
        $this->load->view('cart/cart_footer',$this->data);
    ?>
</div>

<?php $this->load->view('cart/add_coupon',$this->data); ?>