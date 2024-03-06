<style>
@media only screen and (min-width: 1200px) {
    .modal-lg { max-width: 1140px; }
}
@media only screen and (min-width: 992px) {
    .modal-lg { max-width: 1100px; }
}
@media only screen and (max-width: 767px) {
    .modal-lg { max-width: 475px; }
}
</style>

<div class="modal fade half-deals-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""><strong><?= $deal->title ?></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form id="add_to_cart_half_and_half_deal_form" method="post" action="<?= base_url('menu/add_to_cart_half_and_half_deal') ?>">
	            	<div class="row">
	            		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	            			<span class="btn btn-danger btn-block first-half-portion-btn">1/2 (First Portion) (1)</span>
	            		</div>

	            		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
	            			<span class="btn btn-info btn-block second-half-portion-btn disable-btn">1/2 (Second Portion) (1)</span>
	            		</div>
	            	</div>
	            	<input type="hidden" class="hnh-deal" name="deal_id" value="<?= $deal->id ?>">
	            	<input type="hidden" class="hnh-deal-item" name="deal_item_id" value="<?= $deal_item_id ?>">
	            	<input type="hidden" class="selected-fhp-id" name="first_product_id" value="0">
	            	<input type="hidden" class="selected-shp-id" name="second_product_id" value="0">
	            	<input type="hidden" class="selected-fhsp-id" name="first_sub_product_id" value="0">
	            	<input type="hidden" class="selected-fhsp-size-id" name="first_sub_product_size_id" value="0">
	            	<input type="hidden" class="selected-shsp-id" name="second_sub_product_id" value="0">
	            	<input type="hidden" class="selected-shsp-size-id" name="second_sub_product_size_id" value="0">

	        		<div class="first-half-portion">
	        			<?php if ($products): ?>
	        				<div class="half-product-block">
	        					<!-- <h5 class="half-deal-header">1/2 (First Portion)</h5> -->
		        				<div class="row">
			        				<?php foreach ($products as $first_half_product): ?>
		        						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 half-deal-col">
											<span class="btn btn-outline-primary btn-block half-deal-btn first-half-product-btn" id="fhp-btn-<?= $first_half_product->foodItemId ?>" category-id="<?= $first_half_product->categoryId ?>" product-id="<?= $first_half_product->foodItemId ?>" sub-product-ids="<?= $sub_product_ids ?>" portion="first-half" is-selected='false'>
												<?= $first_half_product->foodItemName ?>
											</span>
		        						</div>
			        				<?php endforeach ?>
		        				</div>
	        				</div>
	        				<div class="first-half-sub-product"></div>
	        				<div class="first-half-modifier"></div>
	        			<?php endif ?>
	        		</div>

	        		<div class="second-half-portion">
	        			<?php if ($products): ?>
	        				<!-- <h5 class="half-deal-header">1/2 (Second Portion)</h5> -->
	        				<div class="half-product-block">
	        					<div class="row">
			        				<?php foreach ($products as $second_half_product): ?>
		        						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 half-deal-col">
											<span class="btn btn-outline-primary btn-block half-deal-btn second-half-product-btn" id="shp-btn-<?= $second_half_product->foodItemId ?>" category-id="<?= $second_half_product->categoryId ?>" product-id="<?= $second_half_product->foodItemId ?>" sub-product-ids="<?= $sub_product_ids ?>" portion="second-half" is-selected='false'>
												<?= $second_half_product->foodItemName ?>
											</span>
		        						</div>
			        				<?php endforeach ?>            				
	        					</div>
	        				</div>
	        				<div class="second-half-sub-product"></div>
	        				<div class="second-half-modifier"></div>
	        			<?php endif ?>
	        		</div>

	                <div class="half-deal-btn-block">
		                <div style="float:left;">
		                    <button type="submit" class="btn btn-danger add-to-cart-btn" disabled>Add To Basket</button>
		                    <a class="adding-to-cart-button-loader" style="display: none"><img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
		                    </a>
		                </div>
		                <div style="float: right">
		                    <strong class="total-price-text"><?= get_price_text(0.00) ?></strong>
		                    <input type="hidden" class="first-half-price" name="first_half_price" value="0">
		                    <input type="hidden" class="second-half-price" name="second_half_price" value="0">
		                    <input type="hidden" class="total-price" name="total_price" value="0">
		                    <input type="hidden" class="fh-modifier-price" name="first_half_modifier_price" value="0">
		                    <input type="hidden" class="sh-modifier-price" name="second_half_modifier_price" value="0">
		                    <input type="hidden" class="total-modifier-price" name="total_modifier_price" value="0">
		                </div>
	            	</div>
            	</form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$('.second-half-portion').hide();
    $('.first-half-portion-btn').addClass('selected-btn');
    $('.half-deals-modal').on('hide.bs.modal', function (e) {
        $('.adding-to-cart-button-loader').css('display','none');
        $('.deals-modal-button').css('display','block');
    });

    $(document).on('click','.first-half-portion-btn',function() {
    	$('.second-half-portion-btn').removeClass('selected-btn');
    	$('.first-half-portion').show();
    	$('.second-half-portion').hide();
    	$('.add-to-cart-btn').attr('disabled',true);
    });

    $(document).on('click','.second-half-portion-btn',function() {
    	$('.second-half-portion-btn').addClass('selected-btn');
    	$('.second-half-portion').show();
    	$('.first-half-portion').hide();
    	let is_selected = $('.second-half-sub-product-btn').attr('is-selected');
    	console.log(is_selected);
    	if (is_selected == 'true') {
    		$('.add-to-cart-btn').attr('disabled',false);
    	} else {
    		$('.add-to-cart-btn').attr('disabled',true);
    	}
    });

    $(document).on('click','.first-half-product-btn',function() {
    	let product_id = $(this).attr('product-id');
    	let category_id = $(this).attr('category-id');
    	let sub_product_ids = $(this).attr('sub-product-ids');
    	let portion = $(this).attr('portion');
    	$('.selected-fhp-id').val(product_id);
    	$('.first-half-product-btn').removeClass('selected-btn');
    	$('.first-half-product-btn').attr('is-selected','false');
    	$.ajax({
    		type: 'POST',
    		url: '<?= base_url('menu/get_sub_porduct_for_half_and_half'); ?>',
    		data: {category_id,product_id,sub_product_ids,portion},
    		success: function(response) {
    			$('#fhp-btn-'+product_id).addClass('selected-btn');
    			$('#fhp-btn-'+product_id).attr('is-selected','true');
    			$('.first-half-sub-product').html(response.output);
    			$('.first-half-modifier').html('');
    			$('.second-half-sub-product').html('');
    			$('.second-half-modifier').html('');
		    	$('.second-half-price').val(0);
		    	$('.first-half-price').val(0);
		    	$('.total-price').val(0);
		    	$('.total-price-text').html("£0");
			    $('.fh-modifier-price').val(0);
			    $('.sh-modifier-price').val(0);
			    $('.total-modifier-price').val(0);
    			$('.second-half-product-btn').removeClass('selected-btn');
    			$('.second-half-portion-btn').removeClass('enable-btn');
    			$('.second-half-portion-btn').addClass('disable-btn');
    			$('.add-to-cart-btn').attr('disabled',true);
    		},
    		error: function (error) {
    		}
    	});
    });

    $(document).on('click','.second-half-product-btn',function() {
    	let product_id = $(this).attr('product-id');
    	let category_id = $(this).attr('category-id');
    	let sub_product_ids = $(this).attr('sub-product-ids');
    	let portion = $(this).attr('portion');
    	$('.selected-shp-id').val(product_id);
    	let selected_product_size_id = $('.selected-fhsp-size-id').val();
    	$('.second-half-product-btn').removeClass('selected-btn');
    	$('.second-half-product-btn').attr('is-selected','false');
    	$.ajax({
    		type: 'POST',
    		url: '<?= base_url('menu/get_sub_porduct_for_half_and_half'); ?>',
    		data: {category_id,product_id,sub_product_ids,selected_product_size_id,portion},
    		success: function(response) {
    			$('#shp-btn-'+product_id).addClass('selected-btn');
    			$('#shp-btn-'+product_id).attr('is-selected','true');
    			$('.second-half-sub-product').html(response.output);
    			$('.second-half-modifier').html('');
    			$('.add-to-cart-btn').attr('disabled',true);
    		},
    		error: function (error) {
    		}
    	});
    });

    $(document).on('click','.first-half-sub-product-btn',function() {
    	let category_id = $(this).attr('category-id');
    	let product_id = $(this).attr('product-id');
    	let sub_product_id = $(this).attr('sub-product-id');
    	let product_size_id = $(this).attr('product-size-id');
    	let portion = $(this).attr('portion');
    	$('.selected-fhsp-id').val(sub_product_id);
    	$('.selected-fhsp-size-id').val(product_size_id);
    	$('.first-half-sub-product-btn').removeClass('selected-btn');
    	$('.first-half-sub-product-btn').attr('is-selected','false');
    	let price = parseFloat($(this).attr('sub-product-price'));
    	$.ajax({
    		type: 'POST',
    		url: '<?= base_url('menu/get_modifiers_for_half_and_half'); ?>',
    		data: {category_id,product_id,sub_product_id,portion},
    		success: function(response) {
    			$('#fhsp-btn-'+sub_product_id).addClass('selected-btn');
    			$('#fhsp-btn-'+sub_product_id).attr('is-selected','true');
    			$('.first-half-modifier').html(response.output);
    			$('.second-half-sub-product').html('');
    			$('.second-half-modifier').html('');
    			$('.second-half-product-btn').removeClass('selected-btn');
		    	$('.second-half-price').val(0);
			    $('.fh-modifier-price').val(0);
			    $('.sh-modifier-price').val(0);
			    $('.total-modifier-price').val(0);
		    	$('.first-half-price').val(price.toFixed(2));
		    	$('.total-price').val(price.toFixed(2));
		    	$('.total-price-text').html("£"+price.toFixed(2));
    			$('.add-to-cart-btn').attr('disabled',true);
    			$('.second-half-portion-btn').removeClass('disable-btn');
    			$('.second-half-portion-btn').addClass('enable-btn');
    		},
    		error: function (error) {
    		}
    	});
    });

    $(document).on('click','.second-half-sub-product-btn',function() {
    	let category_id = $(this).attr('category-id');
    	let product_id = $(this).attr('product-id');
    	let sub_product_id = $(this).attr('sub-product-id');
    	let product_size_id = $(this).attr('product-size-id');
    	let portion = $(this).attr('portion');
    	$('.selected-shsp-id').val(sub_product_id);
    	$('.selected-shsp-size-id').val(product_size_id);
    	$('.second-half-sub-product-btn').removeClass('selected-btn');
    	$('.second-half-sub-product-btn').attr('is-selected','false');
    	let first_half_price = parseFloat($('.first-half-price').val());
    	let price = parseFloat($(this).attr('sub-product-price'));
    	$.ajax({
    		type: 'POST',
    		url: '<?= base_url('menu/get_modifiers_for_half_and_half'); ?>',
    		data: {category_id,product_id,sub_product_id,portion},
    		success: function(response) {
    			$('#shsp-btn-'+sub_product_id).addClass('selected-btn');
    			$('#shsp-btn-'+sub_product_id).attr('is-selected','true');
    			$('.second-half-modifier').html(response.output);
		    	$('.second-half-price').val(price.toFixed(2));
    			if (price > first_half_price) {
			    	$('.total-price').val(price.toFixed(2));
			    	$('.total-price-text').html("£"+price.toFixed(2));
    			}
    			$('.add-to-cart-btn').attr('disabled',false);
    		},
    		error: function (error) {
    		}
    	});
    });

    $(document).on('click','.fh-modifier',function(event) {
    	let modifier_id = $(this).val();
    	let category_id = $(this).attr('category-id');
    	let limit = $(this).attr('limit');
    	let price = parseFloat($('.first-half-price').val());
    	let modifier_price = parseFloat($(this).attr('modifier-price'));
    	let second_half_price = parseFloat($('.second-half-price').val());
    	let first_half_modifier_price = parseFloat($('.fh-modifier-price').val());
    	let second_half_modifier_price = parseFloat($('.sh-modifier-price').val());
    	let total_checked = $('.fh-modifier-category-'+category_id+':checked').length;
    	let is_subtract = true;

    	if (limit == 1) {
			if (total_checked == 0) {
				is_subtract = false;
			} else {
				$('.fh-modifier-category-'+category_id).each(function() {
					if (this.checked) {
						if (total_checked > 1) {
							if ($(this).val() != modifier_id) {
								let not_selected_modifier_price = parseFloat($(this).attr('modifier-price'));
				    			first_half_modifier_price = first_half_modifier_price - not_selected_modifier_price;
				    			price = price - not_selected_modifier_price;
							}
						}
					}
				});
			}
            $('.fh-modifier-category-'+category_id).prop("checked",false);
            this.checked = true;
    	} else {
            if (total_checked > limit) {
                this.checked = false;
                is_subtract = false;
                $('#fh-alert-'+category_id).css('display','block');
                setTimeout(function() { $('#fh-alert-'+category_id).css('display','none'); },5000);
            }
    	}

    	if (this.checked) {
    		first_half_modifier_price = first_half_modifier_price + modifier_price;
    		price = price + modifier_price;
    		if (!is_subtract) {
	    		first_half_modifier_price = first_half_modifier_price - modifier_price;
	    		price = price - modifier_price;
    		}
    	} else {
    		if (is_subtract) {
	    		first_half_modifier_price = first_half_modifier_price - modifier_price;
	    		price = price - modifier_price;
    		}
    	}

    	$('.first-half-price').val(price.toFixed(2));
	    $('.fh-modifier-price').val(first_half_modifier_price.toFixed(2));
		if (price > second_half_price) {
	    	$('.total-price').val(price.toFixed(2));
	    	$('.total-price-text').html("£"+price.toFixed(2));
	    	$('.total-modifier-price').val(first_half_modifier_price.toFixed(2));
		} else {
	    	$('.total-price').val(second_half_price.toFixed(2));
	    	$('.total-price-text').html("£"+second_half_price.toFixed(2));
	    	$('.total-modifier-price').val(second_half_modifier_price.toFixed(2));
		}
    	$('.add-to-cart-btn').attr('disabled',true);
    });

    $(document).on('click','.sh-modifier',function(event) {
    	let modifier_id = $(this).val();
    	let category_id = $(this).attr('category-id');
    	let limit = $(this).attr('limit');
    	let price = parseFloat($('.second-half-price').val());
    	let modifier_price = parseFloat($(this).attr('modifier-price'));
    	let first_half_price = parseFloat($('.first-half-price').val());
    	let first_half_modifier_price = parseFloat($('.fh-modifier-price').val());
    	let second_half_modifier_price = parseFloat($('.sh-modifier-price').val());
    	let total_checked = $('.sh-modifier-category-'+category_id+':checked').length;
    	let is_subtract = true;

    	if (limit == 1) {
    		if (total_checked == 0) {
				is_subtract = false;
    		} else {
				$('.sh-modifier-category-'+category_id).each(function() {
					if (this.checked) {
						if (total_checked > 1) {
							if ($(this).val() != modifier_id) {
								let not_selected_modifier_price = parseFloat($(this).attr('modifier-price'));
				    			second_half_modifier_price = second_half_modifier_price - not_selected_modifier_price;
				    			price = price - not_selected_modifier_price;
							}
						}
					}
				});
    		}
            $('.sh-modifier-category-'+category_id).prop("checked",false);
            this.checked = true;
    	} else {
            if (total_checked > limit) {
                this.checked = false;
                is_subtract = false;
                $('#sh-alert-'+category_id).css('display','block');
                setTimeout(function() { $('#sh-alert-'+category_id).css('display','none'); },5000);
            }
    	}

    	if (this.checked) {
    		second_half_modifier_price = second_half_modifier_price + modifier_price
    		price = price + modifier_price;
    		if (!is_subtract) {
	    		second_half_modifier_price = second_half_modifier_price - modifier_price
	    		price = price - modifier_price;
    		}
    	} else {
    		if (is_subtract) {
	    		second_half_modifier_price = second_half_modifier_price - modifier_price
	    		price = price - modifier_price;
    		}
    	}

    	$('.second-half-price').val(price.toFixed(2));
	    $('.sh-modifier-price').val(second_half_modifier_price.toFixed(2));
		if (price > first_half_price) {
	    	$('.total-price').val(price.toFixed(2));
	    	$('.total-price-text').html("£"+price.toFixed(2));
	    	$('.total-modifier-price').val(second_half_modifier_price.toFixed(2));
		} else {
	    	$('.total-price').val(first_half_price.toFixed(2));
	    	$('.total-price-text').html("£"+first_half_price.toFixed(2));
	    	$('.total-modifier-price').val(first_half_modifier_price.toFixed(2));
		}
    });

    $(document).on('submit','#add_to_cart_half_and_half_deal_form',function(event) {
    	event.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (data) {
                $('.half-deals-modal').modal('hide');
                $('.product-cart-block').html(data['cart_content']);
                $('.mobile-cart-block').html(data['mobile_cart']);
                // event.css('display', 'block');
                // event.siblings('.adding-to-cart-button-loader').css('display', 'none');
                cartScroll();
                showProductAddedMessage('Successfully added to cart');
            },
            error: function (error) {
            }
        });
    });
</script>