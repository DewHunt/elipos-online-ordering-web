<form class="form-horizontal form-label-left" id="customer_notification_save_form" name="customer_notification_save_form" method="post" action="<?= base_url('admin/customer_notifications/insert') ?>">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title"  maxlength="50" >
            </div>
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="expired-date">Expired Date</label>
                <input class="form-control" type="date" value="" id="expired-date" name="expired_date" placeholder="Expired date">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class=" form-group">
                <label for="message"> Message</label>
                <textarea class="form-control" id="message" name="message" placeholder="Message" maxlength="256" minlength="10" rows="5"></textarea>
                <div id="counter">0 words and 0 characters</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <button id="send" type="submit" class="btn btn-success pull-right">Save</button>
            </div>
        </div>
    </div>
</form>
