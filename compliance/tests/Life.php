<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');
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
$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

if(isset($EXECUTE)) {
    $TID = filter_input(INPUT_GET, 'TID', FILTER_SANITIZE_NUMBER_INT);
    
    if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) {
        
           $query = $pdo->prepare("SELECT life_test_one_company, life_test_one_advisor, life_test_one_mark, life_test_one_grade, life_test_one_added_date, life_test_one_id FROM life_test_one WHERE life_test_one_id=:TID");
    $query->bindParam(':TID', $TID, PDO::PARAM_INT);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC); 
    }
    
    else {
            $query = $pdo->prepare("SELECT life_test_one_company, life_test_one_advisor, life_test_one_mark, life_test_one_grade, life_test_one_added_date, life_test_one_id FROM life_test_one WHERE life_test_one_id=:TID and life_test_one_company=:COMPANY");
    $query->bindParam(':TID', $TID, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC);
    }
    
$TEST_COMPANY=$data1['life_test_one_company'];
    $TEST_NAME=$data1['life_test_one_advisor'];
    $TEST_MARK=$data1['life_test_one_mark'];
    $TEST_GRADE=$data1['life_test_one_grade'];
    
    if ($query->rowCount()>=1) {  
        
    $query = $pdo->prepare("SELECT life_test_one_questions_q1, life_test_one_questions_q2, life_test_one_questions_q3, life_test_one_questions_q4, life_test_one_questions_q5, life_test_one_questions_q6, life_test_one_questions_q7, life_test_one_questions_q8, life_test_one_questions_q9, life_test_one_questions_q10, life_test_one_questions_q11, life_test_one_questions_q12, life_test_one_questions_q13, life_test_one_questions_q14 FROM life_test_one_questions WHERE life_test_one_questions_id_fk=:TID");
    $query->bindParam(':TID', $TID, PDO::PARAM_INT);
    $query->execute();
    $data2 = $query->fetch(PDO::FETCH_ASSOC);  
    
    $Q1=$data2['life_test_one_questions_q1'];
    $Q2=$data2['life_test_one_questions_q2'];
    $Q3=$data2['life_test_one_questions_q3'];
    $Q4=$data2['life_test_one_questions_q4'];
    $Q5=$data2['life_test_one_questions_q5'];
    $Q6=$data2['life_test_one_questions_q6'];
    $Q7=$data2['life_test_one_questions_q7'];
    $Q8=$data2['life_test_one_questions_q8'];
    $Q9=$data2['life_test_one_questions_q9'];
    $Q10=$data2['life_test_one_questions_q10'];
    $Q11=$data2['life_test_one_questions_q11'];
    $Q12=$data2['life_test_one_questions_q12'];
    $Q13=$data2['life_test_one_questions_q13'];
    $Q14=$data2['life_test_one_questions_q14'];
   
    
    $SEL_COMS = $pdo->prepare("SELECT life_test_one_comments_c1, life_test_one_comments_c2, life_test_one_comments_c3, life_test_one_comments_c4, life_test_one_comments_c5, life_test_one_comments_c6, life_test_one_comments_c7, life_test_one_comments_c8, life_test_one_comments_c9, life_test_one_comments_c10, life_test_one_comments_c11, life_test_one_comments_c12, life_test_one_comments_c13, life_test_one_comments_c14 FROM life_test_one_comments WHERE life_test_one_comments_id_fk=:TID");
    $SEL_COMS->bindParam(':TID', $TID, PDO::PARAM_INT);
    $SEL_COMS->execute();
    $data3 = $SEL_COMS->fetch(PDO::FETCH_ASSOC); 
    
    $C1=$data3['life_test_one_comments_c1'];
    $C2=$data3['life_test_one_comments_c2'];
    $C3=$data3['life_test_one_comments_c3'];
    $C4=$data3['life_test_one_comments_c4'];
    $C5=$data3['life_test_one_comments_c5'];
    $C6=$data3['life_test_one_comments_c6'];
    $C7=$data3['life_test_one_comments_c7'];
    $C8=$data3['life_test_one_comments_c8'];
    $C9=$data3['life_test_one_comments_c9'];
    $C10=$data3['life_test_one_comments_c10'];
    $C11=$data3['life_test_one_comments_c11'];
    $C12=$data3['life_test_one_comments_c12'];
    $C13=$data3['life_test_one_comments_c13'];
    $C14=$data3['life_test_one_comments_c14'];    
        
}
}
$q=1;
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ADL | Life Insurance Test</title>
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../../includes/NAV.php'); ?> 
        
        <div class="container">
            
            <form action="<?php if(isset($EXECUTE)) { } else { ?>/compliance/php/Life.php?EXECUTE=1<?php } ?>" method="POST"><br>

    <div class="card">
        <h4 class="card-header card-info"> <?php if(isset($EXECUTE)) { if($EXECUTE=='2') { echo "Test results for $TEST_NAME | Company: $TEST_COMPANY  ($TEST_MARK/14) Grade: $TEST_GRADE"; } } else { echo "Answer all questions from 1 - 14"; } ?></h4>
        
    <div class="card card-block">
<fieldset class="form-group row" <?php if(!isset($EXECUTE)) { } else { echo "disabled"; } ?>>
        
<legend class="col-form-legend col-8"><?php echo $q++; ?>. The shortfall in the amount of cover necessary to maintain the current living standards of dependants can also be referred to as the:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q1" id="q1" value="A" <?php if(isset($Q1) && $Q1=='A') { echo "checked"; } ?>>
<?php if(isset($Q1) && $Q1=='A') { echo "<p class='bg-danger'>"; } ?>A. Savings gap <?php if(isset($Q1) && $Q1=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q1" id="q1" value="B" <?php if(isset($Q1) && $Q1=='B') { echo "checked"; } ?>>
<?php if(isset($Q1) && $Q1=='B') { echo "<p class='bg-danger'>"; } ?>B. Pensions gap <?php if(isset($Q1) && $Q1=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q1" id="q1" value="C" <?php if(isset($Q1) && $Q1=='C') { echo "checked"; } ?>>
<?php if(isset($Q1) && $Q1=='C') { echo "<p class='bg-danger'>"; } ?>C. Investment gap <?php if(isset($Q1) && $Q1=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q1" id="q1" value="D" <?php if(isset($Q1) && $Q1=='D') { echo "checked"; } ?>>
<?php if(isset($Q1) && $Q1=='D') { echo "<p class='bg-success'>"; } ?>D. Protection gap <?php if(isset($Q1) && $Q1=='D') { echo "</p>"; } ?>
</label>
</div>
    
    <div class="form-check">
        <textarea class="form-check" name="c1" rows="5" cols="100"><?php if(isset($C1)) { echo $C1; } ?></textarea>
    </div>
    
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Where a business is considering putting in place key person insurance, they could do this in the form of:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="A" <?php if(isset($Q2) && $Q2=='A') { echo "checked"; } ?>>
<?php if(isset($Q2) && $Q2=='A') { echo "<p class='bg-danger'>"; } ?>A. Life assurance or critical illness<?php if(isset($Q2) && $Q2=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="B" <?php if(isset($Q2) && $Q2=='B') { echo "checked"; } ?>>
<?php if(isset($Q2) && $Q2=='B') { echo "<p class='bg-success'>"; } ?>B. Life assurance, critical illness or income protection<?php if(isset($Q2) && $Q2=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="C" <?php if(isset($Q2) && $Q2=='C') { echo "checked"; } ?>>
<?php if(isset($Q2) && $Q2=='C') { echo "<p class='bg-danger'>"; } ?>C. Critical illness or income protection<?php if(isset($Q2) && $Q2=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="D" <?php if(isset($Q2) && $Q2=='D') { echo "checked"; } ?>>
<?php if(isset($Q2) && $Q2=='D') { echo "<p class='bg-danger'>"; } ?>D. Life assurance or income protection<?php if(isset($Q2) && $Q2=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c2" rows="5" cols="100"><?php if(isset($C2)) { echo $C2; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Which of the following categories is likely to benefit most from Income Protection?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="A" <?php if(isset($Q3) && $Q3=='A') { echo "checked"; } ?>>
<?php if(isset($Q3) && $Q3=='A') { echo "<p class='bg-success'>"; } ?>A. Self-employed<?php if(isset($Q3) && $Q3=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="B" <?php if(isset($Q3) && $Q3=='B') { echo "checked"; } ?>>
<?php if(isset($Q3) && $Q3=='B') { echo "<p class='bg-danger'>"; } ?>B. Retired<?php if(isset($Q3) && $Q3=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="C" <?php if(isset($Q3) && $Q3=='C') { echo "checked"; } ?>>
<?php if(isset($Q3) && $Q3=='C') { echo "<p class='bg-danger'>"; } ?>C. Employed<?php if(isset($Q3) && $Q3=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="D" <?php if(isset($Q3) && $Q3=='D') { echo "checked"; } ?>>
<?php if(isset($Q3) && $Q3=='D') { echo "<p class='bg-danger'>"; } ?>D. Unemployed<?php if(isset($Q3) && $Q3=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c3" rows="5" cols="100"><?php if(isset($C3)) { echo $C3; } ?></textarea>
    </div>


<legend class="col-form-legend col-8"><?php echo $q++; ?>. Elaine, aged 28 and single, made a claim for employment support allowance (ESA), and has been placed in the work-related activity group. This means that she will have:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q4" id="q4" value="A" <?php if(isset($Q4) && $Q4=='A') { echo "checked"; } ?>>
<?php if(isset($Q4) && $Q4=='A') { echo "<p class='bg-danger'>"; } ?>A. A higher level of benefit than those in the support group.<?php if(isset($Q4) && $Q4=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q4" id="q4" value="B" <?php if(isset($Q4) && $Q4=='B') { echo "checked"; } ?>>
<?php if(isset($Q4) && $Q4=='B') { echo "<p class='bg-danger'>"; } ?>B. Benefits paid for a maximum of 14 weeks.<?php if(isset($Q4) && $Q4=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q4" id="q4" value="C" <?php if(isset($Q4) && $Q4=='C') { echo "checked"; } ?>>
<?php if(isset($Q4) && $Q4=='C') { echo "<p class='bg-success'>"; } ?>C. Been attending mandatory work-focused interviews from week 8 of her claim.<?php if(isset($Q4) && $Q4=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q4" id="q4" value="D" <?php if(isset($Q4) && $Q4=='D') { echo "checked"; } ?>>
<?php if(isset($Q4) && $Q4=='D') { echo "<p class='bg-danger'>"; } ?>D. A work capability assessment every 4 weeks.<?php if(isset($Q4) && $Q4=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c4" rows="5" cols="100"><?php if(isset($C4)) { echo $C4; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Colin, aged 68 has income in 2016/17 from his state basic pension and savings. In addition to this age, which of the following criteria determine his entitlement to the savings credit element of the state pension credit? Colin's...</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q5" id="q5" value="A" <?php if(isset($Q5) && $Q5=='A') { echo "checked"; } ?>>
<?php if(isset($Q5) && $Q5=='A') { echo "<p class='bg-success'>"; } ?>A. Level of income.<?php if(isset($Q5) && $Q5=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q5" id="q5" value="B" <?php if(isset($Q5) && $Q5=='B') { echo "checked"; } ?>>
<?php if(isset($Q5) && $Q5=='B') { echo "<p class='bg-danger'>"; } ?>B. State of health.<?php if(isset($Q5) && $Q5=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q5" id="q5" value="C" <?php if(isset($Q5) && $Q5=='C') { echo "checked"; } ?>>
<?php if(isset($Q5) && $Q5=='C') { echo "<p class='bg-danger'>"; } ?>C. Employment status.<?php if(isset($Q5) && $Q5=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q5" id="q5" value="D" <?php if(isset($Q5) && $Q5=='D') { echo "checked"; } ?>>
<?php if(isset($Q5) && $Q5=='D') { echo "<p class='bg-danger'>"; } ?>D. NI contribution record.<?php if(isset($Q5) && $Q5=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c5" rows="5" cols="100"><?php if(isset($C5)) { echo $C5; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Which of the following is a form of decreasing term assurance?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q6" id="q6" value="A" <?php if(isset($Q6) && $Q6=='A') { echo "checked"; } ?>>
<?php if(isset($Q6) && $Q6=='A') { echo "<p class='bg-danger'>"; } ?>A. Convertible term assurance.<?php if(isset($Q6) && $Q6=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q6" id="q6" value="B" <?php if(isset($Q6) && $Q6=='B') { echo "checked"; } ?>>
<?php if(isset($Q6) && $Q6=='B') { echo "<p class='bg-danger'>"; } ?>B. Flexible whole of life.<?php if(isset($Q6) && $Q6=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q6" id="q6" value="C" <?php if(isset($Q6) && $Q6=='C') { echo "checked"; } ?>>
<?php if(isset($Q6) && $Q6=='C') { echo "<p class='bg-danger'>"; } ?>C. Maximum investment plan.<?php if(isset($Q6) && $Q6=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q6" id="q6" value="D" <?php if(isset($Q6) && $Q6=='D') { echo "checked"; } ?>>
<?php if(isset($Q6) && $Q6=='D') { echo "<p class='bg-success'>"; } ?>D. Family Income Benefit.<?php if(isset($Q6) && $Q6=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c6" rows="5" cols="100"><?php if(isset($C6)) { echo $C6; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. George has a term assurance policy that includes terminal illness benefit. If he makes a claim, it will be paid if the life office decides that his life expectancy is less than:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q7" id="q7" value="A" <?php if(isset($Q7) && $Q7=='A') { echo "checked"; } ?>>
<?php if(isset($Q7) && $Q7=='A') { echo "<p class='bg-danger'>"; } ?>A. 6 months.<?php if(isset($Q7) && $Q7=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q7" id="q7" value="B" <?php if(isset($Q7) && $Q7=='B') { echo "checked"; } ?>>
<?php if(isset($Q7) && $Q7=='B') { echo "<p class='bg-danger'>"; } ?>B. 18 months.<?php if(isset($Q7) && $Q7=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q7" id="q7" value="C" <?php if(isset($Q7) && $Q7=='C') { echo "checked"; } ?>>
<?php if(isset($Q7) && $Q7=='C') { echo "<p class='bg-success'>"; } ?>C. 12 months.<?php if(isset($Q7) && $Q7=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q7" id="q7" value="D" <?php if(isset($Q7) && $Q7=='D') { echo "checked"; } ?>>
<?php if(isset($Q7) && $Q7=='D') { echo "<p class='bg-danger'>"; } ?>D. 9 months.<?php if(isset($Q7) && $Q7=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c7" rows="5" cols="100"><?php if(isset($C7)) { echo $C7; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Susan had an endowment policy assigned to her and is now making a maturity claim to the life office. To receive the benefits, she will need to produce:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q8" id="q8" value="A" <?php if(isset($Q8) && $Q8=='A') { echo "checked"; } ?>>
<?php if(isset($Q8) && $Q8=='A') { echo "<p class='bg-danger'>"; } ?>A. The deed of assignment.<?php if(isset($Q8) && $Q8=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q8" id="q8" value="B" <?php if(isset($Q8) && $Q8=='B') { echo "checked"; } ?>>
<?php if(isset($Q8) && $Q8=='B') { echo "<p class='bg-success'>"; } ?>B. The policy document and deed of assignment.<?php if(isset($Q8) && $Q8=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q8" id="q8" value="C" <?php if(isset($Q8) && $Q8=='C') { echo "checked"; } ?>>
<?php if(isset($Q8) && $Q8=='C') { echo "<p class='bg-danger'>"; } ?>C. The policy document.<?php if(isset($Q8) && $Q8=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q8" id="q8" value="D" <?php if(isset($Q8) && $Q8=='D') { echo "checked"; } ?>>
<?php if(isset($Q8) && $Q8=='D') { echo "<p class='bg-danger'>"; } ?>D. The policy document, deed of assignment and a letter from the assignor.<?php if(isset($Q8) && $Q8=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c8" rows="5" cols="100"><?php if(isset($C8)) { echo $C8; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. David has a life assurance policy with a UK  life office. At which of the following rates will the life fund be taxed on its capital gains after an indexation allowance?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q9" id="q9" value="A" <?php if(isset($Q9) && $Q9=='A') { echo "checked"; } ?>>
<?php if(isset($Q9) && $Q9=='A') { echo "<p class='bg-danger'>"; } ?>A. 10%.<?php if(isset($Q9) && $Q9=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q9" id="q9" value="B" <?php if(isset($Q9) && $Q9=='B') { echo "checked"; } ?>>
<?php if(isset($Q9) && $Q9=='B') { echo "<p class='bg-danger'>"; } ?>B. 18%.<?php if(isset($Q9) && $Q9=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q9" id="q9" value="C" <?php if(isset($Q9) && $Q9=='C') { echo "checked"; } ?>>
<?php if(isset($Q9) && $Q9=='C') { echo "<p class='bg-success'>"; } ?>C. 20%.<?php if(isset($Q9) && $Q9=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q9" id="q9" value="D" <?php if(isset($Q9) && $Q9=='D') { echo "checked"; } ?>>
<?php if(isset($Q9) && $Q9=='D') { echo "<p class='bg-danger'>"; } ?>D. 28%.<?php if(isset($Q9) && $Q9=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c9" rows="5" cols="100"><?php if(isset($C9)) { echo $C9; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Phillip and Gary held property as tenants in common. If on Phillip's death he passes his share to his sister, how will it be treated in relation to inheritance tax?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q10" id="q10" value="A" <?php if(isset($Q10) && $Q10=='A') { echo "checked"; } ?>>
<?php if(isset($Q10) && $Q10=='A') { echo "<p class='bg-danger'>"; } ?>A. It will be liable for inheritance tax at 20%.<?php if(isset($Q10) && $Q10=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q10" id="q10" value="B" <?php if(isset($Q10) && $Q10=='B') { echo "checked"; } ?>>
<?php if(isset($Q10) && $Q10=='B') { echo "<p class='bg-danger'>"; } ?>B. It will be exempt from inheritance tax.<?php if(isset($Q10) && $Q10=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q10" id="q10" value="C" <?php if(isset($Q10) && $Q10=='C') { echo "checked"; } ?>>
<?php if(isset($Q10) && $Q10=='C') { echo "<p class='bg-danger'>"; } ?>C. It will be liable for inheritance tax on a reducing scale.<?php if(isset($Q10) && $Q10=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q10" id="q10" value="D" <?php if(isset($Q10) && $Q10=='D') { echo "checked"; } ?>>
<?php if(isset($Q10) && $Q10=='D') { echo "<p class='bg-success'>"; } ?>D. It will potentially be liable for inheritance tax at 40%.<?php if(isset($Q10) && $Q10=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c10" rows="5" cols="100"><?php if(isset($C10)) { echo $C10; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Pauline is returning to a different employment after a period of illness when she was claiming benefits from her income protection policy. If this results in her receiving a lower level of pay, which benefit may her policy pay to her?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q11" id="q11" value="A" <?php if(isset($Q11) && $Q11=='A') { echo "checked"; } ?>>
<?php if(isset($Q11) && $Q11=='A') { echo "<p class='bg-danger'>"; } ?>A. A lump sum payment.<?php if(isset($Q11) && $Q11=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q11" id="q11" value="B" <?php if(isset($Q11) && $Q11=='B') { echo "checked"; } ?>>
<?php if(isset($Q11) && $Q11=='B') { echo "<p class='bg-success'>"; } ?>B. A proportionate benefit in relation to her new earnings.<?php if(isset($Q11) && $Q11=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q11" id="q11" value="C" <?php if(isset($Q11) && $Q11=='C') { echo "checked"; } ?>>
<?php if(isset($Q11) && $Q11=='C') { echo "<p class='bg-danger'>"; } ?>C. A rehabilitation benefit in relation to her new earnings.<?php if(isset($Q11) && $Q11=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q11" id="q11" value="D" <?php if(isset($Q11) && $Q11=='D') { echo "checked"; } ?>>
<?php if(isset($Q11) && $Q11=='D') { echo "<p class='bg-danger'>"; } ?>D. The same level of benefit for a maximum of 2 years.<?php if(isset($Q11) && $Q11=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c11" rows="5" cols="100"><?php if(isset($C11)) { echo $C11; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Anne wants an income protection policy which includes an element of protection against inflation. Which of the following options may be available?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q12" id="q12" value="A" <?php if(isset($Q12) && $Q12=='A') { echo "checked"; } ?>>
<?php if(isset($Q12) && $Q12=='A') { echo "<p class='bg-danger'>"; } ?>A. An amount of increase chosen by the insurer every five years.<?php if(isset($Q12) && $Q12=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q12" id="q12" value="B" <?php if(isset($Q12) && $Q12=='B') { echo "checked"; } ?>>
<?php if(isset($Q12) && $Q12=='B') { echo "<p class='bg-danger'>"; } ?>B. An amount of increase chosen by her every year.<?php if(isset($Q12) && $Q12=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q12" id="q12" value="C" <?php if(isset($Q12) && $Q12=='C') { echo "checked"; } ?>>
<?php if(isset($Q12) && $Q12=='C') { echo "<p class='bg-success'>"; } ?>C. An automatic increase at stated periods without further underwriting.<?php if(isset($Q12) && $Q12=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q12" id="q12" value="D" <?php if(isset($Q12) && $Q12=='D') { echo "checked"; } ?>>
<?php if(isset($Q12) && $Q12=='D') { echo "<p class='bg-danger'>"; } ?>D. An automatic increase on the occurrence of stated life events.<?php if(isset($Q12) && $Q12=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c12" rows="5" cols="100"><?php if(isset($C12)) { echo $C12; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. The Free Asset Ratio (FAR) of a life office gives an indication of:</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q13" id="q13" value="A" <?php if(isset($Q13) && $Q13=='A') { echo "checked"; } ?>>
<?php if(isset($Q13) && $Q13=='A') { echo "<p class='bg-danger'>"; } ?>A. Annual new business.<?php if(isset($Q13) && $Q13=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q13" id="q13" value="B" <?php if(isset($Q13) && $Q13=='B') { echo "checked"; } ?>>
<?php if(isset($Q13) && $Q13=='B') { echo "<p class='bg-danger'>"; } ?>B. Future Profit.<?php if(isset($Q13) && $Q13=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q13" id="q13" value="C" <?php if(isset($Q13) && $Q13=='C') { echo "checked"; } ?>>
<?php if(isset($Q13) && $Q13=='C') { echo "<p class='bg-danger'>"; } ?>C. Pay claim history.<?php if(isset($Q13) && $Q13=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q13" id="q13" value="D" <?php if(isset($Q13) && $Q13=='D') { echo "checked"; } ?>>
<?php if(isset($Q13) && $Q13=='D') { echo "<p class='bg-success'>"; } ?>D. Financial strength.<?php if(isset($Q13) && $Q13=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c13" rows="5" cols="100"><?php if(isset($C13)) { echo $C13; } ?></textarea>
    </div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Carol and Emily run a hairdressing salon as a partnership. What will happen to the partnership if Carol dies and there is no partnership agreement in place?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q14" id="q14" value="A" <?php if(isset($Q14) && $Q14=='A') { echo "checked"; } ?>>
<?php if(isset($Q14) && $Q14=='A') { echo "<p class='bg-danger'>"; } ?>A. Carol's share will pass to Emily who can continue as a sole trader.<?php if(isset($Q14) && $Q14=='A') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q14" id="q14" value="B" <?php if(isset($Q14) && $Q14=='B') { echo "checked"; } ?>>
<?php if(isset($Q14) && $Q14=='B') { echo "<p class='bg-danger'>"; } ?>B. Emily can purchase Carol's share and then continue as a sole trader.<?php if(isset($Q14) && $Q14=='B') { echo "</p>"; } ?>
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q14" id="q14" value="C" <?php if(isset($Q14) && $Q14=='C') { echo "checked"; } ?>>
<?php if(isset($Q14) && $Q14=='C') { echo "<p class='bg-danger'>"; } ?>C. Emily will have the option of continuing the business or dissolving it.<?php if(isset($Q14) && $Q14=='C') { echo "</p>"; } ?>
</label>
</div>
    <div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q14" id="q14" value="D" <?php if(isset($Q14) && $Q14=='D') { echo "checked"; } ?>>
<?php if(isset($Q14) && $Q14=='D') { echo "<p class='bg-success'>"; } ?>D. The partnership will be automatically dissolved.<?php if(isset($Q14) && $Q14=='D') { echo "</p>"; } ?>
</label>
</div>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c14" rows="5" cols="100"><?php if(isset($C14)) { echo $C14; } ?></textarea>

    </div>

        <?php
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
         <div class="col-9"> <div class="form-group">
    <label for="COMPANY_ENTITY">Company:</label>
    <select class="form-control" name='COMPANY_ENTITY'>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='Bluestone Protect') { echo "selected"; } ?> value='Bluestone Protect'>Bluestone Protect</option>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='Protect Family Plans') { echo "selected"; } ?> value='Protect Family Plans'>Protect Family Plans</option>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='Protected Life Ltd') { echo "selected"; } ?> value='Protected Life Ltd'>Protected Life Ltd</option>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='We Insure') { echo "selected"; } ?> value='We Insure'>We Insure</option>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='The Financial Assessment Centre') { echo "selected"; } ?> value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option <?php if(isset($RID_COMPANY) && $RID_COMPANY=='Assured Protect and Mortgages') { echo "selected"; } ?> value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
  </div>
         </div>
            
      <?php  }
        
        ?>  


<?php if(!isset($EXECUTE)) { ?>
<button type="submit" class="btn btn-primary">Finish</button>
<?php } ?>

</fieldset>



        
        
    </div>
        <div class="card-footer">End of questions.</div>
</div>
</form> 
          
   </div>
        
        
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>    
    </body>
</html>
