<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
}

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<title>Add Product</title>
<meta charset="UTF-8">
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
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
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
<script>
webshims.setOptions('forms-ext', {
    replaceUI: 'auto',
    types: 'number'
});
webshims.polyfill('forms forms-ext');
</script>
<style>

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

<?php include('includes/navbar.php'); 
include('includes/ADL_PDO_CON.php'); 
    include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }

$AddPension= filter_input(INPUT_GET, 'Pension', FILTER_SANITIZE_NUMBER_INT);
?>

<br>

<div class="container">

 <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Add Product</div>
      <div class="panel-body">
          
<?php

if(isset($AddPension)){
    
      $PensionPOST= filter_input(INPUT_GET, 'Pension', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($PensionPOST =='y') {
        
        $search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
         

?>

<form class="AddClient" action="/php/AddPolicySubmit.php?AddPension=y" method="POST">
    <div class="col-md-4">
        
        <input type="hidden" name="client_id" value="<?php echo $search?>">
            
            <?php
            
            $query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from pension_clients where client_id = :search");
            $query->bindParam(':search', $search, PDO::PARAM_INT);
            $query->execute();
            
            echo "<p>";
            echo "<label for='client_name'>Client Name</label>";
            echo "<select class='form-control' name='client_name' id='client_name' style='width: 170px' required>";
            while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='" . $result['Name'] . "'>" . $result['Name'] . "</option>";
                echo "<option value='" . $result['Name2'] . "'>" . $result['Name2'] . "</option>";
                
            }
            echo "</select>";
            echo"</p>";
            
            ?>
    
                <p>
            <label for="provider">Provider:</label>
            <input type='text' id='provider' name='provider' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>
        
                        <p>
            <label for="policy_number">Policy Number:</label>
            <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>
        
                <div class="form-group">
            <label for="type">Type:</label>
            <select class="form-control" name="type" id="type" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Private">Private</option>
                <option value="Former Work">Former Work</option>
            </select>
        </div>
        
                                <div class="form-group">
            <label for="drawing">Drawing Down:</label>
            <select class="form-control" name="drawing" id="drawing" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>  

    </div>
        <div class="col-md-4">
           
            
        <p>
            <label for="duration">Plan Duration:</label>
            <input type='text' id='duration' name='duration' class="form-control" autocomplete="off" style="width: 170px" required>
        </p>    
            
                <div class="form-group">
            <label for="statements">Statements Available:</label>
            <select class="form-control" name="statements" id="statements" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>  
        

        
        </div>
    
    <div class="col-md-4">
           
            
        <div class="form-row">
            <label for="contribution">Contribution:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="contribution" name="contribution" required/>
            </div> 
        </div>
            <br>  
                    <div class="form-row">
            <label for="value">Pot Value:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="value" name="value" required/>
            </div> 
        </div>
        <br>
                
        <div class="form-group">
            <label for="status">Status:</label>
            <select class="form-control" name="status" id="status" style="width: 170px" required>
                <option value="">Select...</option>
                <option value="Active">Active</option>
                <option value="Frozen">Frozen</option>
                <option value="New">New</option>
            </select>
        </div>
    </div>
        
    <div class="col-md-4">
            <div class="btn-group">
                <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
            </div>
    </div>
            </form>


<?php } } ?>

<div class="col-md-4">
</div>
</div>
</div>
</div>
</div>
  
</body>
</html>
