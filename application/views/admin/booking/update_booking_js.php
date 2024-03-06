<script>
    $(document).ready(function () {
        $("form[name='booking_information_save_form']").validate({
            rules: {
                title: "required",
                name: "required",
                mobile: "required",
                email: "required",
                reservation_date: "required",
            },
            messages: {
                title: "Please Select Title",
                name: "Please Enter Name",
                mobile: "Please Enter Mobile",
                email: "Please Enter Email",
                reservation_date: "Please Enter Date",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    $( "#reservation_date" ).datepicker({ dateFormat: 'dd-mm-yy' });

</script>