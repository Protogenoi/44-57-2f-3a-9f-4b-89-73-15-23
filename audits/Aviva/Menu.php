<?php 
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits=='0') {
        
        header('Location: /../../CRMmain.php'); die;
    }
    

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /../../CRMmain.php'); die;

}

$RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
<title>ADL | Aviva Menu</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php require_once(__DIR__ . '/../../includes/navbar.php');
?>
    
    <div class="container">
        <div class="notice notice-default" role="alert"><strong><center><span class="label label-warning"></span> Aviva Audits</center></strong></div>
        
        <?php
        if(isset($RETURN)) {
            $GRADE= filter_input(INPUT_GET, 'GRADE', FILTER_SANITIZE_SPECIAL_CHARS);
            
 switch ($GRADE) {
    case "Red":
        $NOTICE_COLOR="danger";

        break;
    case "Amber":
        $NOTICE_COLOR="warning";
        break;
    case "Green":
        $NOTICE_COLOR="success";
        break;
    default:
        $NOTICE_COLOR="info";
       
}             
            
            if($RETURN=='UPDATED'){
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-edit fa-lg\"></i> Success:</strong> Aviva Audit Updated!</div>";
                echo "<div class=\"notice notice-$NOTICE_COLOR\" role=\"alert\"><strong>Aviva: Audit grade $GRADE</strong></div>";
                
            }
            if($RETURN=='ADDED') {
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check-circle-o\"></i> Success:</strong> Aviva Audit Added!</div>";
                echo "<div class=\"notice notice-$NOTICE_COLOR\" role=\"alert\"><strong>Aviva: Audit grade $GRADE</strong></div>";
                
            }
        }
        ?>
        
        
        <br>
        <center>
            <div class="btn-group">
                <a href="/audits/main_menu.php" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i> Audit Menu</a>
                <a href="Audit.php" class="btn btn-primary"><i class="fa fa-plus"></i> Aviva Audit</a>
                <a href="Search.php" class="btn btn-info "><i class="fa fa-search"></i> Search Audits</a>
            </div>
        </center>
<br>
    
    <?php                
                $query2 = $pdo->prepare("SELECT aviva_audit_policy, aviva_audit_id, aviva_audit_added_date, aviva_audit_closer, aviva_audit_added_by, aviva_audit_grade, aviva_audit_updated_by, aviva_audit_updated_date from aviva_audit where aviva_audit_added_by=:hello and aviva_audit_added_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or aviva_audit_updated_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND aviva_audit_updated_by =:hello ORDER BY aviva_audit_added_date DESC");
                $query2->bindParam(':hello', $hello_name, PDO::PARAM_STR, 12);                
                $query2->execute();
                $i=0;
                if ($query2->rowCount()>0) {
                                    echo "<table align=\"center\" class=\"table\">";
                
                echo "<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
    	<tr>
	<th>ID</th>
	<th>Policy Number</th>
	<th>Submitted</th>
	<th>Closer</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";
                    while ($result=$query2->fetch(PDO::FETCH_ASSOC)){
                        $i++;
                        $AUDIT_ID=$result['aviva_audit_id'];
                        
                        switch( $result['aviva_audit_grade'] ) {
                            case("Red"):
                                $class = 'Red';
                                break;
                            case("Green"):
                                $class = 'Green';
                                break;
                            case("Amber"):
                                $class = 'Amber';
                                break;
                            case("Save"):
                                $class = 'Purple';
                                break;
                            default:
                                }
                                
                                echo '<tr class='.$class.'>';
                                echo "<td>".$result['aviva_audit_id']."</td>";
                                echo "<td>".$result['aviva_audit_policy']."</td>";
                                echo "<td>".$result['aviva_audit_added_date']."</td>";
                                echo "<td>".$result['aviva_audit_closer']."</td>";
                                echo "<td>".$result['aviva_audit_added_by']."</td>";
                                echo "<td>".$result['aviva_audit_grade']."</td>";
                                echo "<td>".$result['aviva_audit_updated_by']."</td>";
                                echo "<td>".$result['aviva_audit_updated_date']."</td>";
   echo "<td><a href='Audit.php?EXECUTE=EDIT&AUDITID=$AUDIT_ID' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span></a></td>";
   echo "<td><a href='View.php?EXECUTE=VIEW&AUDITID=$AUDIT_ID' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span></a></td>";
    echo "</tr>";

	}echo "</table>";
} else {
    echo "<br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Aviva Audits found</div>";
}

?>
    

   
</div>

    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html>
