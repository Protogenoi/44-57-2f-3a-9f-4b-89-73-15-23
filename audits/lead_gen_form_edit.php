<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
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

if ($ffaudits == '0') {

    header('Location: /../CRMmain.php');
    die;
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../CRMmain.php');
    die;
}

$auditid = filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Lead Gen Audit Edit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/datatables/css/layoutcrm.css" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="/EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 
    <script src="/EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 
    <style type="text/css">
        .editclient{
            margin: 20px;
        }
    </style>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
</head>
<body>

    <?php
    require_once(__DIR__ . '/../includes/navbar.php');


    $new = filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);
    $newauditid = filter_input(INPUT_POST, 'editid', FILTER_SANITIZE_NUMBER_INT);

    if (!isset($newauditid)) {

        $newauditid = filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
    }

    if ($new == 'y') {

        $new = filter_input(INPUT_GET, 'new', FILTER_SANITIZE_SPECIAL_CHARS);
        ?>


        <div class="container">
            <div class="notice notice-warning">
                <strong>Warning!</strong> You Are Now Editing Call Audit ID <?php echo $newauditid ?> | Being edited by <?php echo $hello_name ?>.
            </div>
            <br>
            <form class="form-horizontal" name="newformedit" id="newformedit" method="POST" action="php/lead_gen_edit_submit.php?newedit=y">
                <fieldset>


                    <legend>Audit questions (Lead Gen)</legend>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-headphones"></span> Opening Section 1</h3>
                        </div>

                        <div class="panel-body">

    <?php
    $query = $pdo->prepare("SELECT an_number, q1s4q1n, q1s4c1n, id, agent, grade, sq1, sq2, sq3, sq4, sq5, s2aq1, s2aq2, s2aq3, s2aq4, s2aq5, s2aq6, s2aq7, s2aq8, s2aq9, s2aq10, s2aq11, s2bq1, q1s2bc1, q2s2bq2, q1s3q1, q2s2bc2, q1s3c1 from Audit_LeadGen where id =:newidholder");
    $query->bindParam(':newidholder', $newauditid, PDO::PARAM_INT);
    $query->execute()or die(print_r($query->errorInfo(), true));
    $neweditaudits = $query->fetch(PDO::FETCH_ASSOC);

    $QUES = $pdo->prepare("SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14 ,q15 FROM Audit_LeadGen_Comments WHERE audit_id=:id");
    $QUES->bindParam(':id', $newauditid, PDO::PARAM_INT);
    $QUES->execute()or die(print_r($QUES->errorInfo(), true));
    $QUES_RESULTS = $QUES->fetch(PDO::FETCH_ASSOC);

    $q1 = $QUES_RESULTS['q1'];
    $q2 = $QUES_RESULTS['q2'];
    $q3 = $QUES_RESULTS['q3'];
    $q4 = $QUES_RESULTS['q4'];
    $q5 = $QUES_RESULTS['q5'];
    $q6 = $QUES_RESULTS['q6'];
    $q7 = $QUES_RESULTS['q7'];
    $q8 = $QUES_RESULTS['q8'];
    $q9 = $QUES_RESULTS['q9'];
    $q10 = $QUES_RESULTS['q10'];
    $q11 = $QUES_RESULTS['q11'];
    $q12 = $QUES_RESULTS['q12'];
    $q13 = $QUES_RESULTS['q13'];
    $q14 = $QUES_RESULTS['q14'];
    $q15 = $QUES_RESULTS['q15'];

    $anval = $neweditaudits['an_number'];
    ?>
                            <div class='form-group'>
                                <label class='col-md-4 control-label' for='annumber'>AN Number</label>  
                                <div class='col-md-4'>
                                    <input id='annumber' name='annumber' placeholder='AN Number' class='form-control input-md' <?php if (isset($anval)) {
                            echo "value='$anval'";
                        } ?> type='text'>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="agent">Lead Gen</label>  
                                <div class="col-md-4">
                                    <input id="provider-json" name='agent' class='form-control' required placeholder="Lead Gen" class="form-control input-md" type="text" <?php if (isset($neweditaudits['agent'])) {
                            echo "value='$neweditaudits[agent]'";
                        } ?>>
                                </div>
                            </div>

                            <script>var options = {
                                    url: "../JSON/LeadGenNames.json",
                                    getValue: "full_name",

                                    list: {
                                        match: {
                                            enabled: true
                                        }
                                    }
                                };

                                $("#provider-json").easyAutocomplete(options);</script>

                            <?php
                            echo "<div class='form-group'>";
                            echo "<label class='col-md-4 control-label' for='grade'>Grade:</label>";
                            echo "<div class='col-md-4'>";
                            echo "<select class='form-control' name='grade'>";
                            echo "<option value='" . $neweditaudits['grade'] . "'>" . $neweditaudits['grade'] . "</option>";
                            ?>
                            <option value='Green'>Green</option>
                            <option value='Amber'>Amber</option>
                            <option value='Red'>Red</option>
                            </select>
                        </div>
                    </div>


                    <input type="hidden" name="editidsent" value="<?php echo $neweditaudits['id'] ?>">



                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name">Q1. Agent said their name</label>
                        <div class="col-md-4"> 
                            <label class="radio-inline" for="sq1">
                                <input name="sq1" id="name-0" value="Yes" type="radio" <?php if ($neweditaudits['sq1'] == "Yes") echo "checked" ?>>
                                Yes
                            </label> 
                            <label class="radio-inline" for="sq1">
                                <input name="sq1" id="name-Yes" value="No" type="radio" <?php if ($neweditaudits['sq1'] == "No") echo "checked" ?>>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="c1"></label>
                        <div class="col-md-4">                     
                            <textarea class="form-control" id="q1TEXT" name="q1TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q1)) {
                            echo $q1;
                        } ?></textarea>
                            <span class="help-block"><p id="q1LEFT" class="help-block ">You have reached the limit</p></span>
                            <script>
                                $(document).ready(function () {
                                    $('#q1LEFT').text('400 characters left');
                                    $('#q1TEXT').keydown(function () {
                                        var max = 400;
                                        var len = $(this).val().length;
                                        if (len >= max) {
                                            $('#q1LEFT').text('You have reached the limit');
                                            $('#q1LEFT').addClass('red');
                                            $('#btnSubmit').addClass('disabled');
                                        } else {
                                            var ch = max - len;
                                            $('#q1LEFT').text(ch + ' characters left');
                                            $('#btnSubmit').removeClass('disabled');
                                            $('#q1LEFT').removeClass('red');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="calling">Q2. Said where they were calling from</label>
                        <div class="col-md-4"> 
                            <label class="radio-inline" for="sq1">
                                <input name="sq2" id="sq1" value="Yes" type="radio" <?php if ($neweditaudits['sq2'] == "Yes") echo "checked" ?>>
                                Yes
                            </label> 
                            <label class="radio-inline" for="sq1">
                                <input name="sq2" id="sq1" value="No" type="radio" <?php if ($neweditaudits['sq2'] == "No") echo "checked" ?>>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="c2"></label>
                        <div class="col-md-4">                     
                            <textarea class="form-control" id="q2TEXT" name="q2TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q2)) {
                            echo $q2;
                        } ?></textarea>
                            <span class="help-block"><p id="q2LEFT" class="help-block ">You have reached the limit</p></span>
                            <script>
                                $(document).ready(function () {
                                    $('#q2LEFT').text('400 characters left');
                                    $('#q2TEXT').keydown(function () {
                                        var max = 400;
                                        var len = $(this).val().length;
                                        if (len >= max) {
                                            $('#q2LEFT').text('You have reached the limit');
                                            $('#q2LEFT').addClass('red');
                                            $('#btnSubmit').addClass('disabled');
                                        } else {
                                            var ch = max - len;
                                            $('#q2LEFT').text(ch + ' characters left');
                                            $('#btnSubmit').removeClass('disabled');
                                            $('#q2LEFT').removeClass('red');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="reason">Q3. Said the reason for the call</label>
                        <div class="col-md-4"> 
                            <label class="radio-inline" for="sq3">
                                <input name="sq3" id="sq3" value="Yes" type="radio" <?php if ($neweditaudits['sq3'] == "Yes") echo "checked" ?>>
                                Yes
                            </label> 
                            <label class="radio-inline" for="sq3">
                                <input name="sq3" id="sq3" value="No" type="radio" <?php if ($neweditaudits['sq3'] == "No") echo "checked" ?>>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="c2"></label>
                        <div class="col-md-4">                     
                            <textarea class="form-control" id="q3TEXT" name="q3TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q3)) {
                            echo $q3;
                        } ?></textarea>
                            <span class="help-block"><p id="q3LEFT" class="help-block ">You have reached the limit</p></span>
                            <script>
                                $(document).ready(function () {
                                    $('#q3LEFT').text('400 characters left');
                                    $('#q3TEXT').keydown(function () {
                                        var max = 400;
                                        var len = $(this).val().length;
                                        if (len >= max) {
                                            $('#q3LEFT').text('You have reached the limit');
                                            $('#q3LEFT').addClass('red');
                                            $('#btnSubmit').addClass('disabled');
                                        } else {
                                            var ch = max - len;
                                            $('#q3LEFT').text(ch + ' characters left');
                                            $('#btnSubmit').removeClass('disabled');
                                            $('#q3LEFT').removeClass('red');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label" for="sq4">Q4. Used EU gender directive correctly</label>
                        <div class="col-md-4"> 
                            <label class="radio-inline" for="sq4">
                                <input name="sq4" id="directive-0" value="Yes" type="radio" <?php if ($neweditaudits['sq4'] == "Yes") echo "checked" ?>>
                                Yes
                            </label> 
                            <label class="radio-inline" for="sq4">
                                <input name="sq4" id="directive-Yes" value="No" type="radio" <?php if ($neweditaudits['sq4'] == "No") echo "checked" ?>>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="c2"></label>
                        <div class="col-md-4">                     
                            <textarea class="form-control" id="q4TEXT" name="q4TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q4)) {
                            echo $q4;
                        } ?></textarea>
                            <span class="help-block"><p id="q4LEFT" class="help-block ">You have reached the limit</p></span>
                            <script>
                                $(document).ready(function () {
                                    $('#q4LEFT').text('400 characters left');
                                    $('#q4TEXT').keydown(function () {
                                        var max = 400;
                                        var len = $(this).val().length;
                                        if (len >= max) {
                                            $('#q4LEFT').text('You have reached the limit');
                                            $('#q4LEFT').addClass('red');
                                            $('#btnSubmit').addClass('disabled');
                                        } else {
                                            var ch = max - len;
                                            $('#q4LEFT').text(ch + ' characters left');
                                            $('#btnSubmit').removeClass('disabled');
                                            $('#q4LEFT').removeClass('red');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="sq5">Q5. Agent followed the script</label>
                        <div class="col-md-4"> 
                            <label class="radio-inline" for="sq5">
                                <input name="sq5" id="directive-0" value="Yes" type="radio" <?php if ($neweditaudits['sq5'] == "Yes") echo "checked" ?>>
                                Yes
                            </label> 
                            <label class="radio-inline" for="sq5">
                                <input name="sq5" id="directive-Yes" value="No" type="radio" <?php if ($neweditaudits['sq5'] == "No") echo "checked" ?>>
                                No
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="c2"></label>
                        <div class="col-md-4">                     
                            <textarea class="form-control" id="q5TEXT" name="q5TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q5)) {
                            echo $q5;
                        } ?></textarea>
                            <span class="help-block"><p id="q5LEFT" class="help-block ">You have reached the limit</p></span>
                            <script>
                                $(document).ready(function () {
                                    $('#q5LEFT').text('400 characters left');
                                    $('#q5TEXT').keydown(function () {
                                        var max = 400;
                                        var len = $(this).val().length;
                                        if (len >= max) {
                                            $('#q5LEFT').text('You have reached the limit');
                                            $('#q5LEFT').addClass('red');
                                            $('#btnSubmit').addClass('disabled');
                                        } else {
                                            var ch = max - len;
                                            $('#q5LEFT').text(ch + ' characters left');
                                            $('#btnSubmit').removeClass('disabled');
                                            $('#q5LEFT').removeClass('red');
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    </div>
                    </div>

                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h3 class="panel-title">Qualifying Section 2a</h3>
                        </div>
                        <div class="panel-body">


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq1">Q1. Were all the questions asked?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq1">
                                        <input name="s2aq1" id="s2aq1yes" value="Yes" type="radio" onclick="javascript:yesnoqual();" <?php if ($neweditaudits['s2aq1'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq1">
                                        <input name="s2aq1" id="s2aq1no" value="No" type="radio" onclick="javascript:yesnoqual();" <?php if ($neweditaudits['s2aq1'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq2">Q2. What was the main reason you took the policy out?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq2">
                                        <input name="s2aq2" id="radios-0" value="Yes" type="radio" <?php if ($neweditaudits['s2aq2'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq2">
                                        <input name="s2aq2" id="radios-Yes" value="No"  type="radio" <?php if ($neweditaudits['s2aq2'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q6TEXT" name="q6TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q6)) {
                            echo $q6;
                        } ?></textarea>
                                    <span class="help-block"><p id="q6LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q6LEFT').text('400 characters left');
                                            $('#q6TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q6LEFT').text('You have reached the limit');
                                                    $('#q6LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q6LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q6LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq2">Q3. Repayment or interest only?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq2">
                                        <input name="s2aq3" id="s2aq2" value="Yes" type="radio" <?php if ($neweditaudits['s2aq3'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq2">
                                        <input name="s2aq3" id="s2aq2" value="No"  type="radio" <?php if ($neweditaudits['s2aq3'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q7TEXT" name="q7TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q7)) {
                            echo $q7;
                        } ?></textarea>
                                    <span class="help-block"><p id="q7LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q7LEFT').text('400 characters left');
                                            $('#q7TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q7LEFT').text('You have reached the limit');
                                                    $('#q7LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q7LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q7LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq4">Q4. When was your last review on the policy?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq4">
                                        <input name="s2aq4" id="s2aq4" value="Yes" type="radio" <?php if ($neweditaudits['s2aq4'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq4">
                                        <input name="s2aq4" id="s2aq4" value="No"  type="radio" <?php if ($neweditaudits['s2aq4'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q8TEXT" name="q8TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q8)) {
                            echo $q8;
                        } ?></textarea>
                                    <span class="help-block"><p id="q8LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q8LEFT').text('400 characters left');
                                            $('#q8TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q8LEFT').text('You have reached the limit');
                                                    $('#q8LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q8LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q8LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq5">Q5. How did you take out the policy?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq5">
                                        <input name="s2aq5" id="s2aq5" value="Yes" type="radio" <?php if ($neweditaudits['s2aq5'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq5">
                                        <input name="s2aq5" id="s2aq5" value="No"  type="radio" <?php if ($neweditaudits['s2aq5'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q9TEXT" name="q9TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q9)) {
                            echo $q9;
                        } ?></textarea>
                                    <span class="help-block"><p id="q9LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q9LEFT').text('400 characters left');
                                            $('#q9TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q9LEFT').text('You have reached the limit');
                                                    $('#q9LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q9LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q9LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq6">Q6. How much are you paying on a monthly basis?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq6">
                                        <input name="s2aq6" id="s2aq6" value="Yes" type="radio" <?php if ($neweditaudits['s2aq6'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="radios-Yes">
                                        <input name="s2aq6" id="s2aq6" value="No" type="radio" <?php if ($neweditaudits['s2aq6'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q10TEXT" name="q10TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q10)) {
                            echo $q10;
                        } ?></textarea>
                                    <span class="help-block"><p id="q10LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q10LEFT').text('400 characters left');
                                            $('#q10TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q10LEFT').text('You have reached the limit');
                                                    $('#q10LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q10LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q10LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq7">Q7. How much are you covered for?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq7">
                                        <input name="s2aq7" id="s2aq7" value="Yes" type="radio" <?php if ($neweditaudits['s2aq7'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="radios-Yes">
                                        <input name="s2aq7" id="s2aq7" value="No"  type="radio" <?php if ($neweditaudits['s2aq7'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q11TEXT" name="q11TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q11)) {
                            echo $q11;
                        } ?></textarea>
                                    <span class="help-block"><p id="q11LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q11LEFT').text('400 characters left');
                                            $('#q11TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q11LEFT').text('You have reached the limit');
                                                    $('#q11LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q11LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q11LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq8">Q8. How long do you have left on the policy?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="radios-0">
                                        <input name="s2aq8" id="s2aq8" value="Yes" type="radio" <?php if ($neweditaudits['s2aq8'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq8">
                                        <input name="s2aq8" id="s2aq8" value="No"  type="radio" <?php if ($neweditaudits['s2aq8'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q12TEXT" name="q12TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q12)) {
                            echo $q12;
                        } ?></textarea>
                                    <span class="help-block"><p id="q12LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q12LEFT').text('400 characters left');
                                            $('#q12TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q12LEFT').text('You have reached the limit');
                                                    $('#q12LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q12LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q12LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq9">Q9. Is your policy single, joint or separate?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq9">
                                        <input name="s2aq9" id="s2aq9" value="Yes" type="radio" <?php if ($neweditaudits['s2aq9'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq9">
                                        <input name="s2aq9" id="s2aq9" value="No" type="radio" <?php if ($neweditaudits['s2aq9'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q13TEXT" name="q13TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q13)) {
                            echo $q13;
                        } ?></textarea>
                                    <span class="help-block"><p id="q13LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q13LEFT').text('400 characters left');
                                            $('#q13TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q13LEFT').text('You have reached the limit');
                                                    $('#q13LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q13LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q13LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq10">Q10. Have you or your partner smoked in the last 12 months?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq10">
                                        <input name="s2aq10" id="s2aq10" value="Yes" type="radio" <?php if ($neweditaudits['s2aq10'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq10">
                                        <input name="s2aq10" id="s2aq10" value="No" type="radio" <?php if ($neweditaudits['s2aq10'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q14TEXT" name="q14TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q14)) {
                            echo $q14;
                        } ?></textarea>
                                    <span class="help-block"><p id="q14LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q14LEFT').text('400 characters left');
                                            $('#q14TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q14LEFT').text('You have reached the limit');
                                                    $('#q14LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q14LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q14LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2aq11">Q11. Have you or your partner got or has had any health issues?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2aq11">
                                        <input name="s2aq11" id="s2aq11" value="Yes" type="radio" <?php if ($neweditaudits['s2aq11'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2aq11">
                                        <input name="s2aq11" id="s2aq11" value="No"  type="radio" <?php if ($neweditaudits['s2aq11'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q15TEXT" name="q15TEXT" rows="1" cols="75" maxlength="400" onkeyup="textAreaAdjust(this)"><?php if (isset($q15)) {
                            echo $q15;
                        } ?></textarea>
                                    <span class="help-block"><p id="q15LEFT" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#q15LEFT').text('400 characters left');
                                            $('#q15TEXT').keydown(function () {
                                                var max = 400;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#q15LEFT').text('You have reached the limit');
                                                    $('#q15LEFT').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#q15LEFT').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#q15LEFT').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>    

                        </div>

                    </div>

                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h3 class="panel-title">Section 2b</h3>
                        </div>
                        <div class="panel-body">


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="s2bq1">Q1. Were all questions asked correctly?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="s2bq1">
                                        <input name="s2bq1" value="Yes" type="radio" id="s2bq1yescheck" onclick="javascript:yesnoCheckc1();" <?php if ($neweditaudits['s2bq1'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="s2bq1">
                                        <input name="s2bq1" value="No" type="radio" id="s2bq1nocheck" onclick="javascript:yesnoCheckc1();" <?php if ($neweditaudits['s2bq1'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <!-- Textarea -->

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c1"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q1s2bc1" name="q1s2bc1" rows="1" cols="75" maxlength="1000" onkeyup="textAreaAdjust(this)"><?php echo $neweditaudits['q1s2bc1'] ?></textarea>
                                    <span class="help-block"><p id="characterLeft1" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#characterLeft1').text('1000 characters left');
                                            $('#q1s2bc1').keydown(function () {
                                                var max = 1000;
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
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="q2s2bq2">Q2. Were all questions recorded correctly?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="q2s2bq2">
                                        <input name="q2s2bq2" id="q2s2bq2yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc2();" <?php if ($neweditaudits['q2s2bq2'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="q2s2bq2">
                                        <input name="q2s2bq2" id="q2s2bq2no" value="No" type="radio" onclick="javascript:yesnoCheckc2();" <?php if ($neweditaudits['q2s2bq2'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <!-- Textarea -->

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="c2"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q2s2bc2" name="q2s2bc2" ><?php echo $neweditaudits['q2s2bc2']; ?></textarea>
                                    <span class="help-block"><p id="characterLeftc2" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#characterLeftc2').text('1000 characters left');
                                            $('#q2s2bc2').keydown(function () {
                                                var max = 1000;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#characterLeftc2').text('You have reached the limit');
                                                    $('#characterLeftc2').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#characterLeftc2').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#characterLeftc2').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h3 class="panel-title">Section 3</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="q1s4q1n">Q1. Did the agent stick to branding compliance?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="q1s4q1n">
                                        <input name="q1s4q1n" id="q1s4q1nyes" value="Yes" type="radio" <?php if ($neweditaudits['q1s4q1n'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="q1s4q1n">
                                        <input name="q1s4q1n" id="q1s4q1nno" value="No" type="radio" <?php if ($neweditaudits['q1s4q1n'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <!-- Textarea -->

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textarea"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q1s4c1n" name="q1s4c1n"><?php echo $neweditaudits['q1s4c1n']; ?></textarea>
                                    <span class="help-block"><p id="characterLeftc4" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#characterLeftc4').text('1000 characters left');
                                            $('#q1s4c1n').keydown(function () {
                                                var max = 1000;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#characterLeftc4').text('You have reached the limit');
                                                    $('#characterLeftc4').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#characterLeftc4').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#characterLeftc4').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>

                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <h3 class="panel-title">Section 4</h3>
                        </div>
                        <div class="panel-body">


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="radios">Q1. Were all personal details recorded correctly?</label>
                                <div class="col-md-4"> 
                                    <label class="radio-inline" for="q1s3q1">
                                        <input name="q1s3q1" id="q1s3q1yes" value="Yes" type="radio" onclick="javascript:yesnoCheckc3();" <?php if ($neweditaudits['q1s3q1'] == "Yes") echo "checked" ?>>
                                        Yes
                                    </label> 
                                    <label class="radio-inline" for="q1s3q1">
                                        <input name="q1s3q1" id="q1s3q1no" value="No" type="radio" onclick="javascript:yesnoCheckc3();" <?php if ($neweditaudits['q1s3q1'] == "No") echo "checked" ?>>
                                        No
                                    </label> 
                                </div>
                            </div>

                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textarea"></label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="q1s3c1" name="q1s3c1" ><?php echo $neweditaudits['q1s3c1'] ?></textarea>
                                    <span class="help-block"><p id="characterLeftc3" class="help-block ">You have reached the limit</p></span>
                                    <script>
                                        $(document).ready(function () {
                                            $('#characterLeftc3').text('1000 characters left');
                                            $('#q1s3c1').keydown(function () {
                                                var max = 1000;
                                                var len = $(this).val().length;
                                                if (len >= max) {
                                                    $('#characterLeftc3').text('You have reached the limit');
                                                    $('#characterLeftc3').addClass('red');
                                                    $('#btnSubmit').addClass('disabled');
                                                } else {
                                                    var ch = max - len;
                                                    $('#characterLeftc3').text(ch + ' characters left');
                                                    $('#btnSubmit').removeClass('disabled');
                                                    $('#characterLeftc3').removeClass('red');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-click"></i>Submit Changes</button>
                        </div>
                    </div>



                </fieldset>
            </form>
            <script>
                document.querySelector('#newformedit').addEventListener('submit', function (e) {
                    var form = this;
                    e.preventDefault();
                    swal({
                        title: "Save changes?",
                        text: "You will not be able to recover any overwritten data!",
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
                                        text: 'Audit updated updated!',
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




            <?php
        }

        else {


            $connection = mysql_connect('localhost', 'root', 'Cerberus2^n') or die("Couldn't connect to server.");
            $db = mysql_select_db('dev_adl_database', $connection) or die("Couldn't select database.");

            $search = $_POST['search'];

            $data = 'SELECT * FROM `lead_gen_audit` WHERE `id` = "' . $search . '"  OR id ="' . $auditid . '" ';
            $query = mysql_query($data) or die("Couldn't execute query. " . mysql_error());
            $data2 = mysql_fetch_array($query);
            ?>




            <div class="editclient">
                <div class="notice notice-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Warning!</strong> You Are Now Editing Call Audit ID <?php echo $search ?><?php echo $auditid ?> | Being edited by <?php echo $hello_name ?>.
                </div>


                <p>
                    Audited by: <?php echo $data2[auditor] ?><br>
                    Date Submitted: <?php echo $data2[date_submitted] ?><br>

                </p>


                <form class="form-horizontal" name="form" id="from1" method="POST" action="php/lead_gen_edit_submit.php">
                    <fieldset>

                        <div class="panel panel-danger">

                            <div class="panel-heading">
                                <h3 class="panel-title">Agent performance</span></h3>
                            </div>

                            <div class="panel-body">

                                <input type="hidden" name="auditid" value="<?php echo $auditid ?>">
                                <input type="hidden" name="keyfield" value="<?php echo $search ?>">
                                <input type="hidden" name="edited" value="<?php echo $hello_name ?>">  


                                <?php
                                $query = $bureaupdo->prepare("SELECT full_name FROM vicidial_users WHERE user_group = 'Life' OR user_group = 'web' OR user_group = 'ARCHIVED' ORDER BY full_name ASC");
                                $query->execute();

                                echo "<div class='form-group'>";
                                echo "  <label class='col-md-4 control-label' for='lead_gen_name'>Agent:</label>";
                                echo "  <div class='col-md-4'>";
                                echo "    <select id='lead_gen_name' name='lead_gen_name' class='form-control'>";
                                echo "<option value='" . $data2['lead_gen_name'] . "'>" . $data2['lead_gen_name'] . "</option>";
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $result['full_name'] . "'>" . $result['full_name'] . "</option>";
                                }
                                echo "    </select>";
                                echo "  </div>";
                                echo "</div>";
                                ?>

                                <?php
                                $query = $bureaupdo->prepare("SELECT full_name FROM vicidial_users WHERE user_group = 'Life' OR user_group = 'web' OR user_group = 'ARCHIVED' ORDER BY full_name ASC");
                                $query->execute();

                                echo "<div class='form-group'>";
                                echo "  <label class='col-md-4 control-label' for='lead_gen_name2'>Agent (optional):</label>";
                                echo "  <div class='col-md-4'>";
                                echo "    <select id='lead_gen_name2' name='lead_gen_name2' class='form-control'>";
                                echo "<option value='" . $data2['lead_gen_name2'] . "'>" . $data2['lead_gen_name2'] . "</option>";
                                while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $result['full_name'] . "'>" . $result['full_name'] . "</option>";
                                }
                                echo "    </select>";
                                echo "  </div>";
                                echo "</div>";
                                ?>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="grade">Grade</label>
                                    <div class="col-md-4">
                                        <select id="grade" name="grade" class="form-control" required>
                                            <option value="NA">Select...</option>
                                            <option value="Green" <?php if ($data2['grade'] == "Green") echo "selected" ?>>Green</option>
                                            <option value="Amber" <?php if ($data2['grade'] == "Amber") echo "selected" ?>>Amber</option>
                                            <option value="Red" <?php if ($data2['grade'] == "Red") echo "selected" ?>>Red</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c1">Overall comments:</label>
                                    <div class="col-md-4">     
                                        <textarea class="form-control" name="c1" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea1"><?php echo $data2[c1] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea1"));
                                        </script>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="panel panel-danger">

                            <div class="panel-heading">
                                <h3 class="panel-title">Audit Questions</h3>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="call_opening">Call opening?</label>
                                    <div class="col-md-4">
                                        <select name="call_opening" class="form-control" required>
                                            <option value="Excellent" <?php if ($data2['call_opening'] == "Excellent") echo "selected" ?>>Excellent</option>
                                            <option value="Good" <?php if ($data2['call_opening'] == "Good") echo "selected" ?>>Good</option>
                                            <option value="Acceptable" <?php if ($data2['call_opening'] == "Acceptable") echo "selected" ?>>Acceptable</option>
                                            <option value="Unacceptable" <?php if ($data2['call_opening'] == "Unacceptable") echo "selected" ?>>Unacceptable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c2">Comments:</label>
                                    <div class="col-md-4"> 
                                        <textarea  class="form-control" name="c2" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea2"><?php echo $data2[c2] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea2"));
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="full_info">Did the agent provide full information?</label>
                                    <div class="col-md-4">
                                        <select name="full_info" class="form-control" required>
                                            <option value="Excellent" <?php if ($data2['full_info'] == "Excellent") echo "selected" ?>>Excellent</option>
                                            <option value="Good" <?php if ($data2['full_info'] == "Good") echo "selected" ?>>Good</option>
                                            <option value="Acceptable" <?php if ($data2['full_info'] == "Acceptable") echo "selected" ?>>Acceptable</option>
                                            <option value="Unacceptable" <?php if ($data2['full_info'] == "Unacceptable") echo "selected" ?>>Unacceptable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c3">Comments:</label>
                                    <div class="col-md-4"> 
                                        <textarea class="form-control" name="c3" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea3"><?php echo $data2[c3] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea3"));
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="obj_handled">Objections handled</label>
                                    <div class="col-md-4">
                                        <select name="obj_handled" class="form-control" required>
                                            <option value="Excellent" <?php if ($data2['obj_handled'] == "Excellent") echo "selected" ?>>Excellent</option>
                                            <option value="Good" <?php if ($data2['obj_handled'] == "Good") echo "selected" ?>>Good</option>
                                            <option value="Acceptable" <?php if ($data2['obj_handled'] == "Acceptable") echo "selected" ?>>Acceptable</option>
                                            <option value="Unacceptable" <?php if ($data2['obj_handled'] == "Unacceptable") echo "selected" ?>>Unacceptable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c4">Comments:</label>
                                    <div class="col-md-4">                     
                                        <textarea class="form-control" name="c4" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea4"><?php echo $data2[c4] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea4"));
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="rapport">Rapport</label>
                                    <div class="col-md-4">
                                        <select name="rapport" class="form-control" required>
                                            <option value="Excellent" <?php if ($data2['rapport'] == "Excellent") echo "selected" ?>>Excellent</option>
                                            <option value="Good" <?php if ($data2['rapport'] == "Good") echo "selected" ?>>Good</option>
                                            <option value="Acceptable" <?php if ($data2['rapport'] == "Acceptable") echo "selected" ?>>Acceptable</option>
                                            <option value="Unacceptable" <?php if ($data2['rapport'] == "Unacceptable") echo "selected" ?>>Unacceptable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c5">Comments:</label>
                                    <div class="col-md-4">                     
                                        <textarea class="form-control" name="c5" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea5"><?php echo $data2[c5] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea5"));
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="dealsheet_questions">Did the agent ask all the questions on the dealsheet</label>
                                    <div class="col-md-4"> 
                                        <label class="radio-inline" for="dealsheet_questions-0">
                                            <input type="radio" name="dealsheet_questions" class="radio-inline" value="Yes" <?php if ($data2['dealsheet_questions'] == "Yes") echo "checked" ?>>Yes
                                        </label>
                                        <label class="radio-inline" for="dealsheet_questions-1">
                                            <input type="radio" name="dealsheet_questions" class="radio-inline" value="No" <?php if ($data2['dealsheet_questions'] == "No") echo "checked" ?>>No
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c6">Comments</label>
                                    <div class="col-md-4">                     
                                        <textarea class="form-control" rows="5" name="c6" cols="85" onkeyup="textAreaAdjust(this)" id="textarea6"><?php echo $data2[c6] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea6"));
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="brad_compl">Did the agent stick to branding compliance?</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline" for="brad_compl-0"> 
                                            <input type="radio" name="brad_compl" value="Yes" <?php if ($data2['brad_compl'] == "Yes") echo "checked" ?>>Yes
                                        </label>
                                        <label class="radio-inline" for="brad_compl-1">
                                            <input type="radio" name="brad_compl" value="No" <?php if ($data2['brad_compl'] == "No") echo "checked" ?>>No
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="c7">Comments</label>
                                    <div class="col-md-4">                     
                                        <textarea class="form-control" name="c7" rows="5" cols="85" onkeyup="textAreaAdjust(this)" id="textarea7"><?php echo $data2[c7] ?></textarea>
                                        <script type="text/javascript">
                                            textAreaAdjust(document.getElementById("textarea7"));
                                        </script>
                                    </div>
                                </div>


                                <center>
                                    <a href="lead_gen_reports.php">
                                        <button type="button" class="btn btn-warning "><span class="glyphicon glyphicon-chevron-left"></span> Back</button>
                                    </a>
                                    <button value="submit"  class="btn btn-danger "><span class="glyphicon glyphicon-ok"></span> Submit Changes</button>
                                </center>
                                </form>
                                </fieldset>

                                <script>
                                    document.querySelector('#from1').addEventListener('submit', function (e) {
                                        var form = this;
                                        e.preventDefault();
                                        swal({
                                            title: "Save changes?",
                                            text: "You will not be able to recover any overwritten data!",
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
                                                            text: 'Audit updated updated!',
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

                            </div>

<?php } ?>
                    </div>




                    </body>
                    </html>