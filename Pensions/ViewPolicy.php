<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;


include('../includes/adl_features.php');
include('../includes/adlfunctions.php');
            
            if(isset($fferror)) {
    if($fferror=='0') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
    include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../CRMmain.php'); die;

}
    
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | View Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/styles/sweet-alert.min.css" />
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');     
    include('../includes/ADL_PDO_CON.php'); 
    
    $policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
    $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT); 
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
            $client_name=$data2['client_name']

    ?>


    <div class="container">
    <div class="notice notice-info">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Info!</strong> You are now Viewing <?php echo $client_name;?>'s Policy .
    </div>
 <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">View Pension Policy</div>
      <div class="panel-body">    
        <form class="AddClient" method="POST">
    <div class="col-md-4">
        
        <input type="hidden" name="client_id" value="<?php echo $search?>">
            
  
                <p>
            <label for="provider">Provider:</label>
            <input type='text' id='provider' name='provider' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($provider)) { echo $provider; } ?>" disabled>
        </p>
        
                        <p>
            <label for="policy_number">Policy Number:</label>
            <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($policy)) { echo $policy; } ?>" disabled>
        </p>

        <p>
            <label for="type">Type:</label>
            <input type='text' id='type' name='type' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($type)) { echo $type; } ?>" disabled>
        </p>  

                    <p>
            <label for="drawing">Drawing Down:</label>
            <input type='text' id='drawing' name='drawing' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($drawing)) { echo $drawing; } ?>" disabled>
        </p>  
        

    </div>
        <div class="col-md-4">
           
            
        <p>
            <label for="duration">Plan Duration:</label>
            <input type='text' id='duration' name='duration' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($duration)) { echo $duration; } ?>" disabled>
        </p> 
        
        <p>
            <label for="statements">Statements Available:</label>
            <input type='text' id='statements' name='statements' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($statements)) { echo $statements; } ?>" disabled>
        </p>   
        
        </div>
    
    <div class="col-md-4">
           
            <div class="form-group">
            <label for="contribution">Contribution:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="contribution" name="contribution" value="<?php if(isset($contribution)) { echo $contribution; } ?>" disabled>
            </div> 
        </div>
            <br>  
                    <div class="form-group">
            <label for="value">Pot Value:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="text" class="form-control" id="value" name="value" value="<?php if(isset($value)) { echo $value; } ?>" disabled>
            </div> 
        </div>
            
            <p>
            <label for="status">Status:</label>
            <input type='text' id='status' name='status' class="form-control" autocomplete="off" style="width: 170px" value="<?php if(isset($status)) { echo $status; } ?>" disabled>
        </p>   
        
            
            <br>
        
                     <p>
<label for="created">Added By</label>
<input type="text" value="<?php echo $data2["added_by"];?>" class="form-control" id="disabledInput" disabled style="width: 170px">
</p>


<p>
<label for="created">Date Added</label>
<input type="text" value="<?php echo $data2["submitted_date"];?>" class="form-control" id="disabledInput" disabled style="width: 170px">
</p> 
<p>
<label for="created">Edited By</label>
<input type="text" value="<?php if (!empty($data2["updated_by"] && $data2["submitted_date"]!=$data2["updated_date"])) { echo $data2["updated_by"]; }?>" class="form-control" id="disabledInput" disabled style="width: 170px">
</p>   
<p>
<label for="created">Date Edited</label>
<input type="text" value="<?php if($data2["updated_date"]!=$data2["submitted_date"]) { echo $data2["updated_date"]; } ?>" class="form-control" id="disabledInput" disabled style="width: 170px">
</p>  
 <a href="ViewClient.php?search=<?php echo $search;?>" class="btn btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>       
    </div>
        

            </form>

        
      </div>
    </div>
 </div>
    </div>
      <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
    </body>
</html>
