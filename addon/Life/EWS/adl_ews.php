<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2018 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2018
 * 
 * ADL CRM makes use of the following third party open sourced software/tools:
 *  DataTables - https://github.com/DataTables/DataTables
 *  EasyAutocomplete - https://github.com/pawelczak/EasyAutocomplete
 *  PHPMailer - https://github.com/PHPMailer/PHPMailer
 *  ClockPicker - https://github.com/weareoutman/clockpicker
 *  fpdf17 - http://www.fpdf.org
 *  summernote - https://github.com/summernote/summernote
 *  Font Awesome - https://github.com/FortAwesome/Font-Awesome
 *  Bootstrap - https://github.com/twbs/bootstrap
 *  jQuery UI - https://github.com/jquery/jquery-ui
 *  Google Dev Tools - https://developers.google.com
 *  Twitter API - https://developer.twitter.com
 *  Webshim - https://github.com/aFarkas/webshim/releases/latest
 * 
*/ 

require_once filter_input(INPUT_SERVER,'DOCUMENT_ROOT', FILTER_SANITIZE_SPECIAL_CHARS).'/app/core/doc_root.php';

include (BASE_URL."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(BASE_URL.'/includes/user_tracking.php'); 

require_once(BASE_URL.'/includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(BASE_URL.'/includes/adl_features.php');
require_once(BASE_URL.'/includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(BASE_URL.'/app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);
$PID = filter_input(INPUT_GET, 'PID', FILTER_SANITIZE_SPECIAL_CHARS);

if(empty($PID)) {
    $PID="OVERVIEW";
    }

    require_once(BASE_URL.'/classes/database_class.php');
    require_once(BASE_URL.'/class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 8) {
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        $ADL_PAGE_TITLE = "EWS";
        require_once(BASE_URL.'/app/core/head.php'); 
        
        ?>
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
    </head>
    <body>

        <?php require_once(BASE_URL.'/includes/navbar.php'); ?>
        
        <div class="container">
            
        <ul class="nav nav-pills">
            <li <?php if(isset($PID) && $PID == "OVERVIEW") { echo "class='active'"; } ?> ><a href="?PID=OVERVIEW">Overview</a></li>
            <li <?php if(isset($PID) && $PID == "MASTER") { echo "class='active'"; } ?> ><a href="?PID=MASTER">Master</a></li>
            <li <?php if(isset($PID) && $PID == "AVI_EWS") { echo "class='active'"; } ?> ><a href="?PID=AVI_EWS">Aviva</a></li>
            <li <?php if(isset($PID) && $PID == "RL_EWS") { echo "class='active'"; } ?> ><a href="?PID=RL_EWS">Royal London</a></li>
            <li <?php if(isset($PID) && $PID == "LV_EWS") { echo "class='active'"; } ?> ><a href="?PID=LV_EWS">LV</a></li>
            <li <?php if(isset($PID) && $PID == "LV_DD_EWS") { echo "class='active'"; } ?> ><a href="?PID=LV_DD_EWS">LV DD</a></li>
            <li <?php if(isset($PID) && $PID == "LV_LAPSED_EWS") { echo "class='active'"; } ?> ><a href="?PID=LV_LAPSED_EWS">LV Lapsed</a></li>
            <li <?php if(isset($PID) && $PID == "UPLOAD_EWS") { echo "class='active'"; } ?> ><a href="?PID=UPLOAD_EWS">Upload Data</a></li>
            <li><a href="/addon/Life/EWS/php/recheck_missing_cids.php?EXECUTE=1">Recheck Client IDs</a></li>
        </ul>

        </div>       
        
    <div class="tab-content">
        
        <?php 
        
        if(isset($PID) && $PID == "OVERVIEW") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "OVERVIEW") { echo "in active"; } ?>" id="OVERVIEW">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EWS Overview</h3>
                    </div>
                    <div class="panel-body">        
            
            <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Updated</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Mod Pol</th>
                            <th>Insurer</th>
                            <th>Orig Status</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Updated</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Mod Pol</th>
                            <th>Insurer</th>
                            <th>Orig Status</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                    
                    </div>
                </div>
        </div>
        
        <?php }
        
if(isset($PID) && $PID == "MASTER") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "MASTER") { echo "in active"; } ?>" id="MASTER">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EWS Overview</h3>
                    </div>
                    <div class="panel-body">        
            
            <table id="MASTER_EWS_TABLE" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Updated</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Mod Pol</th>
                            <th>Insurer</th>
                            <th>Orig Status</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Updated</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Mod Pol</th>
                            <th>Insurer</th>
                            <th>Orig Status</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                    
                    </div>
                </div>
        </div>
        
        <?php }        
        
        if(isset($PID) && $PID == "AVI_EWS") { ?>
        
        <div id="AVI_EWS" class="tab-pane fade <?php if(isset($PID) && $PID == "AVI_EWS") { echo "in active"; } ?>">   
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Aviva EWS</h3>
                    </div>
                    <div class="panel-body">
                        
                            <table id="AVI_EWS_TABLE" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Description</th>
                            <th>Info</th>
                            <th>Reported Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>                          
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Policy</th>
                            <th>Description</th>
                            <th>Info</th>
                            <th>Reported Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 

            </div>  
                </div>
        </div>
        
        <?php }
        
        if(isset($PID) && $PID == "RL_EWS") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "RL_EWS") { echo "in active"; } ?>" id="RL_EWS">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Royal London EWS</h3>
                    </div>
                    <div class="panel-body">   
                        
                        <div class="row">
                            <div class="col-md-12">
            
            <table id="RL_EWS_TABLE" class="display table-condensed" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>  
                            <th>Date</th>
                            <th>Policy</th>
                            <th>Product</th>
                            <th>Plan Start Date</th>
                            <th>Payer Name</th>
                            <th>Arrears Start Date</th>
                            <th>Plan Premium</th>
                            <th>Arrears Amount</th>
                            <th>No Prems Missed</th>
                            <th>Days in Arrears</th>
                            <th>Days to Lapse</th>
                            <th>BACS Rejection Reason</th>
                            <th>DD Mandate Status</th>
                            <th>Last/Next DD Bank Collection</th>
                            <th>Payment Day</th>
                            <th>Total Commission Liability</th>
                            <th>Within Initial Earnings Period</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>  
                            <th>Date</th>
                            <th>Policy</th>
                            <th>Product</th>
                            <th>Plan Start Date</th>
                            <th>Payer Name</th>
                            <th>Arrears Start Date</th>
                            <th>Plan Premium</th>
                            <th>Arrears Amount</th>
                            <th>No Prems Missed</th>
                            <th>Days in Arrears</th>
                            <th>Days to Lapse</th>
                            <th>BACS Rejection Reason</th>
                            <th>DD Mandate Status</th>
                            <th>Last/Next DD Bank Collection</th>
                            <th>Payment Day</th>
                            <th>Total Commission Liability</th>
                            <th>Within Initial Earnings Period</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                            
                        </div>
                    </div>
                    
                    </div>
                </div>

        </div>    
                
        <?php } 
        
        if(isset($PID) && $PID == "LV_EWS") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "LV_EWS") { echo "in active"; } ?>" id="OVERVIEW">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">LV EWS</h3>
                    </div>
                    <div class="panel-body">        
            
            <table id="LV_EWS_TABLE" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>  
                            <th>Date</th>
                            <th>RAG</th>
                            <th>Due Date</th>
                            <th>Event</th>
                            <th>Completion Date</th>
                            <th>Duration Inforce mths</th>
                            <th>Policy</th>
                            <th>Cover Type</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Mth Prem</th>
                            <th>No. Missed Payments</th>
                            <th>Amount Due</th>
                            <th>Comm Unearned Amount</th>
                            <th>CB Period</th>
                            <th>Report Run Date</th>
                            <th>View</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>RAG</th>
                            <th>Due Date</th>
                            <th>Event</th>
                            <th>Completion Date</th>
                            <th>Duration Inforce mths</th>
                            <th>Policy</th>
                            <th>Cover Type</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Mth Prem</th>
                            <th>No. Missed Payments</th>
                            <th>Amount Due</th>
                            <th>Comm Unearned Amount</th>
                            <th>CB Period</th>
                            <th>Report Run Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                    
                    </div>
                </div>
        </div>
        
        <?php } 
        
        if(isset($PID) && $PID == "LV_DD_EWS") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "LV_DD_EWS") { echo "in active"; } ?>" id="OVERVIEW">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">LV DD EWS</h3>
                    </div>
                    <div class="panel-body">        
            
            <table id="LV_DD_EWS_TABLE" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>  
                            <th>Date</th>
                            <th>Collection Date</th>
                            <th>Event</th>
                            <th>Reject Reason</th>
                            <th>Completion Date</th>
                            <th>Inforce mnths</th>
                            <th>Policy</th>
                            <th>Policy Type</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Total Prem Amount</th>
                            <th>Outstanding Balance Amount</th>
                            <th>Comm Unearned Amount</th>
                            <th>CB Period Mths</th>
                            <th>Report Run Date</th>
                            <th>View</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Collection Date</th>
                            <th>Event</th>
                            <th>Reject Reason</th>
                            <th>Completion Date</th>
                            <th>Inforce mnths</th>
                            <th>Policy</th>
                            <th>Policy Type</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Total Prem Amount</th>
                            <th>Outstanding Balance Amount</th>
                            <th>Comm Unearned Amount</th>
                            <th>CB Period Mths</th>
                            <th>Report Run Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                    
                    </div>
                </div>
        </div>
        
        <?php } 

            if(isset($PID) && $PID == "LV_LAPSED_EWS") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "LV_LAPSED_EWS") { echo "in active"; } ?>" id="OVERVIEW">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">LV Lapsed EWS</h3>
                    </div>
                    <div class="panel-body">        
            
            <table id="LV_LAPSED_EWS_TABLE" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th> 
                            <th>Date</th>
                            <th>Event Date</th>
                            <th>Event</th>
                            <th>Completion Date</th>
                            <th>Inforce Mths</th>
                            <th>Policy</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Total Mth Amount</th>
                            <th>Comm Amount Idem</th>
                            <th>CB Period Mths</th>
                            <th>Comm Type</th>
                            <th>Report Run Date</th>
                            <th>View</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Event Date</th>
                            <th>Event</th>
                            <th>Completion Date</th>
                            <th>Inforce Mths</th>
                            <th>Policy</th>
                            <th>Title</th>
                            <th>Forename</th>
                            <th>Surname</th>
                            <th>Postcode</th>
                            <th>Home num</th>
                            <th>Mob num</th>
                            <th>Ape</th>
                            <th>Total Mth Amount</th>
                            <th>Comm Amount Idem</th>
                            <th>CB Period Mths</th>
                            <th>Comm Type</th>
                            <th>Report Run Date</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table> 
                    
                    </div>
                </div>
        </div>
        
        <?php } 
        
        if(isset($PID) && $PID == "UPLOAD_EWS") { ?>
        
        <div class="tab-pane fade <?php if(isset($PID) && $PID == "UPLOAD_EWS") { echo "in active"; } ?>" id="UPLOAD_EWS">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Upload EWS</h3>
                    </div>
                    <div class="panel-body">        
                        
                        <div class="row">
                            <div class="col-ms-12">
                                
                                <div class="col-sm-4">
                                    <h3>Upload Avia</h3>
                                        
                                    <form action="/addon/Life/EWS/upload/upload_aviva_ews.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#LOADING"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>                                    
                                </div>
                                
                                <div class="col-sm-4">
                                    <h3>Upload Royal London</h3>
                                        
                                    <form action="/addon/Life/EWS/upload/upload_royal_london_ews.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#LOADING"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>                                    
                                </div>    
                                
                                <div class="col-sm-4">
                                    <h3>Upload LV</h3>
                                        
                                    <form action="/addon/Life/EWS/upload/upload_lv_ews.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#LOADING"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>                                    
                                </div>                                    
                                
                            </div>
                            
                    <div class="col-md-12">
                        
                                <div class="col-sm-4">
                                    <h3>Upload LV Rejected DD</h3>
                                        
                                    <form action="/addon/Life/EWS/upload/upload_lv_dd_ews.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#LOADING"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>                                    
                                </div> 

                                <div class="col-sm-4">
                                    <h3>Upload LV Lapsed</h3>
                                        
                                    <form action="/addon/Life/EWS/upload/upload_lv_lapsed_ews.php?EXECUTE=1" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <input name="csv" type="file" id="csv" />                                        
                                        <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#LOADING"><span class="glyphicon glyphicon-open"></span> Upload</button>
                                    </form>                                    
                                </div>                         
                        
                    </div>
                            
                            
                        </div>
                        
                </div>
        </div>
        
        <?php } ?>        
        
        </div>    
    

        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {


                $('#LOADING').modal('show');
            })

                    ;

            $(window).load(function () {
                $('#LOADING').modal('hide');
            });
        </script> 
        <div class="modal modal-static fade" id="LOADING" class="modal fade" role="dialog">
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

       <?php if(isset($PID) && $PID == "OVERVIEW") { ?>
        
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#clients').DataTable({
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] !== '' )  {
                        $('td', nRow).css("color", aData["adl_ews_colour"]);
                    }
                    
                     if ( aData["adl_ews_colour"] === "Black" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },               
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_date_added"},
                        {"data": "adl_ews_updated_date"},
                        {"data": "adl_ews_client_name"},
                        {"data": "adl_ews_ref"},
                        {"data": "adl_ews_modified_ref"},
                        {"data": "adl_ews_insurer"},
                        {"data": "adl_ews_orig_status"},
                        {"data": "adl_ews_status"},
                        {"data": "adl_ews_client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
        
       <?php }
       
       if(isset($PID) && $PID == "MASTER") { ?>
        
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#MASTER_EWS_TABLE').DataTable({
                "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData["color_status"] !== '' )  {
                        $('td', nRow).css("color", aData["adl_ews_colour"]);
                    }
                    
                     if ( aData["adl_ews_colour"] === "Black" )  {
                        $('td', nRow).addClass( 'black' );
                    }
                
    },               
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_master.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_master_date_added"},
                        {"data": "adl_ews_master_updated_date"},
                        {"data": "adl_ews_master_client_name"},
                        {"data": "adl_ews_master_ref"},
                        {"data": "adl_ews_master_modified_ref"},
                        {"data": "adl_ews_master_insurer"},
                        {"data": "adl_ews_master_orig_status"},
                        {"data": "adl_ews_master_status"},
                        {"data": "adl_ews_master_client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
        
       <?php }       
       
       if(isset($PID) && $PID == "AVI_EWS") { ?>    
        
<script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#AVI_EWS_TABLE').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_aviva.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_aviva_date_added"},
                        {"data": "adl_ews_aviva_client_name"},
                        {"data": "adl_ews_aviva_policy_number"},
                        {"data": "adl_ews_aviva_description"},
                        {"data": "adl_ews_aviva_more_info"},
                        {"data": "adl_ews_aviva_reported_date"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
<?php  }

if(isset($PID) && $PID == "RL_EWS") { ?>
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#RL_EWS_TABLE').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_rl.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_royal_london_date_added"},
                        {"data": "adl_ews_royal_london_policyno"},
                        {"data": "adl_ews_royal_london_product"},
                        {"data": "adl_ews_royal_london_plan_start_date"},
                        {"data": "adl_ews_royal_london_payer_name"},
                        {"data": "adl_ews_royal_london_arrears_start_date"},
                        {"data": "adl_ews_royal_london_plan_premium"},
                        {"data": "adl_ews_royal_london_arrears_amount"},
                        {"data": "adl_ews_royal_london_prems_missed"},
                        {"data": "adl_ews_royal_london_days_in_arrears"},
                        {"data": "adl_ews_royal_london_days_to_lapse"},
                        {"data": "adl_ews_royal_london_bacs_rejection_reason"},
                        {"data": "adl_ews_royal_london_dd_mandate_status"},
                        {"data": "adl_ews_royal_london_next_dd"},
                        {"data": "adl_ews_royal_london_payment_day"},
                        {"data": "adl_ews_royal_london_total_commission_liability"},
                        {"data": "adl_ews_royal_london_within_iep"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script>         
<?php } 

if(isset($PID) && $PID == "LV_EWS") { ?>
        
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#LV_EWS_TABLE').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_lv.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_lv_date_added"},
                        {"data": "adl_ews_lv_rag_status"},
                        {"data": "adl_ews_lv_earliest_due_date"},
                        {"data": "adl_ews_lv_event_description"},
                        {"data": "adl_ews_lv_completion_date"},
                        {"data": "adl_ews_lv_duration_inforce_months"},
                        {"data": "adl_ews_lv_policynumber"},
                        {"data": "adl_ews_lv_cover_type"},
                        {"data": "adl_ews_lv_title"},
                        {"data": "adl_ews_lv_forenames"},
                        {"data": "adl_ews_lv_surname"},
                        {"data": "adl_ews_lv_postcode"},
                        {"data": "adl_ews_lv_home_num"},
                        {"data": "adl_ews_lv_mob_num"},
                        {"data": "adl_ews_lv_ape"},
                        {"data": "adl_ews_lv_monthly_premium"},
                        {"data": "adl_ews_lv_no_missed_prems"},
                        {"data": "adl_ews_lv_amount_due"},
                        {"data": "adl_ews_lv_comm_unearned_amount"},
                        {"data": "adl_ews_lv_comm_cb_period"},
                        {"data": "adl_ews_lv_report_run_date"},   
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
        
       <?php } 
                
       if(isset($PID) && $PID == "LV_DD_EWS") { ?>
        
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#LV_DD_EWS_TABLE').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_lv_dd.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_lv_dd_date_added"},
                        {"data": "adl_ews_lv_dd_collection_date"},
                        {"data": "adl_ews_lv_dd_event_des"},
                        {"data": "adl_ews_lv_dd_reject_reason"},
                        {"data": "adl_ews_lv_dd_completion_date"},
                        {"data": "adl_ews_lv_dd_inforce_mths"},
                        {"data": "adl_ews_lv_dd_policy_number"},
                        {"data": "adl_ews_lv_dd_policy_type"},
                        {"data": "adl_ews_lv_dd_title"},
                        {"data": "adl_ews_lv_dd_fornames"},
                        {"data": "adl_ews_lv_dd_surnames"},
                        {"data": "adl_ews_lv_dd_postcode"},
                        {"data": "adl_ews_lv_dd_home_num"},
                        {"data": "adl_ews_lv_dd_mob_num"},
                        {"data": "adl_ews_lv_dd_ape"},
                        {"data": "adl_ews_lv_dd_total_prem_amount"},
                        {"data": "adl_ews_lv_dd_out_bal_amount"},
                        {"data": "adl_ews_lv_dd_comm_unearned_amount"},
                        {"data": "adl_ews_lv_dd_comm_cb_period_mths"},
                        {"data": "adl_ews_lv_dd_report_run_date"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
        
       <?php }
       
        if(isset($PID) && $PID == "LV_LAPSED_EWS") { ?>
        
        <script type="text/javascript" language="javascript" >
             $(document).ready(function () {
                var table = $('#LV_LAPSED_EWS_TABLE').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 10,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                                        "ajax": "JSON/ews_lv_lapsed.php?EXECUTE=1&&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "adl_ews_lv_lapsed_date_added"},
                        {"data": "adl_ews_lv_lapsed_event_date"},
                        {"data": "adl_ews_lv_lapsed_event_des"},
                        {"data": "adl_ews_lv_lapsed_completion_date"},
                        {"data": "adl_ews_lv_lapsed_inforce_mths"},
                        {"data": "adl_ews_lv_lapsed_policy_number"},
                        {"data": "adl_ews_lv_lapsed_title"},
                        {"data": "adl_ews_lv_lapsed_forenames"},
                        {"data": "adl_ews_lv_lapsed_surname"},
                        {"data": "adl_ews_lv_lapsed_postcode"},
                        {"data": "adl_ews_lv_lapsed_home_num"},
                        {"data": "adl_ews_lv_lapsed_mob_num"},
                        {"data": "adl_ews_lv_lapsed_ape"},
                        {"data": "adl_ews_lv_lapsed_total_mth_prem"},
                        {"data": "adl_ews_lv_lapsed_comm_amount_idem"},
                        {"data": "adl_ews_lv_lapsed_comm_cb_period_mths"},
                        {"data": "adl_ews_lv_lapsed_comm_type"},
                        {"data": "adl_ews_lv_lapsed_report_run_date"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ],
                            "order": [[1, 'asc']]
                });

            });           
        </script> 
        
       <?php } ?>        
       
    </body>
</html>