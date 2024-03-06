<style type="text/css">
    .remove-item,.edit-item,.remove-modifier-item,.action-col { display: none!important; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/offers_or_deals/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add New Offer/Deal</a>
                <a class="btn btn-info" href="<?= base_url('admin/offers_or_deals') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Offer/Deal</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center" width="300px">
                            <div>Category</div>
                            <label><?= $deal->categoryName ?></label>
                        </td>
                        <td class="text-center">
                            <div>Title</div>
                            <label><?= $deal->title ?></label>
                        </td>
                        <td class="text-center" width="100px">
                            <div>Price</div>
                            <label><?= $deal->price ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center">
                            <div>Description</div>
                            <label><?= $deal->description ?></label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $this->load->view('admin/menu/offers_or_deals/item_list',$this->data);?>
            </div>
        </div>
    </div>
</div>