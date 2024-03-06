<style>
    .promo-button{ float: right; margin:10px 0px; padding: 0px 5px; }
    .promo-button a {
        margin: 0 0 0 0;
        padding: 0 15px;
        float: left;
        font-family: "Oswald",Arial,sans-serif;
        color: #fff;
        font-weight: normal;
        font-size: 16px;
        border: none;
        cursor: pointer;
        line-height: 34px;
        width: auto;
        height: 34px;
        background-color: green;
    }
    .promo-modal-mt { margin-top: 5vh; }
    #promo-modal a img{ width: 100%;      }
    .promo-banner .close { color: #fff !important; }    
    @media screen and (min-width: 1920px) {
        .promo-banner { margin-top: 35% !important; }
    }
    @media  screen and (max-width: 1366px) {
        .promo-banner { margin-top: 25% !important; }
    }
    /* Portrait and Landscape */
    @media only screen and (min-device-width: 1024px) and (max-device-width: 1366px) and (-webkit-min-device-pixel-ratio: 2) {
        .promo-banner { margin-top: 32% !important; }
    }
    @media only screen and (-webkit-min-device-pixel-ratio: 2) and (max-device-width: 568px) and (min-device-width: 320px) {
        .promo-banner { margin-top: 52% !important; }
    }
    @media only screen and (max-device-width: 667px) and (min-device-width: 375px) {
        .promo-banner { margin-top: 48% !important; }
    }
    @media only screen and (-webkit-min-device-pixel-ratio: 3) and (max-device-width: 812px) and (min-device-width: 375px){
        .promo-banner { margin-top: 48% !important; }
    }
</style>

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
        <div class="modal fade promo-modal-mt" id="promo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg promo-banner" >
                <div class="modal-content" >
                    <div class="modal-body" style="padding:0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: fixed; top: -6px;right: 2px; z-index: 999; font-size: 35px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="card" style="padding: 0;border: none">
                            <?php
                                if (!empty($image_url)) {
                                    if (!empty($promo_image_link)) {
                                        echo sprintf(' <a target="_blank" href="%s"><img class="rounded img-responsive card-img-top" src="%s" alt="Promo Image"></a>',$promo_image_link,base_url($image_url));
                                    } else {
                                        echo sprintf(' <img  class="rounded img-responsive card-img-top" src="%s" alt="Promo Image">',base_url($image_url));
                                    }
                                }
                            ?>

                            <div class="card-body">
                                <?php
                                    if (!empty($description)) {
                                        echo sprintf('<div class="" style="margin: 10px 0px; padding: 0 5px; text-align: justify">%s</div>',$description);
                                    }
                                ?>

                                <?php if (!empty($button_url)): ?>                                    
                                    <div  class="promo-button">
                                        <a target="_blank" href="<?=$button_url?>" class="">
                                            <?= (empty($button_text)) ? 'Goto' : $button_text ?>
                                        </a>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#promo-modal').modal('show');
            });
        </script>
    <?php endif ?>
<?php endif ?>