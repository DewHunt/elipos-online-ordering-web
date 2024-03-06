<script type="text/javascript">
    $(document).on('submit','#menu_file_form',function(e) {
        e.preventDefault();
        var form = $(this);
        var form_data = new FormData(this);
        var type = form.attr('method');
        var action = form.attr('action');

        $.ajax({
            type: type,
            url: action,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.is_valid) {
                    $('#file_data').val(data.file_data);
                    $('#user_authentication').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Yor text file must be start with "data" word or file type must be .txt extention.',
                    });
                }
            }
        });
    });

    $(document).on('submit','#user_authentication_form',function(e) {
        e.preventDefault();
        var form = $(this);
        var form_data = new FormData(this);
        var type = form.attr('method');
        var action = form.attr('action');

        $.ajax({
            type: type,
            url: action,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
            	var icon_text = '';
            	var title_text = '';
            	var msg = '';
            	if (data.is_authenticated) {
            		icon = 'success';
            		title_text = 'Success';
            		msg = data.msg
            		$('#user_authentication').modal('hide');
            	} else {
            		icon = 'error';
            		title_text = 'Oops...';
            		msg = data.msg
            	}

        		Swal.fire({
        			icon: icon_text,
        			title: title_text,
        			text: msg,
        		});
        	}
        });
    });
</script>