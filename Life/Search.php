<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
$USER_TRACKING=0;
require_once(__DIR__ . '/../includes/user_tracking.php'); 
require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');
if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}
if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
      if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;
} 
?>
<!DOCTYPE html>
<html>
<title>Search</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
   <?php    require_once(__DIR__ . '/../includes/navbar.php');
    $SEARCH_DATABASE= filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS); 
    
    if(isset($SEARCH_DATABASE)) {
        if($SEARCH_DATABASE=='1') {
            $SEARCH_searchquery= filter_input(INPUT_POST, 'searchquery', FILTER_SANITIZE_SPECIAL_CHARS);
            $SEARCH_searchby= filter_input(INPUT_POST, 'searchby', FILTER_SANITIZE_SPECIAL_CHARS);  
            
        }
        
        }
    ?>
    
    <div class="container">

                    <?php
                        if($fflife=='1') { 
?>
        
        
        
<form class="form-vertical" method="post" action="?Search">
<fieldset>

    <legend>Search <i>(click row to view)</i></legend>

<div class="col-md-2">
<div class="form-group">
  <input required id="searchquery" name="searchquery" placeholder="Search For" value="<?php if(isset($SEARCH_searchquery)) { echo $SEARCH_searchquery; } ?>" class="form-control input-md" type="text">
</div>
</div>

<div class="col-md-2">
<div class="form-group">
    <select id="searchby" name="searchby" class="form-control" required>
        <?php if(isset($SEARCH_searchby)) { 
            
            switch ($SEARCH_searchby) {
                case 1:
                    $option ="Client Surname";
                    break;
                case 2:
                    $option ="Post Code";
                    break;
                case 3:
                    $option ="Phone Number";
                    break;
                case 4:
                    $option ="Policy Number";
                    break;
                case 5:
                    $option ="AN Number";
                    break;
                case 6:
                    $option ="Client ID";
                    break;
                default;
                    $option ="Search In";
            }
            
            ?>
      <option value="<?php echo $SEARCH_searchby;?>"><?php echo $option;?></option> 
        <?php } if(empty($SEARCH_searchby)) { ?>      
      <option value="0">Search In</option>
        <?php } ?>
      <option value="1">Client Surname</option>
      <option value="2">Post Code</option>
      <option value="3">Phone Number</option>
      <option value="4">Policy Number</option>
      <option value="5">AN Number</option>
      <option value="6">Client ID</option>
    </select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
    <button id="query" name="query" value="1" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
    <a href="Search.php" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</a>
</div>
</div>

</fieldset>
</form>
                        <?php 
                        $SEARCH_DATABASE= filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
                                                
                        if(isset($SEARCH_DATABASE)) {
                            if($SEARCH_DATABASE=='1') {
                        try {
                        
                        if($SEARCH_searchby==1) {
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name, client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_details.last_name=:id OR client_details.last_name2=:id2 GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_STR);
                        $SEARCH->bindParam(':id2', $SEARCH_searchquery, PDO::PARAM_STR);                     
                            
                        }
                        
                        if($SEARCH_searchby==2) {
                          
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name, client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_details.post_code=:id GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_STR);                            
                            
                        }
                        if($SEARCH_searchby==3) {
      
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name,  client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_details.phone_number=:id GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_STR);                      
                            
                        }
                        if($SEARCH_searchby==4) {
                            
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name,  client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_policy.policy_number=:id GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_STR);                              
                            
                        }
                        if($SEARCH_searchby==5) {
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name, client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_policy.application_number=:id GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_INT);                            
                            
                        }
                        if($SEARCH_searchby==6) {
                            
                        $SEARCH = $pdo->prepare("SELECT CONCAT(client_details.first_name, ' ', client_details.last_name) AS NAME, CONCAT(client_details.first_name2, ' ', client_details.last_name2) AS NAME2, client_policy.policy_number, client_details.company, client_details.phone_number, DATE(client_details.submitted_date) AS submitted_date, client_details.client_id, client_policy.client_name, client_details.post_code FROM client_details LEFT JOIN client_policy on client_details.client_id=client_policy.client_id WHERE client_details.client_id=:id GROUP BY client_details.client_id ORDER BY client_details.submitted_date DESC");
                        $SEARCH->bindParam(':id', $SEARCH_searchquery, PDO::PARAM_INT);
                            
                        }
                        
                        ?>        
        
            <table id="clients" class="table table-striped table-hover" width="auto" cellspacing="0">
        <thead>
            <tr>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Policy</th>
                <th>Post Code</th>
                <th>Phone #</th>
                <th>Company</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Policy</th>
                <th>Post Code</th>
                <th>Phone #</th>
                <th>Company</th>
            </tr>
        </tfoot>
        
        <?php
                            
                            $SEARCH->execute();
                            if ($SEARCH->rowCount()>0) {
                                while ($result=$SEARCH->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $NAME=$result['NAME'];
                                    $NAME2=$result['NAME2'];
                                    
                                    if($NAME2==' ') {
                                        
                                        $CLIENT_NAMES=$NAME;
                                        
                                    }
                                    
                                    if(!empty($NAME2)) {
                                        $CLIENT_NAMES="$NAME & $NAME2";
                                    }
                                    
                                    switch ($result['client_name']) {
                                        
                                        case NULL:
                                            $CLIENT_NAME=$CLIENT_NAMES;
                                            break;
                                        default:
                                            $CLIENT_NAME=$result['client_name'];
                                            
                                        
                                    }
                                    
                                    switch ($result['policy_number']) {
                                        
                                        case NULL:
                                            $POLICY_NUM="<i><font color='blue'>No Policy Added</font></i>";
                                            break;
                                        default:
                                            $POLICY_NUM=$result['policy_number'];
                                            
                                        
                                    }
                                    switch($result['client_name']) {
                                        case "Joint Policy":
                                            $CLIENT_NAME="<strong>[TONIC CLIENT]</strong> Surname match found but the Policy holder needs to be updated";
                                            break;
                                        default:
                                            $CLIENT_NAME=$CLIENT_NAMES;
                                    }
                                    
                                    
                                    echo "<tr class='clickable-row' data-href='ViewClient.php?search=".$result['client_id']."'><td>".$result['submitted_date']."</td>"; 
                                    echo "<td>$CLIENT_NAME</td>";
                                    echo "<td>".$result['policy_number']."</td>"; 
                                    echo "<td>".$result['post_code']."</td>"; 
                                    echo "<td>".$result['phone_number']."</td>"; 
                                    echo "<td>".$result['company']."</td>"; 
                                    echo "</tr>"; 
                                }
                            }
                            
                            else {
                                
                                echo "<div class='notice notice-info' role='alert' id='HIDEDUPEPOL'><strong><i class='fa fa-exclamation-triangle fa-lg'></i> Info:</strong> $SEARCH_searchquery not found in $option<a href='#' class='close' data-dismiss='alert' aria-label='close' id='CLICKTOHIDEDUPEPOL'>&times;</a></div>";  
                                
                            }
                            
                        }
                                                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                                                                ?>
        
        
        
    </table>
                    <?php } } 
                    
                   
                    
                    
                    
                    
                                                 } ?>
    
</div>
       
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {                                                                                                    
        $('#LOADING').modal('show');
    });
    $(window).load(function(){
        $('#LOADING').modal('hide');
    });
</script>
<script>
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
<div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                    <br>
                    <h3>Populating client details... </h3>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>