<?php if ($sub_products): ?>
	<div class="half-sub-product-block">
		<div class="row">
			<?php foreach ($sub_products as $sub_product): ?>
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 half-deal-col">
					<?php if ($portion == 'first-half'): ?>
						<span class="btn btn-primary btn-lg btn-block half-sub-product-btn first-half-sub-product-btn" id="fhsp-btn-<?= $sub_product->selectiveItemId ?>" category-id="<?= $category_id ?>" product-id="<?= $sub_product->foodItemId ?>" sub-product-id="<?= $sub_product->selectiveItemId ?>" product-size-id="<?= $sub_product->productSizeId ?>" sub-product-price="<?= $sub_product->takeawayPrice ?>" portion="first-half" is-selected='false'>
							<?= $sub_product->selectiveItemName ?> (<?= get_currency_symbol().$sub_product->takeawayPrice; ?>)
						</span>
					<?php elseif ($portion == 'second-half'): ?>
						<?php
							$disable = 'enable-btn';
							if ($sub_product->productSizeId != $selected_product_size_id) {
								$disable = 'disable-btn';
							}
						?>
						<span class="btn btn-primary btn-lg btn-block half-sub-product-btn second-half-sub-product-btn <?= $disable ?>" id="shsp-btn-<?= $sub_product->selectiveItemId ?>" category-id="<?= $category_id ?>" product-id="<?= $sub_product->foodItemId ?>" sub-product-id="<?= $sub_product->selectiveItemId ?>" product-size-id="<?= $sub_product->productSizeId ?>" sub-product-price="<?= $sub_product->takeawayPrice ?>" portion="second-half" is-selected='false'>
							<?= $sub_product->selectiveItemName ?> (<?= get_currency_symbol().$sub_product->takeawayPrice; ?>)
						</span>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		</div>
	</div>
<?php endif ?>