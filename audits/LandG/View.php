<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../includes/ADL_PDO_CON.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


if ($ffaudits == '0') {

    header('Location: /../../CRMmain.php');
    die;
}


if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../../CRMmain.php');
    die;
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);
?><!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <html lang="en">
        <title>ADL | View Audit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/styles/viewlayout.css" type="text/css" />
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript" language="javascript" src="/js/jquery.dataTables.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        <script src="/js/jquery-1.4.min.js"></script>
        <script>
            function textAreaAdjust(o) {
                o.style.height = "1px";
                o.style.height = (25 + o.scrollHeight) + "px";
            }
        </script>
    </head>
    <body>

        <div class="container">

            <?php
            if ($EXECUTE == '1') {

                $AID = filter_input(INPUT_GET, 'AID', FILTER_SANITIZE_NUMBER_INT);

                $query = $pdo->prepare("SELECT an_number, q1s4q1n, q1s4c1n, auditor, submitted_date, id, agent, grade, sq1, sq2, sq3, sq4, sq5, s2aq1, s2aq2, s2aq3, s2aq4, s2aq5, s2aq6, s2aq7, s2aq8, s2aq9, s2aq10, s2aq11, s2bq1, q1s2bc1, q2s2bq2, q1s3q1, q2s2bc2, q1s3c1 from Audit_LeadGen where id =:AID");
                $query->bindParam(':AID', $AID, PDO::PARAM_INT);
                $query->execute()or die(print_r($query->errorInfo(), true));
                $data3 = $query->fetch(PDO::FETCH_ASSOC);

                $QUES = $pdo->prepare("SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10, q11, q12, q13, q14 ,q15 FROM Audit_LeadGen_Comments WHERE audit_id=:id");
                $QUES->bindParam(':id', $AID, PDO::PARAM_INT);
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
                ?>

                <div class="wrapper col4">

                    <table id='users'>

                        <thead>
                            <tr>
                                <td colspan="4"><b>Call Audit ID: <?php echo $AID; ?></b></td>
                            </tr>
                            <tr>
                                <td>Auditor</td>
                                <td><?php echo $data3['auditor']; ?></td>
                            </tr>

                            <tr>
                                <td>Agent(s)</td>
                                <td><b><?php echo $data3['agent']; ?></b><br></td>
                            </tr>

                            <tr>
                                <td>AN Number</td>
                                <td><?php echo $data3['an_number']; ?><br></td>
                            </tr>


                            <tr>
                                <td>Date Submitted</td>
                                <td><?php echo $data3['submitted_date']; ?></td>
                            </tr>

                            <tr>


                                <td>Grade</td>
                                <?php
                                if ($data3['grade'] == 'Amber') {
                                    echo "<td style='background-color: #FF9900;'><b>" . $data3['grade'] . "</b></td>";
                                } else if ($data3['grade'] == 'Green') {
                                    echo "<td style='background-color: #109618;'><b>" . $data3['grade'] . "</b></td>";
                                } else if ($data3['grade'] == 'Red') {
                                    echo "<td style='background-color: #DC3912;'><b>" . $data3['grade'] . "</b></td>";
                                }
                                ?>
                            </tr>

                        </thead>
                    </table>

                    <br>
                    <h4>Opening Section 1</h4>
                    <br> 



                    <label for="full_info">Q1. Agent said their name?</label>


                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq1'] == "Yes") {
                                    echo "checked";
                                } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq1'] == "No") {
                                    echo "checked";
                                } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q1</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="obj_handled">Q2. Said where they were calling from?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq2'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq2'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q2</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="rapport">Q3. Said the reason for the call?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq3'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq3'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q3</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="dealsheet_questions">Q4. Used EU gender directive correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq4'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq4'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q4</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="sq5">Q5. Agent followed the script?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['sq5'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['sq5'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q5</strong></h3>"; ?>
                    </div>
                    <br>

                    <br>
                    <h4>Qualifying Section 2a</h4>
                    <br>      


                    <label for="full_info">Q1. Were all questions asked?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq1'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq1'] == "No") {
                        echo "checked";
                    } ?>><label for="No">No</label>
                    <br>

                    <label for="obj_handled">Q2. What was the main reason you took out the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq2'] == "Yes") {
                        echo "checked";
                    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq2'] == "No") {
                        echo "checked";
                    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q6</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="rapport">Q3. Repayment or interest only?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq3'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq3'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q7</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="dealsheet_questions">Q4. When was your last review on the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq4'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq4'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q8</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="full_info">Q5. How did you take out the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq5'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq5'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q9</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="obj_handled">Q6. How much are you paying on a monthly basis?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq6'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq6'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q10</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="rapport">Q7. How much are you covered for?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq7'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq7'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q11</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="dealsheet_questions">Q8. How long do you have left on the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq8'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq8'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q12</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="full_info">Q9. Is your policy single, joint or separate?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq9'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq9'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
                        <?php echo "<h3><strong>$q13</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="obj_handled">Q10. Have you or your partner smoked in the last 12 months?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq10'] == "Yes") {
                            echo "checked";
                        } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq10'] == "No") {
                    echo "checked";
                } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q14</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="rapport">Q11. Have you or your partner got or has had any health issues?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2aq11'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2aq11'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$q15</strong></h3>"; ?>
                    </div>
                    <br>

                    <br>
                    <h4>Section 2b</h4>
                    <br>   

                    <label for="rapport">Q1. Were all questions asked correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['s2bq1'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['s2bq1'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>".$data3['q1s2bc1']."</strong></h3> "; ?>
                    </div>
                    <br>

                    <label for="rapport">Q2. Were all questions recorded correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q2s2bq2'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q2s2bq2'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>".$data3['q2s2bc2']."</strong></h3> "; ?>
                    </div>
                    <br>

                    <br>
                    <h4>Section 3</h4>
                    <br>  

                    <label for="rapport">Q1. Did the agent stick to branding compliance?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q1s4q1n'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q1s4q1n'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>".$data3['q1s4c1n']."</strong></h3> "; ?>
                    </div>

                    <br>
                    <h4>Section 4</h4>
                    <br>  

                    <label for="rapport">Q1. Were all personal details recorded correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($data3['q1s3q1'] == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($data3['q1s3q1'] == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>".$data3['q1s3c1']."</strong></h3> "; ?>
                    </div>

    <?php
}
?>
            </div>

    </body>
</html>
