<style type="text/css">
	ul { list-style-type: none; padding: 0px; margin-top: 10px; margin-left: -8px; margin-right: -8px; }
    li { display: inline-block; margin-left: -9px; margin-right: -9px; }
    input[type="checkbox"][id^="cb"] { display: none; }
    .cb-label {
        border: 1px solid #dee2e6;
        padding: 3px;
        display: block;
        position: relative;
        margin: 17px;
        cursor: pointer;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .cb-label::before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 3px;
        border: 1px solid grey;
        position: absolute;
        top: 1px;
        left: 1px;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 19px;
        transition-duration: 0.4s;
        transform: scale(0);
    }
    .cb-label img {
        height: 120px;
        width: 120px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }
    :checked+.cb-label { border-color: #dee2e6; }
    :checked+.cb-label::before { content: "✓"; background-color: #19bcbf; transform: scale(1); z-index: 1; }
    :checked+.cb-label img { transform: scale(0.9); box-shadow: 0 0 5px #333; z-index: -1; }
    hr { margin-top: 0px; margin-bottom: 5px; }
    .btn-refresh { font-size: 16px; color: #ffffff; background-color: #0071ee; padding: 10px 35px; border: 1px solid #fbf9f9; border-radius: 3px; }
    .btn-image-delete { margin-top: -12px; width: 70%; margin-left: 7px; }
</style>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="custom-control custom-checkbox">
            <label class="checkbox-inline"><input type="checkbox" class="select_all" id="customCheck" name="select_all">Select All</label>
        </div>
    </div>
</div> -->

<form class="form-horizontal" id="image-form" action="<?= base_url('admin/image_manager/images_upload'); ?>" method="POST" enctype="multipart/form-data" name="form">
    <div class="row">
        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">            
            <label for="upload-gallery-images">Upload Image</label>
            <div class="form-group">
                <input class="form-control" type="file" id="multiple_file" name="images[]" multiple required />
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 text-right" style="margin-top: 5px;">
            <label></label>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-md btn-block" id="save_btn_multiple_file"><i class="fa fa-save"></i> Upload</button>
            </div>
        </div>
    </div>
</form>

<hr>
<br>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <a href="javascript:void(0)" class="btn-refresh" id="btn-image-refresh"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a>
    </div>
</div>

<div class="text-center">
	<ul>
		<?php
			$count = 0;
		?>
		<?php foreach ($images as $file_name): ?>
			<?php
				$count++;
			?>
			<li class="text-center">
				<input type="checkbox" id="cb<?= $count ?>" class="image-cb" name="image_name" value="<?= $file_name ?>"/>
				<label class="cb-label" for="cb<?= $count ?>"><img src="<?= base_url($file_name) ?>" /></label>
                <span class="btn btn-danger btn-sm btn-image-delete" id="btn-image-delete" image-path="<?= $file_name ?>">Delete</span>
            	<!-- <span><?= $file_name ?></span> -->
			</li>
		<?php endforeach ?>
	</ul>
</div>