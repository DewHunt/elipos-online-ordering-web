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
    $("#dashboard-date-select-form").submit(function (event) {
        event.preventDefault();
        $('.process-loader').css('display','block');

        $('.last-n-days-order-graph-block').css('display','none');
        $('.top-five-products').css('display','none');
        $('.latest-order-block').css('display','none');
        $('.top-customer-block').css('display','none');
        $('.account-summery-block').css('display','none');
        $.post($(this).attr('action'), $(this).serialize(), function (data) {
            $('.process-loader').css('display','none');
            $('.last-n-days-order-graph-block').css('display','block');

            $('.last-n-days-order-graph-block').html(data['last_n_days_order']);


            $('.top-five-products').html(data['to_five_product']);
            $('.top-five-products').css('display','block');

            $('.latest-order-block').html(data['latest_order']);
            $('.latest-order-block').css('display','block');

            $('.top-customer-block').html(data['top_customer']);
            $('.top-customer-block').css('display','block');

            $('.account-summery-block').html(data['account_summary']);
            $('.account-summery-block').css('display','block');
        });
    });
</script>