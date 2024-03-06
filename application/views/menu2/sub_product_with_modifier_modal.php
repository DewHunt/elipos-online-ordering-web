
<div class="" style="padding: .5rem">
    <form id="add_to_cart_sub_product_form" method="post" action="<?= base_url('menu/add_to_cart_sub_product_with_modifier') ?>">
        <input type="hidden" id="item_id" name="item_id" value="<?= $sub_product->selectiveItemId ?>">
        <!-- <span class="itemname">Appetizers</span> -->
        <?php
            $this->load->view('menu2/product_modifier_selection',array('assigned_modifier_by_category_id'=>$assigned_modifier_by_category_id));
        ?>
        <div class="form-group row">
            <label for="" class="col-md-2 col-sm-4 col-xs-12 col-form-label">Selection</label>
            <div class="col-md-10 col-sm-8 col-xs-12">
                <label for="" class="col-form-label"><h6><?= $sub_product->selectiveItemName ?></h6></label>
            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-md-2 col-sm-4 col-xs-12 col-form-label">Quantity</label>
            <div class="col-md-3 col-sm-6 col-xs-6 col-xs-12" >
                <div class="input-group" >
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-danger btn-number"  data-type="minus" data-field="quantity">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                    </span>
                    <input type="text"  name="quantity" class="form-control input-number text-center" value="1" min="1" max="500" >
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-success btn-number" data-type="plus" data-field="quantity">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label for="" class="col-md-2 col-sm-4 col-xs-12 col-form-label">Comments</label>
            <div class="col-md-10 col-sm-8 col-xs-12">
                <textarea class="form-control" id="" rows="3" name="comments"></textarea>
            </div>
        </div> -->

        <div class="form-group row">
            <label for="" class="col-md-2 col-sm-4 col-xs-12 col-form-label"></label>
            <div class="col-md-10 col-sm-8 col-xs-12 float-left">
                <button type="submit" class="common-btn">Add </button>
                <a class="adding-to-cart-button-loader" style="display: none"><img src="<?= base_url('assets/admin/loader/loader.gif') ?>" alt="" title=""/>
                </a>
            </div>
        </div>
    </form>
</div>

<?php
    $this->load->view('menu2/modifier_exceeding_model',array('assigned_modifier_by_category_id'=>$assigned_modifier_by_category_id));
?>

<script type="text/javascript">
    $('.btn-number').click(function(e){
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }
            } else if(type == 'plus') {
                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
            }
        } else {
            input.val(0);
        }
    });

    $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
    
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>