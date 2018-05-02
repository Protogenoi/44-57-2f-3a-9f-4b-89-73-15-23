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
    $INSURER_ARRAY_ONE=array("Bluestone Protect","The Review Bureau","TRB Archive","TRB Vitality","Vitality","TRB Aviva","Aviva","TRB WOL","One Family","TRB Royal London","Royal London");
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
     
     ?>
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
    
    <?php if(isset($DUPE_CLIENT_EXISTS) && $DUPE_CLIENT_EXISTS==1) { ?>
    
    <div class="notice notice-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> Duplicate address details found<br><br>Existing client name: <?php echo "$first $last"; ?><br> Address: <?php echo "$add1 $post"; ?>.<br><br><a href='/app/Client.php?search=<?php echo $dupeclientid; ?>' class="btn btn-default"><i class='fa fa-eye'> View Client</a></i></div>
        
        <?php } else { ?>
    
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">Add <?php echo $INSURER; ?> Policy <a href='/app/Client.php?search=<?php echo "$lastid";?>'><button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-user"></i> Skip Policy and View Client...</button></a></div>
            <div class="panel-body">
                
                <form class="AddClient" action="/addon/Life/php/AddPolicy.php?EXECUTE=1&CID=<?php echo $lastid;?>" method="POST">
                    
                    <div class="col-md-4">
                        <div class="alert alert-info"><strong>Client Name:</strong> 
                                    Naming one person will create a single policy. Naming two person's will create a joint policy. <br><br>
                                    <select class='form-control' name='client_name' id='client_name' style='width: 170px' required>
                                            <option value="<?php echo $TITLE; ?> <?php echo $first; ?> <?php echo $last; ?>"><?php echo $TITLE; ?> <?php echo $first; ?> <?php echo $last; ?></option>
                                            <?php if (!empty($TITLE2)) { ?>
                                            <option value="<?php echo $TITLE2; ?> <?php echo $first2; ?> <?php echo $last2; ?>"><?php echo $TITLE2; ?> <?php echo $first2; ?> <?php echo $last2; ?></option>
                                            <option value="<?php echo "$TITLE $first $last and $TITLE2 $first2 $last2"; ?>"><?php echo "$TITLE $first $last and $TITLE2 $first2 $last2"; ?></option>
                                            <?php } ?>    
                                    </select>
                                       </div>  
                            
                                    <p>
                                        <label for="application_number">Application Number:</label>
                                        <?php if (isset($INSURER)) { ?>

                                            <input type="text" id="application_number" name="application_number"  class="form-control" style="width: 170px" value="<?php
                                            if ($INSURER == 'One Family' || $INSURER =="TRB WOL") {
                                                echo "WOL";
                                            } if ($INSURER == 'Royal London' || $INSURER =='TRB Royal London') {
                                                echo "Royal London";
                                            }
                                            if ($INSURER == 'Vitality') {
                                                echo "Vitality";
                                            }
                                            if ($INSURER == 'LV') {
                                                echo "LV";
                                            }
                                            ?>" required>
                                               <?php } ?>
                                        <label for="application_number"></label>
                                    </p>
                                    <br>  
                                    
                            <div class="alert alert-info"><strong>Policy Number:</strong> 
                                For Awaiting/TBC polices, leave as TBC. A unique ID will be generated. <br><br> <input type='text' id='policy_number' name='policy_number' class="form-control" autocomplete="off" style="width: 170px" value="TBC">
                            </div>
                                    <br> 
                                    
                                    <p>
                                    <div class="form-group">
                                        <label for="type">Type:</label>
                                        <select class="form-control" name="type" id="type" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="LTA">LTA</option>
                                            <option value="TRB Archive">TRB Archive</option>
                                            <option value="LTA SIC">LTA SIC (Vitality)</option>
                                            <option value="DTA SIC">DTA SIC (Vitality)</option>
                                            <option value="VITALITY WOL">Whole of Life (Vitality)</option>        
                                            <option value="LTA CIC">LTA + CIC</option>
                                            <option value="DTA">DTA</option>
                                            <option value="DTA CIC">DTA + CIC</option>
                                            <option value="CIC">CIC</option>
                                            <option value="FPIP">FPIP</option>
                                            <option value="Income Protection">Income Protection</option>
                                            <option value="WOL">WOL (One Family)</option>
                                        </select>
                                    </div>
                                    </p>

                                    <p>
                                    <div class="form-group">
                                        <label for="insurer">Insurer:</label>
                                        <select class="form-control" name="insurer" id="insurer" style="width: 170px" required>
                                            <option value="">Select...</option>
                                            <option value="Legal and General" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Legal and General' || $INSURER=="Bluestone Protect" || $INSURER=="The Review Bureau" || $INSURER=="TRB Archive") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Legal & General</option>
                                            <option value="Zurich" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Zurich') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Zurich</option>
                                            <option value="LV" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'LV') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>LV</option>
                                            <option value="Scottish Widows" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Scottish Widows') {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Scottish Widows</option>                                               
                                            <option value="Vitality" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Vitality' || $INSURER=="TRB Vitality") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Vitality</option>
                                            <option value="Bright Grey">Bright Grey</option>
                                            <option value="Royal London" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Royal London' || $INSURER=="TRB Royal London") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Royal London</option>
                                            <option value="One Family" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'TRB WOL' || $INSURER=="One Family") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>One Family</option>
                                            <option value="Aviva" <?php
                                            if (isset($INSURER)) {
                                                if ($INSURER == 'Aviva' || $INSURER =="TRB Aviva") {
                                                    echo "selected";
                                                }
                                            }
                                            ?>>Aviva</option>
                                        </select>
                                    </div>
                                    </p>
                                    
                        </div>

                                <div class="col-md-4">

                                    <p>
                                    <div class="form-row">
                                        <label for="premium">Premium:</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($INSURER == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="premium" name="premium" required/>
                                        </div> 
                                        </p>
                                        
                                        <p>
                                        <label for="EXTRA_CHARGE">Extra Charges:</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input value="0" style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency premium value1" id="EXTRA_CHARGE" name="EXTRA_CHARGE" required/>
                                        </div> 
                                        </p>  
                                        
                                                 <p>
                                                <div class="form-group">
                                                    <label for="CommissionType">Comms:</label>
                                                    <select class="form-control" name="CommissionType" id="CommissionType" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <option value="Indemnity">Indemnity</option>
                                                        <option value="Non Idenmity">Non-Idemnity</option>
                                                        <option value="NA" <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>N/A</option>
                                                    </select>
                                                </div>
                                                </p>                                       

                                        <p>

                                            <label for="commission">Commission</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input <?php
                                            if ($INSURER == 'TRB Archive') {
                                                echo "value='0'";
                                            }
                                            ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="commission" name="commission" required/>
                                        </div> 
                                        </p>
                                        
                                        <p>

                                            <label for="NonIndem">Non-Indem Comm</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">£</span>
                                            <input value="0" style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="NonIndem" name="NonIndem" required/>
                                        </div> 
                                        </p>                                        

                                        <p>
                                        <div class="form-row">
                                            <label for="commission">Cover Amount</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">£</span>
                                                <input <?php
                                                if ($INSURER == 'TRB Archive') {
                                                    echo "value='0'";
                                                }
                                                ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="covera" name="covera" required/>
                                            </div> 
                                            </p>


                                            <p>
                                            <div class="form-row">
                                                <label for="commission">Policy Term</label>
                                                <div class="input-group"> 
                                                    <span class="input-group-addon">yrs</span>
                                                    <input <?php
                                                    if ($INSURER == 'TRB Archive') {
                                                        echo "value='0'";
                                                    }
                                                    ?> style="width: 140px" autocomplete="off" type="text" class="form-control" id="polterm" name="polterm" <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL') {
                                                                echo "value='WOL'";
                                                            }
                                                        }
                                                        ?> required/>
                                                </div> 
                                            </div>
                                                </p>

                                                <p>
                                                <div class="form-group">
                                                    <label for="comm_term">Clawback Term:</label>
                                                    <select class="form-control" name="comm_term" id="comm_term" style="width: 170px" required>
                                                        <option value="">Select...</option>
                                                        <?php for ($CB_TERM = 52; $CB_TERM > 11; $CB_TERM = $CB_TERM - 1) {
                                                            if($CB_TERM< 12) {
                                                               break; 
                                                            }
                                                            ?>
                                                        
                                                        <option value="<?php echo $CB_TERM;?>"><?php echo $CB_TERM; ?></option>
                                                        <?php } ?>
                                                        <option value="1 year">1 year</option>
                                                        <option value="2 year">2 year</option>
                                                        <option value="3 year">3 year</option>
                                                        <option value="4 year">4 year</option>
                                                        <option value="5 year">5 year</option>
                                                        <option <?php
                                                        if (isset($INSURER)) {
                                                            if ($INSURER == 'One Family' || $INSURER=='TRB WOL' || $INSURER == 'TRB Archive') {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?> value="0">0</option>
                                                    </select>
                                                </div>
                                                </p>

                                                <p>
                                                <div class="form-row">
                                                    <label for="commission">Drip</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">£</span>
                                                        <input <?php
                                                        if ($INSURER == 'TRB Archive') {
                                                            echo "value='0'";
                                                        }
                                                        ?> style="width: 140px" autocomplete="off" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="drip" name="drip" required/>
                                                    </div> 
                                                </div>
                                                    </p>
                                                    
   <p>
                                                        <label for="closer">Closer:</label>
                                                        <input type='text' id='closer' name='closer' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
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
                                                    <br>

                                                    <p>
                                                        <label for="lead">Lead Gen:</label>
                                                        <input type='text' id='lead' name='lead' style="width: 170px" class="form-control" style="width: 170px" required>
                                                    </p>
                                                    <script>var options = {
                                                            url: "/app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };

                                                        $("#lead").easyAutocomplete(options);
                                                                                                                </script>

                                                </div> 
                                            </div>
                                        </div>
                               
                        <div class="col-md-4">

                            <div class="alert alert-info"><strong>Sale Date:</strong> 
                                This is the sale date on the dealsheet. <br><br> <input type="text" id="submitted_date" name="submitted_date" value="<?php
                                if ($INSURER == 'TRB Archive') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                            </div>   

                            <div class="alert alert-info"><strong>Submitted Date:</strong> 
                                This is the policy live date on the insurers portal. <br> <br><input type="text" id="sale_date" name="sale_date" value="<?php
                                if ($INSURER == 'TRB Archive') {
                                    echo "2013";
                                } else {
                                    echo date('Y-m-d H:i:s');
                                }
                                ?>" placeholder="<?php echo date('Y-m-d H:i:s'); ?>"class="form-control" style="width: 170px" required>
                            </div>   
                            
                            <div class="alert alert-info"><strong>Policy Status:</strong> 
                                For any policy where the submitted date is unknown. The policy status should be Awaiting. <br><br>     <div class="form-group">
                                    <select class="form-control" name="PolicyStatus" id="PolicyStatus" style="width: 170px" required>
                                        <option value="">Select...</option>
                                        <option value="Live">Live</option>
                                        <option value="Awaiting">Awaiting</option>
                                        <option value="Not Live">Not Live</option>
                                        <option value="NTU">NTU</option>
                                        <option value="Declined">Declined</option>
                                        <option value="Redrawn">Redrawn</option>
                                        <option value="On Hold">On Hold</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Policy</button>
                        
                        </div>
                    
                    </form>
</div>
</div>
</div>              
<?php } ?>
</div>
</body>
</html>