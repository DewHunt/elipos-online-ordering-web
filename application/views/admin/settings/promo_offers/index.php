<style type="text/css">
	.web-images { width: 100px; height: 100px; }
	.apps-images { width: 100px; height: 100px; }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><h4><?= $title ?></h4></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <a class="btn btn-info" href="<?= base_url('admin/promo_offers/add') ?>"><i class="fa fa-plus" aria-hidden="true"></i> Add Promo Offers</a>
            </div>
        </div>
    </div>

    <div class="panel-body">
	    <table class="table table-striped table-bordered dt-responsive list-dt" id="details-table">
	        <thead class="thead-default">
	            <tr>
	                <th width="20px" class="text-center">SL</th>
	                <th class="text-center">Date</th>
	                <th width="150px" class="text-center">Web Image</th>
	                <th width="150px" class="text-center">Apps Image</th>
	                <th width="100px" class="text-center">Sort Order</th>
	                <th width="150px" class="text-center">Action</th>
	            </tr>
	        </thead>

	        <tbody>
	            <?php $sl = 1 ?>
	            <?php foreach ($promo_offer_list as $promo_offer): ?>                            
	                <tr>
	                    <td><?= $sl++ ?></td>
	                    <td><?= date('Y-m-d', strtotime($promo_offer->start_date)) ?> - <?= date('Y-m-d', strtotime($promo_offer->end_date)) ?></td>
	                    <td class="text-center">
	                    	<img class="web-images" src="<?= base_url($promo_offer->web_image) ?>" alt="web-image">
	                    </td>
	                    <td class="text-center">
	                    	<img class="apps-images" src="<?= base_url($promo_offer->apps_image) ?>" alt="apps-image">
	                    </td>
	                    <td class="text-center"><?= $promo_offer->sort_order ?></td>
	                    <td class="text-center">
	                    	<?php
	                    		$status_str = 'Active';
	                    		$btn_class = 'btn-success';
	                    		if ($promo_offer->status == 0) {
	                    			$status_str = 'Deactive';
	                    			$btn_class = 'btn-danger';
	                    		}
	                    	?>
	                    	<button class="btn <?= $btn_class ?> btn-sm change-status po-status-<?= $promo_offer->id ?>" promo-offers-id="<?= $promo_offer->id ?>" promo-offers-status="<?= $promo_offer->status ?>">
	                    		<?= $status_str ?>
	                    	</button>
	                        <a href="<?= base_url("admin/promo_offers/edit/$promo_offer->id") ?>" class="btn btn-primary btn-sm">
	                            <i class=" fa fa-pencil-square-o" aria-hidden="true"></i>
	                        </a>
	                    </td>
	                </tr>
	            <?php endforeach ?>
	        </tbody>
	    </table>
    </div>
</div>