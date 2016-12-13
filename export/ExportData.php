<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
$ExportLegacy= filter_input(INPUT_GET, 'ExportLegacy', FILTER_SANITIZE_NUMBER_INT);

if(isset($ExportLegacy)) { if($ExportLegacy=='1') {

include('includes/adlfunctions.php');

$host = 'localhost';
$user = 'root';
$pass = 'Cerberus2^n';
$db = 'dev_adl_database';
$file = 'export';
    
    $dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);
    $datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);

            $datefromnew ="$datefrom 00:00:00";
            $datenewto ="$dateto 23:00:00";
 
$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass)) or die("Can not connect." . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $db)) or die("Can not connect.");
 
$result = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW COLUMNS FROM assura_ews_data");
if (mysqli_num_rows($result) > 0) {
 while ($row = mysqli_fetch_assoc($result)) {
  $csv_output .= $row['Field'].", ";
  $i++;
 }
}
$csv_output .= "\n";
 
$values = mysqli_query($GLOBALS["___mysqli_ston"], "select * from assura_ews_data WHERE updated_date between '$datefromnew' and '$datenewto' AND ews_status !='NEW' ORDER BY ews_status");
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

}

if($ExportLegacy=='2') {

include('../includes/ADL_PDO_CON.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

$query = $pdo->prepare("select * from (select * from legacy_client_note
JOIN assura_ews_data  ON legacy_client_note.client_name=assura_ews_data.policy_number 
WHERE legacy_client_note.note_type='EWS Status update'
order by legacy_client_note.date_sent desc) tbl1");

    $query->execute();

	$filelocation = '/tmp/';
	$filename     = 'export-'.date('Y-m-d H.i.s').'.csv';
	$file_export  =  $filelocation . $filename;

    $data = fopen($file_export, 'w');

    $csv_fields = array();

	$csv_fields[] = 'note_id';
	$csv_fields[] = 'client_id';
	$csv_fields[] = 'client_name';
	$csv_fields[] = 'note_type';
	$csv_fields[] = 'message';
	$csv_fields[] = 'sent_by';
	$csv_fields[] = 'date_sent';
	$csv_fields[] = 'ews_id';
	$csv_fields[] = 'ref_id';
	$csv_fields[] = 'provider_created';
	$csv_fields[] = 'policy_number';
	$csv_fields[] = 'created_date';
	$csv_fields[] = 'commisson_status';
	$csv_fields[] = 'product';
	$csv_fields[] = 'gender';
	$csv_fields[] = 'town';
	$csv_fields[] = 'title';
	$csv_fields[] = 'first';
        $csv_fields[] = 'last ';
	$csv_fields[] = 'address';
	$csv_fields[] = 'address2';
	$csv_fields[] = 'address3';
	$csv_fields[] = 'address4';
	$csv_fields[] = 'address5';
	$csv_fields[] = 'postcode';
	$csv_fields[] = 'client_telephone';
	$csv_fields[] = 'client_email';
	$csv_fields[] = 'life_sum_assured';
	$csv_fields[] = 'life_term';
	$csv_fields[] = 'premium';
	$csv_fields[] = 'term_assurance_type';
	$csv_fields[] = 'cic_sum_assured';
	$csv_fields[] = 'cic_term';
	$csv_fields[] = 'phi_sum_assured';
	$csv_fields[] = 'phi_age_until';
	$csv_fields[] = 'phi_term';
        $csv_fields[] = 'fib_sum_assured';
	$csv_fields[] = 'fib_age_until';
	$csv_fields[] = 'fib_term';
	$csv_fields[] = 'premium2';
	$csv_fields[] = 'status';
	$csv_fields[] = 'description';
	$csv_fields[] = 'product_cat';
	$csv_fields[] = 'provider2';
	$csv_fields[] = 'commission_type';
	$csv_fields[] = 'color_status';
	$csv_fields[] = 'ews_status';
	$csv_fields[] = 'updated_date';
  

	fputcsv($data, $csv_fields);

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($data, $row);
    }

    
    
}

}

$financialExport= filter_input(INPUT_GET, 'financialExport', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($financialExport)) {

    $page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
            ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    include('../includes/ADL_PDO_CON.php');

$datefrom= filter_input(INPUT_GET, 'datefrom', FILTER_SANITIZE_SPECIAL_CHARS);
$dateto= filter_input(INPUT_GET, 'dateto', FILTER_SANITIZE_SPECIAL_CHARS);

$datefromnew ="$datefrom";
$datetonew= "$dateto"; 

if($financialExport=='paid') {

$query = $pdo->prepare("select client_policy.policy_number, client_policy.client_name from financial_statistics_history JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.Payment_Type ='I' AND insert_date between :datefromholder AND :datetoholder group by financial_statistics_history.policy;");
    $query->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);
    $query->execute();
    	$filelocation = 'tmp/';
	$filename     = 'export-'.date('Y-m-d H.i.s').'.csv';
	$file_export  =  $filelocation . $filename;

$data = fopen($file_export, 'w');
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    // Export every row to a file
    fputcsv($data, $row);
}
fclose($data);                 // <- close file

    header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");
readfile($file_export);        // <- new line
    
}

if($financialExport=='unpaid') {
    

$query = $pdo->prepare("select client_policy.policy_number, client_policy.client_name from financial_statistics_history JOIN client_policy on financial_statistics_history.policy=client_policy.policy_number where financial_statistics_history.Payment_Type ='X' AND insert_date between :datefromholder AND :datetoholder group by financial_statistics_history.policy;");
    $query->bindParam(':datefromholder', $datefromnew, PDO::PARAM_STR, 100);
    $query->bindParam(':datetoholder', $datetonew, PDO::PARAM_STR, 100);
    $query->execute();
    	$filelocation = 'tmp/';
	$filename     = 'export-'.date('Y-m-d H.i.s').'.csv';
	$file_export  =  $filelocation . $filename;

$data = fopen($file_export, 'w');
while ($row = $query->fetch(PDO::FETCH_ASSOC))
{
    // Export every row to a file
    fputcsv($data, $row);
}
fclose($data);                 // <- close file

    header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");
readfile($file_export);        // <- new line
    

    
}

}

?>
