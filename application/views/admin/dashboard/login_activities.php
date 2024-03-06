<?php if ($is_panel_view): ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h2>Login/Logout Report</h2></div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">View All</button>
				</div>
			</div>
			
		</div>
	    <div class="panel-body">
<?php endif ?>
	    	<div class="table-responsive">
	    		<table class="table table-striped table-bordered table-hover table-condensed">
	    			<thead>
	    				<tr>
	    					<th class="text-center" width="50px">SL</th>
	    					<th class="text-center" width="200px">Time</th>
	    					<th class="text-center">Login Information</th>
	    					<th class="text-center" width="200px">IP Address</th>
	    				</tr>
	    			</thead>

	    			<tbody>
	    				<?php $sl = 1; ?>
	    				<?php foreach ($login_activities as $activity): ?>
	    					<?php
	    						$user_name_or_email = $activity->user_name_or_email;
	    					?>
	    					<tr>
	    						<td><?= $sl++; ?></td>
	    						<?php if ($activity->user_id > 0): ?>
	    							<?php if ($activity->login_time): ?>
			    						<td class="text-center"><?= date('jS M Y h:i A', strtotime(($activity->login_time))) ?></td>
			    						<td class="success-note">Success Login Attempt [<?= $user_name_or_email ?>]</td>
	    							<?php else: ?>
			    						<td class="text-center"><?= date('jS M Y h:i A', strtotime(($activity->logout_time))) ?></td>
			    						<td class="failed-note">Success Logout Attempt [<?= $user_name_or_email ?>]</td>
	    							<?php endif ?>
	    						<?php else: ?>
		    						<td class="text-center"><?= date('jS M Y h:i A', strtotime(($activity->login_time))) ?></td>
		    						<td class="failed-note">Failed Login Attempt [<?= $user_name_or_email ?>]</td>
	    						<?php endif ?>
	    						<td class="text-center"><?= $activity->ip_address ?></td>
	    					</tr>
	    				<?php endforeach ?>
	    			</tbody>
	    		</table>
	    	</div>
<?php if ($is_panel_view): ?>
	    </div>
	</div>
<?php endif ?>