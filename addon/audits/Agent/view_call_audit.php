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

$AUDITID = filter_input(INPUT_GET, 'AUDITID', FILTER_SANITIZE_NUMBER_INT);

if(isset($AUDITID)) {

    $database = new Database();  
    $database->beginTransaction();
    
    $database->query("SELECT 
                            DATE(adl_audits_date_added) AS adl_audits_date_added, 
                            adl_audits_auditor, 
                            adl_audits_grade, 
                            adl_audits_agent,
                            adl_audits_ref
                        FROM 
                            adl_audits 
                        WHERE 
                            adl_audits_id=:AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_AUDIT=$database->single();   
    
    if(isset($VIT_AUDIT['adl_audits_date_added'])) {
        
        $VIT_DATE=$VIT_AUDIT['adl_audits_date_added'];
        
    }
    
    if(isset($VIT_AUDIT['adl_audits_auditor'])) {
        
        $VIT_AUDITOR=$VIT_AUDIT['adl_audits_auditor'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_grade'])) {
        
        $VIT_GRADE=$VIT_AUDIT['adl_audits_grade'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_agent'])) {
        
        $VIT_AGENT=$VIT_AUDIT['adl_audits_agent'];
        
    }

    if(isset($VIT_AUDIT['adl_audits_ref'])) {
        
        $VIT_REF=$VIT_AUDIT['adl_audits_ref'];
        
    }  
    
    $database->query("SELECT 
        adl_audit_lead_id,
        adl_audit_lead_sec_1,
        adl_audit_lead_sec_2,
        adl_audit_lead_sec_3,
        adl_audit_lead_sec_4,
        adl_audit_lead_sec_c1,
        adl_audit_lead_sec_c2,
        adl_audit_lead_sec_c3,
        adl_audit_lead_sec_c4,
        adl_audit_lead_qua_a_1,
        adl_audit_lead_qua_a_2,
        adl_audit_lead_qua_a_3,
        adl_audit_lead_qua_a_4,
        adl_audit_lead_qua_a_5,
        adl_audit_lead_qua_a_6,
        adl_audit_lead_qua_a_7,
        adl_audit_lead_qua_a_8,
        adl_audit_lead_qua_a_9,
        adl_audit_lead_qua_a_10,
        adl_audit_lead_qua_a_11,
        adl_audit_lead_qua_a_c1,
        adl_audit_lead_qua_a_c2,
        adl_audit_lead_qua_a_c3,
        adl_audit_lead_qua_a_c4,
        adl_audit_lead_qua_a_c5,
        adl_audit_lead_qua_a_c6,
        adl_audit_lead_qua_a_c7,
        adl_audit_lead_qua_a_c8,
        adl_audit_lead_qua_a_c9,
        adl_audit_lead_qua_a_c10,
        adl_audit_lead_qua_a_c11,        
        adl_audit_lead_qua_b_1,
        adl_audit_lead_qua_b_2,
        adl_audit_lead_qua_sec3_1,
        adl_audit_lead_qua_sec3_c_1,
        adl_audit_lead_qua_sec4_1
  FROM
    adl_audit_lead
  WHERE
    adl_audit_lead_id_fk = :AUDITID");
    $database->bind(':AUDITID', $AUDITID);
    $database->execute();
    $VIT_Q_AUDIT=$database->single();   
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_id'])) {
        $AID_FK=$VIT_Q_AUDIT['adl_audit_lead_id'];
    }
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_1'])) {
        $SEC1=$VIT_Q_AUDIT['adl_audit_lead_sec_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_2'])) {
        $SEC2=$VIT_Q_AUDIT['adl_audit_lead_sec_2'];
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_3'])) {
        $SEC3=$VIT_Q_AUDIT['adl_audit_lead_sec_3'];
    }        
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_4'])) {
        $SEC4=$VIT_Q_AUDIT['adl_audit_lead_sec_4'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c1'])) {
        $SEC_C1=$VIT_Q_AUDIT['adl_audit_lead_sec_c1'];
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c2'])) {
        $SEC_C2=$VIT_Q_AUDIT['adl_audit_lead_sec_c2'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c3'])) {
        $SEC_C3=$VIT_Q_AUDIT['adl_audit_lead_sec_c3'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_sec_c4'])) {
        $SEC_C4=$VIT_Q_AUDIT['adl_audit_lead_sec_c4'];
    }  

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_1'])) {
        $SEC2_A_1=$VIT_Q_AUDIT['adl_audit_lead_qua_a_1'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_2'])) {
        $SEC2_A_2=$VIT_Q_AUDIT['adl_audit_lead_qua_a_2'];
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_3'])) {
        $SEC2_A_3=$VIT_Q_AUDIT['adl_audit_lead_qua_a_3'];
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_4'])) {
        $SEC2_A_4=$VIT_Q_AUDIT['adl_audit_lead_qua_a_4'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_5'])) {
        $SEC2_A_5=$VIT_Q_AUDIT['adl_audit_lead_qua_a_5'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_6'])) {
        $SEC2_A_6=$VIT_Q_AUDIT['adl_audit_lead_qua_a_6'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_7'])) {
        $SEC2_A_7=$VIT_Q_AUDIT['adl_audit_lead_qua_a_7'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_8'])) {
        $SEC2_A_8=$VIT_Q_AUDIT['adl_audit_lead_qua_a_8'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_9'])) {
        $SEC2_A_9=$VIT_Q_AUDIT['adl_audit_lead_qua_a_9'];
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_10'])) {
        $SEC2_A_10=$VIT_Q_AUDIT['adl_audit_lead_qua_a_10'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_11'])) {
        $SEC2_A_11=$VIT_Q_AUDIT['adl_audit_lead_qua_a_11'];
    } 
    
 if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c1'])) {
        $SEC2_A_C1=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c1'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c2'])) {
        $SEC2_A_C2=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c2'];
    }    
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c3'])) {
        $SEC2_A_C3=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c3'];
    }  
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c4'])) {
        $SEC2_A_C4=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c4'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c5'])) {
        $SEC2_A_C5=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c5'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c6'])) {
        $SEC2_A_C6=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c6'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c7'])) {
        $SEC2_A_C7=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c7'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c8'])) {
        $SEC2_A_C8=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c8'];
    }      
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c9'])) {
        $SEC2_A_C9=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c9'];
    }    

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c10'])) {
        $SEC2_A_C10=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c10'];
    }       
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_a_c11'])) {
        $SEC2_A_C11=$VIT_Q_AUDIT['adl_audit_lead_qua_a_c11'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_b_1'])) {
        $SEC2_B_1=$VIT_Q_AUDIT['adl_audit_lead_qua_b_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_b_2'])) {
        $SEC2_B_2=$VIT_Q_AUDIT['adl_audit_lead_qua_b_2'];
    }     
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec3_1'])) {
        $SEC3_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec3_1'];
    } 
    
    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec3_c_1'])) {
        $SEC3_C_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec3_c_1'];
    } 

    if(isset($VIT_Q_AUDIT['adl_audit_lead_qua_sec4_1'])) {
        $SEC4_1=$VIT_Q_AUDIT['adl_audit_lead_qua_sec4_1'];
    }   
    
    $database->endTransaction();  
    
}
if ($EXECUTE == '1') {
?>
<html>
    <html lang="en">
        <title>ADL | View Agent Call Audit</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/audit_view.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script>
            function textAreaAdjust(o) {
                o.style.height = "1px";
                o.style.height = (25 + o.scrollHeight) + "px";
            }
        </script>
    </head>
    <body>

        <div class="container">
                <div class="wrapper col4">

                    <table id='users'>

                        <thead>
                            <tr>
                                <td colspan="4"><b>Call Audit ID: <?php echo $AUDITID; ?></b></td>
                            </tr>
                            <tr>
                                <td>Auditor</td>
                                <td><?php echo $VIT_AUDITOR; ?></td>
                            </tr>

                            <tr>
                                <td>Agent(s)</td>
                                <td><b><?php echo $VIT_AGENT; ?></b><br></td>
                            </tr>

                            <tr>
                                <td>AN Number</td>
                                <td><?php echo $VIT_REF; ?><br></td>
                            </tr>


                            <tr>
                                <td>Date Submitted</td>
                                <td><?php echo $VIT_DATE; ?></td>
                            </tr>

                            <tr>


                                <td>Grade</td>
                                <?php
                                if ($VIT_GRADE == 'Amber') {
                                    echo "<td style='background-color: #FF9900;'><b>" . $VIT_GRADE . "</b></td>";
                                } else if ($VIT_GRADE == 'Green') {
                                    echo "<td style='background-color: #109618;'><b>" . $VIT_GRADE . "</b></td>";
                                } else if ($VIT_GRADE == 'Red') {
                                    echo "<td style='background-color: #DC3912;'><b>" . $VIT_GRADE . "</b></td>";
                                }
                                ?>
                            </tr>

                        </thead>
                    </table>

                    <br>
                    <h4>Opening Section 1</h4>
                    <br> 



                    <label for="full_info">Q1. Agent said their name?</label>


                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC1 == "Yes") {
                                    echo "checked";
                                } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC1 == "No") {
                                    echo "checked";
                                } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$SEC_C1</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="obj_handled">Q2. Said where they were calling from?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$SEC_C2</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="rapport">Q3. Said the reason for the call?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC3 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC3 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$SEC_C3</strong></h3>"; ?>
                    </div>
                    <br>

                    <label for="sq5">Q4. Agent followed the script?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC4 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC4 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$SEC_C4</strong></h3>"; ?>
                    </div>
                    <br>

                    <br>
                    <h4>Qualifying Section 2a</h4>
                    <br>      


                    <label for="full_info">Q1. Were all questions asked?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_1 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_1 == "No") {
                        echo "checked";
                    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C1)) { echo "<h3><strong>$SEC2_A_C1</strong></h3>"; } ?>
                    </div>                    
                    <br>

                    <label for="obj_handled">Q2. What was the main reason you took out the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_2 == "Yes") {
                        echo "checked";
                    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_2 == "No") {
                        echo "checked";
                    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C2)) {  echo "<h3><strong>$SEC2_A_C2</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="rapport">Q3. Repayment or interest only?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_3 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_3 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C3)) { echo "<h3><strong>$SEC2_A_C3</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="dealsheet_questions">Q4. When was your last review on the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_4 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_4 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C4)) { echo "<h3><strong>$SEC2_A_C4</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="full_info">Q5. How did you take out the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_5 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_5 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C5)) { echo "<h3><strong>$SEC2_A_C5</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="obj_handled">Q6. How much are you paying on a monthly basis?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_6 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_6 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C6)) { echo "<h3><strong>$SEC2_A_C6</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="rapport">Q7. How much are you covered for?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_7 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_7 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C7)) { echo "<h3><strong>$SEC2_A_C7</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="dealsheet_questions">Q8. How long do you have left on the policy?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_8 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_8 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C8)) { echo "<h3><strong>$SEC2_A_C8</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="full_info">Q9. Is your policy single, joint or separate?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_9 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_9 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C9)) { echo "<h3><strong>$SEC2_A_C9</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="obj_handled">Q10. Have you or your partner smoked in the last 12 months?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_10 == "Yes") {
                            echo "checked";
                        } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_10 == "No") {
                    echo "checked";
                } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C10)) { echo "<h3><strong>$SEC2_A_C10</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <label for="rapport">Q11. Have you or your partner got or has had any health issues?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_A_11 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_A_11 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php if(isset($SEC2_A_C11)) { echo "<h3><strong>$SEC2_A_C11</strong></h3>"; } ?>
                    </div> 
                    <br>

                    <br>
                    <h4>Section 2b</h4>
                    <br>   

                    <label for="rapport">Q1. Were all questions asked correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_B_1 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_B_1 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>

                    <br>

                    <label for="rapport">Q2. Were all questions recorded correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC2_B_2 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC2_B_2 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>

                    <br>

                    <br>
                    <h4>Section 3</h4>
                    <br>  

                    <label for="rapport">Q1. Did the agent stick to branding compliance?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC3_1 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC3_1 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>
                    <div class="phpcomments">
    <?php echo "<h3><strong>$SEC3_C_1</strong></h3> "; ?>
                    </div>

                    <br>
                    <h4>Section 4</h4>
                    <br>  

                    <label for="rapport">Q1. Were all personal details recorded correctly?</label>
                    <input type="radio" value="Yes" onclick="return false"onclick="return false"<?php if ($SEC4_1 == "Yes") {
        echo "checked";
    } ?>>Yes
                    <input type="radio" value="No" onclick="return false"onclick="return false"<?php if ($SEC4_1 == "No") {
        echo "checked";
    } ?>><label for="No">No</label>



            </div>

    </body>
</html>    <?php
}
?>