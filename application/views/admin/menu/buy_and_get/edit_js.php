<script type="text/javascript">
	var tree4 = $("#test-select-4").treeMultiselect({
		allowBatchSelection: true,
		enableSelectAll: true,
		searchable: true,
		sortable: true,
		startCollapsed: true
	});

	$(document).on('change','#test-select-4',function(e) {
		e.preventDefault();
		var selectedValues = $(this).val();
		// alert(selectedValues);
	});

	var start = moment($('#from_date').val());
	var end = moment($('#to_date').val());

	if (start == '') {
    	start = moment();
	}

	if (end == '') {
    	end = moment();
	}
    function cb(start, end) {
        $('#validity .date-to-form input[name="start_date"]').val(start.format('YYYY-MM-DD'));
        $('#validity .date-to-form input[name="end_date"]').val(end.format('YYYY-MM-DD'));
        $('#validity span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#validity').daterangepicker({
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