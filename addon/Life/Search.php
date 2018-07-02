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

require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

    require_once(__DIR__ . '/../../classes/database_class.php');
    require_once(__DIR__ . '/../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
    
        $ADL_PAGE_TITLE = "Search";
        require_once(__DIR__ . '/../../app/core/head.php'); 
        
        
        ?>
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
    </head>
    <body>

        <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>


        <div class="container">

            <?php

            if ($fflife == '1') {
                if(in_array($hello_name,$ADMIN_SEARCH_ACCESS)) {
              } ?>
              
<div class='notice notice-primary' role='alert'><center><strong>Search clients</strong></center></div> 

            <?php  if (in_array($hello_name, $OLD_CLIENT_SEARCH,true)) {?>

<table id="home" class="display" width="auto" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Sale Date</th>
                                <th>Client</th>
                                <th>Policy</th>
                                <th>Insurer</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Add Policy</th>
                            </tr>
                        </tfoot>
                    </table>
            
              <?php } else { ?>
            
                <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>Company</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Post Code</th>
                            <th>Company</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table>  
            <?php }

              }
            ?>
          
        </div>

        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
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
                            <h3>Populating client details... </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
      <?php if (in_array($hello_name, $OLD_CLIENT_SEARCH,true)) { ?>  
     <script type="text/javascript" language="javascript" >
                    function format(d) {
                        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                                '<tr>' +
                                '<td>Insurer:</td>' +
                                '<td>' + d.insurer + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Application Number:</td>' +
                                '<td>' + d.application_number + ' </td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Policy Type:</td>' +
                                '<td>' + d.type + ' </td>' +
                                '</tr>' +
                                '</table>';
                    }

                    $(document).ready(function () {
                        var table = $('#home').DataTable({
                            "response": true,
                            "processing": true,
                            "iDisplayLength": 10,
                            "aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
                            "language": {
                                "processing": "<div></div><div></div><div></div><div></div><div></div>"

                            },
                            "ajax": "/addon/Life/JSON/Search.php?EXECUTE=8&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                            "columns": [
                                {
                                    "className": 'details-control',
                                    "orderable": false,
                                    "data": null,
                                    "defaultContent": ''
                                },
                                {"data": "sale_date"},
                                {"data": "client_name"},
                                {"data": "policy_number"},
                                {"data": "insurer"},
                                {"data": "PolicyStatus"},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="/app/Client.php?search=' + data + '">View</a>';
                                    }},
                                {"data": "client_id",
                                    "render": function (data, type, full, meta) {
                                        return '<a href="Home/AddPolicy.php?Home=y&CID=' + data + '">Add Policy</a>';
                                    }}
                            ],
                            "order": [[1, 'asc']]
                        });
                        $('#policy tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = table.row(tr);

                            if (row.child.isShown()) {
                                row.child.hide();
                                tr.removeClass('shown');
                            } else {
                                row.child(format(row.data())).show();
                                tr.addClass('shown');
                            }
                        });
                    });
                </script>
                <?php } else { ?>
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 5,
                    "aLengthMenu": [[5], [5]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "/addon/Life/JSON/Search.php?EXECUTE=<?php if(in_array($hello_name,$AUDIT_SEARCH_ACCESS)) { echo "9"; } else { echo "6"; } ?>&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "submitted_date"},
                        {"data": "Name"},
                        {"data": "Name2"},
                        {"data": "post_code"},
                        {"data": "company"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/app/Client.php?search=' + data + '">View</a>';
                            }}
                    ]
                });

            });
        </script>
                <?php } ?>
    </body>
</html>