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

require_once(__DIR__ . '/classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/includes/user_tracking.php');

$LOGOUT_ACTION = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
$FEATURE = filter_input(INPUT_GET, 'FEATURE', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($LOGOUT_ACTION) && $LOGOUT_ACTION == "log_out") {
	$page_protect->log_out();
}

require_once(__DIR__ . '/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/includes/adl_features.php');
require_once(__DIR__ . '/includes/Access_Levels.php');
require_once(__DIR__ . '/includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

getRealIpAddr();
$TRACKED_IP= getRealIpAddr();

if(!in_array($hello_name, $ANYTIME_ACCESS,true)) {

if($TRACKED_IP!='81.145.167.66') {
    header('Location: /index.php?TIME=1');
}
}

        require_once(__DIR__ . '/classes/database_class.php');
        require_once(__DIR__ . '/class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->UpdateToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL <=0) {
            
        header('Location: index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }  

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: /Life/Financial_Menu.php');
    die;
}

if (in_array($hello_name, $Agent_Access, true)) {

    header('Location: /Life/Dealsheet.php');
    die;
}

if (in_array($hello_name, $Closer_Access, true)) {

    header('Location: /addon/Trackers/Tracker.php?query=CloserTrackers');
    die;
}    
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <?php require_once(__DIR__ . '/includes/navbar.php');
           
    ?> 
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
    </div>

    <div class="container">


        <?php
        $clientdeleted = filter_input(INPUT_GET, 'clientdeleted', FILTER_SANITIZE_SPECIAL_CHARS);

        if (isset($clientdeleted)) {
            if ($clientdeleted == 'y') {

                print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Client deleted from database</strong></div><br>");
            }
            if ($clientdeleted == 'failed') {

                print("<br><div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error: Client not deleted</strong></div><br>");
            }
        }
        ?>
        <div class="col-xs-12 .col-md-8">

            <div class="row">
                <div class="twelve columns">
                    <ul class="ca-menu">

                        <?php 
                        
                        if (isset($ACCESS_LEVEL)) {
                            if ($ACCESS_LEVEL >= 3) { ?>
                            <li>
                                <a href="/app/AddClient.php">
                                    <span class="ca-icon"><i class="fa fa-user-plus"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Add New<br/> Client</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>

                        <li>
                            <a href="/app/SearchClients.php">
                                <span class="ca-icon"><i class="fa fa-search"></i></span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Search<br/>All Clients</h2>
                                    <h3 class="ca-sub"></h3>
                                </div>
                            </a>
                        </li>

                       <?php if($fflife == '1') {
                                ?>
                                <li>
                                    <a href="Life/Main_Menu.php">
                                        <span class="ca-icon"><i class="fa fa-medkit"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Life<br/> Insurance</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>

                                <?php
                            }
                            if(in_array($hello_name, $QA_Access,true)) { ?>
                            <li>
                                <a href="https://164.39.13.58/ConnexReports/dashboard.php" target="_blank">
                                    <span class="ca-icon"><i class="fa fa-headphones"></i></span>
                                    <div class="ca-content">
                                        <h2 class="ca-main">Connex<br/>Call Recordings</h2>
                                        <h3 class="ca-sub"></h3>
                                    </div>
                                </a>
                            </li>
                            
                                <li>
                                    <a href="/addon/audits/main_menu.php">
                                        <span class="ca-icon"><i class="fa fa-folder"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Call Audits<br/></h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>                            
                            
                        
                        <?php }                             
                      
                       }
                        
                            if ($ffemployee == '1') {
                                if ($ACCESS_LEVEL == 10) { 
                                ?>
                                <li>
                                    <a href="/addon/Staff/Main_Menu.php">
                                        <span class="ca-icon"><i class="fa fa-database"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Employee<br/> Database</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                            if ($ffcompliance == '1') {
                                if (in_array($hello_name, $Level_10_Access, true)) {
                            
                                ?>
                                <li>
                                    <a href="/addon/compliance/dash.php?EXECUTE=1">
                                        <span class="ca-icon"><i class="fa fa-folder-open"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Compliance</h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                            }
                        ?>
                                
 <?php
 
 if ($fftrackers == '1') {
                        if (in_array($hello_name, $Manager_Access, true)) {
                            
                                ?>
                                <li>
                                    <a href="/addon/Trackers/Closers.php?EXECUTE=1">
                                        <span class="ca-icon"><i class="fa fa-bullseye"></i></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Trackers<br/></h2>
                                            <h3 class="ca-sub"></h3>
                                        </div>
                                    </a>
                                </li>
                                <?php
                            }
                        } 
                        
                           }
                        ?>    
                                
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div id="pappoint" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Appointment and callback reminders</h4>
                </div>
                <div class="modal-body">
                    <?php
                    if ($fflife == '1') {

                        $set_time = date("G:i", strtotime('-30 minutes'));
                        $set_time_to = date("G:i", strtotime('+20 minutes'));

                        $query = $pdo->prepare("SELECT client_id, callback_time AS calltimeid, reminder, client_name, notes from scheduled_callbacks WHERE callback_date = CURDATE() AND reminder <= :timeto AND reminder >= :time AND complete='N' and assign =:hello");
                        $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
                        $query->bindParam(':time', $set_time, PDO::PARAM_STR);
                        $query->bindParam(':timeto', $set_time_to, PDO::PARAM_STR);
                        echo "<table class=\"table\">";

                        echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">Call back Reminders</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Reminder</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

                        $query->execute();
                        if ($query->rowCount() >= 1) {
                            ?>
                            <script type="text/javascript">
                                $(window).load(function () {
                                    $('#pappoint').modal('show');
                                });
                            </script> 
                            <?php
                            while ($calllist = $query->fetch(PDO::FETCH_ASSOC)) {
                                $NOTES_MESSAGE = html_entity_decode($calllist['notes']);
                                $client_id = $calllist['client_id'];

                                echo '<tr>';
                                echo "<td>" . $calllist['client_name'] . "</td>";
                                echo "<td>" . $calllist['calltimeid'] . "</td>";
                                echo "<td>" . $calllist['reminder'] . "</td>";
                                echo "<td>$NOTES_MESSAGE</td>";
                                echo "<form method='GET' action='Life/ViewClient.php'> <input type='hidden' value='$client_id' name='search'>";
                                echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
                        }
                        echo "</table>";


                        $query = $pdo->prepare("SELECT client_id, callback_time AS calltimeid, reminder, client_name, notes from scheduled_callbacks WHERE callback_date = CURDATE() AND complete='N' and assign =:hello");
                        $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
                        echo "<table class=\"table\">";

                        echo "  <thead>
        <tr>
        <th><h3><span class=\"label label-primary\">Todays Call backs</span></h3></th>
        </tr>
        <tr>
        <th>Client</th>
        <th>Call back</th>
        <th>Reminder</th>
        <th>Notes</th>
        <th>Options</th>
        </tr>
        </thead>";

                        $query->execute();
                        if ($query->rowCount() >= 1) {

                            while ($calllist = $query->fetch(PDO::FETCH_ASSOC)) {
                                $NOTES_MESSAGE = html_entity_decode($calllist['notes']);
                                $client_id = $calllist['client_id'];

                                echo '<tr>';
                                echo "<td>" . $calllist['client_name'] . "</td>";
                                echo "<td>" . $calllist['calltimeid'] . "</td>";
                                echo "<td>" . $calllist['reminder'] . "</td>";
                                echo "<td>$NOTES_MESSAGE</td>";
                                echo "<form method='GET' action='Life/ViewClient.php'> <input type='hidden' value='$client_id' name='search'>";
                                echo "<td><button type=\"submit\" class=\"btn btn-default btn-xs\"><i class='fa fa-folder-open'></i> </button></td></form>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs for today found</div>";
                        }
                        echo "</table>";
                    }

                    ?> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once(__DIR__ . '/app/Holidays.php');

    if (isset($hello_name)) {

            if ($XMAS == 'December' || $XMAS=='November') {
                $SANTA_TIME = date("H");
                
                ?>
                <audio autoplay>
                    <source src="/app/sounds/<?php echo $XMAS_ARRAY[$RAND_XMAS_ARRAY[0]]; ?>" type="audio/mpeg">
                </audio>  
                <?php
          
            }
            
            if($HALLOWEEN=='31st of October') {  ?>
    <style>
        body {
    background-image: url("https://review.adlcrm.com/img/552086.jpg");
        }
    </style>

                <audio autoplay>
                    <source src="/app/sounds/halloween/<?php echo $RAND_HALLOWEEN_ARRAY; ?>" type="audio/mpeg">
                </audio>    
            <?php } }

    ?>
</body>
</html>