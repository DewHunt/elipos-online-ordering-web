<?php
    $isBackgroundImageShow = property_exists($home_page, 'isBackgroundImageShow') ? $home_page->isBackgroundImageShow : '';
    $isTopImageShow = property_exists($home_page, 'isTopImageShow') ? $home_page->isTopImageShow : '';
    $isLogoImageShow = property_exists($home_page, 'isLogoImageShow') ? $home_page->isLogoImageShow : '';
    $isSliderShow = property_exists($home_page, 'isSliderShow') ? $home_page->isSliderShow : '';
    $isMenuButtonShow = property_exists($home_page, 'isMenuButtonShow') ? $home_page->isMenuButtonShow : '';
    $isHomeImageIconShow = property_exists($home_page, 'isHomeImageIconShow') ? $home_page->isHomeImageIconShow : '';
    $isChevronIcon = property_exists($home_page, 'isChevronIcon') ? $home_page->isChevronIcon : '';
    $homeIconImageSide = property_exists($home_page, 'homeIconImageSide') ? $home_page->homeIconImageSide : '';
    $backgroundColor = property_exists($home_page, 'backgroundColor') ? $home_page->backgroundColor : '';
?>

<style type="text/css">
    img { width: 100%; height: 150px; border: 1px solid #e1e1e1; }
    .upload-btn { margin-top: 25px; }
    .up-del-btn { margin-top: 5px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>
</div>

<?php if (get_flash_message()): ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?= get_flash_message(); ?></strong>
    </div>
<?php endif ?>

<form id="menu_form" name="menu_form" action="<?= base_url('admin/app_settings/save_home_page') ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8"><h4>All Permissions</h4></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><button class="btn btn-success">Save</button></div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="checkbox-inline">
                            <input type="hidden" name="isBackgroundImageShow" value="0">
                            <input type="checkbox" id="show-back-img" name="isBackgroundImageShow" value="1" <?= $isBackgroundImageShow ? 'checked' : '' ?>><b>Show background image</b>
                        </label>

                        <label class="checkbox-inline">
                            <input type="hidden" name="isTopImageShow" value="0">
                            <input type="checkbox" name="isTopImageShow" value="1" <?= $isTopImageShow ? 'checked' : '' ?>><b>Show top image</b>
                        </label>

                        <label class="checkbox-inline">
                            <input type="hidden" name="isLogoImageShow" value="0">
                            <input type="checkbox" name="isLogoImageShow" value="1" <?= $isLogoImageShow ? 'checked' : '' ?>><b>Show logo image</b>
                        </label>
                        
                        <label class="checkbox-inline">
                            <input type="hidden" name="isSliderShow" value="0">
                            <input type="checkbox" name="isSliderShow" value="1" <?= $isSliderShow ? 'checked' : '' ?>><b>Show slider</b>
                        </label>
                        
                        <label class="checkbox-inline">
                            <input type="hidden" name="isMenuButtonShow" value="0">
                            <input type="checkbox" name="isMenuButtonShow" value="1" <?= $isMenuButtonShow ? 'checked' : '' ?>><b>Show menu button</b>
                        </label>
                        
                        <label class="checkbox-inline">
                            <input type="hidden" name="isHomeImageIconShow" value="0">
                            <input type="checkbox" name="isHomeImageIconShow" value="1" <?= $isHomeImageIconShow ? 'checked' : '' ?>><b>Show image icon in button</b>
                        </label>

                        <label class="checkbox-inline">
                            <input type="hidden" name="isChevronIcon" value="0">
                            <input type="checkbox" name="isChevronIcon" value="1" <?= $isChevronIcon ? 'checked' : '' ?>><b>Show chevron icon in button</b>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label for="home-icon-image-side">Image icon side in button: </label>
                    <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="homeIconImageSide" value="left" <?= $homeIconImageSide == 'left' ? 'checked' : '' ?>>Left
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="homeIconImageSide" value="right" <?= $homeIconImageSide == 'right' ? 'checked' : '' ?>>Right
                        </label>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="background-color">Home page background color</label>
                        <input type="text" class="form-control" id="back-color" name="backgroundColor" db-val="<?= $backgroundColor ?>" value="<?= $backgroundColor ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" name="upload_img_form" action="<?= base_url('admin/app_settings/upload_image') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="logo-image">Background Image</label>
                                <input type="file" class="form-control" name="backgroundImage">
                                <input type="hidden" class="form-control" name="currentImage" value="<?= $background_image; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="<?= $background_image ? $background_image : $no_img ?>" class="background-img">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <button class="btn btn-success btn-sm btn-block up-del-btn">Upload</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="btn btn-danger btn-sm btn-block up-del-btn img-del-btn" del-for="background-img" img-path="<?= $background_image; ?>">Delete</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" name="upload_img_form" action="<?= base_url('admin/app_settings/upload_image') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="top-image">Top Image</label>
                                <input type="file" class="form-control" name="topImage">
                                <input type="hidden" class="form-control" name="currentImage" value="<?= $top_image; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="<?= $top_image ? $top_image : $no_img ?>" class="top-img">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <button class="btn btn-success btn-sm btn-block up-del-btn">Upload</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="btn btn-danger btn-sm btn-block up-del-btn img-del-btn" del-for="top-img" img-path="<?= $top_image; ?>">Delete</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" name="upload_img_form" action="<?= base_url('admin/app_settings/upload_image') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="logo-image">Logo Image</label>
                                <input type="file" class="form-control" name="logoImage">
                                <input type="hidden" class="form-control" name="currentImage" value="<?= $logo_image; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="<?= $logo_image ? $logo_image : $no_img; ?>" class="logo-img">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <button class="btn btn-success btn-sm btn-block up-del-btn">Upload</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="btn btn-danger btn-sm btn-block up-del-btn img-del-btn" del-for="logo-img" img-path="<?= $logo_image; ?>">Delete</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" name="upload_img_form" action="<?= base_url('admin/app_settings/upload_image') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <div class="form-group">
                                <label for="slider-image">Slider Images</label>
                                <input type="file" class="form-control" name="sliderImages[]" multiple>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-success btn-sm btn-block upload-btn slider-image-btn">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="slider-image-lists">
                    <?php $this->load->view('admin/app_settings/pages/home/slider_image_lists'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post" name="upload_img_form" action="<?= base_url('admin/app_settings/upload_image') ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <div class="form-group">
                                <label for="notification-image">Notification Images</label>
                                <input type="file" class="form-control" name="notificationImages[]" multiple>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-success btn-sm btn-block upload-btn notification-image-btn">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="notification-image-lists">
                    <?php $this->load->view('admin/app_settings/pages/home/notification_image_lists'); ?>
                </div>
            </div>
        </div>
    </div>
</div>