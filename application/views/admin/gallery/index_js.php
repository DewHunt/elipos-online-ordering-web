<script type="text/javascript" src="<?=base_url('assets/js/holder/js/holder.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fancybox/js/jquery.mousewheel-3.0.6.pack.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fancybox/js/jquery.fancybox.pack.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fancybox/js/jquery.fancybox-buttons.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fancybox/js/jquery.fancybox-thumbs.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/fancybox/js/jquery.fancybox-media.js')?>"></script>
<!--End of plugin scripts-->
<script type="text/javascript" src="<?=base_url('assets/js/gallery.js')?>"></script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#logoImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[type=file]').change(function (event) {
        var files = $("#gallery-images")[0].files;
        $('.modal-body .browse-file-block').css('display','none');
        var allowedTypes = /^image\/(jpg|jpeg|png|webp|gif)$/;
        var output = '';

        for (var i = 0; i < files.length; i++) {
            var imageType = files[i].type;
            var isAllowed = allowedTypes.test(imageType);
            var url = URL.createObjectURL(event.target.files[i]);
            if (isAllowed) {
                output += '<div class="selected-img-block">'
                +'<img class="card-img-top img-thumbnail" src="'+url+'" alt="">'
                +'</div>';
            } else {
                output += '<div class="selected-img-block">'
                +'<img class="card-img-top img-thumbnail" src="'+url+'" alt="">'
                +'<span class="error">Invalid Image Format!</span>'
                +'</div>';
            }
        }
        $('.modal-body .images-block').append(output);
    });

    $('.upload-gallery-image').on('hidden.bs.modal', function (e) {
        $('.modal-body .images-block').empty();
        $('.modal-body .browse-file-block').css('display','block');
        $("#gallery-images").val('').clone(true);
    });

    $('.delete-image').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        var dish = $(this);
        $(this).hide();
        $(this).next().show();

        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/gallery_management/delete_file')?>',
            data: {'path': url},
            success: function (data) {
                if (data['is_deleted']) {
                    dish.parents('div.gallery-border').remove();
                }
                if (data['is_logout']) {
                    window.location.href = '<?=base_url('admin')?>';
                }
            },
            error: function (error) {
                console.log("error");
            }
        });
    });

    $('.image-upload').click(function (event) {
        $(this).hide();
        // var gallery_images=$("#gallery-images")[0].files;
        // console.log(gallery_images);
    });
</script>