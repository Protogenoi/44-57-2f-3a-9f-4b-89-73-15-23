<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_FULL_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 6) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }


$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);     

if(isset($EXECUTE)) {
    if($EXECUTE== 1 ) {
     
if ($_FILES["csv"]["size"] > 0) {

    
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-EWS";
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder="../Life/EWS/uploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
 

    do {
        
        if(isset($data[0])){
            $DATES=filter_var($data[0],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[1])){
            $TITLE=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $FIRST=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $LAST=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $ADD=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
            
            if(isset($data[5])){
            $POST=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[6])){
            $PHONE=filter_var($data[6],FILTER_SANITIZE_NUMBER_INT); 
            }
            if(isset($data[7])){
            $EMAIL=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }

// CHECK THERE IS DATA            
            if(isset($data[0])) {

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT client_id FROM client_details WHERE address1=:ADD");
                    $CHK_ADL_WARNINGS->bindParam(':ADD',$ADD, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->execute()or die(print_r($ewsdata->errorInfo(), true)); 
                    $row=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC);
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
echo "DUPE CHK<br>";
                    }
    
    if($CHK_ADL_WARNINGS->rowCount() <= 0) { // INSERT THE REST
echo "INSERT<br>";
        $INSERT_MASTER = $pdo->prepare('INSERT INTO 
                                            client_details 
                                        SET
                                            title=:TITLE, 
                                            first_name=:FIRST, 
                                            last_name=:LAST, 
                                            address1=:ADD, 
                                            post_code=:POST, 
                                            phone_number=:PHONE, 
                                            email=:EMAIL,
                                            date_added=:DATE,
                                            submitted_date=:DATES,
                                            company="FPG Paul",
                                            submitted_by="ADL"
                                         ');     
        $INSERT_MASTER->bindParam(':TITLE',$TITLE, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':FIRST',$FIRST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':LAST',$LAST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':ADD',$ADD, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':POST',$POST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':PHONE',$PHONE, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':EMAIL',$EMAIL, PDO::PARAM_STR); 
        $INSERT_MASTER->bindParam(':DATE',$NEWDATE, PDO::PARAM_STR); 
        $INSERT_MASTER->bindParam(':DATES',$NEWDATE, PDO::PARAM_STR); 
        $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true)); 


    }  

        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));
    

 //header('Location: ../CRMmain.php?UPLOADED'); die;   
 
    
}

    }
    
if($EXECUTE== '2') {    
    echo "EXECUTE 2";
if ($_FILES["csv"]["size"] > 0) {

    
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-EWS";
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder="../Life/EWS/uploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
 

    do {
        
        if(isset($data[0])){
            $DATES=filter_var($data[0],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[1])){
            $TITLE=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $FIRST=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $LAST=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $TITLE2=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[5])){
            $FIRST2=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[6])){
            $LAST2=filter_var($data[6],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }        
        
        if(isset($data[7])){
            $ADD=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
            
            if(isset($data[8])){
            $POST=filter_var($data[8],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[9])){
            $PHONE=filter_var($data[9],FILTER_SANITIZE_NUMBER_INT); 
            }
            if(isset($data[10])){
            $EMAIL=filter_var($data[10],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }

// CHECK THERE IS DATA            
            if(isset($data[0])) {

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT client_id FROM client_details WHERE address1=:ADD");
                    $CHK_ADL_WARNINGS->bindParam(':ADD',$ADD, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->execute()or die(print_r($ewsdata->errorInfo(), true)); 
                    $row=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC);
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
echo "DUPE CHK<br>";
                    }
    
    if($CHK_ADL_WARNINGS->rowCount() <= 0) { // INSERT THE REST
echo "INSERT<br>";
        $INSERT_MASTER = $pdo->prepare('INSERT INTO 
                                            client_details 
                                        SET
                                            title=:TITLE, 
                                            first_name=:FIRST, 
                                            last_name=:LAST, 
                                            title2=:TITLE2, 
                                            first_name2=:FIRST2, 
                                            last_name2=:LAST2,                                             
                                            address1=:ADD, 
                                            post_code=:POST, 
                                            phone_number=:PHONE, 
                                            email=:EMAIL,
                                            date_added=:DATE,
                                            submitted_date=:DATES,
                                            company="FPG Paul",
                                            submitted_by="ADL"
                                         ');     
        $INSERT_MASTER->bindParam(':TITLE',$TITLE, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':FIRST',$FIRST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':LAST',$LAST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':TITLE2',$TITLE2, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':FIRST2',$FIRST2, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':LAST2',$LAST2, PDO::PARAM_STR);        
        $INSERT_MASTER->bindParam(':ADD',$ADD, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':POST',$POST, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':PHONE',$PHONE, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':EMAIL',$EMAIL, PDO::PARAM_STR); 
        $INSERT_MASTER->bindParam(':DATE',$NEWDATE, PDO::PARAM_STR); 
        $INSERT_MASTER->bindParam(':DATES',$NEWDATE, PDO::PARAM_STR); 
        $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true)); 


    }  

        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));
    

 //header('Location: ../CRMmain.php?UPLOADED'); die;   
 
    
}    
    
}


if($EXECUTE== '3') {    
    echo "EXECUTE 3";
if ($_FILES["csv"]["size"] > 0) {

    
    $file = $_FILES["csv"]["tmp_name"];
    $handle = fopen($file,"r");
    
            $date=date("y-m-d-G:i:s");
            
            $fileup = $date."-".$hello_name."-EWS";
            $file_loc = $_FILES["csv"]["tmp_name"];
            $file_size = $_FILES["csv"]["size"];
            $file_type = $_FILES["csv"]["type"];
            $folder="../Life/EWS/uploads/";
            
            $new_size = $file_size/1024;  
            $new_file_name = strtolower($fileup);
            $final_file=str_replace("'","",$new_file_name);
 

    do {
        
        if(isset($data[0])){
            $CID=filter_var($data[0],FILTER_SANITIZE_NUMBER_INT); 
        }
        
        if(isset($data[1])){
            $NAME=filter_var($data[1],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[2])){
            $LEAD=filter_var($data[2],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[3])){
            $CLOSER=filter_var($data[3],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[4])){
            $INSURER=filter_var($data[4],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[5])){
            $POLICY_NUM=filter_var($data[5],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
        
        if(isset($data[6])){
            $PREM=filter_var($data[6],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }        
        
        if(isset($data[7])){
            $COMM=filter_var($data[7],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
        }
            
            if(isset($data[8])){
            $SUB_DATE=filter_var($data[8],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            }
            
            if(isset($data[9])){
            $SALE_DATE=filter_var($data[9],FILTER_SANITIZE_NUMBER_INT); 
            }


// CHECK THERE IS DATA            
            if(isset($data[0])) {

//CHECK IF POL ALREADY EXISTS AND CHECK ADL STATUS TO SET COLOURS WILL CANCEL','WILL REDRAW','CANCELLED','REDRAWN','FUTURE CALLBACK

                    $CHK_ADL_WARNINGS = $pdo->prepare("SELECT client_id FROM client_policy WHERE policy_number=:POL");
                    $CHK_ADL_WARNINGS->bindParam(':POL',$POLICY_NUM, PDO::PARAM_STR);
                    $CHK_ADL_WARNINGS->execute()or die(print_r($ewsdata->errorInfo(), true)); 
                    $row=$CHK_ADL_WARNINGS->fetch(PDO::FETCH_ASSOC);
                    
                    if($CHK_ADL_WARNINGS->rowCount() >= 1) {
$POLICY_NUM="$POLICY_NUM DUPE";
                    }
 // INSERT THE REST
                    
                    if($INSURER == 'Legal and General') {
                       $POLICY_NUM="0$POLICY_NUM"; 
                    }
echo "INSERT<br>";
        $INSERT_MASTER = $pdo->prepare('INSERT INTO 
                                            client_policy 
                                        SET
                                            client_id=:CID, 
                                            client_name=:NAME, 
                                            lead=:LEAD, 
                                            closer=:CLOSER, 
                                            insurer=:INSURER, 
                                            policy_number=:POLICY,                                             
                                            premium=:PREM, 
                                            commission=:COMM, 
                                            soj="Single",
                                            submitted_date=:SALE,
                                            sale_date=:SUB
                                         ');     
        $INSERT_MASTER->bindParam(':CID',$CID, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':NAME',$NAME, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':LEAD',$LEAD, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':CLOSER',$CLOSER, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':INSURER',$INSURER, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':POLICY',$POLICY_NUM, PDO::PARAM_STR);        
        $INSERT_MASTER->bindParam(':PREM',$PREM, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':COMM',$COMM, PDO::PARAM_STR);
        $INSERT_MASTER->bindParam(':SUB',$SUB_DATE, PDO::PARAM_INT);
        $INSERT_MASTER->bindParam(':SALE',$SALE_DATE, PDO::PARAM_STR);
        $INSERT_MASTER->execute()or die(print_r($INSERT_MASTER->errorInfo(), true)); 

        
        } // END CHECK IF THERES DATA
        
    } 
    
    while ($data = fgetcsv($handle,1000,",",'"'));
    

 //header('Location: ../CRMmain.php?UPLOADED'); die;   
 
    
}    
    
}

}

?>
