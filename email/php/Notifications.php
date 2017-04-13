<?php

$EMAIL_ADDRESS = filter_input(INPUT_GET, 'emailto', FILTER_SANITIZE_EMAIL);

if (isset($EMAIL_ADDRESS)) {

    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> Email sent to <b>$EMAIL_ADDRESS</b> !</div>";
}
?>