<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <?php
            $details = '';
            if ($menu_review) {
                $details = json_decode($menu_review->value);
            }
        ?>
        <div class="error"><?php echo validation_errors(); ?></div>
        <form class="form-horizontal form-label-left" id="business_information_settings_form" name="menu-review" method="post" action="<?= base_url('admin/page_management/menu_review_save') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= get_property_value('id',$menu_review)?>">
            <input type="hidden" name="name" class="form-control" id="name" value="menu_review">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="menu-review">Menu Reviews</label>
                        <textarea type="text" rows="15" name="trip_advisor" class="form-control" id="trip_advisor"> <?=get_property_value('trip_advisor',$details)?></textarea>
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