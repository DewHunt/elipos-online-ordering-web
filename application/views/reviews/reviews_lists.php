
<div class="row">
    <?php foreach ($all_feedbacks as $feedback): ?>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="media border p-3 mb-2">
                <img src="<?= base_url('assets/images/avatar.jpg') ?>" alt="John Doe" class="mr-3 rounded-circle" style="width:40px;">
                <div class="media-body">
                    <h5><?= $feedback->name ?> <small><i>Posted on <?= $feedback->created_at ?></i></small></h5>
                    <p>
                        <i class="fa <?= $feedback->ratings >= 1 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        <i class="fa <?= $feedback->ratings >= 2 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        <i class="fa <?= $feedback->ratings >= 3 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        <i class="fa <?= $feedback->ratings >= 4 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                        <i class="fa <?= $feedback->ratings >= 5 ? 'fa-star' : 'fa-star-o' ?>" aria-hidden="true"></i>
                    </p>
                    <p><?= $feedback->choosed_order_types ?></p>
                    <p class="message"><?= $feedback->message ?></p>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>