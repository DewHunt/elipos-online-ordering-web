<script>
    $(document).ready(function () {
        // $("#category_id").select2().trigger('change');
        var category_id = $('#category_id').val();
        if (category_id > 0) {
            get_product_by_category_id();
        }

        $("#product_list_form").validate({
            rules: {
                parent_category_id: "required",
                food_type_id: "required",
                category_id: "required"
            },
            messages: {
                parent_category_id: "Please Select Parent Category Name",
                food_type_id: "Please Select Food Type",
                category_id: "Please Select Category"
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
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

    $(document).on('click','.select_all',function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $(document).on('click','.item-checkbox',function() {
        var total_checkboxes = $('.item-checkbox:checkbox').length;
        var total_checked_checkboxes = $('.item-checkbox:checkbox:checked').length;
        if (total_checkboxes == total_checked_checkboxes) {
            $(".select_all").prop("checked", true);
        } else {
            $(".select_all").prop("checked", false);
        }
    });

    $(document).on('change','#category_id',function() {
        console.log("From Category");
        get_product_by_category_id();
    });

    $(document).on('change','#product_id',function() {
        console.log('From Product');
        get_sub_product_by_product_id();
    });

    $(document).on('change','#sub_product_id',function() {
        console.log('From Sub Product');
        get_assigned_modifiers();
    });

    function get_assigned_modifiers() {
        var category_id = $('#category_id option:selected').val();
        var product_id = $('#product_id option:selected').val();
        var sub_product_id = $('#sub_product_id option:selected').val();
        if ($('.modifier_id_class').is(':checked')) {
            $('.modifier_id_class').prop('checked', false);
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/modifier/get_assigned_modifiers") ?>',
            data: {'category_id': category_id,'product_id':product_id,'sub_product_id':sub_product_id},
            dataType: "JSON",
            success: function (response) {
                console.log('get_assigned_modifiers: ',response);
                var modifiers = response.modifiers;
                var total_modifier = $('.item-checkbox:checkbox').length;
                var total_checked_modifier = modifiers.length;
                for (var i = 0; i < modifiers.length; i++) {
                    var name = modifiers[i].SideDishId;
                    $('#modifier_id_' + modifiers[i].SideDishId).prop('checked', true);
                    $('#modifier_limit_' + modifiers[i].SideDishId).val(modifiers[i].ModifierLimit);
                }
                if (total_modifier == total_checked_modifier) {
                    $(".select_all").prop("checked", true);
                } else {
                    $(".select_all").prop("checked", false);
                }
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function get_product_by_category_id() {
        var category_id = $('#category_id option:selected').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/modifier/get_product_list_by_category_id/") ?>',
            data: {category_id},
            success: function (data) {
                $(".product_id").html(data['options']);
                $('.select2').select2();
                get_sub_product_by_product_id();
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function get_sub_product_by_product_id() {
        var product_id = $('#product_id option:selected').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/modifier/get_sub_product_list_by_product_id") ?>',
            data: {product_id},
            success: function (data) {
                $(".sub_product_id").html(data['options']);
                $('.select2').select2();
                get_assigned_modifiers();
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }
</script>