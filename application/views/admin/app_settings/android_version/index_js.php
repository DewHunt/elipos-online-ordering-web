<script type="text/javascript">
	$(document).on('click','.edit-app-version',function() {
		getAndroidVersion("android-version");
	});

	$(document).on('click','.add-edit-play-store-info',function() {
		getAndroidVersion("play-store");
	});

	function getAndroidVersion(formName) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/app_settings/get_android_version_info') ?>",
            data:{},
            success: function(response) {
            	var android_version = response.android_version;
            	if (android_version) {
	            	$('#package_name').val(android_version.package_name);
	            	$('#play_store_url').val(android_version.play_store_url);
	            	$('#update_url').val(android_version.update_url);
            		$('#current_app_version').val(android_version.current_app_version);
            	}
            		
        		if (formName == "android-version") {
        			$('.modal-title').html('Android App Version Information');
        			$('.app-version-inp-div').show();
        			$('.play-store-inp-div').hide();
        		}

        		if (formName == "play-store") {
        			$('.modal-title').html('Play Store Information');
        			$('.play-store-inp-div').show();
        			$('.app-version-inp-div').hide();
        		}

            	$('#addEditModal').modal('show');
            },
        });
	}

	$(document).on('input','#play_store_url,#package_name',function() {
		var playStoreUrl = $('#play_store_url').val();
		var package_name = $('#package_name').val();
		var updateUrl = playStoreUrl + '?id=' + package_name;
		$('#update_url').val(updateUrl);
	});

	$(document).on('click','.save-btn',function() {
		var play_store_url = $('#play_store_url').val();
		var package_name = $('#package_name').val();
		var update_url = $('#update_url').val();
		var current_app_version = $('#current_app_version').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/app_settings/save_android_version') ?>",
            data:{play_store_url,package_name,update_url,current_app_version},
            success: function(response) {
            	var android_version = response.android_version;
            	console.log('android_version',android_version);
            	if (response.is_save) {
	            	if (android_version) {
		            	$('#package_name_td').html(android_version.package_name);
		            	$('#play_store_url_td').html(android_version.play_store_url);
		            	$('#update_url_td').html(android_version.update_url);
	            		$('#current_app_version_td').html(android_version.current_app_version);
	            	}
	            	$('.edit-app-version').addClass('show');
	            	$('.play-store-info-btn-text').html('Edit');
            		$('.success-msg').html(response.message);
            		$('#addEditModal').modal('hide');
            	} else {
            		$('.error-msg').html(response.message);
            	}
            },
        });
	});
</script>