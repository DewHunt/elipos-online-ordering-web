<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color error">Order Error</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="innercommon-right-content">
                        <div class="card">
                            <div class="card-header text-xs-center">
                                <h5 class="mb-0"><span class="color_green">Thank you</span><?php echo ' very much to try for placing an order with ' ?><span class="color_green"><?= get_company_name(); ?></span> </h5>
                                <h4 style="color: red">We can not place your order due to server error</h4>
                            </div>
                            <div class="card-block">
                                <p class="">Please contact to <?=get_company_name()?>.</p>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Order id</th>
                                        <td><?=$card_order->nochex_order_id?></td>
                                    </tr>

                                </table>

                                <div class="back-to-menu-button right-side-view" style="margin-top: 1rem">
                                    <a href="<?= base_url('menu') ?>" class="continue-shopping-margin right-side-view register-tab common-submit-button checkout_creat_account">
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i> BACK TO MENU</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
