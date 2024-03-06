$(document).ready(function(){

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.typtipstotop').fadeIn();
        } else {
            $('.typtipstotop').fadeOut();
        }
    });

    $('.typtipstotop').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });

});

	/*Filter Search Result though Ajax Request*/
	function filterRestaurantList() 
	{
		var filter_by = jQuery("input[name='filter_by']:checked").val();
		var sort_by = jQuery("input[name='sort_by']:checked").val();
		var city = jQuery("#scity").val();
		var scity = (city == "" || typeof city == "undefined")?"all":city;
		var cuisineIDs = "";
		var restnam = "";
		jQuery('.cuisine_list:checked').each(function() 
		{
			cuisineIDs += $(this).val() + "_";
		});
		cuisineIDs =  cuisineIDs.slice(0,-1);
		jQuery('#list-view').hide();
		jQuery('#loading-icon').show();
		jQuery.ajax({
			type : "POST",
			url : base_url + "user/filter_search_result/" + scity + "/" + cuisineIDs,
			data: "&order_type="+filter_by+"&sort_by="+sort_by+"&restname="+restnam,
			success : function(data) 
			{
				jQuery('#loading-icon').hide();
				jQuery('#list-view').html(data).show();
				jQuery('#no_of_restaurant').html(jQuery('#total_restaurant_found').val());
			}
		});
		jQuery("html, body").animate({ 
			scrollTop: "0px",
			duration: "slow",
			specialEasing: {
			width: "linear",
			height: "easeOutBounce"
		}});
	}
	  