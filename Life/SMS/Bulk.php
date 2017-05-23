<?php
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 8);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');


if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../php/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

if (!in_array($hello_name, $Level_8_Access, true)) {

    header('Location: /../../CRMmain.php');
    die;
}

if ($ffsms == '0') {
    header('Location: /../../CRMmain.php?FEATURE=SMS');
}

$EXECUTE= filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_NUMBER_INT);

$RETURN= filter_input(INPUT_GET, 'RETURN', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($RETURN)) {
    $REMAINING= filter_input(INPUT_GET, 'REMAINING', FILTER_SANITIZE_SPECIAL_CHARS);
    $DATE= filter_input(INPUT_GET, 'DATE', FILTER_SANITIZE_SPECIAL_CHARS);
    $COLOUR= filter_input(INPUT_GET, 'COLOUR', FILTER_SANITIZE_SPECIAL_CHARS);
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
    <title>ADL | Bulk SMS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/styles/Notices.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4/jquery-ui.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/js/jquery-ui-1.11.4/jquery-ui.min.css" />
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

    <div class="container">
        <div class='notice notice-default' role='alert'><strong> <center>Only 25 messages can be sent at a time. ADL will check that clients are not sent a message multiple times.
                    <br>To send a message select an EWS colour and a clawback date and the message that you wish to send and click send.
                    </center></strong> </div>    

        <?php
        
        if(isset($RETURN) && $RETURN=='SENT') { ?>
        <div class='notice notice-info' role='alert'><strong> <center>Messages sent <?php if(isset($DATE) && $COLOUR) { echo "for EWS colour $COLOUR | with clawback date $DATE"; } ?>! <?php if(isset($REMAINING)) { echo "Clients left to message $REMAINING"; } ?></center></strong> </div>    
     <?php   }
        
        ?>
        <br>
        <div class="row">
        
        <form method="POST" action="EWS.php?EXECUTE=1">
            <fieldset>
                
            <div class="col-md-12">
            
                <div class="col-md-4">
            <select class="form-control" name="COLOUR" required="">
                <option value="">Select EWS Colour</option>
                <option value="Black">Black</option>
            </select>
                </div>
            
                <div class="col-md-2">
            <input class="form-control" type="text" name="DATE" id="DATE" placeholder="Clawback Date" required>
                </div>
                
                <div class="col-md-4">
            <select class="form-control" name="MESSAGE" required="">
                <option value="">Select message to send</option>
                <option value="1">[CLIENT_NAME] it very important that we speak to you regarding your life insurance policy. Please contact [COMPANY_NAME] on [COMPANY_TEL].</option>
            </select>
                </div>                
            
                <div class="col-md-2">
            <button type="submit" class="btn btn-success btn-md">Send Bulk SMS <i class="fa fa-send-o"></i></button>
                </div>
                
            </div>
            </fieldset>
        </form>      
        
    </div>
        
        <div class="row">
            
            <form action="" method="GET">
                <fieldset>
                <div class="col-md-4">
                    
                    <select id="EXECUTE" name="EXECUTE" class="form-control" onchange="this.form.submit()" required>
                        <option value="">Search for sent attempts</option>
                        <option <?php if(isset($EXECUTE)) { if($EXECUTE=='1') { echo "selected"; } } ?> value="1">Any</option>
                        <option <?php if(isset($EXECUTE)) { if($EXECUTE=='2') { echo "selected"; } } ?> value="2">Black</option>
                    </select>
                </div>
                </fieldset>
            </form>

                <table id="datatable_black" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Clawback</th>
                            <th>EWS</th>
                            <th>Policy</th>
                            <th>Phone</th>
                            <th>Delivery</th>
                            <th>View Client</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Client Name</th>
                            <th>Clawback</th>
                            <th>EWS</th>
                            <th>Policy</th>
                            <th>Phone</th>
                            <th>Delivery</th>
                            <th>View Client</th>
                        </tr>
                    </tfoot>
                </table>    
            
        </div>
        
    </div>
    
        <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
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

        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#datatable_black').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "datatables/EWS.php?EXECUTE=<?php if(isset($EXECUTE)) { echo $EXECUTE; } else { echo "1"; } ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "date_sent"},
                        {"data": "Name"},
                        {"data": "Name2"},
                        {"data": "clawback_date"},
                        {"data": "warning"},
                        {"data": "policy_number"},
                        {"data": "phone_number"},
                        {"data": "sms_inbound_type"},
                        {"data": "client_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="/Life/ViewClient.php?search=' + data + '" target="_blank">View</a>';
                            }}
                    ]
                });

            });
        </script>
    <script>
        $(function () {
            $("#DATE").datepicker({
                dateFormat: 'M-y',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:-0"
            });
        });
    </script>
</body>
</html>
