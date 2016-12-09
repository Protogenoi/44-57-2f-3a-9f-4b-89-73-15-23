<?php
include('config.php');

$dbc = @mysqli_connect($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
mysqli_set_charset($dbc, 'utf8');



