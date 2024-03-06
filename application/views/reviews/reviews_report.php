<?php
	list($totalRatings,$fiveStarAvg,$fourStarAvg,$threeStarAvg,$twoStarAvg,$oneStarAvg,$averageRatings) = $reviews_reports;
?>

<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12 mb-2">
        <div class="progress-container">
            <div class="progress-label">5</div>
            <div class="progress-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $fiveStarAvg ?>%"></div>
                </div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-label">4</div>
            <div class="progress-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $fourStarAvg ?>%"></div>
                </div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-label">3</div>
            <div class="progress-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $threeStarAvg ?>%"></div>
                </div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-label">2</div>
            <div class="progress-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $twoStarAvg ?>%"></div>
                </div>
            </div>
        </div>

        <div class="progress-container">
            <div class="progress-label">1</div>
            <div class="progress-body">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" style="width: <?= $oneStarAvg ?>%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 mb-2 text-center">
        <h1 class="avg-ratings"><?= $averageRatings ?></h1>
        <div class="avg-rating-star">
            <i class="fa <?= $averageRatings >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
            <i class="fa <?= ($averageRatings > 1 && $averageRatings < 2) ? 'fa-star-half-o' : ($averageRatings >= 2 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
            <i class="fa <?= ($averageRatings > 2 && $averageRatings < 3) ? 'fa-star-half-o' : ($averageRatings >= 3 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
            <i class="fa <?= ($averageRatings > 3 && $averageRatings < 4) ? 'fa-star-half-o' : ($averageRatings >= 4 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
            <i class="fa <?= ($averageRatings > 4 && $averageRatings < 5) ? 'fa-star-half-o' : ($averageRatings >= 5 ? 'fa-star' : 'fa-star-o') ?>" aria-hidden="true"></i>
        </div>
        <p class="total-posts"><?= $totalRatings ?> posts</p>
    </div>
</div>