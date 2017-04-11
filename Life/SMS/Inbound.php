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
    $Body= filter_input(INPUT_POST, 'Body', FILTER_SANITIZE_SPECIAL_CHARS);
    $From= filter_input(INPUT_POST, 'From', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($EXECUTE)) {
        if($EXECUTE=='1') {
            if(isset($Body)) {
      
                    
                    include('../../includes/ADL_PDO_CON.php');
                    include('../../classes/database_class.php');
                    
                    $database = new Database(); 
                    
                    $CALLID = preg_replace('~^[0\D]++44|\D++~', '0', $From);
                    
                    $database->query("SELECT client_id FROM client_details WHERE phone_number =:CALLID");
                    $database->bind(':CALLID', $CALLID);
                    $database->execute();
                    $data2=$database->single();
                    
                    if(isset($data2['client_id'])) {
                        $CID=$data2['client_id'];
                        }
                        
                        if ($database->rowCount()>=1) {
                            
                            $NEW_MESSAGE="Client ($CALLID) SMS Reply: '$Body'";

                        
                            $INSERT = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='ADL Alert', sent_by='ADL', note_type='Client SMS Reply', message=:CALLERID");
                            $INSERT->bindParam(':CID',$CID, PDO::PARAM_INT);
                            $INSERT->bindParam(':CALLERID',$NEW_MESSAGE, PDO::PARAM_STR);
                            $INSERT->execute();
                            
                        }
                        
                        }
                        
                        }
                        
                        }

?>
