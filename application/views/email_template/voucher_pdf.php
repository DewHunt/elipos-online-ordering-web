<!DOCTYPE html>
<html>
    <head>
        <title>Voucher-<?=$code?></title>
        <style>
            @page { margin: 0px auto; }
            body { margin: 0px auto; }
            #description { position: absolute; top: 175px; left: 216px; width: 371px; height: 71px; text-align: center; }
            #description p { margin: 5px 2px; font-size: 20px; width: 100%; }
            #code { position: absolute; top: 257px; left: 371px; width: 153px; height: 29px; text-align: center; }
            #code p { margin: 5px 2px; }
            #validation-date { position: absolute; top: 299px; left: 371px; width: 153px; height: 29px; text-align: center; }
            #validation-date p { margin: 5px 2px; }
            #text-amount { font-size: 30px; }
        </style>
    </head>

    <body>
        <!-- base_url('assets/voucher.png') -->
        <div style=" margin: 0px auto;width: 803px;height: 385px;background-image: url('<?= base_url($background_image) ?>');background-size: 100% 100%">
            <div id="description" ><p><?= $description ?></p></div>
            <div id="code"><p><?= $code ?></p></div>
            <div id="validation-date" ><p><?= $validityDate ?></p></div>
        </div>
    </body>
</html>