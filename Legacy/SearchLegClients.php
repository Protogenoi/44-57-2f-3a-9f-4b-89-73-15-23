<?php 

include('../includes/CompanyDetails.php'); 

if ($companynameref!='Assura') {
      
      header('Location: ../CRMmain.php'); die;
    }
    
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 1);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

?>
<!DOCTYPE html>
<html>
<title>ADL | Search Clients</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/jquery-ui.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
</head>
<body>
    
    <?php 
    include('../includes/navbar.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>

<div class="container">
<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">

                        <li>
			<a href="../SearchClients.php">
                            <span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/> Clients</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>


		</ul>
	</div>
</div>

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>        
<script src="//afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
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
        "ajax": "../datatables/ClientSearch.php?ClientSearch=3",
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
            } }, 

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
