<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/Access_Levels.php');

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    if($EXECUTE=='1') {
        require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
        
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 

        $query = $pdo->prepare("SELECT login AS FULL_NAME from users WHERE active='y' AND extra_info='User' ORDER BY login");
        $query->execute()or die(print_r($query->errorInfo(), true));
        json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));
        
        } else {
                    $query = $pdo->prepare("SELECT login AS FULL_NAME from users WHERE active='y' AND extra_info='User' AND company=:COMPANY ORDER BY login");
                    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
                    $query->execute()or die(print_r($query->errorInfo(), true));
                    json_encode($results= $query->fetchAll(PDO::FETCH_ASSOC));
            
        }

        echo json_encode($results);
        
}

}
  
?>