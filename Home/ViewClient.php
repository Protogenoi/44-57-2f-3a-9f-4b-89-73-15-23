<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
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

$CID= filter_input(INPUT_GET, 'CID', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($CID)) {
    $likesearch = "$CID-%";
    
}

if(empty($CID)) {
    
    header('Location: /../CRMmain.php?AccessDenied'); die;
    
}

        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
    <title>ADL | Home Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/styles/Timeline.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/clockpicker-gh-pages/dist/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="/resources/lib/clockpicker-gh-pages/assets/css/github.min.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .label-purple {
  background-color: #8e44ad;
}
    </style>
</head>
<body>
    <?php
    require_once(__DIR__ . '/../includes/navbar.php');

    ?>  
    <br>

    <?php

 $database = new Database(); 
 
                $database->query("SELECT company, leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, address3, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3,  leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id = :CID");
                $database->bind(':CID', $CID);
                $database->execute();
                $data2=$database->single();
                
                $WHICH_COMPANY=$data2['company'];
                $client_date_added=$data2['date_added'];
                $clientonemail=$data2['email'];
                $clienttwomail=$data2['email2'];
                $clientonefull=$data2['first_name'] ." ". $data2['last_name'];
                $clienttwofull=$data2['first_name2'] . " " . $data2['last_name2'];
                $leadid1 = $data2['leadid1'];
                $leadid2 = $data2['leadid2'];
                $leadid3 = $data2['leadid3'];

                ?>
    
    <div class="container">
<?php    if($WHICH_COMPANY=='TRB Home Insurance') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>Home Client</center></strong> </div>";
        
    }        
    ?>
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Client</a></li>
            <li><a data-toggle="pill" href="#menu4">Timeline <span class="badge alert-warning">
                
                <?php 
                
                $database->query("select count(note_id) AS badge from client_note where client_id ='$CID'"); 
                $row=$database->single(); 
                echo htmlentities($row['badge']);
                
                ?>
                    
                    </span></a></li>
            <li><a data-toggle="pill" href="#menu8">Callbacks</a></li>
            <li><a data-toggle="pill" href="#menu2">Files & Uploads <span class="badge alert-warning">
                
                <?php 

                $database->query("select count(id) AS badge from tbl_uploads where file like '$CID%'"); 
                $filesuploaded=$database->single();  
                echo htmlentities($filesuploaded['badge']);
                                
                ?>
                    </span></a></li>
            <?php 
                        if (in_array($hello_name,$Level_10_Access, true)) { ?>
            <li><a data-toggle="pill" href="#menu3">Financial</a></li>
            <?php } ?>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <div class="list-group">
                        <?php 
                        echo "<li id='clickme'><a class='list-group-item'><i class='fa fa-CID fa-fw'></i>&nbsp; Show Alerts</a></li>";

                        if (in_array($hello_name,$Level_3_Access, true)) { ?>
                        <li><a class="list-group-item" href="EditClient.php?CID=<?php echo $CID; ?>&home"><i class="fa fa-pencil-square-o fa-fw"></i>&nbsp; Edit Client</a></li>
                        <?php } ?>
                        <?php 
                        
                        if (in_array($hello_name,$Level_10_Access, true)) { ?>
                        <li><a class="list-group-item" href="/admin/deleteclient.php?CID=<?php echo $CID; ?>&home"><i class="fa fa-trash fa-fw"></i>&nbsp; Delete Client</a></li>
                        <?php } ?>

                        
                        <li><a class="list-group-item" href="AddPolicy.php?Home=y&CID=<?php echo $CID; ?>"><i class="fa fa-plus fa-fw"></i> Add Policy</a></li>
                    </div>
                </ul>
            </li>
            
        </ul>
        <br>
        
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <?php include('php/Notifications.php'); ?>
                <div class="container">

                    <form class="AddClient">

                        
                        <div class="col-md-4">
                            <h3><span class="label label-primary">Client Details</span></h3>
                            
                            <p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $data2['title']?> <?php echo $data2['first_name']?> <?php echo $data2['last_name']?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a> </span>
                            </div>
                        </p>

            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $data2['dob'];?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
            <?php if(!empty($data2['email'])) { ?>
         
            <p>
            <div class="input-group">
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $data2['email']?>"  readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
                        
                </span>
            </div>
            </p>
 
            <?php } ?>
                            
                <?php $auditid = $data2['callauditid']; ?>
            
            <br>
            
            </div>
            
            <div class="col-md-4">
                
                <?php if (!empty($data2['first_name2'])) { ?>
                
                <h3><span class="label label-primary">Client Details (2)</span></h3>
                
                <p>
                <div class="input-group">
                    <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo $data2['title2']?> <?php echo $data2['first_name2']?> <?php echo $data2['last_name2']?>"  readonly >
                    <span class="input-group-btn">
                        <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                            
                    </span>
                </div>
            </p>
            
            <p>
            <div class="input-group">
                <input type="text" class="form-control" id="dob2" name="dob2" value="<?php echo $data2['dob2']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>
                        
                </span>
            </div>
            </p>
             <?php if(!empty($data2['email2'])) { ?>
            <p>
            <div class="input-group">
                <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $data2['email2']?>"  readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>
                        
                </span>
            </div>
            </p>
            
             <?php } }?>
            
            </div>
            
            <div class="col-md-4">
                <h3><span class="label label-primary">Contact Details</span></h3>
                
                <p>
                <div class="input-group">
                    <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $data2['phone_number']?>" readonly >
                    <span class="input-group-btn">
                        <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>
                            
                    </span>
                </div>
            </p>
                
                <?php
                
                if(!empty($data2['alt_number'])) { ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $data2['alt_number']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>

                </span>
            </div>
            </p>
                
                <?php } ?>
            
            <div class="input-group">
                <input class="form-control" type="text" id="address1" name="address1" value="<?php echo $data2['address1']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php
                if(!empty($data2['address2'])) { ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address2" name="address2" value="<?php echo $data2['address2']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php }
                if(!empty($data2['address3'])) { ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="address3" name="address3" value="<?php echo $data2['address3']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
                
                <?php } ?>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="town" name="town" value="<?php echo $data2['town']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                </span>
            </div>
            </p>
            
            <p>
            <div class="input-group">
                <input class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $data2['post_code']?>" readonly >
                <span class="input-group-btn">
                    <a href="#" data-toggle="tooltip" data-placement="right" title="Post Code"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>
                        
                </span>
            </div>
            </p>
            <br>
            </form>
</div>
                        <br>
                        <br>
                        <br>
                        <br>
                        </div>
                
                               <div class="container">
                    <center>
                        <div class="btn-group">
                            
                            <?php
                            
                            $dealsheetCIDvar = "$CID-%";
                            
                            try {
                            
                            $Dealquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :dealsheetCID and uploadtype ='Dealsheet'");
                            $Dealquery->bindParam(':dealsheetCID', $dealsheetCIDvar, PDO::PARAM_STR, 12);
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
                            
                            $lgCIDvar = "$CID-%";
                            
                            if($WHICH_COMPANY=='Assura') {
                                
                            try {
                            
                            $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :file and uploadtype ='AssuraPol'");
                            $LGquery->bindParam(':file', $lgCIDvar, PDO::PARAM_STR, 12);
                            $LGquery->execute();
                            
                            while ($result=$LGquery->fetch(PDO::FETCH_ASSOC)){ 
                                
                                ?>
                            
                            <a href="../uploads/<?php echo $result['file'] ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Assura Policy</a>
                                
                                <?php
                                
                            }
                                                                                        }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }                                
                                
                                
                            }

                            ?>
                        
                        </div>
                    </center>
                    <br>
                        
                        <?php
                        
                        if($WHICH_COMPANY=='TRB Home Insurance') {   
                            try {
                                $hometable = $pdo->prepare("SELECT DISTINCT id, policy_number, insurer, type, premium, cover, status, client_name FROM home_policy WHERE client_id =:CID GROUP BY policy_number");
                                $hometable->bindParam(':CID', $CID, PDO::PARAM_INT);
                                ?>
                    
                    <table id="ClientListTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Type</th>
                                <th>Premium</th>
                                <th>Cover</th>
                                <th>Status</th>
                                <th colspan="3">Options</th>
                            </tr>
                        </thead>
                            
                            <?php
                            $hometable->execute();
                            if ($hometable->rowCount()>0) {
                                while ($result=$hometable->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $PID=$result['id'];
                                    $policy_number=$result['policy_number'];                                    
                                    $status=$result['status'];
                                    $NAME=$result['client_name'];
                                    
                                    echo '<tr>';
                                    echo "<td>".$result['client_name']."</td>";
                                    echo "<td>$policy_number</td>";
                                    echo "<td>".$result['insurer']."</td>";           
                                    echo "<td>".$result['type']."</td>";
                                    echo "<td>£".$result['premium']."</td>";
                                    echo "<td>£".$result['cover']."</td>";
                                    
                                    if ($status=='CLAWBACK'||['status']=='CLAWBACK-LAPSE' || $status =='Declined') {
                                        echo "<td><span class=\"label label-danger\">".$status."</span></td>"; }
                                        
                                        elseif ($status=='PENDING' || $status=='Live Awaiting Policy Number') {
                                            echo "<td><span class=\"label label-warning\">".$status."</span></td>";}
                                            
                                            elseif ($status=='SUBMITTED-LIVE' || $status=='Live') {
                                                echo "<td><span class=\"label label-success\">".$status."</span></td>"; }
                                                    
                                                    else {
                                                        echo "<td><span class=\"label label-default\">".$status."</span></td>"; }   
                                                        
                                                        echo "<td>
                                                            <a href='ViewPolicy.php?CID=$CID&PID=$PID&NAME=$NAME' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </a>
                                                                </td>";
                                                        
                                                        echo "<td>
                                                            <a href='EditPolicy.php?CID=$CID&PID=$PID&NAME=$NAME' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-edit'></span> </a>
                                                                    </td>";
                                                        
                                                        if (in_array($hello_name,$Level_10_Access, true)) {
                                                            
                                                            echo "<td><a href='/admin/deletepolicy.php?home&PID=$PID&CID=$CID' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </a></td>";
                                                            
                                                        }
                                                        
                                                        else {
                                                            echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
                                                            
                                                        }
                                                        
                                                        }
                                                        
                                                        }
                                                        
                                                        }
                                                        
                                                        catch (PDOException $e) {
                                                            echo 'Connection failed: ' . $e->getMessage();
                                                            
                                                        }
                                                        
                                                        ?>
                    </table>
                        <?php } ?>
                               </div>
            </div>
            
            <div id="menu1" class="tab-pane fade">
                <br>
                    
                    <?php
                    
                    if($ffcallbacks=='1') {  
                        
                        try {
                        
                        $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid from scheduled_callbacks WHERE client_id = :CID");
                        $query->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
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
                            
                            <form class="AddClient" method="POST">
                                <input type="hidden" name="keyfield" value="<?php echo $CID?>">
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
                            
                            <form class="AddClient" method="POST">
                                <input type="hidden" name="keyfield" value="<?php echo $CID;?>">
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
                    
                    <form action="../../uploadsubmit.php?Home=y&CID=<?php echo $CID;?>" method="post" enctype="multipart/form-data">
                        <label for="file">Select file...<input type="file" name="file" /></label> 
                        
                        <label for="uploadtype">
                            <div class="form-group">
                                <select style="width: 170px" class="form-control" name="uploadtype" required>
                                    <option value="">Select...</option>
                                    <option value="Recording">Call Recording</option>
                                    <option value="Happy Call">Happy Call Recording</option>
                                    <option value="HomeCloserAudit">Closer Audit</option>
                                    <option value="HomeLeadAudit">Lead Audit</option>
                                    <option value="HomeDealsheet">Home Dealsheet</option>
                                    <option value="Homenotes">Notes</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </label>
                        
                        <input type="hidden" name="CID" value="<?php echo $CID;?>">
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
                        
                        <?php if($WHICH_COMPANY=='Bluestone Protect') { ?>
                        
                        <span class="label label-primary"><?php echo $data2['title'];?> <?php echo $data2['last_name'];?> Letters/Emails</span>
                        <a class="list-group-item" href="Templates/TrustLetter.php?clientone=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?clientone=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Reinstate Letter</a>
                        <a class="list-group-item confirmation" href="php/MyAccountDetailsEmail.php?CID=<?php echo $CID;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; My Account Details Email</a>
                        <a class="list-group-item confirmation" href="php/SendKeyFacts.php?CID=<?php echo $CID;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; Closer Keyfacts Email</a>

                        <?php if (!empty($data2['first_name2'])) { ?>
                        <span class="label label-primary"><?php echo $data2['title2'];?> <?php echo $data2['last_name2'];?> Letters/Emails</span>   
                        <a class="list-group-item" href="Templates/TrustLetter.php?clienttwo=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?clienttwo=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Reinstate Letter</a>
                        <a class="list-group-item confirmation" href="php/MyAccountDetailsEmail.php?CID=<?php echo $CID;?>&email=<?php if(!empty($clienttwomail)) {echo $clienttwomail; } else { echo $clientonemail; }?>&recipient=<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; My Account Details Email</a>
                        <a class="list-group-item confirmation" href="php/SendKeyFacts.php?CID=<?php echo $CID;?>&email=<?php if(!empty($clienttwomail)) {echo $clienttwomail; } else { echo $clientonemail; }?>&recipient=<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i>&nbsp; Closer Keyfacts Email</a>

                        
                        
                        <span class="label label-primary">Joint Letters/Emails</span>
                        <a class="list-group-item" href="Templates/TrustLetter.php?joint=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Joint Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?joint=1&CID=<?php echo $CID;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>&nbsp; Joint Reinstate Letter</a>
                            <?php } ?>
                        
                        <script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to send this email? The email will be immediately sent.')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

<?php
                        }
                        
                        if($ffaudits=='1') { 
                            
                            if(!empty($closeraudit) || !empty($leadaudit)) { 
                            ?> 
                        
                        <span class="label label-primary">Audit Reports</span>                    

                        <?php if(!empty($closeraudit)) { ?>
                    <a class="list-group-item" href="/audits/closer_form_view.php?auditid=<?php echo $closeraudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; Closer Audit</a>
                        <?php } if(!empty($leadaudit)) { ?>
                    <a class="list-group-item" href="/audits/lead_gen_form_view.php?new=y&auditid=<?php echo $leadaudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>&nbsp; Lead Audit</a>

                        <?php                  } } }
                    
                
                if($ffdialler=='1') {
                  if(!empty($leadid1) || ($leadid2) || $leadid3){        ?>
                    <span class="label label-primary">Call Recordings</span>

                  <?php } if (!empty($leadid1)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 1</a>
        
                   <?php }  
                    
                            if (!empty($leadid2)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 2</a>
        
                   <?php } 
                   
                                               if (!empty($leadid3)) { ?>
                                    <a class="list-group-item" href="http://bureau.bluetelecoms.com/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i>&nbsp; Dialler Call Recording | Lead ID 3</a>
        
                   <?php } 
                    
                }
                
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
                                            case "AssuraPol":
                                            case "Dealsheet":
                                                case "HomeDealsheet":
                                                case "LGpolicy":
                                                    case "LGkeyfacts":
                                                        case "TONIC PDF":
                                                $typeimage="fa-file-pdf-o";
                                                break;
                                            case "Happy Call":
                                                case "Recording":
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
                                                case "HomeDealsheet":
                                                $uploadtype="Dealsheet";
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
                                            case "AssuraPol":
                                                $uploadtype="Assura Policy";
                                                break;
                                            default:
                                                $uploadtype;  
                                                
                                        }
                                  if($uploadtype=='TONIC RECORDING') {
                                    $newfileholder= str_replace("$CID-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$CID/$newfileholder"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                  } 
                                  
                                                                   if($uploadtype=='TONIC PDF') {
                                    $newfileholderPDF= str_replace("$CID-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$CID/$newfileholderPDF"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                 }
                                 
                                                       if($row['uploadtype']=='Other') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }
                                  
                                  if($row['uploadtype']=='RECORDING') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }
                                  
                                  
                                  
                                if($row['uploadtype']=='HomeDealsheet') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  }    
                                  
  
                                  
                               if($row['uploadtype']=='LifeCloserAudit') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                               if($row['uploadtype']=='LifeLeadAudit') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                if($row['uploadtype']=='Recording') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
                            <?php
                                  } 
                                  
                                if($row['uploadtype']=='Happy Call') {
                                ?>
                          
                    
                        <a class="list-group-item" href="../uploads/home/<?php echo "$CID/";?><?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i>&nbsp; <?php echo "$uploadtype | $file"; ?></a>
                        
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
                                <td><a href="../uploads/home/<?php echo "$CID/";?><?php echo $row['file'] ?>" target="_blank"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-search"></span> </button></a></td>
                                <td>
                                            
                                    <form name="deletefileconfirm" id="deletefileconfirm<?php echo $i?>" action="../php/DeleteUpload.php?deletefile=1" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <input type="hidden" name="file" value="<?php echo $row['file'] ?>">
                                        <input type="hidden" name="CID" value="<?php echo $CID ?>">
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

                    
                   
                </div>
            </div>
                
                <?php
                
                try {
                
                $query = $pdo->prepare("SELECT leadauditid, client_id, title, first_name, last_name, email, title2, first_name2, last_name2, dob2, email2 FROM client_details WHERE client_id =:CID");
                $query->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                $query->execute();
                $data2=$query->fetch(PDO::FETCH_ASSOC);
                
                  }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                ?>
            
            <div id="menu3" class="tab-pane fade">
                <div class="container">
                    
                    <?php
                    
                    try {
                    
                    $financial = $pdo->prepare("SELECT financial_statistics_history.*, client_policy.policy_number, client_policy.CommissionType, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM financial_statistics_history join client_policy on financial_statistics_history.Policy = client_policy.policy_number WHERE client_id=:id GROUP BY financial_statistics_history.id");
                    $financial->bindParam(':id', $CID, PDO::PARAM_INT);
                    
                    ?>
                    
                    <table  class='table table-hover table-condensed'>
                        <thead>
                            <tr>
                                <th colspan='7'>Financial Report</th>
                            </tr>
                        <th>Comm Date</th>
                        <th>Policy</th>
                        <th>Commission Type</th>
                        <th>Policy Status</th>
                        <th>Closer</th>
                        <th>Lead</th>
                        <th>Amount</th>
                    </thead>
                    
                    <?php
                    
                    $financial->execute()or die(print_r($financial->errorInfo(), true));
                    if ($financial->rowCount()>0) {
                        while ($row=$financial->fetch(PDO::FETCH_ASSOC)){
                            
                            $formattedpayment = number_format($row['payment'], 2);
                            $formatteddeduction = number_format($row['deduction'], 2);
                            $clientid = $row['policy_number'];
                            
                            echo '<tr>';
                            echo "<td>".$row['insert_date']."</td>";
                            echo "<td><a target='_blank' href='/ViewPolicy.php?&policyID=".$row['POLID']."'>".$row['Policy']."</a></td>";
                            echo "<td>".$row['CommissionType']."</td>";
                            echo "<td>".$row['policystatus']."</td>";
                            echo "<td>".$row['closer']."</td>";
                            echo "<td>".$row['lead']."</td>";
                            if (intval($row['Payment_Amount'])>0) {
                                echo "<td><span class=\"label label-success\">".$row['Payment_Amount']."</span></td>"; }
                                else if (intval($row["Payment_Amount"])<0) {
                                    echo "<td><span class=\"label label-danger\">".$row['Payment_Amount']."</span></td>"; }
                                    else {
                                        echo "<td>".$row['Payment_Amount']."</td>"; }
                                        echo "</tr>";
                                        echo "\n";
                                        
                                    }
                                    
                                    } 
                                    
                                    else {
                                        echo "<div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No Data/Information Available</div>";
                                        
                                    }
                                      }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                    ?>
                    
                    </table>
                </div>
            </div>
            
            <div id="menu8" class="tab-pane fade">
                
                  <?php if($ffcallbacks=='1') { ?>
                
                <form class="form-horizontal" action='php/AddCallback.php?setcall=y&CID=<?php echo $CID;?>' method='POST'>                
                    <fieldset>
                        
                        <div class='container'>
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='getcallback_client' name='callbackclient' class='form-control'>
                                            <option value='<?php echo $clientonefull;?>'><?php echo $clientonefull;?></option>
                                            <option value='<?php echo $clienttwofull;?>'><?php echo $clienttwofull;?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='row'>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <select id='assign' name='assign' class='form-control'>
                                            <option value='<?php echo $hello_name;?>'><?php echo $hello_name;?></option>
                                            
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
                    
                    $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid, CONCAT(callback_date, ' - ',callback_time) AS ordersort, id, client_name, notes, complete from scheduled_callbacks WHERE client_id = :CID ORDER BY ordersort DESC");
                    $query->bindParam(':CID', $CID, PDO::PARAM_STR, 12);
                    
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
                            echo "<td><a href='php/AddCallback.php?CID=$CID&callbackid=$callbackid&cb=yV' class=\"btn btn-success btn-xs\"><i class='fa fa-check'></i> Complete</a></td>";
                            echo "<td><a href='php/AddCallback.php?CID=$CID&callbackid=$callbackid&cb=nV' class=\"btn btn-warning btn-xs\"><i class='fa fa-times'></i> Incomplete</a></td>";
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
                    
                    <div class='container'>
                        <form method="post" id="clientnotessubtab" action="php/AddNotes.php?ViewClientNotes=1&CID=<?php echo $CID; ?>" class="form-horizontal">
                            <legend><h3><span class="label label-info">Add notes</span></h3></legend>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="client_name"></label>
                                <div class="col-md-4">
                                    <select id="selectbasic" name="client_name" class="form-control" required>
                                        <option value="<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?></option>
                                        <?php if(!empty($data2['title2'])) { ?>
                                        <option value="<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
  <label class="col-md-4 control-label" for="textarea"></label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="notes" name="notes" placeholder="" maxlength="2000" required></textarea>
    <center><font color="red"><i><span id="chars">2000</span> characters remaining</i></font></center>
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
   <?php     
try {

$clientnote = $pdo->prepare("select client_name, note_type, message, sent_by, date_sent from client_note where client_id = :CID ORDER BY date_sent DESC");
$clientnote->bindParam(':CID', $CID, PDO::PARAM_INT);
?><br><br>	

<table class="table table-hover">
	<thead>
	<tr>
	<th>Date</th>
	<th>User</th>
	<th>Reference</th>
	<th>Note Type</th>
	<th>Message</th>
	</tr>
	</thead>
<?php

$clientnote->execute();
if ($clientnote->rowCount()>0) {
while ($result=$clientnote->fetch(PDO::FETCH_ASSOC)){

	echo '<tr>';
	echo "<td>".$result['date_sent']."</td>";
	echo "<td>".$result['sent_by']."</td>";
	echo "<td>".$result['client_name']."</td>";
	echo "<td>".$result['note_type']."</td>";
        
        if (in_array($hello_name,$Level_3_Access, true)) {
        
	echo "<td><b>".$result['message']."</b></td>"; 
        
        }
        
                else {
        
	echo "<td><b>".$result['message']."</b></td>"; 
        
        }
	echo "</tr>";
        
}
} 



else {
	echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Client notes)</div>";
}
echo "</table>";
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
                    
                    <input type="hidden" name="keyfield" value="<?php echo $CID;?>">
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
                    
                    <input type="hidden" name="keyfield" value="<?php echo $CID;?>">
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


<script type="text/javascript" src="/resources/lib/clockpicker-gh-pages/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/resources/lib/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});

</script>
<script type="text/javascript" src="/resources/lib/clockpicker-gh-pages/assets/js/highlight.min.js"></script>
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
$( "#CLICKTOHIDECLOSER" ).click(function() {
  $( "#HIDECLOSER" ).fadeOut( "slow", function() {

  });
});
$( "#CLICKTOHIDELEAD" ).click(function() {
  $( "#HIDELEAD" ).fadeOut( "slow", function() {

  });
});
$( "#CLICKTOHIDEGLEAD" ).click(function() {
  $( "#HIDEGLEAD" ).fadeOut( "slow", function() {

  });
});
$( "#CLICKTOHIDEGCLOSER" ).click(function() {
  $( "#HIDEGCLOSER" ).fadeOut( "slow", function() {

  });
});

$( "#clickme" ).click(function() {
  $( "#HIDELGAPP,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY,#HIDELEAD,#HIDECLOSER,#HIDEGLEAD,#HIDEGCLOSER").fadeIn( "slow", function() {
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
<?php include('../php/Holidays.php'); ?>
</body>
</html>
