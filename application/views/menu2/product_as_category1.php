<style>
    .product{
        border-bottom: 1px solid #efefef;
        padding: 5px 0 15px;
        margin-bottom: 5px;
    }

    .product-add-loader-img{
        width: 35px;
    }
</style>
<?php

$show_add_to_cart_button=false;
if(is_shop_maintenance_mode()){
    $is_shop_closed=true;
    $is_pre_order=false;

}else if(is_shop_weekend_off()){
    $is_shop_closed=true;
    $is_pre_order=false;

}else{
    $is_shop_closed=is_shop_closed();
    $is_pre_order=is_pre_order();
}



if(!$is_shop_closed || $is_pre_order){
    $show_add_to_cart_button=true;
}



?>
<div class="content-product">
    <div class="">
        <?php
        $lib_product=new Product();

        foreach ($dealsCategories as $dealsCategory){
            ?>

            <h6 class="category-name">
                <?=$dealsCategory->categoryName?>
            </h6>

        <div class="deals col-md-12 list-group-item">
        </div>

            <?php
        }
        ?>


        <?php



        foreach ($categories as $category) {
            ?>
            <div class="product-category" id="category-id-<?= $category->categoryId ?>">
                <?php

                echo sprintf('<h6 class="category-name">%s</h6>', $category->categoryName);
                $products_as_category = $lib_product->getProductsAsCategory($products, $category->categoryId);
                if (!empty($products_as_category)) {
                    ?>

                    <?php


                    foreach ($products_as_category as $product) {
                      
                      
                  
                      
                        $allSubProducts = $lib_product->getSubProductsByProductId($all_sub_products, $product->foodItemId);
                        $hasSubProduct = (empty($allSubProducts)) ? false : true;
                      
                         if(!$hasSubProduct  && $product->takeawayPrice <=0.00){
                           continue;
                         }

                        ?>
                        <div class="product ">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-8 product-name">
                                    <?= $product->foodItemName ?>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 ">
                                    <div class="product-right-side">
                                        <div class="product-price">


                                            <?php

                                            if($hasSubProduct){
                                                $price=$product->takeawayPrice;
                                                $takeawayPriceList=array_column($allSubProducts,'takeawayPrice');
                                                $price=(!empty($takeawayPriceList))?min($takeawayPriceList):0;
                                                echo get_price_text($price);
                                            }else{
                                                echo get_price_text($product->takeawayPrice);
                                            }


                                            ?>
                                        </div>

                                        <div class="add-to-cart-block">
                                            <?php if ($show_add_to_cart_button) {
                                                if ($hasSubProduct) {
                                                    ?>
                                                    <a class="get-sub-product-button cart-button "
                                                       data-product-id="<?= $product->foodItemId ?>"> <i
                                                                class="fa fa-plus"></i> </a>
                                                    <a class="adding-to-cart-button-loader" style="display: none"><img
                                                                class="product-add-loader-img"
                                                                src="<?= base_url('assets/admin/loader/loader.gif') ?>"
                                                                alt="" title=""/></a>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="adding-to-cart-button cart-button "
                                                       data-product-id="<?= $product->foodItemId ?>"> <i
                                                                class="fa fa-plus"></i> </a>
                                                    <a class="adding-to-cart-button-loader" style="display: none"><img
                                                                class="product-add-loader-img"
                                                                src="<?= base_url('assets/admin/loader/loader.gif') ?>"
                                                                alt="" title=""/></a>

                                                    <?php
                                                }
                                                ?>


                                            <?php } ?>

                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="row no-margin no-padding">
                                <?php
                                echo (!empty($product->description)) ? sprintf('<div class="product-description"><p>%s</p></div>', $product->description) : '';
                                ?>
                            </div>

                        </div>
                        <?php
                    }
                    ?>


                    <?php
                }


                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>



