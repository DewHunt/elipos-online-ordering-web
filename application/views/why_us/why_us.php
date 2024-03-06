<div id="main-contanier">
    <div id="content-wrap">
        <div id="content-block">
            <div class="cmspage_content">
                <h1 class="text-color">Why Us</h1>


                <div class="cmspage_content_left">
                    <div class="cmspage_content_left">
                        <?=$page_details->content?>
                    </div>
                </div>

                <?php
                if(!empty($page_details->image)){
                    ?>
                    <div class="cmspage_content_right">
                        <img src="<?= base_url($page_details->image) ?>" alt=""/>
                    </div>
                    <?php
                }

                ?>

            </div>
        </div>
    </div>

    <!--Scroll To Top-->
    <a href="#" class="typtipstotop"></a>


</div>


<script type="text/javascript">


</script>
