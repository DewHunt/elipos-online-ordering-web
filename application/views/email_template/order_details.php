<div style="background: #6A696F;font-size: 13px ">
    <div style="margin: 5px auto;width: 600px;padding: 2px 0;">
        <div style="padding:2px 10px;background-color: white">
            <h2 style="text-align: center;padding: 5px;margin: 0">
                <span style="border-bottom: 2px solid grey">Thanks for your order</span>
            </h2>
            <p>
                Thank You for placing your order with <?= get_company_name() ?>. We shall endeavour to have your order cooked as soon as possible, while maintaining the quality and freshness you have come to expect at <?= get_company_name() ?>.
            </P>

            <?php if ($order_information->order_type == 'collection'): ?>
                <p>Please note all times given are approximate times and actual collection time may vary day-to-day. Please allow a <?= get_todays_collection_delivery_time('collection') ?>-minute window from the time stated to collect your order. Should you need a clearer time scale please call the restaurant on <?= get_company_contact_number() ?>. </p>
            <?php else: ?>
                <p>Please note all times given are approximate times and actual delivery time may vary day-to-day. Please allow a <?= get_todays_collection_delivery_time('delivery') ?>-minute window from the time stated for your delivery. Should you need a clearer time scale please call the restaurant on <?= get_company_contact_number() ?>. </p>
            <?php endif ?>

            <p>Take Look Our <a href="<?= base_url('terms_and_conditions') ?>">Terms And Conditions</a>.</P>

            <?php $this->load->view('order/order_info_table'); ?>
            <?php $this->load->view('order/customer_info_table'); ?>
            <?php $this->load->view('order/order_details_table'); ?>
            <p style="margin-top: 20px">
                Should you have any questions regarding your order, please contact us on 
                <span><a href="tel:<?=get_company_contact_number()?>"><?=get_company_contact_number()?></a></span>
            </p>
        </div>
    </div>
</div>

