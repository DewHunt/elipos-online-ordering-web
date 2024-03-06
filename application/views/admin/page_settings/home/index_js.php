<script type="text/javascript">
    $('input[type=file]').change(function (event) {
        var files = $("#banner-images")[0].files;
        $('.modal-body .browse-file-block').css('display','none');

        for (var i = 0; i < files.length; i++)
        {
            console.log(files[i]);
            //
            var url =URL.createObjectURL(event.target.files[i]);

            $('.modal-body .images-block').append('<img style="height: 100px;width: 100px;margin-right: 2px;margin-bottom: 2px" class="card-img-top img-thumbnail" src="'+url+'" alt="">');
        }
    });

    $('.delete-image').click(function (event) {
        event.preventDefault();
        var url=$(this).attr('href');
        var dish=$(this);
        $(this).hide();
        $(this).next().show();

        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/page_management/delete_file')?>',
            data: {'path': url},
            success: function (data) {

                if(data['is_deleted']){
                    dish.parents('div.gallery-border').remove();
                }

                if(data['is_logout']){
                    window.location.href='<?=base_url('admin')?>';
                }
            },
            error: function (error) {
                console.log("error");
            }
        });
    });

    $(document).on('click','.delete-well-come-image',function(event) {
        event.preventDefault();
        var url=$(this).attr('href');
        var dish=$(this);
        $(this).hide();
        $(this).next().show();

        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/page_management/delete_file')?>',
            data: {'path': url},
            success: function (data) {
                if(data['is_deleted']){
                    window.location.href='<?=base_url('admin/page_management/home')?>';
                }

                if(data['is_logout']){
                    window.location.href='<?=base_url('admin')?>';
                }
            },
            error: function (error) {
                console.log("error");
            }
        });
    });

    loadImage();
    function loadImage() {
        $('#welcome-image-form input[type=file]').change(function () {
            var file = $(this);
            var name = $(this).attr("name");
            var id = '#well-come-image-'+name;

            var reader = new FileReader();
            reader.onload = function (event) {
                $(id).attr('src', event.target.result);
            };
            reader.readAsDataURL(file[0].files[0]);
        });
    }

    deleteItemimage();
    function deleteItemimage() {
        $('.delete-image-button').on('click', function (event) {
            event.preventDefault();
            $('.uploader img').attr('src', "");
            $('.delete_image').attr('value', "1");
        });
        loadImage();
    }
</script>

<script type="text/javascript">

    $('.delete-apps-image').click(function (event) {
        event.preventDefault();
        var url=$(this).attr('href');
        var dish=$(this);
        $(this).hide();
        $(this).next().show();

        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/page_management/delete_file')?>',
            data: {'path': url},
            success: function (data) {

                if(data['is_deleted']){
                    window.location.href='<?=base_url('admin/page_management/home')?>';
                }

                if(data['is_logout']){
                    window.location.href='<?=base_url('admin')?>';
                }
            },
            error: function (error) {
                console.log("error");
            }
        });


    });


    loadImage();
    function loadImage() {
        $(' #apps-image-form input[type=file]').change(function () {
            var file = $(this);
            var name=$(this).attr("name");
            var id='#apps-image';

            var reader = new FileReader();
            reader.onload = function (event) {
                $(id).attr('src', event.target.result);

            };
            reader.readAsDataURL(file[0].files[0]);
        });
    }


</script>