<form class="form-horizontal form-label-left" id="customer_notification_sent_form" name="customer_notification_sent_form" method="post" action="<?= base_url('admin/customer_notifications/sent_to_firebase') ?>">
    <input type="hidden" class="form-control" id="id" name="id" >
    <div class="form-group row">
        <div class="right-side-view right-side-magin">
            <!--  <button class="btn btn-warning" type="reset">Reset</button>-->
            <button id="send" type="submit" class="btn btn-success">Sent</button>
        </div>
    </div>
</form>
