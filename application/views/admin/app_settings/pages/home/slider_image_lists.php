<div class="row">
    <?php foreach ($slider_images as $slider_image): ?>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <img src="<?= $slider_image; ?>" class="slider-img">
            <button class="btn btn-danger btn-sm btn-block del-btn img-del-btn" del-for="slider-img" img-path="<?= $slider_image; ?>">Delete</button>
        </div>
    <?php endforeach ?>
</div>