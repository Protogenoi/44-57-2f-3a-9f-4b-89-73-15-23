<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);



if(isset($EXECUTE)) {
    require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
    if($EXECUTE=='1') {


        $query = $pdo->prepare("SELECT 
    keyfactsemail_email,
    keyfactsemail_added_by,
    keyfactsemail_added_date
FROM
    keyfactsemail
    ORDER BY keyfactsemail_added_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);




    }
    
        if($EXECUTE=='2') {


        $query = $pdo->prepare("SELECT 
    client_details.email,
    client_details.submitted_date,
    client_policy.closer,
    client_details.client_id
FROM
    client_details
    LEFT JOIN client_policy ON client_details.client_id=client_policy.client_id
WHERE
    client_details.submitted_date >= CURDATE()
        AND client_details.email NOT IN (SELECT 
            keyfactsemail_email
        FROM
            keyfactsemail)
    GROUP BY client_details.email ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);




    }
    
}

?>
