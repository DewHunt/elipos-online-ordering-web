<style>
    @media screen and (max-width: 414px) {
        .copyright { padding: 1em 2em; position: absolute; }
    }
    footer { position: absolute !important; right: 0; bottom: 0; left: 0; }
</style>
<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color">Order Confirmation</h1>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    if (!empty($submitted_order_details)) {
                        ?>
                        <div class="innercommon-right-content">
                            <div class="card">
                                <div class="card-header text-xs-center">
                                    <h5 class="mb-0"><span class="color_green">Thank you</span><?php echo ' for trying to place order with  ' ?><span class="color_green"><?= get_company_name(); ?></span></h5>
                                </div>
                                <div class="card-block">
                                    <label class="error">We  couldn't place you order <?= $submitted_order_details['message'] ?> </label>

                                    <div class="back-to-menu-button right-side-view" style="margin-top: 1rem">
                                        <a href="<?= base_url('menu') ?>" class="continue-shopping-margin right-side-view register-tab common-submit-button checkout_creat_account">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i> BACK TO MENU</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>

