<?php
                            $cat_id++;
                            $count = 0; ?>
                            <?php if (!empty($products_list)) {

                                $orderType=$category->order_type;


                                foreach ($products_list as $product) {

                                    ?>
                                    <?php
                                    $sub_products_list = $product_object->get_sub_product($product->foodItemId);
                                    ?>


                                    <?php if (!empty($sub_products_list)) { ?>
                                        <div class="clearfix"></div>
                                        <a><h6 class="" style="text-decoration: none;"><?= $product->foodItemName  ?></h6></a>
                                        <div class="clearfix"></div>
                                        <div class="product-description">
                                            <p ><?=$product->description?></p>

                                        </div>
                                    <?php } ?>
                                    <div class="<?= ($count % 2) == 0 ? 'restaurant-odd' : 'restaurant-even' ?>">
                                        <?php if (!empty($sub_products_list)) {
                                            $assigned_modifiers = $this->Showsidedish_Model->get_assigned_modifier_by_category_id($category->categoryId);

                                            ?>
                                            <?php foreach ($sub_products_list as $sub_product) { ?>
                                                <ul>
                                                    <li>

                                                        <div class="menu_container_gap"></div>


                                                        <div class="full-width-container">
                                                                            <span class="itemname">
                                                                                <span class="itemdescription">
                                                                                   <a  class="black"> &#8658;&nbsp;&nbsp;<?= $sub_product->selectiveItemName ?></a>
                                                                                </span>
                                                                            </span>
                                                            <span class="itemprice"><?= number_format($sub_product->takeawayPrice, 2) ?>
                                                                            </span>
                                                            <span class="itembasket sub-product">

                                                                                <?php if (!$is_shop_closed || $is_pre_order) { ?>
                                                                                    <a class="adding-to-cart-button"  data-product-id="<?=$product->foodItemId?>" data-order-type="<?=(!empty($orderType))?$orderType:'both';?>" data-sub-product-id="<?=$sub_product->selectiveItemId?>" data-modifiers='<?=json_encode($assigned_modifiers)?>'>  <img src="<?= base_url('assets/images/menuplus.png') ?>" alt="" title=""/></a>
                                                                                    <a class="adding-to-cart-button-loader" style="display: none"><img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
</a>

                                                                                <?php } ?>

                                                                                                        </span>





                                                        </div>

                                                        <div class="menu_container_gap"></div>

                                                    </li>
                                                </ul>


                                            <?php } ?>
                                        <?php } else { ?>
                                            <ul>
                                                <li>

                                                    <div class="menu_container_gap"></div>

                                                    <div class="full-width-container">
                                                                        <span class="itemname">
                                                                            <span class="itemdescription">
                                                                                <a class="black"><?= ucfirst($product->foodItemName) ?></a>
                                                                            </span>
                                                                        </span>
                                                        <span class="itemprice"><?= number_format($product->takeawayPrice, 2) ?>

                                                                                                     </span>

                                                        <span class="itembasket product">
                                                                            <?php if (!$is_shop_closed ||$is_pre_order) { ?>
                                                                                <a class="adding-to-cart-button"  data-order-type="<?=(!empty($orderType))?$orderType:'both';?>"  data-product-id="<?=$product->foodItemId?>" >  <img  src="<?= base_url('assets/images/menuplus.png') ?>" alt="" title=""/></a>

                                                                                <a class="adding-to-cart-button-loader" style="display: none"><img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/></a>
                                                                            <?php } ?>
                                                                                                    </span>

                                                        <div class="product-description">
                                                            <p ><?=$product->description?></p>

                                                        </div>

                                                    </div>



                                                    <div class="menu_container_gap"></div>

                                                </li>
                                            </ul>



                                        <?php } ?>
                                    </div>
                                    <?php
                                    $count++;
                                }
                                ?>
                            <?php } ?>

