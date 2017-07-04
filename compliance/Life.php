<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 1);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

$Level_2_Access = array("Jade");

if (in_array($hello_name, $Level_2_Access, true)) {

    header('Location: ../Life/Financial_Menu.php');
    die;
}

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

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

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /index.php?AccessDenied');
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
    <title>ADL | Life Test</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="/styles/Notices.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <style>tr.Green td {
  background-color: #85E085;

}

tr.Amber td {
  background-color: #FFC266;

}

tr.Red td {
  background-color: #FF4D4D;

}</style>
    <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 

    <div class="container-fluid"><br>
        
        <?php require_once(__DIR__ . '/../compliance/php/notifications.php'); ?> 
        
                        <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
        
<div class="card"">
<h3 class="card-header">
The Life Insurance Test
</h3>
<div class="card-block">

<p class="card-text">
<div class="btn-group">
                                    <p><a href="tests/Life.php" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Take Life Insurance Test</a></p>
                                <p><a href="tests/Protection.php" class="btn btn-outline-success"><i class="fa fa-graduation-cap"></i> Take Protection Test</a></p>
                                
                                </div><h4 class="card-title">Previous passes</h4>
  <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Advisor</th>
                            <th>Company</th>
                            <th>Grade</th>
                            <th>Mark</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Advisor</th>
                            <th>Company</th>
                            <th>Grade</th>
                            <th>Mark</th>
                            <th>View</th>
                        </tr>
                    </tfoot>
                </table>

</p>
</div>
<div class="card-footer">
ADL
</div>
</div>        
            </div>
                        </div>
               
    </div>
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
                    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>  
        
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["life_test_one_grade"] == "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["life_test_one_grade"] == "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["life_test_one_grade"] == "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["life_test_one_grade"] == "SAVED" )  {
          $(nRow).addClass( 'Purple' );
    }
},
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "datatables/Life.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "life_test_one_added_date"},
                        {"data": "life_test_one_advisor"},
                        {"data": "life_test_one_company"},
                        {"data": "life_test_one_grade"},
                        {"data": "life_test_one_mark"},
                        {"data": "life_test_one_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="tests/Life.php?EXECUTE=2&TID=' + data + '"><i class="fa fa-search"></i></a>';
                            }}
                    ]
                });

            });
        </script>
</body>
</html>
