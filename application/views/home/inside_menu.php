<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href="//fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
<style>
    .recipes-w3l-agile, .w3_agile_recipe-grid {
        /* text-transform: uppercase;*/
        font-family: 'Lora', serif !important;
        color: #191919 !important;
    }
    .recipes-w3l-agile h1, h2, h3, h4, h5, h6 { margin: 0; font-family: 'Lora', serif !important; }
    .nav-tabs>li>a {
        margin: 0 5px;
        padding: 15px 44px;
        line-height: 1.42857143;
        font-size: 16px;
        font-weight: 600;
        border: 1px solid transparent;
        border-radius: 0;
        color: #222;
        background: #eee;
    }
    .nav-tabs>li>a:hover, .nav>li>a:focus {
        text-decoration: none;
        background: #191919!important;
        color: #FFF!important;
        border-color: #eee #eee #fff;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        background: #191919 !important;
        color: #FFF!important;
    }
    .nav-tabs { border-bottom: none;  }
    .tab-content>.tab-pane { padding-top: 50px; }
    .menu-text-left { float: left; width: 80%; text-align: left; }
    .menu-text-right { float: right; width: 18%; margin-top: 1.5em; }
    .rep-w3l-text { float: left; width: 70%; margin-top: 1.5em; }
    .width-100{ width: 100% !important; }
</style>
<?php
$product_object = new Product();
$categories = $product_object->get_categories();
//var_dump($categories);
?>
<div id="menu" style="overflow: hidden;">
    <div class="recipes-w3l-agile">
        <div class="container">
            <div class="heading">
                <h3 data-aos="zoom-in" style="text-transform: capitalize;">Resturant Menu
                    <br>
                    <a href="<?= base_url('assets/Streetly_Balti_Dine_Menu.pdf') ?>" target="_blank" class="btn btn-lg btn-primary" >Dine In&nbsp;&nbsp;<i class="fa fa-download" ></i>
                    </a>
                    <a href="<?= base_url('assets/Streetly_Balti_Menu.pdf') ?>" target="_blank" class="btn btn-lg btn-primary" >Takeaway&nbsp;&nbsp;<i class="fa fa-download" ></i>
                    </a>
                </h3>

            </div>
            <div class="agileits-tabs">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs width-100" role="tablist" style="display: flex; flex-wrap: wrap;">
                        <?php if (!empty($categories)): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($categories as $category): ?>
                                <li style="padding-bottom: 5px; display: flex; font-size: 16px;" role="presentation" class="col-md-4 <?= ($count === 1) ? 'active' : '' ?>">
                                    <a class="width-100" href="#category-id-<?= $category->categoryId; ?>" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><?= ($category->categoryName); ?></a>
                                </li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <?php if (!empty($categories)): ?>
                            <?php $count = 1; ?>
                            <?php foreach ($categories as $category): ?>
                                <div role="tabpanel" class="tab-pane fade <?= ($count === 1) ? 'active in' : '' ?>" id="category-id-<?= $category->categoryId; ?>" aria-labelledby="home-tab">
                                    <div class="row w3_agile_recipe-grid">
                                        <h3 class="width-100 text-center">
                                            <span style="border-bottom: 2px solid black; font-weight: bold; font-size: 20px;"><?= ($category->categoryName); ?></span>
                                        </h3>
                                        <?php
                                            $products_list = $product_object->get_product_by_category_id($category->categoryId);
                                        ?>
                                        <?php if (!empty($products_list)): ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($products_list as $product): ?>
                                                <?php
                                                    $product_name = !empty($product->foodItemName) ? $product->foodItemName : '';
                                                    $product_price = number_format($product->tablePrice, 2);
                                                    $product_description = !empty($product->description) ? $product->description : '';
                                                    $sub_products_list = '';
                                                    $sub_products_list = $product_object->get_sub_product($product->foodItemId);
                                                ?>
                                                <?php if (!empty($sub_products_list)): ?>
                                                    <?php
                                                        if ($count > 1) {
                                                            $count++;
                                                        }
                                                    ?>
                                                    <div class="width-100" style="margin-bottom: 10px;">
                                                        <h3 class="width-100" style="margin-top: 5px; padding-left: 5px; padding-right: 5px;">
                                                            <span style="border-bottom: 2px solid black; font-weight: bold; font-size: 15px !important;"><span>
                                                            <!-- <img src="assets/images/heat-sign.svg" alt="Heat Sign" style="width: 15px; height: 15px; margin-top: -6px;"> -->
                                                            </span><?= $product_name; ?></span>
                                                        </h3>
                                                        <?php if (!empty($product_description)): ?>
                                                            <div class="menu-text-left width-100" style="padding-left: 5px; padding-right: 5px;">
                                                                <h6 class="width-100" style="font-size: 1.1em; margin-top:10px; font-size: 13px !important;"><?= $product_description; ?></h6>
                                                            </div>
                                                         <?php endif ?>
                                                         <?php foreach ($sub_products_list as $sub_product): ?>
                                                            <?php
                                                                $sub_product_name = !empty($sub_product->selectiveItemName) ? $sub_product->selectiveItemName : '';
                                                                $sub_product_price = !empty($sub_product->tablePrice) ? number_format($sub_product->tablePrice, 2) : number_format(0, 2);
                                                            ?>
                                                            <div class="col-md-6 menu-grids">
                                                                <div class="menu-text">
                                                                    <div class="menu-text-left">
                                                                        <div class="rep-w3l-text">

                                                                            <h4 style="font-size: 15px !important;"><?= $sub_product_name; ?></h4>
                                                                        </div>
                                                                        <div class="clearfix"> </div>
                                                                    </div>
                                                                    <div class="menu-text-right">
                                                                        <h4 style="font-size: 13px !important;"><?= get_price_text($sub_product_price); ?></h4>
                                                                    </div>
                                                                    <div class="clearfix"> </div>
                                                                </div>
                                                            </div>
                                                         <?php endforeach ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-md-6 menu-grids">
                                                        <div class="menu-text">
                                                            <div class="menu-text-left">
                                                                <div class="rep-w3l-text">
                                                                    <h4 style="font-size: 15px !important; font-weight: bold;">
                                                                        <span><img src="assets/images/heat-sign.svg" alt="Heat Sign" style="width: 15px; height: 15px;"></span>
                                                                        <?= $product_name; ?>
                                                                    </h4>
                                                                    <h6 style="font-size: 13px !important;"><?= $product_description; ?></h6>
                                                                </div>
                                                                <div class="clearfix"> </div>
                                                            </div>
                                                            <div class="menu-text-right">
                                                                <h4 style="font-size: 15px !important;"><?= get_price_text($product_price); ?></h4>
                                                            </div>
                                                            <div class="clearfix"> </div>
                                                        </div>
                                                    </div>                                                    
                                                <?php endif ?>
                                            <?php endforeach ?>                                            
                                        <?php endif ?>
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                                <?php $count++; ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
