<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

if ($ffanalytics == '0') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        if (!in_array($hello_name,$Level_10_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;

} 

$DeleteLifePolicy= filter_input(INPUT_GET, 'DeleteLifePolicy', FILTER_SANITIZE_SPECIAL_CHARS);
$home= filter_input(INPUT_GET, 'home', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Delete Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../datatables/css/layoutcrm.css"/>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<script src="/ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
<script src="/js/jquery-2.1.4.min.js"></script>
<script src="/js/sweet-alert.min.js"></script>
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>

<body>

<?php require_once(__DIR__ . '/../includes/navbar.php');

 
 if(isset($home)){
     $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_NUMBER_INT);
     $PID= filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_NUMBER_INT);
     
     $query = $pdo->prepare("SELECT client_id, id, client_name, sale_date, policy_number, premium, type, insurer, added_date, commission, status, added_by, updated_by, updated_date, closer, lead, cover  FROM home_policy WHERE id=:PID AND client_id=:CID");
     $query->bindParam(':PID', $PID, PDO::PARAM_INT);
     $query->bindParam(':CID', $CID, PDO::PARAM_INT);
     $query->execute();
     $data2=$query->fetch(PDO::FETCH_ASSOC); ?>
    
    <div class="container">
        <div class="policyview">
            <div class="notice notice-danger fade in">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning!</strong> You are about to permanently delete this Policy (<?php echo $data2["policy_number"] ?>) from the database.
            </div>
        </div>

        <div class="panel-group">
            <div class="panel panel-danger">
                <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Delete Policy</div>
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
</form>
                        <form id="from1" id="form1"  class="AddClient" enctype="multipart/form-data" method="POST" action="/php/deletepolicysubmit.php?home&CID=<?php echo $CID;?>&PID=<?php echo $PID;?>">
<button name='delete' class="btn btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Policy</button>
</form>

                    </div>
                    
                    <form class="AddClient">
                        <div class="column-left">

<p>
<label for="client_name">Policy Holder</label>
<input type="text" id="client_name" name="client_name" value="<?php echo $data2['client_name']; ?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="sale_date">Sale Date:</label>
<input type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]; ?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="policy_number">Policy Number</label>
<input type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]; ?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="type">Type</label>
<input type="text" value="<?php echo $data2["type"];?>" class="form-control" readonly style="width: 200px">
</p>


<p>
<label for="insurer">Insurer</label>
<input type="text" value="<?php echo $data2["insurer"];?>" class="form-control" readonly style="width: 200px">
</p>


</div>
                        <div class="column-center">
<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2[premium]?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" class="form-control" readonly style="width: 200px"/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 170px" type="number" value="<?php echo $data2[commission]?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" class="form-control" readonly style="width: 200px"/>
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
     
<?php }


if(isset($DeleteLifePolicy)) { 
    if($DeleteLifePolicy=='1') {

        $policyID= filter_input(INPUT_POST, 'policyID', FILTER_SANITIZE_NUMBER_INT);
        
        $query = $pdo->prepare("SELECT client_id, id, polterm, client_name, sale_date, application_number, policy_number, premium, type, insurer, submitted_by, commission, CommissionType, policystatus, submitted_date, edited, date_edited, drip, comm_term, soj, closer, lead, covera FROM client_policy WHERE id = :SEARCH");
        $query->bindParam(':SEARCH', $policyID, PDO::PARAM_INT);
        $query->execute();
        $data2=$query->fetch(PDO::FETCH_ASSOC);
        
?>
<div class="container">

<div class="warningalert">
    <div class="notice notice-danger fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Warning!</strong> You are about to permanently delete this Policy (<?php echo $data2["policy_number"] ?>) from the database.
    </div>

 <div class="panel-group">
    <div class="panel panel-danger">
      <div class="panel-heading">Delete Policy</div>
      <div class="panel-body">
<form class="AddClient" enctype="multipart/form-data">
<br>


<div class="column-left">

<p>
<label for="client_name">Policy Holder</label>
<input class="form-control" style="width: 170px" type="text" id="client_name" name="client_name" value="<?php echo $data2['client_name']; ?>" disabled>


<p>
<label for="soj">Single or Joint:</label>
<select class="form-control" style="width: 170px" name="soj" disabled>
<option value="<?php echo $data2['soj']; ?>"><?php echo $data2['soj']; ?></option>
</select>
</p>

<p>
<label for="sale_date">Sale Date:</label>
<input class="form-control" style="width: 170px" type="text" id="sale_date" name="sale_date" value="<?php echo $data2["sale_date"]; ?>" disabled>


<p>
<label for="policy_number">Policy Number</label>
<input class="form-control" style="width: 170px" type="text" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]; ?>" disabled>


<p>
<label for="application_number">Application Number:</label>
<input class="form-control" style="width: 170px" type="text" id="application_number" name="application_number" value="<?php echo $data2["application_number"]; ?>" disabled>


<p>
<label for="type">Type</label>
<select class="form-control" style="width: 170px" name="type" style="width: 200px" disabled>
  <option value="<?php echo $data2["type"];?>"><?php echo $data2["type"];?></option>
</select>


<p>
<label for="insurer">Insurer</label>
<select class="form-control" style="width: 170px" name="insurer" style="width: 200px" disabled>
  <option value="<?php echo $data2["insurer"];?>"><?php echo $data2["insurer"];?></option>
</select>
</p>

</div>

<div class="column-center">
<p>
 <div class="form-row">
        <label for="premium">Premium:</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" type="number" value="<?php echo $data2['premium'];?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" disabled/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="commission">Commission</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" type="number" value="<?php echo $data2['commission'];?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" disabled/>
    </div> 
</p>

<p>
 <div class="form-row">
        <label for="polterm">Policy Term</label>
    <div class="input-group"> 
        <span class="input-group-addon">yrs</span>
        <input style="width: 130px" type="text" class="form-control" id="polterm" name="polterm" value="<?php echo $data2['polterm']; ?>" disabled/>
    </div> 
</p>

<p>
<label for="CommissionType">Commission Type</label>
<select class="form-control" style="width: 170px" name="CommissionType" style="width: 200px" disabled>
  <option value="<?php echo $data2["CommissionType"]; ?>"><?php echo $data2["CommissionType"]; ?></option>
</select>
</p>

<p>
<label for="comm_term">Clawback Term</label>
<select class="form-control" style="width: 170px" name="comm_term" disabled>
<option value="<?php echo $data2["comm_term"];?>"><?php echo $data2["comm_term"];?></option>
</select>
</p>

<p>
 <div class="form-row">
        <label for="commission">Drip</label>
    <div class="input-group"> 
        <span class="input-group-addon">£</span>
        <input style="width: 140px" type="number" value="<?php echo $data2["drip"]; ?>" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" disabled/>
    </div> 
</p>

<p>
<label for="PolicyStatus">Policy Status</label>
<select class="form-control" style="width: 170px" name="PolicyStatus" style="width: 200px" disabled>
  <option value="<?php echo $data2['policystatus']; ?>"><?php echo $data2['policystatus']; ?></option>
</select>
</p>

<label for="closer">Closer:</label>
<input class="form-control" style="width: 170px" type='text' id='closer' name='closer' style="width: 170px" value="<?php echo $data2["closer"]; ?>" disabled>


<br>

<p>
<label for="lead">Lead Gen:</label>
<input class="form-control" style="width: 170px" type='text' id='lead' name='lead' style="width: 170px" value="<?php echo $data2["lead"]; ?>" disabled>

</form>
</div>


<form id="from1" id="form1"  class="AddClient" enctype="multipart/form-data" method="POST" action="/php/deletepolicysubmit.php?DeleteLifePolicy=1">
<input type="hidden" id="deletepolicyID" name="deletepolicyID" value="<?php echo $data2["id"]; ?>">
<input type="hidden" id="client_id" name="client_id" value="<?php echo $data2["client_id"]; ?>">
<input type="hidden" id="name" name="name" value="<?php echo $data2['client_name']; ?>">
<input type="hidden" id="policy_number" name="policy_number" value="<?php echo $data2["policy_number"]; ?>">
<button name='delete' class="btn btn-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Delete Policy</button>
</form>
<?php } } ?>
    <script>
        document.querySelector('#from1').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete policy?",
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
                        text: 'Policy details deleted!',
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
</div>
</div>
</div>
</div>
</body>
</html>
