<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2); 
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('../includes/Access_Levels.php');

if (!in_array($hello_name,$Level_3_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}
?>
<!DOCTYPE html>
<html lang="en">
<title>Audit Reports</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../datatables/css/layoutcrm.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>

<?php include('../includes/navbar.php');
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
			<a href="main_menu.php">
			<span class="ca-icon"><i class="fa fa-arrow-left"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Back<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
                        </li>

			<li>
			<a href="audit_search.php">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search Closer<br/>Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>
                        
                        <li>
			<a href="lead_gen_reports.php?step=Searchold">
			<span class="ca-icon"><i class="fa fa-archive"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search Legacy Lead<br/>Audits</h2>
				<h3 class="ca-sub">2016-01-19 and earlier</h3>
			</div>
			</a>
			</li>
                        

<li>
			<a href="lead_gen_reports.php?step=Search">
			<span class="ca-icon"><i class="fa fa-search"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Search Lead<br/>Audits</h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
			</li>


		</ul>
	</div>
</div>



    </div>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
