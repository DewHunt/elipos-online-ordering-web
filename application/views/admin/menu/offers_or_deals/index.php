<style type="text/css">
    .active_btn { width: 60px; }
    .orderable_btn { width: 80px; }
    .highlighted_btn { width: 95px; }
    .btn-group-sm > .btn, .btn-sm { padding: 5px 5px; }
    .btn-default { color: #fff; background-color: #aaa; }
    .btn-success { color: #fff; background: #5cb85c }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/offers_or_deals/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New Offer/Deal</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-respnsive">
                    <table class="table table-striped table-bordered dt-responsive list-dt">
                        <thead>
                            <th>SL</th>
                            <th width="200px">Category</th>
                            <th width="300px">Title</th>
                            <th width="500px">All Description</th>
                            <th width="150px">Order type</th>
                            <th width="250px">Availability</th>
                            <th width="60px">Price(<?=get_currency_symbol()?>)</th>
                            <th width="60px">Order</th>
                            <th class="text-center" width="110px">Action</th>
                        </thead>

                        <tbody>
                            <?php $sl = 0; ?>

                            <?php foreach ($deals as $deal): ?>
                                <?php
                                    $activeButtonName = 'Deactive';
                                    $activeButtonClass = 'btn-danger';
                                    $orderableButtonName = 'Unorderable';
                                    $orderableButtonClass = 'btn-danger';
                                    $highlitedButtonName = 'Not Highlited';
                                    $highlitedButtonClass = 'btn-default';
                                    $half_text = '';
                                    if ($deal->active == 1) {
                                        $activeButtonName = 'Active';
                                        $activeButtonClass = 'btn-success';
                                    }

                                    if ($deal->orderable == 1) {
                                        $orderableButtonName = 'Orderabled';
                                        $orderableButtonClass = 'btn-success';
                                    }

                                    if ($deal->isHighlight == 1) {
                                        $highlitedButtonName = 'Highlited';
                                        $highlitedButtonClass = 'btn-primary';
                                    }

                                    if ($deal->is_half_and_half) {
                                        $half_text = '<br>(Half And Half)';
                                    }
                                ?>
                                <tr>
                                    <td><?= ++$sl ?></td>
                                    <td><?= $deal->categoryName ?></td>
                                    <td><?= $deal->title ?><?= $half_text ?></td>
                                    <td>
                                        <b>Description: </b>
                                        <p><?= $deal->description ?></p>
                                        <b>Printed Description: </b>
                                        <p><?= $deal->deal_printed_description ?></p>
                                    </td>
                                    <td><?= $deal->deal_order_type ?></td>
                                    <td><?= implode(', ', explode(',', $deal->availability)) ?></td>
                                    <td><?= $deal->price ?></td>
                                    <td><?= $deal->sort_order ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url("admin/offers_or_deals/view/".$deal->id) ?>" class="btn btn-primary btn-sm"><i class=" fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="<?= base_url("admin/offers_or_deals/edit/".$deal->id) ?>" class="btn btn-primary btn-sm"><i class=" fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="<?= base_url("admin/offers_or_deals/delete/".$deal->id) ?>"  class="btn btn-delete btn-danger btn-sm"><i class=" fa fa-times" aria-hidden="true"></i></a>
                                        <span onclick="active_or_deactive(<?= $deal->id ?>,<?= $deal->active ?>,1)" id="active_or_deactive_<?= $deal->id ?>" class="btn <?= $activeButtonClass ?> btn-sm btn-block">
                                            <?= $activeButtonName ?>
                                        </span>
                                        <span onclick="orderable_or_unorderable(<?= $deal->id ?>,<?= $deal->orderable ?>,2)" id="orderable_or_unorderable_<?= $deal->id ?>" class="btn <?= $orderableButtonClass ?> btn-sm btn-block">
                                            <?= $orderableButtonName ?>
                                        </span>
                                        <span onclick="highlighted_or_not_highlighted(<?= $deal->id ?>,<?= $deal->isHighlight ?>,3)" id="highlighted_or_not_highlighted_<?= $deal->id ?>" class="btn <?= $highlitedButtonClass ?> btn-sm btn-block">
                                            <?= $highlitedButtonName ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="view-modal-block"></div>
            </div>
        </div>
    </div>
</div>