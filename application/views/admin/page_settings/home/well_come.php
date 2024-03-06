<style type="text/css">
    .color_green { color: #f8781e; }
    #welcome_wrap { margin:5px 0 5px 0; padding:50px 0 10px 0; float:left; background:#f1f1f1; width:100%; height: auto; }
    #welcome_block { margin:0 auto; padding:0 10px 10px 10px; height: auto; }
    #welcome_boxes { margin:10px 0 0 0; padding:0 0 0 0; float:left; width:100%; height: auto; }
    #welcome_boxes_left { margin:0 0 0 0; padding:0 0 0 0; float:left; width:49%; height: auto; }
    #welcome_boxes_left a img { max-width:100%; height: auto; }
    #welcome_boxes_right { margin:0 0 0 0; padding:0 0 0 0; float:right; width:49%; height: auto; }
    #welcome_boxes_right_column1 { margin:0 0 0 0; padding:0 0 0 0; float:left; width:48%; height: auto; }
    #welcome_boxes_right_column1_adv_show { margin:0 0 20px 0; padding:0 0 0 0; float:left; width:100%; height:auto; }
    #welcome_boxes_right_column1_adv_show a img { max-width:100%; height: auto; }
    #welcome_boxes_right_column2 { margin:0 0 0 0; padding:0 0 0 0; float:right; width:48%; height: auto; }
    #welcome_boxes_right_column2_adv_show { margin:0 0 20px 0; padding:0 0 0 0; float:left; width:100%; height:auto; }
    #welcome_boxes_right_column2_adv_show a img { max-width:100%; height: auto; }
    .uploader { position:relative; overflow:hidden; width: 100%; background:#f3f3f3; border:2px dashed #e8e8e8; }
    .upload{ width: 100px; top: 0; right: 0; bottom: 0; z-index:2; opacity:0; cursor:pointer; position: absolute; }
    .uploader img{ position:absolute; width: 100%; top:-1px; left:-1px; z-index:1; border:none; }
    .center { margin-left: auto; margin-right: auto; width: 50%; display: block; padding: 18% 0; text-align: center }
    img { z-index:1; }
</style>
<?php
    $shop_details = get_company_details();
?>

<div id="welcome_wrap">
    <div id="welcome_block">
        <div class="page_heading">
            <?=get_property_value('company_name',$shop_details)?> In the heart of
            <span class="color_green text_bold"><?=get_property_value('city',$shop_details)?></span>
        </div>

        <form id="welcome-image-form" action="<?=base_url('admin/page_management/welcome_image_save')?>" method="post" enctype="multipart/form-data">
            <div id="welcome_boxes">
                <div id="welcome_boxes_left">
                    <div style="position: absolute;z-index: 999;display: inline">
                        <a class="btn btn-sm delete-well-come-image" style="background: white;color: red" title="Delete image" href="./assets/images/home-welcome/1.jpg">X</a>
                        <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                        <input type="file" id="file" name="1" class="upload" accept="image/jpg">
                    </div>
                    <div class="deleting-image">Deleting...</div>
                    <a><img id="well-come-image-1" src="<?= base_url('assets/images/home-welcome/1.jpg') ?>" alt=""/></a>
                </div>

                <div id="welcome_boxes_right">
                    <div id="welcome_boxes_right_column1">
                        <div id="welcome_boxes_right_column1_adv_show">
                            <div style="position: absolute;z-index: 999;display: inline">
                                <a class="btn btn-sm delete-well-come-image" style="background: white;color: red" title="Delete image" href="./assets/images/home-welcome/2.jpg">X</a>
                                <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                                <input type="file" id="file" name="2" class="upload" accept="image/jpeg">
                            </div>
                            <div class="deleting-image">Deleting...</div>
                            <a><img id="well-come-image-2" src="<?= base_url('assets/images/home-welcome/2.jpg') ?>" alt=""/></a>
                        </div>

                        <div id="welcome_boxes_right_column1_adv_show">
                            <div style="position: absolute;z-index: 999;display: inline">
                                <a class="btn btn-sm delete-well-come-image" style="background: white;color: red" title="Delete image" href="./assets/images/home-welcome/3.jpg">X</a>
                                <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                                <input type="file" id="file" name="3" class="upload" accept="image/jpeg">
                            </div>
                            <div class="deleting-image">Deleting...</div>
                            <a><img  id="well-come-image-3" src="<?= base_url('assets/images/home-welcome/3.jpg') ?>" alt="" class="top_gap"/></a>
                        </div>
                    </div>

                    <div id="welcome_boxes_right_column2">
                        <div id="welcome_boxes_right_column2_adv_show">
                            <div style="position: absolute;z-index: 999;display: inline">
                                <a class="btn btn-sm delete-well-come-image" style="background: white;color: red" title="Delete image" href="./assets/images/home-welcome/4.jpg">X</a>
                                <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                                <input type="file" id="file" name="4" class="upload" accept="image/jpeg">
                            </div>
                            <div class="deleting-image">Deleting...</div>
                            <a><img id="well-come-image-4" src="<?= base_url('assets/images/home-welcome/4.jpg') ?>" alt=""/></a>
                        </div>

                        <div id="welcome_boxes_right_column2_adv_show">
                            <div style="position: absolute;z-index: 999;display: inline">
                                <a class="btn btn-sm delete-well-come-image" style="background: white;color: red" title="Delete image" href="./assets/images/home-welcome/4.jpg">X</a>
                                <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                                <input type="file" id="file" name="5" class="upload" accept="image/jpeg">
                            </div>
                            <div class="deleting-image">Deleting...</div>
                            <a href="<?= base_url('menu')?>"><img id="well-come-image-5"  src="<?= base_url('assets/images/home-welcome/5.jpg') ?>" alt="" class="top_gap"/></a>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </form>
    </div>
</div>