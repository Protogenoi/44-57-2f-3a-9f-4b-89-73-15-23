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
?>

<!DOCTYPE html>
<html lang="en">
<title>ADL | Submit Notes</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="2; url=../CRMmain.php">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/bpop.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
</head>
<body>



<?php include('../includes/navbar.php'); 
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


$sql = "INSERT INTO client_notes (
client_id
, complete
, client_name
, notes
, edited
, policy_number
, status
, priority
, deadline
, subject
, cyd
, cancelled_dd
, new_dd
, tps
, trust
, upsells
, assigned
, submitted_date
, completed_by
)
VALUES (
'$_POST[client_id]'
, '$_POST[complete]'
, '$_POST[client_name]'
, '$_POST[notes]'
, '$_POST[edited]'
, '$_POST[policy_number]'
, '$_POST[status2]'
, '$_POST[priority]'
, '$_POST[deadline]'
, '$_POST[subject]'
, '$_POST[CYD]'
, '$_POST[Cancelled_DD]'
, '$_POST[New_DD]'
, '$_POST[TPS]'
, '$_POST[Trust]'
, '$_POST[Upsells]'
, '$_POST[edited]'
, CURRENT_TIMESTAMP
,' ')";

if (mysqli_query($conn, $sql)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Client notes added.
    </div>";
    echo "<br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


$sql4 = "INSERT INTO client_notes_history (
added_by
, client_id
, policy_number
, message
, cyd
, cancelled_dd
, new_dd
, tps
, trust
, upsells
, date_added )
VALUES (
'$_POST[edited]'
, '$_POST[client_id]'
, '$_POST[policy_number]'
, '$_POST[notes]'
, '$_POST[CYD]'
, '$_POST[Cancelled_DD]'
, '$_POST[New_DD]'
, '$_POST[TPS]'
, '$_POST[Trust]'
, '$_POST[Upsells]'
,CURRENT_TIMESTAMP )";

if (mysqli_query($conn, $sql4)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Client/Policy Timeline updated.
    </div>";
    echo "<br>";
} else {
    echo "Error: " . $sql4 . "<br>" . mysqli_error($conn);
}

//$sql2 = "UPDATE ews_data 
//SET ews_status_status = '$_POST[status]', warning='$_POST[warning]', ournotes='$_POST[notes]'
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
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> EWS Notes Added.
    </div> ";
} else {
    echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
<br>
 <a href="../EWSfiles.php">Back to EWS</a> 


</body>
</html>
