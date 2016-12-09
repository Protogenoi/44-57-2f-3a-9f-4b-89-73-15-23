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


$keyfielddata= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$recipientdata= filter_input(INPUT_POST, 'client_name', FILTER_SANITIZE_SPECIAL_CHARS);
$notetypedata= filter_input(INPUT_POST, 'note_type', FILTER_SANITIZE_SPECIAL_CHARS);
$messagedata= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$keyfielddata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);

$query->execute();

echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Client notes database updated.
    </div>";

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
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Client/Policy Timeline updated.
    </div>";
    echo "<br>";
} else {
    echo "Error: " . $sql4 . "<br>" . mysqli_error($conn);
}

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
    echo "<div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> EWS Notes Added.
    </div> ";
} else {
    echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
}


 
header('Location: ../ViewClient.php?clientnotesadded&search='.$keyfielddata.'#menu4'); die;

?>

