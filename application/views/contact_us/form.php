<form id="contact-us-form" action="<?=base_url('contact_us/send_message')?>" method="post">
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-xs-12 col-form-label">Your name</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" class="form-control" id="name" name="name"
                   value="<?=set_value('name')?>" placeholder="Name">
        </div>
    </div>

    <div class="form-group row">
        <label for="email_address" class="col-sm-3 col-xs-12 col-form-label">Email address</label>
        <div class="col-sm-9 col-xs-12">
            <input type="email" class="form-control" id="email_address" name="email"
                   value="<?=set_value('email')?>" placeholder="Email address">
        </div>
    </div>

    <div class="form-group row">
        <label for="message" class="col-sm-3 col-xs-12 col-form-label">Message</label>
        <div class="col-sm-9 col-xs-12">
            <textarea  id="message" name="message" rows="6" class="form-control" placeholder="Write message here..."><?=set_value('message')?></textarea>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
        <div class=" float-right">
            <button type="submit" class="save-button common-btn " style="border-radius: 0">SUBMIT</button>
        </div>
    </div>
</form>