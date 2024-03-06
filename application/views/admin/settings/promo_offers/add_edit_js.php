<script type="text/javascript">  
    var start = "<?= $start_date ?>";
    var end = "<?= $end_date ?>";

    if (start) {
        start = moment(start);
    } else {
        start = moment();
    }

    if (end) {
        end = moment(end);
    } else {
        end = moment();
    }
    show_daterange(start,end);

    function set_date(start, end) {
        $('#daterange-div .date-input-div input[name="start_date"]').val(start.format('YYYY-MM-DD'));
        $('#daterange-div .date-input-div input[name="end_date"]').val(end.format('YYYY-MM-DD'));
        $('#daterange-div span').html(start.format('MMMM D, YYYY')+' - '+end.format('MMMM D, YYYY'));
    }

    function show_daterange(start,end) {
        console.log('Start Date',start);
        console.log('End Date',end);
        $('#daterange-div').daterangepicker({
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
        }, set_date);
        set_date(start, end);
    }
</script>