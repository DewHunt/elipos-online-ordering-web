<?php if ($notifications): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-default">
                <tr>
                    <th width="20px">SN</th>
                    <th width="150px">Title</th>
                    <th>Message</th>
                    <th width="80px">Total Sent</th>
                    <th>Sent Date</th>
                    <th width="80px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1 ?>
                <?php foreach ($notifications as $notification): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $notification->title ?></td>
                        <td><?= nl2br($notification->message)?></td>
                        <td style="text-align: center"><?= ($notification->total_sent)?></td>
                        <td><?= (!empty( $notification->sending_date)) ? date("l jS \of F Y h:i:s A", strtotime($notification->sending_date)) : 'Not sent'; ?></td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/customer_notifications/recover/".$notification->id) ?>"  class="btn btn-danger btn-sm recover-notification">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h6>There is No Customer Notification</h6>'
<?php endif ?>