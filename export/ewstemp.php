<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $test_access_level->log_out();
}
?>

<?php
$host = 'localhost';
$user = 'root';
$pass = 'Cerberus2^n';
$db = 'dev_adl_database';
$table = 'ews_data_template';
$file = 'export';

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass)) or die("Can not connect." . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $db)) or die("Can not connect.");
 
$result = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW COLUMNS FROM ".$table."");
if (mysqli_num_rows($result) > 0) {
 while ($row = mysqli_fetch_assoc($result)) {
  $csv_output .= $row['Field'].", ";
  $i++;
 }
}
$csv_output .= "\n";
 
$values = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT master_agent_no
, agent_no
, policy_number
, client_name
, dob
, address1
, address2
, address3
, address4
, post_code
, policy_type
, warning
, last_full_premium_paid
, net_premium
, premium_os
, clawback_due
, clawback_date
, policy_start_date
, off_risk_date
, seller_name
, frn
, reqs FROM ".$table." ");
while ($rowr = mysqli_fetch_row($values)) {
 for ($j=0;$j<$i;$j++) {
  $csv_output .= $rowr[$j].", ";
 }
 $csv_output .= "\n";
}
 
$filename = $file."_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;
?>
