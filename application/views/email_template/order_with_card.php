<div class="basket-page  background-white">
    <div class="max-page order-success">
        <div class="card">
            <div class="card-header text-xs-center">
                <h1 style="font-size: 150%">Order Confirmation </h1>
                <h5 class="mb-0">Thank you very much for placing an order with <?= get_company_name() ?></h5>
            </div>
            <div class="card-body">
                <p>You have chosen to make the payment on <strong> <?=ucfirst($payment_method)?> </strong> of your order from <?= get_company_name() ?>. We really appreciate your business. Enjoy your order!</p>
                <div class="back-to-menu-button text-xs-left">
                    <a  href="<?=base_url('menu')?>" class="btn btn-primary">Back To Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>