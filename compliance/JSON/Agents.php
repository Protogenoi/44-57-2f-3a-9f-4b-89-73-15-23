<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/Access_Levels.php');
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
        
            if (in_array($hello_name, $TRB_ACCESS, true)) { 
    $COMPANY='The Review Bureau';
    }
        if (in_array($hello_name, $PFP_ACCESS, true)) { 
    $COMPANY='Protect Family Plans';
    }
        if (in_array($hello_name, $PLL_ACCESS, true)) { 
    $COMPANY='Protected Life Ltd';
    }
        if (in_array($hello_name, $WI_ACCESS, true)) { 
    $COMPANY='We Insure';
    }
        if (in_array($hello_name, $TFAC_ACCESS, true)) { 
    $COMPANY='The Financial Assessment Centre';
    }
        if (in_array($hello_name, $APM_ACCESS, true)) { 
    $COMPANY='Assured Protect and Mortgages';
    }
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 

        $query = $pdo->prepare("SELECT CONCAT(firstname, ' ', lastname) AS FULL_NAME from employee_details WHERE position='Closer' ORDER BY lastname");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));
        
        } else {
                    $query = $pdo->prepare("SELECT CONCAT(firstname, ' ', lastname) AS FULL_NAME from employee_details WHERE company=:COMPANY AND position='Closer' ORDER BY lastname");
        $query->bindParam(':COMPANY', $COMPANY, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));
            
        }

        echo json_encode($results);
        
}

}
  
?>