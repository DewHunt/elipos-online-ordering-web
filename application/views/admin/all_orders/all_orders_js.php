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
        let screenWidth = $(window).width();
        showHideSummaryDiv(screenWidth)

    	$("#search-orders-form").submit(function (event) {
    		event.preventDefault();
    		$('.process-loader').css('display','block');
    		$('button',this).css('display','none');
    		$.post($(this).attr('action'), $(this).serialize(), function (data) {
    			$(".form-table-panel").html(data);
    			$('.process-loader').css('display','none');
    			$('#search-orders-form button').css('display','block');
                showHideSummaryDiv(screenWidth)
    		})
        });
    });

    $(window).on('resize', function(){
        var win = $(this);
        var screenWidth = win.width();
        showHideSummaryDiv(screenWidth)
    });

    function showHideSummaryDiv(screenWidth) {
        if (screenWidth <= 414) {
            $('.web-view').removeClass('show');
            $('.web-view').addClass('hide');
            $('.mobile-view').removeClass('hide');
            $('.mobile-view').addClass('show');
        } else {
            $('.web-view').removeClass('hide');
            $('.web-view').addClass('show');
            $('.mobile-view').removeClass('show');
            $('.mobile-view').addClass('hide');
        }
    }

    $(document).on('click','.view-order',function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-action');
        $.post(url, {'id': id,'is_show_btn':'true'}, function (data) {
            $('.view-modal-block').html(data);
            $('.view-modal').modal('show');
        })
    });

    $(document).on('click','.delete-order',function(event) {
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
                    $(closest_row).remove();
                }
            });
        }
    });

    $(document).on('click','#mark-as-new-order',function () {
        $(this).fadeOut();
        var id = $(this).data('id');
        $('#mark-as-new-order-loader').css('display','block');
        $('#btn-modal-close').css('display','none');
        var confirmation = confirm('Are You Sure?');

        if (confirmation) {
            $.ajax({
                url: '<?=base_url('admin/all_orders/sent_to_new_order')?>',
                type: 'post',
                data: {'id': id},
                success: function (data) {
                    var isUpdated = data['isUpdate'];
                    if(isUpdated){
                        $(this).remove();
                    }
                    $('#mark-as-new-order-loader').css('display','none');
                    $('#btn-modal-close').css('display','block');
                }
            });
        }
    });

    $(document).on('click','.btn-accept',function() {
        var data = $(this).attr('accept-data');
        $('#order-status-loader').css('display','block');
        $('.btn-accept').css('display','none');
        $('.btn-reject').css('display','none');
        $('#btn-modal-close').css('display','none');
        $.ajax({
            url: '<?= base_url('order_send_to_desktop/accept_reject_message') ?>',
            type: 'post',
            data: {data},
            dataType: 'text',
            success: function (response) {
                var from_date = $('#from_date_id').val();
                var to_date = $('#to_date_id').val();
                var order_status = $('.order-status').val();
                var order_information_id = $(this).attr('order-information-id');
                get_orders_after_update(from_date,to_date,order_status,order_information_id);

                $('#order-status-loader').css('display','none');
                $('.btn-accept').css('display','block');
                $('.btn-reject').css('display','block');
                $('#btn-modal-close').css('display','block');

                $('.view-modal').modal('hide');
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: `Order has been ${response}`,
                });
            }
        });
    });

    $(document).on('click','.btn-reject',function() {
        $('.reject-msg-modal').modal('show');
    });

    $(document).on('click','.reject-action',function() {
        $('#order-status-loader').css('display','block');
        $('.btn-accept').css('display','none');
        $('.btn-reject').css('display','none');
        $('#btn-modal-close').css('display','none');

        var reject_data = $(this).attr('reject-data');
        var reason_for_reject = $('.reason_for_reject').val();
        const reject_data_obj = JSON.parse(reject_data, function (key, value) {
            if (key == "message") {
                return reason_for_reject;
            } else {
                return value;
            }
        });
        data = JSON.stringify(reject_data_obj);
        $.ajax({
            url: '<?= base_url('order_send_to_desktop/accept_reject_message') ?>',
            type: 'post',
            data: {data},
            dataType: 'text',
            success: function (response) {
                var from_date = $('#from_date_id').val();
                var to_date = $('#to_date_id').val();
                var order_status = $('.order-status').val();
                var order_information_id = $(this).attr('order-information-id');
                get_orders_after_update(from_date,to_date,order_status,order_information_id);

                $('#order-status-loader').css('display','none');
                $('.btn-accept').css('display','block');
                $('.btn-reject').css('display','block');
                $('#btn-modal-close').css('display','block');

                $('.reject-msg-modal').modal('hide');
                $('.view-modal').modal('hide');
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: response,
                });
            }
        });
    });

    $(document).on('click','.btn-sagepay-refund',function() {
        var transaction_id = $(this).attr('transaction-id');
        var order_information_id = $(this).attr('order-information-id');
        var total_amount = $(this).attr('total-amount');
        $('#order-status-loader').css('display','block');
        $('.btn-sagepay-refund').css('display','none');
        $('#btn-modal-close').css('display','none');
        $.ajax({
            url: '<?= base_url('order/sagepay_refund_transaction') ?>',
            type: 'post',
            data: {order_information_id,transaction_id,total_amount},
            success: function (response) {
                var from_date = $('#from_date_id').val();
                var to_date = $('#to_date_id').val();
                var order_status = $('.order-status').val();
                var order_information_id = $(this).attr('order-information-id');
                get_orders_after_update(from_date,to_date,order_status,order_information_id);

                $('#order-status-loader').css('display','none');
                $('.btn-sagepay-refund').css('display','block');
                $('#btn-modal-close').css('display','block');
                $('.view-modal').modal('hide');
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: response['message'],
                });
            }
        });
    });

    function get_orders_after_update(from_date,to_date,order_status,order_information_id) {
        $.ajax({
            url: '<?= base_url('admin/all_orders/get_orders_after_update') ?>',
            type: 'post',
            data: {from_date,to_date,order_status,order_information_id},
            dataType: 'json',
            success: function (response) {
                $('.form-table-panel').html(response.all_orders_table);
            }
        });
    }
</script>