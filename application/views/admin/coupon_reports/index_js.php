<script type="text/javascript">
    var start = "<?= $start_date ?>";
    var end = "<?= $end_date ?>";

    if (start) {
        start = moment(start);
    } else {
        start = moment().startOf('month');
    }

    if (end) {
        end = moment(end);
    } else {
        end = moment().endOf('month');
    }

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
        $('.select2').select2({
            'placeholder': "Select Coupon Code"
        });
    });

    $(document).on('click','.view-report-details',function() {
        const coupon_id = $(this).attr('coupon-id');

        $.ajax({
            url: '<?= base_url("admin/coupons/view_reports_details/") ?>',
            type: 'post',
            data: {coupon_id},
            success: function (response) {
                $('#view-modal-block').html(response.details_view_modal);
                $('.view-modal').modal('show');
            }
        });
    });
</script>