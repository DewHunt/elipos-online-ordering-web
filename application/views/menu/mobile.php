<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>

    <link title="favicon" rel="icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/.png"/>
    <link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script src="<?= base_url('assets/jquery/jquery-3.2.1.min.js') ?>" type="text/javascript"></script>

<!--
    <script src="<?/*= base_url('assets/lib/pace/pace.js') */?>" type="text/javascript"></script>
    <link type="text/css" href="<?/*= base_url('assets/lib/pace/pace.css') */?>" rel="stylesheet"/>-->
    <link type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/my_design/bootstrap/responsive.css') ?>" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom/menu.css') ?>">
    <link type="text/css" href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/my_design/css/style.css') ?>" rel="stylesheet"/>

    <link type="text/css" href="<?= base_url('assets/css/responsive-240-320.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-320-480.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-480-767.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-768-999.css') ?>" rel="stylesheet"/>
    <link type="text/css" href="<?= base_url('assets/css/responsive-1000-1024.css') ?>" rel="stylesheet"/>

    <!--For Menu Start-->
    <script type="text/javascript" src="<?= base_url('assets/js/sticky-sidebar/theia-sticky-sidebar.js') ?>"></script>




    <script src="<?= base_url('assets/bootstrap/js/tether.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <style type="text/css">
        .cuisinesearch-menu ul li a.active{
            border-bottom: 3px solid  #f8781e;
            font-weight: 900;
            font-size: 130%;

        }


        .fade.show {
            opacity: 1;
            background: rgba(5, 5, 5, 0.66);
        }

        .product-description p{
            float: left;
            color: #888;
            font-weight:300;
            line-height:1.3em;
        }
        .itemdescription{
            margin: 0 !important;
        }

    </style>

</head>


<body class="body-frontend font-selector" style="background-color: #ffffff;">


<?php echo $shop_open_close_modal?>


<style>

    .modal-content {
        border: 10px solid grey ;
        background: #ffffff;
        border-radius: 0;
    }
    .fade.show {
        opacity: 1;
        background: rgba(5, 5, 5, 0.66);
    }

    .mobile .tab-link-block .nav-link{
        padding:0;
        font-size: 1rem;
    }
    .mobile .tab-link-block h4{

font-size: 1rem
    }
    @media only screen and (min-width: 240px) and (max-width: 767px){
        .input-group{
            width: 60%;
        }
    }
    @media only screen and (min-width: 768px) and (max-width: 999px){
        .input-group{
            width: 90%;
        }
        .content-cartspan{

        }
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
        $side_dishes = $product_object->get_side_dish();
        $all_sub_products = $product_object->get_all_sub_products();
        $dealsName=$product_object->get_offers_or_deals_name();
        $dealsId=str_replace(' ','-',$dealsName);

        ?>
        <div id="content-wrap">

            <div id="content-block">

                <?php

                $this->load->view('menu/info');
                $is_shop_maintenance_mode=false;
                $is_shop_maintenance_mode=is_shop_maintenance_mode();
                $this->data['is_shop_maintenance_mode']=$is_shop_maintenance_mode;
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


                ?>


                <div class="full-width-container">
                    <div class="menutabarea">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active  " data-toggle="tab" href="#menu" <?=$nav_link_style?> role="tab">Menu</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#info" role="tab" <?=$nav_link_style?>>Info</a>
                            </li>
                            <?php
                            if($is_review_tab_show){
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#review" role="tab">Reviews</a>
                                </li>
                            <?php
                            }

                            ?>

                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="menu" role="tabpanel">
                            <div class="mobile">
                                <div id="accordion-category" role="tablist" aria-multiselectable="true" style="width: 100%">

                                    <?php
                                    $cate_i=0;
                                    if (!empty($dealsCategories)) {
                                        $cate_i++;
                                        ?>

                                        <div class="clearfix" style="margin-top: .5rem">
                                            <div class="card">

                                                <div class="card-header tab-link-block" role="tab" >
                                                    <h4 class="float-left"> <?= ucfirst($dealsName)  ?></h4>

                                                    <a data-toggle="collapse"  style="font-size: 1.5rem" class="nav-link float-right <?=($cate_i==1)?'fa fa-chevron-down':'fa fa-chevron-right'?>" data-parent="#accordion" href="#category-<?= $dealsId?>" aria-expanded="true" aria-controls="collapse<?=$dealsId?>">

                                                    </a>

                                                </div>

                                                <div id="category-<?=$dealsId?>" class="collapse <?=($cate_i==1)?'show':''?>" role="tabpanel" aria-labelledby="headingCategory-<?=$dealsId?>">
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


                                    <?php if (!empty($categories)) {

                                        ?>
                                        <?php foreach ($categories as $category) {
                                            $cate_i++;?>
                                            <div class="card">
                                                <div class="card-header tab-link-block" role="tab" >
                                                    <h4 class="float-left"> <?= ($category->categoryName) ?></h4>

                                                    <a data-toggle="collapse"  style="font-size: 1.5rem" class="nav-link float-right <?=($cate_i==1)?'fa fa-chevron-down':'fa fa-chevron-right'?>" data-parent="#accordion" href="#category-<?= $category->categoryId ?>" aria-expanded="true" aria-controls="collapseOne">

                                                    </a>

                                                </div>

                                                <div id="category-<?= $category->categoryId ?>" class="collapse <?=($cate_i==1)?'show':''?>" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="card-block">
                                                        <?php $products_list = $product_object->get_product_by_category_id($category->categoryId); ?>


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
                                        <?php } ?>


                                    <?php }
                                    ?>

                                </div>


                            </div>

                        </div>
                        <div class="tab-pane  " id="info" role="tabpanel">

                            <?php

                            $this->load->view('menu/tab_info');

                            ?>
                            <div class="clearfix"></div>

                        </div>

                        <?php
                        if($is_review_tab_show){
                            ?>
                            <div class="tab-pane fade" id="reviews-tab" role="tabpanel">
                                <div class="clearfix"></div>
                                <div class="menucontentarea" id="" style="margin-bottom: 30px">
                                    <div class="clarfix">
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






                    <div class="" style="margin-top: .5rem">
                        <?=$cart_content?>


                    </div>

                </div>

                <div class="product-modal-block"></div>


            </div>

            <?php echo $footer ?>

        </div>


        <div class="deals-modal-block">

        </div>


        <?php
        $this->load->view('menu/common_script');

        ?>
<script type="text/javascript">
            $('#accordion-category .tab-link-block a').click(function(){
                if($(this).hasClass('fa-chevron-down')){
                    $(this).removeClass('fa-chevron-down');
                    $(this).addClass('fa-chevron-right');

                }else if($(this).hasClass('fa-chevron-right')){
                    $(this).removeClass('fa-chevron-right');
                    $(this).addClass('fa-chevron-down');
                }
            });







        </script>


</body>

</html>

