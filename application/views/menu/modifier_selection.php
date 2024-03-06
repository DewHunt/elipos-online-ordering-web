<?php if (!empty($assigned_modifier_by_category_id)): ?>
    <?php
        $last_index = count($assigned_modifier_by_category_id) - 1;
        $last_modifier = $assigned_modifier_by_category_id[$last_index];
        $last_modifier_category_id = $last_modifier['ModifierCategoryId'];
    ?>
    <?php foreach ($assigned_modifier_by_category_id as $assigned_modifier_category): ?>
        <?php
            // dd($assigned_modifier_category);
            $assigned_side_dishes = $assigned_modifier_category['SideDishes'];
            $ModifierCategoryId = $assigned_modifier_category['ModifierCategoryId'];
            $ModifierCategoryName = $assigned_modifier_category['ModifierCategoryName'];
            $limit = $assigned_modifier_category['Limit'];
        ?>
        <?php if (!empty($assigned_side_dishes)): ?>
            <?php
                // dd($assigned_side_dishes);
                $deal_alert_id = "deal-alert-".$category_id."-".$product_id."-".$sub_product_id."-".$ModifierCategoryId;
            ?>
            <div class="modifier-as-product" data-limit="<?= $limit ?>">
                <div class="card modifier-card">
                    <div class="card-header modifier-card-header" title="<?= $ModifierCategoryName ?>"><?= $ModifierCategoryName ?></div>

                    <div class="card-body modifier-card-body">
                        <div id="<?= $deal_alert_id ?>"></div>
                        <div class="row">
                            <?php foreach ($assigned_side_dishes as $assigned_side_dish): ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="modifier" data-md="<?= $assigned_side_dish->SideDishesId ?>" data-pr="<?= $assigned_side_dish->UnitPrice ?>">
                                        <span><?= $assigned_side_dish->SideDishesName ?></span>
                                        <div class="add">
                                            <span class="modifier-price" style="float: left;"><?= get_price_text($assigned_side_dish->UnitPrice) ?></span>
                                            <sapn class="addOne" category-id="<?= $category_id ?>" modifier-category-id="<?= $ModifierCategoryId ?>" last-modifier-category-id="<?= $last_modifier_category_id ?>" modifier-category-name="<?= $ModifierCategoryName ?>" assigned-modifier-limit="<?= $limit ?>" style="float: left;">
                                                <img src="<?= base_url('assets/images/menuplus.png') ?>" class="icon-img" alt="" title=""/>
                                            </sapn>
                                        </div>

                                        <div class="clearfix"></div>
                                        
                                        <div class="remove">
                                            <span class="modifier-qty" style="display: none;" data-qty="0"></span>
                                            <span class="modifier-total-price" style="display: none" data-price="0"></span>
                                            <sapn class="removeOne" category-id="<?= $category_id ?>" modifier-category-id="<?= $ModifierCategoryId ?>" last-modifier-category-id="<?= $last_modifier_category_id ?>" modifier-category-name="<?= $ModifierCategoryName ?>" assigned-modifier-limit="<?= $limit ?>" style="display: none;">
                                                <img src="<?= base_url('assets/images/minus.png') ?>" class="icon-img" alt="" title=""/>
                                            </sapn>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
<?php endif ?>

