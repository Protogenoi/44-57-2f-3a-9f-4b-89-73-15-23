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

require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../app/analyticstracking.php');
}

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

        require_once(__DIR__ . '/../classes/database_class.php');
        require_once(__DIR__ . '/../class/login/login.php');
        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        $CHECK_USER_LOGIN->CheckAccessLevel();
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }


if(isset($_GET["datefrom2"])) $datefrom2 = $_GET["datefrom2"];
if(isset($_GET["dateto2"])) $dateto2 = $_GET["dateto2"];


if ($_FILES[csv][size] > 0) {

    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");

    do {
        if ($data[0]) {
            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO ews_data (date_added, master_agent_no, agent_no, policy_number, client_name, dob, address1, address2, address3, address4, post_code, policy_type, warning, last_full_premium_paid, net_premium,premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, seller_name, frn, reqs, processor, ews_status, ournotes) VALUES
                (
                    CURRENT_TIMESTAMP,
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."',
                    '".addslashes($data[3])."',
                    '".addslashes($data[4])."',
                    '".addslashes($data[5])."',
                    '".addslashes($data[6])."',
                    '".addslashes($data[7])."',
                    '".addslashes($data[8])."',
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."',
                    '".addslashes($data[11])."',
                    '".addslashes($data[12])."',
                    '".addslashes($data[13])."',
                    '".addslashes($data[14])."',
                    '".addslashes($data[15])."',
                    '".addslashes($data[16])."',
                    '".addslashes($data[17])."',
                    '".addslashes($data[18])."',
                    '".addslashes($data[19])."',
                    '".addslashes($data[20])."',
                    '".addslashes($data[21])."',
		  '$hello_name',
		  'NEW',
		  ' '
                )
ON DUPLICATE KEY 
UPDATE
date_added=CURRENT_TIMESTAMP
, master_agent_no='".addslashes($data[0])."'
, agent_no='".addslashes($data[1])."'
, policy_number='".addslashes($data[2])."'
, client_name='".addslashes($data[3])."'
, dob='".addslashes($data[4])."'
, address1='".addslashes($data[5])."'
, address2='".addslashes($data[6])."'
, address3='".addslashes($data[7])."'
, address4='".addslashes($data[8])."'
, post_code='".addslashes($data[9])."'
, policy_type='".addslashes($data[10])."'
, warning='".addslashes($data[11])."'
, last_full_premium_paid='".addslashes($data[12])."'
, net_premium='".addslashes($data[13])."'
, premium_os='".addslashes($data[14])."'
, clawback_due='".addslashes($data[15])."'
, clawback_date='".addslashes($data[16])."'
, policy_start_date='".addslashes($data[17])."'
, off_risk_date='".addslashes($data[18])."'
, seller_name='".addslashes($data[19])."'
, frn='".addslashes($data[20])."'
, reqs='".addslashes($data[21])."'
, processor='$hello_name'
            ");
            
    $query = $pdo->prepare("SELECT id, client_id, policy_number FROM client_policy where policy_number=:polhold");
    $query->bindParam(':polhold', $data[2], PDO::PARAM_STR, 12);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    
   
if ($query->rowCount() >= 1) {

    $clientid=$result['client_id'];
    $polid=$result['id'];
    $policynumber=$result['policy_number'];
    
    $message= $data[11];
    $note="EWS Uploaded";
    $ref= "$policynumber ($polid)";
    
    $insert = $pdo->prepare("INSERT INTO client_note set client_id=:clientid, client_name=:ref, note_type=:note, message=:message, sent_by=:sent");
    
    
    
    $insert->bindParam(':clientid', $clientid, PDO::PARAM_STR, 12);
    $insert->bindParam(':ref', $ref, PDO::PARAM_STR, 250);
    $insert->bindParam(':note', $note, PDO::PARAM_STR, 250);
    $insert->bindParam(':message', $message, PDO::PARAM_STR, 250);
    $insert->bindParam(':sent', $hello_name, PDO::PARAM_STR, 250);
    $insert->execute();
}

else {
    
    $fail = $pdo->prepare("INSERT INTO ews_error set error_dump=:dump"); 
    $fail->bindParam(':dump', $data[2], PDO::PARAM_STR, 12);
    $fail->execute();
    
}
            
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
}


if ($_FILES[csv][size] > 0) {

    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");

    do {
         if ($data[0]) {
            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO ews_data_history (date_added, master_agent_no, agent_no, policy_number, client_name, dob, address1, address2, address3, address4, post_code, policy_type, warning, last_full_premium_paid, net_premium, premium_os, clawback_due, clawback_date, policy_start_date, off_risk_date, seller_name, frn, reqs, processor) VALUES
                (
                    CURRENT_TIMESTAMP,
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."',
                    '".addslashes($data[3])."',
                    '".addslashes($data[4])."',
                    '".addslashes($data[5])."',
                    '".addslashes($data[6])."',
                    '".addslashes($data[7])."',
                    '".addslashes($data[8])."',
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."',
                    '".addslashes($data[11])."',
                    '".addslashes($data[12])."',
                    '".addslashes($data[13])."',
                    '".addslashes($data[14])."',
                    '".addslashes($data[15])."',
                    '".addslashes($data[16])."',
                    '".addslashes($data[17])."',
                    '".addslashes($data[18])."',
                    '".addslashes($data[19])."',
                    '".addslashes($data[20])."',
                    '".addslashes($data[21])."',
		'$hello_name'
                )

            ");
        }
    } while ($data = fgetcsv($handle,1000,",","'"));

    header('Location: EWSfiles.php?success=1'); die;

}
?>
<!DOCTYPE html>
<html>
<title>ADL | Early Warning System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.css" />
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="//cdn.oesmith.co.uk/morris-0.5.1.css">
 <style>
            div.smallcontainer {
                margin: 0 auto;
                font: 70%/1.45em "Helvetica Neue",HelveticaNeue,Verdana,Arial,Helvetica,sans-serif;
            }
.panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
        </style>
    </head>
    <body>

<?php include('../includes/navbar.php'); 
        include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/analyticstracking.php'); 
    
    }
?>
        
        <div class="container">
            <ul class="nav nav-pills">
                <li><a data-toggle="pill" href="#home">Master</a></li>
                <li class="active"><a data-toggle="pill" href="#menu2">Cases to Work</a></li>
                <li><a data-toggle="pill" href="#menu1">Rebroke</a></li>
            </ul>
        </div>
        <div class="tab-content">
            
            <div id="home" class="tab-pane fade in active">  
                <div class="smallcontainer">
                    
                    <table id="MASTER" class="display compact" width="auto" cellspacing="0">
                        
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </tfoot>
                    </table>
                
                </div> 
                
            </div>
            
            <div id="menu1" class="tab-pane fade">
                <div class="smallcontainer">
                    <table id="PROGRESS" class="display compact" width="auto" cellspacing="0">
                        
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                    
            </div>
            
            <div id="menu2" class="tab-pane fade">
                <div class="smallcontainer">
                    
                    <table id="WORK" class="display compact" width="auto" cellspacing="0">
                        
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Client Name</th>
                                <th>Provider</th>
                                <th>Policy #</th>
                                <th>Created Date</th>
                                <th>Commission Status</th>
                                <th>Product</th>
                                <th>Gender</th>
                                <th>Life Sum Assured</th>
                                <th>Life Term</th>
                                <th>Premium</th>
                                <th>Term Assurance Type</th>
                                <th>CIC Sum Assured</th>
                                <th>CIC Term</th>
                                <th>PHI Sum Assured</th>
                                <th>PHI Age Until</th>
                                <th>PHI Term</th>
                                <th>FIB Sum Assured</th>
                                <th>FIB Age Until</th>
                                <th>Premium</th>
                                <th>Description</th>
                                <th>Provider Cat</th>
                                <th>Provider</th>
                                <th>Commission Type</th>
                                <th>Our Status</th>
                                <th>Color</th>
                            </tr>
                        </tfoot>
                    </table>
                
                </div>
            </div>
  </div>
  
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" >
function format ( d ) {

    return '<form action="/addon/Legacy/php/SendEwsNote.php?Legacy=1" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

        '<tr>'+

                    '<td>Our EWS Status:'+
            '<select class="hook_to_change_colour" name="status" onchange="" required><option value="'+d.ews_status+'">'+d.ews_status+'</option><option value="Sale">Sale</option><option value="No Number">No Number</option><option value="No Policy Info">No Policy Info</option><option value="Not Interested">Not Interested</option><option value="Hang Up">Hang Up</option><option value="No Answer">No Answer</option><option value="Callback">Callback</option><option value="Work Number">Work Number</option><option value="Decline">Decline</option><option value="Underwritten">Underwritten</option><option value="Dead Number">Dead Number</option><option value="Invalid Number">Invalid Number</option><option value="Email Sent">Email Sent</option><option value="Dead Email">Dead Email</option><option value="Cant Beat">Cant Beat</option><option value="Wrong Number">Wrong Number</option></select>'+
            '<select class="colour_hook" name="colour" required>' +

'<option value="green" style="background-color:green;">Green</option>' +
'<option value="DarkBlue" style="background-color:DarkBlue;">Blue</option>' +
'<option value="purple" style="background-color:purple;">Purple</option>' +
'<option value="Orange" style="background-color:Orange;">Orange</option>' +
'<option value="red" style="background-color:red;">Red</option>' +
'</select></td>'+

        '</tr>'+

        '<tr>'+

'<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
'<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+



'<td><input type="hidden" name="client_name" value="'+d.Name+'"></td>'+
'<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
        '</tr>'+

        '<tr>'+
'<td><div name="BLANK_ZOVOS"> </div></td>'+
        '</tr>'+
        '<tr>'+
'<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
        '</tr>'+
        '<tr>'+
'<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

        '</tr>'+

    '</form>';
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#MASTER').DataTable( {
 dom: 'C<"clear">lfrtip',
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {


        if ( aData["color_status"] != '' )  {
          $('td', nRow).css("color", aData["color_status"]);
                    }

},

"response":true,
                    "processing": true,
"iDisplayLength": 25,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "../datatables/EWSLegacy.php?LegacyMaster=1",
        "deferRender": true,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "reference"},
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Legacy/ViewLegacyClient.php?search=' + data + '">"' + data + '"</a>';
            } },
            { "data": "Name"},
            { "data": "provider_created"},
            { "data": "policy_number"},
            { "data": "created_date"},
            { "data": "commisson_status"},
            { "data": "product" },
            { "data": "gender" },
            { "data": "life_sum_assured"},
            { "data": "life_term"},
            { "data": "premium"},
            { "data": "term_assurance_type"},
            { "data": "cic_sum_assured" },
            { "data": "cic_term" },
            { "data": "phi_sum_assured" },
            { "data": "phi_age_until" },
            { "data": "phi_term" },
            { "data": "fib_sum_assured" },
            { "data": "fib_age_until" },
            { "data": "premium2" },
            { "data": "description" },
            { "data": "product_cat" },
            { "data": "provider2" },
            { "data": "commission_type" },
            { "data": "ews_status" },
            { "data": "color_status" }

        ],
        "order": [[1, 'asc']]
    } );

    $('#MASTER tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            console.log($(this).closest('tr').next('tr').find("input[name='client_id']").val());

var me = $(this);

$.ajax({ url: '/addon/Legacy/php/GetEwsNote.php?Legacy=1',
         data: {
cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
},
         type: 'post',
         success: function(data) {
me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                  }
});

tr.addClass('shown');

                     $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
    case "Sale":
                $(this).next().val('green');
                break;
            
            case "Not Interested":
            case "Hang Up":
            case "No Answer":
                $(this).next().val('DarkBlue');
                break;
            
            case "Callback":
            case "Work Number":
            case "Email Sent":
                $(this).next().val('purple');
                break;
            
            
            case "Decline":
            case "Cant Beat":
            case "Underwritten":
                $(this).next().val('Orange');
                break;
            case "Dead Beat":
            case "Dead Cant Beat":
            case "Dead Email":
            case "Dead Email":
            case "Dead Number":
            case "Invalid Number":
            case "No Policy Info":
            case "No Number":
            case "Wrong Number":
                $(this).next().val('red');
                break;
            
            
                         }
                     });


        }
    } );
} );
        </script>
<script type="text/javascript" language="javascript" >
function format ( d ) {

    return '<form action="/addon/Legacy/php/SendEwsNote.php?Legacy=1" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

        '<tr>'+

                    '<td>Our EWS Status:'+
            '<select class="hook_to_change_colour" name="status" onchange="" required><option value="'+d.ews_status+'">'+d.ews_status+'</option><option value="Sale">Sale</option><option value="No Number">No Number</option><option value="No Policy Info">No Policy Info</option><option value="Not Interested">Not Interested</option><option value="Hang Up">Hang Up</option><option value="No Answer">No Answer</option><option value="Callback">Callback</option><option value="Work Number">Work Number</option><option value="Decline">Decline</option><option value="Underwritten">Underwritten</option><option value="Dead Number">Dead Number</option><option value="Invalid Number">Invalid Number</option><option value="Email Sent">Email Sent</option><option value="Dead Email">Dead Email</option><option value="Cant Beat">Cant Beat</option><option value="Wrong Number">Wrong Number</option></select>'+
            '<select class="colour_hook" name="colour" required>' +

'<option value="green" style="background-color:green;">Green</option>' +
'<option value="DarkBlue" style="background-color:DarkBlue;">Blue</option>' +
'<option value="purple" style="background-color:purple;">Purple</option>' +
'<option value="Orange" style="background-color:Orange;">Orange</option>' +
'<option value="red" style="background-color:red;">Red</option>' +
'</select></td>'+

        '</tr>'+

        '<tr>'+

'<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
'<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+



'<td><input type="hidden" name="client_name" value="'+d.Name+'"></td>'+
'<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
        '</tr>'+

        '<tr>'+
'<td><div name="BLANK_ZOVOS"> </div></td>'+
        '</tr>'+
        '<tr>'+
'<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
        '</tr>'+
        '<tr>'+
'<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

        '</tr>'+

    '</form>';
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#PROGRESS').DataTable( {
 dom: 'C<"clear">lfrtip',
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {


        if ( aData["color_status"] != '' )  {
          $('td', nRow).css("color", aData["color_status"]);
                    }

},

"response":true,
                    "processing": true,
"iDisplayLength": 25,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "../datatables/EWSLegacy.php?LegacyMaster=3",
        "deferRender": true,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "reference"},
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Legacy/ViewLegacyClient.php?search=' + data + '">"' + data + '"</a>';
            } },
            { "data": "Name"},
            { "data": "provider_created"},
            { "data": "policy_number"},
            { "data": "created_date"},
            { "data": "commisson_status"},
            { "data": "product" },
            { "data": "gender" },
            { "data": "life_sum_assured"},
            { "data": "life_term"},
            { "data": "premium"},
            { "data": "term_assurance_type"},
            { "data": "cic_sum_assured" },
            { "data": "cic_term" },
            { "data": "phi_sum_assured" },
            { "data": "phi_age_until" },
            { "data": "phi_term" },
            { "data": "fib_sum_assured" },
            { "data": "fib_age_until" },
            { "data": "premium2" },
            { "data": "description" },
            { "data": "product_cat" },
            { "data": "provider2" },
            { "data": "commission_type" },
            { "data": "ews_status" },
            { "data": "color_status" }

        ],
        "order": [[1, 'asc']]
    } );

    $('#PROGRESS tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            console.log($(this).closest('tr').next('tr').find("input[name='client_id']").val());

var me = $(this);

$.ajax({ url: '/addon/Legacy/php/GetEwsNote.php?Legacy=1',
         data: {
cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
},
         type: 'post',
         success: function(data) {
me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                  }
});

tr.addClass('shown');

                     $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
        case "Sale":
                $(this).next().val('green');
                break;
            
            case "Not Interested":
            case "Hang Up":
            case "No Answer":
                $(this).next().val('DarkBlue');
                break;
            
            case "Callback":
            case "Work Number":
            case "Email Sent":
                $(this).next().val('purple');
                break;
            
            
            case "Decline":
            case "Cant Beat":
            case "Underwritten":
                $(this).next().val('Orange');
                break;
            
            case "Dead Email":
            case "Dead Number":
                        case "Dead Beat":
            case "Dead Cant Beat":
            case "Invalid Number":
            case "No Policy Info":
            case "No Number":
            case "Wrong Number":
                $(this).next().val('red');
                break;
            
            
                         }
                     });
        }
    } );
} );
        </script>

<script type="text/javascript" language="javascript" >
function format ( d ) {

    return '<form action="/addon/Legacy/php/SendEwsNote.php?Legacy=1" method="POST" autocomplete="off">'+'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+

        '<tr>'+

                    '<td>Our EWS Status:'+
           '<select class="hook_to_change_colour" name="status" onchange="" required><option value="'+d.ews_status+'">'+d.ews_status+'</option><option value="Sale">Sale</option><option value="No Number">No Number</option><option value="No Policy Info">No Policy Info</option><option value="Not Interested">Not Interested</option><option value="Hang Up">Hang Up</option><option value="No Answer">No Answer</option><option value="Callback">Callback</option><option value="Work Number">Work Number</option><option value="Decline">Decline</option><option value="Underwritten">Underwritten</option><option value="Dead Number">Dead Number</option><option value="Invalid Number">Invalid Number</option><option value="Email Sent">Email Sent</option><option value="Dead Email">Dead Email</option><option value="Cant Beat">Cant Beat</option><option value="Wrong Number">Wrong Number</option></select>'+
            '<select class="colour_hook" name="colour" required>' +

'<option value="green" style="background-color:green;">Green</option>' +
'<option value="DarkBlue" style="background-color:DarkBlue;">Blue</option>' +
'<option value="purple" style="background-color:purple;">Purple</option>' +
'<option value="Orange" style="background-color:Orange;">Orange</option>' +
'<option value="red" style="background-color:red;">Red</option>' +

'</select></td>'+

        '</tr>'+

        '<tr>'+

'<td><input type="hidden" name="client_id" value="'+d.client_id+'"></td>'+
'<td><input type="hidden" name="policy_number" value="'+d.policy_number+'"></td>'+



'<td><input type="hidden" name="client_name" value="'+d.Name+'"></td>'+
'<td><input type="hidden" name="edited" value="<?php echo $hello_name?>"></td>'+
        '</tr>'+

        '<tr>'+
'<td><div name="BLANK_ZOVOS"> </div></td>'+
        '</tr>'+
        '<tr>'+
'<td><textarea name="notes" id="notes" rows="15" cols="85" placeholder="Add Notes Here" required></textarea></td>'+
        '</tr>'+
        '<tr>'+
'<td><button type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus"></span> Add Notes</button></td>'+

        '</tr>'+

    '</form>';
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#WORK').DataTable( {
 dom: 'C<"clear">lfrtip',
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {


        if ( aData["color_status"] != '' )  {
          $('td', nRow).css("color", aData["color_status"]);
                    }

},

"response":true,
                    "processing": true,
"iDisplayLength": 25,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000], [5, 10, 25, 50, 100, 125, 150, 200, 500, 2500, 3000, 2500, 3000]],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "../datatables/EWSLegacy.php?LegacyMaster=2",
        "deferRender": true,
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "reference"},
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Legacy/ViewLegacyClient.php?search=' + data + '">"' + data + '"</a>';
            } },
            { "data": "Name"},
            { "data": "provider_created"},
            { "data": "policy_number"},
            { "data": "created_date"},
            { "data": "commisson_status"},
            { "data": "product" },
            { "data": "gender" },
            { "data": "life_sum_assured"},
            { "data": "life_term"},
            { "data": "premium"},
            { "data": "term_assurance_type"},
            { "data": "cic_sum_assured" },
            { "data": "cic_term" },
            { "data": "phi_sum_assured" },
            { "data": "phi_age_until" },
            { "data": "phi_term" },
            { "data": "fib_sum_assured" },
            { "data": "fib_age_until" },
            { "data": "premium2" },
            { "data": "description" },
            { "data": "product_cat" },
            { "data": "provider2" },
            { "data": "commission_type" },
            { "data": "ews_status" },
            { "data": "color_status" }

        ],
        "order": [[1, 'asc']]
    } );

    $('#WORK tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            console.log($(this).closest('tr').next('tr').find("input[name='client_id']").val());

var me = $(this);

$.ajax({ url: '/addon/Legacy/php/GetEwsNote.php?Legacy=1',
         data: {
cid: $(this).closest('tr').next('tr').find("input[name='client_id']").val(),
pid: $(this).closest('tr').next('tr').find("input[name='policy_number']").val()
},
         type: 'post',
         success: function(data) {
me.closest('tr').next('tr').find("div[name='BLANK_ZOVOS']").html(data);
                  }
});

tr.addClass('shown');

                     $('.hook_to_change_colour').change(function(){
        
                         switch ($(this).val()) {
            
            case "Sale":
                $(this).next().val('green');
                break;
            
            case "Not Interested":
            case "Hang Up":
            case "No Answer":
                $(this).next().val('DarkBlue');
                break;
            
            case "Callback":
            case "Work Number":
            case "Email Sent":
                $(this).next().val('purple');
                break;
            
            
            case "Decline":
            case "Cant Beat":
            case "Underwritten":
                $(this).next().val('Orange');
                break;
            
            case "Dead Email":
            case "Dead Number":
                        case "Dead Beat":
            case "Dead Cant Beat":
            case "Invalid Number":
            case "No Policy Info":
            case "No Number":
            case "Wrong Number":
                $(this).next().val('red');
                break;
            
            
                         }
                     });
        }
    } );
} );
        </script>


    </body>
</html>
