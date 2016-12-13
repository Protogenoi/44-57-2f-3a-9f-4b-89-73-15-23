<?php 
include($_SERVER['DOCUMENT_ROOT']."/classes/access_user/access_user_class.php"); 
$page_protect = new Access_user;
$page_protect->access_page($_SERVER['PHP_SELF'], "", 2);
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;

include('includes/Access_Levels.php');

if (!in_array($hello_name,$Level_8_Access, true)) {
    
    header('Location: /CRMmain.php'); die;

}

include('includes/adlfunctions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <title>Reports</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/layoutcrm.css" type="text/css" />
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href="img/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    
<?php include('includes/navbar.php');

if($ffanalytics=='1') {
    
    include_once($_SERVER['DOCUMENT_ROOT'].'/php/analyticstracking.php'); 
    
    }
      
?>
    
    <div class="container">        
        <div class="row">
            <div class="twelve columns">
                <ul class="ca-menu">
                    
                    			<li>
			<a href="CRMmain.php">
			<span class="ca-icon"><i class="fa fa-arrow-left"></i></span>
			<div class="ca-content">
				<h2 class="ca-main">Back<br/></h2>
				<h3 class="ca-sub"></h3>
			</div>
			</a>
                        </li>
                    
			<?php if($fflife=='1') { 
                            
                            if (in_array($hello_name,$Level_10_Access, true)) {
                            
                            ?>   
                    
                    <li>
                        <a href="/Life/Reports/EWSMaster.php">
                            <span class="ca-icon"><i class="fa fa-archive"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Archive<br/> EWS</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                            <?php  }
                    
                            
                            if (in_array($hello_name,$Level_8_Access, true)) {
                            
                            ?>  
                    
                    <li>
                        <a href="Life/Assura/Reports.php">
                            <span class="ca-icon"><i class="fa fa-umbrella"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Assura<br/> EWS/Financials</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li> 
                    
                    <li>
                        <a href="Life/Reports_Menu.php">
                            <span class="ca-icon"><i class="fa fa-warning"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">The Review Bureau<br/>EWS</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                   
                    <li>
                    <a href="calendar/All_Callbacks.php">
                            <span class="ca-icon"><i class="fa fa-phone"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">All Active<br/>Callbacks</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="Life/Reports/PolicyStatuses.php">
                            <span class="ca-icon"><i class="fa fa-list-alt"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Policy<br/>Statuses</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                            <?php }                             
                            
                            if($companynamere=='Assura') { ?>
                    
                    <li>
                        <a href="/Legacy/EWSLegfiles.php">
                            <span class="ca-icon"><i class="fa fa-history"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Legacy<br/> Re-broker</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="/Legacy/LegacyStats.php">
                            <span class="ca-icon"><i class="fa fa-bar-chart"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Legacy EWS<br/> Statistics</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                   
                    
<?php } 

if (in_array($hello_name,$Level_10_Access, true)) {

?>
                    
                    <li>
                        <a href="Financial_Reports.php">
                            <span class="ca-icon"><i class="fa fa-gbp"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Report</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    
                    <?php if($companynamere=='The Review Bureau') { ?>
                    
                    <li>
                        <a href="/Life/Reports/FinancialUpload.php">
                            <span class="ca-icon"><i class="fa fa-upload"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Financial<br/>Uploads</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                                             <a href="/Life/Financial_Menu.php">
                            <span class="ca-icon"><i class="fa  fa-database"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Jade Financial<br/>Menu</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <?php } ?>
                    
                    <li>
                        <a href="Export.php">
                            <span class="ca-icon"><i class="fa fa-cloud-download"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Export<br/>Data</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="Upload.php">
                            <span class="ca-icon"><i class="fa fa-cloud-upload"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Upload<br/>Data</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                        <?php }  } 
                        
                        if($ffpensions=='1') {
                            if($companynamere=='HWIFS') { ?>
                    
                    
                    <li>
                        <a href="Pensions/Reports/PensionStages.php">
                            <span class="ca-icon"><i class="fa fa-list-alt"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Pension<br/>Tasks</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                    <a href="Pensions/Reports/Cancelled_Clients.php">
                            <span class="ca-icon"><i class="fa fa-user-times"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">Cancelled<br/>Clients</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>    
                    
                                        
                                                            <li>
                    <a href="calendar/All_Callbacks.php">
                            <span class="ca-icon"><i class="fa fa-phone"></i></span>
                            <div class="ca-content">
                                <h2 class="ca-main">All Active<br/>Callbacks</h2>
                                <h3 class="ca-sub"></h3>
                            </div>
                        </a>
                    </li>
                                
                        <?php } } ?>
                    
                </ul>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" language="javascript" src="/js/jquery/jquery-3.0.0.min.js"></script>
    <script src="/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script> 
</body>
</html>
