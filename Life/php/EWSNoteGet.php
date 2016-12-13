<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

    $query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    
if(isset($query)) {
    if($query=='EWSWhite' || $query=='EWSMaster' || $query=='EWS'){  
        include('../../includes/ADL_PDO_CON.php'); 
        
        $x= filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_NUMBER_INT);
        $y= filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_SPECIAL_CHARS);

        $GETquery = $pdo->prepare("select message, sent_by, client_name, date_sent from client_note where client_id =:CID AND note_type='ews status update' ORDER BY date_sent DESC");
        $GETquery->bindParam(':CID', $x, PDO::PARAM_INT);
        $GETquery->execute(); 
        if ($GETquery->rowCount()>0) {
        ?>

<table class="table table-hover">
    <thead>
        <tr>
            <th><h3><span class='label label-info'>Existing notes</span></h3></th>
        <tr>
            <th>Note</th>
            <th>Policy</th>
            <th>User</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        while ($result=$GETquery->fetch(PDO::FETCH_ASSOC)){ 

            
            ?>
        
        <tr>
            <td><?php echo $result['message']; ?></td>
            <td><?php echo $result['client_name']; ?></td>
            <td><?php echo $result['sent_by']; ?></td>
            <td><?php echo $result['date_sent']; ?></td>
        </tr>
            
        <?php } } ?>
    
    </tbody>
</table>
    
    <?php
    }
    }
    
 else {   

header('Location: ../../CRMmain.php?AccessDenied'); die;    

 }