<script type="text/javascript">
    $(document).on('submit','#galleryImageForm',function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#galleryImageForm')[0].reset();
                $('#images-div').html(data.output);
                // $('#imageModal').modal('show');
            }
        });
    });

    $(document).on('click','#btn_show_images,#btn-image-refresh',function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/settings/maintenance_settings_show_images') ?>',
            data: [],
            success: function (data) {
                $('#images-div').html(data.output);
                $('#imageModal').modal('show');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','#btn-image-delete',function(e) {
        e.preventDefault();
        var image_path = $(this).attr('image-path');
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/settings/maintenance_settings_delete_images') ?>',
            data: {image_path},
            success: function (data) {
                $('#images-div').html(data.output);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','#btn-save-maintenance-image',function(e) {
        e.preventDefault();
        var id = $('#maintenance_mode_id').val();
        var image_paths = [];

        $("input:checkbox[name=image_name]:checked").each(function(){
            image_paths.push($(this).val());
        });
        var first_image_path = image_paths[0];
        $('#maintenance_image').val(first_image_path);
        console.log(image_paths[0]);
    });
</script>