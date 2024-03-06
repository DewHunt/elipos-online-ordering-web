<?php
	$accept_example = "<p>Great News!</p>
		<p>Your reservation has been accepted by (businessName).</p>
		<p>We look forward to welcoming you on (dayName), (date) at (time) for (amountOfPeople) guest.</p>
		<p>Please be aware we are not licensed but have a variety of soft drinks available. You are allowed to bring alcohol but not soft drinks.</p>
		<p>I look forward to seeing you!</p>";
	$reject_example = "<p>Bad News!</p>
		<p>We are sorry but we will not be able to accommodate your reservation request for (dayName), (date),(time) at this present time.</p>
		<p>Please feel free to call the restaurant and ask for alternative times on (contactNumber).</p>
		<p>I look forward to seeing you another time!</p>";
?>
<style type="text/css">
	.validity-div-hide { display: none; }
	.validity-div-show { display: block; }
	.form-horizontal { text-align: left !important; }
	.datepicker, .table-condensed { width: 100%; height: auto; }
	.table-condensed { border: 1px solid #008000; border-collapse: collapse; }
	.datepicker .datepicker-switch, .datepicker .prev, .datepicker .next {
		cursor: pointer;
		background: linear-gradient(rgb(0, 128, 0, 0.8),rgb(0, 133, 0, 0.6)) !important;
		color: #0c0c0c;
		border-radius: 0px;
		margin: 5px;
		border: 1px solid #008000;
	}
	.closing-year { background: #044104; color: #ffffff; text-align: center; padding: 5px; text-align: center; }
	.closing-month-container { display: flex; text-align: center; }
	.closing-month { background: #008000; color: #ffffff; border: 1px solid #044104; flex: 1; padding-top: 5px; }
	.closing-date { background: #eeeeee; color: #0c0c0c; margin-top: 5px; padding: 5px; }
	.example-msg-pop { float: right !important; font-weight: bold; color: #ff0000; cursor: pointer; }
</style>


<form class="form-horizontal" id="booking-settings-form" action="<?= base_url('admin/settings/booking_settings_save') ?>" method="post">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-6">
					<h4>Booking Settings</h4>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 text-right">
					<button type="submit" class="btn btn-primary"><?= empty($booking_settings_value) ? 'Save' : 'Update' ?></button>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			    	<div class="form-group">
					    <input type="hidden" id="is_closed_deactive" name="is_closed" value="0">
					    <label class="checkbox-inline">
					    	<?php
					    		$check = '';
					    		if ($is_closed == 1) {
					    			$check = 'checked';
					    		}
					    	?>
					    	<input type="checkbox" id="is_closed_active" name="is_closed" value="1" <?= $check ?> >Is The Booking Closed?
					    </label>
			    	</div>						
				</div>
			</div>

			<div class="validity-div <?= empty($booking_settings_value) ? 'validity-div-hide' : 'validity-div-show' ?>">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
	                    <div class="form-group">
	                    	<label>Select Closing Dates</label>
	                        <div id="calender" data-date="<?= $closing_date ?>"></div>
	                        <input type="hidden" class="form-control" id="closing_date" name="closing_date">
	                    </div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				    	<div class="form-group">
				    		<label for="message">Message</label>
				    		<textarea class="form-control" rows="2" id="message" name="message"><?= $message ?></textarea>
				    	</div>
				    	<div class="form-group">
				    		<label for="message">Current Closing Dates</label>
				    		<?php if ($sorted_dates): ?>				    			
			    				<?php foreach ($sorted_dates as $year => $months): ?>
			    					<div class="closing-year"><?= $year ?></div>
			    					<div class="closing-month-container">
				    					<?php foreach ($months as $month => $dates): ?>
				    						<div class="closing-month">
				    							<?= date('F', mktime(0, 0, 0, $month, 10)) ?>
				    							<div class="closing-date"><?= implode(', ', $dates) ?></div>
				    						</div>
				    					<?php endforeach ?>
			    					</div>
			    					<br>
			    				<?php endforeach ?>				    			
				    		<?php else: ?>
				    			<div class="closing-year">Closing Dates Not Found</div>
				    		<?php endif ?>
				    	</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="accepted-message">Accepted Message</label>
						<span class="pull-right example-msg-pop" data-placement="left" data-toggle="accept-msg-ex" title="Accepted Message Example" data-content="<?= $accept_example ?>">See Example</span>
						<textarea rows="3" class="form-control" name="accepted_message" id="accepted-message"><?= $accepted_message ?></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="rejected-message">Rejected Message</label>
						<span class="pull-right example-msg-pop" data-placement="left" data-toggle="reject-msg-ex" title="Rejected Message Example" data-content="<?= $reject_example ?>">See Example</span>
						<textarea rows="3" class="form-control" name="rejected_message" id="rejected-message"><?= $rejected_message ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>