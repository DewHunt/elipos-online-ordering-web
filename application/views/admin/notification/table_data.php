<style type="text/css">
    .message-box{ margin: 0 auto; background: rgba(187, 205, 211, 0.58); padding: 10px; border-radius: 5px; color: #000000 }
    .title { font-weight: bold; font-size:22px }
    .message { font-size: 18px }
</style>

<?php if ($notifications): ?>    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-default">
                <tr>
                    <th width="50px">SL</th>
                    <th width="150px">Title</th>
                    <th>Message</th>
                    <th width="150px">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
                <?php foreach ($notifications as $notification): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $notification->title ?></td>
                        <td><?= nl2br($notification->message)?></td>
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
    <h6>There is no composed Notification</h6>
<?php endif ?>