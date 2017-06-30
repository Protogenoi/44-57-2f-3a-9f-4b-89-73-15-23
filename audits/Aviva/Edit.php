<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

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

    header('Location: /CRMmain.php');
    die;
}


if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}

if (isset($_GET["auditid"])) {
    $auditid = $_GET["auditid"];
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
    <title>ADL | L&G Closer Audit Edit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/layout.css" type="text/css" />
    <link rel="stylesheet" href="/../bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/../font-awesome/css/font-awesome.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <link  rel="stylesheet" href="../styles/sweet-alert.min.css" />
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script src="../js/jquery-2.1.4.min.js"></script>
    <script src="../js/sweet-alert.min.js"></script>
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

    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);

    $query = $pdo->prepare("SELECT * FROM closer_audits WHERE id = :searchplaceholder OR id = :auditidplaceholder");
    $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
    $query->bindParam(':auditidplaceholder', $auditid, PDO::PARAM_STR, 12);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC)
    ?>


    <div class="container">

        <div class="editclient">
            <div class="notice notice-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Warning!</strong> You Are Now Editing Call Audit ID <?php echo $search; ?><?php echo $auditid; ?> | Being edited by <?php echo $hello_name; ?>.
            </div>

            <form class="form-horizontal"id="from1" method="POST" action="php/closer_edit_submit.php">
                <fieldset>

                    <div class="panel panel-primary">

                        <div class="panel-heading">
                            <h3 class="panel-title">Closer Call Audit</span></h3>
                        </div>

                        <div class="panel-body">

                            <input type="hidden" name="auditid" value="<?php echo $auditid ?>">
                            <input type="hidden" name="keyfield" value="<?php echo $search ?>">
                            <input type="hidden" name="edited" value="<?php echo $hello_name ?>">  

                            <div class='form-group'>
                                <label class='col-md-4 control-label' for='closer'>Closer:</label>
                                <div class='col-md-4'>
                                    <select class='form-control' name='closer' id='full_name' required>
                                        <?php echo "<option value='" . $result['closer'] . "'>" . $result['closer'] . "</option>"; ?>
<?php if ($companynamere == 'Bluestone Protect') { ?>

                                            <option value="Carys">Carys</option>
                                            <option value="Hayley">Hayley</option>
                                            <option value="James">James</option>
                                            <option value="Kyle">Kyle</option>  
                                            <option value="Mike">Mike</option> 
                                            <option value="Nathan">Nathan</option> 
                                            <option value="Richard">Richard</option>
                                            <option value="Ricky">Ricky</option> 
                                            <option value="Sarah">Sarah</option>
                                            <option value="Stavros">Stavros</option>
                                            <option value="Nicola">Nicola</option>  
                                            <option value="Gavin">Gavin</option>
                                            <option value="Rhys">Rhys</option> 
                                            <option value="David">David</option> 
<?php } if ($companynamere == 'ADL_CUS') { ?>
                                            <option value="Dan Matthews">Dan Matthews</option>
                                            <option value="Joe Rimmell">Joe Rimmell</option>
                                            <option value="Jordan Davies">Jordan Davies</option>
                                            <option value="Matthew Brace">Matthew Brace</option>  
                                            <option value="Sam Morris">Sam Morris</option> 
                                            <option value="Steve Pattin">Steve Pattin</option> 
                                            <option value="James Keen">James Keen</option> 
<?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class='form-group'>
                                <label class='col-md-4 control-label' for='closer2'>Closer (optional):</label>
                                <div class='col-md-4'>
                                    <select class='form-control' name='closer2' id='closer2' > 
                                        <?php echo "<option value='" . $result['closer2'] . "'>" . $result['closer2'] . "</option>"; ?>
<?php if ($companynamere == 'Bluestone Protect') { ?>

                                            <option value="Carys">Carys</option>
                                            <option value="Hayley">Hayley</option>
                                            <option value="James">James</option>
                                            <option value="Kyle">Kyle</option>  
                                            <option value="Mike">Mike</option> 
                                            <option value="Nathan">Nathan</option> 
                                            <option value="Richard">Richard</option>
                                            <option value="Ricky">Ricky</option> 
                                            <option value="Sarah">Sarah</option>
                                            <option value="Stavros">Stavros</option>
                                            <option value="Nicola">Nicola</option>  
                                            <option value="Gavin">Gavin</option>
                                            <option value="Rhys">Rhys</option> 
                                            <option value="David">David</option> 
<?php } if ($companynamere == 'ADL_CUS') { ?>
                                            <option value="Dan Matthews">Dan Matthews</option>
                                            <option value="Joe Rimmell">Joe Rimmell</option>
                                            <option value="Jordan Davies">Jordan Davies</option>
                                            <option value="Matthew Brace">Matthew Brace</option>  
                                            <option value="Sam Morris">Sam Morris</option> 
                                            <option value="Steve Pattin">Steve Pattin</option> 
<?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="policy_number">Policy Number</label>  
                                <div class="col-md-4">
                                    <input type="text" name="policy_number" class="form-control input-md" style="width: 220px"  value="<?php echo $result['policy_number']; ?>" > 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="annumber">AN Number</label>  
                                <div class="col-md-4">
                                    <input type="text" name="annumber" class="form-control input-md" style="width: 220px"  value="<?php echo $result['an_number']; ?>" > 
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label" for="grade">Grade</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="grade" required>
                                        <option value="">Select...</option>
                                        <option value="SAVED" <?php if ($result['grade'] == "SAVED") {
    echo "selected";
} ?> >Incomplete Audit</option>
                                        <option value="Green" <?php if ($result['grade'] == "Green") {
    echo "selected";
} ?> >Green</option>
                                        <option value="Amber" <?php if ($result['grade'] == "Amber") {
    echo "selected";
} ?> >Amber</option>
                                        <option value="Red" <?php if ($result['grade'] == "Red") {
    echo "selected";
} ?> >Red</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">
                            <h3 class="panel-title">Opening Declaration</h3>
                        </div>
                        <div class="panel-body">

                            <p>
                                <label for="q1">Q1. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?</label>
                                <input type="radio" name="q1" value="Yes"  <?php if ($result['q1'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q1" value="No" <?php if ($result['q1'] == "No") {
    echo "checked";
} ?> >No


                            <p>
                                Comments: 
                                <br>
                                <textarea name="c1" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea1"><?php echo $result['c1']; ?></textarea>
                            <div id="textarea_feedbackc1"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc1').html(text_max + ' characters remaining');

                                    $('#textarea1').keyup(function () {
                                        var text_length = $('#textarea1').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc1').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea1"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q2">Q2. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label>

                                <input type="radio" name="q2" value="Yes"  <?php if ($result['q2'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q2" value="No" <?php if ($result['q2'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c2" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea2"><?php echo $result['c2']; ?></textarea>
                            <div id="textarea_feedbackc2"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc2').html(text_max + ' characters remaining');

                                    $('#textarea2').keyup(function () {
                                        var text_length = $('#textarea2').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc2').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea2"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q3">Q3. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label>

                                <input type="radio" name="q3" value="Yes"  <?php if ($result['q3'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q3" value="No" <?php if ($result['q3'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c3" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea3"><?php echo $result['c3']; ?></textarea>
                            <div id="textarea_feedbackc3"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc3').html(text_max + ' characters remaining');

                                    $('#textarea3').keyup(function () {
                                        var text_length = $('#textarea3').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc3').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea3"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q4">Q4. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label>


                                <input type="radio" name="q4" value="Yes"  <?php if ($result['q4'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q4" value="No" <?php if ($result['q4'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c4" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea4"><?php echo $result['c4']; ?></textarea>
                            <div id="textarea_feedbackc4"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc4').html(text_max + ' characters remaining');

                                    $('#textarea4').keyup(function () {
                                        var text_length = $('#textarea4').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc4').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea4"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q5">Q5. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label>

                                <input type="radio" name="q5" value="Yes"  <?php if ($result['q5'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q5" value="No" <?php if ($result['q5'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c5" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea5"><?php echo $result['c5']; ?></textarea>
                            <div id="textarea_feedbackc5"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc5').html(text_max + ' characters remaining');

                                    $('#textarea5').keyup(function () {
                                        var text_length = $('#textarea5').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc5').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea5"));
                            </script>
                            </br>
                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Customer Information</h3>
                        </div>
                        <div class="panel-body">

                            <p>
                                <label for="q6">Q6. Were All Clients Titles And Names Recorded Correctly?</label>
                                <input type="radio" name="q6" value="Yes"  <?php if ($result['q6'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q6" value="No" <?php if ($result['q6'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c6" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea6"><?php echo $result['c6']; ?></textarea>
                            <div id="textarea_feedbackc6"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc6').html(text_max + ' characters remaining');

                                    $('#textarea6').keyup(function () {
                                        var text_length = $('#textarea6').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc6').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea6"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q7">Q7. Was The Clients Gender Accurately Recorded?</label>

                                <input type="radio" name="q7" value="Yes"  <?php if ($result['q7'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q7" value="No" <?php if ($result['q7'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c7" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea7"><?php echo $result['c7']; ?></textarea>
                            <div id="textarea_feedbackc7"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc7').html(text_max + ' characters remaining');

                                    $('#textarea7').keyup(function () {
                                        var text_length = $('#textarea7').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc7').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea7"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q8">Q8. Was The Clients Date Of Birth Accurately Recorded?</label>

                                <input type="radio" name="q8" value="Yes"  <?php if ($result['q8'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q8" value="No" <?php if ($result['q8'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c8" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea8"><?php echo $result['c8']; ?></textarea>
                            <div id="textarea_feedbackc8"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc8').html(text_max + ' characters remaining');

                                    $('#textarea8').keyup(function () {
                                        var text_length = $('#textarea8').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc8').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea8"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q9">Q9. Was The Clients Smoker Status Recorded Correctly?</label>

                                <input type="radio" name="q9" value="Yes"   <?php if ($result['q9'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q9" value="No" <?php if ($result['q9'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c9" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea9"><?php echo $result['c9']; ?></textarea>
                            <div id="textarea_feedbackc9"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc9').html(text_max + ' characters remaining');

                                    $('#textarea9').keyup(function () {
                                        var text_length = $('#textarea9').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc9').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea9"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q10">Q10. Was The Clients Employment Status Recorded Correctly?</label>

                                <input type="radio" name="q10" value="Yes"  <?php if ($result['q10'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q10" value="No" <?php if ($result['q10'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c10" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea10"><?php echo $result['c10']; ?></textarea>
                            <div id="textarea_feedbackc10"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc10').html(text_max + ' characters remaining');

                                    $('#textarea10').keyup(function () {
                                        var text_length = $('#textarea10').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc10').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea10"));
                            </script>
                            </p>

                            <p>
                                <label for="q11">Q11. Did The Sales Agent Confirm The Policy Was A Single Or Joint Application?</label>

                                <input type="radio" name="q11" value="Yes"  <?php if ($result['q11'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q11" value="No" <?php if ($result['q11'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c11" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea11"><?php echo $result['c11']; ?></textarea>
                            <div id="textarea_feedbackc11"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc11').html(text_max + ' characters remaining');

                                    $('#textarea11').keyup(function () {
                                        var text_length = $('#textarea11').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc11').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea11"));
                            </script>
                            </br>
                            </p>


                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Identifying Clients Needs</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q12">Q12. Did The Agent Check All Details Of What The Client Has With Their Existing Life Insurance Policy?</label>

                                <input type="radio" name="q12" value="Yes"  <?php if ($result['q12'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q12" value="No" <?php if ($result['q12'] == "No") {
    echo "checked";
} ?> >No


                            </p>
                            <p>
                                Comments: 
                                <br>
                                <textarea name="c12" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea12"><?php echo $result['c12']; ?></textarea>
                            <div id="textarea_feedbackc12"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc12').html(text_max + ' characters remaining');

                                    $('#textarea12').keyup(function () {
                                        var text_length = $('#textarea12').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc12').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>

                            <p>
                                <label for="q53">Q13. Did the agent mention waiver, indexation, or TPD?</label>

                                <input type="radio" name="q53" value="Yes"  <?php if ($result['q53'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q53" value="No" <?php if ($result['q53'] == "No") {
    echo "checked";
} ?> >No
                                <input type="radio" name="q53" value="N/A" <?php if ($result['q53'] == "N/A") {
    echo "checked";
} ?> >N/A


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c53" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea53"><?php echo $result['c53']; ?></textarea>
                            <div id="textarea_feedbackc53"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc53').html(text_max + ' characters remaining');

                                    $('#textarea53').keyup(function () {
                                        var text_length = $('#textarea53').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc53').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea53"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q13">Q14. Did The Agent Ensure That The Client Was Provided With A Policy That Meet Their Needs? More Cover,Cheaper Premium Etc?</label>

                                <input type="radio" name="q13" value="Yes"  <?php if ($result['q13'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q13" value="No" <?php if ($result['q13'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c13" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea13"><?php echo $result['c13']; ?></textarea>
                            <div id="textarea_feedbackc13"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc13').html(text_max + ' characters remaining');

                                    $('#textarea13').keyup(function () {
                                        var text_length = $('#textarea13').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc13').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea13"));
                            </script>
                            </p>

                            <p>
                                <label for="q14">Q15. Did The Sales Agent Provide The Customer With A Sufficient Amount Of Features And Benefits For The Policy?</label>

                                <select name="q14" >
                                    <option value="NA">Select...</option>
                                    <option value="More than sufficient" <?php if ($result['q14'] == "More than sufficient") {
    echo "selected";
} ?> >More than sufficient</option>
                                    <option value="Sufficient" <?php if ($result['q14'] == "Sufficient") {
    echo "selected";
} ?> >Sufficient</option>
                                    <option value="Adaquate" <?php if ($result['q14'] == "Adaquate") {
    echo "selected";
} ?> >Adaquate</option>
                                    <option value="Poor" <?php if ($result['q14'] == "Poor") {
    echo "selected";
} ?> >Poor</option>
                                </select>

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c14" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea14"><?php echo $result['c14']; ?></textarea>
                            <div id="textarea_feedbackc14"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc14').html(text_max + ' characters remaining');

                                    $('#textarea14').keyup(function () {
                                        var text_length = $('#textarea14').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc14').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea14"));
                            </script>

                            </p>

                            <p>
                                <label for="q15">Q16. Agent confirmed This Policy Will Be Set Up With Legal And General?</label>

                                <input type="radio" name="q15" value="Yes"  <?php if ($result['q15'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q15" value="No" <?php if ($result['q15'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c15" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea15"><?php echo $result['c15']; ?></textarea>
                            <div id="textarea_feedbackc15"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc15').html(text_max + ' characters remaining');

                                    $('#textarea15').keyup(function () {
                                        var text_length = $('#textarea15').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc15').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea15"));
                            </script>

                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Eligibility</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q55">Q17. Important customer information declaration?</label>

                                <input type="radio" name="q55" value="Yes"  <?php if ($result['q55'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q55" value="No" <?php if ($result['q55'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c55" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea17"><?php echo $result['c55']; ?></textarea>
                            <div id="textarea_feedbackc55"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc55').html(text_max + ' characters remaining');

                                    $('#textarea17').keyup(function () {
                                        var text_length = $('#textarea17').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc55').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea17"));
                            </script>
                            </p>

                            <p>
                                <label for="q17">Q18. Were All Clients Contact Details Recorded Correctly?</label>

                                <input type="radio" name="q17" value="Yes"  <?php if ($result['q17'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q17" value="No" <?php if ($result['q17'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c17" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea17"><?php echo $result['c17']; ?></textarea>
                            <div id="textarea_feedbackc17"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc17').html(text_max + ' characters remaining');

                                    $('#textarea17').keyup(function () {
                                        var text_length = $('#textarea17').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc17').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea17"));
                            </script>
                            </p>

                            <p>
                                <label for="q16">Q19. Were All Clients Address Details Recorded Correctly?</label>

                                <input type="radio" name="q16" value="Yes"  <?php if ($result['q16'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q16" value="No" <?php if ($result['q16'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c16" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea16"><?php echo $result['c16']; ?></textarea>
                            <div id="textarea_feedbackc16"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc16').html(text_max + ' characters remaining');

                                    $('#textarea16').keyup(function () {
                                        var text_length = $('#textarea16').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc16').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea16"));
                            </script>
                            </p>

                            <p>
                                <label for="q31">Q20. Were All Doctors Details Recorded Correctly?</label>

                                <input type="radio" name="q31" value="Yes"  <?php if ($result['q31'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q31" value="No" <?php if ($result['q31'] == "No") {
    echo "checked";
} ?> >No


                            </p>



                            <p>
                                Comments: 
                                <br>
                                <textarea name="c31" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea31"><?php echo $result['c31']; ?></textarea>
                            <div id="textarea_feedbackc31"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc31').html(text_max + ' characters remaining');

                                    $('#textarea31').keyup(function () {
                                        var text_length = $('#textarea31').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc31').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>

                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea31"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q18">Q21. Did The Agent Ask And Accurately Record The Work And Travel Questions And Record The Details Correctly?</label>

                                <input type="radio" name="q18" value="Yes"  <?php if ($result['q18'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q18" value="No" <?php if ($result['q18'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c18" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea18"><?php echo $result['c18']; ?></textarea>
                            <div id="textarea_feedbackc18"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc18').html(text_max + ' characters remaining');

                                    $('#textarea18').keyup(function () {
                                        var text_length = $('#textarea18').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc18').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea18"));
                            </script>
                            </p>

                            <p>
                                <label for="q19">Q22. Did The Agent Ask And Accurately Record The Hazardous Activities Questions?</label>

                                <input type="radio" name="q19" value="Yes"  <?php if ($result['q19'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q19" value="No" <?php if ($result['q19'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c19" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea19"><?php echo $result['c19']; ?></textarea>
                            <div id="textarea_feedbackc19"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc19').html(text_max + ' characters remaining');

                                    $('#textarea19').keyup(function () {
                                        var text_length = $('#textarea19').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc19').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea19"));
                            </script>
                            </p>

                            <p>
                                <label for="q20">Q23. Did The Agent Ask And Accurately Record The Height And Weight Details And Record The Details Correctly?</label>

                                <input type="radio" name="q20" value="Yes"  <?php if ($result['q20'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q20" value="No" <?php if ($result['q20'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c20" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea20"><?php echo $result['c20']; ?></textarea>
                            <div id="textarea_feedbackc20"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc20').html(text_max + ' characters remaining');

                                    $('#textarea20').keyup(function () {
                                        var text_length = $('#textarea20').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc20').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea20"));
                            </script>
                            </p>

                            <p>
                                <label for="q21">Q24. Did The Agent Ask And Accurately Record The Smoking Details Correctly?</label>

                                <input type="radio" name="q21" value="Yes"  <?php if ($result['q21'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q21" value="No" <?php if ($result['q21'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c21" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea21"><?php echo $result['c21']; ?></textarea>
                            <div id="textarea_feedbackc21"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc21').html(text_max + ' characters remaining');

                                    $('#textarea21').keyup(function () {
                                        var text_length = $('#textarea21').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc21').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea21"));
                            </script>
                            </p>

                            <p>
                                <label for="q22">Q25. Did The Agent Ask And Accurately Record The Drug Use Details Correctly?</label>

                                <input type="radio" name="q22" value="Yes"  <?php if ($result['q22'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q22" value="No" <?php if ($result['q22'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c22" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea22"><?php echo $result['c22']; ?></textarea>
                            <div id="textarea_feedbackc22"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc22').html(text_max + ' characters remaining');

                                    $('#textarea22').keyup(function () {
                                        var text_length = $('#textarea22').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc22').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea22"));
                            </script>
                            </p>

                            <p>
                                <label for="q23">Q26. Did The Agent Ask And Accurately Record The Alcohol Consumption Details Correctly?</label>

                                <input type="radio" name="q23" value="Yes"  <?php if ($result['q23'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q23" value="No" <?php if ($result['q23'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c23" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea23"><?php echo $result['c23']; ?></textarea>
                            <div id="textarea_feedbackc23"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc23').html(text_max + ' characters remaining');

                                    $('#textarea23').keyup(function () {
                                        var text_length = $('#textarea23').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc23').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea23"));
                            </script>
                            </p>

                            <p>
                                <label for="q24">Q27. Were All Health Ever Questions Asked And Details Recorded Correctly?</label>

                                <input type="radio" name="q24" value="Yes"  <?php if ($result['q24'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q24" value="No" <?php if ($result['q24'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c24" rows="1" cols="85" maxlength="2500" onkeyup="textAreaAdjust(this)" id="textarea24"><?php echo $result['c24']; ?></textarea>
                            <div id="textarea_feedbackc24"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 2500;
                                    $('#textarea_feedbackc24').html(text_max + ' characters remaining');

                                    $('#textarea24').keyup(function () {
                                        var text_length = $('#textarea24').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc24').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea24"));
                            </script>
                            </p>

                            <p>
                                <label for="q25">Q28. Were All Health Last 5 Years Questions Asked And Details Recorded Correctly?</label>

                                <input type="radio" name="q25" value="Yes"  <?php if ($result['q25'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q25" value="No" <?php if ($result['q25'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c25" rows="1" cols="85" maxlength="2500" onkeyup="textAreaAdjust(this)" id="textarea25"><?php echo $result['c25']; ?></textarea>
                            <div id="textarea_feedbackc25"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 2500;
                                    $('#textarea_feedbackc25').html(text_max + ' characters remaining');

                                    $('#textarea25').keyup(function () {
                                        var text_length = $('#textarea25').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc25').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea25"));
                            </script>
                            </p>

                            <p>
                                <label for="q26">Q29. Were All Health Last 2 Years Questions Asked And Details Recorded Correctly?</label>

                                <input type="radio" name="q26" value="Yes"  <?php if ($result['q26'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q26" value="No" <?php if ($result['q26'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c26" rows="1" cols="85" maxlength="2500" onkeyup="textAreaAdjust(this)" id="textarea26"><?php echo $result['c26']; ?></textarea>
                            <div id="textarea_feedbackc26"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 2500;
                                    $('#textarea_feedbackc26').html(text_max + ' characters remaining');

                                    $('#textarea26').keyup(function () {
                                        var text_length = $('#textarea26').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc26').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea26"));
                            </script>
                            </p>

                            <p>
                                <label for="q27">Q30. Were All Health Continued Questions Asked And Details Recorded Correctly?</label>

                                <input type="radio" name="q27" value="Yes"  <?php if ($result['q27'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q27" value="No" <?php if ($result['q27'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c27" rows="1" cols="85" maxlength="2500" onkeyup="textAreaAdjust(this)" id="textarea27"><?php echo $result['c27']; ?></textarea>
                            <div id="textarea_feedbackc27"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 2500;
                                    $('#textarea_feedbackc27').html(text_max + ' characters remaining');

                                    $('#textarea27').keyup(function () {
                                        var text_length = $('#textarea27').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc27').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea27"));
                            </script>
                            </p>

                            <p>
                                <label for="q28">Q31. Were All Family History Questions Asked And Details Recorded Correctly?</label>

                                <input type="radio" name="q28" value="Yes"  <?php if ($result['q28'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q28" value="No" <?php if ($result['q28'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c28" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea28"><?php echo $result['c28']; ?></textarea>
                            <div id="textarea_feedbackc28"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc28').html(text_max + ' characters remaining');

                                    $('#textarea28').keyup(function () {
                                        var text_length = $('#textarea28').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc28').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea28"));
                            </script>
                            </p>

                            <p>
                                <label for="q29">Q32. Were Term For Term Details Recorded Correctly?</label>

                                <select name="q29" >
                                    <option value="NA">Select...</option>
                                    <option value="Client provided details" <?php if ($result['q29'] == "Client provided details") {
    echo "selected";
} ?> >Client Provided Details</option>
                                    <option value="Client failed to provide details" <?php if ($result['q29'] == "Client failed to provide details") {
    echo "selected";
} ?> >Client failed to provided details</option>
                                    <option value="Not existing L&G customer" <?php if ($result['q29'] == "Not existing L&G customer") {
    echo "selected";
} ?> >Not existing legal and general customer</option>
                                    <option value="Obtained from Term4Term service" <?php if ($result['q29'] == "Obtained from Term4Term service") {
    echo "selected";
} ?> >Obtained from Term4Term service</option>
                                    <option value="Existing L&G Policy, no attempt to get policy number" <?php if ($result['q29'] == "Existing L&G Policy, no attempt to get policy number") {
    echo "selected";
} ?> >Existing L&G Policy, no attempt to get policy number</option>
                                </select>

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c29" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea29"><?php echo $result['c29']; ?></textarea>
                            <div id="textarea_feedbackc29"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc29').html(text_max + ' characters remaining');

                                    $('#textarea29').keyup(function () {
                                        var text_length = $('#textarea29').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc29').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea29"));
                            </script>
                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Declarations of Insurance</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q30">Q33. Customer declaration read out?</label>

                                <input type="radio" name="q30" value="Yes"  <?php if ($result['q30'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q30" value="No" <?php if ($result['q30'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c30" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea30"><?php echo $result['c30']; ?></textarea>
                            <div id="textarea_feedbackc30"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc30').html(text_max + ' characters remaining');

                                    $('#textarea30').keyup(function () {
                                        var text_length = $('#textarea30').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc30').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>


                            <br>
                            <p>
                                <label for="q54">Q34. If appropriate did the agent confirm the exclusions on the policy</label>

                                <input type="radio" name="q54" value="Yes"  <?php if ($result['q54'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q54" value="No" <?php if ($result['q54'] == "No") {
    echo "checked";
} ?> >No
                                <input type="radio" name="q54" value="N/A" <?php if ($result['q54'] == "N/A") {
    echo "checked";
} ?> >N/A
                            </p>


                            <p>
                                Comments: 
                                <br>
                                <textarea name="c54" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea54"><?php echo $result['c54']; ?></textarea>
                            <div id="textarea_feedbackc54"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc54').html(text_max + ' characters remaining');

                                    $('#textarea54').keyup(function () {
                                        var text_length = $('#textarea54').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc54').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea54"));
                            </script>
                            </br>
                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Payment Information</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q32">Q35. Was The Clients Policy Start Date Accurately Recorded?</label>
                                <input type="radio" name="q32" value="Yes"  <?php if ($result['q32'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q32" value="No" <?php if ($result['q32'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c32" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea32"><?php echo $result['c32']; ?></textarea>
                            <div id="textarea_feedbackc32"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc32').html(text_max + ' characters remaining');

                                    $('#textarea32').keyup(function () {
                                        var text_length = $('#textarea32').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc32').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea32"));
                            </script>
                            </br>
                            </p>



                            <p>
                                <label for="q33">Q36. Did The Agent Offer To Read The Direct Debit Guarantee?</label>

                                <input type="radio" name="q33" value="Yes"  <?php if ($result['q33'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q33" value="No" <?php if ($result['q33'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c33" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea33"><?php echo $result['c33']; ?></textarea>
                            <div id="textarea_feedbackc33"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc33').html(text_max + ' characters remaining');

                                    $('#textarea33').keyup(function () {
                                        var text_length = $('#textarea33').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc33').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea33"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q34">Q37. Did The Agent Offer A Preferred Premium Collection Date?</label>

                                <input type="radio" name="q34" value="Yes"  <?php if ($result['q34'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q34" value="No" <?php if ($result['q34'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c34" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea34"><?php echo $result['c34']; ?></textarea>
                            <div id="textarea_feedbackc34"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc34').html(text_max + ' characters remaining');

                                    $('#textarea34').keyup(function () {
                                        var text_length = $('#textarea34').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc34').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea34"));
                            </script>
                            </p>

                            <p>
                                <label for="q35">Q38. Did The Agent Take Bank Details Correctly?</label>

                                <input type="radio" name="q35" value="Yes"  <?php if ($result['q35'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q35" value="No" <?php if ($result['q35'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c35" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea35"><?php echo $result['c35']; ?></textarea>
                            <div id="textarea_feedbackc35"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc35').html(text_max + ' characters remaining');

                                    $('#textarea35').keyup(function () {
                                        var text_length = $('#textarea35').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc35').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea35"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q36">Q39. Did They Have Consent Off The Premium Payer?</label>
                                <input type="radio" name="q36" value="Yes"  <?php if ($result['q36'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q36" value="No" <?php if ($result['q36'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c36" rows="1" cols="85" maxlength="1500" onkeyup="textAreaAdjust(this)" id="textarea36"><?php echo $result['c36']; ?></textarea>
                            <div id="textarea_feedbackc36"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 1500;
                                    $('#textarea_feedbackc36').html(text_max + ' characters remaining');

                                    $('#textarea36').keyup(function () {
                                        var text_length = $('#textarea36').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc36').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea36"));
                            </script>
                            </p>

                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Consolidation Declaration</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q38">Q40. Agent confirmed The Customers Rights To Cancel The Policy At Any Anytime And If The Customer Changes Their Mind Within The First 30 Days Of Starting There Will Be A Refund Of Premiums?</label>

                                <input type="radio" name="q38" value="Yes"  <?php if ($result['q38'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q38" value="No" <?php if ($result['q38'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c38" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea38"><?php echo $result['c38']; ?></textarea>
                            <div id="textarea_feedbackc38"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc38').html(text_max + ' characters remaining');

                                    $('#textarea38').keyup(function () {
                                        var text_length = $('#textarea38').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc38').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea38"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q39">Q41. Agent confirmed If The Policy Is Cancelled At Any Other Time The Cover Will End And No Refund Will Be Made And That The Policy Has No Cash In Value?</label>

                                <input type="radio" name="q39" value="Yes"  <?php if ($result['q39'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q39" value="No" <?php if ($result['q39'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c39" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea39"><?php echo $result['c39']; ?></textarea>
                            <div id="textarea_feedbackc39"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc39').html(text_max + ' characters remaining');

                                    $('#textarea39').keyup(function () {
                                        var text_length = $('#textarea39').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc39').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea39"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q40">Q42. Like Mentioned Earlier Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label>

                                <input type="radio" name="q40" value="Yes"  <?php if ($result['q40'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q40" value="No" <?php if ($result['q40'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c40" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea40"><?php echo $result['c40']; ?></textarea>
                            <div id="textarea_feedbackc40"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc40').html(text_max + ' characters remaining');

                                    $('#textarea40').keyup(function () {
                                        var text_length = $('#textarea40').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc40').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea40"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q41">Q43. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label>

                                <input type="radio" name="q41" value="Yes"  <?php if ($result['q41'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q41" value="No" <?php if ($result['q41'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c41" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea41"><?php echo $result['c41'] ;?></textarea>
                            <div id="textarea_feedbackc41"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc41').html(text_max + ' characters remaining');

                                    $('#textarea41').keyup(function () {
                                        var text_length = $('#textarea41').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc41').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea41"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q42">Q44. Did the closer confirm that the customer will be getting a 'my account' email from Legal and General?</label>

                                <input type="radio" name="q42" value="Yes"  <?php if ($result['q42'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q42" value="No" <?php if ($result['q42'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c42" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea42"><?php echo $result['c42']; ?></textarea>
                            <div id="textarea_feedbackc42"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc42').html(text_max + ' characters remaining');

                                    $('#textarea42').keyup(function () {
                                        var text_length = $('#textarea42').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc42').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea42"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q43">Q45. Agent confirmed The Check Your Details Procedure?</label>

                                <input type="radio" name="q43" value="Yes"  <?php if ($result['q43'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q43" value="No" <?php if ($result['q43'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c43" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea43"><?php echo $result['c43']; ?></textarea>
                            <div id="textarea_feedbackc43"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc43').html(text_max + ' characters remaining');

                                    $('#textarea43').keyup(function () {
                                        var text_length = $('#textarea43').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc43').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea43"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q44">Q46. Agent Confirmed an approximate Direct Debit date and informed the customer it is not an exact date, but legal and general will write to them with a more specific date?</label>

                                <input type="radio" name="q44" value="Yes"  <?php if ($result['q44'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q44" value="No" <?php if ($result['q44'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c44" rows="1" cols="85" maxlength="2500" onkeyup="textAreaAdjust(this)" id="textarea44"><?php echo $result['c44']; ?></textarea>
                            <div id="textarea_feedbackc44"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 2500;
                                    $('#textarea_feedbackc44').html(text_max + ' characters remaining');

                                    $('#textarea44').keyup(function () {
                                        var text_length = $('#textarea44').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc44').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea44"));
                            </script>
                            </br>
                            </p>

                            <p>
                                <label for="q45">Q47. Did the closer confirm to the customer to cancel their existing direct debit</label>

                                <input type="radio" name="q45" value="Yes"  <?php if ($result['q45'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q45" value="No" <?php if ($result['q45'] == "No") {
    echo "checked";
} ?> >No
                                <input type="radio" name="q45" value="N/A" <?php if ($result['q45'] == "N/A") {
    echo "checked";
} ?> >N/A


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c45" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea45"><?php echo $result['c45']; ?></textarea>
                            <div id="textarea_feedbackc45"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc45').html(text_max + ' characters remaining');

                                    $('#textarea45').keyup(function () {
                                        var text_length = $('#textarea45').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc45').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea45"));
                            </script>
                            </br>
                            </p>

                        </div>
                    </div>

                    <div class="panel panel-danger">

                        <div class="panel-heading">

                            <h3 class="panel-title">Quality Control</h3>
                        </div>

                        <div class="panel-body">

                            <p>
                                <label for="q46">Q48. Agent confirmed That They Have Set The Client Up On A Level/Decreasing/CIC Term Policy With Legal And General With Client Confirmation?</label>

                                <input type="radio" name="q46" value="Yes"  <?php if ($result['q46'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q46" value="No" <?php if ($result['q46'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c46" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea46"><?php echo $result['c46']; ?></textarea>
                            <div id="textarea_feedbackc46"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc46').html(text_max + ' characters remaining');

                                    $('#textarea46').keyup(function () {
                                        var text_length = $('#textarea46').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc46').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea46"));
                            </script>
                            </p>

                            <p>
                                <label for="q47">Q49. Agent confirmed The Length Of The Policy In Years With Client Confirmation?</label>

                                <input type="radio" name="q47" value="Yes"  <?php if ($result['q47'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q47" value="No" <?php if ($result['q47'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c47" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea47"><?php echo $result['c47']; ?></textarea>
                            <div id="textarea_feedbackc47"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc47').html(text_max + ' characters remaining');

                                    $('#textarea47').keyup(function () {
                                        var text_length = $('#textarea47').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc47').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea47"));
                            </script>
                            </p>

                            <p>
                                <label for="q48">Q50. Agent confirmed The Amount Of Cover On The Policy With Client Confirmation?</label>

                                <input type="radio" name="q48" value="Yes"  <?php if ($result['q48'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q48" value="No" <?php if ($result['q48'] == "No") {
    echo "checked";
} ?> >No 


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c48" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea48"><?php echo $result['c48']; ?></textarea>
                            <div id="textarea_feedbackc48"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc48').html(text_max + ' characters remaining');

                                    $('#textarea48').keyup(function () {
                                        var text_length = $('#textarea48').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc48').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea48"));
                            </script>
                            </p>

                            <p>
                                <label for="q49">Q51. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?</label>

                                <input type="radio" name="q49" value="Yes"  <?php if ($result['q49'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q49" value="No" <?php if ($result['q49'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c49" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea49"><?php echo $result['c49']; ?></textarea>
                            <div id="textarea_feedbackc49"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc49').html(text_max + ' characters remaining');

                                    $('#textarea49').keyup(function () {
                                        var text_length = $('#textarea49').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc49').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea49"));
                            </script>
                            </p>

                            <p>
                                <label for="q50">Q52. Did The Customer Give Their Explicit Consent For The Policy To Be Set Up?</label>

                                <input type="radio" name="q50" value="Yes"  <?php if ($result['q50'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q50" value="No" <?php if ($result['q50'] == "No") {
    echo "checked";
} ?> >No

                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c50" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea50"><?php echo $result['c50']; ?></textarea>
                            <div id="textarea_feedbackc50"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc50').html(text_max + ' characters remaining');

                                    $('#textarea50').keyup(function () {
                                        var text_length = $('#textarea50').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc50').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea50"));
                            </script>
                            </p>

                            <p>
                                <label for="q51">Q53. Did The Agent Provide Contact Details For Bluestone Protect?</label>

                                <input type="radio" name="q51" value="Yes"  <?php if ($result['q51'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q51" value="No" <?php if ($result['q51'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c51" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea51"><?php echo $result['c51']; ?></textarea>
                            <div id="textarea_feedbackc51"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc51').html(text_max + ' characters remaining');

                                    $('#textarea51').keyup(function () {
                                        var text_length = $('#textarea51').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc51').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea51"));
                            </script>
                            </p>

                            <p>
                                <label for="q52">Q54. Did The Sales Agent Keep To The Requirements Of A Non-Advised Sale, Providing An Information Based Service And Not Offering Advice Or Personal Opinion?</label>

                                <input type="radio" name="q52" value="Yes"  <?php if ($result['q52'] == "Yes") {
    echo "checked";
} ?> >Yes
                                <input type="radio" name="q52" value="No" <?php if ($result['q52'] == "No") {
    echo "checked";
} ?> >No


                            </p>

                            <p>
                                Comments: 
                                <br>
                                <textarea name="c52" rows="1" cols="85" maxlength="500" onkeyup="textAreaAdjust(this)" id="textarea52"><?php echo $result['c52']; ?></textarea>
                            <div id="textarea_feedbackc52"></div>
                            <script>
                                $(document).ready(function () {
                                    var text_max = 500;
                                    $('#textarea_feedbackc52').html(text_max + ' characters remaining');

                                    $('#textarea52').keyup(function () {
                                        var text_length = $('#textarea52').val().length;
                                        var text_remaining = text_max - text_length;

                                        $('#textarea_feedbackc52').html(text_remaining + ' characters remaining');
                                    });
                                });
                            </script>
                            <script type="text/javascript">
                                textAreaAdjust(document.getElementById("textarea52"));
                            </script>
                            </p>

                        </div>
                    </div>

                    <a href="auditor_menu.php">
                        <button type="button" class="btn btn-warning "><span class="glyphicon glyphicon-chevron-left"></span> Back</button>
                    </a>
                    <button value="submit"  class="btn btn-danger "><span class="glyphicon glyphicon-ok"></span> Submit Changes</button>
            </form>

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

            </fieldset>
        </div>
    </div>
</body>
</html>