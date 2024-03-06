<div style="background: #6A696F;font-size: 13px ">
    <div  style="margin: 5px auto;width: 600px;padding: 2px 0; ">
        <div style="padding:2px 10px;background-color: white">
            <h4 style="text-align: center;padding: 5px;margin: 0"><span style="border-bottom: 2px solid grey">Voucher</span></h4>

            <table style="width: 100%; border-collapse: collapse;border: 1px solid #7f7f7f">
                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px">Voucher Code
                    </td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px"><?=$discountCode?></td>
                </tr>
                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px" >Discount</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px"><?=$discountText?></td>
                </tr>
            </table>
            <p style="margin-top: 20px">
                <?php
             $contactNumber=get_property_value('contact_number',$shop);
                ?>
                Should you have any questions regarding your order, please contact us on <span><a href="tel:<?=$contactNumber?>"><?=$contactNumber?></a></span>
            </p>
        </div>
    </div>
</div>