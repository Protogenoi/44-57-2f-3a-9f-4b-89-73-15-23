<?php 
require_once(__DIR__ . '/../../classes/access_user/access_user_class.php'); 
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '/../../includes/user_tracking.php'); 

include('../../includes/adlfunctions.php'); 

include('../../includes/adl_features.php');

if(isset($fferror)) {
    if($fferror=='1') {
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
    }
    
    }

if ($ffaudits=='0') {
        
        header('Location: ../../CRMmain.php'); die;
    }
    
    include('../../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../../CRMmain.php'); die;

}

include('../../includes/ADL_PDO_CON.php');

?>
<!DOCTYPE html>
<html>
<title>ADL | Search Royal London Audits</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../../font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../../styles/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="../../datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../../datatables/css/dataTables.customLoader.walker.css">
<link href="../../img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php include('../../includes/navbar.php');
    if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    $QRY= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    $return= filter_input(INPUT_GET, 'return', FILTER_SANITIZE_SPECIAL_CHARS);
?>
    
    <div class="container">
        <div class="notice notice-default" role="alert"><strong><center><span class="label label-warning"></span> Search Whole of Life Audits</center></strong></div>
        
        <br>
        <center>
            <div class="btn-group">
                <a href="Menu.php" class="btn btn-info"><i class="fa fa-folder-open"></i> Royal London Audits</a>
                <a href="../Search.php" class="btn btn-info"><i class="fa fa-search"></i> WOL Audits</a>
                <a href="../audit_search.php" class="btn btn-default"><i class="fa fa-search"></i> Search Life Audits</a>
                <a href="../lead_gen_reports.php?step=Search" class="btn btn-default"><i class="fa fa-search"></i> Search Lead Audits</a>
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
<script type="text/javascript" language="javascript" src="../../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>

<script type="text/javascript" language="javascript" src="../../js/datatables/jquery.DATATABLES.min.js"></script>
<script src="../../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
 

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
   if ( aData["grade"] == "Red" )  {
          $(nRow).addClass( 'Red' );
}
   else  if ( aData["grade"] == "Amber" )  {
          $(nRow).addClass( 'Amber' );
    }
   else if ( aData["grade"] == "Green" )  {
          $(nRow).addClass( 'Green' );
    }
   else if ( aData["grade"] == "SAVED" )  {
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
        "ajax": "php/Search_Results.php?EXECUTE=1",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "added_date" },
            { "data": "audit_id"},
            { "data": "plan_number"},
            { "data": "closer" },
            { "data": "added_by" },
            { "data": "grade" },
  { "data": "audit_id",
            "render": function(data, type, full, meta) {
                return '<a href="Audit.php?EXECUTE=EDIT&AUDITID=' + data + '"><button type=\'submit\' class=\'btn btn-warning btn-xs\'><span class=\'glyphicon glyphicon-pencil\'></span> </button></a>';
            } },
 { "data": "audit_id",
            "render": function(data, type, full, meta) {
                return '<a href="View.php?EXECUTE=VIEW&AUDITID=' + data + '"><button type=\'submit\' class=\'btn btn-info btn-xs\'><span class=\'glyphicon glyphicon-eye-open\'></span> </button></a></a>';
            } },
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
