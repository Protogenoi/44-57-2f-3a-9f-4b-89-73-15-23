<?php 
require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');
    
    $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
    
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Policy Statuses</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" TYPE="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css">
      <link href="/img/favicon.ico" rel="icon" TYPE="image/x-icon" />
</head>
<body>
    
    <?php

    require_once(__DIR__ . '/../../../includes/navbar.php');
    
    $DATE_FROM= filter_input(INPUT_GET, 'DATE_FROM', FILTER_SANITIZE_SPECIAL_CHARS);
    $DATE_TO= filter_input(INPUT_GET, 'DATE_TO', FILTER_SANITIZE_SPECIAL_CHARS);
    $TYPE= filter_input(INPUT_GET, 'TYPE', FILTER_SANITIZE_SPECIAL_CHARS);

$newDATE_FROM="$DATE_FROM 06:00:00";
$newDATE_TO="$DATE_TO 23:00:00";
    ?>
    
    <div class="container">
  <div class="row">
  <form class="form-vertical">
<fieldset>

<legend>Select a Policy Status and a date range</legend>

  <div class="col-xs-2">
    <select id="TYPE" name="TYPE" class="form-control" required>
        
        
        <?php
        
        if(isset($TYPE)) {
            
                ?>
                <option value="<?php echo "$TYPE"; ?>"><?php echo "$TYPE"; ?></option>
                <?php
        }
                $query = $pdo->prepare("SELECT policystatus from client_policy GROUP BY policystatus");
                $query->execute();
                if ($query->rowCount()>0) {
                    while ($result=$query->fetch(PDO::FETCH_ASSOC)){
              
                ?>
                
                <option value="<?php echo "$result[policystatus]"; ?>"><?php echo "$result[policystatus]"; ?></option>
                    
                    <?php
                    }
                    }
                    
                    ?>
    </select>
  </div>

<div class="col-xs-2">
  <input id="DATE_FROM" name="DATE_FROM" placeholder="Date From" <?php if(isset($DATE_FROM)) { echo "value='$DATE_FROM'"; }?>class="form-control input-md" TYPE="text">
</div>

<div class="col-xs-2">
  <input id="DATE_TO" name="DATE_TO" placeholder="Date To" <?php if(isset($DATE_TO)) { echo "value='$DATE_TO'"; }?> class="form-control input-md" TYPE="text"> 
</div>

<div class="col-xs-2">
    <button name="submit" class="btn btn-success">Submit</button>
    <a href="PolicyStatuses.php" class="btn btn-danger "><span class="glyphicon glyphicon-repeat"></span> Reset</a>
  </div>


</fieldset>
</form>
  </div>

<div class="row">
<table class="table table-hover table-condensed">

<thead>
	<tr>
	<th colspan='9'></th>
	</tr>
	<tr>
	<td>Client</td>
        <td>Policy Number</td>
	<td>Policy Status</td>
	<td>Insurer</td>
	<td>Added</td>
	<td>Updated</td>
        <td>View</td>
	</tr>
	</thead>
        
        <?php

        if(isset($TYPE)) {
            
         $query = $pdo->prepare("SELECT
                                        policy_number, 
                                        client_name, 
                                        client_id, 
                                        policystatus, 
                                        insurer, 
                                        submitted_date, 
                                        date_edited
                                FROM 
                                    client_policy 
                                WHERE 
                                    policystatus=:status 
                                AND 
                                    submitted_date 
                                BETWEEN 
                                    :DATE_FROM 
                                AND 
                                    :DATE_TO");
         $query->bindParam(':status', $TYPE, PDO::PARAM_STR, 12);
         $query->bindParam(':DATE_FROM', $newDATE_FROM, PDO::PARAM_STR, 12);
         $query->bindParam(':DATE_TO', $newDATE_TO, PDO::PARAM_STR, 12);
        
$query->execute();
$count = $query->rowCount();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
	                                    $search=$result['client_id'];
                                       
                                    echo '<tr>';
                                    echo "<td>".$result['client_name']."</td>";
                                    echo "<td>".$result['policy_number']."</td>";
                                    echo "<td>".$result['policystatus']."</td>";
                                    echo "<td>".$result['insurer']."</td>";
                                    echo "<td>".$result['submitted_date']."</td>";
                                    echo "<td>".$result['date_edited']."</td>";
                                    echo "<td><a href='/app/Client.php?search=$search' target='_blank' class='btn btn-info btn-sm'><i class='fa fa-search'></i> </a></td>";
                                    echo "</tr>";
    }
    
    echo "<br><div class=\"notice notice-info\" role=\"alert\"><strong>Info!</strong> <strong>$count</strong> records found for <strong>$TYPE</strong></div>";
} 
        
else {
	echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available (Policy Status)</div>";
}
        }
        
?>
    
    </table>
</div> 
         
        
                    </div>
    </div>
    
        <script TYPE="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script TYPE="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
    <script>
  $(function() {
    $( "#DATE_FROM" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
    $(function() {
    $( "#DATE_TO" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>
</body>
</html>