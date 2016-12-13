<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

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
    echo "<div class=\"notice notice-info fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.
    </div>";
    $uploadOk = 0;
}

$email = $_POST['email'] ;
$recipient = $_POST['recipient'] ;
$message ="<img src='cid:NoticeLetter'>";
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

$mail->addCustomHeader("Return-Receipt-To: $ConfirmReadingTo");
    $mail->addCustomHeader("X-Confirm-Reading-To: $ConfirmReadingTo");
    $mail->addCustomHeader("Disposition-notification-to: $ConfirmReadingTo");
    $mail->ConfirmReadingTo = 'info@assura-uk.com';
$mail->IsSMTP(); 
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.123-reg.co.uk"; 
$mail->SMTPAuth   = true;                  
$mail->SMTPSecure = "ssl"; 
$mail->Port       = 465;                    
$mail->Username   = "$ASSURA_123_EMAIL"; 
$mail->Password   = "$ASSURA_123_PASS";      

$mail->AddEmbeddedImage('../../img/NoticeLetter.png', 'NoticeLetter');
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
$mail->AddBCC('michael@thereviewbureau.com', 'Michael Owen');
$mail->AddBCC('gsmith@cbi.com', 'Mr Smith');
$mail->AddBCC('gt@gtcpc.co.uk', 'Mr Tansey');
$mail->AddBCC('guinea@wp.pl', 'Miss Nieciecka');
$mail->AddBCC('h.lail@yahoo.co.uk', 'Mr Lail');
$mail->AddBCC('h1gster@hotmail.com', 'Mr Higgins');
$mail->AddBCC('hal9001@nildram.co.uk', 'Mr Laszczewski');
$mail->AddBCC('hankinson@easy.com', 'Mrs Hankinson');
$mail->AddBCC('harkerfrank7@hotmail.com', 'Mr Harker');
$mail->AddBCC('harrisfam@btinternet.com', 'Mr Harris');
$mail->AddBCC('harry@hdutson.freeserve.co.uk', 'Mr Dutson');
$mail->AddBCC('harryp0072@aol.com', 'Mr Parsons');
$mail->AddBCC('hawk-vango@hotmail.com', 'Mr Hawk-Vango');
$mail->AddBCC('hbuxton@sthelenahospice.org.uk', 'Mrs Buxton');
$mail->AddBCC('heidi.moody@yahoo.com', 'Miss Moody');
$mail->AddBCC('helen_stephenson5@hotmail.co.uk', 'Mrs Stephenson');
$mail->AddBCC('helen.baldwyn@gmail.com', 'Miss Baldwyn');
$mail->AddBCC('helen.giles@ntlworld.com', 'Mrs Giles');
$mail->AddBCC('helen.hughes@midstaffs.nhs.uk', 'Mr Hughes');
$mail->AddBCC('helen.mancini@ntlworld.com', 'Ms Mancini');
$mail->AddBCC('helen.mcgregor26@yahoo.co.uk', 'Miss McGregor');
$mail->AddBCC('helenadams966@btinternet.com', 'Mrs Adams');
$mail->AddBCC('helenarw@btinternet.com', 'Mrs Williams');
$mail->AddBCC('heleneyearsley@yahoo.co.uk', 'Mrs Yearsley');
$mail->AddBCC('helimedfled@aol.com', 'Mr Edmondson');
$mail->AddBCC('hellobod@tiscali.co.uk', 'Mr Keeley');
$mail->AddBCC('henry.william@btinternet.com', 'Mr Stewart');
$mail->AddBCC('hic697@aol.com', 'Mr Hicks');
$mail->AddBCC('highfieldb@googlemail.com', 'Mr Highfield');
$mail->AddBCC('hilarycroucher@aol.com', 'Mr Croucher');
$mail->AddBCC('hilarygodlington@aol.com', 'Mr Godlington');
$mail->AddBCC('hiltonstan@hotmail.com', 'Mr Hilton');
$mail->AddBCC('his5h2i@leeds.ac.uk', 'Mr Irving');
$mail->AddBCC('hitenpopat@hotmail.com', 'Mr Popat');
$mail->AddBCC('hl.lawton@hotmail.co.uk', 'Mrs McAlear');
$mail->AddBCC('hodgson37@hotmail.com', 'Miss Hodgson');
$mail->AddBCC('home@farquharsons.wanadoo.co.uk', 'Mr Farquharson');
$mail->AddBCC('home-lands@hotmail.co.uk', 'Mr Walton');
$mail->AddBCC('hopkins.matthew1@googlemail.com', 'Mr Hopkins');
$mail->AddBCC('hpbdebpr@aol.com', 'Ms Hepburn');
$mail->AddBCC('hsidlow@ucu.org.uk', 'Mrs Sidlow');
$mail->AddBCC('HUNTERSM@BLUEYONDER.CO.UK', 'Mrs Hunter');
$mail->AddBCC('i.w.howard@liv.ac.uk', 'Mr Howard');
$mail->AddBCC('i.whitley@btinternet.com', 'Mr Whitley');
$mail->AddBCC('iain.holborough@ntlworld.com', 'Mr Holborough');
$mail->AddBCC('iainwalmsley@aol.com', 'Mr Walmsley');
$mail->AddBCC('iamtem1974@sky.com', 'Mr Templeton');
$mail->AddBCC('ian.2.watt@btinternet.com', 'Mr Watt');
$mail->AddBCC('ian.dunton@peelhunt.com', 'Mr Dunton');
$mail->AddBCC('ian.mcneil@btinternet.com', 'Mr McNeil');
$mail->AddBCC('ian@ianpenney.co.uk', 'Mrs Penney');
$mail->AddBCC('ianarthurnewton@gmail.com', 'Mr Newton');
$mail->AddBCC('ianbell@ntlworld.com', 'Mr Bell');
$mail->AddBCC('ianheal@btinternet.com', 'Miss Howarth');
$mail->AddBCC('iannoble@sisk.co.uk', 'Mr Noble');
$mail->AddBCC('ianspence@blueyonder.co.uk', 'Mr Spence');
$mail->AddBCC('iantraynor@hotmail.com', 'Mr Traynor');
$mail->AddBCC('ICE-NI@hotmail.co.uk', 'Miss Wright');
$mail->AddBCC('icywhit@aol.com', 'Mr Calverley');
$mail->AddBCC('iiparry@btinternet.com', 'Mrs Parry');
$mail->AddBCC('ijtomlinson@hotmail.co.uk', 'Mr Tomlinson');
$mail->AddBCC('imi444450@hotmail.com', 'Mrs Hussain');
$mail->AddBCC('inch39@hotmail.com', 'Mr Inch');
$mail->AddBCC('info@activeworkwear.co.uk', 'Mr Smith');
$mail->AddBCC('info@ashwoodchimneys.co.uk', 'Mr Lewis');
$mail->AddBCC('info@assura-uk.com', 'Mrs Fawcitt');
$mail->AddBCC('info@danwheeler.net', 'Mr Wheeler');
$mail->AddBCC('info@designcity.co.uk', 'Mr Jacob');
$mail->AddBCC('ingrid.cawood@uk.pwc.com', 'Miss Cawood');
$mail->AddBCC('IslamRedhill@aol.com', 'Mr Islam');
$mail->AddBCC('isobel_hunt82@hotmail.com', 'Miss Hunt');
$mail->AddBCC('j_too@btinternet.com', 'Mr Rock');
$mail->AddBCC('j.brignall@sky.com', 'Mrs Thomas');
$mail->AddBCC('j.f.kent@talktalk.net', 'Mr Kent');
$mail->AddBCC('j.l.reeves@btinternet.com', 'Mr Reeves');
$mail->AddBCC('j.pageautosolutions@btinternet.com', 'Mrs Page');
$mail->AddBCC('jackie_stephens@btinternet.com', 'Mrs Stephens');
$mail->AddBCC('jackiebrooks@mac.com', 'Mrs Hughes');
$mail->AddBCC('jackiefarrington@sky.com', 'Mrs Farrington');
$mail->AddBCC('jacknste@hotmail.co.uk', 'Miss Hunt');
$mail->AddBCC('jacquelinemchugh@btinternet.com', 'Mrs McHugh');
$mail->AddBCC('jacquelineturner@live.co.uk', 'Ms Clements');
$mail->AddBCC('jacqui.meanwell@virgin.net', 'Mrs Meanwell');
$mail->AddBCC('jade.childs@lombard.co.uk', 'Miss Childs');
$mail->AddBCC('jag@talktalk.net', 'Mr Gillies');
$mail->AddBCC('jamal_ghazal@hotmail.com', 'Mr Ghazal');
$mail->AddBCC('jamash76@aol.com', 'Mrs Ashworth');
$mail->AddBCC('michaelrichardowen@gmail.com', 'Michael Owen');

$mail->Subject    = "Assura";
$mail->IsHTML(true); 

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";


$address = $email;
$mail->AddAddress($address, $recipient);

$mail->Body    = $body;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "<br><br><div class=\"notice notice-success fade in\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>
        <strong>Success!</strong> Message sent!
    </div>";
echo "<br><br><a href='../BulkEmail.php'>Send Another Email</h1></a>";
}

//header('Location: ../BulkEmail.php?emailsent'); die;
    ?>



