<?php
if(!empty($assigned_modifier_by_category_id)){
    ?>
    <div class="form-group row">
        <label for="" class="col-md-2 col-sm-12 col-form-label">Modifiers</label>
        <div class="col-md-10 col-sm-12">

            <?php
            foreach ($assigned_modifier_by_category_id as $assigned_modifier_category) {


                $assigned_side_dishes=$assigned_modifier_category['SideDishes'];

                $ModifierCategoryName=$assigned_modifier_category['ModifierCategoryName'];
                $ModifierCategoryId=$assigned_modifier_category['ModifierCategoryId'];
                $limit=$assigned_modifier_category['Limit'];
                if(!empty($assigned_side_dishes)){

                    ?>
                    <div class="side-dish-as-modifier-category " data-limit="<?=$limit?>">
                    <div class="card category-name">
                        <div class="card-header" title="<?=$ModifierCategoryName?>">
                            <h5 class="mb-0 text-center">
                                <?=$ModifierCategoryName?>
                            </h5>
                        </div>
                    </div>
                    <div class="col" id="<?='modifier-cate'.$ModifierCategoryId?>" >

                    </div>
                    <div class="row side-dish-select-block">

                    <?php
                    //var_dump($assigned_side_dishes);

                    foreach ($assigned_side_dishes as $assigned_side_dish){

                        ?>

                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <label class="custom-control custom-checkbox ">
                                <input type="checkbox"  data-cate="<?=$ModifierCategoryId?>" class="custom-control-input <?='modifierCate-'.$ModifierCategoryId?>"
                                       name="side_dish_ids[]" value="<?= $assigned_side_dish->SideDishesId ?>">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description"><?= $assigned_side_dish->SideDishesName ?></span>
                            </label>
                        </div>




                        <?php

                    }

                }
                ?>
                </div>

                </div>


                <?php
            }
            ?>
        </div>
    </div>
    <?php
}