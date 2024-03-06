<style type="text/css">
	.tips-name-block .tips-name { float: left; }
	.tips-name-block .tips-btn { float: right; }
</style>
<div class="list-group">
	<?php if ($tips_lists): ?>
		<?php foreach ($tips_lists as $tips): ?>
			<?php if ($tips->status == 1): ?>				
	  			<li class="list-group-item">
	  				<div class="tips-name-block">
		  				<span class="tips-name"><?= $tips->name ?></span>
		  				&nbsp;&nbsp;&nbsp;<span class="tips-amount"><?= get_price_text(number_format($tips->amount, 2)) ?></span>
		  				<button type="submit" class="btn btn-outline-success btn-sm tips-btn btn-process-payment text-right" tips-id="<?= $tips->id ?>"><i class="fa fa-plus"></i></button>
	  				</div>
	  				<div class="tip-description"><?= $tips->description ?></div>
	  			</li>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
</div>