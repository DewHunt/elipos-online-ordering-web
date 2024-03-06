<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
        </div>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Contents</th>
                        <th width="130px">Is Show In Font Side</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $sl = 1 ?>
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= $page->title ?></td>
                            <td><?= $page->content ?></td>
                            <td class="text-center"><?= ($page->is_show) ? 'Show' : 'Not Show' ?></td>
                            <td>
                                <a href="<?=base_url($this->admin.'/page_management/edit_page/'.$page->id)?>" class="btn btn-secondary btn-sm"><i class="fa fa-pencil" ></i></a>
                                <a href="<?=base_url($page->name)?>" class="btn btn-primary btn-sm"><i class="fa fa-eye" ></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>