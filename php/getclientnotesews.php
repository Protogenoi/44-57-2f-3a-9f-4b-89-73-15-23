<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

$Legacy= filter_input(INPUT_GET, 'Legacy', FILTER_SANITIZE_NUMBER_INT);
$query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($query)) {
    if($query=='EWSWhite') {  
        include('../includes/ADL_PDO_CON.php'); 
        
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

include('../includes/PDOcon.php');
if(isset($Legacy)) {
    
    if($Legacy=='1') {   
        
         $x= filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_NUMBER_INT);
         $y= filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_SPECIAL_CHARS);

        $sql = "select message, sent_by, date_sent from legacy_client_note where client_id ='$x' and client_name='$y' and note_type='ews status update' ORDER BY date_sent DESC";
        $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
        
        $rows = array();
        while($r =mysqli_fetch_assoc($result)) {
            
            $rows['aaData'][] = $r;
            
        }
        
        echo "<table class=\"table table-hover\">";
        
        echo"
	<thead>
	<tr>
	<th><h3><span class='label label-info'>Client notes</span></h3></th>
	</th>
	<tr>
	<th>message</th>
	<th>sent_by</th>
	<th>date_sent</th>
	</tr>
	</thead>
	<tbody>";
        
        foreach($rows['aaData'] as $tablerows) {
            echo<<<EOF
	<tr>
	<td>{$tablerows['message']}</td>
	<td>{$tablerows['sent_by']}</td>
	<td>{$tablerows['date_sent']}</td>
	</tr>
EOF;
        }

echo "</tbody></table>";
        
    }
    
    
}

else {

         $x= filter_input(INPUT_POST, 'cid', FILTER_SANITIZE_NUMBER_INT);
         $y= filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_SPECIAL_CHARS);


    $sql = "select message, sent_by, date_sent from client_note where client_id ='$x' and client_name='$y' and note_type='ews status update' ORDER BY date_sent DESC";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));


    $rows = array();
    while($r =mysqli_fetch_assoc($result))
    {
        $rows['aaData'][] = $r;
    }

echo "<table class=\"table table-hover\">";

echo<<<EOF
	<thead>
	<tr>
	<th><h3><span class="label label-info">Client notes</span></h3></th>
	</th>
	<tr>
	<th>message</th>
	<th>sent_by</th>
	<th>date_sent</th>
	</tr>
	</thead>
	<tbody>
EOF;

foreach($rows['aaData'] as $tablerows)
{
echo<<<EOF
	<tr>
	<td>{$tablerows['message']}</td>
	<td>{$tablerows['sent_by']}</td>
	<td>{$tablerows['date_sent']}</td>
	</tr>
EOF;
}

echo "</tbody></table>";

}
?>



