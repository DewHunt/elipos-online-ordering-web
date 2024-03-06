<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>

    <?php
    $companyDetails=get_company_details();
    ?>
    <link title="favicon" rel="icon" href="<?= base_url(get_property_value('favicon',$companyDetails)) ?>"/>
    <script src="<?= base_url('assets/jquery/jquery-2.2.4.min.js') ?>" type="text/javascript"></script>


<!--    <script src="<?/*= base_url('assets/lib/pace/pace.js') */?>" type="text/javascript"></script>
    <link type="text/css" href="<?/*= base_url('assets/lib/pace/pace.css') */?>" rel="stylesheet"/>-->
    <link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet"/>


    <link type="text/css" href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet"/>


    <link type="text/css" href="<?= base_url('assets/css/responsive-240-320.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-320-480.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-480-767.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-768-999.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-1000-1024.css') ?>" rel="stylesheet"/>


    <link type="text/css" href="<?= base_url('assets/css/new_style.css') ?>" rel="stylesheet"/>
    <!--For Menu Start-->
    <script type="text/javascript" src="<?= base_url('assets/js/sticky-sidebar/theia-sticky-sidebar.js') ?>"></script>




    <script src="<?= base_url('assets/bootstrap/js/tether.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <style type="text/css">
        .cuisinesearch-menu ul li a.active{
            border-bottom: 3px solid  #bc0f11;
            font-weight: 900;
            font-size: 130%;
        }
    </style>

</head>


<body class="body-frontend font-selector" style="background-color: #ffffff;">


<?php echo $shop_open_close_modal?>


<style>
    .modal-content {
        border: 10px solid grey ;
        background: #f8f8f8;
        border-radius: 0;

    }
    .fade.show {
        opacity: 1;
        background: rgba(5, 5, 5, 0.66);
    }
    .cuisinesearch-menu h1 {
        background: #bc0f11;
    }


    .cuisinesearch-menu ul li span.cuisinesearch-text a.active  {
        border-bottom: 3px solid #bc0f11;
    }
    .product-description p{
        float: left;
        color: #888;
        font-weight:300;
        line-height:1.3em;
        clear: both;
    }
    .itemdescription{
        margin: 0 !important;
    }

    .category-name{
        font-size: 1.5rem;
        color: #3b3b3b;
        font-weight:300;
    }
    

</style>

<div id="main-contanier">
    <div id="inner_header_wrap">
        <?php echo $main_navigation?>
    </div>

    <div class="menu-page">

        <?php

        $m_page_settings=new Page_Settings_Model();
        $review_page_details=$m_page_settings->get_by_name('reviews');
        $is_review_tab_show=$review_page_details->is_show;

        $menu_text=' Menu';
        $info_text='Info';
        $review_text='Reviews';

        $nav_link_style='';
        if(!$is_review_tab_show){
            $nav_link_style='style="padding:7px 50px;"';
        }

        $categories = $product_object->get_categories();
        $dealsCategories=$product_object->get_deals_categories();


        $products = $product_object->get_products();

        //print_array($products);

        $side_dishes = $product_object->get_side_dish();
        $all_sub_products = $product_object->get_all_sub_products();
        $dealsName=$product_object->get_offers_or_deals_name();
        $dealsId=str_replace(' ','-',$dealsName);
        ?>
        <div id="content-wrap">
            <div id="content-block">
                <?php
                $this->load->view('menu/info');
                if(is_shop_maintenance_mode()){
                    $is_shop_closed=true;
                    $is_pre_order=false;
                }else if(is_shop_weekend_off()){
                    $is_shop_closed=true;
                    $is_pre_order=false;
                }else{
                    $is_shop_closed=is_shop_closed();
                    $is_pre_order=is_pre_order();
                }

                $this->data['is_shop_closed']=$is_shop_closed;
                $this->data['is_pre_order']=$is_pre_order;
                $this->data['is_shop_maintenance_mode']=is_shop_maintenance_mode();

                ?>



                <div class="full-width-container">


                    <div class="col-lg-9 col-md-9  col-sm-12 col-xs-12 i-pad  ">
                        <div class="menutabarea">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active  " data-toggle="tab" href="#menu" role="tab" <?=$nav_link_style?>><?=$menu_text?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#info" role="tab" <?=$nav_link_style?>><?=$info_text?></a>
                                </li>
                                <?php
                                if($is_review_tab_show){
                                    ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#reviews-tab" role="tab"><?=$review_text?></a>
                                </li>
                                <?php
                                }
                                ?>

                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="menu" role="tabpanel"> <div class="menucontentarea" id="">
                                    <div class="menucontentarea_grid1" style="position: relative; min-height: 0px;">

                                        <div class="showcuisine theiaStickySidebar" style="padding-top: 0px; padding-bottom: 1px; position: static; top: 0px;">

                                            <div class="cuisinesearch-menu">

                                                <h1 class="text-xs-center">Categories</h1>
                                                <ul class="navbar-nav">
                                                    <?php
                                                    $order_type='both';
                                                    if(!empty($dealsCategories)){

                                                        $dealsName=$product_object->get_offers_or_deals_name();
                                                        $dealsId=str_replace(' ','-',$dealsName);
                                                        ?>
                                                        <li class="nav-item">
                                                    <span class="cuisinesearch-text">
                                                        <a class="nav-link" href="#category-id-<?=$dealsId?>" data-collapse-id="categoryCollapseId<?=$dealsId?>" data-heading-category-id="#headingCategory-<?=$dealsId?>">
                                                            <?=ucfirst($product_object->get_offers_or_deals_name())?></a>
                                                    </span>
                                                        </li>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if (!empty($categories)) {
                                                        $i=1;
                                                        $isOfferShowed=false;
                                                        foreach ($categories as $category) {
                                                                $order_type=$category->order_type;

                                                                ?>
                                                                <li class="nav-item">
                                                    <span class="cuisinesearch-text">
                                                        <a class="nav-link" href="#category-id-<?= $category->categoryId ?>" data-collapse-id="categoryCollapseId<?= $category->categoryId ?>" data-heading-category-id="#headingCategory-<?=$category->categoryId ?>">
                                                            <?= ($category->categoryName) ?></a>
                                                    </span>
                                                                </li>
                                                                <?php
                                                                $i++;

                                                            }

                                                    }
                                                    ?>
                                                </ul>




                                            </div>

                                        </div>

                                    </div>

                                    <div class="menucontentarea_grid2">

                                        <div class="showmenu">

                                            <div id="accordion-category" role="tablist" aria-multiselectable="true">

                                                <?php if (!empty($dealsCategories)) { ?>


                                                        <div class="clearfix" style="margin-top: .5rem">


                                                            <?php $products_list = $product_object->get_product_by_category_id($category->categoryId); ?>



                                                            <div class="card" id="category-id-<?=$dealsId?>">
                                                                <div class="card-header" role="tab" id="headingCategory-<?=$dealsId?>">
                                                                    <h5 class="mb-0">
                                                                        <a data-toggle="collapse" data-parent="#accordion-category" class="category-header" href="#categoryCollapseId<?=$dealsId ?>" aria-expanded="true" aria-controls="collapse<?=$dealsId?>">
                                                                            <div class="category-name">    <span class="" style="float: left"><?= ucfirst($dealsName) ?></span>
                                                                                <span class="expand-plus-minus" style="float: right"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                                            </div>
                                                                        </a>
                                                                    </h5>
                                                                </div>

                                                                <div id="categoryCollapseId<?=$dealsId?>" class="collapse " role="tabpanel" aria-labelledby="headingCategory-<?=$dealsId?>">
                                                                    <div class="card-block">
                                                                        <?php
                                                                        $this->data['dealsCategories']=$dealsCategories;
                                                                        $this->load->view('menu/deals_as_category',$this->data);
                                                                        ?>



                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>



                                                <?php }
                                                ?>
                                                <?php if (!empty($categories)) { ?>
                                                    <?php
                                                    $cat_id=1;
                                                    foreach ($categories as $category) {


                                                        ?>
                                                        <div class="clearfix" style="margin-top: .5rem">


                                                            <?php $products_list = $product_object->get_product_by_category_id($category->categoryId); ?>



                                                            <div class="card" id="category-id-<?=$category->categoryId ?>">
                                                                <div class="card-header" role="tab" id="headingCategory-<?=$category->categoryId ?>">
                                                                    <h5 class="mb-0">
                                                                        <a data-toggle="collapse" data-parent="#accordion-category" class="category-header" href="#categoryCollapseId<?=$category->categoryId ?>" aria-expanded="true" aria-controls="collapse<?=$category->categoryId ?>">
                                                                            <div class="category-name">    <span class="" style="float: left"><?= ucfirst($category->categoryName) ?></span>
                                                                                <span class="expand-plus-minus" style="float: right"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                                            </div>
                                                                        </a>
                                                                    </h5>
                                                                </div>

                                                                <div id="categoryCollapseId<?= $category->categoryId ?>" class="collapse " role="tabpanel" aria-labelledby="headingCategory-<?=$category->categoryId ?>">
                                                                    <div class="card-block">

                                                                     <?php
                                                                     $dataArray['category']=$category;
                                                                     $dataArray['is_shop_closed']=$is_shop_closed;
                                                                     $dataArray['is_pre_order']=$is_pre_order;
                                                                     $dataArray['cat_id']=$category->categoryId;
                                                                     $isPackage=$category->isPackage;
                                                                     $isPackageEntered=false;


                                                                     if($isPackage && !$isPackageEntered){
                                                                         $isPackageEntered=true;
                                                                         $this->load->view('menu/deals',$dataArray);

                                                                     }else{
                                                                         $products_list = $product_object->get_product_by_category_id($category->categoryId);


                                                                         $dataArray['products_list']=$products_list;

                                                                         $this->load->view('menu/product_as_category',$dataArray);
                                                                     }


                                                                     ?>

                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>
                                                    <?php } ?>


                                                <?php }
                                                ?>
                                            </div>

                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="tab-pane fade" id="info" role="tabpanel">
                                <?php
                                $this->load->view('menu/tab_info',$this->data);
                                ?>

                            </div>

                            <?php
                            if($is_review_tab_show){
                                ?>
                                <div class="tab-pane fade" id="reviews-tab" role="tabpanel">
                                    <div class="clearfix"></div>
                                    <div class="menucontentarea" id="" style="margin-bottom: 30px">
                                        <div class="clearfix">
                                            <?php
                                            $menu_review= $this->Settings_Model->get_by(array("name" => 'menu_review'), true);

                                            if (!empty($menu_review)) {
                                                $review_details = json_decode($menu_review->value);
                                            } else {
                                                $review_details = '';
                                            }
                                            echo get_property_value('trip_advisor',$review_details)
                                            ?>
                                        </div>


                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>

                    </div>
                    <?=$cart_content?>
                </div>
                <div class="product-modal-block"></div>


            </div>

            <?php echo $footer ?>

        </div>


    </div>
</div>
<div class="deals-modal-block">

</div>

<?php
$this->load->view('menu/common_script');

?>




        <style>
            .category-header-active{
                color: #18bc9c;
                text-decoration: underline;
            }
        </style>

        <script type="text/javascript">
            $('.menucontentarea_grid1')
                .theiaStickySidebar({
                    additionalMarginTop: 0
                });

            $('.content-cartspan')
                .theiaStickySidebar({
                    additionalMarginTop: 0
                });



            $('.cuisinesearch-menu ul li a').removeClass('active');
            $('.cuisinesearch-menu ul li a').click(function(){


                var collapseId=$(this).attr('data-collapse-id');
                var headingCategory=$(this).attr('data-heading-category-id');

                if( $('#'+collapseId).hasClass('show')){
                    $('#'+collapseId).removeClass('show');
                    $(headingCategory+' .expand-plus-minus .fa').removeClass('fa-minus');
                    $(headingCategory+' .expand-plus-minus .fa').addClass('fa-plus');
                }else{
                    $('.collapse').removeClass('show');
                    $('.expand-plus-minus .fa').removeClass('fa-minus');
                    $('.expand-plus-minus .fa').addClass('fa-plus');
                    $('#'+collapseId).addClass('show');
                    $('.expand-plus-minus .fa').addClass('fa-plus');
                    $(headingCategory+' .expand-plus-minus .fa').removeClass('fa-plus');
                    $(headingCategory+' .expand-plus-minus .fa').addClass('fa-minus');
                }









                $('.cuisinesearch-menu ul li a').removeClass('active');
                $(this).addClass('active');
                $('.showmenu .category-name-header').removeClass('category-header-active');
                var href=$(this).attr('href');

                $(href).addClass('category-header-active');

            });

            $('#accordion-category .category-header').click(function(){

                // $('#accordion-category .collapse').removeClass('show');


                var categoryId=$(this).parents('div.card').attr('id');





                if(!$('.cuisinesearch-menu ul li a[href="#' + categoryId + '"]').hasClass('active')){

                    $('.cuisinesearch-menu ul li a').removeClass('active');
                    $('.cuisinesearch-menu ul li a[href="#' + categoryId + '"]').addClass('active');

                }

                if($(this).parents('div.card-header').find('.expand-plus-minus .fa').hasClass('fa-plus')){


                    $('.expand-plus-minus .fa').removeClass('fa-minus');
                    $('.expand-plus-minus .fa').addClass('fa-plus');
                    $(this).parents('div.card-header').find('.expand-plus-minus .fa').removeClass('fa-plus');
                    $(this).parents('div.card-header').find('.expand-plus-minus .fa').addClass('fa-minus');
                }else if($(this).parents('div.card-header').find('.expand-plus-minus .fa').hasClass('fa-minus')){

                    $('.expand-plus-minus .fa').removeClass('fa-minus');
                    $('.expand-plus-minus .fa').addClass('fa-plus');

                    $(this).parents('div.card-header').find('.expand-plus-minus .fa').removeClass('fa-minus');
                    $(this).parents('div.card-header').find('.expand-plus-minus .fa').addClass('fa-plus');
                }
                $(this).toggleClass('show');








                // $(this +'.expand-plus-minus i').toggleClass('fa-minus','fa-plus');

            });






            menucontentarea_width_allocation();

            function menucontentarea_width_allocation(){

                var width= $(window).width();
                console.log(width);
                if(width>480){
                    var nav_tabs_width=$('.menutabarea .nav-tabs').width();
                    var menucontentarea_width=$('.menucontentarea').width();
                    var  menucontentarea_grid1_width=nav_tabs_width;
                    var menucontentarea_grid2=menucontentarea_width-nav_tabs_width-2;

                    $('.menucontentarea_grid1').css('width',menucontentarea_grid1_width+'px');
                    $('.menucontentarea_grid2').css('width',menucontentarea_grid2+'px');
                }else{
                    $('.menucontentarea_grid1').css('width',0+'px');
                    $('.menucontentarea_grid2').css('width','100%');
                }


            }
            $( window ).resize(function() {


                menucontentarea_width_allocation();

                //  responsive_banner(windows_height,windows_width);
            });



            $('.browse ul li a').click(function(){

                $('.cuisinesearch-menu ul li a').removeClass('active');


                $('.showmenu .category-name-header').removeClass('category-header-active');


                var cat=$(this).attr('data-cat');


                $('.cuisinesearch-menu ul li a[href="'+cat+'"]').addClass('active');
                $(cat).addClass('category-header-active');

                if(cat!=='' && !$(cat+' div.collapse').hasClass('show')){
                    $('.collapse').removeClass('show');
                    $(cat+' div.collapse').addClass('show');
                    $('.expand-plus-minus .fa').removeClass('fa-minus');
                    $('.expand-plus-minus .fa').addClass('fa-plus');

                    $(cat+' .expand-plus-minus .fa').removeClass('fa-plus');
                    $(cat+' .expand-plus-minus .fa').addClass('fa-minus');

                }

            });


            var url=window.location.href;
            var category_id = url.substring(url.lastIndexOf('/') + 5);
            if(category_id!==''){
                $(category_id).addClass('category-header-active');
                $('.cuisinesearch-menu ul li a[href="'+category_id+'"]').addClass('active');
            }


            if(category_id!=='' && !$(category_id+' div.collapse').hasClass('show')){
                $(category_id+' div.collapse').addClass('show');
                $(category_id+' .expand-plus-minus .fa').removeClass('fa-plus');
                $(category_id+' .expand-plus-minus .fa').addClass('fa-minus');

            }



        </script>



</body>

</html>