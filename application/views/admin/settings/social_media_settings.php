<style>
    .progress[value] { color: green; width: 100%; }
</style>
<?php
    $medias = '';
    if (!empty($social_media)) {
        $medias = json_decode($social_media->value);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="error"><?php echo validation_errors(); ?></div>
        <form class="form-horizontal form-label-left" id="social_media_settings_form" name="social_media_settings_form" method="post" action="<?= base_url('admin/settings/social_media_settings_save') ?>">
            <input type="hidden" name="id" class="form-control" id="id" value="<?= !empty($social_media) ? $social_media->id : '' ?>">
            <input type="hidden" name="name" class="form-control" id="name" value="social_media">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="facebook-link">Facebook Link</label>
                        <input type="url" name="facebook" class="form-control" id="facebook" value="<?= !empty($medias) ? $medias->facebook : '' ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="twitter-link">Twitter Link</label>
                        <input type="url" name="twitter" class="form-control" id="twitter" value="<?= !empty($medias) ? $medias->twitter : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="youtube-link">Youtube Link</label>
                        <input type="url" name="youtube" class="form-control" id="youtube" value="<?= !empty($medias) ? $medias->youtube : '' ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="linkedin-link">LinkedIn Link</label>
                        <input type="url" name="linkedIn" class="form-control" id="linkedIn" value="<?= !empty($medias) ? $medias->linkedIn : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="google-plus-link">GooglePlus Link</label>
                        <input type="url" name="googlePlus" class="form-control" id="googlePlus" value="<?= !empty($medias) ? $medias->googlePlus : '' ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="skype-link">Skype Link</label>
                        <input type="url" name="skype" class="form-control" id="skype" value="<?= !empty($medias) ? $medias->skype : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="trip-advisor">Trip Advisor</label>
                        <input type="url" name="tripadvisor" class="form-control" id="tripadvisor" value="<?= get_property_value('tripadvisor',$medias)?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="instagram-link">Instagram Link</label>
                        <input type="url" name="instagram" class="form-control" id="instagram" value="<?= get_property_value('instagram',$medias)?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <a type="button" href="<?= base_url('admin/settings/currency') ?>" class="btn btn-danger">Cancel</a>
                        <button id="send" type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>