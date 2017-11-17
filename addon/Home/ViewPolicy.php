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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
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
    
        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
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
<title>ADL | View Home Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php 
    require_once(__DIR__ . '/../../includes/navbar.php');

$PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("SELECT client_id, id, client_name, sale_date, policy_number, premium, type, insurer, added_date, commission, status, added_by, updated_by, updated_date, closer, lead, cover  FROM home_policy WHERE id=:PID AND client_id=:CID");
$query->bindParam(':PID', $PID, PDO::PARAM_INT);
$query->bindParam(':CID', $CID, PDO::PARAM_INT);
$query->execute();
$data2=$query->fetch(PDO::FETCH_ASSOC);

?>
    <div class="container">
        <div class="policyview">
            <div class="notice notice-info fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Note!</strong> You are now viewing <?php echo $data2['client_name']?>'s policy.
            </div>
        </div>
        
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">View Policy</div>
                <div class="panel-body">
                    <div class="column-right">


<form class="AddClient">
             <p>
<label for="created">Added By</label>
<input type="text" value="<?php echo $data2["added_by"];?>" class="form-control" readonly style="width: 200px">
</p>
<p>
<label for="created">Date Added</label>
<input type="text" value="<?php echo $data2["added_date"];?>" class="form-control" readonly style="width: 200px">
</p> 
<p>
<label for="created">Edited By</label>
<input type="text" value="<?php if (!empty($data2["updated_date"] && $data2["added_date"]!=$data2["updated_date"])) { echo $data2["updated_by"]; }?>" class="form-control" readonly style="width: 200px">
</p>   
<p>
<label for="created">Date Edited</label>
<input type="text" value="<?php if($data2["added_date"]!=$data2["updated_date"]) { echo $data2["updated_date"]; } ?>" class="form-control" readonly style="width: 200px">
</p>   
    <a href="ViewClient.php?CID=<?php echo $CID?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>

</form>                  
                    </div>
                    
                    <form class="AddClient" id="VIEWPOL" name="VIEWPOL">
                        <div class="column-left">

<p>
<label for="client_name">Policy Holder</label>
<input type="text" id="client_name" name="client_name" value="<?php echo $data2['client_name']?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="sale_date">Sale Date:</label>
<input type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="policy_number">Policy Number</label>
<input type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="type">Type</label>
<input type="text" value="<?php echo $data2["type"]; ?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="insurer">Insurer</label>
<input type="text" value="<?php echo $data2["insurer"]; ?>" class="form-control" readonly style="width: 200px">
</p>


</div>
                        <div class="column-center">
<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2['premium']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2['commission']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="cover">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2['cover']; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="cover" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>


<p>
<label for="PolicyStatus">Policy Status</label>
  <input type="text" value="<?php echo $data2['status']; ?>" class="form-control" readonly style="width: 200px">
</select>
</p>

<p>
<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' value="<?php echo $data2["closer"]; ?>" class="form-control" readonly style="width: 200px">
</p>

<p>
<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' value="<?php echo $data2["lead"]; ?>" class="form-control" readonly style="width: 200px">
</p>

</form>
</div>

</div>
</div>
</div>

 </div>
                        </div>

                </div>
            </div>

        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 


</body>
</html>
