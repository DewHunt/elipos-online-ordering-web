<style>
    .text-line ul li { list-style-type: disc; margin-left: 30px; }
</style>
<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content text-line">
                <div class="cmspage_content_left"><?= $page_details->content ?></div>

                <?php if ($page_details->image): ?>
                    <div class="cmspage_content_right">
                        <img src="<?= base_url($page_details->image) ?>" alt=""/>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <!--Scroll To Top-->
    <a href="#" class="typtipstotop"></a>
</div>