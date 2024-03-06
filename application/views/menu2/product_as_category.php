<?php
    $show_add_to_cart_button = false;
    if (is_shop_maintenance_mode()) {
        $is_shop_closed = true;
        $is_pre_order = false;
    } else if (is_shop_weekend_off()) {
        $is_shop_closed = true;
        $is_pre_order = false;
    } else {
        $is_shop_closed = is_shop_closed();
        $is_pre_order = is_pre_order();
    }
    if (!$is_shop_closed || $is_pre_order) {
        $show_add_to_cart_button = true;
    }
    // dd($dealsCategories);
?>
<div class="content-product">
    <div class="row no-padding no-margin sticky-top d-sm-none product-category-large" style="background: rgb(255, 255, 255);">
        <h6 style="float: left; background: rgb(255, 255, 255);"></h6>
        <div class="clearfix"></div>
    </div>
    <?php
        $lib_product = new Product();
        $mDeals = new Deals_Model();
        $currentDayName = strtolower(date('l'));
    ?>

    <?php if ($dealsCategories): ?>
        <?php foreach ($dealsCategories as $dealsCategory): ?>
            <?php $availabilities = explode(',',$dealsCategory->availability);?>
            <?php if (in_array($currentDayName,$availabilities)): ?>
                <?php
                    $dealsName = $product_object->get_offers_or_deals_name();
                    $dealsId = str_replace(' ', '-', $dealsName);
                    $order_type = $dealsCategory->order_type;
                    $deals = $mDeals->get_deal_by_category_id_and_flags($dealsCategory->categoryId);
                    // echo "<pre>"; print_r($deals);
                    $category_order_type = $dealsCategory->order_type;
                ?>
                <div class="category-name">
                    <h6><?= $dealsCategory->categoryName ?></h6>
                    <?php if ($dealsCategory->category_description): ?>
                        <p class="description"><?= $dealsCategory->category_description ?></p>
                    <?php endif ?>
                </div>
                <div class="deals col-md-12 list-group-item" id="category-id-<?= $dealsId ?>">
                    <?php if (!empty($deals)): ?>
                        <?php foreach ($deals as $deal): ?>
                            <?php $dealsAvailabilities = explode(',',$deal->availability); ?>
                            <?php //echo "<pre>"; print_r($dealsAvailabilities); ?>
                            <?php if (in_array($currentDayName,$dealsAvailabilities)): ?>
                                <div class="row <?= $deal->isHighlight == 1 ? 'deal' : '' ?>">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 product-name deals-col" style="color: <?= $deal->isHighlight == 1 ? '#fff' : '' ?>;">
                                        <span><!-- img src="assets/images/heat-sign.svg" alt="Heat Sign" style="width: 15px; height: 15px;" --></span>
                                        <?= ucfirst($deal->title) ?>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 product-right-side deals-col" style="color: <?= $deal->isHighlight == 1 ? '#fff' : '' ?>;">
                                        <span class="price-block">
                                            <?php if (!$is_shop_closed || $is_pre_order): ?>
                                                <a class="deals-modal-button cart-button" data-deal-id="<?= $deal->id ?>" data-order-type="<?= (!empty($category_order_type)) ? $category_order_type : 'both';?>">
                                                    <i class="fa fa-plus" style="<?= $deal->isHighlight == 1 ? 'color: #fff; border: 2px solid #fff' : '' ?>"></i>
                                                </a>
                                                <a class="adding-to-cart-button-loader" style="display: none">
                                                    <img class="product-add-loader-img" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                                </a>
                                            <?php endif ?>
                                        </span>
                                        <span class="price-block price-text-block">
                                            <?= get_price_text(number_format($deal->price, 2)) ?>
                                        </span>
                                    </div>

                                    <div class="row no-margin no-padding">
                                        <?php if (!empty($deal->description)): ?>
                                            <div class="product-description">
                                                <p style="color: <?= $deal->isHighlight == 1 ? '#fff' : '' ?>;">
                                                    <?= $deal->description ?>
                                                </p>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>                
            <?php endif ?>
        <?php endforeach ?>            
    <?php endif ?>

    <?php foreach ($categories as $category): ?>            
        <div class="product-category" id="category-id-<?= $category->categoryId ?>">
            <?php $availabilities = explode(',',$category->availability); ?>

            <?php if (in_array($currentDayName,$availabilities)): ?>
                <?php
                    $products_as_category = $lib_product->getProductsAsCategory($products, $category->categoryId);
                ?>
                <div class="category-name">
                    <h6><?= $category->categoryName ?></h6>
                    <?php if ($category->category_description): ?>
                        <p class="description"><?= $category->category_description ?></p>
                    <?php endif ?>
                </div>
                
                <?php if (!empty($products_as_category)): ?>
                    <?php foreach ($products_as_category as $product): ?>
                        <?php
                            $availabilities = explode(',',$product->availability);
                        ?>

                        <?php if (in_array($currentDayName,$availabilities)): ?>
                            <?php
                                $allSubProducts = $lib_product->getSubProductsByProductId($all_sub_products, $product->foodItemId);
                                $hasSubProduct = (empty($allSubProducts)) ? false : true;
                                $itemStrengthCssClass = $lib_product->get_fooditem_strength_css_class_by_id($product->item_strength);

                                if (!$hasSubProduct && $product->takeawayPrice <= 0.00) {
                                    continue;
                                }
                            ?>
                            <div class="product <?= $product->isHighlight == 1 ? 'product-highlighted-text' : '' ?>" style="background-color: <?= $product->isHighlight == 1 ? $product->highlight_color : '' ?>">
                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 product-name" style="color: <?= $product->isHighlight == 1 ? '#fff' : '' ?>">
                                        <?= $product->foodItemName ?>
                                        <?php foreach ($itemStrengthCssClass as $foodItemStrenght): ?>
                                            <span class="<?= $foodItemStrenght->css_class ?>">
                                                <?php if (!empty($foodItemStrenght->icon)): ?>
                                                    <img src="<?= $foodItemStrenght->icon ?>" alt="Heat Sign" style="width: 15px; height: 15px;">
                                                <?php endif ?>
                                            </span>                                                
                                        <?php endforeach ?>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 product-right-side" style="color: <?= $product->isHighlight == 1 ? '#fff' : '' ?>">
                                        <span class="price-block">
                                            <?php if ($show_add_to_cart_button): ?>
                                                <?php if ($hasSubProduct): ?>
                                                    <a class="get-sub-product-button cart-button" data-product-id="<?= $product->foodItemId ?>" data-order-type="<?= (!empty($category_order_type)) ? $category_order_type : 'both';?>">
                                                        <i class="fa fa-plus" style="<?= $product->isHighlight == 1 ? 'color: #fff; border: 2px solid #fff' : '' ?>"></i>
                                                    </a>
                                                    <a class="adding-to-cart-button-loader" style="display: none;">
                                                        <img class="product-add-loader-img" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                                    </a>
                                                <?php else: ?>
                                                    <a class="adding-to-cart-button cart-button" data-product-id="<?= $product->foodItemId ?>" data-order-type="<?= (!empty($category_order_type)) ? $category_order_type : 'both';?>">
                                                        <i class="fa fa-plus" style="<?= $product->isHighlight == 1 ? 'color: #fff; border: 2px solid #fff' : '' ?>"></i>
                                                    </a>
                                                    <a class="adding-to-cart-button-loader" style="display: none;">
                                                        <img class="product-add-loader-img" src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                                                    </a>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </span>
                                        <span class="price-block price-text-block">
                                            <?php
                                                if ($hasSubProduct) {
                                                    $price = $product->takeawayPrice;
                                                    $takeawayPriceList = array_column($allSubProducts,'takeawayPrice');
                                                    $price = (!empty($takeawayPriceList)) ? min($takeawayPriceList) : 0;
                                                    echo get_price_text($price);
                                                } else {
                                                    echo get_price_text($product->takeawayPrice);
                                                }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row no-margin no-padding">
                                    <?php if (!empty($product->description)): ?>
                                        <div class="product-description">
                                            <p style="color: <?= $product->isHighlight == 1 ? '#fff' : '' ?>"><?= $product->description ?></p>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>                                
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endif ?>

        </div>
    <?php endforeach ?>
</div>

<script>
    $('.product-category-large').removeClass('product-name-block');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.product-category-large').addClass('product-name-block');
        } else {
            $('.product-category-large').removeClass('product-name-block');
        }
    });

    $('.product-category').on('scrollSpy:enter', function () {
        var categoryName = $(this).find('.category-name h6').text();
        $('.product-category-large h6').html(categoryName);
        $('.category-list-item.active').removeClass('active');
        $('.category-list-item a:contains("' + categoryName + '")')
                .parent()//select its parent 'li'
                .addClass('active');//add class 'active' to 'li'
        var id = $(this).attr('id');
    });
</script>