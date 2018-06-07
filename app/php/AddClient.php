<?php 
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
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
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
    
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');   

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 
require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}
    
        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        
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
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }    
    
    $INSURER= filter_input(INPUT_POST, 'custype', FILTER_SANITIZE_SPECIAL_CHARS);
    $INSURER_ARRAY_ONE=array("Vitality","Aviva","One Family","Royal London");
    
    
        $TITLE= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $first= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $last= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
        $email= filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone= filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_NUMBER_INT);
        $alt= filter_input(INPUT_POST, 'alt_number', FILTER_SANITIZE_NUMBER_INT);
        $TITLE2= filter_input(INPUT_POST, 'title2', FILTER_SANITIZE_SPECIAL_CHARS);
        $first2= filter_input(INPUT_POST, 'first_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $last2= filter_input(INPUT_POST, 'last_name2', FILTER_SANITIZE_SPECIAL_CHARS);
        $dob2= filter_input(INPUT_POST, 'dob2', FILTER_SANITIZE_SPECIAL_CHARS);
        $email2= filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL);
        $add1= filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
        $add2= filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
        $add3= filter_input(INPUT_POST, 'address3', FILTER_SANITIZE_SPECIAL_CHARS);
        $town= filter_input(INPUT_POST, 'town', FILTER_SANITIZE_SPECIAL_CHARS);
        $post= filter_input(INPUT_POST, 'post_code', FILTER_SANITIZE_SPECIAL_CHARS);
        
        $TITLE_ARRAY=array("Mr","Dr","Miss","Ms","Mrs","Other");
        
        if(!in_array($TITLE,$TITLE_ARRAY)) {
            $TITLE="Other";
        }
        
        if(!empty($TITLE2)) {
        if(!in_array($TITLE2,$TITLE_ARRAY)) {
            $TITLE2="Other";
        }            
        }
        
        $correct_dob = date("Y-m-d" , strtotime($dob)); 
        if(!empty($dob2)) {
        $correct_dob2 = date("Y-m-d" , strtotime($dob2));
        }
        else {
          $correct_dob2="NA";  
        }
        $database = new Database(); 
        $database->beginTransaction();
        
        $database->query("Select client_id, first_name, last_name FROM client_details WHERE post_code=:post AND address1 =:add1 AND company=:company AND owner=:OWNER");
        $database->bind(':OWNER', $COMPANY_ENTITY);
        $database->bind(':company', $INSURER);
        $database->bind(':post', $post);
        $database->bind(':add1',$add1);
        $database->execute();
        
        if ($database->rowCount()>=1) {
            $row = $database->single();
            
            $dupeclientid=$row['client_id'];
            
            $DUPE_CLIENT_EXISTS=1;
            
        }
        
        if(empty($DUPE_CLIENT_EXISTS)) {
            
            $database->query("INSERT into client_details set owner=:OWNER, company=:company, title=:title, first_name=:first, last_name=:last, dob=:dob, email=:email, phone_number=:phone, alt_number=:alt, title2=:title2, first_name2=:first2, last_name2=:last2, dob2=:dob2, email2=:email2, address1=:add1, address2=:add2, address3=:add3, town=:town, post_code=:post, submitted_by=:hello, recent_edit=:hello2");
            $database->bind(':OWNER', $COMPANY_ENTITY);
            $database->bind(':company', $INSURER);
            $database->bind(':title', $TITLE);
            $database->bind(':first',$first);
            $database->bind(':last',$last);
            $database->bind(':dob',$correct_dob);
            $database->bind(':email',$email);
            $database->bind(':phone',$phone);
            $database->bind(':alt',$alt);
            $database->bind(':title2', $TITLE2);
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
                $INSURERnamedata= $TITLE ." ". $first ." ". $last;
                $messagedata="Client Uploaded";
                
                $database->query("INSERT INTO client_note set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");
                $database->bind(':clientidholder',$lastid);
                $database->bind(':sentbyholder',$hello_name);
                $database->bind(':recipientholder',$INSURERnamedata);
                $database->bind(':noteholder',$notedata);
                $database->bind(':messageholder',$messagedata);
                $database->execute();                       
                
                
        
        
     }  
     
        }
     $database->endTransaction();
     
     if($INSURER == 'Home Insurance') {
         
          header('Location: /../../app/Client.php?search='.$lastid);
        die;        
         
     }
     
 if(isset($DUPE_CLIENT_EXISTS) && $DUPE_CLIENT_EXISTS==1) { ?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Add Client Policy</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
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
  $(function() {
    $( "#submitted_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:+1"
        });
</script>
    
    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="container">

    
    <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: <?php echo "$first $last"; ?><br> Address: <?php echo "$add1 $post"; ?>.<br><br><a href='/app/Client.php?search=<?php echo $dupeclientid; ?>' class="btn btn-default"><i class='fa fa-eye'> View Client</a></i></div>

        
</div>
</body>
</html>
    <?php   }  else { 
            
            header('Location: ../Client.php?CLIENT=ADDED&search='.$lastid); die;
            
            
        } 
            
            ?>