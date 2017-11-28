<?php
require_once(__DIR__ . '../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


require_once(__DIR__ . '../../../includes/adl_features.php');
require_once(__DIR__ . '../../../includes/Access_Levels.php');
require_once(__DIR__ . '../../../includes/adlfunctions.php');
require_once(__DIR__ . '../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
    $NID= filter_input(INPUT_GET, 'NID', FILTER_SANITIZE_SPECIAL_CHARS);
    $PHONE= filter_input(INPUT_GET, 'PHONE', FILTER_SANITIZE_SPECIAL_CHARS);
    $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
    $TYPE= filter_input(INPUT_GET, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);

    
    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
            if(isset($NID)) {
                
                $MESSAGE="Viewed $TYPE for $PHONE";
                    
                            $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:PHONE, sent_by=:hello, note_type='SMS Update', message=:MSG");
                            $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $INSERT->bindParam(':hello',$hello_name, PDO::PARAM_STR);
                            $INSERT->bindParam(':MSG',$MESSAGE, PDO::PARAM_STR);
                            $INSERT->bindParam(':PHONE',$PHONE, PDO::PARAM_STR);
                            $INSERT->execute();

                          $SMS_DELETE = $pdo->prepare("DELETE FROM sms_inbound WHERE sms_inbound_id=:NID LIMIT 1");
                          $SMS_DELETE->bindParam(':NID',$NID, PDO::PARAM_INT);
                          $SMS_DELETE->execute();                            
                           
                          header('Location: ../ViewClient.php?search='.$CID); die;
                          
                        }
    }

    }         
        
?>
