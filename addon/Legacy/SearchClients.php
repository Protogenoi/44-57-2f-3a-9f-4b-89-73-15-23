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

require_once(__DIR__ . '/../../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(__DIR__ . '/../../includes/adl_features.php');
require_once(__DIR__ . '/../../includes/Access_Levels.php');
require_once(__DIR__ . '/../../includes/adlfunctions.php');

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

        require_once(__DIR__ . '/../../classes/database_class.php');
        require_once(__DIR__ . '/../../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../../../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        $CHECK_USER_LOGIN->SelectToken();
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }           
?>
<!DOCTYPE html>
<html>
<title>ADL | Search Legacy Clients</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/jquery-ui.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
</head>
<body>
    
    <?php require_once(__DIR__ . '/../../includes/navbar.php'); ?>

<div class="container">

    <table id="clients" class="display" width="auto" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>DOB</th>                
                <th>Daytime Tel</th>
                <th>Evening Tel</th>
                <th>Mobile Tel</th>
                <th>Client Tel</th>    
                <th>Email</th>
                <th>Email</th>
                <th>View</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>DOB</th>
                <th>Daytime Tel</th>
                <th>Evening Tel</th>
                <th>Mobile Tel</th>
                <th>Client Tel</th> 
                <th>Email</th>
                <th>Email</th>
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
        
<script type="text/javascript" language="javascript" >
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Email:</td>'+
            '<td>'+d.home_email+' </td>'+

        '</tr>'+
        '<tr>'+
            '<td>Client ID:</td>'+
            '<td>'+d.client_id+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Date Added:</td>'+
            '<td>'+d.date_added+' </td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#clients').DataTable( {

"response":true,
					"processing": true,
"iDisplayLength": 50,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/addon/Legacy/JSON/ClientSearch.php?ClientSearch=3&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_created"},
            { "data": "Name" },
            { "data": "postcode" },
            { "data": "dob" },
            { "data": "MobileTel" },
            { "data": "DaytimeTel" },
            { "data": "EveningTel" },
            { "data": "Client_telephone" },
            { "data": "home_email" },
            { "data": "office_email" },
 { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Legacy/ViewLegacyClient.php?search=' + data + '">View</a>';
            } }

        ],
        "order": [[1, 'DESC']]
    } );
     
    // Add event listener for opening and closing details
    $('#clients tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
		</script>
</body>

</html>
