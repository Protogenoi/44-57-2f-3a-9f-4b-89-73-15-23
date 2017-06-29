<?php
$HTTP_PROTOCOL_CHK = ((!empty(filter_input(INPUT_SERVER,'HTTPS', FILTER_SANITIZE_SPECIAL_CHARS)) && filter_input(INPUT_SERVER,'HTTPS', FILTER_SANITIZE_SPECIAL_CHARS) != 'off') ||filter_input(INPUT_SERVER,'SERVER_PORT', FILTER_SANITIZE_NUMBER_INT) == 443) ? "https://" : "http://";
$USER_TRACKING_GRAB_URL = $HTTP_PROTOCOL_CHK . filter_input(INPUT_SERVER,'HTTP_HOST', FILTER_SANITIZE_SPECIAL_CHARS) . filter_input(INPUT_SERVER,'REQUEST_URI', FILTER_SANITIZE_SPECIAL_CHARS);
     
require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');


                $USER_TRACKING_QRY = $pdo->prepare("INSERT INTO user_tracking
                    SET
                    user_tracking_id_fk=(SELECT id from users where login=:HELLO), user_tracking_url=:URL, user_tracking_user=:USER
                    ON DUPLICATE KEY UPDATE
                    user_tracking_url=:URL2");
                $USER_TRACKING_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':USER', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':URL', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':URL2', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_TRACKING_QRY->execute();

                
                $USER_TRACKING_CHK = $pdo->prepare("SELECT user_tracking_user, user_tracking_url
                    FROM
                    user_tracking
                    WHERE
                    user_tracking_url=:URL AND user_tracking_user!=:HELLO");
                $USER_TRACKING_CHK->bindParam(':URL', $USER_TRACKING_GRAB_URL, PDO::PARAM_STR);
                $USER_TRACKING_CHK->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_CHK->execute();
                while($USER_TRACKING_RESULT=$USER_TRACKING_CHK->fetch(PDO::FETCH_ASSOC)) {
                    
                if($USER_TRACKING_RESULT['user_tracking_user'] != $hello_name && $USER_TRACKING_GRAB_URL == $USER_TRACKING_RESULT['user_tracking_url']) {    
                ?>
<div class='notice notice-info' role='alert'><strong> <center> <h2><i class="fa fa-user-secret"></i> <?php echo $USER_TRACKING_RESULT['user_tracking_user']; ?> is also viewing this page.</h2></center></strong> </div>
                        
               <?php } }
                
                ?>

