<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adlfunctions.php');
include('../includes/Access_Levels.php');

if (!in_array($hello_name, $Level_10_Access, true)) {

    header('Location: /CRMmain.php');
    die;
}

include('../includes/adl_features.php');

if (isset($fferror)) {
    if ($fferror == '1') {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'deletefile', FILTER_SANITIZE_NUMBER_INT);
if (isset($EXECUTE)) {

    if ($EXECUTE == '1') {

        include('../includes/ADL_PDO_CON.php');

        $FILE_NAME = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_SPECIAL_CHARS);
        $idvarplaceholder = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_NUMBER_INT);

        $query = $pdo->prepare("DELETE FROM tbl_uploads where id = :id");
        $query->bindParam(':id', $idvarplaceholder, PDO::PARAM_INT);
        $query->execute();
        if ($count = $query->rowCount() > 0) {

            if (file_exists("../uploads/$FILE_NAME")) {
                unlink("../uploads/$FILE_NAME");
            } if (file_exists("../uploads/life/$FILE_NAME")) {
                unlink("../uploads/life/$FILE_NAME");
            }
            
            
            
$query = $pdo->prepare("INSERT INTO client_note set client_id=:CID, client_name='ADL Alert', sent_by=:SENT, note_type='Deleted File Upload', message=:messageholder ");
$query->bindParam(':CID',$search, PDO::PARAM_INT);
$query->bindParam(':SENT',$hello_name, PDO::PARAM_STR, 100);
$query->bindParam(':messageholder',$FILE_NAME, PDO::PARAM_STR, 2500);
$query->execute();            

            if (isset($fferror)) {
                if ($fferror == '0') {

                    header('Location: ../Life/ViewClient.php?DeleteUpload=1&search=' . $search . '&count=' . $count . '&file=' . $FILE_NAME . '#menu2');
                    die;
                }
            }
        } else {
            if (isset($fferror)) {
                if ($fferror == '0') {
                    header('Location: ../Life/ViewClient.php?DeleteUpload=0&search=' . $search . '#menu2');
                    die;
                }
            }
        }
    }
}

if (isset($fferror)) {
    if ($fferror == '0') {

        header('Location: ../CRMmain.php');
        die;
    }
}
?>