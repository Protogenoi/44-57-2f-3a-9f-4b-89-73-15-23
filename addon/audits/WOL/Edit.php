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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
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
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);  

if(isset($EXECUTE)) {
    if($EXECUTE=='Edit') {
        $WOLID= filter_input(INPUT_GET, 'WOLID', FILTER_SANITIZE_NUMBER_INT);
        
    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT added_date, added_by, grade, closer, closer2, policy_number FROM audit_wol WHERE wol_id =:WOLID");
    $database->bind(':WOLID', $WOLID);
    $database->execute();
    $WOL_AUDIT=$database->single();
    
    $database->query("SELECT q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,q13,q14,q15,q16,q17,q18,q19,q20,q21,q22,q23,q24,q25,q26,q27,q28,q29,q30,q31,q32,q33,q34,q35,q36 FROM audit_wol_questions WHERE wol_id =:WOLID");
    $database->bind(':WOLID', $WOLID);
    $database->execute();
    $WOL_QUEST=$database->single();
    
    if(isset($WOL_QUEST['q1'])) {
        $q1=$WOL_QUEST['q1'];
        }
    if(isset($WOL_QUEST['q2'])) {
        $q2=$WOL_QUEST['q2'];
        }
            if(isset($WOL_QUEST['q3'])) {
        $q3=$WOL_QUEST['q3'];
        }
            if(isset($WOL_QUEST['q4'])) {
        $q4=$WOL_QUEST['q4'];
        }
            if(isset($WOL_QUEST['q5'])) {
        $q5=$WOL_QUEST['q5'];
        }
            if(isset($WOL_QUEST['q6'])) {
        $q6=$WOL_QUEST['q6'];
        }
            if(isset($WOL_QUEST['q7'])) {
        $q7=$WOL_QUEST['q7'];
        }
            if(isset($WOL_QUEST['q8'])) {
        $q8=$WOL_QUEST['q8'];
        }
            if(isset($WOL_QUEST['q9'])) {
        $q9=$WOL_QUEST['q9'];
        }
            if(isset($WOL_QUEST['q10'])) {
        $q10=$WOL_QUEST['q10'];
        }
            if(isset($WOL_QUEST['q11'])) {
        $q11=$WOL_QUEST['q11'];
        }
            if(isset($WOL_QUEST['q12'])) {
        $q12=$WOL_QUEST['q12'];
        }
            if(isset($WOL_QUEST['q13'])) {
        $q13=$WOL_QUEST['q13'];
        }
            if(isset($WOL_QUEST['q14'])) {
        $q14=$WOL_QUEST['q14'];
        }
            if(isset($WOL_QUEST['q15'])) {
        $q15=$WOL_QUEST['q15'];
        }
            if(isset($WOL_QUEST['q16'])) {
        $q16=$WOL_QUEST['q16'];
        }
            if(isset($WOL_QUEST['q17'])) {
        $q17=$WOL_QUEST['q17'];
        }
            if(isset($WOL_QUEST['q18'])) {
        $q18=$WOL_QUEST['q18'];
        }
            if(isset($WOL_QUEST['q19'])) {
        $q19=$WOL_QUEST['q19'];
        }
            if(isset($WOL_QUEST['q20'])) {
        $q20=$WOL_QUEST['q20'];
        }
            if(isset($WOL_QUEST['q21'])) {
        $q21=$WOL_QUEST['q21'];
        }
            if(isset($WOL_QUEST['q22'])) {
        $q22=$WOL_QUEST['q22'];
        }
            if(isset($WOL_QUEST['q23'])) {
        $q23=$WOL_QUEST['q23'];
        }
            if(isset($WOL_QUEST['q24'])) {
        $q24=$WOL_QUEST['q24'];
        }
            if(isset($WOL_QUEST['q25'])) {
        $q25=$WOL_QUEST['q25'];
        }
            if(isset($WOL_QUEST['q26'])) {
        $q26=$WOL_QUEST['q26'];
        }
            if(isset($WOL_QUEST['q27'])) {
        $q27=$WOL_QUEST['q27'];
        }
            if(isset($WOL_QUEST['q28'])) {
        $q28=$WOL_QUEST['q28'];
        }
            if(isset($WOL_QUEST['q29'])) {
        $q29=$WOL_QUEST['q29'];
        }
            if(isset($WOL_QUEST['q30'])) {
        $q30=$WOL_QUEST['q30'];
        }
            if(isset($WOL_QUEST['q31'])) {
        $q31=$WOL_QUEST['q31'];
        }
            if(isset($WOL_QUEST['q32'])) {
        $q32=$WOL_QUEST['q32'];
        }
            if(isset($WOL_QUEST['q33'])) {
        $q33=$WOL_QUEST['q33'];
        }
            if(isset($WOL_QUEST['q34'])) {
        $q34=$WOL_QUEST['q34'];
        }
            if(isset($WOL_QUEST['q35'])) {
        $q35=$WOL_QUEST['q35'];
        }
            if(isset($WOL_QUEST['q36'])) {
        $q36=$WOL_QUEST['q36'];
        }

    $database->query("SELECT c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,c33,c34,c35,c36 FROM audit_wol_comments WHERE wol_id =:WOLID");
    $database->bind(':WOLID', $WOLID);
    $database->execute();
    $WOL_COMM=$database->single();        
        
    if(isset($WOL_COMM['c1'])) {
        $c1=$WOL_COMM['c1'];
        }
    if(isset($WOL_COMM['c2'])) {
        $c2=$WOL_COMM['c2'];
        }
            if(isset($WOL_COMM['c3'])) {
        $c3=$WOL_COMM['c3'];
        }
            if(isset($WOL_COMM['c4'])) {
        $c4=$WOL_COMM['c4'];
        }
            if(isset($WOL_COMM['c5'])) {
        $c5=$WOL_COMM['c5'];
        }
            if(isset($WOL_COMM['c6'])) {
        $c6=$WOL_COMM['c6'];
        }
            if(isset($WOL_COMM['c7'])) {
        $c7=$WOL_COMM['c7'];
        }
            if(isset($WOL_COMM['c8'])) {
        $c8=$WOL_COMM['c8'];
        }
            if(isset($WOL_COMM['c9'])) {
        $c9=$WOL_COMM['c9'];
        }
            if(isset($WOL_COMM['c10'])) {
        $c10=$WOL_COMM['c10'];
        }
            if(isset($WOL_COMM['c11'])) {
        $c11=$WOL_COMM['c11'];
        }
            if(isset($WOL_COMM['c12'])) {
        $c12=$WOL_COMM['c12'];
        }
            if(isset($WOL_COMM['c13'])) {
        $c13=$WOL_COMM['c13'];
        }
            if(isset($WOL_COMM['c14'])) {
        $c14=$WOL_COMM['c14'];
        }
            if(isset($WOL_COMM['c15'])) {
        $c15=$WOL_COMM['c15'];
        }
            if(isset($WOL_COMM['c16'])) {
        $c16=$WOL_COMM['c16'];
        }
            if(isset($WOL_COMM['c17'])) {
        $c17=$WOL_COMM['c17'];
        }
            if(isset($WOL_COMM['c18'])) {
        $c18=$WOL_COMM['c18'];
        }
            if(isset($WOL_COMM['c19'])) {
        $c19=$WOL_COMM['c19'];
        }
            if(isset($WOL_COMM['c20'])) {
        $c20=$WOL_COMM['c20'];
        }
            if(isset($WOL_COMM['c21'])) {
        $c21=$WOL_COMM['c21'];
        }
            if(isset($WOL_COMM['c22'])) {
        $c22=$WOL_COMM['c22'];
        }
            if(isset($WOL_COMM['c23'])) {
        $c23=$WOL_COMM['c23'];
        }
            if(isset($WOL_COMM['c24'])) {
        $c24=$WOL_COMM['c24'];
        }
            if(isset($WOL_COMM['c25'])) {
        $c25=$WOL_COMM['c25'];
        }
            if(isset($WOL_COMM['c26'])) {
        $c26=$WOL_COMM['c26'];
        }
            if(isset($WOL_COMM['c27'])) {
        $c27=$WOL_COMM['c27'];
        }
            if(isset($WOL_COMM['c28'])) {
        $c28=$WOL_COMM['c28'];
        }
            if(isset($WOL_COMM['c29'])) {
        $c29=$WOL_COMM['c29'];
        }
            if(isset($WOL_COMM['c30'])) {
        $c30=$WOL_COMM['c30'];
        }
            if(isset($WOL_COMM['c31'])) {
        $c31=$WOL_COMM['c31'];
        }
            if(isset($WOL_COMM['c32'])) {
        $c32=$WOL_COMM['c32'];
        }
            if(isset($WOL_COMM['c33'])) {
        $c33=$WOL_COMM['c33'];
        }
            if(isset($WOL_COMM['c34'])) {
        $c34=$WOL_COMM['c34'];
        }
            if(isset($WOL_COMM['c35'])) {
        $c35=$WOL_COMM['c35'];
        }
            if(isset($WOL_COMM['c36'])) {
        $c36=$WOL_COMM['c36'];
        }        
        
    $database->endTransaction();
       
       if(isset($WOL_AUDIT['grade'])) {
           $GRADE=$WOL_AUDIT['grade'];
       }
       if(isset($WOL_AUDIT['added_by'])) {
           $added_by=$WOL_AUDIT['added_by'];
       }
       if(isset($WOL_AUDIT['closer'])) {
           $CLOSER=$WOL_AUDIT['closer'];
       }
       if(isset($WOL_AUDIT['closer2'])) {
           $CLOSER2=$WOL_AUDIT['closer2'];
       }
       if(isset($WOL_AUDIT['policy_number'])) {
           $policy_number=$WOL_AUDIT['policy_number'];
       }
       if(isset($WOL_AUDIT['added_date'])) {
           $added_date=$WOL_AUDIT['added_date'];
       }
           
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Edit WOL Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/audit_layout.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />

<script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script>
<script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25+o.scrollHeight)+"px";
}
</script>

<?php require_once(__DIR__ . '/../../../app/Holidays.php'); ?>
</head>
<body>

<?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>    
    
    <div class="container" id="form-content">
        <form method="POST" autocomplete="off" id="WOL_FORM">
            <fieldset>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-headphones"></i> WOL Call Audit</h3>
                    </div>
                    
                    <div class="panel-body">
                        
                        <div class='form-group'>
                            <label for='closer'>Closer:</label>
                             <input type='text' id='closer' name='closer' class="form-control" value="<?php if(isset($VIT_CLOSER)) { echo $VIT_CLOSER; } ?>" style="width: 520px" required>
                                    <script>var options = {
                                            url: "/../../../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                            getValue: "full_name",
                                            list: {
                                                match: {
                                                    enabled: true
                                                }
                                            }
                                        };

                                        $("#closer").easyAutocomplete(options);</script>
                        </div>
                        
                        <div class='form-group'>
                            <label for='closer2'>Closer (optional):</label>
                            <select class='form-control' name='closer2' id='closer2' > 
                                <option value="None">None</option> 
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Carys") { echo "selected"; }  ?> value="Carys">Carys</option>
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="James") { echo "selected"; }  ?> value="James">James</option>
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Kyle") { echo "selected"; }  ?> value="Kyle">Kyle</option>  
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Mike") { echo "selected"; }  ?> value="Mike">Mike</option> 
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Richard") { echo "selected"; }  ?> value="Richard">Richard</option>
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Sarah") { echo "selected"; }  ?> value="Sarah">Sarah</option> 
                                    <option <?php if(isset($CLOSER2) && $CLOSER2=="Nicola") { echo "selected"; }  ?> value="Nicola">Nicola</option> 
                            </select>
                        </div>
                        
                        <label for="policy_number">Reference ID</label>
                        <input type="text" class="form-control" name="policy_number" value="<?php if(isset($policy_number)) { echo $policy_number; } ?>" style="width: 520px" required>
                        
                        <div class="form-group">
                            <label for='grade'>Grade:</label>
                            <select class="form-control" name="grade" required>
                                <option value="">Select...</option>
                                <option <?php if(isset($GRADE) && $GRADE=="SAVED") { echo "selected"; }  ?> value="SAVED">Incomplete Audit (SAVE)</option>
                                <option <?php if(isset($GRADE) && $GRADE=="Green") { echo "selected"; }  ?> value="Green">Green</option>
                                <option <?php if(isset($GRADE) && $GRADE=="Amber") { echo "selected"; }  ?> value="Amber">Amber</option>
                                <option <?php if(isset($GRADE) && $GRADE=="Red") { echo "selected"; }  ?> value="Red">Red</option>
                            </select>
                        </div>
                        
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Opening Declaration</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q1">Q1. Was the customer made aware that calls are recorded for training and quality purposes?</label>
                        <input type="radio" name="q1" <?php if (isset($q1) && $q1=="1") { echo  "checked"; }?> onclick="javascript:yesnoCheckc1();" value="1" id="yesCheckc1">Yes
                        <input type="radio" name="q1" <?php if (isset($q1) && $q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc1();" value="0" id="noCheckc1">No
                        
                        <div id="ifYesc1" style="display:<?php if(isset($c1)) { echo "block"; } else {  echo "none"; } ?> ">
                            <textarea class="form-control"id="c1" name="c1" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c1)) { echo $c1; } ?></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft1').text('400 characters left');
    $('#c1').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft1').text('You have reached the limit');
            $('#characterLeft1').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft1').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft1').removeClass('red');            
        }
    });    
});

    function yesnoCheckc1() {
    if (document.getElementById('yesCheckc1').checked) {
        document.getElementById('ifYesc1').style.display = 'none';
    }
    else document.getElementById('ifYesc1').style.display = 'block';

}
                        </script>
                        
                        <label for="q2">Q2. Was the customer informed that general insurance is regulated by the FCA?</label>
                        <input type="radio" name="q2" <?php if (isset($q2) && $q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc2();" value="1" id="yesCheckc2">Yes
                        <input type="radio" name="q2" <?php if (isset($q2) && $q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc2();" value="0" id="noCheckc2">No
                        
                        <div id="ifYesc2" style="display:<?php if(isset($c2)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c2" name="c2" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c2)) { echo $c2; } ?></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft2').text('400 characters left');
    $('#c2').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft2').text('You have reached the limit');
            $('#characterLeft2').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft2').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft2').removeClass('red');            
        }
    });    
});

function yesnoCheckc2() {
    if (document.getElementById('yesCheckc2').checked) {
        document.getElementById('ifYesc2').style.display = 'none';
    }
    else document.getElementById('ifYesc2').style.display = 'block';

}
                        </script>
                        
                        <label for="q3">Q3. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
                        <input type="radio" name="q3" <?php if (isset($q3) && $q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc3();" value="1" id="yesCheckc3">Yes
                        <input type="radio" name="q3" <?php if (isset($q3) && $q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc3();" value="0" id="noCheckc3">No
                        
                        <div id="ifYesc3" style="display:<?php if(isset($c3)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c3" name="c3" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c3)) { echo $c3; } ?></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft3').text('400 characters left');
    $('#c3').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft3').text('You have reached the limit');
            $('#characterLeft3').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft3').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft3').removeClass('red');            
        }
    });    
});
                      
function yesnoCheckc3() {
    if (document.getElementById('yesCheckc3').checked) {
        document.getElementById('ifYesc3').style.display = 'none';
    }
    else document.getElementById('ifYesc3').style.display = 'block';

}
                        </script>
                        
                        <label for="q4">Q4. Did the closer provide the name and details of the firm who is regulated by the FCA?</label>
                        <input type="radio" name="q4" <?php if (isset($q4) && $q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc4();" value="1" id="yesCheckc4">Yes
                        <input type="radio" name="q4" <?php if (isset($q4) && $q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc4();" value="0" id="noCheckc4">No
                        
                        <div id="ifYesc4" style="display:<?php if(isset($c4)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c4" name="c4" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c4)) { echo $c4; } ?></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft4').text('400 characters left');
    $('#c4').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft4').text('You have reached the limit');
            $('#characterLeft4').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft4').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft4').removeClass('red');            
        }
    });    
});

function yesnoCheckc4() {
    if (document.getElementById('yesCheckc4').checked) {
        document.getElementById('ifYesc4').style.display = 'none';
    }
    else document.getElementById('ifYesc4').style.display = 'block';

}
                        </script>
                        
                        <label for="q5">Q5. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
                        <input type="radio" name="q5" <?php if (isset($q5) && $q5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc5();" value="1" id="yesCheckc5">Yes
                        <input type="radio" name="q5" <?php if (isset($q5) && $q5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc5();" value="0" id="noCheckc5">No
                        
                        <div id="ifYesc5" style="display:<?php if(isset($c5)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c5" name="c5" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c5)) { echo $c5; } ?></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft5').text('400 characters left');
    $('#c5').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft5').text('You have reached the limit');
            $('#characterLeft5').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft5').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft5').removeClass('red');            
        }
    });    
});

function yesnoCheckc5() {
    if (document.getElementById('yesCheckc5').checked) {
        document.getElementById('ifYesc5').style.display = 'none';
    }
    else document.getElementById('ifYesc5').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q6">Q6. Were all clients titles and names recorded correctly?</label>
                        <input type="radio" name="q6" <?php if (isset($q6) && $q6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc6();" value="1" id="yesCheckc6">Yes
                        <input type="radio" name="q6" <?php if (isset($q6) && $q6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc6();" value="0" id="noCheckc6">No
                        
                        <div id="ifYesc6" style="display:<?php if(isset($c6)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c6" name="c6" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c6)) { echo $c6; } ?></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft6').text('400 characters left');
    $('#c6').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft6').text('You have reached the limit');
            $('#characterLeft6').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft6').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft6').removeClass('red');            
        }
    });    
});

function yesnoCheckc6() {
    if (document.getElementById('yesCheckc6').checked) {
        document.getElementById('ifYesc6').style.display = 'none';
    }
    else document.getElementById('ifYesc6').style.display = 'block';

}
                        </script>
                        
                        <label for="q7">Q7. Was the clients gender accurately recorded?</label>
                        <input type="radio" name="q7"  <?php if (isset($q7) && $q7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc7();" value="1" id="yesCheckc7">Yes
                        <input type="radio" name="q7" <?php if (isset($q7) && $q7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc7();" value="0" id="noCheckc7">No
                        
                        <div id="ifYesc7" style="display:<?php if(isset($c7)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c7" name="c7" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c7)) { echo $c7; } ?></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft7').text('400 characters left');
    $('#c7').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft7').text('You have reached the limit');
            $('#characterLeft7').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft7').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft7').removeClass('red');            
        }
    });    
});

function yesnoCheckc7() {
    if (document.getElementById('yesCheckc7').checked) {
        document.getElementById('ifYesc7').style.display = 'none';
    }
    else document.getElementById('ifYesc7').style.display = 'block';

}
                        </script>
                        
                        <label for="q8">Q8. Was the clients date of birth accurately recorded?</label>
                        <input type="radio" name="q8" onclick="javascript:yesnoCheck();" <?php if (isset($q8) && $q8=="1") { echo "checked"; } ?> value="1" id="yesCheck">Yes
                        <input type="radio" name="q8" onclick="javascript:yesnoCheck();" <?php if (isset($q8) && $q8=="0") { echo "checked"; } ?> value="0" id="noCheck">No
                        
                        <div id="ifYes" style="display:<?php if(isset($c8)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c8" name="c8" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c8)) { echo $c8; } ?></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft8').text('400 characters left');
    $('#c8').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft8').text('You have reached the limit');
            $('#characterLeft8').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft8').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft8').removeClass('red');            
        }
    });    
});

function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'none';
    }
    else document.getElementById('ifYes').style.display = 'block';

}
                        </script>
                        
                        <label for="q9">Q9. Was the clients smoking status recorded correctly?</label>
                        <input type="radio" name="q9" <?php if (isset($q9) && $q9=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc9();" value="1" id="yesCheckc9">Yes
                        <input type="radio" name="q9" <?php if (isset($q9) && $q9=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc9();" value="0" id="noCheckc9">No
                        
                        <div id="ifYesc9" style="display:<?php if(isset($c9)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c9" name="c9" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c9)) { echo $c9; } ?></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft9').text('400 characters left');
    $('#c9').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft9').text('You have reached the limit');
            $('#characterLeft9').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft9').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft9').removeClass('red');            
        }
    });    
});

function yesnoCheckc9() {
    if (document.getElementById('yesCheckc9').checked) {
        document.getElementById('ifYesc9').style.display = 'none';
    }
    else document.getElementById('ifYesc9').style.display = 'block';

}
                        </script>
                        
                        <label for="q10">Q10. Did the closer confirm the policy was a single or a joint application?</label>
                        <input type="radio" name="q10" <?php if (isset($q10) && $q10=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc10();" value="1" id="yesCheckc10">Yes
                        <input type="radio" name="q10" <?php if (isset($q10) && $q10=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc10();" value="0" id="noCheckc10">No
                        
                        <div id="ifYesc10" style="display:<?php if(isset($c10)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c10" name="c10" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c10)) { echo $c10; } ?></textarea><span class="help-block"><p id="characterLeft10" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft10').text('400 characters left');
    $('#c10').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft10').text('You have reached the limit');
            $('#characterLeft10').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft10').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft10').removeClass('red');            
        }
    });    
});

function yesnoCheckc10() {
    if (document.getElementById('yesCheckc10').checked) {
        document.getElementById('ifYesc10').style.display = 'none';
    }
    else document.getElementById('ifYesc10').style.display = 'block';

}
                        </script>
                        
                        <label for="q11">Q11. Did the closer check all details of what the client has with their existing life insurance policy?</label>
                        <input type="radio" name="q11" <?php if (isset($q11) && $q11=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc11();" value="1" id="yesCheckc11">Yes
                        <input type="radio" name="q11" <?php if (isset($q11vvv) && $q11=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc11();" value="0" id="noCheckc11">No
                        
                        <div id="ifYesc11" style="display:<?php if(isset($c11)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c11" name="c11" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c11)) { echo $c11; } ?></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft11').text('400 characters left');
    $('#c11').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft11').text('You have reached the limit');
            $('#characterLeft11').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft11').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft11').removeClass('red');            
        }
    });    
});

function yesnoCheckc11() {
    if (document.getElementById('yesCheckc11').checked) {
        document.getElementById('ifYesc11').style.display = 'none';
    }
    else document.getElementById('ifYesc11').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Identifying Clients Needs</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q12">Q12. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
                        <input type="radio" name="q12" <?php if (isset($q12) && $q12=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc12();" value="1" id="yesCheckc12">Yes
                        <input type="radio" name="q12" <?php if (isset($q12) && $q12=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc12();" value="0" id="noCheckc12">No
                        
                        <div id="ifYesc12" style="display:<?php if(isset($c12)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c12" name="c12" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c12)) { echo $c12; } ?></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft12').text('400 characters left');
    $('#c12').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft12').text('You have reached the limit');
            $('#characterLeft12').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft12').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft12').removeClass('red');            
        }
    });    
});

function yesnoCheckc12() {
    if (document.getElementById('yesCheckc12').checked) {
        document.getElementById('ifYesc12').style.display = 'none';
    }
    else document.getElementById('ifYesc12').style.display = 'block';

}
                        </script>
                        
                        <label for="q13">Q13. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label>
                        <select class="form-control" name="q13">
                            <option value="0">Select...</option>
                            <option value="1">More than sufficient</option>
                            <option value="2">Sufficient</option>
                            <option value="3">Adequate</option>
                            <option value="4" onclick="javascript:yesnoCheckc13();" id="yesCheckc13">Poor</option>
                        </select>
                        
                        <div id="ifYesc13" style="display:<?php if(isset($c13)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c13" name="c13" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c13)) { echo $c13; } ?></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft13').text('400 characters left');
    $('#c13').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft13').text('You have reached the limit');
            $('#characterLeft13').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft13').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft13').removeClass('red');            
        }
    });    
});

function yesnoCheckc13() {
    if (document.getElementById('yesCheckc13').checked) {
        document.getElementById('ifYesc13').style.display = 'none';
    }
    else document.getElementById('ifYesc13').style.display = 'block';

}
                        </script>
                        
                        <label for="q14">Q14. Closer confirmed this policy will be set up with One Family?</label>
                        <input type="radio" name="q14" <?php if (isset($q14) && $q14=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc14();" value="1" id="yesCheckc14">Yes
                        <input type="radio" name="q14" <?php if (isset($q14) && $q14=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc14();" value="0" id="noCheckc14">No
                        
                        <div id="ifYesc14" style="display:<?php if(isset($c14)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c14" name="c14" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c14)) { echo $c14; } ?></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft14').text('400 characters left');
    $('#c14').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft14').text('You have reached the limit');
            $('#characterLeft14').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft14').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft14').removeClass('red');            
        }
    });    
});

function yesnoCheckc14() {
    if (document.getElementById('yesCheckc14').checked) {
        document.getElementById('ifYesc14').style.display = 'none';
    }
    else document.getElementById('ifYesc14').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Eligibility</h3>
                    </div>
                    <div class="panel-body">    
                        
                        <label for="q15">Q15. Were all clients contact details recorded correctly?</label>
                        <input type="radio" name="q15" <?php if (isset($q15) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc15();" value="1" id="yesCheckc15">Yes
                        <input type="radio" name="q15" <?php if (isset($q15) && $q15=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc15();" value="0" id="noCheckc15">No
                        
                        <div id="ifYesc15" style="display:<?php if(isset($c15)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c15" name="c15" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c15)) { echo $c15; } ?></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft15').text('400 characters left');
    $('#c15').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft15').text('You have reached the limit');
            $('#characterLeft15').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft15').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft15').removeClass('red');            
        }
    });    
});

function yesnoCheckc15() {
    if (document.getElementById('yesCheckc15').checked) {
        document.getElementById('ifYesc15').style.display = 'none';
    }
    else document.getElementById('ifYesc15').style.display = 'block';

}
                        </script>
                        
                        <label for="q16">Q16. Were all clients address details recorded correctly?</label>
                        <input type="radio" name="q16" <?php if (isset($q16) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc16();" value="1" id="yesCheckc16">Yes
                        <input type="radio" name="q16" <?php if (isset($q16) && $q16=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc16();" value="0" id="noCheckc16">No
                        
                        <div id="ifYesc16" style="display:<?php if(isset($c16)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c16" name="c16" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c16)) { echo $c16; } ?></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft16').text('400 characters left');
    $('#c16').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft16').text('You have reached the limit');
            $('#characterLeft16').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft16').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft16').removeClass('red');            
        }
    });    
});

function yesnoCheckc16() {
    if (document.getElementById('yesCheckc16').checked) {
        document.getElementById('ifYesc16').style.display = 'none';
    }
    else document.getElementById('ifYesc16').style.display = 'block';

}
                        </script>
                        
                        <label for="q17">Q17. Did the agent explain trust?</label>
                        <input type="radio" name="q17" <?php if (isset($q17) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc17();" value="1" id="yesCheckc17">Yes
                        <input type="radio" name="q17" <?php if (isset($q17) && $q17=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc17();" value="0" id="noCheckc17">No
                        
                        <div id="ifYesc17" style="display:<?php if(isset($c17)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c17" name="c17" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c17)) { echo $c17; } ?></textarea><span class="help-block"><p id="characterLeft17" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft17').text('400 characters left');
    $('#c17').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft17').text('You have reached the limit');
            $('#characterLeft17').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft17').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft17').removeClass('red');            
        }
    });    
});

function yesnoCheckc17() {
    if (document.getElementById('yesCheckc17').checked) {
        document.getElementById('ifYesc17').style.display = 'none';
    }
    else document.getElementById('ifYesc17').style.display = 'block';

}
                        </script>                       
                        
                        <label for="q18">Q18. Did the agent explain funeral contribution?</label>
                        <input type="radio" name="q18" <?php if (isset($q18) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc18();" value="1" id="yesCheckc18">Yes
                        <input type="radio" name="q18" <?php if (isset($q18) && $q18=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc18();" value="0" id="noCheckc18">No
                        
                        <div id="ifYesc18" style="display:<?php if(isset($c18)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c18" name="c18" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c18)) { echo $c18; } ?></textarea><span class="help-block"><p id="characterLeft18" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft18').text('400 characters left');
    $('#c18').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft18').text('You have reached the limit');
            $('#characterLeft18').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft18').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft18').removeClass('red');            
        }
    });    
});

function yesnoCheckc18() {
    if (document.getElementById('yesCheckc18').checked) {
        document.getElementById('ifYesc18').style.display = 'none';
    }
    else document.getElementById('ifYesc18').style.display = 'block';

}
                        </script>
                        
                        <label for="q19">Q19. Did the agent offer to nominate a beneficiary?</label>
                        <input type="radio" name="q19" <?php if (isset($q19) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc19();" value="1" id="yesCheckc19">Yes
                        <input type="radio" name="q19" <?php if (isset($q19) && $q19=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc19();" value="0" id="noCheckc19">No
                        
                        <div id="ifYesc19" style="display:<?php if(isset($c19)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c19" name="c19" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c19)) { echo $c19; } ?></textarea><span class="help-block"><p id="characterLeft19" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft19').text('400 characters left');
    $('#c19').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft19').text('You have reached the limit');
            $('#characterLeft19').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft19').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft19').removeClass('red');            
        }
    });    
});

function yesnoCheckc19() {
    if (document.getElementById('yesCheckc19').checked) {
        document.getElementById('ifYesc19').style.display = 'none';
    }
    else document.getElementById('ifYesc19').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">      
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q20">Q20. Was the clients policy start date accurately recorded?</label>
                        <input type="radio" name="q20" <?php if (isset($q20) && $q20=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc20();" value="1" id="yesCheckc20">Yes
                        <input type="radio" name="q20" <?php if (isset($q20) && $q20=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc20();" value="0" id="noCheckc20">No
                        
                        <div id="ifYesc20" style="display:<?php if(isset($c20)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c20" name="c20" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c20)) { echo $c20; } ?></textarea><span class="help-block"><p id="characterLeft20" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft20').text('400 characters left');
    $('#c20').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft20').text('You have reached the limit');
            $('#characterLeft20').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft20').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft20').removeClass('red');            
        }
    });    
});

function yesnoCheckc20() {
    if (document.getElementById('yesCheckc20').checked) {
        document.getElementById('ifYesc20').style.display = 'none';
    }
    else document.getElementById('ifYesc20').style.display = 'block';

}
                        </script>
                        
                        <label for="q21">Q21. Did the closer offer to read the direct debit guarantee?</label>
                        <input type="radio" name="q21" <?php if (isset($q21) && $q21=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc21();" value="1" id="yesCheckc21">Yes
                        <input type="radio" name="q21" <?php if (isset($q21) && $q21=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc21();" value="0" id="noCheckc21">No
                        
                        <div id="ifYesc21" style="display:<?php if(isset($c21)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c21" name="c21" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c21)) { echo $c21; } ?></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft37').text('400 characters left');
    $('#c21').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft37').text('You have reached the limit');
            $('#characterLeft37').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft37').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft37').removeClass('red');            
        }
    });    
});

function yesnoCheckc21() {
    if (document.getElementById('yesCheckc21').checked) {
        document.getElementById('ifYesc21').style.display = 'none';
    }
    else document.getElementById('ifYesc21').style.display = 'block';

}
                        </script>
                        
                        <label for="q22">Q22. Did the closer offer a preferred premium collection date?</label>
                        <input type="radio" name="q22" <?php if (isset($q22) && $q22=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc22();" value="1" id="yesCheckc22">Yes
                        <input type="radio" name="q22" <?php if (isset($q22) && $q22=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc22();" value="0" id="noCheckc22">No
                        
                        <div id="ifYesc22" style="display:<?php if(isset($c22)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c22" name="c22" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c22)) { echo $c22; } ?></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
$(document).ready(function(){ 
    $('#characterLeft38').text('400 characters left');
    $('#c22').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft38').text('You have reached the limit');
            $('#characterLeft38').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft38').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft38').removeClass('red');            
        }
    });    
});

function yesnoCheckc22() {
    if (document.getElementById('yesCheckc22').checked) {
        document.getElementById('ifYesc22').style.display = 'none';
    }
    else document.getElementById('ifYesc22').style.display = 'block';

}
                        </script>
                        
                        <label for="q23">Q23. Did the closer record the bank details correctly?</label>
                        <input type="radio" name="q23" <?php if (isset($q23) && $q23=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc23();" value="1" id="yesCheckc23">Yes
                        <input type="radio" name="q23" <?php if (isset($q23) && $q23=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc23();" value="0" id="noCheckc23">No
                        
                        <div id="ifYesc23" style="display:<?php if(isset($c23)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c23" name="c23" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c23)) { echo $c23; } ?></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft39').text('400 characters left');
    $('#c23').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft39').text('You have reached the limit');
            $('#characterLeft39').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft39').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft39').removeClass('red');            
        }
    });    
});

function yesnoCheckc23() {
    if (document.getElementById('yesCheckc23').checked) {
        document.getElementById('ifYesc23').style.display = 'none';
    }
    else document.getElementById('ifYesc23').style.display = 'block';

}
                        </script>
                        
                        <label for="q24">Q24. Did they have consent off the premium payer?</label>
                        <input type="radio" name="q24" <?php if (isset($q24) && $q24=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc24();" value="1" id="yesCheckc24">Yes
                        <input type="radio" name="q24" <?php if (isset($q24) && $q24=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc24();" value="0" id="noCheckc24">No
                        
                        <div id="ifYesc24" style="display:<?php if(isset($c24)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c24" name="c24" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c24)) { echo $c24; } ?></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft40').text('400 characters left');
    $('#c24').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft40').text('You have reached the limit');
            $('#characterLeft40').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft40').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft40').removeClass('red');            
        }
    });    
});

function yesnoCheckc24() {
    if (document.getElementById('yesCheckc24').checked) {
        document.getElementById('ifYesc24').style.display = 'none';
    }
    else document.getElementById('ifYesc24').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Consolidation Declaration</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q25">Q25. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                        <input type="radio" name="q25" <?php if (isset($q25) && $q25=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc25();" value="1" id="yesCheckc25">Yes
                        <input type="radio" name="q25" <?php if (isset($q25) && $q25=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc25();" value="0" id="noCheckc25">No
                        
                        <div id="ifYesc25" style="display:<?php if(isset($c25)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c25" name="c25" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c25)) { echo $c25; } ?></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft41').text('400 characters left');
    $('#c25').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft41').text('You have reached the limit');
            $('#characterLeft41').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft41').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft41').removeClass('red');            
        }
    });    
});

function yesnoCheckc25() {
    if (document.getElementById('yesCheckc25').checked) {
        document.getElementById('ifYesc25').style.display = 'none';
    }
    else document.getElementById('ifYesc25').style.display = 'block';

}
                        </script>
                        
                        <label for="q26">Q26. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                        <input type="radio" name="q26" <?php if (isset($q26) && $q26=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc26();" value="1" id="yesCheckc26">Yes
                        <input type="radio" name="q26" <?php if (isset($q26) && $q26=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc26();" value="0" id="noCheckc26">No
                        
                        <div id="ifYesc26" style="display:<?php if(isset($c26)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c26" name="c26" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c26)) { echo $c26; } ?></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft42').text('400 characters left');
    $('#c26').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft42').text('You have reached the limit');
            $('#characterLeft42').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft42').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft42').removeClass('red');            
        }
    });    
});

function yesnoCheckc26() {
    if (document.getElementById('yesCheckc26').checked) {
        document.getElementById('ifYesc26').style.display = 'none';
    }
    else document.getElementById('ifYesc26').style.display = 'block';

}
                        </script>
                        
                        <label for="q27">Q27. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                        <input type="radio" name="q27" <?php if (isset($q27) && $q27=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc27();" value="1" id="yesCheckc27">Yes
                        <input type="radio" name="q27" <?php if (isset($q27) && $q27=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc27();" value="0" id="noCheckc27">No
                        
                        <div id="ifYesc27" style="display:<?php if(isset($c27)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c27" name="c27" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c27)) { echo $c27; } ?></textarea><span class="help-block"><p id="characterLeft27" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft27').text('400 characters left');
    $('#c27').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft27').text('You have reached the limit');
            $('#characterLeft27').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft27').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft27').removeClass('red');            
        }
    });    
});

function yesnoCheckc27() {
    if (document.getElementById('yesCheckc27').checked) {
        document.getElementById('ifYesc27').style.display = 'none';
    }
    else document.getElementById('ifYesc27').style.display = 'block';

}
                        </script>
                        
                        <label for="q28">Q28. Closer confirmed that the client will be documents in the post from One Family?</label>
                        <input type="radio" name="q28" <?php if (isset($q28) && $q28=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc28();" value="1" id="yesCheckc28">Yes
                        <input type="radio" name="q28" <?php if (isset($q28) && $q28=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc28();" value="0" id="noCheckc28">No
                        
                        <div id="ifYesc28" style="display:<?php if(isset($c28)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c28" name="c28" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c28)) { echo $c28; } ?></textarea><span class="help-block"><p id="characterLeft28" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft28').text('400 characters left');
    $('#c28').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft28').text('You have reached the limit');
            $('#characterLeft28').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft28').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft28').removeClass('red');            
        }
    });    
});

function yesnoCheckc28() {
    if (document.getElementById('yesCheckc28').checked) {
        document.getElementById('ifYesc28').style.display = 'none';
    }
    else document.getElementById('ifYesc28').style.display = 'block';

}
                        </script>
                        
                        <label for="q29">Q29. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but One Family will write to them with a more specific date?</label>
                        <input type="radio" name="q29" <?php if (isset($q29) && $q29=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc29();" value="1" id="yesCheckc29">Yes
                        <input type="radio" name="q29" <?php if (isset($q29) && $q29=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc29();" value="0" id="noCheckc29">No
                        
                        <div id="ifYesc29" style="display:<?php if(isset($c29)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c29" name="c29" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c29)) { echo $c29; } ?></textarea><span class="help-block"><p id="characterLeft29" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft29').text('400 characters left');
    $('#c29').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft29').text('You have reached the limit');
            $('#characterLeft29').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft29').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft29').removeClass('red');            
        }
    });    
});

function yesnoCheckc29() {
    if (document.getElementById('yesCheckc29').checked) {
        document.getElementById('ifYesc29').style.display = 'none';
    }
    else document.getElementById('ifYesc29').style.display = 'block';

}
                        </script>
                        
                        <label for="q30">Q30. Did the closer confirm to the customer to cancel any existing direct debit?</label>
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="1" id="yesCheckc30">Yes
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="0" id="noCheckc30">No
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="2") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="2" id="yesCheckc30">N/A
                        
                        <div id="ifYesc30" style="display:<?php if(isset($c30)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c30" name="c30" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c30)) { echo $c30; } ?></textarea><span class="help-block"><p id="characterLeft30" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft30').text('400 characters left');
    $('#c30').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft30').text('You have reached the limit');
            $('#characterLeft30').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft30').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft30').removeClass('red');            
        }
    });    
});

function yesnoCheckc30() {
    if (document.getElementById('yesCheckc30').checked) {
        document.getElementById('ifYesc30').style.display = 'none';
    }
    else document.getElementById('ifYesc30').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Quality Control</h3>
                    </div>
                    <div class="panel-body">
                        
                        <label for="q31">Q31. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with L&G with client information?</label>
                        <input type="radio" name="q31" <?php if (isset($q31) && $q31=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc31();" value="1" id="yesCheckc31">Yes
                        <input type="radio" name="q31" <?php if (isset($q31) && $q31=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc31();" value="0" id="noCheckc31">No
                        
                        <div id="ifYesc31" style="display:<?php if(isset($c31)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c31" name="c31" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c31)) { echo $c31; } ?></textarea><span class="help-block"><p id="characterLeft31" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft31').text('400 characters left');
    $('#c31').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft31').text('You have reached the limit');
            $('#characterLeft31').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft31').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft31').removeClass('red');            
        }
    });    
});

function yesnoCheckc31() {
    if (document.getElementById('yesCheckc31').checked) {
        document.getElementById('ifYesc31').style.display = 'none';
    }
    else document.getElementById('ifYesc31').style.display = 'block';

}
                        </script>
                        
                        <label for="q32">Q32. Closer confirmed the amount of cover on the policy with client confirmation?</label>
                        <input type="radio" name="q32" <?php if (isset($q32) && $q32=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc32();" value="1" id="yesCheckc32">Yes
                        <input type="radio" name="q32" <?php if (isset($q32) && $q32=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc32();" value="0" id="noCheckc32">No
                        
                        <div id="ifYesc32" style="display:<?php if(isset($c32)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c32" name="c32" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c32)) { echo $c32; } ?></textarea><span class="help-block"><p id="characterLeft32" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft32').text('400 characters left');
    $('#c32').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft32').text('You have reached the limit');
            $('#characterLeft32').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft32').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft32').removeClass('red');            
        }
    });    
});

function yesnoCheckc32() {
    if (document.getElementById('yesCheckc32').checked) {
        document.getElementById('ifYesc32').style.display = 'none';
    }
    else document.getElementById('ifYesc32').style.display = 'block';

}
                        </script>
                        
                        <label for="q33">Q33. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
                        <input type="radio" name="q33" <?php if (isset($q33) && $q33=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc33();" value="1" id="yesCheckc33">Yes
                        <input type="radio" name="q33" <?php if (isset($q33) && $q33=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc33();" value="0" id="noCheckc33">No
                        
                        <div id="ifYesc33" style="display:<?php if(isset($c33)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c33" name="c33" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c33)) { echo $c33; } ?></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft33').text('400 characters left');
    $('#c33').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft33').text('You have reached the limit');
            $('#characterLeft33').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft33').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft33').removeClass('red');            
        }
    });    
});

function yesnoCheckc33() {
    if (document.getElementById('yesCheckc33').checked) {
        document.getElementById('ifYesc33').style.display = 'none';
    }
    else document.getElementById('ifYesc33').style.display = 'block';

}
                        </script>
                        
                        <label for="q34">Q34. Did the customer give their explicit consent for the policy to be set up?</label>
                        <input type="radio" name="q34" <?php if (isset($q34) && $q34=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc34();" value="1" id="yesCheckc34">Yes
                        <input type="radio" name="q34" <?php if (isset($q34) && $q34=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc34();" value="0" id="noCheckc34">No
                        
                        <div id="ifYesc34" style="display:<?php if(isset($c34)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c34" name="c34" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c34)) { echo $c34; } ?></textarea><span class="help-block"><p id="characterLeft34" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft34').text('400 characters left');
    $('#c34').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft34').text('You have reached the limit');
            $('#characterLeft34').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft34').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft34').removeClass('red');            
        }
    });    
});

function yesnoCheckc34() {
    if (document.getElementById('yesCheckc34').checked) {
        document.getElementById('ifYesc34').style.display = 'none';
    }
    else document.getElementById('ifYesc34').style.display = 'block';

}
                        </script>
                        
                        <label for="q35">Q35. Closer provided contact details for <?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>?</label>
                        <input type="radio" name="q35" <?php if (isset($q35) && $q35=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc35();" value="1" id="yesCheckc35">Yes
                        <input type="radio" name="q35" <?php if (isset($q35) && $q35=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc35();" value="0" id="noCheckc35">No
                        
                        <div id="ifYesc35" style="display:<?php if(isset($c35)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c35" name="c35" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c35)) { echo $c35; } ?></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft35').text('400 characters left');
    $('#c35').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft35').text('You have reached the limit');
            $('#characterLeft35').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft35').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft35').removeClass('red');            
        }
    });    
});

function yesnoCheckc35() {
    if (document.getElementById('yesCheckc35').checked) {
        document.getElementById('ifYesc35').style.display = 'none';
    }
    else document.getElementById('ifYesc35').style.display = 'block';

}
                        </script>
                        
                        <label for="q36">Q36. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
                        <input type="radio" name="q36" <?php if (isset($q36) && $q36=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc36();" value="1" id="yesCheckc36">Yes
                        <input type="radio" name="q36" <?php if (isset($q36) && $q36=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc36();" value="0" id="noCheckc36">No
                        
                        <div id="ifYesc36" style="display:<?php if(isset($c36)) { echo "block"; } else {  echo "none"; } ?>">
                            <textarea class="form-control"id="c36" name="c36" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if(isset($c36)) { echo $c36; } ?></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
                        </div>
                        
                        <script>
$(document).ready(function(){ 
    $('#characterLeft36').text('400 characters left');
    $('#c36').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft36').text('You have reached the limit');
            $('#characterLeft36').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft36').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft36').removeClass('red');            
        }
    });    
});

function yesnoCheckc36() {
    if (document.getElementById('yesCheckc36').checked) {
        document.getElementById('ifYesc36').style.display = 'none';
    }
    else document.getElementById('ifYesc36').style.display = 'block';

}
                        </script>
                    
                    </div>
                </div>
                
                <center>
                    <button type="submit" value="submit"  class="btn btn-warning "><span class="glyphicon glyphicon-ok"></span> Edit Audit</button>
                </center>
        </form>
        <script>
$('#WOL_FORM').submit(function(e){
  
    e.preventDefault();
  
    $.post('php/Audit_Submit.php?query=WOL&action=Edit&WOLID=<?php echo $WOLID; ?>', $(this).serialize() )
    .done(function(data){
      $('#form-content').fadeOut('slow', function(){
          $("#form-content").fadeIn("slow");
          window.location.href = "Menu.php?query=WOL&return=Edit";
        });
    })
    .fail(function(){
     alert('Audit not submitted, an error has occured ...');
    });
});
</script>
    </div>
</body>
</html>