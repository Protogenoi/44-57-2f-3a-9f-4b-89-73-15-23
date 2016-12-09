<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if($companynamere=='The Review Bureau') {

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}
}
$REDIRECT= filter_input(INPUT_GET, 'REDIRECT', FILTER_SANITIZE_SPECIAL_CHARS);
include('../includes/ADL_PDO_CON.php');

if ($_FILES["csv"]["size"] > 0) {

    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");

    do {
        
            $master= filter_var($data[0], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $agent= filter_var($data[1], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $policy_number= filter_var($data[2], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name= filter_var($data[3], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dob= filter_var($data[4], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $add1= filter_var($data[5], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $add2= filter_var($data[6], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $add3= filter_var($data[7], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $add4= filter_var($data[8], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $post= filter_var($data[9], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $policy_type= filter_var($data[10], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $warning= filter_var($data[11], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_full_premium_paid= filter_var($data[12], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $net_premium= filter_var($data[13], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $premium_os= filter_var($data[14], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clawback_due= filter_var($data[15], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $clawback_date= filter_var($data[16], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $policy_start_date= filter_var($data[17], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $off_risk_date= filter_var($data[18], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $seller_name= filter_var($data[19], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $frn= filter_var($data[20], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $reqs= filter_var($data[21], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ews_status_status=filter_var($data[11], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ournotes= filter_var($data[23], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            #$color_status= filter_var($data[24], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $color_status='Black';
            
            $removechars = array("'", "\"","/", "&quot;");
            
        $new_policy=str_replace("'"," ",$policy_number); //remove quote
        $new_name=str_replace(","," ",$name); // remove comma
        $new_add1=str_replace($removechars,"",$add1); // remove comma
        $new_add2=str_replace($removechars,"",$add2); // remove comma
        $new_add3=str_replace($removechars,"",$add3); // remove comma
        $new_add4=str_replace($removechars,"",$add4); // remove comma
        $new_reqs=str_replace(","," ",$reqs); // remove comma
            
$correct_dob = date("Y-m-d" , strtotime($dob)); 
$correct_paid = date("Y-m-d" , strtotime($last_full_premium_paid)); 
$correct_start = date("Y-m-d" , strtotime($policy_start_date)); 

        
        if ($data[0]) {
            if ($master != 'Master Agent No.' && $data[0] != 'Master_Agent_No.' ) {
                
            $warningcheck = $pdo->prepare("SELECT ournotes, warning, policy_number from ews_data where policy_number=:policy AND warning IN ('WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN')");
            $warningcheck->bindParam(':policy',$new_policy, PDO::PARAM_STR);
            $warningcheck->execute()or die(print_r($ewsdata->errorInfo(), true)); 
            $resultCHK=$warningcheck->fetch(PDO::FETCH_ASSOC);
            
            if ($warningcheck->rowCount() >= 1) {
                
               $newwarning=$resultCHK['warning'];
               $newnotes=$resultCHK['ournotes'];
               $newpolicy_number=$resultCHK['policy_number'];
                
                switch($newwarning) {
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
                
                $ewsdata = $pdo->prepare("UPDATE ews_data set color_status=:color_status1, ournotes=:ournotes1, processor=:processor1 WHERE policy_number=:policy1");     
                $ewsdata->bindParam(':policy1',$newpolicy_number, PDO::PARAM_STR);
                $ewsdata->bindParam(':ournotes1',$newnotes, PDO::PARAM_STR);
                $ewsdata->bindParam(':color_status1',$color, PDO::PARAM_STR);
                $ewsdata->bindParam(':processor1',$hello_name, PDO::PARAM_STR);          
                $ewsdata->execute()or die(print_r($ewsdata->errorInfo(), true));
        
        $ewsmaster = $pdo->prepare("INSERT INTO ews_data_history SET warning=:warning, master_agent_no=:master, agent_no=:agent, policy_number=:policy_number, client_name=:name, dob=:dob, address1=:add1, address2=:add2, address3=:add3, address4=:add4, post_code=:post, policy_type=:policy_type, last_full_premium_paid=:last_full_premium_paid, net_premium=:net_premium,premium_os=:premium_os, clawback_due=:clawback_due, clawback_date=:clawback_date, policy_start_date=:policy_start_date, off_risk_date=:off_risk_date, seller_name=:seller_name, frn=:frn, reqs=:reqs, processor=:processor, ews_status_status=:ews_status_status, ournotes=:ournotes, color_status=:color_status");
        $ewsmaster->bindParam(':master',$master, PDO::PARAM_INT);
        $ewsmaster->bindParam(':agent',$agent, PDO::PARAM_INT);
        $ewsmaster->bindParam(':warning',$newwarning, PDO::PARAM_STR);
        $ewsmaster->bindParam(':policy_number',$newpolicy_number, PDO::PARAM_STR);
        $ewsmaster->bindParam(':name',$new_name, PDO::PARAM_STR);
        $ewsmaster->bindParam(':dob',$correct_dob, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add1',$new_add1, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add2',$new_add2, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add3',$new_add3, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add4',$new_add4, PDO::PARAM_STR);
        $ewsmaster->bindParam(':post',$post, PDO::PARAM_STR);
        $ewsmaster->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $ewsmaster->bindParam(':last_full_premium_paid',$correct_paid, PDO::PARAM_STR);
        $ewsmaster->bindParam(':net_premium',$net_premium, PDO::PARAM_STR);
        $ewsmaster->bindParam(':premium_os',$premium_os, PDO::PARAM_STR);
        $ewsmaster->bindParam(':clawback_due',$clawback_due, PDO::PARAM_STR);
        $ewsmaster->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $ewsmaster->bindParam(':policy_start_date',$correct_start, PDO::PARAM_STR);
        $ewsmaster->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $ewsmaster->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $ewsmaster->bindParam(':frn',$frn, PDO::PARAM_STR);
        $ewsmaster->bindParam(':reqs',$new_reqs, PDO::PARAM_STR);
        $ewsmaster->bindParam(':ews_status_status',$ews_status_status, PDO::PARAM_STR);
        $ewsmaster->bindParam(':ournotes',$newnotes, PDO::PARAM_STR);
        $ewsmaster->bindParam(':color_status',$color, PDO::PARAM_STR);
        $ewsmaster->bindParam(':processor',$hello_name, PDO::PARAM_STR);               
        $ewsmaster->execute()or die(print_r($ewsmaster->errorInfo(), true)); 
        
    $query = $pdo->prepare("SELECT id, client_id, policy_number FROM client_policy where policy_number=:polhold");
    $query->bindParam(':polhold', $new_policy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC); 
    if ($query->rowCount() >= 1) {

    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    
    $note="EWS Uploaded";
    $ref= "$policynumber ($polid)";
    $messageEWS="$warning already on as $newwarning";
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $messageEWS, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
}

    }
    
    if ($warningcheck->rowCount() <= 0) {
        
        $ewsdata = $pdo->prepare("INSERT INTO ews_data SET master_agent_no=:master, agent_no=:agent, policy_number=:policy_number, client_name=:name, dob=:dob, address1=:add1, address2=:add2, address3=:add3, address4=:add4, post_code=:post, policy_type=:policy_type, warning=:warning, last_full_premium_paid=:last_full_premium_paid, net_premium=:net_premium,premium_os=:premium_os, clawback_due=:clawback_due, clawback_date=:clawback_date, policy_start_date=:policy_start_date, off_risk_date=:off_risk_date, seller_name=:seller_name, frn=:frn, reqs=:reqs, processor=:processor, ews_status_status=:ews_status_status, ournotes=:ournotes, color_status=:color_status
ON DUPLICATE KEY UPDATE date_added=CURRENT_TIMESTAMP, policy_number=:policy_number1, client_name=:name1, dob=:dob1, address1=:add11, address2=:add21, address3=:add3, address4=:add41, post_code=:post1, policy_type=:policy_type1, warning=:warning1, last_full_premium_paid=:last_full_premium_paid1, net_premium=:net_premium1,premium_os=:premium_os1, clawback_due=:clawback_due1, clawback_date=:clawback_date1, policy_start_date=:policy_start_date1, off_risk_date=:off_risk_date1, seller_name=:seller_name1, frn=:frn1, reqs=:reqs1, processor=:processor1, ews_status_status=:ews_status_status1, ournotes=:ournotes1, color_status=:color_status1");     

        $ewsdata->bindParam(':master',$master, PDO::PARAM_INT);
        $ewsdata->bindParam(':agent',$agent, PDO::PARAM_INT);
        $ewsdata->bindParam(':policy_number',$new_policy, PDO::PARAM_STR);
        $ewsdata->bindParam(':name',$new_name, PDO::PARAM_STR);
        $ewsdata->bindParam(':dob',$correct_dob, PDO::PARAM_STR);
        $ewsdata->bindParam(':add1',$new_add1, PDO::PARAM_STR);
        $ewsdata->bindParam(':add2',$new_add2, PDO::PARAM_STR);
        $ewsdata->bindParam(':add3',$new_add3, PDO::PARAM_STR);
        $ewsdata->bindParam(':add4',$new_add4, PDO::PARAM_STR);
        $ewsdata->bindParam(':post',$post, PDO::PARAM_STR);
        $ewsdata->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $ewsdata->bindParam(':warning',$warning, PDO::PARAM_STR);
        $ewsdata->bindParam(':last_full_premium_paid',$correct_paid, PDO::PARAM_STR);
        $ewsdata->bindParam(':net_premium',$net_premium, PDO::PARAM_STR);
        $ewsdata->bindParam(':premium_os',$premium_os, PDO::PARAM_STR);
        $ewsdata->bindParam(':clawback_due',$clawback_due, PDO::PARAM_STR);
        $ewsdata->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $ewsdata->bindParam(':policy_start_date',$correct_start, PDO::PARAM_STR);
        $ewsdata->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $ewsdata->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $ewsdata->bindParam(':frn',$frn, PDO::PARAM_STR);
        $ewsdata->bindParam(':reqs',$new_reqs, PDO::PARAM_STR);
        $ewsdata->bindParam(':ews_status_status',$ews_status_status, PDO::PARAM_STR);
        $ewsdata->bindParam(':ournotes',$ournotes, PDO::PARAM_STR);
        $ewsdata->bindParam(':color_status',$color_status, PDO::PARAM_STR);
        $ewsdata->bindParam(':processor',$hello_name, PDO::PARAM_STR);    
        
        //DUPE CHECK
        $ewsdata->bindParam(':policy_number1',$new_policy, PDO::PARAM_STR);
        $ewsdata->bindParam(':name1',$new_name, PDO::PARAM_STR);
        $ewsdata->bindParam(':dob1',$correct_dob, PDO::PARAM_STR);
        $ewsdata->bindParam(':add11',$new_add1, PDO::PARAM_STR);
        $ewsdata->bindParam(':add21',$new_add2, PDO::PARAM_STR);
        $ewsdata->bindParam(':add31',$new_add3, PDO::PARAM_STR);
        $ewsdata->bindParam(':add41',$new_add4, PDO::PARAM_STR);
        $ewsdata->bindParam(':post1',$post, PDO::PARAM_STR);
        $ewsdata->bindParam(':policy_type1',$policy_type, PDO::PARAM_STR);
        $ewsdata->bindParam(':warning1',$warning, PDO::PARAM_STR);
        $ewsdata->bindParam(':last_full_premium_paid1',$correct_paid, PDO::PARAM_STR);
        $ewsdata->bindParam(':net_premium1',$net_premium, PDO::PARAM_STR);
        $ewsdata->bindParam(':premium_os1',$premium_os, PDO::PARAM_STR);
        $ewsdata->bindParam(':clawback_due1',$clawback_due, PDO::PARAM_STR);
        $ewsdata->bindParam(':clawback_date1',$clawback_date, PDO::PARAM_STR);
        $ewsdata->bindParam(':policy_start_date1',$correct_start, PDO::PARAM_STR);
        $ewsdata->bindParam(':off_risk_date1',$off_risk_date, PDO::PARAM_STR);
        $ewsdata->bindParam(':seller_name1',$seller_name, PDO::PARAM_STR);
        $ewsdata->bindParam(':frn1',$frn, PDO::PARAM_STR);
        $ewsdata->bindParam(':reqs1',$new_reqs, PDO::PARAM_STR);
        $ewsdata->bindParam(':ews_status_status1',$ews_status_status, PDO::PARAM_STR);
        $ewsdata->bindParam(':ournotes1',$ournotes, PDO::PARAM_STR);
        $ewsdata->bindParam(':color_status1',$color_status, PDO::PARAM_STR);
        $ewsdata->bindParam(':processor1',$hello_name, PDO::PARAM_STR);        
        $ewsdata->execute()or die(print_r($ewsdata->errorInfo(), true));
        
        $ewsmaster = $pdo->prepare("INSERT INTO ews_data_history SET master_agent_no=:master, agent_no=:agent, policy_number=:policy_number, client_name=:name, dob=:dob, address1=:add1, address2=:add2, address3=:add3, address4=:add4, post_code=:post, policy_type=:policy_type, warning=:warning, last_full_premium_paid=:last_full_premium_paid, net_premium=:net_premium,premium_os=:premium_os, clawback_due=:clawback_due, clawback_date=:clawback_date, policy_start_date=:policy_start_date, off_risk_date=:off_risk_date, seller_name=:seller_name, frn=:frn, reqs=:reqs, processor=:processor, ews_status_status=:ews_status_status, ournotes=:ournotes, color_status=:color_status");     
        $ewsmaster->bindParam(':master',$master, PDO::PARAM_INT);
        $ewsmaster->bindParam(':agent',$agent, PDO::PARAM_INT);
        $ewsmaster->bindParam(':policy_number',$new_policy, PDO::PARAM_STR);
        $ewsmaster->bindParam(':name',$new_name, PDO::PARAM_STR);
        $ewsmaster->bindParam(':dob',$correct_dob, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add1',$new_add1, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add2',$new_add2, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add3',$new_add3, PDO::PARAM_STR);
        $ewsmaster->bindParam(':add4',$new_add4, PDO::PARAM_STR);
        $ewsmaster->bindParam(':post',$post, PDO::PARAM_STR);
        $ewsmaster->bindParam(':policy_type',$policy_type, PDO::PARAM_STR);
        $ewsmaster->bindParam(':warning',$warning, PDO::PARAM_STR);
        $ewsmaster->bindParam(':last_full_premium_paid',$correct_paid, PDO::PARAM_STR);
        $ewsmaster->bindParam(':net_premium',$net_premium, PDO::PARAM_STR);
        $ewsmaster->bindParam(':premium_os',$premium_os, PDO::PARAM_STR);
        $ewsmaster->bindParam(':clawback_due',$clawback_due, PDO::PARAM_STR);
        $ewsmaster->bindParam(':clawback_date',$clawback_date, PDO::PARAM_STR);
        $ewsmaster->bindParam(':policy_start_date',$correct_start, PDO::PARAM_STR);
        $ewsmaster->bindParam(':off_risk_date',$off_risk_date, PDO::PARAM_STR);
        $ewsmaster->bindParam(':seller_name',$seller_name, PDO::PARAM_STR);
        $ewsmaster->bindParam(':frn',$frn, PDO::PARAM_STR);
        $ewsmaster->bindParam(':reqs',$new_reqs, PDO::PARAM_STR);
        $ewsmaster->bindParam(':ews_status_status',$ews_status_status, PDO::PARAM_STR);
        $ewsmaster->bindParam(':ournotes',$ournotes, PDO::PARAM_STR);
        $ewsmaster->bindParam(':color_status',$color_status, PDO::PARAM_STR);
        $ewsmaster->bindParam(':processor',$hello_name, PDO::PARAM_STR, 100);              
        $ewsmaster->execute()or die(print_r($ewsmaster->errorInfo(), true)); 
        
    $query = $pdo->prepare("SELECT id, client_id, policy_number FROM client_policy where policy_number=:polhold");
    $query->bindParam(':polhold', $new_policy, PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    if ($query->rowCount() >= 1) {

    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    
    $note="EWS Uploaded";
    $ref= "$policynumber ($polid)";
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $warning, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
}

    }
    
    else {
        
        $fail = $pdo->prepare("INSERT INTO ews_error set error_dump=:dump, sqlsql='INSERT INTO ews_data (date_added, master_agent_no, agent_no, policy_number, client_name, dob, address1, address2, address3, address4, post_code, policy_type, warning, last_full_premium_paid,net_premium,premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, seller_name, frn, reqs, processor, ews_status_status, ournotes, color_status) VALUES (CURRENT_TIMESTAMP,$master,$agent,$policy_number,$name,$correct_dob,$add1,$add2,$add3,$add4,$post,$policy_type,$warning,$correct_paid,$net_premium,$premium_os,$clawback_due,$clawback_date,$policy_start_date,$off_risk_date,$seller_name,$frn,$reqs,$ews_status_status,$ournotes,$color_status)'");
        $fail->bindParam(':dump', $new_policy, PDO::PARAM_STR, 100);
        $fail->execute();
    
}    
            
        }
        
        
        }
        
        
    } while ($data = fgetcsv($handle,1000,",","'"));
    
    
    if(isset($REDIRECT)) {
    if($REDIRECT=='EWS') {
 header('Location: ../Life/Reports/EWS.php?RETURN=EWSUploaded'); die;   
}
}
    
    
    header('Location: ../EWSfiles.php?EWSupload=1'); die;
}

?>
