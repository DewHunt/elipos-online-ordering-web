<?php
    if (!empty($home_promo)) {
        $home_promo = json_decode($home_promo->value);
    } else {
        $home_promo = '';
    }
    $is_show = get_property_value('is_show',$home_promo);
    $promo_image = get_property_value('promo_image',$home_promo);
    $image_link = $promo_image;
    if ($promo_image) {
        $image_link = base_url($promo_image);
    }
    $date_of_permanence = get_property_value('date_of_permanence',$home_promo);
    $date_status = get_property_value('status',$date_of_permanence);
    $promo_valid_date = get_property_value('date',$date_of_permanence);
    $is_show_in_menu = get_property_value('is_show_in_menu',$home_promo);
    $promo_image_link = get_property_value('promo_image_link',$home_promo);
    $button_text = get_property_value('button_text',$home_promo);
    $button_url = get_property_value('button_url',$home_promo);
    $description = get_property_value('description',$home_promo);
    $promo_script_link = '<script type="text/javascript" src="'.base_url('assets/admin/promo.js').'"></script>';
    // dd($is_show_in_menu);
?>


<div class="panel panel-default">
    <div class="panel-heading"><h4>Home Page Promo Settings</h4></div>

    <div class="panel-body">
        <form class="form-horizontal form-label-left" id="home_promo" name="home_promo" method="post" action="<?= base_url('admin/settings/home_promo_save') ?>">
            <div class="error"><?php echo validation_errors(); ?></div>
            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="promo-image">Promo Image</label>
                <div class="col-sm-3 col-xs-6">
                    <input class="form-control" type="hidden" id="selected_image" name="promo_image" value="<?= $promo_image ?>">
                    <span class="btn btn-primary btn-md btn-block" id="btn-show-images" img-dir="assets/promo_images/" img-limit="1">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Select Image
                    </span>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <img width="100px" height="100px" id="logoImage" class="image-preview" src="<?= $image_link ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="progress" style="display: none">
                    <div class="background-color-white text-align-center" style="background-color: #ffffff; border-radius: 30px" id="progress-percentage"></div>
                    <progress class="progressbar progress progress-striped progress-animated progress-success" value="0" max="100" id="progress-bar"></progress>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="image-link">Image Link</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="url" name="promo_image_link" class="form-control" id="promo_image_link" value="<?= $promo_image_link ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="description">Description</label>
                <div class="col-sm-10 col-xs-12">
                    <textarea class="form-control" name="description" rows="5"><?= $description ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="button-url">Button Url</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="url" name="button_url" class="form-control" id="url" value="<?= $button_url ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="button-text">Button Text</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" name="button_text" class="form-control" id="button-text" value="<?= $button_text ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="pseudo-code">Pseudo Code</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="text" class="form-control" id="promo_script_text" value='<?= $promo_script_link ?>'>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="is-show">Is Show</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="is_show" id="is_show_yes" value="1" <?= ($is_show == 1) ? 'checked' : ''?>>Yes
                    </label>

                    <label class="radio-inline">
                        <input type="radio" name="is_show" id="is_show_no" value="0" <?= ($is_show == 0) ? 'checked' : '' ?>>No
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="is-show">Is Show In Menu</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="is_show_in_menu" id="is_show_in_menu_yes" value="1" <?= ($is_show_in_menu == 1) ? 'checked' : ''?>>Yes
                    </label>

                    <label class="radio-inline">
                        <input type="radio" name="is_show_in_menu" id="is_show_in_menu_no" value="0" <?= ($is_show_in_menu == 0) ? 'checked' : '' ?>>No
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-12" for="is-show">Valid Till</label>
                <div class="col-sm-5 col-xs-12 calender-design">
                    <input class="form-control datepicker promo_valid_date" id="datepicker" name="promo_valid_date" type="text" placeholder="dd/mm/yyyy" autocomplete="off" value="<?= $promo_valid_date ?>">
                </div>
                <div class="col-sm-5 col-xs-12">
                    <?php
                        $check = '';
                        if ($date_status == 1) {
                            $check = 'checked';
                        }
                    ?>
                    <input type="hidden" name="date_status" value="0">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="date_status" name="date_status" value="1" <?= $check ?>>Active
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="right-side-view right-side-magin">
                    <a type="button" href="<?= base_url('admin/settings/currency') ?>"
                       class="btn btn-danger">Cancel</a>
                    <button id="send" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="imageModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">All Images</h4>
            </div>
            <div class="modal-body">
                <div id="images-manager-div"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" id="btn-save-image" data-dismiss="modal" img-limit="1">Okay</button>
            </div>
        </div>
    </div>
</div>