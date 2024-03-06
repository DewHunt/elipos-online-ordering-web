<script type="text/javascript">
    $('#save-settings').click(function () {
        $('.content .overlay').fadeIn();
        var enabled_free_item = $('#enabled_free_item').is(':checked');
        var free_item_limit = $('#free-item-limit').val();
        var dish = $(this);
        $.ajax({
            type: "POST",
            url: '<?=base_url('admin/free_items/save_settings')?>',
            data: {enabled_free_item: enabled_free_item,free_item_limit: free_item_limit},
            success: function (data) {
                if (data['isSave']) {
                    $('#save-message').text('Save successfully');
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

    $('#freeItems-table tr td .btn-approved').click(function () {
        alert('a'+$(this).attr('data-id'));
        var id = $(this).attr('data-id');
    });

    $('#freeItems-table tr td .btn-view').click(function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: '<?=base_url('admin/freeItems/view')?>',
            data: {id: id},
            success: function (data) {
                $('#viewFeedBack .modal-body').html(data.modalBody);
                $('#viewFeedBack').modal('show');
                $('#viewFeedBack .modal-body').attr('data-id', id);
            },
            error: function (error) {
            }
        });
    });
</script>