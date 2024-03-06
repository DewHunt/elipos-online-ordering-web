<script>
    $(document).ready(function () {
        var category_id_id = $('#category_id').val();
        if (category_id_id > 0) {
            search_data();
        }
        $('#color').colorpicker();
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
            submitHandler: function (form) {
                search_data();
            }
        });
    });

    // get_food_type_by_parent_category_id();

    // $(document).on('change','#parent_category_id',function() {
    //     get_food_type_by_parent_category_id();
    // });

    // $(document).on('change','#food_type_id',function() {
    //     get_category_by_food_type_id();
    // });

    $(document).on('change','.category',function() {
        search_data();
    });

    function search_data () {
        $('.loader').css('display','block');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/product/search") ?>',
            data: $("#product_list_form").serializeArray(),
            success: function (data) {
                $('.table-data-block').html(data['table_data']);
                $('.loader').css('display','none');
                $('.product-tab').DataTable({
                    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]]
                });
            },
            error: function (error) {
                console.log("error occured");
            }
        })
    }
	// $('#food_type_id').change(get_category_by_food_type_id);

    function active_or_deactive(foodItemId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/product/active_or_deactive_status') ?>' ,
            data: {foodItemId:foodItemId,status:status,fieldName:fieldName},
            success: function (data) {
                var foodItemInfo = data.foodItemInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (foodItemInfo.active == 1) {
                    buttonText = 'Active';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Deactive';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }

                $('#active_or_deactive_'+foodItemId).html(buttonText);
                $('#active_or_deactive_'+foodItemId).attr('onclick','active_or_deactive('+foodItemInfo.foodItemId+','+foodItemInfo.active+',1)');
                $('#active_or_deactive_'+foodItemId).removeClass(buttonRemoveClass);
                $('#active_or_deactive_'+foodItemId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function orderable_or_unorderable(foodItemId,status,fieldName) {
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/product/active_or_deactive_status') ?>' ,
            data: {foodItemId:foodItemId,status:status,fieldName:fieldName},
            success: function (data) {
                var foodItemInfo = data.foodItemInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (foodItemInfo.orderable == 1) {
                    buttonText = 'Orderable';
                    buttonRemoveClass = 'btn-danger';
                    buttonAddClass = 'btn-success';
                } else {
                    buttonText = 'Unorderable';
                    buttonRemoveClass = 'btn-success';
                    buttonAddClass = 'btn-danger';
                }

                $('#orderable_or_unorderable_'+foodItemId).html(buttonText);
                $('#orderable_or_unorderable_'+foodItemId).attr('onclick','orderable_or_unorderable('+foodItemInfo.foodItemId+','+foodItemInfo.orderable+',2)');
                $('#orderable_or_unorderable_'+foodItemId).removeClass(buttonRemoveClass);
                $('#orderable_or_unorderable_'+foodItemId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    function highlighted_or_not_highlighted_modal(categoryId,status,fieldName,highlightColor) {
        if (status == 1) {
            highlighted_or_not_highlighted(categoryId,status,fieldName);
        } else {
            $('#highlightedColorModal').modal('show');
            $('#color').val(highlightColor);
            $('#highlight_color').attr('onclick','highlighted_or_not_highlighted('+categoryId+','+status+','+fieldName+')');
            $('#color').colorpicker();
        }
    }

    function highlighted_or_not_highlighted(foodItemId,status,fieldName) {
        if (status == 0) {
            var highlightColor = $('#color').val();
            $('#highlightedColorModal').modal('hide');
        } else {
            var highlightColor = "";
        }
        $.ajax({
            type: "POST",
            url:'<?= base_url('admin/product/active_or_deactive_status') ?>' ,
            data: {foodItemId:foodItemId,status:status,fieldName:fieldName,highlightColor:highlightColor},
            success: function (data) {
                var foodItemInfo = data.foodItemInfo;
                var buttonRemoveClass = "";
                var buttonAddClass = "";

                if (foodItemInfo.isHighlight == 1) {
                    buttonText = 'Highlighted';
                    buttonRemoveClass = 'btn-default';
                    buttonAddClass = 'btn-primary';
                } else {
                    buttonText = 'Not Highlighted';
                    buttonRemoveClass = 'btn-primary';
                    buttonAddClass = 'btn-default';
                }

                $('#highlighted_or_not_highlighted_'+foodItemId).html(buttonText);
                $('#highlighted_or_not_highlighted_'+foodItemId).attr('onclick','highlighted_or_not_highlighted_modal('+foodItemInfo.foodItemId+','+foodItemInfo.isHighlight+',3,"'+foodItemInfo.highlight_color+'")');
                $('#highlighted_or_not_highlighted_'+foodItemId).removeClass(buttonRemoveClass);
                $('#highlighted_or_not_highlighted_'+foodItemId).addClass(buttonAddClass);
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    }

    $(document).on('click','.product-list .btn-delete',function() {
	    var foodItemId = $(this).attr('data-id');
	    if(confirm("Are you sure to delete?")){
	        $.ajax({
	            type: "POST",
	            url:'<?= base_url('admin/product/delete') ?>' ,
	            data: {'id':foodItemId},
	            success: function (data) {
	                var isDeleted = data['is_deleted'];
	                if(isDeleted){
	                    $(this).closest('tr').remove();
	                }
	            },
	            error: function (error) {
	                console.log("error occured");
	            }
	        });
	    }
    });
    
    $(document).on('change','.set-unorderable',function() {
        var foodItemId=$(this).attr('data-id');
        var dish=$(this);
        var orderable=$(this).is(':checked')?0:1;
        $.ajax({
            type: "POST",
            url:'<?=base_url('admin/product/changeOrderAbleStatus')?>' ,
            data: {'id':foodItemId,'orderable':orderable},
            success: function (data) {

                var isDeleted=data['is_deleted'];
                if(isDeleted){
                    dish.closest('tr').remove();
                }
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    // var table = $('#product-table').DataTable({
    //     "paging": false
    // });

    // var order = table.order([8,'asc']).draw();
</script>