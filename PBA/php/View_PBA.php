<?php

$pid= filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);

$viewpbashow= file_get_contents("../TONIC/View PBA/view_pba.php?cmd=EDIT&pid=$pid","w");

echo $viewpbashow;



