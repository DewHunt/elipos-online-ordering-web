<link type="text/css" rel="stylesheet" href="<?= base_url('assets/js/fancybox/css/jquery.fancybox.css' )?>"/>
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/js/fancybox/css/jquery.fancybox-buttons.css') ?> "/>
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/js/fancybox/css/jquery.fancybox-thumbs.css') ?>" />
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/js/image_hover/css/imagehover.min.css') ?>" />
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/gallery.css') ?>" />
<style>
    .gallery-border img { width: 100%; }
</style>

<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content ">
                <h1 class="text-color">Gallery</h1>
                <?php
                    $this->load->helper('directory');
                    $company_name = get_company_name();
                    $gallery_path = './assets/images/gallery/';
                    $gallery_images = directory_map($gallery_path, 1);
                ?>

                <div class="clearfix"></div>
                <section id="">
                    <div class="row">
                        <?php if ($gallery_images): ?>
                            <?php foreach ($gallery_images as $image): ?>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-xs-6 gallery-border">
                                    <a class="fancybox-buttons zoom thumb_zoom" data-fancybox-group="button" href="<?= base_url($gallery_path.$image) ?>" title="<?=$company_name?>">
                                        <img src="<?= base_url($gallery_path.$image); ?>" class="img-fluid gallery-style" alt="Image">
                                    </a>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/js/holder/js/holder.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/fancybox/js/jquery.mousewheel-3.0.6.pack.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/fancybox/js/jquery.fancybox.pack.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/fancybox/js/jquery.fancybox-buttons.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/fancybox/js/jquery.fancybox-thumbs.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/fancybox/js/jquery.fancybox-media.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/gallery.js') ?>"></script>