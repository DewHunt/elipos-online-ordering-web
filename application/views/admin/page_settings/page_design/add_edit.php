<?php
    $details = '';
    if ($page_design) {
        $details = $page_design->value;
    }
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
            	<a href="<?= base_url('admin/page_management/page_design') ?>" class="btn btn-success">
            		<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;All Page Design
            	</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?= validation_errors(); ?></div>
        <form class="form-horizontal form-label-left" id="business_information_settings_form" name="menu-review" method="post" action="<?= base_url('admin/page_management/save_menu_design') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_property_value('id',$page_design) ?>">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<label for="name">Name</label>
                    <div class="form-group">
            			<input type="text" class="form-control" name="name" value="<?= get_property_value('name',$page_design) ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display: none">
                    <label for="name">File Location</label>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="file_location" value="assets/theme/css">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="css">Write CSS for Modify Design</label>
                    <div class="form-group">
                        <!-- <textarea type="text" rows="5" class="form-control" id="ckeditor" name="value"><?= get_property_value('value',$page_design) ?></textarea> -->
                        <textarea type="text" rows="12" class="form-control" name="value"><?= get_property_value('value',$page_design) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>