<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /../../CRMmain.php'); die;

}
    $EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($EXECUTE)){
        if($EXECUTE=='1') {           
            
            $MSG = filter_input(INPUT_POST, 'MSG', FILTER_SANITIZE_SPECIAL_CHARS);
            $TO = filter_input(INPUT_POST, 'MSG_TO', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        
               

        foreach ($TO as $SELECTED_TO) {
$database = new Database(); 
        $database->query("INSERT INTO messenger SET messenger_to=:TO, messenger_msg=:MSG, messenger_sent_by=:HELLO, messenger_company=:COMPANY");
        $database->bind(':COMPANY', $COMPANY_ENTITY);
        $database->bind(':MSG', $MSG);
        $database->bind(':TO',$SELECTED_TO);
        $database->bind(':HELLO',$hello_name);
        $database->execute();        
        
        }
            
                header('Location: ../Main.php?RETURN=MSGADDED');

        
        }
        if($EXECUTE=='2') {         
          
            $MID = filter_input(INPUT_GET, 'MID', FILTER_SANITIZE_SPECIAL_CHARS);
         $database = new Database();   
        $database->query("UPDATE messenger SET messenger_status='Read' WHERE messenger_company=:COMPANY AND messenger_id=:MID");
        $database->bind(':COMPANY', $COMPANY_ENTITY);
        $database->bind(':MID', $MID);
        $database->execute();     
        
                header('Location: ../Main.php?RETURN=MSGUPDATED');

            
        }
    }
    ?>