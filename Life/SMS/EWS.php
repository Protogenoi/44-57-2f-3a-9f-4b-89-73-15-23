<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../../includes/ADL_PDO_CON.php');
    include('../../classes/database_class.php'); 
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

    if(isset($EXECUTE)) {
        
        $COLOUR= filter_input(INPUT_POST, 'COLOUR', FILTER_SANITIZE_SPECIAL_CHARS);
        $DATE= filter_input(INPUT_POST, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
        
    if($EXECUTE=='1') {
        
    $SMS_QRY = $pdo->prepare("SELECT twilio_account_sid, AES_DECRYPT(twilio_account_token, UNHEX(:key)) AS twilio_account_token FROM twilio_account");
    $SMS_QRY->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500); 
    $SMS_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $SMS_RESULT=$SMS_QRY->fetch(PDO::FETCH_ASSOC);
    
    $SID=$SMS_RESULT['twilio_account_sid'];
    $TOKEN=$SMS_RESULT['twilio_account_token'];
  
}
}    
    
$countryCode = "+44";   

    $sth = $pdo->prepare("SELECT
    ews_data.id AS EWS_ID,
    client_details.client_id,    
    client_details.phone_number,
    CONCAT(client_details.title,
            ' ',
            client_details.first_name,
            ' ',
            client_details.last_name) AS NAME
FROM
    ews_data
        JOIN
    client_policy ON ews_data.policy_number = client_policy.policy_number
        JOIN
    client_details ON client_policy.client_id = client_details.client_id
WHERE
    ews_data.color_status = :COLOUR
    AND ews_data.clawback_date=:DATE LIMIT 25");
    $sth->bindParam(':COLOUR',$COLOUR, PDO::PARAM_STR, 100);
    $sth->bindParam(':DATE',$DATE, PDO::PARAM_STR, 100);
$sth->execute();
$result = $sth->fetchAll();

 require('../../resources/lib/twilio-php-master/Twilio/autoload.php');
 use Twilio\Rest\Client;
 $client = new Client($SID, $TOKEN);

foreach ($result as $number) {
   
    $EWS_ID=$number['EWS_ID'];
    $OLD_NUMBER=$number['phone_number'];
    $newNumber = preg_replace('/^0?/', ''.$countryCode, $OLD_NUMBER);
    $NAME=$number['NAME'];
    $CID=$number['client_id'];

$SMS_MESSAGE="$NAME it very important that we speak to you regarding your life insurnace policy. Please contact Bluestone Protect on 0845 095 0041.";

if(isset($COLOUR)) {
    
    if($COLOUR=='Black') {

        $database = new Database();
        
            $database->query("SELECT ews_sms_client_id FROM ews_sms WHERE ews_sms_client_id=:CID AND ews_sms_black='1' and ews_sms_clawback_date=:DATE");
            $database->bind(':CID',$CID);
            $database->bind(':DATE',$DATE);
            $database->execute(); 
    }
            if ($database->rowCount()>=1) {
                
if(isset($CID)) {

$NOTE_TYPE="Already Sent SMS (Bulk EWS $COLOUR | Clawback Date: $DATE)";

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:NOTE_TYPE, message=:messageholder ");
$INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
$INSERT->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':NOTE_TYPE',$NOTE_TYPE, PDO::PARAM_STR, 500);
$INSERT->bindParam(':recipientholder',$NAME, PDO::PARAM_STR, 500);
$INSERT->bindParam(':messageholder',$SMS_MESSAGE, PDO::PARAM_STR, 2500);
$INSERT->execute();

}                    
                
            }
            
            else {
                
             if($COLOUR=='Black') {   
              
                 if(isset($EWS_ID)) {
            $database->query("INSERT INTO ews_sms SET ews_sms_id_fk=:EID, ews_sms_client_id=:CID, ews_sms_black='1', ews_sms_clawback_date=:DATE");
            $database->bind(':CID',$CID);
            $database->bind(':EID',$EWS_ID);
            $database->bind(':DATE',$DATE);
            $database->execute(); 
            
                 }
             }
             
           
 $client->messages->create(
    "$newNumber",
    array(
        'from' => '+441792720471',
        'body' => "$SMS_MESSAGE",
        'statusCallback' => "https://review.adlcrm.com/Life/SMS/Status.php?EXECUTE=1"
    )
);

if(isset($CID)) {

$NOTE_TYPE="Sent SMS (Bulk EWS $COLOUR | Clawback Date: $DATE)";

$INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:NOTE_TYPE, message=:messageholder ");
$INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
$INSERT->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$INSERT->bindParam(':NOTE_TYPE',$NOTE_TYPE, PDO::PARAM_STR, 500);
$INSERT->bindParam(':recipientholder',$NAME, PDO::PARAM_STR, 500);
$INSERT->bindParam(':messageholder',$SMS_MESSAGE, PDO::PARAM_STR, 2500);
$INSERT->execute();

}
                
            }
  
  } 
 
}

    $COUNT_QRY = $pdo->prepare("SELECT
    count(ews_data.id) AS EWS_ID
FROM
    ews_data
        JOIN
    client_policy ON ews_data.policy_number = client_policy.policy_number
        JOIN
    client_details ON client_policy.client_id = client_details.client_id
WHERE
    ews_data.color_status = :COLOUR
    AND ews_data.clawback_date=:DATE LIMIT 25");
    $COUNT_QRY->bindParam(':COLOUR',$COLOUR, PDO::PARAM_STR, 100);
    $COUNT_QRY->bindParam(':DATE',$DATE, PDO::PARAM_STR, 100);
$COUNT_QRY->execute();
$REMAINING = $COUNT_QRY->rowCount();

header('Location: /Life/SMS/Bulk.php?RETURN=SENT&REMAINING='.$REMAINING.'&COLOUR='.$COLOUR.'&DATE='.$DATE); die;  
?>

