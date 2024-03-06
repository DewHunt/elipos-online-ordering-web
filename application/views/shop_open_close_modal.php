

<div class="modal fade" id="discount-show-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #191919; color: #FFFFFF;">
                <h4 class="modal-title" style="padding-top:15px;"> Allergens & intolerance</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff;">×</button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class=""  style="padding: 10px">
                        <h6><i class="fa fa-info-circle" aria-hidden="true" ></i> Allergens & intolerance</h6>
                        <p>Many of our dishes contain the following allergens. Please ask about your meal when ordering & we will be happy to advise you. celery, eggs, nuts, mustard, gluten, fish, molluscs, crustaceans,
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color: #191919; color: #FFFFFF;">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if (is_shop_maintenance_mode()): ?>
    <?php
        $maintenance_mode_settings = get_maintenance_mode_settings_value();
        $message = array_key_exists('message',$maintenance_mode_settings) ? $maintenance_mode_settings['message'] : '';
        $image = array_key_exists('image',$maintenance_mode_settings) ? $maintenance_mode_settings['image'] : '';
        if (empty($image)) {
            $image = 'assets/images/maintenance_mode.jpg';
        }
    ?>
    <div class="modal fade" id="shop_open_close_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="float-right">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-xs-center">
                    <img class="rounded img-responsive" style="height: 15rem; width: 100%" src="<?= base_url($image) ?>">
                </div>
                <div class="alert " role="alert">
                    <strong><?= $message ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php if (is_shop_closed() && !is_pre_order() && !is_shop_weekend_off()): ?>
        <div class="modal fade" id="shop_open_close_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="float-right">
                        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body text-xs-center">
                        <img class="rounded img-responsive" style="height: 15rem;width: 100%" src="<?=base_url('assets/images/sorry-were-closed1.jpg')?>">
                    </div>

                    <div class="row" style="margin-bottom: 10px;padding-right: 15px;padding-left: 15px">
                        <div class="col-md-6 col-xs-12">
                            <button type="button" class="btn btn-pre-order-common btn-no-pre-order" data-dismiss="modal" aria-label="Close">
                                No Thanks
                            </button>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <button type="button" class="btn btn-pre-order-common btn-pre-order" data-dismiss="modal" aria-label="Close">Pre-Order</button>
                        </div>
                    </div>

                    <div class="card" style="padding: .5rem;background: #323232;color: #ffffff;border: none;;border-radius: 0">
                        <h4 class="text-center card-header" style="background: #323232;color: #ffffff;"> Our Opening & Closing Hours</h4>
                        <?php $this->load->view('shop_timing_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif(is_shop_weekend_off()): ?>
        <div class="modal fade" id="shop_open_close_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="float-right">
                        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body text-xs-center">
                        <img class="rounded img-responsive" style="height: 15rem;width: 100%" src="<?=base_url('assets/images/sorry-were-closed1.jpg')?>">
                    </div>

                    <div class="card" style="padding: .5rem;background: #323232;color: #ffffff;border: none;;border-radius: 0">
                        <h4 class="text-center card-header" style="background: #323232;color: #ffffff;"> Our Opening & Closing Hours</h4>
                        <?php $this->load->view('shop_timing_list'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endif ?>

<script type="text/javascript">
    $('#discount-show-modal').modal('show');
    $('#shop_open_close_modal').modal('show');
   
    $('.modal-backdrop').hide();
        $('#shop_open_close_modal .btn-pre-order').click(function(){
            $.ajax({
                type: "POST",
                url: '<?= base_url('menu/set_pre_order') ?>',
                data: {'pre_order': true},
                success: function (data) {
                window.location.reload('<?=base_url('menu')?>');
                },
                error: function (error) {
                console.log("error occured");
            }
        });
    });
</script>   