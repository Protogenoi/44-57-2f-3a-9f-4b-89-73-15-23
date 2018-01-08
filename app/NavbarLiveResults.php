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
if (in_array($hello_name, $Level_3_Access, true)) { 
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
        AND DATE(client_details.submitted_date) >= CURDATE()
        GROUP by client_details.client_id");
    $KF_UP_stmt->execute();
    
    if ($KF_UP_stmt->rowCount() > 0) {
        
        $UPLOAD_COUNT=0;

     while ($KF_UP_stmtresult = $KF_UP_stmt->fetch(PDO::FETCH_ASSOC)) {
         $UPLOAD_COUNT++;
     }
    }
}

if(!isset($UPLOAD_COUNT)) {
    $UPLOAD_COUNT=0;
}
if(!isset($ACT_CBS['badge'])) {
    $ACT_CBS['badge']=0;
}
if(!isset($navbarresult['badge'])) {
    $navbarresult['badge']=0;
}
if(!isset($navbarresult2['badge'])) {
    $navbarresult2['badge']=0;
}
if(!isset($KFS_stmtresult['badge'])) {
    $KFS_stmtresult['badge']=0;
}
if(!isset($RPY_stmtresult['badge'])) {
    $RPY_stmtresult['badge']=0;
}
if(!isset($RPY_stmtresult2['badge'])) {
    $RPY_stmtresult2['badge']=0;
}
if(!isset($MSG_stmtresult['badge'])) {
    $MSG_stmtresult['badge']=0;
}

$TOTAL_NOTIFICATIONS=$UPLOAD_COUNT+$ACT_CBS['badge']+$navbarresult['badge']+$navbarresult2['badge']+$KFS_stmtresult['badge']+$RPY_stmtresult['badge']+$RPY_stmtresult2['badge']+$MSG_stmtresult['badge'];
?>
            <ul class="nav navbar-nav navbar-right">
                
                    <li class='dropdown'>
                        <a data-toggle='dropdown' class='dropdown-toggle' href='#'><span class="badge alert-info"><i class="fa fa-exclamation"><strong> <?php if(isset($TOTAL_NOTIFICATIONS) && $TOTAL_NOTIFICATIONS > 0 ) { echo $TOTAL_NOTIFICATIONS; } ?></strong></i></span></a>
                        <ul role='menu' class='dropdown-menu'>
                            <?php if (in_array($hello_name, $Level_8_Access, true)) {  if(isset($UPLOAD_COUNT) && $UPLOAD_COUNT > 0 ) { ?>
                            <li><div class="notice notice-info" role="alert" id="HIDELGKEY"><strong><i class="fa fa-file-pdf-o"></i> Uploads:</strong> <a href="/Life/Reports/Uploads.php?SEARCH=Insurer Keyfacts"><?php echo $UPLOAD_COUNT; ?> Keyfacts not uploaded!</a></div></li>
                            <?php } } 
                            if ($ffcallbacks == '1') { 
                                if ($ACT_CBS['badge'] > 0) { ?>
                            <li><div class="notice notice-danger" role="alert" id="HIDELGKEY"><strong><i class="fa fa fa-phone"></i> Callbacks:</strong><a href="/app/calendar/calendar.php"> There are <?php echo $ACT_CBS['badge']; ?> active callbacks!</a></div></li>
                            <?php } } ?>
                            <?php if ($fflife == '1') {
                                if(in_array($hello_name,$Task_Access,true)) {
                                    if ($navbarresult['badge'] > 0) { ?>
                            <li><div class="notice notice-success" role="alert" id="HIDELGKEY"><strong><i class="fa fa-tasks"></i> Tasks:</strong><a href="/addon/Life/Tasks/Tasks.php"> There are <?php echo $navbarresult['badge']; ?> tasks deadlines expiring today!</a></div></li>
                            <?php } 
                            if ($navbarresult2['badge'] > 0) { ?>
                            <li><div class="notice notice-danger" role="alert" id="HIDELGKEY"><strong><i class="fa fa-tasks"></i> Tasks:</strong><a href="/addon/Life/Tasks/Tasks.php"> There are <?php echo $navbarresult2['badge']; ?> tasks which deadlines have expired!</a></div></li>
                                <?php } }
                                if($ffkeyfactsemail=='1') {
                                if (in_array($hello_name, $Level_8_Access, true)) { 
                                    if ($KFS_stmtresult['badge'] >= '1') { ?>
                            <li><div class="notice notice-info" role="alert" id="HIDELGKEY"><strong><i class="fa fa-envelope"></i> Email:</strong><a href="/addon/Life/Reports/Keyfacts.php?SEARCH=NotSent"> <?php echo $KFS_stmtresult['badge']; ?> Closer Keyfacts email's have not been sent!</a></div></li>
                            <?php } } } }
                            if ($ffsms == '1') {
                                if (in_array($hello_name, $Level_3_Access, true)) {
                                    if ($RPY_stmtresult['badge'] >= '1') { ?>
                            <li><div class="notice notice-success" role="alert" id="HIDELGKEY"><strong><i class="fa fa-commenting-o"></i> SMS:</strong><a href="/app/SMS/Report.php?SEARCH_BY=Responses"> There are <?php echo $RPY_stmtresult['badge']; ?> client responses!</a></div></li>
                            <?php }
                            if(isset($RPY_stmtresult2['badge']) && $RPY_stmtresult2['badge'] >= '1') { ?>
                            <li><div class="notice notice-danger" role="alert" id="HIDELGKEY"><strong><i class="fa fa-commenting-o"></i> SMS:</strong><a href="/app/SMS/Report.php?SEARCH_BY=Failed"> <?php echo $RPY_stmtresult2['badge']; ?> messages have failed to be delivered!</a></div></li>
                            <?php } } }
                            if ($MSG_stmtresult['badge'] >= '1') { ?>
                            <li><div class="notice notice-info" role="alert" id="HIDELGKEY"><strong><i class="fa fa-inbox"></i> Messages:</strong><a href="/app/messenger/Main.php"> You have <?php echo $MSG_stmtresult['badge']; ?> private messages!</a></div></li>
                            <?php } ?>
                        </ul>  
                    </li>                
                
                <li><a href="/CRMmain.php?action=log_out"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>

<ul class="nav navbar-nav navbar-right">
    <?php if (in_array($hello_name, $Level_8_Access, true)) {  if(isset($UPLOAD_COUNT) && $UPLOAD_COUNT > 0 ) { ?>
<li><a href="/Life/Reports/Uploads.php?SEARCH=Insurer Keyfacts"> <span class="badge alert-info"> <i class='fa fa-file-pdf-o'></i> <?php echo $UPLOAD_COUNT; ?> </span></a></li>
   
    <?php } } if ($ffcallbacks == '1') {
if ($ACT_CBS['badge'] > 0) { ?>
        <li><a href="/app/calendar/calendar.php">  <span class="badge alert-danger"><i class="fa fa-phone"></i>Active <?php echo $ACT_CBS['badge']; ?></span></a></li> <?php }

        } if ($fflife == '1') {
            if(in_array($hello_name,$Task_Access,true)) {

        if ($navbarresult['badge'] > 0) {
            ?>    <li><a href="/addon/Life/Tasks/Tasks.php"><span class="badge alert-success"><i class="fa fa-tasks"></i> <?php echo $navbarresult['badge']; ?> </span></a></li> <?php }
    if ($navbarresult2['badge'] > 0) {
            ?>    <li><a href="/addon/Life/Tasks/Tasks.php"><span class="badge alert-danger"><i class="fa fa-tasks"></i> <?php echo $navbarresult2['badge']; ?> </span></a></li> <?php
        }
            }
            
        if($ffkeyfactsemail=='1') {
            if (in_array($hello_name, $Level_8_Access, true)) { 
            if ($KFS_stmtresult['badge'] >= '1') {
                ?>
        <li><a href="/addon/Life/Reports/Keyfacts.php?SEARCH=NotSent"> <span class="badge alert-info"> <i class='fa fa-envelope'></i> <?php echo $KFS_stmtresult['badge']; ?> </span></a></li>

                <?php
            }          
        }
        }

        if ($ffsms == '1') {
            if (in_array($hello_name, $Level_8_Access, true)) { 
            if ($RPY_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/app/SMS/Report.php?SEARCH_BY=Responses"> <span class="badge alert-success"> <i class='fa fa-commenting-o'></i> <?php echo $RPY_stmtresult['badge']; ?> </span></a></li>

                <?php
            }
            if ($RPY_stmtresult2['badge'] >= '1') {
                ?>                <li><a href="/app/SMS/Report.php?SEARCH_BY=Failed"> <span class="badge alert-danger"> <i class='fa fa-comment-o'></i> <?php echo $RPY_stmtresult2['badge']; ?> </span> </a></li>

                <?php
            }
        }
        }
        }    
            if ($MSG_stmtresult['badge'] >= '1') {
                ?>
                <li><a href="/app/messenger/Main.php"> <span class="badge alert-success"> <i class='fa fa-inbox'></i> <?php echo $MSG_stmtresult['badge']; ?> </span></a></li>

                <?php } ?>
</ul>