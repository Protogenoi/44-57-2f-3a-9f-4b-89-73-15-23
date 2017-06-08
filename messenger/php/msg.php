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
            
    if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY_ENTITY='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY_ENTITY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY_ENTITY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY_ENTITY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY_ENTITY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY_ENTITY='Assured Protect and Mortgages';
    }
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    $COMPANY_ENTITY= filter_input(INPUT_POST, 'COMPANY_ENTITY', FILTER_SANITIZE_SPECIAL_CHARS);
    }            
            
            $MSG = filter_input(INPUT_POST, 'MSG', FILTER_SANITIZE_SPECIAL_CHARS);
            $TO = filter_input(INPUT_POST, 'MSG_TO', FILTER_SANITIZE_SPECIAL_CHARS);
        $database = new Database();    
        $database->query("INSERT INTO messenger SET messenger_to=:TO, messenger_msg=:MSG, messenger_sent_by=:HELLO, messenger_company=:COMPANY");
        $database->bind(':COMPANY', $COMPANY_ENTITY);
        $database->bind(':MSG', $MSG);
        $database->bind(':TO',$TO);
        $database->bind(':HELLO',$hello_name);
        $database->execute();            
            
                header('Location: ../Main.php?RETURN=MSGADDED');

        
        }
        if($EXECUTE=='2') {
            
    if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY_ENTITY='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY_ENTITY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY_ENTITY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY_ENTITY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY_ENTITY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY_ENTITY='Assured Protect and Mortgages';
    }          
            
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