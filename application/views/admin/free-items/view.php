<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/free_items'); ?>"><i class="fa fa-reply" aria-hidden="true"></i> All Free Items</a>
            </div>
        </div>
        
    </div>

    <div class="panel-body">
        <?php if ($free_item): ?>
            <?php
                $lim_product = new Product();
                $products = array();
                $sub_products = array();
                if ($free_item->product_ids) {
                    $products = $lim_product->get_products_by_ids(json_decode($free_item->product_ids));
                }

                if ($free_item->sub_products_ids) {
                    $sub_products = $lim_product->get_sub_products_by_ids(json_decode($free_item->sub_products_ids));
                }
            ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td class="text-center">
                                <div>Amount</div>
                                <label><?= $free_item->amount ?></label>
                            </td>
                            <td class="text-center">
                                <div>Status</div>
                                <label><?= $free_item->status ? 'Active' : 'In Active' ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">
                                <div>Description</div>
                                <label><?= $free_item->description ?></label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr><th class="text-center"><h2>Product</h2></th></tr>
                        </thead>

                        <tbody>
                            <?php if ($products): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr><td><?= $product->foodItemName ?></td></tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr><th class="text-center"><h2>Sub Product</h2></th></tr>
                        </thead>

                        <tbody>
                            <?php if ($sub_products): ?>
                                <?php foreach ($sub_products as $sub_product): ?>
                                    <tr><td><?= $sub_product->selectiveItemName ?></td></tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>



