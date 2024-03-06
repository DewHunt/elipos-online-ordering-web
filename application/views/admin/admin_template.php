<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('admin/head',$this->data); ?>

    <body class="nav-md footer_fixed" style="font-family: 'Lato';">
    <!-- <body class="nav-md login fixed_footer" style="font-family: 'Lato';"> -->

        <div class="container body">
            <div class="main_container">
                <?php $this->load->view('admin/navigation'); ?>

                <!-- page content -->
                <div class="right_col" role="main">
                    <?=$page_content?>
                </div>
                <!-- /page content -->

                <?php $this->load->view('admin/footer'); ?>
            </div>
        </div>

        <?php $this->load->view('admin/script_page'); ?>

    </body>
</html>






