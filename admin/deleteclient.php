<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/Access_Levels.php');

        if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;

}

$pension= filter_input(INPUT_GET, 'pension', FILTER_SANITIZE_SPECIAL_CHARS);
$life= filter_input(INPUT_GET, 'life', FILTER_SANITIZE_SPECIAL_CHARS);
$home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

include('../includes/adl_features.php');
            
            if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>


<!DOCTYPE html>
<html lang="en">
<title>Delete Client</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="../datatables/js/bpop.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	.warningalert{
		margin: 20px;
	}
</style>
<link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../js/sweet-alert.min.js"></script>
</head>
<body>
    
    <?php include('../includes/navbar.php');
    include('../includes/adlfunctions.php');
    
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

    <?php } if(isset($pension)) {
        
        
    
  $penq = $pdo->prepare("SELECT ni_num, ni_num2, title, first_name, initials, last_name, dob, title2, first_name2, initials2, last_name2, dob2, address1, address2, address3, town, post_code, number1, number2, number3, email FROM pension_clients WHERE client_id = :searchplaceholder");
  $penq->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
  $penq->execute();
  $gppenresult=$penq->fetch(PDO::FETCH_ASSOC);
  
  
  $pentitle=$gppenresult['title'];
    $penfirst=$gppenresult['first_name'];
    $penint=$gppenresult['initials'];
    $penlast=$gppenresult['last_name'];
    $pendob=$gppenresult['dob'];
    $penadd1=$gppenresult['address1'];
    $penadd2=$gppenresult['address2'];
    $penadd3=$gppenresult['address3'];
    $pentown=$gppenresult['town'];
    $penpost=$gppenresult['post_code'];
    $penemail=$gppenresult['email'];
    $pennum1=$gppenresult['number1'];
    $pennum2=$gppenresult['number2'];
    $pennum3=$gppenresult['number3'];
    $pentitle2=$gppenresult['title2'];
    $penfirst2=$gppenresult['first_name2'];
    $penint2=$gppenresult['initials2'];
    $penlast2=$gppenresult['last_name2'];
    $pendob2=$gppenresult['dob2'];
    $penni=$gppenresult['ni_num'];
    $penni2=$gppenresult['ni_num2'];
  
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
          
<form class="AddClient" id="AddProduct">
        <div class="col-md-4">   
            <h3><span class="label label-info">Client Details</span></h3>
            <br>
            
            <p>
                <label for="Title">Title:</label>
                <input type="text" id="Title" name="Title" class="form-control" style="width: 170px" disabled <?php if (isset($pentitle)) { echo "value='$pentitle'";} ?>>
            </p>

            <p>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" style="width: 170px" disabled <?php if (isset($penfirst)) { echo "value='$penfirst'";} ?>>
            </p>
            <p>
                <label for="initials">Initials:</label>
                <input type="text" id="initials" name="initials" class="form-control" style="width: 170px" disabled <?php if (isset($penint)) { echo "value='$penint'";} ?>>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" style="width: 170px" disabled <?php if (isset($penlast)) { echo "value='$penlast'";} ?>>
            </p>
            <p>
                <label for="dob">Date of Birth:</label>
                <input type="text" id="dob" name="dob" class="form-control" style="width: 170px" disabled <?php if (isset($pendob)) { echo "value='$pendob'";} ?>>
            </p>
            <?php if (empty($penni)) { } else{ ?>
            <p>
                <label for="ni_num">NI:</label>
                <input type="text" id="ni_num" name="ni_num" class="form-control" style="width: 170px" disabled <?php if (isset($penni)) { echo "value='$penni'";} ?>>
            </p>
            <?php } ?>
            <br>
        
        </div>  
        <div class="col-md-4">
            
            <?php if (empty($pentitle2)) { } else{ ?>
            
            <h3><span class="label label-info">Client 2</span></h3>
            <br>
            
            <p>
                <label for="Title2">Title:</label>
                <input type="text" id="Title" name="Title2" class="form-control" style="width: 170px" disabled <?php if (isset($pentitle2)) { echo "value='$pentitle2'";} ?>>
            </p>

            <p>
                <label for="first_name2">First Name:</label>
                <input type="text" id="first_name" name="first_name2" class="form-control" style="width: 170px" disabled <?php if (isset($penfirst2)) { echo "value='$penfirst2'";} ?>>
            </p>
            <p>
                <label for="initials2">Initials:</label>
                <input type="text" id="initials" name="initials2" class="form-control" style="width: 170px" disabled <?php if (isset($penint2)) { echo "value='$penint2'";} ?>>
            </p>
            <p>
                <label for="last_name2">Last Name:</label>
                <input type="text" id="last_name" name="last_name2" class="form-control" style="width: 170px" disabled <?php if (isset($penlast2)) { echo "value='$penlast2'";} ?>>
            </p>
            <p>
                <label for="dob2">Date of Birth:</label>
                <input type="text" id="dob" name="dob2" class="form-control" style="width: 170px" disabled <?php if (isset($pendob2)) { echo "value='$pendob2'";} ?>>
            </p>
            <p>
                <label for="ni_num2">NI:</label>
                <input type="text" id="ni_num" name="ni_num2" class="form-control" style="width: 170px" disabled <?php if (isset($penni2)) { echo "value='$penni2'";} ?>>
            </p>
            <br>
            
            <?php } ?>
           
        </div>
        
        <div class="col-md-4">
            <h3><span class="label label-info">Contact Details</span></h3>
            <br>
            <p>
                <label for="phone_number">Mobile:</label>
                <input type="number" id="phone_number" name="number1" class="form-control" style="width: 170px" disabled <?php if (isset($pennum1)) { echo "value='$pennum1'";} ?>>
            </p>
            <?php if (empty($pennum2)) { } else{ ?>
            <p>
                <label for="alt_number">Landline:</label>
                <input type="tel" id="alt_number" name="number2" class="form-control" style="width: 170px" disabled <?php if (isset($pennum2)) { echo "value='$pennum2'";} ?>>
            </p>
            <?php } if (empty($pennum3)) { } else{  ?>
            <p>
                <label for="alt_number">Work:</label>
                <input type="tel" id="alt_number" name="number3" class="form-control" style="width: 170px" disabled <?php if (isset($pennum3)) { echo "value='$pennum3'";} ?>>
            </p>
            <?php } if (empty($penemail)) { } else{ ?>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" style="width: 170px" name="email" disabled <?php if (isset($penemail)) { echo "value='$penemail'";} ?>>
            </p>
            <?php } if (empty($penadd1)) { } else{ ?>
            <p>
                <label for="address1">Address Line 1:</label>
                <input type="text" id="address1" name="address1" class="form-control" style="width: 170px" disabled <?php if (isset($penadd1)) { echo "value='$penadd1'";} ?>>
            </p>
            <?php } if (empty($penadd2)) { } else{ ?>
            <p>
                <label for="address2">Address Line 2:</label>
                <input type="text" id="address2" name="address2" class="form-control" style="width: 170px" disabled <?php if (isset($penadd2)) { echo "value='$penadd2'";} ?>>
            </p>
            <?php } if (empty($penadd3)) { } else{ ?>
            <p>
                <label for="address3">Address Line 3:</label>
                <input type="text" id="address3" name="address3" class="form-control" style="width: 170px" disabled <?php if (isset($penadd3)) { echo "value='$penadd3'";} ?>>
            </p>
            <?php } if (empty($pentown)) { } else{  ?>
            <p>
                <label for="town">Post Town:</label>
                <input type="text" id="town" name="town" class="form-control" style="width: 170px" disabled <?php if (isset($pentown)) { echo "value='$pentown'";} ?>>
            </p>
            
            <p>
                <?php } if (empty($pentown)) { } else{ ?>
                <label for="post_code">Post Code:</label>
                <input type="text" id="post_code" name="post_code" class="form-control" style="width: 170px" disabled <?php if (isset($penpost)) { echo "value='$penpost'";} ?>>
            </p>
        <?php  } ?>
        </div>
</form>



<form id="from1" class="AddClient" enctype="multipart/form-data" method="POST" action="/php/deleteclientsubmit.php?pension">
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
    
    
    <?php } ?>
<input type="hidden" name="search" value="<?php echo $_GET["search"]?>" readonly>




</form>
</div>
</div>
</body>
</html>
