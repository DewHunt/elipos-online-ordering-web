<script type="text/javascript">
    var modifierAsCategory = <?= json_encode($assigned_modifier_by_category_id) ?>;
    var modifierAsCategoryArray = Object.values(modifierAsCategory);

    // $('.sub-product-modal').on('hide.bs.modal', function (e) {
    //     $('.adding-to-cart-button-loader').css('display','none');
    //     $('.adding-to-cart-button').css('display','block');
    // });

    function getModifierCategory(ModifierCategoryId) {
        var itemIndex = -1;
        itemIndex = modifierAsCategoryArray.findIndex(element=>element.ModifierCategoryId == ModifierCategoryId);
        if (itemIndex >= 0) {
            return modifierAsCategoryArray[itemIndex];
        }
        return null;
    }

    var message = 'Modifier limit is exceed';
    $('input[name="side_dish_ids[]"]').click(function () {
        var cateId = $(this).attr('data-cate');
        var modifierCategory = getModifierCategory(cateId);
        console.log(modifierCategory);
        var limit = modifierCategory.Limit;
        var name = modifierCategory.ModifierCategoryName;
        if (modifierCategory) {
            var checkLimitLength = $('.modifierCate-'+cateId+':checked').length;
            if (limit == 1) {
                $('.modifierCate-'+cateId).prop("checked",false);
                this.checked = true;
            } else {
                if (checkLimitLength > limit) {
                    this.checked = false;
                    $('#modifier-cate'+cateId).html(getAlertTemplate(name,message));
                    $('#modifier-cate'+cateId+'.alert').alert();
                } else {
                    $('#modifier-cate'+cateId).empty();
                }
            }
        } else {
            // something wrong
            console.log('something wrong');
        }
    });

    function getAlertTemplate(categoryName,message) {
        var template='<div style="width: 100%;background-color: #fff3cd;color: red" class="alert alert-waning alert-dismissable fade show">\n' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '<strong>'+categoryName+'!&nbsp;</strong>'+message+'.'+
            '</div>';
        return template;
    }
</script>