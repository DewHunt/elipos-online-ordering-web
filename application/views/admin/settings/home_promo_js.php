<?php $this->load->view('admin/image_manager/script_image_manager'); ?>
<!-- <script type="text/javascript" src="http://localhost:81/demo.elipos/assets/admin/promo.js"></script> -->
<!-- <script type="text/javascript" src="https://demo.elipos.co.uk/assets/admin/promo.js"></script> -->
<script>
    $(document).ready(function() {
        var status = $('#date_status:checked').val();
        if (status == 1) {
            $('#datepicker').datepicker('enable');
        } else {
            $('#datepicker').datepicker('disable');
        }
    });

    $("#datepicker").datepicker({
        dateFormat: 'yy-mm-d',
        minDate: 0,
    });

    $(document).on('click','#date_status',function(event){
        if (this.checked) {
            $('#datepicker').datepicker('enable');
        } else {
            $("#datepicker").datepicker("setDate", '');
            $('#datepicker').datepicker('disable');
        }
    });
</script>