<script type="text/javascript">
    $(document).ready(function(){
        var update_status = '<?php echo $update_status ?>';
        var update_title = '<?php echo $update_title ?>';
        var update_message = '<?php echo $update_message ?>';
        if (update_status) {
            Swal.fire({
                icon: update_status,
                title: update_title,
                text: update_message
            });
        }
    });

    $(window).on('load', function () {
        $('#loading').hide();
    });

    $(document).on('change','#show_entries_by_limit',function(e) {
        e.preventDefault();
        var limit = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/postcode/set_limit_in_session/") ?>',
            data: {limit},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                if (data.is_saved) {
                    var url = '<?php echo base_url("admin/postcode/all") ?>';
                    window.location.href = url;
                }
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','#btn_search_postcode',function(e) {
        e.preventDefault();
        var search_data = $('#search_postcode').val();
        var limit = $('#limit').val();
        var start = $('#start').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/postcode/search_postcode") ?>',
            data: {start,limit,search_data},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                if (data.is_success) {
                    $('.postcode-table').html(data.postcode_table_output);
                } else {
                    // location.reload(true);
                }
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','#btn_show_distance',function(e) {
        e.preventDefault();
        var distance = $('#distance_option').val();
        var limit = $('#limit').val();
        var start = $('#start').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/postcode/search_postcode_by_distance") ?>',
            data: {start,limit,distance},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                if (data.is_success) {
                    $('.postcode-table').html(data.postcode_table_output);
                } else {
                    location.reload(true);
                }
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','#postcode_btn',function() {
        var postcode_id = $(this).attr('postcode_id');
        var form_type = $(this).attr('form-type');
        var url = window.location.href;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/postcode/get_postcode_form") ?>',
            data: {postcode_id,url,form_type},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                if (data.is_success) {
                    $('#postcodeModal').modal('show');
                    if (form_type == 'add') {
                        $('#head_title').html('Add Postcode');
                    } else if (form_type == 'edit') {
                        $('#head_title').html('Edit Postcode');
                    }
                    $('#content_data').html(data.form_output);
                } else {
                    // location.reload(true);
                }
            },
            error: function (error) {
            }
        });
    });

    $("#edit-postcodes-form").validate({
        rules: {
            postcode: "required",
            latitude: "required",
            longitude: "required",
        },
        messages: {
            postcode: "Please Enter Postcode",
            latitude: "Please Enter Latitude",
            longitude: "Please Enter Min Longitude",
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).on('click','#btn-upload-excel',function() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("admin/postcode/get_upload_form") ?>',
            data: {},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                if (data.is_success) {
                    $('#postcodeModal').modal('show');
                    $('#head_title').html('Upload Excel File');
                    $('#content_data').html(data.form_output);
                } else {
                    // location.reload(true);
                }
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','#do-upload-excel-file',function(e) {
        e.preventDefault();
        var excel_file = $("#excel_file")[0].files[0];
        var form_data = new FormData();
        form_data.append("excel_file", $("#excel_file")[0].files[0]);
        $('#postcodeModal').modal('hide');

        $.ajax({
            url: '<?php echo base_url("admin/postcode/upload_excel_file") ?>',
            type: "POST",
            cache: false,
            data: form_data,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                var icon = 'success';
                var title = 'Success';
                if (data.is_uploaded === false) {
                    icon = 'error';
                    title = 'Error';
                } else {
                    $('#postcodeModal').modal('hide');
                    $('#upload-to-db-div').show();
                }
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: $(data.message).text()
                });
            },
            error: function (error) {
            }
        });
    });

    $(document).on('click','.upload-to-db',function(e) {
        e.preventDefault();
        var page_link = $(this).attr('page-link');
        $.ajax({
            type: "POST",
            url: page_link,
            data: {},
            beforeSend: function() {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                location.reload(true);
                // Swal.fire({
                //     icon: data.status,
                //     title: data.title,
                //     text: data.message
                // });
            },
            timeout: 180000,
            error: function (error) {
            }
        });
        // window.location.href = page_link;
    });
</script>