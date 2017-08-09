<?php
$HTTP_PROTOCOL_CHK = ((!empty(filter_input(INPUT_SERVER,'HTTPS', FILTER_SANITIZE_SPECIAL_CHARS)) && filter_input(INPUT_SERVER,'HTTPS', FILTER_SANITIZE_SPECIAL_CHARS) != 'off') ||filter_input(INPUT_SERVER,'SERVER_PORT', FILTER_SANITIZE_NUMBER_INT) == 443) ? "https://" : "http://";
$USER_TRACKING_GRAB_URL = $HTTP_PROTOCOL_CHK . filter_input(INPUT_SERVER,'HTTP_HOST', FILTER_SANITIZE_SPECIAL_CHARS) . filter_input(INPUT_SERVER,'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS);
     
require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

    $SMS_QRY = $pdo->prepare("SELECT twilio_account_sid, AES_DECRYPT(twilio_account_token, UNHEX(:key)) AS twilio_account_token FROM twilio_account");
    $SMS_QRY->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500); 
    $SMS_QRY->execute()or die(print_r($INSERT->errorInfo(), true));
    $SMS_RESULT=$SMS_QRY->fetch(PDO::FETCH_ASSOC);
    
    $SID=$SMS_RESULT['twilio_account_sid'];
    $TOKEN=$SMS_RESULT['twilio_account_token'];

use Twilio\Rest\Client;                
require_once(__DIR__ . '../../twilio-php-master/Twilio/autoload.php');   

function getRealIpAddr()
{
    if (!empty(filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS)))   
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_CLIENT_IP', FILTER_SANITIZE_SPECIAL_CHARS);
    } 
    elseif (!empty(filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS)))
    {
      $ip=filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    else
    { 
      $ip=filter_input(INPUT_SERVER,'REMOTE_ADDR', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    return $ip;
}

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();

if($TRACKED_IP!='81.145.167.66') {
    require_once(__DIR__ . '../../classes/database_class.php');
        $database = new Database();
        $database->beginTransaction();

        $database->query("SELECT user_tracking_user FROM user_tracking WHERE user_tracking_user=:HELLO AND DATE(user_tracking_date)>=CURDATE() AND INET6_NTOA(user_tracking_ip)=:IP");
        $database->bind(':HELLO', $hello_name);
        $database->bind(':IP', $TRACKED_IP);
        $database->execute();
        $row = $database->single();

        $database->endTransaction();

        if ($database->rowCount() <= 0) {    

    $client = new Client($SID, $TOKEN);

$MOB_MSG="ADL $hello_name accessed from IP $TRACKED_IP!";


$client->messages->create(
    "07401434619",
    array(
        'from' => '+441792720471',
        'body' => "$MOB_MSG"
    )
);       

}
    
}

                $USER_TRACKING_QRY = $pdo->prepare("INSERT INTO user_tracking
                    SET
                    user_tracking_id_fk=(SELECT id from users where login=:HELLO), user_tracking_url=:URL, user_tracking_user=:USER, user_tracking_ip=INET6_ATON(:IP)
                    ON DUPLICATE KEY UPDATE
                    user_tracking_url=:URL2,
                    user_tracking_ip=INET6_ATON(:IP2)");
                $USER_TRACKING_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':USER', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':URL', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':URL2', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':IP', $TRACKED_IP, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':IP2', $TRACKED_IP, PDO::PARAM_STR);
                $USER_TRACKING_QRY->execute();
                
                $USER_HISTORY_TRK = $pdo->prepare("INSERT INTO tracking_history
                    SET
                    tracking_history_id_fk=(SELECT id from users where login=:HELLO), tracking_history_url=:URL, tracking_history_user=:USER, tracking_history_ip=INET6_ATON(:IP)");
                $USER_HISTORY_TRK->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_HISTORY_TRK->bindParam(':USER', $hello_name, PDO::PARAM_STR);
                $USER_HISTORY_TRK->bindParam(':URL', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_HISTORY_TRK->bindParam(':IP', $TRACKED_IP, PDO::PARAM_STR);
                $USER_HISTORY_TRK->execute();                

    if($USER_TRACKING=='1') {       
        
                $USER_TRACKING_CHK = $pdo->prepare("SELECT user_tracking_user, user_tracking_url
                    FROM
                    user_tracking
                    WHERE
                    user_tracking_url like :URL AND user_tracking_user!=:HELLO AND DATE(user_tracking_date)=CURDATE()");
                $USER_TRACKING_CHK->bindParam(':URL', $tracking_search, PDO::PARAM_STR);
                $USER_TRACKING_CHK->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_CHK->execute();
                while($USER_TRACKING_RESULT=$USER_TRACKING_CHK->fetch(PDO::FETCH_ASSOC)) {
                    
                if($USER_TRACKING_RESULT['user_tracking_user'] != $hello_name) {    
                ?>
<div class='notice notice-info' role='alert'><strong> <center> <h2><i class="fa fa-user-secret"></i> <?php echo $USER_TRACKING_RESULT['user_tracking_user']; ?> is also viewing this page.</h2></center></strong> </div>
                        
               <?php } }
    }
                
                ?>

