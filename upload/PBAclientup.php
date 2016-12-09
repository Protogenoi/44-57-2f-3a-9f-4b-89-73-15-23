<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $test_access_level->log_out();
}
?>

<?php 

$connect = ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", "Cerberus2^n"));
((bool)mysqli_query($connect, "USE " . adl_database));

       ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        


if ($_FILES[csv][size] > 0) {

    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");

    do {
        if ($data[0]) {
            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pba_client_details (client_id,title,firstname,lastname,dob,email,title2,firstname2,lastname2,dob2,email2, tel,tel2,tel3,add2,add3,town) VALUES
                (
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."',
                    '".addslashes($data[3])."',
                    '".addslashes($data[4])."',
                    '".addslashes($data[5])."',
                    '".addslashes($data[6])."',
                    '".addslashes($data[7])."',
                    '".addslashes($data[8])."',
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."',
                    '".addslashes($data[11])."',
                    '".addslashes($data[12])."',
                    '".addslashes($data[13])."',
                    '".addslashes($data[14])."',
                    '".addslashes($data[15])."',
                    '".addslashes($data[16])."'

                        
                )         ");
        }
    } while ($data = fgetcsv($handle,1000,",","'"));

header('Location: ../Upload.php?success=1'); die;

}


?>