<?php

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
        
        if($ClientSearch=='2') {   
            
            $sql = 'SELECT added_by, submitted_date, client_id, CONCAT(title, " ", first_name, " ", last_name) AS Name, CONCAT(title2, " ", first_name2, " ", last_name2) AS Name2, post_code, email, number1 FROM pension_clients ';
            $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));
            
            $rows = array();
            while($r =mysqli_fetch_assoc($result)) {
                $rows['aaData'][] = $r;
                
            }
            
            print json_encode($rows); 
            
            }  
            
            if($ClientSearch=='3') { 
            
                $sql = 'SELECT assura_client_details.home_email, assura_client_details.office_email, assura_client_details.date_created, assura_client_details.client_id, CONCAT(assura_client_details.title, " ", assura_client_details.firstname, " ", assura_client_details.surname) AS Name, assura_client_details.postcode, assura_client_details.dob, assura_client_details.home_email, assura_client_details.DaytimeTel, assura_client_details.MobileTel, assura_client_details.EveningTel, assura_client_details.Client_telephone 
FROM assura_client_details
JOIN assura_client_policy
ON assura_client_details.client_id = assura_client_policy.ref_id
 ';
    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

print json_encode($rows);
            
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
            
        }            
            


?>

