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
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $CHECK_USER_LOGIN->CheckAccessLevel();
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        } 
$QUESTION_NUMBER=1;
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | Vitality Closer Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/resources/templates/ADL/audit_layout.css" type="text/css" />
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/lib/EasyAutocomplete-1.3.3/easy-autocomplete.min.css">
    <link rel="stylesheet" href="/resources/lib/sweet-alert/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
    <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/resources/lib/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script>
    <script src="/resources/lib/sweet-alert/sweet-alert.min.js"></script>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <?php require_once(__DIR__ . '/../../../app/Holidays.php'); ?>

</head>
<body>
    <?php require_once(__DIR__ . '/../../../includes/navbar.php'); ?>

    <div class="container">

        <form action="php/Audit.php?EXECUTE=1" method="POST" id="AUDIT_FORM" name="AUDIT_FORM" autocomplete="off">

            <fieldset>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Vitality Closer Call Audit</h3>
                    </div>

                    <div class="panel-body">
                        <p>
                        <div class='form-group'>
                            <label for='CLOSER'>Closer:</label>
                            <select class='form-control' name='CLOSER' id='full_name' required> 
                                <option value="">Select...</option>

                                <script type="text/JavaScript"> 
                                    var $select = $('#full_name');
                                    $.getJSON('/../../app/JSON/Closers.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>', function(data){
                                    $select.html('full_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.full_name + '">' + val.full_name + '</option>');
                                    })
                                    });
                                </script>

                            </select>
                        </div>

                        <label for="POLICY">Plan Number</label>
                        <input type="text" class="form-control" name="PLAN_NUMBER" style="width: 520px">

                        </p>

                        <p>
                        <div class="form-group">
                            <label for='GRADE'>Grade:</label>
                            <select class="form-control" name="GRADE" required>
                                <option value="">Select...</option>
                                <option value="SAVED">Incomplete Audit (SAVE)</option>
                                <option value="Green">Green</option>
                                <option value="Amber">Amber</option>
                                <option value="Red">Red</option>
                            </select>
                        </div>
                        </p>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Opening Declaration</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <label for="OD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer made aware that calls are recorded for training and monitoring purposes?</label>
                            <input type="radio" name="OD_Q1" 
                                   <?php if (isset($OD_Q1) && $OD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="1" id="yesCheckOD_C1">Yes
                            <input type="radio" name="OD_Q1"
<?php if (isset($OD_Q1) && $OD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="0" id="noCheckOD_C1">No
                        </p>

                        <div id="ifYesOD_C1" style="display:none">
                            <textarea class="form-control"id="OD_C1" name="OD_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#OD_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOD_C1() {
                                if (document.getElementById('yesCheckOD_C1').checked) {
                                    document.getElementById('ifYesOD_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOD_C1').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="OD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer informed that general insurance is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q2" 
<?php if (isset($OD_Q2) && $OD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C2();"
                                   value="1" id="yesCheckOD_C2">Yes
                            <input type="radio" name="OD_Q2"
<?php if (isset($OD_Q2) && $OD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C2();"
                                   value="0" id="noCheckOD_C2">No
                        </p>

                        <div id="ifYesOD_C2" style="display:none">
                            <textarea class="form-control"id="OD_C2" name="OD_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#OD_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOD_C2() {
                                if (document.getElementById('yesCheckOD_C2').checked) {
                                    document.getElementById('ifYesOD_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOD_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="OD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label>
                            <input type="radio" name="OD_Q3" 
<?php if (isset($OD_Q3) && $OD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C3();"
                                   value="1" id="yesCheckOD_C3">Yes
                            <input type="radio" name="OD_Q3"
<?php if (isset($OD_Q3) && $OD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C3();"
                                   value="0" id="noCheckOD_C3">No
                        </p>

                        <div id="ifYesOD_C3" style="display:none">
                            <textarea class="form-control"id="OD_C3" name="OD_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#OD_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOD_C3() {
                                if (document.getElementById('yesCheckOD_C3').checked) {
                                    document.getElementById('ifYesOD_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOD_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="OD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER provide the name and details of the firm who is regulated by the FCA?</label>
                            <input type="radio" name="OD_Q4" 
<?php if (isset($OD_Q4) && $OD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C4();"
                                   value="1" id="yesCheckOD_C4">Yes
                            <input type="radio" name="OD_Q4"
<?php if (isset($OD_Q4) && $OD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C4();"
                                   value="0" id="noCheckOD_C4">No
                        </p>

                        <div id="ifYesOD_C4" style="display:none">
                            <textarea class="form-control"id="OD_C4" name="OD_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft4').text('500 characters left');
                                $('#OD_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft4').text('You have reached the limit');
                                        $('#characterLeft4').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft4').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft4').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOD_C4() {
                                if (document.getElementById('yesCheckOD_C4').checked) {
                                    document.getElementById('ifYesOD_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOD_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="OD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label>
                            <input type="radio" name="OD_Q5" 
<?php if (isset($OD_Q5) && $OD_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C5();"
                                   value="1" id="yesCheckOD_C5">Yes
                            <input type="radio" name="OD_Q5"
<?php if (isset($OD_Q5) && $OD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C5();"
                                   value="0" id="noCheckOD_C5">No
                        </p>

                        <div id="ifYesOD_C5" style="display:none">
                            <textarea class="form-control"id="OD_C5" name="OD_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#OD_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOD_C5() {
                                if (document.getElementById('yesCheckOD_C5').checked) {
                                    document.getElementById('ifYesOD_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOD_C5').style.display = 'block';

                            }

                        </script>
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">About you</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="AY_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question checking for "existing cover with VitalityLife/PruProtect" asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q1" 
                                   <?php if (isset($AY_Q1) && $AY_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckAY_C1();"
                                   value="1" id="yesCheckAY_C1">Yes
                            <input type="radio" name="AY_Q1"
<?php if (isset($AY_Q1) && $AY_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C1();"
                                   value="0" id="noCheckAY_C1">No
                        </p>

                        <div id="ifYesAY_C1" style="display:none">
                            <textarea class="form-control"id="AY_C1" name="AY_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#AY_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C1() {
                                if (document.getElementById('yesCheckAY_C1').checked) {
                                    document.getElementById('ifYesAY_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C1').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="AY_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Within the last 12 months have you applied for any other cover with VitalityLife.." asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q2" 
<?php if (isset($AY_Q2) && $AY_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C2();"
                                   value="1" id="yesCheckAY_C2">Yes
                            <input type="radio" name="AY_Q2"
<?php if (isset($AY_Q2) && $AY_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C2();"
                                   value="0" id="noCheckAY_C2">No
                        </p>

                        <div id="ifYesAY_C2" style="display:none">
                            <textarea class="form-control"id="AY_C2" name="AY_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#AY_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C2() {
                                if (document.getElementById('yesCheckAY_C2').checked) {
                                    document.getElementById('ifYesAY_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C2').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="AY_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for the total amount of cover exceeding £1.5m asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q3" 
<?php if (isset($AY_Q3) && $AY_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C3();"
                                   value="1" id="yesCheckAY_C3">Yes
                            <input type="radio" name="AY_Q3"
<?php if (isset($AY_Q3) && $AY_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C3();"
                                   value="0" id="noCheckAY_C3">No
                        </p>

                        <div id="ifYesAY_C3" style="display:none">
                            <textarea class="form-control"id="AY_C3" name="AY_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#AY_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C3() {
                                if (document.getElementById('yesCheckAY_C3').checked) {
                                    document.getElementById('ifYesAY_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C3').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="AY_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "What is your main occupation?" asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q4" 
<?php if (isset($AY_Q4) && $AY_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C4();"
                                   value="1" id="yesCheckAY_C4">Yes
                            <input type="radio" name="AY_Q4"
<?php if (isset($AY_Q4) && $AY_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C4();"
                                   value="0" id="noCheckAY_C4">No
                        </p>

                        <div id="ifYesAY_C4" style="display:none">
                            <textarea class="form-control"id="AY_C4" name="AY_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft4').text('500 characters left');
                                $('#AY_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft4').text('You have reached the limit');
                                        $('#characterLeft4').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft4').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft4').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C4() {
                                if (document.getElementById('yesCheckAY_C4').checked) {
                                    document.getElementById('ifYesAY_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C4').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="AY_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Do you work in or with the armed/reserve forces?" asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q5" 
<?php if (isset($AY_Q5) && $AY_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C5();"
                                   value="1" id="yesCheckAY_C5">Yes
                            <input type="radio" name="AY_Q5"
<?php if (isset($AY_Q5) && $AY_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C5();"
                                   value="0" id="noCheckAY_C5">No
                        </p>

                        <div id="ifYesAY_C5" style="display:none">
                            <textarea class="form-control"id="AY_C5" name="AY_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#AY_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C5() {
                                if (document.getElementById('yesCheckAY_C5').checked) {
                                    document.getElementById('ifYesAY_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C5').style.display = 'block';

                            }
                        </script>
                
<p>
                            <label for="AY_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "In the next 12 months, do you intend spending more than 4 weeks overall.." asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q6" 
<?php if (isset($AY_Q6) && $AY_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C6();"
                                   value="1" id="yesCheckAY_C6">Yes
                            <input type="radio" name="AY_Q6"
<?php if (isset($AY_Q6) && $AY_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C6();"
                                   value="0" id="noCheckAY_C6">No
                        </p>

                        <div id="ifYesAY_C6" style="display:none">
                            <textarea class="form-control"id="AY_C6" name="AY_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#AY_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C6() {
                                if (document.getElementById('yesCheckAY_C6').checked) {
                                    document.getElementById('ifYesAY_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C6').style.display = 'block';

                            }
                        </script>     
                        
<p>
                            <label for="AY_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "In the last 5 years have you spent more than 3 consecutive months in...[the countries listed]...?" asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q7" 
<?php if (isset($AY_Q7) && $AY_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C7();"
                                   value="1" id="yesCheckAY_C7">Yes
                            <input type="radio" name="AY_Q7"
<?php if (isset($AY_Q7) && $AY_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C7();"
                                   value="0" id="noCheckAY_C7">No
                        </p>

                        <div id="ifYesAY_C7" style="display:none">
                            <textarea class="form-control"id="AY_C7" name="AY_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#AY_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C7() {
                                if (document.getElementById('yesCheckAY_C7').checked) {
                                    document.getElementById('ifYesAY_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C7').style.display = 'block';

                            }
                        </script>      
                     
 <p>
                            <label for="AY_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Do you take part in or intend to start within the next 12 months any hazardous pastimes?" asked and recorded correctly?</label>
                            <input type="radio" name="AY_Q8" 
<?php if (isset($AY_Q8) && $AY_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C8();"
                                   value="1" id="yesCheckAY_C8">Yes
                            <input type="radio" name="AY_Q8"
<?php if (isset($AY_Q8) && $AY_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckAY_C8();"
                                   value="0" id="noCheckAY_C8">No
                        </p>

                        <div id="ifYesAY_C8" style="display:none">
                            <textarea class="form-control"id="AY_C8" name="AY_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#AY_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckAY_C8() {
                                if (document.getElementById('yesCheckAY_C8').checked) {
                                    document.getElementById('ifYesAY_C8').style.display = 'none';
                                } else
                                    document.getElementById('ifYesAY_C8').style.display = 'block';

                            }
                        </script>                         
                        
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Personal</h3>
                    </div>
                    <div class="panel-body">

                        <p>
                            <label for="P_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have you been advised to reduce your alcohol intake because you were drinking too heavily?" asked and recorded correctly?</label>
                            <input type="radio" name="P_Q1" 
                                   <?php if (isset($P_Q1) && $P_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckP_C1();"
                                   value="1" id="yesCheckP_C1">Yes
                            <input type="radio" name="P_Q1"
<?php if (isset($P_Q1) && $P_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C1();"
                                   value="0" id="noCheckP_C1">No
                        </p>

                        <div id="ifYesP_C1" style="display:none">
                            <textarea class="form-control"id="P_C1" name="P_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft1').text('500 characters left');
                                $('#P_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft1').text('You have reached the limit');
                                        $('#characterLeft1').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft1').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft1').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C1() {
                                if (document.getElementById('yesCheckP_C1').checked) {
                                    document.getElementById('ifYesP_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C1').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="P_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "In the last 10 years have you ever taken recreation drugs such as.." asked and recorded correctly?</label>
                            <input type="radio" name="P_Q2" 
<?php if (isset($P_Q2) && $P_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C2();"
                                   value="1" id="yesCheckP_C2">Yes
                            <input type="radio" name="P_Q2"
<?php if (isset($P_Q2) && $P_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C2();"
                                   value="0" id="noCheckP_C2">No
                        </p>

                        <div id="ifYesP_C2" style="display:none">
                            <textarea class="form-control"id="P_C2" name="P_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft2" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft2').text('500 characters left');
                                $('#P_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft2').text('You have reached the limit');
                                        $('#characterLeft2').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft2').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft2').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C2() {
                                if (document.getElementById('yesCheckP_C2').checked) {
                                    document.getElementById('ifYesP_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="P_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have you ever test positive for HIV, Hepatitis B or C or are you waiting the results of such a test?" asked and recorded correctly?</label>
                            <input type="radio" name="P_Q3" 
<?php if (isset($P_Q3) && $P_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C3();"
                                   value="1" id="yesCheckP_C3">Yes
                            <input type="radio" name="P_Q3"
<?php if (isset($P_Q3) && $P_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C3();"
                                   value="0" id="noCheckP_C3">No
                        </p>

                        <div id="ifYesP_C3" style="display:none">
                            <textarea class="form-control"id="P_C3" name="P_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft3" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft3').text('500 characters left');
                                $('#P_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft3').text('You have reached the limit');
                                        $('#characterLeft3').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft3').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft3').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C3() {
                                if (document.getElementById('yesCheckP_C3').checked) {
                                    document.getElementById('ifYesP_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="P_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Before the age of 60, have any members of your immediate family had any of the medical...[conditions listed]...?" asked and recorded correctly?</label>
                            <input type="radio" name="P_Q4" 
<?php if (isset($P_Q4) && $P_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C4();"
                                   value="1" id="yesCheckP_C4">Yes
                            <input type="radio" name="P_Q4"
<?php if (isset($P_Q4) && $P_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C4();"
                                   value="0" id="noCheckP_C4">No
                        </p>

                        <div id="ifYesP_C4" style="display:none">
                            <textarea class="form-control"id="P_C4" name="P_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft4" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft4').text('500 characters left');
                                $('#P_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft4').text('You have reached the limit');
                                        $('#characterLeft4').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft4').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft4').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C4() {
                                if (document.getElementById('yesCheckP_C4').checked) {
                                    document.getElementById('ifYesP_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="P_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Have you ever had or do you currently have any of the following" asked and recorded correctly?</label>
                            <input type="radio" name="P_Q5" 
<?php if (isset($P_Q5) && $P_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C5();"
                                   value="1" id="yesCheckP_C5">Yes
                            <input type="radio" name="P_Q5"
<?php if (isset($P_Q5) && $P_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C5();"
                                   value="0" id="noCheckP_C5">No
                        </p>

                        <div id="ifYesP_C5" style="display:none">
                            <textarea class="form-control"id="P_C5" name="P_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#P_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C5() {
                                if (document.getElementById('yesCheckP_C5').checked) {
                                    document.getElementById('ifYesP_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C5').style.display = 'block';

                            }

                        </script>
              
<p>
                            <label for="P_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for health condition in the last 5 years asked and recorded correctly?</label>
                            <input type="radio" name="P_Q6" 
<?php if (isset($P_Q6) && $P_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C6();"
                                   value="1" id="yesCheckP_C6">Yes
                            <input type="radio" name="P_Q6"
<?php if (isset($P_Q6) && $P_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C6();"
                                   value="0" id="noCheckP_C6">No
                        </p>

                        <div id="ifYesP_C6" style="display:none">
                            <textarea class="form-control"id="P_C6" name="P_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#P_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C6() {
                                if (document.getElementById('yesCheckP_C6').checked) {
                                    document.getElementById('ifYesP_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C6').style.display = 'block';

                            }

                        </script>                     
<p>
                            <label for="P_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question "Apart from any condition you have already told us about, within the last 5 years have you.." asked and recorded correctly?</label>
                            <input type="radio" name="P_Q7" 
<?php if (isset($P_Q7) && $P_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C7();"
                                   value="1" id="yesCheckP_C7">Yes
                            <input type="radio" name="P_Q7"
<?php if (isset($P_Q7) && $P_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C7();"
                                   value="0" id="noCheckP_C7">No
                        </p>

                        <div id="ifYesP_C7" style="display:none">
                            <textarea class="form-control"id="P_C7" name="P_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#P_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C7() {
                                if (document.getElementById('yesCheckP_C7').checked) {
                                    document.getElementById('ifYesP_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C7').style.display = 'block';

                            }

                        </script>     
                                             
 <p>
                            <label for="P_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Was the question for recent and current health asked and recorded correctly?</label>
                            <input type="radio" name="P_Q8" 
<?php if (isset($P_Q8) && $P_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C8();"
                                   value="1" id="yesCheckP_C8">Yes
                            <input type="radio" name="P_Q8"
<?php if (isset($P_Q8) && $P_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckP_C8();"
                                   value="0" id="noCheckP_C8">No
                        </p>

                        <div id="ifYesP_C8" style="display:none">
                            <textarea class="form-control"id="P_C8" name="P_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft5" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft5').text('500 characters left');
                                $('#P_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft5').text('You have reached the limit');
                                        $('#characterLeft5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft5').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft5').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckP_C8() {
                                if (document.getElementById('yesCheckP_C8').checked) {
                                    document.getElementById('ifYesP_C8').style.display = 'none';
                                } else
                                    document.getElementById('ifYesP_C8').style.display = 'block';

                            }

                        </script>                         
                        
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="CI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients titles and names recorded correctly?</label>
                            <input type="radio" name="CI_Q1" 
<?php if (isset($CI_Q1) && $CI_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C1();"
                                   value="1" id="yesCheckCI_C1">Yes
                            <input type="radio" name="CI_Q1"
<?php if (isset($CI_Q1) && $CI_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C1();"
                                   value="0" id="noCheckCI_C1">No
                        </p>

                        <div id="ifYesCI_C1" style="display:none">
                            <textarea class="form-control"id="CI_C1" name="CI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft6" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft6').text('500 characters left');
                                $('#CI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft6').text('You have reached the limit');
                                        $('#characterLeft6').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft6').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft6').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCI_C1() {
                                if (document.getElementById('yesCheckCI_C1').checked) {
                                    document.getElementById('ifYesCI_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCI_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients gender accurately recorded?</label>
                            <input type="radio" name="CI_Q2" 
<?php if (isset($CI_Q2) && $CI_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C2();"
                                   value="1" id="yesCheckCI_C2">Yes
                            <input type="radio" name="CI_Q2"
<?php if (isset($CI_Q2) && $CI_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C2();"
                                   value="0" id="noCheckCI_C2">No
                        </p>

                        <div id="ifYesCI_C2" style="display:none">
                            <textarea class="form-control"id="CI_C2" name="CI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft7" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft7').text('500 characters left');
                                $('#CI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft7').text('You have reached the limit');
                                        $('#characterLeft7').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft7').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft7').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCI_C2() {
                                if (document.getElementById('yesCheckCI_C2').checked) {
                                    document.getElementById('ifYesCI_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCI_C2').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="CI_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients date of birth accurately recorded?</label>
                            <input type="radio" name="CI_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($CI_Q3) && $CI_Q3 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck">Yes
                            <input type="radio" name="CI_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($CI_Q3) && $CI_Q3 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" style="display:none">
                            <textarea class="form-control"id="CI_C3" name="CI_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft8" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft8').text('500 characters left');
                                $('#CI_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft8').text('You have reached the limit');
                                        $('#characterLeft8').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft8').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft8').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheck() {
                                if (document.getElementById('yesCheck').checked) {
                                    document.getElementById('ifYes').style.display = 'none';
                                } else
                                    document.getElementById('ifYes').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="CI_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients smoking status recorded correctly?</label>
                            <input type="radio" name="CI_Q4" 
<?php if (isset($CI_Q4) && $CI_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C4();"
                                   value="1" id="yesCheckCI_C4">Yes
                            <input type="radio" name="CI_Q4"
<?php if (isset($CI_Q4) && $CI_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C4();"
                                   value="0" id="noCheckCI_C4">No
                        </p>

                        <div id="ifYesCI_C4" style="display:none">
                            <textarea class="form-control"id="CI_C4" name="CI_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft9" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft9').text('500 characters left');
                                $('#CI_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft9').text('You have reached the limit');
                                        $('#characterLeft9').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft9').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft9').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCI_C4() {
                                if (document.getElementById('yesCheckCI_C4').checked) {
                                    document.getElementById('ifYesCI_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCI_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CI_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm the policy was a single or a joint application?</label>
                            <input type="radio" name="CI_Q5" 
<?php if (isset($CI_Q5) && $CI_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C5();"
                                   value="1" id="yesCheckCI_C5">Yes
                            <input type="radio" name="CI_Q5"
<?php if (isset($CI_Q5) && $CI_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCI_C5();"
                                   value="0" id="noCheckCI_C5">No
                        </p>

                        <div id="ifYesCI_C5" style="display:none">
                            <textarea class="form-control"id="CI_C5" name="CI_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft11" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft11').text('500 characters left');
                                $('#CI_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft11').text('You have reached the limit');
                                        $('#characterLeft11').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft11').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft11').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCI_C5() {
                                if (document.getElementById('yesCheckCI_C5').checked) {
                                    document.getElementById('ifYesCI_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCI_C5').style.display = 'block';

                            }

                        </script>
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Identifying Clients Needs</h3>
                    </div>
                        <div class="panel-body">
                            
                        <p>
                            <label for="ICN_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER check all details of what the client has with their existing life insurance policy?</label>
                            <input type="radio" name="ICN_Q1" 
                                   <?php if (isset($ICN_Q1) && $ICN_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="1" id="yesCheckICN_C1">Yes
                            <input type="radio" name="ICN_Q1"
<?php if (isset($ICN_Q1) && $ICN_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="0" id="noCheckICN_C1">No
                        </p>

                        <div id="ifYesICN_C1" style="display:none">
                            <textarea class="form-control"id="ICN_C1" name="ICN_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft12" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft12').text('500 characters left');
                                $('#ICN_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft12').text('You have reached the limit');
                                        $('#characterLeft12').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft12').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft12').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckICN_C1() {
                                if (document.getElementById('yesCheckICN_C1').checked) {
                                    document.getElementById('ifYesICN_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesICN_C1').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="ICN_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER mention waiver, indexation, or TPD?</label>
                            <input type="radio" name="ICN_Q2" 
                                   <?php if (isset($ICN_Q2) && $ICN_Q2 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C2();"
                                   value="1" id="yesCheckICN_C2">Yes
                            <input type="radio" name="ICN_Q2"
<?php if (isset($ICN_Q2) && $ICN_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C2();"
                                   value="0" id="noCheckICN_C2">No
                            <input type="radio" name="ICN_Q2" 
<?php if (isset($ICN_Q2) && $ICN_Q2 == "N/A") {
    echo "checked";
} ?>
                                   value="N/A" >N/A
                        </p>

                        <div id="ifYesICN_C2" style="display:none">
                            <textarea class="form-control"id="ICN_C2" name="ICN_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft13" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft13').text('500 characters left');
                                $('#ICN_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft13').text('You have reached the limit');
                                        $('#characterLeft13').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft13').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft13').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckICN_C2() {
                                if (document.getElementById('yesCheckICN_C2').checked) {
                                    document.getElementById('ifYesICN_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesICN_C2').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="ICN_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label>
                            <input type="radio" name="ICN_Q3" 
<?php if (isset($ICN_Q3) && $ICN_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="1" id="yesCheckICN_C3">Yes
                            <input type="radio" name="ICN_Q3"
<?php if (isset($ICN_Q3) && $ICN_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="0" id="noCheckICN_C3">No
                        </p>

                        <div id="ifYesICN_C3" style="display:none">
                            <textarea class="form-control"id="ICN_C3" name="ICN_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft14" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft14').text('500 characters left');
                                $('#ICN_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft14').text('You have reached the limit');
                                        $('#characterLeft14').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft14').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft14').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckICN_C3() {
                                if (document.getElementById('yesCheckICN_C3').checked) {
                                    document.getElementById('ifYesICN_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesICN_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="ICN_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label>
                            <select class="form-control" name="ICN_Q4" onclick="javascript:yesnoCheckICN_C4();">
                                <option value="N/A">Select...</option>
                                <option value="More than sufficient">More than sufficient</option>
                                <option value="Sufficient">Sufficient</option>
                                <option value="Adaquate">Adequate</option>
                                <option value="Poor" onclick="javascript:yesnoCheckICN_C4a();" id="yesCheckICN_C4">Poor</option>
                            </select>
                        </p>


                        <div id="ifYesICN_C4" style="display:none">
                            <textarea class="form-control"id="ICN_C4" name="ICN_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft15" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft15').text('500 characters left');
                                $('#ICN_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft15').text('You have reached the limit');
                                        $('#characterLeft15').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft15').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft15').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckICN_C4() {
                                if (document.getElementById('yesCheckICN_C4').checked) {
                                    document.getElementById('ifYesICN_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesICN_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="ICN_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed this policy will be set up with Vitality?</label>
                            <input type="radio" name="ICN_Q5" 
<?php if (isset($ICN_Q5) && $ICN_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C5();"
                                   value="1" id="yesCheckICN_C5">Yes
                            <input type="radio" name="ICN_Q5"
<?php if (isset($ICN_Q5) && $ICN_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C5();"
                                   value="0" id="noCheckICN_C5">No
                        </p>

                        <div id="ifYesICN_C5" style="display:none">
                            <textarea class="form-control"id="ICN_C5" name="ICN_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft16" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft16').text('500 characters left');
                                $('#ICN_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft16').text('You have reached the limit');
                                        $('#characterLeft16').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft16').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft16').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckICN_C5() {
                                if (document.getElementById('yesCheckICN_C5').checked) {
                                    document.getElementById('ifYesICN_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesICN_C5').style.display = 'block';

                            }

                        </script>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Eligibility</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="E_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Important customer information declaration?</label>
                            <input type="radio" name="E_Q1" 
<?php if (isset($E_Q1) && $E_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C1();"
                                   value="1" id="yesCheckE_C1">Yes
                            <input type="radio" name="E_Q1"
<?php if (isset($E_Q1) && $E_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C1();"
                                   value="0" id="noCheckE_C1">No
                        </p>

                        <div id="ifYesE_C1" style="display:none">
                            <textarea class="form-control"id="E_C1" name="E_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft19" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft19').text('500 characters left');
                                $('#E_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft19').text('You have reached the limit');
                                        $('#characterLeft19').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft19').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft19').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C1() {
                                if (document.getElementById('yesCheckE_C1').checked) {
                                    document.getElementById('ifYesE_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="E_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients contact details recorded correctly?</label>
                            <input type="radio" name="E_Q2" 
<?php if (isset($E_Q2) && $E_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C2();"
                                   value="1" id="yesCheckE_C2">Yes
                            <input type="radio" name="E_Q2"
<?php if (isset($E_Q2) && $E_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C2();"
                                   value="0" id="noCheckE_C2">No
                        </p>

                        <div id="ifYesE_C2" style="display:none">
                            <textarea class="form-control"id="E_C2" name="E_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft18" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft18').text('500 characters left');
                                $('#E_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft18').text('You have reached the limit');
                                        $('#characterLeft18').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft18').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft18').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C2() {
                                if (document.getElementById('yesCheckE_C2').checked) {
                                    document.getElementById('ifYesE_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="E_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Were all clients address details recorded correctly?</label>
                            <input type="radio" name="E_Q3" 
<?php if (isset($E_Q3) && $OD_Q15 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C3();"
                                   value="1" id="yesCheckE_C3">Yes
                            <input type="radio" name="E_Q3"
<?php if (isset($E_Q3) && $E_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C3();"
                                   value="0" id="noCheckE_C3">No
                        </p>

                        <div id="ifYesE_C3" style="display:none">
                            <textarea class="form-control"id="E_C3" name="E_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft17" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft17').text('500 characters left');
                                $('#E_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft17').text('You have reached the limit');
                                        $('#characterLeft17').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft17').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft17').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C3() {
                                if (document.getElementById('yesCheckE_C3').checked) {
                                    document.getElementById('ifYesE_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C3').style.display = 'block';

                            }

                        </script>
                        
                        <p>
                            <label for="E_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Were all doctors details recorded correctly?</label>
                            <input type="radio" name="E_Q4" 
<?php if (isset($E_Q4) && $E_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C4();"
                                   value="1" id="yesCheckE_C4">Yes
                            <input type="radio" name="E_Q4"
<?php if (isset($E_Q4) && $E_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C4();"
                                   value="0" id="noCheckE_C4">No
                            <input type="radio" name="E_Q4"
<?php if (isset($E_Q4) && $E_Q4 == "N/A") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C4();"
                                   value="N/A" id="noCheckE_C4">N/A                            
                        </p>

                        <div id="ifYesE_C4" style="display:none">
                            <textarea class="form-control"id="E_C4" name="E_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft20" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft20').text('500 characters left');
                                $('#E_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft20').text('You have reached the limit');
                                        $('#characterLeft20').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft20').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft20').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C4() {
                                if (document.getElementById('yesCheckE_C4').checked) {
                                    document.getElementById('ifYesE_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C4').style.display = 'block';

                            }

                        </script>                     

                        <p>
                            <label for="E_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ask and accurately record the height and weight details correctly?</label>
                            <input type="radio" name="E_Q5" 
<?php if (isset($E_Q5) && $E_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C5();"
                                   value="1" id="yesCheckE_C5">Yes
                            <input type="radio" name="E_Q5"
                                   <?php if (isset($E_Q5) && $E_Q5 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckE_C5();"
                                   value="0" id="noCheckE_C5">No
                        </p>

                        <div id="ifYesE_C5" style="display:none">
                            <textarea class="form-control"id="E_C5" name="E_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft23" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft23').text('500 characters left');
                                $('#E_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft23').text('You have reached the limit');
                                        $('#characterLeft23').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft23').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft23').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C5() {
                                if (document.getElementById('yesCheckE_C5').checked) {
                                    document.getElementById('ifYesE_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C5').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="E_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ask and accurately record the smoking details correctly?</label>
                            <input type="radio" name="E_Q6" 
                                   <?php if (isset($E_Q6) && $E_Q6 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckE_C6();"
                                   value="1" id="yesCheckE_C6">Yes
                            <input type="radio" name="E_Q6"
<?php if (isset($E_Q6) && $E_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C6();"
                                   value="0" id="noCheckE_C6">No
                        </p>

                        <div id="ifYesE_C6" style="display:none">
                            <textarea class="form-control"id="E_C6" name="E_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft24" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft24').text('500 characters left');
                                $('#E_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft24').text('You have reached the limit');
                                        $('#characterLeft24').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft24').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft24').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C6() {
                                if (document.getElementById('yesCheckE_C6').checked) {
                                    document.getElementById('ifYesE_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C6').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="E_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER ask and accurately record the drug use details correctly?</label>
                            <input type="radio" name="E_Q7" 
<?php if (isset($E_Q7) && $E_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C7();"
                                   value="1" id="yesCheckE_C7">Yes
                            <input type="radio" name="E_Q7"
<?php if (isset($E_Q7) && $E_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckE_C7();"
                                   value="0" id="noCheckE_C7">No
                        </p>

                        <div id="ifYesE_C7" style="display:none">
                            <textarea class="form-control"id="E_C7" name="E_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft25" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft25').text('500 characters left');
                                $('#E_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft25').text('You have reached the limit');
                                        $('#characterLeft25').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft25').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft25').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckE_C7() {
                                if (document.getElementById('yesCheckE_C7').checked) {
                                    document.getElementById('ifYesE_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesE_C7').style.display = 'block';

                            }

                        </script>

                       <p>
                            <label for="E_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Were term for term details recorded correctly?</label>
                            <select class="form-control" name="E_Q8" >
                                <option value="N/A">Select...</option>
                                <option value="Client provided details">Client Provided Details</option>
                                <option value="Client failed to provide details">Client failed to provide details</option>
                                <option value="Not existing Vitality customer">Not existing legal and general customer</option>
                                <option value="Obtained from Term4Term service">Obtained from Term4Term service</option>
                                <option value="Existing Vitality Policy, no attempt to get policy number">Existing Vitality Policy, no attempt to get policy number</option>
                            </select>
                        </p>

                        <textarea class="form-control"id="E_C8" name="E_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft32" class="help-block ">You have reached the limit</p></span>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft32').text('500 characters left');
                                $('#E_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft32').text('You have reached the limit');
                                        $('#characterLeft32').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft32').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft32').removeClass('red');
                                    }
                                });
                            });
                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Declarations of Insurance</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="DI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Customer declaration read out?</label>
                            <input type="radio" name="DI_Q1" 
<?php if (isset($DI_Q1) && $DI_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDI_C1();"
                                   value="1" id="yesCheckDI_C1">Yes
                            <input type="radio" name="DI_Q1"
<?php if (isset($DI_Q1) && $DI_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDI_C1();"
                                   value="0" id="noCheckDI_C1">No
                        </p>

                        <div id="ifYesDI_C1" style="display:none">
                            <textarea class="form-control"id="DI_C1" name="DI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft33" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft34').text('500 characters left');
                                $('#DI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft34').text('You have reached the limit');
                                        $('#characterLeft34').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft34').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft34').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDI_C1() {
                                if (document.getElementById('yesCheckDI_C1').checked) {
                                    document.getElementById('ifYesDI_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDI_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. If appropriate did the CLOSER confirm the exclusions on the policy?</label>
                            <input type="radio" name="DI_Q2" 
<?php if (isset($DI_Q2) && $DI_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDI_C2();"
                                   value="1" id="yesCheckDI_C2">Yes
                            <input type="radio" name="DI_Q2"
<?php if (isset($DI_Q2) && $DI_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDI_C2();"
                                   value="0" id="noCheckDI_C2">No
                            <input type="radio" name="DI_Q2" 
<?php if (isset($DI_Q2) && $DI_Q2 == "N/A") {
    echo "checked";
} ?>
                                   value="N/A" >N/A
                        </p>

                        <div id="ifYesDI_C2" style="display:none">
                            <textarea class="form-control"id="DI_C2" name="DI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft35" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft35').text('500 characters left');
                                $('#DI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft35').text('You have reached the limit');
                                        $('#characterLeft35').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft35').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft35').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDI_C2() {
                                if (document.getElementById('yesCheckDI_C2').checked) {
                                    document.getElementById('ifYesDI_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDI_C2').style.display = 'block';

                            }

                        </script>
                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Information</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="PI_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients policy start date accurately recorded?</label>
                            <input type="radio" name="PI_Q1" 
                                   <?php if (isset($PI_Q1) && $PI_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckPI_C1();"
                                   value="1" id="yesCheckPI_C1">Yes
                            <input type="radio" name="PI_Q1"
<?php if (isset($PI_Q1) && $PI_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C1();"
                                   value="0" id="noCheckPI_C1">No
                        </p>

                        <div id="ifYesPI_C1" style="display:none">
                            <textarea class="form-control"id="PI_C1" name="PI_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft36" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft36').text('500 characters left');
                                $('#PI_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft36').text('You have reached the limit');
                                        $('#characterLeft36').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft36').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft36').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckPI_C1() {
                                if (document.getElementById('yesCheckPI_C1').checked) {
                                    document.getElementById('ifYesPI_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesPI_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="PI_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer to read the direct debit guarantee?</label>
                            <input type="radio" name="PI_Q2" 
<?php if (isset($PI_Q2) && $PI_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C2();"
                                   value="1" id="yesCheckPI_C2">Yes
                            <input type="radio" name="PI_Q2"
<?php if (isset($PI_Q2) && $PI_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C2();"
                                   value="0" id="noCheckPI_C2">No
                        </p>

                        <div id="ifYesPI_C2" style="display:none">
                            <textarea class="form-control"id="PI_C2" name="PI_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft37" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft37').text('500 characters left');
                                $('#PI_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft37').text('You have reached the limit');
                                        $('#characterLeft37').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft37').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft37').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckPI_C2() {
                                if (document.getElementById('yesCheckPI_C2').checked) {
                                    document.getElementById('ifYesPI_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesPI_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="PI_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer a preferred premium collection date?</label>
                            <input type="radio" name="PI_Q3" 
<?php if (isset($PI_Q3) && $PI_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C3();"
                                   value="1" id="yesCheckPI_C3">Yes
                            <input type="radio" name="PI_Q3"
                                   <?php if (isset($PI_Q3) && $PI_Q3 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckPI_C3();"
                                   value="0" id="noCheckPI_C3">No
                        </p>

                        <div id="ifYesPI_C3" style="display:none">
                            <textarea class="form-control"id="PI_C3" name="PI_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft38" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft38').text('500 characters left');
                                $('#PI_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft38').text('You have reached the limit');
                                        $('#characterLeft38').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft38').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft38').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckPI_C3() {
                                if (document.getElementById('yesCheckPI_C3').checked) {
                                    document.getElementById('ifYesPI_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesPI_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="PI_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER record the bank details correctly?</label>
                            <input type="radio" name="PI_Q4" 
<?php if (isset($PI_Q4) && $PI_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C4();"
                                   value="1" id="yesCheckPI_C4">Yes
                            <input type="radio" name="PI_Q4"
                                   <?php if (isset($PI_Q4) && $PI_Q4 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckPI_C4();"
                                   value="0" id="noCheckPI_C4">No
                        </p>

                        <div id="ifYesPI_C4" style="display:none">
                            <textarea class="form-control"id="PI_C4" name="PI_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft39" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft39').text('500 characters left');
                                $('#PI_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft39').text('You have reached the limit');
                                        $('#characterLeft39').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft39').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft39').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckPI_C4() {
                                if (document.getElementById('yesCheckPI_C4').checked) {
                                    document.getElementById('ifYesPI_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesPI_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="PI_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did they have consent off the premium payer?</label>
                            <input type="radio" name="PI_Q5" 
                                   <?php if (isset($PI_Q5) && $PI_Q5 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckPI_C5();"
                                   value="1" id="yesCheckPI_C5">Yes
                            <input type="radio" name="PI_Q5"
<?php if (isset($PI_Q5) && $PI_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckPI_C5();"
                                   value="0" id="noCheckPI_C5">No
                        </p>

                        <div id="ifYesPI_C5" style="display:none">
                            <textarea class="form-control"id="PI_C5" name="PI_C5" rows="1" cols="75" maxlength="1500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft40" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft40').text('500 characters left');
                                $('#PI_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft40').text('You have reached the limit');
                                        $('#characterLeft40').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft40').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft40').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckPI_C5() {
                                if (document.getElementById('yesCheckPI_C5').checked) {
                                    document.getElementById('ifYesPI_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesPI_C5').style.display = 'block';

                            }

                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Consolidation Declaration</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="CD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                            <input type="radio" name="CD_Q1" 
<?php if (isset($CD_Q1) && $CD_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="1" id="yesCheckCD_C1">Yes
                            <input type="radio" name="CD_Q1"
<?php if (isset($CD_Q1) && $CD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="0" id="noCheckCD_C1">No
                        </p>

                        <div id="ifYesCD_C1" style="display:none">
                            <textarea class="form-control"id="CD_C1" name="CD_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft41" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft41').text('500 characters left');
                                $('#CD_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft41').text('You have reached the limit');
                                        $('#characterLeft41').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft41').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft41').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C1() {
                                if (document.getElementById('yesCheckCD_C1').checked) {
                                    document.getElementById('ifYesCD_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C1').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="CD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                            <input type="radio" name="CD_Q2" 
<?php if (isset($CD_Q2) && $CD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="1" id="yesCheckCD_C2">Yes
                            <input type="radio" name="CD_Q2"
<?php if (isset($CD_Q2) && $CD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="0" id="noCheckCD_C2">No
                        </p>

                        <div id="ifYesCD_C2" style="display:none">
                            <textarea class="form-control"id="CD_C2" name="CD_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft42" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft42').text('500 characters left');
                                $('#CD_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft42').text('You have reached the limit');
                                        $('#characterLeft42').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft42').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft42').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C2() {
                                if (document.getElementById('yesCheckCD_C2').checked) {
                                    document.getElementById('ifYesCD_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Like mentioned earlier did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                            <input type="radio" name="CD_Q3" 
<?php if (isset($CD_Q3) && $CD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="1" id="yesCheckCD_C3">Yes
                            <input type="radio" name="CD_Q3"
<?php if (isset($CD_Q3) && $CD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="0" id="noCheckCD_C3">No
                        </p>

                        <div id="ifYesCD_C3" style="display:none">
                            <textarea class="form-control"id="CD_C3" name="CD_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft43" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft43').text('500 characters left');
                                $('#CD_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft43').text('You have reached the limit');
                                        $('#characterLeft43').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft43').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft43').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C3() {
                                if (document.getElementById('yesCheckCD_C3').checked) {
                                    document.getElementById('ifYesCD_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
                            <input type="radio" name="CD_Q4" 
<?php if (isset($CD_Q4) && $CD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="1" id="yesCheckCD_C4">Yes
                            <input type="radio" name="CD_Q4"
<?php if (isset($CD_Q4) && $CD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="0" id="noCheckCD_C4">No
                        </p>

                        <div id="ifYesCD_C4" style="display:none">
                            <textarea class="form-control"id="CD_C4" name="CD_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft44" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft44').text('500 characters left');
                                $('#CD_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft44').text('You have reached the limit');
                                        $('#characterLeft44').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft44').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft44').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C4() {
                                if (document.getElementById('yesCheckCD_C4').checked) {
                                    document.getElementById('ifYesCD_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CD_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the check your details procedure?</label>
                            <input type="radio" name="CD_Q6" 
<?php if (isset($CD_Q6) && $CD_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="1" id="yesCheckCD_C6">Yes
                            <input type="radio" name="CD_Q6"
<?php if (isset($CD_Q6) && $CD_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="0" id="noCheckCD_C6">No
                        </p>

                        <div id="ifYesCD_C6" style="display:none">
                            <textarea class="form-control"id="CD_C6" name="CD_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft46" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft46').text('500 characters left');
                                $('#CD_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft46').text('You have reached the limit');
                                        $('#characterLeft46').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft46').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft46').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C6() {
                                if (document.getElementById('yesCheckCD_C6').checked) {
                                    document.getElementById('ifYesCD_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C6').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CD_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Vitality will write to them with a more specific date?</label>
                            <input type="radio" name="CD_Q7" 
<?php if (isset($CD_Q7) && $CD_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="1" id="yesCheckCD_C7">Yes
                            <input type="radio" name="CD_Q7"
<?php if (isset($CD_Q7) && $CD_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="0" id="noCheckCD_C7">No

                        </p>

                        <div id="ifYesCD_C7" style="display:none">
                            <textarea class="form-control"id="CD_C7" name="CD_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft47" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft47').text('500 characters left');
                                $('#CD_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft47').text('You have reached the limit');
                                        $('#characterLeft47').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft47').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft47').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C7() {
                                if (document.getElementById('yesCheckCD_C7').checked) {
                                    document.getElementById('ifYesCD_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C7').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="CD_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm to the customer to cancel any existing direct debit?</label>
                            <input type="radio" name="CD_Q8" 
<?php if (isset($CD_Q8) && $CD_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="1" id="yesCheckCD_C8">Yes
                            <input type="radio" name="CD_Q8"
<?php if (isset($CD_Q8) && $CD_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="0" id="noCheckCD_C8">No
                            <input type="radio" name="CD_Q8" 
                                   <?php if (isset($CD_Q8) && $CD_Q8 == "N/A") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="N/A" id="yesCheckCD_C8">N/A
                        </p>

                        <div id="ifYesCD_C8" style="display:none">
                            <textarea class="form-control"id="CD_C8" name="CD_C8" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft48" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft48').text('500 characters left');
                                $('#CD_C8').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft48').text('You have reached the limit');
                                        $('#characterLeft48').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft48').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft48').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C8() {
                                if (document.getElementById('yesCheckCD_C8').checked) {
                                    document.getElementById('ifYesCD_C8').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C8').style.display = 'block';

                            }

                        </script>

                    </div>
                </div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Quality Control</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="QC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Vitality with client information?</label>
                            <input type="radio" name="QC_Q1" 
<?php if (isset($QC_Q1) && $QC_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_Q2();"
                                   value="1" id="yesCheckQC_Q2">Yes
                            <input type="radio" name="QC_Q1"
<?php if (isset($QC_Q1) && $QC_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_Q2();"
                                   value="0" id="noCheckQC_Q2">No
                        </p>

                        <div id="ifYesQC_C1" style="display:none">
                            <textarea class="form-control"id="QC_C1" name="QC_C1" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft49" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft49').text('500 characters left');
                                $('#QC_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft49').text('You have reached the limit');
                                        $('#characterLeft49').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft49').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft49').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C1() {
                                if (document.getElementById('yesCheckQC_Q2').checked) {
                                    document.getElementById('ifYesQC_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed length of policy in years with client confirmation?</label>
                            <input type="radio" name="QC_Q2" 
<?php if (isset($QC_Q2) && $QC_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C2();"
                                   value="1" id="yesCheckQC_C2">Yes
                            <input type="radio" name="QC_Q2"
<?php if (isset($QC_Q2) && $QC_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C2();"
                                   value="0" id="noCheckQC_C2">No
                        </p>

                        <div id="ifYesQC_C2" style="display:none">
                            <textarea class="form-control"id="QC_C2" name="QC_C2" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft50" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft50').text('500 characters left');
                                $('#QC_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft50').text('You have reached the limit');
                                        $('#characterLeft50').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft50').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft50').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C2() {
                                if (document.getElementById('yesCheckQC_C2').checked) {
                                    document.getElementById('ifYesQC_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the amount of cover on the policy with client confirmation?</label>
                            <input type="radio" name="QC_Q3" 
<?php if (isset($QC_Q3) && $QC_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C3();"
                                   value="1" id="yesCheckQC_C3">Yes
                            <input type="radio" name="QC_Q3"
<?php if (isset($QC_Q3) && $QC_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C3();"
                                   value="0" id="noCheckQC_C3">No
                        </p>

                        <div id="ifYesQC_C3" style="display:none">
                            <textarea class="form-control"id="QC_C3" name="QC_C3" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft51" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft51').text('500 characters left');
                                $('#QC_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft51').text('You have reached the limit');
                                        $('#characterLeft51').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft51').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft51').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C3() {
                                if (document.getElementById('yesCheckQC_C3').checked) {
                                    document.getElementById('ifYesQC_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed with the client that they have understood everything today with client confirmation?</label>
                            <input type="radio" name="QC_Q4" 
<?php if (isset($QC_Q4) && $QC_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C4();"
                                   value="1" id="yesCheckQC_C4">Yes
                            <input type="radio" name="QC_Q4"
<?php if (isset($QC_Q4) && $QC_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C4();"
                                   value="0" id="noCheckQC_C4">No
                        </p>

                        <div id="ifYesQC_C4" style="display:none">
                            <textarea class="form-control"id="QC_C4" name="QC_C4" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft52" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft52').text('500 characters left');
                                $('#QC_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft52').text('You have reached the limit');
                                        $('#characterLeft52').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft52').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft52').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C4() {
                                if (document.getElementById('yesCheckQC_C4').checked) {
                                    document.getElementById('ifYesQC_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the customer give their explicit consent for the policy to be set up?</label>
                            <input type="radio" name="QC_Q5" 
<?php if (isset($QC_Q5) && $QC_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C5();"
                                   value="1" id="yesCheckQC_C5">Yes
                            <input type="radio" name="QC_Q5"
<?php if (isset($QC_Q5) && $QC_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C5();"
                                   value="0" id="noCheckQC_C5">No
                        </p>

                        <div id="ifYesQC_C5" style="display:none">
                            <textarea class="form-control"id="QC_C5" name="QC_C5" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft53" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft53').text('500 characters left');
                                $('#QC_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft53').text('You have reached the limit');
                                        $('#characterLeft53').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft53').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft53').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C5() {
                                if (document.getElementById('yesCheckQC_C5').checked) {
                                    document.getElementById('ifYesQC_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C5').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer provided contact details for Bluestone Protect?</label>
                            <input type="radio" name="QC_Q6" 
<?php if (isset($QC_Q6) && $QC_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="1" id="yesCheckQC_C6">Yes
                            <input type="radio" name="QC_Q6"
<?php if (isset($QC_Q6) && $QC_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="0" id="noCheckQC_C6">No
                        </p>

                        <div id="ifYesQC_C6" style="display:none">
                            <textarea class="form-control"id="QC_C6" name="QC_C6" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft54" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft54').text('500 characters left');
                                $('#QC_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft54').text('You have reached the limit');
                                        $('#characterLeft54').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft54').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft54').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C6() {
                                if (document.getElementById('yesCheckQC_C6').checked) {
                                    document.getElementById('ifYesQC_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C6').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label>
                            <input type="radio" name="QC_Q7" 
<?php if (isset($QC_Q7) && $QC_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C7();"
                                   value="1" id="yesCheckQC_C7">Yes
                            <input type="radio" name="QC_Q7"
<?php if (isset($QC_Q7) && $QC_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C7();"
                                   value="0" id="noCheckQC_C7">No
                        </p>

                        <div id="ifYesQC_C7" style="display:none">
                            <textarea class="form-control"id="QC_C7" name="QC_C7" rows="1" cols="75" maxlength="500" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="characterLeft55" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#characterLeft55').text('500 characters left');
                                $('#QC_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#characterLeft55').text('You have reached the limit');
                                        $('#characterLeft55').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#characterLeft55').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#characterLeft55').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C7() {
                                if (document.getElementById('yesCheckQC_C7').checked) {
                                    document.getElementById('ifYesQC_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C7').style.display = 'block';

                            }

                        </script>

                    </div>
                </div>
                <br>
                
                <center>
                    <button type="submit" value="submit"  class="btn btn-success "><span class="glyphicon glyphicon-ok"></span> Submit Audit</button>
                </center>
        </form>

        
</div>  
    <script>
    document.querySelector('#AUDIT_FORM').addEventListener('submit', function (e) {
        var form = this;
        e.preventDefault();
        swal({
            title: "Vitality audit?",
            text: "Save and submit vitality audit!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: 'Complete!',
                            text: 'Vitality audit saved!',
                            type: 'success'
                        }, function () {
                            form.submit();
                        });

                    } else {
                        swal("Cancelled", "No Changes have been submitted", "error");
                    }
                });
    });

</script>
</body>
</html>