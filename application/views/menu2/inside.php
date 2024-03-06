
<?php
$product_object=new Product();
$categories = $product_object->get_categories();

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="card" style="padding: 10px">
        <div id="menu-block">
            <h4 class="menu">Menu</h4>
            <div class="clearfix">
            </div>
            <div class="tabcontainer">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php
                    $cat_count=1;
                    foreach ($categories as $category){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link active" id="cat<?=$category->categoryId?>" data-toggle="tab" href="#cat<?=$category->categoryId?>" role="tab" aria-controls="<?=$category->categoryId?>" aria-selected="true"><?=$category->categoryName?></a>
                        </li>
                        <?php

                    }
                    ?>

                </ul>
                <div class="tab-content" id="myTabContent">

                    <?php
                    $cat_count=1;
                    foreach ($categories as $category) {
                        ?>
                    <div id="cat<?=$category->categoryId?>" role="tabpanel" class="tab-pane fade  <?=($cat_count++==1)?' show active':''?>">
                            <h3 class="category-header"><?=$category->categoryName?></h3>
                              <!--  <div class="para">
                                    <em>Served with green salad & mint sauce.</em>
                                </div>-->


                        <?php

                        $products=$product_object->get_product_by_category_id($category->categoryId);

                        ?>

                                <div class="menuitems row">

                                    <?php
                                    $orderType=$category->order_type;
                                    foreach ($products as $product){
                                        ?>
                                        <div class="col-6 item">
                                            <h4 class="menutitle"><span><?=ucfirst($product->foodItemName)?></span><span class="menuprice"><?=get_price_text($product->tablePrice)?></span></h4>
                                            <div class="para">
                                                <span><?=$product->description?></span>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>

                        </div>

                        <?php

                    }

?>
                </div>
            </div>
    </div>
</div>




