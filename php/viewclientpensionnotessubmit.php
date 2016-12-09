<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');


$client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
$comments = mysqli_real_escape_string($conn, $_POST['comments']);
$submitted_by = mysqli_real_escape_string($conn, $_POST['submitted_by']);

$sql = "INSERT INTO pension_clientnotes (
client_id
, subject
, comments
, submitted_by
, submitted_date
)
VALUES (
'$client_id'
, 'Pension Client Note'
, '$comments'
, '$submitted_by' , CURRENT_TIMESTAMP)";

if (mysqli_query($conn, $sql)) {

    header('Location: ../ViewClient.php?taskedited=y&search='.$client_id); die;
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
