<script>
    $(document).ready(function () {
        $("form[name='user_profile_update_form']").validate({
            rules: {
                full_name: "required",
                user_name: "required",
                user_role: "required",
                email: {required: true,email: true,},
                password: {required: true,minlength: 5,},
                confirm_password: {required: true,minlength: 5,equalTo: '#password',}
            },
            messages: {
                //name: "Please Enter Name",
                full_name: "Please Enter Name",
                user_name: "Please Enter User Name",
                user_role: "Please Select User type",
                email: {
                    required: "Please Enter Email Address",
                    email: "Enter a Valid Email Address",
                },
                password: {
                    required: "Please Enter a password",
                    minlength: "Password must be at least 5 characters long",
                },
                confirm_password: {
                    required: "Please Enter a confirm password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Password doest not match",
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>