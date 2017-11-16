<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);    
$RECHECK= filter_input(INPUT_GET, 'RECHECK', FILTER_SANITIZE_SPECIAL_CHARS);
$INSURER= filter_input(INPUT_GET, 'INSURER', FILTER_SANITIZE_SPECIAL_CHARS); 

$CHECK= filter_input(INPUT_GET, 'CHECK', FILTER_SANITIZE_SPECIAL_CHARS); 

if(isset($CHECK)) {
    if($CHECK=='1') {
        
        $GET_POLS = $pdo->prepare("SELECT
                                        id, 
                                        policy_number, 
                                        payment_amount 
                                    FROM 
                                        financial_statistics_nomatch");
        $GET_POLS->execute();
        $result=$GET_POLS->fetch(PDO::FETCH_ASSOC); 
        
        if ($GET_POLS->rowCount() >= 1) {   
            
            $POLICY_CHECK=$result['policy_number'];
            $POLICY_AMOUNT=$result['payment_amount'];
            $NO_MATCH_ID=$result['id'];
            
            foreach ($POLICY_CHECK as $CHECK) {
                
                $Icheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $Icheck->bindParam(':polhold', $POLICY_CHECK, PDO::PARAM_STR);
                $Icheck->execute();
                $result=$Icheck->fetch(PDO::FETCH_ASSOC);
                    
                if ($Icheck->rowCount() >= 1) {  
                    
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $REF= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];   
                    
                    $note="Financial Uploaded";
                        
                        if($POLICY_AMOUNT >= 0 ) {
                            
                            $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                    $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $NO_MATCH_ID, PDO::PARAM_INT);
                       $delete->execute();
                       
                }
                
                }
                
                if($POLICY_AMOUNT < 0) {
                    
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':CID', $CID, PDO::PARAM_INT);
                            $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                                
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $NO_MATCH_ID, PDO::PARAM_INT);
                       $delete->execute();
  
                            
                        } 
                        }
                        
                    }
                    
                 header('Location: ../Life/Financials.php?RECHECK=y'); die;   
                }
                header('Location: ../Life/Financials.php?RECHECK=n'); die;
        
}
    
    if(isset($INSURER)) {
    if(isset($RECHECK)) {
        
$datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);  
$dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
$commdate= filter_input(INPUT_GET, 'commdate', FILTER_SANITIZE_SPECIAL_CHARS);   
$finpn= filter_input(INPUT_GET, 'finpolicynumber', FILTER_SANITIZE_SPECIAL_CHARS);
$iddd= filter_input(INPUT_GET, 'iddd', FILTER_SANITIZE_SPECIAL_CHARS);

        include('../includes/ADL_PDO_CON.php');
            
        if($RECHECK=='y') {
            if($INSURER=='LG') {
            
            $paytype= filter_input(INPUT_GET, 'paytype', FILTER_SANITIZE_SPECIAL_CHARS);
            
                
            if($paytype=='I') {
                
                $Icheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                $Icheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                $Icheck->execute();
                $result=$Icheck->fetch(PDO::FETCH_ASSOC);
                    
                if ($Icheck->rowCount() >= 1) {  
                    
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $REF= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];
                        
                    $note="Financial Uploaded";
                    $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                    $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                               header('Location: ../Life/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: ../Life/Financials.php?RECHECK=y'); die;    
                           }
                       }
                           
                    header('Location: ../Financial_Reports.php?RECHECK=y'); die; 
                        
                }
                    
                }
     
                if($paytype=='R') {
                    
                    $Rcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number = :polhold");
                    $Rcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                    $Rcheck->execute();
                    $result=$Rcheck->fetch(PDO::FETCH_ASSOC);
                        
                    if ($Rcheck->rowCount() >= 1) {
                        
                        $CID=$result['client_id'];
                        $PID=$result['id'];
                        $policynumber=$result['policy_number'];
                        $REF= "$policynumber ($PID)";
                        $polstat=$result['policystatus'];
                            
                        $note="Financial Uploaded";
                        $message="COMM (Status changed from $polstat to Live)";
                            
                        $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                        $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                        $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                        $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                        $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                        $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $insert->execute();
                            
                        $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                        $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                        $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                        $update->execute();
                            
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: ../Life/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: ../Life/Financials.php?RECHECK=y'); die;    
                           }
                       }
                           
                        header('Location: ../Financial_Reports.php?RECHECK=y'); die; 
                            
                    }
                        
                    }
                        
                    if($paytype=='X') {
                        
                        $Xcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                        $Xcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                        $Xcheck->execute();
                        $result=$Xcheck->fetch(PDO::FETCH_ASSOC);
                            
                        if ($Xcheck->rowCount() >= 1) {
                            
                            $CID=$result['client_id'];
                            $PID=$result['id'];
                            $policynumber=$result['policy_number'];
                            $REF= "$policynumber ($PID)";
                            $polstat=$result['policystatus'];
                                
                            $note="Financial Uploaded";
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                                
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                           
                       if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: ../Life/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: ../Life/Financials.php?RECHECK=y'); die;    
                           }
                       }
                       
                            header('Location: ../Financial_Reports.php?RECHECK=y'); die; 
                                
                        }
                            
                        }
                        
                                               if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                                                              if(isset($datefrom)) {
                               header('Location: ../Life/Financials.php?RECHECK=n&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: ../Life/Financials.php?RECHECK=n'); die;    
                           }
                       }
                        
                          header('Location: ../Financial_Reports.php?RECHECK=n'); die;  
                        }
                        
                 if($INSURER=='OneFamily' || 'RoyalLondon' || 'Aviva' || 'Vitality') {
                  
            if($AMOUNT>='0') {
                
                $Icheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number =:pol");
                $Icheck->bindParam(':pol', $finpn, PDO::PARAM_STR);
                $Icheck->execute();
                $result=$Icheck->fetch(PDO::FETCH_ASSOC);
                    
                if ($Icheck->rowCount() >= 1) {  
                    
                    $CID=$result['client_id'];
                    $PID=$result['id'];
                    $policynumber=$result['policy_number'];
                    $REF= "$policynumber ($PID)";
                    $polstat=$result['policystatus'];
                        
                    $note="$INSURER Financial Uploaded";
                    $message="COMM (Status changed from $polstat to Live)";
                        
                    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                    $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                    $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $insert->execute();
                        
                    $update = $pdo->prepare("UPDATE client_policy set policystatus='Live', edited=:sent WHERE id=:polid");
                    $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                    $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                    $update->execute();
                        
                       $delete = $pdo->prepare("DELETE FROM financial_statistics_nomatch WHERE policy_number=:pol AND id=:id  LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_STR, 250);
                       $delete->execute();
                       
                                              if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                               header('Location: ../Life/Financials.php?RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;    
                               }
                            header('Location: ../Life/Financials.php?RECHECK=y'); die;    
                           }
                       }
                           
                    header('Location: ../Financial_Reports.php?RECHECK=y'); die; 
                        
                }
                    
                }
                        
                    if($AMOUNT<'0') {
                        
                        $Xcheck = $pdo->prepare("SELECT id, client_id, policy_number, policystatus FROM client_policy where policy_number like :polhold");
                        $Xcheck->bindParam(':polhold', $finpn, PDO::PARAM_STR);
                        $Xcheck->execute();
                        $result=$Xcheck->fetch(PDO::FETCH_ASSOC);
                            
                        if ($Xcheck->rowCount() >= 1) {
                            
                            $CID=$result['client_id'];
                            $PID=$result['id'];
                            $policynumber=$result['policy_number'];
                            $REF= "$policynumber ($PID)";
                            $polstat=$result['policystatus'];
                                
                            $note="$INSURER Financial Uploaded";
                            $message="CLAWBACK (Status changed from $polstat to Clawback)";
                                
                            $insert = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
                            $insert->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                            $insert->bindParam(':ref', $REF, PDO::PARAM_STR, 250);
                            $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
                            $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
                            $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $insert->execute();
                                
                            $update = $pdo->prepare("UPDATE client_policy set policystatus='Clawback', edited=:sent WHERE id=:polid");
                            $update->bindParam(':polid', $PID, PDO::PARAM_INT);
                            $update->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
                            $update->execute();
                            
                       if($INSURER=='OneFamily') {
                       $delete = $pdo->prepare("DELETE FROM wol_nomatch WHERE wol_nomatch_policy=:pol AND wol_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }
                       if($INSURER=='Vitality') {
                       $delete = $pdo->prepare("DELETE FROM vitality_nomatch WHERE vitality_nomatch_policy=:pol AND vitality_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='RoyalLondon') {
                       $delete = $pdo->prepare("DELETE FROM royal_london_nomatch WHERE royal_london_nomatch_policy=:pol AND royal_london_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       if($INSURER=='Aviva') {
                       $delete = $pdo->prepare("DELETE FROM aviva_nomatch WHERE aviva_nomatch_policy=:pol AND aviva_nomatch_id=:id LIMIT 1");
                       $delete->bindParam(':pol', $policynumber, PDO::PARAM_STR, 250);
                       $delete->bindParam(':id', $iddd, PDO::PARAM_INT);
                       $delete->execute();   
                       }     
                       
                                                             

                       if(isset($EXECUTE)) {
                           if($EXECUTE='1') {
                               if(isset($datefrom)) {
                                   header('Location: ../Life/Financials/'.$INSURER.'.php?INSURER='.$INSURER.'&RECHECK=y&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;   
                               }
                               header('Location: ../Life/Financials/'.$INSURER.'.php?RECHECK=y&INSURER='.$INSURER); die;    
                               }
                               }             
                               header('Location: ../Life/Financials/'.$INSURER.'.php?RECHECK=y&INSURER='.$INSURER); die;                                
                        }
                        
                        }
                        
                        if(isset($EXECUTE)) {
                            if($EXECUTE='1') {
                                if(isset($datefrom)) {
                                       header('Location: ../Life/Financials/'.$INSURER.'.php?INSURER='.$INSURER.'RECHECK=n&datefrom='.$datefrom.'&dateto='.$dateto.'&commdate='.$commdate); die;
                                       
                               }
                            header('Location: ../Life/Financials/'.$INSURER.'.php?RECHECK=n&INSURER='.$INSURER); die;    
                           }
                       }
                        
                          header('Location: ../Life/Financials/'.$INSURER.'.php?RECHECK=n&INSURER='.$INSURER); die;                       
                     
                 }       
                            
                        }
    }
}
                        ?>