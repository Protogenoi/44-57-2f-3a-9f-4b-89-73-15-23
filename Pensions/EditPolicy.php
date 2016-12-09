<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 3);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;


    include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Edit Policy</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link  rel="stylesheet" href="/styles/sweet-alert.min.css" />
<link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
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

<?php include('../includes/navbar.php');
include('../includes/ADL_PDO_CON.php'); 
include('../includes/adlfunctions.php');
        include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }



$search= filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
$policyID= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);



            $query = $pdo->prepare("SELECT client_name, provider, policy_number, type, drawing, duration, statements, contribution, value, status, added_by, submitted_date, updated_date, updated_by FROM pension_policy  WHERE policy_id=:pol");
            $query->bindParam(':pol', $policyID, PDO::PARAM_STR, 12);
            $query->execute();
            $data2=$query->fetch(PDO::FETCH_ASSOC);
            
            $provider=$data2['provider'];
            $policy=$data2['policy_number'];
            $type=$data2['type'];
            $drawing=$data2['drawing'];
            $duration=$data2['duration'];
            $statements=$data2['statements'];
            $contribution=$data2['contribution'];
            $value=$data2['value'];
            $status=$data2['status'];
            $client_name=$data2['client_name'];


?>
<div class="container">
<div class="editpolicy">
    <div class="notice notice-warning">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are now editing <?php echo $client_name;?>'s Policy .
    </div>
	
	  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Edit Policy</div>
      <div class="panel-body">

<form id="from1" id="form1" class="AddClient" method="post" action="php/EditPolicySubmit.php" enctype="multipart/form-data">

<input  class="form-control"type="hidden" name="policy_id" value="<?php echo $policyID; ?>"> 
<input  class="form-control"type="hidden" name="search" value="<?php echo $search?>">


	<div class="col-md-4">

<p>
<div class="form-group">
  <label for="client_name">Policy Holder</label>
  <select class="form-control" name="client_name" id="client_name" style="width: 170px" required>
      
          <option value="<?php echo $client_name;?>"><?php echo $client_name;?></option>

  </select>
</div>
</p>


<p>
<label for="provider">Provider:</label>
<input  class="form-control"type="text" id="provider" name="provider" value="<?php echo $provider;?>" class="form-control" style="width: 170px" required>
</p>

<p>
<label for="policy_number">Policy:</label>
<input  class="form-control"type="text" id="policy_number" name="policy_number" value="<?php echo $policy;?>" class="form-control" style="width: 170px" required>
</p>

<p>
<div class="form-group">
  <label for="type">Type:</label>
  <select class="form-control" name="type" id="type" style="width: 170px" required>
<option value="<?php echo  $type;?>"><?php echo $type;?></option>
                <option value="Private">Private</option>
                <option value="Former Work">Former Work</option>
  </select>
</div>
</p>

<p>
<div class="form-group">
  <label for="drawing">Drawing down:</label>
  <select class="form-control" name="drawing" id="drawing" style="width: 170px" required>
<option value="<?php echo  $drawing;?>"><?php echo $drawing;?></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
  </select>
</div>
</p>
	</div>

	<div class="col-md-4">
            
            <p>
<label for="duration">Duration:</label>
<input  class="form-control"type="text" id="duration" name="duration" value="<?php echo $duration;?>" class="form-control" style="width: 170px" required>
</p>

<p>
<div class="form-group">
  <label for="statements">Statements:</label>
  <select class="form-control" name="statements" id="statements" style="width: 170px" required>
<option value="<?php echo  $statements;?>"><?php echo $statements;?></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
  </select>
</div>
</p>
        </div>  

<div class="col-md-4">
<p>
 <div class="form-row">
        <label for="contribution">Contribution:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $contribution;?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="contribution" name="contribution" />
    </div> 
</p>


<p>
 <div class="form-row">
        <label for="value">Pot Value</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input  class="form-control currency"style="width: 140px" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" type="number" value="<?php echo $value;?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="value" name="value" />
    </div> 
</p>


<p>
<div class="form-group">
  <label for="status">Status:</label>
  <select class="form-control" name="status" id="status" style="width: 170px" required>
  <option value="<?php echo $status;?>"><?php echo $status;?></option>
                <option value="Active">Active</option>
                <option value="Frozen">Frozen</option>
                <option value="New">New</option>
  </select>
</div>
</p>

	</div>


<br>
<select class="form-control" name="changereason" required>
    <option value="">Select update reason...</option>
    <option value="Incorrect Holder">Incorrect Policy Holder</option>
    <option value="Incorrect Provider">Incorrect Provider</option>
    <option value="Incorrect Policy Number">Incorrect Policy Number</option>
    <option value="Incorrect Type">Incorrect Type</option>
    <option value="Incorrect Drawing Down">Incorrect Drawing Down</option>
    <option value="Incorrect Duration">Incorrect Duration</option>
    <option value="Incorrect Statements">Incorrect Statements</option>
    <option value="Incorrect Contribution">Incorrect Contribution</option>
<option value="Incorrect Pot Value">Incorrect Pot Value</option>
    <option value="Update Policy Status">Update Policy Status</option>

    <?php if($hello_name=='Michael') { ?>
        <option value="Admin Change">Admin Change</option>
   <?php } ?>
</select>
<br>


<button class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>

</form>

<a href="ViewClient.php?search=<?php echo $search?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>

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
