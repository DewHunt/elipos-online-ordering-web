<div class="modal-body print-block">
    <style type="text/css">
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }
        .booking-tab { font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%; }
        .booking-tab td, .booking-tab th { border: 1px solid #ddd;}
        .booking-tab td { padding: 8px; }
        .booking-tab tr:nth-child(even){ background-color: #f2f2f2; }
        .booking-tab tr:hover { background-color: #ddd; }
        .booking-tab th { padding-top: 10px; padding-bottom: 3px; text-align: center; background-color: #959595; color: white; }
        .data-div { color: #000; font-weight: 700; }
        .txt-center { text-align: center; }
    </style>

    <table class="booking-tab">
        <thead>
            <tr><th colspan="4"><h4>Booking</h4></th></tr>
        </thead>

        <tbody>
            <tr>
                <td class="txt-center">
                    <label>Date</label>
                    <div class="data-div"><?= get_formatted_time($booking->BookingTime,'d F Y'); ?></div>
                </td>
                <td class="txt-center">
                    <label>Time</label>
                    <div class="data-div">
                        <?= (!empty($booking->StartTime) && (!empty($booking->EndTime))) ? $booking->StartTime.' To '.$booking->EndTime : $booking->StartTime?>
                    </div>
                </td>
                <td class="txt-center">
                    <label>Status</label>
                    <div class="data-div"><?=$booking->booking_status?></div>
                </td>
                <td class="txt-center">
                    <label>Number Of People</label>
                    <div class="data-div"><?= $booking->NumberOfGuest ?></div>
                </td>
            </tr>
            <tr>
                <td class="txt-center">
                    <label>Name</label>
                    <div class="data-div"><?= $booking->CustomerName ?></div>
                </td>
                <td class="txt-center">
                    <label>Mobile</label>
                    <div class="data-div"><?= $booking->mobile ?></div>
                </td>
                <td class="txt-center">
                    <label>Email</label>
                    <div class="data-div"><?= $booking->email ?></div>
                </td>
                <td class="txt-center">
                    <label>Note</label>
                    <div class="data-div"><?= $booking->BookingPurpose ?></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<div class="modal-footer">
    <?php if ($booking->booking_status == 'pending'): ?>
        <span class="btn btn-success btn-accept" booking-id="<?= $booking->BookingId ?>">Accept</span>
        <span class="btn btn-danger btn-reject" booking-id="<?= $booking->BookingId ?>">Reject</span>
    <?php endif ?>
    <button type="button" class="btn btn-info" onclick="printBooking()">Print</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>

