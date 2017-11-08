<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

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
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Add Product</title>
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

<?php 
require_once(__DIR__ . '/../includes/navbar.php');

$AddHome= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_NUMBER_INT);

?>

<br>

<div class="container">

 <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Add Product</div>
      <div class="panel-body">
<?php 

if(isset($AddHome)){ 
    $HomePOST= filter_input(INPUT_GET, 'Home', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($HomePOST =='y') {  
        $CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);
        $query = $pdo->prepare("SELECT client_id, CONCAT(title, ' ', first_name, ' ', last_name) AS Name , CONCAT(title2, ' ', first_name2, ' ', last_name2) AS Name2 from client_details where client_id = :search");
        $query->bindParam(':search', $CID, PDO::PARAM_INT);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_ASSOC);
        
        $NAME=$result['Name'];
        $NAME2=$result['Name2'];
        ?>

<form class="AddClient" action="php/AddPolicySubmit.php?query=HomeInsurance&CID=<?php echo $CID; ?>" method="POST">
    <div class="col-md-4">
        
        <label for='client_name'>Client Name</label>
        <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
            <option value='<?php if(isset($NAME)) { echo $NAME; } ?>'><?php if(isset($NAME)) { echo $NAME; } ?></option>
                <?php if(isset($NAME2)) { ?>
            <option value='<?php if(isset($NAME2)) { echo $NAME2; } ?>'><?php if(isset($NAME2)) { echo $NAME2; } ?></option>
                <?php } ?>
                    <?php if(isset($NAME2)) { ?>
            <option value='<?php if(isset($NAME2)) { echo "$NAME and $NAME2"; } ?>'><?php if(isset($NAME2)) { echo "$NAME and $NAME2"; } ?></option>
                <?php } ?>
        </select>
        
        <br>
        <label for="sale_date">Sale Date:</label>
        <input class="form-control" type="text" id="sale_date" value="<?php echo $date = date('Y-m-d H:i:s');?>" placeholder="<?php echo $date = date('Y-m-d H:i:s');?>" name="sale_date"  style="width: 140px" required>
        
        <br>
        <label for="policy_number">Policy Number:</label>
        <input class="form-control" autocomplete="off" type='text' id='policy_number' name='policy_number' style="width: 140px" placeholder="TBC">
        
        <br>
        <label for="insurer">Insurer:</label>
        <input class="form-control" autocomplete="off" type='text' id='insurer' name='insurer' style="width: 140px" placeholder="Insurer">

        <br>
        <div class="form-row">
            <label for="type">Type:</label>
            <select class="form-control" name="type" id="type" style="width: 140px" required>
                <option value="">Select...</option>
                <option value="Buildings">Buildings</option>
                <option value="Contents">Contents</option>
                <option value="Buidlings & Contents">Buildings & Contents</option>
            </select>
        </div>
        
    </div>
    
    <div class="col-md-4">
        <div class="form-row">
            
            <label for="premium">Premium:</label>
            <div class="input-group"> 
                <span class="input-group-addon">£</span>
                <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="premium" name="premium" required/>
            </div>
            
            <br>
            <div class="form-row">
                <label for="commission">Commission</label>
                <div class="input-group"> 
                    <span class="input-group-addon">£</span>
                    <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
                </div>
                
                <br>
                <div class="form-row">
                    <label for="cover">Cover Amount</label>
                    <div class="input-group"> 
                        <span class="input-group-addon">£</span>
                        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="cover" required/>
                    </div>
                    
                    <br>
                    <div class="form-row">
                        <label for="PolicyStatus">Policy Status:</label>
                        <select class="form-control" name="status" id="status" style="width: 140px">
                            <option value="">Select...</option>
                            <option value="Live">Live</option>
                            <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
                            <option value="NTU">NTU</option>
                            <option value="Declined">Declined</option>
                            <option value="Redrawn">Redrawn</option>
                        </select>
                    </div>
                    
                    <br>
                    <label for="closer">Closer:</label>
                    <input type='text' id='closer' name='closer' style="width: 140px" required>
                    <script>
                var options = {
                    url: "/JSON/CloserNames.json",
                    getValue: "full_name",
                    list: {
                        match: {
                            enabled: true
                        }
                    }
                };
                $("#closer").easyAutocomplete(options);
                                                </script>
                                                
                                                <label for="lead">Lead Gen:</label>
                                                <input type='text' id='lead' name='lead' style="width: 140px" required>
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
                                                <br>
                </div>
                
                <div class="btn-group">
                    <a href="Home/ViewClient.php?CID=<?php echo $CID; ?>" class="btn btn-warning "><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
                    <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Save</button>
                </div>
                </form>
</div>
    
    <?php } } ?>

<div class="col-md-4">
</div>
</div>
</div>
</div>
</div>
      </div>
    </div>
 </div>
</div>

</body>
</html>
