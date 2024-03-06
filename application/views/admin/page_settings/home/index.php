<style type="text/css">
    .upload-image .modal-body { min-height: 200px; }
    .upload-image .browse-file-block {
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
    input.file {
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
        filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    }
    .gallery-border .img-thumbnail { height: 170px; width: 100%; }
    .loader-image {
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
    .deleting-image {
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
    .deleting-image2 {
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
    .upload-image-modal-body {
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
    .page_heading { margin: -35px 0 10px 0; padding: 0 0 0 0; font-size: 42px; color: #000000; font-weight: normal; text-align: center; width: 100%; height: auto; font-family: 'Oswald', Arial, sans-serif; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group"><h2 class="">Home Slider</h2></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <a class="btn btn-sm  btn-primary float-right" style="float: right" data-toggle="modal" data-target="#banner-image">Upload Slider Images</a>                
                </div>
            </div>            
        </div>
        <?php $this->load->view('admin/page_settings/home/home_slider'); ?>

                <?php $this->load->view('admin/page_settings/home/well_come'); ?>
        <!-- <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
        </div> -->

                    <?php $this->load->view('admin/page_settings/home/app_block'); ?>
        <!-- <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                </div>
            </div>
        </div> -->
    </div>
</div>

<div class="modal fade upload-images" id="banner-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Banner image upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="banner-image-upload"  action="<?=base_url('admin/page_management/upload_banner_images')?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="browse-file-block">
                        <div class="col-sm-3 col-xs-12">

                            <input type="file" name="banner_images[]" id="banner-images" multiple accept="image/*">
                        </div>


                    </div>
                    <div class="images-block">

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-6 col-xs-12">
                        <button style="float: left" type="submit" class="btn btn-primary image-upload">Upload Image
                        </button>

                    </div>
                </div>
            </form>


        </div>
    </div>
</div>





