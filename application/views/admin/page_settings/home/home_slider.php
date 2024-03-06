<?php
    $company_name = get_company_name();
    $home_slider_path = './assets/images/home_slider/';
    $slider_images = directory_map($home_slider_path, 1);
?>

<div class="row">
    <?php if ($slider_images): ?>
        <?php foreach ($slider_images as $image): ?>
            <div class=" col-lg-3 col-md-3 col-sm-6 col-xs-12 gallery-border">
                <div class="form-group">
                    <a class="btn btn-sm delete-image" style="position: absolute;right: 2px;z-index: 999;background: white;color: red" title="Delete image" href="<?=$home_slider_path.$image?>">X</a>
                    <div class="deleting-image">Deleting...</div>
                    <a class="fancybox-buttons zoom thumb_zoom" data-fancybox-group="button" href="<?= base_url($home_slider_path.$image) ?>" title="<?=$company_name?>">
                        <img class="card-img-top img-thumbnail" src="<?=base_url($home_slider_path.$image)?>" alt="Card image cap">
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

