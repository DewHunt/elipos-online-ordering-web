jQuery(document).ready(function() {

	jQuery(".sign-in-tab").click(function() {
		loadSignIn();  // function to display the sin in form
	});

	jQuery(".register-tab").click(function() {
		loadRegister(); // function to display the register form
	});

	jQuery("div.close").click(function() {
		disablePopup();  // function to close pop-up forms
	});

	jQuery("#background-on-popup").click(function() {
		disablePopup();  // function to close pop-up forms
	});

	jQuery(this).keyup(function(event) {
		if (event.which == 27) { // 27 is the code of the ESC key
			disablePopup();
		}
	});

	var status = 0;

	function loadSignIn() {
		if(status == 0) {
			jQuery("#sign-in-form").fadeIn(300);
			jQuery("#background-on-popup").css("opacity", "0.8");
			jQuery("#background-on-popup").fadeIn(300);
			status = 1;
		}
	}

	function loadRegister() {
		if(status == 0) {
			jQuery("#register-form").fadeIn(300);
			jQuery("#background-on-popup").css("opacity", "0.8");
			jQuery("#background-on-popup").fadeIn(300);
			status = 1;
		}
	}

	function disablePopup() {
		if(status == 1) {
			jQuery("#sign-in-form").fadeOut("normal");
			jQuery("#register-form").fadeOut("normal");
			jQuery("#background-on-popup").fadeOut("normal");
			status = 0;
		}
	}


	
	jQuery("#checkbox .unchecked-state").click( // checkbox select event
		function(event) {
			jQuery(this).parent().addClass("selected");
			jQuery(this).parent().find("checkbox").attr("checked","checked");
		}
	);
	
	jQuery("#checkbox .checked-state").click( // checkbox deselect event
		function(event) {
			jQuery(this).parent().removeClass("selected");
			jQuery(this).parent().find("checkbox").removeAttr("checked");
		}
	);	
        
   
         jQuery('#mobileMenu').change(function() {
            var menuValue = jQuery("#mobileMenu").val();
            if (menuValue == 1 )
            {
               loadSignIn();
            } 
            else if (menuValue == 2) {
               loadRegister();
            }
            else{
                window.location = menuValue;
            }
         });


});