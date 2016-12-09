<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

$host = 'localhost';
$user = 'root';
$pass = 'Cerberus2^n';
$db = 'dev_database';
$table = 'clientpolexport_template';
$file = 'export';

$datefrom = $_POST['datefrom'];
$dateto = $_POST['dateto'];
$where = $_POST['Select'];
 
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
 
$values = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT client_policy.application_number, client_policy.policy_number, client_policy.sale_date, '' AS empty_col , client_policy.client_name, '' AS empty_col , client_details.phone_number,  client_details.alt_number, CONCAT(client_details.dob,' - ',client_details.dob2), client_details.email, client_details.address1, client_details.address2, CONCAT(client_details.address3, ' ', client_details.town), client_details.post_code, client_policy.premium, client_policy.type, client_policy.commission,'' AS empty_col ,'' AS empty_col2 , CONCAT(client_policy.lead, '/', client_policy.closer), client_policy.policystatus, client_policy.insurer, client_policy.submitted_by, client_details.company, client_details.submitted_date
FROM  client_policy 
LEFT JOIN client_details
ON client_policy.client_id=client_details.client_id 
WHERE client_policy.sale_date between '$datefrom 00:00:00' and '$dateto 24:00:00' AND client_policy.insurer ='Assura' OR (client_policy.submitted_date between '$datefrom' and '$dateto' AND client_policy.insurer ='Assura') ");
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
