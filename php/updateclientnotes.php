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
    
 include('../includes/crmnav.php');
include('../includes/PDOcon.php');



// escape variables for security
$_POST['client_id'] = mysqli_real_escape_string($conn, $_POST['client_id']);
$_POST['policy_number'] = mysqli_real_escape_string($conn, $_POST['policy_number']);
$_POST['client_name'] = mysqli_real_escape_string($conn, $_POST['client_name']);
$_POST['notes'] = mysqli_real_escape_string($conn, $_POST['notes']);
$_POST['edited'] = mysqli_real_escape_string($conn, $_POST['edited']);
$_POST['submitted_date'] = mysqli_real_escape_string($conn, $_POST['submitted_date']);
$_POST['deadline'] = mysqli_real_escape_string($conn, $_POST['deadline']);
$_POST['status'] = mysqli_real_escape_string($conn, $_POST['status']);
$_POST['priority'] = mysqli_real_escape_string($conn, $_POST['priority']);
$_POST['subject'] = mysqli_real_escape_string($conn, $_POST['subject']);
$_POST['warning'] = mysqli_real_escape_string($conn, $_POST['warning']);
$_POST['complete'] = mysqli_real_escape_string($conn, $_POST['complete']);
$_POST['id'] = mysqli_real_escape_string($conn, $_POST['id']);
$_POST['completed_by'] = mysqli_real_escape_string($conn, $_POST['completed_by']);



$sql = "UPDATE client_notes SET
complete='$_POST[complete]'
, notes='$_POST[notes]'
, edited='$_POST[edited]'
, status='$_POST[status2]'
, priority='$_POST[priority]'
, deadline='$_POST[deadline]'
, subject='$_POST[subject]'
, completed_by='$_POST[completed_by]'
WHERE id ='$_POST[id]
";

if (mysqli_query($conn, $sql)) {
    echo "Notes added";
    echo "<br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//$sql2 = "UPDATE ews_data 
//SET ews_status_status = '$_POST[status]', warning='$_POST[warning]'
//WHERE policy_number ='$_POST[policy_number]'
//";

//if (mysqli_query($conn, $sql2)) {
//    echo "EWS Updated";
//    echo "<br>";
//} else {
//    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
//}

$sql3 = "INSERT INTO ews_data__noteshis (
policy_number
, warning
, status
, submitted_by
, notes
, date_submitted
)
VALUES (
'$_POST[policy_number]'
, '$_POST[warning]'
, '$_POST[status]'
, '$_POST[edited]'
, '$_POST[notes]'
, CURRENT_TIMESTAMP )";

if (mysqli_query($conn, $sql3)) {
    echo "History Updated ";
} else {
    echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
}

$conn->close();
?>

