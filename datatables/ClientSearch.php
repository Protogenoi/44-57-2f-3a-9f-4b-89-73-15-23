<?php
$USER= filter_input(INPUT_GET, 'USER', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$TOKEN= filter_input(INPUT_GET, 'TOKEN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(isset($USER) && $TOKEN) {
    
    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_TOKEN = new UserActions($USER,$TOKEN);
        $CHECK_USER_TOKEN->CheckToken();
        $OUT=$CHECK_USER_TOKEN->CheckToken();
        
        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Bad') {
         echo "BAD";   
        }

        if(isset($OUT['TOKEN_CHECK']) && $OUT['TOKEN_CHECK']=='Good') {


include('../includes/ADL_MYSQLI_CON.php');


$ClientSearch= filter_input(INPUT_GET, 'ClientSearch', FILTER_SANITIZE_NUMBER_INT);

if(isset($ClientSearch)) {
    
    if($ClientSearch=='1') { 
        
    include('../includes/ADL_PDO_CON.php');

        $query = $pdo->prepare("SELECT company, phone_number, submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details ORDER BY client_id DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
        }
        
        if($ClientSearch=='4') { 
            
                $sql = 'SELECT CONCAT(firstname, " ", lastname) AS Name, CONCAT (firstname2, " ", lastname2) AS Name2, submitted_date, tel, tel2, post_code, client_id FROM pba_client_details';
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
            
            }
            
    if($ClientSearch=='5') { 
        
    include('../includes/ADL_PDO_CON.php');
        $query = $pdo->prepare("SELECT company, phone_number, submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details WHERE company='TRB Home Insurance' ORDER BY submitted_date DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));
echo json_encode($results);
        
        }              
        
    if($ClientSearch=='6') { 
        
    include('../includes/ADL_PDO_CON.php');

$query = $pdo->prepare("SELECT submitted_date, client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name, CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2, post_code FROM client_details ORDER BY client_id DESC");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
        }        
            
        }            
            
}

} else {

    header('Location: /../../CRMmain.php');
    die;
    
}
?>

