<?php
require_once(__DIR__ . '/../classes/access_user/access_user_class.php');
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 10);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

require_once(__DIR__ . '/../includes/adl_features.php');
require_once(__DIR__ . '/../includes/Access_Levels.php');
require_once(__DIR__ . '/../includes/adlfunctions.php');
require_once(__DIR__ . '/../classes/database_class.php');
require_once(__DIR__ . '../../includes/ADL_PDO_CON.php');

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADL | User Dash</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
<?php require_once(__DIR__ . '/../includes/NAV.php'); ?> 
    <br>
<div class="container-fluid">
   
   
<div class="row">
		<!-- Left Column -->
		<div class="col-3">

			<!-- List-Group Panel -->
			<div class="card">
				<div class="card-header p-b-0">
					<h5 class="card-title"><i class="fa fa-random" aria-hidden="true"></i> Client Statistics</h5>
				</div>
				<div class="list-group list-group-flush">
					<a href="#" class="list-group-item list-group-item-action">No Closer Audit</a>
                                        <a href="#" class="list-group-item list-group-item-action">No Lead Audit</a>
					<a href="#" class="list-group-item list-group-item-action">No Closer Recording</a>
					<a href="#" class="list-group-item list-group-item-action">No Lead Recording</a>
					<a href="#" class="list-group-item list-group-item-action">No Dealsheet</a>
                                        <a href="#" class="list-group-item list-group-item-action">No Policy Docs</a>
				</div>
			</div>

			<!-- Text Panel -->
			<div class="card">
				<div class="card-header p-b-0">
					<h5 class="card-title"><i class="fa fa-random" aria-hidden="true"></i> EWS Statistics</h5>
				</div>
				<div class="list-group list-group-flush">
                                    <a href="#" class="list-group-item list-group-item-action">Total on EWS</a>
                                    <a href="#" class="list-group-item list-group-item-action">Total on EWS White</a>
                                    <a href="#" class="list-group-item list-group-item-action">BOUNCED DD</a>
                                        <a href="#" class="list-group-item list-group-item-action">CANCELLED</a>
					<a href="#" class="list-group-item list-group-item-action">CANCELLED DD</a>
					<a href="#" class="list-group-item list-group-item-action">CFO</a>
					<a href="#" class="list-group-item list-group-item-action">LAPSED</a>
                                        <a href="#" class="list-group-item list-group-item-action">RE-INSTATED</a>
                                        <a href="#" class="list-group-item list-group-item-action">REDRAWN</a>
                                        <a href="#" class="list-group-item list-group-item-action">WILL CANCEL</a>
                                        <a href="#" class="list-group-item list-group-item-action">WILL REDRAW</a>
				</div>
			</div>
				
		</div><!--/Left Column-->
  
  
		<!-- Center Column -->
		<div class="col-6">
		
			<!-- Alert -->
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Dash:</strong> This is your dashboard, it can show you what you have done or what needs to be done for this week!
			</div>		
		
			<!-- Articles -->
			<div class="row">
				<article class="col-12">
					<h2>Premier Niche Markets</h2>
					<p>Phosfluorescently engage worldwide methodologies with web-enabled technology. Interactively coordinate proactive e-commerce via process-centric "outside the box" thinking. Completely pursue scalable customer service through sustainable potentialities.</p>
					<p><button class="btn btn-outline-success">Read More</button></p>
					<p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
					<ul class="list-inline">
						<li class="list-inline-item"><a href="#">Today</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-comment"></span> 2 Comments</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-share"></span> 8 Shares</a></li>
					</ul>
				</article>
			</div>
			<hr>
			<div class="row">
				<article class="col-12">
					<h2>ADL TRACKER</h2>
					<p>Seamlessly visualize quality intellectual capital without superior collaboration and idea-sharing. Holistically pontificate installed base portals after maintainable products. Proactively envisioned multimedia based expertise and cross-media growth strategies.</p>
					<p><button class="btn btn-outline-primary">Read More</button></p>
					<p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
					<ul class="list-inline">
						<li class="list-inline-item"><a href="#">Yesterday</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-comment"></span> 21 Comments</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-share"></span> 36 Shares</a></li>
					</ul>
				</article>
			</div>
			<hr>      
			<div class="row">
				<article class="col-12">
					<h2>Completely Synergize</h2>
					<p>Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art customer service.</p>
					<p><button class="btn btn-outline-danger">Read More</button></p>
					<p class="pull-right"><span class="tag tag-default">keyword</span> <span class="tag tag-default">tag</span> <span class="tag tag-default">post</span></p>
					<ul class="list-inline">
						<li class="list-inline-item"><a href="#">2 Days Ago</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-comment"></span> 12 Comments</a></li>
						<li class="list-inline-item"><a href="#"><span class="glyphicon glyphicon-share"></span> 18 Shares</a></li>
					</ul>
				</article>
			</div>
			<hr>
		</div><!--/Center Column-->


	  <!-- Right Column -->
	  <div class="col-3">

			<!-- Text Panel -->
			<div class="card">
				<div class="card-header p-b-0">
					<h5 class="card-title">
						<i class="fa fa-bullhorn" aria-hidden="true"></i>
						SMS
					</h5>
				</div>
				<div class="card-block">
					<p class="card-text">Check on inbound and outbound SMS messages.</p>
					<div class="btn-group btn-group" role="group">
						<button type="button" class="btn btn-secondary">Client Responses</button>
						<button type="button" class="btn btn-secondary">Failed SMS</button>
						<button type="button" class="btn btn-secondary">Sent SMS</button>
					</div>
				</div>
			</div>	
 
			<!-- Progress Bars -->
			<div class="card">
				<div class="card-header p-b-0">
					<h5 class="card-title">
						<i class="fa fa-tachometer" aria-hidden="true"></i> 
						Today's Audits
					</h5>
				</div>
				<div class="card-block">

                    <div class="text-center" id="progress-caption-1">Auditor 1 &hellip; 25%</div>
                    <div class="progress">
  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                    <div class="text-center" id="progress-caption-1">Auditor 2 &hellip; 50%</div>
<div class="progress">
  <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                    <div class="text-center" id="progress-caption-1">Auditor 3 &hellip; 75%</div>
<div class="progress">
  <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                    <div class="text-center" id="progress-caption-1">Auditor 4 &hellip; 100%</div>
<div class="progress">
  <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
				</div>
			</div>

	  </div><!--/Right Column -->

	</div>
</div>
    <!--/container-fluid-->
	
	<footer>
        
        <div class="small-print">
        	<div class="container">
        		<p><a href="#">Terms &amp; Conditions</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact</a></p>
        		<p>Copyright &copy; ADL CRM 2017 </p>
        	</div>
        </div>
	</footer>

    <script src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script>
    // Initialize tooltip component
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // Initialize popover component
    $(function () {
      $('[data-toggle="popover"]').popover()
    })
    </script> 
    
	<!-- Placeholder Images -->
	<script src="js/holder.min.js"></script>
	
</body>

</html>
