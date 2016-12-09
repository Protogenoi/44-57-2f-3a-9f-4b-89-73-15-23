<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../includes/Access_Levels.php'); 

    if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);
}
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
include('../includes/adlfunctions.php');
include('../classes/database_class.php');


if(empty($search)) {
    
    header('Location: ../CRMmain.php'); die;
    
}

include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
    <title>ADL | View Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/styles/Timeline.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="../clockpicker-gh-pages/dist/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="../clockpicker-gh-pages/assets/css/github.min.css">
    <style>
        .label-purple {
  background-color: #8e44ad;
}
    </style>
</head>
<body>
    <?php
    include('../includes/navbar.php');
        if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    ?>  
    <br>

    <?php

 $database = new Database(); 
 
                $database->query("SELECT active, marital, residence, ni_num, ni_num2, title, first_name, initials, last_name, dob, title2, first_name2, initials2, last_name2, dob2, address1, address2, address3, town, post_code, number1, number2, number3, email FROM pension_clients WHERE client_id=:searchplaceholder");
                $database->bind(':searchplaceholder', $search);
                $database->execute();
                $data2=$database->single();
    
    $penmarital=$data2['marital'];
    $penresidence=$data2['residence'];
                
    $pentitle=$data2['title'];
    $penfirst=$data2['first_name'];
    $penint=$data2['initials'];
    $penlast=$data2['last_name'];
    $pendob=$data2['dob'];
    $penadd1=$data2['address1'];
    $penadd2=$data2['address2'];
    $penadd3=$data2['address3'];
    $pentown=$data2['town'];
    $penpost=$data2['post_code'];
    $penemail=$data2['email'];
    $pennum1=$data2['number1'];
    $pennum2=$data2['number2'];
    $pennum3=$data2['number3'];
    $pentitle2=$data2['title2'];
    $penfirst2=$data2['first_name2'];
    $penint2=$data2['initials2'];
    $penlast2=$data2['last_name2'];
    $pendob2=$data2['dob2'];
    $penni=$data2['ni_num'];
    $penni2=$data2['ni_num2'];
    $clientonemail=$data2['email'];
    $penactive=$data2['active'];
    
    $penclientonefulltitle=$data2['title'] ." ". $data2['first_name'] ." ". $data2['last_name'];
    $penclientonefull=$data2['first_name'] ." ". $data2['last_name'];
    $penclienttwofull=$data2['first_name2'] . " " . $data2['last_name2'];
                
                ?>
    
    <div class="container">
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Client</a></li>
            <li><a data-toggle="pill" href="#menu4">Timeline <span class="badge alert-warning">
                
                <?php 
                
                $database->query("select count(note_id) AS badge from pension_client_note where client_id ='$search'"); 
                $row=$database->single(); 
                echo htmlentities($row['badge']);
                
                ?>
                    
                    </span></a></li>
            <li><a data-toggle="pill" href="#menu8">Callbacks</a></li>
            <li><a data-toggle="pill" href="#menu2">Files & Uploads <span class="badge alert-warning">
                
                <?php 

                $database->query("select count(id) AS badge from tbl_uploads where file like '$search-%'"); 
                $filesuploaded=$database->single();  
                echo htmlentities($filesuploaded['badge']);
                                
                ?>
                    </span></a></li>
           

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <div class="list-group">
                        <?php 
                        echo "<li id='clickme'><a class='list-group-item'><i class='fa fa-search fa-fw'></i>&nbsp; Show Alerts</a></li>";
                        
                        if (in_array($hello_name,$Level_3_Access, true)) { ?>
                        <li><a class="list-group-item" href="/EditClient.php?search=<?php echo $search?>&pension"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp; Edit Client</a></li>
                        <?php } ?>
                        <?php 
                        
                        if (in_array($hello_name,$Level_10_Access, true)) { ?>
                        <li><a class="list-group-item" href="/admin/deleteclient.php?search=<?php echo $search?>&pension"><i class="fa fa-trash fa-fw"></i>&nbsp; Delete Client</a></li>
                        <?php }  ?>
                       
                        
                        <li><a class="list-group-item" href="AddNewPension.php?Pension=new&search=<?php echo $search?>"><i class="fa fa-plus fa-fw"></i> Add Policy</a></li>
                    </div>
                </ul>
            </li>
            
        </ul>
        <br>
            
            <?php
            $likesearch = "$search-%";
            include('php/Notifications.php');
            ?>
        
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="container">

     <form class="AddClient" id="AddProduct" action="php/AddPensionClient.php?add=y" method="POST" autocomplete="off">
        <div class="col-md-4">   
            <h3><span class="label label-info">Client Details</span></h3>
            <br>

            
                <p>
                <div class="input-group">
                    <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo "$pentitle $penfirst $penint $penlast";?>" disabled >
                    <span class="input-group-btn">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                            
                    </span>
                </div>
            </p>
            
                                   <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob2" name="dob2" <?php if (isset($pendob)) { echo "value='$pendob'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
            
            
            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="marital" name="marital" <?php if (isset($penmarital)) { echo "value='$penmarital'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Marital Status"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
            
            <?php if (empty($penni)) { } else{ ?>
            
                                               <p>
            <div class="input-group">
                <input type="text" class="form-control" id="ni_num" name="ni_num" <?php if (isset($penni)) { echo "value='$penni'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="National Insurance Number"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php } ?>
            <br>
        
        </div>  
        <div class="col-md-4">
            
            <?php if (empty($pentitle2)) { } else{ ?>
            
            <h3><span class="label label-info">Client 2</span></h3>
            <br>

            
           <p>
                <div class="input-group">
                    <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo "$pentitle2 $penfirst2 $penint2 $penlast2";?>" disabled >
                    <span class="input-group-btn">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Policy Info"><button type="button" data-toggle="modal" data-target="#clientpol1" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                            
                    </span>
                </div>
            </p>
            
                        <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob2" name="dob2" <?php if (isset($pendob2)) { echo "value='$pendob2'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
            
                                                           <p>
            <div class="input-group">
                <input type="text" class="form-control" id="ni_num2" name="ni_num2" <?php if (isset($penni2)) { echo "value='$penni2'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="National Insurance Number"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <br>
            
            <?php } ?>
           
        </div>
        
        <div class="col-md-4">
            <h3><span class="label label-info">Contact Details</span></h3>
            <br>
                 <p>
                <div class="input-group">
                    <input class="form-control" type="tel" id="phone_number" name="number1" <?php if (isset($pennum1)) { echo "value='$pennum1'";} ?> disabled >
                    <span class="input-group-btn">
                        <button type="button" data-toggle="modal" data-target="#smspensionModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
                            
                    </span>
                </div>
            </p>
            <?php if (empty($pennum2)) { } else{ ?>
            
                             <p>
                <div class="input-group">
                    <input class="form-control" type="tel" id="alt_number" name="number2" <?php if (isset($pennum2)) { echo "value='$pennum2'";} ?> disabled >
                    <span class="input-group-btn">
                        <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
                            
                    </span>
                </div>
            </p>
            <?php } if (empty($pennum3)) { } else{  ?>
          
                <p>
                <div class="input-group">
                    <input class="form-control" type="tel" id="alt_number" name="number3" <?php if (isset($pennum3)) { echo "value='$pennum3'";} ?> disabled >
                    <span class="input-group-btn">
                        <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
                            
                    </span>
                </div>
            </p>
            <?php } if (empty($penemail)) { } else{ ?>
           
                        <p>
            <div class="input-group">
                <input class="form-control" type="email" id="email" name="email" <?php if (isset($penemail)) { echo "value='$penemail'";} ?>  disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#emailpension" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
                        
                </span>
            </div>
            </p>
            
            
            <?php } 
            
                         if (empty($penresidence)) { } else{ ?>
            
                        <div class="input-group">
                <input class="form-control" type="text" id="residence" name="residence" <?php if (isset($penresidence)) { echo "value='$penresidence'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Time at residence"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php }  
            
            if (empty($penadd1)) { } else{ ?>
            
                        <div class="input-group">
                <input class="form-control" type="text" id="address1" name="address1" <?php if (isset($penadd1)) { echo "value='$penadd1'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php } if (empty($penadd2)) { } else{ ?>
            
                        <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address2" name="address2" <?php if (isset($penadd2)) { echo "value='$penadd2'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php } if (empty($penadd3)) { } else{ ?>

                                    <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address2" name="address3" <?php if (isset($penadd3)) { echo "value='$penadd3'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php } if (empty($pentown)) { } else{  ?>

                        <p>
            <div class="input-group">
                <input class="form-control" type="text" id="town" name="town" <?php if (isset($pentown)) { echo "value='$pentown'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                </span>
            </div>
            </p>
                        <p>
            <div class="input-group">
                <input class="form-control" type="text" id="post_code" name="post_code" <?php if (isset($penpost)) { echo "value='$penpost'";} ?> disabled >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Post Code"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php } ?>
        </div>
    </form>
                        <br>
                        <br>
                        <br>
                        <br>
                        </div>
                
                               <div class="container">
                    <center>
                        <div class="btn-group">
                            
                            <?php
                            
                            $dealsheetsearchvar = "$search-%";
                            
                            try {
                            
                            $Dealquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :dealsheetsearchplaceholder and uploadtype ='Pension Dealsheet'");
                            $Dealquery->bindParam(':dealsheetsearchplaceholder', $dealsheetsearchvar, PDO::PARAM_STR, 12);
                            $Dealquery->execute();
                            
                            while ($result=$Dealquery->fetch(PDO::FETCH_ASSOC)){
                                
                                ?>
                            
                            <a href="../uploads/<?php echo $result['file'] ?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Dealsheet</a>
                                
                                <?php
                                
                            } 
                            
                                                                                        }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                            
                            ?>
                        
                        </div>
                    </center>
                    <br>
                        <?php
                                $penstages = $pdo->prepare("SELECT policy_id, client_name, policy_number, value, provider FROM pension_policy WHERE client_id =:searchhold;");
                                $penstages->bindParam(':searchhold', $search, PDO::PARAM_INT);
    
    echo "<table class=\"table table-hover\">";
    echo "<thead>
        <tr>
        <th>Client</th> 
        <th>Policy</th>
        <th>Provider</th>
        <th>Pot Value</th>
        <th>View</th>
        </tr>
        </thead>";
    
    $penstages->execute();
    if ($penstages->rowCount()>0) {
        while ($resultstages=$penstages->fetch(PDO::FETCH_ASSOC)){
                      
             $number=$resultstages['value'];
            $sendpolicyid=$resultstages['policy_id'];
            $english_format_number = number_format($number);

            echo '<tr>';
            echo "<td>".$resultstages['client_name']."</td>";
            echo "<td>".$resultstages['policy_number']."</td>";
            echo "<td>".$resultstages['provider']."</td>";
            echo "<td>£$english_format_number</td>";
            echo "<td>
                <a href='ViewPolicy.php?search=$search&policyID=$sendpolicyid' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </a>
                    
                 
                    </td>";
                                                                                    
            echo "<td><form method='POST' action='EditPolicy.php'>    
                  <button type='submit' name='search' value='$search' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>                                                                                    
<input type='hidden' id='id' name='id' value='".$resultstages['policy_id']."' >
                    </form>
                    </td>";
            echo "</tr>";
            
            } 
            
        } else {
            
            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Pension Stages)</div>";
            
        }
        
        echo "</table>"; 


        ?>     
                    
                    
                </div>
            </div>
            
            <div id="menu1" class="tab-pane fade">
                <br>
                    
                    <?php
                    
                    if($ffcallbacks=='1') {  
                        
                        try {
                        
                        $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid from scheduled_pension_callbacks WHERE client_id = :searchplaceholder");
                        $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
                        $query->execute();
                        $pullcall=$query->fetch(PDO::FETCH_ASSOC);
                        
                        $calltimeid=$pullcall['calltimeid'];
                        
                        echo "<button type=\"button\" class=\"btn btn-default btn-block\" data-toggle=\"modal\" data-target=\"#schcallback\"><i class=\"fa fa-calendar-check-o\"></i> Schedule callback ($calltimeid)</button>";
                                                                                    }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                    }
                    
                    ?>
            </div>
            
            <!-- SMS Modal -->
            <div id="smsModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Send SMS</h4>
                        </div>
                        <div class="modal-body">
                            
                            <?php if ($ffsms=='1') {
                                
                                try {
                                
                                $smsquery = $pdo->prepare("select smsprovider, smsusername, smspassword from sms_accounts limit 1");
                                $smsquery->execute()or die(print_r($query->errorInfo(), true));
                                $smsaccount=$smsquery->fetch(PDO::FETCH_ASSOC);
                                
                                $smsuser=$smsaccount['smsusername'];
                                $smspass=$smsaccount['smspassword'];
                                $smspro=$smsaccount['smsprovider'];
                                
                                                                                            }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                
                                ?>
                            
                            <br> 
                                
                                <?php $getsmsbal = file_get_contents("https://www.bulksms.co.uk/eapi/user/get_credits/1/1.1?username=$smsuser&password=$smspass");
                                
                                $str = substr($getsmsbal, 2); ?>
                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Provider</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td><?php echo $smspro;?></td>
                                    <td <?php if($str>='1') { echo 'bgcolor="#85E085"';} else { echo 'bgcolor="#FF4D4D"'; } ?>>
                                        
                                <?php
                                
                                if($str>='1') {
                                    echo $str;
                                    }
                                    
                                    ?>
                                    
                                    </td>
                                </tr>
                            </table>
                            
                            <form class="AddClient">
                                <p>
                                    <label for="phone_number">Contact Number:</label>
                                    <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number']?>" readonly>
                                </p>
                            </form>
                            
                            <form class="AddClient" method="POST" action="/php/sms.php">
                                <input type="hidden" name="keyfield" value="<?php echo $search?>">
                                <div class="form-group">
                                    <label for="selectsms">Select SMS:</label>
                                    <select class="form-control" name="selectopt">
                                        <option value=" ">Select message...</option>
                                            
                                            <?php
                                            
                                            try {
                                            
                                            $SMSquery = $pdo->prepare("SELECT title from sms_templates");
                                            $SMSquery->execute();
                                            if ($SMSquery->rowCount()>0) {
                                                while ($smstitles=$SMSquery->fetch(PDO::FETCH_ASSOC)){
                                                    
                                                    $smstitle=$smstitles['title'];
                                                    echo "<option value='$smstitle'>$smstitle</option>";
                                                    
                                                }
                                                
                                                }
                                                                                                            }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                                ?>
                                    
                                    </select>
                                </div>
                                
                                <input type="hidden" id="FullName" name="FullName" value="<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>">
                                <input type="hidden" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number'];?>">
                                <br>
                                <br>
                                    
                                    <?php 
                                    
                                    if($str>='1') {
                                        
                                        echo "<button type='submit' class='btn btn-success'><i class='fa fa-mobile'></i> SEND SMS</button>";
                                        
                                    }
                                    
                                    else {
                                        
                                        echo "<button type='submit' class='btn btn-warning' disalbed><i class='fa fa-mobile'></i> SEND SMS</button>"; 
                                        
                                    }
                                    
                                    ?>
                            
                            </form>
                                
                                <?php } ?>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SMS ALT Modal -->
            <div id="smsModalalt" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Send SMS</h4>
                        </div>
                        <div class="modal-body">
                            
                            <?php if ($ffsms=='1') { 
                                
                                
                                ?>
                            
                            <br> 
                            
                        <?php $getsmsbal = file_get_contents("https://www.bulksms.co.uk/eapi/user/get_credits/1/1.1?username=$smsuser&password=$smspass");
                        
                        $str = substr($getsmsbal, 2); ?>
                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Provider</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td><?php echo $smspro;?></td>
                                    <td <?php if($str>='1') { echo 'bgcolor="#85E085"';} else { echo 'bgcolor="#FF4D4D"'; } ?>>

                                <?php
                                
                                if($str>='1') {
                                    echo $str;
                                    }
                                    
                                    ?>
                                    
                                    </td>
                                </tr>
                            </table>
                            
                            <form class="AddClient">
                                <p>
                                    <label for="phone_number">Contact Number:</label>
                                    <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['alt_number'];?>" readonly>
                                </p>
                            </form>
                            
                            <form class="AddClient" method="POST" action="/php/sms.php">
                                <input type="hidden" name="keyfield" value="<?php echo $search;?>">
                                <div class="form-group">
                                    <label for="selectsms">Select SMS:</label>
                                    <select class="form-control" name="selectopt">
                                        <option value=" ">Select message...</option>
                                        
          <?php
                                                try {
          $query = $pdo->prepare("SELECT title from sms_templates");
          $query->execute();
          if ($query->rowCount()>0) {
              while ($smstitles2=$query->fetch(PDO::FETCH_ASSOC)){
                  
                  $smstitle=$smstitles2['title'];
                  echo "<option value='$smstitle'>$smstitle</option>";
                  
              }
              
              }
                                                            }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
              ?>
                                    
                                    </select>
                                </div>
                                
                                <input type="hidden" id="FullName" name="FullName" value="<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>">
                                <input type="hidden" id="phone_number" name="phone_number" value="<?php echo $data2['alt_number'];?>">
                                
                                <br>
                                <br>
                                    
                                    <?php 
                                    
                                    if($str>='1') {
                                        echo "<button type='submit' class='btn btn-success'><i class='fa fa-mobile'></i> SEND SMS</button>";
                                        
                                    }
                                    
                                    else {
                                        echo "<button type='submit' class='btn btn-warning' disalbed><i class='fa fa-mobile'></i> SEND SMS</button>";  
                                        
                                    }
                                    
                                    ?>
                            
                            </form>
                                
                                <?php } ?>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- START TAB 3 -->
            
            <div id="menu2" class="tab-pane fade">
                <div class="container">
                    
                    <form action="../../uploadsubmit.php?pension=y" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="uploadclientid" value="<?php echo $search;?>">
                        <label for="file">Select file...<input type="file" name="file" /></label> 
                        
                        <label for="uploadtype">
                            <div class="form-group">
                                <select style="width: 170px" class="form-control" name="uploadtype" required>
                                    <option value="">Select...</option>
                                    <option value="Pension Recording">Call Recording</option>
                                    <option value="Pension Dealsheet">Dealsheet</option>   
                                    <option value="Pension LoA">LoA</option> 
                                    <option value="Pension ToB">ToB</option> 
                                    <option value="Pension Address Proof">Proof of Address</option> 
                                    <option value="Pension Photo ID">Photo ID</option> 
                                    <option value="Pension Statement">Pension Statement/Policy Number</option> 
                                    <option value="Pension Other">Other</option>
                                </select>
                            </div>
                        </label>
                        
                        <input type="hidden" name="search" value="<?php echo $search;?>">
                        <button type="submit" class="btn btn-success" name="btn-upload"><span class="glyphicon glyphicon-arrow-up"> </span></button>
                    </form>
                    <br /><br />
                        
                        <?php
                        
                        $success= filter_input(INPUT_GET, 'success', FILTER_SANITIZE_SPECIAL_CHARS);
                        $fail= filter_input(INPUT_GET, 'fail', FILTER_SANITIZE_SPECIAL_CHARS);
                        
                        if(isset($success)) {
                            
                            ?>
                    
                    <label>File Uploaded Successfully... </label>

        <?php
        
                        }
                        
                        else if(isset($fail)) {
                            
                            ?>
                    
                    <label>Problem While File Uploading !</label>
                        
                        <?php
                        
                        }
                        
                        else {
                            
                        }
                        
                        ?>
                    
                    <div class="list-group">
                        <span class="label label-primary"><?php echo $data2['title'];?> <?php echo $data2['last_name'];?> Letters/Emails</span>
<a class="list-group-item confirmation" href="php/WelcomeEmail.php?search=<?php echo $search;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; Welcome Email</a>

                        
                        <script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to send this email? An appointment MUST be set first! The email will be immediately sent.')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

<?php
                        
                        if($ffaudits=='1') { 
                            ?> 
                        
                        <span class="label label-primary">Audit Reports</span>
                        
                        <?php
                    
                        try {
                        
                    $anquery = $pdo->prepare("select application_number from client_policy where client_id=:search");
                    $anquery->bindParam(':search', $search, PDO::PARAM_INT);   
                    $anquery->execute();
                    $ansearch=$anquery->fetch(PDO::FETCH_ASSOC);  
                    
                    $an_number=$ansearch['application_number'];
                    
                    }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                    
                try {
                
                    $query = $pdo->prepare("select closer_audits.id AS CLOSER, Audit_LeadGen.id AS LEAD from closer_audits JOIN Audit_LeadGen on closer_audits.an_number=Audit_LeadGen.an_number where closer_audits.an_number=:annum");
                    $query->bindParam(':annum', $an_number, PDO::PARAM_INT); 
                    $query->execute();
                    $auditre=$query->fetch(PDO::FETCH_ASSOC);
                    
                    $closeraudit=$auditre['CLOSER'];
                    $leadaudit=$auditre['LEAD'];
                    
                    }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                    
                    ?>
                        
                    <a class="list-group-item" href="/audits/closer_form_view.php?auditid=<?php echo $closeraudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; Closer Audit</a>
                    <a class="list-group-item" href="/audits/lead_gen_form_view.php?new=y&auditid=<?php echo $leadaudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; Lead Audit</a>

                    <?php                   }
                    
                    
                     try {
                            
                            $query = $pdo->prepare("SELECT leadid1, leadid2, leadid3, callauditid FROM client_details WHERE client_id = :searchplaceholder");
                            $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
                            $query->execute();
                            $data2=$query->fetch(PDO::FETCH_ASSOC);
                            
                            $leadid1 = $data2['leadid1'];
                            $leadid2 = $data2['leadid2'];
                            $leadid3 = $data2['leadid3'];
                            
                            }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                if($ffdialler=='1') {
                  if(!empty($leadid1) || ($leadid2) || $leadid3){        ?>
                    <span class="label label-primary">Call Recordings</span>

                  <?php } if (!empty($leadid1)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 1</a>
        
                   <?php }  } 
                    
                            if (!empty($leadid2)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 2</a>
        
                   <?php } 
                   
                                               if (!empty($leadid3)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 3</a>
        
                   <?php } 
                    
                     try {
                                
                                $queryup = $pdo->prepare("SELECT file, uploadtype FROM tbl_uploads WHERE file like :file");
                                $queryup->bindParam(':file', $likesearch, PDO::PARAM_STR, 12);
                                $queryup->execute(); 
         
                                if ($queryup->rowCount()>0) {
                                    
                                    ?>
                                    
                                    <span class="label label-primary">Uploads</span>
                                    
                                    <?php
                                    
                                    while ($row=$queryup->fetch(PDO::FETCH_ASSOC)){
                                        
                                        $file=$row['file'];
                                        $uploadtype=$row['uploadtype'];
                                        
                                        switch ($uploadtype) {
                                            case "Dealsheet":
                                                case "LGpolicy":
                                                    case "LGkeyfacts":
                                                        case "TONIC PDF":
                                                $typeimage="fa-file-pdf-o";
                                                break;
                                            case "Happy Call":
                                                case "Recording":
                                                    case "Pension Recording":
                                                    case "LGkeyfacts":
                                                        case "TONIC RECORDING":
                                                $typeimage="fa-headphones";
                                                break;
                                            case "Other":
                                                $typeimage="fa-file-text-o";
                                                break;
                                            case "lifenotes":
                                                $typeimage="fa-file-text-o";
                                                break;
                                            case "LifeLeadAudit":
                                            case "LifeCloserAudit":
                                                $typeimage="fa-folder-open";
                                                break;
                                            default:
                                                $typeimage=$uploadtype;  
                                                
                                        }
                                        
                                        switch ($uploadtype) {
                                            case "LGkeyfacts":
                                                $uploadtype="L&G Keyfacts";
                                                break;
                                            case "LGpolicy":
                                                $uploadtype="L&G APP";
                                                break;
                                            case "lifenotes":
                                                $uploadtype="Notes";
                                                break;
                                            case "LifeCloserAudit":
                                                $uploadtype="Closer Audit";
                                                break;
                                            case "LifeLeadAudit":
                                                $uploadtype="Life Audit";
                                                break;
                                            default:
                                                $uploadtype;  
                                                
                                        }
                                  if($uploadtype=='TONIC RECORDING') {
                                    $newfileholder= str_replace("$search-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholder"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                  } 
                                  
                                                                   if($uploadtype=='TONIC PDF') {
                                    $newfileholderPDF= str_replace("$search-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholderPDF"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                 }
                                 
                                                       if($row['uploadtype']=='Other') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }
                                  
                                  if($row['uploadtype']=='RECORDING') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }
                                  
                                if($row['uploadtype']=='Dealsheet') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }    
                                  
                                if($row['uploadtype']=='LGkeyfacts') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }     
                                  
                                 if($row['uploadtype']=='L&G APP') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }    
                                  
                               if($row['uploadtype']=='LifeCloserAudit') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                               if($row['uploadtype']=='LifeLeadAudit') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                if($row['uploadtype']=='Recording') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                                                  if($row['uploadtype']=='Pension Recording') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                if($row['uploadtype']=='Happy Call') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                    }
                                }
                                }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                                          ?>
                       </div>
                           
                           <?php if (in_array($hello_name,$Level_10_Access, true)) { ?>
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="4"><h3><span class="label label-info">Uploads</span></h3><label></label></th>
                            </tr>
                            <tr>
                                <td>File Name</td>
                                <td>File Type</td>
                                <td></td>
                                <td></td>
                            </tr>
                                
                                <?php
                                
                                try {
                                
                                $query = $pdo->prepare("SELECT file, uploadtype, id FROM tbl_uploads WHERE file like :filelikeholder");
                                $query->bindParam(':filelikeholder', $likesearch, PDO::PARAM_STR, 12);
                                $query->execute();  
                                
                                $i=0;
                                if ($query->rowCount()>0) {
                                    while ($row=$query->fetch(PDO::FETCH_ASSOC)){
                                        $i++;
                                        
                                        ?>
                            
                            <tr>
                                <td><?php echo $row['file'] ?></td>
                                <td><?php echo $row['uploadtype'] ?></td>
                                <td><a href="../uploads/<?php echo $row['file'] ?>" target="_blank"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-search"></span> </button></a></td>
                                <td>
                                            
                                    <form id="deletefileconfirm<?php echo $i?>" action="../php/DeleteUpload.php?deletefile=1" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <input type="hidden" name="file" value="<?php echo $row['file'] ?>">
                                        <input type="hidden" name="search" value="<?php echo $search ?>">
                                        <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> </button>
                                    </form>

        <?php } ?>
                                
                                </td>
                            </tr>
                        </thead>
                        
                        <script>
        document.querySelector('#deletefileconfirm<?php echo $i?>').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Delete file?",
                text: "File cannot be recovered if deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Deleted!',
                        text: 'File deleted!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No files were deleted", "error");
                }
            });
        });
                            </script>
                                
                                <?php } }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }} 
                                
                                
                                ?>
                    
                    </table>
                        
                        <?php
                        
                        if($ffdialler=='1' && $companynamere=='The Review Bureau')   {

                                include('../includes/RealTimeCON.php');
                            
                            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                $search = $_GET['search'];
                                if(isset($_GET["search"])) $rf = $_GET["search"];
                                
                            }
                            
                            if(isset($leadid1)) {  
                             
                             try {
                             
                             $recording_query = $bureaupdo->prepare("SELECT lead_id, user, start_time, end_time, length_in_min, location from recording_log where lead_id =:leadid AND NOT lead_id ='0' ORDER BY start_time DESC limit 25");
                                $recording_query->bindParam(':leadid', $leadid1, PDO::PARAM_INT);
                                $recording_query->execute(); 
                                
                                
                            ?>
                    
                    
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="6"><h3><span class=\"label label-info\">Call Recordings</span></h3></th>
                            </tr>
                        <th>Lead ID</th>
                        <th>User</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Length (mins)</th>
                        <th>Location</th>
                    </thead>
                    
                    <?php
                    
                                if ($recording_query->rowCount()>0) {
                                    while ($row=$recording_query->fetch(PDO::FETCH_ASSOC)){
                            
                            $lead_id  =$row['lead_id'];
                            $location=$row['location'];
                            $user=$row['user'];
                            
                            echo '<tr class='.$class.'>';
                            echo "<tr>";
                            echo "<td><a href='//bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=" . $row['lead_id'] . "'target='_blank'>$lead_id</a></td>";
                            echo "<td><a href='//bureau.bluetelecoms.com/vicidial/admin.php?ADD=3&user=" . $row['user'] . "'target='_blank'>$user</a></td>";
                            echo "<td>".$row['start_time']."</td>";
                            echo "<td>".$row['end_time']."</td>";
                            echo "<td>".$row['length_in_min']."</td>";
                            echo "<td><a href='" . $row['location'] . "'target='_blank'>Download</a></td>";
                            echo  "</td>";
                            echo "</tr>";
                            echo "\n";
                            
                        }
                        
                        }
                        
                        else {
                            echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Recordings Available</div>";
                            
                        }

                          }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                        }
                        echo "</table>";
                        }
                        ?>
                    
                   
                </div>
            </div>
                
                <?php
                
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $search = $_GET['search'];
                    if(isset($_GET["search"])) $rf = $_GET["search"];
                    
                }
                
                try {
                
                $query = $pdo->prepare("SELECT leadauditid, client_id, title, first_name, last_name, email, title2, first_name2, last_name2, dob2, email2 FROM client_details WHERE client_id =:data2searchholder");
                $query->bindParam(':data2searchholder', $search, PDO::PARAM_STR, 12);
                $query->execute();
                $data2=$query->fetch(PDO::FETCH_ASSOC);
                
                  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                ?>
            
            
                 
             
            
            <div id="menu8" class="tab-pane fade">
                
                  <?php if($ffcallbacks=='1') { ?>
                
                <form class="form-horizontal" action='php/AddCallback.php?setcall=y&search=<?php echo $search;?>' method='POST'>                
                    <fieldset>
                        
                        <div class='container'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='getcallback_client' name='callbackclient' class='form-control'>
                                            <option value='<?php echo $penclientonefull;?>'><?php echo $penclientonefull;?></option>
                                            <option value='<?php echo $penclienttwofull;?>'><?php echo $penclienttwofull;?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
        
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='assign' name='assign' class='form-control'>
                                            <option value='<?php echo $hello_name;?>'><?php echo $hello_name;?></option>
                                            <option value='Matthew'>Matthew</option>
                                            <option value='Gavin'>Gavin</option>
                                            <option value='Hannah'>Hannah</option>
                                            <option value='Kelly'>Kelly</option>
                                            <option value='Nathan'>Nathan</option>
                                            <?php
                                            
                                            try {
                                            
                                            $calluser = $pdo->prepare("SELECT login, real_name from users where extra_info ='User'");
                                            
                                            $calluser->execute()or die(print_r($calluser->errorInfo(), true));
                                            if ($calluser->rowCount()>0) {
                                                while ($row=$calluser->fetch(PDO::FETCH_ASSOC)){
                                           
                                            
                                            ?>
                                            
                                            <option value='<?php echo $row['login'];?>'><?php echo $row['real_name'];?></option>
                                            
                                            <?php
                                            
                                                }
                                                
                                                }
                                                  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                                ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" id="callback_date" name="callbackdate" placeholder="YYYY-MM-DD" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date clockpicker'>
                                            <input type='text' class="form-control" id="clockpicker" name="callbacktime" placeholder="24 Hour Format" required  />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-4'>
                            <div class="form-group">

    <select id="calltype" name="calltype" class="form-control" required>
        <option value="">Callback type...</option>
      <option value="Quickdox Appointment">Quickdox Appointment</option>
      <option value="Other">Other</option>
 
    </select>
</div>
                                </div>
                            </div>                            
                            
                            <div class="row">
                                <div class='col-md-4'>
                            <div class="form-group">

    <select id="callreminder" name="callreminder" class="form-control" required>
        <option value="">Reminder</option>
      <option value="-5 minutes">5mins</option>
      <option value="-10 minutes">10mins</option>
      <option value="-15 minutes">15mins</option>
      <option value="-20 minutes">20mins</option>
    </select>
</div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class='col-md-4'>
                                    <div class="form-group"> 
                                        <textarea class="form-control" id="textarea" name="callbacknotes" placeholder="Call back notes"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        
                        <button id="callsub" name="callsub" class="btn btn-primary"><i class='fa  fa-check-circle-o'></i> New callback</button>
                    
                    </fieldset>
                </form> 
                    
                    <?php
                    
                    try {
                    
                    $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid, CONCAT(callback_date, ' - ',callback_time) AS ordersort, id, client_name, notes, complete from scheduled_pension_callbacks WHERE client_id = :searchplaceholder ORDER BY ordersort DESC");
                    $query->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);
                    
                    ?>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan='2'><h3><span class="label label-info">Call backs</span></h3></th>
                        </tr>
                    <th>Client</th>
                    <th>Call back</th>
                    <th>Notes</th>
                    <th colspan="2">Callback status</th>
                </thead>
                    
                    <?php
                    
                    $query->execute();
                    if ($query->rowCount()>0) {
                        while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
                            
                            $callbackid = $calllist['id'];
                            
                            echo '<tr>';
                            echo "<td>".$calllist['client_name']."</td>";
                            echo "<td>".$calllist['calltimeid']."</td>"; 
                            echo "<td>".$calllist['notes']."</td>"; 
                            echo "<td><a href='php/AddCallback.php?search=$search&callbackid=$callbackid&cb=yV' class=\"btn btn-success btn-xs\"><i class='fa fa-check'></i> Complete</a></td>";
                            echo "<td><a href='php/AddCallback.php?search=$search&callbackid=$callbackid&cb=nV' class=\"btn btn-warning btn-xs\"><i class='fa fa-times'></i> Incomplete</a></td>";
                            echo "</tr>";
                            
                        }
                        
                        }
                        
                        else {
                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs found</div>";
                            
                        }
                        
                        echo "</table>";
                          }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                        }
                        
                        ?>
            </div>
            
            <div id="menu4" class="tab-pane fade">

                <?php
        
                $database->query("select active_stage FROM pension_stages where client_id=:cid and stage='1'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                $StageONEactive=$result['active_stage'];
                
                $database->query("select active_stage FROM pension_stages where client_id=:cid and stage='1.1'");
                $database->bind(':cid', $search); 
                $database->execute();
                $Stage1bresult=$database->single();
                $StageONEbactive=$Stage1bresult['active_stage'];
                
        if($StageONEactive == "Y") {

            try {
                
                $query = $pdo->prepare("select complete, stage_id, task FROM pension_stages where client_id=:cid and stage='1'");
                $query->bindParam(':cid', $search, PDO::PARAM_STR, 12);
                
                $query->execute();
                if ($query->rowCount()>0) {
                    
                    ?>
                   <center>
                    <br><br>
                    
                    <div class="btn-group">
                    <?php
                $i=0;
                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                   $i++; 
                    $StageONEtask=$result['task'];
                    $StageONEid=$result['stage_id'];
                    $StageONEcomplete=$result['complete'];
                    
                    ?>
             
                        <button type="button" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="<?php if(isset($StageONEtask)) { if($StageONEcomplete=='No') { echo "btn btn-danger";} if($StageONEcomplete=='Yes') { echo "btn btn-success"; }} ?>"><?php echo $StageONEtask; ?></button>                 
<div id="myModal<?php echo $i?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $StageONEtask;?></h4>
      </div>
      <div class="modal-body">
          <i class="fa fa-question-circle-o fa-5x"></i>
          <br>
        <p>Has this task been completed?</p>
        <br>
        <a href="php/TaskComplete.php?stage=1&Task=<?php echo $StageONEtask;?>&stageid=<?php echo $StageONEid;?>&complete=1&search=<?php echo $search;?>"  class="btn btn-success"><i class="fa fa-check-square-o"></i> Yes</a> 
        <a href="php/TaskComplete.php?stage=1&Task=<?php echo $StageONEtask;?>&stageid=<?php echo $StageONEid;?>&complete=0&search=<?php echo $search;?>"   class="btn btn-danger" ><i class="fa fa-close"></i> No</a>
      </div>
    </div>

  </div>
</div>    
                        
                        <?php }
                        
                        ?>
                                            
                    </div>

                    <br><br>
                   </center> 

                        <?php
                        
                        }} 
                        
                         catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                $database->query("select complete FROM pension_stages where client_id=:cid and stage='1' and complete='Yes'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                if ($database->rowCount()>=5) {
                $StageONEcomplete=$result['complete'];
                
                ?>
                <center>    
                    <a href="php/StageComplete.php?stage=1&complete=1&search=<?php echo $search;?>&policy_id=<?php echo $sendpolicyid;?>"  class="btn btn-info"><i class="fa fa-question-circle-o fa-5x"></i><br> Complete Stage 1</a> 
                </center>
                
                <?php
                
                }
                
                        
        }      
        
        
                if($StageONEbactive == "Y") {

            try {
                
                $query = $pdo->prepare("select complete, stage_id, task FROM pension_stages where client_id=:cid and stage='1.1'");
                $query->bindParam(':cid', $search, PDO::PARAM_STR, 12);
                
                $query->execute();
                if ($query->rowCount()>0) {
                    
                    ?>
                   <center>
                    <br><br>
                    
                    <div class="btn-group">
                    <?php
                $i=0;
                while ($result=$query->fetch(PDO::FETCH_ASSOC)){
                   $i++; 
                    $StageONEbtask=$result['task'];
                    $StageONEbid=$result['stage_id'];
                    $StageONEbcomplete=$result['complete'];
                    
                    ?>
             
                        <button type="button" data-toggle="modal" data-target="#myModal<?php echo $i;?>" class="<?php if(isset($StageONEbtask)) { if($StageONEbcomplete=='No') { echo "btn btn-danger";} if($StageONEbcomplete=='Yes') { echo "btn btn-success"; }} ?>"><?php echo $StageONEbtask; ?></button>                 
<div id="myModal<?php echo $i?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $StageONEbtask;?></h4>
      </div>
      <div class="modal-body">
          <i class="fa fa-question-circle-o fa-5x"></i>
          <br>
        <p>Has this task been completed?</p>
        <br>
        <a href="php/TaskComplete.php?stage=1.1&Task=<?php echo $StageONEbtask;?>&stageid=<?php echo $StageONEbid;?>&complete=1&search=<?php echo $search;?>"  class="btn btn-success"><i class="fa fa-check-square-o"></i> Yes</a> 
        <a href="php/TaskComplete.php?stage=1.1&Task=<?php echo $StageONEbtask;?>&stageid=<?php echo $StageONEbid;?>&complete=0&search=<?php echo $search;?>"   class="btn btn-danger" ><i class="fa fa-close"></i> No</a>
      </div>
    </div>

  </div>
</div>    
                        
                        <?php }
                        
                        ?>
                                            
                    </div>

                    <br><br>
                   </center> 

                        <?php
                        
                        }} 
                        
                         catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                $database->query("select complete FROM pension_stages where client_id=:cid and stage='1.1' and complete='Yes'");
                $database->bind(':cid', $search); 
                $database->execute();
                $result=$database->single();
                if ($database->rowCount()>=8) {
                $StageONEcomplete=$result['complete'];
                
                ?>
                <center>    
                    <a href="php/StageComplete.php?stage=1.1&complete=1&search=<?php echo $search;?>&policy_id=<?php echo $sendpolicyid;?>"  class="btn btn-info"><i class="fa fa-question-circle-o fa-5x"></i><br> Complete Stage 1.1</a> 
                </center>
                
                <?php
                
                }
                
                        
        } 
        
        ?>
            
                    <div class='container'>
                        <form method="post" id="clientnotessubtab" action="php/AddNotes.php?ViewClientNotes=1" class="form-horizontal">
                            <legend><h3><span class="label label-info">Add notes</span></h3></legend>
                            <input type="hidden" name="client_id" value="<?php echo $search?>">
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="client_name"></label>
                                <div class="col-md-4">
                                    <select id="selectbasic" name="client_name" class="form-control" required>
                                        <option value="<?php echo $penclientonefull;?>"><?php echo $penclientonefull;?></option>
                                        <option value="<?php echo $penclienttwofull;?>"><?php echo $penclienttwofull;?></option>
                                    </select>
                                </div>
                            </div>
  
                            <div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="notes" name="notes" placeholder="Add Notes Here (2k CHARS MAX)" maxlength="2000" required></textarea>
    <span id="chars">2000</span> characters remaining
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
      <button class="btn btn-primary btn-block"><i class="fa fa-pencil-square-o"></i> Submit</button>
  </div>
</div>
                        </form>
</div>
       <h3><span class="label label-info">Client Timeline</span></h3>             
        
        <style>
            .fa-edit {
                color: #FEAF20;
            }
            .fa-exclamation {
                color: #FEAF20;
            }
            .fa-exclamation-triangle {
                color: red;
            }
            .fa-upload {
                color: #5BC0DE;
            }
            .fa-phone {
                color: #2A6598;
            }
            .fa-gbp {
                color: red;
            }
             .fa-check {
                color: green;
            }
            .fa-thumbs-up
            {
                color: green;
            }
        </style>
        <br><br>
<?php
       
try {

$clientnote = $pdo->prepare("select client_name, note_type, message, sent_by, date_sent from pension_client_note where client_id = :searchplaceholder ORDER BY date_sent DESC");
$clientnote->bindParam(':searchplaceholder', $search, PDO::PARAM_STR, 12);

$clientnote->execute();
if ($clientnote->rowCount()>0) {
while ($result=$clientnote->fetch(PDO::FETCH_ASSOC)){
    
    $TLdate=$result['date_sent'];
    $TLwho=$result['sent_by'];
    $TLname=$result['client_name'];
    $TLmessage=$result['message'];
    $TLnotetype=$result['note_type'];
    
    $TLdate= date("d M y - G:i:s");
    
    switch ($TLnotetype) {
    
        case "Client Added":
            $TMicon="fa-user-plus";
            break;
        case "Policy Deleted":
            $TMicon="fa-exclamation";
            break;
        case "CRM Alert":
            case "Policy Added":
            $TMicon="fa-check";
            break;
        case "EWS Status update":  
            case"EWS Uploaded";
                $TMicon="fa-exclamation-triangle";
                break;
            case "Financial Uploaded":
                $TMicon="fa-gbp";
                break;
            case "Dealsheet":
                case"LGpolicy";
                    case"LGkeyfacts";
                        case"Recording";
                $TMicon="fa-upload";
                break;
            case stristr($TLnotetype,"Tasks"):
                $TMicon="fa-tasks";
                break;
            case "Client Note":
                $TMicon="fa-pencil";
                break;
            case stristr($TLnotetype,"Callback"):
                $TMicon="fa-calendar-check-o";
                break;
            case "Email Sent":
                $TMicon="fa-envelope-o";
                break;
            case "Client Details Updated":
                case "Policy Details Updated":
                    case"Policy Number Updated":
                $TMicon="fa-edit";
                break;
            case "Sent SMS":
                $TMicon="fa-phone";
                break;
        case "Task Updated";
            $TMicon="fa-check-circle-o";
            break;
        case "Stage Complete";
            $TMicon="fa-thumbs-up";
            break;
            default:
                $TMicon="fa-bomb";

    } 
    
    ?>        
            <div class="qa-message-list" id="wallmessages">
    				<div class="message-item" id="m16">
						<div class="message-inner">
							<div class="message-head clearfix">
                                                            <div class="avatar pull-left"><i id="iconid" class="fa <?php echo "$TMicon";?> fa-3x"></i></div>
								<div class="user-detail">
									<h5 class="handle"><?php echo "Note Type: <strong>$TLname | $TLnotetype</strong>"; ?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?php echo "Date: $TLdate"; ?></span>
											</span>
											<span class="qa-message-who">
												<span class="qa-message-who-pad"><?php echo " Added by: $TLwho"; ?> </span>
												<span class="qa-message-who-data"><a href="./index.php?qa=user&qa_1=Oleg+Kolesnichenko"></a></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-content">
								<?php
                                                                if (in_array($hello_name,$Level_3_Access, true)) {
                                                                
                                                                echo "<strong>$TLmessage</strong>"; }
                                                                
                                                                else { echo "$TLmessage"; }
                                                                
                                                                ?>
							</div>
					</div></div>
        
        
        <?php
}
} 
  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
   
   
?>
</div>

</div>
<!-- START EMAIL BPOP -->

<div id="email2pop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email: <?php echo $data2['title2'];?> <?php echo $data2['last_name2'];?> <i>(<?php echo $data2['email2'];?>)</i></h4>
            </div>
            <div class="modal-body">
                <?php if($ffclientemails=='1') { ?>
                
                <form class="AddClient" method="post" action="../email/php/ViewClientEmailSend.php?life=y" enctype="multipart/form-data">
                    
                    <input type="hidden" name="keyfield" value="<?php echo $search;?>">
                    <input type="hidden" name="recipient" value="<?php echo $data2['title2'];?> <?php echo $data2['last_name2'];?>" readonly>
                    <input type="hidden" name="email" value="<?php echo $data2['email2'];?>" readonly>
                    <input type="hidden" name="note_type" value="Email Sent">
                    
                    <p>
                        <label for="subject">Subject</label>
                        <input name="subject" id="subject"  class="summernote" placeholder="Subject/Title" type="text" required/>
                    </p>
                    <p>
                        <label for="Message">Message:</label> <br />
                        <textarea name="message" id="message" rows="15" cols="85"></textarea><br />
                        <label for="attachment1">Add attachment:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        <label for="attachment2">Add attachment 2:</label>
                        <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                        <label for="attachment3">Add attachment 3:</label>
                        <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                        <label for="attachment4">Add attachment 4:</label>
                        <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                        <label for="attachment5">Add attachment 5:</label>
                        <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                        <label for="attachment6">Add attachment 6:</label>
                        <input type="file" name="fileToUpload6" id="fileToUpload6">
                    </p>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
                </form>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- START EMAIL BPOP -->
<div id="email1pop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Email: <?php echo $data2['title'];?> <?php echo $data2['last_name'];?> <i>(<?php echo $data2['email'];?>)</i></h4>
            </div>
            <div class="modal-body">
                <?php if($ffclientemails=='1') { ?>
                
                <form class="AddClient" method="post" action="../email/php/ViewClientEmailSend.php?life=y" enctype="multipart/form-data">
                    
                    <input type="hidden" name="keyfield" value="<?php echo $search;?>">
                    <input type="hidden" name="recipient" value="<?php echo $data2['title'];?> <?php echo $data2['last_name'];?>" readonly>
                    <input type="hidden" name="email" value="<?php echo $data2['email'];?>" readonly>
                    <input type="hidden" name="note_type" value="Email Sent">
                    
                    <p>
                        <label for="subject">Subject</label>
                        <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                    </p>
                    
                    <p>
                        <label for="Message">Message:</label> <br />
                        <textarea name="message" id="message" rows="15" cols="85"></textarea><br />
                        <label for="attachment1">Add attachment:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br>
                        <label for="attachment2">Add attachment 2:</label>
                        <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                        <label for="attachment3">Add attachment 3:</label>
                        <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                        <label for="attachment4">Add attachment 4:</label>
                        <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                        <label for="attachment5">Add attachment 5:</label>
                        <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                        <label for="attachment6">Add attachment 6:</label>
                        <input type="file" name="fileToUpload6" id="fileToUpload6">
                    </p>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-warning "><span class="glyphicon glyphicon-envelope"></span> Send Email</button>
                </form>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span>Close</button>
            </div>
        </div>
    </div>
</div>


    
        <script type="text/javascript">
$('.clockpicker').clockpicker();
</script>


<script type="text/javascript" src="/clockpicker-gh-pages/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});

</script>
<script type="text/javascript" src="/clockpicker-gh-pages/assets/js/highlight.min.js"></script>
<script>
        document.querySelector('#clientnotessubtab').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Submit notes?",
                text: "Confirm to send notes!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Notes submitted!',
                        text: 'Notes saved!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
<script>
        document.querySelector('#ClientTaskForm').addEventListener('submit', function(e) {
            var form = this;
            e.preventDefault();
            swal({
                title: "Update Task?",
                text: "Confirm to Update Task!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Updated!',
                        text: 'Task Updated!',
                        type: 'success'
                    }, function() {
                        form.submit();
                    });
                    
                } else {
                    swal("Cancelled", "No changes were made", "error");
                }
            });
        });

</script>
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script>var maxLength = 2000;
$('textarea').keyup(function() {
  var length = $(this).val().length;
  var length = maxLength-length;
  $('#chars').text(length);
});</script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
 <script>
  $(function() {
    $( "#callback_date" ).datepicker({
        dateFormat: 'yy-mm-dd',
            changeMonth: true
        });
  });
    $( "#CLICKTOHIDEDEALSHEET" ).click(function() {
  $( "#HIDEDEALSHEET" ).fadeOut( "slow", function() {

  });
});
  $( "#CLICKTOHIDECLOSERKF" ).click(function() {
  $( "#HIDECLOSERKF" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDELGKEY" ).click(function() {
  $( "#HIDELGKEY" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDELGAPP" ).click(function() {
  $( "#HIDELGAPP" ).fadeOut( "slow", function() {

  });
});

$( "#CLICKTOHIDEDUPEPOL" ).click(function() {
  $( "#HIDEDUPEPOL" ).fadeOut( "slow", function() {

  });
});
$( "#CLICKTOHIDENEWPOLICY" ).click(function() {
  $( "#HIDENEWPOLICY" ).fadeOut( "slow", function() {

  });
});

$( "#clickme" ).click(function() {
  $( "#HIDELGAPP,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY").fadeIn( "slow", function() {
    // Animation complete
  });
});
  </script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script src="/js/sweet-alert.min.js"></script>
<script>

$(document).ready(function() {
   if(window.location.href.split('#').length > 1 )
      {
      $tab_to_nav_to=window.location.href.split('#')[1];
      if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
         {
         $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
         }
      }
});

</script>

</body>
</html>
