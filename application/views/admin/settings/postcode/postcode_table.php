<?php
	$postcode_model = new Postcode_Model();
	// echo "<pre>"; print_r($links); exit();
?>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="thead-default">
            <tr>
                <th class="text-center" width="70px">SN</th>
                <th class="text-center">Postcode</th>
                <th class="text-center" width="130px">Latitude</th>
                <th class="text-center" width="130px">Longitude</th>
                <th class="text-center" width="130px">Distance (Miles)</th>
                <th class="text-center" width="100px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1 ?>
            <?php if (!empty($postcodes_list)): ?>
                <?php foreach ($postcodes_list as $postcode): ?>
                    <tr>
                        <td class="text-center"><?= $count++ ?></td>
                        <td><?= $postcode->postcode ?></td>
                        <td class="text-right"><?= $postcode->latitude ?></td>
                        <td class="text-right"><?= $postcode->longitude ?></td>
                        <td class="text-right"><?= $postcode->distance ?></td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-primary" id="postcode_btn" href="javaScript:void(0);" postcode_id="<?= $postcode->id ?>" form-type="edit"><i class="fa fa-eye"></i></span>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div  class="container-fluid" style="margin-top: 40px;">
            <input type="hidden" name="limit" id="limit" value="<?= $limit ?>">
            <input type="hidden" name="start" id="start" value="<?= $start ?>">
            <?php
                $text_limit = $limit;
                if (isset($total_search_postcode) && $total_search_postcode > 0) {
                    $text_limit = $total_search_postcode;
                }
            ?>
            Showing 1 to <?= $text_limit ?> of <?= $total_postcodes ?> Entries
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
        <div class="form-group">
            <p><?php echo $links; ?></p>
        </div>
    </div>
</div>