<div id="welcome_wrap">
    <div id="welcome_block">

        <?php
        $shop_details=get_company_details();


        ?>
        <div class="page_heading">  <?=get_property_value('company_name',$shop_details)?> In the heart of
 <span class="color_green text_bold"><?=get_property_value('city',$shop_details)?></span></div>
        <div id="welcome_boxes">
            <div id="welcome_boxes_left">
                <a><img src="<?= base_url('assets/images/home-welcome/1.jpg') ?>" alt=""/></a>
            </div>



            <div id="welcome_boxes_right">
                <div id="welcome_boxes_right_column1">
                    <div id="welcome_boxes_right_column1_adv_show">
                        <a><img src="<?= base_url('assets/images/home-welcome/2.jpg') ?>" alt=""/></a>
                    </div>


                    <div id="welcome_boxes_right_column1_adv_show">
                        <a><img src="<?= base_url('assets/images/home-welcome/3.jpg') ?>" alt="" class="top_gap"/></a>
                    </div>
                </div>



                <div id="welcome_boxes_right_column2">
                    <div id="welcome_boxes_right_column2_adv_show">
                        <a>
                            <img src="<?= base_url('assets/images/home-welcome/4.jpg') ?>" alt=""/>
                            </a>
                    </div>

                    <div id="welcome_boxes_right_column2_adv_show">
                        <a href="<?= base_url('menu')?>"><img src="<?= base_url('assets/images/home-welcome/5.jpg') ?>" alt="" class="top_gap"/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>