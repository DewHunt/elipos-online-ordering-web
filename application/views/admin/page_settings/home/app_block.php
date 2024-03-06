<style type="text/css">
    #apps_download_wrap { margin:5px 0 0 0; padding:50px 0 0 0; float:left; background:#f2f2f2; width:100%; height: auto; }
    #apps_download_block { margin:0 0 0 0; padding:0px 10px 10px 10px; float:left; background:#f1f1f1; width:100%; height: auto; }
    .apps_mobile_pic { margin:10px 0 0 0; padding:0 0 0 0; float:left; width:50%; height: auto; }
    .apps_texts_area { margin:81px 0 0 0; padding:0 0 0 0; float:left; width:50%; height: auto; }
    .apps_texts { margin:20px 5% 0 5%; padding:0 0 0 0; float:left; font-weight: lighter; font-size:20px; color:#000000; line-height:30px; text-align:center; width:90%; height: auto; font-family: 'Open Sans', sans-serif; }
    .apps_texts img { max-width:100%; height: auto; }
    .apps_buttons { margin:30px 5% 0 5%; padding:0 0 0 0; float:left; font-family: 'Open Sans', sans-serif; font-weight: lighter; font-size:20px; color:#000000; line-height:30px; text-align:center; width:90%; height: auto; }
    /*.apps_texts { margin:100px 5% 0 5%; padding:0 0 0 0; float:left; font-family: 'Open Sans', sans-serif; font-weight: lighter; font-size:20px; color:#000000; line-height:30px; width:90%; height: auto; }*/
</style>

<div id="apps_download_wrap">
    <div id="apps_download_block">
        <form id="apps-image-form" action="<?=base_url('admin/page_management/upload_app_image')?>" method="post" enctype="multipart/form-data">
            <div id="apps_download_block">
                <div class="page_heading"> <?=get_company_name()?> app is available  <span class="color_green text_bold">in app stores</span></div>
                <!-- <div class="page_subheading">Veri Peri online food ordering app will be available in app stores soon!</div> -->
                <div class="apps_mobile_pic">
                    <div style="position: absolute;z-index: 999;display: inline">
                        <a class="btn btn-sm delete-apps-image" style="background: white;color: red" title="Delete image" href="./assets/images/apps.jpg">X</a>
                        <button class="btn btn-sm btn-browse-image" style="background: green;color: #ffffff" title="Browse Image" >Browse Image</button>
                        <input type="file" id="file" name="apps" class="upload" accept="image/jpeg">
                    </div>
                    <div class="" style="display: none">Deleting...</div>
                    <img id="apps-image" src="<?= base_url('assets/images/apps.jpg') ?>" alt=""/>
                </div>
                <div class="apps_texts_area"></div>
            </div>
            <button type="submit" class="btn btn-primary" style="float: right">Save</button>
        </form>
    </div>
</div>