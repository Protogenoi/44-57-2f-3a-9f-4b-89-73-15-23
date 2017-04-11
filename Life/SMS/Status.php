<?php
include('../../includes/adl_features.php');

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
        if($EXECUTE=='1') {
            if(isset($MessageStatus)) {
                if($MessageStatus=='delivered') {
                    
                    include('../../includes/ADL_PDO_CON.php');
                    include('../../classes/database_class.php');
                    
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
                            
                        }
                        
                        }
                        
                if($MessageStatus=='undelivered') {
                    
                    include('../../includes/ADL_PDO_CON.php');
                    include('../../classes/database_class.php');
                    
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
                            
                        }
                        
                        }                        
                        
                        }
                        
                        }
                        
                        }
?>
