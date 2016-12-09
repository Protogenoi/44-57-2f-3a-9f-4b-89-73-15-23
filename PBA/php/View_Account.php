<?php

$aid= filter_input(INPUT_GET, 'aid', FILTER_SANITIZE_NUMBER_INT);

$viewaccountshow= file_get_contents("../TONIC/View Account/view_account.php?aid=$aid","w");

echo $viewaccountshow;