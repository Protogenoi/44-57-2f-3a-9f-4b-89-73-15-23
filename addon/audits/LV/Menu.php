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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

?>
<!DOCTYPE html>
<html>
<title>ADL | LV Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<?php require_once(__DIR__ . '/../../../app/Holidays.php'); ?>
</head>
<body>

<?php require_once(__DIR__ . '/../../../includes/navbar.php');   

    $QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $return= filter_input(INPUT_GET, 'return', FILTER_SANITIZE_SPECIAL_CHARS);
?>
    
    <div class="container">
        <div class="notice notice-default" role="alert"><strong><center><span class="label label-warning"></span> LV Audits</center></strong></div>
        
        <?php
        if(isset($return)) {
            if($return=='Edit'){
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-edit fa-lg\"></i> Success:</strong> LV Audit Updated!</div>";
                
            }
            if($return=='Add') {
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> LV Audit Added!</div>";
                
            }
        }
        ?>
        
        
        <br>
        <center>
            <div class="btn-group">
                <a href="/addon/audits/main_menu.php" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i> Audit Menu</a>
                <a href="Audit.php" class="btn btn-primary"><i class="fa fa-plus"></i> LV Audit</a>
                <a href="Search.php" class="btn btn-info "><i class="fa fa-search"></i> Search Audits</a>
            </div>
        </center>
<br>
    
    <?php 
    $CHK_SAVED = $pdo->prepare("select count(lv_audit_id) AS lv_audit_id from lv_audit where lv_audit_auditor ='SAVED' and lv_audit_grade =:hello");
    $CHK_SAVED->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
    $CHK_SAVED->execute();
    if ($CHK_SAVED->rowCount()>0) {
        while ($result=$CHK_SAVED->fetch(PDO::FETCH_ASSOC)){
            $savedcount = $result['lv_audit_id'];
            if ($savedcount >=1){
                echo "<div class=\"notice notice-danger\" role=\"alert\"><strong>You have <span class=\"label label-warning\">$savedcount</span> incomplete audit(s)</strong><button type=\"button\" class=\"btn btn-danger pull-right\" data-toggle=\"modal\" data-target=\"#savedaudits\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Saved Audits</button></div>";
                
            }
            
            }
            
            }
               
                $query = $pdo->prepare("SELECT
                                            lv_audit_ref, 
                                            lv_audit_id, 
                                            lv_audit_added_date, 
                                            lv_audit_closer, 
                                            lv_audit_auditor, 
                                            lv_audit_grade, 
                                            lv_audit_updated_by, 
                                            lv_audit_updated_date 
                                        FROM 
                                            lv_audit 
                                        WHERE 
                                            lv_audit_auditor=:hello
                                        AND 
                                            lv_audit_added_date 
                                        BETWEEN 
                                            DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) 
                                        AND 
                                            DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) 
                                        OR 
                                            lv_audit_updated_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) 
                                        AND 
                                            DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) 
                                        AND 
                                            lv_audit_updated_by =:hello 
                                        ORDER BY 
                                            lv_audit_added_date DESC");
                $query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);                
                $query->execute();
                $i=0;
                if ($query->rowCount()>0) {
                                    echo "<table align=\"center\" class=\"table\">";
                
                echo "<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Plan Number</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                        $i++;
                        $AUDIT_ID=$result['lv_audit_id'];
                        
                        switch( $result['lv_audit_grade'] ) {
                            case("Red"):
                                $class = 'Red';
                                break;
                            case("Green"):
                                $class = 'Green';
                                break;
                            case("Amber"):
                                $class = 'Amber';
                                break;
                            case("Saved"):
                                $class = 'Purple';
                                break;
                            default:
                                }
                                
                                echo '<tr class='.$class.'>';
                                echo "<td>".$result['lv_audit_id']."</td>";
                                echo "<td>".$result['lv_audit_ref']."</td>";
                                echo "<td>".$result['lv_audit_added_date']."</td>";
                                echo "<td>".$result['lv_audit_closer']."</td>";
                                echo "<td>".$result['lv_audit_auditor']."</td>";
                                echo "<td>".$result['lv_audit_grade']."</td>";
                                echo "<td>".$result['lv_audit_updated_by']."</td>";
                                echo "<td>".$result['lv_audit_updated_date']."</td>";
   echo "<td><a href='Edit.php?EXECUTE=EDIT&AUDITID=$AUDIT_ID' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span></a></td>";
   echo "<td><a href='View.php?EXECUTE=VIEW&AUDITID=$AUDIT_ID' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span></a></td>";
    echo "</tr>";

	}echo "</table>";
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No LV Audits found</div>";
}

?>

    
<div id="savedaudits" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Incomplete (saved) audits</h4>
      </div>
      <div class="modal-body">
<?php
$query = $pdo->prepare("SELECT lv_audit_ref, lv_audit_id, lv_audit_added_date, lv_audit_closer, lv_audit_auditor, lv_audit_grade from lv_audit where lv_audit_auditor = :hello and lv_audit_grade = 'Saved' ORDER BY lv_audit_added_date DESC");
$query->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);
echo "<table align=\"center\" class=\"table\">";

echo 
	"<thead>
	<tr>
	<th>ID</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th colspan='3'></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

switch( $result['lv_audit_grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("Saved"):
            $class = 'Purple';
          break;
        default:
 }
	echo '<tr class='.$class.'>';
	echo "<td>".$result['lv_audit_id'] ."</td>";
	echo "<td>".$result['lv_audit_added_date']."</td>";
	echo "<td>".$result['lv_audit_closer']."</td>";
	echo "<td>".$result['lv_audit_auditor']."</td>";
	echo "<td>".$result['lv_audit_grade']."</td>";
	   echo "<td><a href='Edit.php?EXECUTE=EDIT&AUDITID=".$result['lv_audit_id'] ."' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span></a></td>";
   echo "<td><a href='View.php?EXECUTE=VIEW&AUDITID=".$result['lv_audit_id']."' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span></a></td>";
	echo "</tr>";
    }
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No incomplete/saved audits</div>";
}
echo "</table>";

?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
  
</div>
   
</div>

</body>
</html>