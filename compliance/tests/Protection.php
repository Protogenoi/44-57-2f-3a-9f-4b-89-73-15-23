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
       $query = $pdo->prepare("SELECT life_test_two_company, life_test_two_advisor, life_test_two_mark, life_test_two_grade, life_test_two_added_date, life_test_two_id FROM life_test_two WHERE life_test_two_id=:TID");
    $query->bindParam(':TID', $TID, PDO::PARAM_INT);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC);         
        }
    
        else {
        
    $query = $pdo->prepare("SELECT life_test_two_company, life_test_two_advisor, life_test_two_mark, life_test_two_grade, life_test_two_added_date, life_test_two_id FROM life_test_two WHERE life_test_two_id=:TID and life_test_two_company=:COMPANY");
    $query->bindParam(':TID', $TID, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC);
    
        }
    $TEST_COMPANY=$data1['life_test_two_company'];
    $TEST_NAME=$data1['life_test_two_advisor'];
    $TEST_MARK=$data1['life_test_two_mark'];
    $TEST_GRADE=$data1['life_test_two_grade'];
    
    if(empty($TEST_MARK)) {
        $TEST_MARK="Not yet marked";
    }
    
    if ($query->rowCount()>=1) {  
    
    $SEL_COMS = $pdo->prepare("SELECT life_test_two_qa_q2, life_test_two_qa_q3, life_test_two_qa_q15, life_test_two_qa_c1, life_test_two_qa_c2, life_test_two_qa_c3, life_test_two_qa_c4, life_test_two_qa_c5, life_test_two_qa_c6, life_test_two_qa_c7, life_test_two_qa_c8, life_test_two_qa_c9, life_test_two_qa_c10, life_test_two_qa_c11, life_test_two_qa_c12, life_test_two_qa_c13, life_test_two_qa_c14, life_test_two_qa_c15 FROM life_test_two_qa WHERE life_test_two_qa_id_fk=:TID");
    $SEL_COMS->bindParam(':TID', $TID, PDO::PARAM_INT);
    $SEL_COMS->execute();
    $data3 = $SEL_COMS->fetch(PDO::FETCH_ASSOC); 
    
    $Q2=$data3['life_test_two_qa_q2'];
    $Q3=$data3['life_test_two_qa_q3'];
    $Q15=$data3['life_test_two_qa_q15'];
    $C1=$data3['life_test_two_qa_c1'];
    $C2=$data3['life_test_two_qa_c2'];
    $C3=$data3['life_test_two_qa_c3'];
    $C4=$data3['life_test_two_qa_c4'];
    $C5=$data3['life_test_two_qa_c5'];
    $C6=$data3['life_test_two_qa_c6'];
    $C7=$data3['life_test_two_qa_c7'];
    $C8=$data3['life_test_two_qa_c8'];
    $C9=$data3['life_test_two_qa_c9'];
    $C10=$data3['life_test_two_qa_c10'];
    $C11=$data3['life_test_two_qa_c11'];
    $C12=$data3['life_test_two_qa_c12'];
    $C13=$data3['life_test_two_qa_c13'];
    $C14=$data3['life_test_two_qa_c14'];  
    $C15=$data3['life_test_two_qa_c15']; 
        
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
        <title>ADL | Protection Test</title>
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../../includes/NAV.php'); ?> 
        
        <div class="container">

            <form action="<?php if(!isset($EXCUTE)) { ?>/compliance/php/Protection.php?EXECUTE=1<?php } else { }?> " method="POST"><br>

    <div class="card">
        <h4 class="card-header card-info"> <?php if(isset($EXECUTE)) { if($EXECUTE=='2') { echo "Test results for $TEST_NAME | Company: $TEST_COMPANY ($TEST_MARK/15) Grade: $TEST_GRADE"; } } else { echo "Answer all questions from 1 - 15, as best as you can."; } ?></h4>
        
    <div class="card card-block">
<fieldset class="form-group row" <?php if(!isset($EXECUTE)) { } else { echo "disabled"; } ?>>
<legend class="col-form-legend col-8"><?php echo $q++; ?>. What is straight through processing?</legend>
    <div class="col-9">
    <div class="form-check">
        <textarea class="form-check" name="c1" rows="5" cols="100"><?php if(isset($C1)) { echo $C1; } ?></textarea>
    </div>
    
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Can critical illness cover be combined with life cover in one contract?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="Yes" <?php if(isset($Q2) && $Q2=='Yes') { echo "checked"; } ?>>
Yes
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q2" id="q2" value="No" <?php if(isset($Q2) && $Q2=='No') { echo "checked"; } ?>>
No
</label>
</div>

    <div class="form-check">
        <textarea class="form-check" name="c2" rows="5" cols="100"><?php if(isset($C2)) { echo $C2; } ?></textarea>
    </div>
</div>


<legend class="col-form-legend col-8"><?php echo $q++; ?>. For a person aged 35 is the risk of being off work due to illness or accident greater than the risk of death?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="Yes" <?php if(isset($Q3) && $Q3=='Yes') { echo "checked"; } ?>>
Yes
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q3" id="q3" value="No" <?php if(isset($Q3) && $Q3=='Yes') { echo "checked"; } ?>>
No
</label>

</div>

    <div class="form-check">
        <textarea class="form-check" name="c3" rows="5" cols="100"><?php if(isset($C3)) { echo $C3; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. What is the current NIL rate tax band for IHT?</legend>
<div class="col-9">


    <div class="form-check">
        <textarea class="form-check" name="c4" rows="5" cols="100"><?php if(isset($C4)) { echo $C4; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. How much is the government bereavement payment?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c5" rows="5" cols="100"><?php if(isset($C5)) { echo $C5; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. For what purpose is a joint LEFE second death policy normally used for?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c6" rows="5" cols="100"><?php if(isset($C6)) { echo $C6; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. How will an insurer treat a claim when there has been a negligent non disclosure of a material fact?</legend>
<div class="col-9">
    <div class="form-check">
        <textarea class="form-check" name="c7" rows="5" cols="100"><?php if(isset($C7)) { echo $C7; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. If terminal illness cover is part of a life policy when will it not normally apply?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c8" rows="5" cols="100"><?php if(isset($C8)) { echo $C8; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. What is the tax position of a payment made following a critical illness claim?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c9" rows="5" cols="100"><?php if(isset($C9)) { echo $C9; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. How often should a clients affairs be reviewed?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c10" rows="5" cols="100"><?php if(isset($C10)) { echo $C10; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. What does LTA stand for?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c11" rows="5" cols="100"><?php if(isset($C11)) { echo $C11; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. What does JLDTA stand for?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c12" rows="5" cols="100"><?php if(isset($C12)) { echo $C12; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. What does JLDCIC stand for?</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c13" rows="5" cols="100"><?php if(isset($C13)) { echo $C13; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Provide two reasons why life cover has reduced in price over the last few years.</legend>
<div class="col-9">

    <div class="form-check">
        <textarea class="form-check" name="c14" rows="5" cols="100"><?php if(isset($C14)) { echo $C14; } ?></textarea>
    </div>
</div>

<legend class="col-form-legend col-8"><?php echo $q++; ?>. Does terminal illness benefit increase the cost of a life insurance policy?</legend>
<div class="col-9">
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q15" id="q15" value="Yes" <?php if(isset($Q3) && $Q3=='Yes') { echo "checked"; } ?>>
Yes
</label>
</div>
<div class="form-check">
<label class="form-check-label">
<input class="form-check-input" type="radio" name="q15" id="q15" value="No" <?php if(isset($Q3) && $Q3=='Yes') { echo "checked"; } ?>>
No
</label>

</div>

    <div class="form-check">
        <textarea class="form-check" name="c15" rows="5" cols="100"><?php if(isset($C15)) { echo $C15; } ?></textarea>
    </div>
</div>

        <?php
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
         <div class="col-9"> <div class="form-group">
    <label for="COMPANY_ENTITY">Company:</label>
    <select class="form-control" name='COMPANY_ENTITY'>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='Bluestone Protect') { echo "selected"; } ?> value='Bluestone Protect'>Bluestone Protect</option>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='Protect Family Plans') { echo "selected"; } ?> value='Protect Family Plans'>Protect Family Plans</option>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='Protected Life Ltd') { echo "selected"; } ?> value='Protected Life Ltd'>Protected Life Ltd</option>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='We Insure') { echo "selected"; } ?> value='We Insure'>We Insure</option>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='The Financial Assessment Centre') { echo "selected"; } ?> value='The Financial Assessment Centre'>The Financial Assessment Centre</option>
        <option <?php if(isset($TEST_COMPANY) && $TEST_COMPANY=='Assured Protect and Mortgages') { echo "selected"; } ?> value='Assured Protect and Mortgages'>Assured Protect and Mortgages</option>
    </select>
  </div>
         </div>
            
      <?php  }
        
        ?>  

<?php if(!isset($EXECUTE)) { ?>
<button type="submit" class="btn btn-primary">Finish</button>
<?php } ?>

</fieldset>
</form> 
            
                        <?php if(isset($EXECUTE) && isset($TID) && in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
            <form method="POST" action="/compliance/php/Protection.php?EXECUTE=2&TID=<?php echo $TID;?>&NAME=<?php echo $TEST_NAME; ?>">
                
                 <div class="form-check">
                <input  class="form-control" type="number" placeholder="Questions answered correctly out of 15" name="PROTECTION_MARK">
                 </div>

                <button class="btn btn-primary" type="submit">Mark Test</button>
            </form>    
        <?php } ?>
            
    </div>
        <div class="card-footer">End of questions.</div>
</div>

          
   </div>
        
        
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>    
    </body>
</html>
