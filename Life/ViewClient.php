<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=1;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');

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

$PID = filter_input(INPUT_GET, 'policyID', FILTER_SANITIZE_NUMBER_INT);
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_NUMBER_INT);

if (isset($search)) {
    $likesearch = "$search-%";
}

if (empty($search)) {

    header('Location: ../CRMmain.php?PARAMS');
    die;
}

if (in_array($hello_name, $Level_3_Access, true) || in_array($hello_name, $COM_MANAGER_ACCESS, true) || in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 

if(in_array($hello_name, $COM_LVL_10_ACCESS, true)) { 
    require_once(__DIR__ . '/models/AllClientModel.php');
    $ClientModel = new AllClientModel($pdo);
    $ClientList = $ClientModel->getAllSingleClient($search);
    require_once(__DIR__ . '/views/Single-Client.php');
    
} else {
    
    require_once(__DIR__ . '/models/ClientModel.php');
    $ClientModel = new ClientModel($pdo);
    $ClientList = $ClientModel->getSingleClient($search,$COMPANY_ENTITY);
    require_once(__DIR__ . '/views/Single-Client.php');

}


if(empty($ClientList)) {
    header('Location: ../CRMmain.php?NO_COMPANY');
}

if (isset($Single_Client['company'])) {
    $WHICH_COMPANY = $Single_Client['company'];

    if ($WHICH_COMPANY == 'TRB Home Insurance') {
        header('Location: /Home/ViewClient.php?CID=' . $search);
        die;
    }
}

if (isset($Single_Client['owner'])) {
    $WHICH_OWNER = $Single_Client['owner'];
}

if (isset($Single_Client['date_added'])) {
    $client_date_added = $Single_Client['date_added'];
}
if (isset($Single_Client['email'])) {
    $clientonemail = $Single_Client['email'];
}
if (isset($Single_Client['email2'])) {
    $clienttwomail = $Single_Client['email2'];
}
if (isset($Single_Client['first_name'])) {
    $clientonefull = $Single_Client['first_name'] . " " . $Single_Client['last_name'];
}
if (isset($Single_Client['first_name2'])) {
    $clienttwofull = $Single_Client['first_name2'] . " " . $Single_Client['last_name2'];
}
if (isset($Single_Client['leadid1'])) {
    $leadid1 = $Single_Client['leadid1'];
}
if (isset($Single_Client['leadid2'])) {
    $leadid2 = $Single_Client['leadid2'];
}
if (isset($Single_Client['leadid3'])) {
    $leadid3 = $Single_Client['leadid3'];
}
if (isset($Single_Client['dealsheet_id'])) {
    $dealsheet_id = $Single_Client['dealsheet_id'];
}
if (isset($Single_Client['callauditid2'])) {
    $WOL_CLOSER_AUDIT = $Single_Client['callauditid2'];
}
if (isset($Single_Client['leadauditid2'])) {
    $WOL_LEAD_AUDIT = $Single_Client['leadauditid2'];
}

if (isset($Single_Client['callauditid'])) {
    $auditid = $Single_Client['callauditid'];
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
    <title>ADL | View Client</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/styles/sweet-alert.min.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/clockpicker-gh-pages/dist/jquery-clockpicker.min.css">
    <link rel="stylesheet" type="text/css" href="/clockpicker-gh-pages/assets/css/github.min.css">
    <link rel="stylesheet" href="/summernote-master/dist/summernote.css">
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
    require_once(__DIR__ . '/../includes/navbar.php');
    

    try {
        $anquery = $pdo->prepare("select application_number from client_policy where client_id=:search");
        $anquery->bindParam(':search', $search, PDO::PARAM_INT);
        $anquery->execute();
        $ansearch = $anquery->fetch(PDO::FETCH_ASSOC);

        $an_number = $ansearch['application_number'];
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    try {

        $auditquery = $pdo->prepare("select closer_audits.id AS CLOSER, closer_audits.grade AS CGRADE, Audit_LeadGen.id AS LEAD, Audit_LeadGen.grade AS LGRADE from closer_audits LEFT JOIN Audit_LeadGen on closer_audits.an_number=Audit_LeadGen.an_number where closer_audits.an_number=:annum");
        $auditquery->bindParam(':annum', $an_number, PDO::PARAM_STR);
        $auditquery->execute();
        $auditre = $auditquery->fetch(PDO::FETCH_ASSOC);

        $closeraudit = $auditre['CLOSER'];
        $leadaudit = $auditre['LEAD'];
        $CGRADE = $auditre['CGRADE'];
        $LGRADE = $auditre['LGRADE'];
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
    <br>
    <div class="container">

        <?php require_once(__DIR__ . '/../includes/user_tracking.php');  ?>

        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home">Client</a></li>
            <li><a data-toggle="pill" href="#menu4">Timeline <span class="badge alert-warning">

                        <?php
                        $database = new Database();
                        $database->query("select count(note_id) AS badge from client_note where client_id ='$search'");
                        $row = $database->single();
                        echo htmlentities($row['badge']);
                        ?>

                    </span></a></li>
            <li><a data-toggle='modal' data-target='#CK_MODAL'>Callbacks</a></li>
            <li><a data-toggle="pill" href="#menu2">Files & Uploads <span class="badge alert-warning">

                        <?php
                        $database->query("select count(id) AS badge from tbl_uploads where file like '$search%'");
                        $filesuploaded = $database->single();
                        echo htmlentities($filesuploaded['badge']);
                        ?>
                    </span></a></li>
            <?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                <li><a data-toggle="pill" href="#menu3">Financial</a></li>
            <?php } ?>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add Policy <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                        <li><a class="list-group-item" href="NewPolicy.php?EXECUTE=1&search=<?php echo $search; ?>&INSURER=LANDG">Legal and General Policy</a></li>
                        <li><a class="list-group-item" href="NewPolicy.php?EXECUTE=1&search=<?php echo $search; ?>&INSURER=AVIVA">Aviva Policy</a></li>
                        <li><a class="list-group-item" href="NewPolicy.php?EXECUTE=1&search=<?php echo $search; ?>&INSURER=VITALITY">Vitality Policy</a></li>
                        <li><a class="list-group-item" href="NewPolicy.php?EXECUTE=1&search=<?php echo $search; ?>&INSURER=ROYALLONDON">Royal London Policy</a></li>
                        <li><a class="list-group-item" href="NewPolicy.php?EXECUTE=1&search=<?php echo $search; ?>&INSURER=ONEFAMILY">One Family Policy</a></li>
                    <?php } ?>

                </ul>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <div class="list-group">
                        <?php if (in_array($hello_name, $Level_3_Access, true)) { ?>
                            <li><a class="list-group-item" href="EditClient.php?search=<?php echo $search ?>&life"><i class="fa fa-pencil-square-o fa-fw"></i> &nbsp; Edit Client</a></li> 
                            <li><a class="list-group-item" href="AddPolicy.php?EXECUTE=1&search=<?php echo $search ?>"><i class="fa fa-plus fa-fw"></i> Add Policy</a></li>
                        <?php } ?>
                        <?php if (in_array($hello_name, $Level_10_Access, true)) { ?>
                            <li><a class="list-group-item" href="/admin/deleteclient.php?search=<?php echo $search ?>&life"><i class="fa fa-trash fa-fw"></i> &nbsp; Delete Client</a></li>
                        <?php } ?>

                    </div>
                </ul>
            </li>
            <li id='SHOW_ALERTS'><a data-toggle="pill"><i class='fa fa-eye-slash fa-fw'></i> Show Alerts</a></li>
            <li id='HIDE_ALERTS'><a data-toggle="pill"><i class='fa fa-eye-slash fa-fw'></i> Hide Alerts</a></li>

        </ul>


        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <?php require_once(__DIR__ . '/php/Notifications.php'); ?>
                <div class="container">

                    <div class="col-md-4">
                        <h3><span class="label label-primary">Client Details</span></h3>

                        <p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="FullName" name="FullName" value="<?php echo $Single_Client['title'] ?> <?php echo $Single_Client['first_name'] ?> <?php echo $Single_Client['last_name'] ?>" readonly >
                            <span class="input-group-btn">
                                <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                    <form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'>

                                        <input type='hidden' name='searchCriteria.surname' id='searchCriteria.surname' value='<?php echo $Single_Client['last_name']; ?>'>
                                        <input type='hidden' name='searchCriteria.forename' id='searchCriteria.forename' value='<?php echo $Single_Client['first_name']; ?> '>
                                        <input type='hidden' name='searchCriteria.dob' id='searchCriteria.dob' value=''>
                                        <input type='hidden' name='searchCriteria.postcode' id='searchCriteria.postcode' value='NULL'>
                                        <input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='NULL'>
                                        <input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value=''>
                                        <input type='hidden' name='searchCriteria.period' id='searchCriteria.period' value='' >
                                        <input type='hidden' name='searchCriteria.agentNumber' id='searchCriteria.agentNumber' value='' >
                                        <input type='hidden' name='searchCriteria.status' id='searchCriteria.status' value='NULL' >
                                        <input type='hidden' name='searchCriteria.oiiType' id='searchCriteria.oiiType' value='' >

                                        <input type='hidden' name='searchCriteria.includeLife' value='true' >
                                        <input type='hidden' name='searchCriteria.includeGI' id='searchCriteria.includeGI' value='false' > 
                                        <input type='hidden' name='selectedAgencyNumberForSearch' id='selectedAgencyNumberForSearch.oiiType' value='7168529' >
                                        <button type='submit' value='SEARCH' name='command'class="btn btn-success"><i class="fa fa-search"></i></button>
                                    </form>
                                <?php } else { ?>
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a> </span>

                            <?php } ?>

                        </div>
                        </p>

                        <p>
                        <div class="input-group">
                            <input type="text" class="form-control" id="dob" name="dob" value="<?php echo $Single_Client['dob']; ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>

                            </span>
                        </div>
                        </p>
                        <?php if (!empty($Single_Client['email'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="email" id="email" name="email" value="<?php echo $Single_Client['email'] ?>"  readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email1pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <br>

                    </div>

                    <div class="col-md-4">

                        <?php if (!empty($Single_Client['first_name2'])) { ?>

                            <h3><span class="label label-primary">Client Details (2)</span></h3>


                            <p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="FullName2" name="FullName2" value="<?php echo $Single_Client['title2'] ?> <?php echo $Single_Client['first_name2'] ?> <?php echo $Single_Client['last_name2'] ?>"  readonly >
                                <span class="input-group-btn">

                                    <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                        <form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'>

                                            <input type='hidden' name='searchCriteria.surname' id='searchCriteria.surname' value='<?php echo $Single_Client['last_name2']; ?>'>
                                            <input type='hidden' name='searchCriteria.forename' id='searchCriteria.forename' value='<?php echo $Single_Client['first_name2']; ?> '>
                                            <input type='hidden' name='searchCriteria.dob' id='searchCriteria.dob' value=''>
                                            <input type='hidden' name='searchCriteria.postcode' id='searchCriteria.postcode' value='NULL'>
                                            <input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='NULL'>
                                            <input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value=''>
                                            <input type='hidden' name='searchCriteria.period' id='searchCriteria.period' value='' >
                                            <input type='hidden' name='searchCriteria.agentNumber' id='searchCriteria.agentNumber' value='' >
                                            <input type='hidden' name='searchCriteria.status' id='searchCriteria.status' value='NULL' >
                                            <input type='hidden' name='searchCriteria.oiiType' id='searchCriteria.oiiType' value='' >

                                            <input type='hidden' name='searchCriteria.includeLife' value='true' >
                                            <input type='hidden' name='searchCriteria.includeGI' id='searchCriteria.includeGI' value='false' > 
                                            <input type='hidden' name='selectedAgencyNumberForSearch' id='selectedAgencyNumberForSearch.oiiType' value='7168529' >
                                            <button type='submit' value='SEARCH' name='command'class="btn btn-success"><i class="fa fa-search"></i></button>
                                        </form>
                                    <?php } else { ?>                                        


                                        <a href="#" data-toggle="tooltip" data-placement="right" title="Client Name"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                                    <?php } ?>
                                </span>
                            </div>
                            </p>

                            <p>
                            <div class="input-group">
                                <input type="text" class="form-control" id="dob2" name="dob2" value="<?php echo $Single_Client['dob2'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Date of Birth"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-calendar"></span></button></a>

                                </span>
                            </div>
                            </p>
                            <?php if (!empty($Single_Client['email2'])) { ?>
                                <p>
                                <div class="input-group">
                                    <input class="form-control" type="email" id="email2" name="email2" value="<?php echo $Single_Client['email2'] ?>"  readonly >
                                    <span class="input-group-btn">
                                        <a href="#" data-toggle="tooltip" data-placement="right" title="Send Email"><button type="button" data-toggle="modal" data-target="#email2pop" class="btn btn-success"><span class="glyphicon glyphicon-envelope"></span></button></a>

                                    </span>
                                </div>
                                </p>

                                <?php
                            }
                        }
                        ?>

                    </div>

                    <div class="col-md-4">
                        <h3><span class="label label-primary">Contact Details</span></h3>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $Single_Client['phone_number'] ?>" readonly >
                            <span class="input-group-btn">
                                <button type="button" data-toggle="modal" data-target="#smsModal"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button>

                            </span>
                        </div>
                        </p>

                        <?php if (!empty($Single_Client['alt_number'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="tel" id="alt_number" name="alt_number" value="<?php echo $Single_Client['alt_number'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Call/SMS"><button type="button" data-toggle="modal" data-target="#smsModalalt"  class="btn btn-success"><span class="glyphicon glyphicon-earphone"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <div class="input-group">
                            <input class="form-control" type="text" id="address1" name="address1" value="<?php echo $Single_Client['address1'] ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 1"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></button></a>

                            </span>
                        </div>
                        </p>

                        <?php if (!empty($Single_Client['address2'])) { ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="text" id="address2" name="address2" value="<?php echo $Single_Client['address2'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 2"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                                </span>
                            </div>
                            </p>

                            <?php
                        }
                        if (!empty($Single_Client['address3'])) {
                            ?>

                            <p>
                            <div class="input-group">
                                <input class="form-control" type="text" id="address3" name="address3" value="<?php echo $Single_Client['address3'] ?>" readonly >
                                <span class="input-group-btn">
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Address Line 3"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                                </span>
                            </div>
                            </p>

                        <?php } ?>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="text" id="town" name="town" value="<?php echo $Single_Client['town'] ?>" readonly >
                            <span class="input-group-btn">
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Postal Town"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>

                            </span>
                        </div>
                        </p>

                        <p>
                        <div class="input-group">
                            <input class="form-control" type="text" id="post_code" name="post_code" value="<?php echo $Single_Client['post_code'] ?>" readonly >
                            <span class="input-group-btn">
                                <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                    <form target='_blank' action='//www10.landg.com/ProtectionPortal/home.htm' method='post'>
                                        <input type='hidden' name='searchCriteria.referenceType' id='searchCriteria.referenceType' value='NULL'>
                                        <input type='hidden' name='searchCriteria.reference' id='searchCriteria.reference' value=''>
                                        <input type='hidden' name='searchCriteria.period' id='searchCriteria.period' value='' >
                                        <input type='hidden' name='searchCriteria.postcode' id='searchCriteria.postcode' value='<?php echo $Single_Client['post_code'] ?>' >
                                        <input type='hidden' name='searchCriteria.agentNumber' id='searchCriteria.agentNumber' value='' >
                                        <input type='hidden' name='searchCriteria.status' id='searchCriteria.status' value='' >
                                        <input type='hidden' name='searchCriteria.oiiType' id='searchCriteria.oiiType' value='' >
                                        <input type='hidden' name='searchCriteria.includeLife' value='true' >
                                        <input type='hidden' name='searchCriteria.includeGI' id='searchCriteria.includeGI' value='false' >
                                        <input type='hidden' name='selectedAgencyNumberForSearch' id='selectedAgencyNumberForSearch' value='7168529' >    
                                        <button type='submit' value='SEARCH' name='command'class="btn btn-success"><i class="fa fa-search"></i></button>
                                    </form>
                                <?php } else { ?>
                                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                <?php } ?>


                            </span>
                        </div>
                        </p>
                        <br>

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

                            if (empty($dealsheet_id)) {

                                try {

                                    $Dealquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Dealsheet'");
                                    $Dealquery->bindParam(':search', $search_file_var, PDO::PARAM_INT);
                                    $Dealquery->execute();

                                    while ($result = $Dealquery->fetch(PDO::FETCH_ASSOC)) {
                                        $DSFILE = $result['file'];
                                        if (file_exists("../uploads/$DSFILE")) {
                                            ?>
                                            <a href="../uploads/<?php echo $DSFILE; ?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Dealsheet</a>
                                        <?php } if (file_exists("../uploads/life/$search/$DSFILE")) { ?>
                                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $DSFILE; ?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> Dealsheet</a>
                                            <?php
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                            } else {
                                ?>
                                <a href="LifeDealSheet.php?REF=<?php echo $dealsheet_id; ?>&query=CompletedADL" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-file"></span> ADL Dealsheet</a>

                                <?php
                            }

                            if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY == 'ADL_CUS' || $WHICH_COMPANY=='ADL Legal and General') {

                                try {

                                    $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='LGpolicy'");
                                    $LGquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                                    $LGquery->execute();

                                    while ($result = $LGquery->fetch(PDO::FETCH_ASSOC)) {
                                        $LGPOLFILE = $result['file'];
                                        if (file_exists("../uploads/$LGPOLFILE")) {
                                            ?>
                                            <a href="../uploads/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy</a>
                                        <?php } else { ?>
                                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Policy</a>
                                            <?php
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }

                                try {

                                    $LGKeyfactsquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='LGkeyfacts'");
                                    $LGKeyfactsquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                                    $LGKeyfactsquery->execute();

                                    while ($result = $LGKeyfactsquery->fetch(PDO::FETCH_ASSOC)) {
                                        $LGFILE = $result['file'];
                                        if (file_exists("../uploads/$LGFILE")) {
                                            ?>
                                            <a href="../uploads/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> L&G Keyfacts</a> 
                                            <?php
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                            }

                            if ($WHICH_COMPANY == 'TRB Vitality') {

                                try {

                                    $LGquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Vitalitypolicy'");
                                    $LGquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                                    $LGquery->execute();

                                    while ($result = $LGquery->fetch(PDO::FETCH_ASSOC)) {
                                        $LGPOLFILE = $result['file'];
                                        if (file_exists("../uploads/$LGPOLFILE")) {
                                            ?>
                                            <a href="../uploads/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Policy</a>
                                        <?php } else { ?>
                                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGPOLFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Policy</a>
                                            <?php
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }

                                try {

                                    $LGKeyfactsquery = $pdo->prepare("SELECT file FROM tbl_uploads WHERE file like :search and uploadtype ='Vitalitykeyfacts'");
                                    $LGKeyfactsquery->bindParam(':search', $search_file_var, PDO::PARAM_STR);
                                    $LGKeyfactsquery->execute();

                                    while ($result = $LGKeyfactsquery->fetch(PDO::FETCH_ASSOC)) {
                                        $LGFILE = $result['file'];
                                        if (file_exists("../uploads/$LGFILE")) {
                                            ?>
                                            <a href="../uploads/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Keyfacts</a> 
                                        <?php } else { ?>
                                            <a href="../uploads/life/<?php echo $search; ?>/<?php echo $LGFILE; ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> Vitality Keyfacts</a> 
                                            <?php
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                            }
                            ?>

                        </div>
                    </center>
                    <br>

                    <?php
                    if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL Legal and General' || 'TRB Archive' || $WHICH_COMPANY == 'TRB Vitality' || $WHICH_COMPANY == 'TRB WOL' || $WHICH_COMPANY == 'TRB Royal London' || $WHICH_COMPANY == 'TRB Aviva' || $WHICH_COMPANY == 'ADL_CUS' || $WHICH_COMPANY == 'CUS Vitality' || $WHICH_COMPANY == 'CUS WOL' || $WHICH_COMPANY == 'CUS Royal London' || $WHICH_COMPANY == 'CUS Aviva') {

                        $LG_CHECK = $pdo->prepare("SELECT client_policy.id  FROM client_policy WHERE insurer='Legal and General' AND client_id=:CID");
                        $LG_CHECK->bindParam(':CID', $search, PDO::PARAM_INT);
                        $LG_CHECK->execute();
                        if ($LG_CHECK->rowCount() > 0) {
                            $LANG_POL = "1";
                            require_once(__DIR__ . '/models/LGPoliciesModel.php');
                            $LGPolicies = new LGPoliciesModal($pdo);
                            $LGPoliciesList = $LGPolicies->getLGPolicies($search);
                            require_once(__DIR__ . '/views/LG-Policies.php');
                        }

                        $VIT_CHECK = $pdo->prepare("SELECT client_policy.id  FROM client_policy WHERE insurer='Vitality' AND client_id=:CID");
                        $VIT_CHECK->bindParam(':CID', $search, PDO::PARAM_INT);
                        $VIT_CHECK->execute();
                        if ($VIT_CHECK->rowCount() > 0) {
                            $VITALITY_POL = "1";
                            require_once(__DIR__ . '/models/VITALITYPoliciesModal.php');
                            $VITALITYPolicies = new VITALITYPoliciesModal($pdo);
                            $VITALITYPoliciesList = $VITALITYPolicies->getVITALITYPolicies($search);
                            require_once(__DIR__ . '/views/VITALITY-Policies.php');
                        }

                        $WOL_CHECK = $pdo->prepare("SELECT client_policy.id  FROM client_policy WHERE insurer='One Family' AND client_id=:CID");
                        $WOL_CHECK->bindParam(':CID', $search, PDO::PARAM_INT);
                        $WOL_CHECK->execute();
                        if ($WOL_CHECK->rowCount() > 0) {
                            $WOL_POL = "1";
                            require_once(__DIR__ . '/models/WOLPoliciesModal.php');
                            $WOLPolicies = new WOLPoliciesModal($pdo);
                            $WOLPoliciesList = $WOLPolicies->getWOLPolicies($search);
                            require_once(__DIR__ . '/views/WOL-Policies.php');
                        }

                        $RL_CHECK = $pdo->prepare("SELECT client_policy.id  FROM client_policy WHERE insurer='Royal London' AND client_id=:CID");
                        $RL_CHECK->bindParam(':CID', $search, PDO::PARAM_INT);
                        $RL_CHECK->execute();
                        if ($RL_CHECK->rowCount() > 0) {
                            $RL_POL = "1";
                            require_once(__DIR__ . '/models/RLPoliciesModel.php');
                            $RLPolicies = new RLPoliciesModal($pdo);
                            $RLPoliciesList = $RLPolicies->getRLPolicies($search);
                            require_once(__DIR__ . '/views/RL-Policies.php');
                        }

                        $Aviva_CHECK = $pdo->prepare("SELECT client_policy.id  FROM client_policy WHERE insurer='Aviva' AND client_id=:CID");
                        $Aviva_CHECK->bindParam(':CID', $search, PDO::PARAM_INT);
                        $Aviva_CHECK->execute();
                        if ($Aviva_CHECK->rowCount() > 0) {
                            $AVIVA_POL = "1";
                            require_once(__DIR__ . '/models/AvivaPoliciesModal.php');
                            $AvivaPolicies = new AvivaPoliciesModal($pdo);
                            $AvivaPoliciesList = $AvivaPolicies->getAvivaPolicies($search);
                            require_once(__DIR__ . '/views/Aviva-Policies.php');
                        }
                    } ?>

                </div>
            </div>

            <div id="menu1" class="tab-pane fade">
                <br>

                <?php
                if ($ffcallbacks == '1') {

                    try {

                        $query = $pdo->prepare("SELECT CONCAT(callback_time, ' - ', callback_date) AS calltimeid from scheduled_callbacks WHERE client_id =:CID");
                        $query->bindParam(':CID', $search, PDO::PARAM_INT);
                        $query->execute();
                        $pullcall = $query->fetch(PDO::FETCH_ASSOC);

                        $calltimeid = $pullcall['calltimeid'];

                        echo "<button type=\"button\" class=\"btn btn-default btn-block\" data-toggle=\"modal\" data-target=\"#schcallback\"><i class=\"fa fa-calendar-check-o\"></i> Schedule callback ($calltimeid)</button>";
                    } catch (PDOException $e) {
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
                            <h4 class="modal-title"><i class='fa fa-commenting-o'></i> Send SMS</h4>
                        </div>
                        <div class="modal-body">

                            <?php
                            if ($ffsms == '1') {

                                try {

                                    $smsquery = $pdo->prepare("select smsprovider, smsusername, AES_DECRYPT(smspassword, UNHEX(:key)) AS smspassword from sms_accounts limit 1");
                                    $smsquery->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500);
                                    $smsquery->execute()or die(print_r($query->errorInfo(), true));
                                    $smsaccount = $smsquery->fetch(PDO::FETCH_ASSOC);

                                    $smsuser = $smsaccount['smsusername'];
                                    $smspass = $smsaccount['smspassword'];
                                    $smspro = $smsaccount['smsprovider'];
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                                ?>
                                <br> 

                                <?php
                                $CHECK_NUM = strlen($Single_Client['phone_number']);

                                if ($CHECK_NUM > 11) {
                                    $CHK_NUM = '0';
                                }
                                if ($CHECK_NUM <= 10) {
                                    $CHK_NUM = '0';
                                }
                                if ($CHECK_NUM == 11) {
                                    $CHK_NUM = '1';
                                }

                                if ($CHK_NUM == '0') {
                                    ?>

                                    <div class="notice notice-danger" role="alert"><strong><i class="fa fa-exclamation-circle fa-lg"></i> Invalid Number:</strong> Please check that the phone number is correct and is in the correct format (i.e. 07401434619) </div>              


                                <?php }
                                if ($CHK_NUM == '1') {
                                    ?>
                                    <form class="AddClient">
                                        <p>
                                            <label for="phone_number">Contact Number:</label>
                                            <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $Single_Client['phone_number'] ?>" readonly>
                                        </p>
                                    </form>

                                    <form class="AddClient" method="POST" action="<?php if ($CHK_NUM == '0') {
                                        echo "#";
                                    } if ($CHK_NUM == '1') {
                                        echo "SMS/Send.php?WHICH_COMPANY=$WHICH_COMPANY";
                                    } ?>">

                                        <input type="hidden" name="keyfield" value="<?php echo $search; ?>">
                                        <div class="form-group">

                                            <label for="selectsms">Select SMS:</label>
                                            <select class="form-control" name="selectopt" id="selectopt">
                                                <option value=" ">Select message...</option>

                                                <?php
                                                if (isset($WHICH_COMPANY)) {
                                                    if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL Legal and General' || $WHICH_COMPANY == 'ADL_CUS') {
                                                        $SMS_INSURER = 'Legal and General';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB WOL' || $WHICH_COMPANY == 'CUS WOL') {
                                                        $SMS_INSURER = 'One Family';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB Vitality' || $WHICH_COMPANY == 'CUS Vitality') {
                                                        $SMS_INSURER = 'Vitality';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB Royal London' || $WHICH_COMPANY == 'CUS Royal London') {
                                                        $SMS_INSURER = 'Royal London';
                                                    }
                                                }

                                                try {

                                                    $SMSquery = $pdo->prepare("SELECT title from sms_templates WHERE insurer =:insurer AND company=:COMPANY OR insurer='NA' AND company=:COMPANY2");
                                                    $SMSquery->bindParam(':insurer', $SMS_INSURER, PDO::PARAM_STR);
                                                    $SMSquery->bindParam(':COMPANY', $WHICH_COMPANY, PDO::PARAM_STR);
                                                    $SMSquery->bindParam(':COMPANY2', $WHICH_COMPANY, PDO::PARAM_STR);
                                                    $SMSquery->execute();
                                                    if ($SMSquery->rowCount() > 0) {
                                                        while ($smstitles = $SMSquery->fetch(PDO::FETCH_ASSOC)) {

                                                            $smstitle = $smstitles['title'];
                           
                                                            echo "<option value='$smstitle'>$smstitle</option>";
                                                        }
                                                    }
                                                } catch (PDOException $e) {
                                                    echo 'Connection failed: ' . $e->getMessage();
                                                }
                                                ?>

                                            </select>
                                        </div>

                                        <div id="General_Contact" class="SELECTED_SMS well" style="display:none">[CLIENT_NAME] Its Very Important We Speak To You Regarding Your Life Insurance Policy. Please Contact [COMPANY NAME] On [COMPANY TEL].</div>
                                        <div id="CFO" class="SELECTED_SMS well" style="display:none">We are sorry to here that you want to cancel your policy with [INSURER]. Cancelling any protection is an important decision and one that should be considered carefully. To discuss your options please call us on [COMPANY_TEL]. Yours Sincerely, Customer Services, [COMPANY_NAME].</div>
                                        <div id="CYD" class="SELECTED_SMS well" style="display:none">Your Check Your Details Form Is Outstanding For Your Life Insurance Policy. Please Ensure This Is Completed To [INSURER] via My Account As Soon As Possible. Any Queries Please Contact [COMPANY_NAME] On [COMPANY_TEL].</div>
                                        <div id="CYD_DD" class="SELECTED_SMS well" style="display:none">Your Check Your Details Form Is Still Outstanding. You Will Have Noticed Your First Direct Debit Has Been Collected Or Will Be Shortly. Please Ensure Your Check Your Details Is Completed Online via My Account. Any Queries Please Contact [COMPANY_NAME] On [COMPANY_TEL]</div>
                                        <div id="CYD_POST" class="SELECTED_SMS well" style="display:none">Your Check Your Details form is outstanding for your Life Insurance policy. Please sign and return the form in the freepost envelope as soon as possible. Any queries please contact [COMPANY_NAME] on [COMPANY_TEL]</div>
                                        <div id="Direct_Debit" class="SELECTED_SMS well" style="display:none">Your direct debit with [INSURER/<?php echo $SMS_INSURER; ?>] is due to be taken shortly if it hasn’t been taken already. Any further direct debits will be taken on your preferred collection date. If you have any issues please don’t hesitate to contact us on [COMPANY_TEL]. Many thanks [COMPANY_NAME].</div>
                                        <div id="EWS_Bounced" class="SELECTED_SMS well" style="display:none">Your bank has told us that they cannot pay your life insurance premium with [INSURER] by direct debit. To restart your direct debit or update your bank details, please call us on [COMPANY_TEL]. Yours Sincerely, Customer Services, [COMPANY_NAME].</div>
                                        <div id="EWS_DD_Cancelled" class="SELECTED_SMS well" style="display:none">Your bank has told us the direct debit instruction for your life insurance with [INSURER] has been cancelled, so it cannot be used to collect future premiums. To restart your direct debit or update your bank details, please call us on [COMPANY_TEL].</div>
                                        <div id="For_any_queries_call_us" class="SELECTED_SMS well" style="display:none">Regarding your life insurance policy with us, should you have an questions or queries please do not hesitate too contact us on [COMPANY_TEL] or via email [COMPANY_EMAIL].</div>
                                        <div id="Incomplete_Trust" class="SELECTED_SMS well" style="display:none">We can see that you have not yet completed your trust forms. If you have any questions please contact our [COMPANY_NAME] customer care team on [COMPANY_TEL].</div>
                                        <div id="Welcome" class="SELECTED_SMS well" style="display:none">Your Policy Has Been Submitted With [INSURER]. All Correspondence Will Follow Shortly. Any Queries Please Contact [COMPANY_NAME] On [COMPANY_TEL].</div>

                                        <input type="hidden" id="FullName" name="FullName" value="<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>">
                                        <input type="hidden" id="phone_number" name="phone_number" value="<?php echo $Single_Client['phone_number']; ?>">
                                        <input type="hidden" id="SMS_INSURER" name="SMS_INSURER" value="<?php echo $SMS_INSURER; ?>">

                                        <center>
                                            <button type='submit' class='btn btn-success'><i class='fa fa-mobile'></i> SEND TEMPLATE SMS</button>
                                        </center>

                                    </form>
                                    <br>
        <?php if (in_array($hello_name, $Level_9_Access, true)) { ?>

                                        <form class="AddClient" method="POST" action="<?php if ($CHK_NUM == '0') {
                echo "#";
            } if ($CHK_NUM == '1') {
                echo "SMS/Send.php?EXECUTE=1";
            } ?>">

                                            <input type="hidden" name="keyfield" value="<?php echo $search; ?>">
                                            <div class="form-group">
                                                <label for="message">Custom MSG:</label>
                                                <textarea class="form-control" name="message" required></textarea>
                                            </div>

                                            <input type="hidden" id="FullName" name="FullName" value="<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>">
                                            <input type="hidden" id="phone_number" name="phone_number" value="<?php echo $Single_Client['phone_number']; ?>">
                                            <center>
                                                <button type='submit' class='btn btn-primary'><i class='fa fa-mobile'></i> SEND CUSTOM SMS</button>
                                            </center>

                                        </form>

        <?php
        }
    }
} else {
    ?>

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
                            <h4 class="modal-title"><i class='fa fa-commenting-o'></i> Send SMS</h4>
                        </div>
                        <div class="modal-body">

                            <?php
                            if ($ffsms == '1') {

                                try {

                                    $smsquery = $pdo->prepare("select smsprovider, smsusername, AES_DECRYPT(smspassword, UNHEX(:key)) AS smspassword from sms_accounts limit 1");
                                    $smsquery->bindParam(':key', $EN_KEY, PDO::PARAM_STR, 500);
                                    $smsquery->execute()or die(print_r($query->errorInfo(), true));
                                    $smsaccount = $smsquery->fetch(PDO::FETCH_ASSOC);

                                    $smsuser = $smsaccount['smsusername'];
                                    $smspass = $smsaccount['smspassword'];
                                    $smspro = $smsaccount['smsprovider'];
                                } catch (PDOException $e) {
                                    echo 'Connection failed: ' . $e->getMessage();
                                }
                                ?>
                                <br> 

                                <?php
                                $CHECK_NUM_ALT = strlen($Single_Client['alt_number']);

                                if ($CHECK_NUM_ALT > 11) {
                                    $CHK_NUM_ALT = '0';
                                }
                                if ($CHECK_NUM_ALT <= 10) {
                                    $CHK_NUM_ALT = '0';
                                }
                                if ($CHECK_NUM_ALT == 11) {
                                    $CHK_NUM_ALT = '1';
                                }

                                if ($CHK_NUM_ALT == '0') {
                                    ?>

                                    <div class="notice notice-danger" role="alert"><strong><i class="fa fa-exclamation-circle fa-lg"></i> Invalid Number:</strong> Please check that the phone number is correct and is in the correct format (i.e. 07401434619) </div>              


    <?php } if ($CHK_NUM_ALT == '1') { ?>
                                    <form class="AddClient">    
                                        <p>
                                            <label for="phone_number">Contact Number:</label>
                                            <input class="form-control" type="tel" id="phone_number" name="phone_number" value="<?php echo $Single_Client['alt_number'] ?>" readonly>
                                        </p>
                                    </form>

                                    <form class="AddClient" method="POST" action="<?php if ($CHK_NUM == '0') {
                                        echo "#";
                                    } if ($CHK_NUM == '1') {
                                        echo "SMS/Send.php?WHICH_COMPANY=$WHICH_COMPANY";
                                    } ?>">

                                        <input type="hidden" name="keyfield" value="<?php echo $search; ?>">
                                        <div class="form-group">
                                            <label for="selectsms">Select SMS:</label>
                                            <select class="form-control" name="selectopt">
                                                <option value=" ">Select message...</option>

                                                <?php
                                                if (isset($WHICH_COMPANY)) {
                                                    if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL Legal and General' || $WHICH_COMPANY == 'ADL_CUS') {
                                                        $SMS_INSURER = 'Legal and General';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB WOL' || $WHICH_COMPANY == 'CUS WOL') {
                                                        $SMS_INSURER = 'One Family';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB Vitality' || $WHICH_COMPANY == 'CUS Vitality') {
                                                        $SMS_INSURER = 'Vitality';
                                                    }
                                                    if ($WHICH_COMPANY == 'TRB Royal London' || $WHICH_COMPANY == 'CUS Royal London') {
                                                        $SMS_INSURER = 'Royal London';
                                                    }
                                                }

                                                try {
  $SMSquery = $pdo->prepare("SELECT title from sms_templates WHERE insurer =:insurer AND company=:COMPANY OR insurer='NA' AND company=:COMPANY2");
                                                    $SMSquery->bindParam(':insurer', $SMS_INSURER, PDO::PARAM_STR);
                                                    $SMSquery->bindParam(':COMPANY', $WHICH_COMPANY, PDO::PARAM_STR);
                                                    $SMSquery->bindParam(':COMPANY2', $WHICH_COMPANY, PDO::PARAM_STR);
                                                    $SMSquery->execute();
                                                    if ($SMSquery->rowCount() > 0) {
                                                        while ($smstitles = $SMSquery->fetch(PDO::FETCH_ASSOC)) {

                                                            $smstitle = $smstitles['title'];
                                                          
                                                            echo "<option value='$smstitle'>$smstitle</option>";
                                                        }
                                                    }
                                                } catch (PDOException $e) {
                                                    echo 'Connection failed: ' . $e->getMessage();
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        
                                        <input type="hidden" id="FullName" name="FullName" value="<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?>">
                                        <input type="hidden" id="phone_number" name="phone_number" value="<?php echo $Single_Client['alt_number']; ?>">
                                        <input type="hidden" id="SMS_INSURER" name="SMS_INSURER" value="<?php echo $SMS_INSURER; ?>">

                                        <br>
                                        <br>

                                        <button type='submit' class='btn btn-success'><i class='fa fa-mobile'></i> SEND SMS</button>

                                    </form>

                    <?php }
                } else { ?>

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
$fileuploaded = filter_input(INPUT_GET, 'fileuploaded', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($fileuploaded)) {
    $uploadtypeuploaded = filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-upload fa-lg\"></i> Success:</strong> $uploadtypeuploaded uploaded!</div>");
}

$fileuploadedfail = filter_input(INPUT_GET, 'fileuploadedfail', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($fileuploadedfail)) {
    $uploadtypeuploaded = filter_input(INPUT_GET, 'fileupname', FILTER_SANITIZE_SPECIAL_CHARS);
    print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Error:</strong> $uploadtypeuploaded <b>upload failed!</b></div>");
}
                                                    $UPLOAD= filter_input(INPUT_GET, 'UPLOAD', FILTER_SANITIZE_SPECIAL_CHARS);
                                                    if(isset($UPLOAD)) {
                                                        if($UPLOAD=='MAX') {
                                                    echo "<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> The filesize of the upload is too big!</strong></div>";
        
                                                        }
                                                    }
?>
                <div class="container">

                    <form action="/life_upload.php?life=y&CID=<?php echo $search; ?>" method="post" enctype="multipart/form-data">
                        <label for="file">Select file...<input type="file" name="file" /></label> 

                        <label for="uploadtype">
                            <div class="form-group">
                                <select style="width: 170px" class="form-control" name="uploadtype" required>
                                    <option value="">Select...</option>
                                    <option value="Closer Call Recording">Closer Call Recording</option>
                                    <option value="Agent Call Recording">Agent Call Recording</option>
                                    <option value="Dealsheet">Life Dealsheet</option>
                                    <option disabled>──────────</option>
                                    <option value="Admin Call Recording">Admin Call Recording</option>
                                    <option value="Recording">Call Recording</option>
                                    <option value="Happy Call">Happy Call Recording</option>
                                    <option value="LifeCloserAudit">Closer Audit</option>
                                    <option value="LifeLeadAudit">Lead Audit</option>
                                    <option disabled>──────────</option>                                  
                                    <option value="Vitalitypolicy">Vitality App</option>
                                    <option value="Vitalitykeyfacts">Vitality Keyfacts</option>
                                    <option disabled>──────────</option>
                                    <option value="RLpolicy">Royal London App</option>
                                    <option value="RLkeyfacts">Royal London Keyfacts</option>
                                    <option disabled>──────────</option>
                                    <option value="LGpolicy">L&G App</option>
                                    <option value="LGkeyfacts">L&G Keyfacts</option>
                                    <option disabled>──────────</option>
                                    <option value="WOLpolicy">One Family App</option>
                                    <option value="WOLkeyfacts">One Family Keyfacts</option>
                                    <option disabled>──────────</option>
                                    <option value="Avivapolicy">Aviva App</option>
                                    <option value="Avivakeyfacts">Aviva Keyfacts</option>
                                    <option disabled>──────────</option>
                                    <option value="lifenotes">Notes</option>
                                    <option value="Other">Other</option>
                                    <option disabled>──────────</option>
                                </select>
                            </div>
                        </label>
                        
                        <button type="submit" class="btn btn-success" name="btn-upload"><span class="glyphicon glyphicon-arrow-up"> </span></button>
                    </form>
                    <br /><br />

                    <div class="list-group">

                        <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY == 'ADL_CUS') { ?>

                            <span class="label label-primary"><?php echo $Single_Client['title']; ?> <?php echo $Single_Client['last_name']; ?> Letters/Emails</span>
                            <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/PostPackLetter.php?clientone=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Post Pack Letter</a>
                            <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustLetter.php?clientone=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Letter</a>
                            
                                    <?php } if ($WHICH_COMPANY == 'ADL_CUS') { ?>
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustGuide.php?clientone=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Guide</a>
                            <?php } ?>
                                
                            <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/ReinstateLetter.php?clientone=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Reinstate Letter</a>
                            <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/SendAnyQueriesCallUs.php?search=<?php echo $search; ?>&email=<?php echo $clientonemail; ?>&recipient=<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Any Queries Call Us</a>
                            <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/MyAccountDetailsEmail.php?search=<?php echo $search; ?>&email=<?php echo $clientonemail; ?>&recipient=<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; My Account Details Email</a>
                               <?php if ($ffkeyfactsemail == '1') { ?>
                                <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/SendKeyFacts.php?search=<?php echo $search; ?>&email=<?php echo $clientonemail; ?>&recipient=<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Closer Keyfacts Email</a>
                            <?php } ?>
                            <?php if (!empty($Single_Client['first_name2'])) { ?>
                                <span class="label label-primary"><?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['last_name2']; ?> Letters/Emails</span> 
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/PostPackLetter.php?clienttwo=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Post Pack Letter</a>
                                <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                    <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustLetter.php?clienttwo=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Letter</a>
                                   <?php } if ($WHICH_COMPANY == 'ADL_CUS') { ?>
                                    <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustGuide.php?clienttwo=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Trust Guide</a>
                                <?php } ?>
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/ReinstateLetter.php?clienttwo=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Reinstate Letter</a>
                                <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/SendAnyQueriesCallUs.php?search=<?php echo $search; ?>&email=<?php
                                if (!empty($clienttwomail)) {
                                    echo $clienttwomail;
                                } else {
                                    echo $clientonemail;
                                }
                                ?>&recipient=<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Any Queries Call Us</a>
                                <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/MyAccountDetailsEmail.php?search=<?php echo $search; ?>&email=<?php
                                if (!empty($clienttwomail)) {
                                    echo $clienttwomail;
                                } else {
                                    echo $clientonemail;
                                }
                                ?>&recipient=<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; My Account Details Email</a>
                                <?php if ($ffkeyfactsemail == '1') { ?>
                                    <a class="list-group-item confirmation" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "php"; } ?>/SendKeyFacts.php?search=<?php echo $search; ?>&email=<?php
                        if (!empty($clienttwomail)) {
                            echo $clienttwomail;
                        } else {
                            echo $clientonemail;
                        }
                        ?>&recipient=<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?>"><i class="fa  fa-envelope-o fa-fw" aria-hidden="true"></i> &nbsp; Closer Keyfacts Email</a>
        <?php } ?>

                                <span class="label label-primary">Joint Letters/Emails</span>
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/PostPackLetter.php?joint=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Post Pack Letter</a>
                                <?php if ($WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau') { ?>
                                    <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustLetter.php?joint=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Trust Letter</a>
                                <?php } if ($WHICH_COMPANY == 'ADL_CUS') { ?>
                                    <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/TrustGuide.php?joint=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Guide Letter</a>
                                <?php } ?>
                                <a class="list-group-item" href="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Letters"; } else { echo "Templates"; } ?>/ReinstateLetter.php?joint=1&search=<?php echo $search; ?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> &nbsp; Joint Reinstate Letter</a>
                            <?php } ?>

                            <script type="text/javascript">
                                var elems = document.getElementsByClassName('confirmation');
                                var confirmIt = function (e) {
                                    if (!confirm('Are you sure you want to send this email? The email will be immediately sent.'))
                                        e.preventDefault();
                                };
                                for (var i = 0, l = elems.length; i < l; i++) {
                                    elems[i].addEventListener('click', confirmIt, false);
                                }
                            </script>

                            <?php
                        }

                        if ($ffaudits == '1') {
                            if (!empty($closeraudit) || !empty($leadaudit)) {
                                ?> 

                                <span class="label label-primary">Audit Reports</span>                    

                                <?php if (!empty($closeraudit)) { ?>
                                    <a class="list-group-item" href="/audits/closer_form_view.php?auditid=<?php echo $closeraudit; ?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i> &nbsp; Closer Audit</a>
                                <?php } if (!empty($leadaudit)) { ?>
                                    <a class="list-group-item" href="/audits/lead_gen_form_view.php?new=y&auditid=<?php echo $leadaudit; ?>" target="_blank"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i> &nbsp; Lead Audit</a>

                                    <?php
                                }
                            }
                        }

                        if ($ffdialler == '1') {

                            $database->query("SELECT url from connex_accounts");
                            $database->execute();
                            $CONNEX_URL_QRY = $database->single();

                            if (isset($CONNEX_URL_QRY['url'])) {
                                $CONNEX_URL = $CONNEX_URL_QRY['url'];
                            }

                            $database->query("SELECT url from vicidial_accounts WHERE servertype='Database'");
                            $database->execute();
                            $VICIDIAL_URL_QRY = $database->single();

                            if (isset($VICIDIAL_URL_QRY['url'])) {
                                $VICIDIAL_URL = $VICIDIAL_URL_QRY['url'];
                            }

                            if (isset($leadid1) && $leadid1 > '0') {
                                ?>
                                <span class="label label-primary">Call Recordings</span>

                                <?php
                            } if (!empty($leadid1)) {
                                if ($client_date_added >= "2016-11-09 10:00:00") {
                                    ?>
                                    <a class="list-group-item" href="http://<?php
                                    if (isset($VICIDIAL_URL)) {
                                        echo $VICIDIAL_URL;
                                    }
                                    ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Bluetelecoms Call Recording | Lead ID 1</a>
                                    <a class="list-group-item" href="http://<?php
                                       if (isset($CONNEX_URL)) {
                                           echo $CONNEX_URL;
                                       }
                                       ?>/Admin/data/search/edit/?id=<?php echo $leadid1; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Connex Call Recording | Lead ID 1</a>

                                <?php } else {
                                    ?>
                                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid1; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 1</a>
                                    <?php
                                }
                            }
                            if (!empty($leadid2)) {
                                if ($client_date_added >= "2016-11-09 10:00:00") {
                                    ?>
                                    <a class="list-group-item" href="http://<?php
                                    if (isset($VICIDIAL_URL)) {
                                        echo $VICIDIAL_URL;
                                    }
                                    ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 2</a>
                                <?php } else {
                                    ?>
                                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid2; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 2</a>

                                    <?php
                                }
                            }

                            if (!empty($leadid3)) {
                                if ($client_date_added >= "2016-11-09 10:00:00") {
                                    ?>
                                    <a class="list-group-item" href="http://<?php
                                    if (isset($VICIDIAL_URL)) {
                                        echo $VICIDIAL_URL;
                                    }
                                    ?>/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 3</a>

        <?php } else {
            ?>
                                    <a class="list-group-item" href="http://94.23.208.13/vicidial/admin_modify_lead.php?lead_id=<?php echo $leadid3; ?>" target="_blank"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> &nbsp; Dialler Call Recording | Lead ID 3</a>

                                    <?php
                                }
                            }
                        }

                        try {

                            $queryup = $pdo->prepare("SELECT file, uploadtype FROM tbl_uploads WHERE file like :file");
                            $queryup->bindParam(':file', $likesearch, PDO::PARAM_INT);
                            $queryup->execute();

                            if ($queryup->rowCount() > 0) {
                                ?>

                                <span class="label label-primary">Uploads</span>

                                <?php
                                while ($row = $queryup->fetch(PDO::FETCH_ASSOC)) {

                                    $file = $row['file'];
                                    $uploadtype = $row['uploadtype'];

                                    switch ($uploadtype) {
                                        case "Dealsheet":
                                        case "LGpolicy":
                                        case "LGkeyfacts":
                                        case "TONIC PDF":
                                            case "Avivapolicy":
                                                case "Avivakeyfacts":
                                            $typeimage = "fa-file-pdf-o";
                                            break;
                                        case "Happy Call":
                                        case "Recording":
                                        case "LGkeyfacts":
                                        case "TONIC RECORDING":
                                        case "Closer Call Recording":
                                        case "Agent Call Recording":
                                        case "Admin Call Recording":
                                            $typeimage = "fa-headphones";
                                            break;
                                        case "Other":
                                        case "Old Other":
                                            $typeimage = "fa-file-text-o";
                                            break;
                                        case "lifenotes":
                                            $typeimage = "fa-file-text-o";
                                            break;
                                        case "TONIC Acount Updates";
                                            $typeimage = "fa-check-square-o";
                                            break;
                                        case "LifeLeadAudit":
                                        case "LifeCloserAudit":
                                            $typeimage = "fa-folder-open";
                                            break;
                                        default:
                                            $typeimage = $uploadtype;
                                    }

                                    switch ($uploadtype) {
                                        case "Avivakeyfacts":
                                            $uploadtype = "Aviva Keyfacts";
                                            break;
                                         case "Avivapolicy":
                                            $uploadtype = "Aviva Policy";
                                            break;
                                        case "LGkeyfacts":
                                            $uploadtype = "L&G Keyfacts";
                                            break;
                                        case "LGpolicy":
                                            $uploadtype = "L&G APP";
                                            break;
                                        case "lifenotes":
                                            $uploadtype = "Notes";
                                            break;
                                        case "LifeCloserAudit":
                                            $uploadtype = "Closer Audit";
                                            break;
                                        case "LifeLeadAudit":
                                            $uploadtype = "Life Audit";
                                            break;
                                        default:
                                            $uploadtype;
                                    }
                                    if ($uploadtype == 'TONIC RECORDING') {
                                        $newfileholder = str_replace("$search-", "", "$file"); //remove quote
                                        ?>

                                        <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholder"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                        <?php
                                    }

                                    if ($uploadtype == 'TONIC PDF') {
                                        $newfileholderPDF = str_replace("$search-", "", "$file"); //remove quote
                                        ?>

                                        <a class="list-group-item" href="../uploads/TONIC_FILES/hwifs.tonicpower.co.uk/archive/lifeprotectbureau/<?php echo "$search/$newfileholderPDF"; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>

                                        <?php
                                    }
                                    
                                     if ($row['uploadtype'] == 'Avivapolicy' || $row['uploadtype'] =='Avivakeyfacts') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }                                   

                                    if ($row['uploadtype'] == 'Other') {
                                        ?>
                                        <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php
                                    }

                                    if ($row['uploadtype'] == 'Old Other') {
                                        ?>
                                        <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php
                                    }

                                    if ($row['uploadtype'] == 'RECORDING' || $row['uploadtype'] == 'Closer Call Recording' || $row['uploadtype'] == 'Agent Call Recording' || $row['uploadtype'] == 'Admin Call Recording') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'lifenotes') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }
                                   
                                    if ($row['uploadtype'] == 'Dealsheet') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'LGkeyfacts') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }
                                    if ($row['uploadtype'] == 'LGpolicy') {
                                        if (!file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'L&G APP') {
                                        if (!file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'LifeCloserAudit') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'LifeLeadAudit') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'Recording') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                        <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                                            <?php
                                        }
                                    }

                                    if ($row['uploadtype'] == 'Happy Call') {
                                        if (file_exists("../uploads/$file")) {
                                            ?>
                                            <a class="list-group-item" href="../uploads/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                <?php } else { ?>
                                            <a class="list-group-item" href="../uploads/life/<?php echo $search; ?>/<?php echo $file; ?>" target="_blank"><i class="fa <?php echo $typeimage; ?> fa-fw" aria-hidden="true"></i> &nbsp; <?php echo "$uploadtype | $file"; ?></a>
                    <?php
                }
            }
        }
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
                    </div>

                            <?php if (in_array($hello_name, $Level_10_Access, true)) { ?>

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

                                            $i = 0;
                                            if ($query->rowCount() > 0) {
                                                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                                    $i++;
                                                    $FILElocation = $row['file'];
                                                    ?>

                                            <tr>
                                                <td><?php echo $row['file'] ?></td>
                                                <td><?php echo $row['uploadtype'] ?></td>
                                                <td><a href="<?php
                                    if (file_exists("../uploads/$FILElocation")) {
                                        echo "../uploads/$FILElocation";
                                    } else {
                                        echo "../uploads/life/$search/$FILElocation";
                                    }
                                    ?>" target="_blank"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-search"></span> </button></a></td>
                                                <td>

                                                    <form name="deletefileconfirm" id="deletefileconfirm<?php echo $i ?>" action="../php/DeleteUpload.php?deletefile=1" method="POST">
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
                                        document.querySelector('#deletefileconfirm<?php echo $i ?>').addEventListener('submit', function (e) {
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
                                                    function (isConfirm) {
                                                        if (isConfirm) {
                                                            swal({
                                                                title: 'Deleted!',
                                                                text: 'File deleted!',
                                                                type: 'success'
                                                            }, function () {
                                                                form.submit();
                                                            });

                                                        } else {
                                                            swal("Cancelled", "No files were deleted", "error");
                                                        }
                                                    });
                                        });
                                    </script>

                        <?php
                    }
                } catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();
                }
            }
            ?>
                    </table>
                </div>
            </div>

                    <?php
                    try {

                        $query55 = $pdo->prepare("SELECT leadauditid, client_id, title, first_name, last_name, email, title2, first_name2, last_name2, dob2, email2 FROM client_details WHERE client_id =:data2searchholder");
                        $query55->bindParam(':data2searchholder', $search, PDO::PARAM_INT);
                        $query55->execute();
                        $Single_Client = $query55->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo 'Connection failed: ' . $e->getMessage();
                    }
                    ?>

            <div id="menu3" class="tab-pane fade">
                <div class="container">

<?php
try {

    $LG_FIN = $pdo->prepare("SELECT financial_statistics_history.*, client_policy.policy_number, client_policy.CommissionType, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM financial_statistics_history join client_policy on financial_statistics_history.Policy = client_policy.policy_number WHERE client_id=:id GROUP BY financial_statistics_history.id");
    $LG_FIN->bindParam(':id', $search, PDO::PARAM_INT);
    $LG_FIN->execute()or die(print_r($LG_FIN->errorInfo(), true));
    if ($LG_FIN->rowCount() > 0) {
        ?>

                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Legal and General</th>
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
                                while ($row = $LG_FIN->fetch(PDO::FETCH_ASSOC)) {

                                    if (isset($row['payment'])) {

                                        $formattedpayment = number_format($row['payment'], 2);
                                    }

                                    if (isset($row['deduction'])) {

                                        $formatteddeduction = number_format($row['deduction'], 2);
                                    }

                                    if (isset($row['policy_number'])) {

                                        $clientid = $row['policy_number'];
                                    }

                                    if (isset($row['POLID'])) {

                                        $PID = $row['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $row['insert_date'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $row['Policy'] . "</a></td>";
                                    echo "<td>" . $row['CommissionType'] . "</td>";
                                    echo "<td>" . $row['policystatus'] . "</td>";
                                    echo "<td>" . $row['closer'] . "</td>";
                                    echo "<td>" . $row['lead'] . "</td>";
                                    if (intval($row['Payment_Amount']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $row['Payment_Amount'] . "</span></td>";
                                    } else if (intval($row["Payment_Amount"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $row['Payment_Amount'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $row['Payment_Amount'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                }
                            }
                        } catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
                        }
                        ?>
                    </table>
<?php
try {

    $VIT_FIN = $pdo->prepare("SELECT vitality_financials.vitality_insert_date, vitality_financials.vitality_comm, vitality_financials.vitality_comm_status, client_policy.policy_number, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM vitality_financials join client_policy on vitality_financials.vitality_policy = client_policy.policy_number WHERE client_policy.client_id=:id GROUP BY vitality_financials.vitality_id");
    $VIT_FIN->bindParam(':id', $search, PDO::PARAM_INT);
    $VIT_FIN->execute()or die(print_r($VIT_FIN->errorInfo(), true));
    if ($VIT_FIN->rowCount() > 0) {
        ?>

                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Vitality</th>
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
                                while ($row = $VIT_FIN->fetch(PDO::FETCH_ASSOC)) {

                                    if (isset($row['POLID'])) {

                                        $PID = $row['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $row['vitality_insert_date'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $row['policy_number'] . "</a></td>";
                                    echo "<td>" . $row['vitality_comm_status'] . "</td>";
                                    echo "<td>" . $row['policystatus'] . "</td>";
                                    echo "<td>" . $row['closer'] . "</td>";
                                    echo "<td>" . $row['lead'] . "</td>";
                                    if (intval($row['vitality_comm']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $row['vitality_comm'] . "</span></td>";
                                    } else if (intval($row["vitality_comm"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $row['vitality_comm'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $row['vitality_comm'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                }
                            }
                        } catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
                        }
                        ?>

                    </table>

<?php
try {

    $RL_FIN = $pdo->prepare("SELECT royal_london_financials.royal_london_insert_date, royal_london_financials.royal_london_comm, royal_london_financials.royal_london_type, client_policy.policy_number, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM royal_london_financials join client_policy on royal_london_financials.royal_london_policy = client_policy.policy_number WHERE client_policy.client_id=:id GROUP BY royal_london_financials.royal_london_id");
    $RL_FIN->bindParam(':id', $search, PDO::PARAM_INT);
    $RL_FIN->execute()or die(print_r($RL_FIN->errorInfo(), true));
    if ($RL_FIN->rowCount() > 0) {
        ?>

                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>Royal London</th>
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
                                while ($row = $RL_FIN->fetch(PDO::FETCH_ASSOC)) {

                                    if (isset($row['POLID'])) {

                                        $PID = $row['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $row['royal_london_insert_date'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $row['policy_number'] . "</a></td>";
                                    echo "<td>" . $row['royal_london_type'] . "</td>";
                                    echo "<td>" . $row['policystatus'] . "</td>";
                                    echo "<td>" . $row['closer'] . "</td>";
                                    echo "<td>" . $row['lead'] . "</td>";
                                    if (intval($row['royal_london_comm']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $row['royal_london_comm'] . "</span></td>";
                                    } else if (intval($row["royal_london_comm"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $row['royal_london_comm'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $row['royal_london_comm'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                }
                            }
                        } catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
                        }
                        ?>

                    </table>

<?php
try {

    $WOL_FIN = $pdo->prepare("SELECT wol_financials.wol_insert_date, wol_financials.wol_comm, wol_financials.wol_comm_type, client_policy.policy_number, client_policy.policystatus, client_policy.closer, client_policy.lead, client_policy.id AS POLID FROM wol_financials join client_policy on wol_financials.wol_policy = client_policy.policy_number WHERE client_policy.client_id=:id GROUP BY wol_financials.wol_id");
    $WOL_FIN->bindParam(':id', $search, PDO::PARAM_INT);
    $WOL_FIN->execute()or die(print_r($WOL_FIN->errorInfo(), true));
    if ($WOL_FIN->rowCount() > 0) {
        ?>

                            <table  class='table table-hover table-condensed'>
                                <thead>
                                    <tr>
                                        <th colspan='7'>One Family</th>
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
                                while ($row = $WOL_FIN->fetch(PDO::FETCH_ASSOC)) {

                                    if (isset($row['POLID'])) {

                                        $PID = $row['POLID'];
                                    }

                                    echo '<tr>';
                                    echo "<td>" . $row['wol_insert_date'] . "</td>";
                                    echo "<td><a href='ViewPolicy.php?policyID=$PID&search=$search&WHICH_COMPANY=$WHICH_COMPANY'>" . $row['policy_number'] . "</a></td>";
                                    echo "<td>" . $row['wol_comm_type'] . "</td>";
                                    echo "<td>" . $row['policystatus'] . "</td>";
                                    echo "<td>" . $row['closer'] . "</td>";
                                    echo "<td>" . $row['lead'] . "</td>";
                                    if (intval($row['wol_comm']) > 0) {
                                        echo "<td><span class=\"label label-success\">" . $row['wol_comm'] . "</span></td>";
                                    } else if (intval($row["wol_comm"]) < 0) {
                                        echo "<td><span class=\"label label-danger\">" . $row['wol_comm'] . "</span></td>";
                                    } else {
                                        echo "<td>" . $row['wol_comm'] . "</td>";
                                    }
                                    echo "</tr>";
                                    echo "\n";
                                }
                            }
                        } catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
                        }
                        ?>

                    </table>                    

                </div>
            </div>

            <div id="menu4" class="tab-pane fade">

                <?php
                $clientnotesadded = filter_input(INPUT_GET, 'clientnotesadded', FILTER_SANITIZE_SPECIAL_CHARS);
                if (isset($clientnotesadded)) {
                    print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-pencil fa-lg\"></i> Success:</strong> Client notes added!</div>");
                }

                $TaskSelect = filter_input(INPUT_GET, 'TaskSelect', FILTER_SANITIZE_SPECIAL_CHARS);

                if (isset($TaskSelect)) {
                    if ($TaskSelect == 'CYD') {

                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> CYD Task Updated!</div>";
                    }

                    if ($TaskSelect == '5 day') {

                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 5 Day Task Updated!</div>";
                    }

                    if ($TaskSelect == '24 48') {

                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 24-48 Day Task Updated!</div>";
                    }

                    if ($TaskSelect == '18 day') {

                        echo "<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check\"></i> Success:</strong> 18 Day Task Updated!</div>";
                    }
                }

                if ($client_date_added >= "2016-06-19" && $WHICH_COMPANY == 'Bluestone Protect' || $WHICH_COMPANY=='The Review Bureau' || $WHICH_COMPANY=='ADL Legal and General' || $WHICH_COMPANY == 'ADL_CUS') {

                    $database->query("select Task, Upsells, PitchTrust, PitchTPS, RemindDD, CYDReturned, DocsArrived, HappyPol FROM Client_Tasks where client_id=:cid");
                    $database->bind(':cid', $search);
                    $database->execute();
                    $result = $database->single();

                    $HappyPol = $result['HappyPol'];
                    $DocsArrived = $result['DocsArrived'];
                    $CYDReturned = $result['CYDReturned'];
                    $RemindDD = $result['RemindDD'];
                    $PitchTPS = $result['PitchTPS'];
                    $PitchTrust = $result['PitchTrust'];
                    $Upsells = $result['Upsells'];
                    $Taskoption = $result['Task'];
                    ?>
                    <center>
                        <br><br>

                        <div class="btn-group">
                            <button data-toggle="collapse" data-target="#HappyPol" class="<?php
                            if (empty($HappyPol)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Happy with Policy <br><?php echo $HappyPol; ?></button>                 
                            <button data-toggle="collapse" data-target="#DocsArrived" class="<?php
                            if (empty($DocsArrived)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Docs Emailed? <br><?php echo $DocsArrived; ?></button>
                            <button data-toggle="collapse" data-target="#CYDReturned" class="<?php
                            if (empty($CYDReturned)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">CYD Returned? <br><?php echo $CYDReturned; ?></button>
                            <button data-toggle="collapse" data-target="#RemindDD" class="<?php
                            if (empty($RemindDD)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Remind/Cancel Old/New DD <br><?php echo $RemindDD; ?></button>
                            <button data-toggle="collapse" data-target="#PitchTPS" class="<?php
                            if (empty($PitchTPS)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Pitch TPS <br><?php echo $PitchTPS; ?></button>
                            <button data-toggle="collapse" data-target="#PitchTrust" class="<?php
                            if (empty($PitchTrust)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Pitch Trust <br><?php echo $PitchTrust; ?></button>
                            <button data-toggle="collapse" data-target="#Upsells" class="<?php
                            if (empty($Upsells)) {
                                echo "btn btn-danger";
                            } else {
                                echo "btn btn-success";
                            }
                            ?>">Upsells <br><?php echo $Upsells; ?></button>
                        </div>

                        <br><br>


                        <form name="ClientTaskForm" id="ClientTaskForm" class="form-horizontal" method="POST" action="php/ClientTaskPull.php?search=<?php echo "$search"; ?>">

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
                                            <input name="HappyPol" id="HappyPol-0" value="No" type="radio" <?php
                            if (isset($HappyPol)) {
                                if ($HappyPol == 'No') {
                                    echo "checked='checked'";
                                }
                            }
                            ?>>
                                            No
                                        </label> 
                                        <label class="radio-inline" for="HappyPol-1">
                                            <input name="HappyPol" id="HappyPol-1" value="Yes" type="radio" <?php
                            if (isset($HappyPol)) {
                                if ($HappyPol == 'Yes') {
                                    echo "checked='checked'";
                                }
                            }
                            ?>>
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
                                            <input name="DocsArrived" id="DocsArrived-0" value="No"  type="radio" <?php
                                        if (isset($DocsArrived)) {
                                            if ($DocsArrived == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            No
                                        </label> 
                                        <label class="radio-inline" for="DocsArrived-1">
                                            <input name="DocsArrived" id="DocsArrived-1" value="Yes" type="radio" <?php
                                        if (isset($DocsArrived)) {
                                            if ($DocsArrived == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Yes
                                        </label>
                                        <label class="radio-inline" for="DocsArrived-3">
                                            <input name="DocsArrived" id="DocsArrived-3" value="Not Checked" type="radio" <?php
                                        if (isset($DocsArrived)) {
                                            if ($DocsArrived == 'Not Checked') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
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
                                            <input name="CYDReturned" id="CYDReturned-0" value="Yes complete with Legal and General"  type="radio" <?php
                                        if (isset($CYDReturned)) {
                                            if ($CYDReturned == 'Yes complete with Legal and General') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Yes complete with Legal and General
                                        </label> 
                                        <label class="radio-inline" for="CYDReturned-1">
                                            <input name="CYDReturned" id="CYDReturned-1" value="Yes Legal and General not received" type="radio" <?php
                                        if (isset($CYDReturned)) {
                                            if ($CYDReturned == 'Yes Legal and General not received') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Yes Legal and General not received
                                        </label> 
                                        <label class="radio-inline" for="CYDReturned-2">
                                            <input name="CYDReturned" id="CYDReturned-2" value="No" type="radio" <?php
                                        if (isset($CYDReturned)) {
                                            if ($CYDReturned == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
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
                                            <input name="RemindDD" id="RemindDD-0" value="Old DD Cancelled"  type="radio" <?php
                                        if (isset($RemindDD)) {
                                            if ($RemindDD == 'Old DD Cancelled') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Old DD Cancelled
                                        </label> 
                                        <label class="radio-inline" for="RemindDD-1">
                                            <input name="RemindDD" id="RemindDD-1" value="Old DD Not Cancelled" type="radio" <?php
                                        if (isset($RemindDD)) {
                                            if ($RemindDD == 'Old DD Not Cancelled') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Old DD Not Cancelled
                                        </label> 
                                        <label class="radio-inline" for="RemindDD-2">
                                            <input name="RemindDD" id="RemindDD-2" value="Replacing Legal and General" type="radio" <?php
                                        if (isset($RemindDD)) {
                                            if ($RemindDD == 'Replacing Legal and General') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Replacing Legal and General
                                        </label> 
                                        <label class="radio-inline" for="RemindDD-3">
                                            <input name="RemindDD" id="RemindDD-3" value="Keeping Old Policy" type="radio" <?php
                                        if (isset($RemindDD)) {
                                            if ($RemindDD == 'Keeping Old Policy') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Keeping Old Policy
                                        </label>
                                        <label class="radio-inline" for="RemindDD-4">
                                            <input name="RemindDD" id="RemindDD-4" value="New Policy" type="radio" <?php
                                        if (isset($RemindDD)) {
                                            if ($RemindDD == 'New Policy') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
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
                                            <input name="PitchTPS" id="PitchTPS-0" value="Wants"  type="radio" <?php
                                        if (isset($PitchTPS)) {
                                            if ($PitchTPS == 'Wants') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Wants
                                        </label> 
                                        <label class="radio-inline" for="PitchTPS-1">
                                            <input name="PitchTPS" id="PitchTPS-1" value="Doesnt Want" type="radio" <?php
                                        if (isset($PitchTPS)) {
                                            if ($PitchTPS == 'Doesnt Want') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
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
                                            <input name="PitchTrust" id="PitchTrust-0" value="Wants by Post"  type="radio" <?php
                                        if (isset($PitchTrust)) {
                                            if ($PitchTrust == 'Wants by Post') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Wants by Post
                                        </label> 
                                        <label class="radio-inline" for="PitchTrust-1">
                                            <input name="PitchTrust" id="PitchTrust-1" value="Wants by Email" type="radio" <?php
                                        if (isset($PitchTrust)) {
                                            if ($PitchTrust == 'Wants by Email') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
                                            Wants by Email
                                        </label> 
                                        <label class="radio-inline" for="PitchTrust-2">
                                            <input name="PitchTrust" id="PitchTrust-2" value="Doesnt Want" type="radio" <?php
                                        if (isset($PitchTrust)) {
                                            if ($PitchTrust == 'Doesnt Want') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            Doesnt Want
                                        </label> 
                                        <label class="radio-inline" for="PitchTrust-3">
                                            <input name="PitchTrust" id="PitchTrust-3" value="Both" type="radio"<?php
                                        if (isset($PitchTrust)) {
                                            if ($PitchTrust == 'Both') {
                                                echo "checked='checked'";
                                            }
                                        }
                            ?>>
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
                                            <input name="Upsells" id="Upsells-0" value="No"  type="radio" <?php
                                        if (isset($Upsells)) {
                                            if ($Upsells == 'No') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
                                            No
                                        </label> 
                                        <label class="radio-inline" for="Upsells-1">
                                            <input name="Upsells" id="Upsells-1" value="Yes" type="radio" <?php
                                        if (isset($Upsells)) {
                                            if ($Upsells == 'Yes') {
                                                echo "checked='checked'";
                                            }
                                        }
                                        ?>>
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
                            <input type="hidden" name="client_id" value="<?php echo $search ?>">

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="client_name"></label>
                                <div class="col-md-4">
                                    <select id="selectbasic" name="client_name" class="form-control" required>
                                        <option value="<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?>"><?php echo $Single_Client['first_name']; ?> <?php echo $Single_Client['last_name']; ?></option>
<?php if (!empty($Single_Client['title2'])) { ?>
                                            <option value="<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?>"><?php echo $Single_Client['first_name2']; ?> <?php echo $Single_Client['last_name2']; ?></option>
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
                            if ($clientnote->rowCount() > 0) {
                                while ($result = $clientnote->fetch(PDO::FETCH_ASSOC)) {

                                    switch ($result['note_type']) {

                                        case "Client Added":
                                            $TMicon = "fa-user-plus";
                                            break;
                                        case "Policy Deleted":
                                            $TMicon = "fa-exclamation";
                                            break;
                                        case "CRM Alert":
                                        case "Policy Added":
                                            $TMicon = "fa-check";
                                            break;
                                        case "Client SMS Reply":
                                            $TMicon = "fa-phone-square";
                                            break;
                                        case "EWS Status update":
                                        case"EWS Uploaded";
                                        case"SMS Failed";
                                            $TMicon = "fa-exclamation-triangle";
                                            break;
                                        case "Deleted File Upload";
                                            $TMicon="fa-trash";
                                            break;
                                        case "Financial Uploaded":
                                        case "Legal and General Financial Uploaded":
                                        case "Royal London Financial Uploaded":
                                        case "Aviva Financial Uploaded":
                                        case "Vitality Financial Uploaded":
                                        case "One Family Financial Uploaded":
                                        case "WOL Financial Uploaded":
                                            $TMicon = "fa-gbp";
                                            break;
                                        case "Dealsheet":
                                        case"LGpolicy";
                                        case"LGkeyfacts";
                                            case"Avivakeyfacts";
                                                case"Avivapolicy";
                                        case"Recording";
                                        case"Closer Call Recording";
                                        case"Agent Call Recording";
                                        case"Admin Call Recording";
                                            $TMicon = "fa-upload";
                                            break;

                                        case stristr($result['note_type'], "Tasks"):
                                            $TMicon = "fa-tasks";
                                            break;
                                        case stristr($result['note_type'], "Callback"):
                                            $TMicon = "fa-calendar-check-o";
                                            break;

                                        case "Client Note":
                                        case "Policy Details Updated":
                                        case "Policy Update":
                                            $TMicon = "fa-pencil";
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
                                            $TMicon = "fa-tasks";
                                            break;
                                        case "Email Sent":
                                            $TMicon = "fa-envelope-o";
                                            break;
                                        case "Client Edited":
                                        case "TONIC Acount Updates ":
                                        case "Client Details Updated":
                                            $TMicon = "fa-edit";
                                            break;
                                        case "SMS Delivered":
                                        case "SMS Update":
                                            $TMicon = "fa-mobile-phone";
                                            break;
                                        case "Sent SMS":
                                        case "Callback":
                                            case stristr($result['note_type'], "Sent SMS"):
                                                case stristr($result['note_type'], "Already Sent SMS"):
                                            $TMicon = "fa-phone";
                                            break;
                                        default:
                                            $TMicon = "fa-bomb";
                                    }

                                    $TIMELINE_MESSAGE = html_entity_decode($result['message']);
                                    echo '<tr>';
                                    echo "<td>" . $result['date_sent'] . "</td>";
                                    echo "<td>" . $result['sent_by'] . "</td>";
                                    echo "<td>" . $result['client_name'] . "</td>";
                                    echo "<td><i class='fa $TMicon'></i> " . $result['note_type'] . "</td>";

                                    if (in_array($hello_name, $Level_3_Access, true)) {

                                        echo "<td><b>$TIMELINE_MESSAGE</b></td>";
                                    } else {

                                        echo "<td><b>$TIMELINE_MESSAGE</b></td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<br><br><div class=\"notice notice-warning\" role=\"alert\"><strong>Info!</strong> No data/information found (Client notes)</div>";
                            }
                            echo "</table>";
                        } catch (PDOException $e) {
                            echo 'Connection failed: ' . $e->getMessage();
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
                        <h4 class="modal-title">Email: <?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['last_name2']; ?> <i>(<?php echo $Single_Client['email2']; ?>)</i></h4>
                    </div>
                    <div class="modal-body">
<?php if ($ffclientemails == '1') { ?>

                            <form class="AddClient" method="post" action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "../email/php"; } ?>/ViewClientEmailSend.php?life=y" enctype="multipart/form-data">

                                <input type="hidden" name="keyfield" value="<?php echo $search; ?>">
                                <input type="hidden" name="recipient" value="<?php echo $Single_Client['title2']; ?> <?php echo $Single_Client['last_name2']; ?>" readonly>
                                <input type="hidden" name="email" value="<?php echo $Single_Client['email2']; ?>" readonly>
                                <input type="hidden" name="note_type" value="Email Sent">

                                <p>
                                    <label for="subject">Subject</label>
                                    <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                                </p>
                                <p>
                                    <textarea name="message" id="message" class="summernote" id="contents" title="Contents" placeholder="Message"></textarea><br />
                                    <label for="attachment1">Attachment:</label>
                                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                                    <label for="attachment2">Attachment 2:</label>
                                    <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                                    <label for="attachment3">Attachment 3:</label>
                                    <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                                    <label for="attachment4">Attachment 4:</label>
                                    <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                                    <label for="attachment5">Attachment 5:</label>
                                    <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                                    <label for="attachment6">Attachment 6:</label>
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
                        <h4 class="modal-title">Email: <?php echo $Single_Client['title']; ?> <?php echo $Single_Client['last_name']; ?> <i>(<?php echo $Single_Client['email']; ?>)</i></h4>
                    </div>
                    <div class="modal-body">
<?php if ($ffclientemails == '1') { ?>

                            <form class="AddClient" method="post" action="<?php if(isset($WHICH_COMPANY) && $WHICH_COMPANY=='Bluestone Protect') { echo "Emails"; } else { echo "../email/php"; } ?>/ViewClientEmailSend.php?life=y" enctype="multipart/form-data" novalidate>

                                <input type="hidden" name="keyfield" value="<?php echo $search; ?>">
                                <input type="hidden" name="recipient" value="<?php echo $Single_Client['title']; ?> <?php echo $Single_Client['last_name']; ?>" readonly>
                                <input type="hidden" name="email" value="<?php echo $Single_Client['email']; ?>" readonly>
                                <input type="hidden" name="note_type" value="Email Sent">

                                <p>
                                    <label for="subject">Subject</label>
                                    <input name="subject" id="subject" placeholder="Subject/Title" type="text" required/>
                                </p>

                                <p>

                                    <textarea name="message" id="message" class="summernote" id="contents" title="Contents" placeholder="Message"></textarea><br />
                                    <label for="attachment1">Attachment:</label>
                                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                                    <label for="attachment2">Attachment 2:</label>
                                    <input type="file" name="fileToUpload2" id="fileToUpload2"><br>
                                    <label for="attachment3">Attachment 3:</label>
                                    <input type="file" name="fileToUpload3" id="fileToUpload3"><br>
                                    <label for="attachment4">Attachment 4:</label>
                                    <input type="file" name="fileToUpload4" id="fileToUpload4"><br>
                                    <label for="attachment5">Attachment 5:</label>
                                    <input type="file" name="fileToUpload5" id="fileToUpload5"><br>
                                    <label for="attachment6">Attachment 6:</label>
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

                                            <form class="form-horizontal" action='../php/AddCallback.php?setcall=y&search=<?php echo $search; ?>' method='POST'>                
                                                <fieldset>

                                                    <div class='container'>
                                                        <div class='row'>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <select id='getcallback_client' name='callbackclient' class='form-control'>
                                                                        <option value='<?php echo $clientonefull; ?>'><?php echo $clientonefull; ?></option>
                                                                        <option value='<?php echo $clienttwofull; ?>'><?php echo $clienttwofull; ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class='row'>
                                                            <div class='col-md-4'>
                                                                <div class='form-group'>
                                                                    <select id='assign' name='assign' class='form-control'>
                                                                        <option value='<?php echo $hello_name; ?>'><?php echo $hello_name; ?></option>

                                                                        <?php
                                                                        try {

                                                                            $calluser = $pdo->prepare("SELECT login, real_name from users where extra_info ='User'");

                                                                            $calluser->execute()or die(print_r($calluser->errorInfo(), true));
                                                                            if ($calluser->rowCount() > 0) {
                                                                                while ($row = $calluser->fetch(PDO::FETCH_ASSOC)) {
                                                                                    ?>

                                                                                    <option value='<?php echo $row['login']; ?>'><?php echo $row['real_name']; ?></option>

                                                                                    <?php
                                                                                }
                                                                            }
                                                                        } catch (PDOException $e) {
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
                                                                        <input type='text' class="form-control" id="callback_date" name="callbackdate" placeholder="YYYY-MM-DD" value="<?php
                                                                        if (isset($CB_DATE)) {
                                                                            echo $CB_DATE;
                                                                        }
                                                                        ?>" required />
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
                                                                        <input type='text' class="form-control" id="clockpicker" name="callbacktime" placeholder="24 Hour Format" value="<?php
                                                                        if (isset($CB_TIME)) {
                                                                            echo $CB_TIME;
                                                                        }
                                                                        ?>" required  />
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
                                                                    <textarea class="form-control summernote" id="textarea" name="callbacknotes" placeholder="Call back notes"><?php
                                                                        if (isset($NOTES)) {
                                                                            echo $NOTES;
                                                                        }
                                                                        ?></textarea>
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
                                                if ($query->rowCount() > 0) {
                                                    ?>

                                                <table class="table table-hover">
                                                    <thead>                    
                                                    <th>Client</th>
                                                    <th>Callback</th>
                                                    <th></th>
                                                    </thead>

                                                    <?php
                                                    while ($calllist = $query->fetch(PDO::FETCH_ASSOC)) {

                                                        $callbackid = $calllist['id'];
                                                        $search = $calllist['client_id'];
                                                        $NAME = $calllist['client_name'];
                                                        $TIME = $calllist['calltimeid'];
                                                        $NOTES = $calllist['notes'];
                                                        $REMINDER = $calllist['reminder'];
                                                        $CB_DATE = $calllist['callback_date'];
                                                        $CB_TIME = $calllist['callback_time'];

                                                        echo "<tr>";
                                                        echo "<td class='text-left'><a href='/Life/ViewClient.php?search=$search'>" . $calllist['client_name'] . "</a></td>";
                                                        echo "<td class='text-left'>" . $calllist['calltimeid'] . "</td>";
                                                        echo "<td><a href='/php/AddCallback.php?search=$search&callbackid=$callbackid&cb=y' class='btn btn-success btn-sm'><i class='fa fa-check'></i> Complete</a></td>";
                                                        echo "</tr>";
                                                        ?>    

    <?php } ?>
                                                </table>   

    <?php
} else {
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

        <script type="text/javascript" src="/clockpicker-gh-pages/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
        <script type="text/javascript">
                            $('.clockpicker').clockpicker()
                                    .find('input').change(function () {
                            });
        </script>
        <script type="text/javascript" src="/clockpicker-gh-pages/assets/js/highlight.min.js"></script>
        <script>
                            document.querySelector('#clientnotessubtab').addEventListener('submit', function (e) {
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
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                swal({
                                                    title: 'Notes submitted!',
                                                    text: 'Notes saved!',
                                                    type: 'success'
                                                }, function () {
                                                    form.submit();
                                                });

                                            } else {
                                                swal("Cancelled", "No changes were made", "error");
                                            }
                                        });
                            });
        </script>
        <script>
            document.querySelector('#ClientTaskForm').addEventListener('submit', function (e) {
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
                        function (isConfirm) {
                            if (isConfirm) {
                                swal({
                                    title: 'Updated!',
                                    text: 'Task Updated!',
                                    type: 'success'
                                }, function () {
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
            $('textarea').keyup(function () {
                var length = $(this).val().length;
                var length = maxLength - length;
                $('#chars').text(length);
            });</script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script>
            $(function () {
                $("#callback_date").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true
                });
            });
            $("#CLICKTOHIDEDEALSHEET").click(function () {
                $("#HIDEDEALSHEET").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDECLOSERKF").click(function () {
                $("#HIDECLOSERKF").fadeOut("slow", function () {

                });
            });

            $("#CLICKTOHIDELGKEY").click(function () {
                $("#HIDELGKEY").fadeOut("slow", function () {

                });
            });

            $("#CLICKTOHIDELGAPP").click(function () {
                $("#HIDELGAPP").fadeOut("slow", function () {

                });
            });

            $("#CLICKTOHIDEDUPEPOL").click(function () {
                $("#HIDEDUPEPOL").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDENEWPOLICY").click(function () {
                $("#HIDENEWPOLICY").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDECLOSER").click(function () {
                $("#HIDECLOSER").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDELEADID").click(function () {
                $("#HIDELEADID").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDELEAD").click(function () {
                $("#HIDELEAD").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDEGLEAD").click(function () {
                $("#HIDEGLEAD").fadeOut("slow", function () {

                });
            });
            $("#CLICKTOHIDEGCLOSER").click(function () {
                $("#HIDEGCLOSER").fadeOut("slow", function () {

                });
            });
            $(document).ready(function () {
                $("#SHOW_ALERTS").hide("fast", function () {
                    // Animation complete
                });
            });

            $("#SHOW_ALERTS").click(function () {
                $("#HIDELGAPP,#HIDELEADID,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY,#HIDELEAD,#HIDECLOSER,#HIDEGLEAD,#HIDEGCLOSER,#SHOW_ALERTS").fadeIn("slow", function () {
                    // Animation complete
                });
                $("#HIDE_ALERTS").fadeIn("slow", function () {
                    // Animation complete
                });
                $("#SHOW_ALERTS").fadeOut("slow", function () {
                    // Animation complete
                });
            });
            $("#HIDE_ALERTS").click(function () {
                $("#HIDELGAPP,#HIDELEADID,#HIDELGKEY,#HIDECLOSERKF,#HIDEDEALSHEET,#HIDEDUPEPOL,#HIDENEWPOLICY,#HIDELEAD,#HIDECLOSER,#HIDEGLEAD,#HIDEGCLOSER,#HIDE_ALERTS").fadeOut("slow", function () {
                    // Animation complete
                });
                $("#SHOW_ALERTS").fadeIn("slow", function () {
                    // Animation complete
                });
            });
        </script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script src="/js/sweet-alert.min.js"></script>
        <script type="text/javascript" src="/summernote-master/dist/summernote.js"></script>

        <script type="text/javascript">
            $(function () {
                $('.summernote').summernote({
                    height: 200
                });


            });
        </script>
        <script>

            $(document).ready(function () {
                if (window.location.href.split('#').length > 1)
                {
                    $tab_to_nav_to = window.location.href.split('#')[1];
                    if ($(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']").length)
                    {
                        $(".nav-pills > li > a[href='#" + $tab_to_nav_to + "']")[0].click();
                    }
                }
            });

        </script>
        <script>
            $(function () {
                $('#selectopt').change(function () {
                    $('.SELECTED_SMS').hide();
                    $('#' + $(this).val()).show();
                });
            });
        </script>
<?php require_once(__DIR__ . '/../php/Holidays.php'); ?>
</body>
</html>
<?php } else {
        header('Location: /..//CRMmain.php?AccessDenied');
    die;
}