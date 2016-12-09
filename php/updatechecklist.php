<?php 
//print_r($_POST);

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

include('../includes/ADL_PDO_CON.php');
include('../includes/ADL_MYSQLI_CON.php');

$query = $pdo->prepare("describe taskcheck");
$query->execute();

while ($check_list_table_result=$query->fetch(PDO::FETCH_ASSOC))
{
        if($check_list_table_result['Type']=='tinyint(1)')
        {
                $TASKS_TO_DISPLAY[]=$check_list_table_result['Field'];
        }
}

$sql = "INSERT INTO taskcheck set ";

foreach($TASKS_TO_DISPLAY as $value)
{
        if(isset($_POST[$value]))
	{
                $TASK[$value]=mysqli_real_escape_string($conn, $_POST[$value]);
                $sql .= $value."='1' ,";
                //$sql .= $value."='".$TASK[$value]."' ,";
        }
	else
        {
                $sql .= $value."='0' ,";
        }

}

//$sql=substr($sql, 0, -1);


$sql.=" client_id='";
$sql.=mysqli_real_escape_string($conn, $_POST['client_id']);
$sql.="',";
$sql.=" policy_id='";
$sql.=mysqli_real_escape_string($conn, $_POST['polid']);
$sql.="'";

$sql.=" ON DUPLICATE KEY UPDATE ";

foreach($TASKS_TO_DISPLAY as $value)
{
        if(isset($_POST[$value]))
	{
                $TASK[$value]=mysqli_real_escape_string($conn, $_POST[$value]);
                $sql .= $value."='1' ,";
                //$sql .= $value."='".$TASK[$value]."' ,";
        }
	else
        {
                $sql .= $value."='0' ,";
        }

}

$sql=substr($sql, 0, -1);



$query = $pdo->prepare($sql);
$query->execute();





$keyfielddata= filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
$recipientdata= filter_input(INPUT_POST, 'JOBTYPE', FILTER_SANITIZE_SPECIAL_CHARS);
$notetypedata= "CRM Alert";
$messagedata= "Checklist updated";

foreach($TASK as $key => $val)
{
$messagedata.=' - '.$key;
}


$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$keyfielddata, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);

$query->execute();


    header("Location: ../Life/ViewClient.php?checklistupdated=y&search=".$keyfielddata."#menu4"); die;


//}

// else {
//    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//    
//    header("Location: ../ViewClient.php?checklistupdated=n&search=".$keyfielddata); die;
//}


//print_r($sql);
//print_r($TASK);

$conn->close();

?>
