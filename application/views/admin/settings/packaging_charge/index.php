<style type="text/css">
	.collection-child-checkbox-div { padding-left: 25px; }
	.delivery-child-checkbox-div { padding-left: 25px; }
	.checkbox-ml { margin-left: 10px; }
	.child-checkbox-div-hide { display: none; }
	.child-checkbox-div-show { display: block; }
	.form-horizontal .control-label { text-align: left !important; }
</style>

<div class="panel panel-default">
	<div class="panel-heading"><h4>Packaging Charge</h4></div>

	<div class="panel-body">
		<form class="form-horizontal" id="packaging-charge-form" action="<?= base_url('admin/settings/packaging_charge_save') ?>" method="post">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="is_packaging_charge_applicable_deactive" name="is_packaging_charge_applicable" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		if ($is_packaging_charge_applicable == 1) {
					    			$check = 'checked';
					    		}
					    	?>
					    	<input type="checkbox" id="is_packaging_charge_applicable_active" name="is_packaging_charge_applicable" value="1" <?= $check ?> >Is The Packaging Charge Active
					    </label>
			    	</div>						
				</div>
			</div>

			<div class="row">
			    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="is_for_collection_deactive" name="is_for_collection" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		$display_status_class = 'child-checkbox-div-hide';
					    		if ($is_for_collection == 1) {
					    			$check = 'checked';
					    			$display_status_class = 'child-checkbox-div-show';
					    		}
					    	?>
					    	<input type="checkbox" id="is_for_collection_active" name="is_for_collection" value="1" <?= $check ?> >Collection Packaging Charge
					    </label>
			    	</div>
				    <div class="collection-child-checkbox-div <?= $display_status_class ?>">
				    	<div class="row">
				    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    	<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="collection_packaging_charge" name="collection_packaging_charge" value="<?= $collection_packaging_charge ?>">
						    	</div>
				    		</div>
				    	</div>
				    </div>
			    </div>

			    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="is_for_delivery_deactive" name="is_for_delivery" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		$display_status_class = 'child-checkbox-div-hide';
					    		if ($is_for_delivery == 1) {
					    			$check = 'checked';
					    			$display_status_class = 'child-checkbox-div-show';
					    		}
					    	?>
					    	<input type="checkbox" id="is_for_delivery_active" name="is_for_delivery" value="1" <?= $check ?> >Delivery Packaging Charge
					    </label>
			    	</div>
				    <div class="delivery-child-checkbox-div <?= $display_status_class ?>">
				    	<div class="row">
				    		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    	<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="delivery_packaging_charge" name="delivery_packaging_charge" value="<?= $delivery_packaging_charge ?>">
						    	</div>
				    		</div>
				    	</div>
				    </div>
			    </div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg"><?= empty($packaging_charge_value) ? 'Save' : 'Update' ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>