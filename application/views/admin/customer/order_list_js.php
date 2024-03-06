<script type="text/javascript">
    $(document).on('click','.view-order',function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-action');
        $.post(url, {'id': id,'is_show_btn':'false'}, function (data) {
            $('.view-modal-block').html(data);
            $('.view-modal').modal('show');
            delete_order();
        })
    });

    $(document).on('click','.delete-order',function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-action');
        alert(url);
        var dish = $(this);
        var closest_row = $(this).closest('tr');
        var confirmation = confirm('Are You Sure?');
        if (confirmation) {
            $.ajax({
                url: url,
                type: 'post',
                data: {'id': id},
                success: function (data) {
                    $(closest_row).remove();
                }
            });
        }
    });
</script>