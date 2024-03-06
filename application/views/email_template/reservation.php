<style type="text/css">
    td { text-transform: uppercase; }
</style>

<div style="background: #6A696F;font-size: 13px ">
    <div style="margin: 5px auto;width: 450px;padding: 2px 0; ">
        <div style="padding:2px 10px;background-color: white;margin-bottom: 10px">            
            <h2 style="text-align: center;text-transform:uppercase;padding: 5px;margin: 0"><?= get_company_name() ?> Online Reservation</h2>
             <p>
                Dear <?= ucfirst($booking->CustomerName) ?>,<br>
                Thank you for your reservation request, at this moment your request is awaiting our confirmation. We shall call you after 5:00 pm to confirm your reservation.<br>
                If you have not heard back from us by 6:00 pm then please do give us a call as its most likely that we have been unable to reach you.<br>
                Please visit our website <?= base_url(); ?> if you wish to view our menus or for further information regarding what we have to offer. We look forward to welcoming you soon at <?= get_company_name() ?> Restaurant. Kind regards,
            </p>

            <p>
                <?= get_company_name() ?>,<br>
                <?= get_company_address() ?><br>
                Tel:  <?= get_company_contact_number() ?><br>
                Email: <?= get_company_contact_email() ?>
            </p>
            
            <table style="width: 100%; border-collapse: collapse;border: 1px solid #7f7f7f">
                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Name</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= ucfirst($booking->CustomerName) ?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">People</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= $booking->NumberOfGuest ?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Booking Date</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= get_formatted_time($booking->BookingTime, 'd F Y') ?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Time</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?php echo $booking->StartTime;?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Mobile NO</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= $booking->mobile ?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Status</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= ucfirst ($booking->booking_status) ?></td>
                </tr>

                <tr>
                    <td style="width: 100px; border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase">Note</td>
                    <td style="border: 1px solid #7f7f7f;padding: 5px;text-transform: uppercase"><?= $booking->BookingPurpose ?></td>
                </tr>
            </table>

            <!-- <p style="margin-top: 20px">
                Should you have any questions regarding your order, please contact us on <span><a href="tel:<?/*= get_company_contact_number() */?>"><?/*= get_company_contact_number() */?></a></span>
            </p> -->
            <p style="margin-top: 20px"></p>
        </div>
    </div>
</div>

