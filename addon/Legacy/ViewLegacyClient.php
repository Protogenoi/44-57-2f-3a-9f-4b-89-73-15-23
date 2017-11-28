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

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
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

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../app/analyticstracking.php');
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

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | View Client</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
</head>
<body>
    
    <?php include('../includes/navbar.php'); 
    include('../includes/ADL_PDO_CON.php'); 
    include('../includes/adlfunctions.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/analyticstracking.php'); 
    
    }
    ?>

<br>

<!-- TAB 1 SQL -->
<?php
$clientone = $pdo->prepare("select date_created, title, firstname, middlename, surname, DaytimeTel, EveningTel, MobileTel, Client_telephone, home_email, office_email, address1, address2, address3, address4, postcode, dob, branch_client_ref, employment_status, status, partner_id, Introducing_branch, smoker, most_recent_lender, next_contact_date FROM assura_client_details WHERE client_id = :searchplaceholder");
$clientone->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
$clientone->execute();
$data2=$clientone->fetch(PDO::FETCH_ASSOC);

$clientonefull=$data2['firstname'] ." ". $data2['surname'];
$partnersearch=$data2['partner_id'];

$clienttwo = $pdo->prepare("select date_created, title, firstname, middlename, surname, DaytimeTel, EveningTel, MobileTel, Client_telephone, home_email, office_email, address1, address2, address3, address4, postcode, dob, branch_client_ref, employment_status, status, Introducing_branch, smoker, most_recent_lender, next_contact_date FROM assura_client_details WHERE client_id = :partner");
$clienttwo->bindParam(':partner', $partnersearch, PDO::PARAM_STR, 12);
$clienttwo->execute();
$tworesult=$clienttwo->fetch(PDO::FETCH_ASSOC);


?>

<div class="container">
    
    <?php
    
    $newclientstatus = filter_input(INPUT_GET, 'clientstatus', FILTER_SANITIZE_NUMBER_INT);
          
          if(isset($newclientstatus)){
              
              $statusset= filter_input(INPUT_GET, 'setstatus', FILTER_SANITIZE_SPECIAL_CHARS);
              $statusidset= filter_input(INPUT_GET, 'statusid', FILTER_SANITIZE_SPECIAL_CHARS);
              
              $query = $pdo->prepare("UPDATE assura_client_details set client_status=:statusholder WHERE client_id = :searchplaceholder");
              $query->bindParam(':statusholder', $statusset, PDO::PARAM_STR, 12);
              $query->bindParam(':searchplaceholder', $statusidset, PDO::PARAM_STR, 12);
              $query->execute();

              if ($count = $query->rowCount()>0) {
                  echo("<div class=\"notice notice-success\" role=\"alert\"><strong>Client status updated</strong></div>\n");
              }
              else 
                  {
                  echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>No changes made</strong></div>";
                  }
              
          } 
          
                                         
?>
    
    
  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Legacy Clients</a></li>
    <li><a data-toggle="pill" href="#menu1">Notes</a></li>
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <div class="list-group">
                            <li><a class="list-group-item" href="../EditClient.php?search=<?php echo $search?>&legacy"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp; Edit Client</a></li>
                            <li><a class="list-group-item" href="../app/admin/deleteclient.php?search=<?php echo $search?>&legacy"><i class="fa fa-trash fa-fw"></i>&nbsp; Delete Client</a></li>
                        </div>
                    </ul>
            </li>
  </ul>
    <br>
    <?php
                     $smssent= filter_input(INPUT_GET, 'smssent', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($smssent)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-envelope fa-lg\"></i> Success:</strong> SMS sent!</div>");
                                                }
                                                
                                                email_sent_catch();
                                                    ?>                                           
                                                
  <br>
  
  
<div class="tab-content">
    

<div id="home" class="tab-pane fade in active">
<div class="container">
	
<form class="AddClient">


<div class="col-md-4">

<h3><span class="label label-primary">Client Details (1)</span></h3>
<br>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $data2[title]?> <?php echo $data2[firstname]?> <?php echo $data2[middlename]?> <?php echo $data2[surname]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>

<?php if(empty($data2[dob])) { } else { ?>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $data2[dob]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2[smoker])) { } else { ?>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob" name="smoker" value="<?php echo "Smoker? $data2[smoker]"?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Smoker"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2[home_email])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="email" id="email" name="email" value="<?php echo $data2[home_email]?>"  disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2[office_email])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="email" id="email" name="email" value="<?php echo $data2[office_email]?>"  disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2[DaytimeTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="phonenumber" name="phonenumber" value="<?php echo $data2[DaytimeTel]?>" disabled >
   <span class="input-group-btn">
       <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
   </span>
</div>
</p>
<?php } 
if(empty($data2[EveningTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $data2[EveningTel]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-toggle="modal" data-target="#smsModal" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2[MobileTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $data2[MobileTel]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-toggle="modal" data-target="#smsModal" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2['Client_telephone'])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $data2[Client_telephone]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-toggle="modal" data-target="#smsModal" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>
<?php } ?>

<br>
<br>
<br>
<br>
<br>

<br>
</div>

<div class="col-md-4">
<?php if (empty($tworesult['firstname'])) { } else{ ?>
<h3><span class="label label-primary">Client Details (2)</span></h3>
<br>

<p>
<div class="input-group">
   <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo $tworesult[title]?> <?php echo $tworesult[firstname]?> <?php echo $tworesult[middlename]?> <?php echo $tworesult[surname]?>"  disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
   </span>
</div>
</p>
<?php 
if(empty($tworesult[dob])) { } else { ?>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob2" name="dob2" value="<?php echo $tworesult[dob]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[smoker])) { } else { ?>
<p>
<div class="input-group">
   <input type="text" class="form-control" id="dob" name="smoker" value="<?php echo "Smoker? $tworesult[smoker]"?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Smoker"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[home_email])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $tworesult[home_email]?>"  disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#ALTemail1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[work_email])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $tworesult[work_email]?>"  disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#ALTemail1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[DaytimeTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="phonenumber" name="phonenumber" value="<?php echo $tworesult[DaytimeTel]?>" disabled >
   <span class="input-group-btn">
       <button type="button" data-toggle="modal" data-target="#ALTsmsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[EveningTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $tworesult[EveningTel]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#ALTsmsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[MobileTel])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $tworesult[MobileTel]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#ALTsmsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($tworesult[Client_telephone])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="tel" id="altnumber" name="altnumber" value="<?php echo $tworesult[Client_telephone]?>" disabled >
   <span class="input-group-btn">
                <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#ALTsmsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>
   </span>
</div>
</p>


<?php  } }?>
	</div>

	<div class="col-md-4">


<h3><span class="label label-primary">Contact Details</span></h3>
<br>

<?php if(empty($data2['address1'])) { } else { ?>

<div class="input-group">
   <input class="form-control" type="text" id="address1" name="address1" value="<?php echo $data2[address1]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2['address2'])) { } else {?>
<p>
<div class="input-group">
   <input class="form-control" type="text" id="address2" name="address2" value="<?php echo $data2[address2]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2['address3'])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="text" id="address3" name="address3" value="<?php echo $data2[address3]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2['address4'])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="text" id="town" name="town" value="<?php echo $data2[address4]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>
<?php } 
if(empty($data2['postcode'])) { } else { ?>
<p>
<div class="input-group">
   <input class="form-control" type="text" id="postcode" name="postcode" value="<?php echo $data2[postcode]?>" disabled >
   <span class="input-group-btn">
        <a href="#" data-toggle="tooltip" data-placement="right" title="Post Code"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
   </span>
</div>
</p>
<?php } ?>
<br>
</form>


    

</div>


</div>

<?php

$query = $pdo->prepare("select assura_client_policy.ref_id, assura_ews_data.ews_id, assura_ews_data.color_status, assura_ews_data.ews_status, assura_ews_data.policy_number from assura_ews_data JOIN assura_client_policy on assura_ews_data.ref_id = assura_client_policy.ref_id JOIN assura_client_details on assura_client_details.client_id = assura_client_policy.ref_id WHERE assura_client_details.client_id = :searchholder GROUP BY assura_ews_data.policy_number");
$query->bindParam(':searchholder', $search, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover\">";

echo 
	"<thead>
	<tr>
        <th>id</th>
	<th>Policy #</th>
        <th></th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

	echo '<tr>';
        echo "<td>".$result['ews_id']."</td>";
        echo "<td>".$result['policy_number']."</td>";
        echo "<td><form action='../php/ewsclientnotessubmit.php?Legacy=1' method='POST' autocomplete='off'>
<select class='hook_to_change_colour' name='status' id='status' onchange='' required>
<option value='$result[ews_status]'>$result[ews_status]</option>
<option value='Sale'>Sale</option>
<option value='No Number'>No Number</option>
<option value='No Policy Info'>No Policy Info</option>
<option value='Not Interested'>Not Interested</option>
<option value='Hang Up'>Hang Up</option>
<option value='No Answer'>No Answer</option>
<option value='Callback'>Callback</option>
<option value='Work Number'>Work Number</option>
<option value='Decline'>Decline</option>
<option value='Underwritten'>Underwritten</option>
<option value='Dead Number'>Dead Number</option>
<option value='Dead Beat'>Dead Beat</option>
<option value='Dead Cant Beat'>Dead Cant Beat</option>
<option value='Invalid Number'>Invalid Number</option>
<option value='Email Sent'>Email Sent</option>
<option value='Email quote beat'>Email quote beat</option>
<option value='Email quote cant beat'>Email quote cant beat</option>
<option value='Dead Email'>Dead Email</option>
<option value='Cant Beat'>Cant Beat</option>
<option value='Wrong Number'>Wrong Number</option>
</select></td>";
echo "<td>
<select class='colour_hook' name='colour' id='colour' required>
<option value='$result[color_status]' style='background-color:$result[color_status];'>$result[color_status]</option>
<option value='green' style='background-color:green;'>Sale</option>

<option value='DarkBlue' style='background-color:DarkBlue;'>Not Interested</option>
<option value='DarkBlue' style='background-color:DarkBlue;'>No Answer</option>
<option value='DarkBlue' style='background-color:DarkBlue;'>Hang Up</option>

<option value='purple' style='background-color:purple;'>Callback</option>
<option value='purple' style='background-color:purple;'>Work Number</option>
<option value='purple' style='background-color:purple;'>Email Sent</option>

<option value='Orange' style='background-color:Orange;'>Cant Beat</option>
<option value='Orange' style='background-color:Orange;'>Underwritten</option>
<option value='Orange' style='background-color:Orange;'>Decline</option>

<option value='red' style='background-color:red;'>Invalid Number</option>
<option value='red' style='background-color:red;'>No Policy Info</option>
<option value='red' style='background-color:red;'>Wrong Number</option>
<option value='red' style='background-color:red;'>Dead Number</option>
<option value='red' style='background-color:red;'>Dead Beat</option>
<option value='red' style='background-color:red;'>Dead Cant Beat</option>
<option value='red' style='background-color:red;'>Dead Email</option>
<option value='red' style='background-color:red;'>No Number</option>
<option value='red' style='background-color:red;'>Wrong Number</option>
</select></td>";

echo"<input type='hidden' name='client_id' value='$result[ref_id]'>
<input type='hidden' name='policy_number' value='$result[policy_number]'>
<td><textarea name='notes' id='notes' rows='15' cols='85' placeholder='Add Notes Here' required></textarea></td>";

echo"<td><button type='submit' class='btn btn-primary '><span class='glyphicon glyphicon-plus'></span> Add Notes</button>

</form>
</td>";
	echo "</tr>";
}
} else {
	echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
}
	echo "</table>";



$query = $pdo->prepare("SELECT id, provider_created,policy_number,created_date,commisson_status,product,gender,title,first,last,life_sum_assured,life_term,premium,term_assurance_type,cic_sum_assured,cic_term,phi_sum_assured,phi_age_until,phi_term,fib_sum_assured,fib_age_until,fib_term,premium,description,product_cat,provider2,commission_type FROM assura_client_policy WHERE ref_id = :searchholder");
$query->bindParam(':searchholder', $search, PDO::PARAM_STR, 12);

echo "<table class=\"table table-hover\">";

echo 
	"<thead>
	<tr>
        <th>Ref</th>
	<th>Client</th>
        <th>Provider</th>
	<th>Policy #</th>
	<th>Created Date</th>
	<th>Commission Status</th>
	<th>Product</th>
	<th>Gender</th>
        <th>Life Sum Assured</th>
        <th>Life Term</th>
        <th>Premium</th>
        <th>Term Assurance Type</th>
        <th>CIC Sum Assured</th>
        <th>CIC Term</th>
        <th>PHI Sum Assured</th>
        <th>PHI Age Until</th>
        <th>PHI Term</th>
        <th>Premium</th>
        <th>Description</th>
        <th>Provider Cat</th>
        <th>Commission Type</th>
	</tr>
	</thead>";

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

	echo '<tr>';
        echo "<td>".$result['id']."</td>";
	echo "<td>".$result['title']." ".$result['first']." ".$result['last']."</td>";
        echo "<td>".$result['provider_created']."</td>";
	echo "<td>".$result['policy_number']."</td>";
        echo "<td>".$result['created_date']."</td>";
        echo "<td>".$result['commission_status']."</td>";
        echo "<td>".$result['product']."</td>";
        echo "<td>".$result['gender']."</td>";
        echo "<td>".$result['life_sum_assured']."</td>";
        echo "<td>".$result['life_term']."</td>";
        echo "<td>".$result['premium']."</td>";
        echo "<td>".$result['term_assurance_type']."</td>";
        echo "<td>".$result['cic_sum_assured']."</td>";
        echo "<td>".$result['cic_term']."</td>";
        echo "<td>".$result['phi_sum_assured']."</td>";
        echo "<td>".$result['phi_sum_until']."</td>";
        echo "<td>".$result['phi_term']."</td>";
        echo "<td>".$result['premium2']."</td>";
        echo "<td>".$result['description']."</td>";
        echo "<td>".$result['provider_cat']."</td>";
        echo "<td>".$result['provider2']."</td>";
        echo "<td>".$result['commission_type']."</td>";
	echo "</tr>";
}
} else {
	echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
}
	echo "</table>";

?>
</div>

    <div id="menu1" class="tab-pane fade">
        
    <?php
    $query = $pdo->prepare("select client_name, note_type, message, sent_by, date_sent from legacy_client_note where client_id = :searchplaceholder ORDER BY date_sent DESC");
    $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);

	echo "<table class=\"table table-hover\">";
        echo<<<EOF
	<thead>
	<tr>
	<th><h3><span class="label label-info">Client notes</span></h3></th>
	</th>
	<tr>
	<th>Date</th>
	<th>User</th>
	<th>Reference</th>
	<th>Note Type</th>
	<th>Message</th>
	</tr>
	</thead>
EOF;

$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){

	echo '<tr>';
	echo "<td>".$result['date_sent']."</td>";
	echo "<td>".$result['sent_by']."</td>";
	echo "<td>".$result['client_name']."</td>";
	echo "<td>".$result['note_type']."</td>";
	echo "<td>".$result['message']."</td>"; 
	echo "</tr>";
}
} else {
	echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Client notes)</div>";
}
	echo "</table>";

//END

?>
        
        
    </div>


</div>
</div>


<!-- SMS Modal -->
<div id="ALTsmsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send SMS</h4>
      </div>
      <div class="modal-body">
          <?php if ($ffsms=='1') { ?>
    
          
          <form class="AddClient" method="POST">
              <input type="hidden" name="keyfield" value="<?php echo $search?>">
              <div class="form-group">
                  <label for="selectsms">Select SMS:</label>
                  <select class="form-control" name="selectopt">
                      <option value=" ">Select message...</option>
          <?php
          $query = $pdo->prepare("SELECT title from sms_templates");
          $query->execute();
          if ($query->rowCount()>0) {
              while ($smstitles=$query->fetch(PDO::FETCH_ASSOC)){
                  
                  $smstitle=$smstitles['title'];
                  echo "<option value='$smstitle'>$smstitle</option>";
                  
              }
              
              }
              ?>
                  </select>
              </div>
              
              <div class="form-group">
                  <label for="selectsms">Select Number:</label>
                  <select class="form-control" name="phone_number">
                      <option value=" ">Select Number...</option>
                      
                      
          <?php
          
          if(empty($partnersearch)) {} else {
          
          $querysms2 = $pdo->prepare("SELECT DaytimeTel, EveningTel, MobileTel, Client_telephone from assura_client_details where client_id=$partnersearch");
          $querysms2->execute();
          if ($querysms2->rowCount()>0) {
              while ($smsnumber2=$querysms2->fetch(PDO::FETCH_ASSOC)){
                  
                  $numb12=$smsnumber2['DaytimeTel'];
                  $numb22=$smsnumber2['EveningTel'];
                  $numb32=$smsnumber2['MobileTel'];
                  $numb42=$smsnumber2['Client_telephone'];
                 if(empty($numb12)) {  } else {echo "<option value='$numb12'>$numb12</option>";}
                 if(empty($numb22)) {   } else {echo "<option value='$numb22'>$numb22</option>";}
                 if(empty($numb32)) { }  else {echo "<option value='$numb32'>$numb32</option>"; }
                 if(empty($numb42)) {  } else {echo "<option value='$numb42'>$numb42</option>"; }
                  
              }
              
              }
              
          }
              ?>
                      
                  </select>
              </div>
    
              <input type="hidden" id="FullName" name="FullName" value="<?php echo $tworesult[title]?> <?php echo $tworesult[surname]?>">

              <br>
              <br>
              <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-envelope"></span> SEND SMS</button>
          </form>
              <?php } ?>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- START EMAIL BPOP -->
<div id="email1pop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email: <?php echo $data2[title]?> <?php echo $data2[firstname]?> <?php echo $data2[middlename]?> <?php echo $data2[surname]?></i></h4>
            </div>
            <div class="modal-body">
                <?php if($ffclientemails=='1') { ?>
                
                <form class="AddClient" method="post" action="../email/php/ViewClientEmailSend.php?legacy=y" enctype="multipart/form-data">
                    
                    <input type="hidden" name="keyfield" value="<?php echo $search?>">
                    <input type="hidden" name="recipient" value="<?php echo $data2[title]?> <?php echo $data2['surname']?>" readonly>
                    <input type="hidden" name="note_type" value="Email Sent">
                    
                                  <div class="form-group">
                  <label for="selectsms">Select Email:</label>
                  <select class="form-control" name="email">
          <?php
          
                   
          $queryemail = $pdo->prepare("SELECT home_email, office_email from assura_client_details where client_id=$search");
          $queryemail->execute();
          if ($queryemail->rowCount()>0) {
              while ($emailre=$queryemail->fetch(PDO::FETCH_ASSOC)){
                  
                  $em1=$emailre['home_email'];
                  $em2=$emailre['office_email'];

                 if(empty($em1)) {  } else {echo "<option value='$em1'>$em1</option>";}
                 if(empty($em2)) {   } else {echo "<option value='$em2'>$em2</option>";}
                  
              }
              
              }
              
          
              ?>
                  </select>
              </div>
                    
                    <p>
                        <label for="subject">Subject</label>
                        <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                    </p>
                    
                    <p>
                        <label for="Message">Message:</label> <br />
                        <textarea name="message" id="message" rows="15" cols="85"></textarea><br />
                        <label for="attachment1">Add attachment:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        <label for="attachment2">Add attachment 2:</label>
                        <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                        <label for="attachment3">Add attachment 3:</label>
                        <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                        <label for="attachment4">Add attachment 4:</label>
                        <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                        <label for="attachment5">Add attachment 5:</label>
                        <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                        <label for="attachment6">Add attachment 6:</label>
                        <input type="file" name="fileToUpload6" id="fileToUpload6">
                    </p>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
                </form>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span>Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<!-- START ALT EMAIL BPOP -->
<div id="ALTemail1pop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email: <?php echo $tworesult[title]?> <?php echo $tworesult[firstname]?> <?php echo $tworesult[middlename]?> <?php echo $tworesult[surname]?></i></h4>
            </div>
            <div class="modal-body">
                <?php if($ffclientemails=='1') { ?>
                
                <form class="AddClient" method="post" action="../email/php/ViewClientEmailSend.php?legacy=y" enctype="multipart/form-data">
                    
                    <input type="hidden" name="keyfield" value="<?php echo $search?>">
                    <input type="hidden" name="recipient" value="<?php echo $tworesult[title]?> <?php echo $tworesult[surname]?>" readonly>
                    <input type="hidden" name="note_type" value="Email Sent">
                    
                                  <div class="form-group">
                  <label for="selectsms">Select Email:</label>
                  <select class="form-control" name="email">
          <?php
          if(empty($partnersearch)) {} else {
          $queryemail = $pdo->prepare("SELECT home_email, office_email from assura_client_details where client_id=$partnersearch");
          $queryemail->execute();
          if ($queryemail->rowCount()>0) {
              while ($emailre=$queryemail->fetch(PDO::FETCH_ASSOC)){
                  
                  $em1=$emailre['home_email'];
                  $em2=$emailre['office_email'];

                 if(empty($em1)) {  } else {echo "<option value='$em1'>$em1</option>";}
                 if(empty($em2)) {   } else {echo "<option value='$em2'>$em2</option>";}
                  
              }
              
              }
          }
              ?>
                  </select>
              </div>
                    
                    <p>
                        <label for="subject">Subject</label>
                        <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                    </p>
                    
                    <p>
                        <label for="Message">Message:</label> <br />
                        <textarea name="message" id="message" rows="15" cols="85"></textarea><br />
                        <label for="attachment1">Add attachment:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        <label for="attachment2">Add attachment 2:</label>
                        <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                        <label for="attachment3">Add attachment 3:</label>
                        <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                        <label for="attachment4">Add attachment 4:</label>
                        <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                        <label for="attachment5">Add attachment 5:</label>
                        <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                        <label for="attachment6">Add attachment 6:</label>
                        <input type="file" name="fileToUpload6" id="fileToUpload6">
                    </p>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
                </form>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span>Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<!-- SMS Modal -->
<div id="smsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send SMS</h4>
      </div>
      <div class="modal-body">
          <?php if ($ffsms=='1') { ?>
    
          
          <form class="AddClient" method="POST">
              <input type="hidden" name="keyfield" value="<?php echo $search?>">
              <div class="form-group">
                  <label for="selectsms">Select SMS:</label>
                  <select class="form-control" name="selectopt">
                      <option value=" ">Select message...</option>
          <?php
          $query = $pdo->prepare("SELECT title from sms_templates");
          $query->execute();
          if ($query->rowCount()>0) {
              while ($smstitles=$query->fetch(PDO::FETCH_ASSOC)){
                  
                  $smstitle=$smstitles['title'];
                  echo "<option value='$smstitle'>$smstitle</option>";
                  
              }
              
              }
              ?>
                  </select>
              </div>
              
              <div class="form-group">
                  <label for="selectsms">Select Number:</label>
                  <select class="form-control" name="phone_number">
                      <option value=" ">Select Number...</option>
          <?php
          $querysms = $pdo->prepare("SELECT DaytimeTel, EveningTel, MobileTel, Client_telephone from assura_client_details where client_id=$search");
          $querysms->execute();
          if ($querysms->rowCount()>0) {
              while ($smsnumber=$querysms->fetch(PDO::FETCH_ASSOC)){
                  
                  $numb1=$smsnumber['DaytimeTel'];
                  $numb2=$smsnumber['EveningTel'];
                  $numb3=$smsnumber['MobileTel'];
                  $numb4=$smsnumber['Client_telephone'];
                 if(empty($numb1)) {  } else {echo "<option value='$numb1'>$numb1</option>";}
                 if(empty($numb2)) {   } else {echo "<option value='$numb2'>$numb2</option>";}
                 if(empty($numb3)) { }  else {echo "<option value='$numb3'>$numb3</option>"; }
                 if(empty($numb4)) {  } else {echo "<option value='$numb4'>$numb4</option>"; }
                  
              }
              
              }
              ?>
                  </select>
              </div>
    
              <input type="hidden" id="FullName" name="FullName" value="<?php echo $data2[title]?> <?php echo $data2[surname]?>">

              <br>
              <br>
              <button type="submit" class="btn btn-success "><span class="glyphicon glyphicon-envelope"></span> SEND SMS</button>
          </form>
              <?php } ?>
      </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<script>
    $("readonly").keydown(function(e){
        e.preventDefault();
    });
</script>
<script>$('table tr').each(function(){
  $(this).find('th').first().addClass('first');
  $(this).find('th').last().addClass('last');
  $(this).find('td').first().addClass('first');
  $(this).find('td').last().addClass('last');
});

$('table tr').first().addClass('row-first');
$('table tr').last().addClass('row-last');</script>
</body>
</html>
