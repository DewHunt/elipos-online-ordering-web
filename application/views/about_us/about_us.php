<style>
    #content-wrap{ padding: 0; }
    .pace-progress{ display: none !important; }
    .header-title{ display: none !important; }
</style>

<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
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
    <!--Scroll To Top-->

    <!--Scroll To Top-->
    <a href="#" class="typtipstotop"></a>
    <!--Scroll To Top-->

    <div id="background-on-popup"></div>
</div>