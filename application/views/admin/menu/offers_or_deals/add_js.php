<script type="text/javascript">
    $(document).on('change','#category_id',function() {
        var category_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/offers_or_deals/get_sort_order') ?>',
            data: {category_id},
            success: function (data) {
                $('#sort_order').val(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on('click','#is_half_and_half',function() {
        console.log('#is_half_and_half');
        let item_limit = document.getElementById('item_limit');
        if ($(this).is(':checked')) {
            $('#price').val(0);
            $('#item_limit').val(1);
            item_limit.setAttribute('min','1');
            item_limit.setAttribute('max','1');
        } else {
            item_limit.setAttribute('min','0');
            item_limit.removeAttribute('max');
            $('#addItemButton').attr('disabled',false);
        }
    });

    $(document).on('click','#subProductCheckAll',function() {
        console.log('#subProductCheckAll');
        if ($(this).is(':checked')) {
            $('input[name="sub_product_ids[]"]').not(this).prop('checked', true);
        } else {
            $('input[name="sub_product_ids[]"]').not(this).prop('checked', false);
        }
    });

    $(document).on('click','#productCheckAll',function() {
        console.log('#productCheckAll');
        if ($(this).is(':checked')) {
            $('input[name="product_ids[]"]').not(this).prop('checked', true);
        } else {
            $('input[name="product_ids[]"]').not(this).prop('checked', false);
        }
    });

    $(document).on('click','#addDealsFormButtonConfirm',function() {
        console.log('#addDealsFormButtonConfirm');
        dealsFormValidate();
        var isValid = $('#dealsAddForm').valid();
        if (isValid) {
            $('#dealsAddForm').submit();
        }
    });

    function dealsItemFormValidate() {
        console.log('dealsItemFormValidate()');
        $('#addItemForm').validate({
            rules: {
                item_title: "required",
                item_limit: "required",
            },
            messages: {
                item_title: "Please Enter Title",
                item_limit: "Please Enter Limit",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );
                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {
                    error.insertAfter( element);
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
            },
        });
    }

    function dealsFormValidate() {
        console.log('dealsFormValidate()');
        $('#dealsAddForm').validate({
            rules: {
                title: "required",
                categoryId: "required",
                price: "required",
                availability: "required",
            },
            messages: {
                categoryId: "Please Select Category",
                title: "Please Enter title",
                price: "Please Enter price",
                availability: "Please Enter Availability",
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
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
        });
    }

    $(document).on('click','#addItemButton',function() {
        console.log('SaveItem -> #addItemButton');
        dealsItemFormValidate();
        if ($('#addItemForm').valid()) {
            var productIds = new Array();
            var productAsModifierLimit = new Array();
            var subProductIds = new Array();
            var subProductAsModifierLimit = new Array();
            $('input[name="product_ids[]"]:checked').each(function() {
                productIds.push(this.value);
                var id = this.value;
                var inputId = "product_"+id;
                console.log("product_"+id);
                var limit = $('input[name="'+inputId+'"]').val();
                console.log(id);
                productAsModifierLimit.push({id:id,limit:limit});
            });
            $('input[name="sub_product_ids[]"]:checked').each(function() {
                subProductIds.push(this.value);
                var id = this.value;
                var inputId = "subProduct_"+id;
                var limit = $('input[name="'+inputId+'"]').val();
                subProductAsModifierLimit.push({id:id,limit:limit});
            });
            if ((productIds.length > 0 || subProductIds.length > 0)) {
                var formData = new Array();
                var item_title = $('#addItemForm input[name="item_title"]').val();
                var item_description = $('#addItemForm input[name="item_description"]').val();
                var item_limit = $('#addItemForm input[name="item_limit"]').val();
                var index_key = $('#addItemForm input[name="index_key"]').val();
                let isHalfAndHalf = $('#is_half_and_half').is(':checked');
                formData.push({name:'product_ids',value:JSON.stringify(productIds)});
                formData.push({name:'sub_product_ids',value:JSON.stringify(subProductIds)});
                formData.push({name:'productAsModifierLimit',value:JSON.stringify(productAsModifierLimit)});
                formData.push({name:'subProductAsModifierLimit',value:JSON.stringify(subProductAsModifierLimit)});
                formData.push({name:'item_title',value:item_title});
                formData.push({name:'item_description',value:item_description});
                formData.push({name:'item_limit',value:item_limit});
                formData.push({name:'index_key',value:index_key});
                formData.push({name:'is_half_and_half',value:isHalfAndHalf});
                $('input[name="sub_product_ids[]"]').prop('checked', false);
                $('input[name="product_ids[]"]').prop('checked', false);
                $.ajax({
                    type: "POST",
                    url:'<?= base_url('admin/offers_or_deals/save_item') ?>',
                    data:formData ,
                    success: function (data) {
                        let totalDealsItem = data.deals_items.length;
                        $('#deals-item-list-block').html(data.dealsItemsView);
                        if (isHalfAndHalf && totalDealsItem >= 1) {
                            $('#addItemButton').attr('disabled',true);
                        } else {
                            $('#addItemButton').attr('disabled',false);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            } else {
                alert('Please select at least one Product Or Sub product');
            }
        }
    });

    $(document).on('click','.list-item .edit-item',function() {
        console.log('Edit Item -> .list-item .edit-item');
        var index_key = $(this).attr('data-key');
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/offers_or_deals/edit_item') ?>',
            data: {index_key},
            success: function (data) {
                $('#deals-item-add-form-block').html(data['dealsItemsAddForm']);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });        

    $(document).on('click','.list-item .remove-item',function() {
        console.log('Remove Item -> .list-item .remove-item');
        var index_key = $(this).attr('data-key');
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/offers_or_deals/remove_item') ?>',
            data: {index_key},
            success: function (data) {
                $('#deals-item-list-block').html(data['dealsItemsView']);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).on('click','.remove-modifier-item',function() {
        console.log('Remove Modifier Item -> .remove-modifier-item');
        var item_id = $(this).attr('item-id');
        var item_category = $(this).attr('item-cat');
        var item_index = $(this).attr('item-index');
        console.log('item_id: ',item_id);
        console.log('item_category: ',item_category);
        console.log('item_index: ',item_index);
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/offers_or_deals/remove_modifier_item') ?>',
            data: {item_index,item_id,item_category},
            success: function (data) {
                $('#deals-item-list-block').html(data['dealsItemsView']);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>