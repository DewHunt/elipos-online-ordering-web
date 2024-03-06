<?php
    $rating_taste = $feedback->rating_taste;
    $rating_service = $feedback->rating_service;
    $rating_price = $feedback->rating_price;
    $ratings = $feedback->ratings;
?>

<div class="modal-body">
    <table class="feedback-tab">
        <thead>
            <tr><th colspan="4"><h4>Feedback</h4></th></tr>
        </thead>

        <tbody>
            <tr>
                <td class="txt-center">
                    <label>Date</label>
                    <div class="data-div"><?= get_formatted_time($feedback->created_at,'d F Y'); ?></div>
                </td>
                <td class="txt-center">
                    <label>Name</label>
                    <div class="data-div"><?= $feedback->name ?></div>
                </td>
                <td class="txt-center">
                    <label>Status</label>
                    <div class="data-div"><?= $feedback->is_approved ? 'Appeoved' : 'Pending' ?></div>
                </td>
                <td class="txt-center">
                    <label>Email</label>
                    <div class="data-div"><?= $feedback->email ?></div>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">Food</div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                            <i class="fa <?= $rating_taste >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_taste >= 2 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_taste >= 3 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_taste >= 4 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_taste >= 5 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">Service</div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                            <i class="fa <?= $rating_service >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_service >= 2 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_service >= 3 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_service >= 4 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_service >= 5 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">Atmosphere</div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                            <i class="fa <?= $rating_price >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_price >= 2 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_price >= 3 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_price >= 4 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                            <i class="fa <?= $rating_price >= 5 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <label>Ratings</label>
                    <div class="data-div">
                        <h3><?= $ratings ?></h3>
                        <i class="fa <?= $ratings >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        <i class="fa <?= ($ratings > 1 && $ratings < 2) ? 'fa-star-half-o' : ($ratings >= 2 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
                        <i class="fa <?= ($ratings > 2 && $ratings < 3) ? 'fa-star-half-o' : ($ratings >= 3 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
                        <i class="fa <?= ($ratings > 3 && $ratings < 4) ? 'fa-star-half-o' : ($ratings >= 4 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
                        <i class="fa <?= ($ratings > 4 && $ratings < 5) ? 'fa-star-half-o' : ($ratings >= 5 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
                    </div>
                </td>                
                <td class="txt-center" width="350px" colspan="2">
                    <label>Message</label>
                    <div class="data-div"><?= $feedback->message ?></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<div class="modal-footer">
	<?php
		$status = 'Approved';
		$btn_class = 'btn-success';
		if ($feedback->is_approved == 1) {
    		$status = 'Pending';
    		$btn_class = 'btn-warning';
		}
	?>
	<button type="button" class="btn <?= $btn_class ?> btn-sm btn-status" feedback-id="<?= $feedback->id ?>" feedback-status="<?= $feedback->is_approved ?>">
        <?= $status ?>
    </button>
    <button type="button" class="btn btn-danger btn-sm btn-delete" feedback-id="<?= $feedback->id ?>">Delete</button>
    <button type="button" class="btn btn-sm btn-close" data-dismiss="modal">Close</button>
</div>

