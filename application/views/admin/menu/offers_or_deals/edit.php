<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/offers_or_deals') ?>"><i class="fa fa-hand-o-left" aria-hidden="true"></i> All Offer/Deal</a>
            </div>
        </div>
    </div>

    <div class="panel-body">        
        <div class="row">
            <div class="col-lg-12"><?php $this->load->view('admin/menu/offers_or_deals/save_message')?></div>
        </div>

        <form id="dealsEditForm" method="post" action="<?= base_url('admin/offers_or_deals/update') ?>">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h2>Category Details</h2></div>
                <div class="panel-body">
                    <input type="hidden" name="id" value="<?=$deal->id?>">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?php
                                $m_category = new Category_Model();
                                $categories = $m_category->get_offers_or_deals_and_package();
                            ?>
                            <label>Category</label>
                            <div class="form-group">
                                <select class="form-control select2" name="categoryId" id="category_id">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <?php
                                            $select = "";
                                            if ($deal->categoryId == $category->categoryId) {
                                                $select = "selected";
                                            }
                                        ?>
                                        <option value="<?= $category->categoryId ?>" <?= $select ?>><?= $category->categoryName ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Title</label>
                            <div class="form-group"><input type="text" class="form-control" name="title" value="<?=$deal->title?>"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Price(<?=get_currency_symbol()?>)</label>
                            <div class="form-group"><input type="number" class="form-control" name="price" id="price" value="<?= $deal->price ?>"></div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Sort Order</label>
                            <div class="form-group"><input type="number" class="form-control" name="sort_order" id="sort_order" value="<?= $deal->sort_order ?>"></div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Discount</label>
                            <div class="form-group">
                                <?php
                                    $check = '';
                                    if ($deal->is_discount == 1) {
                                        $check = 'checked';
                                    }
                                ?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="is_discount" id="is_discount" value="1" <?= $check ?>>Exclude Discount
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Type</label>
                            <div class="form-group">
                                <input type="hidden" name="is_half_and_half" value="0">
                                <label class="checkbox-inline">
                                    <?php
                                        $check = '';
                                        if ($deal->is_half_and_half == 1) {
                                            $check = 'checked';
                                        }
                                    ?>
                                    <input type="checkbox" name="is_half_and_half" id="is_half_and_half" value="1" <?= $check ?>>Half And Half
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php
                                $days = array('sunday,monday,tuesday,wednesday,thursday,friday,saturday' => 'All Days', 'sunday' => 'Sunday','monday' => 'Monday','tuesday' => 'Tuesday','wednesday' => 'Wednesday','thursday' => 'Thursday','friday' => 'Friday','saturday' => 'Saturday',);
                                $availabilityArray = explode(',',$deal->availability);
                            ?>
                            <label>Availability</label>
                            <div class="form-group">
                                <select id="" name="availability[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Days" required>
                                    <?php foreach ($days as $key => $value): ?>
                                        <?php
                                            $select = "";
                                            if (in_array($key,$availabilityArray)) {
                                                $select = "selected";
                                            }                                                       
                                        ?>
                                        <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php
                                $order_types = array('delivery,collection,dine_in' => 'Delivery, Collection And Dine-In', 'delivery,collection' => 'Delivery And Collection','delivery' => 'Delivery','collection' => 'Collection','dine_in' => 'Dine-in');
                            ?>
                            <label>Order Type</label>
                            <div class="form-group">
                                <select name="deal_order_type" class="form-control select2">
                                    <option value="">Select Order Type</option>
                                    <?php foreach ($order_types as $key => $value): ?>
                                        <?php
                                            if ($deal->deal_order_type == $key) {
                                                $select = 'selected';
                                            } else {
                                                $select = '';
                                            }                                                        
                                        ?>
                                        <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Description</label>
                            <div class="form-group"><textarea class="form-control" name="description" rows="5"><?= $deal->description ?></textarea></div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Printed Description</label>
                            <div class="form-group"><textarea  class="form-control" name="deal_printed_description" rows="5"><?= $deal->deal_printed_description ?></textarea></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div style="padding-top: 10px;"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="deals-item-add-form-block">
                    <?php $this->load->view('admin/menu/offers_or_deals/deals_item_add_form'); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
                <div id="deals-item-list-block"><?=$dealsItemsView?></div>
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <button class="btn btn-primary" id="editDealsFormButtonConfirm" type="submit">Confirm</button>
            </div>
        </div>
    </div>
</div>