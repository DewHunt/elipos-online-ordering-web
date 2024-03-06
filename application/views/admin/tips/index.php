<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/tips/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Tips</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive list-dt">
                <thead class="thead-default">
                    <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center" width="150px">Name</th>
                        <th class="text-center" width="50px">Amount</th>
                        <th class="text-center">Description</th>
                        <th class="text-center" width="50px">Status</th>
                        <th class="text-center" width="60px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $count = 1 ?>
                    <?php if (!empty($tips_lists)): ?>
                        <?php foreach ($tips_lists as $tips): ?>
                            <?php
                                $status = 'Deactive';
                                if ($tips->status == 1) {
                                    $status = 'Active';
                                }                                                   
                            ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= $tips->name ?></td>
                                <td class="text-right"><?= $tips->amount ?></td>
                                <td><?= $tips->description ?></td>
                                <td class="text-center"><?= $status ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url("admin/tips/edit/$tips->id") ?>"class="btn btn-primary btn-sm">
                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    <a href="<?= base_url("admin/tips/delete/$tips->id") ?>" class="btn btn-danger btn-sm">
                                        <i class=" fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>