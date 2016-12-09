<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

$adddetails= filter_input(INPUT_GET, 'adddetails', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($adddetails)) {
      
    
    $adddetails= filter_input(INPUT_GET, 'adddetails', FILTER_SANITIZE_SPECIAL_CHARS);

if($adddetails=='y') {
    
    
    
$client_id= filter_input(INPUT_POST, 'sendclientid', FILTER_SANITIZE_NUMBER_INT);
$marital= filter_input(INPUT_POST, 'marital', FILTER_SANITIZE_SPECIAL_CHARS);
$smoker= filter_input(INPUT_POST, 'smoker', FILTER_SANITIZE_NUMBER_INT);
$dependents= filter_input(INPUT_POST, 'dependents', FILTER_SANITIZE_SPECIAL_CHARS);
$employment= filter_input(INPUT_POST, 'employment', FILTER_SANITIZE_SPECIAL_CHARS);
$job= filter_input(INPUT_POST, 'Job', FILTER_SANITIZE_SPECIAL_CHARS);
$gross= filter_input(INPUT_POST, 'gross', FILTER_SANITIZE_SPECIAL_CHARS);
$net= filter_input(INPUT_POST, 'net', FILTER_SANITIZE_SPECIAL_CHARS);
$expenditure= filter_input(INPUT_POST, 'expenditure', FILTER_SANITIZE_SPECIAL_CHARS);
$disposable= filter_input(INPUT_POST, 'disposable', FILTER_SANITIZE_SPECIAL_CHARS);
$health= filter_input(INPUT_POST, 'health', FILTER_SANITIZE_SPECIAL_CHARS);
$will= filter_input(INPUT_POST, 'will', FILTER_SANITIZE_NUMBER_INT);
$residence= filter_input(INPUT_POST, 'residence', FILTER_SANITIZE_SPECIAL_CHARS);
$domicile= filter_input(INPUT_POST, 'domicile', FILTER_SANITIZE_SPECIAL_CHARS);
$abroad= filter_input(INPUT_POST, 'abroad', FILTER_SANITIZE_NUMBER_INT);
$notes= filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
$tax= filter_input(INPUT_POST, 'taxstat', FILTER_SANITIZE_SPECIAL_CHARS);

echo "<p>ID $client_id - Maritail $marital - Smoker $smoker - Dependents $dependents - Employment $employment - Job $job - Gross $gross - Net $net -"
        . "expenditure $expenditure - Dispo  $disposable - Health $health - Will $will, Res $residence - Dom $domicile - Abroad $abroad - Notes $notes - Tax $tax"
        . " - Hello $hello_name</p>";

$pensionname= filter_input(INPUT_POST, 'pensionname', FILTER_SANITIZE_SPECIAL_CHARS);

$details = $pdo->prepare("INSERT INTO client_pension_details 
set 
client_id=:clienthold
, marital=:maritalhold
, smoker=:smokerhold
, dependents=:dependentshold
, employment=:employmenthold
, job=:jobhold
, gross=:grosshold
, net=:nethold
, expenditure=:expenditurehold
, disposable=:disposablehold
, health=:healthhold
, will=:willhold
, residence=:residencehold
, domicile=:domicilehold
, abroad=:abroadhold
, notes=:noteshold
, added_by=:addedbyhold
, tax=:taxhold");

$details->bindParam(':clienthold',$client_id, PDO::PARAM_INT);
$details->bindParam(':maritalhold',$marital, PDO::PARAM_STR, 100);
$details->bindParam(':smokerhold',$smoker, PDO::PARAM_INT);
$details->bindParam(':dependentshold',$dependents, PDO::PARAM_STR, 255);
$details->bindParam(':employmenthold',$employment, PDO::PARAM_STR, 255);
$details->bindParam('jobhold',$job, PDO::PARAM_STR, 255);
$details->bindParam(':grosshold',$gross, PDO::PARAM_STR, 255);
$details->bindParam(':nethold',$net, PDO::PARAM_STR, 255);
$details->bindParam(':expenditurehold',$expenditure, PDO::PARAM_STR, 255);
$details->bindParam(':disposablehold',$disposable, PDO::PARAM_STR, 255);
$details->bindParam(':healthhold',$health, PDO::PARAM_STR, 255);
$details->bindParam(':willhold',$will, PDO::PARAM_INT);
$details->bindParam(':residencehold',$residence, PDO::PARAM_STR, 255);
$details->bindParam(':domicilehold',$domicile, PDO::PARAM_STR, 255);
$details->bindParam(':abroadhold',$abroad, PDO::PARAM_INT);
$details->bindParam(':noteshold',$notes, PDO::PARAM_STR, 255);
$details->bindParam(':addedbyhold',$hello_name, PDO::PARAM_STR, 255);
$details->bindParam(':taxhold',$tax, PDO::PARAM_STR, 255);
$details->execute()or die(print_r($query->errorInfo(), true)); 

    
$notedata= "CRM Alert";
$messagedata="Client Pension Details Added";

$query = $pdo->prepare("INSERT INTO client_note 
set client_id=:clientidholder, client_name=:recipientholder, sent_by=:sentbyholder, note_type=:noteholder, message=:messageholder ");

$query->bindParam(':clientidholder',$client_id, PDO::PARAM_INT);
$query->bindParam(':sentbyholder',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':recipientholder',$pensionname, PDO::PARAM_STR, 500);
$query->bindParam(':noteholder',$notedata, PDO::PARAM_STR, 255);
$query->bindParam(':messageholder',$messagedata, PDO::PARAM_STR, 2500);
$query->execute()or die(print_r($query->errorInfo(), true));

header('Location: ../ViewClient.php?policydetailsadded=y&search='.$client_id); die;

}

else {
    
    header('Location: ../ViewClient.php?policydetailsadded=failed&search='.$client_id); die;
    
}

}