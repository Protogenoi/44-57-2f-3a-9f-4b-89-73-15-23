<?php
/*
 * ------------------------------------------------------------------------
 *                               ADL CRM
 * ------------------------------------------------------------------------
 * 
 * Copyright © 2017 ADL CRM All rights reserved.
 * 
 * Unauthorised copying of this file, via any medium is strictly prohibited.
 * Unauthorised distribution of this file, via any medium is strictly prohibited.
 * Unauthorised modification of this code is strictly prohibited.
 * 
 * Proprietary and confidential
 * 
 * Written by Michael Owen <michael@adl-crm.uk>, 2017
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
 * 
*/
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');
require_once(__DIR__ . '/../../classes/database_class.php');

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

if (!in_array($hello_name, $Level_1_Access, true)) {

    header('Location: /../../../index.php?AccessDenied');
    die;
}

        $COMID = filter_input(INPUT_GET, 'COMID', FILTER_SANITIZE_NUMBER_INT);
        $SCID = filter_input(INPUT_GET, 'SCID', FILTER_SANITIZE_SPECIAL_CHARS);
        
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2018
-->
<html lang="en">
    <title>ADL | Compliance Documents</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap/css/bootstrap.css">
        <link href="/resources/templates/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/resources/templates/ADL/Notices.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

    <?php require_once(__DIR__ . '/includes/NAV.php'); ?> 

    <div class="container-fluid"><br>
        
        <?php require_once(__DIR__ . '/../../addon/compliance/php/notifications.php'); ?> 
        
                <div class="row">
            <?php require_once(__DIR__ . '/includes/LeftSide.html'); ?> 
            
            <div class="col-9">
<div class="card"">
<h3 class="card-header">
Uploaded Documents
</h3>
<div class="card-block">
    
                    <?php if(isset($SCID)) { 
                    if($SCID=='1') { ?>
                                   <div class='notice notice-info' role='alert'><strong><i class='fa fa-edit fa-question-circle-o'></i> Info:</strong> All uploaded documents are show below.</div>      
       
                <?php    } else {
                    ?>
                  <div class='notice notice-info' role='alert'><strong><i class='fa fa-edit fa-question-circle-o'></i> Info:</strong> All documents found for <?php echo $SCID; ?>.</div>      
                <?php } } ?>

<p class="card-text">
    <div class="btn-group">
                           <p><a data-toggle="modal" data-target="#mymodal" class="btn btn-outline-success"><i class="fa fa-cloud-upload"></i> Upload</a></p>      
                                </div>
    
<h4 class="card-title"></h4>
  <table id="clients" class="display" width="auto" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Company</th>
                            <th>View</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Company</th>
                            <th>View</th>
                            <th>Review</th>
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
<h4 class="modal-title" id="modalLabel">Add new documents.</h4>
</div>
<div class="modal-body">

    <form action="/uploadsubmit.php?EXECUTE=2" method="POST" enctype="multipart/form-data">

  <div class="form-group">
    <label for="DOC_TITLE">Title:</label>
    <input type="text" class="form-control" id="DOC_TITLE" name="DOC_TITLE" placeholder="Document Title" required>
  </div>
        
          <div class="form-group">
    <label for="DOC_CAT">Category:</label>
    <select class="form-control" name='DOC_CAT' required>
        <option value="">Select a category...</option>
        <option value='FCA'>FCA</option>
        <option value='ICO'>ICO</option>
        <option value='LANDG'>Legal and General</option>
        <option value='Vulnerable Clients'>Vulnerable Clients</option>
        <option value='Money Laundering'>Money Laundering</option>
        <option value='Data Protection'>Data Protection</option>
        <option value='Other'>Other</option>
    </select>
  </div>        
        
          <div class="form-group">
    <label for="DOC_COMPANY">Company:</label>
    <select class="form-control" name='DOC_COMPANY'>
        <option value='N/A'>For all</option>
        <option value='<?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?>'><?php if(isset($COMPANY_ENTITY)) { echo $COMPANY_ENTITY; } ?></option>
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
            <script src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
                    
        <?php

        
        if(isset($COMID)) { 
       
        $database = new Database();
        $database->query("SELECT 
            compliance_uploads_title,
            compliance_uploads_company
                FROM
                compliance_uploads
                WHERE
                compliance_uploads_id=:COMID");
                        $database->bind(':COMID', $COMID);
                        $RESULT = $database->single();        
            
            ?>
        
<div class="modal fade" id="MYMODAL" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="modalLabel"><?php echo $RESULT['compliance_uploads_title']; ?></h4>
</div>
<div class="modal-body">
    <p>If you have read and understood this document click "Mark as Read".</p>
    <p>If you have a question about the document click "Question"</p>
    <form action="php/Compliance.php?EXECUTE=1&COMID=<?php echo $COMID; ?>&TITLE=<?php echo $RESULT['compliance_uploads_title']; ?>" method="POST">
        
          <div class="form-group">
    <label for="COMPANY_ENTITY">Company:</label>
    <select class="form-control" name='COMPANY_ENTITY'>
        <option <?php if(isset($RESULT['compliance_uploads_company']) && $RESULT['compliance_uploads_company']=='N/A') { echo "selected"; }  ?> value='N/A'>For all</option>
        <option <?php if(isset($RESULT['compliance_uploads_company']) && $RESULT['compliance_uploads_company']=='First Priority Group') { echo "selected"; }  ?> value='First Priority Group'>First Priority Group</option>
        <option <?php if(isset($RESULT['compliance_uploads_company']) && $RESULT['compliance_uploads_company']=='Bluestone Protect') { echo "selected"; }  ?> value='Bluestone Protect'>Bluestone Protect</option>
    </select>
  </div>


  <button type="submit" class="btn btn-primary form-control" name="btn-upload">Mark as Read</button>
    </form>  <br>
    
  <form action="php/Compliance.php?EXECUTE=2&COMID=<?php echo $COMID; ?>&TITLE=<?php echo $RESULT['compliance_uploads_title']; ?>" method="POST">
      
     <div class="form-group">
        <textarea class="form-control" name="MSG" rows="5" cols="100" placeholder="Any Questions about the document?"></textarea>
    </div>
      
 
  
  <button type="submit" class="btn btn-primary form-control">Question</button>
</form>
    
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>         
        
 <script type="text/javascript">
    $(window).on('load',function(){
        $('#MYMODAL').modal('show');
    });
</script> 
     <?php   }
        
        ?>                    
                    
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>  
<script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="/resources/templates/bootstrap/js/bootstrap.min.js"></script> 
        
        <script type="text/javascript" language="javascript" >

            $(document).ready(function () {
                var table = $('#clients').DataTable({
                    "response": true,
                    "processing": true,
                    "iDisplayLength": 25,
                    "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                    "language": {
                        "processing": "<div></div><div></div><div></div><div></div><div></div>"
                    },
                    "ajax": "datatables/Compliance.php?SCID=<?php echo $SCID; ?>",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "compliance_uploads_title"},
                        {"data": "compliance_uploads_category"},
                        {"data": "compliance_uploads_company"},
                        {"data": "compliance_uploads_location",
                            "render": function (data, type, full, meta) {
                                return '<a href="/' + data + '" target="_blank"><i class="fa fa-search"></i></a>';
                            }},
                        {"data": "compliance_uploads_id",
                            "render": function (data, type, full, meta) {
                                return '<a href="Compliance.php?COMID=' + data + '"><i class="fa fa-check-circle-o"></i></a>';
                            }}    
                    ]
                });

            });
        </script>
</body>
</html>
