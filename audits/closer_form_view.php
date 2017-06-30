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
require_once(__DIR__ . '/../classes/database_class.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '0') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if ($ffaudits == '0') {

    header('Location: /../CRMmain.php?FeatureDisabled');
    die;
}

if (!in_array($hello_name, $Level_3_Access, true)) {

    header('Location: /../CRMmain.php?AccessDenied');
    die;
}


$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
$auditid = filter_input(INPUT_GET, 'auditid', FILTER_SANITIZE_NUMBER_INT);
if (!isset($search)) {
    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);
}

if (!isset($auditid)) {
    $auditid = filter_input(INPUT_POST, 'auditid', FILTER_SANITIZE_NUMBER_INT);
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
    <title>ADL | View Closer Audit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/styles/viewlayout.css" type="text/css" />
    <script src="/js/jquery-1.4.min.js"></script>
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <script>
        function toggle(id) {
            if (document.getElementById(id).style.display == 'none') {
                document.getElementById(id).style.display = 'block';
            } else {
                document.getElementById(id).style.display = 'none';
            }
        }
    </script>
    <script type="text/javascript">

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'none';
            } else
                document.getElementById('ifYes').style.display = 'block';

        }

    </script>
</head>
<body>

    <div class="container">

        <?php
        $query = $pdo->prepare("SELECT * FROM closer_audits WHERE id = :search OR id = :auditid");
        $query->bindParam(':search', $search, PDO::PARAM_INT);
        $query->bindParam(':auditid', $auditid, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC)
        ?>

        <div class="wrapper col4">
            <table id='users'>
                <thead>

                    <tr>
                        <td colspan=2><b>Call Audit ID: <?php echo $search ?><?php echo $auditid ?></b></td>
                    </tr>

                    <tr>

                        <?php
                        if ($result['grade'] == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>" . $result['grade'] . "</b></td>";
                        } else if ($result['grade'] == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>" . $result['grade'] . "</b></td>";
                        } else if ($result['grade'] == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>" . $result['grade'] . "</b></td>";
                        }
                        ?>
                    </tr>

                    <tr>
                        <td colspan=2><?php echo $result['total']; ?>/ 54 answered correctly</td>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php echo $result['auditor']; ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php echo $result['closer']; ?> - <?php echo $result['closer2']; ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php echo $result['date_submitted']; ?></td>
                    </tr>

                    <tr>
                        <td>Policy/AN Number</td>
                        <td><?php echo $result['policy_number']; ?> / <?php echo $result['an_number']; ?></td>
                    </tr>

                </thead>
            </table>

            <h1><b>Opening Declaration</b></h1>

            <p>
                <label for="q1">Q1. Was The Customer Made Aware That Calls Are Recorded For Training And Monitoring Purposes?</label><br>
                <input type="radio" name="q1" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q1'] == "Yes") { echo "checked"; }?> >Yes
                <input type="radio" name="q1" value="No" onclick="return false"onclick="return false"<?php if ($result['q1'] == "No") echo "checked" ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php echo $result['c1'] ?>
            </div>
            </p>

            <p>
                <label for="q2">Q2. Was The Customer Informed That General Insurance Is Regulated By The FCA?</label><br>
                <input type="radio" name="q2" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q2'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q2" value="No" onclick="return false"onclick="return false"<?php if ($result['q2'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c2'] ?>
            </div>
            </p>

            <p>
                <label for="q3">Q3. Did The Customer Consent To The Abbreviated Script Being Read? (If no, was the full disclosure read?)</label><br>
                <input type="radio" name="q3" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q3'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q3" value="No" onclick="return false"onclick="return false"<?php if ($result['q3'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c3'] ?>
            </div>
            </p>

            <p>
                <label for="q4">Q4. Did The Sales Agent Provide The Name And Details Of The Firm Who Is Regulated With The FCA?</label><br>


                <input type="radio" name="q4" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q4'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q4" value="No" onclick="return false"onclick="return false"<?php if ($result['q4'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c4'] ?>
            </div>
            </p>

            <p>
                <label for="q5">Q5. Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>

                <input type="radio" name="q5" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q5'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q5" value="No" onclick="return false"onclick="return false"<?php if ($result['q5'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c5'] ?>
            </div>
            </p>


            <h1><b>Customer Information</b></h1>

            <p>
                <label for="q6">Q6. Were All Clients Titles And Names Recorded Correctly?</label><br>

                <input type="radio" name="q6" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q6'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q6" value="No" onclick="return false"onclick="return false"<?php if ($result['q6'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c6'] ?>
            </div>
            </p>

            <label for="q7">Q7. Was The Clients Gender Accurately Recorded?</label><br>

            <input type="radio" name="q7" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q7'] == "Yes") echo "checked" ?> >Yes
            <input type="radio" name="q7" value="No" onclick="return false"onclick="return false"<?php if ($result['q7'] == "No") echo "checked" ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php echo $result['c7'] ?>
            </div>
            </p>
            <p>
                <label for="q8">Q8. Was The Clients Date Of Birth Accurately Recorded?</label><br>

                <input type="radio" name="q8" value="Yes"<?php if ($result['q8'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q8" value="No"<?php if ($result['q8'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c8'] ?>
            </div>
            </p>
            </p>

            <p>
                <label for="q9">Q9. Was The Clients Smoker Status Recorded Correctly?</label><br>

                <input type="radio" name="q9" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q9'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q9" value="No" onclick="return false"onclick="return false"<?php if ($result['q9'] == "No") echo "checked" ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php echo $result['c9'] ?>
            </div>
            </p>

            <p>
                <label for="q10">Q10. Was The Clients Employment Status Recorded Correctly?</label><br>

                <input type="radio" name="q10" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q10'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q10" value="No" onclick="return false"onclick="return false"<?php if ($result['q10'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c10'] ?>
            </div>
            </p>
            </p>

            <p>
                <label for="q11">Q11. Did The Sales Agent Confirm The Policy Was A Single Or Joint Application?</label><br>

                <input type="radio" name="q11" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q11'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q11" value="No" onclick="return false"onclick="return false"<?php if ($result['q11'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c11'] ?>
            </div>


            <h1><b>Identifying Clients Needs</b></h1>

            <p>
                <label for="q12">Q12. Did The Agent Check All Details Of What The Client Has With Their Existing Life Insurance Policy?</label><br>

                <input type="radio" name="q12" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q12'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q12" value="No" onclick="return false"onclick="return false"<?php if ($result['q12'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c12'] ?>
            </div>
            </p>

            <p>
                <label for="q53">Q13. Did the agent mention waiver, indexation, or TPD?</label><br>

                <input type="radio" name="q53" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q53'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q53" value="No" onclick="return false"onclick="return false"<?php if ($result['q53'] == "No") echo "checked" ?> ><label for="No">No</label>
                <input type="radio" name="q53" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q53'] == "N/A") echo "checked" ?> ><label for="N/A">N/A</label>


            <div class="phpcomments">
                <?php echo $result['c53'] ?>
            </div>
            </p>

            <p>
                <label for="q13">Q14. Did The Agent Ensure That The Client Was Provided With A Policy That Meet Their Needs? More Cover,Cheaper Premium Etc?</label><br>

                <input type="radio" name="q13" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q13'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q13" value="No" onclick="return false"onclick="return false"<?php if ($result['q13'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c13'] ?>
            </div>
            </p>

            <p>
                <label for="q14">Q15. Did The Sales Agent Provide The Customer With A Sufficient Amount Of Features And Benefits For The Policy?</label><br>

                <b><?php echo $result['q14'] ?></b> 

            <div class="phpcomments">
                <?php echo $result['c14'] ?>
            </div>
            </p>

            <p>
                <label for="q15">Q16. Agent confirmed This Policy Will Be Set Up With Legal And General?</label><br>

                <input type="radio" name="q15" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q15'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q15" value="No" onclick="return false"onclick="return false"<?php if ($result['q15'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c15'] ?>
            </div>
            </p>

            <h1><b>Eligibility</b></h1>

            <p>
                <label for="q55">Q17. Important customer information declaration?</label><br>

                <input type="radio" name="q55" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q55'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q55" value="No" onclick="return false"onclick="return false"<?php if ($result['q55'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c55'] ?>
            </div>
            </p>

            <p>
                <label for="q17">Q18. Were All Clients Contact Details Recorded Correctly?</label><br>

                <input type="radio" name="q17" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q17'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q17" value="No" onclick="return false"onclick="return false"<?php if ($result['q17'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c17'] ?>
            </div>
            </p>



            <p>
                <label for="q16">Q19. Were All Clients Address Details Recorded Correctly?</label><br>

                <input type="radio" name="q16" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q16'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q16" value="No" onclick="return false"onclick="return false"<?php if ($result['q16'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c16'] ?>
            </div>
            </p>

            <p>
                <label for="q31">Q20. Were All Doctors Details Recorded Correctly?</label><br>

                <input type="radio" name="q31" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q31'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q31" value="No" onclick="return false"onclick="return false"<?php if ($result['q31'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c31'] ?>
            </div>
            </p>

            <p>
                <label for="q18">Q21. Did The Agent Ask And Accurately Record The Work And Travel Questions And Record The Details Correctly?</label><br>

                <input type="radio" name="q18" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q18'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q18" value="No" onclick="return false"onclick="return false"<?php if ($result['q18'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c18'] ?>
            </div>
            </p>

            <p>
                <label for="q19">Q22. Did The Agent Ask And Accurately Record The Hazardous Activities Questions?</label><br>

                <input type="radio" name="q19" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q19'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q19" value="No" onclick="return false"onclick="return false"<?php if ($result['q19'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c19'] ?>
            </div>
            </p>

            <p>
                <label for="q20">Q23. Did The Agent Ask And Accurately Record The Height And Weight Details And Record The Details Correctly?</label><br>

                <input type="radio" name="q20" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q20'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q20" value="No" onclick="return false"onclick="return false"<?php if ($result['q20'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c20'] ?>
            </div>
            </p>

            <p>
                <label for="q21">Q24. Did The Agent Ask And Accurately Record The Smoking Details Correctly?</label><br>

                <input type="radio" name="q21" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q21'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q21" value="No" onclick="return false"onclick="return false"<?php if ($result['q21'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c21'] ?>
            </div>
            </p>

            <p>
                <label for="q22">Q25. Did The Agent Ask And Accurately Record The Drug Use Details Correctly?</label><br>

                <input type="radio" name="q22" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q22'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q22" value="No" onclick="return false"onclick="return false"<?php if ($result['q22'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c22'] ?>
            </div>
            </p>

            <p>
                <label for="q23">Q26. Did The Agent Ask And Accurately Record The Alcohol Consumption Details Correctly?</label><br>

                <input type="radio" name="q23" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q23'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q23" value="No" onclick="return false"onclick="return false"<?php if ($result['q23'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c23'] ?>
            </div>
            </p>

            <p>
                <label for="q24">Q27. Were All Health Ever Questions Asked And Details Recorded Correctly?</label><br>

                <input type="radio" name="q24" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q24'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q24" value="No" onclick="return false"onclick="return false"<?php if ($result['q24'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c24'] ?>
            </div>
            </p>

            <p>
                <label for="q25">Q28. Were All Health Last 5 Years Questions Asked And Details Recorded Correctly?</label><br>

                <input type="radio" name="q25" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q25'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q25" value="No" onclick="return false"onclick="return false"<?php if ($result['q25'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c25'] ?>
            </div>
            </p>

            <p>
                <label for="q26">Q29. Were All Health Last 2 Years Questions Asked And Details Recorded Correctly?</label><br>

                <input type="radio" name="q26" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q26'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q26" value="No" onclick="return false"onclick="return false"<?php if ($result['q26'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c26'] ?>
            </div>
            </p>

            <p>
                <label for="q27">Q30. Were All Health Continued Questions Asked And Details Recorded Correctly?</label><br>

                <input type="radio" name="q27" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q27'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q27" value="No" onclick="return false"onclick="return false"<?php if ($result['q27'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c27'] ?>
            </div>
            </p>

            <p>
                <label for="q28">Q31. Were All Family History Questions Asked And Details Recorded Correctly?</label><br>

                <input type="radio" name="q28" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q28'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q28" value="No" onclick="return false"onclick="return false"<?php if ($result['q28'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c28'] ?>
            </div>
            </p>

            <p>
                <label for="q29">Q32. Were Term For Term Details Recorded Correctly?</label><br>

                <b><?php echo $result['q29'] ?></b>

            <div class="phpcomments">
                <?php echo $result['c29'] ?>
            </div>
            </p>

            <h1><b>Declarations of Insurance</b></h1>

            <p>
                <label for="q30">Q33. Customer declaration read out?</label><br>

                <input type="radio" name="q30" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q30'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q30" value="No" onclick="return false"onclick="return false"<?php if ($result['q30'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c30'] ?>
            </div>
            </p>


            <p>
                <label for="q54">Q34. If appropriate did the agent confirm the exclusions on the policy</label><br>

                <input type="radio" name="q54" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q54'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q54" value="No" onclick="return false"onclick="return false"<?php if ($result['q54'] == "No") echo "checked" ?> ><label for="No">No</label>
                <input type="radio" name="q54" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q54'] == "N/A") echo "checked" ?> ><label for="N/A">N/A</label>


            <div class="phpcomments">
                <?php echo $result['c54'] ?>
            </div>
            </p>



            <h1><b>Payment Information</b></h1>

            <p>
                <label for="q32">Q35. Was The Clients Policy Start Date Accurately Recorded?</label><br>

                <input type="radio" name="q32" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q32'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q32" value="No" onclick="return false"onclick="return false"<?php if ($result['q32'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c32'] ?>
            </div>
            </p>
            <p>
                <label for="q33">Q36. Did The Agent Offer To Read The Direct Debit Guarantee?</label><br>

                <input type="radio" name="q33" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q33'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q33" value="No" onclick="return false"onclick="return false"<?php if ($result['q33'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c33'] ?>
            </div>
            </p>

            <p>
                <label for="q34">Q37. Did The Agent Offer A Preferred Premium Collection Date?</label><br>

                <input type="radio" name="q34" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q34'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q34" value="No" onclick="return false"onclick="return false"<?php if ($result['q34'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c34'] ?>
            </div>
            </p>

            <p>
                <label for="q35">Q38. Did The Agent Take Bank Details Correctly?</label><br>

                <input type="radio" name="q35" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q35'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q35" value="No" onclick="return false"onclick="return false"<?php if ($result['q35'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c35'] ?>
            </div>
            </p>

            <p>
                <label for="q36">Q39. Did They Have Consent Off The Premium Payer?</label><br>

                <input type="radio" name="q36" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q36'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q36" value="No" onclick="return false"onclick="return false"<?php if ($result['q36'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c36'] ?>
            </div>
            </p>
            </p>

            <h1><b>Consolidation Declaration</b></h1>

            <p>
                <label for="q38">Q40. Agent confirmed The Customers Rights To Cancel The Policy At Any Anytime And If The Customer Changes Their Mind Within The First 30 Days Of Starting There Will Be A Refund Of Premiums?</label><br>

                <input type="radio" name="q38" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q38'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q38" value="No" onclick="return false"onclick="return false"<?php if ($result['q38'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c38'] ?>
            </div>
            </p>

            <p>
                <label for="q39">Q41. Agent confirmed If The Policy Is Cancelled At Any Other Time The Cover Will End And No Refund Will Be Made And That The Policy Has No Cash In Value?</label><br>

                <input type="radio" name="q39" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q39'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q39" value="No" onclick="return false"onclick="return false"<?php if ($result['q39'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c39'] ?>
            </div>
            </p>

            <p>
                <label for="q40">Q42. Like Mentioned Earlier Did The Sales Agent Make The Customer Aware That They Are Unable To Offer Advice Or Personal Opinion They Will Only Be Providing Them With An Information Based Service To Make Their Own Informed Decision?</label><br>

                <input type="radio" name="q40" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q40'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q40" value="No" onclick="return false"onclick="return false"<?php if ($result['q40'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c40'] ?>
            </div>
            </p>

            <p>
                <label for="q41">Q43. Closer confirmed that the client will be emailed the following: A policy booklet, quote, policy summary, and a keyfact document.</label><br>

                <input type="radio" name="q41" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q41'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q41" value="No" onclick="return false"onclick="return false"<?php if ($result['q41'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c41'] ?>
            </div>
            </p>

            <p>
                <label for="q42">Q44. Did the closer confirm that the customer will be getting a 'my account' email from Legal and General?</label><br>

                <input type="radio" name="q42" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q42'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q42" value="No" onclick="return false"onclick="return false"<?php if ($result['q42'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c42'] ?>
            </div>
            </p>

            <p>
                <label for="q43">Q45. Agent confirmed The Check Your Details Procedure?</label><br>

                <input type="radio" name="q43" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q43'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q43" value="No" onclick="return false"onclick="return false"<?php if ($result['q43'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c43'] ?>
            </div>
            </p>

            <p>
                <label for="q44">Q46. Agent Confirmed an approximate Direct Debit date and informed the customer it is not an exact date, but legal and general will write to them with a more specific date?</label><br>

                <input type="radio" name="q44" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q44'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q44" value="No" onclick="return false"onclick="return false"<?php if ($result['q44'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c44'] ?>
            </div>
            </p>

            <p>
                <label for="q45">Q47. Did the closer confirm to the customer to cancel their existing direct debit</label><br>

                <input type="radio" name="q45" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q45'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q45" value="No" onclick="return false"onclick="return false"<?php if ($result['q45'] == "No") echo "checked" ?> ><label for="No">No</label>
                <input type="radio" name="q45" value="N/A" onclick="return false"onclick="return false"<?php if ($result['q45'] == "N/A") echo "checked" ?> ><label for="N/A">N/A</label>

            <div class="phpcomments">
                <?php echo $result['c45'] ?>
            </div>
            </p>

            <h1><b>Quality Control</b></h1>

            <p>
                <label for="q46">Q48. Agent confirmed That They Have Set The Client Up On A Level/Decreasing/CIC Term Policy With Legal And General With Client Confirmation?</label><br>

                <input type="radio" name="q46" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q46'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q46" value="No" onclick="return false"onclick="return false"<?php if ($result['q46'] == "No") echo "checked" ?> ><label for="No">No</label>


            <div class="phpcomments">
                <?php echo $result['c46'] ?>
            </div>
            </p>

            <p>
                <label for="q47">Q49. Agent confirmed The Length Of The Policy In Years With Client Confirmation?</label><br>

                <input type="radio" name="q47" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q47'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q47" value="No" onclick="return false"onclick="return false"<?php if ($result['q47'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c47'] ?>
            </div>
            </p>
            <p>
                <label for="q48">Q50. Agent confirmed The Amount Of Cover On The Policy With Client Confirmation?</label><br>

                <input type="radio" name="q48" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q48'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q48" value="No" onclick="return false"onclick="return false"<?php if ($result['q48'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c48'] ?>
            </div>
            </p>

            <p>
                <label for="q49">Q51. Agent confirmed With The Client That They Have Understood Everything Today With Client Confirmation?</label><br>

                <input type="radio" name="q49" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q49'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q49" value="No" onclick="return false"onclick="return false"<?php if ($result['q49'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c49'] ?>
            </div>
            </p>

            <p>
                <label for="q50">Q52. Did The Customer Give Their Explicit Consent For The Policy To Be Set Up?</label><br>

                <input type="radio" name="q50" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q50'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q50" value="No" onclick="return false"onclick="return false"<?php if ($result['q50'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c50'] ?>
            </div>
            </p>

            <p>
                <label for="q51">Q53. Did The Agent Provide Contact Details For Bluestone Protect?</label><br>

                <input type="radio" name="q51" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q51'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q51" value="No" onclick="return false"onclick="return false"<?php if ($result['q51'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c51'] ?>
            </div>
            </p>

            <p>
                <label for="q52">Q54. Did The Sales Agent Keep To The Requirements Of A Non-Advised Sale, Providing An Information Based Service And Not Offering Advice Or Personal Opinion?</label><br>

                <input type="radio" name="q52" value="Yes" onclick="return false"onclick="return false"<?php if ($result['q52'] == "Yes") echo "checked" ?> >Yes
                <input type="radio" name="q52" value="No" onclick="return false"onclick="return false"<?php if ($result['q52'] == "No") echo "checked" ?> ><label for="No">No</label>

            <div class="phpcomments">
                <?php echo $result['c52'] ?>
            </div>
            </p>

            </form>
            </fieldset>


        </div>
    </div>


</body>
</html>
