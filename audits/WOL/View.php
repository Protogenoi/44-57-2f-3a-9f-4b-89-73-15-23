<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

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

if ($ffaudits=='0') {
        
        header('Location: /../../CRMmain.php'); die;
    }

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /../../CRMmain.php'); die;

}
    
$QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);  

if(isset($QRY)) {
    if($QRY=='View') {
        $WOLID= filter_input(INPUT_GET, 'WOLID', FILTER_SANITIZE_NUMBER_INT);
        require_once(__DIR__ . '/../../classes/database_class.php');
        
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
           $grade=$WOL_AUDIT['grade'];
       }
       if(isset($WOL_AUDIT['added_by'])) {
           $added_by=$WOL_AUDIT['added_by'];
       }
       if(isset($WOL_AUDIT['closer'])) {
           $closer=$WOL_AUDIT['closer'];
       }
       if(isset($WOL_AUDIT['closer2'])) {
           $closer2=$WOL_AUDIT['closer2'];
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
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | View WOL Audit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="/styles/viewlayout.css" type="text/css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script src="/js/jquery-1.4.min.js"></script>
</head>
<body>
    
        <div class="container">
       <div class="wrapper col4">
            <table id='users'>
                <thead>

                    <tr>
                        <td colspan=2><b>One Family Call Audit ID: <?php echo $WOLID ?></b></td>
                    </tr>

                    <tr>

                        <?php
                        if(isset($grade)) { 
                        if ($grade == 'Amber') {
                            echo "<td style='background-color: #FF9900;' colspan=2><b>$grade</b></td>";
                        } else if ($grade == 'Green') {
                            echo "<td style='background-color: #109618;' colspan=2><b>$grade</b></td>";
                        } else if ($grade == 'Red') {
                            echo "<td style='background-color: #DC3912;' colspan=2><b>$grade</b></td>";
                        }
                        }
                        ?>
                    </tr>

                    <tr>
                        <td>Auditor</td>
                        <td><?php if(isset($added_by)) { echo $added_by; } ?></td>
                    </tr>

                    <tr>
                        <td>Closer(s)</td>
                        <td><?php if(isset($closer)) { echo $closer; } if(isset($closer2) && $closer2 !="None") { echo " - $closer2"; } ?><br></td>
                    </tr>

                    <tr>
                        <td>Date Submitted</td>
                        <td><?php if(isset($added_date)) {  echo $added_date; } ?></td>
                    </tr>

                    <tr>
                        <td>Policy Number</td>
                        <td><?php if(isset($policy_number)) {  echo $policy_number; } ?></td>
                    </tr>

                </thead>
            </table>
           
<br><h3 class="panel-title">Opening Declaration</h3>
                        
                        <label for="q1">Q1. Was the customer made aware that calls are recorded for training and monitoring purposes?</label><br>
                        <input type="radio" name="q1" <?php if (isset($q1) && $q1=="1") { echo  "checked"; }?> onclick="javascript:yesnoCheckc1();" value="1" id="yesCheckc1" <?php if(isset($QRY)) { if($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q1" <?php if (isset($q1) && $q1=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc1();" value="0" id="noCheckc1" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c1)) { echo $c1; } ?></div>

                        
                        <label for="q2">Q2. Was the customer informed that general insurance is regulated by the FCA?</label><br>
                        <input type="radio" name="q2" <?php if (isset($q2) && $q2=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc2();" value="1" id="yesCheckc2" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q2" <?php if (isset($q2) && $q2=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc2();" value="0" id="noCheckc2" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c2)) { echo $c2; } ?></div>
                     
                        
                        <label for="q3">Q3. Did the customer consent to the abbreviated script being read? If no, was the full disclosure read?</label><br>
                        <input type="radio" name="q3" <?php if (isset($q3) && $q3=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc3();" value="1" id="yesCheckc3" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q3" <?php if (isset($q3) && $q3=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc3();" value="0" id="noCheckc3" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No

                        <div class="phpcomments"><?php if(isset($c3)) { echo $c3; } ?></div>
                        
                        
                        <label for="q4">Q4. Did the closer provide the name and details of the firm who is regulated by the FCA?</label><br>
                        <input type="radio" name="q4" <?php if (isset($q4) && $q4=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc4();" value="1" id="yesCheckc4" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q4" <?php if (isset($q4) && $q4=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc4();" value="0" id="noCheckc4" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
      
                        <div class="phpcomments"><?php if(isset($c4)) { echo $c4; } ?></div>
                    
                        <br><h3 class="panel-title">Customer Information</h3>
                        
                        <label for="q5">Q5. Did the closer make the customer aware that they are unable to offer advice or personal opinion and that they will only be providing them with an information based service to make their own informed decision?</label><br>
                        <input type="radio" name="q5" <?php if (isset($q5) && $q5=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc5();" value="1" id="yesCheckc5" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q5" <?php if (isset($q5) && $q5=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc5();" value="0" id="noCheckc5" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c5)) { echo $c5; } ?></div>
                        
                        <label for="q6">Q6. Were all clients titles and names recorded correctly?</label><br>
                        <input type="radio" name="q6" <?php if (isset($q6) && $q6=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc6();" value="1" id="yesCheckc6" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q6" <?php if (isset($q6) && $q6=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc6();" value="0" id="noCheckc6" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        

                        <div class="phpcomments"><?php if(isset($c6)) { echo $c6; } ?></div>
                       
                        
                        <label for="q7">Q7. Was the clients gender accurately recorded?</label><br>
                        <input type="radio" name="q7"  <?php if (isset($q7) && $q7=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc7();" value="1" id="yesCheckc7" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q7" <?php if (isset($q7) && $q7=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc7();" value="0" id="noCheckc7" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        

                        <div class="phpcomments"><?php if(isset($c7)) { echo $c7; } ?></div>
                       
                        <label for="q8">Q8. Was the clients date of birth accurately recorded?</label><br>
                        <input type="radio" name="q8" onclick="javascript:yesnoCheck();" <?php if (isset($q8) && $q8=="1") { echo "checked"; } ?> value="1" id="yesCheck" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q8" onclick="javascript:yesnoCheck();" <?php if (isset($q8) && $q8=="0") { echo "checked"; } ?> value="0" id="noCheck" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
       
                        <div class="phpcomments"><?php if(isset($c8)) { echo $c8; } ?></div>
                        
                        
                        <label for="q9">Q9. Was the clients smoking status recorded correctly?</label><br>
                        <input type="radio" name="q9" <?php if (isset($q9) && $q9=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc9();" value="1" id="yesCheckc9" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q9" <?php if (isset($q9) && $q9=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc9();" value="0" id="noCheckc9" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
          
                        <div class="phpcomments"><?php if(isset($c9)) { echo $c9; } ?></div>
                      
                        
                        <label for="q10">Q10. Did the closer confirm the policy was a single or a joint application?</label><br>
                        <input type="radio" name="q10" <?php if (isset($q10) && $q10=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc10();" value="1" id="yesCheckc10" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q10" <?php if (isset($q10) && $q10=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc10();" value="0" id="noCheckc10" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
      
                        <div class="phpcomments"><?php if(isset($c10)) { echo $c10; } ?></div>
                      
                        
                        <label for="q11">Q11. Did the closer check all details of what the client has with their existing life insurance policy?</label><br>
                        <input type="radio" name="q11" <?php if (isset($q11) && $q11=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc11();" value="1" id="yesCheckc11" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q11" <?php if (isset($q11vvv) && $q11=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc11();" value="0" id="noCheckc11" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c11)) { echo $c11; } ?></div>
           
  <br><h3 class="panel-title">Identifying Clients Needs</h3> 
  
   <label for="q12">Q12. Did the closer ensure that the client was provided with a policy that met their needs (more cover, cheaper premium etc...)?</label><br>
                        <input type="radio" name="q12" <?php if (isset($q12) && $q12=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc12();" value="1" id="yesCheckc12" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q12" <?php if (isset($q12) && $q12=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc12();" value="0" id="noCheckc12" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
   
                        <div class="phpcomments"><?php if(isset($c12)) { echo $c12; } ?></div>
                       
                        <label for="q13">Q13. Did The closer provide the customer with a sufficient amount of features and benefits for the policy?</label><br>
                        <select class="form-control" name="q13">
                            <option value="0" <?php if(isset($q13)) { if($q13=='0') { echo "selected"; } } ?> <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Select...</option>
                            <option value="1" <?php if(isset($q13)) { if($q13=='1') { echo "selected"; } } ?>>More than sufficient</option>
                            <option value="2" <?php if(isset($q13)) { if($q13=='2') { echo "selected"; } } ?>>Sufficient</option>
                            <option value="3" <?php if(isset($q13)) { if($q13=='3') { echo "selected"; } } ?>>Adequate</option>
                            <option value="4" <?php if(isset($q13)) { if($q13=='4') { echo "selected"; } } ?> onclick="javascript:yesnoCheckc13();" id="yesCheckc13">Poor</option>
                        </select>
                      
                        <div class="phpcomments"><?php if(isset($c13)) { echo $c13; } ?></div>
                      
                        <label for="q14">Q14. Closer confirmed this policy will be set up with One Family?</label><br>
                        <input type="radio" name="q14" <?php if (isset($q14) && $q14=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc14();" value="1" id="yesCheckc14" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q14" <?php if (isset($q14) && $q14=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc14();" value="0" id="noCheckc14" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
           
                        <div class="phpcomments"><?php if(isset($c14)) { echo $c14; } ?></div>
                     
  <br><h3 class="panel-title">Eligibility</h3>
  
 <label for="q15">Q15. Were all clients contact details recorded correctly?</label><br>
                        <input type="radio" name="q15" <?php if (isset($q15) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc15();" value="1" id="yesCheckc15" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q15" <?php if (isset($q15) && $q15=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc15();" value="0" id="noCheckc15" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                
                        <div class="phpcomments"><?php if(isset($c15)) { echo $c15; } ?></div>

                        
                        <label for="q16">Q16. Were all clients address details recorded correctly?</label><br>
                        <input type="radio" name="q16" <?php if (isset($q16) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc16();" value="1" id="yesCheckc16" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q16" <?php if (isset($q16) && $q16=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc16();" value="0" id="noCheckc16" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                  
                        <div class="phpcomments"><?php if(isset($c16)) { echo $c16; } ?></div>
              
                        <label for="q17">Q17. Did the agent explain trust?</label><br>
                        <input type="radio" name="q17" <?php if (isset($q17) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc17();" value="1" id="yesCheckc17" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q17" <?php if (isset($q17) && $q17=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc17();" value="0" id="noCheckc17" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
       
                        <div class="phpcomments"><?php if(isset($c17)) { echo $c17; } ?></div>
                                
                        
                        <label for="q18">Q18. Did the agent explain funeral contribution?</label><br>
                        <input type="radio" name="q18" <?php if (isset($q18) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc18();" value="1" id="yesCheckc18" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q18" <?php if (isset($q18) && $q18=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc18();" value="0" id="noCheckc18" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        <br>
                        <label for="q19">Q19. Did the agent offer to nominate a beneficiary?</label><br>
                        <input type="radio" name="q19" <?php if (isset($q19) && $q15=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc19();" value="1" id="yesCheckc19" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q19" <?php if (isset($q19) && $q19=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc19();" value="0" id="noCheckc19" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
   
                        <div class="phpcomments"><?php if(isset($c19)) { echo $c19; } ?></div>
  
 <br><h3 class="panel-title">Payment Information</h3> 

                        <label for="q20">Q20. Was the clients policy start date accurately recorded?</label><br>
                        <input type="radio" name="q20" <?php if (isset($q20) && $q20=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc20();" value="1" id="yesCheckc20" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q20" <?php if (isset($q20) && $q20=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc20();" value="0" id="noCheckc20" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                       
                        <div class="phpcomments"><?php if(isset($c20)) { echo $c20; } ?></div>
                     
                        
                        <label for="q21">Q21. Did the closer offer to read the direct debit guarantee?</label><br>
                        <input type="radio" name="q21" <?php if (isset($q21) && $q21=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc21();" value="1" id="yesCheckc21" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q21" <?php if (isset($q21) && $q21=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc21();" value="0" id="noCheckc21" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
   
                        <div class="phpcomments"><?php if(isset($c21)) { echo $c21; } ?></div>
                     
                        
                        <label for="q22">Q22. Did the closer offer a preferred premium collection date?</label><br>
                        <input type="radio" name="q22" <?php if (isset($q22) && $q22=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc22();" value="1" id="yesCheckc22" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q22" <?php if (isset($q22) && $q22=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc22();" value="0" id="noCheckc22" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
             
                        <div class="phpcomments"><?php if(isset($c22)) { echo $c22; } ?></div>
                      
                        
                        <label for="q23">Q23. Did the closer record the bank details correctly?</label><br>
                        <input type="radio" name="q23" <?php if (isset($q23) && $q23=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc23();" value="1" id="yesCheckc23" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q23" <?php if (isset($q23) && $q23=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc23();" value="0" id="noCheckc23" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
            
                        <div class="phpcomments"><?php if(isset($c23)) { echo $c23; } ?></div>
                  
                        
                        <label for="q24">Q24. Did they have consent off the premium payer?</label><br>
                        <input type="radio" name="q24" <?php if (isset($q24) && $q24=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc24();" value="1" id="yesCheckc24" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q24" <?php if (isset($q24) && $q24=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc24();" value="0" id="noCheckc24" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
  
                        <div class="phpcomments"><?php if(isset($c24)) { echo $c24; } ?></div>
                       
<br><h3 class="panel-title">Consolidation Declaration</h3> 

  <label for="q25">Q25. Closer confirmed the customers right to cancel the policy at any time and if the customer changes their mind within the first 30 days of starting there will be a refund of premiums?</label><br>
                        <input type="radio" name="q25" <?php if (isset($q25) && $q25=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc25();" value="1" id="yesCheckc25" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q25" <?php if (isset($q25) && $q25=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc25();" value="0" id="noCheckc25" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
              
                        <div class="phpcomments"><?php if(isset($c25)) { echo $c25; } ?></div>
                    
                        
                        <label for="q26">Q26. Closer confirmed if the policy is cancelled at any other time the cover will end and no refund will be made and that the policy has no cash in value?</label><br>
                        <input type="radio" name="q26" <?php if (isset($q26) && $q26=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc26();" value="1" id="yesCheckc26" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q26" <?php if (isset($q26) && $q26=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc26();" value="0" id="noCheckc26" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c26)) { echo $c26; } ?></div>
                       
                        
                        <label for="q27">Q27. Like mentioned earlier did the closer make the customer aware that they are unable to offer advice or personal opinion and that they only provide an information based service to make their own informed decision?</label><br>
                        <input type="radio" name="q27" <?php if (isset($q27) && $q27=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc27();" value="1" id="yesCheckc27" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q27" <?php if (isset($q27) && $q27=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc27();" value="0" id="noCheckc27" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
          
                        <div class="phpcomments"><?php if(isset($c27)) { echo $c27; } ?></div>
                       
                        
                        <label for="q28">Q28. Closer confirmed that the client will be documents in the post from One Family?</label><br>
                        <input type="radio" name="q28" <?php if (isset($q28) && $q28=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc28();" value="1" id="yesCheckc28" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q28" <?php if (isset($q28) && $q28=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc28();" value="0" id="noCheckc28" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c28)) { echo $c28; } ?></div>
                 
                        
                        <label for="q29">Q29. Closer confirmed an approximate direct debit date and informed the customer it is not an exact date, but One Family will write to them with a more specific date?</label><br>
                        <input type="radio" name="q29" <?php if (isset($q29) && $q29=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc29();" value="1" id="yesCheckc29" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q29" <?php if (isset($q29) && $q29=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc29();" value="0" id="noCheckc29" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c29)) { echo $c29; } ?></div>
                       
                        
                        <label for="q30">Q30. Did the closer confirm to the customer to cancel any existing direct debit?</label><br>
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="1" id="yesCheckc30" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="0" id="noCheckc30" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        <input type="radio" name="q30" <?php if (isset($q30) && $q30=="2") { echo "checked"; } ?> onclick="javascript:yesnoCheckc30();" value="2" id="yesCheckc30" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>N/A
                        
                        <div class="phpcomments"><?php if(isset($c30)) { echo $c30; } ?></div>
                       
<br><h3 class="panel-title">Quality Control</h3>     

   <label for="q31">Q31. Closer confirmed that they have set up the client on a level/decreasing/CIC term policy with L&G with client information?</label><br>
                        <input type="radio" name="q31" <?php if (isset($q31) && $q31=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc31();" value="1" id="yesCheckc31" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q31" <?php if (isset($q31) && $q31=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc31();" value="0" id="noCheckc31" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
         
                        <div class="phpcomments"><?php if(isset($c31)) { echo $c31; } ?></div>
                    
                        
                        <label for="q32">Q32. Closer confirmed the amount of cover on the policy with client confirmation?</label><br>
                        <input type="radio" name="q32" <?php if (isset($q32) && $q32=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc32();" value="1" id="yesCheckc32" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q32" <?php if (isset($q32) && $q32=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc32();" value="0" id="noCheckc32" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c32)) { echo $c32; } ?></div>
            
                        <label for="q33">Q33. Closer confirmed with the client that they have understood everything today with client confirmation?</label><br>
                        <input type="radio" name="q33" <?php if (isset($q33) && $q33=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc33();" value="1" id="yesCheckc33" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q33" <?php if (isset($q33) && $q33=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc33();" value="0" id="noCheckc33" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c33)) { echo $c33; } ?></div>
                  
                        
                        <label for="q34">Q34. Did the customer give their explicit consent for the policy to be set up?</label><br>
                        <input type="radio" name="q34" <?php if (isset($q34) && $q34=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc34();" value="1" id="yesCheckc34" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q34" <?php if (isset($q34) && $q34=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc34();" value="0" id="noCheckc34" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
                        
                        <div class="phpcomments"><?php if(isset($c34)) { echo $c34; } ?></div>
                      
                        
                        <label for="q35">Q35. Closer provided contact details for Bluestone Protect?</label><br>
                        <input type="radio" name="q35" <?php if (isset($q35) && $q35=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc35();" value="1" id="yesCheckc35" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q35" <?php if (isset($q35) && $q35=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc35();" value="0" id="noCheckc35" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No

                        <div class="phpcomments"><?php if(isset($c35)) { echo $c35; } ?></div>
          
                        
                        <label for="q36">Q36. Did the closer keep to the requirements of a non-advised sale, providing an information based service and not offering advice or personal opinion?</label><br>
                        <input type="radio" name="q36" <?php if (isset($q36) && $q36=="1") { echo "checked"; } ?> onclick="javascript:yesnoCheckc36();" value="1" id="yesCheckc36" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>Yes
                        <input type="radio" name="q36" <?php if (isset($q36) && $q36=="0") { echo "checked"; } ?> onclick="javascript:yesnoCheckc36();" value="0" id="noCheckc36" <?php if(isset($QRY)) { if ($QRY=='View') { echo "disabled"; } } ?>>No
    
                        <div class="phpcomments"><?php if(isset($c36)) { echo $c36; } ?></div>
                      

       </div>
        </div>

   


</body>
</html>