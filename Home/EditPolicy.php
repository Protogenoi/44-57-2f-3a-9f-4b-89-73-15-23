<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

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
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
    
$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
$PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
$client_namePOST= filter_input(INPUT_GET, 'NAME', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($CID)) {

$query = $pdo->prepare("SELECT CONCAT(client_details.title, ' ',client_details.first_name,' ',client_details.last_name) AS NAME, CONCAT(client_details.title2, ' ',client_details.first_name2,' ',client_details.last_name2) AS NAME2, home_policy.client_id, home_policy.id, home_policy.client_name, home_policy.sale_date, home_policy.policy_number, home_policy.premium, home_policy.type, home_policy.insurer, home_policy.added_date, home_policy.commission, home_policy.status, home_policy.added_by, home_policy.updated_by, home_policy.updated_date, home_policy.closer, home_policy.lead, home_policy.cover FROM home_policy JOIN client_details on client_details.client_id = home_policy.client_id WHERE home_policy.id = :PID AND home_policy.client_id=:CID");
$query->bindParam(':CID', $CID, PDO::PARAM_INT);
$query->bindParam(':PID', $PID, PDO::PARAM_INT);
$query->execute();
$data2=$query->fetch(PDO::FETCH_ASSOC);

$NAME=$data2['NAME'];
$NAME2=$data2['NAME2'];    

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
<title>ADL | Edit Home Policy</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link  rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
  <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
<style>

	.editpolicy{
		margin: 20px;
	}

.form-row input {
    padding: 3px 1px;
    width: 100%;
}
input.currency {
    text-align: right;
    padding-right: 15px;
}
.input-group .form-control {
    float: none;
}
.input-group .input-buttons {
    position: relative;
    z-index: 3;
}
</style>
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php'); ?>
    
<div class="container">
<div class="editpolicy">
    <div class="notice notice-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are now editing <?php echo $data2['client_name']?>'s Policy .
    </div>
	
	  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Edit Policy</div>
      <div class="panel-body">

<form id="from1" id="form1" class="AddClient" method="post" action="php/EditPolicySubmit.php?CID=<?php echo $CID; ?>&PID=<?php echo $PID; ?>" enctype="multipart/form-data">


<input  class="form-control"type="hidden" name="policyID" value="<?php echo $data2['policy_number']?>">



	<div class="col-md-4">

<p>
<div class="form-group">
  <label for="client_name">Policy Holder</label>
  <select class="form-control" name="client_name" id="client_name" style="width: 170px" required>
      <?php if(isset($client_namePOST)) { ?>
          <option value="<?php echo $client_namePOST;?>"><?php echo $client_namePOST;?></option>

     <?php  } ?>
<option value="<?php echo $NAME;?>"><?php echo $NAME?></option>
<?php if(!empty($NAME2)) { ?>
 <option value="<?php echo $NAME2;?>"><?php echo $NAME2?></option>   
   <option value="<?php echo "$NAME and $NAME2";?>"><?php echo "$NAME and $NAME2"?></option>  
  <?php  
}

?>
  </select>
</div>
</p>



<p>
<label for="sale_date">Sale Date:</label>
<input  class="form-control"type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]?>" class="form-control" style="width: 170px" required>
</p>


<p>
<label for="policy_number">Policy Number</label>
<input  class="form-control"type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]?>" class="form-control" style="width: 170px" required>
</p>




<p>
<div class="form-group">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 170px" required>
  <option value="<?php echo $data2["type"];?>"><?php echo $data2["type"];?></option>
                <option value="Buildings">Buildings</option>
                <option value="Contents">Contents</option>
                <option value="Buidlings and Contents">Buildings & Contents</option>
  </select>
</div>
</p>
        
        <label for="insurer">Insurer:</label>
        <input class="form-control" style="width: 170px" autocomplete="off" type='text' id='insurer' name='insurer' style="width: 140px" placeholder="Insurer" value="<?php if(isset($data2['insurer'])) { echo $data2["insurer"]; }?>">

        <br>
	</div>

	<div class="col-md-4">
<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['premium']?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" />
    </div> 
</p>


<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['commission']?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" />
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="cover">Cover Amount</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $data2['cover']?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="cover" />
    </div> 
</p>



<p>
<div class="form-group">
  <label for="status">Policy Status:</label>
  <select class="form-control" name="status" id="status" style="width: 170px" required>
  <option value="<?php echo $data2['status']?>"><?php echo $data2['status']?></option>
  <option value="Live">Live</option>
  <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
  <option value="NTU">NTU</option>
  <option value="Declined">Declined</option>
    <option value="Redrawn">Redrawn</option>
    <option value="Cancelled">Cancelled</option>
   
  </select>
</div>
</p>
	</div>



<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' style="width: 140px" value="<?php echo $data2["closer"]?>" required>
    <script>var options = {
	url: "/JSON/CloserNames.json",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#closer").easyAutocomplete(options);</script>

<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' style="width: 140px" value="<?php echo $data2["lead"]?>" required>
    <script>var options = {
	url: "../JSON/Agents.php?EXECUTE=1",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#lead").easyAutocomplete(options);</script>

<br>
<select class="form-control" name="changereason" required>
    <option value="">Select update reason...</option>
    <option value="Updated TBC Policy Number">Updated TBC Policy Number</option>
    <option value="Incorrect Policy Number">Incorrect Policy Number</option>
    <option value="Incorrect Policy Holder">Incorrect Policy Holder</option>
    <option value="Incorrect Sale Date">Incorrect Sale Date</option>
    <option value="Incorrect Policy Type">Incorrect Policy Type  (Buildings, Contents...)</option>
    <option value="Incorrect Insurer">Incorrect Insurer</option>
    <option value="Incorrect Premium">Incorrect Premium</option>
    <option value="Incorrect Commission">Incorrect Commission</option>
    <option value="Incorrect Lead Gen">Incorrect Lead Gen</option>
    <option value="Incorrect Closer">Incorrect Closer</option>
    <option value="Update Policy Status">Update Policy Status</option>
    <option value="Updated Cover Amount">Update Cover Amount</option>
    <?php if($hello_name=='Michael') { ?>
        <option value="Admin Change">Admin Change</option>
   <?php } ?>
</select>
<br>

<div class="btn-group">
    <a href="ViewClient.php?CID=<?php echo $CID?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
</div>
</form>



</div>
</div>
 </div>
        </div>
      </div>


    </div>
          </div>
</div>
</div>
</div>
<script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Save changes?",
                text: "You will not be able to recover any overwritten data!",
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
                        text: 'Policy details updated!',
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

  <script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>

<script src="/js/sweet-alert.min.js"></script>
 <script>
  $(function() {
    $( "#dob" ).datepicker();
  });
  </script>
 <script>
  $(function() {
    $( "#dob2" ).datepicker();
  });
  </script>
<script>
    $("readonly").keydown(function(e){
        e.preventDefault();
    });
</script>
<script>
webshims.setOptions('forms-ext', {
    replaceUI: 'auto',
    types: 'number'
});
webshims.polyfill('forms forms-ext');
</script>
 <script>
  $(function() {
    $( "#sale_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
  });
  </script>
</body>
</html>
