<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 1) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
$SID = filter_input(INPUT_GET, 'SID', FILTER_SANITIZE_NUMBER_INT);
$NOTES = filter_input(INPUT_POST, 'NOTES', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$STATUS = filter_input(INPUT_POST, 'DISPO', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($EXECUTE)) {
    if($EXECUTE == 1 ) {
        
        $database = new Database();
        $database->beginTransaction();

        $database->query("  UPDATE
                                  survey_tracker 
                            SET 
                                survey_tracker_notes=:NOTES, 
                                survey_tracker_status=:STATUS, 
                                survey_tracker_call_count = survey_tracker_call_count + 1 
                            WHERE 
                                survey_tracker_id=:SID 
                            AND 
                                survey_tracker_agent=:USER");
        $database->bind(':SID', $SID);
        $database->bind(':USER', $hello_name);
        $database->bind(':NOTES',$NOTES);
        $database->bind(':STATUS',$STATUS);
        $database->execute();
        
 $database->query("  INSERT INTO
                                  survey_history 
                            SET 
                                survey_history_id_fk=:SID, 
                                survey_history_status=:STATUS");
        $database->bind(':SID', $SID);
        $database->bind(':STATUS',$STATUS);
        $database->execute();        

        $database->endTransaction();     
        
        header('Location: ../Survey.php?EXECUTE=1&TRACKER=UPDATED');
        die;
        
    }
    
    if($EXECUTE == 2 ) {

if ($_FILES["csv"]["size"] > 0) {

    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-SURVEY-DATA";
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder=filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/addon/Trackers/Uploads/Survey/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {
                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype='SURVEY Upload'");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->execute(); 
                
            }

    do {
        
        if(isset($data[0])){
            $NUMBER=filter_var($data[0],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[1])){
            $AGENT=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }

            if(isset($data[0])) {
                if(is_numeric($data[0]) ) {
    
        $database = new Database();
        $database->beginTransaction();

        $database->query("  INSERT INTO
                                  survey_tracker 
                            SET 
                                survey_tracker_number=:NUMBER, 
                                survey_tracker_agent=:AGENT");
        $database->bind(':AGENT', $AGENT);
        $database->bind(':NUMBER', $NUMBER);
        $database->execute();

        $database->endTransaction();  
}

    }  
            
        }
    
    while ($data = fgetcsv($handle,1000,",",'"'));
    
header('Location: ../Survey.php?EXECUTE=1&TRACKER=UPLOADED'); 
die;
    
    
}
    }
    
}

header('Location: /../../../../CRMmain.php');
die;
?>