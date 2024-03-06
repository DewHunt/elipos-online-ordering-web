<style type="text/css">
    .saved-image { width: 100px; height: 100px; margin-top: 8px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/promo_offers') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Promo Offers Lists</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="add_table_form" action="<?= base_url('admin/promo_offers/update') ?>" method="post" enctype="multipart/form-data">            
            <input type="hidden" name="promo_offers_id" value="<?= $promo_offers->id ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Validity</label>
                        <div class="form-group">
                            <div id="daterange-div" class="pull-right calender-block">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                                <div class="date-input-div">
                                    <input id="from_date" type="hidden" name="start_date" value="<?= $promo_offers->start_date ?>">
                                    <input id="to_date" type="hidden" name="end_date" value="<?= $promo_offers->end_date ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="sort-order">Sort Order</label>
                        <input type="number" min="1" class="form-control" name="sort_order" value="<?= $promo_offers->sort_order ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="web-image">Web Image</label>
                        <input type="hidden" class="form-control" name="previous_web_image" value="<?= $promo_offers->web_image; ?>">
                        <input type="file" class="form-control" name="web_image">
                        <img class="img-thumbnail saved-image" src="<?= base_url($promo_offers->web_image); ?>">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="apps-image">Apps Image</label>
                        <input type="hidden" class="form-control" name="previous_apps_image" value="<?= $promo_offers->apps_image; ?>">
                        <input type="file" class="form-control" name="apps_image">
                        <img class="img-thumbnail saved-image" src="<?= base_url($promo_offers->apps_image); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <a href="<?= base_url("admin/promo_offers/delete/$promo_offers->id") ?>" class="btn btn-danger">
                        <i class="fa fa-times" aria-hidden="true"></i>&nbsp;Delete
                    </a>
                    <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Update</button>
                </div>
            </div>
        </form>
    </div>
</div>