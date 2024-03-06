<?php
$message=get_flash_save_message();
if(!empty($message)){
    echo  sprintf('<div class="alert alert-info text-center" role="alert">  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="" aria-hidden="true">&times;</span></button>%s</div>',$message);
}
?>
