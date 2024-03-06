<script type="text/javascript">
    CKEDITOR.editorConfig = function(config) {
        config.allowedContent = true;
    };

    <?php if ($page_details->name != 'contact_us'): ?>
        CKEDITOR.replace('content');
    <?php endif ?>

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#logoImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('input[type=file]').on('click', function () {
        $('.progress').css({'display': 'none'});
    });

    $('input[type=file]').change(function () {
        var dish = $(this);
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logoImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(dish[0].files[0]);
    });
</script>