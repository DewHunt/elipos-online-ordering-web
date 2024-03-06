<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/tips/index') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Tips Lists</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <form id="tip-form" action="<?= base_url($this->admin.'/tips/update') ?>" method="post">
            <input class="form-control" type="hidden" name="tips_id" value="<?= $tips->id ?>">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Tips Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="<?= $tips->name ?>" placeholder="Tips Name" required>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Tips Amount</label>
                        <input class="form-control" type="number" min="1" name="amount" id="amount" value="<?= $tips->amount ?>" placeholder="Tips Amount" required>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Status</label>
                        <br>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" <?= $tips->status == 1 ? 'checked' : '' ?>>Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" <?= $tips->status == 0 ? 'checked' : '' ?>>Deactive
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label>Tips Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Tips Description"><?= $tips->description ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 text-right">
                    <button id="send" type="submit" class="btn btn-success">Save Change</button>
                </div>
            </div>
        </form>
    </div>
</div>