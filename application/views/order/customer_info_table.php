<table class="table"  style="width: 100%">
    <tr><td  colspan="2">Customer Details</td></tr>
    <tr><td style="width: 200px;text-transform: capitalize">Name</td><td><?=get_customer_full_name($customer)?></td></tr>
    <tr><td style="width: 200px">Email</td><td><a href="mailto:<?=$customer->email?>"><?=$customer->email?></a></td></tr>
    <tr><td style="width: 200px">Telephone</td><td><a href="tel:<?=$customer->telephone?>"><?=$customer->telephone?></a></td></tr>
    <tr><td style="width: 200px">Mobile</td><td><a href="tel:<?=$customer->mobile?>"><?=$customer->mobile?></a></td></tr>
    <tr><td style="width: 200px">Delivery Address Line 1</td><td> <a target="_blank" href="https://www.google.com/maps/search/?<?=str_replace(' ','+',$customer->delivery_address_line_2)?>" ><?=$customer->delivery_address_line_1?></a></td></tr>
    <tr><td style="width: 200px">Delivery Address Line 2</td><td> <a target="_blank" href="https://www.google.com/maps/search/?<?=str_replace(' ','+',$customer->delivery_address_line_2)?>" ><?=$customer->delivery_address_line_2?></a></td></tr>
    <tr><td style="width: 200px">City</td><td><?=$customer->delivery_city?></td></tr>
    <tr><td style="width: 200px">Post Code</td><td><?=$customer->delivery_postcode?></td></tr>
</table>