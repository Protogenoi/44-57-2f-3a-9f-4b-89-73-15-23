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

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/adl_features.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 

require_once(__DIR__ . '/../../../resources/lib/PHPMailer_5.2.0/class.phpmailer.php');

        $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailaccount='account3'");
        $query->bindParam(':key', $EN_KEY, PDO::PARAM_STR);
        $query->execute()or die(print_r($query->errorInfo(), true));
        $queryr=$query->fetch(PDO::FETCH_ASSOC);
        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        $emailsubjectdb=$queryr['emailsubject'];
        $SMTP_HOST=$queryr['smtp'];
        $SMTP_PORT=$queryr['smtpport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $SMTP_PASS=$queryr['password'];
        $SMTP_USER=$queryr['email'];
        $signat=  html_entity_decode($queryr['sig']);
        
        $cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            $companynamere=$companydetailsq['company_name'];   
                            
if(isset($hello_name)) {
    
     switch ($hello_name) {
         case "Michael":
             $hello_name_full="Michael Owen";
             break;
         case "Jakob":
             $hello_name_full="Jakob Lloyd";
             break;
         case "leighton":
             $hello_name_full="Leighton Morris";
             break;
         case "Roxy":
             $hello_name_full="Roxanne Studholme";
             break;
         case "Nicola":
             $hello_name_full="Nicola Griffiths";
             break;
         case "carys":
             $hello_name_full="Carys Riley";
             break;
         case "Matt":
             $hello_name_full="Matthew Jones";
             break;
         case "Tina":
             $hello_name_full="Tina Dennis";
             break;
         case "Nick":
             $hello_name_full="Nick Dennis";
             break;
         case "Ryan":
             $hello_name_full="Ryan Lloyd";
             break;         
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }                             
                            
if(isset($companynamere))  {       

$CID= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$policy= filter_input(INPUT_GET, 'policy', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_GET, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);

if($companynamere=='Bluestone Protect') {

$subject = "Bluestone Protect - Policy Number" ;
$sig = "<br>-- \n
<br>
<br>
<br>
$signat";

$body = "<p>Dear $recipient,</p>
          <p>           
Following our recent phone conversation I have resent the 'My Account' email so you can create your personal online account with Legal and General. 
In order to do this you'll need the policy number which is: <strong>$policy</strong>. </p>

          <p>
Once this has been completed you'll be able to access all the policy information, terms and conditions as well as the 'Check Your Details' form. 
Please could you complete this section at your earliest convenience.
          </p>
          <p>If you require any further information please call our customer care team on 0330 010 0707. Office hours are between Monday to Friday 10:00 - 18:30.</p>

          Kind regards,<br>
$hello_name_full
          </p>";

}

if(isset($COMPANY_ENTITY) && $COMPANY_ENTITY == 'First Priority Group') {
$subject = "$COMPANY_ENTITY - Policy Number" ;
$sig = "<br>-- \n
<br>
<br>
<br>
$signat";

$body = "<p>Dear $recipient,</p>
          <p>           
Following our recent phone conversation I have resent the 'My Account' email so you can create your personal online account with Legal and General. 
In order to do this you'll need the policy number which is: <strong>$policy</strong>. </p>

          <p>
Once this has been completed you'll be able to access all the policy information, terms and conditions as well as the 'Check Your Details' form. 
Please could you complete this section at your earliest convenience.
          </p>
          <p>If you require any further information please call our customer care team on 03300 100 035. Office hours are between Monday to Friday 10:00 - 18:30.</p>

          Kind regards,<br>
$hello_name_full
          </p>";    
}
    
$body .= $sig;

$mail             = new PHPMailer();
$mail->ConfirmReadingTo = "$emailbccdb";
$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; 
$mail->SMTPAuth   = true; 
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;
$mail->Username   = "$SMTP_USER"; 
$mail->Password   = "$SMTP_PASS";
$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");
$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
$mail->Subject    = $subject;
$mail->IsHTML(true); 
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;

   $message="Email policy number for My Account failed ($email)!";
  
                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Failed', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));  
                
  header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=0&CLIENT_EMAIL=Send policy number&EMAIL_SENT_TO='.$email); die;    
  
} else {

$message="Policy Number $policy for My Account Details sent ($email)";

                $noteq = $pdo->prepare("INSERT into client_note set client_id=:CID, note_type='Email Sent', client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':CID', $CID, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $recipient, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));
                
header('Location: /../../../../app/Client.php?search='.$CID.'&EMAIL_SENT=1&CLIENT_EMAIL=Send policy number&EMAIL_SENT_TO='.$email); die;

}
}
?>