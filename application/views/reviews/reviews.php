<style type="text/css">
    body { background: #ffffff !important; }
    .fa-star,.fa-star-half-o { color: #008000; }
    .message { text-align: justify; }
    .checked-newest { color: #fff; background-color: #28a745; border-color: #28a745; }
    .checked-highest { color: #fff; background-color: #17a2b8; border-color: #17a2b8; }
    .checked-lowest { color: #fff; background-color: #dc3545; border-color: #dc3545; }
    .modal-title { width: 100%; text-align: center; }
    .label { width: 100%; border-bottom: 1px solid #ff0000; }
    .form-group { margin-top: 10px; }
    .form-star { margin-right: 8px; }
    .progress-container { padding-bottom: 5px; }
    .progress-label { float: left; padding: 0px 6px; text-align: center; line-height: 17px; }
    .progress-body { padding: 0px 6px; }
    .avg-ratings,.total-posts { font-weight: bold; }
    .avg-ratings { font-size: 60px; color: #008000; }
    .avg-rating-star { font-size: 20px; }
    .total-posts { font-size: 14px; }
</style>

<div class="reviews-report">
    <?php $this->load->view('reviews/reviews_report'); ?>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
        Sort By: 
        <button type="button" class="btn btn-outline-success sort-btn newest-btn" value="newest">Newest</button>
        <button type="button" class="btn btn-outline-info sort-btn highest-btn" value="highest">Highest</button>
        <button type="button" class="btn btn-outline-danger sort-btn lowest-btn" value="lowest">Lowest</button>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2 text-right">
        <button type="button" class="btn btn-outline-secondary text-dark" id="write-review-btn">
            <i class="fa fa-pencil" aria-hidden="true"></i> Write a review
        </button>
    </div>
</div>

<div class="reviews-sec">
    <?php $this->load->view('reviews/reviews_lists'); ?>
</div>

<?php $this->load->view('reviews/review_form'); ?>

<script type="text/javascript">
    let orderTypeArray = [
        {type: 'Dine in',isChoosed: false,iconId: '#dine-in-icon'},
        {type: 'Take out',isChoosed: false,iconId: '#take-out-icon'},
        {type: 'Delivery',isChoosed: false,iconId: '#delivery-icon'},
    ];
    let foodStarArray = [
        {star: 1,notSelectedId: '.food-one-star',selectedId: '.food-selected-one-star'},
        {star: 2,notSelectedId: '.food-two-star',selectedId: '.food-selected-two-star'},
        {star: 3,notSelectedId: '.food-three-star',selectedId: '.food-selected-three-star'},
        {star: 4,notSelectedId: '.food-four-star',selectedId: '.food-selected-four-star'},
        {star: 5,notSelectedId: '.food-five-star',selectedId: '.food-selected-five-star'},
    ];
    let serviceStarArray = [
        {star: 1,notSelectedId: '.service-one-star',selectedId: '.service-selected-one-star'},
        {star: 2,notSelectedId: '.service-two-star',selectedId: '.service-selected-two-star'},
        {star: 3,notSelectedId: '.service-three-star',selectedId: '.service-selected-three-star'},
        {star: 4,notSelectedId: '.service-four-star',selectedId: '.service-selected-four-star'},
        {star: 5,notSelectedId: '.service-five-star',selectedId: '.service-selected-five-star'},
    ];
    let atmosphereStarArray = [
        {star: 1,notSelectedId: '.atmosphere-one-star',selectedId: '.atmosphere-selected-one-star'},
        {star: 2,notSelectedId: '.atmosphere-two-star',selectedId: '.atmosphere-selected-two-star'},
        {star: 3,notSelectedId: '.atmosphere-three-star',selectedId: '.atmosphere-selected-three-star'},
        {star: 4,notSelectedId: '.atmosphere-four-star',selectedId: '.atmosphere-selected-four-star'},
        {star: 5,notSelectedId: '.atmosphere-five-star',selectedId: '.atmosphere-selected-five-star'},
    ];

    $(document).ready(function() {
        hideIcons();
    });

    function hideIcons() {
        $('.checked-star').hide();
        $('.unchecked-star').show();
        $('#dine-in-icon').hide();
        $('#take-out-icon').hide();
        $('#delivery-icon').hide();
    }

    function clearForm() {
        $('#food-star-count').val('');
        $('#service-star-count').val('');
        $('#atmosphere-star-count').val('');
        $('#message').val('');
        $('#choosed-order-types').val('');
        $('#name').val('');
        $('#email').val('');
    }

    $(document).on('click','.sort-btn',function() {
        let sortBy = $(this).val();
        $('.newest-btn').removeClass('checked-newest');
        $('.highest-btn').removeClass('checked-highest');
        $('.lowest-btn').removeClass('checked-lowest');

        if (sortBy == 'newest') {
            $('.newest-btn').addClass('checked-newest');
        }

        if (sortBy == 'highest') {
            $('.highest-btn').addClass('checked-highest');
        }

        if (sortBy == 'lowest') {
            $('.lowest-btn').addClass('checked-lowest');
        }

        $.ajax({
            type: "POST",
            url: '<?= base_url('reviews/get_sorted_feedbacks') ?>',
            data: {sortBy},
            success: function (data) {
                console.log('data: ',data);
                $('.reviews-sec').html(data.output);
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','#write-review-btn',function() {
        $('#reviewFormModal').modal('show');
    });

    $(document).on('click','.order-type-btn',function() {
        let type = $(this).val();
        let choosedOrderTypes = [];

        let index = orderTypeArray.findIndex((orderType) => orderType.type === type);
        if (index >= 0) {
            orderTypeArray[index].isChoosed = !orderTypeArray[index].isChoosed;
            if (orderTypeArray[index].isChoosed) {
                $(orderTypeArray[index].iconId).show();
            } else {
                $(orderTypeArray[index].iconId).hide();
            }
        }

        orderTypeArray.map((orderType) => {
            if (orderType.isChoosed === true) {
                choosedOrderTypes.push(orderType.type);
            }
        });

        $('#choosed-order-types').val(choosedOrderTypes.join(' | '));
    });

    $(document).on('click','.food-star', function() {
        let starVal = $(this).attr('star-val');
        foodStarArray.map((foodStar) => {
            if (foodStar.star <= starVal) {
                $(foodStar.notSelectedId).hide();
                $(foodStar.selectedId).show();                
            } else {
                $(foodStar.notSelectedId).show();
                $(foodStar.selectedId).hide(); 
            }
        });
        $('#food-star-count').val(starVal);
    });

    $(document).on('click','.service-star', function() {
        let starVal = $(this).attr('star-val');
        serviceStarArray.map((service) => {
            if (service.star <= starVal) {
                $(service.notSelectedId).hide();
                $(service.selectedId).show();                
            } else {
                $(service.notSelectedId).show();
                $(service.selectedId).hide(); 
            }
        });
        $('#service-star-count').val(starVal);
    });

    $(document).on('click','.atmosphere-star', function() {
        let starVal = $(this).attr('star-val');
        atmosphereStarArray.map((atmosphere) => {
            if (atmosphere.star <= starVal) {
                $(atmosphere.notSelectedId).hide();
                $(atmosphere.selectedId).show();                
            } else {
                $(atmosphere.notSelectedId).show();
                $(atmosphere.selectedId).hide(); 
            }
        });
        $('#atmosphere-star-count').val(starVal);
    });

    $(document).on('click','.reviews-save-btn',function() {
        let foodStar = $('#food-star-count').val();
        let serviceStar = $('#service-star-count').val();
        let atmosphereStar = $('#atmosphere-star-count').val();
        let message = $('#message').val();
        let choosedOrderTypes = $('#choosed-order-types').val();
        let name = $('#name').val();
        let email = $('#email').val();

        let isValid = true;
        let foodStarError = '';
        let serviceStarError = '';
        let atmosphereStarError = '';
        let nameError = '';
        let emailError = '';

        if (foodStar == '') {
            foodStarError = 'Please select stars for food';
            isValid = false;
        }

        if (serviceStar == '') {
            serviceStarError = 'Please select stars for service';
            isValid = false;
        }

        if (atmosphereStar == '') {
            atmosphereStarError = 'Please select stars for atmosphere';
            isValid = false;
        }

        if (name == '') {
            nameError = 'Please enter name';
            isValid = false;
        }

        if (email == '') {
            emailError = 'Please enter email';
            isValid = false;
        }

        $('#food-star-error').html(foodStarError);
        $('#service-star-error').html(serviceStarError);
        $('#atmosphere-star-error').html(atmosphereStarError);
        $('#name-error').html(nameError);
        $('#email-error').html(emailError);

        if (isValid) {
            $.ajax({
                type: "POST",
                url: '<?= base_url('reviews/save') ?>',
                data: {foodStar,serviceStar,atmosphereStar,message,choosedOrderTypes,name,email},
                success: function (data) {
                    if (data.isSaved) {
                        clearForm();
                        $('#reviewFormModal').modal('hide');
                        $('.reviews-report').html(data.reviews_report);
                        $('.reviews-sec').html(data.reviews_lists);
                    }
                    hideIcons();
                    Swal.fire({icon: 'success',title: 'Information',text: data.message,});
                },
                error: function (error) {
                }
            });
        }
    });
</script>