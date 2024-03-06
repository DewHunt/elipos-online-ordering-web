<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color error">Payment Confirmation</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="innercommon-right-content">
                        <div class="card">
                            <div class="card-header text-xs-center">
                                <h5 class="mb-0"><span class="color_green">Thank you</span><?php echo ' very much to try for placing an order with ' ?><span class="color_green"><?= get_company_name(); ?></span> </h5>
                                <h4 style="color: red">Your could not complete your order due to payment authorization</h4>
                            </div>
                            <div class="card-block">
                                <p class="">Please contact to <?=get_company_name()?>.</p>

                                <?php
                                if(!empty($card_order->nochex_order_id)){
                                    ?>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Order id</th>
                                            <td><?=$card_order->nochex_order_id?></td>
                                        </tr>
                                    </table>
                                    <p class=""> You have chosen to make the payment on card of your order and you should receive an email with confirmation of your order. If the email does not appear in your Inbox, please check your Spam or Junk folder. If you still have not received it please contact your <?= get_company_name() ?>.
                                        We really appreciate your business.</p>
                                <?php
                                }
                                ?>


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
