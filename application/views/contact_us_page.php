<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet"/>
        <link type="text/css" href="<?= base_url('assets/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet"/>
        <link type="text/css" href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet"/>

        <script src="<?= base_url('assets/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/bootstrap/js/tether.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/js/main.js') ?>" type="text/javascript"></script>

        <style type="text/css">
            .content { margin: 20px; }
            .contact-info-div { margin-left: 25px; margin-bottom: 20px; }
            .contact-info-div h5 { margin-bottom: 0px; }
            .contact-info-div p { margin-left: 15px; margin-top: -20px; }
        </style>
    </head>

    <body>
        <div class="content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h2>Contact Information</h2>
                        </div>
                    </div>

                    <div class="contact-info-div">
                        <h5><i class="fa fa-map-marker" aria-hidden="true"></i> Address</h5>
                        <p><br><span><?= get_company_address(); ?></span></p>
                    </div>

                    <div class="contact-info-div">
                        <h5><i class="fa fa-phone" aria-hidden="true"></i> Mobile</h5>
                        <p><br><span><?= get_company_contact_number(); ?></span></p>
                    </div>

                    <div class="contact-info-div">
                        <h5><i class="fa fa-envelope" aria-hidden="true"></i> E-Mail</h5>
                        <p><br><span><?= get_company_contact_email(); ?></span></p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <form name="contact-us-form" action="<?= base_url('contact_us/send_message'); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" class="form-control" class="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Phone Number:</label>
                                    <input type="text" class="form-control" class="phone" name="mobile" placeholder="Phone Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Massage:</label>
                                    <textarea class="form-control" placeholder="Message" name="message" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="SUBMIT">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>