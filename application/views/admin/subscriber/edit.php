<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/subscriber') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Subscriber</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form action="<?=base_url('admin/subscriber/update')?>" method="post">
            <input type="hidden" name="id" value="<?=$subscriber->id?>">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="email-address">Email Address</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $subscriber->email ?>">
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" style="margin-top: 25px;">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>