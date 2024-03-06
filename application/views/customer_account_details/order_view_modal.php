<!-- <script type="text/javascript">
    $('body').append('.order-details-modal').modal('show');
</script> -->

<style>
    /*.modal-content { border: 10px solid grey ; background: #f8f8f8; border-radius: 0; }*/
    /*.fade.show { opacity: 1; background: rgba(5, 5, 5, 0.66) }*/
</style>

<div class="modal fade order-details-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="background: #6A696F;font-size: 13px ">
                    <div  style=" ">
                        <div style="padding:2px 10px;background-color: white">
                            <?php $this->load->view('order/order_info_table',$this->data); ?>
                            <?php $this->load->view('order/order_details_table',$this->data); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>