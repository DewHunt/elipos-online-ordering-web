
<?php
$mDeals = new Deals_Model();


if(!empty($dealsCategories)){
    foreach ($dealsCategories as $dealsCategory){
        $order_type=$dealsCategory->order_type;
        ?>
        <div class="clearfix"></div>
        <a><h6 class="" style="text-decoration: none;"><?= $dealsCategory->categoryName ?></h6></a>
        <div class="clearfix"></div>
        <div class="product-description">

        </div>

        <?php
        $deals = $mDeals->get_by_category_id($dealsCategory->categoryId);

        $this->data['deals']=$deals;
        $this->data['category']=$dealsCategory;


        $this->load->view('menu/deals',$this->data);







    }
}


?>




