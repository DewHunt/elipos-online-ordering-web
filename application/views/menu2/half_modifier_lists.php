<?php if ($modifiers): ?>
	<div class="half-modifier-block">
		<?php foreach ($modifiers as $modifier): ?>
			<?php
				$modifier_category_id = $modifier['ModifierCategoryId'];
				$modifier_category_name = $modifier['ModifierCategoryName'];
				$limit = $modifier['Limit'];
				$side_dishes = $modifier['SideDishes'];
			?>
			<?php if ($side_dishes): ?>
				<div class="card">				
					<div class="card-header modifier-head"><h5><?= $modifier_category_name ?></h5></div>
				</div>
				<div class="modifier-item">
					<?php if ($portion == 'first-half'): ?>
						<div class="hd-alert alert alert-waning alert-dismissable fade show" id="fh-alert-<?= $modifier_category_id ?>" style="display: none;">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong><?= $modifier_category_name ?></strong> Modifier limit is exceed
						</div>
					<?php elseif ($portion == 'second-half'): ?>
						<div class="hd-alert alert alert-waning alert-dismissable fade show" id="sh-alert-<?= $modifier_category_id ?>" style="display: none;">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong><?= $modifier_category_name ?></strong> Modifier limit is exceed
						</div>
					<?php endif ?>
					<div class="row">
						<?php foreach ($side_dishes as $side_dish): ?>
							<?php
								$side_dish_price = 0;
								if (isset($side_dish->UnitPrice)) {
									$side_dish_price = $side_dish->UnitPrice;
								}
							?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<?php if ($portion == 'first-half'): ?>
									<input type="checkbox" class="fh-modifier fh-modifier-category-<?= $modifier_category_id ?>" id="fhsp-<?= $side_dish->SideDishesId ?>" category-id="<?= $modifier_category_id ?>" modifier-price="<?= $side_dish_price ?>" limit="<?= $limit ?>" name="first_half_modifier_ids[]" value="<?= $side_dish->SideDishesId ?>">
									<label for="fhsp-<?= $side_dish->SideDishesId ?>"><?= $side_dish->SideDishesName; ?></label>
		                            <?php if ($side_dish_price > 0): ?> 
		                                <label for="fhsp-<?= $side_dish->SideDishesId ?>">(<?= get_currency_symbol().$side_dish_price; ?>)</label>
		                            <?php endif ?>
								<?php elseif ($portion == 'second-half'): ?>
									<input type="checkbox" class="sh-modifier sh-modifier-category-<?= $modifier_category_id ?>" id="shsp-<?= $side_dish->SideDishesId ?>" category-id="<?= $modifier_category_id ?>" modifier-price="<?= $side_dish_price ?>" limit="<?= $limit ?>" name="second_half_modifier_ids[]" value="<?= $side_dish->SideDishesId ?>">
									<label for="shsp-<?= $side_dish->SideDishesId ?>"><?=  $side_dish->SideDishesName; ?></label>
		                            <?php if ($side_dish_price > 0): ?> 
		                                <label for="shsp-<?= $side_dish->SideDishesId ?>">(<?= get_currency_symbol().$side_dish_price; ?>)</label>
		                            <?php endif ?>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>
<?php endif ?>