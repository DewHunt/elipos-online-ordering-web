<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="modifier-category">Modifier Category</label>
            <select class="form-control modifier-category select2" name="modifier_category[]" multiple>
                <?php if ($modifier_category_list): ?>
                	<?php
                		$all_option_select = "selected";
                		if (isset($selected_modifier_category_id)) {
                			$all_option_select = "";
	                		if (is_array($selected_modifier_category_id) && in_array('-1', $selected_modifier_category_id)) {
	                			$all_option_select = "selected";
	                		}
                		}
                	?>
                    <option value="-1" <?= $all_option_select ?>>All</option>
                    <?php foreach ($modifier_category_list as $modifier_category): ?>
                    	<?php
                    		$select = "";
	                		if (isset($selected_modifier_category_id)) {
	                			$select = "";
		                		if (is_array($selected_modifier_category_id) && in_array('-1', $selected_modifier_category_id) == false && in_array($modifier_category->ModifierCategoryId, $selected_modifier_category_id)) {
		                			$select = "selected";
		                		}
	                		}
                    	?>
                        <option value="<?= $modifier_category->ModifierCategoryId ?>" <?= $select ?>><?= $modifier_category->ModifierCategoryName ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <button class="btn btn-primary btn-block show-modifier-list" style="margin-top: 23px;">Show</button>
        </div>
    </div>
</div>