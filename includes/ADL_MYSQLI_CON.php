<?php
//datacon.php
include('config.php');

$conn = new mysqli($DB_SERVER, $DB_ADL_USER, $DB_ADL_PASS, $DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



