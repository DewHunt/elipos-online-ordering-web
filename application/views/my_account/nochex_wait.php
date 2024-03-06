<!DOCTYPE html>
<html>
<head>
    <style>
        /* The Modal (background) */
        .modal {
            display: block; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

    </style>
</head>
<body>


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <h1 style="text-align: center"> Waiting for Nochex</h1>
    </div>

</div>


<form name="nochex-form" action="https://secure.nochex.com" method="post" >
    <input type="hidden" name="merchant_id" value="<?=$merchant_id?>" />
    <input type="hidden" name="amount" value="<?=$total?>" />
    <input type="hidden" name="order_id" value="<?=$nochex_order_id?>" />
    <input type="hidden" name="callback_url" value="<?=$callback_url?>" / >
    <input type="hidden" name="success_url" value="<?=$success_url?>" / >
    <input type="hidden" name="cancel_url" value="<?=$cancel_url?>" / >
    <input type="hidden" name="description" value="<?=$description?>" / >
</form >
<script type="text/javascript">
    document.forms["nochex-form"].submit();
</script>

</body>
</html>
