<?php

include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;


require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
include('../../includes/ADL_PDO_CON.php');
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_GET, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$keyfactsr="Key Facts";

        
        $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, email_accounts.password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailtype=:emailtypeholder");
        $query->bindParam(':emailtypeholder', $keyfactsr, PDO::PARAM_STR);
$query->execute()or die(print_r($query->errorInfo(), true));
$queryr=$query->fetch(PDO::FETCH_ASSOC);

        $emailfromdb=$queryr['emailfrom'];
        $emailbccdb=$queryr['emailbcc'];
        $emailreplydb=$queryr['emailreply'];
        $emailsubjectdb=$queryr['emailsubject'];
        $emailsmtpdb=$queryr['smtp'];
        $emailsmtpportdb=$queryr['smtpport'];
        $emaildisplaynamedb=$queryr['displayname'];
        $passworddb=$queryr['password'];
        $emaildb=$queryr['email'];
        $signat=$queryr['sig'];
        
        
$cnquery = $pdo->prepare("select company_name from company_details limit 1");
                            $cnquery->execute()or die(print_r($query->errorInfo(), true));
                            $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
                            
                            $companynamere=$companydetailsq['company_name'];        
        
if($companynamere=='The Review Bureau') {

        
error_reporting(E_ALL);
ini_set('display_errors',1);
//echo '<pre>';
//print_r($_FILES);
//echo '</pre>';  

$target_dir = "../../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check file size
if ($_FILES["fileToUpload"]["size"] > 700000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {
    echo "<div class=\"notice notice-info fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.
    </div>";
    $uploadOk = 0;
}




$message ="<img src='cid:KeyFacts'>";
$sig = "<br>-- \n
<br>
<br>
<br>

<p>
<font color='blue'><b>Customer Service</font></b><br>
<font color='blue'><b>E:</font></b> info@thereviewbureau.com <br>

<font color='blue'></b>T:</font></b> 0845 095 0041 <br>

<font color='blue'></b>F:</font></b> 0845 095 0042 <br>
</p>
<br>
<img src='cid:logo' style='width:200px;height:100px'>
</br>
<br>
----------------------------------------------------------------<br>
<p>
This e-mail is intended only for the person to whom it is addressed. If an addressing or transmission error has misdirected this e-mail, please notify the sender by replying to this e-mail. If you are not the intended recipient, please delete this e-mail and do not use, disclose, copy, print or rely on the e-mail in any manner. To the extent permitted by law, The Review Bureau Ltd does not accept or assume any liability, responsibility or duty of care for any use of or reliance on this e-mail by anyone, other than the intended recipient to the extent agreed in the relevant contract for the matter to which this e-mail relates (if any).
</p>
<p>
The Review Bureau Ltd. Registered in England and Wales with registered number 08519932.  Registered Office: The Post House, Adelaide Street, Swansea, SA1 1SB.  The Review Bureau Ltd may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
----------------------------------------------------------------
<br>Visit our website <a href='http://www.TheReviewBureau.com'>www.TheReviewBureau.com</a>";

$body = $message;
$body .= $sig;

$mail             = new PHPMailer();

	//$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
	//$mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
	//$mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
	//$mail->ConfirmReadingTo = 'info@thereviewbureau.com';

$mail->IsSMTP(); // telling the class to use SMTP
$mail->CharSet = 'UTF-8';
$mail->Host       = "$emailsmtpdb"; // SMTP server
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $emailsmtpportdb;                    // set the SMTP port for the GMAIL server
$mail->Username   = "$emaildb"; // SMTP account username
$mail->Password   = "$passworddb";        // SMTP account password

//$mail->AddEmbeddedImage('img/tick.png', 'tick');
//$mail->AddEmbeddedImage('img/cross.png', 'cross');
//$mail->AddEmbeddedImage('img/Keyfacts.jpg', 'keyfacts');
//$mail->AddEmbeddedImage('img/RBlogo.png', 'logo');
$mail->AddEmbeddedImage('../../img/Key Facts - The Review Bureau.png', 'KeyFacts');
$mail->AddEmbeddedImage('../../img/RBlogo.png', 'logo');

if (isset($_FILES["fileToUpload"]) &&
    $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload"]["tmp_name"],
                         $_FILES["fileToUpload"]["name"]);
}

if (isset($_FILES["fileToUpload2"]) &&
    $_FILES["fileToUpload2"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload2"]["tmp_name"],
                         $_FILES["fileToUpload2"]["name"]);
}

if (isset($_FILES["fileToUpload3"]) &&
    $_FILES["fileToUpload3"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload3"]["tmp_name"],
                         $_FILES["fileToUpload3"]["name"]);
}

if (isset($_FILES["fileToUpload4"]) &&
    $_FILES["fileToUpload4"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload4"]["tmp_name"],
                         $_FILES["fileToUpload4"]["name"]);
}

if (isset($_FILES["fileToUpload5"]) &&
    $_FILES["fileToUpload5"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload5"]["tmp_name"],
                         $_FILES["fileToUpload5"]["name"]);
}

if (isset($_FILES["fileToUpload6"]) &&
    $_FILES["fileToUpload6"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload6"]["tmp_name"],
                         $_FILES["fileToUpload6"]["name"]);
}



$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");

$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
$mail->AddBCC("$emailbccdb", "$emaildisplaynamedb");
$mail->Subject    = "$emailsubjectdb";
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
  header('Location: ../ViewClient.php?emailfailed&search='.$search); die;
  
} else {
    
       $emailaddress= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
   
   $INSERT = $pdo->prepare("INSERT INTO KeyFactsEmails set email_address=:email");
   $INSERT->bindParam(':email', $emailaddress, PDO::PARAM_STR);
   $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
   
   $notetype="Email Sent";
   $message="Closer KeyFacts email sent ($email)";
   $ref= "$recipient";


                $noteq = $pdo->prepare("INSERT into client_note set client_id=:id, note_type=:type, client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':id', $search, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':type', $notetype, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $ref, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));

header('Location: ../ViewClient.php?emailtype=CloserKeyFacts&emailsent&emailto='.$emailaddress.'&search='.$search); die;
  
}

}

if($companynamere=='Assura') {
    
    $target_dir = "../../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ($_FILES["fileToUpload"]["size"] > 700000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {
    echo "<div class=\"notice notice-info fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.
    </div>";
    $uploadOk = 0;
}

$message ="<img src='cid:KeyFacts'>";
$sig = "<br>-- \n
<br>
<br>
<br>

<p>
<font color='blue'><b>Customer Service</font></b><br>
<font color='blue'><b>E:</font></b> info@assura-uk.com <br>

<font color='blue'></b>T:</font></b> 0333 443 2484 <br></p>

<br>
<img src='cid:logo' style='width:200px;height:100px'>
<br>
----------------------------------------------------------------<br>
<p>
This e-mail is intended only for the person to whom it is addressed. If an addressing or transmission error has misdirected this e-mail, please notify the sender by replying to this e-mail. If you are not the intended recipient, please delete this e-mail and do not use, disclose, copy, print or rely on the e-mail in any manner. To the extent permitted by law, Assura does not accept or assume any liability, responsibility or duty of care for any use of or reliance on this e-mail by anyone, other than the intended recipient to the extent agreed in the relevant contract for the matter to which this e-mail relates (if any).
</p>
<p>
Assura is a trading name of CJTD Limited investments. CJTD Investments Limited registered in England and Wales with registered number 08403633. Registered office: Churchill house, 120 Bunns Lane, London, NW7 2AS.
CJTD Investments Limited may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring.
</p>
----------------------------------------------------------------

";

$body = $message;
$body .= $sig;

$mail             = new PHPMailer();


$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$emailsmtpdb";                      
$mail->SMTPAuth   = true;                
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $emailsmtpportdb;                    
$mail->Username   = "$emaildb";
$mail->Password   = "$passworddb";        

$mail->AddEmbeddedImage('../../img/AssuraKeyFacts.png', 'KeyFacts');
$mail->AddEmbeddedImage('../../img/assuralogo.png', 'logo');

if (isset($_FILES["fileToUpload"]) &&
    $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload"]["tmp_name"],
                         $_FILES["fileToUpload"]["name"]);
}

if (isset($_FILES["fileToUpload2"]) &&
    $_FILES["fileToUpload2"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload2"]["tmp_name"],
                         $_FILES["fileToUpload2"]["name"]);
}

if (isset($_FILES["fileToUpload3"]) &&
    $_FILES["fileToUpload3"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload3"]["tmp_name"],
                         $_FILES["fileToUpload3"]["name"]);
}

if (isset($_FILES["fileToUpload4"]) &&
    $_FILES["fileToUpload4"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload4"]["tmp_name"],
                         $_FILES["fileToUpload4"]["name"]);
}

if (isset($_FILES["fileToUpload5"]) &&
    $_FILES["fileToUpload5"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload5"]["tmp_name"],
                         $_FILES["fileToUpload5"]["name"]);
}

if (isset($_FILES["fileToUpload6"]) &&
    $_FILES["fileToUpload6"]["error"] == UPLOAD_ERR_OK) {
    $mail->AddAttachment($_FILES["fileToUpload6"]["tmp_name"],
                         $_FILES["fileToUpload6"]["name"]);
}



$mail->SetFrom("$emailfromdb", "$emaildisplaynamedb");

$mail->AddReplyTo("$emailreplydb","$emaildisplaynamedb");
$mail->AddBCC("$emailbccdb", "$emaildisplaynamedb");
$mail->Subject    = "$emailsubjectdb";
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  
  header('Location: ../ViewClient.php?emailfailed&search='.$search); die;
  
} else {
    
       $emailaddress= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
   
   $INSERT = $pdo->prepare("INSERT INTO KeyFactsEmails set email_address=:email");
   $INSERT->bindParam(':email', $emailaddress, PDO::PARAM_STR);
   $INSERT->execute()or die(print_r($INSERT->errorInfo(), true));
   
   $notetype="Email Sent";
   $message="Closer KeyFacts email sent ($email)";
   $ref= "$recipient";


                $noteq = $pdo->prepare("INSERT into client_note set client_id=:id, note_type=:type, client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':id', $search, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':type', $notetype, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $ref, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));

header('Location: ../ViewClient.php?emailtype=CloserKeyFacts&emailsent&emailto='.$emailaddress.'&search='.$search); die;
    
}


    
    
}

header('Location: ../ViewClient.php?emailfailed&search='.$search); die;
    ?>



