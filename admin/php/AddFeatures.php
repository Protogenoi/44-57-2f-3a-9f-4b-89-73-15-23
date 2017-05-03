<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }


include('../../includes/ADL_PDO_CON.php');
include('../../includes/ADL_MYSQLI_CON.php');

$addvar= filter_input(INPUT_GET, 'add', FILTER_SANITIZE_SPECIAL_CHARS);



if (isset($addvar)) {

$featurecallbacks= filter_input(INPUT_POST, 'featurecallbacks', FILTER_SANITIZE_NUMBER_INT);    
$featuredialler= filter_input(INPUT_POST, 'featuredialler', FILTER_SANITIZE_NUMBER_INT);
$featuresintemail= filter_input(INPUT_POST, 'featuresintemail', FILTER_SANITIZE_NUMBER_INT);
$featureclientemails= filter_input(INPUT_POST, 'featureclientemails', FILTER_SANITIZE_NUMBER_INT);
$featurekeyfacts= filter_input(INPUT_POST, 'featurekeyfacts', FILTER_SANITIZE_NUMBER_INT);
$featuregenemail= filter_input(INPUT_POST, 'featuregenemail', FILTER_SANITIZE_NUMBER_INT);
$featuresreemails= filter_input(INPUT_POST, 'featuresreemails', FILTER_SANITIZE_NUMBER_INT);
$featuresms= filter_input(INPUT_POST, 'featuresms', FILTER_SANITIZE_NUMBER_INT);
$featurescal= filter_input(INPUT_POST, 'featurescal', FILTER_SANITIZE_NUMBER_INT);
$featureaudits= filter_input(INPUT_POST, 'featureaudits', FILTER_SANITIZE_NUMBER_INT);
$featurelife= filter_input(INPUT_POST, 'featurelife', FILTER_SANITIZE_NUMBER_INT);
$featurepensions= filter_input(INPUT_POST, 'featurepensions', FILTER_SANITIZE_NUMBER_INT);
$featurehome= filter_input(INPUT_POST, 'featurehome', FILTER_SANITIZE_NUMBER_INT);
$featureanalytics= filter_input(INPUT_POST, 'featureanalytics', FILTER_SANITIZE_NUMBER_INT);
$featurepba= filter_input(INPUT_POST, 'featurepba', FILTER_SANITIZE_NUMBER_INT);
$featuregmaps= filter_input(INPUT_POST, 'featuregmaps', FILTER_SANITIZE_NUMBER_INT);
$featuretwitter= filter_input(INPUT_POST, 'featuretwitter', FILTER_SANITIZE_NUMBER_INT);
$featurepost_code= filter_input(INPUT_POST, 'featurepost_code', FILTER_SANITIZE_NUMBER_INT);

$featuredealsheets= filter_input(INPUT_POST, 'featuredealsheets', FILTER_SANITIZE_NUMBER_INT);
$featureemployee= filter_input(INPUT_POST, 'featureemployee', FILTER_SANITIZE_NUMBER_INT);
$featuretrackers= filter_input(INPUT_POST, 'featuretracker', FILTER_SANITIZE_NUMBER_INT);

$featureerror= filter_input(INPUT_POST, 'featureerror', FILTER_SANITIZE_NUMBER_INT);
$featureews= filter_input(INPUT_POST, 'featureews', FILTER_SANITIZE_NUMBER_INT);
$featurefinancials= filter_input(INPUT_POST, 'featurefinancials', FILTER_SANITIZE_NUMBER_INT);

$dupcheck = "Select id from adl_features";

$duperaw = $conn->query($dupcheck);

if ($duperaw->num_rows >= 1) {
    while($row = $duperaw->fetch_assoc()) {
        
    $dupeclientid=$row['id'];  
    }
 
    $update = $pdo->prepare("UPDATE adl_features set financials=:financials, ews=:ews, trackers=:trackers, dealsheets=:dealsheets, employee=:employee, post_code=:post, pba=:pba, error=:error, gmaps=:gmaps, twitter=:twitter, analytics=:analyticshold, callbacks=:callbackholder, dialler=:diallerholder, intemails=:internalholder, clientemails=:clientemailholder, keyfactsemail=:keyfactsholder, genemail=:genholder, recemail=:recholder, sms=:smsholder, calendar=:calholder, audits=:auditsholder, life=:lifeholder, home=:homeholder, pension=:penholder, added_by=:helloholder where id=:iddupe");
    
    $update->bindParam(':iddupe', $dupeclientid, PDO::PARAM_INT);
    $update->bindParam(':financials', $featurefinancials, PDO::PARAM_INT);
    $update->bindParam(':ews', $featureews, PDO::PARAM_INT);
    $update->bindParam(':trackers', $featuretrackers, PDO::PARAM_INT);
    $update->bindParam(':employee', $featureemployee, PDO::PARAM_INT);
    $update->bindParam(':dealsheets', $featuredealsheets, PDO::PARAM_INT);
    $update->bindParam(':callbackholder', $featurecallbacks, PDO::PARAM_INT);
        $update->bindParam(':diallerholder', $featuredialler, PDO::PARAM_INT);
        $update->bindParam(':internalholder', $featuresintemail, PDO::PARAM_INT);
        $update->bindParam(':clientemailholder', $featureclientemails, PDO::PARAM_INT);
        $update->bindParam(':keyfactsholder', $featurekeyfacts, PDO::PARAM_INT);
        $update->bindParam(':genholder', $featuregenemail, PDO::PARAM_INT);
        $update->bindParam(':helloholder', $hello_name, PDO::PARAM_INT);
        $update->bindParam(':recholder', $featuresreemails, PDO::PARAM_INT);
        $update->bindParam(':smsholder', $featuresms, PDO::PARAM_INT);
        $update->bindParam(':calholder', $featurescal, PDO::PARAM_INT);
        $update->bindParam(':auditsholder', $featureaudits, PDO::PARAM_INT);
        $update->bindParam(':lifeholder', $featurelife, PDO::PARAM_INT);
        $update->bindParam(':homeholder', $featurehome, PDO::PARAM_INT);
        $update->bindParam(':penholder', $featurepensions, PDO::PARAM_INT);
        $update->bindParam(':analyticshold', $featureanalytics, PDO::PARAM_INT);
        $update->bindParam(':gmaps', $featuregmaps, PDO::PARAM_INT);
        $update->bindParam(':twitter', $featuretwitter, PDO::PARAM_INT);
        $update->bindParam(':error', $featureerror, PDO::PARAM_INT);
        $update->bindParam(':pba', $featurepba, PDO::PARAM_INT);
        $update->bindParam(':post', $featurepost_code, PDO::PARAM_INT);

        
        $update->execute()or die(print_r($update->errorInfo(), true));
    

        
    header('Location: ../../admin/Admindash.php?featuresupdated=ydatabase&Settings=y'); die;

    }

if ($duperaw->num_rows <= 0) {
    
    $insert = $pdo->prepare("INSERT INTO adl_features set ews=:ews, financials=:financials, trackers=:trackers, dealsheets=:dealsheets, employee=:employee, post_code=:post, pba=:pba, error=:error, gmaps=:gmaps, twitter=:twitter, analytics=:analyticshold, callbacks=:callbackholder, dialler=:diallerholder, intemails=:internalholder, clientemails=:clientemailholder, keyfactsemail=:keyfactsholder, genemail=:genholder, recemail=:recholder, sms=:smsholder, calendar=:calholder, audits=:auditsholder, life=:lifeholder, home=:homeholder, pension=:penholder, added_by=:helloholder");
        $insert->bindParam(':employee', $featureemployee, PDO::PARAM_INT);
        $insert->bindParam(':financials', $featurefinancials, PDO::PARAM_INT);
        $insert->bindParam(':ews', $featureews, PDO::PARAM_INT);
        $insert->bindParam(':trackers', $featuretrackers, PDO::PARAM_INT);
    $insert->bindParam(':dealsheets', $featuredealsheets, PDO::PARAM_INT);
    $insert->bindParam(':callbackholder', $featurecallbacks, PDO::PARAM_INT);
        $insert->bindParam(':diallerholder', $featuredialler, PDO::PARAM_INT);
        $insert->bindParam(':internalholder', $featuresintemail, PDO::PARAM_INT);
        $insert->bindParam(':clientemailholder', $featureclientemails, PDO::PARAM_INT);
        $insert->bindParam(':keyfactsholder', $featurekeyfacts, PDO::PARAM_INT);
        $insert->bindParam(':genholder', $featuregenemail, PDO::PARAM_INT);
        $insert->bindParam(':helloholder', $hello_name, PDO::PARAM_INT);
        $insert->bindParam(':recholder', $featuresreemails, PDO::PARAM_INT);
        $insert->bindParam(':smsholder', $featuresms, PDO::PARAM_INT);
        $insert->bindParam(':calholder', $featurescal, PDO::PARAM_INT);
        $insert->bindParam(':auditsholder', $featureaudits, PDO::PARAM_INT);
        $insert->bindParam(':lifeholder', $featurelife, PDO::PARAM_INT);
        $insert->bindParam(':homeholder', $featurehome, PDO::PARAM_INT);
        $insert->bindParam(':penholder', $featurepensions, PDO::PARAM_INT);
        $insert->bindParam(':analyticshold', $featureanalytics, PDO::PARAM_INT);
        $insert->bindParam(':gmaps', $featuregmaps, PDO::PARAM_INT);
        $insert->bindParam(':twitter', $featuretwitter, PDO::PARAM_INT);
        $insert->bindParam(':error', $featureerror, PDO::PARAM_INT);
        $insert->bindParam(':pba', $featurepba, PDO::PARAM_INT);
        $insert->bindParam(':post', $featurepost_code, PDO::PARAM_INT);

        
        $insert->execute()or die(print_r($insert->errorInfo(), true));
}
                   
        
    header('Location: ../../admin/Admindash.php?featuresadded=ydatabase&Settings=y'); die;
   
}


else {
   
    header('Location: ../../admin/Admindash.php?featuresadded=failed&Settings=y'); die;
   
}




