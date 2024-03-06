<div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive nowrap feedback-tab list-dt">
        <thead class="thead-default">
            <tr>
                <th class="text-center" width="20px">SN</th>
                <th class="text-center">Name</th>
                <th class="text-center" width="50px">Email</th>
                <th class="text-center">Message</th>
                <th class="text-center" width="50px">Rating</th>
                <th class="text-center" width="70px">Status</th>
                <th class="text-center" width="50px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1 ?>
            <?php if (!empty($feedback_lists)): ?>
                <?php foreach ($feedback_lists as $feedback): ?>
                    <tr id="row_<?= $feedback->id ?>">
                        <td class="text-center"><?= $count++ ?></td>
                        <td><?= $feedback->name ?></td>
                        <td><?= $feedback->email ?></td>
                        <td><?= $feedback->message ?></td>
                        <td class="text-center"><?= $feedback->ratings ?></td>
                        <td class="text-center"><?= $feedback->is_approved ? 'Appeoved' : 'Pending' ?></td>
                        <td class="text-center">
                        	<button type="button" class="btn btn-success btn-sm btn-view" feedback-id="<?= $feedback->id ?>">
                                <i class=" fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>