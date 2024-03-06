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
        <form id="free_items" name="free_items" method="post" action="<?= base_url('admin/free_items/update') ?>">
            <div class="error error-message"><?= validation_errors(); ?></div>
            <input  type="hidden" value="<?= get_property_value('id',$free_item) ?>" name="id">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input class="form-control" type="number" id="amount" name="amount" value="<?= get_property_value('amount',$free_item) ?>" placeholder="Amount">
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <?php
                            $status_array = array('1'=>'Active','0'=>'Deactive');
                            $status = get_property_value('status',$free_item);
                        ?>
                        <label for="status">Status:</label>
                        <select class="form-control select2" id="status" name="status">
                            <?php foreach ($status_array as $key => $value): ?>
                                <?php                                    
                                    $select = '';
                                    if ($key == $status) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" type="text" id="" name="description" placeholder="description"><?= get_property_value('description',$free_item) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><?= $product_lists_data; ?></div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><?= $sub_product_lists_data; ?></div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>