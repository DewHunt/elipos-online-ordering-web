
function show_loader(divClass)
{
	jQuery("."+divClass).addClass("spinned");
}
function hide_loader(divClass)
{
	jQuery("."+divClass).removeClass("spinned");
}
	<!--scroll to top-->
	jQuery(document).ready(function(){
		jQuery(window).scroll(function(){
            if (jQuery(this).scrollTop() > 200) {
                jQuery('.typtipstotop').fadeIn();
            } else {
                jQuery('.typtipstotop').fadeOut();
            }
        });
		jQuery('.typtipstotop').click(function(){
			jQuery("html, body").animate({ scrollTop: 0 }, 1000);
            return false;
        });
	});
	<!--scroll to top-->
	<!-- Slidebars -->
	/*(function($) {
		jQuery(document).ready(function() {
			// Initiate Slidebars
			$.slidebars();
			// Slidebars Submenus
			jQuery('.sb-toggle-submenu').off('click').on('click', function() {
				$submenu = jQuery(this).parent().children('.sb-submenu');
				jQuery(this).add($submenu).toggleClass('sb-submenu-active'); // Toggle active class.
				if ($submenu.hasClass('sb-submenu-active')) {
					$submenu.slideDown(200);
				} else {
					$submenu.slideUp(200);
				}
			});
		});
	}) (jQuery);*/
	<!-- Slidebars -->
	<!--Select Search Field-->
	/*jQuery(document).ready(function()
	{ 
		if( jQuery( document ).width() > 1000 )
		{	
			jQuery(".spdropdown1").select2();
			jQuery(".spdropdown2").select2();
		}
	});*/
	<!--Select Search Field-->