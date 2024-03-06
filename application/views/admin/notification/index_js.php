<script type="text/javascript">
    var start = moment();
    var end = moment();
    function cb(start, end) {
        $('#reportrange-new .date-to-form input[name="to_date"]').val(end.format('YYYY-MM-DD'));
        $('#reportrange-new .date-to-form input[name="from_date"]').val(start.format('YYYY-MM-DD'));
        $('#reportrange-new span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange-new').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);

    $(document).ready(function () {
        $("#search-orders-form").submit(function (event) {
            event.preventDefault();
            $.post($(this).attr('action'), $(this).serialize(), function (data) {
                $(".form-table-panel").html(data);
                view_order_details();
            })
        });

        view_order_details();
    });

    $(document).on('click','.addNotificationFrom',function() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/customer_notifications/add/") ?>',
            data: {},
            success: function (data) {
                //alert(data);
                $(".add_edit_from_div").html(data.output);
                $('#addEditNotification').modal('show');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $(document).on('click','.editNotificationForm',function() {
        var notification_id = $(this).attr('notification-id');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/customer_notifications/edit/") ?>',
            data: {notification_id},
            success: function (data) {
                //alert(data);
                $('#title-text').html('Edit');
                $(".add_edit_from_div").html(data.output);
                count_strings_and_characters();
                $('#addEditNotification').modal('show');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    function view_order_details() {
        $('.order-table-admin table tr td .view-order').click(function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-action');
            $.post(url, {'id': id}, function (data) {
                $('.view-modal-block').html(data);
                $('.view-modal').modal('show')
            })
        });
        return false;
    }

    $(document).on('click','.delete-notification',function() {
        event.preventDefault();
        var url = $(this).attr('href');
        var closest_row = $(this).closest('tr');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {},
                    success: function (data) {
                        if (data.is_deleted) {
                            $(closest_row).remove();
                            $('.deleted-notification-table-div').html(data.deleted_notification_table);
                            Swal.fire('Deleted!','Your file has been deleted.','success')
                        } else {
                            Swal.fire('Delete Faild!','Your file has not been deleted.','error')
                        }
                    }
                });
            }
        })
    });

    $(document).on('click','.recover-notification',function() {
        event.preventDefault();
        var url = $(this).attr('href');
        var closest_row = $(this).closest('tr');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, recover it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {},
                    success: function (data) {
                        if (data.is_recover) {
                            $(closest_row).remove();
                            $('.draft-notification-table-div').html(data.draft_notification_table);
                            $('.sent-notification-table-div').html(data.sent_notification_table);
                            Swal.fire('Recoverd!','Your file has been recovered.','success')
                        } else {
                            Swal.fire('Recover Faild!','Your file has not been recovered.','error')
                        }
                    }
                });
            }
        })
    });

    $(document).ready(function () {
        $("form[name='customer_notification_save_form']").validate({
            rules: {
                title: "required",
                message: "required",
                expired_date: "required",
            },
            messages: {
            },

            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );

                if ( (element.prop( "type" ) === "checkbox") ) {
                    error.insertAfter( element.parent( "div" ) );
                } else if(element.prop( "type" ) === "radio"){
                    error.insertAfter( element.parent().nextAll().last( "div" ) );
                }else {
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

    $(document).on('keyup propertychange paste','textarea',function() {
        count_strings_and_characters();
    });

    function count_strings_and_characters() {
        var txt_val = $('textarea').val();
        var words = txt_val.trim().replace(/\s+/gi, ' ').split(' ').length;
        var chars = txt_val.length;
        if (chars === 0) { words = 0; }
        $('#title').html('Dew Hunt');
        $('#counter').html(words+' words and '+chars+' characters');
    }

    $(document).on('click','.show-notification',function() {
        var id = $(this).attr('data-id');
        var message = $(this).attr('data-message');
        var title = $(this).attr('data-title');
        $('#sent-notification-modal').modal('show');
        $('#sent-notification-modal #notification-id').val(id);
        $('#sent-notification-modal .modal-body .title').text(title);
        $('#sent-notification-modal .modal-body .message').text(message);
    });

    $(document).on('click','#sent-notification-button',function() {
       var notification_id = $('#sent-notification-modal #notification-id').val();

       $(this).css("display","none");
        $('#sent-notification-loader').css("display","block");
        $.ajax({
            type: "POST",
            url: '<?= base_url('admin/customer_notifications/sent_to_firebase') ?>',
            data: {id:notification_id},
            success: function (data) {
                var is_sent = data['is_sent'];
                $('#sent-notification-modal .message-report').css("display","block");
                if (is_sent) {
                    var total_sent = data['total_sent'];
                    var total_failed = data['total_failed'];
                    $('#sent-notification-modal .message-report #sent-amount').text(total_sent);
                    $('#sent-notification-modal .message-report #failed-amount').text(total_failed);
                } else {
                    $('#sent-notification-modal .message-report').html('<h4 class="error">Notification not sent.Try Again.</h4>');
                    $('#sent-notification-btn-div').css("display","block");
                }
                $('#sent-notification-loader').css("display","none");
                $('.draft-notification-table-div').html(data.draft_notification_table);
                $('.sent-notification-table-div').html(data.sent_notification_table);
                // $('#sent-notification-modal').on('hidden.bs.modal', function () {
                //     window.location.replace('<?=base_url('admin/customer_notifications')?>');
                // });
            },
            error:function(error){
                console.log("error occured");
                $('#sent-notification-loader').css("display","none");
            }
        }).always(function() {
            $('#sent-notification-loader').css("display","none");
        });
    });
</script>