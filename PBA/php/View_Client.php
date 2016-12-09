<?php

$cid= filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT);

$viewclientshow= file_get_contents("../TONIC/View Client/view_client.php?panel=1&cid=$cid","w");

echo $viewclientshow;