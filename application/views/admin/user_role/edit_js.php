<script type="text/javascript">
	$(document).ready(function() {		
        $("form[name='user-role-form']").validate({
            rules: {
                name: "required",
                role: "required",
            },
            messages: {
                name: "Please Enter User Role Name",
                role: "Please Enter Role ID",
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
</script>