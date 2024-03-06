<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h4><?= $title ?></h4></div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/buy_and_get'); ?>"><i class="fa fa-reply" aria-hidden="true"></i> All Buy X Get Y</a>
            </div>
        </div>
        
    </div>

    <div class="panel-body">
        <form id="dealsAddForm" method="post" action="<?=base_url('admin/buy_and_get/update')?>">
    		<input class="form-control" type="hidden" name="buy_get_id" value="<?= $buy_get_info->id ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="title">Title</label>
        				<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?= $buy_get_info->title ?>" required>
        			</div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                    	<label for="validity">Validity</label>
                        <div id="validity" style="cursor: pointer; padding: 6px 12px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="from_date" type="hidden" name="start_date" value="<?= $buy_get_info->start_date ?>">
                                <input id="to_date" type="hidden" name="end_date" value="<?= $buy_get_info->end_date ?>">
                            </div>
                        </div>
                    </div>
                </div>
        	</div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $days = array('sunday,monday,tuesday,wednesday,thursday,friday,saturday' => 'All Days', 'sunday' => 'Sunday','monday' => 'Monday','tuesday' => 'Tuesday','wednesday' => 'Wednesday','thursday' => 'Thursday','friday' => 'Friday','saturday' => 'Saturday',);
                        $availabilityArray = explode(',', $buy_get_info->availability);
                    ?>
                    <label>Availability</label>
                    <div class="form-group">
                        <select id="availability" name="availability[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Days" required>
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
            </div>

            <div class="row">
        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="order-type">Order Type</label>
        				<?php
        					$order_type_array = array('collection,delivery' => 'Any','collection' => 'Collection','delivery' => 'Delivery');
        				?>
        				<select class="form-control" id="order_type" name="order_type">
        					<option value="">Select Order Type</option>
        					<?php foreach ($order_type_array as $key => $value): ?>
        						<?php
        							if ($key == $buy_get_info->order_type) {
        								$select = "selected";
        							} else {
        								$select = "";
        							}
        						?>
        						<option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
        					<?php endforeach ?>
        				</select>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="buy-qty">Buy Quantity</label>
        				<input type="number" min="1" class="form-control" id="but_qty" name="but_qty" placeholder="Buy Quantity" value="<?= $buy_get_info->buy_qty ?>" required>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="get-qty">Get Quantity</label>
        				<input type="number" min="1" class="form-control" id="get_qty" name="get_qty" placeholder="Get Quantity" value="<?= $buy_get_info->get_qty ?>" required>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<label for="status">Status</label>
        			<div class="form-group">
        				<label class="radio-inline"><input type="radio" name="status" value="1" <?= $buy_get_info->status == 1 ? 'checked' : '' ?>>Active</label>
        				<label class="radio-inline"><input type="radio" name="status" value="0" <?= $buy_get_info->status == 0 ? 'checked' : '' ?>>Inactive</label>
        			</div>
        		</div>
        	</div>
        	
        	<div class="row">
        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="description">Description</label>
        				<textarea class="form-control" id="description" name="description" rows="2" placeholder="Descripotion"><?= $buy_get_info->description ?></textarea>
        			</div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			<div class="form-group">
	        			<select id="test-select-4" multiple="multiple" name="category_item_list[]">
	        				<?php
	        					$category_id_array = explode(',',$buy_get_info->category_id);
	        					$item_id_array = explode(',',$buy_get_info->item_id);
	        				?>
	        				<?php foreach ($items_by_category as $category): ?>
	        					<?php
	        						$categoryId = $category->categoryId;
	        						$categoryName = $category->categoryName;
	        						$itemList = $category->itemList;
	        					?>
	    						<?php if ($itemList): ?>
	    							<?php foreach ($itemList as $item): ?>
	    								<?php
	        								$itemId = $item->foodItemId;
	        								$itemName = $item->foodItemName;
	        								if (in_array($categoryId,$category_id_array)) {
	        									$select = "selected";
	        								} else {
		        								if (in_array($itemId,$item_id_array)) {
		        									// echo "ok"; exit();
		        									$select = "selected";
		        								} else {
		        									$select = "";
		        								}
	        								}	        								
	    								?>
	    								<option value="<?= $categoryId ?>,<?= $itemId ?>" data-section="<?= $categoryName ?>" data-index="1" <?= $select ?>><?= $itemName ?></option>
	    							<?php endforeach ?>
	    						<?php endif ?>
	        				<?php endforeach ?>
	        			</select>
        			</div>
        		</div>
        	</div>

            <div class="row">
                <div class="col-lg-12 text-right">
                	<div class="form-group">
                    	<button class="btn btn-primary" type="submit">Save</button>
                	</div>
                </div>
            </div>
        </form>
    </div>
</div>