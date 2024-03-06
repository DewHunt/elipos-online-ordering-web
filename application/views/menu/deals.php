<?php
$mDeals = new Deals_Model();

$deals = $mDeals->get_by_category_id($category->categoryId);
$category_order_type=$category->order_type;

$count = 0; ?>
<?php if (!empty($deals)) {
  //  $mDealsItem = new Deals_Item_Model();

    ?>
    <?php foreach ($deals as $deal) { ?>
        <?php
     //   $deals_items = $mDealsItem->get_by_deals_id($deal->id)

        ?>
        <div class="<?= ($count % 2) == 0 ? 'restaurant-odd' : 'restaurant-even' ?>">

            <ul>
                <li>

                    <div class="menu_container_gap"></div>

                    <div class="full-width-container">
                        <span class="itemname">
                            <span class="itemdescription"><a class="black"><?= ucfirst($deal->title) ?></a></span>
                        </span>
                        <span class="itemprice"><?= number_format($deal->price, 2) ?>
                        </span>

                        <span class="itembasket product">
                            <?php
                            if (!$is_shop_closed || $is_pre_order) {
                                ?>
                                <a class="deals-modal-button" data-deal-id="<?= $deal->id ?>" data-order-type="<?= (!empty($category_order_type))?$category_order_type:'both';?>">
                                    <img src="<?= base_url('assets/images/menuplus.png') ?>" alt="" title=""/>
                                </a>
                                <a class="adding-to-cart-button-loader" style="display: none">
                                    <img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                </a>
                           <?php
                            }
                           ?>
                     </span>
                        <div class="product-description" style="clear: both">
                            <p><?= $deal->description ?></p>

                        </div>
                 </div>


                    <div class="menu_container_gap"></div>

                </li>
            </ul>
        </div>

        <?php
        $count++;
    }
    ?>
<?php } ?>


