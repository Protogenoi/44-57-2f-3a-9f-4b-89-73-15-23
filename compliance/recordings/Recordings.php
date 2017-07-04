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
    $RID = filter_input(INPUT_GET, 'RID', FILTER_SANITIZE_NUMBER_INT);

    if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
        
    $query = $pdo->prepare("SELECT compliance_recordings_location, compliance_recordings_audited_by, compliance_recordings_audited_date, compliance_recordings_comments, compliance_recordings_status, compliance_recordings_advisor, compliance_recordings_grade, compliance_recordings_recording_date, compliance_recordings_company FROM compliance_recordings WHERE compliance_recordings_id=:RID");
    $query->bindParam(':RID', $RID, PDO::PARAM_INT);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC);        
        
    } 
    
    else { 
        
    $query = $pdo->prepare("SELECT compliance_recordings_location, compliance_recordings_audited_by, compliance_recordings_audited_date, compliance_recordings_comments, compliance_recordings_status, compliance_recordings_advisor, compliance_recordings_grade, compliance_recordings_recording_date, compliance_recordings_company FROM compliance_recordings WHERE compliance_recordings_company=:COMPANY AND compliance_recordings_id=:RID");
    $query->bindParam(':RID', $RID, PDO::PARAM_INT);
    $query->bindParam(':COMPANY', $COMPANY_ENTITY, PDO::PARAM_STR);
    $query->execute();
    $data1 = $query->fetch(PDO::FETCH_ASSOC);
    
    }
    
    $RID_AUDITED_BY=$data1['compliance_recordings_audited_by'];
    $TEST_AUDIT_DATE=$data1['compliance_recordings_audited_date'];
    $TEST_COMMENTS=$data1['compliance_recordings_comments'];
    
    $RID_STATUS=$data1['compliance_recordings_status'];
    $RID_ADVISOR=$data1['compliance_recordings_advisor'];
    $RID_DATE=$data1['compliance_recordings_recording_date'];
    $RID_COMPANY=$data1['compliance_recordings_company'];
    $RID_GRADE=$data1['compliance_recordings_grade'];
    $RID_LOCATION=$data1['compliance_recordings_location'];

}
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
        <title>ADL | Recording Audit</title>
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
<?php require_once(__DIR__ . '/../../includes/NAV.php'); ?> 
        
        <div class="container">
            
            <form action="<?php if(!isset($EXECUTE)) { } else { ?>/compliance/php/Recordings.php?EXECUTE=1&RID=<?php echo $RID; ?>&RDATE=<?php echo $RID_DATE; } ?>" method="POST"><br>

    <div class="card">
        <h4 class="card-header card-info"> <?php if(isset($EXECUTE)) { if($EXECUTE=='1') { echo "Call audit for: $RID_ADVISOR ($RID_COMPANY)"; } } else { } ?></h4>
        
    <div class="card card-block">
<fieldset class="form-group row">
<div class="col-9">
    
    <a href='<?php if(isset($RID_LOCATION)) { echo "/../$RID_LOCATION"; } ?>'><i class="fa fa-headphones"></i> Listen to Recording</a><br>
<input type="hidden" name="AGENT_NAME" value="<?php if(isset($RID_ADVISOR)) { echo $RID_ADVISOR; }?>"
  <div class="form-group">
                            <label for='GRADE'>Grade:</label>
                            <select class="form-control" name="GRADE" required>
                                <option <?php if(isset($RID_GRADE) && $RID_GRADE=='Not Graded') { echo "selected"; } ?> value="Not Graded">Not Graded</option>
                                <option <?php if(isset($RID_GRADE) && $RID_GRADE=='Green') { echo "selected"; } ?> value="Green">Green</option>
                                <option <?php if(isset($RID_GRADE) && $RID_GRADE=='Amber') { echo "selected"; } ?> value="Amber">Amber</option>
                                <option <?php if(isset($RID_GRADE) && $RID_GRADE=='Red') { echo "selected"; } ?> value="Red">Red</option>
                            </select>
                        </div>
       
        <?php
        
        if (in_array($hello_name, $COM_LVL_10_ACCESS, true)) { ?>
        
          <div class="form-group">
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
 
            
      <?php  }
        
        ?>          
    
    <div class="form-group">
                            <label for='STATUS'>Action required:</label>
                            <select class="form-control" name="STATUS" required>
                                <option <?php if(isset($RID_STATUS) && $RID_STATUS=='Not Audited') { echo "selected"; } ?> value="Not Audited">Not Audited</option>
                                <option <?php if(isset($RID_STATUS) && $RID_STATUS=='No Action') { echo "selected"; } ?> value="No Action">No Action</option>
                                <option <?php if(isset($RID_STATUS) && $RID_STATUS=='Re-training') { echo "selected"; } ?> value="Re-training">Re-training</option>
                                <option <?php if(isset($RID_STATUS) && $RID_STATUS=='Disciplinary') { echo "selected"; } ?> value="Disciplinary">Disciplinary</option>
                                <option <?php if(isset($RID_STATUS) && $RID_STATUS=='Informal Warning') { echo "selected"; } ?> value="Informal Warning">Informal Warning</option>
                            </select>
                        </div>    
    
    <div class="form-group">
        <textarea class="form-control" name="RID_COMMENTS" rows="5" cols="100" placeholder="Auditor comments"><?php if(isset($TEST_COMMENTS)) { echo $TEST_COMMENTS; } ?></textarea>
    </div>
    
</div>


<?php if(isset($EXECUTE)) { ?>
    <div class="form-group">
<button type="submit" class="btn btn-primary form-control">Finish Call Audit</button>
    </div>
<?php } ?>

</fieldset>



        
        
    </div>
        <div class="card-footer"></div>
</div>
</form> 

       
        
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>    
    </body>
</html>
