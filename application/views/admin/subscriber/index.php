<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/subscriber/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Subscriber</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered list-dt">
                <thead>
                    <tr>
                        <th width="20px">SL</th>
                        <th>Email</th>
                        <th width="60px">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $sl = 1; ?>
                    <?php foreach ($subscribers as $subscriber): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= $subscriber->email ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("admin/subscriber/edit/".$subscriber->id) ?>" class="btn btn-primary btn-sm view view-order"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="<?= base_url("admin/subscriber/delete/".$subscriber->id) ?>" class="btn btn-danger btn-sm delete-order" onclick="return confirm('Are you sure to delete subscribed email <?= $subscriber->email.' ?'?>')"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
        </div>
    </div>
</div>