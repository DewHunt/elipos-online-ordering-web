<script>
    $(document).on('click','input[type=file]', function () {
        var dish = $(this);
        dish.parent('div').siblings('div').find('.progress').css({'display': 'none'});
    });

    $(document).on('change','input[type=file]', function () {
        var dish = $(this);
        var reader = new FileReader();
        reader.onload = function (e) {
            dish.parent('div').siblings('div').find('.image-preview').attr('src', e.target.result);
            console.log('Siblings', dish.parent('div').siblings('div').find('.image-preview'));
        };
        reader.readAsDataURL(dish[0].files[0]);
    });

    $(document).on('click','.image-upload', function () {
        var dish = $(this);
        var input_file = dish.parent('div').siblings('div').find('input[name=file]');
        var upload_file = input_file[0].files[0];
        var name = input_file[0].files[0]['name'];
        var size = input_file[0].files[0]['size'];
        //alert(size);
        var formdata = new FormData();
        formdata.append('file', upload_file);

        $.ajax({
            url: '<?= base_url($this->admin.'/settings/image_load') ?>',
            type: 'post',
            data: formdata,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (event) {
                    dish.parent('div').siblings('div').find('.progress').css({'display': 'block'});
                    var percentComplete = Math.round((event.loaded / event.total) * 100);
                    console.log(percentComplete);
                    dish.parent('div').siblings('div').find('.progress-bar').val(percentComplete);
                    dish.parent('div').siblings('div').find('.progress-percentage').html(percentComplete + '%');

                }, false);

                return xhr;
            },
            success: function (data) {
                if (data['isUploaded']) {
                    dish.parent('div').siblings('div').find('.input-value').val(data['imagePath']);
                }
                dish.parent('div').siblings('div').find('.image-message').html(data['message']);
            }
        });
    });

    $("form[name='business_information_settings_form']").validate({
        rules: {
            company_name: "required",
        },
        messages: {
            company_name: "Please Enter Name",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
</script>