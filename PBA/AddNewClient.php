<?php 
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');
require_once(__DIR__ . '../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html lang="en">
<title>Add PBA Client</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>


</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
    
    ?>
    <br>
    <div class="container">
        
        <?php
        
        $Clientadded= filter_input(INPUT_GET, 'Clientadded', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($Clientadded)) {
            if($Clientadded=='1'){
                
                $id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                
                echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Client $id added</strong></div>";
                
            }
            if($Clientadded=='0') {
                
                echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Client NOT added</strong></div>";

            }
        }

        ?>

	  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading"><i class="fa fa-user-plus"></i> Add Client</div>
      <div class="panel-body">

          
          <form class="AddClient" id="AddProduct" action="/php/AddClientSubmit.php?add=1" method="POST" autocomplete="off">
 
        <div class="col-md-4">
            
<h3><span class="label label-info">Client Details (1)</span></h3>
<br>

           <p>
 <div class="form-group">
  <label for="custtype">Product:</label>
  <select class="form-control" name="custype" id="custype" style="width: 170px" required>
                    <option value="PBA">PBA</option>

  </select>
</div>
            </p>

            <p>
<div class="form-group">
  <label for="title">Title:</label>
  <select class="form-control" name="title" id="title" style="width: 170px" required>
 <option value="">Select...</option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>
            </p>

            <p>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="dob">Date of Birth:</label>
                <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" style="width: 170px" name="email">
            </p>


            <br>

        </div>
        <div class="col-md-4">
            <p>
                
<h3><span class="label label-info">Client Details (2)</span></h3>
<br>

            </p>
            <p>
<div class="form-group">
  <label for="title2">Title:</label>
  <select class="form-control" name="title2" id="title2" style="width: 170px">
 <option value="">Select...</option>
                    <option value="Mr">Mr</option>
                    <option value="Dr">Dr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Other">Other</option>
  </select>
</div>
            </p>

            <p>
                <label for="firstname2">First Name:</label>
                <input type="text" id="firstname2" name="firstname2" class="form-control" style="width: 170px">
            </p>
            <p>
                <label for="lastname2">Last Name:</label>
                <input type="text" id="lastname2" name="lastname2" class="form-control" style="width: 170px" >
            </p>
            <p>
                <label for="dob2">Date of Birth:</label>
                <input type="text" id="dob2" name="dob2" class="form-control" style="width: 170px">
            </p>
            <p>
                <label for="email2">Email:</label>
                <input type="email" id="email2" name="email2" class="form-control" style="width: 170px"">
            </p>
            <br>            
        </div>

        <div class="col-md-4">
            <p>
                
<h3><span class="label label-info">Contact Details</span></h3>
<br>
            </p>
            <p>
                <label for="tel">Tel 1:</label>
                <input type="tel" id="tel" name="tel" class="form-control" style="width: 170px" required pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>
            <p>
                <label for="tel2">Tel 2:</label>
                <input type="tel" id="tel2" name="tel2" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>
            
                        <p>
                <label for="tel3">Tel 3:</label>
                <input type="tel" id="tel3" name="tel3" class="form-control" style="width: 170px" pattern=".{11}|.{11,12}" maxlength="12" title="Enter a valid phone number">
            </p>

            <p>
                <label for="add1">Address Line 1:</label>
                <input type="text" id="add1" name="add1" class="form-control" style="width: 170px" required>
            </p>
            <p>
                <label for="add2">Address Line 2:</label>
                <input type="text" id="add2" name="add2" class="form-control" style="width: 170px">
            </p>
            <p>
                <label for="add3">Address Line 3:</label>
                <input type="text" id="add3" name="add3" class="form-control" style="width: 170px"">
            </p>
            <p>
                <label for="town">Post Town:</label>
                <input type="text" id="town" name="town" class="form-control" style="width: 170px">
            </p>
            <p>
                <label for="post_code">Post Code:</label>
                <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" required>
            </p>


</div>
    <br>
    <br>
    <center>
        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Client</button></center>
</form>
          
      </div>
    </div>
          </div>
    </div>
</body>
</html>