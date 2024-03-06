<script type="text/javascript">
	$(document).ready(function() {
		$('[data-toggle="accept-msg-ex"]').popover({html: true});
		$('[data-toggle="reject-msg-ex"]').popover({html: true});
	});

    CKEDITOR.editorConfig = function(config) {
        config.allowedContent = true;
    };
    CKEDITOR.replace('accepted-message');
    CKEDITOR.replace('rejected-message');
    
    $('#calender').datepicker({
    	format: 'yyyy-mm-dd',
    	multidate: true
    });
    $('#closing_date').val(
        $('#calender').datepicker('getFormattedDate')
    );
	$('#calender').on('changeDate', function() {
	    $('#closing_date').val(
	        $('#calender').datepicker('getFormattedDate')
	    );
	});

	$(document).on('change','#is_closed_active',function() {
		if (this.checked) {
			$('.validity-div').removeClass('validity-div-hide');
			$('.validity-div').addClass('validity-div-show');
			$('#message').val('<?= $message ?>');
		    cb(start,end);
		} else {
			$('.validity-div').removeClass('validity-div-show');
			$('.validity-div').addClass('validity-div-hide');
			$('#message').val('');
		    cb(moment(),moment());
		}
	});

</script>