<?php
    $home_promo = $this->Settings_Model->get_by(array("name" => 'home_promo'), true);
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
		<style>
			body { font-family: Arial, Helvetica, sans-serif; }
			.mod {
				display: none;
				position: fixed;
				z-index: 99999;
				padding-top: 100px;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				overflow: auto;
				background-color: rgb(0,0,0);
				background-color: rgba(0,0,0,0.4);
			}
			.mod-content {
				position: relative;
				background-color: #fefefe;
				margin: auto;
				padding: 0;
				border: 1px solid #888;
				border-radius: 8px;
				width: 60%;
				box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
				-webkit-animation-name: animatetop;
				-webkit-animation-duration: 0.4s;
				animation-name: animatetop;
				animation-duration: 0.4s;
			}
			@-webkit-keyframes animatetop {
				from { top: -300px; opacity: 0 }
				to { top: 0; opacity:1}
			}
			@keyframes animatetop {
				from { top: -300px; opacity : 0 }
				to { top: 0; opacity: 1 }
			}
			.mod-close {
				color: #fff;
				float: right;
				font-size: 28px;
				font-weight: bold;
				/*background: #656768;*/
				background: transparent;
				width: 30px;
				height: 30px;
				line-height: 27px;
				border-radius: 50%;
				padding: 0px 0px 0px 8px;
				position: absolute;
			    top: 17px;
			    right: 12px;
			    z-index: 999;
			}
			.mod-close:hover, .mod-close:focus { color: #fff; background-color: red; text-decoration: none; cursor: pointer; }
			.mod-head { padding: 2px 16px; background-color: #fff; color: #000; }
			.mod-body { padding: 7px; }
			.mod-footer { padding: 2px 16px; background-color: #fff; color: #000; }
			.mod-btn:hover { color: #fff; background-color: #28a745; border-color: #28a745 }
			.mod-body-content { padding: 15px; }
			.mod-img-top { border-radius: 8px; display: block; margin-top: 5px; margin-left: auto; margin-right: auto; width: 100%; }

			.txt-right { text-align: right; }
			.txt-left { text-align: left; }
			.txt-center { text-align: center; }
			.txt-justify { text-align: justify; }
			.mod-btn {
				display: inline-block;
				font-weight: bold;
				text-align: center;
				vertical-align: middle;
				user-select: none;
				background-color: transparent;
				border: 1px solid transparent;
				border-color: #28a745;
				color: #28a745;
				font-size: 14px;
				padding: 15px;
				line-height: 15px;
				border-radius: 5px;
			}
		</style>

		<button id="myBtn" style="display: none;">Open Modal</button>

		<div id="promoMod" class="mod">
			<div class="mod-content">
				<!-- <div class="mod-head"><span class="mod-close">&times;</span></div> -->
				<div class="mod-body">
					<span class="mod-close" id="mod-btn-close">&times;</span>
		        	<?php if ($image_url): ?>
		        		<?php if ($promo_image_link): ?>
		        			<a target="_blank" href="<?= $promo_image_link ?>">
		        				<img class="mod-img-top" src="<?= base_url($image_url) ?>">
		        			</a>
		        		<?php else: ?>
		        			<img class="mod-img-top" src="<?= base_url($image_url) ?>">
		        		<?php endif ?>
		        	<?php endif ?>

		            <div class="mod-body-content">
		            	<?php if ($description): ?>
		            		<p class="txt-justify"><?= $description ?></p>
		            	<?php endif ?>

		                <?php if ($button_url): ?>
		                	<div class="txt-right">
			                    <a class="mod-btn" target="_blank" href="<?= $button_url ?>">
			                        <?= (empty($button_text)) ? 'Goto' : $button_text ?>
			                    </a>
		                	</div>
		                <?php endif ?>
		            </div>
			    </div>
			</div>
		</div>

        <script type="text/javascript">
			var modal = document.getElementById("promoMod");
			var btn = document.getElementById("myBtn");
			var span = document.getElementsByClassName("mod-close")[0];			 
			modal.style.display = "block";
			btn.onclick = function() { modal.style.display = "block"; }
			span.onclick = function() { modal.style.display = "none"; }
			window.onclick = function(event) {
				if (event.target == modal) { modal.style.display = "none"; }
			}
		</script>
    <?php endif ?>
<?php endif ?>
