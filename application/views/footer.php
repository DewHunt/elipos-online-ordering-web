<br>
<footer>
    <div class="copyright">
        <div class="copyrightbottom">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 footer-1">
                    <ul>
                        <?php if (get_footer_content_status('privacy_policy')): ?>
                            <li class="list-inline-item"><a class="text-xs-center" href="<?= base_url('privacy_policy'); ?>">Privacy Policy</a></li>
                        <?php endif ?>

                        <?php if (get_footer_content_status('terms_and_conditions')): ?>
                            <li class="list-inline-item"><a class="social-icon text-xs-center" href="<?= base_url('terms_and_conditions'); ?>">Terms & Conditions</a></li>
                        <?php endif ?>

                        <?php if (get_footer_content_status('return_and_refund_policy')): ?>
                            <li class="list-inline-item"><a class="social-icon text-xs-center" href="<?= base_url('return_and_refund_policy'); ?>">Return & Refund Policy</a></li>
                        <?php endif ?>
                    </ul>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 copyrighttop">
                    <ul>
                        <li><h4>Follow us on:</h4></li>
                        <!-- <li><a target="_blank" class="facebook" href="<?= get_facebook_url(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li> -->
                        <!-- <li><a target="_blank" class="facebook" href="<?= get_instagram_url(); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li> -->
                        <?php
                            $social_medias = get_social_media_details();
                            $facebook = get_property_value('facebook', $social_medias);
                            $tripadvisor = get_property_value('tripadvisor', $social_medias);
                            $instagram = get_property_value('instagram', $social_medias);
                            $youtube = get_property_value('youtube', $social_medias);
                            $twitter= get_property_value('twitter', $social_medias);
                            $google= get_property_value('googlePlus', $social_medias);
                        ?>

                        <?php if (!empty($facebook)): ?>
                            <li><a target="_blank" class="facebook" href="<?= $facebook ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <?php endif ?>

                        <?php if (!empty($tripadvisor)): ?>
                            <li><a target="_blank" class="facebook" href="<?= $tripadvisor ?>"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a></li>
                        <?php endif ?>

                        <?php if (!empty($instagram)): ?>
                            <li><a target="_blank" class="facebook" href="<?= $instagram ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <?php endif ?>

                        <?php if (!empty($twitter)): ?>
                            <li><a target="_blank" class="facebook" href="<?= $twitter ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <?php endif ?>

                        <?php if (!empty($google)): ?>
                            <li><a target="_blank" class="facebook" href="<?= $google ?>"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"><?= design_develop_by() ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</footer>