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
            'Next 7 Days': [moment(), moment().add(6, 'days')],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Next 30 Days': [moment(), moment().add(29, 'days')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
        }
    }, cb);
    cb(start, end);

    $("#search-booking-form").submit(function (event) {
        $('.process-loader').css('display','block');
        $('button',this).css('display','none');
        // $('.table-block').removeClass('animated  zoomIn');

        event.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function (data) {
            $('.table-block').html(data['table_data']);
            $('.process-loader').css('display','none');
            $('#search-booking-form button').css('display','block');
            $('.booking-table-data').DataTable({
                "bSort": false,
                "lengthMenu": [[500, 1000, 2000, 5000,-1], [500, 1000, 2000, 5000,"All"]]
            });
            delete_table_row();
        })
    });

    delete_table_row();
    function delete_table_row() {
        $('.table tr td .delete').click(function (event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-action');
            var dish = $(this);
            var closest_row = $(this).closest('tr');
            var confirmation = confirm('Are You Sure?');

            if (confirmation) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {'id': id},
                    success: function (data) {
                        if (data['is_deleted']) {
                            $(closest_row).remove();
                        }
                    }
                });
            }
        });
    }

    $(document).on('click','.btn-view',function() {
        var booking = $(this).closest('tr').attr('data-details');
        var booking_id = $(this).attr('data-id');
        if(typeof booking != 'undefined'){
            $.ajax({
                url: "<?= base_url('admin/booking_customer/view') ?>",
                type: 'post',
                data: {booking,booking_id},
                success: function (data) {
                    $('.view-data').html(data['content']);
                    $('.booking-view-modal').modal('show');
                }
            });
        }
    });

    $(document).on('click','.btn-accept',function() {
        var booking_id = $(this).attr('booking-id');
        if(typeof booking_id != 'undefined'){
            $.ajax({
                url: "<?= base_url('admin/booking_customer/accept_booking') ?>",
                type: 'post',
                data: {booking_id},
                success: function (data) {
                    $('.view-data').html(data['content']);
                    $('.booking-view-modal').modal('show');
                }
            });
        }
    });

    $(document).on('click','.btn-reject',function() {
        var booking_id = $(this).attr('booking-id');
        if(typeof booking_id != 'undefined'){
            $.ajax({
                url: "<?= base_url('admin/booking_customer/reject_booking') ?>",
                type: 'post',
                data: {booking_id},
                success: function (data) {
                    $('.view-data').html(data['content']);
                    $('.booking-view-modal').modal('show');
                }
            });
        }
    });

    function printBooking() {
        var divToPrint = $('.print-block').html();
        var newWin = window.open('','Booking');
        // newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');
        newWin.document.close();
    }
</script>