<script type="text/javascript">
    var start = "<?= $from_date ?>";
    var end = "<?= $to_date ?>";

    if (start) {
        start = moment(start);
    } else {
        start = moment().startOf('month');
    }

    if (end) {
        end = moment(end);
    } else {
        end = moment().endOf(end);
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

    $(document).ready(function() {
        $('.category').select2({ placeholder: "Select Category" })
        $('.product').select2({ placeholder: "Select Products" })
    });

    $('.item-report').DataTable({
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "footerCallback": function(tfoot,data,start,end,display ) {
            var api = this.api();
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
            };
            // var qtyTotal = api.column(3).data().reduce(function (a,b) { return intVal(a) + intVal(b); },0);
            var amtTotal = api.column(4).data().reduce(function (a,b) { return intVal(a) + intVal(b); },0);
            // $(tfoot).find('th').eq(1).html(qtyTotal.toFixed(2));
            $(tfoot).find('th').eq(1).html(amtTotal.toFixed(2));
        },
    });

    $(document).on('change','.category',function() {
        var category_id = $(this).val();
        $.ajax({
            url: '<?= base_url('admin/sell_items_report/get_products_by_category_id') ?>',
            type: 'post',
            data: {category_id},
            success: function (response) {
                var output = response.output;
                $('.product-div').html(output);
                $('.product').select2({ placeholder: "Select Products" });
            }
        });
    });
</script>