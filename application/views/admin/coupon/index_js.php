<script type="text/javascript">
    $('#save-settings').click(function () {
        $('.content .overlay').fadeIn();
        var isCouponEnabled = $('#isCouponEnabled').is(':checked');
        var dish = $(this);
        $('#save-message').text('');
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/coupons/save_settings') ?>',
            data: {isCouponEnabled: isCouponEnabled},
            success: function (data) {
                if (data['isSave']) {
                    $('#save-message').text('Save Successfully');
                } else {
                    $('#save-message').text('Please try again');
                }
                $('.content .overlay').fadeOut();
            },
            error: function (error) {
                $('#save-message').text('Please try again');
                $('.content .overlay').fadeOut();
            }
        });
    });
</script>