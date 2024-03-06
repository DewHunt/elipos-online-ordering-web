<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Sub Product Files Items</a>
                <a class="btn btn-info" href="<?= base_url('admin/sub_product_files/add_item') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Product Files Item</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category_id" name="category_id" class="form-control select2">
                        <option value="">Please Select</option>
                        <?php
                            $category_id_for_sub_product_session = $this->session->userdata('category_id_for_sub_product_session');
                        ?>
                        <?php if ($category_list): ?>
                            <?php foreach ($category_list as $category): ?>
                                <?php
                                    $select = '';
                                    if ($category_id_for_sub_product_session == $category->categoryId) {
                                        $select = 'selected';
                                    }
                                ?>
                                <option value="<?= $category->categoryId ?>" <?=  $select ?>><?= $category->categoryName ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="">Food Type</label>
                    <div class="product_id">
                        <select id="product_id" name="product_id" class="form-control select2">
                            <option value="">Please Select</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <div class="form-group" style="margin-top: 22px;">
                    <button id="send" type="submit" class="btn btn-success btn-block show-sub-product-files">Show</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="text-xs-center assign-message" style="text-align: center"></h2>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sub-product-files-tables"></div>
            </div>
        </div>
    </div>
</div>