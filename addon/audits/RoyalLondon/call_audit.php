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
    <title>ADL | Royal London Call Audit</title>
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

        <form action="php/add_call_audit.php?EXECUTE=1" method="POST" id="AUDIT_FORM" name="AUDIT_FORM" autocomplete="off">

            <fieldset>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Royal London Closer Call Audit</h3>
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
                        
                        <label for="AGENT">Agent</label>
                        <input type="text" class="form-control" name="AGENT" id="AGENT" style="width: 520px">
                        
    <script>var options = {
                                                            url: "/../../app/JSON/Agents.php?EXECUTE=1&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                                                            getValue: "full_name",
                                                            list: {
                                                                match: {
                                                                    enabled: true
                                                                }
                                                            }
                                                        };
                                                        $("#AGENT").easyAutocomplete(options);</script>                         

                        <label for="POLICY">Reference</label>
                        <input type="text" class="form-control" name="REFERENCE" style="width: 520px">
                        
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
                            <label for="OD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the customer made aware that calls are recorded for training and quality purposes?</label>
                            <input type="radio" name="OD_Q1" 
                                   <?php if (isset($OD_Q1) && $OD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="1" id="yesCheckOD_C1" required >Yes
                            <input type="radio" name="OD_Q1"
<?php if (isset($OD_Q1) && $OD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C1();"
                                   value="0" id="noCheckOD_C1">No
                        </p>

                        <div id="ifYesOD_C1" style="display:none">
                            <textarea class="form-control"id="OD_C1" name="OD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckOD_C2" required >Yes
                            <input type="radio" name="OD_Q2"
<?php if (isset($OD_Q2) && $OD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C2();"
                                   value="0" id="noCheckOD_C2">No
                        </p>

                        <div id="ifYesOD_C2" style="display:none">
                            <textarea class="form-control"id="OD_C2" name="OD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckOD_C3" required >Yes
                            <input type="radio" name="OD_Q3"
<?php if (isset($OD_Q3) && $OD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C3();"
                                   value="0" id="noCheckOD_C3">No
                        </p>

                        <div id="ifYesOD_C3" style="display:none">
                            <textarea class="form-control"id="OD_C3" name="OD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckOD_C4" required >Yes
                            <input type="radio" name="OD_Q4"
<?php if (isset($OD_Q4) && $OD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C4();"
                                   value="0" id="noCheckOD_C4">No
                        </p>

                        <div id="ifYesOD_C4" style="display:none">
                            <textarea class="form-control"id="OD_C4" name="OD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckOD_C5" required >Yes
                            <input type="radio" name="OD_Q5"
<?php if (isset($OD_Q5) && $OD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOD_C5();"
                                   value="0" id="noCheckOD_C5">No
                        </p>

                        <div id="ifYesOD_C5" style="display:none">
                            <textarea class="form-control"id="OD_C5" name="OD_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_5').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                        <h3 class="panel-title">Identifying Clients Needs</h3>
                    </div>
                        <div class="panel-body">
                            
                        <p>
                            <label for="ICN_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer check the customers existing policy details?</label>
                            <input type="radio" name="ICN_Q1" 
                                   <?php if (isset($ICN_Q1) && $ICN_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="1" id="yesCheckICN_C1" required >Yes
                            <input type="radio" name="ICN_Q1"
<?php if (isset($ICN_Q1) && $ICN_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C1();"
                                   value="0" id="noCheckICN_C1">No
                            <input type="radio" name="ICN_Q1" 
                                   <?php if (isset($ICN_Q1) && $ICN_Q1 == "N/A") {
                                       echo "checked";
                                   } ?> value="N/A" id="yesCheckICN_C1" required >N/A                            
                        </p>

                        <div id="ifYesICN_C1" style="display:none">
                            <textarea class="form-control"id="ICN_C1" name="ICN_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="ICN_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer offer additional benefit or even make the customer aware of the benefits/extra's of the new policy?</label>
                            <input type="radio" name="ICN_Q2" 
                                   <?php if (isset($ICN_Q2) && $ICN_Q2 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckICN_C2();"
                                   value="1" id="yesCheckICN_C2" required >Yes
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
                            <textarea class="form-control"id="ICN_C2" name="ICN_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="ICN_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ensure that the customer was provided with a policy that met their needs (more cover, cheaper premium, extension of years etc...)?</label>
                            <input type="radio" name="ICN_Q3" 
<?php if (isset($ICN_Q3) && $ICN_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="1" id="yesCheckICN_C3" required >Yes
                            <input type="radio" name="ICN_Q3"
<?php if (isset($ICN_Q3) && $ICN_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C3();"
                                   value="0" id="noCheckICN_C3">No
                        </p>

                        <div id="ifYesICN_C3" style="display:none">
                            <textarea class="form-control"id="ICN_C3" name="ICN_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="ICN_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm that this policy would be set up with Royal London?</label>
                            <input type="radio" name="ICN_Q4" 
<?php if (isset($ICN_Q4) && $ICN_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C4();"
                                   value="1" id="yesCheckICN_C4" required >Yes
                            <input type="radio" name="ICN_Q4"
<?php if (isset($ICN_Q4) && $ICN_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckICN_C4();"
                                   value="0" id="noCheckICN_C4">No
                        </p>

                        <div id="ifYesICN_C4" style="display:none">
                            <textarea class="form-control"id="ICN_C4" name="ICN_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="ICN_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did The CLOSER provide the customer with a sufficient amount of features and benefits for the policy?</label>
                            <select class="form-control" name="ICN_Q5" onclick="javascript:yesnoCheckICN_C5();">
                                <option value="N/A">Select...</option>
                                <option value="More than sufficient">More than sufficient</option>
                                <option value="Sufficient">Sufficient</option>
                                <option value="Adequate">Adequate</option>
                                <option value="Poor" onclick="javascript:yesnoCheckICN_C5a();" id="yesCheckICN_C5">Poor</option>
                            </select>
                        </p>

                        <div id="ifYesICN_C5" style="display:none">
                            <textarea class="form-control"id="ICN_C5" name="ICN_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#ICN_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                        <h3 class="panel-title">Customer Details</h3>
                    </div>
                    <div class="panel-body">

                        <p>
                            <label for="CD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask customer titles?</label>
                            <input type="radio" name="CD_Q1" 
                                   <?php if (isset($CD_Q1) && $CD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="1" id="yesCheckCD_C1" required >Yes
                            <input type="radio" name="CD_Q1"
<?php if (isset($CD_Q1) && $CD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C1();"
                                   value="0" id="noCheckCD_C1">No
                        </p>

                        <div id="ifYesCD_C1" style="display:none">
                            <textarea class="form-control"id="CD_C1" name="CD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer phonetically check names?</label>
                            <input type="radio" name="CD_Q2" 
<?php if (isset($CD_Q2) && $CD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="1" id="yesCheckCD_C2" required >Yes
                            <input type="radio" name="CD_Q2"
<?php if (isset($CD_Q2) && $CD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C2();"
                                   value="0" id="noCheckCD_C2">No
                        </p>

                        <div id="ifYesCD_C2" style="display:none">
                            <textarea class="form-control"id="CD_C2" name="CD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask and confirm customers DOB?</label>
                            <input type="radio" name="CD_Q3" 
<?php if (isset($CD_Q3) && $CD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="1" id="yesCheckCD_C3" required >Yes
                            <input type="radio" name="CD_Q3"
<?php if (isset($CD_Q3) && $CD_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C3();"
                                   value="0" id="noCheckCD_C3">No
                        </p>

                        <div id="ifYesCD_C3" style="display:none">
                            <textarea class="form-control"id="CD_C3" name="CD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer get the customers email correct?</label>
                            <input type="radio" name="CD_Q4" 
<?php if (isset($CD_Q4) && $CD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="1" id="yesCheckCD_C4" required >Yes
                            <input type="radio" name="CD_Q4"
<?php if (isset($CD_Q4) && $CD_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C4();"
                                   value="0" id="noCheckCD_C4">No
                        </p>

                        <div id="ifYesCD_C4" style="display:none">
                            <textarea class="form-control"id="CD_C4" name="CD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers smoking question?</label>
                            <input type="radio" name="CD_Q5" 
<?php if (isset($CD_Q5) && $CD_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C5();"
                                   value="1" id="yesCheckCD_C5" required >Yes
                            <input type="radio" name="CD_Q5"
<?php if (isset($CD_Q5) && $CD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C5();"
                                   value="0" id="noCheckCD_C5">No
                        </p>

                        <div id="ifYesCD_C5" style="display:none">
                            <textarea class="form-control"id="CD_C5" name="CD_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckCD_C5() {
                                if (document.getElementById('yesCheckCD_C5').checked) {
                                    document.getElementById('ifYesCD_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesCD_C5').style.display = 'block';

                            }

                        </script>
              
<p>
                            <label for="CD_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer was a UK resident?</label>
                            <input type="radio" name="CD_Q6" 
<?php if (isset($CD_Q6) && $CD_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="1" id="yesCheckCD_C6" required >Yes
                            <input type="radio" name="CD_Q6"
<?php if (isset($CD_Q6) && $CD_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C6();"
                                   value="0" id="noCheckCD_C6">No
                        </p>

                        <div id="ifYesCD_C6" style="display:none">
                            <textarea class="form-control"id="CD_C6" name="CD_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer occupation?</label>
                            <input type="radio" name="CD_Q7" 
<?php if (isset($CD_Q7) && $CD_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="1" id="yesCheckCD_C7" required >Yes
                            <input type="radio" name="CD_Q7"
<?php if (isset($CD_Q7) && $CD_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C7();"
                                   value="0" id="noCheckCD_C7">No
                        </p>

                        <div id="ifYesCD_C7" style="display:none">
                            <textarea class="form-control"id="CD_C7" name="CD_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="CD_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer confirm the customers address?</label>
                            <input type="radio" name="CD_Q8" 
<?php if (isset($CD_Q8) && $CD_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="1" id="yesCheckCD_C8" required >Yes
                            <input type="radio" name="CD_Q8"
<?php if (isset($CD_Q8) && $CD_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckCD_C8();"
                                   value="0" id="noCheckCD_C8">No
                        </p>

                        <div id="ifYesCD_C8" style="display:none">
                            <textarea class="form-control"id="CD_C8" name="CD_C8" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#CD_C8').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                        <h3 class="panel-title">Other/existing cover</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="OTHER_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer is covered by Royal London and did they record the answer correctly?</label>
                            <input type="radio" name="OTHER_Q1" 
<?php if (isset($OTHER_Q1) && $OTHER_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOTHER_C1();"
                                   value="1" id="yesCheckOTHER_C1" required >Yes
                            <input type="radio" name="OTHER_Q1"
<?php if (isset($OTHER_Q1) && $OTHER_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOTHER_C1();"
                                   value="0" id="noCheckOTHER_C1">No
                        </p>

                        <div id="ifYesOTHER_C1" style="display:none">
                            <textarea class="form-control"id="OTHER_C1" name="OTHER_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OTHER_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOTHER_C1() {
                                if (document.getElementById('yesCheckOTHER_C1').checked) {
                                    document.getElementById('ifYesOTHER_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOTHER_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="OTHER_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has ever had an application for life insurance that was deferred or declined?</label>
                            <input type="radio" name="OTHER_Q2" 
<?php if (isset($OTHER_Q2) && $OTHER_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOTHER_C2();"
                                   value="1" id="yesCheckOTHER_C2" required >Yes
                            <input type="radio" name="OTHER_Q2"
<?php if (isset($OTHER_Q2) && $OTHER_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckOTHER_C2();"
                                   value="0" id="noCheckOTHER_C2">No
                        </p>

                        <div id="ifYesOTHER_C2" style="display:none">
                            <textarea class="form-control"id="OTHER_C2" name="OTHER_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OTHER_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckOTHER_C2() {
                                if (document.getElementById('yesCheckOTHER_C2').checked) {
                                    document.getElementById('ifYesOTHER_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesOTHER_C2').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="OTHER_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer had exiting life cover exceeding £1m or £500k critical illness?</label>
                            <input type="radio" name="OTHER_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($OTHER_Q3) && $OTHER_Q3 == "1") {
    echo "checked";
} ?>
                                   value="1" id="yesCheck" required >Yes
                            <input type="radio" name="OTHER_Q3" onclick="javascript:yesnoCheck();"
<?php if (isset($OTHER_Q3) && $OTHER_Q3 == "0") {
    echo "checked";
} ?>
                                   value="0" id="noCheck">No
                        </p>
                        <div id="ifYes" style="display:none">
                            <textarea class="form-control"id="OTHER_C3" name="OTHER_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#OTHER_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                        
                    </div>
                </div>         
                
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lifestyle</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="L_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers 'Height and Weight' and did they record the answers correctly?</label>
                            <input type="radio" name="L_Q1" 
<?php if (isset($L_Q1) && $L_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C1();"
                                   value="1" id="yesCheckL_C1" required >Yes
                            <input type="radio" name="L_Q1"
<?php if (isset($L_Q1) && $L_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C1();"
                                   value="0" id="noCheckL_C1">No
                        </p>

                        <div id="ifYesL_C1" style="display:none">
                            <textarea class="form-control"id="L_C1" name="L_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C1() {
                                if (document.getElementById('yesCheckL_C1').checked) {
                                    document.getElementById('ifYesL_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="L_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer 'Trouser/Dress size' and did they record the answers correctly?</label>
                            <input type="radio" name="L_Q2" 
<?php if (isset($L_Q2) && $L_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C2();"
                                   value="1" id="yesCheckL_C2" required >Yes
                            <input type="radio" name="L_Q2"
<?php if (isset($L_Q2) && $L_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C2();"
                                   value="0" id="noCheckL_C2">No
                           
                        </p>

                        <div id="ifYesL_C2" style="display:none">
                            <textarea class="form-control"id="L_C2" name="L_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C2() {
                                if (document.getElementById('yesCheckL_C2').checked) {
                                    document.getElementById('ifYesL_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C2').style.display = 'block';

                            }

                        </script>
                        
                        <p>
                            <label for="L_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customers 'Smoking status' and did the closer record the answer correctly?</label>
                            <input type="radio" name="L_Q3" 
<?php if (isset($L_Q3) && $L_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C3();"
                                   value="1" id="yesCheckL_C3" required >Yes
                            <input type="radio" name="L_Q3"
<?php if (isset($L_Q3) && $L_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C3();"
                                   value="0" id="noCheckL_C3">No
                           
                        </p>

                        <div id="ifYesL_C3" style="display:none">
                            <textarea class="form-control"id="L_C3" name="L_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C3() {
                                if (document.getElementById('yesCheckL_C3').checked) {
                                    document.getElementById('ifYesL_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C3').style.display = 'block';

                            }

                        </script>      
                        
  <p>
                            <label for="L_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer what the customer had smoked and how many per day in the last 12 months?</label>
                            <input type="radio" name="L_Q4" 
<?php if (isset($L_Q4) && $L_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C4();"
                                   value="1" id="yesCheckL_C4" required >Yes
                            <input type="radio" name="L_Q4"
<?php if (isset($L_Q4) && $L_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C4();"
                                   value="0" id="noCheckL_C4">No
                            
                        </p>

                        <div id="ifYesL_C4" style="display:none">
                            <textarea class="form-control"id="L_C4" name="L_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C4() {
                                if (document.getElementById('yesCheckL_C4').checked) {
                                    document.getElementById('ifYesL_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C4').style.display = 'block';

                            }

                        </script>   
                        
  <p>
                            <label for="L_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer how many units of alcohol does the customer drink per week and did they record the answers correctly?</label>
                            <input type="radio" name="L_Q5" 
<?php if (isset($L_Q5) && $L_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C5();"
                                   value="1" id="yesCheckL_C5" required >Yes
                            <input type="radio" name="L_Q5"
<?php if (isset($L_Q5) && $L_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C5();"
                                   value="0" id="noCheckL_C5">No
                           
                        </p>

                        <div id="ifYesL_C5" style="display:none">
                            <textarea class="form-control"id="L_C5" name="L_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C5() {
                                if (document.getElementById('yesCheckL_C5').checked) {
                                    document.getElementById('ifYesL_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C5').style.display = 'block';

                            }

                        </script>    
                        
  <p>
                            <label for="L_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has been advised to reduce alcohol consumption?</label>
                            <input type="radio" name="L_Q6" 
<?php if (isset($L_Q6) && $L_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C6();"
                                   value="1" id="yesCheckL_C6" required >Yes
                            <input type="radio" name="L_Q6"
<?php if (isset($L_Q6) && $L_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C6();"
                                   value="0" id="noCheckL_C6">No
                            <input type="radio" name="L_Q6" 
<?php if (isset($L_Q6) && $L_Q6 == "N/A") {
    echo "checked";
} ?>
                                   value="N/A" >N/A
                        </p>

                        <div id="ifYesL_C6" style="display:none">
                            <textarea class="form-control"id="L_C6" name="L_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C6() {
                                if (document.getElementById('yesCheckL_C6').checked) {
                                    document.getElementById('ifYesL_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C6').style.display = 'block';

                            }

                        </script>    
                        
  <p>
                            <label for="L_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer if they have taken any drugs in the last 10 years?</label>
                            <input type="radio" name="L_Q7" 
<?php if (isset($L_Q7) && $L_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C7();"
                                   value="1" id="yesCheckL_C7" required >Yes
                            <input type="radio" name="L_Q7"
<?php if (isset($L_Q7) && $L_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C7();"
                                   value="0" id="noCheckL_C7">No
                            
                        </p>

                        <div id="ifYesL_C7" style="display:none">
                            <textarea class="form-control"id="L_C7" name="L_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C7() {
                                if (document.getElementById('yesCheckL_C7').checked) {
                                    document.getElementById('ifYesL_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C7').style.display = 'block';

                            }

                        </script>   
                        
   <label for="L_Q8">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer intends to take part in any hazardous activities?</label>
                            <input type="radio" name="L_Q8" 
<?php if (isset($L_Q8) && $L_Q8 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C8();"
                                   value="1" id="yesCheckL_C8" required >Yes
                            <input type="radio" name="L_Q8"
<?php if (isset($L_Q8) && $L_Q8 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckL_C8();"
                                   value="0" id="noCheckL_C8">No
                          
                        </p>

                        <div id="ifYesL_C8" style="display:none">
                            <textarea class="form-control"id="L_C8" name="L_C8" rows="1" cols="85" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#L_C8').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckL_C8() {
                                if (document.getElementById('yesCheckL_C8').checked) {
                                    document.getElementById('ifYesL_C8').style.display = 'none';
                                } else
                                    document.getElementById('ifYesL_C8').style.display = 'block';

                            }

                        </script>                         
                        
                    </div>
                </div>                      
                         
 <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Occupation</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="O_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customers current job involves manual work or driving?</label>
                            <input type="radio" name="O_Q1" 
                                   <?php if (isset($O_Q1) && $O_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckO_C1();"
                                   value="1" id="yesCheckO_C1" required >Yes
                            <input type="radio" name="O_Q1"
<?php if (isset($O_Q1) && $O_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C1();"
                                   value="0" id="noCheckO_C1">No
                        </p>

                        <div id="ifYesO_C1" style="display:none">
                            <textarea class="form-control"id="O_C1" name="O_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#O_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckO_C1() {
                                if (document.getElementById('yesCheckO_C1').checked) {
                                    document.getElementById('ifYesO_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesO_C1').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="O_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer is involved in any of the hazardous activities listed?</label>
                            <input type="radio" name="O_Q2" 
<?php if (isset($O_Q2) && $O_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C2();"
                                   value="1" id="yesCheckO_C2" required >Yes
                            <input type="radio" name="O_Q2"
<?php if (isset($O_Q2) && $O_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C2();"
                                   value="0" id="noCheckO_C2">No
                        </p>

                        <div id="ifYesO_C2" style="display:none">
                            <textarea class="form-control"id="O_C2" name="O_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#O_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckO_C2() {
                                if (document.getElementById('yesCheckO_C2').checked) {
                                    document.getElementById('ifYesO_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesO_C2').style.display = 'block';

                            }
                        </script>

                        <p>
                            <label for="O_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask if the customer has lived, worked or travelled to the listed areas during the last two years?</label>
                            <input type="radio" name="O_Q3" 
<?php if (isset($O_Q3) && $O_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C3();"
                                   value="1" id="yesCheckO_C3" required >Yes
                            <input type="radio" name="O_Q3"
<?php if (isset($O_Q3) && $O_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckO_C3();"
                                   value="0" id="noCheckO_C3">No
                        </p>

                        <div id="ifYesO_C3" style="display:none">
                            <textarea class="form-control"id="O_C3" name="O_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#O_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckO_C3() {
                                if (document.getElementById('yesCheckO_C3').checked) {
                                    document.getElementById('ifYesO_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesO_C3').style.display = 'block';

                            }
                        </script>
                       
                    </div>
                </div> 
                
 <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Health</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="H_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask all the "Have you ever had or do you currently have" health questions and did they record the answers correctly?</label>
                            <input type="radio" name="H_Q1" 
<?php if (isset($H_Q1) && $H_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C1();"
                                   value="1" id="yesCheckH_C1" required >Yes
                            <input type="radio" name="H_Q1"
<?php if (isset($H_Q1) && $H_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C1();"
                                   value="0" id="noCheckH_C1">No
                        </p>

                        <div id="ifYesH_C1" style="display:none">
                            <textarea class="form-control"id="H_C1" name="H_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckH_C1() {
                                if (document.getElementById('yesCheckH_C1').checked) {
                                    document.getElementById('ifYesH_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesH_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="H_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask all the "any condition in the last 5 years" health questions and did the closer record the answers correctly?</label>
                            <input type="radio" name="H_Q2" 
<?php if (isset($H_Q2) && $H_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C2();"
                                   value="1" id="yesCheckH_C2" required >Yes
                            <input type="radio" name="H_Q2"
<?php if (isset($H_Q2) && $H_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C2();"
                                   value="0" id="noCheckH_C2">No
                          
                        </p>

                        <div id="ifYesH_C2" style="display:none">
                            <textarea class="form-control"id="H_C2" name="H_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckH_C2() {
                                if (document.getElementById('yesCheckH_C2').checked) {
                                    document.getElementById('ifYesH_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesH_C2').style.display = 'block';

                            }

                        </script>
                        
                        <p>
                            <label for="H_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask all the "any condition in the last 3 years" health questions and did the closer record the answers correctly?</label>
                            <input type="radio" name="H_Q3" 
<?php if (isset($H_Q3) && $H_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C3();"
                                   value="1" id="yesCheckH_C3" required >Yes
                            <input type="radio" name="H_Q3"
<?php if (isset($H_Q3) && $H_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckH_C3();"
                                   value="0" id="noCheckH_C3">No
                          
                        </p>

                        <div id="ifYesH_C3" style="display:none">
                            <textarea class="form-control"id="H_C3" name="H_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#H_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckH_C3() {
                                if (document.getElementById('yesCheckH_C3').checked) {
                                    document.getElementById('ifYesH_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesH_C3').style.display = 'block';

                            }

                        </script>                        
                        
                    </div>
                </div>   
                
 <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Family history</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="FAM_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Did the closer ask the customer's family history and did they record the answers correctly?</label>
                            <input type="radio" name="FAM_Q1" 
<?php if (isset($FAM_Q1) && $FAM_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckFAMC1();"
                                   value="1" id="yesCheckFAMC1" required >Yes
                            <input type="radio" name="FAM_Q1"
<?php if (isset($FAM_Q1) && $FAM_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckFAMC1();"
                                   value="0" id="noCheckFAMC1">No
                        </p>

                        <div id="ifYesFAMC1" style="display:none">
                            <textarea class="form-control"id="FAMC1" name="FAMC1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#FAMC1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckFAMC1() {
                                if (document.getElementById('yesCheckFAMC1').checked) {
                                    document.getElementById('ifYesFAMC1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesFAMC1').style.display = 'block';

                            }

                        </script>
                        
                    </div>
                </div>      
              
<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bank details</h3>
                    </div>
                    <div class="panel-body">
                        
                        <p>
                            <label for="BD_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Was the clients policy start date accurately recorded?</label>
                            <input type="radio" name="BD_Q1" 
                                   <?php if (isset($BD_Q1) && $BD_Q1 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C1();"
                                   value="1" id="yesCheckBD_C1" required >Yes
                            <input type="radio" name="BD_Q1"
<?php if (isset($BD_Q1) && $BD_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C1();"
                                   value="0" id="noCheckBD_C1">No
                        </p>

                        <div id="ifYesBD_C1" style="display:none">
                            <textarea class="form-control"id="BD_C1" name="BD_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckBD_C1() {
                                if (document.getElementById('yesCheckBD_C1').checked) {
                                    document.getElementById('ifYesBD_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesBD_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="BD_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer to read the direct debit guarantee?</label>
                            <input type="radio" name="BD_Q2" 
<?php if (isset($BD_Q2) && $BD_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C2();"
                                   value="1" id="yesCheckBD_C2" required >Yes
                            <input type="radio" name="BD_Q2"
<?php if (isset($BD_Q2) && $BD_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C2();"
                                   value="0" id="noCheckBD_C2">No
                        </p>

                        <div id="ifYesBD_C2" style="display:none">
                            <textarea class="form-control"id="BD_C2" name="BD_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckBD_C2() {
                                if (document.getElementById('yesCheckBD_C2').checked) {
                                    document.getElementById('ifYesBD_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesBD_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="BD_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER offer a preferred premium collection date?</label>
                            <input type="radio" name="BD_Q3" 
<?php if (isset($BD_Q3) && $BD_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C3();"
                                   value="1" id="yesCheckBD_C3" required >Yes
                            <input type="radio" name="BD_Q3"
                                   <?php if (isset($BD_Q3) && $BD_Q3 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C3();"
                                   value="0" id="noCheckBD_C3">No
                        </p>

                        <div id="ifYesBD_C3" style="display:none">
                            <textarea class="form-control"id="BD_C3" name="BD_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckBD_C3() {
                                if (document.getElementById('yesCheckBD_C3').checked) {
                                    document.getElementById('ifYesBD_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesBD_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="BD_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER record the bank details correctly?</label>
                            <input type="radio" name="BD_Q4" 
<?php if (isset($BD_Q4) && $BD_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C4();"
                                   value="1" id="yesCheckBD_C4" required >Yes
                            <input type="radio" name="BD_Q4"
                                   <?php if (isset($BD_Q4) && $BD_Q4 == "0") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C4();"
                                   value="0" id="noCheckBD_C4">No
                        </p>

                        <div id="ifYesBD_C4" style="display:none">
                            <textarea class="form-control"id="BD_C4" name="BD_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckBD_C4() {
                                if (document.getElementById('yesCheckBD_C4').checked) {
                                    document.getElementById('ifYesBD_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesBD_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="BD_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Did they have consent off the premium payer?</label>
                            <input type="radio" name="BD_Q5" 
                                   <?php if (isset($BD_Q5) && $BD_Q5 == "1") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckBD_C5();"
                                   value="1" id="yesCheckBD_C5" required >Yes
                            <input type="radio" name="BD_Q5"
<?php if (isset($BD_Q5) && $BD_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckBD_C5();"
                                   value="0" id="noCheckBD_C5">No
                        </p>

                        <div id="ifYesBD_C5" style="display:none">
                            <textarea class="form-control"id="BD_C5" name="BD_C5" rows="1" cols="75" maxlength="11000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#BD_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckBD_C5() {
                                if (document.getElementById('yesCheckBD_C5').checked) {
                                    document.getElementById('ifYesBD_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesBD_C5').style.display = 'block';

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
                            <label for="DEC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label>
                            <input type="radio" name="DEC_Q1" 
<?php if (isset($DEC_Q1) && $DEC_Q1 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C1();"
                                   value="1" id="yesCheckDEC_C1" required >Yes
                            <input type="radio" name="DEC_Q1"
<?php if (isset($DEC_Q1) && $DEC_Q1 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C1();"
                                   value="0" id="noCheckDEC_C1">No
                        </p>

                        <div id="ifYesDEC_C1" style="display:none">
                            <textarea class="form-control"id="DEC_C1" name="DEC_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C1').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C1() {
                                if (document.getElementById('yesCheckDEC_C1').checked) {
                                    document.getElementById('ifYesDEC_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C1').style.display = 'block';

                            }

                        </script>


                        <p>
                            <label for="DEC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label>
                            <input type="radio" name="DEC_Q2" 
<?php if (isset($DEC_Q2) && $DEC_Q2 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C2();"
                                   value="1" id="yesCheckDEC_C2" required >Yes
                            <input type="radio" name="DEC_Q2"
<?php if (isset($DEC_Q2) && $DEC_Q2 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C2();"
                                   value="0" id="noCheckDEC_C2">No
                        </p>

                        <div id="ifYesDEC_C2" style="display:none">
                            <textarea class="form-control"id="DEC_C2" name="DEC_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C2').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C2() {
                                if (document.getElementById('yesCheckDEC_C2').checked) {
                                    document.getElementById('ifYesDEC_C2').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C2').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DEC_Q3">Q<?php echo $QUESTION_NUMBER++; ?>. Like mentioned earlier did the CLOSER make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label>
                            <input type="radio" name="DEC_Q3" 
<?php if (isset($DEC_Q3) && $DEC_Q3 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C3();"
                                   value="1" id="yesCheckDEC_C3" required >Yes
                            <input type="radio" name="DEC_Q3"
<?php if (isset($DEC_Q3) && $DEC_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C3();"
                                   value="0" id="noCheckDEC_C3">No
                        </p>

                        <div id="ifYesDEC_C3" style="display:none">
                            <textarea class="form-control"id="DEC_C3" name="DEC_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C3').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C3() {
                                if (document.getElementById('yesCheckDEC_C3').checked) {
                                    document.getElementById('ifYesDEC_C3').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C3').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DEC_Q4">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>
                            <input type="radio" name="DEC_Q4" 
<?php if (isset($DEC_Q4) && $DEC_Q4 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C4();"
                                   value="1" id="yesCheckDEC_C4" required >Yes
                            <input type="radio" name="DEC_Q4"
<?php if (isset($DEC_Q4) && $DEC_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C4();"
                                   value="0" id="noCheckDEC_C4">No
                        </p>

                        <div id="ifYesDEC_C4" style="display:none">
                            <textarea class="form-control"id="DEC_C4" name="DEC_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C4').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C4() {
                                if (document.getElementById('yesCheckDEC_C4').checked) {
                                    document.getElementById('ifYesDEC_C4').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C4').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DEC_Q5">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed the check your details procedure?</label>
                            <input type="radio" name="DEC_Q5" 
<?php if (isset($DEC_Q5) && $DEC_Q5 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C5();"
                                   value="1" id="yesCheckDEC_C5" required >Yes
                            <input type="radio" name="DEC_Q5"
<?php if (isset($DEC_Q5) && $DEC_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C5();"
                                   value="0" id="noCheckDEC_C5">No
                        </p>

                        <div id="ifYesDEC_C5" style="display:none">
                            <textarea class="form-control"id="DEC_C5" name="DEC_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C5').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C5() {
                                if (document.getElementById('yesCheckDEC_C5').checked) {
                                    document.getElementById('ifYesDEC_C5').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C5').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DEC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but Royal London will write to them with a more specific date?</label>
                            <input type="radio" name="DEC_Q6" 
<?php if (isset($DEC_Q6) && $DEC_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C6();"
                                   value="1" id="yesCheckDEC_C6" required >Yes
                            <input type="radio" name="DEC_Q6"
<?php if (isset($DEC_Q6) && $DEC_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C6();"
                                   value="0" id="noCheckDEC_C6">No

                        </p>

                        <div id="ifYesDEC_C6" style="display:none">
                            <textarea class="form-control"id="DEC_C6" name="DEC_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C6').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_47').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C6() {
                                if (document.getElementById('yesCheckDEC_C6').checked) {
                                    document.getElementById('ifYesDEC_C6').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C6').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="DEC_Q7">Q<?php echo $QUESTION_NUMBER++; ?>. Did the CLOSER confirm to the customer to cancel any existing direct debit?</label>
                            <input type="radio" name="DEC_Q7" 
<?php if (isset($DEC_Q7) && $DEC_Q7 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="1" id="yesCheckDEC_C7" required >Yes
                            <input type="radio" name="DEC_Q7"
<?php if (isset($DEC_Q7) && $DEC_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="0" id="noCheckDEC_C7">No
                            <input type="radio" name="DEC_Q7" 
                                   <?php if (isset($DEC_Q7) && $DEC_Q7 == "N/A") {
                                       echo "checked";
                                   } ?> onclick="javascript:yesnoCheckDEC_C7();"
                                   value="N/A" id="yesCheckDEC_C7">N/A
                        </p>

                        <div id="ifYesDEC_C7" style="display:none">
                            <textarea class="form-control"id="DEC_C7" name="DEC_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#DEC_C7').keydown(function () {
                                    var max = 1000;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckDEC_C7() {
                                if (document.getElementById('yesCheckDEC_C7').checked) {
                                    document.getElementById('ifYesDEC_C7').style.display = 'none';
                                } else
                                    document.getElementById('ifYesDEC_C7').style.display = 'block';

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
                            <label for="QC_Q1">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with Royal London with client information?</label>
                            <input type="radio" name="QC_Q1" <?php if (isset($QC_Q1) && $QC_Q1 == "1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQC_C1();" value="1" id="yesCheckQC_Q1" required>Yes
                            <input type="radio" name="QC_Q1" <?php if (isset($QC_Q1) && $QC_Q1 == "0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQC_C1();" value="0" id="noCheckQC_Q1">No
                        </p>

                        <div id="ifYesQC_C1" style="display:none">
                            <textarea class="form-control"id="QC_C1" name="QC_C1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C1').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
                                    }
                                });
                            });
                        </script>
                        <script type="text/javascript">

                            function yesnoCheckQC_C1() {
                                if (document.getElementById('yesCheckQC_Q1').checked) {
                                    document.getElementById('ifYesQC_C1').style.display = 'none';
                                } else
                                    document.getElementById('ifYesQC_C1').style.display = 'block';

                            }

                        </script>

                        <p>
                            <label for="QC_Q2">Q<?php echo $QUESTION_NUMBER++; ?>. Closer confirmed length of policy in years with client confirmation?</label>
                            <input type="radio" name="QC_Q2" <?php if (isset($QC_Q2) && $QC_Q2 == "1") { echo "checked"; } ?> onclick="javascript:yesnoCheckQC_C2();" value="1" id="yesCheckQC_C2" required >Yes
                            <input type="radio" name="QC_Q2" <?php if (isset($QC_Q2) && $QC_Q2 == "0") { echo "checked"; } ?> onclick="javascript:yesnoCheckQC_C2();" value="0" id="noCheckQC_C2">No
                        </p>

                        <div id="ifYesQC_C2" style="display:none">
                            <textarea class="form-control"id="QC_C2" name="QC_C2" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C2').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckQC_C3" required >Yes
                            <input type="radio" name="QC_Q3"
<?php if (isset($QC_Q3) && $QC_Q3 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C3();"
                                   value="0" id="noCheckQC_C3">No
                        </p>

                        <div id="ifYesQC_C3" style="display:none">
                            <textarea class="form-control"id="QC_C3" name="QC_C3" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C3').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckQC_C4" required >Yes
                            <input type="radio" name="QC_Q4"
<?php if (isset($QC_Q4) && $QC_Q4 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C4();"
                                   value="0" id="noCheckQC_C4">No
                        </p>

                        <div id="ifYesQC_C4" style="display:none">
                            <textarea class="form-control"id="QC_C4" name="QC_C4" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C4').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckQC_C5" required >Yes
                            <input type="radio" name="QC_Q5"
<?php if (isset($QC_Q5) && $QC_Q5 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C5();"
                                   value="0" id="noCheckQC_C5">No
                        </p>

                        <div id="ifYesQC_C5" style="display:none">
                            <textarea class="form-control"id="QC_C5" name="QC_C5" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C5').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                            <label for="QC_Q6">Q<?php echo $QUESTION_NUMBER++; ?>. Closer provided contact details for <?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>?</label>
                            <input type="radio" name="QC_Q6" 
<?php if (isset($QC_Q6) && $QC_Q6 == "1") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="1" id="yesCheckQC_C6" required >Yes
                            <input type="radio" name="QC_Q6"
<?php if (isset($QC_Q6) && $QC_Q6 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C6();"
                                   value="0" id="noCheckQC_C6">No
                        </p>

                        <div id="ifYesQC_C6" style="display:none">
                            <textarea class="form-control"id="QC_C6" name="QC_C6" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C6').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
                                   value="1" id="yesCheckQC_C7" required >Yes
                            <input type="radio" name="QC_Q7"
<?php if (isset($QC_Q7) && $QC_Q7 == "0") {
    echo "checked";
} ?> onclick="javascript:yesnoCheckQC_C7();"
                                   value="0" id="noCheckQC_C7">No
                        </p>

                        <div id="ifYesQC_C7" style="display:none">
                            <textarea class="form-control"id="QC_C7" name="QC_C7" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"></textarea><span class="help-block"><p id="CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('1000 characters left');
                                $('#QC_C7').keydown(function () {
                                    var max = 500;
                                    var len = $(this).val().length;
                                    if (len >= max) {
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text('You have reached the limit');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').addClass('red');
                                        $('#btnSubmit').addClass('disabled');
                                    } else {
                                        var ch = max - len;
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').text(ch + ' characters left');
                                        $('#btnSubmit').removeClass('disabled');
                                        $('#CHARS_LEFT_ID_<?php echo $QUESTION_NUMBER; ?>').removeClass('red');
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
            title: "Royal London audit?",
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
                            text: 'Royal London audit saved!',
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