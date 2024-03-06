<script>    
    $(document).ready(function () {
        $('.modifier-category').select2({ 'placeholder': 'Select Modifier Categories' });
        $("form[name='modifier_save_form']").validate({
            rules: {
                modifier_name: "required",
                ModifierCategoryId: "required",
                menu_price: "required",
                unit: "required",
                vat_rate: "required",
                sort_order: "required",
            },
            messages: {
                modifier_name: "Please Enter Name",
                ModifierCategoryId: "Please select modifier category",
                menu_price: "Please Enter Price",
                unit: "Please Select Unit",
                vat_rate: "Please Enter Vat Rate",
                sort_order: "Please Enter Sort Order",
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    } else if ( (element.prop( "type" ) === "checkbox") ) {
                    error.insertAfter( element.parent( "div" ) );
                } else if(element.prop( "type" ) === "radio"){
                    error.insertAfter( element.parent().nextAll().last( "div" ) );
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    $(document).on('click','.show-modifier-list',function() {
        var modifier_category_id = $('.modifier-category').val();
        $.ajax({
            url: '<?= base_url('admin/modifier/show_modifier_by_modifier_category') ?>',
            type: 'post',
            data: {modifier_category_id},
            success: function (response) {
                let output = response.output;
                let modifier_form_div = response.modifier_form_div;
                if (modifier_form_div != "") {
                    $('.modifier-form-div').html(modifier_form_div);
                }
                $('.modifier-list-div').html(output);
                $('.modifier-category').select2({ 'placeholder': 'Select Modifier Categories' });
                $('#modifier-table').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
            }
        });
    });

    $(document).on('change','.mod-category',function() {
        let modifier_category_id = $(this).val();
        $.ajax({
            url: '<?= base_url('admin/modifier/get_sort_order') ?>',
            type: 'post',
            data: {modifier_category_id},
            success: function (response) {
                $('.sort-order').val(response);
            }
        });
    });
</script>