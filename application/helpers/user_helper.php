<?php

function get_users_table_rows($users) {
    $CI =& get_instance();
    $logged_id = $CI->session->userdata('user_id');
    $sl_no = 0;
    if (count($users)):foreach ($users as $user):
        if ($user->role == 1) {
            if ($logged_id == $user->id) {
                ?>
                <tr>
                    <td><?= ++$sl_no ?></td>
                    <td>
                        <?= $user->user_name ?>
                    </td>
                    <td>
                        <?= $user->name ?>
                    </td>

                    <td> <?= $user->email; ?></td>
                    <td> <?= $user->role == 1 ? 'Admin' : 'Editor'; ?></td>
                    <td width="25%"><a href="" class="btn btn-primary" action-data="edit" data-id="<?= $user->id ?>"
                                       data-toggle="modal" data-target="#editModal"><i class=" fa fa-pencil-square-o"
                                                                                       aria-hidden="true"></i></a>
                        <span>&nbsp;&nbsp;</span>
                        <a href="" class="btn btn-danger" action-data="delete" data-id="<?= $user->id ?>"> <i
                                class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td><?= ++$sl_no ?></td>
                <td>
                    <?= $user->user_name ?>
                </td>
                <td>
                    <?= $user->name ?>
                </td>

                <td> <?= $user->email; ?></td>
                <td> <?= $user->role == 1 ? 'Admin' : 'Editor'; ?></td>
                <td width="25%"><a href="" class="btn btn-primary" action-data="edit" data-id="<?= $user->id ?>"
                                   data-toggle="modal" data-target="#editModal"><i class=" fa fa-pencil-square-o"
                                                                                   aria-hidden="true"></i></a> <span>&nbsp;&nbsp;</span>
                    <a href="" class="btn btn-danger" action-data="delete" data-id="<?= $user->id ?>"> <i
                            class="fa fa-times" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php
        }
    endforeach;
    endif;
}

function view_user($single_user)
{
    ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="viewModalLabel" style="text-align: center">
                InformationOf <?php echo $single_user['name']; ?></h4></div>
        <div class="modal-body">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td><?= $single_user['id'] ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?= $single_user['name'] ?> </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $single_user['email'] ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php
}

function user_role_dropdown()
{
    $roles = array(
        'Admin' => 1,
        'Editor' => 2,
    )
    ?>

    <select id="role" name="role" class="c-select form-control">
        <option value="0" selected hidden><span>Select User Role</span></option>
        <?php
        foreach ($roles as $role => $value) {
            ?>
            <option value='<?= $value ?>'> <?= $role ?> </option>
            <?php
        }
        ?>
    </select>
    <?php
    echo form_error('role', '<div class="error">', '</div>');
}