<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');

if($hello_name!='Michael') {
$TIMELOCK = date('H');

if($TIMELOCK>='20' || $TIMELOCK<'08') {
    
                $USER_TRACKING_QRY = $pdo->prepare("INSERT INTO user_tracking
                    SET
                    user_tracking_id_fk=(SELECT id from users where login=:HELLO), user_tracking_url='NAV_Logout', user_tracking_user=:USER
                    ON DUPLICATE KEY UPDATE
                    user_tracking_url='Access_Level_Logout'");
                $USER_TRACKING_QRY->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->bindParam(':USER', $hello_name, PDO::PARAM_STR);
                $USER_TRACKING_QRY->execute();    
   
    header('Location: /../CRMmain.php?action=log_out');
    die;
    
}
}

if ($fflife == '1') {
if(in_array($hello_name,$Task_Access,true)) {
    $NAVdate = date("Y-m-d");
echo "YES";
    $navbar = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline=:date AND assigned =:navbarname and complete ='0'");
    $navbar->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar->execute();
    $navbarresult = $navbar->fetch(PDO::FETCH_ASSOC);

    $navbar2 = $pdo->prepare("select count(deadline) AS badge from Client_Tasks where deadline <:date AND assigned =:navbarname and complete ='0'");
    $navbar2->bindParam(':navbarname', $hello_name, PDO::PARAM_STR, 25);
    $navbar2->bindParam(':date', $NAVdate, PDO::PARAM_STR, 25);
    $navbar2->execute();
    $navbarresult2 = $navbar2->fetch(PDO::FETCH_ASSOC);
    
}

    $set_timea = date("G:i", strtotime('-30 minutes'));
    $set_time_toa = date("G:i", strtotime('+20 minutes'));

    $query = $pdo->prepare("SELECT count(id) AS badge from scheduled_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
    $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $query->bindParam(':time', $set_timea, PDO::PARAM_STR);
    $query->bindParam(':timeto', $set_time_toa, PDO::PARAM_STR);
    $query->execute();
    $ACT_CBS = $query->fetch(PDO::FETCH_ASSOC);
}


if ($ffsms == '1') {
if (in_array($hello_name, $Level_8_Access, true)) { 
    $RPY_stmt = $pdo->prepare("SELECT 
    count(sms_inbound_id) AS badge 
FROM
    sms_inbound
WHERE
    sms_inbound_type = 'Client SMS Reply'");
    $RPY_stmt->execute();
    $RPY_stmtresult = $RPY_stmt->fetch(PDO::FETCH_ASSOC);

    $RPY_stmt2 = $pdo->prepare("SELECT 
    count(sms_inbound_id) AS badge 
FROM
    sms_inbound
WHERE
    sms_inbound_type = 'SMS Failed'");
    $RPY_stmt2->execute();
    $RPY_stmtresult2 = $RPY_stmt2->fetch(PDO::FETCH_ASSOC);
}
}

if($ffkeyfactsemail=='1') {
if (in_array($hello_name, $Level_8_Access, true)) { 
    $KFS_stmt = $pdo->prepare("SELECT 
    count(client_details.email) as badge
FROM
    client_details
WHERE
    DATE(submitted_date) >='2017-08-31'
    AND
    client_details.email !=''
 AND
    client_details.email NOT IN (SELECT 
            keyfactsemail_email
        FROM
            keyfactsemail)");
    $KFS_stmt->execute();
    $KFS_stmtresult = $KFS_stmt->fetch(PDO::FETCH_ASSOC);
}
    
}
if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    
    $MSG_stmt = $pdo->prepare("SELECT 
    count(messenger_id) AS badge 
FROM
    messenger
WHERE
    messenger_to=:HELLO
    AND
    messenger_status='Unread'");
    $MSG_stmt->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
    $MSG_stmt->execute();
    $MSG_stmtresult = $MSG_stmt->fetch(PDO::FETCH_ASSOC);    
    
} else {


    $MSG_stmt = $pdo->prepare("SELECT 
    count(messenger_id) AS badge 
FROM
    messenger
WHERE
    messenger_to=:HELLO
    AND
    messenger_company=:COMPANY
    AND
    messenger_status='Unread'");
    $MSG_stmt->bindParam(':HELLO', $hello_name, PDO::PARAM_STR);
    $MSG_stmt->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $MSG_stmt->execute();
    $MSG_stmtresult = $MSG_stmt->fetch(PDO::FETCH_ASSOC);
}


if (in_array($hello_name, $Level_8_Access, true)) { 
    $KF_UP_stmt = $pdo->prepare("SELECT 
    client_note.note_id
FROM
    client_note
        JOIN
    client_details ON client_note.client_id = client_details.client_id
WHERE
    client_details.client_id NOT IN (SELECT
            client_id
        FROM
            client_note
        WHERE
            note_type like '%keyfacts' )
        AND DATE(client_details.submitted_date) >= '2017-09-07'
        GROUP by client_details.client_id");
    $KF_UP_stmt->execute();
    
    if ($KF_UP_stmt->rowCount() > 0) {
        
        $UPLOAD_COUNT=0;

     while ($KF_UP_stmtresult = $KF_UP_stmt->fetch(PDO::FETCH_ASSOC)) {
         $UPLOAD_COUNT++;
     }
    }
}
?>

<ul class="nav navbar-nav navbar-right">
    <?php if (in_array($hello_name, $Level_8_Access, true)) {  if(isset($UPLOAD_COUNT)) { ?>
<li><a href="/Life/Reports/Uploads.php?SEARCH=Insurer Keyfacts"> <span class="badge alert-info"> <i class='fa fa-file-pdf-o'></i> <?php echo $UPLOAD_COUNT; ?> </span></a></li>
   
    <?php } } if ($ffcallbacks == '1') {
if ($ACT_CBS['badge'] > 0) { ?>
        <li><a href="/calendar/calendar.php">  <span class="badge alert-danger"><i class="fa fa-phone"></i>Active <?php echo $ACT_CBS['badge']; ?></span></a></li> <?php }

        } if ($fflife == '1') {
            if(in_array($hello_name,$Task_Access,true)) {

        if ($navbarresult['badge'] > 0) {
            ?>    <li><a href="/Life/Reports/Tasks.php"><span class="badge alert-success"><i class="fa fa-tasks"></i>  Today <?php echo $navbarresult['badge']; ?> </span></a></li> <?php }
    if ($navbarresult2['badge'] > 0) {
            ?>    <li><a href="/Life/Reports/Tasks.php"><span class="badge alert-danger"><i class="fa fa-tasks"></i>  Expired <?php echo $navbarresult2['badge']; ?> </span></a></li> <?php
        }
            }
            
        if($ffkeyfactsemail=='1') {
            if (in_array($hello_name, $Level_8_Access, true)) { 
            if ($KFS_stmtresult['badge'] >= '1') {
                ?>
        <li><a href="/Life/Reports/Keyfacts.php?SEARCH=NotSent"> <span class="badge alert-info"> <i class='fa fa-envelope'></i> <?php echo $KFS_stmtresult['badge']; ?> </span></a></li>

                <?php
            }          
        }
        }

        if ($ffsms == '1') {
            if (in_array($hello_name, $Level_8_Access, true)) { 
            if ($RPY_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Responses"> <span class="badge alert-success"> <i class='fa fa-commenting-o'></i> <?php echo $RPY_stmtresult['badge']; ?> </span></a></li>

                <?php
            }
            if ($RPY_stmtresult2['badge'] >= '1') {
                ?>                <li><a href="/Life/SMS/Report.php?SEARCH_BY=Failed"> <span class="badge alert-danger"> <i class='fa fa-comment-o'></i> <?php echo $RPY_stmtresult2['badge']; ?> </span> </a></li>

                <?php
            }
        }
        }
        }    
            if ($MSG_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/messenger/Main.php"> <span class="badge alert-success"> <i class='fa fa-inbox'></i> <?php echo $MSG_stmtresult['badge']; ?> </span></a></li>

                <?php
            }

        
 ?>

</ul>