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

require_once(__DIR__ . '/../../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}

require_once(__DIR__ . '/../../../includes/adl_features.php');
require_once(__DIR__ . '/../../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../../../app/analyticstracking.php');
}

    require_once(__DIR__ . '/../../../classes/database_class.php');
    require_once(__DIR__ . '/../../../class/login/login.php');

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
            
        header('Location: /../../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

?>
<!DOCTYPE html>
<html>
<title>ADL | Search Aviva Audits</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
<link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php

require_once(__DIR__ . '/../../../app/Holidays.php'); 
require_once(__DIR__ . '/../../../includes/navbar.php');

    $QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $return= filter_input(INPUT_GET, 'return', FILTER_SANITIZE_SPECIAL_CHARS);
?>
    
    <div class="container">
        <div class="notice notice-default" role="alert"><strong><center><span class="label label-warning"></span> Search Aviva Audits</center></strong></div>
        
        <br>
        <center>
            <div class="btn-group">
                <a href="Menu.php" class="btn btn-info"><i class="fa fa-folder-open"></i> Aviva Audits</a>
            </div>
        </center>
<br>        
        
    <table id="clients" width="auto" cellspacing="0" class="table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>Policy</th>
                <th>Closer</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>Policy</th>
                <th>Closer</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
            </tr>
        </tfoot>
    </table>
   
</div>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
 

    <script type="text/javascript">
    $(document).ready(function() {                                                                                                    
                                                                                                        
    
        $('#LOADING').modal('show');
    })
    
    ;
    
    $(window).load(function(){
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
                    <h3>Searching Royal London Audits... </h3>
                </div>
            </div>
        </div>
    </div>
</div>   
    
    <script type="text/javascript" language="javascript" >

 
$(document).ready(function() {
    var table = $('#clients').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["aviva_audit_grade"] === "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["aviva_audit_grade"] === "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["aviva_audit_grade"] === "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["aviva_audit_grade"] === "SAVED" )  {
          $(nRow).addClass( 'Purple' );
    }
},

"response":true,
					"processing": true,
"iDisplayLength": 50,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "php/Search_Results.php?EXECUTE=1&USER=<?php echo $USER;?>&TOKEN=<?php echo $TOKEN; ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "aviva_audit_added_date" },
            { "data": "aviva_audit_id"},
            { "data": "aviva_audit_policy"},
            { "data": "aviva_audit_closer" },
            { "data": "aviva_audit_added_by" },
            { "data": "aviva_audit_grade" },
  { "data": "aviva_audit_id",
            "render": function(data, type, full, meta) {
                return '<a href="Audit.php?EXECUTE=EDIT&AUDITID=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "aviva_audit_id",
            "render": function(data, type, full, meta) {
                return '<a href="View.php?EXECUTE=VIEW&AUDITID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a></a>';
            } }
        ],
        "order": [[1, 'desc']]
    } );
     
    $('#clients tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
		</script>
</body>
</html>
