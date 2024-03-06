<script type="text/javascript">
    $(document).on('change','#show-back-img',function() {
        if ($(this).prop('checked')) {
            $('#back-color').val('none');
        } else {
            let backColor = $('#back-color').attr('db-val');
            $('#back-color').val(backColor);
        }
    });

    $(document).on('click','.img-del-btn',function() {
        let imagePath = $(this).attr('img-path');
        let deleteFor = $(this).attr('del-for');

        if (imagePath) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/app_settings/delete_image') ?>",
                data:{deleteFor,imagePath},
                success: function(response) {
                    console.log('response: ',response);
                    if (deleteFor == 'background-img') {
                        $('.background-img').attr('src',response.output);
                    }
                    if (deleteFor == 'top-img') {
                        $('.top-img').attr('src',response.output);
                    }
                    if (deleteFor == 'logo-img') {
                        $('.logo-img').attr('src',response.output);
                    }
                    if (deleteFor == 'slider-img') {
                        $('.slider-image-lists').html(response.output);
                    }
                    if (deleteFor == 'notification-img') {
                        $('.notification-image-lists').html(response.output);
                    }
                },
            });
        }
    });
</script>