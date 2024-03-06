	/*var restaurant_id;
	var base_url;*/
	jQuery.ajaxSetup({
		async : true
	});

	
	
		//mycart in rightbar
	jQuery(document).ready(function() {
		jQuery('.content-cartspan')
			.theiaStickySidebar({
				additionalMarginTop: 0
			});
	});
	
	//show menu in leftbar
	jQuery(document).ready(function() {
		jQuery('.menucontentarea_grid1')
			.theiaStickySidebar({
				additionalMarginTop: 0
			});
	});
	
jQuery(document).ready(function() {


	scrolling_cart();

    jQuery.post(base_url + 'user/showRestaurantReviews', {restid:restaurant_id}, function(response) {
        if (response != '') {
            jQuery('#review').html(response);
        } else {
            jQuery('#review').html('Request fail to load the data. Please reload the page');
        }

    });
    jQuery.post(base_url + 'user/getopeningtime', {restid:restaurant_id}, function(response) {
        if (response != '') {
            jQuery('#opening_time').html(response);
        } else {
            jQuery('#opening_time').html('Request fail to load the data. Please reload the page');
        }

    });

	jQuery.post(base_url + 'user/getPormotionDetails', {
		restid : restaurant_id
	}, function(response) {
		if (response != '') {
			jQuery('#promo-div').html('');
			jQuery('#promo-div').html(response);
		} else {
			jQuery('#promo-div').html('Request fail to load the data.Please reload the page');
		}

	});

	jQuery.post(base_url + 'user/getDeliveryCollectionTime', {
		restid : restaurant_id
	}, function(response) {
		if (response != '') {
			jQuery('#order-time-div').html('');
			jQuery('#order-time-div').html(response);
		} else {
			jQuery('#order-time-div').html('Request fail to load the data.Please reload the page');
		}

	});
	/*
	 * jQuery.post(base_url+'user/getSuburbText',{restid:restaurant_id},function(response){
	 * if(response != '') { jQuery('#suburb-div').html('');
	 * jQuery('#suburb-div').html(response); } else {
	 * jQuery('#suburb-div').html('Request fail to load the data.Please reload the
	 * page'); }
	 * 
	 * 
	 * });
	 */

	jQuery('#tab-menu').click(function() {
		/*jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').show();
		jQuery('#info').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#review').hide();
		jQuery('#tab-menu').addClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-review').removeClass('selected');
		jQuery('#read_review').removeClass('green');
		jQuery('#read_review').addClass('orange');*/
        jQuery('#menu').show();
        jQuery('#info').hide();
        jQuery('#review').hide();
        jQuery('#reservation').hide();
        jQuery('#tab-menu').addClass('selected');
        jQuery('#tab-info').removeClass('selected');
        jQuery('#tab-review').removeClass('selected');
        jQuery('#tab-bookatable').removeClass('selected');
	});

	jQuery('#tab-info').live('click', function() {

		/*jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#review').hide();
		jQuery('#info').show();
		jQuery('#tab-menu').removeClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-review').removeClass('selected');
		jQuery('#tab-info').addClass('selected');
		jQuery('#read_review').removeClass('orange');
		jQuery('#read_review').addClass('orange');*/
        jQuery('#menu').hide();
        jQuery('#review').hide();
        jQuery('#reservation').hide();
        jQuery('#info').show();
        jQuery('#tab-menu').removeClass('selected');
        jQuery('#tab-info').addClass('selected');
        jQuery('#tab-review').removeClass('selected');
        jQuery('#tab-bookatable').removeClass('selected');

	});
    jQuery('#tab-bookatable').live('click', function() {

        /*jQuery('#myTab').children().removeClass('active');
         jQuery(jQuery(this)).parent().addClass('active');
         jQuery('#menu').hide();
         jQuery('#deliveryarea').hide();
         jQuery('#review').hide();
         jQuery('#info').show();
         jQuery('#tab-menu').removeClass('selected');
         jQuery('#tab-delarea').removeClass('selected');
         jQuery('#tab-review').removeClass('selected');
         jQuery('#tab-info').addClass('selected');
         jQuery('#read_review').removeClass('orange');
         jQuery('#read_review').addClass('orange');*/
        jQuery('#menu').hide();
        jQuery('#review').hide();
        jQuery('#info').hide();
        jQuery('#reservation').show();
        jQuery('#tab-menu').removeClass('selected');
        jQuery('#tab-info').removeClass('selected');
        jQuery('#tab-review').removeClass('selected');
        jQuery('#tab-bookatable').addClass('selected');
        jQuery.post(base_url + "user/reservation/"+ restaurant_id,function(data){

            jQuery('#reservation').html(data);

        });


    });

	jQuery('#tab-delarea').click(function() {

		jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').hide();
		jQuery('#info').hide();
		jQuery('#deliveryarea').show();
		jQuery('#review').hide();
		jQuery('#tab-menu').removeClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#tab-delarea').addClass('selected');
		jQuery('#tab-review').removeClass('selected');
		jQuery('#read_review').removeClass('green');
		jQuery('#read_review').addClass('orange');

		jQuery.post(base_url + 'user/showDeliveryAreaMap', function(response) {
			if (response != '') {
				jQuery('#delarea-div').html(response);
			} else {
				jQuery('#delarea-div').html('Request fail to load the data.Please reload the page');
			}

		});
	});

	jQuery('#tab-review').click(function() {
		/*jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').hide();
		jQuery('#info').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#review').show();
		jQuery('#tab-menu').removeClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-review').addClass('selected');
		jQuery('#read_review').removeClass('green');
		jQuery('#read_review').addClass('orange');*/
        jQuery('#menu').hide();
        jQuery('#info').hide();
        jQuery('#reservation').hide();
        jQuery('#review').show();
        jQuery('#tab-menu').removeClass('selected');
        jQuery('#tab-info').removeClass('selected');
        jQuery('#tab-review').addClass('selected');
        jQuery('#tab-bookatable').removeClass('selected');
	});

	jQuery('#read_review').click(function() {
		jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').hide();
		jQuery('#review').show();
		jQuery('#info').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#tab-menu').removeClass('selected');
		jQuery('#tab-review').addClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#read_review').removeClass('orange');
		jQuery('#read_review').addClass('green');
	});

	jQuery('#menu-tab-link').click(function() {
		jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').show();
		jQuery('#info').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#review').hide();
		jQuery('#tab-menu').addClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-review').removeClass('selected');
		jQuery('#read_review').removeClass('green');
		jQuery('#read_review').addClass('orange');
	});

	jQuery('#menu-tab-link-photo').click(function() {
		jQuery('#myTab').children().removeClass('active');
		jQuery(jQuery(this)).parent().addClass('active');
		jQuery('#menu').show();
		jQuery('#info').hide();
		jQuery('#deliveryarea').hide();
		jQuery('#review').hide();
		jQuery('#tab-menu').addClass('selected');
		jQuery('#tab-info').removeClass('selected');
		jQuery('#tab-delarea').removeClass('selected');
		jQuery('#tab-review').removeClass('selected');
		jQuery('#read_review').removeClass('green');
		jQuery('#read_review').addClass('orange');
	});

});

function showReviews() {

	jQuery('#myTab').children().removeClass('active');
	jQuery('#tab-review').parent().addClass('active');
	jQuery('#menu').hide();
	jQuery('#review').show();
	jQuery('#info').hide();
	jQuery('#deliveryarea').hide();
	jQuery('#tab-menu').removeClass('selected');
	jQuery('#tab-review').addClass('selected');
	jQuery('#tab-delarea').removeClass('selected');
	jQuery('#tab-info').removeClass('selected');
	jQuery('#read_review').removeClass('orange');
	jQuery('#read_review').addClass('green');
}

function add_sp_sec_price(baseid, tval) {

	bsprice = jQuery("#bacpri-" + baseid).val();

	// get special item category array
	spcat = jQuery("#bspcatid-" + baseid).val();
	gb2_status = jQuery("#gb2-" + baseid).val();

	spcatarr = spcat.split(',');
	selectionname = '';
	var spcnt = 0;
	var hasgbsel = 0;
	var total_price = 0;
	for (j in spcatarr) {
		if (spcatarr[j] != '') {

			if ((jQuery("#specialItem-" + baseid + "-" + spcatarr[j]).val() != undefined)) {

				spcatselected_temp = jQuery("#specialItem-" + baseid + "-" + spcatarr[j]).val();
				spcatselected_arr = spcatselected_temp.split('=');
				gbselprice = spcatselected_arr[1];
				total_price = parseFloat(gbselprice) + total_price;

			} else {
				hasgbsel = 1;
				spcatselected_temp = jQuery("#specialItem-" + baseid + "-" + spcatarr[j] + "-GB").val();

				spcatselected_arr = spcatselected_temp.split('=');
				spcatselected = spcatselected_arr[0];
				gbselprice = spcatselected_arr[1]
				selectionname = jQuery("#specialItem-" + baseid + "-" + spcatarr[j] + "-GB" + " option:selected").text();
				total_price = parseFloat(gbselprice) + total_price;
			}
		}
	}

	if (gb2_status == '0') {
		total_price = total_price + parseFloat(bsprice);
		jQuery("#bp-" + baseid + " p").html(currency + total_price.toFixed(2));
	} else {
		jQuery("#bp-" + baseid + " p").html(currency + total_price.toFixed(2));
	}

}

function scrolling_cart() {
	/*
	jQuery('.content-cartspan')
			.theiaStickySidebar({
				additionalMarginTop: 0
			});
	var api = jQuery('.cartscroll').jScrollPane({
		stickToBottom : true,
		maintainPosition : true,
		showArrows : false,
		verticalDragMinHeight : 50,
		verticalDragMaxHeight : 50
	}).data('jsp').scrollToBottom();
	*/
}


