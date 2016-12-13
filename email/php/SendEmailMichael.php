<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once('../../PHPMailer_5.2.0/class.phpmailer.php');

//error_reporting(E_ALL);
//ini_set('display_errors',1);
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
    $uploadOk = 0;
}


//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
//$message = $_POST['message'] ;
$email = $_POST['email'] ;
$recipient = $_POST['recipient'] ;
$message = $_POST['message'] ;
$subject = $_POST['subject'] ;
$sig = "<br>-- \n
";

$body = $message;
$body .= $sig;

$mail             = new PHPMailer();



$mail->IsSMTP(); // telling the class to use SMTP
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.123-reg.co.uk"; // SMTP server
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "$M_123_EMAIL"; // SMTP account username
$mail->Password   = "$M_123_PASS";        // SMTP account password



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

$mail->SetFrom('michael@thereviewbureau.com', 'Michael Owen');

$mail->AddReplyTo("michael@thereviewbureau.com","Michael Owen");
$mail->Subject    = $subject;
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

//$mail->Body    = $sig;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><div class=\"alert alert-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Message sent!
    </div>";
}

header('Location: ../emailinbox.php?emailsent'); die;
    ?>

