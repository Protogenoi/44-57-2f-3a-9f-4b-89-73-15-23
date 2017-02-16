<?php
require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
include('../../includes/config.php');

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

$email = $_POST['email'] ;
$recipient = $_POST['recipient'] ;
$message = $_POST['message'] ;
$subject = $_POST['subject'] ;
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

$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
$mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
$mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
$mail->ConfirmReadingTo = 'info@thereviewbureau.com';

$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.123-reg.co.uk"; 
$mail->SMTPAuth   = true;                 
$mail->SMTPSecure = "ssl"; 
$mail->Port       = 465;                
$mail->Username   = "$IDD_123_EMAIL"; 
$mail->Password   = "$IDD_123_PASS";
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

$mail->SetFrom('idd@thereviewbureau.com', 'The Review Bureau');
$mail->AddReplyTo("info@thereviewbureau.com","The Review Bureau Info");
$mail->AddBCC('info@thereviewbureau.com', 'The Review Bureau');
$mail->Subject    = $subject;
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$address = $email;
$mail->AddAddress($address, $recipient);
$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} 

header('Location: ../GenericEmail.php?emailsent&emailto='.$email); die;
?>
