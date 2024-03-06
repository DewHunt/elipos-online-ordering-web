<script src="<?= base_url('assets/jquery/additional-methods.min.js') ?>"></script>

<div class="card">
    <div class="cart-title">My Order - <?= $title ?></div>
    <div class="card-body">
    	<?php
    		//echo "<pre>"; print_r(json_decode($request_data));
    		// echo "<pre>"; print_r(json_decode($response));
    		echo "<pre>"; print_r($response->transaction->transactionId);
    		echo "<pre>"; print_r($response);
    	?>
    </div>
</div>

<div style="margin-bottom: 20px;"></div>