<?php if ($notifications): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-default">
                <tr>
                    <th width="20px">SN</th>
                    <th width="100px">Title</th>
                    <th width="150px">Message</th>
                    <th width="80px">Total Sent</th>
                    <th width="250px">Sent Date</th>
                    <th width="150px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php foreach ($notifications as $notification): ?>
                    <tr>
                        <td><?= $count++?></td>
                        <td><?= $notification->title ?></td>
                        <td><?= nl2br($notification->message)?></td>
                        <td style="text-align: center"><?= ($notification->total_sent)?></td>
                        <td>
                            <?php
                                $sent_text = 'Not Sent';
                                if ($notification->is_sent) {
                                    $sent_text = 'Date Not Found';
                                    if ($notification->sending_date) {
                                        $sent_text = date("l jS \of F Y h:i:s A", strtotime($notification->sending_date));
                                    }
                                }
                                echo $sent_text;
                            ?>
                        </td>
                        <td class="text-center">
                            <button notification-id="<?= $notification->id ?>" class="btn btn-primary btn-sm editNotificationForm" data-toggle="tooltip" data-placement="top" title="Edit Message">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </button>
                            <a href="<?= base_url("admin/customer_notifications/delete/".$notification->id) ?>"  class="btn btn-danger btn-sm delete-notification">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                            <a data-id="<?= $notification->id ?>" data-message="<?= $notification->message ?>" data-title="<?= $notification->title ?>"class="btn btn-sm btn-primary show-notification" data-toggle="tooltip" data-placement="top" title="Send Message">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h6>There is no sent Notification</h6>
<?php endif ?>