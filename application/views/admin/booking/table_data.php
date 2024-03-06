<div class="table-responsive">
    <table class="table table-striped table-bordered list-dt booking-table-data">
        <thead class="thead-default">
            <tr>
                <th width="50px">SL</th>
                <th width="120px">Name</th>
                <th width="100px">Mobile</th>
                <th width="80px">Date</th>
                <th width="50px">Table</th>
                <th width="100px">Time</th>
                <th>Purpose</th>
                <th width="80px">Guest</th>
                <th width="140px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($booking_list_by_date as $booking): ?>
                <?php $booking_date = date("d-m-Y", strtotime($booking->BookingTime)); ?>
                <tr data-details='<?= json_encode($booking) ?>'>
                    <td><?= $count++ ?></td>
                    <td><?= ucfirst($booking->CustomerName) ?></td>
                    <td><?= $booking->CustomerPhone ?></td>
                    <td><?= $booking_date ?></td>
                    <td><?= $booking->TableNumber ?></td>
                    <td><?= $booking->StartTime ?> to <?= $booking->EndTime ?></td>
                    <td><?= ucfirst($booking->BookingPurpose) ?></td>
                    <td class="text-center"><?= $booking->NumberOfGuest ?></td>
                    <td class="text-center">
                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-view" data-id="<?=$booking->BookingId?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="<?= base_url("admin/booking_customer/edit/$booking->BookingId") ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="javascript:void(0)" data-id="<?=$booking->BookingId?>" data-action="<?= base_url("admin/booking_customer/delete") ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>