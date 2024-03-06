/*$(document).ready(function($) {
	chooseSearchOption(2);
	//get_area_list_home( $('#search_area_parent').val() );
});*/

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

/*<!--Color Box-->
<!--Restaurant Carousal Starts-->
function mycarousel_initCallback(carousel) {
	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
};

$(document).ready(function() {
	$('#mycarousel').jcarousel({
		auto: 2,
		scroll: 1,
		wrap: 'circular',
		initCallback: mycarousel_initCallback
	});
});
<!--Restaurant Carousal Ends-->


function chooseSearchOption(choice) {
	if(choice==1)
	{
		$('#search_area').hide();
		$('#search_area_parent').hide();
		$('#s2id_search_area').hide();

		$('#search_postcode').show();
		//alert("Search by postcode will be available soon");
	}
	else
	{
		$('#search_postcode').hide();
		$('#search_area').show();
		$('#search_area_parent').show();
		$('#s2id_search_area').show();
	}
}

function validate_search() {
	var search_type = $( "input:radio[name=search_type]:checked" ).val();
	//alert(search_type);
	if(search_type==1)
	{
		var user_postcode = $("#search_postcode").val();
		if (user_postcode.trim() == '' || user_postcode.trim() == 'Enter your postcode')
		{
			alert("Please choose your location.");
			document.search_restaurant.search_postcode.focus();
			return false;
		}
	}
	else
	{
		var user_area = $('#search_area_parent').val();
		var user_zone = $("#search_area").val();
		if (user_area == '')
		{
			alert("Please choose your area.");
			document.search_restaurant.search_area_parent.focus();
			return false;
		}
		else if (user_zone == '')
		{
			alert("Please choose your zone.");
			document.search_restaurant.search_area.focus();
			return false;
		}
	}

	document.search_restaurant.submit();
}
// Tabs Start
$(function() {

	$("#$tab").organicTabs();

	$("#example-two").organicTabs({
		"speed": 200
	});

});

(function($) {

	$.organicTabs = function(el, options) {

		var base = this;
		base.$el = $(el);
		base.$nav = base.$el.find(".nav");

		base.init = function() {

			base.options = $.extend({},$.organicTabs.defaultOptions, options);

			// Accessible hiding fix
			$(".hide").css({
				"position": "relative",
				"top": 0,
				"left": 0,
				"display": "none"
			});

			base.$nav.delegate("li > a", "click", function() {

				// Figure out current list via CSS class
				var curList = base.$el.find("a.current").attr("href").substring(1),

				// List moving to
					$newList = $(this),

				// Figure out ID of new list
					listID = $newList.attr("href").substring(1),

				// Set outer wrapper height to (static) height of current inner list
					$allListWrap = base.$el.find(".list-wrap"),
					curListHeight = $allListWrap.height();

				$allListWrap.height(curListHeight);

				if ((listID != curList) && ( base.$el.find(":animated").length == 0)) {

					// Fade out current list
					base.$el.find("#"+curList).fadeOut(base.options.speed, function() {

						// Fade in new list on callback
						base.$el.find("#"+listID).fadeIn(base.options.speed);

						// Adjust outer wrapper to fit new list snuggly
						var newHeight = base.$el.find("#"+listID).height();
						$allListWrap.animate({
							//height: newHeight /!*[auto height off sayed]*!/
						});

						// Remove highlighting - Add to just-clicked tab
						base.$el.find(".nav li a").removeClass("current");
						$newList.addClass("current");

					});

				}

				// Don't behave like a regular link
				// Stop propegation and bubbling
				return false;
			});

		};
		base.init();
	};

	$.organicTabs.defaultOptions = {
		"speed": 300
	};

	$.fn.organicTabs = function(options) {
		return this.each(function() {
			(new $.organicTabs(this, options));
		});
	};

})($);
// Tabs End



/!************************* START OF GOOGLE MAPS SEARCH *****************************!/
function show_google_map() {
	var ucity = $("#map_search_city").val();
	if(ucity==""){
		alert("Please select your city!");
		return false;
	}
	document.getElementById('map_search_city').value = ucity;

	$(".point_location_map_container").colorbox({inline:true, width:"720px", open:true });
	$(".point_location_map_container").colorbox.resize();
	initialize_gmap(ucity);
}

function initialize_gmap(ucity) {
	var rlat = document.getElementById("templat").value;
	var rlon = document.getElementById("templon").value;
	var mapOptions={
				center: new google.maps.LatLng(rlat,rlon),
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: true,
				mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.TOP_RIGHT
				}
	};
	var geocoder = new google.maps.Geocoder();
	var address = document.getElementById('map_searchinput').value;
	address += ' + '+ucity;
	map = new google.maps.Map(document.getElementById("location_map"),mapOptions);

}

function codeAddress() {
	var geocoder = new google.maps.Geocoder();
	var address = $.trim($('#map_search_city option:selected').text());
	if(address=="")
	{
		alert("Please select your city!");
		return false;
	}
	address = address+' + '+$.trim($('#map_searchinput option:selected').text());
	//document.getElementById('city').value = document.getElementById('changed_city').value;
	geocoder.geocode( { 'address': address}, function(results, status)
	{
		if (status == google.maps.GeocoderStatus.OK)
		{
			map.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: map,
				zoom: 15,
				position: results[0].geometry.location,
				draggable:true
			});
			document.getElementById("templat").value = results[0].geometry.location.lat();
			document.getElementById("templon").value = results[0].geometry.location.lng();
			google.maps.event.addListener(marker, 'dragend', function(a)
			{
				document.getElementById("templat").value = a.latLng.lat();
				document.getElementById("templon").value = a.latLng.lng();
			});
		 }
		 else
		 {
			alert('Geocode was not successful for the following reason: ' + status);
		 }
	});
}

function mapSearch() {
		document.map_search_frm.submit();	
	}
/!************************* END OF GOOGLE MAPS SEARCH *****************************!/*/

function slideSwitch() {
    var $active = $('#slideshow IMG.active');

    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slideshow IMG:first');

    // uncomment the 3 lines below to pull the images in random order

    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );
    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

/*
function setOrderOption(choice) {
   $('#search_order_option').val(choice);
}

function get_area_list_home(city_id) {
	$('#search_area').empty();
	$('#search_area').append($('<option>', {
		value: "",
		text : "Choose Zone"
	}));

	$.ajax({
		type: "POST",
		url: base_url+"user/get_area_list_home",
		data: "cityid="+city_id,
		success: function(response){
			zoneArray = $.parseJSON(response);
			$.each(zoneArray, function (i, zone) {
				//alert( "test"+zone.AreaId+" -- "+zone.AreaName+" ---- "+zone.CityId );
				$('#search_area').append($('<option>', {
					value: zone.AreaId,
					text : zone.AreaName
				}));
			});
		}
	});
}
*/




