<?php

include('config.php');

$mysqli = new mysqli($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE);

  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  ?>

