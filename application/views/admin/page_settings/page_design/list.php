<div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive design-tab list-dt">
        <thead class="thead-default">
            <tr>
                <th class="text-center" width="20px">SN</th>
                <th class="text-center" width="300px">Name</th>
                <th class="text-center">File Location</th>
                <th class="text-center" width="220px">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $count = 1 ?>
            <?php if (!empty($all_design)): ?>
                <?php foreach ($all_design as $design): ?>
                    <tr id="row_<?= $design->id ?>">
                        <td class="text-center"><?= $count++ ?></td>
                        <td><?= $design->name ?></td>
                        <td><?= $design->file_location ?></td>
                        <td class="text-center">
                            <a href="<?= base_url("admin/page_management/edit_page_design/$design->id") ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Edit
                            </a>
                            <button class="btn btn-success btn-sm btn-view" design-id="<?= $design->id ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" design-id="<?= $design->id ?>" style="display: none;">
                                <i class=" fa fa-trash" aria-hidden="true"></i>&nbsp;Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>