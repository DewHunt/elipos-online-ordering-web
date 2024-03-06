<style>
    @media screen and (max-width: 414px) {
        .copyright { padding: 1em 2em; }
    }
    footer { position: absolute !important; right: 0; bottom: 0; left: 0; }
</style>

<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color error">Order Confirmation</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php //var_dump($submitted_order_details); exit; ?>
                    <?php if (!empty($submitted_order_details)): ?>
                        <div class="innercommon-right-content">
                            <div class="card">
                                <div class="card-header text-xs-center">
                                    <h5 class="mb-0">
                                        <span class="color_green">Thank you</span><?php echo ' very much for placing an order with ' ?><span class="color_green"><?= get_company_name(); ?></span>
                                    </h5>
                                </div>
                                <div class="card-block" style="padding: 0.75rem 1.25rem;">
                                    <?php if ($submitted_order_details['order_type'] == 'Collection'): ?>
                                        <p class="">Please note all times given are approximate times and actual collection time may vary day to day. Please allow a 15 minute window from time stated to collect your order. Should you need a clearer time scale please call the restaurant on <?= get_company_contact_number() ?>. </p>

                                        <p class="">You have chosen to make payment via <?= $submitted_order_details['payment_method'] ?> for your order and you should receive an email with confirmation of your order. If the email does not appear in your inbox, please check your spam or junk folder. If you still have not received it please contact <?= get_company_name() ?> on <?= get_company_contact_number() ?>.</p>
                                        <p class="">We really appreciate your business. Enjoy your meal!</p>
                                    <?php else: ?>
                                        <p class="">Please note all times given are approximate times and actual delivery time may vary day to day. Please allow a 30 minute window from time stated for your delivery. Should you need a clearer time scale please call the restaurant on <?= get_company_contact_number() ?>. </p>

                                        <p class="">You have chosen to make payment via <?= $submitted_order_details['payment_method'] ?> for your order and you should receive an email with confirmation of your order. If the email does not appear in your inbox, please check your spam or junk folder. If you still have not received it please contact <?= get_company_name() ?> on <?= get_company_contact_number() ?>.</p>

                                        <p class="">We really appreciate your business. Enjoy your meal!</p>
                                    <?php endif ?>

                                    <div class="back-to-menu-button right-side-view" style="margin-top: 1rem">
                                        <a href="<?= base_url('menu') ?>" class="continue-shopping-margin right-side-view register-tab common-submit-button checkout_creat_account">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i> BACK TO MENU</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

