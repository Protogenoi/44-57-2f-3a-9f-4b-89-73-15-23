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
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2);
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
require_once(__DIR__ . '/../includes/ADL_MYSQLI_CON.php');
require_once(__DIR__ . '/../includes/ADL_PDO_CON.php');

    require_once(__DIR__ . '../../classes/database_class.php');
    require_once(__DIR__ . '../../class/login/login.php');

        $CHECK_USER_LOGIN = new UserActions($hello_name,"NoToken");
        
        $CHECK_USER_LOGIN->SelectToken();
        $CHECK_USER_LOGIN->CheckAccessLevel();
   
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }
        
        $USER_ACCESS_LEVEL=$CHECK_USER_LOGIN->CheckAccessLevel();
        
        $ACCESS_LEVEL=$USER_ACCESS_LEVEL['ACCESS_LEVEL'];
        
        if($ACCESS_LEVEL < 2) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }

if ($ffanalytics == '1') {
    require_once(__DIR__ . '/../php/analyticstracking.php');
}

if ($ffaudits=='0') {
        
        header('Location: /../CRMmain.php'); die;
    }
    
    $step= filter_input(INPUT_GET, 'step', FILTER_SANITIZE_SPECIAL_CHARS);
    
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html lang="en">
<title>ADL | Lead Gen Report</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/resources/templates/ADL/main.css" type="text/css" />
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/templates/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/resources/lib/DataTable/datatables.min.css"/>
        <link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php require_once(__DIR__ . '/../includes/navbar.php'); ?>

<div class="container">

    <br>

    <?php

$audit= filter_input(INPUT_GET, 'audit', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($audit)){

    if ($audit =='y') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Success:</strong> Audit submitted!</div>");
    }
    
}

$grade= filter_input(INPUT_GET, 'grade', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($grade)){

    if ($grade =='Green') {

print("<div class=\"notice notice-success\" role=\"alert\"><strong><i class=\"fa fa-check fa-lg\"></i> Audit grade: Green!</strong></div>");
    }
    
        if ($grade =='Red') {

print("<div class=\"notice notice-danger\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Audit grade: Red!</strong></div>");
    }
    
           if ($grade =='Amber') {

print("<div class=\"notice notice-warning\" role=\"alert\"><strong><i class=\"fa fa-exclamation-triangle fa-lg\"></i> Audit grade: Amber!</strong></div>");
    }
    
}

?>

<br>

<center>
    <div class="btn-group">
        <a href="Audit_LeadGen.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> New Audit</a>
        <a href="auditor_menu.php" class="btn btn-info"><i class="fa fa-folder-open"></i> Closer Audits</a>
    </div>
</center>
<br>


          <form class="form-inline" method="GET">
              <fieldset>
                  <legend>Audit Search</legend>

<div class="form-group">
    <select id="step" name="step" class="form-control">
        <?php if(isset($step)) { echo "<option value='$step'>$step</option>";} ?>
        <option value=" ">Select..</option>
      <option value="Search">Search New Audits</option>
      <option value="Searchold">Search Old Audits</option>
    </select>
</div>

<div class="form-group">

    <button id="" name="" class="btn btn-primary">Submit</button>
    <a href="lead_gen_reports.php?step=New" class="btn btn-danger"> Reset</a>

</div>
              </fieldset>
          </form>
<br>

<?php

if ($step=='New') {
    
$query = $pdo->prepare("SELECT id, an_number, submitted_date, agent, auditor, grade, edited, submitted_edit from Audit_LeadGen where auditor = :HELLO and submitted_date between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) or submitted_edit between DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) AND edited =:HELLO ORDER BY submitted_date DESC");
$query->bindParam(':HELLO', $hello_name, PDO::PARAM_STR, 12);

echo "<table class=\"table\">";

echo 
"<thead>
	<tr>
	<th colspan= 12>Your Recent Audits</th>
	</tr>
	<tr>
	<th>ID</th>
	<th>Date Submitted</th>
        <th>AN Number</th>
	<th>Lead Gen</th>
	<th>Auditor</th>
	<th>Grade</th>
	<th>Edited By</th>
	<th>Date Edited</th>
	<th colspan='5'>Options</th>
	</tr>
	</thead>";
$i=0;
$query->execute();
if ($query->rowCount()>0) {
while ($result=$query->fetch(PDO::FETCH_ASSOC)){
    $i++;
    switch( $result['grade'] )
    {
      case("Red"):
         $class = 'Red';
          break;
        case("Green"):
          $class = 'Green';
           break;
        case("Amber"):
          $class = 'Amber';
           break;
       case("SAVED"):
            $class = 'Purple';
          break;
        default:
 }
         
	echo '<tr class='.$class.'>';
	echo "<td>".$result['id']."</td>";
	echo "<td>".$result['submitted_date']."</td>";
        echo "<td>".$result['an_number']."</td>";
	echo "<td>".$result['agent']."</td>";
	echo "<td>".$result['auditor']."</td>";
	echo "<td>".$result['grade']."</td>";
	echo "<td>".$result['edited']."</td>";
	echo "<td>".$result['submitted_edit']."</td>";
	echo "<td>
      <form action='lead_gen_form_edit.php?new=y'  method='POST' name='form'>
	<input type='hidden' name='editid' value='".$result['id']."' >
<button type='submit' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-pencil'></span> </button>
      </form>
   </td>";
	echo "<td> 
      <form action='LandG/View.php?EXECUTE=1&AID=".$result['id']."' method='POST'>
<button type='submit' class='btn btn-info btn-xs'><span class='glyphicon glyphicon-eye-open'></span> </button>
      </form>
   </td>";
   
	echo "</tr>";
	echo "\n"; ?>
    <?php
      
} }
    echo "</table>";
    
}



if ($step =='Search') {
    
    ?>
    <table id="clients" width="auto" cellspacing="0" class="table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>AN Number</th>
                <th>Lead Gen</th>
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
                <th>AN Number</th>
                <th>Lead Gen</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
            </tr>
        </tfoot>
    </table>
<?php

}

if ($step =='Searchold') {
    
    ?>
    <table id="oldclients" width="auto" cellspacing="0" class="table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Submitted</th>
                <th>ID</th>
                <th>Lead Gen</th>
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
                <th>Lead Gen</th>
                <th>Auditor</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>View</th>
            </tr>
        </tfoot>
    </table>
<?php

}
?>

</div>
  
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" language="javascript" src="/resources/lib/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="/resources/lib/DataTable/datatables.min.js"></script>
        <script src="/resources/lib/jquery-ui-1.11.4/jquery-ui.js"></script>
        <script src="/resources/templates/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" >
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Changes:</td>'+
            '<td>'+d.submitted_edit+' </td>'+
	   '<td>'+d.edited+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Grade:</td>'+
            '<td>'+d.grade+' </td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#clients').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["grade"] === "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["grade"] === "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["grade"] === "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["grade"] === "SAVED" )  {
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
        "ajax": "datatables/AuditSearch.php?AuditType=NewLeadGen&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "submitted_date" },
            { "data": "id"},
            { "data": "an_number"},
            { "data": "agent" },
            { "data": "auditor" },
            { "data": "grade" },
  { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="lead_gen_form_edit.php?new=y&auditid=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LandG/View.php?EXECUTE=1&AID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a>';
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
<script type="text/javascript" language="javascript" >
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Changes:</td>'+
            '<td>'+d.date_edited+' </td>'+
	   '<td>'+d.edited+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Grade:</td>'+
            '<td>'+d.grade+' </td>'+
        '</tr>'+
        '<tr>'+
            '<td>Answered Correctly:</td>'+
            '<td>'+d.total+'/6 </td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#oldclients').DataTable( {
"fnRowCallback": function(  nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
   if ( aData["grade"] === "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["grade"] === "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["grade"] === "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["grade"] === "SAVED" )  {
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
        "ajax": "datatables/AuditSearch.php?AuditType=OldLeadGen&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "date_submitted" },
            { "data": "id"},
            { "data": "lead_gen_name" },
            { "data": "auditor" },
            { "data": "grade" },
  { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="lead_gen_form_edit.php?auditid=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "id",
            "render": function(data, type, full, meta) {
                return '<a href="LandG/View.php?EXECUTE=1&AID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a>';
            } }
        ],
        "order": [[1, 'desc']]
    } );

    $('#oldclients tbody').on('click', 'td.details-control', function () {
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