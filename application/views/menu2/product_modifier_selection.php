<?php if (!empty($assigned_modifier_by_category_id)): ?>
    <div class="form-group row">
        <label for="" class="col-md-2 col-sm-12 col-form-label">Modifiers</label>
        <div class="col-md-10 col-sm-12">
            <?php foreach ($assigned_modifier_by_category_id as $assigned_modifier_category): ?>
                <?php
                    $assigned_side_dishes = $assigned_modifier_category['SideDishes'];
                    $ModifierCategoryName = $assigned_modifier_category['ModifierCategoryName'];
                    $ModifierCategoryId = $assigned_modifier_category['ModifierCategoryId'];
                    $limit = $assigned_modifier_category['Limit'];
                    // dd($assigned_side_dishes);
                ?>
                <?php if (!empty($assigned_side_dishes)): ?>
                    <div class="side-dish-as-modifier-category" data-limit="<?=$limit?>">
                        <div class="card category-name">
                            <div class="card-header" title="<?= $ModifierCategoryName ?>">
                                <h5 class="mb-0 text-center"><?= $ModifierCategoryName ?></h5>
                            </div>
                        </div>
                        <div class="col" id="<?='modifier-cate'.$ModifierCategoryId?>"></div>
                        <div class="row side-dish-select-block">
                            <?php foreach ($assigned_side_dishes as $assigned_side_dish): ?>
                                <?php
                                    $assigned_side_dish_price = 0;
                                    if (isset($assigned_side_dish->UnitPrice)) {
                                        $assigned_side_dish_price = $assigned_side_dish->UnitPrice;
                                    }
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"  data-cate="<?=$ModifierCategoryId?>" id="<?=$assigned_side_dish->SideDishesId?>" class="custom-control-input <?='modifierCate-'.$ModifierCategoryId?>"
                                               name="side_dish_ids[]" value="<?= $assigned_side_dish->SideDishesId ?>">
                                        <label class="custom-control-label" for="<?=$assigned_side_dish->SideDishesId?>"><?=  $assigned_side_dish->SideDishesName; ?></label>
                                        <?php if ($assigned_side_dish_price > 0): ?> 
                                            <label class="custom-control-label" for="<?=$assigned_side_dish->SideDishesId?>">( <?= get_currency_symbol().$assigned_side_dish_price; ?> )</label>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <?php // dd($assigned_side_dishes); ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>    
<?php endif ?>