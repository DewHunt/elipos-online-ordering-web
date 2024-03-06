<!DOCTYPE html>
<html>
    <head>
        <title>Voucher-<?=$code?></title>
    </head>

    <body>
        <div style=" margin: 0px auto;width: 803px;height: 385px;background-image: url('<?= base_url('assets/voucher.png') ?>');background-size: 100% 100%">
            <table style="width: 100%">
                <tr><td style="height: 150px;width: 100%"></td></tr>
                <tr><td  valign="top" style="height: 71px;padding: 6px 215px 0px 216px;text-align: center"> <?=$description?></td></tr>
                <tr><td style="height: 30px;width: 100%;padding: 3px 274px 0px 370px;text-align: center"><?=$code?></td></tr>
                <tr><td style="height: 40px;width: 100%;padding: 3px 274px 0px 370px;text-align: center"><?=$validityDate?></td></tr>
            </table>
        </div>
    </body>
</html>