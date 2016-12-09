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
<meta http-equiv="refresh" content="2; url=https://review.adlcrm.com/ViewClient.php?search=<?php echo $_POST[client_id]?>">
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
$_POST['id'] = mysqli_real_escape_string($conn, $_POST['id']);
$_POST['policy_number'] = mysqli_real_escape_string($conn, $_POST['policy_number']);
$_POST['client_name'] = mysqli_real_escape_string($conn, $_POST['client_name']);
$_POST['notes'] = mysqli_real_escape_string($conn, $_POST['notes']);
$_POST['edited'] = mysqli_real_escape_string($conn, $_POST['edited']);
$_POST['submitted_date'] = mysqli_real_escape_string($conn, $_POST['submitted_date']);
$_POST['deadline'] = mysqli_real_escape_string($conn, $_POST['deadline']);
$_POST['status'] = mysqli_real_escape_string($conn, $_POST['status']);
$_POST['priority'] = mysqli_real_escape_string($conn, $_POST['priority']);
$_POST['subject'] = mysqli_real_escape_string($conn, $_POST['subject']);
$_POST['client_id'] = mysqli_real_escape_string($conn, $_POST['client_id']);
$_POST['completed_by'] = mysqli_real_escape_string($conn, $_POST['completed_by']);

$id=$_POST['id'];
$client_id=$_POST['client_id'];

$sql = "UPDATE client_notes
SET 
notes='$_POST[notes]'
, deadline='$_POST[deadline]'
, edited='$_POST[edited]'
, status='$_POST[status]'
, priority='$_POST[priority]'
, subject='$_POST[subject]'
, complete='$_POST[complete]'
, cyd='$_POST[CYD]'
, cancelled_dd='$_POST[Cancelled_DD]'
, new_dd='$_POST[New_DD]'
, tps='$_POST[TPS]'
, trust='$_POST[Trust]'
, upsells='$_POST[Upsells]'
, completed_by='$_POST[completed_by]'
WHERE id='$id' ";




if (mysqli_query($conn, $sql)) {
    echo "Notes Updated";
    echo "$_POST[completed_by]";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$sqln = "UPDATE client_notes
SET 
cyd='$_POST[CYD]'
, cancelled_dd='$_POST[Cancelled_DD]'
, new_dd='$_POST[New_DD]'
, tps='$_POST[TPS]'
, trust='$_POST[Trust]'
, upsells='$_POST[Upsells]'
WHERE policy_number='$_POST[policy_number]' ";

if (mysqli_query($conn, $sqln)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Checklist updated.
    </div>";
} else {
    echo "Error: " . $sqln . "<br>" . mysqli_error($conn);
}

$sql2 = "INSERT INTO client_notes_history (
added_by
, client_id
, policy_number
, message
, date_added
, upsells
, trust
, tps
, new_dd
, cancelled_dd
, cyd
) 
VALUES (
'$_POST[edited]'
, '$_POST[client_id]'
, '$_POST[policy_number]'
, '$_POST[notes]' 
, CURRENT_TIMESTAMP
, '$_POST[Upsells]'
, '$_POST[Trust]'
, '$_POST[TPS]'
, '$_POST[New_DD]'
, '$_POST[Cancelled_DD]'
, '$_POST[CYD]'
)";


if (mysqli_query($conn, $sql2)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> History Updated.
    </div>";
} else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
}

echo "<br>";


$conn->close();
?>

<br>
If you are not redirected automatically, follow the <a href='https://adlcrm.com/ViewClient.php?search=<?php echo $_POST[client_id]?>'>link to view Client</a>


</body>
</html>
