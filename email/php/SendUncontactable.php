<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

    include('../../includes/Access_Levels.php');

        if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../../CRMmain.php?AccessDenied'); die;

}


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
         case "Rhibayliss":
             $hello_name_full="Rhiannon Bayliss";
             break;
         case "Amelia":
             $hello_name_full="Amelia Pike";
             break;
         case "Abbiek":
             $hello_name_full="Abbie Kenyon";
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
         case "Amy":
             $hello_name_full="Amy Clayfield";
             break;
        case "Georgia":
             $hello_name_full="Georgia Davies";
             break;
         case "Mike":
             $hello_name_full="Michael Lloyd";
             break;
         default:
             $hello_name_full=$hello_name;
             
     }
     
     }

require_once('../../PHPMailer_5.2.0/class.phpmailer.php');
include('../../includes/config.php');

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$policy= filter_input(INPUT_GET, 'policy', FILTER_SANITIZE_SPECIAL_CHARS);
$email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$recipient= filter_input(INPUT_GET, 'recipient', FILTER_SANITIZE_SPECIAL_CHARS);

$subject = "The Review Bureau - Direct Debit" ;
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

$body = "<p>Dear $recipient,</p>
          <p>           
There is an issue with your Legal and General direct debit <strong>$policy</strong>. </p>

          <p>
We have tried contacting you on numerous occasions but have been unsuccessful, It is very important we speak to you.
          </p>
          <p>Please contact us on 0845 095 0041 or email us back with a preferred contact time and number for us to call you. Office hours are between Monday to Friday 10:00 - 18:30.</p>
          Many thanks,<br>
$hello_name_full<br>The Review Bureau
          </p>";
$body .= $sig;

$mail             = new PHPMailer();

$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
    $mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
    $mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
    $mail->ConfirmReadingTo = 'info@thereviewbureau.com';

$mail->IsSMTP(); // telling the class to use SMTP
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.123-reg.co.uk"; // SMTP server
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Port       = 465;                    // set the SMTP port for the GMAIL server
$mail->Username   = "$IDD_123_EMAIL"; // SMTP account username
$mail->Password   = "$IDD_123_PASS";        // SMTP account password


$mail->AddEmbeddedImage('../../img/RBlogo.png', 'logo');

$mail->SetFrom('idd@thereviewbureau.com', 'The Review Bureau');
$mail->AddReplyTo("info@thereviewbureau.com","The Review Bureau Info");
$mail->Subject    = $subject;
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$address = $email;
$mail->AddAddress($address, $recipient);
$mail->Body    = $body;


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    
    $notetype="Email Sent";
$message="Uncontactable email sent ($email)";
$ref= "$recipient";


                $noteq = $pdo->prepare("INSERT into client_note set client_id=:id, note_type=:type, client_name=:ref, message=:message, sent_by=:sent");
                $noteq->bindParam(':id', $search, PDO::PARAM_STR);
                $noteq->bindParam(':sent', $hello_name, PDO::PARAM_STR);
                $noteq->bindParam(':type', $notetype, PDO::PARAM_STR);
                $noteq->bindParam(':message', $message, PDO::PARAM_STR);
                $noteq->bindParam(':ref', $ref, PDO::PARAM_STR);
                $noteq->execute()or die(print_r($noteq->errorInfo(), true));
    
    
  header('Location: ../../Life/ViewClient.php?emailsent&search='.$search.'&emailto='.$email); die;

}

    ?>
