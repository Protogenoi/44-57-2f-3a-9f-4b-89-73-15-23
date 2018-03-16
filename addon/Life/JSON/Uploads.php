<?php
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {



if(isset($EXECUTE)) {
    require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
    
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
        JOIN
    client_policy on client_policy.client_id = client_details.client_id
WHERE
    client_details.client_id NOT IN (SELECT 
            client_id
        FROM
            client_note
        WHERE
            note_type like '%keyfacts')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_policy.insurer != 'One Family' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }
    
    if($EXECUTE=='2') {

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
            note_type = 'Closer Call Recording')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }  
    
    if($EXECUTE=='3') {

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
            note_type = 'Agent Call Recording')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }   
    
    if($EXECUTE=='4') {

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
            note_type = 'Dealsheet')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }   
    
    if($EXECUTE=='5') {

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
            note_type = 'LGpolicy')
        AND DATE(client_details.submitted_date) >= '2017-09-07'
        AND client_details.company ='Bluestone Protect'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }  
    
    if($EXECUTE=='6') {

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
            note_type = 'Sent SMS: Welcome')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }  
    
    
    if($EXECUTE=='7') {

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
            note_type = 'Policy Added')
        AND DATE(client_details.submitted_date) >= '2017-09-07' AND client_details.company !='FPG Paul'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }

    if($EXECUTE=='8') {

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
            note_type = 'Vitalitypolicy')
        AND DATE(client_details.submitted_date) >= '2018-01-01'
        AND client_details.company ='Vitality'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }   
    
    if($EXECUTE=='9') {

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
            note_type = 'SWpolicy')
        AND DATE(client_details.submitted_date) >= '2018-01-01'
        AND client_details.company ='Scottish Widows'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }  
    
    if($EXECUTE=='10') {

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
            note_type = 'Zurichpolicy')
        AND DATE(client_details.submitted_date) >= '2018-01-01'
        AND client_details.company ='Zurich'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }    
    
    if($EXECUTE=='11') {

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
            note_type = 'RLpolicy')
        AND DATE(client_details.submitted_date) >= '2018-01-01'
        AND client_details.company ='Royal London'
GROUP BY client_id
    ORDER BY client_details.submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);

    }    
    
}

        }
}
?>