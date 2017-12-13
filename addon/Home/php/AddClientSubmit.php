<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 * 
*/  

include(filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS)."/classes/access_user/access_user_class.php");  
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/adl_features.php');

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../../includes/Access_Levels.php');

require_once(__DIR__ . '/../../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
} 
    
        require_once(__DIR__ . '/../../../classes/database_class.php');
        require_once(__DIR__ . '/../../../class/login/login.php');
        
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }    
    
    $custype= filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($custype)) {  
        if($custype=='TRB Home Insurance') {
 
    ?>

<!DOCTYPE html>
<html lang="en">
<title>Add Home Insurance Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
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
    
  <?php  require_once(__DIR__ . '/../../../includes/navbar.php');
        
        $title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $phone= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $alt= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_SPECIAL_CHARS);
        $title2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        
        if(isset($dob2)) {
            $correct_dob2 = date("Y-m-d" , strtotime($dob2));
            
        }
        
        $database = new Database(); 
        $database->beginTransaction();
        
        $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company='TRB Home Insurance'");
        $database->bind(':post', $post);
        $database->bind(':add1',$add1);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupeclientid=$row['client_id'];
            
            echo "<div class=\"notice notice-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: $first $last<br> Address: $add1 $post.<br><br><a href='../Life/ViewClient.php?search=$dupeclientid' class=\"btn btn-default\"><i class='fa fa-eye'> View Client</a></i></div>";
            
        }
        
        else {
            
            $database->query("INSERT into client_details set company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':company', $custype);
            $database->bind(':title', $title);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':phone',$phone);
            $database->bind(':alt',$alt);
            $database->bind(':title2', $title2);
            $database->bind(':first2',$first2);
            $database->bind(':last2',$last2);
            $database->bind(':dob2',$correct_dob2);
            $database->bind(':email2',$email2);
            $database->bind(':add1',$add1);
            $database->bind(':add2',$add2);
            $database->bind(':add3',$add3);
            $database->bind(':town',$town);
            $database->bind(':post',$post);
            $database->bind(':hello',$hello_name);
            $database->bind(':hello2',$hello_name);
            $database->execute();
            $lastid =  $database->lastInsertId();
            
            if ($database->rowCount()>=0) { 
                
                $notedata= "Client Added";
                $custypenamedata= $title ." ". $first ." ". $last;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $database->bind(':clientidholder',$lastid);
                $database->bind(':sentbyholder',$hello_name);
                $database->bind(':recipientholder',$custypenamedata);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();
                
                $database->endTransaction();
         
     }
     
     else {
         
         header('Location: /../../../../../CRMmain.php?Clientadded=failed'); die;
         }

?>
           <div class="container">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Add Policy <a href='../ViewClient.php?CID=<?php echo "$lastid";?>'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-user"></i> Skip Policy and View Client...</button></a></div>
                <div class="panel-body">
                    
                    <form class="AddClient" action="AddPolicySubmit.php?query=HomeInsurance&CID=<?php echo $lastid;?>" method="POST">
                        
                        <div class="col-md-4">
                            
                            <label for="client_name">Client Name</label>
                            <select class="form-control"  style="width: 140px"  name="client_name" required>
                                <option value="<?php echo $title;?> <?php echo $first;?> <?php echo $last;?>">  <?php echo $title;?> <?php echo $first;?> <?php echo $last;?></option>
                                <option value="<?php echo $title2;?> <?php echo $first2;?> <?php echo $last2;?>">  <?php echo $title2;?> <?php echo $first2;?> <?php echo $last2;?></option>
                                <option value=" <?php echo "$title $first $last and $title2 $first2 $last";?>">  <?php echo "$title $first $last and $title2 $first2 $last2";?></option>
                            </select>
                            <br>

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
  <option value="Buidlings and Contents">Buildings & Contents</option>
  </select>
</div>

<br>

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
        <input autocomplete="off" style="width: 140px" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="cover" name="covera" required/>
    </div> 

<br>
<div class="form-row">
  <label for="PolicyStatus">Policy Status:</label>
  <select class="form-control" name="status" id="status" style="width: 140px">
  <option value="">Select...</option>
  <option value="Live">Live</option>
  <option value="Awaiting Policy Number">Awaiting Policy Number (TBC Policies)</option>
  <option value="Live Awaiting Policy Number">Live Awaiting Policy Number</option>
  <option value="NTU">NTU</option>
  <option value="Declined">Declined</option>
    <option value="Redrawn">Redrawn</option>
   </select>
</div>

<br>
<label for="closer">Closer:</label>
<input type='text' id='closer' name='closer' style="width: 140px" required>
    <script>var options = {
	url: "/app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                getValue: "full_name",

	list: {
		match: {
			enabled: true
		}
	}
};

$("#closer").easyAutocomplete(options);</script>

<label for="lead">Lead Gen:</label>
<input type='text' id='lead' name='lead' style="width: 140px" required>
    <script>var options = {
	url: "/app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
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
<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Policy</button>
</div>
</form>
          
<?php }?>
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
<?php } }

else {
header('Location: /../../../../../CRMmain.php?Clientadded=failed'); die;
}
?>