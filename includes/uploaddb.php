<?php

include('config.php');

($GLOBALS["___mysqli_ston"] = mysqli_connect($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS)) or die('cannot connect to the server'); 
((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $DB_DATABASE)) or die('database selection problem');
?>
