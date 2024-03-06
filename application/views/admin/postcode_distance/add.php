<div class="container body">
    <div class="main_container">
        <?php $this->load->view('admin/navigation'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Add Product Item</h2>
                                <?php echo anchor(base_url('admin/product'), '<i class="fa fa-reply" aria-hidden="true"></i> All Product', 'class="btn btn-info btn-lg right-side-view"') ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left" id="product_save_form"
                                      name="product_save_form" method="post" action="<?= base_url('admin/product/save') ?>">
                                          <?php if (!empty($this->session->flashdata('save_success_message'))) { ?>
                                        <div class="success-message text-align-center">
                                            <?php echo $this->session->flashdata('save_success_message'); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="error error-message">
                                        <?php echo validation_errors(); ?>
                                    </div>
                                    <div class="form-group row error-message text-align-center">
                                        <label for=""
                                               class="col-sm-3 col-xs-12 col-form-label"></label>

                                        <div class="col-sm-9 col-xs-12">
                                            <?php
                                            if (!empty($this->session->flashdata('save_error_message'))) {
                                                echo $this->session->flashdata('save_error_message');
                                            }
                                            $product_category_food_type=$this->session->userdata('product_category_food_type');
                                            $product_form=$this->session->userdata('product_form_data');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card col-xs-12">
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">Parent Category</div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <select id="parent_category_id" name="parent_category_id" class="form-control">
                                                        <option  name="parent_category_id" value="">Please Select</option>
                                                        <?php
                                                        if (!empty($parent_category_list)) {
                                                            foreach ($parent_category_list as $parent_category) {
                                                                ?>
                                                                <option  name="parent_category_id" value="<?= $parent_category->parentCategoryId ?>" <?=((get_array_key_value('parentCategoryId',$product_category_food_type))==$parent_category->parentCategoryId)?'selected':''?>><?= $parent_category->parentCategoryName ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Food Type

                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <select id="food_type_id" name="food_type_id" class="form-control">
                                                        <option id="food_type_id" name="food_type_id" value="">Please Select</option>
                                                        <?php
                                                        if (!empty($food_type_list)) {
                                                            foreach ($food_type_list as $food_type) {
                                                                ?>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Category
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <select id="category_id" name="category_id" class="form-control">
                                                        <option id="category_id" name="category_id" value="">Please Select</option>
                                                        <?php
                                                        if (!empty($category_list)) {
                                                            foreach ($category_list as $category) {
                                                                ?>
                                                                                                                                                                <!--                                                                <option id="category_id" name="category_id" value="<?= $category->categoryId ?>"><?= $category->categoryName ?></option>-->
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>


                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Size
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                                    <?php
                                                    $m_product_size=new Product_Size_Model();
                                                    $product_sizes=$m_product_size->get();

                                                    ?>
                                                    <div class="form-group">
                                                        <select name="product_size_id" class="form-control">

                                                            <?php
                                                            foreach ($product_sizes as $size){
                                                                ?>
                                                                <option value="<?=$size->id?>" <?=($size->size==0)?'selected':''?>><?=$size->title?></option>
                                                                <?php
                                                            }
                                                            ?>


                                                        </select>

                                                    </div>



                                                </div>




                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Product Short Name
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <input class="form-control" type="text" value="<?=get_array_key_value('foodItemName',$product_form)?>"
                                                           id="product_name"
                                                           name="product_name" placeholder="Product Short Name">
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Product Full Name
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <input class="form-control" type="text" value="<?=get_array_key_value('foodItemFullName',$product_form)?>"
                                                           id="product_full_name"
                                                           name="product_full_name" placeholder="Product Full Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Table Price
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <input class="form-control" type="text" value="<?=(!empty($product_form))?get_array_key_value('tablePrice',$product_form):0?>"
                                                           id="table_price"
                                                           name="table_price" placeholder=" Table Price">
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Takeaway Price
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <input class="form-control" type="text" value="<?=(!empty($product_form))?get_array_key_value('takeawayPrice',$product_form):0?>"
                                                           id="takeaway_price"
                                                           name="takeaway_price" placeholder=" Takeaway Price">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Bar Price
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <input class="form-control" type="text" value="<?=(!empty($product_form))?get_array_key_value('barPrice',$product_form):0?>" id="bar_price" name="bar_price" placeholder=" Bar Price">
                                                </div>



                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Vat Rate
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group">
                                                    <input class="form-control" type="text" value="<?=get_array_key_value('vatRate',$product_form)?>" id="vat_rate" name="vat_rate" placeholder="Vat Rate" >

                                                    <input type="checkbox" class="form-check-input"
                                                           id="vat_included" name="vat_included" <?=(get_array_key_value('vatStatus',$product_form)==1)?'checked':''?>>
                                                    <span class="">Vat Included</span>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="card-block">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Unit
                                                </div>
                                                <?php

                                                $unit=get_array_key_value('itemUnit',$product_category_food_type);


                                                $units=array(
                                                        'Per Piece'=>'Per Piece',
                                                        'Per Pound'=>'Per Pound',
                                                        'Per Kg'=>'Per Kg',
                                                        'Per Letter'=>'Per Letter',
                                                );

                                                ?>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <select id="unit" name="unit" class="form-control">
                                                        <option name="unit" value="">Please Select</option>
                                                        <?php

                                                        foreach ($units as $key=>$value){

                                                            ?>
                                                            <option name="unit" value="<?=$value?>" <?=($unit==$value)?'selected':''?>><?=$value?></option>
                                                        <?php
                                                        }


                                                        ?>


                                                    </select>
                                                </div>

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Sort Order
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <input class="form-control" type="number" value="<?=get_array_key_value('SortOrder',$product_category_food_type)?>"
                                                           id="sort_order"
                                                           name="sort_order" placeholder=" Sort Order">
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-block">
                                        <div class="col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12">

                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label form-group">
                                                    Description
                                                </div>
                                                <div class="col-lg-10 col-md-10 control-label form-group">
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix">

                                    </div>
                                    <div class="form-group row" style="margin-top: 10px">
                                        <div class="right-side-view right-side-magin">
                                            <a type="button" href="<?= base_url('admin/product') ?>"
                                               class="btn btn-danger">Cancel</a>
                                            <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
                                            <button id="send" type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        <?php $this->load->view('admin/footer'); ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("form[name='product_save_form']").validate({
            rules: {
                parent_category_id: "required",
                food_type_id: "required",
                category_id: "required",
                product_name: "required",
                sort_order: "required",
                table_price: "required",
                takeaway_price: "required",
                bar_price: "required",
                unit: "required",
                vat_rate: "required",
            },
            messages: {
                parent_category_id: "Please Select Parent Category Name",
                food_type_id: "Please Select Food Type",
                category_id: "Please Select Category",
                product_name: "Please Enter Product Name",
                sort_order: "Please Enter Sort Order",
                unit: "Please Select Unit",
                vat_rate: "Please Enter Vat Rate",
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {

                    error.insertAfter( element);
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".error-message" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".error-message" ).addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
        get_food_type_by_parent_category_id();

        $('#parent_category_id').change(get_food_type_by_parent_category_id);


        $('#food_type_id').change(get_category_by_food_type_id);

        function get_food_type_by_parent_category_id() {

            var parent_category_id = $('#parent_category_id option:selected').val();
            var status = 'add_or_update';
            var foodTypeId='<?=get_array_key_value('foodTypeId',$product_category_food_type)?>';
            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/food_type/get_food_type_by_parent_catregory_id/") ?>',
                data: {'parent_category_id': parent_category_id, 'status': status,'category_food_type_id':foodTypeId},
                success: function (data) {
                    //alert(data);
                    $("#food_type_id").html(data['options']);

                    get_category_by_food_type_id();
                },
                error: function (error) {
                    console.log("error occured");
                }
            });

        }

        function get_category_by_food_type_id() {
            var food_type_id = $('#food_type_id option:selected').val();
            var status = 'add_or_update';
            var categoryId='<?=get_array_key_value('categoryId',$product_category_food_type)?>';

            $.ajax({
                type: "POST",
                url: '<?php echo base_url("admin/category/get_category_by_food_type_id/") ?>',
                data: {'food_type_id': food_type_id, 'status': status,'product_category_id':categoryId},
                success: function (data) {
                    //alert(data);
                    $("#category_id").html(data['options']);
                },
                error: function (error) {
                    console.log("error occured");
                }
            });
        }
    });

</script>
