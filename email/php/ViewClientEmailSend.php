<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../../includes/ADL_PDO_CON.php'); 
    
    $pension= filter_input(INPUT_GET, 'pension', FILTER_SANITIZE_SPECIAL_CHARS);
    $life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
    $legacy= filter_input(INPUT_GET, 'legacy', FILTER_SANITIZE_SPECIAL_CHARS);
    
$message= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);               
$subject= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);                     

    
    $cnquery = $pdo->prepare("select company_name from company_details limit 1");
    $cnquery->execute()or die(print_r($query->errorInfo(), true));
    $companydetailsq=$cnquery->fetch(PDO::FETCH_ASSOC);
    $companynamere=$companydetailsq['company_name'];
        
    if(isset($life)) {
        if($life=='y' ) {
            
            if(isset($companynamere)) {
                
    $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailaccount='account1'");
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
                    
                    $keyfielddata= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);
                    $recipientdata= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
                    $notetypedata= filter_input(INPUT_POST, 'note_type', FILTER_SANITIZE_SPECIAL_CHARS);
                    $messagedata= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
                    
                if($companynamere=="The Review Bureau") {
                        
                    $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:recipient, sent_by=:sentby, note_type=:note, message=:message ");
                    $query->bindParam(':clientid',$keyfielddata, PDO::PARAM_INT);
                    $query->bindParam(':sentby',$hello_name, PDO::PARAM_STR, 100);
                    $query->bindParam(':recipient',$recipientdata, PDO::PARAM_STR, 500);
                    $query->bindParam(':note',$notetypedata, PDO::PARAM_STR, 255);
                    $query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
                    $query->execute();
                    
                    require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
                    
                    $target_dir = "../../uploads/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    
                    if ($_FILES["fileToUpload"]["size"] > 700000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                        
                    }
                    
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" ) {
                        echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
                        $uploadOk = 0;
                        
                    }

$sig = "<br>-- \n
<br>
<br>
<br>
$signat";

$body = html_entity_decode($message);
$body .= $sig;

$mail             = new PHPMailer();
$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; 
$mail->SMTPAuth   = true;                  
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;                   
$mail->Username   = "$SMTP_USER"; 
$mail->Password   = "$SMTP_PASS"; 

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
$mail->Subject    = $subject;
$mail->IsHTML(true); 
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><h1>Message sent!</h1>";
echo "<br><br><a href='GenericEmail.php'>Send Another Email</h1></a>";
}

if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../../Life/ViewClient.php?emailsent&emailto='.$email.'&search='.$keyfielddata); die;
    }
}
    }
    
    if($companynamere=='ADL_CUS') {
                    
                    $query = $pdo->prepare("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                    $query->bindParam(':clientidholder',$keyfielddata, PDO::PARAM_INT);
                    $query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
                    $query->bindParam(':recipientholder',$recipientdata, PDO::PARAM_STR, 500);
                    $query->bindParam(':noteholder',$notetypedata, PDO::PARAM_STR, 255);
                    $query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
                    $query->execute();
                    
                    require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
                    
                    $target_dir = "../../uploads/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    
                    if ($_FILES["fileToUpload"]["size"] > 700000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                        
                    }
                    
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" ) {
                        echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
                        $uploadOk = 0;
                        
                    }
                    
  
$sig = "<br>-- \n
<br>
<br>
<br>

$signat";
$body = html_entity_decode($message);
$body .= $sig;

$mail             = new PHPMailer();
$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; // SMTP server
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;                    // set the SMTP port for the GMAIL server
$mail->Username   = "$SMTP_USER"; // SMTP account username
$mail->Password   = "$SMTP_PASS";  

$mail->AddEmbeddedImage('../../uploads/LoginLogo.jpg', 'logo');


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
$mail->Subject    = $subject;
$mail->IsHTML(true); 
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->AddAddress($email, $recipient);
$mail->Body    = $body;


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><h1>Message sent!</h1>";
echo "<br><br><a href='GenericEmail.php'>Send Another Email</h1></a>";
}

if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../../Life/ViewClient.php?emailsent&emailto='.$email.'&search='.$keyfielddata); die;
    }
}
    }    
    
    
        if($companynamere=='Assura') {
    
    $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailtype=:emailtype");
    $query->bindParam(':emailtype', $keyfactsr, PDO::PARAM_STR);
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
    $signat=$queryr['sig'];
        
$keyfielddata= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);
$recipientdata= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$notetypedata= filter_input(INPUT_POST, 'note_type', FILTER_SANITIZE_SPECIAL_CHARS);
$messagedata= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:recipient, sent_by=:sentby, note_type=:note, message=:message ");
$query->bindParam(':clientid',$keyfielddata, PDO::PARAM_INT);
$query->bindParam(':sentby',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$recipientdata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);
$query->execute();

     
require_once('../../PHPMailer_5.2.0/class.phpmailer.php');

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
    echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
    $uploadOk = 0;
}

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

$body = html_entity_decode($message);
$body .= $sig;

$mail             = new PHPMailer();


$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; // SMTP server
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;                    // set the SMTP port for the GMAIL server
$mail->Username   = "$SMTP_USER"; // SMTP account username
$mail->Password   = "$SMTP_PASS";        // SMTP account password
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

$mail->SetFrom('info@assura-uk.com', 'Assura');

$mail->AddReplyTo("info@assura-uk.com","Assura Info");
$mail->Subject    = $subject;
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 

$mail->AddAddress($email, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><h1>Message sent!</h1>";
echo "<br><br><a href='GenericEmail.php'>Send Another Email</h1></a>";
}

if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../../Life/ViewClient.php?emailsent&search='.$keyfielddata); die;
    }
}
    }
    
    
    
}

    }
}

if(isset($pension)) {
    
    if($pension=='y' ) {

                    $keyfactsr="Customer-facing";
    
    $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailtype=:emailtype");
    $query->bindParam(':emailtype', $keyfactsr, PDO::PARAM_STR);
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
    $signat=$queryr['sig'];

$keyfielddata= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);
$recipientdata= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$notetypedata= filter_input(INPUT_POST, 'note_type', FILTER_SANITIZE_SPECIAL_CHARS);
$messagedata= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO pension_client_note 
set client_id=:clientid, client_name=:recipient, sent_by=:sentby, note_type=:note, message=:message ");

$query->bindParam(':clientid',$keyfielddata, PDO::PARAM_INT);
$query->bindParam(':sentby',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$recipientdata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);

$query->execute();

echo "<p>$keyfielddata $recipientdata $subjectdata $messagedata</p>";

require_once('../../PHPMailer_5.2.0/class.phpmailer.php');


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
    echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
    $uploadOk = 0;
}

$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$message= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$subject= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);

$sig = "<br>-- \n
<br>
<br>
<br>

<p>
<font color='blue'></b>T:</font></b> 01792 917899 <br>
</p>
<br>
<img src='cid:logo' style='width:200px;height:250px'>
</br>
<br>
<p>
Hayden Williams Independent Financial Services Limited is authorised and regulated by the Financial Conduct Authority as a licensed FCA Independent Financial Advisory Service (FCA Registration Number 486350, see www.fsa.gov.uk/register/  for registration details).
</p>
<p>
Registered in England and Wales 04676474. The registered address for Hayden Williams Independent Financial Services Limited is 24a College Street, Ammanford, Dyfed, SA18 3AF. Email: info@hwifs.co.uk Telephone: 01792 917899
</p>
<p>
This e-mail is intended only for the person to whom it is addressed. If an addressing or transmission error has misdirected this e-mail, please notify the sender by replying to this e-mail. If you are not the intended recipient, please delete this e-mail and do not use, disclose, copy, print or rely on the e-mail in any manner. To the extent permitted by law, Hayden Williams Independent Financial Services Ltd does not accept or assume any liability, responsibility or duty of care for any use of or reliance on this e-mail by anyone, other than the intended recipient to the extent agreed in the relevant contract for the matter to which this e-mail relates (if any). 
</p>
<p>
Hayden Williams Independent Financial Services Ltd may monitor outgoing and incoming e-mails and other telecommunications on its e-mail and telecommunications systems. By replying to this e-mail you give your consent to such monitoring. 
</p>";

$body = html_entity_decode($message);
$body .= $sig;

$mail             = new PHPMailer();

    //$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
    //$mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
    //$mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
    //$mail->ConfirmReadingTo = "$emailbccdb";

$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; 
$mail->SMTPAuth   = true;                  
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;                    
$mail->Username   = "$SMTP_USER"; 
$mail->Password   = "$SMTP_PASS";    

$mail->AddEmbeddedImage('../../img/hwifstr.png', 'logo');

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

$mail->AddAddress($email, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
    header('Location: ../../ViewClient.php?emailfailed&search='.$keyfielddata); die;
} else {
  if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../../ViewClient.php?emailsent&search='.$keyfielddata); die;
    }
}
    }
}
}



if(isset($legacy)) {
    
    if($legacy=='y' ) {
        
                    $keyfactsr="Customer-facing";
    
    $query = $pdo->prepare("select email_signatures.sig, email_accounts.email, email_accounts.emailfrom, email_accounts.emailreply, email_accounts.emailbcc, email_accounts.emailsubject, email_accounts.smtp, email_accounts.smtpport, email_accounts.displayname, AES_DECRYPT(email_accounts.password, UNHEX(:key)) AS password from email_accounts LEFT JOIN email_signatures ON email_accounts.id = email_signatures.email_id where email_accounts.emailtype=:emailtype");
    $query->bindParam(':emailtype', $keyfactsr, PDO::PARAM_STR);
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
    $signat=$queryr['sig'];


$keyfielddata= filter_input(INPUT_POST, 'keyfield', FILTER_SANITIZE_NUMBER_INT);
$recipientdata= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$notetypedata= filter_input(INPUT_POST, 'note_type', FILTER_SANITIZE_SPECIAL_CHARS);
$messagedata= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

$query = $pdo->prepare("INSERT INTO legacy_client_note 
set client_id=:clientid, client_name=:recipient, sent_by=:sentby, note_type=:note, message=:message ");

$query->bindParam(':clientid',$keyfielddata, PDO::PARAM_INT);
$query->bindParam(':sentby',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipient',$recipientdata, PDO::PARAM_STR, 500);
$query->bindParam(':note',$notetypedata, PDO::PARAM_STR, 255);
$query->bindParam(':message',$messagedata, PDO::PARAM_STR, 2500);

$query->execute();

echo "<p>$keyfielddata $recipientdata $subjectdata $messagedata</p>";

require_once('../../PHPMailer_5.2.0/class.phpmailer.php');


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
    echo "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
    $uploadOk = 0;
}

$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_POST, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);
$message= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$subject= filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);

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

    //$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
    //$mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
    //$mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
    //$mail->ConfirmReadingTo = 'info@assura-uk.com';

$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "$SMTP_HOST"; 
$mail->SMTPAuth   = true;                  
$mail->SMTPSecure = "ssl"; 
$mail->Port       = $SMTP_PORT;                    
$mail->Username   = "$SMTP_USER"; 
$mail->Password   = "$SMTP_PASS";    

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

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

$mail->AddAddress($email, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><h1>Message sent!</h1>";
echo "<br><br><a href='GenericEmail.php'>Send Another Email</h1></a>";
}

if(isset($fferror)) {
    if($fferror=='0') {
header('Location: ../../Legacy/ViewLegacyClient.php?emailsent&search='.$keyfielddata); die;
    }
}
    }
}
    ?>
