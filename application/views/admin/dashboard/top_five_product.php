<?php
    $m_order_details = new Order_details_Model();
    $top_sellings_products = '';
    if ((isset($from_date) && !empty($from_date)) && (isset($to_date) && !empty($to_date))) {
        $top_sellings_products = $m_order_details->get_top_sellings_product(5,$from_date,$to_date);
    } else {
        $top_sellings_products = $m_order_details->get_top_sellings_product();
    }
    $m_product = new Fooditem_Model();
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Top 5 Products</h3></div>
    <div class="panel-body">
        <!-- <h3>Top 5 Products</h3> -->
        <table class="table">
            <thead>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Amount</th>
            </thead>
            <tbody>
                <?php if (empty($top_sellings_products)): ?>
                    <tr>
                        <td colspan="3">Product Not Found</td>
                    </tr>                    
                <?php else: ?>                    
                    <?php foreach ($top_sellings_products as $top_sellings_product): ?>
                        <?php
                            $product = $m_product->get($top_sellings_product->product_id);
                            $product_name = (!empty($product)) ? $product->foodItemName : '';
                        ?>                    
                        <tr>
                            <td><?=$product_name?></td>
                            <td><?=$top_sellings_product->qty?></td>
                            <td><?=get_price_text($top_sellings_product->amt)?></td>
                        </tr>
                    <?php endforeach ?>                    
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
