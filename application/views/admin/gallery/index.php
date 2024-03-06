<link type="text/css" rel="stylesheet" href="<?=base_url('assets/css/gallery.css')?>"/>
<link type="text/css" rel="stylesheet" href="<?=base_url('assets/js/fancybox/css/jquery.fancybox.css')?>"/>
<link type="text/css" rel="stylesheet" href="<?=base_url('assets/js/fancybox/css/jquery.fancybox-buttons.css')?> "/>
<link type="text/css" rel="stylesheet" href="<?=base_url('assets/js/fancybox/css/jquery.fancybox-thumbs.css')?>" />
<link type="text/css" rel="stylesheet" href="<?=base_url('assets/js/image_hover/css/imagehover.min.css')?>" />

<style type="text/css">
    .upload-gallery-image .modal-body { min-height: 200px; }
    .upload-gallery-image .browse-file-block {
        position: absolute;
        top: 50%;
        left: 50%;
        background: #fff;
        width: 80%;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    input.file {
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
        filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    }
    .gallery-border .img-thumbnail{ height: 170px; width: 100%; }
    .loader-image{
        position: absolute;
        top: 50%;
        left: 50%;
        background: #fff;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        background: transparent;
    }
    .deleting-image{
        position: absolute;
        top: 50%;
        left: 50%;
        background: #fff;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        display: none;
        z-index: 999;
        padding: 2px;
        color: #ffffff;
        background: transparent;
    }

    .upload-gallery-image-modal-body{
        position: absolute;
        top: 50%;
        left: 50%;
        background: #fff;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .selected-img-block {
        width: 135px;
        height: 100px;
        margin-right: 5px;
        margin-bottom: 5px;
        display: -webkit-inline-box;
        text-align: center;
    }
    .selected-img-block img { width: 135px; height: 100px; }
    .modal-footer { text-align: left !important; }
    .gallery-images { width: 255px; height: 200px; }
    .cancel-btn { position: absolute; top: 5px; right: 3px; z-index: 999; background: #e1e1e2; color: red; }
</style>

<?php
    $company_name = get_company_name();
    $gallery_path = './assets/images/gallery/';
    $gallery_images = directory_map($gallery_path, 1);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <?php if ($gallery_images): ?>
                    <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete all gallery images ?')" href="<?=base_url('admin/gallery_management/delete_all_gallery_images')?>">Delete All</a>
                <?php endif ?>
                <a class="btn btn-sm  btn-primary float-right" data-toggle="modal" data-target=".upload-gallery-image">Upload Image</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <?php if ($gallery_images): ?>
                <?php foreach ($gallery_images as $image): ?>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 gallery-border text-center">
                        <a class="btn btn-sm delete-image cancel-btn" title="Delete image" href="<?='assets/images/gallery/'.$image?>">X</a>
                        <div class="deleting-image">Deleting...</div>

                        <a class="fancybox-buttons zoom thumb_zoom" data-fancybox-group="button" href="<?= base_url($gallery_path.$image) ?>" title="<?=$company_name?>">
                            <img class="gallery-images" src="<?=base_url('assets/images/gallery/'.$image)?>" alt="Card image cap">
                        </a>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="modal fade upload-gallery-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                        <h5 class="modal-title" id="exampleModalLabel">Gallery image upload</h5>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <form id="gallery-image-upload" method="post" action="<?= base_url('admin/gallery_management/upload_images') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="browse-file-block">
                        <input type="file" class="form-control" name="gallery_images[]" id="gallery-images" multiple accept="image/*">
                    </div>
                    <div class="images-block"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary image-upload">Upload Image</button>
                    <span class="error">Image Format Must Be JPG, JPEG, PNG, WEBP or GIF.</span>
                </div>
            </form>
        </div>
    </div>
</div>
