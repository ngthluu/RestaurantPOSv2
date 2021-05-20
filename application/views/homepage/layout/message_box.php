<?php 
if (!isset($_SESSION["message_ok"]) && !isset($_SESSION["message_err"])) { 
echo isset($default_message) ? $default_message : '';
} else if (isset($_SESSION["message_err"])) {
echo '
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    '.$_SESSION["message_err"].'
    </div>
    ';
} else if (isset($_SESSION["message_ok"])) {
echo '
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    '.$_SESSION["message_ok"].'
    </div>
    ';
}
unset($_SESSION["message_ok"]);
unset($_SESSION["message_err"]);