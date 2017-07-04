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
    <title>ADL | Recordings</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="/styles/Notices.css">
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
        <link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
        
<div class="card">
<h3 class="card-header">
Uploaded Call Recordings
</h3>
<div class="card-block">

<p class="card-text">
<div class="btn-group">
                                    <p><a data-toggle="modal" data-target="#mymodal" class="btn btn-outline-success"><i class="fa fa-cloud-upload"></i> Upload</a></p>                                
                                </div>

<h4 class="card-title">Call Recordings</h4>
  <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date Added</th>
                            <th>Advisor</th>
                            <th>Company</th>
                            <th>Grade</th>
                            <th>Status</th>
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
                            <th>Status</th>
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
    
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="modalLabel">Upload a new call recording.</h4>
</div>
<div class="modal-body">

    <form action="../uploadsubmit.php?EXECUTE=1" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="RECORDING_DATE">Date:</label>
    <input type="text" class="form-control" id="RECORDING_DATE" name="RECORDING_DATE" placeholder="Date of the recording" required>
  </div>
        
   <div class="form-group">
 <select class="form-control" name="AGENT_NAME" id="AGENT_NAME">
     <option value="">Select Agent...</option>
 </select>
   </div>      
        
     

  <div class="form-group">
    <label for="RECORDING_FILE">File:</label>
    <input type="file" class="form-control-file" id="file" name="file" aria-describedby="fileHelp" required>
    <small id="fileHelp" class="form-text text-muted">Max filesize 40MB. Use a Audacity to convert big files to mp3's.</small>
  </div>

  <button type="submit" class="btn btn-primary" name="btn-upload">UPLOAD</button>
</form>
    
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>    
            <script src="/js/jquery/jquery-3.0.0.min.js"></script>
                    <script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script> 
                    <script>
                $(function () {
                    $("#RECORDING_DATE").datepicker({
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "-100:+1"
                    });
                });
                </script>
  
        <script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
 
         
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["compliance_recordings_grade"] == "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["compliance_recordings_grade"] == "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["compliance_recordings_grade"] == "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["compliance_recordings_grade"] == "SAVED" )  {
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
                    "ajax": "datatables/Recordings.php?EXECUTE=1",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "compliance_recordings_recording_date"},
                        {"data": "compliance_recordings_advisor"},
                        {"data": "compliance_recordings_company"},
                        {"data": "compliance_recordings_grade"},
                        {"data": "compliance_recordings_status"},
                        {"data": "compliance_recordings_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="recordings/Recordings.php?EXECUTE=1&RID=' + data + '"><i class="fa fa-search"></i></a>';
                            }}
                    ]
                });

            });
        </script>
          <script type="text/JavaScript">
                                    var $select = $('#AGENT_NAME');
                                    $.getJSON('/compliance/JSON/Agents.php?EXECUTE=1', function(data){
                                    $select.html('agent_name');
                                    $.each(data, function(key, val){ 
                                    $select.append('<option value="' + val.FULL_NAME + '">' + val.FULL_NAME + '</option>');
                                    })
                                    });
                                </script>
</body>
</html>
