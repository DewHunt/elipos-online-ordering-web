<?php
    $home_promo=$this->Settings_Model->get_by(array("name" => 'home_promo'), true);
    if (!empty($home_promo)) {
        $home_promo = json_decode($home_promo->value);
    } else {
        $home_promo = '';
    }
?>

<?php if (!empty($home_promo)): ?>
    <?php if (is_home_promo_active()): ?>
        <?php
            $image_url = get_property_value('promo_image',$home_promo);
            $button_url = get_property_value('button_url',$home_promo);
            $button_text = get_property_value('button_text',$home_promo);
            $description = get_property_value('description',$home_promo);
            $promo_image_link = get_property_value('promo_image_link',$home_promo);
            $title = get_property_value('title',$home_promo);
        ?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>Promo</title>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
				<!-- jQuery library -->
				<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
				<!-- Popper JS -->
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
				<!-- Latest compiled JavaScript -->
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
			</head>

			<body>
				<div class="container">
			        <div class="card">
			        	<?php if ($image_url): ?>
			        		<?php if ($promo_image_link): ?>
			        			<a target="_blank" href="<?= $promo_image_link ?>">
			        				<img class="rounded img-responsive card-img-top" src="<?= base_url($image_url) ?>">
			        			</a>
			        		<?php else: ?>
			        			<img class="rounded img-responsive card-img-top" src="<?= base_url($image_url) ?>">
			        		<?php endif ?>
			        	<?php endif ?>

			            <div class="card-body">
			            	<?php if ($description): ?>
			            		<p class="card-text text-justify"><?= $description ?></p>
			            	<?php endif ?>

			                <?php if ($button_url): ?>
			                	<div class="text-right">
				                    <a class="btn btn-outline-success btn-lg" target="_blank" href="<?= $button_url ?>">
				                        <?= (empty($button_text)) ? 'Goto' : $button_text ?>
				                    </a>
			                	</div>
			                <?php endif ?>
			            </div>
			        </div>
				</div>
			</body>
		</html>
    <?php endif ?>
<?php endif ?>
