<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 10);
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

$taskid= filter_input(INPUT_POST, 'taskid', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
$subject= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "UPDATE client_notes SET notes='$notes' WHERE id ='taskid'
";

if (mysqli_query($conn, $sql)) {
    
    $notetypedata= "Note Edited";

$query = $pdo->prepare("INSERT INTO client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$search, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$subject, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$notes, PDO::PARAM_STR, 2500);

$query->execute();
    
    
    header('Location: ../ViewClient.php?taskedited=y&search='.$search); die;
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>

