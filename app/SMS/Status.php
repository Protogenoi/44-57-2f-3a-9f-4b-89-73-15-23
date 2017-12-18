<?php
require_once(__DIR__ . '/../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
    $MessageStatus= filter_input(INPUT_POST, 'MessageStatus', FILTER_SANITIZE_SPECIAL_CHARS);
    $TO= filter_input(INPUT_POST, 'To', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($EXECUTE)) {
                    require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');
                    require_once(__DIR__ . '/../../classes/database_class.php');        
        if($EXECUTE=='1') {
            if(isset($MessageStatus)) {
                if($MessageStatus=='delivered') {
                    
                    $database = new Database(); 
                    
                    $CALLID = preg_replace('~^[0\D]++44|\D++~', '0', $TO);
                    
                    $database->query("SELECT client_id FROM client_details WHERE phone_number =:CALLID");
                    $database->bind(':CALLID', $CALLID);
                    $database->execute();
                    $data2=$database->single();
                    
                    if(isset($data2['client_id'])) {
                        $CID=$data2['client_id'];
                        }
                        
                        if ($database->rowCount()>=1) {
                            
                        $MESSAGE="SMS has been successfully delivered to $CALLID";  
                        
                            $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='ADL Alert', sent_by='ADL', note_type='SMS Delivered', message=:CALLERID");
                            $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $INSERT->bindParam(':CALLERID',$MESSAGE, PDO::PARAM_STR);
                            $INSERT->execute();
                            
                          $SMS_INSERT = $pdo->prepare("INSERT INTO sms_inbound set sms_inbound_client_id=:CID, sms_inbound_phone=:PHONE, sms_inbound_type='SMS Delivered', sms_inbound_msg=:MSG");
                          $SMS_INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                          $SMS_INSERT->bindParam(':MSG',$MESSAGE, PDO::PARAM_STR);
                          $SMS_INSERT->bindParam(':PHONE',$CALLID, PDO::PARAM_STR);
                          $SMS_INSERT->execute();                            
                            
                        }
                        
                        }
                        
                if($MessageStatus=='undelivered') {

                    $database = new Database(); 
                    
                    $CALLID = preg_replace('~^[0\D]++44|\D++~', '0', $TO);
                    
                    $database->query("SELECT client_id FROM client_details WHERE phone_number =:CALLID");
                    $database->bind(':CALLID', $CALLID);
                    $database->execute();
                    $data2=$database->single();
                    
                    if(isset($data2['client_id'])) {
                        $CID=$data2['client_id'];
                        }
                        
                        if ($database->rowCount()>=1) {
                            
                        $MESSAGE="SMS has failed to be delivered to $CALLID";  
                        
                            $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='ADL Alert', sent_by='ADL', note_type='SMS Failed', message=:CALLERID");
                            $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $INSERT->bindParam(':CALLERID',$MESSAGE, PDO::PARAM_STR);
                            $INSERT->execute();
                            
                            $SMS_INSERT = $pdo->prepare("INSERT INTO sms_inbound set sms_inbound_client_id=:CID, sms_inbound_phone=:PHONE, sms_inbound_type='SMS Failed', sms_inbound_msg=:MSG");
                            $SMS_INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $SMS_INSERT->bindParam(':MSG',$MESSAGE, PDO::PARAM_STR);
                            $SMS_INSERT->bindParam(':PHONE',$CALLID, PDO::PARAM_STR);
                            $SMS_INSERT->execute();
                            
                        }
                        
                        }                        
                        
                        }
                        
                        }
                        
                        }
?>