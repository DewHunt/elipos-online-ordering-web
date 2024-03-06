<script type="text/javascript">
    function set_images_directory_in_session(directory) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/image_manager/set_images_directory_in_session') ?>',
            data: {directory},
            success: function (data) {
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    $(document).on('submit','#image-form',function(e) {
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
                $('#image-form')[0].reset();
                $('#images-manager-div').html(data.output);
                // $('#imageModal').modal('show');
            }
        });
    });

    $(document).on('click','#btn-show-images,#btn-image-refresh',function(e) {
        e.preventDefault();
        var directory = $(this).attr('img-dir');
        if (typeof directory != 'undefined' && directory != false) {
            set_images_directory_in_session(directory);
        }
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/image_manager/set_images_in_modal') ?>',
            data: [],
            success: function (data) {
                $('#images-manager-div').html(data.output);
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
            url:'<?= base_url('admin/image_manager/delete_images') ?>',
            data: {image_path},
            success: function (data) {
                $('#images-manager-div').html(data.output);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('change','.image-cb',function() {
        var imageLimit = $('#btn-show-images').attr('img-limit');
        var loop = 1;
        $("input:checkbox[name=image_name]:checked").each(function() {
            if (imageLimit != 'all') {
                if (imageLimit == 1) {
                    this.checked = false;
                } else if (imageLimit >= loop) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
                loop++;
            }
        });
        if (imageLimit == 1) {
            this.checked = true;
        }
    });

    $(document).on('click','#btn-save-image',function(e) {
        /*
        * This function will set image or images in a hidden input file.
        * This function will have to use where you want to use image manager
        */
        e.preventDefault();
        var image_paths = [];

        $("input:checkbox[name=image_name]:checked").each(function(){
            image_paths.push($(this).val());
        });
        // var first_image_path = image_paths[0];
        var all_images = image_paths.join();
        $('#selected_image').val(all_images);
        console.log('all_images: ',all_images);
    });
</script>