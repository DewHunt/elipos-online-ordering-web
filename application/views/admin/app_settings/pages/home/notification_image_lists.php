<div class="row">
    <?php foreach ($notification_images as $notification_image): ?>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <img src="<?= $notification_image; ?>" class="notification-img">
            <button class="btn btn-danger btn-sm btn-block del-btn img-del-btn" del-for="notification-img" img-path="<?= $notification_image; ?>">Delete</button>
        </div>
    <?php endforeach ?>
</div>