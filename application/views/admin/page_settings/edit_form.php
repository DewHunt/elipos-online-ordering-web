<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/page_management') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Pages</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php if ($page_details): ?>
            <form id="business_information_settings_form" name="business_information_settings_form" method="post"
                  action="<?= base_url('admin/page_management/update_page_settings') ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" class="form-control" id="id" value="<?= $page_details->id ?>">
                <input type="hidden" name="name" class="form-control" id="name" value="<?= $page_details->name ?>">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="company_name" value="<?= $page_details->title?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea type="text" rows="3" name="content" class="form-control" id="content"><?= $page_details->content ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="side-image">Side Images</label>
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label for="show-in-front-side">Show In Font Side</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="is_show" class="" id="is_show" value="1" <?= ($page_details->is_show) ? 'checked' : '' ?>> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_show" class="" id="is_show" value="0" <?= (!$page_details->is_show) ? ' checked' : '' ?>> No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="logo-image-section form-group">
                            <div style="height: 300px;width: 400px">
                                <img width="auto" height="100%" id="logoImage" class="image-preview" src="<?= !empty($page_details) ? base_url($page_details->image) : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button id="send" type="submit" class="btn btn-success pull-right">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif ?>
    </div>
</div>