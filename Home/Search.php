<?php 
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page(filter_input(INPUT_SERVER,'PHP_SELF', FILTER_SANITIZE_SPECIAL_CHARS), "", 3);
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
    require_once(__DIR__ . '/../php/analyticstracking.php');
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
        
        if($ACCESS_LEVEL < 3) {
            
        header('Location: /../index.php?AccessDenied&USER='.$hello_name.'&COMPANY='.$COMPANY_ENTITY);
        die;    
            
        }
        
        $CHECK_USER_LOGIN->SelectToken();
        $OUT=$CHECK_USER_LOGIN->SelectToken();
        
        if(isset($OUT['TOKEN_SELECT']) && $OUT['TOKEN_SELECT']!='NoToken') {
        
        $TOKEN=$OUT['TOKEN_SELECT'];
                
        }        
?>
<!DOCTYPE html>
<!-- 
 Copyright (C) ADL CRM - All Rights Reserved
 Unauthorised copying of this file, via any medium is strictly prohibited
 Proprietary and confidential
 Written by Michael Owen <michael@adl-crm.uk>, 2017
-->
<html>
<title>ADL | Search Home Clients</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="/styles/layoutcrm.css"  />
<link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="/styles/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="/datatables/css/dataTables.customLoader.walker.css">
<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.11.4/jquery-ui.css">
<link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
    <?php
    
require_once(__DIR__ . '/../includes/navbar.php');
    
    $query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

    ?>
    
<div class="container">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">
<?php if($ffhome=='1'){ ?>			
			<li>
			<a href="/SearchPolicies.php?EXECUTE=Home">
                            <span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search<br/>Policies</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        <li>
			<a href="/AddClient.php">
			<span class="ca-icon"><i class="fa fa-user-plus"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Add New<br/> Client</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
<?php }   ?> 

		</ul>
	</div>
</div>


          <?php

          
           if($ffhome=='1') {
        ?>
            <table id="clients" class="display" width="auto" cellspacing="0">
        <thead>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>Phone #</th>
                <th>Company</th>
                <th>View</th>
                <th>Add Policy</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Date Added</th>
                <th>Client Name</th>
                <th>Client Name</th>
                <th>Post Code</th>
                <th>Phone #</th>
                <th>Company</th>
                <th>View</th>
                <th>Add Policy</th>
            </tr>
        </tfoot>
    </table>
        <?php
    } ?>
    
</div>
       
<script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="/js/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/js/datatables/jquery.DATATABLES.min.js"></script>
<script type="text/javascript" src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
 

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

<script type="text/javascript" language="javascript" >
 
$(document).ready(function() {
    var table = $('#clients').DataTable( {
        "response":true,
        "processing": true,
        "iDisplayLength": 25,
        "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "language": {
            "processing": "<div></div><div></div><div></div><div></div><div></div>"
        },
        "ajax": "/datatables/ClientSearch.php?ClientSearch=5&USER=<?php echo $hello_name; ?>&TOKEN=<?php echo $TOKEN; ?>",
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
            { "data": "phone_number" },
            { "data": "company" },
 { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="ViewClient.php?CID=' + data + '">View</a>';
            } },
         { "data": "client_id",
            "render": function(data, type, full, meta) {
                return '<a href="AddPolicy.php?Home=y&CID=' + data + '">Add Policy</a>';
            } }
        ]
    } );

} );
</script>            
</body>
</html>
