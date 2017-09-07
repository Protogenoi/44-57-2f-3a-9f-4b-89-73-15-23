<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);



if(isset($EXECUTE)) {
    require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
    if($EXECUTE=='1') {


        $query = $pdo->prepare("
SELECT 
    client_details.client_id,
    client_details.submitted_date,
    CONCAT(title, ' ', first_name, ' ', last_name) AS Name,
    CONCAT(title2,
            ' ',
            first_name2,
            ' ',
            last_name2) AS Name2,
    post_code,
    client_details.company
FROM
    client_details
        JOIN
    client_note ON client_note.client_id = client_details.client_id
WHERE
    client_details.client_id NOT IN (SELECT 
            client_id
        FROM
            client_note
        WHERE
            note_type like '%keyfacts')
        AND DATE(client_details.submitted_date) >= '2017-09-07'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);




    }
    
}

?>
