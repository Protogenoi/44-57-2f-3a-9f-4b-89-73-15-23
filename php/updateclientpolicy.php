<?php    

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

include('../includes/PDOcon.php');

  $mysqli->query("
UPDATE client_policy
INNER JOIN financial_statisics 
ON client_policy.policy_number = financial_statisics.policy_number
SET client_policy.PolicyStatus = financial_statisics.trans_type 
        ")or die(mysqli_error($db));
  $mysqli->commit();
    if ($mysqli->error) {
       printf("Errormessage: %s\n", $mysqli->error);
    }
  mysqli_free_result();
?>

