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


$clientidata= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$clientnamedata= "CRM Alert";
$subjectdata= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
$notesdata= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$clientidata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$subjectdata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$notesdata, PDO::PARAM_STR, 2500);

$query->execute();

echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Client notes database updated.
    </div>";

$polun = mysqli_real_escape_string($conn, $_POST['id']);
$_POST['policy_number'] = mysqli_real_escape_string($conn, $_POST['policy_number']);
$_POST['client_name'] = mysqli_real_escape_string($conn, $_POST['client_name']);
$_POST['notes'] = mysqli_real_escape_string($conn, $_POST['notes']);
$_POST['deadline'] = mysqli_real_escape_string($conn, $_POST['deadline']);
$_POST['subject'] = mysqli_real_escape_string($conn, $_POST['subject']);

$client_id= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$id= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$cyd= filter_input(INPUT_POST, 'cyd', FILTER_SANITIZE_SPECIAL_CHARS);
$cancelled_dd= filter_input(INPUT_POST, 'cancelled_dd', FILTER_SANITIZE_SPECIAL_CHARS);
$new_dd= filter_input(INPUT_POST, 'new_dd', FILTER_SANITIZE_SPECIAL_CHARS);
$tps= filter_input(INPUT_POST, 'tps', FILTER_SANITIZE_SPECIAL_CHARS);
$trust= filter_input(INPUT_POST, 'trust', FILTER_SANITIZE_SPECIAL_CHARS);
$upsells= filter_input(INPUT_POST, 'upsells', FILTER_SANITIZE_SPECIAL_CHARS);


$sql = "UPDATE client_notes
SET 
notes='$_POST[notes]'
, deadline='$_POST[deadline]'
, edited='$hello_name'
, status='In Progress'
, priority='Medium'
, subject='$_POST[subject]'
, complete='Y'
, completed_by='$hello_name'
, cyd='$cyd'
, cancelled_dd='$cancelled_dd'
, new_dd='$new_dd'
, tps='$tps'
, trust='$trust'
, upsells='$upsells'
WHERE id ='$id' ";

if (mysqli_query($conn, $sql)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Notes updated.
    </div>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$sqln = "UPDATE client_notes
SET 
cyd='$cyd'
, cancelled_dd='$cancelled_dd'
, new_dd='$new_dd'
, tps='$tps'
, trust='$trust'
, upsells='$upsells'
WHERE client_id ='$client_id' ";

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
'$hello_name'
, '$client_id'
, '$_POST[policy_number]'
, '$_POST[notes]' 
, CURRENT_TIMESTAMP
, '$upsells'
, '$trust'
, '$tps'
, '$new_dd'
, '$cancelled_dd'
, '$cyd'
)";

if (mysqli_query($conn, $sql2)) {
    echo "<div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> History Updated.
    </div>";
} else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
}

$conn->close();

header('Location: ../ViewClient.php?taskcompleted&search='.$client_id); die;
?>