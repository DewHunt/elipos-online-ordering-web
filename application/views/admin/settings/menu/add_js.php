<script type="text/javascript">
	$(document).ready(function() {		
        $("form[name='menu_form']").validate({
            rules: {
                menu_name: "required",
            },
            messages: {
                menu_name: "Please Enter Menu Name",
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );
                if (element.prop( "type" ) === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
	});

    $(document).on('change','#parent-menu-id',function(){
        var parent_menu_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/menu/max_order') ?>",
            data:{parent_menu_id},
            success: function(response) {
                $('#order-by').val(response.order_by);
            },
        });
    });
</script>