<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/Access_Levels.php');
include('../includes/adl_features.php');

      if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: ../CRMmain.php'); die;
} 
?>
<!DOCTYPE html>
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
    include('../includes/navbar.php');
    include('../includes/adlfunctions.php');
        if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
    
    $query= filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

    ?>
    
<div class="container">

<div class="row">
	<div class="twelve columns">
		<ul class="ca-menu">
<?php if($ffhome=='1'){ ?>			
			<li>
			<a href="/SearchPolicies.php?query=Home">
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
        "ajax": "/datatables/ClientSearch.php?ClientSearch=5",
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
                return '<a href="/Home/AddPolicy.php?Home=y&search=' + data + '">Add Policy</a>';
            } },
        ],
    } );

} );
</script>            
</body>
</html>
