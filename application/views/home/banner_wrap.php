<div id="banner_wrap">
    <div id="banner_block">
        <div id="banner_search_area">
            <div class="order_text">
                    <span class="logoradio" for="opt_1">
                        <h1> Welcome to <?php echo get_company_name(); ?> </h1>
                       <!--h4>Award winning Bangladeshi cuisine</h4-->
                    </span>
                <br/>
            </div>



                    <?php
                    if($this->order_type=='delivery_and_collection'){
                        ?>
                        <style type="text/css">

                            @media only screen and (min-width: 768px) {
                                /* For desktop: */
                                .search_button_home{
                                    width: 50%;
                                }
                                .search_button_home:first-child{
                                  margin-left: 0;
                                }
                                .search_button_home:last-child{
                                    margin-right: 0;
                                }
                                .choose_area{
                                    display: inline-flex;
                                }
                            }
                            @media only screen and (max-width: 999px) and (min-width: 768px){
                                /* For desktop: */
                                .choose_area{
                                    display: inline-flex;
                                }
                                .search_button_home{
                                    width: 50%;
                                    margin: 0;

                                }
                            }



                        </style>
            <div class="search_panel">
                <div class="choose_area">

                        <input  type="button" class="search_button_home order_type_from_search" order-type="delivery" value="Delivery" id="order_type_delivery_from_search">
                        <input  type="button" class="search_button_home order_type_from_search" order-type="collection" value="Collection" id="order_type_collection_from_search">
                </div>
            </div>
                        <?php
                    }elseif ($this->order_type=='delivery'){
                        ?>
            <div class="search_panel">
                <div class="choose_area">

                        <input style="width: 100%;margin: 0" type="button" class="search_button_home order_type_from_search" order-type="delivery" value="Delivery" id="order_type_delivery_from_search">

                </div>
            </div>
                        <?php
                    }elseif ($this->order_type=='collection'){
                        ?>
                        <style type="text/css">

                            @media only screen and (min-width: 768px) {
                                /* For desktop: */
                                .search_button_home{
                                    width: 39%;
                                }
                            }
                            @media only screen and (max-width: 999px) and (min-width: 768px){
                                /* For desktop: */
                                .search_button_home{
                                    width: 100%;
                                }
                            }



                        </style>
            <div class="search_panel">
                <div class="choose_area">
                        <input style="width:100%;margin: 0 " type="button" class="search_button_home order_type_from_search" order-type="collection" value="Collection" id="order_type_collection_from_search">
                </div>
            </div>
                        <?php

                    }


                    ?>

                </div>





            <div class="banner_add_text">
                <ul>
                    <li>&bull; Full Free To Use</li>
                    <li>&bull; Direct Connections With The Restaurant</li>
                    <li>&bull; Pay By Cash Or Credit Card</li>
                </ul>
            </div>
        </div>
    </div>
</div>


