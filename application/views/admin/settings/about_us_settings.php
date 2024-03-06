<div class="container body">
    <div class="main_container">

        <?php
        if (!empty($about_us)) {
            $about_us_value = json_decode($about_us->value);
        } else {
            $about_us_value = '';
        }
        ?>

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
                                <h2>About Us Settings</h2>

                                <div class="form-group row success-message text-align-center">
                                    <label for=""
                                           class="col-sm-3 col-xs-12 col-form-label"></label>

                                    <div class="col-sm-9 col-xs-12">
                                        <?php
                                        if (!empty($this->session->flashdata('save_message'))) {
                                            echo $this->session->flashdata('save_message');
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                            <div class="error">
                                <?php echo validation_errors(); ?>
                            </div>

                            <div class="x_content">

                                <form class="form-horizontal form-label-left" id="about_us_settings_form"
                                      name="about_us_settings_form" method="post"
                                      action="<?= base_url('admin/settings/about_us_save') ?>">
                                    <input type="hidden" name="id" class="form-control" id="id"
                                           value="<?= !empty($about_us) ? $about_us->id : '' ?>">
                                    <input type="hidden" name="name" class="form-control" id="name" value="about_us">

                                    <div class="card col-xs-12">
                                        <div class="card-block">

                                            <div class="form-group row">
                                                <label for="description" class="col-sm-3 col-xs-12 col-form-label">About
                                                    Us</label>

                                                <div class="col-sm-9 col-xs-12">
                                                    <textarea type="text" rows="10" name="description"
                                                              class="form-control"
                                                              id="description"><?= !empty($about_us_value) ? $about_us_value->description : '' ?>
                                                    </textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="about_us_logo" class="col-sm-3 col-xs-12 col-form-label">About
                                                    Us
                                                    Logo</label>

                                                <div class="col-sm-3 col-xs-12">
                                                    <span>Select File</span>
                                                    <input type="file" name="file" id="file">
                                                </div>
                                                <div class="col-sm-6 col-xs-12">
                                                    <button type="button" class="btn btn-primary image-upload">Upload
                                                        Image
                                                    </button>
                                                </div>
                                            </div>


                                            <div class="logo-image-section col-xs-12 form-group row">
                                                <label for="" class="col-sm-3 col-xs-12 col-form-label"></label>

                                                <div class="card col-sm-3 col-xs-12">
                                                    <img width="100px" height="100px" id="logoImage"
                                                         class="image-preview"
                                                         src="<?= !empty($about_us_value) ? base_url() . $about_us_value->about_us_logo : '' ?>">
                                                </div>
                                            </div>
                                            <div class="image-message">
                                                <?php
                                                if (!empty(get_about_us_logo())) {
                                                    ?>
                                                    <input type="hidden" name="about_us_logo"
                                                           value="<?= get_about_us_logo() ?>">
                                                <?php } ?>
                                            </div>

                                            <div class="form-group row">
                                                <div class="progress" style="display: none">
                                                    <div class="background-color-white text-align-center"
                                                         style="background-color: #ffffff; border-radius: 30px"
                                                         id="progress-percentage">
                                                    </div>
                                                    <div id="progressbar">
                                                        <div class="progress-label">Loading...</div>
                                                    </div>
                                                    <progress
                                                        class="progressbar progress progress-striped progress-animated progress-success"
                                                        value="0" max="100" id="progress-bar"></progress>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="right-side-view right-side-magin">
                                            <a type="button" href="<?= base_url('admin/settings/currency') ?>"
                                               class="btn btn-danger">Cancel</a>
                                            <button id="send" type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </div>

                                </form>
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


<style>
    .progress[value] {
        color: green;
        width: 100%;
    }

    .ui-widget-header {
        background-color: green !important;
    }

    .ui-progressbar {
        position: relative;
        color: green;
    }

    .progress-label {
        position: absolute;
        left: 50%;
        top: 4px;
        font-weight: bold;
        text-shadow: 1px 1px 0 #fff;
        color: green;
    }
</style>

<script>

    CKEDITOR.replace('description');

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#logoImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


    $('input[type=file]').on('click', function () {
        $('.progress').css({'display': 'none'});
    });
    $('input[type=file]').change(function () {
        var dish = $(this);
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logoImage').attr('src', e.target.result);
        };
        reader.readAsDataURL(dish[0].files[0]);
    });

    $('.image-upload').on('click', function () {
        var input_file = $('input[name=file]');
        var upload_file = input_file[0].files[0];

        var name = input_file[0].files[0]['name'];
        var size = input_file[0].files[0]['size'];
        //alert(size);
        var formdata = new FormData();
        formdata.append('file', upload_file);
        $.ajax({
            url: '<?=base_url($this->admin.'/settings/about_us_image_load')?>',
            type: 'post',
            data: formdata,
            processData: false,
            contentType: false,

            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (event) {
                    $('.progress').css({'display': 'block'});
                    var percentComplete = Math.round((event.loaded / event.total) * 100);
                    console.log(percentComplete);
                    //$('#progress-bar').val(percentComplete);
                    //$('#progress-percentage').html(percentComplete + '%');
                    $(function () {
                        var progressbar = $("#progressbar"),
                            progressLabel = $(".progress-label");

                        progressbar.progressbar({
                            value: false,
                            change: function () {
                                progressLabel.text(progressbar.progressbar("value") + "%");
                            },
                            complete: function () {
                                progressLabel.text("Complete!");
                            }
                        });

                        function progress() {
                            var val = progressbar.progressbar("value") || 0;

                            progressbar.progressbar("value", val + 2);

                            if (val < 99) {
                                setTimeout(progress, 80);
                            }
                        }

                        setTimeout(progress, 2000);
                    });

                }, false);

                return xhr;
            },
            success: function (data) {
                $('.image-message').html(data);
            }
        });

    });

</script>
