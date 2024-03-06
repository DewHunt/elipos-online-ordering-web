<style>
    .table-responsive > .table-bordered { border: 1px solid #000 !important; }
    .table { background-color: #d3d3d3; }
    .table th, .table td { padding: 8px 8px 8px 8px; font-size: 12px; }
    .table th { text-align: center; }
    .nav { margin-bottom: 10px }
</style>

<div id="main-contanier">
    <ul class="nav nav-tabs" id="myTab" role="tablist" >
        <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('my_account/customer_order_list') ?>" aria-controls="profile">All Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('my_account/customer_account_details') ?>" aria-controls="profile">Profile Edit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('my_account/reset_password') ?>" aria-controls="profile">Change Password</a>
        </li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-bordered order-table-customer">
            <thead class="thead-default">
                <tr>
                    <th colspan="11"><h4>All Orders</h4></th>
                </tr>
                <tr>
                    <th rowspan="2">Sl No.</th>
                    <th>Order</th>
                    <th>Delivery</th>
                    <th rowspan="2">Order Type</th>                                            
                    <th rowspan="2">Payment Method</th>
                    <th rowspan="2">Platform</th>
                    <th rowspan="2">Order Notes</th>
                    <th rowspan="2">Reject Cause</th>
                    <th rowspan="2">Order Status</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order_information_list)): ?>
                    <?php $sl_no = count($order_information_list); ?>
                    <?php foreach ($order_information_list as $order_information): ?>
                        <?php
                            $order_status=$order_information->order_status;
                            if ($order_status == 'accept') {
                                $order_status = 'Accepted';
                            } else if ($order_status == 'reject') {
                                $order_status = 'Rejected';
                            }
                            $payment_method = $order_information->payment_method;
                            if($payment_method != 'cash'){
                                $payment_method = 'card';
                            }

                            $delivery_time = $order_information->delivery_time;
                            $delivery_time = ((strtotime($delivery_time) > 0)) ? date("h:i:s A", strtotime($order_information->delivery_time)) : 'ASAP';
                            $total = $order_information->order_total;
                        ?>
                        <tr>
                            <td class="text-center"><?=$sl_no--?></td>
                            <td class="text-center">
                                <p><?= date("d-m-Y",strtotime($order_information->order_time ))?></p>
                                <p><?= date("h:i:s A",strtotime($order_information->order_time ))?></p>
                            </td>
                            <td class="text-center"><?= $delivery_time ?></td>
                            <td class="text-center"><?= ucfirst($order_information->order_type) ?></td>
                            <td class="text-center"><?= ucfirst($payment_method) ?></td>
                            <td class="text-center"><?= ucfirst($order_information->platform) ?></td>
                            <td><?= ucfirst($order_information->notes) ?></td>
                            <td><?= ucfirst($order_information->order_comments) ?></td>
                            <td class="text-center"><?= ucfirst($order_status) ?></td>
                            <td class="text-right"><?= number_format($total, 2) ?></td>
                            <td class="text-center">
                                <button style="margin-bottom: 2px" data-id="<?=$order_information->id?>" data-action="<?= base_url("my_account/get_order") ?>" data-action-type="view"  class="btn common-submit-button view" >
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>

                                <button style="margin-bottom: 2px" data-id="<?=$order_information->id?>" data-action="<?= base_url("menu/reorder") ?>" data-action-type="re_order" data-redirect="<?= base_url('menu') ?>" class="btn common-submit-button view" data-toggle="tooltip" data-placement="top" title="Re Order">
                                    <i class="fa fa-reply-all" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<div class="view-modal-block"></div>

<div class="modal fade" id="re-order-confirm-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-xs-center" >Are You Sure to Re Order?</h6>
            </div>
            <div class="modal-body">
                <div class="float-right">
                    <button type="button" class="btn common-submit-button " data-confirm="yes" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn common-submit-button" data-confirm="no" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    view_order_details();
    function view_order_details() {
        $('.order-table-customer tr td button').click( function(event) {
            // event.preventDefault();
            var id = $(this).attr('data-id');      
            var url = $(this).attr('data-action');
            var action_type = $(this).attr('data-action-type');
            var redirect_url = $(this).attr('data-redirect');

            if (action_type == 'view') {
                $.post(url, {'id':id}, function(data) {
                    $('.view-modal-block').html(data);
                    $('.order-details-modal').modal('show');
                    $('.modal-backdrop').css('display','none');
                });
            } else {
                $('#re-order-confirm-modal').modal('show');
                $('.modal-backdrop').css('display','none');
                $('#re-order-confirm-modal button').click(function(event){
                    event.preventDefault();
                    var confirmation = $(this).attr('data-confirm');
                    if(confirmation == 'yes'){
                        $.ajax({
                            type: "POST",
                            url: url,
                            data:{'id':id},
                            success: function (response) {
                                if(response.status === true){
                                    document.location.href = response.redirect;
                                }
                            },
                            error:function(error){
                                console.log("error occured");
                            }
                        });
                    }
                });
            }
        });
        // return false;
    }

    // get_re_order_confirmation();
    // function  get_re_order_confirmation(){
    //     $('#re-order-confirm-modal').on('shown.bs.modal', function (event) { event.preventDefault(); });
    //     return false;
    // }
</script>