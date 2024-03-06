<table class="table table-bordered table-sm">
    <tr>
        <th width="100px">Order Total</th>
        <th class="text-right"><?= get_price_text($account_details->order_total) ?></th>
    </tr>
    <tr>
        <th width="100px">Discount</th>
        <th class="text-right"><?= get_price_text($account_details->discount) ?></th>
    </tr>
    <tr>
        <th width="100px">Cash Amount</th>
        <th class="text-right"><?= get_price_text($account_details->cash_amount) ?></th>
    </tr>

    <tr>
        <th width="100px">Card Amount</th>
        <th class="text-right"><?= get_price_text($account_details->card_amount) ?></th>
    </tr>
</table>