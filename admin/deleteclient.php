<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
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

$life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
$home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Delete Client</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="/datatables/js/bpop.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	.warningalert{
		margin: 20px;
	}
</style>
<link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
<script src="/js/jquery-2.1.4.min.js"></script>
<script src="/js/sweet-alert.min.js"></script>
</head>
<body>
    
    <?php include('../includes/navbar.php');

    
        if(isset($home)) {
            $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare("SELECT leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3,  leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id =:CID AND company='TRB Home Insurance'");
$query->bindParam(':CID', $CID, PDO::PARAM_INT);
$query->execute();
$data2=$query->fetch(PDO::FETCH_ASSOC);

$auditid = $data2['callauditid'];
?>

<div id="tab1" class="tab active">

<div class="container">

<div class="warningalert">
    <div class="notice notice-danger fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are about to permanently delete this client(s) from the database.
    </div>
    
    <div class="panel panel-danger">
      <div class="panel-heading">Delete client and ALL related data</div>
      <div class="panel-body">
<form class="AddClient">

<div class="col-md-4">
<h3>Client Details (1)</h3>
<br>

<p>
<label for="FullName">Name:</label>
<input type="text" id="FullName" name="FullName" value="<?php echo $data2['title']?> <?php echo $data2['first_name']?> <?php echo $data2['last_name']?>" disabled>
</p>

<p>
<label for="dob">Date of Birth:</label>
<input type="text" id="dob" name="dob" value="<?php echo $data2['dob']?>" disabled>
</p>

<p>
<label for="email">Email:</label>
<input type="email" id="email" name="email" value="<?php echo $data2['email']?>" disabled>																			
</p>

<p>
<label for="callauditid">Closer Audit</a></label>
<input type="text" id="callauditid" name="callauditid" value="<?php echo $data2['callauditid']?>" disabled>
</p>

<br>
<br>
<br>
<br>
<br>
<br>
</div>

<div class="col-md-4">

<h3>Client Details (2)</h3>
<br>

<p>
<label for="FullName2">Name:</label>
<input type="text" id="FullName2" name="FullName2" value="<?php echo $data2['title2']?> <?php echo $data2['first_name2']?> <?php echo $data2['last_name2']?>" disabled>
</p>

<p>
<label for="dob2">Date of Birth:</label>
<input type="text" id="dob2" name="dob2" value="<?php echo $data2['dob2']?>" disabled>
</p>

<p>
<label for="email2">Email:</label>
<input type="email2" id="email2" name="email2" value="<?php echo $data2['email2']?>" disabled>
</p>

<p>
<label for="callauditid2">Closer Audit</a></label>
<input type="text" id="callauditid2" name="callauditid2" value="<?php echo $data2['callauditid2']?>" disabled>
</p>

</div>

<div class="col-md-4">

<h3>Contact Details</h3>
<br>

<p>
<label for="phone_number">Contact Number:</label>
<input type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number']?>" disabled>
</p>


<p>
<label for="alt_number">Alt Number:</label>
<input type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['alt_number']?>" disabled>
</p>

<p>
<label for="address1">Address Line 1:</label>
<input type="text" id="address1" name="address1" value="<?php echo $data2['address1']?>" disabled>
</p>

<p>
<label for="address2">Address Line 2:</label>
<input type="text" id="address2" name="address2" value="<?php echo $data2['address2']?>" disabled>
</p>

<p>
<label for="town">Town:</label>
<input type="text" id="town" name="town" value="<?php echo $data2['town']?>" disabled>
</p>

<p>
<label for="post_code">Post Code:</label>
<input type="text" id="post_code" name="post_code" value="<?php echo $data2['post_code']?>" disabled>
</p>

</form>

<form id="from1" class="AddClient" enctype="multipart/form-data" method="POST" action="/php/deleteclientsubmit.php?home&CID=<?php echo $CID; ?>">
<br>
<button class="btn btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Client</button>
</form>

 <script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete client?",
                text: "You will not be able to recover any deleted data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Complete!',
                        text: 'Client details deleted!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No Changes have been submitted", "error");
                }
            });
        });

    </script>

<br>
<br>

    <?php }
    
    if(isset($life)) {

$query = $pdo->prepare("SELECT leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3,  leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id = :searchplaceholder");
$query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
$query->execute();
$data2=$query->fetch(PDO::FETCH_ASSOC);
  
?>

<div id="tab1" class="tab active">

<div class="container">

<div class="warningalert">
    <div class="notice notice-danger fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are about to permanently delete this client(s) from the database.
    </div>
    
    <div class="panel panel-danger">
      <div class="panel-heading">Delete client and ALL related data</div>
      <div class="panel-body">
<form class="AddClient">

<div class="col-md-4">
<h3>Client Details (1)</h3>
<br>

<p>
<label for="FullName">Name:</label>
<input type="text" id="FullName" name="FullName" value="<?php echo $data2['title']?> <?php echo $data2['first_name']?> <?php echo $data2['last_name']?>" disabled>
</p>

<p>
<input type="hidden" id="title" name="title" value="<?php echo $data2['title']?>" disabled>
</p>

<p>
<input type="hidden" id="first_name" name="first_name" value="<?php echo $data2['first_name']?>" disabled>
</p>


<p>
<input type="hidden" id="last_name" name="last_name" value="<?php echo $data2['last_name']?>" disabled>
</p>


<p>
<label for="dob">Date of Birth:</label>
<input type="text" id="dob" name="dob" value="<?php echo $data2['dob']?>" disabled>
</p>


<p>
<label for="email">Email:</label>
<input type="email" id="email" name="email" value="<?php echo $data2['email']?>" disabled>																			
</p>

<?php $auditid = $data2['callauditid']; ?>

<p>
<label for="callauditid">Closer Audit</a></label>
<input type="text" id="callauditid" name="callauditid" value="<?php echo $data2['callauditid']?>" disabled>
</p>

<br>
<br>
<br>
<br>
<br>

<?php $auditid = $data2['callauditid']; ?>

<p>
<input type="hidden" id="callauditid" name="callauditid" value="<?php echo $data2['callauditid']?>" disabled>
</p>

<p>
<input type="hidden" id="leadauditid" name="leadauditid" value="<?php echo $data2['leadauditid']?>" disabled>
</p>

<p>
<input type="hidden" id="leadid1" name="leadid1" value="<?php echo $data2['leadid1']?>" disabled>
</p>

<p>
<input type="hidden" id="leadid2" name="leadid2" value="<?php echo $data2['leadid2']?>" disabled>
</p>

<p>
<input type="hidden" id="leadid3" name="leadid3" value="<?php echo $data2['leadid3']?>" disabled>
</p>



<br>
</div>

<div class="col-md-4">

<h3>Client Details (2)</h3>
<br>

<p>
<label for="FullName2">Name:</label>
<input type="text" id="FullName2" name="FullName2" value="<?php echo $data2['title2']?> <?php echo $data2['first_name2']?> <?php echo $data2['last_name2']?>" disabled>
</p>

<p>
<input type="hidden" id="title2" name="title2" value="<?php echo $data2['title2']?> " disabled>
</p>

<p>
<input type="hidden" id="first_name2" name="first_name2" value="<?php echo $data2['first_name2']?>" disabled>
</p>

<p>
<input type="hidden" id="last_name2" name="last_name2" value="<?php echo $data2['last_name2']?>" disabled>
</p>

<p>
<label for="dob2">Date of Birth:</label>
<input type="text" id="dob2" name="dob2" value="<?php echo $data2['dob2']?>" disabled>
</p>

<p>
<label for="email2">Email:</label>
<input type="email2" id="email2" name="email2" value="<?php echo $data2['email2']?>" disabled>
</p>

<p>
<label for="callauditid2">Closer Audit</a></label>
<input type="text" id="callauditid2" name="callauditid2" value="<?php echo $data2['callauditid2']?>" disabled>
</p>

</div>

<div class="col-md-4">

<h3>Contact Details</h3>
<br>

<p>
<label for="phone_number">Contact Number:</label>
<input type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number']?>" disabled>
</p>


<p>
<label for="alt_number">Alt Number:</label>
<input type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['alt_number']?>" disabled>
</p>

<p>
<label for="address1">Address Line 1:</label>
<input type="text" id="address1" name="address1" value="<?php echo $data2['address1']?>" disabled>
</p>

<p>
<label for="address2">Address Line 2:</label>
<input type="text" id="address2" name="address2" value="<?php echo $data2['address2']?>" disabled>
</p>

<p>
<label for="town">Town:</label>
<input type="text" id="town" name="town" value="<?php echo $data2['town']?>" disabled>
</p>

<p>
<label for="post_code">Post Code:</label>
<input type="text" id="post_code" name="post_code" value="<?php echo $data2['post_code']?>" disabled>
</p>


</form>


<form id="from1" class="AddClient" enctype="multipart/form-data" method="POST" action="/php/deleteclientsubmit.php?life">
<br>

<input type="hidden" name="deleteclientid" value="<?php echo $search?>" readonly>
<button class="btn btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Client</button>


</form>

 <script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete client?",
                text: "You will not be able to recover any deleted data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Complete!',
                        text: 'Client details deleted!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No Changes have been submitted", "error");
                }
            });
        });

    </script>

<br>
<br>
    <?php } ?>
<input type="hidden" name="search" value="<?php echo $_GET["search"]?>" readonly>




</form>
</div>
</div>
</body>
</html>
