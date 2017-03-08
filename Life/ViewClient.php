<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$policyID= filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search= filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

if(isset($search)) {
    $likesearch = "$search-%";
    
}

if(empty($search)) {
    
    header('Location: ../CRMmain.php?AccessDenied'); die;
    
}

include('../classes/database_class.php');
include('../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }
   
    include('../includes/Access_Levels.php');

        if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php?AccessDenied'); die;
}
 $database = new Database(); 
 
                $database->query("SELECT dealsheet_id, company, leadauditid, leadauditid2, client_id, title, first_name, last_name, dob, email, phone_number, alt_number, title2, first_name2, last_name2, dob2, email2, address1, address2, address3, town, post_code, date_added, submitted_by, leadid1, leadid2, leadid3,  leadid12, leadid22, leadid32, callauditid, callauditid2 FROM client_details WHERE client_id =:CID");
                $database->bind(':CID', $search);
                $database->execute();
                $data2=$database->single();
                
                if(isset($data2['company'])) {
                    $WHICH_COMPANY=$data2['company']; 
                    
                }
                if($WHICH_COMPANY=='TRB Home Insurance') {
                    header('Location: /Home/ViewClient.php?CID='.$search); die;
                    
                }
                if(isset($data2['date_added'])) {
                    $client_date_added=$data2['date_added']; 
                    
                }
                if(isset($data2['email'])) {
                    $clientonemail=$data2['email'];
                    
                }
                if(isset($data2['email2'])) {
                    $clienttwomail=$data2['email2'];
                    
                }
                if(isset($data2['first_name'])) {
                    $clientonefull=$data2['first_name'] ." ". $data2['last_name'];
                    
                }
                if(isset($data2['first_name2'])) {
                    $clienttwofull=$data2['first_name2'] . " " . $data2['last_name2'];
                    
                }
                if(isset($data2['leadid1'])) {
                    $leadid1 = $data2['leadid1'];
                    
                }
                if(isset($data2['leadid2'])) {
                    $leadid2 = $data2['leadid2'];
                    
                }
                if(isset($data2['leadid3'])) {
                    $leadid3 = $data2['leadid3'];
                    
                }
                if(isset($data2['dealsheet_id'])) {
                    $dealsheet_id = $data2['dealsheet_id'];
                    
                }
                if(isset($data2['callauditid2'])) {
                    $WOL_CLOSER_AUDIT=$data2['callauditid2'];
                    
                }
                if(isset($data2['leadauditid2'])) {
                    $WOL_LEAD_AUDIT=$data2['leadauditid2'];
                    
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
    <link rel="stylesheet" href="../summernote-master/dist/summernote.css">
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
    <style>
        .label-purple {
  background-color: #8e44ad;
}
     .clockpicker-popover {
    z-index: 999999;
}
.ui-datepicker{ z-index:1151 !important; }
    </style>
</head>
<body>
    <?php
    include('../includes/navbar.php');
    
        if($ffanalytics=='1') {
    
    include('../php/analyticstracking.php'); 
    
    }
    
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
                
                    $auditquery = $pdo->prepare("select closer_audits.id AS CLOSER, closer_audits.grade AS CGRADE, Audit_LeadGen.id AS LEAD, Audit_LeadGen.grade AS LGRADE from closer_audits LEFT JOIN Audit_LeadGen on closer_audits.an_number=Audit_LeadGen.an_number where closer_audits.an_number=:annum");
                    $auditquery->bindParam(':annum', $an_number, PDO::PARAM_STR); 
                    $auditquery->execute();
                    $auditre=$auditquery->fetch(PDO::FETCH_ASSOC);
                    
                    $closeraudit=$auditre['CLOSER'];
                    $leadaudit=$auditre['LEAD'];
                    $CGRADE=$auditre['CGRADE'];
                    $LGRADE=$auditre['LGRADE'];
                    
                    }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                ?>
        <br>
    <div class="container">
        
<?php if(isset($WHICH_COMPANY)) {
    if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL_CUS') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>Legal & General Client</center></strong> </div>";
        
    }
        if($WHICH_COMPANY=='TRB WOL' || $WHICH_COMPANY=='CUS WOL') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>One Family Client</center></strong> </div>";
        
    }
            if($WHICH_COMPANY=='TRB Aviva' || $WHICH_COMPANY=='CUS Aviva') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>Aviva Client</center></strong> </div>";
        
    }
    if($WHICH_COMPANY=='TRB Vitality' || $WHICH_COMPANY=='CUS Vitality') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>Vitality Client</center></strong> </div>";
        
    } 
    
    if($WHICH_COMPANY=='TRB Royal London' || $WHICH_COMPANY=='CUS Royal London') {
        echo "<div class='notice notice-default' role='alert'><strong> <center>Royal London Client</center></strong> </div>";
        
    }  
}     ?>  
        
        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Client</a></li>
            <li><a data-toggle="pill" href="#menu4">Timeline <span class="badge alert-warning">
                
                <?php 
                
                $database->query("select count(note_id) AS badge from client_note where client_id ='$search'"); 
                $row=$database->single(); 
                echo htmlentities($row['badge']);
                
                ?>
                    
                    </span></a></li>
            <li><a data-toggle='modal' data-target='#CK_MODAL'>Callbacks</a></li>
            <li><a data-toggle="pill" href="#menu2">Files & Uploads <span class="badge alert-warning">
                
                <?php 

                $database->query("select count(id) AS badge from tbl_uploads where file like '$search%'"); 
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

                        if (in_array($hello_name,$Level_3_Access, true)) { ?>
                        <li><a class="list-group-item" href="EditClient.php?search=<?php echo $search?>&life"><i class="fa fa-pencil-square-o fa-fw"></i> &nbsp; Edit Client</a></li>
                        <?php } ?>
                        <?php 
                        
                        if (in_array($hello_name,$Level_10_Access, true)) { ?>
                        <li><a class="list-group-item" href="/admin/deleteclient.php?search=<?php echo $search?>&life"><i class="fa fa-trash fa-fw"></i> &nbsp; Delete Client</a></li>
                        <?php } ?>

                        
                        <li><a class="list-group-item" href="AddPolicy.php?EXECUTE=1&search=<?php echo $search?>"><i class="fa fa-plus fa-fw"></i> Add Policy</a></li>
                    </div>
                </ul>
            </li>
            <li id='SHOW_ALERTS'><a data-toggle="pill"><i class='fa fa-eye-slash fa-fw'></i> Show Alerts</a></li>
            <li id='HIDE_ALERTS'><a data-toggle="pill"><i class='fa fa-eye-slash fa-fw'></i> Hide Alerts</a></li>
            
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
                            
                            $search_file_var = "$search-%";
                            
                            if(empty($dealsheet_id)) {
                            
                            try {
                            
                            $Dealquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Dealsheet'");
                            $Dealquery->bindParam(':search', $search_file_var, PDO::PARAM_INT);
                            $Dealquery->execute();
                            
                            while ($result=$Dealquery->fetch(PDO::FETCH_ASSOC)){
                               $DSFILE=$result['file'];
                            if(file_exists("../uploads/$DSFILE")){ ?>
                            <a href="../uploads/<?php echo $DSFILE; ?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Dealsheet</a>
                            <?php } if(file_exists("../uploads/life/$search/$DSFILE")){ ?>
                            <a href="../uploads/life/<?php echo $search ; ?>/<?php echo $DSFILE; ?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Dealsheet</a>
                                <?php
                                }
                                }    
                                
                            }
                            
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                            }else { ?>
                            <a href="LifeDealSheet.php?REF=<?php echo $dealsheet_id; ?>&query=CompletedADL" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> ADL Dealsheet</a>
    
                           <?php }          
                            if($WHICH_COMPANY=='Assura') {
                                
                            try {
                            
                            $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :file and uploadtype ='AssuraPol'");
                            $LGquery->bindParam(':file', $search_file_var, PDO::PARAM_STR, 12);
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
                            
                            if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL_CUS') {
                            
                            try {
                            
                            $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='LGpolicy'");
                            $LGquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                            $LGquery->execute();
                            
                            while ($result=$LGquery->fetch(PDO::FETCH_ASSOC)){ 
                                $LGPOLFILE=$result['file'];
                            if(file_exists("../uploads/$LGPOLFILE")){ ?>
                            <a href="../uploads/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy</a>
                                <?php } else {?>
                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy</a>
                                <?php
                                
                                }
                                
                                }
                                
                                }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                            
                try {
                
                            $LGKeyfactsquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='LGkeyfacts'");
                            $LGKeyfactsquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                            $LGKeyfactsquery->execute();
                            
                            while ($result=$LGKeyfactsquery->fetch(PDO::FETCH_ASSOC)){ 
                            $LGFILE=$result['file'];
                            if(file_exists("../uploads/$LGFILE")){ ?>
                            <a href="../uploads/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                <?php } else {?>
                            <a href="../uploads/life/<?php echo $search ; ?>/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                <?php
                                }    
                                
                                }
                                
                                }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                
                            }
                            
                            if($WHICH_COMPANY=='TRB Vitality') {
                            
                            try {
                            
                            $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Vitalitypolicy'");
                            $LGquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                            $LGquery->execute();
                            
                            while ($result=$LGquery->fetch(PDO::FETCH_ASSOC)){ 
                                $LGPOLFILE=$result['file'];
                            if(file_exists("../uploads/$LGPOLFILE")){ ?>
                            <a href="../uploads/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Policy</a>
                                <?php } else {?>
                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Policy</a>
                                <?php
                                
                                }
                                
                                }
                                
                                }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                            
                try {
                
                            $LGKeyfactsquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Vitalitykeyfacts'");
                            $LGKeyfactsquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                            $LGKeyfactsquery->execute();
                            
                            while ($result=$LGKeyfactsquery->fetch(PDO::FETCH_ASSOC)){ 
                            $LGFILE=$result['file'];
                            if(file_exists("../uploads/$LGFILE")){ ?>
                            <a href="../uploads/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Keyfacts</a> 
                                <?php } else {?>
                            <a href="../uploads/life/<?php echo $search ; ?>/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Keyfacts</a> 
                                <?php
                                }    
                                
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
                        
                        if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='TRB Vitality' || $WHICH_COMPANY=='TRB WOL' || $WHICH_COMPANY=='TRB Royal London' || $WHICH_COMPANY=='TRB Aviva' || $WHICH_COMPANY=='ADL_CUS' || $WHICH_COMPANY=='CUS Vitality' || $WHICH_COMPANY=='CUS WOL' || $WHICH_COMPANY=='CUS Royal London' || $WHICH_COMPANY=='CUS Aviva') {
                        
                        try {
                        
                        $hometable = $pdo->prepare("SELECT DISTINCT client_policy.policy_number, client_policy.insurer, financial_statistics_history.payment_amount, ews_data.ews_status_status AS ADLSTATUS, client_policy.id, client_policy.polterm, ews_data.warning, client_policy.closer, client_policy.covera, client_policy.lead, client_policy.client_id, client_policy.soj, client_policy.drip, client_policy.client_name, client_policy.sale_date, client_policy.application_number, client_policy.premium, client_policy.type, client_policy.insurer, client_policy.submitted_by, client_policy.comm_term, client_policy.CommissionType, client_policy.PolicyStatus, client_policy.submitted_date, client_policy.commission FROM client_policy LEFT JOIN financial_statistics_history ON client_policy.policy_number = financial_statistics_history.Policy LEFT JOIN ews_data ON client_policy.policy_number = ews_data.policy_number WHERE client_policy.client_id =:CID GROUP BY client_policy.policy_number");
                        $hometable->bindParam(':CID', $search, PDO::PARAM_INT);
                        $hometable->execute();
                            if ($hometable->rowCount()>0) { ?>
                    <table id="ClientListTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>AN</th>
                                <th>Insurer</th>
                                <th>Type</th>
                                <th>Comm Type</th>
                                <th>Term</th>
                                <th>Premium</th>
                                <th>Cover</th>
                                <th>Status</th>
                                <th>EWS</th>
                                <th>Financial</th>
                                <th colspan="4">Options</th>
                            </tr>
                        </thead> 
                            
                            <?php 
                            
                            while ($result=$hometable->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $poldid=$result['id'];
                                    $anref=$result['application_number'];
                                    $polref=$result['policy_number'];
                                    $polcap[]=$result['id'];
                                    $polname=$result['client_name'];
                                    
                                    $ADLSTATUS=$result['ADLSTATUS'];
                                    $EWSSTATUS=$result['warning'];
                                    
                                    echo '<tr>';
                                    echo "<td>$polname</td>";
                                    if(empty($polref)) {
                                      echo "<td>TBC</td>";  
                                    }
                                    else {
                                    echo "<td><form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'><input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value='$polref'><input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='B'><input type='hidden' name='searchCriteria.includeLife' value='true' ><button type='submit' value='Search' name='command' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button></form></td>";
                                    }
                                    echo "<td><a href='//www10.landg.com/CNBSWeb/administerApplicationDialogue/administerApplicationPage.htm?applicationId=$anref' target='_blank' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $anref</a></td>";
                                    
                                    if($result['insurer']=='Legal and General') {
                                        
                                     echo "<td>L&G</td>";    
                                    }
                                    
                                    else {
                                    echo "<td>".$result['insurer']."</td>";           
                                    }
                                    
                                    echo "<td>".$result['type']."</td>";
                                    echo "<td>".$result['CommissionType']."</td>";
                                    echo "<td>".$result['polterm']."</td>";
                                    echo "<td>£".$result['premium']."</td>";
                                    echo "<td>£".$result['covera']."</td>";
                                    
                                    if ($result['PolicyStatus']=='CLAWBACK'||['PolicyStatus']=='CLAWBACK-LAPSE' || $result['PolicyStatus'] =='Declined') {
                                        echo "<td><span class=\"label label-danger\">".$result['PolicyStatus']."</span></td>"; }
                                        
                                        elseif ($result['PolicyStatus']=='PENDING' || $result['PolicyStatus']=='Live Awaiting Policy Number' || $result['PolicyStatus']=='Awaiting Policy Number') {
                                            echo "<td><span class=\"label label-warning\">".$result['PolicyStatus']."</span></td>";}
                                            
                                            elseif ($result['PolicyStatus']=='SUBMITTED-LIVE' || $result['PolicyStatus']=='Live') {
                                                echo "<td><span class=\"label label-success\">".$result['PolicyStatus']."</span></td>"; }
                                                    
                                                    else {
                                                        echo "<td><span class=\"label label-default\">".$result['PolicyStatus']."</span></td>"; }     
                                                        
                                    if($ADLSTATUS != $EWSSTATUS) {
                                        switch ($EWSSTATUS) {
                                            case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$EWSSTATUS</span></td>";
                                                break;
                                                case "WILL CANCEL":
                                                echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                                                break;
                                            case "REDRAWN":
                                                case "WILL REDRAW":
                                                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                                                    break;
                                                case "CANCELLED":
                                                    case "CFO":
                                                        case "LAPSED":
                                                            case "CANCELLED DD":
                                                                case "BOUNCED DD":
                                                                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                                                                    break;
                                                                default:
                                                                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
                                                                    
                                        }
                                        
                                        }
                                        
                                        else {
                                            
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$ADLSTATUS</span></td>";
                                                break;
                                                    case "WILL CANCEL":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "CANCELLED":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                            
                                            }
                                            
                                            if(($result['payment_amount'])) {
                                                echo "<td><span class='label label-warning'>On Financial</span> </td>";
                                                
                                            }
                                            
                                            else {
                                               
                                                echo "<td> </td>";
                                                
                                            }
                                            
                                            echo "<td><a href='ViewPolicy.php?policyID=$poldid&search=$search' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> </a></td>";
                                            echo "<td><a href='EditPolicy.php?id=$poldid&search=$search&name=$polname' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> </a></td>";
                                                                                    
                                                                                    if($companynamere=='The Review Bureau' || $companyname=='ADL_CUS') {
                                                                                        if (in_array($hello_name,$Level_10_Access, true)) {
                                                                                    
                                                                                    
                                                                                    echo "<td>
                                                                                        <form method='POST' action='/admin/deletepolicy.php?DeleteLifePolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$poldid'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";
                                                                                    }
                                                                                    }
                                                                                    
                                                                                    
                                                                                    if(!empty($EWSSTATUS))  {
                                                                                    echo "<td><a href='Reports/EWSPolicySearch.php?EWSView=1&search=$search&policy_number=$polref' class='btn btn-success btn-xs'><i class='fa fa-warning'></i> </a></td>";
                                                                                    }
                                                                                    echo "</tr>";
                                                                                    
                                                                                } ?>
                        
                              </table>   
                                                                                
                                                                            <?php    } 
                                                                                
                                                                                else {
                                                                                    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No policies have been added to this client.</div>";
                                                                                    
                                                                                }
                                                                                                                                            }
                 catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                    
                }
                                                                                ?>
              
                    
                        <?php } 

                        if($WHICH_COMPANY=='Assura') {
                        
                        try {
                        
                        $hometable = $pdo->prepare("SELECT DISTINCT client_policy.policy_number, client_policy.insurer, financial_statistics_history.payment_amount, ews_data.ews_status_status AS ADLSTATUS, client_policy.id, client_policy.polterm, ews_data.warning, client_policy.closer, client_policy.covera, client_policy.lead, client_policy.client_id, client_policy.soj, client_policy.drip, client_policy.client_name, client_policy.sale_date, client_policy.application_number, client_policy.premium, client_policy.type, client_policy.insurer, client_policy.submitted_by, client_policy.comm_term, client_policy.CommissionType, client_policy.PolicyStatus, client_policy.submitted_date, client_policy.commission FROM client_policy LEFT JOIN financial_statistics_history ON client_policy.policy_number = financial_statistics_history.Policy LEFT JOIN ews_data ON client_policy.policy_number = ews_data.policy_number WHERE client_policy.client_id =:CID GROUP BY client_policy.policy_number");
                        $hometable->bindParam(':CID', $search, PDO::PARAM_INT);
                        
                        ?>
                    
                    <table id="ClientListTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>AN</th>
                                <th>Insurer</th>
                                <th>Type</th>
                                <th>Comm Type</th>
                                <th>Term</th>
                                <th>Premium</th>
                                <th>Cover</th>
                                <th>Policy Status</th>
                                <th>EWS</th>
                                <th>Financial</th>
                                <th colspan="4">Options</th>
                            </tr>
                        </thead>
                            
                            <?php
                            
                            $hometable->execute();
                            if ($hometable->rowCount()>0) {
                                while ($result=$hometable->fetch(PDO::FETCH_ASSOC)){
                                    
                                    $poldid=$result['id'];
                                    $anref=$result['application_number'];
                                    $polref=$result['policy_number'];
                                    $polcap[]=$result['id'];
                                    
                                    $ADLSTATUS=$result['ADLSTATUS'];
                                    $EWSSTATUS=$result['warning'];
                                    
                                    echo '<tr>';
                                    echo "<td>".$result['client_name']."</td>";
                                    if(empty($polref)) {
                                      echo "<td>TBC</td>";  
                                    }
                                    else {
                                    echo "
<td>
<form target='_blank' action='https://assuraprotectlifeaffinity.instanda.com/Public/UserDefinedSearch?searchId=16&packageId=3215' method='post'>

<input id='345' type='hidden' name='SearchParams[2].ParameterValue' value='$polref'>
<input id='SearchParams_2__ParameterName' name='SearchParams[2].ParameterName' value='PolicyNumber' type='hidden'>    

<button type='submit' value='Search' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $polref</button>
</form>
</td>";
                                    }
                                    echo "<td><a href='//www10.landg.com/CNBSWeb/administerApplicationDialogue/administerApplicationPage.htm?applicationId=$anref' target='_blank' class='btn btn-default btn-sm'><i class='fa fa-search'></i> $anref</a></td>";

                                    echo "<td>".$result['insurer']."</td>";                                            
                                    echo "<td>".$result['type']."</td>";
                                    echo "<td>".$result['CommissionType']."</td>";
                                    echo "<td>".$result['polterm']."</td>";
                                    echo "<td>£".$result['premium']."</td>";
                                    echo "<td>£".$result['covera']."</td>";
                                    
                                    if ($result['PolicyStatus']=='CLAWBACK'||['PolicyStatus']=='CLAWBACK-LAPSE' || $result['PolicyStatus'] =='Declined') {
                                        echo "<td><span class=\"label label-danger\">".$result['PolicyStatus']."</span></td>"; }
                                        
                                        elseif ($result['PolicyStatus']=='PENDING' || $result['PolicyStatus']=='Live Awaiting Policy Number') {
                                            echo "<td><span class=\"label label-warning\">".$result['PolicyStatus']."</span></td>";}
                                            
                                            elseif ($result['PolicyStatus']=='SUBMITTED-LIVE' || $result['PolicyStatus']=='Live') {
                                                echo "<td><span class=\"label label-success\">".$result['PolicyStatus']."</span></td>"; }
                                                    
                                                    else {
                                                        echo "<td><span class=\"label label-default\">".$result['PolicyStatus']."</span></td>"; }     
                                                        
                                    if($ADLSTATUS != $EWSSTATUS) {
                                        switch ($EWSSTATUS) {
                                            case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$EWSSTATUS</span></td>";
                                                break;
                                                case "WILL CANCEL":
                                                echo "<td><span class='label label-warning'>$EWSSTATUS</span></td>";
                                                break;
                                            case "REDRAWN":
                                                case "WILL REDRAW":
                                                    echo "<td><span class='label label-purple'>$EWSSTATUS</td>";
                                                    break;
                                                case "CANCELLED":
                                                    case "CFO":
                                                        case "LAPSED":
                                                            case "CANCELLED DD":
                                                                case "BOUNCED DD":
                                                                    echo "<td><span class='label label-danger'>$EWSSTATUS</td>";
                                                                    break;
                                                                default:
                                                                    echo "<td><span class='label label-info'>$EWSSTATUS</td>";
                                                                    
                                        }
                                        
                                        }
                                        
                                        else {
                                            
                                            switch ($ADLSTATUS) {
                                                case "RE-INSTATED":
                                                echo "<td><span class='label label-success'>$ADLSTATUS</span></td>";
                                                break;
                                                    case "WILL CANCEL":
                                                    echo "<td><span class='label label-warning'>$ADLSTATUS</span></td>";
                                                    break;
                                                case "REDRAWN":
                                                    case "WILL REDRAW":
                                                        echo "<td><span class='label label-purple'>$ADLSTATUS</td>";
                                                        break;
                                                    case "CANCELLED":
                                                        case "CFO":
                                                            case "LAPSED":
                                                                case "CANCELLED DD":
                                                                    case "BOUNCED DD":
                                                                        echo "<td><span class='label label-danger'>$ADLSTATUS</td>";
                                                                        break;
                                                                    default:
                                                                        echo "<td><span class='label label-info'>$ADLSTATUS</td>";
                                                                        
                                            }
                                            
                                            }
                                            
                                            if(($result['payment_amount'])) {
                                                echo "<td><span class='label label-warning'>On Financial</span> </td>";
                                                
                                            }
                                            
                                            else {
                                               
                                                echo "<td> </td>";
                                                
                                            }

                                                                                    echo "<td>
                                                                                        <form method='GET' action='ViewPolicy.php'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$result[id]' >
                                                                                            <button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
                                                                                            </form>
                                                                                            </td>";
                                                                                    
                                                                                    echo "<td>
                                                                                        <form method='POST' action='EditPolicy.php'>    
                                                                                        <button type='submit' name='search' value='".$search."'  class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
<input type='hidden' id='client_name' name='client_name' value='".$result['client_name']."' >                                                                                        
<input type='hidden' id='id' name='id' value='".$result['id']."' >
                                                                                            </form>
                                                                                            </td>";
                                                                                    
                                                                                    if($companynamere=='The Review Bureau' || $companyname=='ADL_CUS') {
                                                                                        if (in_array($hello_name,$Level_10_Access, true)) {
                                                                                    
                                                                                    
                                                                                    echo "<td>
                                                                                        <form method='POST' action='/admin/deletepolicy.php?DeleteLifePolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$result[id]'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";
                                                                                    }
                                                                                    }
                                                                                    
                                                                                    if($companynamere!='The Review Bureau' || $companyname!='ADL_CUS') {
                                                                                        
                                                                                     echo "<td>
                                                                                        <form method='POST' action='/admin/deletepolicy.php?DeleteLifePolicy=1'>
                                                                                        <input type='hidden' id='policyID' name='policyID' value='$result[id]'>
                                                                                            <button type='submit' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span> </button>
                                                                                            </form>
                                                                                            </td>";   
                                                                                        
                                                                                    }
                                                                                    
                                                                                    
                                                                                    if(!empty($EWSSTATUS))  {
                                                                                    echo "<td><a href='Reports/EWSPolicySearch.php?EWSView=1&search=$search&policy_number=$polref' class='btn btn-success btn-xs'><i class='fa fa-warning'></i> </a></td>";
                                                                                    }
                                                                                    echo "</tr>";
                                                                                    
                                                                                }
                                                                                
                                                                                } 
                                                                                
                                                                                else {
                                                                                    echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Policy)</div>";
                                                                                    
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
                        
                        $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid from scheduled_callbacks WHERE client_id =:CID");
                        $query->bindParam(':CID', $search, PDO::PARAM_INT);
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
                                            if(isset($WHICH_COMPANY)) {
                                                if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL_CUS') {
                                                    $SMS_INSURER='Legal and General';
                                                    
                                                }
                                                if($WHICH_COMPANY=='TRB WOL' || $WHICH_COMPANY=='CUS WOL') {
                                                    $SMS_INSURER='One Family';
                                                    
                                                }
                                                if($WHICH_COMPANY=='TRB Vitality' || $WHICH_COMPANY=='CUS Vitality') {
                                                    $SMS_INSURER='Vitality';       
                                                    
                                                } 
                                                if($WHICH_COMPANY=='TRB Royal London' || $WHICH_COMPANY=='CUS Royal London') {
                                                    $SMS_INSURER='Royal London';
                                                    
                                                }  
                                                
                                                }   
                                            
                                            try {
                                            
                                            $SMSquery = $pdo->prepare("SELECT title from sms_templates WHERE insurer =:insurer OR insurer='NA'");
                                            $SMSquery->bindParam(':insurer', $SMS_INSURER, PDO::PARAM_INT);
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
                                
                                <?php } else { ?>
                            
                            <div class="alert alert-info"><strong>Info!</strong> SMS feature not enabled.</div>
                                <?php } ?>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
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
                                
                                <?php } else { ?>
                            
                            <div class="alert alert-info"><strong>Info!</strong> SMS feature not enabled.</div>
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
                                        
                        <?php
                        
                                                $fileuploaded= filter_input(INPUT_GET, 'fileuploaded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploaded)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-upload fa-lg\"></i> Success:</strong> $uploadtypeuploaded uploaded!</div>");
                                                    
                                                }
                                                
                                                $fileuploadedfail= filter_input(INPUT_GET, 'fileuploadedfail', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($fileuploadedfail)){
                                                    $uploadtypeuploaded= filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> $uploadtypeuploaded <b>upload failed!</b></div>");
                                                    
                                                }  
                        ?>
                <div class="container">
                    
                    <form action="../../uploadsubmit.php?life=y&life=y" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="uploadclientid" value="<?php echo $search;?>">
                        <label for="file">Select file...<input type="file" name="file" /></label> 
                        
                        <label for="uploadtype">
                            <div class="form-group">
                                <select style="width: 170px" class="form-control" name="uploadtype" required>
                                    <option value="">Select...</option>
                                    <option value="Closer Call Recording">Closer Call Recording</option>
                                    <option value="Agent Call Recording">Agent Call Recording</option>
                                    <option value="Admin Call Recording">Admin Call Recording</option>
                                    <option value="Recording">Call Recording</option>
                                    <option value="Happy Call">Happy Call Recording</option>
                                    <option value="LifeCloserAudit">Closer Audit</option>
                                    <option value="LifeLeadAudit">Lead Audit</option>
                                    <option value="Dealsheet">Life Dealsheet</option>
                                    <?php if($WHICH_COMPANY=='TRB Vitality' || $WHICH_COMPANY=='CUS Vitality') { ?>
                                    <option value="Vitalitypolicy">Vitality App</option>
                                    <option value="Vitalitykeyfacts">Vitality Keyfacts</option>
                                    <?php } elseif($WHICH_COMPANY=='TRB Royal London' || $WHICH_COMPANY=='CUS Royal London') { ?>
                                    <option value="RLpolicy">Royal London App</option>
                                    <option value="RLkeyfacts">Royal London Keyfacts</option>
                                    <?php }
                                    else { ?>
                                    <option value="LGpolicy">L&G App</option>
                                    <option value="LGkeyfacts">L&G Keyfacts</option>
                                    <?php } if($WHICH_COMPANY=='Assura') { ?>
                                    <option value="AssuraPol">Assura Policy</option>
                                    <?php } ?>
                                    <option value="lifenotes">Notes</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </label>
                        
                        <input type="hidden" name="search" value="<?php echo $search;?>">
                        <button type="submit" class="btn btn-success" name="btn-upload"><span class="glyphicon glyphicon-arrow-up"> </span></button>
                    </form>
                    <br /><br />
                    
                    <div class="list-group">
                        
                        <?php if($WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL_CUS') { ?>

                        <span class="label label-primary"><?php echo $data2['title'];?> <?php echo $data2['last_name'];?> Letters/Emails</span>
                        <a class="list-group-item" href="Templates/PostPackLetter.php?clientone=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Post Pack Letter</a>
                        <a class="list-group-item" href="Templates/TrustLetter.php?clientone=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?clientone=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Reinstate Letter</a>
                        <a class="list-group-item confirmation" href="php/SendAnyQueriesCallUs.php?search=<?php echo $search;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Any Queries Call Us</a>
                        <a class="list-group-item confirmation" href="php/MyAccountDetailsEmail.php?search=<?php echo $search;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; My Account Details Email</a>
                        <?php if($ffkeyfactsemail=='1'){ ?>
                        <a class="list-group-item confirmation" href="php/SendKeyFacts.php?search=<?php echo $search;?>&email=<?php echo $clientonemail;?>&recipient=<?php echo $data2['title'];?> <?php echo $data2['first_name'];?> <?php echo $data2['last_name'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Closer Keyfacts Email</a>
                        <?php } ?>
                        <?php if (!empty($data2['first_name2'])) { ?>
                        <span class="label label-primary"><?php echo $data2['title2'];?> <?php echo $data2['last_name2'];?> Letters/Emails</span> 
                        <a class="list-group-item" href="Templates/PostPackLetter.php?clienttwo=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Post Pack Letter</a>
                        <a class="list-group-item" href="Templates/TrustLetter.php?clienttwo=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?clienttwo=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Reinstate Letter</a>
                        <a class="list-group-item confirmation" href="php/SendAnyQueriesCallUs.php?search=<?php echo $search;?>&email=<?php if(!empty($clienttwomail)) {echo $clienttwomail; } else { echo $clientonemail; }?>&recipient=<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Any Queries Call Us</a>
                        <a class="list-group-item confirmation" href="php/MyAccountDetailsEmail.php?search=<?php echo $search;?>&email=<?php if(!empty($clienttwomail)) {echo $clienttwomail; } else { echo $clientonemail; }?>&recipient=<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; My Account Details Email</a>
                        <?php if($ffkeyfactsemail=='1'){ ?>
                        <a class="list-group-item confirmation" href="php/SendKeyFacts.php?search=<?php echo $search;?>&email=<?php if(!empty($clienttwomail)) {echo $clienttwomail; } else { echo $clientonemail; }?>&recipient=<?php echo $data2['title2'];?> <?php echo $data2['first_name2'];?> <?php echo $data2['last_name2'];?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Closer Keyfacts Email</a>
                        <?php } ?>
                        
                        
                        <span class="label label-primary">Joint Letters/Emails</span>
                        <a class="list-group-item" href="Templates/PostPackLetter.php?joint=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Post Pack Letter</a>
                        <a class="list-group-item" href="Templates/TrustLetter.php?joint=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Trust Letter</a>
                        <a class="list-group-item" href="Templates/ReinstateLetter.php?joint=1&search=<?php echo $search;?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Reinstate Letter</a>
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
                    <a class="list-group-item" href="/audits/closer_form_view.php?auditid=<?php echo $closeraudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i> &nbsp; Closer Audit</a>
                        <?php } if(!empty($leadaudit)) { ?>
                    <a class="list-group-item" href="/audits/lead_gen_form_view.php?new=y&auditid=<?php echo $leadaudit;?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i> &nbsp; Lead Audit</a>

                        <?php                  } } }
                 
                if($ffdialler=='1') {
                    
                $database->query("SELECT url from connex_accounts");
                $database->execute();
                $CONNEX_URL_QRY=$database->single();
                
                if(isset($CONNEX_URL_QRY['url'])) {
                    $CONNEX_URL=$CONNEX_URL_QRY['url']; 
                    
                } 
                
                $database->query("SELECT url from vicidial_accounts WHERE servertype='Database'");
                $database->execute();
                $VICIDIAL_URL_QRY=$database->single();
                
                if(isset($VICIDIAL_URL_QRY['url'])) {
                    $VICIDIAL_URL=$VICIDIAL_URL_QRY['url']; 
                    
                }       
                    
                    
                    
                  if(!empty($leadid1) || ($leadid2) || $leadid3){        ?>
                    <span class="label label-primary">Call Recordings</span>

                  <?php } if (!empty($leadid1)) {
                      if($client_date_added >= "2016-11-09 10:00:00") { ?>
                    <a class="list-group-item" href="http://<?php if(isset($VICIDIAL_URL)) { echo $VICIDIAL_URL; } ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Bluetelecoms Call Recording | Lead ID 1</a>
                    <a class="list-group-item" href="http://<?php if(isset($CONNEX_URL)) { echo $CONNEX_URL; } ?>/Admin/data/search/edit/?id=<?php echo $leadid1;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Connex Call Recording | Lead ID 1</a>
   
                     <?php }
                      else { ?>
                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 1</a>
                        <?php }  }
                        if (!empty($leadid2)) {
                            if($client_date_added >= "2016-11-09 10:00:00") { ?>
                    <a class="list-group-item" href="http://<?php if(isset($VICIDIAL_URL)) { echo $VICIDIAL_URL; } ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 2</a>
                        <?php }
                      else { ?>
                                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 2</a>
        
                            <?php }  }
                   
                                               if (!empty($leadid3)) { 
                                                   if($client_date_added >= "2016-11-09 10:00:00") { ?>
                                    <a class="list-group-item" href="http://<?php if(isset($VICIDIAL_URL)) { echo $VICIDIAL_URL; } ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 3</a>

                     <?php }
                      else { ?>
                                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3;?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 3</a>
        
                                               <?php } }
                    
                }
                
                     try {
                                
                                $queryup = $pdo->prepare("SELECT file, uploadtype FROM tbl_uploads WHERE file like :file");
                                $queryup->bindParam(':file', $likesearch, PDO::PARAM_INT);
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
                                                case "LGpolicy":
                                                    case "LGkeyfacts":
                                                        case "TONIC PDF":
                                                $typeimage="fa-file-pdf-o";
                                                break;
                                            case "Happy Call":
                                                case "Recording":
                                                    case "LGkeyfacts":
                                                        case "TONIC RECORDING":
                                                            case "Closer Call Recording":
                                                                case "Agent Call Recording":
                                                                    case "Admin Call Recording":
                                                                        $typeimage="fa-headphones";
                                                break;
                                            case "Other":
                                                case "Old Other":
                                                $typeimage="fa-file-text-o";
                                                break;
                                            case "lifenotes":
                                                $typeimage="fa-file-text-o";
                                                break;
                                            case "TONIC Acount Updates";
                                                $typeimage="fa-check-square-o";
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
                                            case "AssuraPol":
                                                $uploadtype="Assura Policy";
                                                break;
                                            default:
                                                $uploadtype;  
                                                
                                        }
                                  if($uploadtype=='TONIC RECORDING') {
                                    $newfileholder= str_replace("$search-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholder"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                  }
                                  
                                  if($uploadtype=='TONIC PDF') {
                                      $newfileholderPDF= str_replace("$search-","","$file"); //remove quote
                                      ?>
                                
                                <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholderPDF"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                <?php
                                 }
                                 
                                 if($row['uploadtype']=='Other') {
                                     ?>
                                <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php
                                }
                                
                                if($row['uploadtype']=='Old Other') {
                                     ?>
                                <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php
                                }                               
                                  
                                  if($row['uploadtype']=='RECORDING' || $row['uploadtype']=='Closer Call Recording' || $row['uploadtype']=='Agent Call Recording' || $row['uploadtype']=='Admin Call Recording') {
                                      if(file_exists("../uploads/$file")){ ?>
                                <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php } else {?>
                                <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php
                                  } }
                                  
                                                                    if($row['uploadtype']=='lifenotes') {
                                      if(file_exists("../uploads/$file")){ ?>
                                <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php } else {?>
                                <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                    <?php
                                  } }
                                  
                                  
                                if($row['uploadtype']=='Dealsheet') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  }    
                                  
                                if($row['uploadtype']=='LGkeyfacts') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  } 
                                  if($row['uploadtype']=='LGpolicy') {
                                      if(!file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php  } else {?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } 
                                   }
                                  
                                 if($row['uploadtype']=='L&G APP') {
                                if(!file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php  } else {?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } 
                                  }    

                                 if($row['uploadtype']=='AssuraPol') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  }  
                                  
                               if($row['uploadtype']=='LifeCloserAudit') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  } 
                                  
                               if($row['uploadtype']=='LifeLeadAudit') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  } 
                                  
                                if($row['uploadtype']=='Recording') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
                                  } 
                                  
                                if($row['uploadtype']=='Happy Call') {
                            if(file_exists("../uploads/$file")){ ?>
                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                            <?php } else {?>
                        <a class="list-group-item" href="../uploads/life/<?php echo $search ; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                <?php
                                }
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
                                
                                $query = $pdo->prepare("SELECT file, uploadtype, id FROM tbl_uploads WHERE file like :file");
                                $query->bindParam(':file', $likesearch, PDO::PARAM_STR, 150);
                                $query->execute();  
                                
                                $i=0;
                                if ($query->rowCount()>0) {
                                    while ($row=$query->fetch(PDO::FETCH_ASSOC)){
                                        $i++;
                                        $FILElocation=$row['file'];
                                        ?>
                            
                            <tr>
                                <td><?php echo $row['file'] ?></td>
                                <td><?php echo $row['uploadtype'] ?></td>
                                <td><a href="<?php if(file_exists("../uploads/$FILElocation")){ echo "../uploads/$FILElocation"; } else { echo "../uploads/life/$search/$FILElocation" ; }?>" target="_blank"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-search"></span> </button></a></td>
                                <td>
                                            
                                    <form name="deletefileconfirm" id="deletefileconfirm<?php echo $i?>" action="../php/DeleteUpload.php?deletefile=1" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="file" value="<?php echo $FILElocation; ?>">
                                        <input type="hidden" name="search" value="<?php echo $search; ?>">
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
                    
                 }
                 
                 }
                 ?>
                    </table>
                </div>
            </div>
                
                <?php
                
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
            
            <div id="menu3" class="tab-pane fade">
                <div class="container">
                    
                    <?php
                    
                    try {
                    
                    $financial = $pdo->prepare("SELECT financial_statistics_history.*, client_policy.policy_number, client_policy.CommissionType, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM financial_statistics_history join client_policy on financial_statistics_history.Policy = client_policy.policy_number WHERE client_id=:id GROUP BY financial_statistics_history.id");
                    $financial->bindParam(':id', $search, PDO::PARAM_INT);
                    
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
                            echo "<td><a href='ViewPolicy.php?policyID=$poldid&search=$search'>".$row['Policy']."</a></td>";
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
            
            <div id="menu4" class="tab-pane fade">

                <?php
                
                                                $clientnotesadded= filter_input(INPUT_GET, 'clientnotesadded', FILTER_SANITIZE_SPECIAL_CHARS);
                                                if(isset($clientnotesadded)){
                                                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client notes added!</div>");
                                                    
                                                }
                                                
            $TaskSelect= filter_input(INPUT_GET, 'TaskSelect', FILTER_SANITIZE_SPECIAL_CHARS);
                 
                  if(isset($TaskSelect)){                   
                if ($TaskSelect =='CYD') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> CYD Task Updated!</div>";
                    
                }
                
                 if ($TaskSelect =='5 day') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 5 Day Task Updated!</div>";
                    
                }
                
                if ($TaskSelect =='24 48') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 24-48 Day Task Updated!</div>";
                    
                }
                
                  if ($TaskSelect =='18 day') {
                    
                    echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 18 Day Task Updated!</div>";
                    
                }
                 
                }
                
        if($client_date_added >= "2016-06-19" && $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL_CUS') {

        $database->query("select Task, Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks where client_id=:cid");
        $database->bind(':cid', $search); 
        $database->execute();
        $result=$database->single();
        
        $HappyPol=$result['HappyPol'];
        $DocsArrived=$result['DocsArrived'];
        $CYDReturned=$result['CYDReturned'];
        $RemindDD=$result['RemindDD'];
        $PitchTPS=$result['PitchTPS'];
        $PitchTrust=$result['PitchTrust'];
        $Upsells=$result['Upsells'];         
        $Taskoption=$result['Task']; 
    ?>
                <center>
                    <br><br>
                    
                    <div class="btn-group">
                        <button data-toggle="collapse" data-target="#HappyPol" class="<?php if(empty($HappyPol)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Happy with Policy <br><?php echo $HappyPol;?></button>                 
                 <button data-toggle="collapse" data-target="#DocsArrived" class="<?php if(empty($DocsArrived)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Docs Emailed? <br><?php echo $DocsArrived;?></button>
                 <button data-toggle="collapse" data-target="#CYDReturned" class="<?php if(empty($CYDReturned)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">CYD Returned? <br><?php echo $CYDReturned;?></button>
                 <button data-toggle="collapse" data-target="#RemindDD" class="<?php if(empty($RemindDD)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Remind/Cancel Old/New DD <br><?php echo $RemindDD;?></button>
                 <button data-toggle="collapse" data-target="#PitchTPS" class="<?php if(empty($PitchTPS)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Pitch TPS <br><?php echo $PitchTPS;?></button>
                 <button data-toggle="collapse" data-target="#PitchTrust" class="<?php if(empty($PitchTrust)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Pitch Trust <br><?php echo $PitchTrust;?></button>
                 <button data-toggle="collapse" data-target="#Upsells" class="<?php if(empty($Upsells)) { echo "btn btn-danger";} else { echo "btn btn-success"; } ?>">Upsells <br><?php echo $Upsells;?></button>
                </div>

                    <br><br>
                    
                   
                    <form name="ClientTaskForm" id="ClientTaskForm" class="form-horizontal" method="POST" action="php/ClientTaskPull.php?search=<?php echo "$search";?>">
                                        
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <select id="Taskoption" class="form-control" name="Taskoption" required>
        <option value="">Select Task</option>
                                        <option value="24 48">24-48</option>
                                            <option value="5 day">5-day</option>
                                                <option value="18 day">18-day</option>
                                                    <option value="CYD">CYD</option>
                                                    <option value="Trust">Trust</option>
    </select>
 
</div>   
</div>

                                         
                                         <div class="form-group">
                                                        
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
                 <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Update</button>
                  
  </div>
</div>
                   
<div id="HappyPol" class="collapse">
    
<div class="form-group">
  <label class="col-md-4 control-label" for="HappyPol">Happy with Policy?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="HappyPol-0">
      <input name="HappyPol" id="HappyPol-0" value="No" type="radio" <?php if(isset($HappyPol)) { if($HappyPol=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="HappyPol-1">
      <input name="HappyPol" id="HappyPol-1" value="Yes" type="radio" <?php if(isset($HappyPol)) { if($HappyPol=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
  </div>
</div>
    
</div>
                
<div id="DocsArrived" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="DocsArrived">Emailed?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="DocsArrived-0">
      <input name="DocsArrived" id="DocsArrived-0" value="No"  type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="DocsArrived-1">
      <input name="DocsArrived" id="DocsArrived-1" value="Yes" type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
          <label class="radio-inline" for="DocsArrived-3">
      <input name="DocsArrived" id="DocsArrived-3" value="Not Checked" type="radio" <?php if(isset($DocsArrived)) { if($DocsArrived=='Not Checked') { echo "checked='checked'";}}?>>
      Not Checked
    </label>
  </div>
</div>
    
</div>

<div id="CYDReturned" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="CYDReturned">CYD Returned?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="CYDReturned-0">
      <input name="CYDReturned" id="CYDReturned-0" value="Yes complete with Legal and General"  type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='Yes complete with Legal and General') { echo "checked='checked'";}}?>>
      Yes complete with Legal and General
    </label> 
    <label class="radio-inline" for="CYDReturned-1">
      <input name="CYDReturned" id="CYDReturned-1" value="Yes Legal and General not received" type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='Yes Legal and General not received') { echo "checked='checked'";}}?>>
      Yes Legal and General not received
    </label> 
    <label class="radio-inline" for="CYDReturned-2">
      <input name="CYDReturned" id="CYDReturned-2" value="No" type="radio" <?php if(isset($CYDReturned)) { if($CYDReturned=='No') { echo "checked='checked'";}}?>>
      No
    </label>
  </div>
</div>
    
</div>

<div id="RemindDD" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="RemindDD">Remind/Cancel Old/New DD</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="RemindDD-0">
      <input name="RemindDD" id="RemindDD-0" value="Old DD Cancelled"  type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Old DD Cancelled') { echo "checked='checked'";}}?>>
      Old DD Cancelled
    </label> 
    <label class="radio-inline" for="RemindDD-1">
      <input name="RemindDD" id="RemindDD-1" value="Old DD Not Cancelled" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Old DD Not Cancelled') { echo "checked='checked'";}}?>>
      Old DD Not Cancelled
    </label> 
    <label class="radio-inline" for="RemindDD-2">
      <input name="RemindDD" id="RemindDD-2" value="Replacing Legal and General" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Replacing Legal and General') { echo "checked='checked'";}}?>>
      Replacing Legal and General
    </label> 
    <label class="radio-inline" for="RemindDD-3">
      <input name="RemindDD" id="RemindDD-3" value="Keeping Old Policy" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='Keeping Old Policy') { echo "checked='checked'";}}?>>
      Keeping Old Policy
    </label>
          <label class="radio-inline" for="RemindDD-4">
      <input name="RemindDD" id="RemindDD-4" value="New Policy" type="radio" <?php if(isset($RemindDD)) { if($RemindDD=='New Policy') { echo "checked='checked'";}}?>>
      New Policy
    </label>
  </div>
</div>
    
</div>

<div id="PitchTPS" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="PitchTPS">Pitch TPS</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="PitchTPS-0">
      <input name="PitchTPS" id="PitchTPS-0" value="Wants"  type="radio" <?php if(isset($PitchTPS)) { if($PitchTPS=='Wants') { echo "checked='checked'";}}?>>
      Wants
    </label> 
    <label class="radio-inline" for="PitchTPS-1">
      <input name="PitchTPS" id="PitchTPS-1" value="Doesnt Want" type="radio" <?php if(isset($PitchTPS)) { if($PitchTPS=='Doesnt Want') { echo "checked='checked'";}}?>>
      Doesnt Want
    </label>
  </div>
</div>
    
</div>

<div id="PitchTrust" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="PitchTrust">Pitch Trust</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="PitchTrust-0">
      <input name="PitchTrust" id="PitchTrust-0" value="Wants by Post"  type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Wants by Post') { echo "checked='checked'";}}?>>
      Wants by Post
    </label> 
    <label class="radio-inline" for="PitchTrust-1">
      <input name="PitchTrust" id="PitchTrust-1" value="Wants by Email" type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Wants by Email') { echo "checked='checked'";}}?>>
      Wants by Email
    </label> 
    <label class="radio-inline" for="PitchTrust-2">
      <input name="PitchTrust" id="PitchTrust-2" value="Doesnt Want" type="radio" <?php if(isset($PitchTrust)) { if($PitchTrust=='Doesnt Want') { echo "checked='checked'";}}?>>
      Doesnt Want
    </label> 
    <label class="radio-inline" for="PitchTrust-3">
      <input name="PitchTrust" id="PitchTrust-3" value="Both" type="radio"<?php if(isset($PitchTrust)) { if($PitchTrust=='Both') { echo "checked='checked'";}}?>>
      Both
    </label>
  </div>
</div>
    
</div>

<div id="Upsells" class="collapse">

<div class="form-group">
  <label class="col-md-4 control-label" for="Upsells">Upsells</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="Upsells-0">
      <input name="Upsells" id="Upsells-0" value="No"  type="radio" <?php if(isset($Upsells)) { if($Upsells=='No') { echo "checked='checked'";}}?>>
      No
    </label> 
    <label class="radio-inline" for="Upsells-1">
      <input name="Upsells" id="Upsells-1" value="Yes" type="radio" <?php if(isset($Upsells)) { if($Upsells=='Yes') { echo "checked='checked'";}}?>>
      Yes
    </label>
  </div>
</div>
    
</div>                

   </center> 
                </form>          
                
        <?php } ?>
                    
                    <div class='container'>
                        <div class="row">
                        <form method="post" id="clientnotessubtab" action="../php/AddNotes.php?ViewClientNotes=1" class="form-horizontal">
                            <legend><h3><span class="label label-info">Add notes</span></h3></legend>
                            <input type="hidden" name="client_id" value="<?php echo $search?>">
                            
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
  <label class="col-md-12 control-label" for="textarea"></label>
  <div class="col-md-12"> 
      <textarea id="notes" name="notes" id="message" class="summernote" id="contents" title="Contents" maxlength="2000" required></textarea>
    
    <center><font color="red"><i><span id="chars">2000</span> characters remaining</i></font></center>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
      <button class="btn btn-primary btn-block"><i class="fa fa-pencil-square-o"></i> Submit </button>
  </div>
</div>
                        </form>
       </div>                 
</div>
                    
       <h3><span class="label label-info">Client Timeline</span></h3>             
  <?php 
  
  
  if($companynamere=='The Review Bureau' || $companynamere=='ADL_CUS')  { 
                    try {

$clientnote = $pdo->prepare("select client_name, note_type, message, sent_by, date_sent from client_note where client_id = :search ORDER BY date_sent DESC");
$clientnote->bindParam(':search', $search, PDO::PARAM_INT);
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
    
            switch ($result['note_type']) {
    
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
                        case"Closer Call Recording";    
                        case"Agent Call Recording";     
                        case"Admin Call Recording";    
                $TMicon="fa-upload";
                break;
            case stristr($TLnotetype,"Tasks"):
                $TMicon="fa-tasks";
                break;
            case "Client Note":
        case "Policy Details Updated":
            case "Policy Update":
                $TMicon="fa-pencil";
                break;
            case stristr($TLnotetype,"Callback"):
                $TMicon="fa-calendar-check-o";
                break;
        case "Task 24 48":
        case "Task 5 day":
        case "Task CYD":
        case "Task 18 day":
        case "Tasks 24 48":
        case "Tasks 5 day":
        case "Tasks CYD":
        case "Tasks 18 day":
        case "Tasks Trust":
            $TMicon="fa-tasks";
            break;
            case "Email Sent":
                $TMicon="fa-envelope-o";
                break;
            case "Client Edited":
        case "TONIC Acount Updates ":
                case "Client Details Updated":
                $TMicon="fa-edit";
                break;
            case "Sent SMS":
        case "Callback":
                $TMicon="fa-phone";
                break;
            default:
                $TMicon="fa-bomb";

    } 

    $TIMELINE_MESSAGE=  html_entity_decode($result['message']);
	echo '<tr>';
	echo "<td>".$result['date_sent']."</td>";
	echo "<td>".$result['sent_by']."</td>";
	echo "<td>".$result['client_name']."</td>";
	echo "<td><i class='fa $TMicon'></i> ".$result['note_type']."</td>";
        
        if (in_array($hello_name,$Level_3_Access, true)) {
        
	echo "<td><b>$TIMELINE_MESSAGE</b></td>"; 
        
        }
        
                else {
        
	echo "<td><b>$TIMELINE_MESSAGE</b></td>"; 
        
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
                 }
   
?>
</div>

</div>
<!-- START EMAIL BPOP2 -->
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
                        <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                    </p>
                    <p>
                        <textarea name="message" id="message" class="summernote" id="contents" title="Contents" placeholder="Message"></textarea><br />
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
                
                <form class="AddClient" method="post" action="../email/php/ViewClientEmailSend.php?life=y" enctype="multipart/form-data" novalidate>
                    
                    <input type="hidden" name="keyfield" value="<?php echo $search;?>">
                    <input type="hidden" name="recipient" value="<?php echo $data2['title'];?> <?php echo $data2['last_name'];?>" readonly>
                    <input type="hidden" name="email" value="<?php echo $data2['email'];?>" readonly>
                    <input type="hidden" name="note_type" value="Email Sent">
                    
                    <p>
                        <label for="subject">Subject</label>
                        <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                    </p>
                    
                    <p>
                        
                        <textarea name="message" id="message" class="summernote" id="contents" title="Contents" placeholder="Message"></textarea><br />
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

<div id='CK_MODAL' class='modal fade' role='dialog'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'><i class="fa fa-clock-o"></i> Set a Callback</h4>
            </div>
            <div class='modal-body'>
        
                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#CB_ONE">New Callback</a></li>
                        <li><a data-toggle="pill" href="#CB_TWO">Active Callbacks</a></li>
                    </ul>
           
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div id="CB_ONE" class="tab-pane fade in active">
                                                <div class="col-lg-12 col-md-12">
                             
                        <form class="form-horizontal" action='../php/AddCallback.php?setcall=y&search=<?php echo $search;?>' method='POST'>                
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
                                            <input type='text' class="form-control" id="callback_date" name="callbackdate" placeholder="YYYY-MM-DD" value="<?php if(isset($CB_DATE)) { echo $CB_DATE; } ?>" required />
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
                                            <input type='text' class="form-control" id="clockpicker" name="callbacktime" placeholder="24 Hour Format" value="<?php if(isset($CB_TIME)) { echo $CB_TIME; } ?>" required  />
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
                                <div class='col-md-8'>
                                    <div class="form-group"> 
                                        <textarea class="form-control summernote" id="textarea" name="callbacknotes" placeholder="Call back notes"><?php if(isset($NOTES)) { echo $NOTES; } ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        
                        <div class="btn-group">
                        <button id="callsub" name="callsub" class="btn btn-primary"><i class='fa  fa-check-circle-o'></i> New callback</button>
                       </div>
                    </fieldset>
                </form> 
          
                                                   </div>     </div>
                                      <div id="CB_TWO" class="tab-pane fade">
                                          <div class="row">
                                              
 <?php
 
    $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid, callback_date, callback_time, reminder, CONCAT(callback_date, ' - ',callback_time)AS ordersort, client_id, id, client_name, notes, complete from scheduled_callbacks WHERE client_id=:CID AND complete='n' ORDER BY ordersort ASC");
                    $query->bindParam(':CID', $search, PDO::PARAM_INT);
                    $query->execute();
                    if ($query->rowCount()>0) { 
                 
                        ?>
        
                    <table class="table table-hover">
                    <thead>                    
                    <th>Client</th>
                    <th>Callback</th>
                    <th></th>
                    </thead>
                
                <?php
                        while ($calllist=$query->fetch(PDO::FETCH_ASSOC)){
                         
                            $callbackid = $calllist['id'];
                            $search = $calllist['client_id'];
                            $NAME=$calllist['client_name'];
                            $TIME=$calllist['calltimeid'];
                            $NOTES=$calllist['notes'];
                            $REMINDER=$calllist['reminder'];
                            $CB_DATE=$calllist['callback_date'];
                            $CB_TIME=$calllist['callback_time'];
                            
                            echo "<tr>";
                            echo "<td class='text-left'><a href='/Life/ViewClient.php?search=$search'>".$calllist['client_name']."</a></td>";
                            echo "<td class='text-left'>".$calllist['calltimeid']."</td>";
                            echo "<td><a href='/php/AddCallback.php?search=$search&callbackid=$callbackid&cb=y' class='btn btn-success btn-sm'><i class='fa fa-check'></i> Complete</a></td>";
                            echo "</tr>"; ?>    
                    
                <?php } ?>
                  </table>   
                      
                      <?php } 
                      
                      else {
                          echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No call backs found</div>";
                            
                        }
                 
                        ?>                                                             
                                              
                                          </div>
                            </div>
                        </div>
                                </div>
                            </div>
                            
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
      </div>
    </div>
  </div>
                    </div></div>
    
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
<script type="text/javascript" src="/clockpicker-gh-pages/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
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
$( "#CLICKTOHIDECLOSER" ).click(function() {
  $( "#HIDECLOSER" ).fadeOut( "slow", function() {

  });
});
$( "#CLICKTOHIDELEADID" ).click(function() {
  $( "#HIDELEADID" ).fadeOut( "slow", function() {

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
$(document).ready(function() {
      $( "#SHOW_ALERTS").hide( "fast", function() {
    // Animation complete
  });    
    });

$( "#SHOW_ALERTS" ).click(function() {
  $( "#HIDELGAPP,#HIDELEADID,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY,#HIDELEAD,#HIDECLOSER,#HIDEGLEAD,#HIDEGCLOSER,#SHOW_ALERTS").fadeIn( "slow", function() {
    // Animation complete
  });
    $( "#HIDE_ALERTS").fadeIn( "slow", function() {
    // Animation complete
  });
    $( "#SHOW_ALERTS").fadeOut( "slow", function() {
    // Animation complete
  });  
});
$( "#HIDE_ALERTS" ).click(function() {
  $( "#HIDELGAPP,#HIDELEADID,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY,#HIDELEAD,#HIDECLOSER,#HIDEGLEAD,#HIDEGCLOSER,#HIDE_ALERTS").fadeOut( "slow", function() {
    // Animation complete
  });
      $( "#SHOW_ALERTS").fadeIn( "slow", function() {
    // Animation complete
  });
});
  </script>
<script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script src="/js/sweet-alert.min.js"></script>
<script type="text/javascript" src="../summernote-master/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });


    });
  </script>
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
