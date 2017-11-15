<?php
require_once(__DIR__ . '../../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

$USER_TRACKING=0;

require_once(__DIR__ . '../../includes/user_tracking.php'); 

require_once(__DIR__ . '/../includes/time.php');

if(isset($FORCE_LOGOUT) && $FORCE_LOGOUT== 1) {
    $page_protect->log_out();
}


require_once(__DIR__ . '../../includes/adl_features.php');
require_once(__DIR__ . '../../includes/Access_Levels.php');
require_once(__DIR__ . '../../includes/adlfunctions.php');

if ($ffanalytics == '1') {
    require_once(__DIR__ . '../../php/analyticstracking.php');
}

        if($ffpba=='0') {
        
        header('Location: ../../CRMmain.php'); die;
        
    }

if (isset($fferror)) {
    if ($fferror == '1') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

$EXECUTE = filter_input(INPUT_GET, 'EXECUTE', FILTER_SANITIZE_SPECIAL_CHARS);

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
        
        if($ACCESS_LEVEL < 10) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
?>
<!DOCTYPE html>
<html>
<title>ADL | Search PBA Clients</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" href="/styles/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4/jquery-ui.css">
<link rel="stylesheet" href="/resources/templates/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
    <body>
    <?php
    include('../includes/navbar.php');
     ?>
        <div class="container">
            
            
                <?php 
    
    $client= filter_input(INPUT_GET, 'client', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(isset($client)) {
        if($client=='PBA') { ?>
    
                <table id="PBA" class="display" width="auto" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>Tel</th>
                <th>Tel</th>
                <th>View</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>Tel</th>
                <th>Tel</th>
                <th>View</th>
            </tr>
        </tfoot>
    </table>
    
            
     <?php   }
    }
     ?>
            
            
        </div>
        
        
        
     <script type="text/javascript" language="javascript" src="../js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>

<script type="text/javascript" language="javascript" src="../js/datatables/jquery.DATATABLES.min.js"></script>
<script src="../bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>    
        
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
                    <h3>Populating client details... </h3>
                </div>
            </div>
        </div>
    </div>
</div>        
        <?php 
        if(isset($client)) {
        if($client=='PBA') { 
            
            ?>
        <script type="text/javascript" language="javascript" >
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
            '<td>Added By:</td>'+
            '<td>'+d.submitted_by+' </td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#PBA').DataTable( {

"response":true,
					"processing": true,
"iDisplayLength": 10,
"aLengthMenu": [[5, 10, 25, 50, 100, 125, 150, 200, 500], [5, 10, 25, 50, 100, 125, 150, 200, 500]],
				"language": {
					"processing": "<div></div><div></div><div></div><div></div><div></div>"

        },
        "ajax": "../datatables/ClientSearch.php?ClientSearch=4&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "submitted_date"},
            { "data": "Name" },
            { "data": "Name2" },
            { "data": "post_code" },
            { "data": "tel" },
            { "data": "tel2" },
 { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="ViewClient.php?search=' + data + '">View</a>';
            } }
        ],
        "order": [[1, 'DESC']]
    } );

    $('#PBA tbody').on('click', 'td.details-control', function () {
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
                
<?php } }?>
    </body>
</html>
