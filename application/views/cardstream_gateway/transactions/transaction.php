<?php
    // dd($res);
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