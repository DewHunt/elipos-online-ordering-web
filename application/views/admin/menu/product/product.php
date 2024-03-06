<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/product/add_product') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</a>
            </div>
        </div>
    </div>

    <div class="panel-body">        
        <form id="product_list_form" name="product_list_form" method="post">
            <div class="row">                
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <label>Category</label>
                    <div class="form-group">
                        <select id="category_id" name="category_id" class="form-control category select2">
                            <option value="">Please Select</option>
                            <?php if (!empty($category_list)): ?>
                                <?php foreach ($category_list as $category): ?>
                                    <?php
                                        $select = '';
                                        if ($session_category_id == $category->categoryId) {
                                            $select = 'selected';
                                        }
                                    ?>
                                    <option value="<?= $category->categoryId ?>" <?= $select ?>><?= $category->categoryName ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <label></label>
                    <div class="form-group" style="padding-top: 5px;">
                        <button id="send" type="submit" class="btn btn-block btn-success">Show</button>
                    </div>
                </div>
            </div>
        </form>

        <center><img align="middle" class="loader" style="display: none" src="<?=base_url('assets/admin/loader/loader.gif')?>"></center>

        <div class="form-container table-data-block"><?= $product_list_info ?></div>
    </div>
</div>


