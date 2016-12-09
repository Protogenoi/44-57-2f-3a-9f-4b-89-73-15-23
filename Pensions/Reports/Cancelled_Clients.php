<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$test_access_level = new Access_user;
$test_access_level->access_page($_SERVER['PHP_SELF'], "", 7);
$hello_name = ($test_access_level->user_full_name != "") ? $test_access_level->user_full_name : $test_access_level->user;

include('../../includes/adlfunctions.php'); 
include('../../includes/Access_Levels.php'); 

    if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

if (isset($_GET['action']) && $_GET['action'] == "log_out") {
	$test_access_level->log_out();
}

?>
<!DOCTYPE html>
<html lang="en">
<title>ADL | Cancelled Clients</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../../styles/jquery.dataTables.css">
</head>
<body>
    
    <?php
    include('../../includes/navbar.php');
    include('../../includes/ADL_PDO_CON.php');
            include($_SERVER['DOCUMENT_ROOT']."/includes/adl_features.php");
    
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    ?>
    
    <div class="container">
   
    
    <div  class="text-center">
       <label class="label label-success">Cancelled Clients</label>
      <div id="bar-chart" ></div>
    </div>
  
          <br>
          
    <table id="task" class="display" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>Added By</th>
                <th>Updated on</th>
                <th>Updated By</th>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Added On</th>
                <th>Added By</th>
                <th>Updated on</th>
                <th>Updated By</th>
                <th>ID</th>
                <th>Name</th>

            </tr>
        </tfoot>
    </table>

</div>

<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>

<script type="text/javascript" language="javascript" src="../../js/datatables/jquery.DATATABLES.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 


<script type="text/javascript" language="javascript" >
$(document).ready(function() {
    var table = $('#task').DataTable( {

"response":true,
					"processing": true,
"iDisplayLength": 500,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "/Pensions/JSON/GetCancelledClients.php?report=1",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "submitted_date" },
            { "data": "added_by" },
            { "data": "submitted_update" },
            { "data": "updated_by" },
            { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="/Pensions/ViewClient.php?search=' + data + '">View</a>';
            } },
            { "data": "client_name" },

         ],
        "order": [[1, 'asc']]
    } ); $('#min, #max').keyup( function() {
        table.draw();
    } );
     
    $('#task tbody').on('click', 'td.details-control', function () {
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
