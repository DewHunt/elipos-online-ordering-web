<script type="text/javascript">
    $(document).on('change','.reservation',function() {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
        	$('.reservation_amount').attr('readonly',false);
        } else {
        	$('.reservation_amount').val(0);
        	$('.reservation_amount').attr('readonly',true);
        }
    })
</script>