<script type="text/javascript">
	$(document).on('click','.edit-app-version',function() {
		getIosVersion("ios-version");
	});

	$(document).on('click','.add-edit-app-store-info',function() {
		getIosVersion("app-store");
	});

	function getIosVersion(formName) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/app_settings/get_ios_version_info') ?>",
            data:{},
            success: function(response) {
            	var ios_version = response.ios_version;
            	if (ios_version) {
	            	$('#app_store_url').val(ios_version.app_store_url);
	            	$('#package_name').val(ios_version.package_name);
	            	$('#ios_app_id').val(ios_version.ios_app_id);
	            	$('#update_url').val(ios_version.update_url);
            		$('#current_app_version').val(ios_version.current_app_version);
            	}
            		
        		if (formName == "ios-version") {
        			$('.modal-title').html('iOS App Version Information');
        			$('.app-version-inp-div').show();
        			$('.app-store-inp-div').hide();
        		}

        		if (formName == "app-store") {
        			$('.modal-title').html('App Store Information');
        			$('.app-store-inp-div').show();
        			$('.app-version-inp-div').hide();
        		}

            	$('#addEditModal').modal('show');
            },
        });
	}

	$(document).on('input','#app_store_url,#package_name,#ios_app_id',function() {
		var app_store_url = $('#app_store_url').val();
		var package_name = $('#package_name').val();
		var ios_app_id = $('#ios_app_id').val();
		var updateUrl = app_store_url + package_name + '/id' + ios_app_id;
		$('#update_url').val(updateUrl);
	});

	$(document).on('click','.save-btn',function() {
		var app_store_url = $('#app_store_url').val();
		var package_name = $('#package_name').val();
		var ios_app_id = $('#ios_app_id').val();
		var update_url = $('#update_url').val();
		var current_app_version = $('#current_app_version').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/app_settings/save_ios_version') ?>",
            data:{app_store_url,package_name,ios_app_id,update_url,current_app_version},
            success: function(response) {
            	var ios_version = response.ios_version;
            	console.log('ios_version',ios_version);
            	if (response.is_save) {
	            	if (ios_version) {
		            	$('#app_store_url_td').html(ios_version.app_store_url);
		            	$('#package_name_td').html(ios_version.package_name);
		            	$('#ios_app_id_td').html(ios_version.ios_app_id);
		            	$('#update_url_td').html(ios_version.update_url);
	            		$('#current_app_version_td').html(ios_version.current_app_version);
	            	}
	            	$('.edit-app-version').addClass('show');
	            	$('.app-store-info-btn-text').html('Edit');
            		$('.success-msg').html(response.message);
            		$('#addEditModal').modal('hide');
            	} else {
            		$('.error-msg').html(response.message);
            	}
            },
        });
	});
</script>