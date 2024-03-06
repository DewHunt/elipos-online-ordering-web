<?php
echo '<pre>';
print_r($booking_customer_list);
echo '</pre>';

?>
<div class="container body">
    <div class="main_container">
        <?php $this->load->view('admin/navigation'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Booking Time Slot Form</h2>
                                <?php echo anchor(base_url('admin/booking_customer/add_booking'), '<i class="fa fa-plus" aria-hidden="true"></i> Add New Booking', 'class="btn btn-info btn-lg right-side-view"') ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="form-container">
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead class="thead-default">
                                        <tr>
                                            <th class="font-width width-table">Serial No</th>
                                            <th class="font-width ">booking</th>
                                            <th class="font-width">Floor</th>
                                            <th class="font-width ">17.00-17</th>
                                            <th class="font-width">17.15-17</th>
                                            <th class="font-width">17.30-17</th>
                                            <th class="font-width">17.45-17</th>
                                            <th class="font-width">18.00-18</th>
                                            <th class="font-width">18.15-18</th>
                                            <th class="font-width">18.30-18</th>
                                            <th class="font-width">18.45-18</th>
                                            <th class="font-width width-action">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($allowed_postcodes_list as $allowed_postcodes): ?>
                                            <tr>
                                                <td><?= $allowed_postcodes->id ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td><?= $allowed_postcodes->min_order_for_delivery ?></td>
                                                <td>
                                                    <?php echo anchor(base_url('admin/menu/edit_category'), '<i class=" fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-primary post-code-edit_delete-button"') ?>
                                                    <!--   <button id="<? /*=$allowed_postcodes->id */ ?>" data-action="<? /*=base_url('admin/settings/edit_coverage_area')*/ ?>"class="btn btn-primary post-code-edit_delete-button">
                                                        <i class=" fa fa-pencil-square-o" aria-hidden="true"></i></button>-->
                                                    <button id="<?= $allowed_postcodes->id ?>"
                                                            data-action="<?= base_url($this->admin . '/settings/post_code_delete') ?>"
                                                            class="btn btn-danger post-code-edit_delete-button"><i
                                                            class="fa fa-times" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        <?php $this->load->view('admin/footer'); ?>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("form[name='customer_save_form']").validate({
            rules: {
                first_name: "required",
            },
            messages: {
                first_name: "Please Enter First Name",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

</script>


