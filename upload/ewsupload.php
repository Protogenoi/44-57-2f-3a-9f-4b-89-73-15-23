<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_FULL_SPECIAL_CHARS), "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$REDIRECT= filter_input(INPUT_GET, 'REDIRECT', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($_FILES["csv"]["size"] > 0) {

    
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-".EWS;
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder="../Life/EWS/uploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
            
            if(move_uploaded_file($file_loc,$folder.$final_file)) {

                
                $query= $pdo->prepare("INSERT INTO tbl_uploads set file=:file, type=:type, size=:size, uploadtype='EWS Upload'");
                $query->bindParam(':file',$final_file, PDO::PARAM_STR);
                $query->bindParam(':type',$file_type, PDO::PARAM_STR);
                $query->bindParam(':size',$new_size, PDO::PARAM_STR);
                $query->execute(); 
                
            }
 

    do {
        
        if(isset($data[0])){
            $master=filter_var($data[0],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[1])){
            $agent=filter_var($data[1],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[2])){
            $policy_number=filter_var($data[2],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[3])){
            $name=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $dob=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
            
            if(isset($data[5])){
            $add1=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[6])){
            $add2=filter_var($data[6],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            if(isset($data[7])){
            $add3=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            if(isset($data[8])){
            $add4=filter_var($data[8],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            if(isset($data[9])){
            $post=filter_var($data[9],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
            
            if(isset($data[10])){
            $policy_type=filter_var($data[10],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            
            }
            
            if(isset($data[11])){
            $warning=filter_var($data[11],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            $NEW_EWS="$warning NEW";
            }
            
            if(isset($data[12])){
            $last_full_premium_paid=filter_var($data[12],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[13])){
            $net_premium=filter_var($data[13],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[14])){
            $premium_os=filter_var($data[14],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[15])){
            $clawback_due=filter_var($data[15],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[16])){
            $clawback_date=filter_var($data[16],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[17])){
            $policy_start_date=filter_var($data[17],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[18])){
            $off_risk_date=filter_var($data[18],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[19])){
            $seller_name=filter_var($data[19],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[20])){
            $frn=filter_var($data[20],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[21])){
            $reqs=filter_var($data[21],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[22])){
            $ASSIGNED=filter_var($data[22],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            $color_status='Black';

// CHECK THERE IS DATA            
            if(isset($data[0])) {
                if(is_numeric($data[1]) ) {  //IGNORE FIRST ROW

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT warning, policy_number from ews_data where policy_number=:POLICY AND warning IN ('WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN')");
                    $CHK_ADL_WARNINGS->bindParam(':POLICY',$policy_number, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->execute()or die(print_r($ewsdata->errorInfo(), true)); 
                    $row=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC);
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
                        
                        $ORIG_WARNING=$row['warning'];
                        $ORIG_POL_NUM=$row['policy_number'];
                
                switch($ORIG_WARNING) {
                    case "WILL CANCEL";
                        $color='orange';
                        break;
                    case "CANCELLED";
                        $color="red";
                        break;
                    case "REDRAWN";
                        case "WILL REDRAW";
                            $color="purple";
                            break;
                            default:
                                $color="black"; 
                                
                }

//UPDATE EWS AND KEEP OLD WARNINGS
                
                $UPDATE_EWS = $pdo->prepare('UPDATE ews_data set color_status=:COLOUR, processor=:HELLO, ews_status_status=:UP_WARNING WHERE policy_number=:POLICY');     
                $UPDATE_EWS->bindParam(':POLICY',$ORIG_POL_NUM, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':COLOUR',$color, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':UP_WARNING',$warning, PDO::PARAM_STR);
                $UPDATE_EWS->bindParam(':HELLO',$hello_name, PDO::PARAM_STR);          
                $UPDATE_EWS->execute()or die(print_r($UPDATE_EWS->errorInfo(), true));
                
// ALLWAYS INSERT INTO MASTER
                
        $INSERT_MASTER = $pdo->prepare('INSERT INTO
                ews_data_history 
                SET
                assigned=:ASSIGNED,
                warning=:warning, 
                master_agent_no=:master, 
                agent_no=:agent, 
                policy_number=:policy_number, 
                client_name=:name, 
                dob=:dob, 
                address1=:add1, 
                address2=:add2, 
                address3=:add3, 
                address4=:add4, 
                post_code=:post, 
                policy_type=:policy_type, 
                last_full_premium_paid=:last_full_premium_paid, 
                net_premium=:net_premium,
                premium_os=:premium_os, 
                clawback_due=:clawback_due, 
                clawback_date=:clawback_date, 
                policy_start_date=:policy_start_date, 
                off_risk_date=:off_risk_date, 
                seller_name=:seller_name, 
                frn=:frn, 
                reqs=:reqs, 
                processor=:processor, 
                ews_status_status=:ews_status_status, 
                color_status=:color_status');
        $INSERT_MASTER->bindParam(':ASSIGNED',$ASSIGNED, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':master',$master, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':agent',$agent, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':warning',$ORIG_WARNING, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_number',$ORIG_POL_NUM, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':name',$name, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':dob',$dob, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add1',$add1, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add2',$add2, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add3',$add3, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add4',$add4, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':post',$post, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':last_full_premium_paid',$last_full_premium_paid, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':net_premium',$net_premium, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':premium_os',$premium_os, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':clawback_due',$clawback_due, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_start_date',$policy_start_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':frn',$frn, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':reqs',$reqs, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':ews_status_status',$warning, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':color_status',$color, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':processor',$hello_name, PDO::PARAM_STR);               
        $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true)); 
        
//MATCH POLICY TO ADL TO GET CLIENT ID        
        
    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy where policy_number=:POL_NUM');
    $SELECT_CID->bindParam(':POL_NUM', $policy_number, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC); 
    if ($SELECT_CID->rowCount() >= 1) {

    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];
    
    $note="EWS Uploaded";
    $ref= "$POL_NUMBER ($PID)";
    $messageEWS="$warning already on as $ORIG_WARNING";
    
//INSERT NOTE INTO CLIENT TIMELINE    
    
    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':clientid', $CID, PDO::PARAM_INT);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':message', $messageEWS, PDO::PARAM_STR);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR);
    $INSERT_TIMELINE->execute();
}

    } //END OF UPDATES
    
    if ($CHK_ADL_WARNINGS->rowCount() <= 0) { // INSERT THE REST
        
        $INSERT_EWS = $pdo->prepare('INSERT INTO ews_data 
            SET 
            assigned=:ASSIGNED,
            master_agent_no=:master, 
            agent_no=:agent, 
            policy_number=:policy_number, 
            client_name=:name, 
            dob=:dob, 
            address1=:add1, 
            address2=:add2, 
            address3=:add3, 
            address4=:add4, 
            post_code=:post, 
            policy_type=:policy_type, 
            warning=:warning, 
            last_full_premium_paid=:last_full_premium_paid, 
            net_premium=:net_premium,
            premium_os=:premium_os, 
            clawback_due=:clawback_due, 
            clawback_date=:clawback_date, 
            policy_start_date=:policy_start_date, 
            off_risk_date=:off_risk_date, 
            seller_name=:seller_name, 
            frn=:frn, 
            reqs=:reqs, 
            processor=:processor, 
            ews_status_status=:ews_status_status, 
            color_status=:color_status
                ON DUPLICATE KEY UPDATE
                assigned=:ASSIGNED2,
                date_added=CURRENT_TIMESTAMP, 
                policy_number=:policy_number1, 
                client_name=:name1, 
                dob=:dob1, 
                address1=:add11, 
                address2=:add21, 
                address3=:add3, 
                address4=:add41, 
                post_code=:post1, 
                policy_type=:policy_type1, 
                warning=:warning1, 
                last_full_premium_paid=:last_full_premium_paid1, 
                net_premium=:net_premium1,
                premium_os=:premium_os1, 
                clawback_due=:clawback_due1, 
                clawback_date=:clawback_date1, 
                policy_start_date=:policy_start_date1, 
                off_risk_date=:off_risk_date1, 
                seller_name=:seller_name1, 
                frn=:frn1, 
                reqs=:reqs1, 
                processor=:HELLO, 
                ews_status_status=:ews_status_status1, 
                color_status=:COLOUR');     

        $INSERT_EWS->bindParam(':master',$master, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':agent',$agent, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':policy_number',$policy_number, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':name',$name, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':dob',$dob, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ASSIGNED',$ASSIGNED, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add1',$add1, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add2',$add2, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add3',$add3, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add4',$add4, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':post',$post, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':warning',$NEW_EWS, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':last_full_premium_paid',$last_full_premium_paid, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':net_premium',$net_premium, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':premium_os',$premium_os, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':clawback_due',$clawback_due, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':policy_start_date',$policy_start_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':frn',$frn, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':reqs',$reqs, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ews_status_status',$warning, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':color_status',$color_status, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':processor',$hello_name, PDO::PARAM_STR);    
        
        //DUPE CHECK
        $INSERT_EWS->bindParam(':policy_number1',$policy_number, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':name1',$name, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ASSIGNED2',$ASSIGNED, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':dob1',$dob, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add11',$add1, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add21',$add2, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add31',$add3, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':add41',$add4, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':post1',$post, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':policy_type1',$policy_type, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':warning1',$warning, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':last_full_premium_paid1',$last_full_premium_paid, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':net_premium1',$net_premium, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':premium_os1',$premium_os, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':clawback_due1',$clawback_due, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':clawback_date1',$clawback_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':policy_start_date1',$policy_start_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':off_risk_date1',$off_risk_date, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':seller_name1',$seller_name, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':frn1',$frn, PDO::PARAM_INT);
        $INSERT_EWS->bindParam(':reqs1',$reqs, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':ews_status_status1',$warning, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':COLOUR',$color_status, PDO::PARAM_STR);
        $INSERT_EWS->bindParam(':HELLO',$hello_name, PDO::PARAM_STR);        
        $INSERT_EWS->execute()or die(print_r($INSERT_EWS->errorInfo(), true));
        
        $INSERT_MASTER = $pdo->prepare('INSERT INTO ews_data_history SET assigned=:ASSIGNED, master_agent_no=:master, agent_no=:agent, policy_number=:policy_number, client_name=:name, dob=:dob, address1=:add1, address2=:add2, address3=:add3, address4=:add4, post_code=:post, policy_type=:policy_type, warning=:warning, last_full_premium_paid=:last_full_premium_paid, net_premium=:net_premium,premium_os=:premium_os, clawback_due=:clawback_due, clawback_date=:clawback_date, policy_start_date=:policy_start_date, off_risk_date=:off_risk_date, seller_name=:seller_name, frn=:frn, reqs=:reqs, processor=:processor, ews_status_status=:ews_status_status, color_status=:color_status');     
        $INSERT_MASTER->bindParam(':master',$master, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':agent',$agent, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':ASSIGNED',$ASSIGNED, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_number',$policy_number, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':name',$name, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':dob',$dob, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add1',$add1, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add2',$add2, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add3',$add3, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':add4',$add4, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':post',$post, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':warning',$NEW_EWS, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':last_full_premium_paid',$last_full_premium_paid, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':net_premium',$net_premium, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':premium_os',$premium_os, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':clawback_due',$clawback_due, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':policy_start_date',$policy_start_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':frn',$frn, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':reqs',$reqs, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':ews_status_status',$warning, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':color_status',$color_status, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':processor',$hello_name, PDO::PARAM_STR);              
        $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true)); 
             
    //INSERT INTO CLIENT TIMELINE 
        
    $SELECT_CID = $pdo->prepare('SELECT id, client_id, policy_number FROM client_policy where policy_number=:POL_NUM');
    $SELECT_CID->bindParam(':POL_NUM', $policy_number, PDO::PARAM_STR);
    $SELECT_CID->execute();
    $result=$SELECT_CID->fetch(PDO::FETCH_ASSOC);
    if ($SELECT_CID->rowCount() >= 1) {

    $CID=$result['client_id'];
    $PID=$result['id'];
    $POL_NUMBER=$result['policy_number'];
    
    $note="EWS Uploaded";
    $ref= "$POL_NUMBER ($PID)";
    
    $INSERT_TIMELINE = $pdo->prepare('INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent');
    $INSERT_TIMELINE->bindParam(':clientid', $CID, PDO::PARAM_STR, 12);
    $INSERT_TIMELINE->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $INSERT_TIMELINE->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $INSERT_TIMELINE->bindParam(':message', $warning, PDO::PARAM_STR, 250);
    $INSERT_TIMELINE->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $INSERT_TIMELINE->execute();
}

    }  
            
        }
        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));
    
    if(isset($REDIRECT)) {
    if($REDIRECT=='EWS') {
 header('Location: ../Life/Reports/EWS.php?RETURN=EWSUploaded'); die;   
}
}
    
    
}

?>
