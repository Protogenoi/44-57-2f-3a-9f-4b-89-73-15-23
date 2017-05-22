<?php

$COLOUR= filter_input(INPUT_GET, 'COLOUR', FILTER_SANITIZE_SPECIAL_CHARS);
$DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    
    require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');
    if($EXECUTE=='1') { 

        $query = $pdo->prepare("SELECT
            sms_inbound_type,
    client_note.date_sent,
    ews_data.policy_number,
    ews_data.clawback_date,
    ews_data.warning,
    client_details.phone_number,
    client_details.client_id,
    CONCAT(client_details.title,
            ' ',
            client_details.first_name,
            ' ',
            client_details.last_name) AS Name,
    CONCAT(client_details.title2,
            ' ',
            client_details.first_name2,
            ' ',
            client_details.last_name2) AS Name2
FROM
    ews_sms
        JOIN
    client_details ON ews_sms_client_id = client_details.client_id
        JOIN
    ews_data ON ews_sms_id_fk = ews_data.id
        JOIN
    client_note ON client_note.client_id = ews_sms_client_id
        LEFT JOIN
        sms_inbound on ews_sms_client_id = sms_inbound.sms_inbound_client_id");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
        }

    if($EXECUTE=='2') { 

        $query = $pdo->prepare("SELECT 
            sms_inbound_type,
    client_note.date_sent,
    ews_data.policy_number,
    ews_data.clawback_date,
    ews_data.warning,
    client_details.phone_number,
    client_details.client_id,
    CONCAT(client_details.title,
            ' ',
            client_details.first_name,
            ' ',
            client_details.last_name) AS Name,
    CONCAT(client_details.title2,
            ' ',
            client_details.first_name2,
            ' ',
            client_details.last_name2) AS Name2
FROM
    ews_sms
        JOIN
    client_details ON ews_sms_client_id = client_details.client_id
        JOIN
    ews_data ON ews_sms_id_fk = ews_data.id
        JOIN
    client_note ON client_note.client_id = ews_sms_client_id
        LEFT JOIN
        sms_inbound on ews_sms_client_id = sms_inbound.sms_inbound_client_id    
WHERE
    ews_sms_black = '1'
        AND client_note.note_type = 'Already Sent SMS (Bulk EWS Black)'");
$query->execute()or die(print_r($query->errorInfo(), true));
json_encode($results['aaData']=$query->fetchAll(PDO::FETCH_ASSOC));

echo json_encode($results);
        
        }        
            
        }            
          
?>

