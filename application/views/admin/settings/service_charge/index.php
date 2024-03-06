<style type="text/css">
	.collection-child-checkbox-div { padding-left: 25px; }
	.delivery-child-checkbox-div { padding-left: 25px; }
	.checkbox-ml { margin-left: 10px; }
	.child-checkbox-div-hide { display: none; }
	.child-checkbox-div-show { display: block; }
	.form-horizontal .control-label { text-align: left !important; }
</style>

<div class="panel panel-default">
	<div class="panel-heading"><h4>Service Charge</h4></div>

	<div class="panel-body">
		<form class="form-horizontal" id="service-charge-form" action="<?= base_url('admin/settings/service_charge_save') ?>" method="post">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="is_service_charge_applicable_deactive" name="is_service_charge_applicable" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		if ($is_service_charge_applicable == 1) {
					    			$check = 'checked';
					    		}
					    	?>
					    	<input type="checkbox" id="is_service_charge_applicable_active" name="is_service_charge_applicable" value="1" <?= $check ?> >Is The Service Charge Active
					    </label>
			    	</div>						
				</div>
			</div>

			<div class="row">
			    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="for_collection_deactive" name="for_collection" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		$display_status_class = 'child-checkbox-div-hide';
					    		if ($for_collection == 1) {
					    			$check = 'checked';
					    			$display_status_class = 'child-checkbox-div-show';
					    		}
					    	?>
					    	<input type="checkbox" id="for_collection_active" name="for_collection" value="1" <?= $check ?> >Collection Service Charge
					    </label>
			    	</div>
				    <div class="collection-child-checkbox-div <?= $display_status_class ?>">
				    	<div class="row">
				    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				    			<div class="form-group">
								    <input type="hidden" id="collection_cash_deactive" name="is_active_collection_cash" value="0">
								    <label class="checkbox-inline">
								    	<?php
								    		$check = '';
								    		if ($is_active_collection_cash == 1) {
								    			$check = 'checked';
								    		}
								    	?>
								    	<input type="checkbox" class="collection-child" id="collection_cash_active" name="is_active_collection_cash" value="1" <?= $check ?> >Service Charge For Cash
								    </label>
				    			</div>
						    	<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="collection_cash_charge" name="collection_cash_charge" value="<?= $collection_cash_charge ?>">
						    	</div>
				    		</div>

				    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				    			<div class="form-group">
								    <input type="hidden" id="collection_card_deactive" name="is_active_collection_card" value="0">
								    <label class="checkbox-inline">
								    	<?php
								    		$check = '';
								    		if ($is_active_collection_card == 1) {
								    			$check = 'checked';
								    		}
								    	?>
								    	<input type="checkbox" class="collection-child" id="collection_card_active" name="is_active_collection_card" value="1" <?= $check ?> >Service Charge For Card
								    </label>
						    	</div>

				    			<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="collection_card_charge" name="collection_card_charge" value="<?= $collection_card_charge ?>">
						    	</div>
				    		</div>
				    	</div>
				    </div>
			    </div>

			    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="for_delivery_deactive" name="for_delivery" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		$display_status_class = 'child-checkbox-div-hide';
					    		if ($for_delivery == 1) {
					    			$check = 'checked';
					    			$display_status_class = 'child-checkbox-div-show';
					    		}
					    	?>
					    	<input type="checkbox" id="for_delivery_active" name="for_delivery" value="1" <?= $check ?> >Delivery Service Charge
					    </label>
			    	</div>
				    <div class="delivery-child-checkbox-div <?= $display_status_class ?>">
				    	<div class="row">
				    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						    	<div class="form-group">
								    <input type="hidden" id="delivery_cash_deactive" name="is_active_delivery_cash" value="0">
								    <label class="checkbox-inline">
								    	<?php
								    		$check = '';
								    		if ($is_active_delivery_cash == 1) {
								    			$check = 'checked';
								    		}
								    	?>
								    	<input type="checkbox" class="delivery-child" id="delivery_cash_active" name="is_active_delivery_cash" value="1" <?= $check ?> >Service Charge For Cash
								    </label>
						    	</div>

						    	<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="delivery_cash_charge" name="delivery_cash_charge" value="<?= $delivery_cash_charge ?>">
						    	</div>
				    		</div>

				    		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						    	<div class="form-group">
								    <input type="hidden" id="delivery_card_deactive" name="is_active_delivery_card" value="0">
								    <label class="checkbox-inline checkbox-ml">
								    	<?php
								    		$check = '';
								    		if ($is_active_delivery_card == 1) {
								    			$check = 'checked';
								    		}
								    	?>
								    	<input type="checkbox" class="delivery-child" id="delivery_card_active" name="is_active_delivery_card" value="1" <?= $check ?> >Service Charge For Card
								    </label>
						    	</div>

						    	<div class="form-group">
							    	<input type="number" min="0" step="0.01" class="form-control" id="delivery_card_charge" name="delivery_card_charge" value="<?= $delivery_card_charge ?>">
						    	</div>
				    		</div>
				    	</div>
				    </div>
			    </div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-lg"><?= empty($service_charge_value) ? 'Save' : 'Update' ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>