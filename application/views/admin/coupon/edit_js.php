<script type="text/javascript">
    var start = moment($('#from_date').val());
    var end = moment($('#to_date').val());

    if (start == '') {
        start = moment();
    }

    if (end == '') {
        end = moment();
    }
    function cb(start, end) {
        $('#reportrange-new .date-to-form input[name="start_date"]').val(start.format('YYYY-MM-DD'));
        $('#reportrange-new .date-to-form input[name="expired_date"]').val(end.format('YYYY-MM-DD'));
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
</script>