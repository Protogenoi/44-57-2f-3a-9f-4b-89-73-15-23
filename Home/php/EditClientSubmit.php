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
$page_protect->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='0') {       
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    $home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($home)) {
        if($home=='y') {
            include('../../includes/ADL_PDO_CON.php');
            include('../../classes/database_class.php');
            
            $CID= filter_input(INPUT_POST, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
            $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $first= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $last= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
            $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $phone_number= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
            $alt_number= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
            $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
            $first2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
            $last2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
            $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
            $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
            $address1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
            $address2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
            $address3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
            $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
            $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid1= filter_input(INPUT_POST, 'leadid1', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid2= filter_input(INPUT_POST, 'leadid2', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid3= filter_input(INPUT_POST, 'leadid3', FILTER_SANITIZE_SPECIAL_CHARS);
            $callauditid= filter_input(INPUT_POST, 'callauditid', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadauditid= filter_input(INPUT_POST, 'leadauditid', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid12= filter_input(INPUT_POST, 'leadid12', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid22= filter_input(INPUT_POST, 'leadid22', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadid32= filter_input(INPUT_POST, 'leadid32', FILTER_SANITIZE_SPECIAL_CHARS);
            $callauditid2= filter_input(INPUT_POST, 'callauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
            $leadauditid2= filter_input(INPUT_POST, 'leadauditid2', FILTER_SANITIZE_SPECIAL_CHARS);
            $company= filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
            $changereason= filter_input(INPUT_POST, 'changereason', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $correct_dob = date("Y-m-d" , strtotime($dob)); 
            $correct_dob2 = date("Y-m-d" , strtotime($dob2));
            
            $CUR_NAME = $pdo->prepare("SELECT CONCAT(title, ' ', first_name, ' ',last_name) AS orig_name, CONCAT(title2, ' ', first_name2, ' ',last_name2) AS orig_name2 FROM client_details WHERE client_id=:origidholder");
            $CUR_NAME->bindParam(':origidholder',$CID, PDO::PARAM_INT);
            $CUR_NAME->execute(); 
            $origdetails=$CUR_NAME->fetch(PDO::FETCH_ASSOC);
            
            $oname=$origdetails['orig_name'];
            $oname2=$origdetails['orig_name2'];
            
            $database = new Database();
            $database->query("UPDATE client_details set company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:tel, alt_number=:tel2, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, recent_edit=:hello, date_edited=CURRENT_TIMESTAMP, leadid1=:lead, leadid2=:lead2, leadid3=:lead3, callauditid=:closeraudit, leadauditid=:leadaudit, leadid12=:lead4, leadid22=:lead5, leadid32=:lead6, callauditid2=:closeraudit2, leadauditid2=:leadaudit2 WHERE client_id=:id");
            $database->bind(':id', $CID);
            $database->bind(':company', $company);
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':tel',$phone_number);
            $database->bind(':tel2',$alt_number);
            $database->bind(':title2', $title2);
            $database->bind(':first2',$first2);
            $database->bind(':last2',$last2);
            $database->bind(':dob2',$correct_dob2);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$address1);
            $database->bind(':add2',$address2);
            $database->bind(':add3',$address3);
            $database->bind(':town',$town);
            $database->bind(':post',$post);
            $database->bind(':hello',$hello_name);
            $database->bind(':lead',$leadid1);
            $database->bind(':lead2',$leadid2);
            $database->bind(':lead3',$leadid3);
            $database->bind(':closeraudit',$callauditid);
            $database->bind(':leadaudit',$leadauditid);
            $database->bind(':lead4',$leadid12);
            $database->bind(':lead5',$leadid22);
            $database->bind(':lead6',$leadid32);
            $database->bind(':closeraudit2',$callauditid2);
            $database->bind(':leadaudit2',$leadauditid2);
            $database->execute();
            
            $clientnamedata= "CRM Alert";
            $notedata= "Client Details Updated";
            
            $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
            $query->bindParam(':clientidholder',$CID, PDO::PARAM_INT);
            $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
            $query->bindParam(':recipientholder',$clientnamedata, PDO::PARAM_STR, 500);
            $query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
            $query->bindParam(':messageholder',$changereason, PDO::PARAM_STR, 2500);
            $query->execute();
            
            $clientnamedatas=$title ." ". $first ." ". $last;
            $clientnamedatas2=$title2 ." ". $first2 ." ". $last2;
            
            if(isset($changereason)){
                if ($changereason =='Incorrect Client Name') {
                    $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholder WHERE client_name =:orignameholder");
                    $query->bindParam(':recipientholder',$clientnamedatas, PDO::PARAM_STR, 500);
                    $query->bindParam(':orignameholder',$oname, PDO::PARAM_STR, 500);
                    $query->execute(); 
                    
                }
                
                if ($changereason =='Incorrect Client Name 2') {
                    $query = $pdo->prepare("UPDATE client_note set client_name=:recipientholders WHERE client_name =:orignameholders");
                    $query->bindParam(':recipientholders',$clientnamedatas2, PDO::PARAM_STR, 500);
                    $query->bindParam(':orignameholders',$oname2, PDO::PARAM_STR, 500);
                    $query->execute(); 
                    
                }
                
                }
                
                if ($database->rowCount()>=1) {
                    if(isset($fferror)) {
                        if($fferror=='0') {
                            header('Location: /Home/ViewClient.php?clientedited=y&search='.$CID); die;
                            }
                            }
                            
                        }
                        
                        else {  
                            if(isset($fferror)) {
                                if($fferror=='0') {  
                                    header('Location: /Home/ViewClient.php?clientedited=n&search='.$CID); die;
                                    }
                                    
                                }
                                
                                }
                                
                                }
                                
                                }
                                
                                if(isset($fferror)) {
                                    if($fferror=='0') {  
                                        header('Location: ../../CRMmain.php?NoAccess'); die;
                                        }
                                        
                                    }
                                    ?>

