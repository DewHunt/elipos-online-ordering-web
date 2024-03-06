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
        <form id="dealsAddForm" method="post" action="<?= base_url('admin/buy_and_get/save') ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="title">Title</label>
        				<input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
        			</div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                    	<label for="validity">Validity</label>
                        <div id="validity" style="cursor: pointer; padding: 6px 12px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span id="changed_date" class="changed_date"></span> <b class="caret"></b>
                            <div class="date-to-form">
                                <input id="from_date" type="hidden" name="start_date" value="">
                                <input id="to_date" type="hidden" name="end_date" value="">
                            </div>
                        </div>
                    </div>
                </div>
        	</div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $days = array('sunday,monday,tuesday,wednesday,thursday,friday,saturday' => 'All Days', 'sunday' => 'Sunday','monday' => 'Monday','tuesday' => 'Tuesday','wednesday' => 'Wednesday','thursday' => 'Thursday','friday' => 'Friday','saturday' => 'Saturday',);
                    ?>
                    <label>Availability</label>
                    <div class="form-group">
                        <select id="availability" name="availability[]" class="form-control select2 select2-multiple" multiple data-placeholder="Select Days" required>
                            <?php foreach ($days as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
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
        				<select class="form-control select2" id="order_type" name="order_type">
        					<option value="">Select Order Type</option>
        					<?php foreach ($order_type_array as $key => $value): ?>
        						<option value="<?= $key ?>"><?= $value ?></option>
        					<?php endforeach ?>
        				</select>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="buy-qty">Buy Quantity</label>
        				<input type="number" min="1" class="form-control" id="but_qty" name="but_qty" placeholder="Buy Quantity" value="1" required>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="get-qty">Get Quantity</label>
        				<input type="number" min="1" class="form-control" id="get_qty" name="get_qty" placeholder="Get Quantity" value="1" required>
        			</div>
        		</div>

        		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        			<label for="status">Status</label>
        			<div class="form-group">
        				<label class="radio-inline"><input type="radio" name="status" value="1" checked>Active</label>
        				<label class="radio-inline"><input type="radio" name="status" value="0">Inactive</label>
        			</div>
        		</div>
        	</div>
        	
        	<div class="row">
        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			<div class="form-group">
        				<label for="description">Description</label>
        				<textarea class="form-control" id="description" name="description" rows="2" placeholder="Descripotion"></textarea>
        			</div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        			<div class="form-group">
	        			<select id="test-select-4" multiple="multiple" name="category_item_list[]">
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
	    								?>
	    								<option value="<?= $categoryId ?>,<?= $itemId ?>" data-section="<?= $categoryName ?>" data-index="1"><?= $itemName ?></option>
	    							<?php endforeach ?>
	    						<?php endif ?>
	        				<?php endforeach ?>
	        			</select>
        			</div>
        		</div>
        	</div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                	<div class="form-group">
                    	<button class="btn btn-primary" type="submit">Save</button>
                	</div>
                </div>
            </div>
        </form>
    </div>
</div>