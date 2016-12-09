<?php
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 8);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adlfunctions.php');
include('../../includes/Access_Levels.php');
include('includes/ADL_PDO_CON.php');
include('includes/ADL_MYSQLI_CON.php');

if($fflife=='0') {
    header('Location: ../../CRMmain.php'); die;
    
}

if (!in_array($hello_name,$Level_8_Access, true)) {
    header('Location: ../../CRMmain.php'); die;
}

if(isset($_GET["datefrom2"])) $datefrom2 = $_GET["datefrom2"];
if(isset($_GET["dateto2"])) $dateto2 = $_GET["dateto2"];

$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
    <title>ADL | EWS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">    
    <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css"> 
    <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">    
    <link rel="stylesheet" type="text/css" href="//datatables.net/release-datatables/extensions/ColVis/css/dataTables.colVis.css">
    <link rel="stylesheet" type="text/css" href="/datatables/css/jquery-ui.css">  
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />   
        <style>
        div.smallcontainer {
            margin: 0 auto;
            font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
        }
        .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    </style>
</head>
<body>
    
<?php include('../../includes/navbar.php'); 
        include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
?>
    <div class="container">
        
        <?php
        
        $RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_NUMBER_INT);
        
        if(isset($RETURN)) {
            if($RETURN=='EWSUploaded') {
                
            echo "<div class='notice notice-success' role='alert'><strong><i class='fa fa-upload fa-lg'></i> Success:</strong> EWS uploaded!</div>";

                
            }
        }
        
        ?>
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#menu7">Master</a></li>
            <li><a data-toggle="pill" href="#menu1">Cases Worked</a></li>
            <li><a data-toggle="pill" href="#menu2">Cases to Work</a></li>
            <li><a data-toggle="pill" href="#menu5">Upload Data</a></li>
        </ul>
    </div>
    
    <div class="tab-content">
        <div id="menu7" class="tab-pane fade in active ">  
           <?php 
                    
                $menu7filter= filter_input(INPUT_GET, 'menu7filter', FILTER_SANITIZE_NUMBER_INT);
                $menu1filter= filter_input(INPUT_GET, 'menu1filter', FILTER_SANITIZE_NUMBER_INT);
                
                if(isset($menu7filter)) {                    
                    if($menu7filter=='1') {
                        
                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Info:</strong> Filter settings set!</div>");

                    }
                        
                }
                    
                ?>
            <div class="smallcontainer"> 
                
                <?php 

                    
                if(isset($menu7filter)) {                    
                    if($menu7filter=='1') {
                        
                        $menu7date= filter_input(INPUT_POST, 'menu7date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $clawcolour= filter_input(INPUT_POST, 'clawcolour', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        
                        $newmenu7date ="$menu7date-%";
                        
                            $query = $pdo->prepare("select sum(clawback_due) AS due, color_status from ews_data WHERE clawback_date like :date group by color_status");
                            $query->bindParam(':date', $newmenu7date, PDO::PARAM_STR, 12);
                            
                                     echo "<table id='filtertable' class='table table-hover'>
                                     <thead>
                                     <tr>
                                     <th>Colour</th>
                                     <th>Clawback Risk Total</th>                                      
                                     </tr>
                                     </thead>";
                            
                            $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                    switch( $result['color_status'] ) {
                                                                         
                                                case("Black"):
                                                    $colorclass = 'black';
                                                    break;
                                                case("red"):
                                                    $colorclass = 'red';
                                                    break;
                                                case("purple"):
                                                    $colorclass = 'purple';
                                                    break;
                                                case("amber"):
                                                    $colorclass = 'amber';
                                                    break;
                                                case("orange"):
                                                    $colorclass = 'orange';
                                                    break;
                                                case("green"):
                                                    $colorclass = 'green';
                                                    break;
                                                        
                                     }
                                     
                                     echo '<tr>';
                                     echo "<td style='color: #fff; background: $colorclass;'>".$result['color_status']."</td>";
                                     echo "<td>".$result['due']."</td>";
                                     echo "</tr>";
                                
                            }
                                
                            }
                            
                            else {
                                
                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle\"></i> Info:</strong> No data found!</div>";
                                
                            }
                            echo "</table>";   
                            
                            $query2 = $pdo->prepare("SELECT ews_data.policy_number, ews_data.id, ews_data.address1, ews_data.address2, ews_data.address3, ews_data.address4, ews_data.post_code, ews_data.policy_type, ews_data.warning, ews_data.last_full_premium_paid, ews_data.net_premium, ews_data.premium_os, ews_data.clawback_due, DATE_FORMAT(ews_data.clawback_date, '%y-%M') AS clawback_date, ews_data.policy_start_date, ews_data.off_risk_date, ews_data.reqs, ews_data.date_added, ews_data.Processor, ews_data.ews_status_status, ews_data.client_name, client_details.client_id, ews_data.color_status, ews_data.ournotes
	FROM ews_data LEFT JOIN client_policy ON ews_data.policy_number=client_policy.policy_number LEFT JOIN client_details ON client_policy.client_id=client_details.client_id
	LEFT JOIN financial_statisics ON financial_statisics.policy_number=ews_data.policy_number WHERE clawback_date = :date ORDER BY ews_data.color_status");
                            $query2->bindParam(':date', $newmenu7date, PDO::PARAM_STR, 12);
                            
                                     echo "<table id='filtertable'>
                                     <thead>
                                     <tr>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>                                      
                                     </tr>
                                     </thead>";
                            
                            $query2->execute();
                            if ($query2->rowCount()>0) {
                                while ($result2=$query2->fetch(PDO::FETCH_ASSOC)){
                                     
                                     switch( $result2['color_status'] ) {
                                                                          
                                                case("Black"):
                                                    $colorclass = 'black';
                                                    break;
                                                case("red"):
                                                    $colorclass = 'red';
                                                    break;
                                                case("purple"):
                                                    $colorclass = 'purple';
                                                    break;
                                                case("amber"):
                                                    $colorclass = 'amber';
                                                    break;
                                                case("orange"):
                                                    $colorclass = 'orange';
                                                    break;
                                                case("green"):
                                                    $colorclass = 'green';
                                                    break;
                                                
                                     }
                
                                     echo "<tr style='color:$colorclass;'>
                                     <td>".$result2['date_added']."</td>
                                     <td>".$result2['policy_number']."</td>
                                     <td>".$result2['client_name']."</td>
                                     <td>".$result2['client_id']."</td>
                                     <td>".$result2['address1']."</td>
                                     <td>".$result2['address2']."</td>
                                     <td>".$result2['address3']."</td>
                                     <td>".$result2['address4']."</td>
                                     <td>".$result2['post_code']."</td>
                                     <td>".$result2['policy_type']."</td>
                                     <td>".$result2['warning']."</td> 
                                     <td>".$result2['last_full_premium_paid']."</td>
                                     <td>".$result2['net_premium']."</td>
                                     <td>".$result2['premium_os']."</td>
                                     <td>".$result2['clawback_due']."</td>
                                     <td>".$result2['clawback_date']."</td>
                                     <td>".$result2['policy_start_date']."</td>
                                     <td>".$result2['off_risk_date']."</td>
                                     <td>".$result2['reqs']."</td>
                                     <td>".$result2['ews_status_status']."</td>
                                     <td>".$result2['our_notes']."</td>
                                     <td>".$result2['color_status']."</td> 
                                     </tr>";
                                
                            }
                                
                            }
                                               else {
                                
                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle\"></i> Info:</strong> No data found!</div>";
                                
                            }
                            echo "</table>";
        
                    }
                        
                }
                 if(!isset($menu7filter)) { ?>
                
                <table id="master" class="display compact" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                        
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <br>
                <br>
                  <?php } ?> 
            </div>
        </div>
            
        <div id="menu1" class="tab-pane fade <?php if(isset($hello_name)) {  if(!in_array($hello_name,array("Michael","carys","Matt"))){echo "in active";} } ?>">   
            <?php if(isset($menu1filter)) {
                    
                    if($menu1filter=='1') {
                        
                        print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-check\"></i> Info:</strong> Filter settings set for Cases Worked!</div>");
                        
                    }
                        
                } ?>
            <div class="smallcontainer">
                <form class="form-vertical" method="POST" action="EWS.php?menu1filter=1">
                    <fieldset>
                        <legend>Filter (Cases Worked)</legend>
                        <div class="col-xs-2">
                                <input id="menu1date" name="menu1date" class="form-control" placeholder="Clawback date" type="text">
                            </div>                        
                            
                        <div class="col-xs-2">
                            <select id="clawcolour" name="clawcolour" class="form-control">
                                    <option value="">Sort by colour</option>
                                    <option value="Red">Red</option>
                                    <option value="Green">Green</option>
                                </select>                        
                        </div>
                            
                        <div class="col-xs-2">
                                <button id="submit" name="submit" class="btn btn-success btn-sm">Search</button>
                                <a href="EWS.php" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Reset</a>
                        </div>
                            
                    </fieldset>
                </form>
                    
                <?php 

                    
                if(isset($menu1filter)) {
                    
                    if($menu1filter=='1') {
                        
                        $menu1date= filter_input(INPUT_POST, 'menu1date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);                         
                                               
                            $query = $pdo->prepare("select sum(clawback_due) AS due, color_status from ews_data WHERE clawback_date = :date group by color_status");
                            $query->bindParam(':date', $menu1date, PDO::PARAM_STR, 12);
                            
                                     echo "<table id='filtertable' class='table table-hover'>
                                     <thead>
                                     <tr>
                                     <th>Colour</th>
                                     <th>Clawback Risk Total</th>                                      
                                     </tr>
                                     </thead>";
                            
                            $query->execute();
                            if ($query->rowCount()>0) {
                                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                                     
                                     switch( $result['color_status'] ) {
                                                                            
                                                case("Black"):
                                                    $colorclass = 'black';
                                                    break;
                                                case("red"):
                                                    $colorclass = 'red';
                                                    break;
                                                case("purple"):
                                                    $colorclass = 'purple';
                                                    break;
                                                case("amber"):
                                                    $colorclass = 'amber';
                                                    break;
                                                case("green"):
                                                    $colorclass = 'green';
                                                    break;
                                                        
                                     }
                                
                                     echo "<tr>
                                     <td style='color: #fff; background: $colorclass;'>".$result['color_status']."</td>
                                     <td>".$result['due']."</td>
                                     </tr>";
                                
                            }
                                
                            }
                            
                            else {
                                
                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle\"></i> Info:</strong> No data found!</div>";
                                
                            }
                            
                            echo "</table>";   
                            
                            $query2 = $pdo->prepare("SELECT 
ews_data.policy_number
, ews_data.id
, ews_data.address1
, ews_data.address2
, ews_data.address3
, ews_data.address4
, ews_data.post_code
, ews_data.policy_type
, ews_data.warning
, ews_data.last_full_premium_paid
, ews_data.net_premium
, ews_data.premium_os
, ews_data.clawback_due
, ews_data.clawback_date
, ews_data.policy_start_date
, ews_data.off_risk_date
, ews_data.reqs
, ews_data.date_added
, ews_data.Processor
, ews_data.ews_status_status
, ews_data.client_name
, client_details.client_id
, ews_data.color_status
, ews_data.ournotes
	FROM ews_data 
	LEFT JOIN client_policy 
	ON ews_data.policy_number=client_policy.policy_number 
	LEFT JOIN client_details 
	ON client_policy.client_id=client_details.client_id
	LEFT JOIN financial_statisics
	ON financial_statisics.policy_number=ews_data.policy_number
	WHERE clawback_date = :date
        ORDER BY ews_data.color_status");
                            $query2->bindParam(':date', $menu1date, PDO::PARAM_STR, 12);
                            
                                     echo "<table id='filtertable'>
                                     <thead>
                                     <tr>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>Address 1</th>
                            <th>Address 2</th>
                            <th>Address 3</th>
                            <th>Address 4</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>                                      
                                     </tr>
                                     </thead>";
                            
                            $query2->execute();
                            if ($query2->rowCount()>0) {
                                while ($result2=$query2->fetch(PDO::FETCH_ASSOC)){
                                     
                                     switch( $result2['color_status'] ) {
                                                                            
                                                case("Black"):
                                                    $colorclass = 'black';
                                                    break;
                                                case("red"):
                                                    $colorclass = 'red';
                                                    break;
                                                case("purple"):
                                                    $colorclass = 'purple';
                                                    break;
                                                case("orange"):
                                                    $colorclass = 'orange';
                                                    break;
                                                case("green"):
                                                    $colorclass = 'green';
                                                    break;
                                                default:
                                                    $colorclass='black';
                                                        
                                     }
                                
                                     echo "<tr style='color:$colorclass;'>
                                     <td>".$result2['date_added']."</td>
                                     <td>".$result2['policy_number']."</td>
                                     <td>".$result2['client_name']."</td>
                                     <td>".$result2['client_id']."</td>
                                     <td>".$result2['address1']."</td>
                                     <td>".$result2['address2']."</td>
                                     <td>".$result2['address3']."</td>
                                     <td>".$result2['address4']."</td>
                                     <td>".$result2['post_code']."</td>
                                     <td>".$result2['policy_type']."</td>
                                     <td>".$result2['warning']."</td> 
                                     <td>".$result2['last_full_premium_paid']."</td>
                                     <td>".$result2['net_premium']."</td>
                                     <td>".$result2['premium_os']."</td>
                                     <td>".$result2['clawback_due']."</td>
                                     <td>".$result2['clawback_date']."</td>
                                     <td>".$result2['policy_start_date']."</td>
                                     <td>".$result2['off_risk_date']."</td>
                                     <td>".$result2['reqs']."</td>
                                     <td>".$result2['ews_status_status']."</td>
                                     <td>".$result2['our_notes']."</td>
                                     <td>".$result2['color_status']."</td> 
                                     </tr>";
                                
                            }
                                
                            }
                                               else {
                                
                                echo "<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle\"></i> Info:</strong> No data found!</div>";
                                
                            }
                            echo "</table>";
        
        
        
                    }
                        
                }
                  if(!isset($menu1filter)) { ?>
                <table id="cases-worked" class="display compact" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                        
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </tfoot>
                </table>
                  <?php } ?>
            </div>
        </div>
            

            
        <div id="menu2" class="tab-pane fade">   
            
            <div class="smallcontainer">
                <?php 
                if($companynamere=='The Review Bureau') {
                if (in_array($hello_name,$Level_8_Access, true)) { ?>
                  <div class="row">
  <form class="form-vertical">
<fieldset>

<legend>Select EWS to work</legend>

  <div class="col-xs-2">
    <select id="agent" name="who" class="form-control" required>
        <?php if(isset($who)) { ?>
        <option value="<?php echo $who;?>"><?php echo $who;?></option>
        <?php } ?>
        <option value="Carys">Carys</option>
        <option value="Abbie">Abbie</option>
          </select>
  </div>

<div class="col-xs-2">
    <input type="text" name="clwdate" class="form-control" placeholder="Search by Off Risk Date" value="<?php if(empty($clwdate)) { echo date("M-y"); } else { echo $clwdate; }?>">
</div>
    
<div class="col-xs-2">
    <div class="btn-group" role="group" aria-label="Basic example">
    <button name="submit" class="btn btn-success">Submit</button>
    <a href="EWS.php" class="btn btn-danger "><span class="glyphicon glyphicon-repeat"></span> Reset</a>
    </div>
  </div>


</fieldset>
</form>
                  </div>
                <?php } } ?>
                
                <div class="row">
                <table id="white" class="display compact" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                        
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Policy</th>
                            <th>Client</th>
                            <th>ID</th>
                            <th>DOB</th>
                            <th>Post Code</th>
                            <th>Policy Type</th>
                            <th>Warning</th>
                            <th>Last Full Premium Paid</th>
                            <th>Net Premium</th>
                            <th>Premium OS</th>
                            <th>Clawback Risk</th>
                            <th>Clawback Date</th>
                            <th>Policy Start Date</th>
                            <th>Off Risk Date</th>
                            <th>Reqs</th>
                            <th>Orig Status</th>
                            <th>Our Notes</th>
                            <th>Color</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
                <br>
                <br>
                <br>
                    
            </div>       
                
        </div>
            
        <!-- TAB 2 END -->
            
        <!-- TAB 5 START -->
            
        <div id="menu5" class="tab-pane fade">  
            
            
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-hdd"></span> Upload data</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <h3>Upload EWS data</h3>
                                        
                                    <form action="../../upload/ewsupload.php?REDIRECT=EWS" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#processing-modal"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>
                                    <form action="../../export/ewstemp.php?REDIRECT=EWS" method="post"><br>
                                        <button type="submit" class="btn btn-info "><span class="glyphicon glyphicon-save"></span> Template</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                            
                        <br /><br />
 
    
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
    
    
     <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-1.11.1.min.js"></script>    
    <script type="text/javascript" language="javascript" src="/datatables/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="/datatables/js/jquery.dataTables.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<?php if(isset($hello_name)) { if(in_array($hello_name,array("Michael","AaronT","Matt","carys"))){ ?>
     <script type="text/javascript" language="javascript" >
                function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWS" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                    '<tr>'+
'<td><label>EWS ID</label><input type="text" name="ewsididididi" value="'+d.id+'" readonly></td>'+
'</tr>'+
'<tr>'+
                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.warning+'">'+d.warning+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+

                    '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+
              '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#master').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 100,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000, 2500]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "/datatables/EWSData.php?EWS=4",

                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "deferRender": true,
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "address1"},
                    { "data": "address2"},
                    { "data": "address3"},
                    { "data": "address4"},
                    { "data": "dob" },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }


                ],
                "order": [[1, 'DESC']]
            } );

            $('#master tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format(row.data()) ).show();

                    var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWS',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });
  tr.addClass('shown');
                    
                                         $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
                             case "RE-INSTATED":
                                 $(this).next().val('green');
                                 break;
            
                             case "WILL CANCEL":
                                 $(this).next().val('orange');
                                 break;
            
                             case "REDRAWN":
                             case "WILL REDRAW":
                                 $(this).next().val('purple');
                                 break;
            
                             case "CANCELLED":
                                 $(this).next().val('red');
                                 break;
            
            
                         }
                     });
                }
            } );
        } );
    </script>
    <?php } }
    
    $who= filter_input(INPUT_GET, 'who', FILTER_SANITIZE_SPECIAL_CHARS);
    $clwdate= filter_input(INPUT_GET, 'clwdate', FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($who)) {
        if($who=='Abbie'){
        ?>
    <script type="text/javascript" language="javascript" >
                function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWS" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                     '<tr>'+
'<td><label>EWS ID</label><input type="text" name="ewsididididi" value="'+d.id+'" readonly></td>'+
'</tr>'+
'<tr>'+
                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.ews_status_status+'">'+d.ews_status_status+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+

                    '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+
 
            '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#white').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 25,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "/datatables/EWSData.php?EWS=5&clwdate=<?php echo $clwdate;?>",

                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "deferRender": true,                        
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "dob" },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }

                ],
                "order": [[1, 'DESC']]
            } );

            $('#white tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    
                    row.child( format(row.data()) ).show();
                    var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWS',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });

                    
                    tr.addClass('shown');
            
                    $('.hook_to_change_colour').change(function(){
                
                        switch ($(this).val()) {
                    
                            case "RE-INSTATED":
                                $(this).next().val('green');
                                break;
            
                            case "WILL CANCEL":
                                $(this).next().val('orange');
                                break;
                
                            case "REDRAWN":
                            case "WILL REDRAW":
                                $(this).next().val('purple');
                                break;
            
                            case "CANCELLED":
                                $(this).next().val('red');
                                break;
                      
                
                        }
                    });
            
                }
            } );
        } );
        
        
    </script>
    
    <?php
    }
    if($who=='Carys'){
        
        ?>
    
    <script type="text/javascript" language="javascript" >
                function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWS" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                    '<tr>'+
'<td><label>EWS ID</label><input type="text" name="ewsididididi" value="'+d.id+'" readonly></td>'+
'</tr>'+
'<tr>'+
                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.ews_status_status+'">'+d.ews_status_status+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+

                    '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+
 
            '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#white').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 25,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "/datatables/EWSData.php?EWS=6&clwdate=<?php echo $clwdate;?>",
 
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "deferRender": true,                        
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "dob" },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }

                ],
                "order": [[1, 'DESC']]
            } );

            $('#white tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    
                    row.child( format(row.data()) ).show();
                    var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWS',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });

                    
                    tr.addClass('shown');
            
                    $('.hook_to_change_colour').change(function(){
                
                        switch ($(this).val()) {
                    
                            case "RE-INSTATED":
                                $(this).next().val('green');
                                break;
            
                            case "WILL CANCEL":
                                $(this).next().val('orange');
                                break;
                
                            case "REDRAWN":
                            case "WILL REDRAW":
                                $(this).next().val('purple');
                                break;
            
                            case "CANCELLED":
                                $(this).next().val('red');
                                break;
                      
                
                        }
                    });
            
                }
            } );
        } );
        
        
    </script>
    
    <?php
       
        
    }
    
    }
    
    if(empty($who)){
    ?>
    
    <script type="text/javascript" language="javascript" >
                function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWS" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                    '<tr>'+
'<td><label>EWS ID</label><input type="text" name="ewsididididi" value="'+d.id+'" readonly></td>'+
'</tr>'+
'<tr>'+
                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.ews_status_status+'">'+d.ews_status_status+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+

                    '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+

            '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#white').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 25,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "/datatables/EWSData.php?EWS=2",
                 
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "deferRender": true,                        
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "dob" },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }

                ],
                "order": [[1, 'DESC']]
            } );

            $('#white tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    
                    row.child( format(row.data()) ).show();
 var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWS',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });
   tr.addClass('shown');
            
                    $('.hook_to_change_colour').change(function(){
                
                        switch ($(this).val()) {
                    
                            case "RE-INSTATED":
                                $(this).next().val('green');
                                break;
            
                            case "WILL CANCEL":
                                $(this).next().val('orange');
                                break;
                
                            case "REDRAWN":
                            case "WILL REDRAW":
                                $(this).next().val('purple');
                                break;
            
                            case "CANCELLED":
                                $(this).next().val('red');
                                break;
                      
                
                        }
                    });
            
                }
            } );
        } );      
</script>
 <?php } ?>
    <script type="text/javascript" language="javascript" >
        function format ( d ) {

            return '<form action="../php/EWSNoteSubmit.php?EWS=1&REDIRECT=EWS" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

                    '<tr>'+
'<td><label>EWS ID</label><input type="text" name="ewsididididi" value="'+d.id+'" readonly></td>'+
'</tr>'+
'<tr>'+
                    '<td>Our EWS Status:'+
                    '<select class="hook_to_change_colour" name="status" onchange="" required>'+
                    '<option value="'+d.ews_status_status+'">'+d.ews_status_status+'</option>'+
                    '<option value="RE-INSTATED">RE-INSTATED</option>'+
                    '<option value="WILL CANCEL">WILL CANCEL</option>'+
                    '<option value="REDRAWN">REDRAWN</option>'+
                    '<option value="WILL REDRAW">WILL REDRAW</option>'+
                    '<option value="CANCELLED">CANCELLED</option>'+
                    '</select>'+
                    '<select class="colour_hook" name="colour" required>' +

                    '<option value="green" style="background-color:green;color:white;">Green</option>' +
                    '<option value="orange" style="background-color:orange;color:white;">Orange</option>' +
                    '<option value="purple" style="background-color:purple;color:white;">Purple</option>' +
                    '<option value="red" style="background-color:red;color:white;">Red</option>' +
                    '<option value="black" style="background-color:black;color:white;">Black</option>' +
                    '<option value="blue" style="background-color:blue;color:white;">Blue</option>' +
                    '<option value="grey" style="background-color:blue;color:white;">Grey</option>' +
                    '</select></td>'+

                    '<td><label>Closer</label><input type="text" name="policy_number" value="'+d.closer+'" disabled></td>'+
                    '<td><label>Lead Gen</label><input type="text" name="policy_number" value="'+d.lead+'" disabled></td>'+

                    '</tr>'+
 '<tr>'+

                    '<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
                    '<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+

            '<td><input type="hidden" name="warning" value="'+d.warning+'"></td>'+
                    '<td><input type="hidden" name="client_name" value="'+d.client_name+'"></td>'+
                    '<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
                    '</tr>'+

                    '<tr>'+
                    '<td><div name="BLANK_ZOVOS"> </div></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

                    '</tr>'+

                    '</form>';
            '</table>';
        }
 
        $(document).ready(function() {
            var table = $('#cases-worked').DataTable( {
                dom: 'C<"clear">lfrtip',
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] != '' )  {
                        $('td', nRow).css("color", aData["color_status"]);
                    }
                    
                     if ( aData["ews_status_status"] == "NEW" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },
                "response":true,
                "processing": true,
                "iDisplayLength": 25,
                "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 2500, 3000, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

                },
                "ajax": "/datatables/EWSData.php?EWS=3",

                "deferRender": true,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "date_added"},
                    { "data": "policy_number"},
                    { "data": "client_name"},
                    { "data": "client_id",
                        "render": function(data, type, full, meta) {
                            return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">"' + data + '"</a>';
                        } },
                    { "data": "dob" },
                    { "data": "post_code" },
                    { "data": "policy_type" },
                    { "data": "warning" },
                    { "data": "last_full_premium_paid" },
                    { "data": "net_premium" },
                    { "data": "premium_os" },
                    { "data": "clawback_due" },
                    { "data": "clawback_date" },
                    { "data": "policy_start_date" },
                    { "data": "off_risk_date" },
                    { "data": "reqs" },
                    { "data": "ews_status_status" },
                    { "data": "ournotes" },
                    { "data": "color_status" }

                ],
                "order": [[1, 'DESC']]
            } );

            $('#cases-worked tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
 
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
            
            
            
                }
                else 
                {
                    row.child( format(row.data()) ).show();
                    console.log($(this).closest('tr').next('tr').find("input[name='client_id']").val());
 var me = $(this);

                    $.ajax({ url: '../php/EWSNoteGet.php?query=EWS',
                        data: {
                            cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
                            pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
                        },
                        type: 'post',
                        success: function(data) {
                            me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                        }
                    });
  tr.addClass('shown');
    
                     $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
                             case "RE-INSTATED":
                                 $(this).next().val('green');
                                 break;
            
                             case "WILL CANCEL":
                                 $(this).next().val('orange');
                                 break;
            
                             case "REDRAWN":
                             case "WILL REDRAW":
                                 $(this).next().val('purple');
                                 break;
            
                             case "CANCELLED":
                                 $(this).next().val('red');
                                 break;
            
            
                         }
                     });
            
                 }
             } );
         } );
    </script>
    <script>
        $(function() {
            $( "#datefrom2" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });
    </script>
    <script>
        $(function() {
            $( "#dateto2" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+1"
            });
        });

  $(function() {
    $( "#menu7date" ).datepicker({
        dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  
   $(function() {
    $( "#menu1date" ).datepicker({
        dateFormat: 'M-y',
            changeMonth: true,
            changeYear: true,
    yearRange: "-100:-0"
        });
  });
  </script>    
    

   <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><img src="/img/loading.gif" class="icon" /></center>
                    <h4>Uploading EWS... <button type="button" class="close" style="float: none;" data-dismiss="modal" aria-hidden="true">×</button></h4>
                </div>
            </div>
        </div>
    </div>
</div>  
        

    <script type="text/javascript">
    $(document).ready(function() {                                                                                                    
                                                                                                        
    
        $('#LOADINGEWS').modal('show');
    })
    
    ;
    
    $(window).load(function(){
        $('#LOADINGEWS').modal('hide');
    });
</script> 
<div class="modal modal-static fade" id="LOADINGEWS" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <center><i class="fa fa-spinner fa-pulse fa-5x fa-lg"></i></center>
                    <br>
                    <h3>Loading EWS... </h3>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
</html>

