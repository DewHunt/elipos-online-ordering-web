<style>
    #content-wrap { margin-bottom: 12px; background: #ededed; }
    #content-block { text-align: center; }
    .waiting-content { display: inline-flex; justify-content: center; align-items: center; width: calc(100% - 0px); height: calc(100vh - 325px); text-align: center; border: 2px solid #008000; }
    .waiting-msg { padding: 10px; font-size: 22px; background: #008000; color: #ffffff; }
    .waiting-img { width: 200px; }
</style>

<?php
    // echo "<pre>"; print_r($res); echo "</pre>";
    $style = (isset($res['threeDSRequest']['threeDSMethodData']) ? 'display: none;' : '');
?>

<div id="content-wrap">
    <div id="content-block">
        <?php if (!isset($res['threeDSRequest']['creq'])) : ?>
            <div class="waiting-content">
                <div>
                    <img class="waiting-img" src="<?= base_url('assets/images/waiting.gif'); ?>" alt="">
                    <p class="waiting-msg">Please wait a minute, we processing your request.</p>
                </div>
            </div>
        <?php endif ?>
        <iframe name="threeds_acs" id="threeds_acs" style="width: calc(100% - 0px); height: calc(100vh - 325px); <?= $style ?>"></iframe>
        <?= $silent_post ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        let screenWidth = $(window).width()
        console.log('screenWidth: ',screenWidth);
        if (screenWidth >= 1280) {
            $('.waiting-content').css('height', '420px');
            $('iframe').css('height', '420px');
        }
    });
</script>